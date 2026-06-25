-- =============================================================
-- ESQUEMA RELACIONAL: División de Estudios de Posgrado
-- Institución : FECA · UJED · Durango, México
-- Motor        : PostgreSQL 15+
-- Tablas       : 22 (+ 2 vistas de compatibilidad)
-- =============================================================

-- ─────────────────────────────────────────────────────────────
-- EXTENSIONES
-- ─────────────────────────────────────────────────────────────
CREATE EXTENSION IF NOT EXISTS "pgcrypto";  -- gen_random_uuid(), crypt()
CREATE EXTENSION IF NOT EXISTS "pg_trgm";   -- búsqueda difusa / LIKE rápido
CREATE EXTENSION IF NOT EXISTS "unaccent";  -- búsqueda sin acentos

-- ─────────────────────────────────────────────────────────────
-- FUNCIÓN GLOBAL: auto-actualiza el campo actualizado_en
-- Se adjunta como trigger a todas las tablas que lo necesiten
-- ─────────────────────────────────────────────────────────────
CREATE OR REPLACE FUNCTION fn_timestamp_auto()
RETURNS TRIGGER AS $$
BEGIN
  NEW.actualizado_en = NOW();
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- ─────────────────────────────────────────────────────────────
-- MACRO: crea el trigger de actualizado_en en cualquier tabla
-- ─────────────────────────────────────────────────────────────
CREATE OR REPLACE FUNCTION fn_crear_trigger_upd(p_tabla TEXT)
RETURNS void AS $$
BEGIN
  EXECUTE format(
    'CREATE TRIGGER trg_%s_upd
     BEFORE UPDATE ON %I
     FOR EACH ROW EXECUTE FUNCTION fn_timestamp_auto()',
    p_tabla, p_tabla
  );
END;
$$ LANGUAGE plpgsql;


-- =============================================================
-- BLOQUE 1 · USUARIOS Y CONTROL DE ACCESO
-- =============================================================

-- ─────────────────────────────────────────────────────────────
-- TABLA 1: usuarios
-- Almacena todos los administradores y editores del sistema.
-- La contraseña se guarda como hash Argon2id, nunca en texto.
-- ─────────────────────────────────────────────────────────────
CREATE TABLE usuarios (
  id              BIGSERIAL      PRIMARY KEY,
  username        VARCHAR(60)    NOT NULL UNIQUE,
  email           VARCHAR(180)   NOT NULL UNIQUE,
  password_hash   TEXT           NOT NULL,          -- Argon2id / bcrypt
  nombre_completo VARCHAR(200)   NOT NULL,
  rol             VARCHAR(20)    NOT NULL DEFAULT 'editor'
                  CHECK (rol IN ('superadmin', 'admin', 'editor', 'lector')),
  activo          BOOLEAN        NOT NULL DEFAULT TRUE,
  ultimo_acceso   TIMESTAMPTZ,
  ip_ultimo       INET,
  creado_en       TIMESTAMPTZ    NOT NULL DEFAULT NOW(),
  actualizado_en  TIMESTAMPTZ    NOT NULL DEFAULT NOW()
);

SELECT fn_crear_trigger_upd('usuarios');
CREATE INDEX idx_usuarios_rol    ON usuarios(rol);
CREATE INDEX idx_usuarios_activo ON usuarios(activo);

-- ─────────────────────────────────────────────────────────────
-- TABLA 2: sesiones
-- Tokens de sesión web (alternativa segura a $_SESSION puro).
-- Se guarda el HASH del token, nunca el token real.
-- ─────────────────────────────────────────────────────────────
CREATE TABLE sesiones (
  token       VARCHAR(128)  PRIMARY KEY,   -- SHA-256 del token enviado al cliente
  usuario_id  BIGINT        NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
  ip          INET,
  user_agent  TEXT,
  expira_en   TIMESTAMPTZ   NOT NULL,
  creada_en   TIMESTAMPTZ   NOT NULL DEFAULT NOW()
);

CREATE INDEX idx_sesiones_usuario ON sesiones(usuario_id);
CREATE INDEX idx_sesiones_expira  ON sesiones(expira_en);

