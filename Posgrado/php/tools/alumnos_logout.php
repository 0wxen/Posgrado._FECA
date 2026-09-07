<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/alumnos.php';

cerrar_sesion_alumno();
header('Location: /html/htmlcode.html#alumnos');
exit;
