import { useParams, Navigate, NavLink } from 'react-router-dom';
import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';
import { PROGRAMAS, NIVEL_LABEL } from '../data/programas.js';
import { PROGRAM_CONTENT, NOTA_TITULACION, admisionPasos } from '../data/programContent.js';

// Portado de las 8 páginas estáticas Posgrado/pages/program_*.html
// (una por programa) como una sola ruta dinámica /oferta-educativa/:slug,
// con el contenido real de cada una en src/data/programContent.js.
export default function ProgramDetail() {
  const { slug } = useParams();
  const programa = PROGRAMAS.find((p) => p.slug === slug);
  const info = programa ? PROGRAM_CONTENT[slug] : null;

  if (!programa || !info) {
    return <Navigate to="/oferta-educativa" replace />;
  }

  return (
    <>
      <PageBanner title={info.nombreCompleto}>
        <div style={{ display: 'flex', gap: 8, alignItems: 'center', marginBottom: 12, flexWrap: 'wrap' }}>
          <span className={`program-level${programa.nivel === 'doctorado' ? ' level-doc' : programa.nivel === 'especialidad' ? ' level-esp' : ''}`} style={{ fontSize: 12, padding: '5px 14px' }}>
            {NIVEL_LABEL[programa.nivel]}
          </span>
          {programa.snp && <span className="program-pnpc"><i className="ti ti-star"></i> SNP · CONAHCYT</span>}
          {info.acreditacion && <span className="program-pnpc"><i className="ti ti-award"></i> Acreditada CIEES</span>}
        </div>
        <p className="page-banner-desc">{info.bannerDesc}</p>
      </PageBanner>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div style={{ display: 'grid', gridTemplateColumns: '1fr 280px', gap: 48, alignItems: 'start' }}>
            <div>
              <div className="seccion-header" style={{ marginBottom: 20 }}>
                <span className="kicker">Objetivo General</span>
                <h2>¿Qué busca este programa?</h2>
              </div>
              <p style={{ fontSize: 16, color: '#555', lineHeight: 1.8 }}>{info.objetivo}</p>
            </div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 12 }}>
              <div className="directorio-item">
                <div className="directorio-icon"><i className="ti ti-clock"></i></div>
                <div><div className="directorio-nombre">Duración</div><div className="directorio-cargo">{programa.duracion}</div></div>
              </div>
              <div className="directorio-item">
                <div className="directorio-icon"><i className={`ti ${programa.icono}`}></i></div>
                <div><div className="directorio-nombre">Modalidad</div><div className="directorio-cargo">{programa.modalidad}</div></div>
              </div>
              {(programa.snp || info.acreditacion) && (
                <div className="directorio-item">
                  <div className="directorio-icon"><i className="ti ti-star"></i></div>
                  <div><div className="directorio-nombre">Acreditación</div><div className="directorio-cargo">{programa.snp ? 'SNP · CONAHCYT' : info.acreditacion}</div></div>
                </div>
              )}
              <div className="directorio-item">
                <div className="directorio-icon"><i className="ti ti-map-pin"></i></div>
                <div><div className="directorio-nombre">Sede</div><div className="directorio-cargo">Durango, Dgo.</div></div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className="seccion seccion-gris">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Perfiles del Estudiante</span>
            <h2>Perfil de Ingreso y Egreso</h2>
          </div>
          <div className="mv-grid">
            <div className="mv-card mv-card--mision">
              <span className="mv-card-deco">IN</span>
              <i className="ti ti-user-check mv-card-icon"></i>
              <h3>Perfil de Ingreso</h3>
              <p>
                Al ingresar a {info.nombreCompleto}, el aspirante deberá tener:
                <br /><br />
                {info.perfilIngreso.map((item, i) => (
                  <span key={i}>· {item}<br /></span>
                ))}
              </p>
            </div>
            <div className="mv-card mv-card--vision">
              <span className="mv-card-deco">EG</span>
              <i className="ti ti-certificate mv-card-icon"></i>
              <h3>Perfil de Egreso</h3>
              <p>
                El egresado de {info.nombreCompleto}:
                <br /><br />
                {info.perfilEgreso.map((item, i) => (
                  <span key={i}>· {item}<br /></span>
                ))}
              </p>
            </div>
          </div>
        </div>
      </section>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Titulación</span>
            <h2>Modalidades de Titulación</h2>
          </div>
          <div className="recursos-grid">
            {info.titulacion.map((t) => (
              <div className="recurso-card" key={t.titulo}>
                <div className="recurso-icon tipo-doc"><i className={`ti ${t.icono}`}></i></div>
                <div className="recurso-info">
                  <h4>{t.titulo}</h4>
                  <p>{t.desc}</p>
                </div>
              </div>
            ))}
          </div>
          <p style={{ fontSize: 11, color: '#aaa', marginTop: 18, lineHeight: 1.7, borderTop: '1px solid #eee', paddingTop: 14 }}>
            * {NOTA_TITULACION}
          </p>
        </div>
      </section>

      <section className="seccion seccion-gris">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Mercado Laboral</span>
            <h2>Campo de Acción Profesional</h2>
            {info.campoLaboralDesc && <p>{info.campoLaboralDesc}</p>}
          </div>
          <div className="directorio-grid">
            {info.campoLaboral.map((c) => (
              <div className="directorio-item" key={c.titulo}>
                <div className="directorio-icon"><i className={`ti ${c.icono}`}></i></div>
                <div><div className="directorio-nombre">{c.titulo}</div><div className="directorio-cargo">{c.desc}</div></div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="seccion seccion-oscura">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Admisión</span>
            <h2>Proceso de Inscripción</h2>
          </div>
          <div className="directorio-grid" style={{ marginBottom: 32 }}>
            {admisionPasos(slug).map((paso, i) => (
              <div className="directorio-item" key={paso.titulo} style={{ background: '#2a2a2a', borderLeftColor: i === 0 ? 'var(--rojo)' : 'var(--dorado)' }}>
                <div
                  className="directorio-icon"
                  style={{
                    background: i === 0 ? 'rgba(227,19,19,0.15)' : 'rgba(168,127,61,0.15)',
                    color: i === 0 ? 'var(--rojo)' : 'var(--dorado)',
                    fontFamily: "'Barlow Condensed',sans-serif",
                    fontSize: 22,
                    fontWeight: 700,
                  }}
                >
                  {i + 1}
                </div>
                <div>
                  <div className="directorio-nombre" style={{ color: '#fff' }}>{paso.titulo}</div>
                  <div className="directorio-cargo" style={{ color: '#aaa' }}>{paso.desc}</div>
                </div>
              </div>
            ))}
          </div>
          <p style={{ fontSize: 11, color: 'rgba(255,255,255,0.45)', marginBottom: 18, lineHeight: 1.7, borderTop: '1px solid rgba(255,255,255,0.1)', paddingTop: 14 }}>
            * {NOTA_TITULACION}
          </p>
          <div style={{ display: 'flex', gap: 14, flexWrap: 'wrap' }}>
            <NavLink to="/convocatorias" className="btn-primary"><i className="ti ti-file-description"></i> Ver Convocatorias</NavLink>
            <a href="mailto:posgradofeca@ujed.mx" className="btn-outline-white"><i className="ti ti-mail"></i> posgradofeca@ujed.mx</a>
          </div>
        </div>
      </section>

      <PageNavBottom
        prev={{ to: '/oferta-educativa', label: 'Oferta Educativa' }}
        next={{ to: '/convocatorias', label: 'Convocatorias' }}
      />
    </>
  );
}
