// Contenido real de Posgrado/pages/announcements.html (Semestre B-2026),
// mucho más actualizado que su espejo php/pages/announcements.php (que
// solo tenía 2 pósters genéricos de "Ciclo A-2025"). Incluye fechas,
// costos y documentos reales.

export const CONVOCATORIAS_B2026 = [
  {
    codigo: 'MGP',
    titulo: 'Maestría en Gestión Pública',
    cicloLabel: 'Semestre B-2026 · Inicio de clases: 14 de agosto de 2026',
    limite: 'Curso Propedéutico: 5 de junio – 8 de agosto de 2026',
    inicioClases: '14 de agosto de 2026',
    cierre: '2026-08-14',
    descCorta: 'Programa híbrido (viernes y sábados). Duración 2 años, clases modulares. Forma líderes para el desarrollo y modernización del sector público.',
    descLarga: 'Programa escolarizado en modalidad híbrida con sesiones los viernes de 17:00 a 22:00 h y los sábados de 9:00 a 14:00 h. Duración de 2 años en clases modulares. Costo de admisión: $4,550.00 · Costo por materia: $2,950.00. Programa Autofinanciable — No aplica descuento.',
    doc: '/assets/docs/Convocatoria MGP-B2026.pdf',
  },
  {
    codigo: 'MGN',
    titulo: 'Maestría en Gestión de Negocios',
    cicloLabel: 'Semestre B-2026 · Inicio de clases: 14 de agosto de 2026',
    limite: 'Curso Propedéutico: 5 de junio – 8 de agosto de 2026',
    inicioClases: '14 de agosto de 2026',
    cierre: '2026-08-14',
    descCorta: 'Programa híbrido (viernes y sábados). Duración 2 años, clases modulares. Desarrolla competencias estratégicas para liderar organizaciones en entornos dinámicos.',
    descLarga: 'Programa escolarizado en modalidad híbrida con sesiones los viernes de 17:00 a 22:00 h y los sábados de 9:00 a 14:00 h. Duración de 2 años en clases modulares. Costo de admisión: $4,550.00 · Costo por materia: $2,950.00. Programa Autofinanciable — No aplica descuento.',
    doc: '/assets/docs/Convocatoria MGN-B2026.pdf',
  },
  {
    codigo: 'MEC',
    titulo: 'Maestría en Estrategias Contables',
    cicloLabel: 'Semestre B-2026 · Inicio de clases: 14 de agosto de 2026',
    limite: 'Curso Propedéutico: 5 de junio – 8 de agosto de 2026',
    inicioClases: '14 de agosto de 2026',
    cierre: '2026-08-14',
    descCorta: 'Programa híbrido (viernes y sábados). Duración 14 meses, clases modulares. Forma especialistas en análisis financiero y planeación fiscal para decisiones efectivas.',
    descLarga: 'Programa escolarizado en modalidad híbrida con sesiones los viernes de 17:00 a 22:00 h y los sábados de 9:00 a 14:00 h. Duración de 14 meses en clases modulares. Costo de admisión: $4,550.00 · Costo por materia: $2,950.00. Programa Autofinanciable — No aplica descuento.',
    doc: '/assets/docs/Convocatoria MEC-B2026.pdf',
  },
];

export const DOCUMENTACION_REQUERIDA = [
  'Clave Única de Registro de Población (CURP)',
  'Comprobante de domicilio actual (no mayor a 3 meses)',
  'Credencial Electoral (INE)',
  'Título Profesional, Certificado de estudios y Cédula Profesional',
  'Acta de nacimiento',
  '2 cartas de recomendación (laborales o personales)',
  'Currículum Vitae con fotografía',
];

export const PROCESO_ADMISION = [
  'Aplicación de Examen de Ubicación de Inglés',
  'Acreditar Curso Propedéutico (4 materias, 8 semanas) con mínimo 8.0',
  'Acreditar entrevista de admisión',
  'Pago del proceso de admisión: $4,550.00',
  'Costo por materia: $2,950.00 (programa autofinanciable)',
];

export const REGISTRO_URL = 'http://sumafeca.ujed.mx/publico/dep/registro_propedeutico';

// Cronograma Semestre B-2026: cada paso se clasifica en vivo (Completado
// / En curso / Próximo / Pendiente) comparando con la fecha de hoy,
// igual que hacía el <script> de announcements.html.
export const CRONOGRAMA_B2026 = [
  { label: 'Inscripción al proceso', fechas: '13 – 29 de mayo de 2026', desde: '2026-05-13', hasta: '2026-05-29', icono: 'ti-clipboard-list' },
  { label: 'Inducción al proceso de admisión', fechas: '5 de junio de 2026', desde: '2026-06-05', hasta: '2026-06-05', icono: 'ti-presentation' },
  { label: 'Curso Propedéutico', fechas: '5 de junio – 8 de agosto de 2026', desde: '2026-06-05', hasta: '2026-08-08', icono: 'ti-book' },
  { label: 'Examen de inglés', fechas: '31 de julio de 2026', desde: '2026-07-31', hasta: '2026-07-31', icono: 'ti-language' },
  { label: 'Entrevistas de admisión', fechas: '27 – 31 de julio de 2026', desde: '2026-07-27', hasta: '2026-07-31', icono: 'ti-users' },
  { label: 'Entrega de resultados', fechas: '9 de agosto de 2026', desde: '2026-08-09', hasta: '2026-08-09', icono: 'ti-mail-check' },
  { label: 'Sesión de bienvenida e inicio de clases', fechas: '14 de agosto de 2026', desde: '2026-08-14', hasta: '2026-08-14', icono: 'ti-school' },
];
