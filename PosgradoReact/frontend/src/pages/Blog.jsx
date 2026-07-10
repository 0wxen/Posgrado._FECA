import { useState } from 'react';
import { NavLink } from 'react-router-dom';
import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';

// Portado de Posgrado/pages/blog.html (más completo que su espejo
// php/pages/blog.php: agrega la pestaña "Semana ECA"). Las pestañas,
// antes JS vanilla con data-tabs, aquí son estado de React.
const ENTRADAS = [
  { tag: 'Noticia', titulo: 'Maestría en Economía reconocida en el SNP-CONAHCYT', desc: 'El programa mantiene su reconocimiento dentro del Sistema Nacional de Posgrados.' },
  { tag: 'Evento', titulo: 'Conferencia Internacional de Gestión Pública en la FECA', desc: 'La División fue sede del encuentro académico con ponentes de México, Colombia y España.' },
  { tag: 'Aviso', titulo: 'Actualización de fechas: entrega de tesis ciclo A-2025', desc: 'Nuevas fechas para la entrega y defensa de tesis para alumnos próximos a titularse.' },
  { tag: 'Investigación', titulo: 'Publicación en revista indexada por docentes del Cuerpo Académico', desc: 'Investigadores del CA-FECA publican artículo sobre finanzas públicas en revista de alto impacto.', to: '/investigacion', cta: 'Ver publicaciones' },
  { tag: 'Convocatoria', titulo: 'Convocatoria para el Doctorado en Gestión de las Organizaciones', desc: 'La División abre proceso de admisión para el programa doctoral. Revisa requisitos y fechas.', to: '/convocatorias', cta: 'Ver convocatoria' },
  { tag: 'Comunidad', titulo: 'Egresados distinguidos del Posgrado FECA en puestos directivos', desc: 'Reconocemos a egresados que ocupan cargos de alto impacto en el sector público y privado de Durango.' },
];

const PILARES_ECA = [
  { icono: 'ti-palette', titulo: 'Actividades Culturales y Artísticas', desc: 'Expresión artística, cultura y creatividad como parte de la formación profesional integral.' },
  { icono: 'ti-users', titulo: 'Convivencia y Comunidad', desc: 'Espacio de encuentro entre alumnado, profesorado y egresados de todas las áreas de la FECA.' },
  { icono: 'ti-heart-handshake', titulo: 'Formación Ética y Social', desc: 'Refuerzo de competencias culturales para un desempeño profesional ético y socialmente comprometido.' },
  { icono: 'ti-building-community', titulo: 'Identidad Institucional', desc: 'Encuentro desde la cultura, la identidad y el sentido de pertenencia a la FECA UJED.' },
];