-- ─────────────────────────────────────────────────────────────
-- TABLA 3: api_tokens
-- Credenciales para consumir la REST API desde apps externas.
-- Solo se guarda el hash; el token original se muestra UNA VEZ.
-- ─────────────────────────────────────────────────────────────
CREATE TABLE api_tokens (
  id          BIGSERIAL     PRIMARY KEY,
  usuario_id  BIGINT        NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
  nombre      VARCHAR(120)  NOT NULL,             -- "App móvil", "Dashboard React", …
  token_hash  VARCHAR(128)  NOT NULL UNIQUE,       -- nunca el token real
  permisos    TEXT[]        NOT NULL DEFAULT '{"leer"}',
  activo      BOOLEAN       NOT NULL DEFAULT TRUE,
  ultimo_uso  TIMESTAMPTZ,
  expira_en   TIMESTAMPTZ,
  creado_en   TIMESTAMPTZ   NOT NULL DEFAULT NOW()
);

CREATE INDEX idx_api_usuario ON api_tokens(usuario_id);
CREATE INDEX idx_api_hash    ON api_tokens(token_hash);


-- =============================================================
-- BLOQUE 2 · OFERTA ACADÉMICA
-- =============================================================

-- ─────────────────────────────────────────────────────────────
-- TABLA 4: programas
-- Los 8 programas actuales de la División (maestrías, esp., doc.)
-- ─────────────────────────────────────────────────────────────
CREATE TABLE programas (
  id                  BIGSERIAL     PRIMARY KEY,
  codigo              VARCHAR(10)   NOT NULL UNIQUE,  -- DGO, ME, MAG, MEC …
  nombre              VARCHAR(250)  NOT NULL,
  nivel               VARCHAR(20)   NOT NULL
                      CHECK (nivel IN ('especialidad', 'maestria', 'doctorado')),
  modalidad           VARCHAR(20)   NOT NULL DEFAULT 'presencial'
                      CHECK (modalidad IN ('presencial', 'virtual', 'mixta')),
  duracion_semestres  SMALLINT      CHECK (duracion_semestres > 0),
  creditos            SMALLINT      CHECK (creditos > 0),
  descripcion         TEXT,
  objetivo            TEXT,
  perfil_ingreso      TEXT,
  perfil_egreso       TEXT,
  campo_formacion     VARCHAR(120),
  pnpc                BOOLEAN       NOT NULL DEFAULT FALSE,
  pnpc_nivel          VARCHAR(60),   -- 'en desarrollo', 'en consolidación', 'competencia internacional'
  pnpc_clave          VARCHAR(50),
  activo              BOOLEAN       NOT NULL DEFAULT TRUE,
  imagen_id           BIGINT,                          -- FK → archivos (se agrega tras crear esa tabla)
  orden_display       SMALLINT      NOT NULL DEFAULT 0,
  creado_en           TIMESTAMPTZ   NOT NULL DEFAULT NOW(),
  actualizado_en      TIMESTAMPTZ   NOT NULL DEFAULT NOW()
);

SELECT fn_crear_trigger_upd('programas');
CREATE INDEX idx_programas_nivel  ON programas(nivel);
CREATE INDEX idx_programas_activo ON programas(activo);

-- ─────────────────────────────────────────────────────────────
-- TABLA 5: programa_materias  (plan de estudios)
-- ─────────────────────────────────────────────────────────────
CREATE TABLE programa_materias (
  id             BIGSERIAL    PRIMARY KEY,
  programa_id    BIGINT       NOT NULL REFERENCES programas(id) ON DELETE CASCADE,
  semestre       SMALLINT     NOT NULL CHECK (semestre >= 1),
  nombre         VARCHAR(250) NOT NULL,
  clave          VARCHAR(30),
  creditos       SMALLINT,
  horas_teoria   SMALLINT,
  horas_practica SMALLINT,
  tipo           VARCHAR(20)  NOT NULL DEFAULT 'obligatoria'
                 CHECK (tipo IN ('obligatoria', 'optativa', 'optativa_libre')),
  UNIQUE (programa_id, semestre, nombre)
);

