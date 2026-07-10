import { useState } from 'react';
import { NavLink, useNavigate } from 'react-router-dom';
import '../styles/login.css';
import { ADMIN_LOGIN_URL } from '../config/api.js';

// Portado de Posgrado/php/admin/login.php. El backend NO tiene un
// endpoint JSON de login -- admin/login.php sigue siendo un POST de
// formulario clásico con sesión por cookie httpOnly (config/auth.php,
// tabla usuarios). Por eso aquí se hace POST x-www-form-urlencoded al
// mismo login.php: si las credenciales son correctas responde con un
// redirect a index.php (fetch lo sigue solo); si fallan, vuelve a
// renderizar login.php con el mismo status 200 -- se detecta por res.url.
export default function AdminLogin() {
  const [usuario, setUsuario] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const navigate = useNavigate();

  const onSubmit = async (e) => {
    e.preventDefault();
    setError('');
    try {
      const body = new URLSearchParams({ usuario, password });
      const res = await fetch(ADMIN_LOGIN_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        credentials: 'include',
        body,
      });
      if (res.ok && res.url.endsWith('index.php')) {
        navigate('/admin/panel');
      } else {
        setError('Usuario o contraseña incorrectos.');
      }
    } catch {
      setError('No se pudo contactar al servidor.');
    }
  };

  return (
    <div className="login-brand-wrap" style={{ margin: 0, minHeight: '100vh', display: 'grid', gridTemplateColumns: '1fr 1fr' }}>
      <div className="login-brand">
        <img src="/assets/img/logo-dep.png" className="brand-img" alt="DEP FECA UJED" />
        <h1 className="brand-title">Panel de Administración</h1>
        <div className="brand-divider"></div>
        <p className="brand-sub">
          División de Estudios de Posgrado
          <br />
          Facultad de Economía, Contaduría y Administración
          <br />
          Universidad Juárez del Estado de Durango
        </p>
        <p className="brand-notice">
          Acceso restringido a personal autorizado.
          <br />
          Todos los accesos quedan registrados.
        </p>
      </div>

      <div className="login-form-wrap">
        <div className="login-card">
          <h1>Iniciar sesión</h1>
          <p className="subtitle">Ingresa con tu usuario y contraseña</p>

          {error && (
            <div className="error-msg">
              <i className="ti ti-alert-circle"></i> {error}
            </div>
          )}

          <form onSubmit={onSubmit} autoComplete="on">
            <div className="form-field">
              <label htmlFor="usuario">Usuario</label>
              <div className="input-wrap">
                <i className="ti ti-user"></i>
                <input
                  type="text" id="usuario" autoComplete="username" required placeholder="usuario"
                  value={usuario} onChange={(e) => setUsuario(e.target.value)}
                />
              </div>
            </div>

            <div className="form-field">
              <label htmlFor="password">Contraseña</label>
              <div className="input-wrap">
                <i className="ti ti-lock"></i>
                <input
                  type="password" id="password" autoComplete="current-password" required placeholder="••••••••••••"
                  value={password} onChange={(e) => setPassword(e.target.value)}
                />
              </div>
            </div>

            <button type="submit" className="btn-login">
              <i className="ti ti-login"></i> Entrar al panel
            </button>
          </form>

          <NavLink to="/" className="back-link">
            <i className="ti ti-arrow-left"></i> Volver al sitio público
          </NavLink>
        </div>
      </div>
    </div>
  );
}
