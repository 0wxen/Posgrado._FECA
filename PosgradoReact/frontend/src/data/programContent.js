// Contenido real portado de Posgrado/pages/program_*.html (8 páginas).
// Complementa la metadata estructural de programas.js con el texto
// editorial de cada programa: objetivo, perfiles, titulación, campo
// laboral y proceso de inscripción.

const NOTA_TITULACION =
  'Los estudiantes que concluyan satisfactoriamente el plan de estudios podrán obtener el grado mediante ' +
  'elaboración de trabajo terminal (tesis) o a través de la certificación de competencias profesionales ante ' +
  'el Consejo Nacional de Normalización y Certificación de Competencias Laborales (CONOCER), que ofrece el ' +
  'Centro de Innovación, Investigación, Emprendimiento y Desarrollo Organizacional (CIIEDO) de la Facultad de ' +
  'Economía, Contaduría y Administración, conforme a estándares de competencia alineados al perfil del programa.';

const ADMISION_BASE = [
  { titulo: 'Documentación', desc: 'Presentar la documentación de registro que la División solicite, entre esta poseer el grado de estudios profesionales.' },
  { titulo: 'Pago', desc: 'Realizar el pago correspondiente al proceso de admisión.' },
];

export const PROGRAM_CONTENT = {
  dgo: {
    nombreCompleto: 'Doctorado en Gestión de las Organizaciones',
    bannerDesc: 'Forma investigadores de alto nivel con capacidad para generar conocimiento aplicado a la gestión organizacional en contextos complejos y globalizados.',
    ofertaDesc: 'Forma recursos humanos de alto nivel que generen alternativas de innovación y desarrollo sustentable mediante investigación, diagnóstico y planeación aplicada a los problemas organizacionales del entorno.',
    objetivo: 'Formar recursos humanos de alto nivel en las disciplinas del área económico administrativa, que tengan como objeto de estudio las organizaciones, que generen alternativas de innovación y desarrollo sustentable, por medio de procesos de investigación, diagnóstico, planeación e intervención aplicada a los problemas comunes del entorno.',
    perfilIngreso: [
      'Grado de maestría en áreas económico-administrativas o afines.',
      'Experiencia en el ámbito organizacional, académico o empresarial.',
      'Interés por la investigación científica aplicada a las organizaciones.',
      'Habilidades de análisis, síntesis y comunicación académica avanzada.',
      'Capacidad de trabajo autónomo y colaborativo.',
    ],
    perfilEgreso: [
      'Analizar el entorno desde la perspectiva económico-financiera, organizacional y de sustentabilidad para tomar decisiones en los ámbitos regional y nacional.',
      'Analizar las propuestas teóricas y empíricas de las organizaciones contemporáneas, aplicar técnicas de mejora de eficiencia, productividad, competitividad y rentabilidad.',
      'Emplear estrategias de mejora continua sustentadas en las tendencias actuales de la teoría organizacional para optimizar la calidad en los procesos productivos y de servicios.',
    ],
    titulacion: [
      { icono: 'ti-file-text', titulo: 'Tesis de Intervención Organizacional', desc: 'Documento académico que describe cómo el investigador se inserta en una organización, realiza un diagnóstico y propone acciones de mejora con sustento teórico y metodológico.' },
      { icono: 'ti-microscope', titulo: 'Tesis de Investigación', desc: 'Documento académico con sustento teórico y rigor metodológico que profundiza y soluciona un tema determinado e hipotético en las organizaciones, aportando evidencias y generando nuevo conocimiento.' },
    ],
    campoLaboralDesc: 'El Doctorado en Gestión de las Organizaciones formará a los estudiantes para asumir el liderazgo regional en el desarrollo de las organizaciones.',
    campoLaboral: [
      { icono: 'ti-building', titulo: 'Sector Público', desc: 'Organismos gubernamentales y entidades del Estado' },
      { icono: 'ti-briefcase', titulo: 'Sector Privado', desc: 'Empresas nacionales e internacionales' },
      { icono: 'ti-users', titulo: 'Sector Social', desc: 'Organizaciones sociales y OSC' },
      { icono: 'ti-school', titulo: 'Docencia e Investigación', desc: 'Universidades y centros de investigación' },
    ],
    admisionPaso3: 'Acreditar: Curso propedéutico · Entrevista · Examen de inglés.',
  },

  eah: {
    nombreCompleto: 'Especialidad en Administración de Hospitales',
    bannerDesc: 'Prepara profesionales capacitados en técnicas administrativas para la adecuada toma de decisiones en instituciones hospitalarias públicas y privadas.',
    ofertaDesc: 'Prepara profesionales en técnicas administrativas para la adecuada toma de decisiones en instituciones hospitalarias, dotándolos de capacidad para relacionar y aprovechar los recursos del sector salud.',
    objetivo: 'Preparar profesionales capacitados en las técnicas administrativas para la adecuada toma de decisiones en las instituciones hospitalarias. Dotar a los participantes de capacidad para relacionar y aprovechar las técnicas administrativas a través del conocimiento profundo de la situación que prevalece en las instituciones hospitalarias.',
    perfilIngreso: [
      'Interés por el área de la salud y laborar en instituciones hospitalarias públicas o privadas.',
      'Habilidades de comunicación oral y escrita.',
      'Experiencia en trabajo en equipo.',
    ],
    perfilEgreso: [
      'Administra los recursos materiales, financieros y humanos a través de negociación, trabajo en equipo, liderazgo y toma de decisiones éticas.',
      'Diagnostica, analiza y sintetiza problemáticas en las organizaciones de salud para presentar propuestas y proyectos de mejora.',
      'Mejora actitudes de servicio, aprendizaje constante, colaboración, orientación al paciente, relación de ayuda y sentido ético.',
    ],
    titulacion: [
      { icono: 'ti-file-text', titulo: 'Tesina', desc: 'Documento académico con sustento teórico y metodológico de menor extensión que la tesis. Permite abordar un tema de estudio a través de revisión y recopilación bibliográfica con originalidad y rigor metodológico.' },
      { icono: 'ti-chart-bar', titulo: 'Propuesta de Intervención Profesional', desc: 'Documento académico con sustento teórico y contextual que permite, a través de metodología de trabajo, realizar un diagnóstico y presentar estrategias para atender una problemática detectada en una organización de salud.' },
    ],
    campoLaboralDesc: 'El egresado se desempeña en la dirección y gestión de unidades de salud del sector público y privado.',
    campoLaboral: [
      { icono: 'ti-building-hospital', titulo: 'Hospitales Públicos', desc: 'Dirección y coordinación de unidades hospitalarias del sector salud' },
      { icono: 'ti-building-community', titulo: 'Clínicas Privadas', desc: 'Gestión administrativa de instituciones hospitalarias privadas' },
      { icono: 'ti-report-analytics', titulo: 'Consultoría', desc: 'Asesoría en mejores prácticas de gestión hospitalaria' },
      { icono: 'ti-school', titulo: 'Docencia', desc: 'Nivel licenciatura, especialidad y maestría' },
    ],
    admisionPaso3: 'Acreditar: Curso propedéutico · Entrevista.',
  },

  mag: {
    nombreCompleto: 'Maestría en Auditoría Gubernamental',
    bannerDesc: 'Capacita profesionales para ejercer la auditoría en organismos públicos con un enfoque de transparencia, legalidad y eficiencia en el uso de recursos gubernamentales.',
    ofertaDesc: 'Forma maestros capacitados en la revisión de operaciones con apego a las normas de auditoría gubernamental, leyes de ingresos y presupuestos de egresos de la federación, verificando metas y resultados obtenidos.',
    objetivo: 'Formar maestros capacitados en la revisión de las operaciones, en lo general y en lo particular con apego a las normas generales de auditoría gubernamental, leyes de ingresos y a los presupuestos de egresos de la federación, que permitan comprobar los objetivos y metas propuestas con los resultados obtenidos.',
    perfilIngreso: [
      'Interés por el desarrollo socio-económico, político y financiero de las organizaciones públicas.',
      'Conocimientos básicos en auditoría, contabilidad, administración, finanzas, fiscal, tecnologías de la información y derecho para aplicarlos en el ámbito profesional.',
      'Habilidades para analizar, abstraer, sintetizar y procesar información, que permita la identificación de problemas.',
    ],
    perfilEgreso: [
      'Tiene una actitud crítica y reflexiva para adaptarse a cambios institucionales de los sistemas de auditoría y control gubernamental, con plena conciencia del impacto del trabajo del auditor.',
      'Realiza diagnósticos de organismos gubernamentales, revelando evidencia e identificando hallazgos para formular recomendaciones e informes con los resultados del proceso de auditoría.',
      'Implementa proyectos con mejores prácticas de auditoría gubernamental que permiten agilizar procesos y fomentar el crecimiento profesional del egresado.',
    ],
    titulacion: [
      { icono: 'ti-file-text', titulo: 'Tesis', desc: 'Documento académico con sustento teórico y metodológico que permite aportar conocimientos e información novedosa. Su objetivo es comprobar el planteamiento o solución de un problema mediante investigación teórico-metodológica.' },
      { icono: 'ti-chart-bar', titulo: 'Propuesta de Intervención Profesional', desc: 'Documento académico con sustento teórico y contextual para realizar un diagnóstico organizacional y presentar estrategias de solución a una problemática detectada en el ámbito gubernamental.' },
      { icono: 'ti-report-analytics', titulo: 'Reporte Analítico de Experiencia Profesional', desc: 'Documento que permite el análisis objetivo y sistemático de una experiencia profesional aplicada distinguida por su carácter creativo e innovador, generando casos de éxito en auditoría.' },
    ],
    campoLaboral: [
      { icono: 'ti-building', titulo: 'Auditoría Gubernamental', desc: 'Dirección de unidades de auditoría y control de la hacienda gubernamental' },
      { icono: 'ti-report-money', titulo: 'Consultoría', desc: 'Asesoría en mejores prácticas de auditoría y control del sector público' },
      { icono: 'ti-calendar-check', titulo: 'Planeación de Auditoría', desc: 'Implementación de planes anuales y plurianuales de auditoría gubernamental' },
      { icono: 'ti-school', titulo: 'Docencia e Investigación', desc: 'Nivel licenciatura, especializaciones y maestrías' },
    ],
    admisionPaso3: 'Acreditar: Curso propedéutico · Entrevista · Examen de inglés.',
  },

  me: {
    nombreCompleto: 'Maestría en Economía',
    bannerDesc: 'Desarrolla competencias analíticas avanzadas para comprender y resolver los desafíos económicos locales, regionales y globales mediante la investigación aplicada.',
    ofertaDesc: 'Desarrolla habilidades en análisis económico y toma de decisiones para abordar desafíos y oportunidades económicas en un mundo globalizado, promoviendo la economía y el desarrollo sostenible.',
    objetivo: 'Adquirir habilidades en análisis económico y toma de decisiones para abordar desafíos y oportunidades económicas que enfrentan las comunidades en un mundo globalizado, con el propósito de mejorar la calidad de vida a través de la economía y el desarrollo sostenible.',
    perfilIngreso: [
      'Conocimientos básicos en economía, desarrollo local, lógica matemática y principios de economía sostenible y desarrollo económico.',
      'Habilidades de pensamiento crítico, analíticas, comunicación oral y escrita, trabajo en equipo, manejo de tecnologías y liderazgo.',
      'Actitud reflexiva, interés en temas económicos, mentalidad abierta, automotivación y compromiso con el aprendizaje continuo.',
      'Valores como compromiso con el desarrollo sostenible, integridad y ética profesional sólida.',
    ],
    perfilEgreso: [
      'Domina teoría económica, desarrollo económico, economía social, técnicas estadísticas, análisis de datos y software especializado para herramientas de diagnóstico económico.',
      'Analiza e interpreta información económica de manera rigurosa, examina el comportamiento económico y evalúa teorías de desarrollo y políticas públicas para desarrollar propuestas de solución.',
      'Tiene actitud crítica y asertiva para proponer soluciones a problemáticas económicas con bienestar social, liderando proyectos de desarrollo sostenible e inclusivo.',
    ],
    titulacion: [
      { icono: 'ti-file-text', titulo: 'Tesis', desc: 'Documento académico con sustento teórico y metodológico que busca profundizar y solucionar un tema económico determinado, sometiendo a prueba la teoría existente y aportando evidencias.' },
      { icono: 'ti-chart-bar', titulo: 'Propuesta de Intervención Profesional', desc: 'Diagnóstico de problemáticas económicas en organizaciones o comunidades, con presentación de estrategias para su solución orientadas al desarrollo sostenible.' },
      { icono: 'ti-report-analytics', titulo: 'Reporte Analítico de Experiencia Profesional', desc: 'Análisis objetivo y sistemático de una experiencia profesional en economía aplicada, generando casos de éxito que sirvan para difusión y estudio económico.' },
    ],
    campoLaboral: [
      { icono: 'ti-building', titulo: 'Sector Público', desc: 'Análisis y diseño de políticas económicas en gobierno federal, estatal y municipal' },
      { icono: 'ti-chart-line', titulo: 'Sector Privado', desc: 'Análisis económico, consultoría y planeación estratégica empresarial' },
      { icono: 'ti-globe', titulo: 'Organismos Internacionales', desc: 'Proyectos de desarrollo económico sostenible e inclusivo' },
      { icono: 'ti-school', titulo: 'Docencia e Investigación', desc: 'Universidades y centros de investigación económica' },
    ],
    admisionPaso3: 'Acreditar: Curso propedéutico · Entrevista · Examen de inglés.',
  },

  mec: {
    nombreCompleto: 'Maestría en Estrategias Contables',
    bannerDesc: 'Forma maestros en contabilidad altamente calificados para solucionar problemas en los sectores público y privado, especializándolos en Auditoría, Fiscal, Contaduría y Finanzas.',
    ofertaDesc: 'Forma maestros integrales y altamente calificados para solucionar problemas en los sectores público y privado, generando especialistas en Auditoría, Fiscal, Contaduría y Finanzas.',
    objetivo: 'Formar Maestros en Contabilidad, de manera integral, altamente calificados, para solucionar problemas en los ámbitos del sector privado y del sector público, con un enfoque objetivo para la toma de decisiones, generando especialistas en las áreas de Auditoría, Fiscal, Contaduría y Finanzas.',
    perfilIngreso: [
      'Capacidad para trabajar en equipo, tolerancia a puntos de vista diferentes e interés por el desarrollo socioeconómico.',
      'Habilidades para procesar, analizar, abstraer y sintetizar información, identificar problemas y manejo de relaciones humanas.',
      'Conocimientos básicos en materia contable, administrativa, financiera, fiscal y derecho, así como uso de tecnologías de la información.',
    ],
    perfilEgreso: [
      'Identifica necesidades y problemáticas en el ámbito económico de las organizaciones, principalmente en aspectos financieros y fiscales, detectando riesgos y oportunidades de mejora.',
      'Analiza de manera integral el entorno económico de las organizaciones, evaluando sus sistemas, registros y aplicación utilizando herramientas y técnicas profesionales con el marco regulatorio vigente.',
      'Diseña, proyecta, propone y asesora estrategias que resuelvan las problemáticas en las organizaciones, estableciendo propuestas para implantar y evaluar resultados.',
    ],
    titulacion: [
      { icono: 'ti-file-text', titulo: 'Tesis', desc: 'Documento académico con sustento teórico y metodológico para aportar conocimientos e información novedosa sobre un tema contable-financiero en particular.' },
      { icono: 'ti-chart-bar', titulo: 'Propuesta de Intervención Profesional', desc: 'Diagnóstico de problemáticas contables en una organización con presentación de estrategias de solución para mejorar el desempeño económico-financiero.' },
      { icono: 'ti-building-store', titulo: 'Proyecto de Negocio', desc: 'Desarrollo de un proyecto de negocios para definir, estructurar y medir el modelo de negocio en sus dimensiones de mercado, técnicas y financieras.' },
      { icono: 'ti-report-analytics', titulo: 'Reporte Analítico de Experiencia Profesional', desc: 'Análisis sistemático de una experiencia profesional contable creativa e innovadora, generando casos de éxito para difusión en áreas económico-administrativas.' },
    ],
    campoLaboralDesc: 'El campo de acción se desarrolla en los sectores público y privado, de forma dependiente o independiente.',
    campoLaboral: [
      { icono: 'ti-calculator', titulo: 'Contabilidad y Costos', desc: 'Contabilidad general, de costos, contraloría y tesorería' },
      { icono: 'ti-search', titulo: 'Auditoría', desc: 'Auditoría interna, financiera y para fines específicos' },
      { icono: 'ti-report-money', titulo: 'Fiscal y Finanzas', desc: 'Determinación de impuestos, planeación financiera y análisis de información' },
      { icono: 'ti-trending-up', titulo: 'Estrategia y Consultoría', desc: 'Planeación estratégica, formulación de proyectos y consultoría para toma de decisiones' },
    ],
    admisionPaso3: 'Acreditar: Curso propedéutico · Entrevista · Examen de inglés.',
  },

  mgn: {
    nombreCompleto: 'Maestría en Gestión de Negocios',
    bannerDesc: 'Forma maestros con conciencia global para generar soluciones creativas e innovadoras que impulsen el crecimiento y la competitividad con un enfoque social y sustentable.',
    ofertaDesc: 'Forma competencias estratégicas para liderar y transformar organizaciones en entornos dinámicos, globales y altamente competitivos con visión empresarial.',
    acreditacion: 'CIEES (vigencia hasta 2026)',
    objetivo: 'Formar maestros que posean una clara conciencia global, que les permita entender el contexto regional y local de los negocios y generar soluciones creativas e innovadoras que permitan el crecimiento y la competitividad, dando preferencia al enfoque social y sustentable.',
    perfilIngreso: [
      'Capacidad para el trabajo colaborativo e innovación en el ámbito de los negocios.',
      'Habilidades de comunicación efectiva, análisis de datos y resolución de problemas.',
      'Espíritu emprendedor y visión estratégica orientada al crecimiento organizacional.',
    ],
    perfilEgreso: [
      'Aplica modelos de planeación estratégica diseñando estrategias para proyectos viables, factibles y sostenibles en entornos regionales y globales.',
      'Ejerce un liderazgo directivo que refleja su compromiso ético y responsable con la comunidad, acelerando procesos de crecimiento y gobernanza.',
      'Diseña intervenciones profesionales proponiendo soluciones empresariales y generando cambios creativos e innovadores desde un punto de vista sistémico.',
    ],
    titulacion: [
      { icono: 'ti-file-text', titulo: 'Tesis', desc: 'Investigación académica con sustento teórico y metodológico riguroso sobre un tema relacionado con la gestión de negocios en contextos locales o internacionales.' },
      { icono: 'ti-chart-bar', titulo: 'Propuesta de Intervención Profesional', desc: 'Diagnóstico organizacional con propuesta de estrategias innovadoras para resolver problemáticas detectadas en organizaciones empresariales.' },
      { icono: 'ti-building-store', titulo: 'Proyecto de Negocio', desc: 'Desarrollo de un proyecto de negocios para definir, estructurar y medir el modelo de negocio en sus dimensiones de mercado, técnicas y financieras con factibilidad e implementación.' },
      { icono: 'ti-report-analytics', titulo: 'Reporte Analítico de Experiencia Profesional', desc: 'Análisis objetivo y sistemático de una experiencia profesional distinguida por su carácter creativo e innovador en el ámbito de los negocios.' },
    ],
    campoLaboralDesc: 'El maestro en Gestión de Negocios se desempeña en organizaciones como directivo o mando medio, además puede emprender considerando el marco legal y el entorno económico empresarial.',
    campoLaboral: [
      { icono: 'ti-building', titulo: 'Dirección Empresarial', desc: 'Directivo o mando medio en organizaciones del sector público y privado' },
      { icono: 'ti-rocket', titulo: 'Emprendimiento', desc: 'Creación y desarrollo de negocios en contextos regional y local' },
      { icono: 'ti-trending-up', titulo: 'Consultoría Estratégica', desc: 'Intervención organizacional para crear valor y acelerar el crecimiento' },
      { icono: 'ti-school', titulo: 'Docencia', desc: 'Educación superior en áreas de negocios y administración' },
    ],
    admisionPaso3: 'Acreditar: Curso propedéutico · Entrevista · Examen de inglés.',
  },

  mgp: {
    nombreCompleto: 'Maestría en Gestión Pública',
    bannerDesc: 'Prepara servidores públicos y gestores con capacidad de análisis, diseño e implementación de políticas para impulsar la modernización y el desarrollo institucional.',
    ofertaDesc: 'Forma maestros de alto nivel en Administración Pública que generen alternativas de innovación y desarrollo sustentable mediante investigación, diagnóstico y planeación en problemáticas del sector gubernamental.',
    objetivo: 'Formar maestros de alto nivel en las disciplinas del área de Administración Pública, que tengan como objetivo el estudio de las organizaciones gubernamentales y sociales, que generen alternativas de innovación y desarrollo sustentable por medio de procesos de investigación, diagnóstico y planeación a problemas comunes del sector.',
    perfilIngreso: [
      'Capacidad de análisis de problemas públicos, trabajo en equipo y relaciones interpersonales.',
      'Habilidad para toma de decisiones y expresión argumentativa.',
      'Compromiso y motivación profesional, tolerancia al cambio y sensibilidad social hacia las problemáticas del sector público.',
    ],
    perfilEgreso: [
      'Soluciona problemáticas de manera proactiva e innovadora a través de herramientas profesionales en la gestión pública, promoviendo el desarrollo regional social, político y económico.',
      'Toma decisiones a través de la integración de equipos de trabajo que permitan la inclusión de la calidad en el servicio público, identificando problemas focales y generando políticas públicas.',
      'Es agente de cambio con ejercicio de valores en la función pública, espíritu de servicio, compromiso social y generación de propuestas innovadoras para procesos administrativos.',
    ],
    titulacion: [
      { icono: 'ti-file-text', titulo: 'Tesis', desc: 'Investigación académica con sustento teórico y metodológico que busca profundizar y generar conocimiento sobre problemáticas de la gestión pública y la administración gubernamental.' },
      { icono: 'ti-chart-bar', titulo: 'Propuesta de Intervención Profesional', desc: 'Diagnóstico de problemáticas en el sector público con presentación de estrategias innovadoras para su solución, con impacto en la modernización del servicio público.' },
      { icono: 'ti-report-analytics', titulo: 'Reporte Analítico de Experiencia Profesional', desc: 'Análisis objetivo y sistemático de una experiencia profesional en el ámbito de la gestión pública, generando casos de éxito aplicables en la función pública.' },
    ],
    campoLaboralDesc: 'El maestro en Gestión Pública se desempeña en organizaciones del sector público, promoviendo el desarrollo regional en aspectos sociales, políticos y económicos.',
    campoLaboral: [
      { icono: 'ti-building-arch', titulo: 'Gobierno Federal', desc: 'Secretarías, dependencias y entidades del gobierno federal' },
      { icono: 'ti-map', titulo: 'Gobierno Estatal y Municipal', desc: 'Gestión y modernización de servicios gubernamentales locales' },
      { icono: 'ti-users', titulo: 'Organizaciones Sociales', desc: 'OSC, organismos autónomos y entidades del sector social' },
      { icono: 'ti-school', titulo: 'Docencia e Investigación', desc: 'Universidades y centros de investigación en políticas públicas' },
    ],
    admisionPaso3: 'Acreditar: Curso propedéutico · Entrevista · Examen de inglés.',
  },

  mm: {
    nombreCompleto: 'Maestría en Mercadotecnia',
    bannerDesc: 'Capacita en técnicas de mercadeo para hacer frente a los retos que plantean los entornos, los clientes y la competencia en mercados locales e internacionales.',
    ofertaDesc: 'Desarrolla habilidades para diseñar, ejecutar y evaluar estrategias de marketing en entornos digitales y tradicionales, orientadas al posicionamiento y creación de valor.',
    objetivo: 'Capacitar en técnicas de mercadeo a quienes estén inmersos en los procesos de comercialización, para hacer frente a los diversos retos que plantean los entornos, los clientes y la competencia de un mercado determinado, con énfasis en la innovación y el desarrollo de productos y servicios de alto impacto.',
    perfilIngreso: [
      'Capacidad de organización, para trabajar en equipo e individual.',
      'Habilidades para el análisis de problemas, toma de decisiones y comunicación efectiva.',
      'Compromiso con su profesión, ser creativo e innovador en la generación de estrategias de mercado.',
    ],
    perfilEgreso: [
      'Aplica estrategias de mercadeo en las organizaciones para mejorar la ventaja competitiva ante los retos del entorno local e internacional.',
      'Utiliza la innovación para el desarrollo de productos y servicios, identificando nuevos satisfactores en las organizaciones.',
      'Desarrolla y evalúa planes estratégicos de mercadotecnia para la implementación de productos y servicios con alto impacto en el mercado.',
    ],
    titulacion: [
      { icono: 'ti-file-text', titulo: 'Tesis', desc: 'Investigación académica con rigor metodológico que analiza y soluciona un problema de mercadotecnia, aportando conocimiento nuevo al campo disciplinar.' },
      { icono: 'ti-chart-bar', titulo: 'Propuesta de Intervención Profesional', desc: 'Diagnóstico y planteamiento de estrategias de mercadotecnia para atender una problemática detectada en una organización del sector público o privado.' },
      { icono: 'ti-building-store', titulo: 'Plan Estratégico de Mercadotecnia', desc: 'Diseño de un plan estratégico integral para detectar problemáticas y oportunidades en el área de mercado y presentar acciones concretas para atenderlas.' },
      { icono: 'ti-report-analytics', titulo: 'Reporte Analítico de Experiencia Profesional', desc: 'Análisis objetivo y sistemático de una experiencia profesional innovadora en mercadotecnia, generando casos de éxito para difusión en el campo.' },
    ],
    campoLaboral: [
      { icono: 'ti-speakerphone', titulo: 'Marketing Estratégico', desc: 'Dirección de marketing en empresas de consumo, servicios y tecnología' },
      { icono: 'ti-brand-instagram', titulo: 'Marketing Digital', desc: 'Estrategias digitales, e-commerce y posicionamiento en entornos digitales' },
      { icono: 'ti-chart-pie', titulo: 'Investigación de Mercados', desc: 'Análisis de mercados, tendencias de consumo y comportamiento del cliente' },
      { icono: 'ti-rocket', titulo: 'Emprendimiento', desc: 'Creación y posicionamiento de marcas y nuevos modelos de negocio' },
    ],
    admisionPaso3: 'Acreditar: Curso propedéutico · Entrevista · Examen de inglés.',
  },
};

export function admisionPasos(slug) {
  const info = PROGRAM_CONTENT[slug];
  return [...ADMISION_BASE, { titulo: 'Admisión', desc: info.admisionPaso3 }];
}

export { NOTA_TITULACION };