CREATE INDEX idx_materias_programa  ON programa_materias(programa_id);
CREATE INDEX idx_materias_semestre  ON programa_materias(programa_id, semestre);


-- =============================================================
-- BLOQUE 3 · PERSONAS (PLANTA DOCENTE)
-- =============================================================

-- ─────────────────────────────────────────────────────────────
-- TABLA 6: profesores
-- ─────────────────────────────────────────────────────────────
CREATE TABLE profesores (
  id                  BIGSERIAL    PRIMARY KEY,
  nombre              VARCHAR(200) NOT NULL,
  grado_academico     VARCHAR(20)  NOT NULL DEFAULT 'doctor'
                      CHECK (grado_academico IN ('licenciado','especialista','maestro','doctor')),
  titulo_cargo        VARCHAR(200),
  especialidad        TEXT,
  email               VARCHAR(180),
  tel_extension       VARCHAR(20),
  perfil_prodep_url   TEXT,
  sni_nivel           VARCHAR(20)
                      CHECK (sni_nivel IN ('candidato','I','II','III','emerito')),
  orcid               VARCHAR(30),           -- p.ej. 0000-0001-2345-6789
  google_scholar_url  TEXT,
  foto_id             BIGINT,                -- FK → archivos
  activo              BOOLEAN      NOT NULL DEFAULT TRUE,
  orden_display       SMALLINT     NOT NULL DEFAULT 0,
  creado_en           TIMESTAMPTZ  NOT NULL DEFAULT NOW(),
  actualizado_en      TIMESTAMPTZ  NOT NULL DEFAULT NOW()
);

SELECT fn_crear_trigger_upd('profesores');
CREATE INDEX idx_profesores_activo ON profesores(activo);
CREATE INDEX idx_profesores_sni    ON profesores(sni_nivel);


-- =============================================================
-- BLOQUE 4 · INVESTIGACIÓN
-- =============================================================

-- ─────────────────────────────────────────────────────────────
-- TABLA 7: cuerpos_academicos
-- ─────────────────────────────────────────────────────────────
CREATE TABLE cuerpos_academicos (
  id             BIGSERIAL    PRIMARY KEY,
  clave_prodep   VARCHAR(30)  NOT NULL UNIQUE,   -- FECA-CA-01
  nombre         VARCHAR(250) NOT NULL,
  consolidacion  VARCHAR(25)  NOT NULL DEFAULT 'en_formacion'
                 CHECK (consolidacion IN ('en_formacion','en_consolidacion','consolidado')),
  descripcion    TEXT,
  activo         BOOLEAN      NOT NULL DEFAULT TRUE,
  creado_en      TIMESTAMPTZ  NOT NULL DEFAULT NOW(),
  actualizado_en TIMESTAMPTZ  NOT NULL DEFAULT NOW()
);

SELECT fn_crear_trigger_upd('cuerpos_academicos');

-- ─────────────────────────────────────────────────────────────
-- TABLA 8: lgac  (Líneas de Generación y Aplicación del Conocimiento)
-- Cada CA tiene entre 2 y 4 líneas de investigación
-- ─────────────────────────────────────────────────────────────
CREATE TABLE lgac (
  id                   BIGSERIAL    PRIMARY KEY,
  cuerpo_academico_id  BIGINT       NOT NULL REFERENCES cuerpos_academicos(id) ON DELETE CASCADE,
  nombre               VARCHAR(300) NOT NULL,
  descripcion          TEXT,
  activa               BOOLEAN      NOT NULL DEFAULT TRUE
);

CREATE INDEX idx_lgac_ca ON lgac(cuerpo_academico_id);

-- ─────────────────────────────────────────────────────────────
-- TABLA 9: ca_miembros  (N:N  profesores ↔ cuerpos_academicos)
-- Un profesor puede pertenecer a varios CA con distintos roles
-- ─────────────────────────────────────────────────────────────
CREATE TABLE ca_miembros (
  id                   BIGSERIAL  PRIMARY KEY,
  cuerpo_academico_id  BIGINT     NOT NULL REFERENCES cuerpos_academicos(id) ON DELETE CASCADE,
  profesor_id          BIGINT     NOT NULL REFERENCES profesores(id) ON DELETE CASCADE,
  rol                  VARCHAR(20) NOT NULL DEFAULT 'integrante'
                       CHECK (rol IN ('responsable','integrante','colaborador')),
  fecha_ingreso        DATE,
  UNIQUE (cuerpo_academico_id, profesor_id)
);

