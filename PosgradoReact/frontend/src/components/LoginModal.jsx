import { useEffect } from 'react';
import { NavLink } from 'react-router-dom';
import { ADMIN_LOGIN_URL } from '../config/api.js';

// Portado del modal #modal-login de Posgrado/html/htmlcode.html, que se
// abre desde el botón "Ingresar" del top-bar (id btn-abrir-login). Los
// campos de correo/contraseña siguen deshabilitados a propósito: el
// HTML original los deja así porque la autenticación con PostgreSQL
// para usuarios del portal (no del Control Maestro) aún no existe.
export default function LoginModal({ open, onClose }) {
  useEffect(() => {
    if (!open) return;
    document.body.style.overflow = 'hidden';
    const onKey = (e) => { if (e.key === 'Escape') onClose(); };
    document.addEventListener('keydown', onKey);
    return () => {
      document.body.style.overflow = '';
      document.removeEventListener('keydown', onKey);
    };
  }, [open, onClose]);

  if (!open) return null;

  return (
    <div className="login-overlay" role="dialog" aria-modal="true" aria-labelledby="login-titulo" onClick={(e) => { if (e.target === e.currentTarget) onClose(); }}>
      <div className="login-box">
        <div className="login-hdr">
          <img src="/assets/img/logo-dep.png" className="login-hdr-logo" alt="División de Estudios de Posgrado FECA UJED" />
          <h2 id="login-titulo" className="login-hdr-title">
            <small>Acceso al Portal</small>
            Iniciar Sesión
          </h2>
        </div>

        <div className="login-body">
          <div className="login-db-aviso">
            <i className="ti ti-database-off"></i>
            <span>La autenticación con <strong>PostgreSQL</strong> estará disponible próximamente. Por ahora puedes explorar el portal en modo invitado.</span>
          </div>

          <div className="form-group">
            <label className="form-label" htmlFor="login-email">Correo institucional</label>
            <input type="email" id="login-email" className="form-control" placeholder="usuario@ujed.mx" disabled style={{ opacity: 0.5, cursor: 'not-allowed' }} />
          </div>
          <div className="form-group">
            <label className="form-label" htmlFor="login-pass">Contraseña</label>
            <input type="password" id="login-pass" className="form-control" placeholder="••••••••" disabled style={{ opacity: 0.5, cursor: 'not-allowed' }} />
          </div>
          <button className="btn-submit" disabled style={{ opacity: 0.4, cursor: 'not-allowed', marginTop: 0, marginBottom: 0 }}>
            <i className="ti ti-lock"></i> Iniciar Sesión
          </button>

          <div className="login-divider">
            <span>o continúa sin cuenta</span>
          </div>

          <NavLink to="/admin/contenido" className="btn-sin-cuenta" onClick={onClose}>
            <i className="ti ti-door-enter"></i> Entrar sin iniciar sesión
          </NavLink>

          <a href={ADMIN_LOGIN_URL} className="btn-sin-cuenta" style={{ marginTop: 10, textDecoration: 'none' }}>
            <i className="ti ti-shield-lock"></i> Control Maestro
          </a>
        </div>

        <div className="login-footer-note">
          Al ingresar aceptas los <NavLink to="/terminos" onClick={onClose}>términos de uso</NavLink> del portal.
        </div>
      </div>
    </div>
  );
}
