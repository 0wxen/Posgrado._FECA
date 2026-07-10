import { useState } from 'react';
import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';
import { PROGRAMAS, NIVEL_LABEL } from '../data/programas.js';
import { PROGRAM_CONTENT } from '../data/programContent.js';

const UNIDADES = Array.from({ length: 20 }, (_, i) => String(i + 1).padStart(2, '0'));

// Portado de Posgrado/pages/unidades_aprendizaje.html: 8 pestañas (una
// por programa), cada una con la misma nota y el mismo listado de 20
// unidades de referencia que ya traía el HTML original (aún sin
// documentos reales cargados).
export default function UnidadesAprendizaje() {
  const [activo, setActivo] = useState(PROGRAMAS[0].slug);
  const programa = PROGRAMAS.find((p) => p.slug === activo);

  return (
    <>
      <PageBanner title="Unidades de Aprendizaje por Programa Académico">
        <p className="page-banner-desc">
          Consulta las materias de cada programa de posgrado y descarga los documentos correspondientes a cada unidad de aprendizaje.
        </p>
      </PageBanner>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="comunidad-tab-header" style={{ flexWrap: 'wrap' }}>
            {PROGRAMAS.map((p) => (
              <button
                key={p.slug}
                className={`comunidad-tab-title${activo === p.slug ? ' activo' : ''}`}
                onClick={() => setActivo(p.slug)}
              >
                {p.codigo}
              </button>
            ))}
          </div>

          <div className="seccion-header" style={{ marginTop: 0, marginBottom: 20 }}>
            <span className="kicker">{NIVEL_LABEL[programa.nivel]}</span>
            <h2>{PROGRAM_CONTENT[programa.slug].nombreCompleto}</h2>
          </div>
          <p className="ua-tab-note">Contenido de referencia; se actualizará con el listado real de unidades de aprendizaje y documentos.</p>
          <div className="ua-grid">
            {UNIDADES.map((n) => (
              <a className="ua-item" href="#" key={n}>
                <i className="ti ti-file-type-pdf"></i> Unidad de Aprendizaje {n} <i className="ti ti-download"></i>
              </a>
            ))}
          </div>
        </div>
      </section>

      <PageNavBottom prev={{ to: '/comunidad', label: 'Comunidad' }} next={{ to: '/oferta-educativa', label: 'Oferta Educativa' }} />
    </>
  );
}
