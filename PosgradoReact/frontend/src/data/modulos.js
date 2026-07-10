// Portado tal cual desde Posgrado/php/admin/modulos.php (const MODULOS).
// Es el registro central de módulos del Control Maestro: cada uno define
// una tabla real, sus campos editables y cómo debe verse su formulario.
// AdminPanel.jsx lo usa para generar la grilla/formulario de cada pestaña
// sin tener que escribir un CRUD distinto por módulo.
export const MODULOS = {
  oferta: {
    tabla: 'programas',
    etiqueta: 'Oferta Educativa',
    etiquetaItem: 'Programa',
    icono: 'ti-school',
    tituloCampo: 'nombre',
    campos: [
      { nombre: 'codigo', etiqueta: 'Código (Ej. DGO, ME)', tipo: 'text', requerido: true },
      { nombre: 'nombre', etiqueta: 'Nombre completo', tipo: 'text', requerido: true },
      { nombre: 'nivel', etiqueta: 'Nivel', tipo: 'select', opciones: { especialidad: 'Especialidad', maestria: 'Maestría', doctorado: 'Doctorado' }, requerido: true },
      { nombre: 'modalidad', etiqueta: 'Modalidad', tipo: 'select', opciones: { presencial: 'Presencial', virtual: 'Virtual', mixta: 'Mixta' }, requerido: true },
      { nombre: 'duracion_semestres', etiqueta: 'Duración (semestres)', tipo: 'number' },
      { nombre: 'creditos', etiqueta: 'Créditos', tipo: 'number' },
      { nombre: 'descripcion', etiqueta: 'Descripción', tipo: 'textarea' },
      { nombre: 'objetivo', etiqueta: 'Objetivo', tipo: 'textarea' },
      { nombre: 'perfil_ingreso', etiqueta: 'Perfil de ingreso', tipo: 'textarea' },
      { nombre: 'perfil_egreso', etiqueta: 'Perfil de egreso', tipo: 'textarea' },
      { nombre: 'pnpc', etiqueta: 'Reconocido en el SNP', tipo: 'checkbox' },
      { nombre: 'pnpc_nivel', etiqueta: 'Nivel SNP (Ej. en consolidación)', tipo: 'text' },
      { nombre: 'imagen_id', etiqueta: 'Imagen del programa', tipo: 'imagen' },
      { nombre: 'orden_display', etiqueta: 'Orden (menor = primero)', tipo: 'number' },
      { nombre: 'activo', etiqueta: 'Publicado en el sitio', tipo: 'checkbox', defecto: true },
    ],
  },

  convocatorias: {
    tabla: 'convocatorias',
    etiqueta: 'Convocatorias',
    etiquetaItem: 'Convocatoria',
    icono: 'ti-file-text',
    tituloCampo: 'titulo',
    campos: [
      { nombre: 'titulo', etiqueta: 'Título', tipo: 'text', requerido: true },
      { nombre: 'programa_id', etiqueta: 'Programa relacionado', tipo: 'programa_id' },
      { nombre: 'ciclo', etiqueta: 'Ciclo (Ej. A-2025)', tipo: 'text' },
      { nombre: 'descripcion', etiqueta: 'Descripción', tipo: 'textarea' },
      { nombre: 'requisitos', etiqueta: 'Requisitos', tipo: 'textarea' },
      { nombre: 'proceso_seleccion', etiqueta: 'Proceso de selección', tipo: 'textarea' },
      { nombre: 'fecha_inicio', etiqueta: 'Inicio de registro', tipo: 'date' },
      { nombre: 'fecha_cierre', etiqueta: 'Límite de registro', tipo: 'date' },
      { nombre: 'fecha_inicio_clases', etiqueta: 'Inicio de clases', tipo: 'date' },
      { nombre: 'imagen_poster_id', etiqueta: 'Cartel (imagen)', tipo: 'imagen' },
      { nombre: 'archivo_id', etiqueta: 'Documento (PDF)', tipo: 'documento' },
      { nombre: 'es_publicado', etiqueta: 'Publicar en el sitio', tipo: 'checkbox' },
    ],
  },

  nosotros: {
    tabla: 'directivos',
    etiqueta: 'Nosotros · Directorio',
    etiquetaItem: 'Persona',
    icono: 'ti-users',
    tituloCampo: 'nombre',
    campos: [
      { nombre: 'nombre', etiqueta: 'Nombre completo', tipo: 'text', requerido: true },
      { nombre: 'cargo', etiqueta: 'Cargo / puesto', tipo: 'text', requerido: true },
      { nombre: 'area', etiqueta: 'Área', tipo: 'text' },
      { nombre: 'email', etiqueta: 'Correo electrónico', tipo: 'email' },
      { nombre: 'telefono', etiqueta: 'Teléfono / extensión', tipo: 'text' },
      { nombre: 'descripcion', etiqueta: 'Descripción / semblanza', tipo: 'textarea' },
      { nombre: 'foto_id', etiqueta: 'Fotografía', tipo: 'imagen' },
      { nombre: 'orden_display', etiqueta: 'Orden (menor = primero)', tipo: 'number' },
      { nombre: 'activo', etiqueta: 'Publicado en el sitio', tipo: 'checkbox', defecto: true },
    ],
  },

  investigacion: {
    tabla: 'cuerpos_academicos',
    etiqueta: 'Investigación',
    etiquetaItem: 'Cuerpo académico',
    icono: 'ti-microscope',
    tituloCampo: 'nombre',
    campos: [
      { nombre: 'clave_prodep', etiqueta: 'Clave PRODEP (Ej. FECA-CA-01)', tipo: 'text', requerido: true },
      { nombre: 'nombre', etiqueta: 'Nombre', tipo: 'text', requerido: true },
      { nombre: 'consolidacion', etiqueta: 'Grado de consolidación', tipo: 'select', opciones: { en_formacion: 'En formación', en_consolidacion: 'En consolidación', consolidado: 'Consolidado' }, requerido: true },
      { nombre: 'descripcion', etiqueta: 'Descripción / líneas generales', tipo: 'textarea' },
      { nombre: 'activo', etiqueta: 'Publicado en el sitio', tipo: 'checkbox', defecto: true },
    ],
  },

  comunidad: {
    tabla: 'comunidad_items',
    etiqueta: 'Comunidad',
    etiquetaItem: 'Elemento',
    icono: 'ti-users-group',
    tituloCampo: 'titulo',
    campos: [
      { nombre: 'tipo', etiqueta: 'Tipo de contenido', tipo: 'select', opciones: { evento: 'Evento', recurso: 'Recurso', servicio: 'Servicio', tutoria: 'Tutoría', otro: 'Otro' }, requerido: true },
      { nombre: 'titulo', etiqueta: 'Título', tipo: 'text', requerido: true },
      { nombre: 'descripcion', etiqueta: 'Descripción', tipo: 'textarea' },
      { nombre: 'fecha', etiqueta: 'Fecha (si aplica)', tipo: 'date' },
      { nombre: 'categoria', etiqueta: 'Categoría (Ej. Académico)', tipo: 'text' },
      { nombre: 'url', etiqueta: 'Enlace / URL', tipo: 'url' },
      { nombre: 'imagen_id', etiqueta: 'Imagen / banner', tipo: 'imagen' },
      { nombre: 'orden_display', etiqueta: 'Orden (menor = primero)', tipo: 'number' },
      { nombre: 'es_publicado', etiqueta: 'Publicar en el sitio', tipo: 'checkbox' },
    ],
  },

  blog: {
    tabla: 'noticias',
    etiqueta: 'Blog / Noticias',
    etiquetaItem: 'Entrada',
    icono: 'ti-news',
    tituloCampo: 'titulo',
    campos: [
      { nombre: 'tipo', etiqueta: 'Tipo', tipo: 'select', opciones: { noticia: 'Noticia', evento: 'Evento', aviso: 'Aviso', comunicado: 'Comunicado' }, requerido: true },
      { nombre: 'titulo', etiqueta: 'Título', tipo: 'text', requerido: true },
      { nombre: 'slug', etiqueta: 'Slug (se genera solo si se deja vacío)', tipo: 'text' },
      { nombre: 'resumen', etiqueta: 'Resumen / extracto', tipo: 'textarea' },
      { nombre: 'cuerpo', etiqueta: 'Cuerpo de la nota', tipo: 'textarea' },
      { nombre: 'fecha_evento', etiqueta: 'Fecha del evento (si aplica)', tipo: 'date' },
      { nombre: 'lugar_evento', etiqueta: 'Lugar del evento', tipo: 'text' },
      { nombre: 'imagen_portada_id', etiqueta: 'Imagen destacada', tipo: 'imagen' },
      { nombre: 'es_destacado', etiqueta: 'Destacar en Inicio', tipo: 'checkbox' },
      { nombre: 'es_publicado', etiqueta: 'Publicar en el sitio', tipo: 'checkbox' },
    ],
  },

  documentos: {
    tabla: 'documentos',
    etiqueta: 'Documentos / Descargas',
    etiquetaItem: 'Documento',
    icono: 'ti-download',
    tituloCampo: 'titulo',
    campos: [
      { nombre: 'titulo', etiqueta: 'Título', tipo: 'text', requerido: true },
      { nombre: 'categoria', etiqueta: 'Categoría', tipo: 'select', opciones: { reglamento: 'Reglamento', formato: 'Formato', calendario: 'Calendario', plan_estudios: 'Plan de estudios', guia: 'Guía', plantilla: 'Plantilla', informe: 'Informe', otro: 'Otro' }, requerido: true },
      { nombre: 'audiencia', etiqueta: 'Audiencia', tipo: 'select', opciones: { todos: 'Todos', alumnado: 'Alumnado', profesorado: 'Profesorado', administrativo: 'Administrativo' }, requerido: true },
      { nombre: 'descripcion', etiqueta: 'Descripción', tipo: 'textarea' },
      { nombre: 'archivo_id', etiqueta: 'Archivo descargable', tipo: 'documento', requerido: true },
      { nombre: 'orden_display', etiqueta: 'Orden (menor = primero)', tipo: 'number' },
      { nombre: 'es_publicado', etiqueta: 'Publicar en el sitio', tipo: 'checkbox' },
    ],
  },

  tarjetas: {
    tabla: 'tarjetas',
    etiqueta: 'Tarjetas nuevas',
    etiquetaItem: 'Tarjeta',
    icono: 'ti-layout-cards',
    tituloCampo: 'titulo',
    campos: [
      { nombre: 'seccion', etiqueta: 'Sección donde aparece (Ej. inicio, comunidad, transparencia)', tipo: 'text', requerido: true },
      { nombre: 'titulo', etiqueta: 'Título', tipo: 'text', requerido: true },
      { nombre: 'descripcion', etiqueta: 'Descripción', tipo: 'textarea' },
      { nombre: 'icono', etiqueta: 'Ícono (clase Tabler, Ej. ti-star)', tipo: 'text' },
      { nombre: 'imagen_id', etiqueta: 'Imagen', tipo: 'imagen' },
      { nombre: 'destino_tipo', etiqueta: 'Destino', tipo: 'select', opciones: { pagina_dinamica: 'Página nueva (slug)', documento: 'Documento (id de Documentos)', externo: 'Enlace externo (URL)' }, requerido: true },
      { nombre: 'destino_valor', etiqueta: 'Valor del destino (slug / id / URL según lo de arriba)', tipo: 'text', requerido: true },
      { nombre: 'orden_display', etiqueta: 'Orden (menor = primero)', tipo: 'number' },
      { nombre: 'es_publicado', etiqueta: 'Publicar en el sitio', tipo: 'checkbox' },
    ],
  },
};

// Pestañas del panel que no siguen el patrón genérico tabla+campos (portado de panel.php).
export const TABS_EXTRA = {
  bloques: { etiqueta: 'Página principal (bloques)', icono: 'ti-typography' },
  paginas: { etiqueta: 'Páginas nuevas', icono: 'ti-file-plus' },
  historial: { etiqueta: 'Historial', icono: 'ti-history' },
};

// Portado de BLOQUES_CONOCIDOS en modulos.php.
export const BLOQUES_CONOCIDOS = [
  { pagina: 'home', clave: 'hero_titulo', etiqueta: 'Inicio · Título principal (hero)' },
  { pagina: 'home', clave: 'hero_subtitulo', etiqueta: 'Inicio · Texto bajo el título (hero)' },
  { pagina: 'contacto', clave: 'direccion', etiqueta: 'Contacto · Dirección' },
  { pagina: 'contacto', clave: 'horario', etiqueta: 'Contacto · Horario de atención' },
];
