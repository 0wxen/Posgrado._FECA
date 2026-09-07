-- Contador de visitas por sección, del lado del servidor -- reemplaza el
-- conteo anterior en localStorage (que solo reflejaba el navegador de quien
-- veía el panel, no las visitas reales al sitio). Un solo renglón por
-- página (no uno por visita ni por visitante): el conteo nunca crece más
-- allá del número de secciones del sitio, así que no le pega en nada al
-- rendimiento ni al tamaño de la base.
CREATE TABLE IF NOT EXISTS estadisticas_visitas (
    pagina          VARCHAR(60) PRIMARY KEY,
    visitas         INT NOT NULL DEFAULT 0,
    actualizado_en  TIMESTAMPTZ NOT NULL DEFAULT NOW()
);
