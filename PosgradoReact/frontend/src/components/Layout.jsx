import { NavLink, Outlet } from 'react-router-dom';
import { TELEFONO_GENERAL, CORREO_GENERAL } from '../data/contactInfo.js';

// Portado de la cabecera/pie de Posgrado/php/main.php. La lógica de
// resaltar el enlace activo (⦿ / 𐤏) que antes vivía en el <script> al
// final de main.php aquí es NavLink de react-router, sin JS manual.
const NAV_LINKS = [
  { to: '/nosotros', label: 'Nosotros' },
  { to: '/oferta-educativa', label: 'Oferta Educativa' },
  { to: '/investigacion', label: 'Investigación' },
  { to: '/comunidad', label: 'Comunidad' },
  { to: '/blog', label: 'Blog' },
];

function NavChevron({ isActive }) {
  return (
    <span className="chevron" aria-hidden="true">
      {isActive ? '⦿' : '𐤏'}
    </span>
  );
}

export default function Layout() {
  return (
    <>
      <div className="top-bar">
        <div className="inner">
          <a href="https://www.facebook.com/FECAUJEDMX" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <i className="ti ti-brand-facebook"></i>
          </a>
          <a href="https://x.com/fecaujedmx" target="_blank" rel="noopener noreferrer" aria-label="X / Twitter">
            <i className="ti ti-brand-x"></i>
          </a>
          <a href="https://www.instagram.com/fecaujedmx" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
            <i className="ti ti-brand-instagram"></i>
          </a>
          <a href="https://www.tiktok.com/@fecaujed.mx" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
            <i className="ti ti-brand-tiktok"></i>
          </a>
          <a href="mailto:posgradofeca@ujed.mx" aria-label="Correo electrónico">
            <i className="ti ti-mail"></i>
          </a>
        </div>
      </div>

      <header className="header-main" role="banner">
        <div className="inner">
          <NavLink to="/" className="header-logos" aria-label="Inicio — División de Estudios de Posgrado FECA UJED">
            <img src="/assets/img/logo-ujed.png" className="logo-ujed-img" alt="Logo UJED" />
            <div className="logo-divider" aria-hidden="true"></div>
            <div className="logo-feca-block">
              <img src="/assets/img/logo-feca.png" className="logo-feca-img" alt="Logo FECA" />
            </div>
            <div className="logo-section-divider" aria-hidden="true"></div>
            <div className="logo-division-block">
              <img src="/assets/img/logo-dep.png" className="logo-division-img" alt="División de Estudios de Posgrado FECA UJED" />
            </div>
          </NavLink>

          <nav role="navigation" aria-label="Menú principal">
            {NAV_LINKS.map((item) => (
              <NavLink
                key={item.to}
                to={item.to}
                className={({ isActive }) => `nav-link${isActive ? ' is-active' : ''}`}
              >
                {({ isActive }) => (
                  <>
                    {item.label} <NavChevron isActive={isActive} />
                  </>
                )}
              </NavLink>
            ))}
            <NavLink to="/contacto" className="nav-cta">
              Contacto
            </NavLink>
          </nav>
        </div>
      </header>

      <main>
        <div className="inner page-content">
          <Outlet />
        </div>
      </main>

      <footer className="footer" role="contentinfo">
        <div className="inner">
          <div className="footer-grid">
            <div>
              <div className="footer-brand-logos">
                <img src="/assets/img/logo-dep.png" style={{ height: 44, width: 'auto' }} alt="División de Estudios de Posgrado" />
                <div>
                  <div className="footer-brand-name">División de Estudios de Posgrado</div>
                  <div className="footer-brand-sub">
                    Facultad de Economía, Contaduría y Administración
                    <br />
                    Universidad Juárez del Estado de Durango
                  </div>
                </div>
              </div>
              <p className="footer-brand-desc">
                Formamos líderes con excelencia académica, investigación y compromiso para el desarrollo de la sociedad.
              </p>
              <div className="footer-social">
                <a href="https://www.facebook.com/FECAUJEDMX" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                  <i className="ti ti-brand-facebook"></i>
                </a>
                <a href="https://x.com/fecaujedmx" target="_blank" rel="noopener noreferrer" aria-label="X / Twitter">
                  <i className="ti ti-brand-x"></i>
                </a>
                <a href="https://www.instagram.com/fecaujedmx" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                  <i className="ti ti-brand-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@fecaujed.mx" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
                  <i className="ti ti-brand-tiktok"></i>
                </a>
                <a href="mailto:posgradofeca@ujed.mx" aria-label="Correo">
                  <i className="ti ti-mail"></i>
                </a>
              </div>
            </div>

            <div className="footer-col">
              <div className="footer-col-title">Contacto</div>
              <div className="footer-contact-item">
                <i className="ti ti-map-pin"></i>
                <span>Fanny Anitua s/n, Col. Los Ángeles, C.P. 34000<br />Durango, Dgo., México</span>
              </div>
              <div className="footer-contact-item">
                <i className="ti ti-phone"></i>
                <span>{TELEFONO_GENERAL.texto}</span>
              </div>
              <div className="footer-contact-item">
                <i className="ti ti-mail"></i>
                <a href={`mailto:${CORREO_GENERAL}`}>{CORREO_GENERAL}</a>
              </div>
            </div>

            <div className="footer-col">
              <div className="footer-col-title">Secciones</div>
              <ul>
                <li><NavLink to="/nosotros">Nosotros</NavLink></li>
                <li><NavLink to="/oferta-educativa">Oferta Educativa</NavLink></li>
                <li><NavLink to="/investigacion">Investigación</NavLink></li>
                <li><NavLink to="/comunidad">Comunidad</NavLink></li>
                <li><NavLink to="/blog">Blog</NavLink></li>
                <li><NavLink to="/contacto">Contacto</NavLink></li>
              </ul>
            </div>

            <div className="footer-col">
              <div className="footer-col-title">Enlaces rápidos</div>
              <ul>
                <li><NavLink to="/aviso-privacidad">Aviso de Privacidad</NavLink></li>
                <li><NavLink to="/transparencia">Transparencia</NavLink></li>
                <li><NavLink to="/mapa-sitio">Mapa del Sitio</NavLink></li>
                <li>
                  <a href="https://ujed.mx" target="_blank" rel="noopener noreferrer">Directorio UJED</a>
                </li>
                <li><NavLink to="/convocatorias">Convocatorias</NavLink></li>
                <li><NavLink to="/publicaciones">Publicaciones</NavLink></li>
              </ul>
            </div>
          </div>

          <div className="footer-bottom">
            <span>© {new Date().getFullYear()} División de Estudios de Posgrado FECA · UJED. Todos los derechos reservados.</span>
            <div className="footer-bottom-links">
              <NavLink to="/aviso-privacidad">Aviso de Privacidad</NavLink>
              <NavLink to="/terminos">Términos de Uso</NavLink>
              <NavLink to="/mapa-sitio">Mapa del Sitio</NavLink>
            </div>
          </div>
        </div>
      </footer>

      <div className="footer-accent-bar" aria-hidden="true"></div>
    </>
  );
}
