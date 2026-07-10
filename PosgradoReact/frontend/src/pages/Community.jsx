import { useState } from 'react';
import { NavLink } from 'react-router-dom';
import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';

// Portado de Posgrado/php/pages/community.php. Las pestañas Alumnado /
// Profesorado usaban data-tabs + JS vanilla (js/cargar.js); aquí es
// estado de React (useState) en vez de manipular el DOM a mano.

const DESTACADOS_ALUMNADO = [
  { icono: 'ti-certificate', titulo: 'Titulación por Certificación — Guía Oficial', desc: '7 pasos para concluir tu proceso de grado: pagos, documentación requerida, tiempos de tramitación y etapas finales ante la UJED y la SEP.', to: '/titulacion' },
  { icono: 'ti-notebook', titulo: 'Titulación por Trabajo Terminal — Guía Oficial', desc: 'Requisitos, etapas y documentación necesaria para concluir tu proceso de grado mediante la modalidad de Trabajo Terminal ante la División y la UJED.', href: '#' },
];

const RECURSOS_ALUMNADO = [
  { icono: 'ti-database', titulo: 'Sistema de Información de Posgrado Universitario (SIPU)', desc: 'Consulta expedientes, trámites y documentación académica del posgrado a través del portal institucional SIPU.', href: 'https://www.sipu.ujed.mx/', externo: true, cta: 'Ir al portal' },
  { icono: 'ti-link', titulo: 'Sistema Único de Monitoreo Académico (SUMA)', desc: 'Consulta calificaciones, historial académico y trámites en línea a través del portal SUMA+ de la FECA.', href: 'https://sumafeca.ujed.mx/', externo: true, cta: 'Ir al portal' },
  { icono: 'ti-clipboard-list', titulo: 'Proceso de Tutorías', desc: 'Conoce el proceso completo de tutorías académicas y descarga el formato de registro correspondiente.', to: '/procesos-academicos', cta: 'Ver proceso completo' },
  { icono: 'ti-mail', titulo: 'Contacto con la División', desc: '¿Tienes alguna duda? Comunícate directamente con la coordinación de tu programa.', to: '/contacto', cta: 'Ir a contacto' },
  { icono: 'ti-calendar-event', titulo: 'Calendario Escolar 2026', desc: 'Periodos de inscripción, inicio y fin de clases, exámenes y fechas clave del ciclo escolar de posgrado.', href: '/assets/img/calendario.png', externo: true, cta: 'Ver calendario' },
  { icono: 'ti-file-text', titulo: 'Plan de Estudios (por programa)', desc: 'Mapa curricular con materias, créditos y semestres de cada programa.', to: '/oferta-educativa', cta: 'Ver programas' },
  { icono: 'ti-file-type-pdf', titulo: 'Guía para Pagados de Módulos de Asignatura', desc: 'Procedimiento e indicaciones para realizar el pago correspondiente a los módulos de asignatura de posgrado.', href: '#', cta: 'Descargar guía' },
  { icono: 'ti-file-type-pdf', titulo: 'Guía para Elaboración de Tesis', desc: 'Lineamientos de formato, citas y estructura para la presentación del trabajo de grado.', href: '#', cta: 'Descargar guía' },
];

const DESTACADOS_PROFESORADO = [
  { icono: 'ti-award', titulo: 'PRODEP / SNI', desc: 'Información y enlaces relacionados con el Programa de Desarrollo Profesional Docente y el Sistema Nacional de Investigadores.', href: '#' },
  { icono: 'ti-link', titulo: 'DIPI', desc: 'Dirección de Investigación y Posgrado Institucional de la UJED.', href: 'https://dipi.ujed.mx/#/' },
  { icono: 'ti-link', titulo: 'CADEP FECA', desc: 'Centro de Actualización y Desarrollo Profesional Docente de la FECA.', href: 'https://cadepfeca.ujed.mx/' },
];

const RECURSOS_PROFESORADO = [
  { icono: 'ti-books', titulo: 'Unidades de Aprendizaje por Programa Académico', desc: 'Consulta las materias de cada programa de posgrado y descarga los documentos de cada unidad de aprendizaje.', to: '/unidades-aprendizaje', cta: 'Ver programas' },
  { icono: 'ti-chalkboard', titulo: 'Proceso de Impartición de Clases', desc: 'Constancias, lista de asistencia y lineamientos para la impartición de clases en los programas de posgrado.', to: '/procesos-academicos', cta: 'Ver proceso completo' },
  { icono: 'ti-award', titulo: 'PRODEP / SNI', desc: 'Información y enlaces relacionados con el Programa de Desarrollo Profesional Docente y el SNI.', href: '#', cta: 'Más información' },
  { icono: 'ti-flask', titulo: 'Cuerpos Académicos', desc: 'Consulta los cuerpos académicos activos, sus integrantes y sus líneas de investigación.', to: '/investigacion', cta: 'Ver investigación' },
  { icono: 'ti-file-text', titulo: 'Protocolo de Dirección de Tesis', desc: 'Guía para directores y codirectores sobre procedimientos de seguimiento de trabajos de grado.', href: '#', cta: 'Descargar' },
  { icono: 'ti-file-type-pdf', titulo: 'Lineamientos de Evaluación', desc: 'Criterios y ponderaciones institucionales para la evaluación del aprendizaje en posgrado.', href: '#', cta: 'Descargar PDF' },
  { icono: 'ti-file-type-pdf', titulo: 'Protocolo de Exámenes de Grado', desc: 'Procedimiento institucional para la organización y desarrollo de los exámenes de grado de posgrado.', href: '#', cta: 'Descargar PDF' },
  { icono: 'ti-file-type-pdf', titulo: 'Reglamento de Personal Académico', desc: 'Marco normativo que regula las obligaciones, derechos y actividades del profesorado en la UJED.', href: '#', cta: 'Descargar PDF' },
];

