BEGIN;

CREATE TABLE IF NOT EXISTS carreras (
    id_carrera SERIAL PRIMARY KEY,
    nombre_carrera VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS alumnos (
    id_alumno SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    edad INT,
    id_carrera INT,
    FOREIGN KEY (id_carrera)
        REFERENCES carreras(id_carrera)
);

CREATE TABLE IF NOT EXISTS profesores (
    id_profesor SERIAL PRIMARY KEY,
    nombre_profesor VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS materias (
    id_materia SERIAL PRIMARY KEY,
    nombre_materia VARCHAR(100) NOT NULL,
    creditos INT,
    id_profesor INT,
    FOREIGN KEY (id_profesor)
        REFERENCES profesores(id_profesor)
);

CREATE TABLE IF NOT EXISTS calificaciones (
    id_calificacion SERIAL PRIMARY KEY,
    id_alumno INT NOT NULL,
    id_materia INT NOT NULL,
    calificacion INT,
    FOREIGN KEY (id_alumno)
        REFERENCES alumnos(id_alumno),
    FOREIGN KEY (id_materia)
        REFERENCES materias(id_materia)
);

CREATE OR REPLACE VIEW carrera AS
SELECT id_carrera, nombre_carrera
FROM carreras;

INSERT INTO carreras (id_carrera, nombre_carrera)
VALUES
(1, 'Tecnologías de la Información'),
(2, 'Mecatrónica'),
(3, 'Administración'),
(4, 'Diseño Digital'),
(5, 'Contabilidad')
ON CONFLICT (id_carrera) DO UPDATE
SET nombre_carrera = EXCLUDED.nombre_carrera;

INSERT INTO profesores (id_profesor, nombre_profesor)
VALUES
(1, 'Juan Hernández'),
(2, 'Laura García'),
(3, 'Miguel Torres'),
(4, 'Patricia Ruiz')
ON CONFLICT (id_profesor) DO UPDATE
SET nombre_profesor = EXCLUDED.nombre_profesor;

INSERT INTO materias (id_materia, nombre_materia, creditos, id_profesor)
VALUES
(1, 'Bases de Datos', 6, 1),
(2, 'Programación', 7, 1),
(3, 'Estadística', 5, 2),
(4, 'Inglés', 4, 2),
(5, 'Redes', 6, 3),
(6, 'Administración de Proyectos', 5, 4),
(7, 'Contabilidad Básica', 6, 4)
ON CONFLICT (id_materia) DO UPDATE
SET nombre_materia = EXCLUDED.nombre_materia,
    creditos = EXCLUDED.creditos,
    id_profesor = EXCLUDED.id_profesor;

INSERT INTO alumnos (id_alumno, nombre, edad, id_carrera)
VALUES
(1, 'Ana López', 20, 1),
(2, 'Carlos Pérez', 21, 1),
(3, 'María Gómez', 22, 2),
(4, 'Luis Torres', 19, 3),
(5, 'Sofía Ramírez', 20, NULL),
(6, 'Pedro Martínez', 23, 4),
(7, 'Fernanda Silva', 20, 1),
(8, 'Jorge Díaz', 22, 2),
(9, 'Alejandra Castro', 21, 3),
(10, 'Ricardo Vargas', 24, 5)
ON CONFLICT (id_alumno) DO UPDATE
SET nombre = EXCLUDED.nombre,
    edad = EXCLUDED.edad,
    id_carrera = EXCLUDED.id_carrera;

INSERT INTO calificaciones (id_calificacion, id_alumno, id_materia, calificacion)
VALUES
(1, 1, 1, 95),
(2, 1, 2, 90),
(3, 1, 3, 88),
(4, 2, 1, 70),
(5, 2, 2, 75),
(6, 2, 5, 80),
(7, 3, 3, 85),
(8, 3, 4, 92),
(9, 3, 5, 87),
(10, 4, 4, 60),
(11, 4, 6, 72),
(12, 6, 1, 80),
(13, 6, 5, 85),
(14, 7, 1, 98),
(15, 7, 2, 95),
(16, 7, 3, 96),
(17, 8, 3, 78),
(18, 8, 4, 82),
(19, 8, 5, 75),
(20, 9, 6, 88),
(21, 9, 7, 91),
(22, 10, 7, 93)
ON CONFLICT (id_calificacion) DO UPDATE
SET id_alumno = EXCLUDED.id_alumno,
    id_materia = EXCLUDED.id_materia,
    calificacion = EXCLUDED.calificacion;

SELECT setval(pg_get_serial_sequence('carreras', 'id_carrera'), (SELECT MAX(id_carrera) FROM carreras));
SELECT setval(pg_get_serial_sequence('profesores', 'id_profesor'), (SELECT MAX(id_profesor) FROM profesores));
SELECT setval(pg_get_serial_sequence('materias', 'id_materia'), (SELECT MAX(id_materia) FROM materias));
SELECT setval(pg_get_serial_sequence('alumnos', 'id_alumno'), (SELECT MAX(id_alumno) FROM alumnos));
SELECT setval(pg_get_serial_sequence('calificaciones', 'id_calificacion'), (SELECT MAX(id_calificacion) FROM calificaciones));

COMMIT;
