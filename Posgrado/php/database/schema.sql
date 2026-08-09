CREATE OR REPLACE FUNCTION set_actualizado_en()
RETURNS TRIGGER AS $$
BEGIN
    NEW.actualizado_en = NOW();
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TABLE usuarios (
    id              SERIAL PRIMARY KEY,
    nombre_completo VARCHAR(150) NOT NULL,
    nombre_usuario  VARCHAR(50)  UNIQUE NOT NULL,
    contrasena_hash VARCHAR(255) NOT NULL,
    rol             VARCHAR(30)  NOT NULL DEFAULT 'administrador'
                    CHECK (rol IN ('control_maestro', 'administrador')),
    activo          BOOLEAN      NOT NULL DEFAULT TRUE,
    creado_en       TIMESTAMP    NOT NULL DEFAULT NOW(),
    actualizado_en  TIMESTAMP    NOT NULL DEFAULT NOW()
);
CREATE TRIGGER trg_usuarios_actualizado
    BEFORE UPDATE ON usuarios
    FOR EACH ROW EXECUTE FUNCTION set_actualizado_en();

CREATE TABLE archivos (
    id              SERIAL PRIMARY KEY,
    nombre_original VARCHAR(255) NOT NULL,
    ruta_relativa   VARCHAR(500) NOT NULL,
    tipo_mime       VARCHAR(100) NOT NULL,
    extension       VARCHAR(10),
    tamano_bytes    BIGINT,
    es_imagen       BOOLEAN NOT NULL DEFAULT FALSE,
    ancho_px        INT,
    alto_px         INT,
    alt_texto       VARCHAR(255),
    subido_por      INT REFERENCES usuarios(id) ON DELETE SET NULL,
    es_publico      BOOLEAN NOT NULL DEFAULT TRUE,
    creado_en       TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE INDEX idx_archivos_subido_por ON archivos(subido_por);

CREATE TABLE imagenes_sitio (
    clave           VARCHAR(40) PRIMARY KEY,
    etiqueta        VARCHAR(120) NOT NULL,
    imagen_id       INT REFERENCES archivos(id) ON DELETE SET NULL,
    actualizado_en  TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE INDEX idx_imagenes_sitio_imagen_id ON imagenes_sitio(imagen_id);
CREATE TRIGGER trg_imagenes_sitio_actualizado
    BEFORE UPDATE ON imagenes_sitio
    FOR EACH ROW EXECUTE FUNCTION set_actualizado_en();

INSERT INTO imagenes_sitio (clave, etiqueta) VALUES
    ('galeria_1',   'Inicio · Galería, imagen 1'),
    ('galeria_2',   'Inicio · Galería, imagen 2'),
    ('galeria_3',   'Inicio · Galería, imagen 3'),
    ('galeria_4',   'Inicio · Galería, imagen 4'),
    ('galeria_5',   'Inicio · Galería, imagen 5'),
    ('organigrama', 'Nosotros · Organigrama');

CREATE TABLE profesores (
    id                  SERIAL PRIMARY KEY,
    nombre              VARCHAR(200) NOT NULL,
    grado_academico     VARCHAR(100),
    titulo_cargo        VARCHAR(150),
    especialidad        VARCHAR(200),
    email               VARCHAR(150),
    telefono_extension  VARCHAR(50),
    orcid               VARCHAR(50),
    google_scholar_url  VARCHAR(300),
    foto_id             INT REFERENCES archivos(id) ON DELETE SET NULL,
    activo              BOOLEAN NOT NULL DEFAULT TRUE,
    orden_display       INT DEFAULT 0,
    creado_en           TIMESTAMP NOT NULL DEFAULT NOW(),
    actualizado_en      TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE INDEX idx_profesores_foto_id ON profesores(foto_id);
CREATE TRIGGER trg_profesores_actualizado
    BEFORE UPDATE ON profesores
    FOR EACH ROW EXECUTE FUNCTION set_actualizado_en();

CREATE TABLE mensajes_institucionales (
    clave           VARCHAR(40) PRIMARY KEY,
    cargo           VARCHAR(100) NOT NULL,
    nombre          VARCHAR(200) NOT NULL,
    mensaje         TEXT,
    foto_id         INT REFERENCES archivos(id) ON DELETE SET NULL,
    orden_display   INT DEFAULT 0,
    actualizado_en  TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE INDEX idx_mensajes_institucionales_foto_id ON mensajes_institucionales(foto_id);
CREATE TRIGGER trg_mensajes_institucionales_actualizado
    BEFORE UPDATE ON mensajes_institucionales
    FOR EACH ROW EXECUTE FUNCTION set_actualizado_en();

INSERT INTO mensajes_institucionales (clave, cargo, nombre, mensaje, orden_display) VALUES
    ('director', 'Director', 'Dr. Jesús Guillermo Sotelo Asef',
     'Es un honor darles la bienvenida a la División de Estudios de Posgrado de la Facultad de Economía, Contaduría y Administración de la Universidad Juárez del Estado de Durango. En esta División hemos asumido el compromiso de formar profesionales de alto nivel académico, con una sólida base investigativa y un profundo compromiso con el desarrollo de nuestra región y del país.

Nuestros programas están diseñados para responder a los retos actuales del entorno económico, administrativo y social, ofreciendo a nuestros estudiantes las herramientas necesarias para convertirse en agentes de cambio y líderes en sus respectivas áreas de conocimiento. Los invitamos a ser parte de esta gran familia académica.', 10),
    ('jefe', 'Jefe de Posgrado', 'Dr. Eliú J. Reyes Reyes',
     'La División de Estudios de Posgrado de la FECA UJED es un espacio de crecimiento académico, personal y profesional donde la excelencia, el rigor investigativo y la innovación son el motor de nuestro quehacer cotidiano.

Contamos con un equipo de docentes altamente calificados, comprometidos con la generación y aplicación del conocimiento, así como con programas reconocidos a nivel nacional por el Sistema Nacional de Posgrados (SNP) del CONAHCYT. Los invitamos a descubrir la herramienta para el futuro que tú deseas.', 20);

CREATE TABLE programas (
    id                  SERIAL PRIMARY KEY,
    codigo              VARCHAR(20) UNIQUE,
    nombre              VARCHAR(200) NOT NULL,
    nivel               VARCHAR(50),
    modalidad           VARCHAR(50),
    duracion_semestres  INT,
    creditos            INT,
    descripcion         TEXT,
    objetivo            TEXT,
    perfil_ingreso      TEXT,
    perfil_egreso       TEXT,
    campo_formacion     VARCHAR(150),
    acreditacion        VARCHAR(150),
    admision_nota       VARCHAR(300),
    activo              BOOLEAN NOT NULL DEFAULT TRUE,
    imagen_id           INT REFERENCES archivos(id) ON DELETE SET NULL,
    orden_display       INT DEFAULT 0,
    creado_en           TIMESTAMP NOT NULL DEFAULT NOW(),
    actualizado_en      TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE INDEX idx_programas_imagen_id ON programas(imagen_id);
CREATE TRIGGER trg_programas_actualizado
    BEFORE UPDATE ON programas
    FOR EACH ROW EXECUTE FUNCTION set_actualizado_en();

CREATE TABLE programa_titulacion (
    id              SERIAL PRIMARY KEY,
    programa_id     INT NOT NULL REFERENCES programas(id) ON DELETE CASCADE,
    icono           VARCHAR(50) NOT NULL DEFAULT 'ti-file-text',
    titulo          VARCHAR(150) NOT NULL,
    descripcion     TEXT,
    orden_display   INT DEFAULT 0,
    creado_en       TIMESTAMP NOT NULL DEFAULT NOW(),
    actualizado_en  TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE INDEX idx_programa_titulacion_programa_id ON programa_titulacion(programa_id);
CREATE TRIGGER trg_programa_titulacion_actualizado
    BEFORE UPDATE ON programa_titulacion
    FOR EACH ROW EXECUTE FUNCTION set_actualizado_en();

CREATE TABLE programa_campo_laboral (
    id              SERIAL PRIMARY KEY,
    programa_id     INT NOT NULL REFERENCES programas(id) ON DELETE CASCADE,
    icono           VARCHAR(50) NOT NULL DEFAULT 'ti-briefcase',
    titulo          VARCHAR(150) NOT NULL,
    descripcion     TEXT,
    orden_display   INT DEFAULT 0,
    creado_en       TIMESTAMP NOT NULL DEFAULT NOW(),
    actualizado_en  TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE INDEX idx_programa_campo_laboral_programa_id ON programa_campo_laboral(programa_id);
CREATE TRIGGER trg_programa_campo_laboral_actualizado
    BEFORE UPDATE ON programa_campo_laboral
    FOR EACH ROW EXECUTE FUNCTION set_actualizado_en();

CREATE TABLE convocatorias (
    id                  SERIAL PRIMARY KEY,
    programa_id         INT REFERENCES programas(id) ON DELETE RESTRICT,
    titulo              VARCHAR(200) NOT NULL,
    descripcion         TEXT,
    ciclo               VARCHAR(50),
    fecha_inicio        DATE,
    fecha_cierre        DATE,
    requisitos          TEXT,
    proceso_seleccion   TEXT,
    archivo_id          INT REFERENCES archivos(id) ON DELETE SET NULL,
    imagen_id           INT REFERENCES archivos(id) ON DELETE SET NULL,
    es_publicado        BOOLEAN NOT NULL DEFAULT FALSE,
    destacado           BOOLEAN NOT NULL DEFAULT FALSE,
    creado_por          INT REFERENCES usuarios(id) ON DELETE SET NULL,
    creado_en           TIMESTAMP NOT NULL DEFAULT NOW(),
    actualizado_en      TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE INDEX idx_convocatorias_programa_id ON convocatorias(programa_id);
CREATE INDEX idx_convocatorias_archivo_id ON convocatorias(archivo_id);
CREATE INDEX idx_convocatorias_imagen_id ON convocatorias(imagen_id);
CREATE INDEX idx_convocatorias_creado_por ON convocatorias(creado_por);
CREATE TRIGGER trg_convocatorias_actualizado
    BEFORE UPDATE ON convocatorias
    FOR EACH ROW EXECUTE FUNCTION set_actualizado_en();

CREATE TABLE blog (
    id                  SERIAL PRIMARY KEY,
    titulo              VARCHAR(200) NOT NULL,
    slug                VARCHAR(220) UNIQUE NOT NULL,
    resumen             TEXT,
    cuerpo              TEXT,
    imagen_id           INT REFERENCES archivos(id) ON DELETE SET NULL,
    fecha_evento        DATE,
    lugar_evento        VARCHAR(200),
    autor_profesor_id   INT REFERENCES profesores(id) ON DELETE SET NULL,
    destacado           BOOLEAN NOT NULL DEFAULT FALSE,
    es_publicado        BOOLEAN NOT NULL DEFAULT FALSE,
    publicado_en        TIMESTAMP,
    creado_por          INT REFERENCES usuarios(id) ON DELETE SET NULL,
    creado_en           TIMESTAMP NOT NULL DEFAULT NOW(),
    actualizado_en      TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE INDEX idx_blog_imagen_id ON blog(imagen_id);
CREATE INDEX idx_blog_autor_profesor_id ON blog(autor_profesor_id);
CREATE INDEX idx_blog_creado_por ON blog(creado_por);
CREATE TRIGGER trg_blog_actualizado
    BEFORE UPDATE ON blog
    FOR EACH ROW EXECUTE FUNCTION set_actualizado_en();

CREATE TABLE publicaciones (
    id                  SERIAL PRIMARY KEY,
    tipo                VARCHAR(50),
    titulo              VARCHAR(300) NOT NULL,
    autores_texto       TEXT NOT NULL,
    anio                INT,
    revista_editorial   VARCHAR(200),
    volumen_numero      VARCHAR(50),
    paginas             VARCHAR(50),
    doi                 VARCHAR(100),
    url_externo         VARCHAR(500),
    resumen             TEXT,
    archivo_id          INT REFERENCES archivos(id) ON DELETE SET NULL,
    es_publicado        BOOLEAN NOT NULL DEFAULT TRUE,
    creado_en           TIMESTAMP NOT NULL DEFAULT NOW(),
    actualizado_en      TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE INDEX idx_publicaciones_archivo_id ON publicaciones(archivo_id);
CREATE TRIGGER trg_publicaciones_actualizado
    BEFORE UPDATE ON publicaciones
    FOR EACH ROW EXECUTE FUNCTION set_actualizado_en();

CREATE TABLE grupos_disciplinares (
    id                  SERIAL PRIMARY KEY,
    nombre              VARCHAR(200) NOT NULL,
    descripcion         TEXT,
    area_conocimiento   VARCHAR(150),
    activo              BOOLEAN NOT NULL DEFAULT TRUE,
    creado_en           TIMESTAMP NOT NULL DEFAULT NOW(),
    actualizado_en      TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE TRIGGER trg_grupos_disciplinares_actualizado
    BEFORE UPDATE ON grupos_disciplinares
    FOR EACH ROW EXECUTE FUNCTION set_actualizado_en();

CREATE TABLE documentos (
    id              SERIAL PRIMARY KEY,
    categoria       VARCHAR(100),
    audiencia       VARCHAR(100),
    titulo          VARCHAR(200) NOT NULL,
    descripcion     TEXT,
    archivo_id      INT NOT NULL REFERENCES archivos(id) ON DELETE RESTRICT,
    es_publicado    BOOLEAN NOT NULL DEFAULT TRUE,
    orden_display   INT DEFAULT 0,
    creado_en       TIMESTAMP NOT NULL DEFAULT NOW(),
    actualizado_en  TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE INDEX idx_documentos_archivo_id ON documentos(archivo_id);
CREATE TRIGGER trg_documentos_actualizado
    BEFORE UPDATE ON documentos
    FOR EACH ROW EXECUTE FUNCTION set_actualizado_en();

CREATE TABLE preguntas_frecuentes (
    id              SERIAL PRIMARY KEY,
    pregunta        VARCHAR(300) NOT NULL,
    respuesta       TEXT NOT NULL,
    orden_display   INT DEFAULT 0,
    activo          BOOLEAN NOT NULL DEFAULT TRUE,
    creado_en       TIMESTAMP NOT NULL DEFAULT NOW(),
    actualizado_en  TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE TRIGGER trg_preguntas_frecuentes_actualizado
    BEFORE UPDATE ON preguntas_frecuentes
    FOR EACH ROW EXECUTE FUNCTION set_actualizado_en();

INSERT INTO preguntas_frecuentes (pregunta, respuesta, orden_display) VALUES
    ('¿Cómo consulto mis calificaciones e historial académico?', 'A través del Sistema Único de Monitoreo Académico (SUMA), disponible desde el encabezado del sitio o en sumafeca.ujed.mx.', 10),
    ('¿Dónde descargo los formatos y guías de trámites?', 'En las pestañas Alumnado y Profesorado de la sección de Comunidad encontrarás los formatos, guías y plantillas vigentes.', 20),
    ('¿Cuáles son las modalidades de titulación disponibles?', 'La División ofrece titulación por Certificación y por Trabajo Terminal. Ambas guías están disponibles en la pestaña Alumnado.', 30),
    ('¿Cómo funciona el proceso de tutorías?', 'Consulta el detalle en Procesos Académicos, donde también podrás descargar el formato correspondiente.', 40),
    ('¿A quién contacto si tengo dudas sobre mi programa?', 'Puedes comunicarte directamente con la Coordinación Académica de tu programa desde la sección de Contacto.', 50);

