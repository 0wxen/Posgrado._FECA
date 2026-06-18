<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

function admin_user(): string {
  return getenv('ADMIN_USER') ?: 'admin';
}

function admin_password(): string {
  return getenv('ADMIN_PASSWORD') ?: 'Owen1234';
}

function is_admin_logged_in(): bool {
  return !empty($_SESSION['admin_logged_in']);
}

function require_admin(): void {
  if (!is_admin_logged_in()) {
    header('Location: login.php');
    exit;
  }
}

function attempt_admin_login(string $user, string $password): bool {
  if (hash_equals(admin_user(), $user) && hash_equals(admin_password(), $password)) {
    session_regenerate_id(true);
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_user'] = $user;
    return true;
  }

  return false;
}

function logout_admin(): void {
  $_SESSION = [];

  if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
  }

  session_destroy();
}