const FAQ = [
  { q: '¿Cómo consulto mis calificaciones e historial académico?', a: <>A través del Sistema Único de Monitoreo Académico (SUMA), disponible desde el encabezado del sitio o en <a href="https://sumafeca.ujed.mx/" target="_blank" rel="noopener noreferrer">sumafeca.ujed.mx</a>.</> },
  { q: '¿Dónde descargo los formatos y guías de trámites?', a: <>En las pestañas <strong>Alumnado</strong> y <strong>Profesorado</strong> de esta sección de Comunidad encontrarás los formatos, guías y plantillas vigentes.</> },
  { q: '¿Cuáles son las modalidades de titulación disponibles?', a: <>La División ofrece titulación por <strong>Certificación</strong> y por <strong>Trabajo Terminal</strong>. Ambas guías están disponibles en la pestaña Alumnado.</> },
  { q: '¿Cómo funciona el proceso de tutorías?', a: <>Consulta el detalle en <NavLink to="/procesos-academicos">Procesos Académicos</NavLink>, donde también podrás descargar el formato correspondiente.</> },
  { q: '¿A quién contacto si tengo dudas sobre mi programa?', a: <>Puedes comunicarte directamente con la Coordinación Académica de tu programa desde la sección de <NavLink to="/contacto">Contacto</NavLink>.</> },
];

function RecursoCard({ r, destacado }) {
  const content = (
    <>
      <div className="recurso-icon" style={destacado ? { background: 'rgba(149,24,35,0.08)', color: 'var(--rojo-oscuro)' } : undefined}>
        <i className={`ti ${r.icono}`}></i>
      </div>
      <div className="recurso-info">
        <h4>{r.titulo}</h4>
        <p>{r.desc}</p>
        <span className="recurso-info-link"><i className={`ti ${r.externo ? 'ti-external-link' : 'ti-arrow-right'}`}></i> {r.cta || 'Ver más'}</span>
      </div>
    </>
  );
  const className = `recurso-card${destacado ? ' recurso-destacado' : ''}`;
  const style = destacado ? { borderLeft: '3px solid var(--rojo)', background: '#fff' } : undefined;

  if (r.to) return <NavLink className={className} style={style} to={r.to}>{content}</NavLink>;
  return <a className={className} style={style} href={r.href} target={r.externo ? '_blank' : undefined} rel={r.externo ? 'noopener noreferrer' : undefined}>{content}</a>;
}

export default function Community() {
  const [tab, setTab] = useState('alumnado');

  return (
    <>
      <PageBanner title="Comunidad">
        <p className="page-banner-desc">
          Recursos, formatos y documentos de utilidad organizados para alumnado y profesorado de la División de Estudios de Posgrado.
        </p>
      </PageBanner>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="comunidad-tab-header">
            <button className={`comunidad-tab-title${tab === 'alumnado' ? ' activo' : ''}`} onClick={() => setTab('alumnado')}>
              <i className="ti ti-school"></i> Alumnado
            </button>
            <button className={`comunidad-tab-title${tab === 'profesorado' ? ' activo' : ''}`} onClick={() => setTab('profesorado')}>
              <i className="ti ti-chalkboard"></i> Profesorado
            </button>
          </div>

          {tab === 'alumnado' && (
            <div>
              <div className="seccion-header" style={{ marginTop: 0, marginBottom: 28 }}>
                <span className="kicker">Estudiantes de Posgrado</span>
                <h2>Recursos para Alumnado</h2>
                <p>Documentos, formatos y guías de apoyo durante tu trayectoria en la División.</p>
              </div>
              {DESTACADOS_ALUMNADO.map((r) => <RecursoCard key={r.titulo} r={r} destacado />)}
              <div className="recursos-grid">
                {RECURSOS_ALUMNADO.map((r) => <RecursoCard key={r.titulo} r={r} />)}
              </div>
            </div>
          )}

          {tab === 'profesorado' && (
            <div>
              <div className="seccion-header" style={{ marginTop: 0, marginBottom: 28 }}>
                <span className="kicker">Docentes e Investigadores</span>
                <h2>Recursos para Profesorado</h2>
                <p>Formatos, lineamientos y materiales de apoyo para la actividad docente y de investigación.</p>
              </div>
              {DESTACADOS_PROFESORADO.map((r) => <RecursoCard key={r.titulo} r={r} destacado />)}
              <div className="recursos-grid">
                {RECURSOS_PROFESORADO.map((r) => <RecursoCard key={r.titulo} r={r} />)}
              </div>
            </div>
          )}
        </div>
      </section>

      <section className="seccion seccion-faq-dorada">
        <div className="inner">
          <div className="seccion-header" style={{ textAlign: 'center', marginLeft: 'auto', marginRight: 'auto' }}>
            <span className="kicker">¿Tienes dudas?</span>
            <h2>Preguntas Frecuentes</h2>
            <p style={{ marginLeft: 'auto', marginRight: 'auto' }}>
              Respuestas rápidas a las consultas más comunes de alumnado y profesorado sobre trámites y recursos de la División.
            </p>
          </div>
          <div className="faq-list">
            {FAQ.map((item) => (
              <details className="faq-item" key={item.q}>
                <summary className="faq-question">
                  <span>{item.q}</span>
                  <i className="ti ti-chevron-down"></i>
                </summary>
                <div className="faq-answer"><p>{item.a}</p></div>
              </details>
            ))}
          </div>
        </div>
      </section>

      <PageNavBottom prev={{ to: '/investigacion', label: 'Investigación' }} next={{ to: '/blog', label: 'Blog' }} />
    </>
  );
}
