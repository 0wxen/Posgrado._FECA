<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/auth.php';

if (is_admin_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $credencial = trim($_POST['credencial'] ?? '');
    $password   = $_POST['password'] ?? '';

    if (attempt_login($credencial, $password)) {
        header('Location: index.php');
        exit;
    }
    $error = 'Usuario/correo o contraseña incorrectos.';
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acceso · Panel DEP FECA UJED</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;600;700&family=Barlow+Condensed:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; }

    :root {
      --rojo       : #e31313;
      --rojo-osc   : #951823;
      --dorado     : #a87f3d;
      --gris       : #b9c7c7;
      --texto      : #2a2a2a;
      --fondo      : #f2f1ef;
    }

    body {
      margin: 0;
      min-height: 100vh;
      display: grid;
      grid-template-columns: 1fr 1fr;
      font-family: 'Barlow', sans-serif;
      background: var(--fondo);
      color: var(--texto);
    }

    /* ── Panel izquierdo: marca ── */
    .login-brand {
      background: var(--rojo-osc);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      padding: 60px 56px;
      position: relative;
      overflow: hidden;
    }
    .login-brand::before {
      content: '';
      position: absolute;
      bottom: -60px; right: -60px;
      width: 320px; height: 320px;
      border-radius: 50%;
      background: rgba(255,255,255,.04);
    }
    .login-brand::after {
      content: '';
      position: absolute;
      top: -40px; right: 40px;
      width: 180px; height: 180px;
      border-radius: 50%;
      background: rgba(255,255,255,.03);
    }
    .brand-img {
      height: 52px;
      width: auto;
      margin-bottom: 40px;
      opacity: .95;
    }
    .brand-title {
      font-family: 'Barlow Condensed', sans-serif;
      font-size: 30px;
      font-weight: 700;
      color: #fff;
      line-height: 1.2;
      margin: 0 0 12px;
    }
    .brand-sub {
      font-size: 13px;
      color: rgba(255,255,255,.65);
      line-height: 1.7;
    }
    .brand-divider {
      width: 48px; height: 3px;
      background: var(--dorado);
      margin: 24px 0;
    }
    .brand-notice {
      font-size: 11px;
      color: rgba(255,255,255,.4);
      line-height: 1.6;
      margin-top: auto;
      padding-top: 40px;
    }

    /* ── Panel derecho: formulario ── */
    .login-form-wrap {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 48px 32px;
    }
    .login-card {
      width: 100%;
      max-width: 400px;
    }
    .login-card h1 {
      font-family: 'Barlow Condensed', sans-serif;
      font-size: 26px;
      font-weight: 700;
      color: var(--rojo-osc);
      margin: 0 0 6px;
    }
    .login-card .subtitle {
      font-size: 13px;
      color: #888;
      margin: 0 0 32px;
    }
    .form-field {
      margin-bottom: 18px;
    }
    .form-field label {
      display: block;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: .05em;
      text-transform: uppercase;
      color: #555;
      margin-bottom: 6px;
    }
    .input-wrap {
      position: relative;
    }
    .input-wrap i {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 16px;
      color: #aaa;
      pointer-events: none;
    }
    .input-wrap input {
      width: 100%;
      height: 44px;
      padding: 0 12px 0 38px;
      border: 1.5px solid var(--gris);
      border-radius: 3px;
      font: 14px/1 'Barlow', sans-serif;
      color: var(--texto);
      background: #fff;
      transition: border-color .2s;
      outline: none;
    }
    .input-wrap input:focus { border-color: var(--rojo); }
    .btn-login {
      width: 100%;
      height: 46px;
      margin-top: 8px;
      background: var(--rojo);
      border: none;
      border-radius: 3px;
      font: 700 14px 'Barlow', sans-serif;
      color: #fff;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: background .2s;
    }
    .btn-login:hover { background: var(--rojo-osc); }
    .error-msg {
      display: flex;
      align-items: center;
      gap: 8px;
      background: #fff0f0;
      border: 1px solid #fcc;
      border-left: 4px solid var(--rojo);
      border-radius: 3px;
      padding: 10px 14px;
      font-size: 13px;
      color: var(--rojo-osc);
      font-weight: 600;
      margin-bottom: 20px;
    }
    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin-top: 28px;
      font-size: 12px;
      color: #aaa;
      text-decoration: none;
      transition: color .2s;
    }
    .back-link:hover { color: var(--rojo); }

    /* ── Responsive ── */
    @media (max-width: 720px) {
      body { grid-template-columns: 1fr; }
      .login-brand { display: none; }
      .login-form-wrap { padding: 40px 20px; }
    }
  </style>
</head>
<body>

  <!-- Panel de marca -->
  <div class="login-brand">
    <img src="../assets/img/logo-dep-blanco.png" class="brand-img" alt="DEP FECA UJED">
    <h1 class="brand-title">Panel de Administración</h1>
    <div class="brand-divider"></div>
    <p class="brand-sub">
      División de Estudios de Posgrado<br>
      Facultad de Economía, Contaduría y Administración<br>
      Universidad Juárez del Estado de Durango
    </p>
    <p class="brand-notice">
      Acceso restringido a personal autorizado.<br>
      Todos los accesos quedan registrados.
    </p>
  </div>

  <!-- Formulario -->
  <div class="login-form-wrap">
    <div class="login-card">

      <h1>Iniciar sesión</h1>
      <p class="subtitle">Ingresa con tu usuario o correo institucional</p>

      <?php if ($error): ?>
        <div class="error-msg">
          <i class="ti ti-alert-circle"></i>
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="post" action="login.php" autocomplete="on">

        <div class="form-field">
          <label for="credencial">Usuario o correo</label>
          <div class="input-wrap">
            <i class="ti ti-user"></i>
            <input type="text" id="credencial" name="credencial"
                   autocomplete="username" required
                   placeholder="usuario o correo@ujed.mx"
                   value="<?= htmlspecialchars($_POST['credencial'] ?? '') ?>">
          </div>
        </div>

        <div class="form-field">
          <label for="password">Contraseña</label>
          <div class="input-wrap">
            <i class="ti ti-lock"></i>
            <input type="password" id="password" name="password"
                   autocomplete="current-password" required
                   placeholder="••••••••••••">
          </div>
        </div>

        <button type="submit" class="btn-login">
          <i class="ti ti-login"></i> Entrar al panel
        </button>

      </form>

      <a href="../html/htmlcode.html" class="back-link">
        <i class="ti ti-arrow-left"></i> Volver al sitio público
      </a>

    </div>
  </div>

</body>
</html>
