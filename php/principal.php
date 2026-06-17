<?php
$pages = [
  'inicio' => ['title' => 'Inicio', 'file' => 'inicio.php'],
  'nosotros' => ['title' => 'Nosotros', 'file' => 'nosotros.php'],
  'oferta_educativa' => ['title' => 'Oferta Educativa', 'file' => 'oferta_educativa.php'],
  'investigacion' => ['title' => 'Investigación', 'file' => 'investigacion.php'],
  'comunidad' => ['title' => 'Comunidad', 'file' => 'comunidad.php'],
  'blog' => ['title' => 'Blog', 'file' => 'blog.php'],
  'contacto' => ['title' => 'Contacto', 'file' => 'contacto.php'],
  'aviso_privacidad' => ['title' => 'Aviso de Privacidad', 'file' => 'aviso_privacidad.php'],
  'terminos' => ['title' => 'Términos de Uso', 'file' => 'terminos.php'],
  'mapa_sitio' => ['title' => 'Mapa del Sitio', 'file' => 'mapa_sitio.php'],
  'transparencia' => ['title' => 'Transparencia', 'file' => 'transparencia.php'],
  'convocatorias' => ['title' => 'Convocatorias', 'file' => 'convocatorias.php'],
  'publicaciones' => ['title' => 'Publicaciones', 'file' => 'publicaciones.php'],
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
    </style>
  </head>

  <body>
    <!-- ===== TOP BAR ===== -->
    <div class="top-bar">
      <div class="inner">
        <a
          href="https://facebook.com"
          target="_blank"
          rel="noopener"
          aria-label="Facebook"
        >
          <i class="ti ti-brand-facebook"></i>
        </a>
        <a
          href="https://instagram.com"
          target="_blank"
          rel="noopener"
          aria-label="Instagram"
        >
          <i class="ti ti-brand-instagram"></i>
        </a>
        <a
          href="https://youtube.com"
          target="_blank"
          rel="noopener"
          aria-label="YouTube"
        >
          <i class="ti ti-brand-youtube"></i>
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
          href="principal.php?page=inicio"
          class="header-logos"
          aria-label="Inicio — División de Estudios de Posgrado FECA UJED"
        >
          <img
            src="../División de Estudios de Posgrado – FECA UJED – División de Estudios de Posgrado de la Facultad de Economía, Contaduría y Administración_files/Logo_Institucional-UJED.png"
            class="logo-ujed-img"
            alt="Logo UJED"
          />
          <div class="logo-divider" aria-hidden="true"></div>

          <!-- Logo FECA -->
          <div class="logo-feca-block">
            <img
              src="../División de Estudios de Posgrado – FECA UJED – División de Estudios de Posgrado de la Facultad de Economía, Contaduría y Administración_files/FECA-Logotipo.png"
              class="logo-feca-img"
              alt="Logo FECA"
            />
          </div>

          <div class="logo-section-divider" aria-hidden="true"></div>

          <!-- División de Estudios de Posgrado -->
          <div class="logo-division-block">
            <img
              src="../División de Estudios de Posgrado – FECA UJED – División de Estudios de Posgrado de la Facultad de Economía, Contaduría y Administración_files/Logo-AZUL-DEP-UJED-2022-03_Mesa-de-trabajo-1.png"
              class="logo-division-img"
              alt="División de Estudios de Posgrado FECA UJED"
            />
          </div>
        </a>

        <!-- Navegación principal -->
        <nav role="navigation" aria-label="Menú principal">
          <a href="principal.php?page=nosotros" class="<?= nav_class($currentPage, 'nosotros') ?>" data-nav-section="nosotros" <?= $currentPage === 'nosotros' ? 'aria-current="page"' : '' ?>
            >Nosotros <span class="chevron" aria-hidden="true"><?= nav_symbol($currentPage, 'nosotros') ?></span></a
          >
          <a href="principal.php?page=oferta_educativa" class="<?= nav_class($currentPage, 'oferta_educativa') ?>" data-nav-section="oferta_educativa" <?= $currentPage === 'oferta_educativa' ? 'aria-current="page"' : '' ?>
            >Oferta Educativa <span class="chevron" aria-hidden="true"><?= nav_symbol($currentPage, 'oferta_educativa') ?></span></a
          >
          <a href="principal.php?page=investigacion" class="<?= nav_class($currentPage, 'investigacion') ?>" data-nav-section="investigacion" <?= $currentPage === 'investigacion' ? 'aria-current="page"' : '' ?>
            >Investigación <span class="chevron" aria-hidden="true"><?= nav_symbol($currentPage, 'investigacion') ?></span></a
          >
          <a href="principal.php?page=comunidad" class="<?= nav_class($currentPage, 'comunidad') ?>" data-nav-section="comunidad" <?= $currentPage === 'comunidad' ? 'aria-current="page"' : '' ?>
            >Comunidad <span class="chevron" aria-hidden="true"><?= nav_symbol($currentPage, 'comunidad') ?></span></a
          >
          <a href="principal.php?page=blog" class="<?= nav_class($currentPage, 'blog') ?>" data-nav-section="blog">Blog <span class="chevron" aria-hidden="true"><?= nav_symbol($currentPage, 'blog') ?></span></a>
          <a href="principal.php?page=contacto" class="nav-cta">Contacto</a>
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
            include __DIR__ . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'inicio.php';
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
              <!-- Logo División de Estudios de Posgrado versión blanca -->
              <img
                src="../División de Estudios de Posgrado – FECA UJED – División de Estudios de Posgrado de la Facultad de Economía, Contaduría y Administración_files/Logo-DEP-Blanco-01.png"
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
              <a
                href="https://facebook.com"
                target="_blank"
                rel="noopener"
                aria-label="Facebook"
                ><i class="ti ti-brand-facebook"></i
              ></a>
              <a
                href="https://instagram.com"
                target="_blank"
                rel="noopener"
                aria-label="Instagram"
                ><i class="ti ti-brand-instagram"></i
              ></a>
              <a
                href="https://youtube.com"
                target="_blank"
                rel="noopener"
                aria-label="YouTube"
                ><i class="ti ti-brand-youtube"></i
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
              <li><a href="principal.php?page=nosotros">Nosotros</a></li>
              <li><a href="principal.php?page=oferta_educativa">Oferta Educativa</a></li>
              <li><a href="principal.php?page=investigacion">Investigación</a></li>
              <li><a href="principal.php?page=comunidad">Comunidad</a></li>
              <li><a href="principal.php?page=blog">Blog</a></li>
              <li><a href="principal.php?page=contacto">Contacto</a></li>
            </ul>
          </div>

          <!-- Columna: Enlaces rápidos -->
          <div class="footer-col">
            <div class="footer-col-title">Enlaces rápidos</div>
            <ul>
              <li><a href="principal.php?page=aviso_privacidad">Aviso de Privacidad</a></li>
              <li><a href="principal.php?page=transparencia">Transparencia</a></li>
              <li><a href="principal.php?page=mapa_sitio">Mapa del Sitio</a></li>
              <li>
                <a href="https://ujed.mx" target="_blank" rel="noopener"
                  >Directorio UJED</a
                >
              </li>
              <li><a href="principal.php?page=convocatorias">Convocatorias</a></li>
              <li><a href="principal.php?page=publicaciones">Publicaciones</a></li>
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
            <a href="principal.php?page=aviso_privacidad">Aviso de Privacidad</a>
            <a href="principal.php?page=terminos">Términos de Uso</a>
            <a href="principal.php?page=mapa_sitio">Mapa del Sitio</a>
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
