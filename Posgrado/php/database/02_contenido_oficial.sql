-- Contenido real y oficial de la División de Estudios de Posgrado FECA UJED.
-- Correr después de schema.sql (que ya deja creadas mensajes_institucionales
-- y preguntas_frecuentes con sus propios datos reales).

-- ── PROFESORES / DIRECTORIO ──────────────────────────────────────────────
-- El Director no va aquí (va solo en mensajes_institucionales, con su mensaje).
INSERT INTO profesores (nombre, titulo_cargo, email, telefono_extension, orden_display) VALUES
    ('Dr. Eliú J. Reyes Reyes', 'Jefe de Posgrado', 'jefaturaposgrado.feca@ujed.mx', 'Ext. 5715', 10),
    ('María Concepción Sosa Álvarez', 'Coordinadora Académica', 'academicaposgrado.feca@ujed.mx', 'Ext. 5718', 20),
    ('César Alberto Gurrola Pérez', 'Coordinador Administrativo', 'adminposgrado.feca@ujed.mx', 'Ext. 5717', 30),
    ('Coordinación General', 'Atención General', 'posgradofeca@ujed.mx', '618 827 1266', 40);


-- ── PROGRAMAS ─────────────────────────────────────────────────────────────
INSERT INTO programas (codigo, nombre, nivel, modalidad, duracion_semestres, descripcion, orden_display, activo)
VALUES
    ('DGO', 'Doctorado en Gestión de las Organizaciones', 'doctorado', 'presencial', 8,
     'Forma investigadores y académicos con capacidad para generar conocimiento científico aplicado a la gestión organizacional en contextos complejos y globalizados.', 10, TRUE),
    ('EAH', 'Especialidad en Administración de Hospitales', 'especialidad', 'presencial', 2,
     'Desarrolla habilidades de gestión en el sector salud para optimizar los recursos y mejorar la calidad en la atención de unidades hospitalarias.', 20, TRUE),
    ('MAG', 'Maestría en Auditoría Gubernamental', 'maestria', 'presencial', 4,
     'Capacita profesionales para ejercer la auditoría en organismos públicos con un enfoque de transparencia, legalidad y eficiencia en el uso de recursos gubernamentales.', 30, TRUE),
    ('ME', 'Maestría en Economía', 'maestria', 'presencial', 4,
     'Desarrolla competencias analíticas avanzadas para comprender y resolver los desafíos económicos locales, regionales y globales mediante la investigación aplicada.', 40, TRUE),
    ('MEC', 'Maestría en Estrategias Contables', 'maestria', 'presencial', 4,
     'Especialízate en análisis financiero, planeación fiscal y estrategias contables para la toma de decisiones efectiva en organizaciones públicas y privadas.', 50, TRUE),
    ('MGN', 'Maestría en Gestión de Negocios', 'maestria', 'presencial', 4,
     'Forma competencias estratégicas para liderar y transformar organizaciones en entornos dinámicos, globales y altamente competitivos con visión empresarial.', 60, TRUE),
    ('MGP', 'Maestría en Gestión Pública', 'maestria', 'presencial', 4,
     'Prepara servidores públicos y gestores con capacidad de análisis, diseño e implementación de políticas para impulsar la modernización y el desarrollo institucional.', 70, TRUE),
    ('MM', 'Maestría en Mercadotecnia', 'maestria', 'presencial', 4,
     'Desarrolla habilidades para diseñar, ejecutar y evaluar estrategias de marketing en entornos digitales y tradicionales, orientadas al posicionamiento y creación de valor.', 80, TRUE);

-- Objetivo / Perfil de ingreso / Perfil de egreso / Acreditación / Admisión
UPDATE programas SET
  objetivo = 'Formar recursos humanos de alto nivel en las disciplinas del área económico administrativa, que tengan como objeto de estudio las organizaciones, que generen alternativas de innovación y desarrollo sustentable, por medio de procesos de investigación, diagnóstico, planeación e intervención aplicada a los problemas comunes del entorno.',
  perfil_ingreso = 'Grado de maestría en áreas económico-administrativas o afines.
