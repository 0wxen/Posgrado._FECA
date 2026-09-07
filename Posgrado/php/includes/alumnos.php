<?php
declare(strict_types=1);

// acceso del área de Alumnos: una sola clave compartida (ALUMNOS_PASSWORD),
// no cuentas por alumno -- a propósito, para no meter una tabla ni sesiones
// por usuario que carguen la base de datos por algo que solo necesita
// mantener afuera al público casual, no autenticar personas una por una.

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'cookie_secure'   => getenv('APP_ENV') === 'production',
        'use_strict_mode' => true,
        'gc_maxlifetime'  => 7200,
    ]);
}

function alumno_autenticado(): bool {
    return !empty($_SESSION['alumno_ok']);
}

function alumnos_clave_configurada(): bool {
    return (getenv('ALUMNOS_PASSWORD') ?: '') !== '';
}

function intentar_acceso_alumno(string $clave): bool {
    $esperada = getenv('ALUMNOS_PASSWORD') ?: '';
    if ($esperada === '' || $clave === '' || !hash_equals($esperada, $clave)) {
        usleep(random_int(200_000, 400_000)); // igual que el login del panel: no revelar por tiempo de respuesta
        return false;
    }
    $_SESSION['alumno_ok'] = true;
    return true;
}

function cerrar_sesion_alumno(): void {
    unset($_SESSION['alumno_ok']);
}

// Lista blanca de documentos descargables del área de Alumnos: la única
// forma de bajar un archivo de aquí es pedirlo por esta clave, nunca por
// su ruta real -- así no importa que alguien adivine dónde vive el archivo
// en el servidor, igual necesita haber pasado por la clave de acceso.
const ALUMNOS_DOCUMENTOS = [
    'asignacion_director_procedimiento' => [
        'ruta' => 'alumnos/asignacion-director/Procedimiento-Asignacion-Director-Tesis.docx',
        'nombre' => 'Procedimiento - Asignación de Director de Tesis.docx',
    ],
    'asignacion_director_carta' => [
        'ruta' => 'alumnos/asignacion-director/Carta-Compromiso-Director.docx',
        'nombre' => 'Carta Compromiso del Director.docx',
    ],
    'baja_solicitud_definitiva' => [
        'ruta' => 'alumnos/baja-alumno/Solicitud-Baja-Definitiva.docx',
        'nombre' => 'Solicitud de Baja Definitiva.docx',
    ],
    'baja_solicitud_temporal' => [
        'ruta' => 'alumnos/baja-alumno/Solicitud-Baja-Temporal.docx',
        'nombre' => 'Solicitud de Baja Temporal.docx',
    ],
    'titulacion_certificacion_procedimiento' => [
        'ruta' => 'alumnos/titulacion-certificacion/Procedimiento-Titulacion-Certificacion.docx',
        'nombre' => 'Procedimiento - Titulación por Certificación.docx',
    ],
    'titulacion_tt_procedimiento' => [
        'ruta' => 'alumnos/titulacion-trabajo-terminal/Procedimiento-Titulacion-Trabajo-Terminal.docx',
        'nombre' => 'Procedimiento - Titulación por Trabajo Terminal.docx',
    ],
    'titulacion_tt_carta' => [
        'ruta' => 'alumnos/titulacion-trabajo-terminal/Carta-Compromiso-Director.docx',
        'nombre' => 'Carta Compromiso del Director.docx',
    ],
    'titulacion_tt_consentimiento' => [
        'ruta' => 'alumnos/titulacion-trabajo-terminal/Consentimiento-Publicacion.docx',
        'nombre' => 'Consentimiento de Publicación.docx',
    ],
    'titulacion_tt_oficio' => [
        'ruta' => 'alumnos/titulacion-trabajo-terminal/Oficio-Liberacion-Trabajo-Terminal.docx',
        'nombre' => 'Oficio de Liberación de Trabajo Terminal.docx',
    ],
    'titulacion_tt_portada' => [
        'ruta' => 'alumnos/titulacion-trabajo-terminal/Portada-Lineamientos-Entrega.docx',
        'nombre' => 'Portada y Lineamientos de Entrega.docx',
    ],
    'manual_completo' => [
        'ruta' => 'alumnos/Manual-Procedimientos-DEP-Completo.docx',
        'nombre' => 'Manual de Procedimientos DEP (los 12 procesos).docx',
    ],
];
