// Portado tal cual de Posgrado/pages/admin.html ("Panel de Contenido"):
// datos por defecto, esquema de campos por formulario y etiquetas por
// sección. Es el panel de agregar/editar/eliminar en modo invitado
// (localStorage, sin backend), distinto del Control Maestro real
// (admin/panel.php -> AdminPanel.jsx) que requiere sesión y PostgreSQL.

export const STORAGE_KEY = 'dep_cms_v2';

export const DEFAULTS = {
  convocatorias: [
    { id: 1, imagen: '', titulo: 'Convocatoria MGP · Semestre B-2026', programa: 'Maestría en Gestión Pública', ciclo: 'B-2026', limite: '2026-05-29', descripcion: 'Programa escolarizado en modalidad híbrida. Sesiones viernes 17:00-22:00 h y sábados 9:00-14:00 h. Duración 2 años, clases modulares. Inicio de clases: 14 de agosto de 2026. Costo admisión: $4,550.00 · Costo por materia: $2,950.00. Programa Autofinanciable, no aplica descuento.', estado: 'Vigente', urlRegistro: 'http://sumafeca.ujed.mx/publico/dep/registro_propedeutico', urlPDF: '/assets/docs/Convocatoria MGP-B2026.pdf' },
    { id: 2, imagen: '', titulo: 'Convocatoria MGN · Semestre B-2026', programa: 'Maestría en Gestión de Negocios', ciclo: 'B-2026', limite: '2026-05-29', descripcion: 'Programa escolarizado en modalidad híbrida. Sesiones viernes 17:00-22:00 h y sábados 9:00-14:00 h. Duración 2 años, clases modulares. Inicio de clases: 14 de agosto de 2026. Costo admisión: $4,550.00 · Costo por materia: $2,950.00. Programa Autofinanciable, no aplica descuento.', estado: 'Vigente', urlRegistro: 'http://sumafeca.ujed.mx/publico/dep/registro_propedeutico', urlPDF: '/assets/docs/Convocatoria MGN-B2026.pdf' },
    { id: 3, imagen: '', titulo: 'Convocatoria MEC · Semestre B-2026', programa: 'Maestría en Estrategias Contables', ciclo: 'B-2026', limite: '2026-05-29', descripcion: 'Programa escolarizado en modalidad híbrida. Sesiones viernes 17:00-22:00 h y sábados 9:00-14:00 h. Duración 14 meses, clases modulares. Inicio de clases: 14 de agosto de 2026. Costo admisión: $4,550.00 · Costo por materia: $2,950.00. Programa Autofinanciable, no aplica descuento.', estado: 'Vigente', urlRegistro: 'http://sumafeca.ujed.mx/publico/dep/registro_propedeutico', urlPDF: '/assets/docs/Convocatoria MEC-B2026.pdf' },
  ],
  nosotros: [
    { id: 1, foto: '', nombre: 'Dr. Jesús Guillermo Sotelo Asef', cargo: 'Director de la División de Estudios de Posgrado', area: 'Dirección', email: 'posgradofeca@ujed.mx', descripcion: 'Responsable de la dirección y gestión académica de los programas de posgrado de la FECA UJED.' },
    { id: 2, foto: '', nombre: 'Dr. Eliú J. Reyes Reyes', cargo: 'Jefe de la División de Estudios de Posgrado', area: 'Academia', email: 'jefaturaposgrado.feca@ujed.mx', descripcion: 'Responsable de la operación académica y administrativa de la División.' },
  ],
  oferta: [
    { id: 1, imagen: '', nivel: 'Doctorado', sigla: 'DGO', nombre: 'Doctorado en Gestión de las Organizaciones', descripcion: 'Forma recursos humanos de alto nivel que generen alternativas de innovación y desarrollo sustentable.', duracion: '4 años', modalidad: 'Presencial', reconocimiento: 'SNP' },
    { id: 2, imagen: '', nivel: 'Especialidad', sigla: 'EAH', nombre: 'Especialidad en Administración de Hospitales', descripcion: 'Prepara profesionales en técnicas administrativas para la toma de decisiones en instituciones hospitalarias.', duracion: '1 año', modalidad: 'Presencial', reconocimiento: '' },
    { id: 3, imagen: '', nivel: 'Maestría', sigla: 'ME', nombre: 'Maestría en Economía', descripcion: 'Desarrolla habilidades en análisis económico y toma de decisiones en un mundo globalizado.', duracion: '2 años', modalidad: 'Presencial', reconocimiento: 'SNP' },
  ],
  investigacion: [
    { id: 1, nombre: 'Gestión Organizacional y Administración Pública', tipo: 'Cuerpo Académico Consolidado', lineas: 'Gestión de las organizaciones públicas y privadas\nAdministración pública, transparencia y rendición de cuentas\nCapital humano y desempeño organizacional', descripcion: 'Grupo dedicado a la investigación en gestión organizacional y administración pública.', integrantes: '', prodep: 'FECA-CA-01', publicaciones: '' },
    { id: 2, nombre: 'Economía Regional y Desarrollo Sustentable', tipo: 'Cuerpo Académico en Consolidación', lineas: 'Política fiscal y crecimiento económico regional\nMercados financieros y microeconomía aplicada\nDesarrollo sustentable y economía ambiental', descripcion: 'Grupo enfocado en economía regional y desarrollo sustentable.', integrantes: '', prodep: 'FECA-CA-02', publicaciones: '' },
  ],
  comunidad: [
    { id: 1, imagen: '', tipo: 'Servicio', titulo: 'Sistema Único de Monitoreo Académico (SUMA)', descripcion: 'Consulta calificaciones, historial académico y trámites en línea a través del portal SUMA+ de la FECA.', fecha: '', categoria: 'Académico', url: 'https://sumafeca.ujed.mx/' },
    { id: 2, imagen: '', tipo: 'Recurso', titulo: 'Sistema de Información de Posgrado Universitario (SIPU)', descripcion: 'Consulta expedientes, trámites y documentación académica del posgrado a través del portal institucional SIPU.', fecha: '', categoria: 'Académico', url: 'https://www.sipu.ujed.mx/' },
  ],
  blog: [
    { id: 1, imagen: '', titulo: 'Abierta la convocatoria de admisión Ciclo A-2025', categoria: 'Noticia', fecha: '2025-01-15', extracto: 'La División de Estudios de Posgrado FECA UJED anuncia la apertura del proceso de admisión para el ciclo escolar A-2025 en sus programas de maestría y especialidad.' },
  ],
};

