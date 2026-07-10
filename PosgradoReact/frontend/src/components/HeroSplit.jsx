import { useEffect, useRef, useState } from 'react';

// Portado del hero de dos columnas de Posgrado/pages/home.html
// (sección .hero-split) junto con el carrusel que antes vivía en un
// <script> inline: mismo comportamiento (autoplay 4.5s, flechas, dots),
// ahora como estado de React. `slides` reemplaza los data-conv-* del
// HTML original (título, badge, ícono y color por convocatoria real).
const DURACION_MS = 4500;

export default function HeroSplit({ titulo, subtitulo, stats, slides }) {
  const [current, setCurrent] = useState(0);
  const timerRef = useRef(null);

  const goTo = (idx) => {
    const total = slides.length;
    setCurrent(((idx % total) + total) % total);
  };

  const resetTimer = () => {
    clearInterval(timerRef.current);
    timerRef.current = setInterval(() => setCurrent((c) => (c + 1) % slides.length), DURACION_MS);
  };

  useEffect(() => {
    resetTimer();
    return () => clearInterval(timerRef.current);
  }, []);

  return (
    <section className="hero-split" id="hero-inicio">
      <div className="hero-split-inner">
        <div className="hero-split-content">
          <span className="hero-split-kicker">División de Estudios de Posgrado · FECA · UJED</span>
          <h1 className="hero-split-title" dangerouslySetInnerHTML={{ __html: titulo }} />
          <p className="hero-split-desc">{subtitulo}</p>
          <div className="hero-split-actions">
            <a href="#convocatorias" className="btn-primary">
              <i className="ti ti-file-text"></i> Ver Convocatorias
            </a>
            <a href="#nosotros" className="btn-outline-white">
              Conoce más
            </a>
          </div>
          <div className="hero-split-stats">
            {stats.map((s) => (
              <div className="hero-split-stat" key={s.label}>
                <div className="hero-split-stat-num">{s.num}</div>
                <div className="hero-split-stat-label">{s.label}</div>
              </div>
            ))}
          </div>
        </div>

        <div className="hero-split-visual" id="hero-split-visual">
          {slides.map((slide, i) => (
            <div key={slide.titulo} className={`hero-split-slide${i === current ? ' activo' : ''}`}>
              <div className="hero-split-media" style={{ '--tint1': slide.tint1, '--tint2': slide.tint2 }}>
                <i className={`ti ${slide.icono}`}></i>
              </div>
              <div className="hero-split-caption">
                <span className="hero-split-caption-kicker">{slide.badge}</span>
                <span className="hero-split-caption-title">{slide.titulo}</span>
              </div>
            </div>
          ))}

          <button
            className="hero-split-nav hero-split-nav-prev"
            aria-label="Convocatoria anterior"
            onClick={() => { goTo(current - 1); resetTimer(); }}
          >
            <i className="ti ti-chevron-left"></i>
          </button>
          <button
            className="hero-split-nav hero-split-nav-next"
            aria-label="Siguiente convocatoria"
            onClick={() => { goTo(current + 1); resetTimer(); }}
          >
            <i className="ti ti-chevron-right"></i>
          </button>

          <div className="hero-split-dots">
            {slides.map((slide, i) => (
              <button
                key={slide.titulo}
                className={`hero-split-dot${i === current ? ' activo' : ''}`}
                aria-label={`Ver ${slide.titulo}`}
                onClick={() => { goTo(i); resetTimer(); }}
              />
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
