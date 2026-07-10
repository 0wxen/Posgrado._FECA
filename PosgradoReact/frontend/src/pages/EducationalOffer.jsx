import { useState } from 'react';
import { NavLink } from 'react-router-dom';
import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';
import { PROGRAMAS, NIVEL_LABEL } from '../data/programas.js';
import { PROGRAM_CONTENT } from '../data/programContent.js';

// Portado de Posgrado/pages/educational_offer.html (más actualizado que
// su espejo php/pages/educational_offer.php: agrega las pestañas de
// filtrado por nivel/modalidad híbrida y descripciones de programa
// revisadas). El filtrado por pestañas, antes JS vanilla sobre
// data-nivel, aquí es estado de React.
const FILTROS = [
  { valor: 'todos', icono: 'ti-layout-grid', label: 'Todos' },
  { valor: 'maestria', icono: 'ti-school', label: 'Maestrías' },
  { valor: 'doctorado', icono: 'ti-award', label: 'Doctorado' },
  { valor: 'especialidad', icono: 'ti-stethoscope', label: 'Especialidad' },
  { valor: 'hibrida', icono: 'ti-device-laptop', label: 'Estudia de Forma Híbrida' },
];

const HIBRIDA_ITEMS = [
  { icono: 'ti-building-community', titulo: 'Sesiones Presenciales' },
  { icono: 'ti-device-laptop', titulo: 'Sesiones Virtuales' },
  { icono: 'ti-calendar-event', titulo: 'Calendario y Horarios' },
  { icono: 'ti-wifi', titulo: 'Plataforma Digital' },
];

export default function EducationalOffer() {
  const [filtro, setFiltro] = useState('todos');
  const visibles = filtro === 'todos' || filtro === 'hibrida' ? PROGRAMAS : PROGRAMAS.filter((p) => p.nivel === filtro);

  return (
    <>
      <PageBanner title="Oferta Educativa">
        <p className="page-banner-desc">
          Conoce nuestros programas de posgrado y encuentra la opción que mejor se alinee con tus metas académicas y profesionales.
        </p>
      </PageBanner>

      <section className="seccion seccion-gris">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">{PROGRAMAS.length} programas disponibles</span>
            <h2>Programas de Posgrado</h2>
            <p>Todos nuestros programas cuentan con planta docente de alto nivel y están orientados al impacto regional y nacional.</p>
          </div>

          <div className="comunidad-tab-header" style={{ marginBottom: 32 }}>
            {FILTROS.map((f) => (
              <button
                key={f.valor}
                className={`comunidad-tab-title${filtro === f.valor ? ' activo' : ''}`}
                onClick={() => setFiltro(f.valor)}
              >
                <i className={`ti ${f.icono}`}></i> {f.label}
              </button>
            ))}
          </div>

          {filtro !== 'hibrida' ? (
            <>
              <div className="programs-grid">
                {visibles.map((p) => (
                  <div className="program-card" key={p.slug}>
                    <div className="program-card-hdr">
                      <span className={`program-level${p.nivel === 'doctorado' ? ' level-doc' : p.nivel === 'especialidad' ? ' level-esp' : ''}`}>
                        {NIVEL_LABEL[p.nivel]}
                      </span>
                      {p.snp && <span className="program-pnpc"><i className="ti ti-star"></i> SNP · CONAHCYT</span>}
                      {PROGRAM_CONTENT[p.slug].acreditacion && (
                        <span className="program-pnpc"><i className="ti ti-award"></i> Acreditada CIEES</span>
                      )}
                      <span className="program-sigla">{p.codigo}</span>
                    </div>
                    <div className="program-card-body">
                      <h3>{PROGRAM_CONTENT[p.slug].nombreCompleto}</h3>
                      <p>{PROGRAM_CONTENT[p.slug].ofertaDesc}</p>
                      <div className="program-tags">
                        <span className="program-tag"><i className="ti ti-clock"></i> {p.duracion}</span>
                        <span className="program-tag"><i className="ti ti-building-university"></i> {p.modalidad}</span>
                      </div>
                      <div className="program-card-actions">
                        <NavLink to={`/oferta-educativa/${p.slug}`} className="btn-sm-rojo">
                          <i className="ti ti-info-circle"></i> Más info
                        </NavLink>
                        <NavLink to="/convocatorias" className="btn-sm-outline">Convocatoria</NavLink>
                      </div>
                    </div>
                  </div>
                ))}
              </div>

              <div className="seccion-cta">
                <NavLink to="/convocatorias" className="btn-link-rojo">
                  Ver convocatorias abiertas <i className="ti ti-arrow-right"></i>
                </NavLink>
              </div>
            </>
          ) : (
            <>
              <div className="directorio-grid" style={{ marginBottom: 32 }}>
                {HIBRIDA_ITEMS.map((h) => (
                  <div className="directorio-item" key={h.titulo}>
                    <div className="directorio-icon"><i className={`ti ${h.icono}`}></i></div>
                    <div>
                      <div className="directorio-nombre">{h.titulo}</div>
                      <div className="directorio-cargo">Información próximamente disponible.</div>
                    </div>
                  </div>
                ))}
              </div>
              <p style={{ fontSize: 11, color: '#aaa', lineHeight: 1.7, borderTop: '1px solid #eee', paddingTop: 14 }}>
                * La modalidad híbrida combina sesiones presenciales y virtuales, alternando según la naturaleza de cada
                asignatura y el avance del grupo. Esto permite mantener la cercanía académica del aula cuando el contenido
                lo requiere, y aprovechar la flexibilidad de lo virtual cuando el proceso de aprendizaje así lo permite. De
                esta manera, se optimiza el tiempo del estudiante sin comprometer la calidad de la formación.
              </p>
            </>
          )}
        </div>
      </section>

      <PageNavBottom prev={{ to: '/nosotros', label: 'Nosotros' }} next={{ to: '/investigacion', label: 'Investigación' }} />
    </>
  );
}
