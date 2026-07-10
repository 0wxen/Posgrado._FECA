import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';

// Portado de Posgrado/php/pages/privacy_notice.php.
export default function PrivacyNotice() {
  return (
    <>
      <PageBanner title="Aviso de Privacidad">
        <p className="page-banner-desc">
          Información sobre el tratamiento de sus datos personales conforme a la Ley Federal de Protección de Datos Personales en Posesión de los Particulares.
        </p>
      </PageBanner>

      <section className="seccion seccion-blanca">
        <div className="inner" style={{ maxWidth: 820 }}>
          <div className="legal-block">
            <h2>Identidad y Domicilio del Responsable</h2>
            <p>
              La <strong>División de Estudios de Posgrado de la Facultad de Economía, Contaduría y Administración</strong> de
              la Universidad Juárez del Estado de Durango (UJED), con domicilio en Fanny Anitua s/n, Col. Los Ángeles, C.P.
              34000, Durango, Dgo., México, es responsable del tratamiento de sus datos personales.
            </p>
          </div>

          <div className="legal-block">
            <h2>Datos Personales que se Recaban</h2>
            <p>Para llevar a cabo las finalidades descritas en el presente aviso de privacidad, podremos recabar los siguientes datos:</p>
            <ul>
              <li>Nombre completo</li>
              <li>Correo electrónico institucional o personal</li>
              <li>Número telefónico</li>
              <li>Programa académico de interés o en curso</li>
              <li>Datos de navegación (cookies de sesión y registros de acceso)</li>
            </ul>
          </div>

          <div className="legal-block">
            <h2>Finalidades del Tratamiento</h2>
            <p>Sus datos personales serán utilizados para las siguientes finalidades:</p>
            <ul>
              <li>Atender solicitudes de información sobre programas académicos de posgrado</li>
              <li>Envío de información sobre convocatorias, eventos y actividades académicas</li>
              <li>Gestión administrativa de trámites escolares y procesos de admisión</li>
              <li>Mejora continua de los servicios del portal institucional</li>
              <li>Cumplimiento de obligaciones legales y normativas de la UJED</li>
            </ul>
          </div>

          <div className="legal-block">
            <h2>Transferencia de Datos Personales</h2>
            <p>
              La División de Estudios de Posgrado FECA UJED no realizará transferencias de datos personales a terceros ajenos
              a la institución, salvo las necesarias para el cumplimiento de obligaciones contraídas con usted, o cuando medie
              requerimiento legal o autorización expresa de su parte.
            </p>
          </div>

          <div className="legal-block">
            <h2>Derechos ARCO</h2>
            <p>
              Usted tiene derecho a <strong>Acceder, Rectificar, Cancelar u Oponerse</strong> al tratamiento de sus datos
              personales (Derechos ARCO). Para ejercerlos, puede enviar una solicitud a:
            </p>
            <p>
              <strong>Correo:</strong> <a href="mailto:posgradofeca@ujed.mx">posgradofeca@ujed.mx</a><br />
              <strong>Teléfono:</strong> (618) 827 12 00 ext. 5430<br />
              <strong>Horario:</strong> Lunes a Viernes, 8:00 a.m. – 8:00 p.m. · Sábados, 9:00 a.m. – 2:00 p.m.
            </p>
            <p>La solicitud deberá incluir su nombre completo, una descripción clara del derecho que desea ejercer y los datos de contacto para notificarle la respuesta.</p>
          </div>

          <div className="legal-block">
            <h2>Uso de Cookies</h2>
            <p>
              Este sitio puede utilizar cookies de sesión con fines técnicos y para mejorar la experiencia de navegación. Las
              cookies no contienen datos personales identificables y pueden ser deshabilitadas desde la configuración de su
              navegador.
            </p>
          </div>

          <div className="legal-block">
            <h2>Cambios al Aviso de Privacidad</h2>
            <p>Nos reservamos el derecho de modificar este aviso de privacidad en cualquier momento. Los cambios serán publicados en este mismo portal.</p>
            <p style={{ color: '#888', fontSize: 13 }}>Última actualización: Junio 2025</p>
          </div>
        </div>
      </section>

      <PageNavBottom prev={{ to: '/', label: 'Inicio' }} next={{ to: '/terminos', label: 'Términos de Uso' }} />
    </>
  );
}