export const FORMS = {
  convocatorias: [
    { id: 'imagen', label: 'Imagen / Cartel (formato horizontal, igual que en Inicio)', type: 'image', aspecto: '16/9' },
    { id: 'titulo', label: 'Título', type: 'text', req: true },
    { id: 'programa', label: 'Programa', type: 'text' },
    { id: 'ciclo', label: 'Ciclo (Ej. B-2026)', type: 'text' },
    { id: 'limite', label: 'Fecha límite de registro', type: 'date' },
    { id: 'estado', label: 'Estado', type: 'select', options: ['Vigente', 'Próxima', 'Cerrada'] },
    { id: 'descripcion', label: 'Descripción', type: 'textarea' },
    { id: 'urlRegistro', label: 'URL de registro en línea', type: 'url' },
    { id: 'urlPDF', label: 'URL del documento PDF', type: 'url' },
  ],
  nosotros: [
    { id: 'foto', label: 'Fotografía (formato vertical / carnet)', type: 'image' },
    { id: 'nombre', label: 'Nombre completo', type: 'text', req: true },
    { id: 'cargo', label: 'Cargo / Puesto', type: 'text', req: true },
    { id: 'area', label: 'Área', type: 'text' },
    { id: 'email', label: 'Correo electrónico', type: 'email' },
    { id: 'descripcion', label: 'Descripción / Semblanza', type: 'textarea' },
  ],
  oferta: [
    { id: 'imagen', label: 'Imagen del programa (opcional)', type: 'image' },
    { id: 'nivel', label: 'Nivel', type: 'select', options: ['Maestría', 'Doctorado', 'Especialidad'], req: true },
    { id: 'sigla', label: 'Sigla (Ej. MCEyA)', type: 'text', req: true },
    { id: 'nombre', label: 'Nombre completo', type: 'text', req: true },
    { id: 'descripcion', label: 'Descripción', type: 'textarea' },
    { id: 'duracion', label: 'Duración', type: 'text' },
    { id: 'modalidad', label: 'Modalidad', type: 'select', options: ['Presencial', 'En línea', 'Mixta'] },
    { id: 'reconocimiento', label: 'Reconocimiento (SNP…)', type: 'text' },
  ],
  investigacion: [
    { id: 'nombre', label: 'Nombre del cuerpo / grupo', type: 'text', req: true },
    { id: 'tipo', label: 'Tipo', type: 'select', options: ['Cuerpo Académico Consolidado', 'Cuerpo Académico en Consolidación', 'Cuerpo Académico en Formación', 'Grupo Disciplinar'], req: true },
    { id: 'lineas', label: 'Líneas de investigación (una por línea)', type: 'textarea' },
    { id: 'descripcion', label: 'Descripción / Objetivos', type: 'textarea' },
    { id: 'integrantes', label: 'Integrantes (uno por línea)', type: 'textarea' },
    { id: 'prodep', label: 'Clave PRODEP', type: 'text' },
    { id: 'publicaciones', label: 'URL de publicaciones / repositorio', type: 'url' },
  ],
  comunidad: [
    { id: 'imagen', label: 'Imagen / Banner (horizontal recomendado)', type: 'image' },
    { id: 'tipo', label: 'Tipo de contenido', type: 'select', options: ['Evento', 'Recurso', 'Servicio', 'Tutoría', 'Otro'], req: true },
    { id: 'titulo', label: 'Título', type: 'text', req: true },
    { id: 'descripcion', label: 'Descripción', type: 'textarea' },
    { id: 'fecha', label: 'Fecha (si aplica)', type: 'date' },
    { id: 'categoria', label: 'Categoría (Ej. Bienestar, Académico)', type: 'text' },
    { id: 'url', label: 'Enlace / URL', type: 'url' },
  ],
  blog: [
    { id: 'imagen', label: 'Imagen destacada (formato horizontal 16:9)', type: 'image' },
    { id: 'titulo', label: 'Título', type: 'text', req: true },
    { id: 'categoria', label: 'Categoría', type: 'text' },
    { id: 'fecha', label: 'Fecha de publicación', type: 'date' },
    { id: 'extracto', label: 'Extracto / Resumen', type: 'textarea' },
  ],
};

export const LABELS = {
  convocatorias: { panel: 'Convocatorias', item: 'Convocatoria', icono: 'ti-file-text' },
  nosotros: { panel: 'Directivos y Personal', item: 'Persona', icono: 'ti-users' },
  oferta: { panel: 'Programas de Posgrado', item: 'Programa', icono: 'ti-school' },
  investigacion: { panel: 'Investigación', item: 'Cuerpo / Grupo', icono: 'ti-microscope' },
  comunidad: { panel: 'Comunidad', item: 'Elemento', icono: 'ti-users-group' },
  blog: { panel: 'Blog / Noticias', item: 'Entrada de blog', icono: 'ti-news' },
};

export const STATS_LABELS = {
  inicio: 'Inicio',
  convocatorias: 'Convocatorias',
  nosotros: 'Nosotros',
  oferta_educativa: 'Oferta Educativa',
  investigacion: 'Investigación',
  comunidad: 'Comunidad',
  contacto: 'Contacto',
  blog: 'Blog / Noticias',
  transparencia: 'Transparencia',
  titulacion: 'Titulación',
  publicaciones: 'Publicaciones',
  grupos_disciplinares: 'Grupos Disciplinares',
  admin: 'Administración',
  perfil: 'Perfil',
};
