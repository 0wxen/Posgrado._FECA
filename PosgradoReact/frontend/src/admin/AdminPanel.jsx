import { useState } from 'react';
import '../styles/admin.css';
import { MODULOS, TABS_EXTRA, BLOQUES_CONOCIDOS } from '../data/modulos.js';
import AdminModulePanel from './AdminModulePanel.jsx';

// Portado de Posgrado/php/admin/panel.php ("Control Maestro"). El PHP
// original vive en PosgradoReact/backend/php/admin/panel.php y sigue
// siendo dueño de la sesión/autenticación y de guardar.php; este
// componente reproduce su interfaz (pestañas + módulos genéricos) para
// que quede en React, pendiente de conectarlo a una API JSON real.
export default function AdminPanel() {
  const [tab, setTab] = useState('oferta');
  const tabsValidas = { ...MODULOS, ...TABS_EXTRA };

  return (
    <div style={{ fontFamily: "'Barlow', sans-serif" }}>
      <header className="panel-header">
        <div className="panel-header-title">
          Control Maestro
          <small>División de Estudios de Posgrado · FECA UJED</small>
        </div>
        <nav className="panel-header-nav">
          {/* CONTENIDO: nombre y rol del usuario autenticado */}
          <a href="/" target="_blank" rel="noopener noreferrer"><i className="ti ti-external-link"></i> Ver sitio</a>
          <a href="/admin/login">Salir</a>
        </nav>
      </header>

      <main className="panel-main">
        <div className="admin-tabs">
          {Object.entries(tabsValidas).map(([clave, def]) => (
            <button
              key={clave}
              type="button"
              className={`admin-tab-btn${tab === clave ? ' activo' : ''}`}
              onClick={() => setTab(clave)}
            >
              <i className={`ti ${def.icono}`}></i> {def.etiqueta}
            </button>
          ))}
        </div>

        {MODULOS[tab] && <AdminModulePanel modulo={tab} definicion={MODULOS[tab]} />}

        {tab === 'bloques' && (
          <>
            <div className="admin-panel-hdr">
              <div className="admin-panel-hdr-left"><h3>Página principal (bloques de texto)</h3></div>
              <button type="button" className="btn-sm-rojo"><i className="ti ti-plus"></i> Agregar bloque nuevo</button>
            </div>
            <table className="admin-table">
              <thead>
                <tr><th>Página</th><th>Bloque</th><th>Contenido actual</th><th></th></tr>
              </thead>
              <tbody>
                {BLOQUES_CONOCIDOS.map((c) => (
                  <tr key={`${c.pagina}::${c.clave}`}>
                    <td>{c.pagina}</td>
                    <td>{c.etiqueta}<br /><small style={{ color: '#aaa' }}>{c.clave}</small></td>
                    {/* CONTENIDO: valor actual del bloque (vía API) */}
                    <td><em style={{ color: '#ccc' }}>Usa el texto por defecto del sitio</em></td>
                    <td><button type="button" className="admin-btn-edit"><i className="ti ti-pencil"></i> Editar</button></td>
                  </tr>
                ))}
              </tbody>
            </table>
          </>
        )}

        {tab === 'paginas' && (
          <>
            <div className="admin-panel-hdr">
              <div className="admin-panel-hdr-left"><h3>Páginas nuevas</h3><span className="admin-count-badge">0</span></div>
              <button type="button" className="btn-sm-rojo"><i className="ti ti-plus"></i> Agregar página</button>
            </div>
            <table className="admin-table">
              <thead><tr><th>Título</th><th>URL</th><th>Estado</th><th></th></tr></thead>
              <tbody>
                {/* CONTENIDO: páginas dinámicas creadas desde el panel (tabla paginas_dinamicas) */}
                <tr><td colSpan={4}>Todavía no hay páginas nuevas.</td></tr>
              </tbody>
            </table>
          </>
        )}

        {tab === 'historial' && (
          <>
            <div className="admin-panel-hdr">
              <div className="admin-panel-hdr-left"><h3>Historial de cambios</h3><span className="admin-count-badge">0</span></div>
            </div>
            <p style={{ fontSize: 13, color: '#888', marginTop: -10 }}>
              Cada creación, edición o eliminación queda aquí. "Restaurar" vuelve a dejar el elemento
              como estaba antes de ese cambio (y esa restauración también queda registrada).
            </p>
            <table className="admin-table">
              <thead><tr><th>Cuándo</th><th>Quién</th><th>Módulo</th><th>Acción</th><th></th></tr></thead>
              <tbody>
                {/* CONTENIDO: eventos de auditoría (tabla audit_log, vía includes/auditoria.php) */}
                <tr><td colSpan={5}>Todavía no hay historial.</td></tr>
              </tbody>
            </table>
          </>
        )}
      </main>
    </div>
  );
}
