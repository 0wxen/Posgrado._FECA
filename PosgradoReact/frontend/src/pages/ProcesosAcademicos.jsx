import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';

// Portado de Posgrado/pages/procesos_academicos.html.
const RECURSOS = [
  { icono: 'ti-certificate', titulo: 'Constancias', desc: 'Solicitud y seguimiento de constancias de impartición de clases ante la División.', cta: 'Ir al trámite', ctaIcono: 'ti-external-link' },
  { icono: 'ti-file-type-pdf', titulo: 'Lista de Asistencia', desc: 'Formato para el registro de asistencia de alumnos durante el curso. (Pendiente de definir el mecanismo de captura; por ahora solo el formato descargable.)', cta: 'Descargar formato', ctaIcono: 'ti-download' },
  { icono: 'ti-file-type-pdf', titulo: 'Lineamientos Orientados para Impartición de la Clase', desc: 'Criterios institucionales que orientan la planeación y desarrollo de las sesiones de clase en posgrado.', cta: 'Descargar PDF', ctaIcono: 'ti-download' },
];

export default function ProcesosAcademicos() {
  return (
    <>
      <PageBanner title="Procesos Académicos">
        <p className="page-banner-desc">
          Procedimientos y formatos oficiales que acompañan la trayectoria académica de alumnado y profesorado.
        </p>
      </PageBanner>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Acompañamiento académico</span>
            <h2>Proceso de Tutorías</h2>
            <p>Lineamientos y formato para el registro de las actividades de tutoría individual y grupal en todos los programas de posgrado.</p>
          </div>
          <a className="recurso-card" href="#" style={{ borderLeft: '3px solid var(--rojo)', background: '#fff', maxWidth: 720 }}>
            <div className="recurso-icon" style={{ background: 'rgba(149,24,35,0.08)', color: 'var(--rojo-oscuro)' }}><i className="ti ti-clipboard-list"></i></div>
            <div className="recurso-info">
              <h4>Formato de Tutorías</h4>
              <p>Documento oficial para el registro de las sesiones de tutoría, utilizado por tutores y tutorados durante el ciclo escolar.</p>
              <span className="recurso-info-link"><i className="ti ti-download"></i> Descargar formato</span>
            </div>
          </a>
        </div>
      </section>

      <section className="seccion seccion-gris">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Actividad docente</span>
            <h2>Proceso de Impartición de Clases</h2>
            <p>Documentos y trámites relacionados con la impartición de clases en los programas de posgrado.</p>
          </div>
          <div className="recursos-grid">
            {RECURSOS.map((r) => (
              <a className="recurso-card" href="#" key={r.titulo}>
                <div className="recurso-icon tipo-link"><i className={`ti ${r.icono}`}></i></div>
                <div className="recurso-info">
                  <h4>{r.titulo}</h4>
                  <p>{r.desc}</p>
                  <span className="recurso-info-link"><i className={`ti ${r.ctaIcono}`}></i> {r.cta}</span>
                </div>
              </a>
            ))}
          </div>
        </div>
      </section>

      <PageNavBottom prev={{ to: '/comunidad', label: 'Comunidad' }} next={{ to: '/blog', label: 'Blog' }} />
    </>
  );
}
