<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'use_strict_mode' => true,
        'gc_maxlifetime'  => 7200,  // 2 horas de inactividad
    ]);
}

require_once __DIR__ . '/database.php';

// ─────────────────────────────────────────────────────────────
// Consultas de estado de sesión
// ─────────────────────────────────────────────────────────────

function is_admin_logged_in(): bool {
    return !empty($_SESSION['usuario_id'])
        && !empty($_SESSION['usuario_rol'])
        && !empty($_SESSION['_ts'])
        && (time() - $_SESSION['_ts']) < 7200;
}

function usuario_actual(): array {
    return [
        'id'     => $_SESSION['usuario_id']     ?? null,
        'nombre' => $_SESSION['usuario_nombre'] ?? 'Usuario',
        'rol'    => $_SESSION['usuario_rol']    ?? 'lector',
    ];
}

function require_admin(): void {
    if (!is_admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
    // Renovar timestamp de actividad
    $_SESSION['_ts'] = time();
}

function require_rol(string ...$roles): void {
    require_admin();
    $rolActual = $_SESSION['usuario_rol'] ?? '';
    if (!in_array($rolActual, $roles, true)) {
        http_response_code(403);
        exit('Acceso denegado: no tienes permisos suficientes.');
    }
}

// ─────────────────────────────────────────────────────────────
// Login con la tabla usuarios (hash Argon2id / bcrypt)
// ─────────────────────────────────────────────────────────────

function attempt_login(string $credencial, string $password): bool {
    global $pdo;

    if ($credencial === '' || $password === '') {
        return false;
    }

    $stmt = $pdo->prepare(
        'SELECT id, password_hash, nombre_completo, rol
         FROM   usuarios
         WHERE  (username = :c OR email = :c) AND activo = TRUE
         LIMIT  1'
    );
    $stmt->execute([':c' => $credencial]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        // Pausa anti-timing para no revelar si el usuario existe
        usleep(random_int(200_000, 400_000));
        return false;
    }

    // Re-hash si el algoritmo cambió (migración transparente)
    if (password_needs_rehash($user['password_hash'], PASSWORD_ARGON2ID)) {
        $nuevoHash = password_hash($password, PASSWORD_ARGON2ID);
        $pdo->prepare('UPDATE usuarios SET password_hash = ? WHERE id = ?')
            ->execute([$nuevoHash, $user['id']]);
    }

    session_regenerate_id(true);
    $_SESSION['usuario_id']     = $user['id'];
    $_SESSION['usuario_nombre'] = $user['nombre_completo'];
    $_SESSION['usuario_rol']    = $user['rol'];
    $_SESSION['_ts']            = time();

    $pdo->prepare(
        'UPDATE usuarios SET ultimo_acceso = NOW(), ip_ultimo = ?::inet WHERE id = ?'
    )->execute([$_SERVER['REMOTE_ADDR'] ?? null, $user['id']]);

    return true;
}

// ─────────────────────────────────────────────────────────────
// Logout seguro
// ─────────────────────────────────────────────────────────────

function logout_usuario(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 86400,
                  $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}