Experiencia en el ámbito organizacional, académico o empresarial.
Interés por la investigación científica aplicada a las organizaciones.
Habilidades de análisis, síntesis y comunicación académica avanzada.
Capacidad de trabajo autónomo y colaborativo.',
  perfil_egreso = 'Analizar el entorno desde la perspectiva económico-financiera, organizacional y de sustentabilidad para tomar decisiones en los ámbitos regional y nacional.
Analizar las propuestas teóricas y empíricas de las organizaciones contemporáneas, aplicar técnicas de mejora de eficiencia, productividad, competitividad y rentabilidad.
Emplear estrategias de mejora continua sustentadas en las tendencias actuales de la teoría organizacional para optimizar la calidad en los procesos productivos y de servicios.',
  acreditacion = 'SNP · CONAHCYT',
  admision_nota = 'Curso propedéutico · Entrevista · Examen de inglés.'
WHERE codigo = 'DGO';

UPDATE programas SET
  objetivo = 'Preparar profesionales capacitados en las técnicas administrativas para la adecuada toma de decisiones en las instituciones hospitalarias. Dotar a los participantes de capacidad para relacionar y aprovechar las técnicas administrativas a través del conocimiento profundo de la situación que prevalece en las instituciones hospitalarias.',
  perfil_ingreso = 'Interés por el área de la salud y laborar en instituciones hospitalarias públicas o privadas.
Habilidades de comunicación oral y escrita.
Experiencia en trabajo en equipo.',
  perfil_egreso = 'Administra los recursos materiales, financieros y humanos a través de negociación, trabajo en equipo, liderazgo y toma de decisiones éticas.
Diagnostica, analiza y sintetiza problemáticas en las organizaciones de salud para presentar propuestas y proyectos de mejora.
Mejora actitudes de servicio, aprendizaje constante, colaboración, orientación al paciente, relación de ayuda y sentido ético.',
  acreditacion = NULL,
  admision_nota = 'Curso propedéutico · Entrevista.'
WHERE codigo = 'EAH';

UPDATE programas SET
  objetivo = 'Formar maestros capacitados en la revisión de las operaciones, en lo general y en lo particular con apego a las normas generales de auditoría gubernamental, leyes de ingresos y a los presupuestos de egresos de la federación, que permitan comprobar los objetivos y metas propuestas con los resultados obtenidos.',
  perfil_ingreso = 'Interés por el desarrollo socio-económico, político y financiero de las organizaciones públicas.
Conocimientos básicos en auditoría, contabilidad, administración, finanzas, fiscal, tecnologías de la información y derecho para aplicarlos en el ámbito profesional.
Habilidades para analizar, abstraer, sintetizar y procesar información, que permita la identificación de problemas.',
  perfil_egreso = 'Tiene una actitud crítica y reflexiva para adaptarse a cambios institucionales de los sistemas de auditoría y control gubernamental, con plena conciencia del impacto del trabajo del auditor.
Realiza diagnósticos de organismos gubernamentales, revelando evidencia e identificando hallazgos para formular recomendaciones e informes con los resultados del proceso de auditoría.
Implementa proyectos con mejores prácticas de auditoría gubernamental que permiten agilizar procesos y fomentar el crecimiento profesional del egresado.',
  acreditacion = NULL,
  admision_nota = 'Curso propedéutico · Entrevista · Examen de inglés.'
WHERE codigo = 'MAG';

UPDATE programas SET
  objetivo = 'Adquirir habilidades en análisis económico y toma de decisiones para abordar desafíos y oportunidades económicas que enfrentan las comunidades en un mundo globalizado, con el propósito de mejorar la calidad de vida a través de la economía y el desarrollo sostenible.',
  perfil_ingreso = 'Conocimientos básicos en economía, desarrollo local, lógica matemática y principios de economía sostenible y desarrollo económico.
