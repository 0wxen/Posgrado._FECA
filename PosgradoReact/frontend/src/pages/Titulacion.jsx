import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';

// Portado de Posgrado/pages/titulacion.html ("Titulación por Certificación").
const COSTOS = [
  { monto: '$4,000', nombre: 'Derecho a Examen (General)', nota: 'Todos los programas de Posgrado' },
  { monto: '$3,000', nombre: 'Derecho a Examen (EAH)', nota: 'Especialidad en Administración de Hospitales' },
  { monto: '$300', nombre: 'Constancia Biblioteca', nota: 'No adeudo a la Biblioteca FECA' },
  { monto: '$400', nombre: 'Estola y Pin', nota: 'Accesorios oficiales para la Ceremonia Protocolaria' },
];

const DOCUMENTOS = [
  'Constancia de no adeudo a la Biblioteca FECA',
  'Solicitud de Autorización de Presentación de Examen de Grado, emitida por la Jefatura de la División de Estudios de Posgrado',
  'Solicitud de Autorización de Presentación de Examen de Grado, firmada por el Sustentante',
  '2 juegos de Kardex',
  '2 Oficios de firmas de los miembros del Sínodo',
];

const ETAPAS_FINALES = [
  { num: 5, icono: 'ti-clipboard-check', titulo: 'Acto Protocolario', desc: 'Toma de protesta del sustentante y generación del Acta de Presentación de Examen de Grado ante el Sínodo.' },
  { num: 6, icono: 'ti-school', titulo: 'Trámite del Título', desc: 'El Acta de Presentación de Examen de Grado es el insumo para gestionar y obtener el título profesional de posgrado ante el Edificio Central de la UJED.' },
  { num: 7, icono: 'ti-certificate', titulo: 'Cédula Profesional', desc: 'Generación de la Cédula Profesional ante la Dirección General de Profesiones de la Secretaría de Educación Pública (SEP).' },
];