-- ─────────────────────────────────────────────────────────────
-- TABLA 10: grupos_disciplinares
-- ─────────────────────────────────────────────────────────────
CREATE TABLE grupos_disciplinares (
  id                BIGSERIAL    PRIMARY KEY,
  nombre            VARCHAR(250) NOT NULL,
  descripcion       TEXT,
  area_conocimiento VARCHAR(120),
  activo            BOOLEAN      NOT NULL DEFAULT TRUE,
  creado_en         TIMESTAMPTZ  NOT NULL DEFAULT NOW(),
  actualizado_en    TIMESTAMPTZ  NOT NULL DEFAULT NOW()
);

SELECT fn_crear_trigger_upd('grupos_disciplinares');

-- ─────────────────────────────────────────────────────────────
-- TABLA 11: gd_miembros  (N:N  profesores ↔ grupos_disciplinares)
-- ─────────────────────────────────────────────────────────────
CREATE TABLE gd_miembros (
  grupo_id    BIGINT NOT NULL REFERENCES grupos_disciplinares(id) ON DELETE CASCADE,
  profesor_id BIGINT NOT NULL REFERENCES profesores(id) ON DELETE CASCADE,
  PRIMARY KEY (grupo_id, profesor_id)
);


-- =============================================================
-- BLOQUE 5 · ARCHIVOS Y MEDIA  (central de uploads)
-- =============================================================

-- ─────────────────────────────────────────────────────────────
-- TABLA 12: archivos
-- Registro de TODOS los archivos subidos al sistema.
-- El archivo físico vive en /uploads/; aquí solo los metadatos.
-- ─────────────────────────────────────────────────────────────
CREATE TABLE archivos (
  id               BIGSERIAL    PRIMARY KEY,
  ruta_relativa    TEXT         NOT NULL UNIQUE,  -- uploads/20250101_a1b2c3d4.pdf
  nombre_original  VARCHAR(255) NOT NULL,
  mime_type        VARCHAR(120) NOT NULL,
  extension        VARCHAR(20)  NOT NULL,
  tamaño_bytes     BIGINT       NOT NULL CHECK (tamaño_bytes > 0),
  checksum_sha256  CHAR(64),                       -- detecta duplicados
  es_imagen        BOOLEAN      NOT NULL DEFAULT FALSE,
  ancho_px         INT,                            -- solo imágenes
  alto_px          INT,                            -- solo imágenes
  alt_texto        VARCHAR(300),                   -- accesibilidad <img alt>
  subido_por       BIGINT       REFERENCES usuarios(id) ON DELETE SET NULL,
  es_publico       BOOLEAN      NOT NULL DEFAULT TRUE,
  creado_en        TIMESTAMPTZ  NOT NULL DEFAULT NOW()
);

CREATE INDEX idx_archivos_mime     ON archivos(mime_type);
CREATE INDEX idx_archivos_publ     ON archivos(es_publico);
CREATE INDEX idx_archivos_imagen   ON archivos(es_imagen);
CREATE INDEX idx_archivos_checksum ON archivos(checksum_sha256);

-- FK diferidas: ahora que archivos existe las podemos registrar
ALTER TABLE programas  ADD CONSTRAINT fk_prog_imagen FOREIGN KEY (imagen_id) REFERENCES archivos(id) ON DELETE SET NULL;
ALTER TABLE profesores ADD CONSTRAINT fk_prof_foto   FOREIGN KEY (foto_id)   REFERENCES archivos(id) ON DELETE SET NULL;


-- =============================================================
-- BLOQUE 6 · CONTENIDO PUBLICABLE
-- =============================================================