Habilidades de pensamiento crítico, analíticas, comunicación oral y escrita, trabajo en equipo, manejo de tecnologías y liderazgo.
Actitud reflexiva, interés en temas económicos, mentalidad abierta, automotivación y compromiso con el aprendizaje continuo.
Valores como compromiso con el desarrollo sostenible, integridad y ética profesional sólida.',
  perfil_egreso = 'Domina teoría económica, desarrollo económico, economía social, técnicas estadísticas, análisis de datos y software especializado para herramientas de diagnóstico económico.
Analiza e interpreta información económica de manera rigurosa, examina el comportamiento económico y evalúa teorías de desarrollo y políticas públicas para desarrollar propuestas de solución.
Tiene actitud crítica y asertiva para proponer soluciones a problemáticas económicas con bienestar social, liderando proyectos de desarrollo sostenible e inclusivo.',
  acreditacion = 'SNP · CONAHCYT',
  admision_nota = 'Curso propedéutico · Entrevista · Examen de inglés.'
WHERE codigo = 'ME';

UPDATE programas SET
  objetivo = 'Formar Maestros en Contabilidad, de manera integral, altamente calificados, para solucionar problemas en los ámbitos del sector privado y del sector público, con un enfoque objetivo para la toma de decisiones, generando especialistas en las áreas de Auditoría, Fiscal, Contaduría y Finanzas.',
  perfil_ingreso = 'Capacidad para trabajar en equipo, tolerancia a puntos de vista diferentes e interés por el desarrollo socioeconómico.
Habilidades para procesar, analizar, abstraer y sintetizar información, identificar problemas y manejo de relaciones humanas.
Conocimientos básicos en materia contable, administrativa, financiera, fiscal y derecho, así como uso de tecnologías de la información.',
  perfil_egreso = 'Identifica necesidades y problemáticas en el ámbito económico de las organizaciones, principalmente en aspectos financieros y fiscales, detectando riesgos y oportunidades de mejora.
Analiza de manera integral el entorno económico de las organizaciones, evaluando sus sistemas, registros y aplicación utilizando herramientas y técnicas profesionales con el marco regulatorio vigente.
Diseña, proyecta, propone y asesora estrategias que resuelvan las problemáticas en las organizaciones, estableciendo propuestas para implantar y evaluar resultados.',
  acreditacion = NULL,
  admision_nota = 'Curso propedéutico · Entrevista · Examen de inglés.'
WHERE codigo = 'MEC';

UPDATE programas SET
  objetivo = 'Formar maestros que posean una clara conciencia global, que les permita entender el contexto regional y local de los negocios y generar soluciones creativas e innovadoras que permitan el crecimiento y la competitividad, dando preferencia al enfoque social y sustentable.',
  perfil_ingreso = 'Capacidad para el trabajo colaborativo e innovación en el ámbito de los negocios.
Habilidades de comunicación efectiva, análisis de datos y resolución de problemas.
Espíritu emprendedor y visión estratégica orientada al crecimiento organizacional.',
  perfil_egreso = 'Aplica modelos de planeación estratégica diseñando estrategias para proyectos viables, factibles y sostenibles en entornos regionales y globales.
Ejerce un liderazgo directivo que refleja su compromiso ético y responsable con la comunidad, acelerando procesos de crecimiento y gobernanza.
Diseña intervenciones profesionales proponiendo soluciones empresariales y generando cambios creativos e innovadores desde un punto de vista sistémico.',
  acreditacion = 'CIEES (vigencia hasta 2026)',
  admision_nota = 'Curso propedéutico · Entrevista · Examen de inglés.'
WHERE codigo = 'MGN';

UPDATE programas SET
  objetivo = 'Formar maestros de alto nivel en las disciplinas del área de Administración Pública, que tengan como objetivo el estudio de las organizaciones gubernamentales y sociales, que generen alternativas de innovación y desarrollo sustentable por medio de procesos de investigación, diagnóstico y planeación a problemas comunes del sector.',
  perfil_ingreso = 'Capacidad de análisis de problemas públicos, trabajo en equipo y relaciones interpersonales.