export default function Blog() {
  const [tab, setTab] = useState('noticias');

  return (
    <>
      <PageBanner title="Blog">
        <p className="page-banner-desc">
          Noticias, comunicados, artículos y actualizaciones de la División de Estudios de Posgrado. Mantente informado.
        </p>
      </PageBanner>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="comunidad-tab-header">
            <button className={`comunidad-tab-title${tab === 'noticias' ? ' activo' : ''}`} onClick={() => setTab('noticias')}>
              <i className="ti ti-news"></i> Noticias
            </button>
            <button className={`comunidad-tab-title${tab === 'semana-eca' ? ' activo' : ''}`} onClick={() => setTab('semana-eca')}>
              <i className="ti ti-calendar-event"></i> Semana ECA
            </button>
          </div>

          {tab === 'noticias' && (
            <div>
              <div className="seccion-header" style={{ marginTop: 0, marginBottom: 28 }}>
                <span className="kicker">Lo más reciente</span>
                <h2>Entrada Destacada</h2>
              </div>
              <div className="blog-featured" style={{ marginBottom: 40 }}>
                <div className="blog-featured-img">
                  <img src="/assets/img/blog-destacado.png" alt="Entrada destacada del Blog" />
                </div>
                <div className="blog-featured-body">
                  <span className="noticia-tag">Noticia</span>
                  <h2>Abierta la convocatoria de admisión Ciclo A-2025</h2>
                  <p>
                    La División de Estudios de Posgrado FECA UJED anuncia la apertura del proceso de admisión para el
                    ciclo escolar A-2025 en sus programas de maestría y especialidad. Los interesados pueden descargar
                    la convocatoria y consultar los requisitos de admisión.
                  </p>
                  <NavLink to="/convocatorias" className="btn-sm-rojo" style={{ marginTop: 8 }}>
                    <i className="ti ti-file-text"></i> Ver convocatoria
                  </NavLink>
                </div>
              </div>

              <div className="seccion-header" style={{ marginBottom: 24 }}>
                <span className="kicker">Archivo</span>
                <h2>Todas las Entradas</h2>
              </div>
              <div className="noticias-grid">
                {ENTRADAS.map((e) => (
                  <article className="noticia-card" key={e.titulo}>
                    <div className="noticia-img"><i className="ti ti-news"></i></div>
                    <div className="noticia-body">
                      <span className="noticia-tag">{e.tag}</span>
                      <h3>{e.titulo}</h3>
                      <p>{e.desc}</p>
                      {e.to ? (
                        <NavLink to={e.to} className="noticia-leer">{e.cta} <i className="ti ti-arrow-right"></i></NavLink>
                      ) : (
                        <a href="#" className="noticia-leer">Leer más <i className="ti ti-arrow-right"></i></a>
                      )}
                    </div>
                  </article>
                ))}
              </div>
            </div>
          )}

          {tab === 'semana-eca' && (
            <div>
              <div className="seccion-header" style={{ marginTop: 0, marginBottom: 28 }}>
                <span className="kicker">Evento Institucional · FECA UJED</span>
                <h2>Semana ECA</h2>
                <p>Semana de la Economía, Contaduría y Administración</p>
              </div>

              <div style={{ background: 'linear-gradient(135deg,var(--rojo-oscuro) 0%,#6b1010 100%)', borderRadius: 8, padding: '36px 40px', color: '#fff', marginBottom: 32, position: 'relative', overflow: 'hidden' }}>
                <span style={{ display: 'inline-block', fontSize: 11, fontWeight: 700, textTransform: 'uppercase', letterSpacing: '.1em', background: 'rgba(255,255,255,0.15)', color: '#fff', padding: '4px 12px', borderRadius: 99, marginBottom: 16 }}>
                  <i className="ti ti-star"></i> Evento Anual
                </span>
                <h3 style={{ fontSize: 26, fontWeight: 800, margin: '0 0 16px', color: '#fff' }}>SEMANA ECA</h3>
                <p style={{ fontSize: 15, lineHeight: 1.85, color: 'rgba(255,255,255,0.9)', margin: 0, maxWidth: 700 }}>
                  La Semana ECA (Semana de la Contaduría y Administración) es un espacio de encuentro que convoca a todas
                  las áreas de la FECA en torno a un objetivo común: fortalecer la formación integral del profesionista
                  más allá de lo técnico. A través de actividades culturales, artísticas y de convivencia, busca reforzar
                  aquellas competencias culturales indispensables para un desempeño profesional ético, sensible y
                  socialmente comprometido. Es, en esencia, una pausa formativa que recuerda que la excelencia profesional
                  se construye también desde la cultura, la identidad y el encuentro humano.
                </p>
              </div>

              <div className="directorio-grid" style={{ marginBottom: 32 }}>
                {PILARES_ECA.map((p) => (
                  <div className="directorio-item" key={p.titulo}>
                    <div className="directorio-icon"><i className={`ti ${p.icono}`}></i></div>
                    <div>
                      <div className="directorio-nombre">{p.titulo}</div>
                      <div className="directorio-cargo">{p.desc}</div>
                    </div>
                  </div>
                ))}
              </div>

              <p style={{ fontSize: 11, color: '#aaa', lineHeight: 1.7, borderTop: '1px solid #eee', paddingTop: 14 }}>
                * La información específica sobre fechas, actividades y ponentes de la próxima edición de la Semana ECA se
                publicará oportunamente a través de los canales oficiales de la FECA UJED.
              </p>
            </div>
          )}
        </div>
      </section>

      <PageNavBottom prev={{ to: '/comunidad', label: 'Comunidad' }} next={{ to: '/contacto', label: 'Contacto' }} />
    </>
  );
}
