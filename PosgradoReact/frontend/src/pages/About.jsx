import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';
import { DIRECTOR, JEFE_POSGRADO, DIRECTORIO } from '../data/contactInfo.js';

// Portado de Posgrado/pages/about.html (más actualizado que su espejo
// php/pages/about.php: ese último se quedó con nombres/correos viejos o
// genéricos). Los nombres y el directorio vienen de data/contactInfo.js.
const MENSAJES = [
  { cargo: DIRECTOR.cargo, foto: DIRECTOR.foto, nombre: DIRECTOR.nombre, texto: DIRECTOR.mensajeLargo },
  { cargo: JEFE_POSGRADO.cargo, foto: JEFE_POSGRADO.foto, nombre: JEFE_POSGRADO.nombre, texto: JEFE_POSGRADO.mensajeLargo },
];

export default function About() {
  return (
    <>
      <PageBanner title="Nosotros">
        <p className="page-banner-desc">
          Conoce a nuestro equipo directivo, el organigrama y el directorio de la estructura de la División.
        </p>
      </PageBanner>

      <section className="seccion seccion-gris">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Palabras de nuestra dirección</span>
            <h2>Mensaje Institucional</h2>
          </div>
          <div className="mensaje-grid">
            {MENSAJES.map((m) => (
              <div className="mensaje-card" key={m.nombre}>
                <div className="mensaje-card-header">
                  <div className="mensaje-foto">
                    <i className="ti ti-user"></i>
                    <span>{m.foto}</span>
                  </div>
                  <span className="mensaje-cargo">{m.cargo}</span>
                  <div className="mensaje-nombre">{m.nombre}</div>
                </div>
                <div className="mensaje-card-body">
                  <p className="mensaje-texto">
                    {m.texto.map((parrafo, i) => (
                      <span key={i}>
                        {parrafo}
                        {i < m.texto.length - 1 && <><br /><br /></>}
                      </span>
                    ))}
                  </p>
                  <p className="mensaje-firma">— {m.nombre}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Estructura institucional</span>
            <h2>Organigrama</h2>
          </div>
          <div className="organigrama-wrapper">
            <div className="organigrama-placeholder">
              <img src="/assets/img/organigrama.png" alt="Organigrama División de Estudios de Posgrado FECA UJED 2024" />
            </div>
            <a href="/assets/img/organigrama.png" target="_blank" rel="noopener noreferrer" className="btn-link-rojo" style={{ marginTop: 16, display: 'inline-flex' }}>
              <i className="ti ti-download"></i> Descargar organigrama
            </a>
          </div>
        </div>
      </section>

      <section className="seccion seccion-gris">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Personal</span>
            <h2>Directorio</h2>
            <p>Estructura de la División de Estudios de Posgrado FECA UJED.</p>
          </div>
          <div className="directorio-grid">
            {DIRECTORIO.map((d) => (
              <div className="directorio-item" key={d.nombre}>
                <div className="directorio-icon"><i className={`ti ${d.icono}`}></i></div>
                <div>
                  <div className="directorio-nombre">{d.nombre}</div>
                  <div className="directorio-cargo">
                    {d.cargo && <>{d.cargo} · </>}
                    <a href={`mailto:${d.correo}`} style={{ color: 'var(--rojo)', textDecoration: 'none' }}>{d.correo}</a>
                    {d.extension && <> · 618 827 1266 ext. {d.extension}</>}
                    {!d.extension && !d.cargo && <> · 618 827 1266</>}
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <PageNavBottom prev={{ to: '/', label: 'Inicio' }} next={{ to: '/oferta-educativa', label: 'Oferta Educativa' }} />
    </>
  );
}
