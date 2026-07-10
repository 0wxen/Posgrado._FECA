import { useState } from 'react';
import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';
import ConvocatoriaModal from '../components/ConvocatoriaModal.jsx';
import { CONVOCATORIAS_B2026, DOCUMENTACION_REQUERIDA, PROCESO_ADMISION, CRONOGRAMA_B2026 } from '../data/announcementsContent.js';

// Portado de Posgrado/pages/announcements.html (Semestre B-2026) — mucho
// más completo que su espejo php/pages/announcements.php, que solo tenía
// 2 pósters genéricos de "Ciclo A-2025". El cierre automático y el
// cronograma con estado (Completado/En curso/Próximo/Pendiente), antes
// calculados en un <script> manipulando el DOM, aquí se recalculan en
// cada render comparando con la fecha de hoy.
function hoy() {
  const d = new Date();
  d.setHours(0, 0, 0, 0);
  return d;
}

function parseFecha(str) {
  const d = new Date(`${str}T00:00:00`);
  d.setHours(0, 0, 0, 0);
  return d;
}

function estadoPaso(paso, ahora, huboSiguiente) {
  const desde = parseFecha(paso.desde);
  const hasta = parseFecha(paso.hasta);
  if (hasta < ahora) return { etiqueta: 'Completado', color: '#2e7d32', bg: '#e8f5e9', icono: 'ti-check' };
  if (ahora >= desde && ahora <= hasta) return { etiqueta: 'En curso', color: 'var(--rojo)', bg: 'rgba(227,19,19,0.08)', icono: 'ti-loader-2' };
  if (!huboSiguiente.current) { huboSiguiente.current = true; return { etiqueta: 'Próximo', color: 'var(--dorado)', bg: 'rgba(168,127,61,0.1)', icono: paso.icono }; }
  return { etiqueta: 'Pendiente', color: '#aaa', bg: '#f5f5f5', icono: paso.icono };
}

