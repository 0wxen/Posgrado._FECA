<?php require_once __DIR__ . '/../includes/content.php'; ?>
<!-- ===== BANNER ===== -->
<section class="page-banner">
  <div class="page-banner-inner">
    <span class="page-banner-kicker">FECA UJED · División de Estudios de Posgrado</span>
    <h1>Contacto</h1>
    <p class="page-banner-desc">
      Comunícate con nosotros para solicitar información sobre programas,
      convocatorias o el proceso de admisión.
    </p>
  </div>
</section>

<!-- ===== AVISO DE ENVÍO (según ?enviado=1 / ?error=campos|servidor en la URL) ===== -->
<div id="contacto-aviso" hidden class="contacto-aviso"></div>
<script>
(function () {
  var params = new URLSearchParams(window.location.search);
  var aviso = document.getElementById('contacto-aviso');
  if (!aviso) return;

  var mensajes = {
    enviado: { texto: 'Tu mensaje fue enviado correctamente. Te responderemos en un plazo máximo de 2 días hábiles.', tipo: 'ok' },
    campos:  { texto: 'Revisa los campos obligatorios (nombre, correo, asunto y mensaje) e intenta de nuevo.', tipo: 'error' },
    servidor:{ texto: 'No se pudo enviar tu mensaje en este momento. Escríbenos directo a posgradofeca@ujed.mx.', tipo: 'error' },
  };

  var clave = params.has('enviado') ? 'enviado' : (params.get('error') || null);
  if (!clave || !mensajes[clave]) return;

  aviso.textContent = mensajes[clave].texto;
  aviso.classList.add(mensajes[clave].tipo === 'ok' ? 'contacto-aviso--ok' : 'contacto-aviso--error');
  aviso.hidden = false;
})();
</script>

<!-- ===== INFO + FORMULARIO ===== -->
<section class="seccion seccion-gris">
  <div class="inner">
    <div class="contacto-grid">

      <!-- Columna izquierda: información -->
      <div class="contacto-info-col">

        <!-- Panel Coordinación General -->
        <div class="contacto-panel">
          <div class="contacto-panel-header">
            <i class="ti ti-headset"></i>
            <span>Coordinación General</span>
          </div>
          <div class="contacto-panel-body">
            <a href="tel:+526188271266" class="contacto-item-link">
              <span class="contacto-item-icon">
                <i class="ti ti-phone"></i>
              </span>
              <div>
                <div class="contacto-item-label">Teléfono</div>
                <div class="contacto-item-valor">618 827 1266</div>
              </div>
            </a>
            <a href="mailto:posgradofeca@ujed.mx" class="contacto-item-link">
              <span class="contacto-item-icon">
                <i class="ti ti-mail"></i>
              </span>
              <div>
                <div class="contacto-item-label">Correo electrónico</div>
                <div class="contacto-item-valor contacto-item-valor--sm">posgradofeca@ujed.mx</div>
              </div>
            </a>
          </div>
        </div>

        <!-- Panel Ubicación y horario -->
        <div class="contacto-panel">
          <div class="contacto-panel-header contacto-panel-header--dorado">
            <i class="ti ti-map-pin"></i>
            <span>Dónde encontrarnos</span>
          </div>
          <div class="contacto-panel-body">
            <div class="contacto-item-row">
              <span class="contacto-item-icon contacto-item-icon--dorado">
                <i class="ti ti-building-community"></i>
              </span>
              <div>
                <div class="contacto-item-label">Dirección</div>
                <div class="contacto-item-texto">Fanny Anitua s/n<br>Col. Los Ángeles · C.P. 34000<br><span class="contacto-item-texto-sub">Durango, Dgo.</span></div>
              </div>
            </div>
            <div class="contacto-divider"></div>
            <div class="contacto-item-row">
              <span class="contacto-item-icon contacto-item-icon--dorado">
                <i class="ti ti-clock"></i>
              </span>
              <div>
                <div class="contacto-item-label">Horario de atención</div>
                <div class="contacto-item-texto">Lunes a Viernes<br><strong>8:00 a.m. — 8:00 p.m.</strong><br>Sábados<br><strong>9:00 a.m. — 2:00 p.m.</strong></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Panel Redes sociales -->
        <div class="contacto-panel">
          <div class="contacto-panel-body contacto-panel-body--social">
            <div class="contacto-social-titulo">Síguenos en redes</div>
            <div class="contacto-social-row">
              <a href="https://www.facebook.com/FECAUJEDMX" target="_blank" rel="noopener" title="Facebook" class="contacto-social-link">
                <i class="ti ti-brand-facebook"></i> Facebook
              </a>
              <a href="https://x.com/fecaujedmx" target="_blank" rel="noopener" title="X / Twitter" class="contacto-social-link">
                <i class="ti ti-brand-x"></i> X
              </a>
              <a href="https://www.instagram.com/fecaujedmx" target="_blank" rel="noopener" title="Instagram" class="contacto-social-link">
                <i class="ti ti-brand-instagram"></i> Instagram
              </a>
              <a href="https://www.tiktok.com/@fecaujed.mx" target="_blank" rel="noopener" title="TikTok" class="contacto-social-link">
                <i class="ti ti-brand-tiktok"></i> TikTok
              </a>
            </div>
          </div>
        </div>

      </div><!-- /info rediseñada -->

      <!-- Columna derecha: formulario -->
      <div class="contacto-form-card">
        <h3>Envíanos un mensaje</h3>

        <form action="/php/tools/contacto_enviar.php" method="post" novalidate>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="c-nombre">Nombre *</label>
              <input type="text" id="c-nombre" name="nombre"
                     class="form-control" placeholder="Tu nombre completo" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="c-email">Correo electrónico *</label>
              <input type="email" id="c-email" name="email"
                     class="form-control" placeholder="tu@correo.com" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="c-asunto">Asunto *</label>
            <select id="c-asunto" name="asunto" class="form-control" required>
              <option value="" disabled selected>Selecciona un tema…</option>
              <option value="informacion">Información sobre programas</option>
              <option value="convocatoria">Convocatorias y admisión</option>
              <option value="titulacion">Proceso de titulación</option>
              <option value="investigacion">Investigación y publicaciones</option>
              <option value="comunidad">Recursos para alumnado o profesorado</option>
              <option value="otro">Otro</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="c-programa">Programa de interés</label>
            <select id="c-programa" name="programa" class="form-control">
              <option value="" selected>— Opcional —</option>
              <option value="DGO">Doctorado en Gestión de las Organizaciones</option>
              <option value="EAH">Especialidad en Administración de Hospitales</option>
              <option value="MAG">Maestría en Auditoría Gubernamental</option>
              <option value="ME">Maestría en Economía (SNP)</option>
              <option value="MEC">Maestría en Estrategias Contables</option>
              <option value="MGN">Maestría en Gestión de Negocios</option>
              <option value="MGP">Maestría en Gestión Pública</option>
              <option value="MM">Maestría en Mercadotecnia</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="c-mensaje">Mensaje *</label>
            <textarea id="c-mensaje" name="mensaje" class="form-control"
                      rows="5"
                      placeholder="Escribe aquí tu consulta o comentario…"
                      required></textarea>
          </div>

          <button type="submit" class="btn-submit">
            <i class="ti ti-send"></i> Enviar mensaje
          </button>

          <p class="form-nota">
            * Campos obligatorios. Responderemos en un plazo máximo de 2 días hábiles.
          </p>

        </form>
      </div><!-- /formulario -->

    </div><!-- /contacto-grid -->
  </div>
