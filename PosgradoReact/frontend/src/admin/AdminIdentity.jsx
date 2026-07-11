import { useEffect, useState } from 'react';

const STORAGE_KEY = 'dep_admin_perfil_v1';
const VACIO = { nombre: '', usuario: '', password: '' };

function cargar() {
  try { return { ...VACIO, ...JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}') }; } catch { return VACIO; }
}

// El "Perfil" que pidió el usuario no es el perfil de un alumno (eso ya
// existe en /perfil, portado de Posgrado/pages/profile.html) sino la
// identidad de quien administra el Panel de Contenido: nombre para el
// saludo de bienvenida, usuario y contraseña (locales, sin backend real
// -- el modo invitado del panel nunca tuvo autenticación de verdad).
export default function AdminIdentity() {
  const [datos, setDatos] = useState(cargar);
  const [editando, setEditando] = useState(false);
  const [borrador, setBorrador] = useState(datos);

  useEffect(() => {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(datos));
  }, [datos]);

  const abrir = () => { setBorrador(datos); setEditando(true); };
  const guardar = (e) => { e.preventDefault(); setDatos(borrador); setEditando(false); };

  return (
    <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: 14, background: '#fff', border: '1px solid rgba(0,0,0,0.07)', borderRadius: 8, padding: '14px 20px', marginBottom: 20 }}>
      <div style={{ display: 'flex', alignItems: 'center', gap: 12 }}>
        <div style={{ width: 40, height: 40, borderRadius: '50%', background: 'rgba(227,19,19,0.08)', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
          <i className="ti ti-user-circle" style={{ fontSize: 22, color: 'var(--rojo)' }}></i>
        </div>
        <div>
          <div style={{ fontSize: 15, fontWeight: 700, color: '#222' }}>
            Bienvenido{datos.nombre ? `, ${datos.nombre}` : ''}
          </div>
          <div style={{ fontSize: 12, color: '#999' }}>{datos.usuario || 'Sin usuario configurado'}</div>
        </div>
      </div>
      <button className="btn-sm-outline" onClick={abrir}>
        <i className="ti ti-settings"></i> Mi perfil
      </button>

      {editando && (
        <div className="admin-modal-overlay" role="dialog" aria-modal="true" onClick={(e) => { if (e.target === e.currentTarget) setEditando(false); }}>
          <div className="admin-modal-box">
            <div className="admin-modal-hdr">
              <h3><small>Panel de Contenido</small>Mi perfil</h3>
              <button className="admin-modal-cerrar" aria-label="Cerrar" onClick={() => setEditando(false)}>
                <i className="ti ti-x"></i>
              </button>
            </div>
            <form className="admin-modal-body" onSubmit={guardar}>
              <div className="form-group">
                <label className="form-label" htmlFor="ai-nombre">Nombre (para el saludo de bienvenida)</label>
                <input id="ai-nombre" className="form-control" placeholder="Ej. Mtra. Ana López" value={borrador.nombre} onChange={(e) => setBorrador((b) => ({ ...b, nombre: e.target.value }))} />
              </div>
              <div className="form-group">
                <label className="form-label" htmlFor="ai-usuario">Usuario</label>
                <input id="ai-usuario" className="form-control" placeholder="usuario" value={borrador.usuario} onChange={(e) => setBorrador((b) => ({ ...b, usuario: e.target.value }))} />
              </div>
              <div className="form-group">
                <label className="form-label" htmlFor="ai-password">Contraseña</label>
                <input id="ai-password" type="password" className="form-control" placeholder="••••••••" value={borrador.password} onChange={(e) => setBorrador((b) => ({ ...b, password: e.target.value }))} />
                <small style={{ color: '#999' }}>Se guarda solo en este navegador; no hay autenticación real todavía.</small>
              </div>
              <div className="admin-modal-footer" style={{ padding: '18px 0 0' }}>
                <button type="submit" className="btn-primary"><i className="ti ti-device-floppy"></i> Guardar</button>
                <button type="button" className="btn-outline-dark" onClick={() => setEditando(false)}><i className="ti ti-x"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}