Habilidad para toma de decisiones y expresión argumentativa.
Compromiso y motivación profesional, tolerancia al cambio y sensibilidad social hacia las problemáticas del sector público.',
  perfil_egreso = 'Soluciona problemáticas de manera proactiva e innovadora a través de herramientas profesionales en la gestión pública, promoviendo el desarrollo regional social, político y económico.
Toma decisiones a través de la integración de equipos de trabajo que permitan la inclusión de la calidad en el servicio público, identificando problemas focales y generando políticas públicas.
Es agente de cambio con ejercicio de valores en la función pública, espíritu de servicio, compromiso social y generación de propuestas innovadoras para procesos administrativos.',
  acreditacion = NULL,
  admision_nota = 'Curso propedéutico · Entrevista · Examen de inglés.'
WHERE codigo = 'MGP';

UPDATE programas SET
  objetivo = 'Capacitar en técnicas de mercadeo a quienes estén inmersos en los procesos de comercialización, para hacer frente a los diversos retos que plantean los entornos, los clientes y la competencia de un mercado determinado, con énfasis en la innovación y el desarrollo de productos y servicios de alto impacto.',
  perfil_ingreso = 'Capacidad de organización, para trabajar en equipo e individual.
Habilidades para el análisis de problemas, toma de decisiones y comunicación efectiva.
Compromiso con su profesión, ser creativo e innovador en la generación de estrategias de mercado.',
  perfil_egreso = 'Aplica estrategias de mercadeo en las organizaciones para mejorar la ventaja competitiva ante los retos del entorno local e internacional.
Utiliza la innovación para el desarrollo de productos y servicios, identificando nuevos satisfactores en las organizaciones.
Desarrolla y evalúa planes estratégicos de mercadotecnia para la implementación de productos y servicios con alto impacto en el mercado.',
  acreditacion = NULL,
  admision_nota = 'Curso propedéutico · Entrevista · Examen de inglés.'
WHERE codigo = 'MM';


