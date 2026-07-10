import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';

// Portado de Posgrado/php/pages/research.php.
const PUBLICACIONES_FALLBACK = [
  { tag: 'Artículo', titulo: 'Impacto de la política fiscal en el crecimiento económico regional', meta: 'Revista de Economía y Administración · Año 2024 · Vol. 12' },
  { tag: 'Capítulo de libro', titulo: 'Gestión pública y transparencia: retos para el norte de México', meta: 'Compilación Iberoamericana de Administración Pública · 2024' },
  { tag: 'Memorias de congreso', titulo: 'Innovación en negocios: estrategias para el mercado duranguense', meta: 'Congreso Internacional de Gestión · Durango, 2023' },
];

export default function Research() {
  return (
    <>
      <PageBanner title="Investigación">
        <p className="page-banner-desc">
          Generamos conocimiento con impacto regional y nacional a través de nuestros cuerpos académicos, grupos disciplinares y producción científica.
        </p>
      </PageBanner>

      <div className="invest-grid">
        <a className="invest-card" href="https://cadepfeca.ujed.mx/cuerpos-academicos/gestion-y-desarrollo-de-las-organizaciones" target="_blank" rel="noopener noreferrer">
          <i className="ti ti-users invest-card-icon"></i>
          <h2>Cuerpos Académicos</h2>
          <p>Grupos de profesores-investigadores que comparten una o más Líneas de Generación y Aplicación del Conocimiento (LGAC) en temas disciplinares afines. Consulta los cuerpos activos, sus integrantes y sus líneas de trabajo.</p>
          <span className="invest-card-cta">Explorar cuerpos <i className="ti ti-arrow-right"></i></span>
        </a>

        <a className="invest-card" href="/grupos-disciplinares">
          <i className="ti ti-microscope invest-card-icon"></i>
          <h2>Grupos Disciplinares</h2>
          <p>Equipos de trabajo enfocados en líneas de investigación específicas que enriquecen la actividad académica y fortalecen los programas de posgrado. Conoce sus proyectos en desarrollo y resultados recientes.</p>
          <span className="invest-card-cta">Ver grupos <i className="ti ti-arrow-right"></i></span>
        </a>

        <a className="invest-card" href="/publicaciones">
          <i className="ti ti-book-2 invest-card-icon"></i>
          <h2>Publicaciones</h2>
          <p>Artículos, libros, capítulos y memorias de congreso producidos por los investigadores de la División. Una muestra del compromiso con la generación de conocimiento riguroso y de alto impacto.</p>
          <span className="invest-card-cta">Ver publicaciones <i className="ti ti-arrow-right"></i></span>
        </a>
      </div>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Producción académica</span>
            <h2>Publicaciones Recientes</h2>
          </div>
          <div className="noticias-grid">
            {PUBLICACIONES_FALLBACK.map((p) => (
              <article className="noticia-card" key={p.titulo}>
                <div className="noticia-img"><i className="ti ti-book-2"></i></div>
                <div className="noticia-body">
                  <span className="noticia-tag">{p.tag}</span>
                  <h3>{p.titulo}</h3>
                  <p>{p.meta}</p>
                  <a href="/publicaciones" className="noticia-leer">Ver publicación <i className="ti ti-arrow-right"></i></a>
                </div>
              </article>
            ))}
          </div>
          <div className="seccion-cta">
            <a href="/publicaciones" className="btn-link-rojo">Ver todas las publicaciones <i className="ti ti-arrow-right"></i></a>
          </div>
        </div>
      </section>

      <PageNavBottom prev={{ to: '/oferta-educativa', label: 'Oferta Educativa' }} next={{ to: '/comunidad', label: 'Comunidad' }} />
    </>
  );
}
