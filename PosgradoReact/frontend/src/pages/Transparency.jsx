import { NavLink } from 'react-router-dom';
import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';

// Portado de Posgrado/php/pages/transparency.php.
const RECURSOS = [
  { icono: 'ti-world', titulo: 'Portal de Transparencia UJED', desc: 'Accede al portal institucional de transparencia y solicitudes de información de la UJED.', href: 'https://www.ujed.mx', cta: 'Ir al portal' },
  { icono: 'ti-scale', titulo: 'Marco Normativo', desc: 'Reglamentos, estatutos y disposiciones legales que rigen a la División y a la UJED.', href: 'https://www.ujed.mx', cta: 'Ver normatividad' },
  { icono: 'ti-building', titulo: 'Página Principal FECA', desc: 'Consulta la normatividad y demás información institucional en el sitio oficial de la FECA UJED.', href: 'http://feca.ujed.mx', cta: 'Ir al sitio de la FECA' },
  { icono: 'ti-mail', titulo: 'Solicitudes de Acceso a la Información', desc: 'Para realizar una solicitud formal de información, comunícate con la coordinación de la División.', href: 'mailto:posgradofeca@ujed.mx', cta: 'Enviar solicitud', ctaIcono: 'ti-mail' },
  { icono: 'ti-file-text', titulo: 'Presupuesto y Ejercicio del Gasto', desc: 'Información sobre el presupuesto asignado y el ejercicio del gasto de la División.', href: '#', cta: 'Descargar', ctaIcono: 'ti-download' },
  { icono: 'ti-file-type-pdf', titulo: 'Plan de Desarrollo Institucional', desc: 'Documento rector con los objetivos estratégicos de la División de Estudios de Posgrado.', href: '#', cta: 'Descargar', ctaIcono: 'ti-download' },
];

export default function Transparency() {
  return (
    <>
      <PageBanner title="Transparencia">
        <p className="page-banner-desc">
          Información pública y documentos institucionales conforme a las obligaciones de transparencia de la Universidad Juárez del Estado de Durango.
        </p>
      </PageBanner>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Acceso a la información pública</span>
            <h2>Información Institucional</h2>
            <p>La UJED y sus dependencias académicas están sujetas a la Ley de Acceso a la Información Pública y Protección de Datos Personales del Estado de Durango.</p>
          </div>

          <div className="recursos-grid">
            {RECURSOS.map((r) => (
              <a className="recurso-card" key={r.titulo} href={r.href} target={r.href.startsWith('http') ? '_blank' : undefined} rel={r.href.startsWith('http') ? 'noopener noreferrer' : undefined}>
                <div className="recurso-icon tipo-link"><i className={`ti ${r.icono}`}></i></div>
                <div className="recurso-info">
                  <h4>{r.titulo}</h4>
                  <p>{r.desc}</p>
                  <span className="recurso-info-link"><i className={`ti ${r.ctaIcono || 'ti-external-link'}`}></i> {r.cta}</span>
                </div>
              </a>
            ))}
            <NavLink className="recurso-card" to="/nosotros">
              <div className="recurso-icon tipo-pdf"><i className="ti ti-file-type-pdf"></i></div>
              <div className="recurso-info">
                <h4>Directorio de Personal</h4>
                <p>Listado de docentes, investigadores y personal administrativo de la División.</p>
                <span className="recurso-info-link"><i className="ti ti-arrow-right"></i> Ver directorio</span>
              </div>
            </NavLink>
          </div>
        </div>
      </section>

      <PageNavBottom prev={{ to: '/', label: 'Inicio' }} next={{ to: '/mapa-sitio', label: 'Mapa del Sitio' }} />
    </>
  );
}