-- ── TITULACIÓN Y CAMPO LABORAL POR PROGRAMA ─────────────────────────────
INSERT INTO programa_titulacion (programa_id, icono, titulo, descripcion, orden_display)
SELECT p.id, v.icono, v.titulo, v.descripcion, v.orden
FROM (VALUES
  ('DGO', 'ti-file-text',     'Tesis de Intervención Organizacional',        'Documento académico que describe cómo el investigador se inserta en una organización, realiza un diagnóstico y propone acciones de mejora con sustento teórico y metodológico.', 10),
  ('DGO', 'ti-microscope',    'Tesis de Investigación',                      'Documento académico con sustento teórico y rigor metodológico que profundiza y soluciona un tema determinado e hipotético en las organizaciones, aportando evidencias y generando nuevo conocimiento.', 20),

  ('EAH', 'ti-file-text',     'Tesina',                                      'Documento académico con sustento teórico y metodológico de menor extensión que la tesis. Permite abordar un tema de estudio a través de revisión y recopilación bibliográfica con originalidad y rigor metodológico.', 10),
  ('EAH', 'ti-chart-bar',     'Propuesta de Intervención Profesional',       'Documento académico con sustento teórico y contextual que permite, a través de metodología de trabajo, realizar un diagnóstico y presentar estrategias para atender una problemática detectada en una organización de salud.', 20),

  ('MAG', 'ti-file-text',     'Tesis',                                       'Documento académico con sustento teórico y metodológico que permite aportar conocimientos e información novedosa. Su objetivo es comprobar el planteamiento o solución de un problema mediante investigación teórico-metodológica.', 10),
  ('MAG', 'ti-chart-bar',     'Propuesta de Intervención Profesional',       'Documento académico con sustento teórico y contextual para realizar un diagnóstico organizacional y presentar estrategias de solución a una problemática detectada en el ámbito gubernamental.', 20),
  ('MAG', 'ti-report-analytics', 'Reporte Analítico de Experiencia Profesional', 'Documento que permite el análisis objetivo y sistemático de una experiencia profesional aplicada distinguida por su carácter creativo e innovador, generando casos de éxito en auditoría.', 30),

  ('ME',  'ti-file-text',     'Tesis',                                       'Documento académico con sustento teórico y metodológico que busca profundizar y solucionar un tema económico determinado, sometiendo a prueba la teoría existente y aportando evidencias.', 10),
  ('ME',  'ti-chart-bar',     'Propuesta de Intervención Profesional',       'Diagnóstico de problemáticas económicas en organizaciones o comunidades, con presentación de estrategias para su solución orientadas al desarrollo sostenible.', 20),
  ('ME',  'ti-report-analytics', 'Reporte Analítico de Experiencia Profesional', 'Análisis objetivo y sistemático de una experiencia profesional en economía aplicada, generando casos de éxito que sirvan para difusión y estudio económico.', 30),

  ('MEC', 'ti-file-text',     'Tesis',                                       'Documento académico con sustento teórico y metodológico para aportar conocimientos e información novedosa sobre un tema contable-financiero en particular.', 10),
  ('MEC', 'ti-chart-bar',     'Propuesta de Intervención Profesional',       'Diagnóstico de problemáticas contables en una organización con presentación de estrategias de solución para mejorar el desempeño económico-financiero.', 20),
  ('MEC', 'ti-building-store','Proyecto de Negocio',                        'Desarrollo de un proyecto de negocios para definir, estructurar y medir el modelo de negocio en sus dimensiones de mercado, técnicas y financieras.', 30),
  ('MEC', 'ti-report-analytics', 'Reporte Analítico de Experiencia Profesional', 'Análisis sistemático de una experiencia profesional contable creativa e innovadora, generando casos de éxito para difusión en áreas económico-administrativas.', 40),

  ('MGN', 'ti-file-text',     'Tesis',                                       'Investigación académica con sustento teórico y metodológico riguroso sobre un tema relacionado con la gestión de negocios en contextos locales o internacionales.', 10),
  ('MGN', 'ti-chart-bar',     'Propuesta de Intervención Profesional',       'Diagnóstico organizacional con propuesta de estrategias innovadoras para resolver problemáticas detectadas en organizaciones empresariales.', 20),
  ('MGN', 'ti-building-store','Proyecto de Negocio',                        'Desarrollo de un proyecto de negocios para definir, estructurar y medir el modelo de negocio en sus dimensiones de mercado, técnicas y financieras con factibilidad e implementación.', 30),
  ('MGN', 'ti-report-analytics', 'Reporte Analítico de Experiencia Profesional', 'Análisis objetivo y sistemático de una experiencia profesional distinguida por su carácter creativo e innovador en el ámbito de los negocios.', 40),

  ('MGP', 'ti-file-text',     'Tesis',                                       'Investigación académica con sustento teórico y metodológico que busca profundizar y generar conocimiento sobre problemáticas de la gestión pública y la administración gubernamental.', 10),
  ('MGP', 'ti-chart-bar',     'Propuesta de Intervención Profesional',       'Diagnóstico de problemáticas en el sector público con presentación de estrategias innovadoras para su solución, con impacto en la modernización del servicio público.', 20),
  ('MGP', 'ti-report-analytics', 'Reporte Analítico de Experiencia Profesional', 'Análisis objetivo y sistemático de una experiencia profesional en el ámbito de la gestión pública, generando casos de éxito aplicables en la función pública.', 30),

  ('MM',  'ti-file-text',     'Tesis',                                       'Investigación académica con rigor metodológico que analiza y soluciona un problema de mercadotecnia, aportando conocimiento nuevo al campo disciplinar.', 10),
  ('MM',  'ti-chart-bar',     'Propuesta de Intervención Profesional',       'Diagnóstico y planteamiento de estrategias de mercadotecnia para atender una problemática detectada en una organización del sector público o privado.', 20),
  ('MM',  'ti-building-store','Plan Estratégico de Mercadotecnia',          'Diseño de un plan estratégico integral para detectar problemáticas y oportunidades en el área de mercado y presentar acciones concretas para atenderlas.', 30),
  ('MM',  'ti-report-analytics', 'Reporte Analítico de Experiencia Profesional', 'Análisis objetivo y sistemático de una experiencia profesional innovadora en mercadotecnia, generando casos de éxito para difusión en el campo.', 40)
) AS v(codigo, icono, titulo, descripcion, orden)
JOIN programas p ON p.codigo = v.codigo;

