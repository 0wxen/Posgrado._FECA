<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/auth.php';

if (is_admin_logged_in()) {
  header('Location: index.php');
  exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = trim($_POST['user'] ?? '');
  $password = $_POST['password'] ?? '';

  if (attempt_admin_login($user, $password)) {
    header('Location: index.php');
    exit;
  }

  $error = 'Usuario o contraseña incorrectos.';
}
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Acceso administrativo</title>
    <style>
      body {
        min-height: 100vh;
        margin: 0;
        display: grid;
        place-items: center;
        background: #f8f7f5;
        color: #3a3a3a;
        font-family: Arial, sans-serif;
      }

      form {
        width: min(420px, calc(100% - 32px));
        display: grid;
        gap: 16px;
        padding: 28px;
        background: #fff;
        border-top: 4px solid #e31313;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
      }

      h1 {
        margin: 0;
        color: #951823;
        font-size: 24px;
      }

      label {
        display: grid;
        gap: 6px;
        font-weight: 700;
      }

      input,
      button {
        min-height: 42px;
        font: inherit;
      }

      input {
        border: 1px solid #b9c7c7;
        padding: 8px 10px;
      }

      button {
        border: 0;
        background: #e31313;
        color: #fff;
        cursor: pointer;
        font-weight: 700;
      }

      .error {
        color: #951823;
        font-weight: 700;
      }
    </style>
  </head>
  <body>
    <form method="post" action="login.php">
      <h1>Acceso administrativo</h1>
      <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>
      <label>
        Usuario
        <input name="user" autocomplete="username" required />
      </label>
      <label>
        Contraseña
        <input name="password" type="password" autocomplete="current-password" required />
      </label>
      <button type="submit">Entrar</button>
    </form>
  </body>
</html>
