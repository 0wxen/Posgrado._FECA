import PageBanner from '../components/PageBanner.jsx';
import PageNavBottom from '../components/PageNavBottom.jsx';

// Portado de Posgrado/php/pages/disciplinary_groups.php.
const GRUPOS = [
  { nombre: 'Mercadotecnia y Comportamiento del Consumidor', desc: 'Análisis de tendencias de consumo, estrategias de marketing digital y comportamiento del mercado en contextos regionales y globales.' },
  { nombre: 'Finanzas Corporativas e Inversión', desc: 'Modelos de valoración de activos, gestión de riesgo financiero, mercados de capitales y finanzas empresariales en entornos emergentes.' },
  { nombre: 'Políticas Públicas y Administración Local', desc: 'Evaluación de programas gubernamentales, innovación en la gestión municipal y estudios de descentralización administrativa.' },
  { nombre: 'Contabilidad Social y Responsabilidad Empresarial', desc: 'Informes de sostenibilidad, responsabilidad social corporativa, impacto ambiental de las organizaciones y contabilidad medioambiental.' },
];

export default function DisciplinaryGroups() {
  return (
    <>
      <PageBanner title="Grupos Disciplinares">
        <p className="page-banner-desc">
          Equipos de trabajo académico enfocados en áreas disciplinares específicas que fortalecen la calidad y pertinencia de los programas de posgrado.
        </p>
      </PageBanner>

      <section className="seccion seccion-blanca">
        <div className="inner">
          <div className="seccion-header">
            <span className="kicker">Especialización académica</span>
            <h2>Grupos Disciplinares Activos</h2>
            <p>Los Grupos Disciplinares articulan docencia e investigación en áreas del conocimiento con alta relevancia para la región y los programas de posgrado.</p>
          </div>

          <div className="programas-grid" style={{ gap: 24 }}>
            {GRUPOS.map((g) => (
              <div className="program-card" key={g.nombre}>
                <div className="program-card-header">
                  <span className="program-nivel">Grupo Activo</span>
                </div>
                <h3>{g.nombre}</h3>
                <p style={{ fontSize: 14, color: '#666', lineHeight: 1.75, marginBottom: 12 }}>{g.desc}</p>
                <a href="/contacto" style={{ fontSize: 13, fontWeight: 700, color: 'var(--rojo)', textDecoration: 'none' }}>
                  Más información <i className="ti ti-arrow-right"></i>
                </a>
              </div>
            ))}
          </div>
        </div>
      </section>

      <PageNavBottom prev={{ to: '/investigacion', label: 'Investigación' }} next={{ to: '/publicaciones', label: 'Publicaciones' }} />
    </>
  );
}
