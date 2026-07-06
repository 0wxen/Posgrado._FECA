<?php
$pages = [
  'inicio' => ['title' => 'Inicio', 'file' => 'home.php'],
  'nosotros' => ['title' => 'Nosotros', 'file' => 'about.php'],
  'oferta_educativa' => ['title' => 'Oferta Educativa', 'file' => 'educational_offer.php'],
  'investigacion' => ['title' => 'Investigación', 'file' => 'research.php'],
  'comunidad' => ['title' => 'Comunidad', 'file' => 'community.php'],
  'blog' => ['title' => 'Blog', 'file' => 'blog.php'],
  'contacto' => ['title' => 'Contacto', 'file' => 'contact.php'],
  'aviso_privacidad' => ['title' => 'Aviso de Privacidad', 'file' => 'privacy_notice.php'],
  'terminos' => ['title' => 'Términos de Uso', 'file' => 'terms.php'],
  'mapa_sitio' => ['title' => 'Mapa del Sitio', 'file' => 'sitemap.php'],
  'transparencia' => ['title' => 'Transparencia', 'file' => 'transparency.php'],
  'convocatorias' => ['title' => 'Convocatorias', 'file' => 'announcements.php'],
  'publicaciones' => ['title' => 'Publicaciones', 'file' => 'publications.php'],
];

$currentPage = $_GET['page'] ?? 'inicio';

if (!isset($pages[$currentPage])) {
  $currentPage = 'inicio';
}

$contentFile = __DIR__ . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . $pages[$currentPage]['file'];
$pageTitle = $pages[$currentPage]['title'];

function nav_class(string $currentPage, string $page): string {
  return $currentPage === $page ? 'nav-link is-active' : 'nav-link';
}

