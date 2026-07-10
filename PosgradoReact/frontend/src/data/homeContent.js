// Contenido real de Posgrado/pages/home.html (bloque de fallback que se usa
// cuando no hay convocatorias/noticias en la base de datos -- que es
// exactamente el estado actual, sin backend conectado). Los nombres de
// Nosotros vienen de contactInfo.js: home.html ya trae el director y jefe
// de posgrado actualizados, a diferencia de php/pages/home.php que se
// quedó con los nombres viejos. El hero y las convocatorias también se
// actualizaron a las 3 convocatorias reales del Semestre B-2026 (antes
// home.php mostraba 5 tarjetas genéricas de "Ciclo A-2025").
import { DIRECTOR, JEFE_POSGRADO } from './contactInfo.js';
import { CONVOCATORIAS_B2026 } from './announcementsContent.js';

export const HERO = {
  titulo: 'La herramienta para el futuro<br>que tú deseas',
  subtitulo:
    'Formamos líderes con excelencia académica, investigación y compromiso para el desarrollo de la sociedad.',
  stats: [
    { num: '5+', label: 'Programas de Posgrado' },
    { num: '25+', label: 'Años de Trayectoria' },
    { num: 'SNP', label: 'Reconocimiento Nacional' },
  ],
  slides: [
    { titulo: 'Maestría en Gestión Pública', badge: 'Semestre B-2026', icono: 'ti-building-community', tint1: '#b71c1c', tint2: '#7f0000' },
    { titulo: 'Maestría en Gestión de Negocios', badge: 'Semestre B-2026', icono: 'ti-briefcase', tint1: '#a87f3d', tint2: '#6d5227' },
    { titulo: 'Maestría en Estrategias Contables', badge: 'Semestre B-2026', icono: 'ti-calculator', tint1: '#1a3a5c', tint2: '#0d2035' },
  ],
};

export const CONVOCATORIAS_HOME = [
  {
    ...CONVOCATORIAS_B2026[0],
    descHome: 'Forma líderes para el desarrollo y modernización del sector público con visión estratégica e institucional. Duración 2 años, modalidad híbrida.',
  },
  {
    ...CONVOCATORIAS_B2026[1],
    descHome: 'Desarrolla competencias estratégicas para liderar organizaciones en entornos dinámicos y globales. Duración 2 años, modalidad híbrida.',
  },
  {
    ...CONVOCATORIAS_B2026[2],
    descHome: 'Especialízate en análisis financiero y planeación fiscal para una toma de decisiones efectiva. Duración 14 meses, modalidad híbrida.',
  },
];

export const NOTICIAS_HOME = [
  {
    titulo: 'Abierta la convocatoria para el Ciclo A-2025 para ME',
    desc: 'El programa de Maestría en Economía abre su proceso de admisión para el próximo ciclo escolar con nuevas modalidades.',
  },
  {
    titulo: 'Nuevo programa de posgrado: Maestría en Economía',
    desc: 'La División incorpora un nuevo programa reconocido a nivel nacional con el sello de calidad del SNP-CONAHCYT.',
  },
  {
    titulo: 'Convocatoria Ciclo A-2025 para MGN, MGP, MEC y EAH',
    desc: 'Cuatro programas de posgrado abren simultáneamente su proceso de admisión. Descarga la convocatoria de tu interés.',
  },
];

export const NOSOTROS_HOME = [
  {
    rol: 'Mensaje del Director',
    cargo: DIRECTOR.cargo,
    nombre: DIRECTOR.nombre,
    foto: DIRECTOR.foto,
    mensaje: DIRECTOR.mensajeCorto,
  },
  {
    rol: 'Mensaje del Jefe de Posgrado',
    cargo: JEFE_POSGRADO.cargo,
    nombre: JEFE_POSGRADO.nombre,
    foto: JEFE_POSGRADO.foto,
    mensaje: JEFE_POSGRADO.mensajeCorto,
  },
];

export const GALERIA_HOME = [
  { archivo: 'assets/img/galeria-1.jpg', large: true },
  { archivo: 'assets/img/galeria-2.jpg' },
  { archivo: 'assets/img/galeria-3.jpg' },
  { archivo: 'assets/img/galeria-4.jpg' },
  { archivo: 'assets/img/galeria-5.jpg' },
];
