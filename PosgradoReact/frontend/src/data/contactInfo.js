// Directorio y datos de contacto reales, portados de Posgrado/pages/*.html
// (contact.html, about.html, home.html), que están MÁS actualizados que
// sus espejos Posgrado/php/pages/*.php -- esos todavía tienen el
// teléfono y los nombres viejos/genéricos (827 12 00, "Nombre",
// Dr. José Ramón Duarte Carranza, Dra. Jessica Yocaste Castañeda Galván).
// Esta es la fuente única de verdad para el resto del frontend.

export const TELEFONO_GENERAL = { texto: '618 827 1266', tel: '+526188271266' };
export const CORREO_GENERAL = 'posgradofeca@ujed.mx';

export const DIRECTOR = {
  cargo: 'Director',
  nombre: 'Dr. Jesús Guillermo Sotelo Asef',
  foto: 'assets/img/director.jpg',
  mensajeCorto:
    'Bienvenido a la División de Estudios de Posgrado. Nuestra misión es formar profesionales con visión global y un compromiso genuino con el desarrollo de nuestra región.',
  mensajeLargo: [
    'Es un honor darles la bienvenida a la División de Estudios de Posgrado de la Facultad de Economía, Contaduría y Administración de la Universidad Juárez del Estado de Durango. En esta División hemos asumido el compromiso de formar profesionales de alto nivel académico, con una sólida base investigativa y un profundo compromiso con el desarrollo de nuestra región y del país.',
    'Nuestros programas están diseñados para responder a los retos actuales del entorno económico, administrativo y social, ofreciendo a nuestros estudiantes las herramientas necesarias para convertirse en agentes de cambio y líderes en sus respectivas áreas de conocimiento. Los invitamos a ser parte de esta gran familia académica.',
  ],
};

export const JEFE_POSGRADO = {
  cargo: 'Jefe de Posgrado',
  nombre: 'Dr. Eliú J. Reyes Reyes',
  foto: 'assets/img/jefa-posgrado.jpg',
  correo: 'jefaturaposgrado.feca@ujed.mx',
  extension: '5715',
  mensajeCorto:
    'Los invitamos a ser parte de nuestra comunidad académica, donde el rigor investigativo y la excelencia son el camino hacia el futuro que deseas.',
  mensajeLargo: [
    'La División de Estudios de Posgrado de la FECA UJED es un espacio de crecimiento académico, personal y profesional donde la excelencia, el rigor investigativo y la innovación son el motor de nuestro quehacer cotidiano.',
    'Contamos con un equipo de docentes altamente calificados, comprometidos con la generación y aplicación del conocimiento, así como con programas reconocidos a nivel nacional por el Sistema Nacional de Posgrados (SNP) del CONAHCYT. Los invitamos a descubrir la herramienta para el futuro que tú deseas.',
  ],
};

// Directorio completo de Posgrado/pages/about.html (reemplaza el listado
// genérico "Coordinación Académica · Nombre" que traía about.php).
export const DIRECTORIO = [
  { icono: 'ti-school', nombre: JEFE_POSGRADO.nombre, cargo: 'Jefe de la División de Estudios de Posgrado', correo: 'jefaturaposgrado.feca@ujed.mx', extension: '5715' },
  { icono: 'ti-book', nombre: 'María Concepción Sosa Álvarez', cargo: 'Coordinadora Académica', correo: 'academicaposgrado.feca@ujed.mx', extension: '5718' },
  { icono: 'ti-building', nombre: 'César Alberto Gurrola Pérez', cargo: 'Coordinador Administrativo', correo: 'adminposgrado.feca@ujed.mx', extension: '5717' },
  { icono: 'ti-mail', nombre: 'Coordinación General', cargo: null, correo: CORREO_GENERAL, extension: null },
];