-- ─────────────────────────────────────────────────────────────
-- TABLA 13: publicaciones  (producción académica)
-- ─────────────────────────────────────────────────────────────
CREATE TABLE publicaciones (
  id                BIGSERIAL    PRIMARY KEY,
  tipo              VARCHAR(20)  NOT NULL
                    CHECK (tipo IN ('articulo','capitulo','libro','memoria','reporte','tesis','otro')),
  titulo            VARCHAR(400) NOT NULL,
  autores_texto     TEXT         NOT NULL,  -- "Pérez J., García M., …"
  anio              SMALLINT     NOT NULL CHECK (anio >= 1990 AND anio <= 2100),
  revista_editorial VARCHAR(300),
  volumen_numero    VARCHAR(80),
  paginas           VARCHAR(40),
  doi               VARCHAR(200),
  url_externo       TEXT,
  resumen           TEXT,
  palabras_clave    TEXT[],
  archivo_id        BIGINT       REFERENCES archivos(id) ON DELETE SET NULL,
  es_publicado      BOOLEAN      NOT NULL DEFAULT FALSE,
  creado_en         TIMESTAMPTZ  NOT NULL DEFAULT NOW(),
  actualizado_en    TIMESTAMPTZ  NOT NULL DEFAULT NOW()
);

SELECT fn_crear_trigger_upd('publicaciones');
CREATE INDEX idx_pub_tipo    ON publicaciones(tipo);
CREATE INDEX idx_pub_anio    ON publicaciones(anio DESC);
CREATE INDEX idx_pub_publico ON publicaciones(es_publicado);
CREATE INDEX idx_pub_fts     ON publicaciones
  USING GIN (to_tsvector('spanish', coalesce(titulo,'') || ' ' || coalesce(autores_texto,'') || ' ' || coalesce(resumen,'')));

-- N:N  publicaciones ↔ profesores
CREATE TABLE publicacion_autores (
  publicacion_id  BIGINT    NOT NULL REFERENCES publicaciones(id)  ON DELETE CASCADE,
  profesor_id     BIGINT    NOT NULL REFERENCES profesores(id)     ON DELETE CASCADE,
  orden           SMALLINT  NOT NULL DEFAULT 1 CHECK (orden >= 1),
  PRIMARY KEY (publicacion_id, profesor_id)
);

-- ─────────────────────────────────────────────────────────────
-- TABLA 14: noticias  (blog / eventos / comunicados)
-- ─────────────────────────────────────────────────────────────
CREATE TABLE noticias (
  id                 BIGSERIAL    PRIMARY KEY,
  tipo               VARCHAR(20)  NOT NULL DEFAULT 'noticia'
                     CHECK (tipo IN ('noticia','evento','aviso','comunicado')),
  titulo             VARCHAR(300) NOT NULL,
  slug               VARCHAR(320) NOT NULL UNIQUE,  -- URL amigable
  resumen            TEXT,
  cuerpo             TEXT,
  imagen_portada_id  BIGINT       REFERENCES archivos(id) ON DELETE SET NULL,
  es_destacado       BOOLEAN      NOT NULL DEFAULT FALSE,
  es_publicado       BOOLEAN      NOT NULL DEFAULT FALSE,
  publicado_en       TIMESTAMPTZ,
  fecha_evento       DATE,                             -- solo si tipo = 'evento'
  lugar_evento       VARCHAR(200),
  creado_por         BIGINT       REFERENCES usuarios(id) ON DELETE SET NULL,
  creado_en          TIMESTAMPTZ  NOT NULL DEFAULT NOW(),
  actualizado_en     TIMESTAMPTZ  NOT NULL DEFAULT NOW()
);

SELECT fn_crear_trigger_upd('noticias');
CREATE INDEX idx_noticias_tipo      ON noticias(tipo);
CREATE INDEX idx_noticias_publico   ON noticias(es_publicado);
CREATE INDEX idx_noticias_destacado ON noticias(es_destacado);
CREATE INDEX idx_noticias_slug      ON noticias(slug);
CREATE INDEX idx_noticias_fts       ON noticias
  USING GIN (to_tsvector('spanish',
    coalesce(titulo,'') || ' ' || coalesce(resumen,'') || ' ' || coalesce(cuerpo,'')));

