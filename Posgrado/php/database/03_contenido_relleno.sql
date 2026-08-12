-- Contenido de relleno para áreas genuinamente vacías del sitio.
-- A diferencia de 02_contenido_oficial.sql, nada de lo que hay aquí es
-- información real confirmada por la División — es contenido de ejemplo
-- razonable para que las páginas no se vean vacías mientras no exista
-- contenido oficial. Reemplazar/editar desde el panel admin cuando se
-- tenga el contenido real.
--
-- Qué NO se rellena aquí, y por qué:
--   • documentos: cada fila exige un archivo_id NOT NULL con un PDF real
--     (archivo_id REFERENCES archivos ON DELETE RESTRICT). Inventar filas
--     aquí obligaría a inventar también archivos que no existen en disco,
--     y cada tarjeta terminaría en un enlace roto. Mejor dejarla vacía
--     hasta subir los PDFs reales desde el panel.
--   • convocatorias de DGO, EAH, MAG, ME y MM: solo hay carteles/PDF reales
--     para MGP, MGN y MEC del ciclo B-2026 (ver 02_contenido_oficial.sql).
--     Inventar fechas y costos para los otros 5 programas sería publicar
--     información falsa de admisión, así que se quedan sin convocatoria
--     hasta que la coordinación confirme sus propios ciclos.
--   • "Semana FECA": mencionada por el usuario pero sin contenido ni
--     rastro en el historial del proyecto; no se rellena con datos
--     inventados. Ver recomendación de ubicación (tabla blog, usando
--     fecha_evento/lugar_evento) pendiente de que el usuario aporte texto.

-- ── BLOG ──────────────────────────────────────────────────────────────────
INSERT INTO blog (titulo, slug, resumen, cuerpo, fecha_evento, lugar_evento, autor_profesor_id, destacado, es_publicado, publicado_en)
VALUES
    ('Inicio de cursos del semestre B-2026',
     'inicio-cursos-b2026',
     'La División de Estudios de Posgrado da la bienvenida a las nuevas generaciones de Maestría en Gestión Pública, Gestión de Negocios y Estrategias Contables.',
     'Con la llegada del semestre B-2026, la División de Estudios de Posgrado de la FECA recibió a las nuevas generaciones de estudiantes en sus programas de Maestría en Gestión Pública, Maestría en Gestión de Negocios y Maestría en Estrategias Contables. Las actividades iniciaron con una sesión de bienvenida donde la coordinación académica presentó los planes de estudio, la planta docente y los servicios disponibles para el alumnado a lo largo del programa.',
     '2026-05-13', 'Auditorio FECA, Campus UJED',
     (SELECT id FROM profesores WHERE titulo_cargo = 'Coordinadora Académica' LIMIT 1),
     TRUE, TRUE, NOW()),

    ('Curso propedéutico: fechas y recomendaciones',
     'curso-propedeutico-b2026',
     'Información general para el alumnado de nuevo ingreso sobre el curso propedéutico previo al inicio de clases.',
     'Como parte del proceso de admisión, el alumnado de nuevo ingreso debe cursar y aprobar el curso propedéutico, compuesto por 4 materias a lo largo de 8 semanas con una calificación mínima de 8.0. Se recomienda a los aspirantes revisar con anticipación los materiales de estudio y mantenerse en contacto con la coordinación administrativa para cualquier duda sobre el proceso.',
     NULL, NULL,
     (SELECT id FROM profesores WHERE titulo_cargo = 'Coordinador Administrativo' LIMIT 1),
     FALSE, TRUE, NOW()),

    ('Reflexiones sobre la gestión pública contemporánea',
     'reflexiones-gestion-publica-contemporanea',
     'Un vistazo a los retos que enfrentan los servidores públicos formados en programas de posgrado ante la modernización institucional.',
     'La administración pública contemporánea exige perfiles capaces de combinar rigor analítico con sensibilidad social. Egresados de la Maestría en Gestión Pública de la FECA comparten su experiencia aplicando herramientas de diagnóstico y planeación estratégica en distintas dependencias gubernamentales de la región, destacando la importancia de la formación en políticas públicas para impulsar procesos de modernización institucional.',
     NULL, NULL,
     NULL,
     FALSE, TRUE, NOW()),

    ('Ceremonia de graduación generación 2024-2026',
     'graduacion-generacion-2024-2026',
     'La División de Estudios de Posgrado celebró la titulación de una nueva generación de maestros y especialistas.',
     'La comunidad de la División de Estudios de Posgrado se reunió para celebrar la culminación de estudios de la generación 2024-2026, integrada por egresados de los distintos programas de maestría y especialidad. Durante el evento se reconoció el esfuerzo académico de los estudiantes y se destacaron los proyectos de titulación con mayor impacto en sus respectivas áreas.',
     NULL, 'Auditorio FECA, Campus UJED',
     (SELECT id FROM profesores WHERE titulo_cargo = 'Jefe de Posgrado' LIMIT 1),
     TRUE, TRUE, NOW());


-- ── PUBLICACIONES ────────────────────────────────────────────────────────
INSERT INTO publicaciones (tipo, titulo, autores_texto, anio, revista_editorial, volumen_numero, paginas, resumen, es_publicado)
VALUES
    ('articulo',
     'Modernización administrativa en gobiernos municipales: un análisis comparado',
     'Reyes Reyes, E. J.; Sosa Álvarez, M. C.',
     2025, 'Revista de Administración Pública y Sociedad', 'Vol. 12, Núm. 1', 'pp. 45-68',
     'El artículo analiza procesos de modernización administrativa implementados en gobiernos municipales de la región, identificando factores que favorecen u obstaculizan su adopción efectiva.',
     TRUE),

    ('articulo',
     'Estrategias contables para la sostenibilidad financiera de las PyMEs',
     'Gurrola Pérez, C. A.',
     2025, 'Revista Mexicana de Contaduría y Finanzas', 'Vol. 8, Núm. 3', 'pp. 112-130',
     'Se examinan estrategias contables y de planeación fiscal aplicadas por pequeñas y medianas empresas de la región para mejorar su sostenibilidad financiera en contextos de incertidumbre económica.',
     TRUE),

    ('capitulo',
     'Gestión del talento humano en instituciones hospitalarias públicas',
     'Sosa Álvarez, M. C.; Reyes Reyes, E. J.',
     2024, 'Perspectivas de la Administración en Salud (compilación)', 'Cap. 6', 'pp. 89-104',
     'Capítulo que analiza modelos de gestión del talento humano aplicables a instituciones hospitalarias públicas, con énfasis en la mejora de la calidad del servicio y el desarrollo profesional del personal.',
     TRUE),

    ('memoria',
     'Comportamiento del consumidor en entornos digitales: evidencia regional',
     'Gurrola Pérez, C. A.; Sosa Álvarez, M. C.',
     2025, 'Congreso Nacional de Investigación en Ciencias Económico-Administrativas', NULL, NULL,
     'Ponencia presentada sobre patrones de comportamiento del consumidor en plataformas digitales, con datos recabados en la región y su aplicación al diseño de estrategias de mercadotecnia.',
     TRUE);
