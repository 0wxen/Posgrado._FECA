import { useEffect } from 'react';
import { REGISTRO_URL } from '../data/announcementsContent.js';

const REQS_MODAL = [
  'Título de licenciatura con cédula profesional',
  'Acta de nacimiento (copia certificada)',
  'CURP y dos fotografías tamaño título',
  'Carta de exposición de motivos',
  'Carta de recomendación académica o laboral',
];

// Portado del modal global `openConvModal()` de Posgrado/html/htmlcode.html
// (ids conv-detail-*): antes manipulaba el DOM a mano, aquí es un
// componente controlado que se muestra cuando `conv` no es null.
export default function ConvocatoriaModal({ conv, onClose }) {
  useEffect(() => {
    if (!conv) return;
    document.body.style.overflow = 'hidden';
    const onKey = (e) => { if (e.key === 'Escape') onClose(); };
    document.addEventListener('keydown', onKey);
    return () => {
      document.body.style.overflow = '';
      document.removeEventListener('keydown', onKey);
    };
  }, [conv, onClose]);

  if (!conv) return null;

  return (
    <div className="conv-detail-modal abierto" role="dialog" aria-modal="true">
      <div className="conv-detail-overlay" onClick={onClose}></div>
      <div className="conv-detail-box">
        <button className="conv-detail-close" aria-label="Cerrar" onClick={onClose}>
          <i className="ti ti-x"></i>
        </button>
        <div className="conv-detail-grid">
          <div className="conv-detail-img-col">
            <div style={{ width: '100%', aspectRatio: '4/3', background: '#f5f5f5', borderRadius: 6, display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#ccc' }}>
              <i className="ti ti-file-certificate" style={{ fontSize: 56 }}></i>
            </div>
            <a href={conv.doc} download className="btn-sm-rojo" style={{ width: '100%', justifyContent: 'center' }}>
              <i className="ti ti-photo-down"></i> Descargar imagen
            </a>
          </div>
          <div className="conv-detail-info-col">
            <span className="conv-badge">{conv.cicloLabel.split(' · ')[0]}</span>
            <h2 className="conv-detail-title">{conv.titulo}</h2>
            <div className="conv-detail-meta">
              <div className="conv-detail-meta-item"><i className="ti ti-calendar"></i><span>{conv.cicloLabel}</span></div>
              <div className="conv-detail-meta-item"><i className="ti ti-clock-hour-4"></i><span>{conv.limite}</span></div>
              <div className="conv-detail-meta-item"><i className="ti ti-map-pin"></i><span>Modalidad presencial · Durango, Dgo.</span></div>
            </div>
            <p className="conv-detail-desc">{conv.descLarga}</p>
            <div className="conv-detail-reqs">
              <h4>Requisitos principales</h4>
              <ul>
                {REQS_MODAL.map((r) => <li key={r}>{r}</li>)}
              </ul>
            </div>
            <div className="conv-detail-register">
              <div className="conv-detail-register-label">
                <i className="ti ti-alert-circle"></i>
                Regístrate en línea para iniciar tu proceso de admisión
              </div>
              <a href={REGISTRO_URL} target="_blank" rel="noopener noreferrer" className="btn-primary conv-detail-register-btn">
                <i className="ti ti-external-link"></i> Registrarse a la Convocatoria
              </a>
            </div>
            <div className="conv-detail-actions">
              <a href={conv.doc} target="_blank" rel="noopener noreferrer" className="btn-outline-dark">
                <i className="ti ti-file-type-pdf"></i> Descargar Documento
              </a>
              <button className="btn-outline-dark" onClick={onClose}>
                <i className="ti ti-arrow-right"></i> Ver todas
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