export default function Announcements() {
  const [convAbierta, setConvAbierta] = useState(null);
  const ahora = hoy();

  const vigentes = CONVOCATORIAS_B2026.filter((c) => parseFecha(c.cierre) >= ahora);
  const cerradas = CONVOCATORIAS_B2026.filter((c) => parseFecha(c.cierre) < ahora);

  const marcador = { current: false };

  return (
    <>
      <PageBanner title="Convocatorias">
        <p className="page-banner-desc">
          Consulta las convocatorias vigentes para admisión a los programas de maestría de la División de Estudios de
          Posgrado, semestre B-2026.
        </p>
      </PageBanner>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="conv-section-title" style={{ marginBottom: 28 }}>
            <h3>Convocatorias Semestre B-2026</h3>
            <span className="conv-vigente-badge">
              <i className="ti ti-circle-filled" style={{ fontSize: 8 }}></i>
              {vigentes.length > 0 ? 'Proceso activo' : 'Sin convocatorias activas'}
            </span>
          </div>

          {vigentes.length === 0 ? (
            <div style={{ gridColumn: '1/-1', textAlign: 'center', padding: '48px 20px', color: '#bbb' }}>
              <i className="ti ti-calendar-off" style={{ fontSize: 48, display: 'block', marginBottom: 12, color: '#ddd' }}></i>
              <p style={{ fontSize: 15, fontWeight: 600, marginBottom: 6, color: '#aaa' }}>No hay convocatorias vigentes por el momento.</p>
              <p style={{ fontSize: 13 }}>Mantente atento a nuestras redes o contáctanos para conocer las próximas fechas.</p>
            </div>
          ) : (
            <div className="conv-vigentes-grid">
              {vigentes.map((c) => (
                <div className="conv-card-vigente" key={c.codigo} onClick={() => setConvAbierta(c)}>
                  <div className="conv-card-vigente-body">
                    <span className="conv-vigente-badge" style={{ fontSize: 10 }}><i className="ti ti-circle-filled" style={{ fontSize: 7 }}></i> B-2026</span>
                    <h3>{c.titulo}</h3>
                    <div className="conv-card-vigente-fecha">
                      <i className="ti ti-calendar"></i>
                      Inicio de clases: {c.inicioClases}
                    </div>
                    <p>{c.descCorta}</p>
                  </div>
                  <div className="conv-card-vigente-footer">
                    <button className="btn-sm-rojo" onClick={(e) => { e.stopPropagation(); setConvAbierta(c); }}>
                      <i className="ti ti-info-circle"></i> Ver detalles
                    </button>
                    <a href={c.doc} download className="btn-sm-outline" onClick={(e) => e.stopPropagation()}>
                      <i className="ti ti-download"></i> Descargar
                    </a>
                  </div>
                </div>
              ))}
            </div>
          )}

          {cerradas.length > 0 && (
            <div style={{ marginTop: 44 }}>
              <div className="conv-section-title" style={{ marginBottom: 20 }}>
                <h3 style={{ color: '#777' }}>Convocatorias Cerradas</h3>
                <span style={{ background: '#eee', color: '#888', padding: '3px 12px', borderRadius: 99, fontSize: 11, fontWeight: 700, letterSpacing: '.07em', display: 'inline-flex', alignItems: 'center', gap: 5 }}>
                  <i className="ti ti-lock" style={{ fontSize: 10 }}></i> Proceso finalizado
                </span>
              </div>
              <div className="conv-vigentes-grid">
                {cerradas.map((c) => (
                  <div className="conv-card-vigente" key={c.codigo} style={{ opacity: 0.6, cursor: 'default', position: 'relative' }}>
                    <div style={{ position: 'absolute', top: 10, right: 10, background: '#888', color: '#fff', fontSize: 9, fontWeight: 800, letterSpacing: '.1em', textTransform: 'uppercase', padding: '3px 9px', borderRadius: 3 }}>CERRADA</div>
                    <div className="conv-card-vigente-body">
                      <span className="conv-vigente-badge" style={{ fontSize: 10, background: '#aaa', color: '#fff', borderColor: '#aaa' }}><i className="ti ti-lock" style={{ fontSize: 7 }}></i> Cerrada</span>
                      <h3>{c.titulo}</h3>
                      <div className="conv-card-vigente-fecha"><i className="ti ti-calendar"></i> Inicio de clases: {c.inicioClases}</div>
                      <p>{c.descCorta}</p>
                    </div>
                    <div className="conv-card-vigente-footer">
                      <a href={c.doc} download className="btn-sm-outline"><i className="ti ti-download"></i> Descargar</a>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          )}

          <div style={{ marginTop: 44, marginBottom: 16 }}>
            <div className="conv-section-title" style={{ marginBottom: 20 }}>
              <h3>Cronograma Semestre B-2026</h3>
            </div>
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill,minmax(260px,1fr))', gap: 14 }}>
              {CRONOGRAMA_B2026.map((paso) => {
                const e = estadoPaso(paso, ahora, marcador);
                return (
                  <div key={paso.label} style={{ background: '#fff', border: '1px solid #eee', borderLeft: `3px solid ${e.color}`, borderRadius: 4, padding: '14px 16px', display: 'flex', gap: 12, alignItems: 'flex-start' }}>
                    <div style={{ width: 36, height: 36, background: e.bg, borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                      <i className={`ti ${e.icono}`} style={{ color: e.color, fontSize: 18 }}></i>
                    </div>
                    <div>
                      <div style={{ fontSize: 11, fontWeight: 700, textTransform: 'uppercase', letterSpacing: '.08em', color: e.color, marginBottom: 2 }}>{e.etiqueta}</div>
                      <div style={{ fontSize: 14, fontWeight: 700, color: '#333' }}>{paso.label}</div>
                      <div style={{ fontSize: 12, color: '#888', marginTop: 2 }}>{paso.fechas}</div>
                    </div>
                  </div>
                );
              })}
            </div>
            <p style={{ fontSize: 12, color: '#aaa', marginTop: 14, fontStyle: 'italic' }}>
              <i className="ti ti-alert-triangle" style={{ fontSize: 13, color: 'var(--dorado)' }}></i> Las fechas están sujetas a cambios por parte de la División de Estudios de Posgrado.
            </p>
          </div>

          <div style={{ marginTop: 44 }}>
            <div className="conv-section-title" style={{ marginBottom: 20 }}>
              <h3>Requisitos y Condiciones de Admisión</h3>
            </div>
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 24 }}>
              <div style={{ background: '#fff', border: '1px solid rgba(0,0,0,0.07)', borderRadius: 6, padding: 24 }}>
                <div style={{ fontSize: 12, fontWeight: 700, textTransform: 'uppercase', letterSpacing: '.09em', color: 'var(--dorado)', marginBottom: 14 }}>
                  <i className="ti ti-file-description" style={{ fontSize: 14 }}></i> Documentación requerida
                </div>
                <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: 9 }}>
                  {DOCUMENTACION_REQUERIDA.map((r) => (
                    <li key={r} style={{ fontSize: 13, color: '#555', display: 'flex', alignItems: 'flex-start', gap: 8, lineHeight: 1.5 }}>
                      <i className="ti ti-point-filled" style={{ color: 'var(--rojo)', fontSize: 10, marginTop: 4, flexShrink: 0 }}></i>
                      {r}
                    </li>
                  ))}
                </ul>
              </div>
              <div style={{ background: '#fff', border: '1px solid rgba(0,0,0,0.07)', borderRadius: 6, padding: 24 }}>
                <div style={{ fontSize: 12, fontWeight: 700, textTransform: 'uppercase', letterSpacing: '.09em', color: 'var(--dorado)', marginBottom: 14 }}>
                  <i className="ti ti-checklist" style={{ fontSize: 14 }}></i> Proceso de admisión
                </div>
                <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: 9 }}>
                  {PROCESO_ADMISION.map((r, i) => (
                    <li key={i} style={{ fontSize: 13, color: '#555', display: 'flex', alignItems: 'flex-start', gap: 8, lineHeight: 1.5 }}>
                      <i className="ti ti-point-filled" style={{ color: 'var(--rojo)', fontSize: 10, marginTop: 4, flexShrink: 0 }}></i>
                      {r}
                    </li>
                  ))}
                </ul>
              </div>
            </div>
          </div>

          <div style={{ marginTop: 40, padding: '20px 24px', background: '#f8f7f5', borderLeft: '4px solid var(--rojo-oscuro)', borderRadius: '0 6px 6px 0' }}>
            <p style={{ fontSize: 14, color: '#555', lineHeight: 1.7, margin: 0 }}>
              <strong>¿Tienes dudas sobre el proceso de admisión?</strong><br />
              Comunícate con la División de Estudios de Posgrado al{' '}
              <a href="tel:6188271200" style={{ color: 'var(--rojo)', fontWeight: 700 }}>(618) 827 12 00 ext. 5430</a> o
              escríbenos a <a href="mailto:posgradofeca@ujed.mx" style={{ color: 'var(--rojo)', fontWeight: 700 }}>posgradofeca@ujed.mx</a>.
              Horario de atención: Lunes a Viernes 8:00 a.m. – 8:00 p.m., Sábados 9:00 a.m. – 2:00 p.m.
            </p>
          </div>
        </div>
      </section>

      <ConvocatoriaModal conv={convAbierta} onClose={() => setConvAbierta(null)} />

      <PageNavBottom prev={{ to: '/oferta-educativa', label: 'Oferta Educativa' }} next={{ to: '/contacto', label: 'Contacto' }} />
    </>
  );
}
