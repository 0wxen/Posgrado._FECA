import { useState } from 'react';
import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';
import { PROGRAMAS } from '../data/programas.js';
import { API_V1 } from '../config/api.js';
import { TELEFONO_GENERAL, CORREO_GENERAL } from '../data/contactInfo.js';

const infoBtnStyle = {
  display: 'flex', alignItems: 'center', gap: 14, textDecoration: 'none', color: 'inherit',
  padding: '12px 14px', borderRadius: 6, background: '#fafafa', border: '1px solid #f0f0f0',
};
const infoIconStyle = (bg) => ({
  width: 38, height: 38, borderRadius: '50%', background: bg, display: 'flex',
  alignItems: 'center', justifyContent: 'center', flexShrink: 0,
});

const ASUNTOS = [
  ['informacion', 'Información sobre programas'],
  ['convocatoria', 'Convocatorias y admisión'],
  ['titulacion', 'Proceso de titulación'],
  ['investigacion', 'Investigación y publicaciones'],
  ['comunidad', 'Recursos para alumnado o profesorado'],
  ['otro', 'Otro'],
];

// Portado de Posgrado/php/pages/contact.php. A diferencia de las páginas
// de solo lectura, el formulario sí es funcional: hace POST JSON contra
// el endpoint que YA existe en el backend, POST /php/api/v1/?r=contacto
// (ver PosgradoReact/backend/php/api/v1/index.php, función r_contacto).
// Nota: ese endpoint espera { nombre, email, asunto, mensaje, programa_interes },
// por eso "programa" se remapea a "programa_interes" al enviar.
export default function Contact() {
  const [form, setForm] = useState({ nombre: '', email: '', asunto: '', programa: '', mensaje: '' });
  const [estado, setEstado] = useState('inactivo'); // inactivo | enviando | ok | error

  const onChange = (e) => setForm((f) => ({ ...f, [e.target.name]: e.target.value }));

  const onSubmit = async (e) => {
    e.preventDefault();
    setEstado('enviando');
    try {
      const { programa, ...resto } = form;
      const res = await fetch(`${API_V1}?r=contacto`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ...resto, programa_interes: programa || null }),
      });
      setEstado(res.ok ? 'ok' : 'error');
    } catch {
      setEstado('error');
    }
  };

  return (
    <>
      <PageBanner title="Contacto">
        <p className="page-banner-desc">
          Comunícate con nosotros para solicitar información sobre programas, convocatorias o el proceso de admisión.
        </p>
      </PageBanner>

      <section className="seccion seccion-gris">
        <div className="inner">
          <div className="contacto-grid">
            <div style={{ display: 'flex', flexDirection: 'column', gap: 20 }}>
              <div style={{ background: '#fff', borderRadius: 8, overflow: 'hidden', boxShadow: '0 2px 12px rgba(0,0,0,0.07)' }}>
                <div style={{ background: 'var(--rojo)', padding: '16px 22px', display: 'flex', alignItems: 'center', gap: 10 }}>
                  <i className="ti ti-headset" style={{ fontSize: 20, color: '#fff', opacity: 0.9 }}></i>
                  <span style={{ fontSize: 13, fontWeight: 700, letterSpacing: '.07em', textTransform: 'uppercase', color: '#fff' }}>Coordinación General</span>
                </div>
                <div style={{ padding: '20px 22px', display: 'flex', flexDirection: 'column', gap: 14 }}>
                  <a href={`tel:${TELEFONO_GENERAL.tel}`} style={infoBtnStyle}>
                    <span style={infoIconStyle('rgba(227,19,19,0.1)')}><i className="ti ti-phone" style={{ fontSize: 17, color: 'var(--rojo)' }}></i></span>
                    <div>
                      <div style={{ fontSize: 11, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '.06em', color: '#999', marginBottom: 2 }}>Teléfono</div>
                      <div style={{ fontSize: 16, fontWeight: 700, color: '#222' }}>{TELEFONO_GENERAL.texto}</div>
                    </div>
                  </a>
                  <a href={`mailto:${CORREO_GENERAL}`} style={infoBtnStyle}>
                    <span style={infoIconStyle('rgba(227,19,19,0.1)')}><i className="ti ti-mail" style={{ fontSize: 17, color: 'var(--rojo)' }}></i></span>
                    <div>
                      <div style={{ fontSize: 11, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '.06em', color: '#999', marginBottom: 2 }}>Correo electrónico</div>
                      <div style={{ fontSize: 15, fontWeight: 600, color: '#222' }}>{CORREO_GENERAL}</div>
                    </div>
                  </a>
                </div>
              </div>

              <div style={{ background: '#fff', borderRadius: 8, overflow: 'hidden', boxShadow: '0 2px 12px rgba(0,0,0,0.07)' }}>
                <div style={{ background: 'var(--dorado)', padding: '16px 22px', display: 'flex', alignItems: 'center', gap: 10 }}>
                  <i className="ti ti-map-pin" style={{ fontSize: 20, color: '#fff', opacity: 0.9 }}></i>
                  <span style={{ fontSize: 13, fontWeight: 700, letterSpacing: '.07em', textTransform: 'uppercase', color: '#fff' }}>Dónde encontrarnos</span>
                </div>
                <div style={{ padding: '20px 22px', display: 'flex', flexDirection: 'column', gap: 14 }}>
                  <div style={{ display: 'flex', alignItems: 'flex-start', gap: 14 }}>
                    <span style={{ ...infoIconStyle('rgba(168,127,61,0.1)'), marginTop: 2 }}><i className="ti ti-building-community" style={{ fontSize: 17, color: 'var(--dorado)' }}></i></span>
                    <div>
                      <div style={{ fontSize: 11, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '.06em', color: '#999', marginBottom: 4 }}>Dirección</div>
                      <div style={{ fontSize: 14, color: '#333', lineHeight: 1.6 }}>Fanny Anitua s/n<br />Col. Los Ángeles · C.P. 34000<br /><span style={{ color: '#888', fontSize: 13 }}>Durango, Dgo.</span></div>
                    </div>
                  </div>
                  <div style={{ height: 1, background: '#f0f0f0' }}></div>
                  <div style={{ display: 'flex', alignItems: 'flex-start', gap: 14 }}>
                    <span style={{ ...infoIconStyle('rgba(168,127,61,0.1)'), marginTop: 2 }}><i className="ti ti-clock" style={{ fontSize: 17, color: 'var(--dorado)' }}></i></span>
                    <div>
                      <div style={{ fontSize: 11, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '.06em', color: '#999', marginBottom: 4 }}>Horario de atención</div>
                      <div style={{ fontSize: 14, color: '#333', lineHeight: 1.6 }}>Lunes a Viernes<br /><strong>8:00 a.m. — 8:00 p.m.</strong><br />Sábados<br /><strong>9:00 a.m. — 2:00 p.m.</strong></div>
                    </div>
                  </div>
                </div>
              </div>

              <div style={{ background: '#fff', borderRadius: 8, overflow: 'hidden', boxShadow: '0 2px 12px rgba(0,0,0,0.07)' }}>
                <div style={{ padding: '18px 22px' }}>
                  <div style={{ fontSize: 12, fontWeight: 700, textTransform: 'uppercase', letterSpacing: '.07em', color: '#aaa', marginBottom: 12 }}>Síguenos en redes</div>
                  <div style={{ display: 'flex', gap: 10, flexWrap: 'wrap' }}>
                    {[
                      ['https://www.facebook.com/FECAUJEDMX', 'ti-brand-facebook', 'Facebook'],
                      ['https://x.com/fecaujedmx', 'ti-brand-x', 'X'],
                      ['https://www.instagram.com/fecaujedmx', 'ti-brand-instagram', 'Instagram'],
                      ['https://www.tiktok.com/@fecaujed.mx', 'ti-brand-tiktok', 'TikTok'],
                    ].map(([href, icono, label]) => (
                      <a
                        key={label}
                        href={href}
                        target="_blank"
                        rel="noopener noreferrer"
                        title={label}
                        style={{
                          display: 'flex', alignItems: 'center', gap: 8, padding: '9px 16px', borderRadius: 6,
                          background: '#f5f5f5', textDecoration: 'none', color: '#333', fontSize: 13, fontWeight: 600,
                        }}
                      >
                        <i className={`ti ${icono}`} style={{ fontSize: 18 }}></i> {label}
                      </a>
                    ))}
                  </div>
                </div>
              </div>
            </div>

            <div className="contacto-form-card">
              <h3>Envíanos un mensaje</h3>
              <form onSubmit={onSubmit} noValidate>
                <div className="form-row">
                  <div className="form-group">
                    <label className="form-label" htmlFor="c-nombre">Nombre *</label>
                    <input type="text" id="c-nombre" name="nombre" className="form-control"
                      placeholder="Tu nombre completo" required value={form.nombre} onChange={onChange} />
                  </div>
                  <div className="form-group">
                    <label className="form-label" htmlFor="c-email">Correo electrónico *</label>
                    <input type="email" id="c-email" name="email" className="form-control"
                      placeholder="tu@correo.com" required value={form.email} onChange={onChange} />
                  </div>
                </div>

                <div className="form-group">
                  <label className="form-label" htmlFor="c-asunto">Asunto *</label>
                  <select id="c-asunto" name="asunto" className="form-control" required value={form.asunto} onChange={onChange}>
                    <option value="" disabled>Selecciona un tema…</option>
                    {ASUNTOS.map(([valor, etiqueta]) => (
                      <option key={valor} value={valor}>{etiqueta}</option>
                    ))}
                  </select>
                </div>

                <div className="form-group">
                  <label className="form-label" htmlFor="c-programa">Programa de interés</label>
                  <select id="c-programa" name="programa" className="form-control" value={form.programa} onChange={onChange}>
                    <option value="">— Opcional —</option>
                    {PROGRAMAS.map((p) => (
                      <option key={p.slug} value={p.codigo}>{p.codigo}</option>
                    ))}
                  </select>
                </div>

                <div className="form-group">
                  <label className="form-label" htmlFor="c-mensaje">Mensaje *</label>
                  <textarea id="c-mensaje" name="mensaje" className="form-control" rows={5}
                    placeholder="Escribe aquí tu consulta o comentario…" required value={form.mensaje} onChange={onChange} />
                </div>

                <button type="submit" className="btn-submit" disabled={estado === 'enviando'}>
                  <i className="ti ti-send"></i> {estado === 'enviando' ? 'Enviando…' : 'Enviar mensaje'}
                </button>

                {estado === 'ok' && <p className="form-nota">Mensaje enviado. Te responderemos pronto.</p>}
                {estado === 'error' && <p className="form-nota">No se pudo enviar. Intenta de nuevo más tarde.</p>}

                <p className="form-nota">* Campos obligatorios. Responderemos en un plazo máximo de 2 días hábiles.</p>
              </form>
            </div>
          </div>
        </div>
      </section>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Cómo llegar</span>
            <h2>Nuestra Ubicación</h2>
            <p>División de Estudios de Posgrado · FECA · UJED · Campus Universitario, Durango</p>
          </div>
          <div style={{ width: '100%', aspectRatio: '16/6', borderRadius: 4, overflow: 'hidden' }}>
            <iframe
              src="https://maps.google.com/maps?q=Fanny+Anitua+s%2Fn+Los+Angeles+Durango+Mexico&output=embed&hl=es&z=16"
              width="100%"
              height="100%"
              style={{ border: 0, display: 'block' }}
              allowFullScreen
              loading="lazy"
              referrerPolicy="no-referrer-when-downgrade"
              title="Ubicación FECA UJED · Fanny Anitua, Los Ángeles, Durango"
            />
          </div>
          <div style={{ marginTop: 20, display: 'flex', gap: 14, flexWrap: 'wrap' }}>
            <a href="https://maps.google.com/?q=Fanny+Anitua+s%2Fn+Los+Angeles+Durango+Mexico" target="_blank" rel="noopener noreferrer" className="btn-sm-rojo">
              <i className="ti ti-map-pin"></i> Abrir en Google Maps
            </a>
            <a href="https://www.ujed.mx" target="_blank" rel="noopener noreferrer" className="btn-sm-outline">
              <i className="ti ti-external-link"></i> Portal UJED
            </a>
          </div>
        </div>
      </section>

      <PageNavBottom prev={{ to: '/blog', label: 'Blog' }} next={{ to: '/', label: 'Inicio' }} />
    </>
  );
}
