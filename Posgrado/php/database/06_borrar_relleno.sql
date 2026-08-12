-- Borra el contenido de ejemplo de 03_contenido_relleno.sql. Borra por
-- slug/título exactos, no toda la tabla -- así no toca nada real que hayas
-- agregado después desde el panel.
--   psql -U <usuario> -d <basededatos> -f 06_borrar_relleno.sql

DELETE FROM blog WHERE slug IN (
  'inicio-cursos-b2026',
  'curso-propedeutico-b2026',
  'reflexiones-gestion-publica-contemporanea',
  'graduacion-generacion-2024-2026'
);

DELETE FROM publicaciones WHERE titulo IN (
  'Modernización administrativa en gobiernos municipales: un análisis comparado',
  'Estrategias contables para la sostenibilidad financiera de las PyMEs',
  'Gestión del talento humano en instituciones hospitalarias públicas',
  'Comportamiento del consumidor en entornos digitales: evidencia regional'
);
