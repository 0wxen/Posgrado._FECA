import { NavLink } from 'react-router-dom';
import HeroSplit from '../components/HeroSplit.jsx';
import { HERO, CONVOCATORIAS_HOME, NOTICIAS_HOME, NOSOTROS_HOME, GALERIA_HOME } from '../data/homeContent.js';

// Portado de Posgrado/pages/home.html, con el mismo contenido de
// respaldo que la página mostraba cuando no hay convocatorias/noticias
// en la base de datos (que es el estado actual, sin backend conectado).
export default function Home() {
  return (
    <>
      <HeroSplit titulo={HERO.titulo} subtitulo={HERO.subtitulo} stats={HERO.stats} slides={HERO.slides} />

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Proceso activo · Semestre B-2026</span>
            <h2>Convocatorias Abiertas</h2>
            <p>Tres programas de maestría con admisión activa para el Semestre B-2026.</p>
            <p style={{ display: 'inline-flex', alignItems: 'center', gap: 6, fontSize: 13, fontWeight: 700, color: 'var(--rojo)', background: 'rgba(227,19,19,0.07)', padding: '5px 14px', borderRadius: 99, marginTop: 8 }}>
              <i className="ti ti-calendar-event"></i> Inicio de clases: 14 de agosto de 2026
            </p>
          </div>

          <div className="conv-grid">
            {CONVOCATORIAS_HOME.map((c) => (
              <div className="conv-card" key={c.codigo}>
                <span className="conv-badge">Semestre B-2026</span>
                <h3>{c.titulo}</h3>
                <p>{c.descHome}</p>
                <div className="conv-card-actions">
                  <a href={c.doc} target="_blank" rel="noopener noreferrer" className="btn-sm-rojo">
                    <i className="ti ti-download"></i> Descargar Convocatoria
                  </a>
                  <NavLink to="/convocatorias" className="btn-sm-outline">Más Información</NavLink>
                </div>
              </div>
            ))}
          </div>

          <div className="seccion-cta">
            <NavLink to="/convocatorias" className="btn-link-rojo">
              Ver detalles y cronograma <i className="ti ti-arrow-right"></i>
            </NavLink>
          </div>
        </div>
      </section>

      <section className="seccion seccion-gris">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Últimas actualizaciones</span>
            <h2>Nuestras Noticias</h2>
          </div>

          <div className="noticias-grid">
            {NOTICIAS_HOME.map((n) => (
              <article className="noticia-card" key={n.titulo}>
                <div className="noticia-img">
                  <i className="ti ti-news"></i>
                  <span>Imagen de noticia</span>
                </div>
                <div className="noticia-body">
                  <span className="noticia-tag">Noticia</span>
                  <h3>{n.titulo}</h3>
                  <p>{n.desc}</p>
                  <NavLink to="/blog" className="noticia-leer">
                    Leer más <i className="ti ti-arrow-right"></i>
                  </NavLink>
                </div>
              </article>
            ))}
          </div>

          <div className="seccion-cta">
            <NavLink to="/blog" className="btn-link-rojo">
              Ver todas las noticias <i className="ti ti-arrow-right"></i>
            </NavLink>
          </div>
        </div>
      </section>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Quiénes somos</span>
            <h2>Nosotros</h2>
          </div>

          <div className="directivos-grid">
            {NOSOTROS_HOME.map((p) => (
              <div className="directivo-card" key={p.nombre}>
                <div className="directivo-foto">
                  <i className="ti ti-user"></i>
                  <span>{p.cargo}</span>
                </div>
                <div className="directivo-info">
                  <span className="directivo-rol">{p.rol}</span>
                  <h3>{p.nombre}</h3>
                  <p>{p.mensaje}</p>
                  <NavLink to="/nosotros">
                    Conoce más <i className="ti ti-arrow-right"></i>
                  </NavLink>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="seccion seccion-oscura">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Nuestra comunidad</span>
            <h2>Nuestra vida en la División de Estudios de Posgrado</h2>
          </div>

          <div className="galeria-grid">
            {GALERIA_HOME.map((g) => (
              <div className={`galeria-item${g.large ? ' galeria-item--large' : ''}`} key={g.archivo}>
                <i className="ti ti-photo"></i>
                <span>{g.archivo}</span>
              </div>
            ))}
          </div>

          <div className="seccion-cta" style={{ marginTop: 32 }}>
            <NavLink to="/comunidad" className="btn-outline-white">
              Ver comunidad <i className="ti ti-arrow-right"></i>
            </NavLink>
          </div>
        </div>
      </section>
    </>
  );
}
