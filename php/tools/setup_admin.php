<?php
declare(strict_types=1);

/**
 * Script para crear el PRIMER usuario administrador.
 * Ejecutar UNA VEZ desde la terminal:
 *
 *   C:\xampp\php\php.exe php/tools/setup_admin.php
 *
 * NO es accesible por navegador.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Este script solo se ejecuta desde la línea de comandos.\n");
}

require_once __DIR__ . '/../config/database.php';

echo "\n";
echo "╔══════════════════════════════════════════════════════╗\n";
echo "║   Crear administrador · DEP FECA UJED               ║\n";
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

$username = leer('Usuario (username): ');
$email    = leer('Correo electrónico: ');
$nombre   = leer('Nombre completo   : ');
$password = leer('Contraseña (mín. 12 caracteres): ', true);
$confirma = leer('Confirmar contraseña            : ', true);

echo "\n";

// Validaciones básicas
$errores = [];

if (strlen($username) < 3) {
    $errores[] = 'El username debe tener al menos 3 caracteres.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'El correo electrónico no es válido.';
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
        'INSERT INTO usuarios (username, email, password_hash, nombre_completo, rol)
         VALUES (?, ?, ?, ?, \'superadmin\')
         ON CONFLICT (username) DO NOTHING
         RETURNING id, username'
    );
    $stmt->execute([$username, $email, $hash, $nombre]);
    $result = $stmt->fetch();

    if ($result) {
        echo "✓ Usuario creado exitosamente.\n";
        echo "  ID      : {$result['id']}\n";
        echo "  Username: {$result['username']}\n";
        echo "  Rol     : superadmin\n\n";
        echo "Accede al panel en:\n";
        echo "  http://127.0.0.1:8001/php/admin/login.php\n\n";
    } else {
        echo "✗ El username '$username' ya existe. Elige otro o revisa la BD.\n";
        exit(1);
    }
} catch (PDOException $e) {
    echo "✗ Error al guardar en la base de datos:\n  " . $e->getMessage() . "\n";
    exit(1);
}
