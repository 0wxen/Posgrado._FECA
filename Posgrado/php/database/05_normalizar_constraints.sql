-- Aplica a una BD ya existente las restricciones nuevas de schema.sql
-- (NOT NULL / CHECK / UNIQUE). No borra nada. Segura de correr más de una vez.
--   psql -U <usuario> -d <basededatos> -f 05_normalizar_constraints.sql

-- convocatorias
DO $$
BEGIN
  IF NOT EXISTS (SELECT 1 FROM pg_constraint WHERE conname = 'convocatorias_programa_id_ciclo_key') THEN
    ALTER TABLE convocatorias ADD CONSTRAINT convocatorias_programa_id_ciclo_key UNIQUE (programa_id, ciclo);
  END IF;
  IF NOT EXISTS (SELECT 1 FROM pg_constraint WHERE conname = 'convocatorias_fecha_cierre_check') THEN
    ALTER TABLE convocatorias ADD CONSTRAINT convocatorias_fecha_cierre_check
      CHECK (fecha_inicio IS NULL OR fecha_cierre IS NULL OR fecha_cierre >= fecha_inicio);
  END IF;
END $$;

-- profesores
UPDATE profesores SET titulo_cargo = '' WHERE titulo_cargo IS NULL;
ALTER TABLE profesores ALTER COLUMN titulo_cargo SET NOT NULL;

-- programas
ALTER TABLE programas ALTER COLUMN codigo SET NOT NULL;
ALTER TABLE programas ALTER COLUMN nivel SET NOT NULL;
ALTER TABLE programas ALTER COLUMN modalidad SET NOT NULL;
DO $$
BEGIN
  IF NOT EXISTS (SELECT 1 FROM pg_constraint WHERE conname = 'programas_nivel_check') THEN
    ALTER TABLE programas ADD CONSTRAINT programas_nivel_check
      CHECK (nivel IN ('especialidad', 'maestria', 'doctorado'));
  END IF;
  IF NOT EXISTS (SELECT 1 FROM pg_constraint WHERE conname = 'programas_modalidad_check') THEN
    ALTER TABLE programas ADD CONSTRAINT programas_modalidad_check
      CHECK (modalidad IN ('presencial', 'virtual', 'mixta'));
  END IF;
END $$;

-- publicaciones
-- Corrige 2 valores de tipo que entraron directo por SQL (02_contenido_oficial.sql)
-- y nunca pasaron por el select del panel, así que no coinciden con sus opciones.
UPDATE publicaciones SET tipo = 'capitulo' WHERE tipo = 'capitulo_libro';
UPDATE publicaciones SET tipo = 'memoria'  WHERE tipo = 'ponencia';
ALTER TABLE publicaciones ALTER COLUMN tipo SET NOT NULL;
DO $$
BEGIN
  IF NOT EXISTS (SELECT 1 FROM pg_constraint WHERE conname = 'publicaciones_tipo_check') THEN
    ALTER TABLE publicaciones ADD CONSTRAINT publicaciones_tipo_check
      CHECK (tipo IN ('articulo', 'capitulo', 'libro', 'memoria', 'otro'));
  END IF;
END $$;

-- documentos
UPDATE documentos SET categoria = 'otro'  WHERE categoria IS NULL;
UPDATE documentos SET audiencia = 'todos' WHERE audiencia IS NULL;
ALTER TABLE documentos ALTER COLUMN categoria SET NOT NULL;
ALTER TABLE documentos ALTER COLUMN audiencia SET NOT NULL;
DO $$
BEGIN
  IF NOT EXISTS (SELECT 1 FROM pg_constraint WHERE conname = 'documentos_categoria_check') THEN
    ALTER TABLE documentos ADD CONSTRAINT documentos_categoria_check
      CHECK (categoria IN ('reglamento', 'formato', 'calendario', 'plan_estudios', 'guia', 'plantilla', 'informe', 'otro'));
  END IF;
  IF NOT EXISTS (SELECT 1 FROM pg_constraint WHERE conname = 'documentos_audiencia_check') THEN
    ALTER TABLE documentos ADD CONSTRAINT documentos_audiencia_check
      CHECK (audiencia IN ('todos', 'alumnado', 'profesorado'));
  END IF;
END $$;

-- archivos
DO $$
BEGIN
  IF NOT EXISTS (SELECT 1 FROM pg_constraint WHERE conname = 'archivos_tamano_bytes_check') THEN
    ALTER TABLE archivos ADD CONSTRAINT archivos_tamano_bytes_check
      CHECK (tamano_bytes IS NULL OR tamano_bytes > 0);
  END IF;
END $$;