export default function Titulacion() {
  return (
    <>
      <PageBanner title="Titulación por Certificación">
        <p className="page-banner-desc">Guía oficial de trámites · 7 pasos para concluir tu proceso de grado</p>
      </PageBanner>

      <section className="seccion seccion-oscura">
        <div className="inner">
          <div style={{ maxWidth: 760, margin: '0 auto', textAlign: 'center' }}>
            <span className="kicker" style={{ color: 'var(--dorado-claro)' }}>Proceso de graduación</span>
            <h2 style={{ color: '#fff', margin: '10px 0 16px' }}>¿Qué es la Titulación por Certificación?</h2>
            <p style={{ color: 'rgba(255,255,255,0.78)', lineHeight: 1.75, marginBottom: 26 }}>
              Los estudiantes que concluyan satisfactoriamente el plan de estudios podrán obtener el grado de maestría
              mediante la <strong style={{ color: '#fff' }}>certificación de competencias profesionales</strong> ante el
              Consejo Nacional de Normalización y Certificación de Competencias Laborales (CONOCER), a través del Centro de
              Innovación, Investigación, Emprendimiento y Desarrollo Organizacional (CIIEDO) de la FECA, conforme a
              estándares de competencia alineados al perfil del programa.
            </p>
            <div style={{ display: 'flex', gap: 12, justifyContent: 'center', flexWrap: 'wrap' }}>
              <a href="/assets/docs/Titulacion-Certificacion.pdf" target="_blank" rel="noopener noreferrer" className="btn-sm-rojo">
                <i className="ti ti-download"></i> Descargar guía en PDF
              </a>
              <a href="/contacto" className="btn-sm-outline" style={{ borderColor: 'rgba(255,255,255,0.3)', color: 'rgba(255,255,255,0.75)' }}>
                <i className="ti ti-mail"></i> Contactar a la División
              </a>
            </div>
          </div>
        </div>
      </section>

      <section className="seccion seccion-blanca" style={{ paddingTop: 28, paddingBottom: 28 }}>
        <div className="inner">
          <div style={{ background: '#fff8e1', border: '1px solid #ffe082', borderLeft: '4px solid #e67e00', borderRadius: 6, padding: '16px 20px', display: 'flex', gap: 14, maxWidth: 820, margin: '0 auto' }}>
            <i className="ti ti-clock" style={{ color: '#e67e00', fontSize: 26, flexShrink: 0, marginTop: 2 }}></i>
            <div>
              <strong style={{ display: 'block', marginBottom: 5, color: '#5d4037' }}>Duración total del proceso: aproximadamente 2 meses</strong>
              <p style={{ color: '#6d4c0e', margin: 0, fontSize: 13, lineHeight: 1.65 }}>
                El proceso de titulación por certificación implica una revisión meticulosa y detallada del expediente de
                cada sustentante: verificación de adeudos académicos, adeudos de pago de asignaturas y pendientes
                administrativos. Se trata de documentación de carácter oficial y de alto valor legal, por lo que cada
                expediente es atendido con el rigor y responsabilidad que amerita.
              </p>
            </div>
          </div>
        </div>
      </section>

      <section className="seccion seccion-gris">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Procedimiento</span>
            <h2>Pasos del Proceso</h2>
            <p>Sigue estos pasos en orden para completar tu trámite de titulación correctamente.</p>
          </div>

          <div style={{ display: 'flex', flexDirection: 'column', gap: 30 }}>
            <div style={{ display: 'grid', gridTemplateColumns: '58px 1fr', gap: 20, alignItems: 'flex-start' }}>
              <div style={{ width: 58, height: 58, background: 'var(--rojo-oscuro)', color: '#fff', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', fontFamily: "'Barlow Condensed',sans-serif", fontSize: 28, fontWeight: 700, flexShrink: 0 }}>1</div>
              <div style={{ paddingTop: 6 }}>
                <h3 style={{ fontFamily: "'Barlow Condensed',sans-serif", fontSize: 23, color: 'var(--rojo-oscuro)', margin: '0 0 8px' }}>Pagos en Caja de la FECA</h3>
                <p style={{ color: '#555', fontSize: 14, margin: '0 0 16px', lineHeight: 1.55 }}>Realiza los siguientes pagos directamente en la caja de la Facultad:</p>
                <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(170px, 1fr))', gap: 14 }}>
                  {COSTOS.map((c) => (
                    <div key={c.nombre} style={{ background: '#fff', border: '1px solid #e8e6e1', borderTop: '3px solid var(--rojo)', borderRadius: 8, padding: 16 }}>
                      <div style={{ fontFamily: "'Barlow Condensed',sans-serif", fontSize: 30, fontWeight: 700, color: 'var(--rojo-oscuro)', lineHeight: 1, marginBottom: 6 }}>
                        {c.monto} <span style={{ fontSize: 13, fontWeight: 500, color: '#888' }}>MXN</span>
                      </div>
                      <div style={{ fontWeight: 600, fontSize: 13, color: '#333', marginBottom: 4 }}>{c.nombre}</div>
                      <div style={{ fontSize: 12, color: '#888', lineHeight: 1.4 }}>{c.nota}</div>
                    </div>
                  ))}
                </div>
              </div>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '58px 1fr', gap: 20, alignItems: 'flex-start' }}>
              <div style={{ width: 58, height: 58, background: 'var(--rojo-oscuro)', color: '#fff', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', fontFamily: "'Barlow Condensed',sans-serif", fontSize: 28, fontWeight: 700, flexShrink: 0 }}>2</div>
              <div style={{ paddingTop: 6 }}>
                <h3 style={{ fontFamily: "'Barlow Condensed',sans-serif", fontSize: 23, color: 'var(--rojo-oscuro)', margin: '0 0 8px' }}>Renta de Toga y Birrete</h3>
                <p style={{ fontWeight: 600, margin: '0 0 10px', color: 'var(--rojo-oscuro)', fontSize: 14 }}>Costo aproximado de renta: ~$200 MXN</p>
                <ul style={{ margin: 0, paddingLeft: 18, lineHeight: 1.9, color: '#555', fontSize: 14 }}>
                  <li>Toga y birrete <strong>NEGROS</strong>, borla <strong>ROJA</strong>.</li>
                  <li>Se recomienda rentar <strong>próximo a la fecha</strong> de la Ceremonia Protocolaria.</li>
                  <li>La toga y el birrete se recogen <strong>un día antes</strong> de la ceremonia.</li>
                  <li>Garantía requerida al recoger: INE o ~$500 en efectivo (se devuelve al día siguiente al entregar la indumentaria).</li>
                </ul>
              </div>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '58px 1fr', gap: 20, alignItems: 'flex-start' }}>
              <div style={{ width: 58, height: 58, background: 'var(--rojo-oscuro)', color: '#fff', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', fontFamily: "'Barlow Condensed',sans-serif", fontSize: 28, fontWeight: 700, flexShrink: 0 }}>3</div>
              <div style={{ paddingTop: 6 }}>
                <h3 style={{ fontFamily: "'Barlow Condensed',sans-serif", fontSize: 23, color: 'var(--rojo-oscuro)', margin: '0 0 8px' }}>Recoger Documentación en la DEP</h3>
                <p style={{ color: '#555', fontSize: 14, margin: '0 0 16px', lineHeight: 1.55 }}>El sustentante recoge en la DEP la siguiente documentación, misma que será entregada a la Dirección de Servicios Escolares de la UJED:</p>
                <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: 10 }}>
                  {DOCUMENTOS.map((d) => (
                    <li key={d} style={{ display: 'flex', alignItems: 'flex-start', gap: 10, fontSize: 14, color: '#444', lineHeight: 1.55 }}>
                      <i className="ti ti-circle-check" style={{ color: 'var(--rojo)', fontSize: 18, flexShrink: 0, marginTop: 2 }}></i>
                      {d}
                    </li>
                  ))}
                </ul>
              </div>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '58px 1fr', gap: 20, alignItems: 'flex-start' }}>
              <div style={{ width: 58, height: 58, background: 'var(--rojo-oscuro)', color: '#fff', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', fontFamily: "'Barlow Condensed',sans-serif", fontSize: 28, fontWeight: 700, flexShrink: 0 }}>4</div>
              <div style={{ paddingTop: 6 }}>
                <h3 style={{ fontFamily: "'Barlow Condensed',sans-serif", fontSize: 23, color: 'var(--rojo-oscuro)', margin: '0 0 8px' }}>Tramitación ante Servicios Escolares UJED</h3>
                <p style={{ color: '#555', fontSize: 14, lineHeight: 1.6 }}>
                  Una vez generada, la División notificará al sustentante para que la recoja y la gire a la Dirección de
                  Servicios Escolares de la UJED. Ahí se emite el <strong>Oficio de Autorización de Examen de Grado
                  (3–4 días hábiles)</strong>, que debe entregarse a la Coordinación Académica de la DEP para poder
                  participar en la Ceremonia Protocolaria de Presentación de Examen de Grado.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className="seccion seccion-oscura">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker" style={{ color: 'var(--dorado-claro)' }}>Cierre del proceso</span>
            <h2 style={{ color: '#fff' }}>Etapas Finales</h2>
          </div>
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(220px, 1fr))', gap: 20 }}>
            {ETAPAS_FINALES.map((e) => (
              <div key={e.num} style={{ background: 'rgba(255,255,255,0.07)', border: '1px solid rgba(255,255,255,0.14)', borderRadius: 8, padding: '28px 22px', textAlign: 'center' }}>
                <div style={{ width: 46, height: 46, background: 'var(--rojo)', color: '#fff', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', fontFamily: "'Barlow Condensed',sans-serif", fontSize: 22, fontWeight: 700, margin: '0 auto 14px' }}>{e.num}</div>
                <i className={`ti ${e.icono}`} style={{ fontSize: 38, color: 'var(--dorado-claro)', display: 'block', marginBottom: 12 }}></i>
                <h4 style={{ color: '#fff', margin: '0 0 10px', fontFamily: "'Barlow Condensed',sans-serif", fontSize: 18, textTransform: 'uppercase' }}>{e.titulo}</h4>
                <p style={{ color: 'rgba(255,255,255,0.72)', fontSize: 13, lineHeight: 1.65, margin: 0 }}>{e.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="seccion seccion-blanca">
        <div className="inner" style={{ maxWidth: 700, margin: '0 auto', textAlign: 'center' }}>
          <span className="kicker">¿Tienes dudas?</span>
          <h2 style={{ margin: '10px 0 12px' }}>Contacta a la Coordinación Académica</h2>
          <p style={{ color: '#555', marginBottom: 24, lineHeight: 1.65 }}>
            Para iniciar tu proceso de titulación o resolver dudas sobre el trámite, comunícate directamente con la
            Coordinación Académica de la División de Estudios de Posgrado FECA UJED.
          </p>
          <div style={{ display: 'flex', gap: 12, justifyContent: 'center', flexWrap: 'wrap' }}>
            <a href="mailto:academicaposgrado.feca@ujed.mx" className="btn-sm-rojo">
              <i className="ti ti-mail"></i> academicaposgrado.feca@ujed.mx
            </a>
            <a href="/contacto" className="btn-sm-outline">
              <i className="ti ti-address-book"></i> Ver todos los contactos
            </a>
          </div>
        </div>
      </section>

      <PageNavBottom prev={{ to: '/comunidad', label: 'Comunidad' }} next={{ to: '/contacto', label: 'Contacto' }} />
    </>
  );
}
