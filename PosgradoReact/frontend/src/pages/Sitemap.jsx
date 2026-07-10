import { NavLink } from 'react-router-dom';
import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';

// Portado de Posgrado/php/pages/sitemap.php. Los enlaces sí son
// estructura/navegación (no contenido editorial), por eso se conservan.
const GRUPOS = [
  {
    titulo: 'Principal',
    enlaces: [
      ['/', 'ti-home', 'Inicio'],
      ['/nosotros', 'ti-building', 'Nosotros'],
      ['/oferta-educativa', 'ti-school', 'Oferta Educativa'],
      ['/investigacion', 'ti-microscope', 'Investigación'],
      ['/comunidad', 'ti-users', 'Comunidad'],
      ['/blog', 'ti-news', 'Blog'],
      ['/contacto', 'ti-mail', 'Contacto'],
    ],
  },
  {
    titulo: 'Investigación',
    enlaces: [
      ['/grupos-disciplinares', 'ti-microscope', 'Grupos Disciplinares'],
      ['/publicaciones', 'ti-book-2', 'Publicaciones'],
    ],
  },
  {
    titulo: 'Legal',
    enlaces: [
      ['/convocatorias', 'ti-file-certificate', 'Convocatorias'],
      ['/aviso-privacidad', 'ti-shield-check', 'Aviso de Privacidad'],
      ['/terminos', 'ti-file-description', 'Términos de Uso'],
      ['/transparencia', 'ti-eye', 'Transparencia'],
    ],
  },
];

export default function Sitemap() {
  return (
    <>
      <PageBanner title="Mapa del Sitio" />

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="sitemap-grid">
            {GRUPOS.map((grupo) => (
              <div key={grupo.titulo}>
                <h3>{grupo.titulo}</h3>
                <ul>
                  {grupo.enlaces.map(([to, icono, label]) => (
                    <li key={to}>
                      <NavLink to={to}><i className={`ti ${icono}`}></i> {label}</NavLink>
                    </li>
                  ))}
                </ul>
              </div>
            ))}
          </div>
        </div>
      </section>

      <PageNavBottom prev={{ to: '/terminos', label: 'Términos de Uso' }} next={{ to: '/contacto', label: 'Contacto' }} />
    </>
  );
}
