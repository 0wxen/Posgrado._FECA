import { useEffect, useState } from 'react';
import PageBanner from '../components/PageBanner.jsx';
import CmsField from './CmsField.jsx';
import { RENDERERS } from './CmsCards.jsx';
import AdminIdentity from './AdminIdentity.jsx';
import { STORAGE_KEY, DEFAULTS, FORMS, LABELS, STATS_LABELS } from '../data/adminCmsSchema.js';
import { STATS_KEY } from '../hooks/useVisitTracking.js';
import '../styles/stats.css';

const TABS = [
  { id: 'convocatorias', label: 'Convocatorias', icono: 'ti-file-text' },
  { id: 'nosotros', label: 'Nosotros', icono: 'ti-users' },
  { id: 'oferta', label: 'Oferta Educativa', icono: 'ti-school' },
  { id: 'investigacion', label: 'Investigación', icono: 'ti-microscope' },
  { id: 'comunidad', label: 'Comunidad', icono: 'ti-users-group' },
  { id: 'blog', label: 'Blog', icono: 'ti-news' },
  { id: 'estadisticas', label: 'Estadísticas', icono: 'ti-chart-bar' },
];

function cargarTodo() {
  try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || {}; } catch { return {}; }
}
function genId() { return Date.now() + Math.floor(Math.random() * 999); }

// Portado de Posgrado/pages/admin.html ("Panel de Contenido"): agregar,
// editar y eliminar contenido guardando en localStorage (dep_cms_v2),
// en modo invitado -- sin sesión ni PostgreSQL, igual que el original.
// Reachable desde el modal de login ("Entrar sin iniciar sesión").
export default function ContentCMS() {
  const [tab, setTab] = useState('convocatorias');
  const [datos, setDatos] = useState(cargarTodo);
  const [editando, setEditando] = useState(null); // { sec, id } | null
  const [borrador, setBorrador] = useState({});

  useEffect(() => {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(datos));
  }, [datos]);

  const getSeccion = (sec) => (datos[sec] !== undefined ? datos[sec] : DEFAULTS[sec] || []);

  const abrirNuevo = (sec) => {
    setEditando({ sec, id: null });
    setBorrador({});
  };
  const abrirEditar = (sec, id) => {
    const item = getSeccion(sec).find((i) => i.id === id) || {};
    setEditando({ sec, id });
    setBorrador(item);
  };
  const cerrarModal = () => { setEditando(null); setBorrador({}); };

  const guardar = () => {
    const { sec, id } = editando;
    const esNuevo = id === null;
    const item = esNuevo ? { ...borrador, id: genId() } : { ...borrador, id };
    setDatos((prev) => {
      const items = getSeccion(sec);
      const siguiente = esNuevo ? [...items, item] : items.map((i) => (i.id === id ? item : i));
      return { ...prev, [sec]: siguiente };
    });
    cerrarModal();
  };

  const eliminar = (sec, id) => {
    if (!confirm('¿Eliminar este elemento? Esta acción no se puede deshacer.')) return;
    setDatos((prev) => ({ ...prev, [sec]: getSeccion(sec).filter((i) => i.id !== id) }));
  };

  const CardComp = editando ? null : RENDERERS[tab];

  return (
    <>
      <PageBanner title="Panel de Contenido">
        <p className="page-banner-desc">
          Ve, edita, agrega y elimina el contenido del sitio: textos, imágenes y datos de cada sección.
        </p>
      </PageBanner>

      <section className="seccion seccion-gris">
        <div className="inner">
          <AdminIdentity />

          <div className="admin-aviso-db">
            <i className="ti ti-database-off"></i>
            <div>
              <strong>Modo de vista previa</strong> · Los cambios se guardan en tu navegador (localStorage).
              La sincronización con <strong>PostgreSQL</strong> estará disponible al conectar el servidor.
            </div>
          </div>

          <div className="admin-tabs" role="tablist">
            {TABS.map((t) => (
              <button
                key={t.id}
                className={`admin-tab-btn${tab === t.id ? ' activo' : ''}`}
                role="tab"
                onClick={() => setTab(t.id)}
              >
                <i className={`ti ${t.icono}`}></i> {t.label}
              </button>
            ))}
          </div>

          {tab !== 'estadisticas' ? (
            <div className="admin-panel" role="tabpanel">
              <div className="admin-panel-hdr">
                <div style={{ display: 'flex', alignItems: 'center', gap: 12 }}>
                  <h3>{LABELS[tab].panel}</h3>
                  <span className="admin-count-badge">{getSeccion(tab).length} elemento{getSeccion(tab).length !== 1 ? 's' : ''}</span>
                </div>
                <button className="btn-sm-rojo" onClick={() => abrirNuevo(tab)}>
                  <i className="ti ti-plus"></i> Agregar {LABELS[tab].item.toLowerCase()}
                </button>
              </div>

              {getSeccion(tab).length === 0 ? (
                <div className="admin-empty">
                  <i className="ti ti-inbox"></i>
                  <p>Sin elementos. Haz clic en &quot;Agregar&quot; para crear el primero.</p>
                </div>
              ) : (
                <div
                  className={`admin-grid admin-grid-${tab === 'nosotros' ? 'person' : tab === 'investigacion' ? 'invest' : tab}`}
                  style={tab === 'convocatorias' ? { gridTemplateColumns: 'repeat(auto-fill, minmax(280px, 1fr))' } : undefined}
                >
                  {getSeccion(tab).map((item) => {
                    const Card = RENDERERS[tab];
                    return <Card key={item.id} item={item} onEditar={abrirEditar} onEliminar={eliminar} />;
                  })}
                </div>
              )}
            </div>
          ) : (
            <EstadisticasPanel />
          )}
        </div>
      </section>

      {editando && (
        <div className="admin-modal-overlay" role="dialog" aria-modal="true" onClick={(e) => { if (e.target === e.currentTarget) cerrarModal(); }}>
          <div className="admin-modal-box">
            <div className="admin-modal-hdr">
              <h3>
                <small>{LABELS[editando.sec].panel}</small>
                {editando.id === null ? 'Agregar ' : 'Editar '}{LABELS[editando.sec].item}
              </h3>
              <button className="admin-modal-cerrar" aria-label="Cerrar" onClick={cerrarModal}>
                <i className="ti ti-x"></i>
              </button>
            </div>
            <div className="admin-modal-body">
              {FORMS[editando.sec].map((f) => (
                <CmsField
                  key={f.id}
                  field={f}
                  value={borrador[f.id]}
                  onChange={(v) => setBorrador((b) => ({ ...b, [f.id]: v }))}
                />
              ))}
            </div>
            <div className="admin-modal-footer">
              <button className="btn-primary" onClick={guardar}>
                <i className="ti ti-device-floppy"></i> Guardar cambios
              </button>
              <button className="btn-outline-dark" onClick={cerrarModal}>
                <i className="ti ti-x"></i> Cancelar
              </button>
            </div>
          </div>
        </div>
      )}
    </>
  );
}

