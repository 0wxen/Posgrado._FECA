import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';

// Portado de Posgrado/php/pages/publications.php (contenido de respaldo).
const PUBLICACIONES = [
  { tag: 'Artículo', titulo: 'Impacto de la política fiscal en el crecimiento económico regional', meta: 'Revista de Economía y Administración · Vol. 12 · 2024' },
  { tag: 'Capítulo de libro', titulo: 'Gestión pública y transparencia: retos para el norte de México', meta: 'Compilación Iberoamericana de Administración Pública · 2024' },
  { tag: 'Memorias', titulo: 'Innovación en negocios: estrategias para el mercado duranguense', meta: 'Congreso Internacional de Gestión · Durango, 2023' },
  { tag: 'Artículo', titulo: 'Modelos de auditoría en el sector público: evidencia empírica', meta: 'Revista Contaduría y Administración · UNAM · 2023' },
  { tag: 'Artículo', titulo: 'Capital humano y competitividad empresarial en Durango', meta: 'Revista Internacional de Administración y Finanzas · Vol. 16 · 2024' },
  { tag: 'Libro', titulo: 'Finanzas empresariales en contextos emergentes', meta: 'Editorial Universitaria UJED · 2023' },
];

export default function Publications() {
  return (
    <>
      <PageBanner title="Publicaciones">
        <p className="page-banner-desc">
          Producción académica de los investigadores y cuerpos académicos de la División: artículos, libros, capítulos de libro y memorias de congreso.
        </p>
      </PageBanner>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Producción académica</span>
            <h2>Publicaciones y Documentos</h2>
          </div>
          <div className="noticias-grid">
            {PUBLICACIONES.map((p) => (
              <article className="noticia-card" key={p.titulo}>
                <div className="noticia-img"><i className="ti ti-book-2"></i></div>
                <div className="noticia-body">
                  <span className="noticia-tag">{p.tag}</span>
                  <h3>{p.titulo}</h3>
                  <p>{p.meta}</p>
                  <a href="#" className="noticia-leer">Ver más <i className="ti ti-arrow-right"></i></a>
                </div>
              </article>
            ))}
          </div>
        </div>
      </section>

      <PageNavBottom prev={{ to: '/investigacion', label: 'Investigación' }} next={{ to: '/comunidad', label: 'Comunidad' }} />
    </>
  );
}