-- ─────────────────────────────────────────────────────────────
-- TABLA 15: convocatorias
-- ─────────────────────────────────────────────────────────────
CREATE TABLE convocatorias (
  id                    BIGSERIAL    PRIMARY KEY,
  programa_id           BIGINT       REFERENCES programas(id) ON DELETE SET NULL,
  titulo                VARCHAR(300) NOT NULL,
  descripcion           TEXT,
  ciclo                 VARCHAR(20),             -- 'A-2025', 'B-2025'
  fecha_inicio          DATE,
  fecha_cierre          DATE,
  fecha_inicio_clases   DATE,
  requisitos            TEXT,
  proceso_seleccion     TEXT,
  archivo_id            BIGINT       REFERENCES archivos(id) ON DELETE SET NULL,
  imagen_poster_id      BIGINT       REFERENCES archivos(id) ON DELETE SET NULL,
  es_publicado          BOOLEAN      NOT NULL DEFAULT FALSE,
  creado_por            BIGINT       REFERENCES usuarios(id) ON DELETE SET NULL,
  creado_en             TIMESTAMPTZ  NOT NULL DEFAULT NOW(),
  actualizado_en        TIMESTAMPTZ  NOT NULL DEFAULT NOW(),
  CONSTRAINT chk_fechas CHECK (
    fecha_cierre IS NULL OR fecha_inicio IS NULL OR fecha_cierre >= fecha_inicio
  )
);

SELECT fn_crear_trigger_upd('convocatorias');
CREATE INDEX idx_conv_programa ON convocatorias(programa_id);
CREATE INDEX idx_conv_publico  ON convocatorias(es_publicado);
CREATE INDEX idx_conv_cierre   ON convocatorias(fecha_cierre);

-- ─────────────────────────────────────────────────────────────
-- TABLA 16: documentos  (recursos descargables para comunidad)
-- ─────────────────────────────────────────────────────────────
CREATE TABLE documentos (
  id             BIGSERIAL    PRIMARY KEY,
  categoria      VARCHAR(40)  NOT NULL
                 CHECK (categoria IN ('reglamento','formato','calendario','plan_estudios',
                                      'guia','plantilla','informe','otro')),
  audiencia      VARCHAR(20)  NOT NULL DEFAULT 'todos'
                 CHECK (audiencia IN ('todos','alumnado','profesorado','administrativo')),
  titulo         VARCHAR(300) NOT NULL,
  descripcion    TEXT,
  archivo_id     BIGINT       REFERENCES archivos(id) ON DELETE SET NULL,
  es_publicado   BOOLEAN      NOT NULL DEFAULT FALSE,
  orden_display  SMALLINT     NOT NULL DEFAULT 0,
  creado_en      TIMESTAMPTZ  NOT NULL DEFAULT NOW(),
  actualizado_en TIMESTAMPTZ  NOT NULL DEFAULT NOW()
);

SELECT fn_crear_trigger_upd('documentos');
CREATE INDEX idx_docs_categoria ON documentos(categoria);
CREATE INDEX idx_docs_audiencia ON documentos(audiencia);
CREATE INDEX idx_docs_publico   ON documentos(es_publicado);


-- =============================================================
-- BLOQUE 7 · INTERACCIÓN CON EL PÚBLICO
-- =============================================================

-- ─────────────────────────────────────────────────────────────
-- TABLA 17: mensajes_contacto
-- Formulario de contacto público → llega aquí
-- ─────────────────────────────────────────────────────────────
CREATE TABLE mensajes_contacto (
  id               BIGSERIAL    PRIMARY KEY,
  nombre           VARCHAR(200) NOT NULL,
  email            VARCHAR(180) NOT NULL,
  asunto           VARCHAR(100) NOT NULL,
  programa_interes VARCHAR(10),              -- código de programa (p.ej. 'ME')
  mensaje          TEXT         NOT NULL,
  ip_origen        INET,
  leido            BOOLEAN      NOT NULL DEFAULT FALSE,
  respondido       BOOLEAN      NOT NULL DEFAULT FALSE,
  respondido_en    TIMESTAMPTZ,
  respondido_por   BIGINT       REFERENCES usuarios(id) ON DELETE SET NULL,
  creado_en        TIMESTAMPTZ  NOT NULL DEFAULT NOW()
);