function EstadisticasPanel() {
  const [raw, setRaw] = useState({});

  useEffect(() => {
    try { setRaw(JSON.parse(localStorage.getItem(STATS_KEY) || '{}')); } catch { setRaw({}); }
  }, []);

  const entries = Object.entries(raw).sort((a, b) => b[1] - a[1]);
  const total = entries.reduce((s, e) => s + e[1], 0);
  const max = entries.length ? entries[0][1] : 1;
  const top = entries.length ? entries[0] : null;

  const borrar = () => {
    if (!confirm('¿Borrar todas las estadísticas de uso? Esta acción no se puede deshacer.')) return;
    localStorage.removeItem(STATS_KEY);
    setRaw({});
  };

  return (
    <div className="admin-panel" role="tabpanel">
      <div className="admin-panel-hdr">
        <div style={{ display: 'flex', alignItems: 'center', gap: 12 }}>
          <h3>Estadísticas de Uso</h3>
          <span style={{ fontSize: 11, fontWeight: 600, color: '#aaa', padding: '3px 8px', background: '#f5f5f5', borderRadius: 99 }}>Este dispositivo</span>
        </div>
        <button className="btn-sm-outline" onClick={borrar} style={{ color: '#e31313', borderColor: '#e31313' }}>
          <i className="ti ti-trash"></i> Borrar datos
        </button>
      </div>

      <div className="stats-kpis">
        <div className="stats-kpi"><div className="stats-kpi-num">{total}</div><div className="stats-kpi-lbl">Visitas totales</div></div>
        <div className="stats-kpi"><div className="stats-kpi-num">{entries.length}</div><div className="stats-kpi-lbl">Secciones visitadas</div></div>
        {top && (
          <div className="stats-kpi stats-kpi--top">
            <div className="stats-kpi-num" style={{ fontSize: 20, lineHeight: 1.2 }}>{STATS_LABELS[top[0]] || top[0]}</div>
            <div className="stats-kpi-lbl">Más visitada</div>
            <div className="stats-kpi-sub">{top[1]} visita{top[1] !== 1 ? 's' : ''}</div>
          </div>
        )}
      </div>

      <div className="stats-chart-wrap">
        <div className="stats-chart-ttl">
          <i className="ti ti-chart-bar" style={{ fontSize: 14 }}></i>
          Visitas por sección · ordenadas de mayor a menor
        </div>
        {entries.length === 0 ? (
          <div className="stats-empty">
            <i className="ti ti-chart-bar-off"></i>
            <p>Sin datos todavía.<br />Navega por las secciones del sitio para que aparezcan aquí.</p>
          </div>
        ) : (
          entries.map(([key, val], idx) => {
            const label = STATS_LABELS[key] || key;
            const pct = Math.round((val / max) * 100);
            const pctTotal = total ? Math.round((val / total) * 100) : 0;
            return (
              <div className="stats-bar-row" key={key}>
                <div className="stats-bar-lbl" title={label}>{label}</div>
                <div className="stats-bar-track">
                  <div className={`stats-bar-fill${idx === 0 ? ' stats-bar-fill--top' : ''}`} style={{ width: `${pct}%` }}></div>
                  {pct > 20 && <span className="stats-bar-pct">{pctTotal}%</span>}
                </div>
                <div className="stats-bar-num">{val}</div>
              </div>
            );
          })
        )}
      </div>

      <p style={{ fontSize: 11, color: '#bbb', marginTop: 12, fontStyle: 'italic', display: 'flex', alignItems: 'center', gap: 5 }}>
        <i className="ti ti-info-circle" style={{ fontSize: 13, color: 'var(--dorado)' }}></i>
        Los datos se almacenan en este navegador (localStorage). Solo reflejan visitas desde este dispositivo.
      </p>
    </div>
  );
}