function nav_symbol(string $currentPage, string $page): string {
  return $currentPage === $page ? '⦿' : '𐤏';
}
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($pageTitle) ?> · FECA · División de Estudios de Posgrado · UJED</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Barlow+Condensed:wght@600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"
    />

    <style>
      :root {
        --rojo: #e31313;
        --rojo-oscuro: #951823;
        --dorado: #a87f3d;
        --dorado-claro: #b79a63;
        --gris-claro: #b9c7c7;
        --gris-bg: #f8f7f5;
        --gris-texto: #3a3a3a;
      }

      *,
      *::before,
      *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      body {
        font-family: "Barlow", sans-serif;
        color: var(--gris-texto);
        background: var(--gris-bg);
      }

      /* Contenedor centrado — mismo ancho en header, footer y main */
      .inner {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 40px;
        width: 100%;
      }

      /* ===================== TOP BAR ===================== */
      .top-bar {
        background: var(--rojo-oscuro);
        height: 36px;
      }

      .top-bar .inner {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 18px;
      }

      .top-bar a {
        color: rgba(255, 255, 255, 0.75);
        font-size: 17px;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: color 0.2s;
      }

      .top-bar a:hover {
        color: #fff;
      }

      /* ===================== HEADER MAIN ===================== */
      .header-main {
        background: #fff;
        border-bottom: 3px solid var(--rojo);
        height: 76px;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.07);
      }

      .header-main .inner {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
      }

      /* --- Logos --- */
      .header-logos {
        display: flex;
        align-items: center;
        gap: 0;
        text-decoration: none;
        flex-shrink: 0;
        min-width: 0;
      }

      /* Ajusta estos valores con los tamaños reales de tus imágenes */
      .logo-ujed-img {
        height: 52px;
        width: auto;
        max-width: 128px;
        object-fit: contain;
        display: block;
        flex-shrink: 0;
      }

      .logo-feca-img {
        height: 38px;
        width: auto;
        max-width: 96px;
        object-fit: contain;
        display: block;
        flex-shrink: 0;
      }

      .logo-feca-block {
        display: flex;
        align-items: center;
        flex-shrink: 0;
      }

      .logo-divider {
        width: 1px;
        height: 44px;
        background: var(--gris-claro);
        margin: 0 16px;
        flex-shrink: 0;
      }

      .logo-section-divider {
        width: 1px;
        height: 44px;
        background: var(--gris-claro);
        margin: 0 20px;
        flex-shrink: 0;
      }

      .logo-division-block {
        display: flex;
        align-items: center;
        justify-content: center;
      }

      /* --- Navegación --- */
      nav {
        display: flex;
        align-items: center;
        gap: 2px;
        flex-shrink: 0;
      }

      .nav-link {
        font-family: "Barlow", sans-serif;
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        color: var(--gris-texto);
        text-decoration: none;
        padding: 7px 10px;
        display: flex;
        align-items: center;
        gap: 3px;
        border-radius: 4px;
        transition:
          color 0.2s,
          background 0.15s;
        white-space: nowrap;
      }

      .nav-link:hover {
        color: var(--rojo);
        background: rgba(227, 19, 19, 0.05);
      }

      .nav-link .chevron {
        font-size: 9px;
        opacity: 0.45;
      }

      .nav-link.is-active .chevron {
        color: var(--rojo);
        opacity: 1;
      }

      .nav-cta {
        margin-left: 6px;
        padding: 7px 16px;
        border: 2px solid var(--rojo);
        color: var(--rojo);
        font-family: "Barlow", sans-serif;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-radius: 3px;
        text-decoration: none;
        transition:
          background 0.2s,
          color 0.2s;
        white-space: nowrap;
      }

      .nav-cta:hover {
        background: var(--rojo);
        color: #fff;
      }

      /* ===================== MAIN ===================== */
      main {
        min-height: 400px;
        padding: 60px 0;
      }

      .page-content {
        display: grid;
        gap: 24px;
      }

      .page-content h1 {
        color: var(--rojo-oscuro);
        font-family: "Barlow Condensed", sans-serif;
        font-size: 36px;
        letter-spacing: 0.03em;
        line-height: 1.1;
        text-transform: uppercase;
      }

      .page-content h2 {
        color: var(--rojo);
        font-family: "Barlow Condensed", sans-serif;
        font-size: 24px;
        letter-spacing: 0.03em;
        text-transform: uppercase;
      }

      .page-content p,
      .page-content li {
        width: 100%;
        margin: 0;
        color: var(--gris-texto);
        font-size: 16px;
        line-height: 1.7;
      }

      .page-content ul {
        display: grid;
        gap: 10px;
        padding-left: 20px;
      }

      .page-kicker {
        color: var(--dorado);
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
      }

      .content-list {
        display: grid;
        gap: 18px;
      }

      .content-card {
        display: grid;
        gap: 10px;
        padding: 18px;
        background: #fff;
        border-left: 4px solid var(--rojo);
        box-shadow: 0 8px 22px rgba(0, 0, 0, 0.06);
      }

      .content-card .page-kicker {
        margin: 0;
      }

      .content-image {
        width: min(520px, 100%);
        max-height: 360px;
        object-fit: contain;
        background: #fff;
        border: 1px solid rgba(0, 0, 0, 0.08);
      }

      .content-file-link {
        color: var(--rojo);
        font-weight: 700;
        text-decoration: none;
      }

      .content-file-link:hover {
        text-decoration: underline;
      }

      .logo-division-img {
        display: block;
        height: 44px;
        max-width: 220px;
        width: auto;
        object-fit: contain;
      }

      /* ===================== FOOTER ===================== */
      .footer {
        background: #1a1a1a;
        color: rgba(255, 255, 255, 0.75);
        padding: 48px 0 0;
      }

      .footer-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr 1fr 1fr;
        gap: 40px;
        padding-bottom: 40px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      .footer-brand-logos {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
      }

      .footer-brand-name {
        font-family: "Barlow Condensed", sans-serif;
        font-size: 15px;
        font-weight: 700;
        color: var(--rojo);
        letter-spacing: 0.04em;
        text-transform: uppercase;
      }

      .footer-brand-sub {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.4);
        line-height: 1.5;
        margin-top: 3px;
      }

      .footer-brand-desc {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.5);
        line-height: 1.7;
        margin-top: 12px;
      }

      .footer-social {
        display: flex;
        gap: 10px;
        margin-top: 20px;
      }

      .footer-social a {
        width: 34px;
        height: 34px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.55);
        font-size: 16px;
        text-decoration: none;
        transition:
          border-color 0.2s,
          color 0.2s,
          background 0.2s;
      }

      .footer-social a:hover {
        border-color: var(--rojo);
        color: #fff;
        background: var(--rojo);
      }

      .footer-col-title {
        font-family: "Barlow Condensed", sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #fff;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--rojo);
        display: inline-block;
      }

      .footer-col ul {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 8px;
      }

      .footer-col ul li a {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        font-size: 13px;
        line-height: 1.4;
        transition: color 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
      }

      .footer-col ul li a::before {
        content: "";
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: var(--dorado);
        flex-shrink: 0;
      }

      .footer-col ul li a:hover {
        color: #fff;
      }

      .footer-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 12px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.5);
        line-height: 1.55;
      }

      .footer-contact-item i {
        color: var(--dorado);
        font-size: 16px;
        flex-shrink: 0;
        margin-top: 2px;
      }

      .footer-contact-item a {
        color: var(--dorado-claro);
        text-decoration: none;
      }

      .footer-contact-item a:hover {
        color: var(--dorado);
      }

      .footer-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 0;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.3);
        gap: 16px;
        flex-wrap: wrap;
      }

      .footer-bottom-links {
        display: flex;
        gap: 20px;
      }

      .footer-bottom-links a {
        color: rgba(255, 255, 255, 0.3);
        text-decoration: none;
        transition: color 0.2s;
      }

      .footer-bottom-links a:hover {
        color: rgba(255, 255, 255, 0.7);
      }

      .footer-accent-bar {
        height: 4px;
        background: linear-gradient(
          90deg,
          var(--rojo-oscuro) 0%,
          var(--rojo) 50%,
          var(--dorado) 100%
        );
      }

      /* ===================== RESPONSIVE ===================== */
      @media (max-width: 1100px) {
        .logo-section-divider,
        .logo-division-block {
          display: none;
        }
        .nav-link {
          font-size: 11.5px;
          padding: 7px 7px;
        }
      }

      @media (max-width: 768px) {
        .top-bar {
          padding: 0 20px;
        }
        .inner {
          padding: 0 20px;
        }
        .header-main {
          height: auto;
        }
        .header-main .inner {
          flex-direction: column;
          align-items: center;
          padding-top: 12px;
          padding-bottom: 12px;
          gap: 10px;
        }
        .header-logos {
          justify-content: center;
          width: 100%;
        }
        nav {
          justify-content: center;
          flex-wrap: wrap;
          gap: 4px;
          width: 100%;
        }
        .footer {
          padding: 40px 0 0;
        }
        .footer-grid {
          grid-template-columns: 1fr 1fr;
          gap: 28px;
        }
        .footer-bottom {
          flex-direction: column;
          align-items: flex-start;
        }
      }

      @media (max-width: 480px) {
        .logo-ujed-img {
          height: 44px;
          max-width: 108px;
        }
        .logo-feca-img {
          height: 32px;
          max-width: 82px;
        }
        .logo-divider,
        .logo-section-divider {
          height: 36px;
          margin: 0 10px;
        }
        .footer-grid {
          grid-template-columns: 1fr;
        }
      }

      /* ===== HERO (v6) — dos columnas: texto institucional + imagen contenida ===== */
      .hero-split {
        position: relative;
        overflow: hidden;
        background:
          radial-gradient(1000px 520px at 88% -12%, rgba(168, 127, 61, 0.38) 0%, rgba(168, 127, 61, 0) 60%),
          radial-gradient(800px 520px at -6% 112%, rgba(227, 19, 19, 0.32) 0%, rgba(227, 19, 19, 0) 60%),
          linear-gradient(135deg, #1a0508 0%, var(--rojo-oscuro) 55%, #2b1405 100%);
        padding: 64px 0;
      }
      .hero-split::after {
        content: '';
        position: absolute;
        left: 0; right: 0; bottom: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--rojo-oscuro) 0%, var(--rojo) 50%, var(--dorado) 100%);
      }
      .hero-split-inner {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 60px;
        display: grid;
        grid-template-columns: 0.78fr 1.22fr;
        gap: 44px;
        align-items: center;
      }
      .hero-split-content { max-width: 420px; }
      .hero-split-kicker {
        display: block;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--dorado);
        margin-bottom: 12px;
      }
      .hero-split-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: clamp(26px, 2.8vw, 38px);
        font-weight: 700;
        color: #fff;
        text-transform: uppercase;
        line-height: 1.08;
        letter-spacing: 0.01em;
        margin-bottom: 14px;
      }
      .hero-split-desc {
        font-size: 14.5px;
        color: rgba(255, 255, 255, 0.75);
        line-height: 1.62;
        margin-bottom: 22px;
      }
      .hero-split-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 24px; }
      .hero-split-actions .btn-primary,
      .hero-split-actions .btn-outline-red {
        padding: 10px 20px;
        font-size: 11.5px;
      }
      .btn-outline-red {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 13px 28px;
        background: transparent;
        color: var(--rojo);
        font-family: 'Barlow', sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        border-radius: 3px;
        text-decoration: none;
        border: 2px solid var(--rojo);
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
      }
      .btn-outline-red:hover { background: var(--rojo); color: #fff; }
      .hero-split-stats {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
      }
      .hero-split-stat-num {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: var(--dorado);
        line-height: 1;
      }
      .hero-split-stat-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: rgba(255, 255, 255, 0.55);
        margin-top: 3px;
      }
      .hero-split-visual {
        position: relative;
        border-radius: 18px;
        overflow: hidden;
        aspect-ratio: 16 / 9;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.16);
        background: #111;
        cursor: pointer;
      }
      .hero-split-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 0.5s ease;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
      }
      .hero-split-slide.activo { opacity: 1; z-index: 1; }
      .hero-split-media {
        position: absolute;
        inset: 0;
        background:
          radial-gradient(140% 130% at 12% 8%, rgba(255, 255, 255, 0.22) 0%, rgba(255, 255, 255, 0) 42%),
          radial-gradient(120% 140% at 100% 100%, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0) 55%),
          linear-gradient(135deg, var(--tint1, #7f0000) 0%, var(--tint2, #2b0a0a) 100%);
        overflow: hidden;
      }
      .hero-split-media::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 20px 20px;
        opacity: 0.5;
      }
      .hero-split-media i {
        position: absolute;
        right: 28px;
        bottom: 24px;
        font-size: 76px;
        color: rgba(255, 255, 255, 0.16);
      }
      .hero-split-caption {
        position: relative;
        z-index: 2;
        padding: 26px 30px;
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.82) 0%, rgba(0, 0, 0, 0.15) 70%, rgba(0, 0, 0, 0) 100%);
      }
      .hero-split-caption-kicker {
        display: block;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--dorado-claro);
        margin-bottom: 6px;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
      }
      .hero-split-caption-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: clamp(22px, 2.6vw, 30px);
        font-weight: 700;
        color: #fff;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
      }

      /* Puntos de navegación */
      .hero-split-dots {
        position: absolute;
        top: 18px;
        right: 18px;
        z-index: 4;
        display: flex;
        gap: 7px;
      }
      .hero-split-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        border: none;
        padding: 0;
        cursor: pointer;
        transition: background 0.2s, transform 0.2s;
      }
      .hero-split-dot:hover { background: rgba(255, 255, 255, 0.7); }
      .hero-split-dot.activo { background: #fff; transform: scale(1.2); }

      /* Flechas de navegación */
      .hero-split-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 4;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.32);
        border: 1.5px solid rgba(255, 255, 255, 0.28);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        cursor: pointer;
        transition: background 0.2s, border-color 0.2s, transform 0.2s;
      }
      .hero-split-nav:hover { background: var(--rojo); border-color: var(--rojo); transform: translateY(-50%) scale(1.08); }
      .hero-split-nav-prev { left: 12px; }
      .hero-split-nav-next { right: 12px; }

      @media (max-width: 980px) {
        .hero-split-inner { grid-template-columns: 1fr; gap: 40px; padding: 0 32px; }
        .hero-split-visual { aspect-ratio: 16 / 9; order: -1; }
      }
      @media (max-width: 720px) {
        .hero-split { padding: 44px 0; }
        .hero-split-inner { padding: 0 20px; }
        .hero-split-stats { gap: 22px; }
        .hero-split-nav { width: 30px; height: 30px; font-size: 13px; }
      }

      /* ===== BANNER INSTITUCIONAL (v5) — imágenes horizontales, una a la vez ===== */
      .hero3 {
        position: relative;
        width: 100%;
        aspect-ratio: 21 / 7;
        max-height: 66vh;
        min-height: 260px;
        overflow: hidden;
        background: #0c0304;
        isolation: isolate;
      }
      .hero3::after {
        content: '';
        position: absolute;
        left: 0; right: 0; bottom: 0;
        height: 4px;
        z-index: 3;
        background: linear-gradient(90deg, var(--rojo-oscuro) 0%, var(--rojo) 50%, var(--dorado) 100%);
      }
      .hero3-viewport { position: absolute; inset: 0; }
      .hero3-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 0.6s ease;
      }
      .hero3-slide.activo { opacity: 1; z-index: 1; }
      .hero3-slide-media { position: absolute; inset: 0; }
      .hero3-slide-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
      }
      .hero3-slide-media--placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: linear-gradient(120deg, var(--tint1, #7f0000) 0%, var(--tint2, #2b0a0a) 100%);
        color: rgba(255, 255, 255, 0.55);
      }
      .hero3-slide-media--placeholder i { font-size: 34px; color: rgba(255, 255, 255, 0.35); }
      .hero3-slide-media--placeholder span {
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        text-align: center;
        padding: 0 20px;
      }
      .hero3-slide-caption {
        position: absolute;
        left: 0; right: 0; bottom: 0;
        z-index: 2;
        padding: 26px 110px 24px 48px;
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.75) 0%, rgba(0, 0, 0, 0) 100%);
      }
      .hero3-slide-kicker {
        display: block;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--dorado-claro);
        margin-bottom: 6px;
      }
      .hero3-slide-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: clamp(20px, 3vw, 32px);
        font-weight: 700;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        line-height: 1.1;
      }
      .hero3-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 4;
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.32);
        border: 1.5px solid rgba(255, 255, 255, 0.25);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        cursor: pointer;
        transition: background 0.2s, border-color 0.2s, transform 0.2s;
      }
      .hero3-nav:hover { background: var(--rojo); border-color: var(--rojo); transform: translateY(-50%) scale(1.06); }
      .hero3-nav-prev { left: 18px; }
      .hero3-nav-next { right: 18px; }
      .hero3-dots {
        position: absolute;
        right: 24px;
        bottom: 26px;
        z-index: 4;
        display: flex;
        gap: 8px;
      }
      .hero3-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.35);
        border: none;
        padding: 0;
        cursor: pointer;
        transition: background 0.2s, transform 0.2s;
      }
      .hero3-dot:hover { background: rgba(255, 255, 255, 0.6); }
      .hero3-dot.activo { background: #fff; transform: scale(1.2); }
      @media (max-width: 720px) {
        .hero3 { aspect-ratio: 4 / 3; max-height: 60vh; }
        .hero3-slide-caption { padding: 20px 20px 60px; }
        .hero3-nav { width: 38px; height: 38px; font-size: 17px; }
      }

      /* ===== CONVOCATORIAS — sección debajo del banner institucional ===== */
      .convs-section {
        position: relative;
        overflow: hidden;
        padding: 64px 0;
        background:
          radial-gradient(1000px 500px at 85% -10%, rgba(168, 127, 61, 0.28) 0%, rgba(168, 127, 61, 0) 60%),
          radial-gradient(800px 450px at -10% 110%, rgba(227, 19, 19, 0.22) 0%, rgba(227, 19, 19, 0) 60%),
          linear-gradient(150deg, #14060b 0%, #3a0c14 55%, #1a0a12 100%);
      }

      /* ===== HERO REDISEÑADO (v2/v3) — versiones anteriores, ya sin marcado HTML que las use =====
         Este archivo no tenía CSS propio para el hero original (lo definía solo html/htmlcode.html).
         Las clases .hero2-convs-heading / .hero2-conv-card / .hero2-bottombar siguen activas y en
         uso, ahora dentro de .convs-section (ver php/pages/home.php). */
      .hero2 {
        position: relative;
        overflow: hidden;
        isolation: isolate;
        background:
          radial-gradient(1200px 600px at 85% -10%, rgba(168, 127, 61, 0.35) 0%, rgba(168, 127, 61, 0) 60%),
          radial-gradient(900px 500px at -10% 110%, rgba(227, 19, 19, 0.28) 0%, rgba(227, 19, 19, 0) 60%),
          linear-gradient(150deg, #12040a 0%, var(--rojo-oscuro) 55%, #1a0a12 100%);
      }
      .hero2::after {
        content: '';
        position: absolute;
        left: 0; right: 0; bottom: 0;
        height: 4px;
        z-index: 2;
        background: linear-gradient(90deg, var(--rojo-oscuro) 0%, var(--rojo) 50%, var(--dorado) 100%);
      }
      .hero2-inner {
        position: relative;
        z-index: 1;
        max-width: 1400px;
        margin: 0 auto;
        padding: 56px 60px 48px;
      }
      /* ----- v4: barra institucional al pie del banner (antes iba arriba) ----- */
      .hero2-bottombar {
        margin-top: 34px;
        padding-top: 22px;
        border-top: 1px solid rgba(255, 255, 255, 0.12);
        display: flex;
        flex-direction: column;
        gap: 16px;
      }
      .hero2-bottombar-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
      }
      .hero2-bottombar-kicker {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--dorado-claro);
        white-space: nowrap;
      }
      .hero2-bottombar-right { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
      .hero2-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.7);
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.14);
        padding: 5px 11px;
        border-radius: 99px;
        white-space: nowrap;
      }
      .hero2-chip b {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 13px;
        color: var(--dorado-claro);
      }
      .hero2-bottombar-more {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #fff;
        text-decoration: none;
        opacity: 0.75;
        transition: opacity 0.2s, transform 0.2s;
      }
      .hero2-bottombar-more:hover { opacity: 1; transform: translateX(3px); }
      /* La frase institucional, tratada como una declaración destacada (fácil de quitar si no convence) */
      .hero2-tagline {
        display: flex;
        align-items: center;
        gap: 12px;
        font-family: 'Barlow Condensed', sans-serif;
        font-style: italic;
        font-size: clamp(16px, 1.8vw, 22px);
        color: rgba(255, 255, 255, 0.82);
        border-left: 3px solid var(--dorado);
        padding-left: 14px;
      }
      .hero2-tagline i { color: var(--dorado-claro); font-size: 20px; font-style: normal; flex-shrink: 0; }

      /* ----- v3: encabezado + tarjetas de convocatorias, protagonistas del banner ----- */
      .hero2-convs-heading { margin-bottom: 26px; }
      .hero2-convs-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #fff;
        background: rgba(227, 19, 19, 0.22);
        border: 1px solid rgba(227, 19, 19, 0.45);
        padding: 6px 14px;
        border-radius: 99px;
        margin-bottom: 16px;
      }
      .hero2-convs-eyebrow .dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #ff5c5c;
        animation: hero2-pulse 1.8s infinite;
      }
      @keyframes hero2-pulse {
        0%   { box-shadow: 0 0 0 0 rgba(255, 92, 92, 0.55); }
        70%  { box-shadow: 0 0 0 9px rgba(255, 92, 92, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 92, 92, 0); }
      }
      .hero2-convs-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: clamp(30px, 3.6vw, 46px);
        font-weight: 700;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        line-height: 1.05;
        margin-bottom: 10px;
      }
      .hero2-convs-sub { font-size: 14px; color: rgba(255, 255, 255, 0.62); }

      .hero2-convs-track {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
      }
      .hero2-conv-card {
        --accent: var(--dorado);
        position: relative;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-top: 4px solid var(--accent);
        border-radius: 14px;
        padding: 28px 26px 24px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        cursor: pointer;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
        transition: background 0.2s, border-color 0.2s, transform 0.2s, box-shadow 0.2s;
      }
      .hero2-conv-card:hover,
      .hero2-conv-card:focus-visible {
        background: rgba(255, 255, 255, 0.13);
        border-color: rgba(255, 255, 255, 0.32);
        transform: translateY(-6px);
        box-shadow: 0 22px 48px rgba(0, 0, 0, 0.4);
        outline: none;
      }
      .hero2-conv-top { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
      .hero2-conv-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: color-mix(in srgb, var(--accent) 25%, transparent);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 20px;
        flex-shrink: 0;
      }
      .hero2-conv-countdown {
        display: inline-flex;
        align-items: center;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #fff;
        background: color-mix(in srgb, var(--accent) 45%, transparent);
        border: 1px solid color-mix(in srgb, var(--accent) 70%, transparent);
        padding: 5px 11px;
        border-radius: 99px;
        white-space: nowrap;
      }
      .hero2-conv-card h3 {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 23px;
        font-weight: 700;
        color: #fff;
        line-height: 1.15;
      }
      .hero2-conv-card p {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.55;
      }
      .hero2-conv-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.55);
      }
      .hero2-conv-meta i { color: var(--accent); font-size: 13px; }
      .hero2-conv-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
      }
      .hero2-conv-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 12.5px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #fff;
        background: var(--accent);
        padding: 11px 16px;
        border-radius: 6px;
        text-decoration: none;
        transition: filter 0.2s, transform 0.2s;
      }
      .hero2-conv-btn:hover { filter: brightness(1.12); transform: translateY(-1px); }
      .hero2-conv-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.75);
        padding: 11px 6px;
      }
      .hero2-conv-card:hover .hero2-conv-more-btn { color: #fff; }
      .hero2-convs-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 32px 20px;
        color: rgba(255, 255, 255, 0.5);
      }
      .hero2-convs-empty i {
        font-size: 38px;
        display: block;
        margin-bottom: 8px;
        color: rgba(255, 255, 255, 0.3);
      }
      @media (max-width: 980px) {
        .hero2-inner { padding: 44px 32px 36px; }
        .hero2-convs-track { grid-template-columns: 1fr 1fr; }
        .hero2-bottombar-right { width: 100%; justify-content: flex-start; }
      }
      @media (max-width: 720px) {
        .hero2-bottombar-row { flex-direction: column; align-items: flex-start; }
        .hero2-convs-track { grid-template-columns: 1fr; }
        .hero2-inner { padding: 36px 20px 28px; }
      }
    </style>
  </head>

  <body>
    <!-- ===== TOP BAR ===== -->
    <div class="top-bar">
      <div class="inner">
        <a href="https://www.facebook.com/FECAUJEDMX" target="_blank" rel="noopener" aria-label="Facebook">
          <i class="ti ti-brand-facebook"></i>
        </a>
        <a href="https://x.com/fecaujedmx" target="_blank" rel="noopener" aria-label="X / Twitter">
          <i class="ti ti-brand-x"></i>
        </a>
        <a href="https://www.instagram.com/fecaujedmx" target="_blank" rel="noopener" aria-label="Instagram">
          <i class="ti ti-brand-instagram"></i>
        </a>
        <a href="https://www.tiktok.com/@fecaujed.mx" target="_blank" rel="noopener" aria-label="TikTok">
          <i class="ti ti-brand-tiktok"></i>
        </a>
        <a href="mailto:posgradofeca@ujed.mx" aria-label="Correo electrónico">
          <i class="ti ti-mail"></i>
        </a>
      </div>
    </div>

    <!-- ===== HEADER ===== -->
    <header class="header-main" role="banner">
      <div class="inner">
        <!-- Logotipos institucionales -->
        <a
          href="main.php?page=inicio"
          class="header-logos"
          aria-label="Inicio — División de Estudios de Posgrado FECA UJED"
        >
          <img
            src="../assets/img/logo-ujed.png"
            class="logo-ujed-img"
            alt="Logo UJED"
          />
          <div class="logo-divider" aria-hidden="true"></div>

          <!-- Logo FECA -->
          <div class="logo-feca-block">
            <img
              src="../assets/img/logo-feca.png"
              class="logo-feca-img"
              alt="Logo FECA"
            />
          </div>

          <div class="logo-section-divider" aria-hidden="true"></div>

          <!-- División de Estudios de Posgrado -->
          <div class="logo-division-block">
            <img
              src="../assets/img/logo-dep.png"
              class="logo-division-img"
              alt="División de Estudios de Posgrado FECA UJED"
            />
          </div>
        </a>

        <!-- Navegación principal -->
        <nav role="navigation" aria-label="Menú principal">
          <a href="main.php?page=nosotros" class="<?= nav_class($currentPage, 'nosotros') ?>" data-nav-section="nosotros" <?= $currentPage === 'nosotros' ? 'aria-current="page"' : '' ?>
            >Nosotros <span class="chevron" aria-hidden="true"><?= nav_symbol($currentPage, 'nosotros') ?></span></a
          >
          <a href="main.php?page=oferta_educativa" class="<?= nav_class($currentPage, 'oferta_educativa') ?>" data-nav-section="oferta_educativa" <?= $currentPage === 'oferta_educativa' ? 'aria-current="page"' : '' ?>
            >Oferta Educativa <span class="chevron" aria-hidden="true"><?= nav_symbol($currentPage, 'oferta_educativa') ?></span></a
          >
          <a href="main.php?page=investigacion" class="<?= nav_class($currentPage, 'investigacion') ?>" data-nav-section="investigacion" <?= $currentPage === 'investigacion' ? 'aria-current="page"' : '' ?>
            >Investigación <span class="chevron" aria-hidden="true"><?= nav_symbol($currentPage, 'investigacion') ?></span></a
          >
          <a href="main.php?page=comunidad" class="<?= nav_class($currentPage, 'comunidad') ?>" data-nav-section="comunidad" <?= $currentPage === 'comunidad' ? 'aria-current="page"' : '' ?>
            >Comunidad <span class="chevron" aria-hidden="true"><?= nav_symbol($currentPage, 'comunidad') ?></span></a
          >
          <a href="main.php?page=blog" class="<?= nav_class($currentPage, 'blog') ?>" data-nav-section="blog">Blog <span class="chevron" aria-hidden="true"><?= nav_symbol($currentPage, 'blog') ?></span></a>
          <a href="main.php?page=contacto" class="nav-cta">Contacto</a>
        </nav>
      </div>
    </header>

    <!-- ===== CONTENIDO PRINCIPAL ===== -->
    <main>
      <div class="inner page-content">
        <?php
          if (is_file($contentFile)) {
            include $contentFile;
          } else {
            include __DIR__ . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'home.php';
          }
        ?>
      </div>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="footer" role="contentinfo">
      <div class="inner">
        <div class="footer-grid">
          <!-- Columna: Marca institucional -->
          <div>
            <div class="footer-brand-logos">
              <!-- Logo División de Estudios de Posgrado -->
              <img
                src="../assets/img/logo-dep.png"
                style="
                  height: 44px;
                  width: auto;
                "
                alt="División de Estudios de Posgrado"
              />
              <div>
                <div class="footer-brand-name">
                  División de Estudios de Posgrado
                </div>
                <div class="footer-brand-sub">
                  Facultad de Economía, Contaduría y Administración<br />
                  Universidad Juárez del Estado de Durango
                </div>
              </div>
            </div>
            <p class="footer-brand-desc">
              Formamos líderes con excelencia académica, investigación y
              compromiso para el desarrollo de la sociedad.
            </p>
            <div class="footer-social">
              <a href="https://www.facebook.com/FECAUJEDMX" target="_blank" rel="noopener" aria-label="Facebook"
                ><i class="ti ti-brand-facebook"></i
              ></a>
              <a href="https://x.com/fecaujedmx" target="_blank" rel="noopener" aria-label="X / Twitter"
                ><i class="ti ti-brand-x"></i
              ></a>
              <a href="https://www.instagram.com/fecaujedmx" target="_blank" rel="noopener" aria-label="Instagram"
                ><i class="ti ti-brand-instagram"></i
              ></a>
              <a href="https://www.tiktok.com/@fecaujed.mx" target="_blank" rel="noopener" aria-label="TikTok"
                ><i class="ti ti-brand-tiktok"></i
              ></a>
              <a href="mailto:posgradofeca@ujed.mx" aria-label="Correo"
                ><i class="ti ti-mail"></i
              ></a>
            </div>
          </div>

          <!-- Columna: Contacto -->
          <div class="footer-col">
            <div class="footer-col-title">Contacto</div>
            <div class="footer-contact-item">
              <i class="ti ti-map-pin"></i>
              <span
                >Circuito Universitario s/n, C.P. 34120<br />Durango, Dgo.,
                México</span
              >
            </div>
            <div class="footer-contact-item">
              <i class="ti ti-phone"></i>
              <span>(618) 827 12 00 ext. 5430</span>
            </div>
            <div class="footer-contact-item">
              <i class="ti ti-mail"></i>
              <a href="mailto:posgradofeca@ujed.mx">posgradofeca@ujed.mx</a>
            </div>
          </div>

          <!-- Columna: Secciones -->
          <div class="footer-col">
            <div class="footer-col-title">Secciones</div>
            <ul>
              <li><a href="main.php?page=nosotros">Nosotros</a></li>
              <li><a href="main.php?page=oferta_educativa">Oferta Educativa</a></li>
              <li><a href="main.php?page=investigacion">Investigación</a></li>
              <li><a href="main.php?page=comunidad">Comunidad</a></li>
              <li><a href="main.php?page=blog">Blog</a></li>
              <li><a href="main.php?page=contacto">Contacto</a></li>
            </ul>
          </div>

          <!-- Columna: Enlaces rápidos -->
          <div class="footer-col">
            <div class="footer-col-title">Enlaces rápidos</div>
            <ul>
              <li><a href="main.php?page=aviso_privacidad">Aviso de Privacidad</a></li>
              <li><a href="main.php?page=transparencia">Transparencia</a></li>
              <li><a href="main.php?page=mapa_sitio">Mapa del Sitio</a></li>
              <li>
                <a href="https://ujed.mx" target="_blank" rel="noopener"
                  >Directorio UJED</a
                >
              </li>
              <li><a href="main.php?page=convocatorias">Convocatorias</a></li>
              <li><a href="main.php?page=publicaciones">Publicaciones</a></li>
            </ul>
          </div>
        </div>

        <!-- Barra inferior -->
        <div class="footer-bottom">
          <span
            >© 2025 División de Estudios de Posgrado FECA · UJED. Todos los
            derechos reservados.</span
          >
          <div class="footer-bottom-links">
            <a href="main.php?page=aviso_privacidad">Aviso de Privacidad</a>
            <a href="main.php?page=terminos">Términos de Uso</a>
            <a href="main.php?page=mapa_sitio">Mapa del Sitio</a>
          </div>
        </div>
      </div>
      <!-- /.inner -->
    </footer>

    <div class="footer-accent-bar" aria-hidden="true"></div>

    <script>
      const inactiveNavSymbol = "𐤏";
      const activeNavSymbol = "⦿";

      function updateActiveNavigation() {
        const currentSection = <?= json_encode($currentPage) ?>;

        document.querySelectorAll("[data-nav-section]").forEach((link) => {
          const isActive = link.dataset.navSection === currentSection;
          const symbol = link.querySelector(".chevron");

          link.classList.toggle("is-active", isActive);
          link.setAttribute("aria-current", isActive ? "page" : "false");

          if (symbol) {
            symbol.textContent = isActive ? activeNavSymbol : inactiveNavSymbol;
          }
        });
      }

      updateActiveNavigation();
      window.addEventListener("hashchange", updateActiveNavigation);
    </script>
  </body>
</html>