CREATE INDEX idx_contacto_leido   ON mensajes_contacto(leido);
CREATE INDEX idx_contacto_creado  ON mensajes_contacto(creado_en DESC);


-- =============================================================
-- BLOQUE 8 · TAXONOMÍA (etiquetas)
-- =============================================================

-- ─────────────────────────────────────────────────────────────
-- TABLA 18: etiquetas
-- ─────────────────────────────────────────────────────────────
CREATE TABLE etiquetas (
  id     BIGSERIAL   PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL UNIQUE,
  slug   VARCHAR(80) NOT NULL UNIQUE
);

-- N:N  etiquetas ↔ noticias
CREATE TABLE etiqueta_noticia (
  noticia_id  BIGINT NOT NULL REFERENCES noticias(id)   ON DELETE CASCADE,
  etiqueta_id BIGINT NOT NULL REFERENCES etiquetas(id)  ON DELETE CASCADE,
  PRIMARY KEY (noticia_id, etiqueta_id)
);

-- N:N  etiquetas ↔ publicaciones
CREATE TABLE etiqueta_publicacion (
  publicacion_id BIGINT NOT NULL REFERENCES publicaciones(id) ON DELETE CASCADE,
  etiqueta_id    BIGINT NOT NULL REFERENCES etiquetas(id)     ON DELETE CASCADE,
  PRIMARY KEY (publicacion_id, etiqueta_id)
);


-- =============================================================
-- BLOQUE 9 · TRAZABILIDAD
-- =============================================================