</section>

<!-- ===== MAPA / UBICACIÓN ===== -->
<section class="seccion seccion-blanca">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Cómo llegar</span>
      <h2>Nuestra Ubicación</h2>
      <p>División de Estudios de Posgrado · FECA · UJED · Campus Universitario, Durango</p>
    </div>

    <div class="contacto-mapa-wrap">
      <iframe
        src="https://maps.google.com/maps?q=UJED+-+Facultad+de+Economia,+Contaduria+y+Administracion&ll=24.0234569,-104.6793856&z=17&output=embed&hl=es"
        width="100%"
        height="100%"
        allowfullscreen
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="Ubicación FECA UJED · Fanny Anitua, Los Ángeles, Durango"
      ></iframe>
    </div>

    <div class="contacto-mapa-acciones">
      <a href="https://maps.app.goo.gl/nXJxduaTtp1vpBgR9"
         target="_blank" rel="noopener" class="btn-sm-rojo">
        <i class="ti ti-map-pin"></i> Abrir en Google Maps
      </a>
      <a href="#inicio" data-page="inicio"
         class="btn-sm-outline">
        <i class="ti ti-home"></i> Portal Posgrado
      </a>
    </div>

  </div>
</section>

<!-- ===== NAVEGACIÓN INFERIOR ===== -->
<nav class="page-nav-bottom">
  <div class="inner">
    <a href="#blog" class="pnb-prev" data-page="blog">
      <span class="pnb-arrow"><i class="ti ti-arrow-left"></i></span>
      <span class="pnb-info">
        <span class="pnb-dir">Anterior</span>
        <span class="pnb-name">Blog</span>
      </span>
    </a>
    <a href="#inicio" class="pnb-home" data-page="inicio" title="Volver a Inicio">
      <i class="ti ti-home"></i>
    </a>
    <a href="#inicio" class="pnb-next" data-page="inicio">
      <span class="pnb-info">
        <span class="pnb-dir">Volver al</span>
        <span class="pnb-name">Inicio</span>
      </span>
      <span class="pnb-arrow"><i class="ti ti-arrow-right"></i></span>
    </a>
  </div>
</nav>