INSERT INTO programa_campo_laboral (programa_id, icono, titulo, descripcion, orden_display)
SELECT p.id, v.icono, v.titulo, v.descripcion, v.orden
FROM (VALUES
  ('DGO', 'ti-building',           'Sector Público',              'Organismos gubernamentales y entidades del Estado', 10),
  ('DGO', 'ti-briefcase',          'Sector Privado',              'Empresas nacionales e internacionales', 20),
  ('DGO', 'ti-users',              'Sector Social',                'Organizaciones sociales y OSC', 30),
  ('DGO', 'ti-school',             'Docencia e Investigación',    'Universidades y centros de investigación', 40),

  ('EAH', 'ti-building-hospital',  'Hospitales Públicos',          'Dirección y coordinación de unidades hospitalarias del sector salud', 10),
  ('EAH', 'ti-building-community', 'Clínicas Privadas',            'Gestión administrativa de instituciones hospitalarias privadas', 20),
  ('EAH', 'ti-report-analytics',   'Consultoría',                  'Asesoría en mejores prácticas de gestión hospitalaria', 30),
  ('EAH', 'ti-school',             'Docencia',                     'Nivel licenciatura, especialidad y maestría', 40),

  ('MAG', 'ti-building',           'Auditoría Gubernamental',      'Dirección de unidades de auditoría y control de la hacienda gubernamental', 10),
  ('MAG', 'ti-report-money',       'Consultoría',                  'Asesoría en mejores prácticas de auditoría y control del sector público', 20),
  ('MAG', 'ti-calendar-check',     'Planeación de Auditoría',      'Implementación de planes anuales y plurianuales de auditoría gubernamental', 30),
  ('MAG', 'ti-school',             'Docencia e Investigación',    'Nivel licenciatura, especializaciones y maestrías', 40),

  ('ME',  'ti-building',           'Sector Público',              'Análisis y diseño de políticas económicas en gobierno federal, estatal y municipal', 10),
  ('ME',  'ti-chart-line',         'Sector Privado',              'Análisis económico, consultoría y planeación estratégica empresarial', 20),
  ('ME',  'ti-globe',              'Organismos Internacionales',   'Proyectos de desarrollo económico sostenible e inclusivo', 30),
  ('ME',  'ti-school',             'Docencia e Investigación',    'Universidades y centros de investigación económica', 40),

  ('MEC', 'ti-calculator',         'Contabilidad y Costos',        'Contabilidad general, de costos, contraloría y tesorería', 10),
  ('MEC', 'ti-search',             'Auditoría',                    'Auditoría interna, financiera y para fines específicos', 20),
  ('MEC', 'ti-report-money',       'Fiscal y Finanzas',            'Determinación de impuestos, planeación financiera y análisis de información', 30),
  ('MEC', 'ti-trending-up',        'Estrategia y Consultoría',     'Planeación estratégica, formulación de proyectos y consultoría para toma de decisiones', 40),

  ('MGN', 'ti-building',           'Dirección Empresarial',        'Directivo o mando medio en organizaciones del sector público y privado', 10),
  ('MGN', 'ti-rocket',             'Emprendimiento',                'Creación y desarrollo de negocios en contextos regional y local', 20),
  ('MGN', 'ti-trending-up',        'Consultoría Estratégica',      'Intervención organizacional para crear valor y acelerar el crecimiento', 30),
  ('MGN', 'ti-school',             'Docencia',                      'Educación superior en áreas de negocios y administración', 40),

  ('MGP', 'ti-building-arch',      'Gobierno Federal',              'Secretarías, dependencias y entidades del gobierno federal', 10),
  ('MGP', 'ti-map',                'Gobierno Estatal y Municipal',  'Gestión y modernización de servicios gubernamentales locales', 20),
  ('MGP', 'ti-users',              'Organizaciones Sociales',       'OSC, organismos autónomos y entidades del sector social', 30),
  ('MGP', 'ti-school',             'Docencia e Investigación',     'Universidades y centros de investigación en políticas públicas', 40),

  ('MM',  'ti-speakerphone',       'Marketing Estratégico',         'Dirección de marketing en empresas de consumo, servicios y tecnología', 10),
  ('MM',  'ti-brand-instagram',    'Marketing Digital',             'Estrategias digitales, e-commerce y posicionamiento en entornos digitales', 20),
  ('MM',  'ti-chart-pie',          'Investigación de Mercados',     'Análisis de mercados, tendencias de consumo y comportamiento del cliente', 30),
  ('MM',  'ti-rocket',             'Emprendimiento',                'Creación y posicionamiento de marcas y nuevos modelos de negocio', 40)
) AS v(codigo, icono, titulo, descripcion, orden)
JOIN programas p ON p.codigo = v.codigo;