-- ─────────────────────────────────────────────────────────────
-- TABLA 19: audit_log
-- Registra quién cambió qué y cuándo. JSONB guarda el estado
-- antes/después de cada fila modificada.
-- ─────────────────────────────────────────────────────────────
CREATE TABLE audit_log (
  id          BIGSERIAL   PRIMARY KEY,
  usuario_id  BIGINT      REFERENCES usuarios(id) ON DELETE SET NULL,
  tabla       VARCHAR(60) NOT NULL,
  registro_id BIGINT      NOT NULL,
  accion      VARCHAR(6)  NOT NULL CHECK (accion IN ('INSERT','UPDATE','DELETE')),
  datos_antes JSONB,
  datos_des   JSONB,
  ip          INET,
  creado_en   TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE INDEX idx_audit_tabla   ON audit_log(tabla, registro_id);
CREATE INDEX idx_audit_usuario ON audit_log(usuario_id);
CREATE INDEX idx_audit_creado  ON audit_log(creado_en DESC);
CREATE INDEX idx_audit_datos   ON audit_log USING GIN (datos_des);


-- =============================================================
-- VISTA DE COMPATIBILIDAD
-- El código PHP anterior usa fetch_public_content() que buscaba
-- en content_items. Esta vista evita reescribir ese código.
-- =============================================================
CREATE OR REPLACE VIEW content_items AS
  -- Noticias
  SELECT
    n.id,
    n.tipo                                          AS content_type,
    n.titulo                                        AS title,
    n.resumen                                       AS description,
    a.ruta_relativa                                 AS file_path,
    a.nombre_original                               AS original_filename,
    a.mime_type,
    a.tamaño_bytes                                  AS file_size,
    n.es_publicado                                  AS is_published,
    n.creado_en                                     AS created_at
  FROM noticias n
  LEFT JOIN archivos a ON a.id = n.imagen_portada_id

UNION ALL
  -- Convocatorias
  SELECT
    c.id,
    'convocatoria',
    c.titulo, c.descripcion,
    af.ruta_relativa, af.nombre_original, af.mime_type, af.tamaño_bytes,
    c.es_publicado, c.creado_en
  FROM convocatorias c
  LEFT JOIN archivos af ON af.id = c.archivo_id

UNION ALL
  -- Publicaciones
  SELECT
    p.id,
    'publicacion',
    p.titulo, p.resumen,
    ap.ruta_relativa, ap.nombre_original, ap.mime_type, ap.tamaño_bytes,
    p.es_publicado, p.creado_en
  FROM publicaciones p
  LEFT JOIN archivos ap ON ap.id = p.archivo_id

UNION ALL
  -- Documentos
  SELECT
    d.id,
    'documento',
    d.titulo, d.descripcion,
    ad.ruta_relativa, ad.nombre_original, ad.mime_type, ad.tamaño_bytes,
    d.es_publicado, d.creado_en
  FROM documentos d
  LEFT JOIN archivos ad ON ad.id = d.archivo_id;


-- =============================================================
-- DATOS INICIALES: catálogos base
-- =============================================================

-- Programas de la División
INSERT INTO programas (codigo, nombre, nivel, duracion_semestres, creditos, pnpc, pnpc_nivel, activo, orden_display) VALUES
  ('DGO', 'Doctorado en Gestión de las Organizaciones',   'doctorado',    8, 200, false, NULL,                  true, 10),
  ('ME',  'Maestría en Economía',                         'maestria',     4, 120, true,  'en consolidación',    true, 20),
  ('MAG', 'Maestría en Auditoría Gubernamental',          'maestria',     4, 108, false, NULL,                  true, 30),
  ('MEC', 'Maestría en Estrategias Contables',            'maestria',     4, 108, false, NULL,                  true, 40),
  ('MGN', 'Maestría en Gestión de Negocios',              'maestria',     4, 108, false, NULL,                  true, 50),
  ('MGP', 'Maestría en Gestión Pública',                  'maestria',     4, 108, false, NULL,                  true, 60),
  ('MM',  'Maestría en Mercadotecnia',                    'maestria',     4, 108, false, NULL,                  true, 70),
  ('EAH', 'Especialidad en Administración de Hospitales', 'especialidad', 2,  60, false, NULL,                  true, 80);

-- Cuerpos académicos base
INSERT INTO cuerpos_academicos (clave_prodep, nombre, consolidacion) VALUES
  ('FECA-CA-01', 'Gestión Organizacional y Administración Pública', 'consolidado'),
  ('FECA-CA-02', 'Economía Regional y Desarrollo Sustentable',      'en_consolidacion'),
  ('FECA-CA-03', 'Contabilidad, Auditoría y Finanzas Públicas',     'en_formacion');

-- LGAC del CA-01
INSERT INTO lgac (cuerpo_academico_id, nombre) VALUES
  (1, 'Gestión de las organizaciones públicas y privadas'),
  (1, 'Administración pública, transparencia y rendición de cuentas'),
  (1, 'Capital humano y desempeño organizacional');

-- LGAC del CA-02
INSERT INTO lgac (cuerpo_academico_id, nombre) VALUES
  (2, 'Política fiscal y crecimiento económico regional'),
  (2, 'Mercados financieros y microeconomía aplicada'),
  (2, 'Desarrollo sustentable y economía ambiental');

-- LGAC del CA-03
INSERT INTO lgac (cuerpo_academico_id, nombre) VALUES
  (3, 'Modelos de auditoría gubernamental y fiscal'),
  (3, 'Información contable y toma de decisiones'),
  (3, 'Estrategias financieras en el sector público');

-- Grupos disciplinares base
INSERT INTO grupos_disciplinares (nombre, area_conocimiento) VALUES
  ('Mercadotecnia y Comportamiento del Consumidor', 'Administración'),
  ('Finanzas Corporativas e Inversión',             'Finanzas'),
  ('Políticas Públicas y Administración Local',     'Administración Pública'),
  ('Contabilidad Social y Responsabilidad Empresarial', 'Contabilidad');

-- Etiquetas base
INSERT INTO etiquetas (nombre, slug) VALUES
  ('Convocatoria',  'convocatoria'),
  ('PNPC',          'pnpc'),
  ('Investigación', 'investigacion'),
  ('Titulación',    'titulacion'),
  ('Evento',        'evento'),
  ('Beca',          'beca'),
  ('Egresados',     'egresados');

-- =============================================================
-- NOTA IMPORTANTE: El primer usuario administrador NO se crea aquí.
-- Ejecuta este comando desde la terminal para crearlo de forma segura:
--
--   php php/tools/setup_admin.php
--
-- Ese script pide usuario, email y contraseña de forma interactiva
-- y guarda el hash Argon2id. NUNCA escribas contraseñas en este archivo.
-- =============================================================
