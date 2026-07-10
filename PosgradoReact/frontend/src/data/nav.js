// Equivalente en React Router del array $pages de Posgrado/php/main.php.
// Cada entrada mapea la ruta pública a su título de <title> y a la sección
// de navegación activa (para el estado is-active del menú).
export const NAV_PAGES = [
  { path: '/', section: 'inicio', title: 'Inicio' },
  { path: '/nosotros', section: 'nosotros', title: 'Nosotros' },
  { path: '/oferta-educativa', section: 'oferta_educativa', title: 'Oferta Educativa' },
  { path: '/investigacion', section: 'investigacion', title: 'Investigación' },
  { path: '/comunidad', section: 'comunidad', title: 'Comunidad' },
  { path: '/blog', section: 'blog', title: 'Blog' },
  { path: '/contacto', section: 'contacto', title: 'Contacto' },
  { path: '/aviso-privacidad', section: 'aviso_privacidad', title: 'Aviso de Privacidad' },
  { path: '/terminos', section: 'terminos', title: 'Términos de Uso' },
  { path: '/mapa-sitio', section: 'mapa_sitio', title: 'Mapa del Sitio' },
  { path: '/transparencia', section: 'transparencia', title: 'Transparencia' },
  { path: '/convocatorias', section: 'convocatorias', title: 'Convocatorias' },
  { path: '/publicaciones', section: 'publicaciones', title: 'Publicaciones' },
  { path: '/grupos-disciplinares', section: 'grupos_disciplinares', title: 'Grupos Disciplinares' },
  { path: '/perfiles', section: 'perfiles', title: 'Perfiles' },
  { path: '/titulacion', section: 'titulacion', title: 'Titulación' },
  { path: '/procesos-academicos', section: 'procesos_academicos', title: 'Procesos Académicos' },
  { path: '/unidades-aprendizaje', section: 'unidades_aprendizaje', title: 'Unidades de Aprendizaje' },
];

// Ítems principales del menú superior (subconjunto de NAV_PAGES + el CTA de Contacto).
export const MAIN_NAV_ITEMS = ['nosotros', 'oferta_educativa', 'investigacion', 'comunidad', 'blog'];
