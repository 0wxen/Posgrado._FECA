-- Convierte TIMESTAMP (sin zona horaria) a TIMESTAMPTZ en creado_en/
-- actualizado_en/publicado_en de todas las tablas. Los valores existentes
-- se guardaron con SET timezone='America/Monterrey' (ver config/database.php),
-- así que se reinterpretan en esa misma zona al convertir -- si no, Postgres
-- los tomaría como UTC y quedarían corridos varias horas.
--
-- Idempotente: recorre las columnas que TODAVÍA sean timestamp sin zona: si
-- ya se corrió antes, no encuentra ninguna y no hace nada.
DO $$
DECLARE
  t RECORD;
BEGIN
  FOR t IN
    SELECT table_schema, table_name, column_name
    FROM information_schema.columns
    WHERE table_schema NOT IN ('pg_catalog', 'information_schema')
      AND data_type = 'timestamp without time zone'
      AND column_name IN ('creado_en', 'actualizado_en', 'publicado_en')
  LOOP
    EXECUTE format(
      'ALTER TABLE %I.%I ALTER COLUMN %I TYPE TIMESTAMPTZ USING %I AT TIME ZONE ''America/Monterrey''',
      t.table_schema, t.table_name, t.column_name, t.column_name
    );
  END LOOP;
END $$;
