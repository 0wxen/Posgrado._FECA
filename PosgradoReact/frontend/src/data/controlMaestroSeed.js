// Datos semilla del Control Maestro: mismas filas reales que ya usa el
// sitio público (Semestre B-2026, director/jefe correctos, 8 programas),
// reformateadas con los nombres de columna que espera el esquema de
// PosgradoReact/backend/php/database/schema.sql (mismo shape que
// MODULOS en admin/modulos.php). "documentos" y "tarjetas" se quedan
// vacíos: no hay contenido real portado todavía para esos dos módulos.
import { PROGRAMAS, NIVEL_LABEL } from './programas.js';
import { PROGRAM_CONTENT } from './programContent.js';
import { CONVOCATORIAS_B2026, DOCUMENTACION_REQUERIDA, PROCESO_ADMISION } from './announcementsContent.js';
import { DIRECTOR, DIRECTORIO, TELEFONO_GENERAL } from './contactInfo.js';
import { NOTICIAS_HOME } from './homeContent.js';

const DURACION_A_SEMESTRES = { '4 años': 8, '2 años': 4, '1 año': 2 };

const oferta = PROGRAMAS.map((p, i) => ({
  id: i + 1,
  codigo: p.codigo,
  nombre: PROGRAM_CONTENT[p.slug].nombreCompleto,
  nivel: p.nivel,
  modalidad: 'presencial',
  duracion_semestres: DURACION_A_SEMESTRES[p.duracion] ?? null,
  creditos: null,
  descripcion: PROGRAM_CONTENT[p.slug].ofertaDesc,
  objetivo: PROGRAM_CONTENT[p.slug].objetivo,
  perfil_ingreso: PROGRAM_CONTENT[p.slug].perfilIngreso.join('\n'),
  perfil_egreso: PROGRAM_CONTENT[p.slug].perfilEgreso.join('\n'),
  pnpc: !!p.snp,
  pnpc_nivel: p.snp ? 'en consolidación' : (PROGRAM_CONTENT[p.slug].acreditacion || ''),
  imagen_id: null,
  orden_display: i + 1,
  activo: true,
}));

const convocatorias = CONVOCATORIAS_B2026.map((c, i) => ({
  id: i + 1,
  titulo: c.titulo,
  programa_id: null,
  ciclo: 'B-2026',
  descripcion: c.descLarga,
  requisitos: DOCUMENTACION_REQUERIDA.join('\n'),
  proceso_seleccion: PROCESO_ADMISION.join('\n'),
  fecha_inicio: '2026-05-13',
  fecha_cierre: c.cierre,
  fecha_inicio_clases: '2026-08-14',
  imagen_poster_id: null,
  archivo_id: null,
  es_publicado: true,
}));

const nosotros = [
  { id: 1, nombre: DIRECTOR.nombre, cargo: DIRECTOR.cargo, area: 'Dirección', email: 'posgradofeca@ujed.mx', telefono: TELEFONO_GENERAL.texto, descripcion: DIRECTOR.mensajeCorto, foto_id: null, orden_display: 1, activo: true },
  ...DIRECTORIO.map((d, i) => ({
    id: i + 2,
    nombre: d.nombre,
    cargo: d.cargo || '',
    area: '',
    email: d.correo,
    telefono: d.extension ? `${TELEFONO_GENERAL.texto} ext. ${d.extension}` : TELEFONO_GENERAL.texto,
    descripcion: '',
    foto_id: null,
    orden_display: i + 2,
    activo: true,
  })),
];

const investigacion = [
  { id: 1, clave_prodep: 'FECA-CA-01', nombre: 'Gestión Organizacional y Administración Pública', consolidacion: 'consolidado', descripcion: 'Gestión de las organizaciones públicas y privadas; administración pública, transparencia y rendición de cuentas; capital humano y desempeño organizacional.', activo: true },
  { id: 2, clave_prodep: 'FECA-CA-02', nombre: 'Economía Regional y Desarrollo Sustentable', consolidacion: 'en_consolidacion', descripcion: 'Política fiscal y crecimiento económico regional; mercados financieros y microeconomía aplicada; desarrollo sustentable y economía ambiental.', activo: true },
  { id: 3, clave_prodep: 'FECA-CA-03', nombre: 'Contabilidad, Auditoría y Finanzas Públicas', consolidacion: 'en_formacion', descripcion: 'Modelos de auditoría gubernamental y fiscal; información contable y toma de decisiones; estrategias financieras en el sector público.', activo: true },
];

const comunidad = [
  { id: 1, tipo: 'servicio', titulo: 'Sistema Único de Monitoreo Académico (SUMA)', descripcion: 'Consulta calificaciones, historial académico y trámites en línea a través del portal SUMA+ de la FECA.', fecha: null, categoria: 'Académico', url: 'https://sumafeca.ujed.mx/', imagen_id: null, orden_display: 1, es_publicado: true },
  { id: 2, tipo: 'recurso', titulo: 'Sistema de Información de Posgrado Universitario (SIPU)', descripcion: 'Consulta expedientes, trámites y documentación académica del posgrado a través del portal institucional SIPU.', fecha: null, categoria: 'Académico', url: 'https://www.sipu.ujed.mx/', imagen_id: null, orden_display: 2, es_publicado: true },
];

function slugify(s) {
  return s.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
}

const blog = [
  ...NOTICIAS_HOME.map((n, i) => ({
    id: i + 1,
    tipo: 'noticia',
    titulo: n.titulo,
    slug: slugify(n.titulo),
    resumen: n.desc,
    cuerpo: '',
    fecha_evento: null,
    lugar_evento: '',
    imagen_portada_id: null,
    es_destacado: i === 0,
    es_publicado: true,
  })),
  {
    id: NOTICIAS_HOME.length + 1,
    tipo: 'evento',
    titulo: 'Semana ECA',
    slug: 'semana-eca',
    resumen: 'Semana de la Economía, Contaduría y Administración: encuentro anual con actividades culturales, artísticas y de convivencia para toda la FECA.',
    cuerpo: '',
    fecha_evento: null,
    lugar_evento: 'FECA UJED',
    imagen_portada_id: null,
    es_destacado: false,
    es_publicado: true,
  },
];

export const CONTROL_MAESTRO_SEED = {
  oferta,
  convocatorias,
  nosotros,
  investigacion,
  comunidad,
  blog,
  documentos: [],
  tarjetas: [],
};