-- ── CONVOCATORIAS REALES · SEMESTRE B-2026 ──────────────────────────────
-- Los PDF ya viven localmente en Posgrado/assets/docs/ (no dependen del sitio
-- externo de la FECA, que hoy tiene el certificado SSL vencido).
INSERT INTO archivos (nombre_original, ruta_relativa, tipo_mime, extension, es_imagen, es_publico) VALUES
    ('Convocatoria MGP-B2026.pdf', '../assets/docs/Convocatoria%20MGP-B2026.pdf', 'application/pdf', 'pdf', FALSE, TRUE),
    ('Convocatoria MGN-B2026.pdf', '../assets/docs/Convocatoria%20MGN-B2026.pdf', 'application/pdf', 'pdf', FALSE, TRUE),
    ('Convocatoria MEC-B2026.pdf', '../assets/docs/Convocatoria%20MEC-B2026.pdf', 'application/pdf', 'pdf', FALSE, TRUE);

INSERT INTO convocatorias (programa_id, titulo, descripcion, ciclo, fecha_inicio, fecha_cierre, requisitos, proceso_seleccion, archivo_id, es_publicado, destacado)
SELECT
  (SELECT id FROM programas WHERE codigo = 'MGP'),
  'Maestría en Gestión Pública',
  'Programa escolarizado en modalidad híbrida con sesiones los viernes de 17:00 a 22:00 h y los sábados de 9:00 a 14:00 h. Duración de 2 años en clases modulares. Costo de admisión: $4,550.00 · Costo por materia: $2,950.00. Programa Autofinanciable — No aplica descuento.',
  'B-2026', '2026-05-13', '2026-08-14',
  'CURP · Comprobante de domicilio actual (no mayor a 3 meses) · Credencial Electoral (INE) · Título Profesional, Certificado de estudios y Cédula Profesional · Acta de nacimiento · 2 cartas de recomendación (laborales o personales) · Currículum Vitae con fotografía',
  'Examen de Ubicación de Inglés · Curso Propedéutico (4 materias, 8 semanas, mínimo 8.0) · Entrevista de admisión · Pago de admisión $4,550.00 · Costo por materia $2,950.00 (programa autofinanciable)',
  (SELECT id FROM archivos WHERE nombre_original = 'Convocatoria MGP-B2026.pdf'),
  TRUE, TRUE;

