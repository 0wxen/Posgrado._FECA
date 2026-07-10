// Portado del bloque <section class="page-banner"> repetido al inicio de
// cada página en Posgrado/php/pages/*.php. `title` es el único texto real
// que se conserva (es la etiqueta de navegación, no contenido editorial);
// la bajada/descripción de cada página es contenido y va como comentario.
export default function PageBanner({ title, children }) {
  return (
    <section className="page-banner">
      <div className="page-banner-inner">
        <span className="page-banner-kicker">FECA UJED · División de Estudios de Posgrado</span>
        <h1>{title}</h1>
        {/* CONTENIDO: bajada/descripción de esta página */}
        {children}
      </div>
    </section>
  );
}
