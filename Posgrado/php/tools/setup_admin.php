<?php
declare(strict_types=1);

// crea usuarios del panel -- única forma, a propósito (sin registro público)
// uso:  C:\xampp\php\php.exe php/tools/setup_admin.php  (solo CLI)

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Este script solo se ejecuta desde la línea de comandos.\n");
}

require_once __DIR__ . '/../config/database.php';

echo "\n";
echo "╔══════════════════════════════════════════════════════╗\n";
echo "║   Crear usuario del panel · DEP FECA UJED            ║\n";
echo "╚══════════════════════════════════════════════════════╝\n\n";

function leer(string $pregunta, bool $ocultar = false): string {
    echo $pregunta;
    if ($ocultar && PHP_OS_FAMILY !== 'Windows') {
        system('stty -echo');
        $valor = trim(fgets(STDIN));
        system('stty echo');
        echo "\n";
    } else {
        $valor = trim(fgets(STDIN));
    }
    return $valor;
}

$username = leer('Usuario           : ');
$nombre   = leer('Nombre completo   : ');
$rolInput = leer('Rol (1 = control_maestro, 2 = administrador) [1]: ');
$password = leer('Contraseña (mín. 12 caracteres): ', true);
$confirma = leer('Confirmar contraseña            : ', true);

echo "\n";

$rol = ($rolInput === '2') ? 'administrador' : 'control_maestro';

// Validaciones básicas
$errores = [];

if (strlen($username) < 3) {
    $errores[] = 'El usuario debe tener al menos 3 caracteres.';
}
if (strlen($nombre) < 4) {
    $errores[] = 'Escribe el nombre completo.';
}
if (strlen($password) < 12) {
    $errores[] = 'La contraseña debe tener al menos 12 caracteres.';
}
if ($password !== $confirma) {
    $errores[] = 'Las contraseñas no coinciden.';
}

if (!empty($errores)) {
    echo "✗ Errores encontrados:\n";
    foreach ($errores as $e) {
        echo "  - $e\n";
    }
    exit(1);
}

// Guardar en BD con Argon2id
$hash = password_hash($password, PASSWORD_ARGON2ID);

try {
    $stmt = $pdo->prepare(
        'INSERT INTO usuarios (nombre_usuario, contrasena_hash, nombre_completo, rol)
         VALUES (?, ?, ?, ?)
         ON CONFLICT (nombre_usuario) DO NOTHING
         RETURNING id, nombre_usuario'
    );
    $stmt->execute([$username, $hash, $nombre, $rol]);
    $result = $stmt->fetch();

    if ($result) {
        echo "✓ Usuario creado exitosamente.\n";
        echo "  ID      : {$result['id']}\n";
        echo "  Usuario : {$result['nombre_usuario']}\n";
        echo "  Rol     : $rol\n\n";
        echo "Accede al panel en:\n";
        echo "  http://127.0.0.1:8001/php/admin/login.php\n\n";
    } else {
        echo "✗ El usuario '$username' ya existe. Elige otro o revisa la BD.\n";
        exit(1);
    }
} catch (PDOException $e) {
    echo "✗ Error al guardar en la base de datos:\n  " . $e->getMessage() . "\n";
    exit(1);
}