INSERT INTO convocatorias (programa_id, titulo, descripcion, ciclo, fecha_inicio, fecha_cierre, requisitos, proceso_seleccion, archivo_id, es_publicado, destacado)
SELECT
  (SELECT id FROM programas WHERE codigo = 'MGN'),
  'Maestría en Gestión de Negocios',
  'Programa escolarizado en modalidad híbrida con sesiones los viernes de 17:00 a 22:00 h y los sábados de 9:00 a 14:00 h. Duración de 2 años en clases modulares. Costo de admisión: $4,550.00 · Costo por materia: $2,950.00. Programa Autofinanciable — No aplica descuento.',
  'B-2026', '2026-05-13', '2026-08-14',
  'CURP · Comprobante de domicilio actual (no mayor a 3 meses) · Credencial Electoral (INE) · Título Profesional, Certificado de estudios y Cédula Profesional · Acta de nacimiento · 2 cartas de recomendación (laborales o personales) · Currículum Vitae con fotografía',
  'Examen de Ubicación de Inglés · Curso Propedéutico (4 materias, 8 semanas, mínimo 8.0) · Entrevista de admisión · Pago de admisión $4,550.00 · Costo por materia $2,950.00 (programa autofinanciable)',
  (SELECT id FROM archivos WHERE nombre_original = 'Convocatoria MGN-B2026.pdf'),
  TRUE, TRUE;

INSERT INTO convocatorias (programa_id, titulo, descripcion, ciclo, fecha_inicio, fecha_cierre, requisitos, proceso_seleccion, archivo_id, es_publicado, destacado)
SELECT
  (SELECT id FROM programas WHERE codigo = 'MEC'),
  'Maestría en Estrategias Contables',
  'Programa escolarizado en modalidad híbrida con sesiones los viernes de 17:00 a 22:00 h y los sábados de 9:00 a 14:00 h. Duración de 14 meses en clases modulares. Costo de admisión: $4,550.00 · Costo por materia: $2,950.00. Programa Autofinanciable — No aplica descuento.',
  'B-2026', '2026-05-13', '2026-08-14',
  'CURP · Comprobante de domicilio actual (no mayor a 3 meses) · Credencial Electoral (INE) · Título Profesional, Certificado de estudios y Cédula Profesional · Acta de nacimiento · 2 cartas de recomendación (laborales o personales) · Currículum Vitae con fotografía',
  'Examen de Ubicación de Inglés · Curso Propedéutico (4 materias, 8 semanas, mínimo 8.0) · Entrevista de admisión · Pago de admisión $4,550.00 · Costo por materia $2,950.00 (programa autofinanciable)',
  (SELECT id FROM archivos WHERE nombre_original = 'Convocatoria MEC-B2026.pdf'),
  TRUE, TRUE;


-- ── GRUPOS DISCIPLINARES ─────────────────────────────────────────────────
INSERT INTO grupos_disciplinares (nombre, descripcion, area_conocimiento, activo) VALUES
    ('Mercadotecnia y Comportamiento del Consumidor',
     'Análisis de tendencias de consumo, estrategias de marketing digital y comportamiento del mercado en contextos regionales y globales.',
     'Mercadotecnia', TRUE),
    ('Finanzas Corporativas e Inversión',
     'Modelos de valoración de activos, gestión de riesgo financiero, mercados de capitales y finanzas empresariales en entornos emergentes.',
     'Finanzas', TRUE),
    ('Políticas Públicas y Administración Local',
     'Evaluación de programas gubernamentales, innovación en la gestión municipal y estudios de descentralización administrativa.',
     'Administración Pública', TRUE),
    ('Contabilidad Social y Responsabilidad Empresarial',
     'Informes de sostenibilidad, responsabilidad social corporativa, impacto ambiental de las organizaciones y contabilidad medioambiental.',
     'Contabilidad', TRUE);
