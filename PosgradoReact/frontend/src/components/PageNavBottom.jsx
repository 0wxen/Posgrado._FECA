import { NavLink } from 'react-router-dom';

// Portado de <nav class="page-nav-bottom"> repetido al final de cada
// página en Posgrado/php/pages/*.php (anterior / inicio / siguiente).
export default function PageNavBottom({ prev, next }) {
  return (
    <nav className="page-nav-bottom">
      <div className="inner">
        {prev ? (
          <NavLink to={prev.to} className="pnb-prev">
            <span className="pnb-arrow"><i className="ti ti-arrow-left"></i></span>
            <span className="pnb-info">
              <span className="pnb-dir">Anterior</span>
              <span className="pnb-name">{prev.label}</span>
            </span>
          </NavLink>
        ) : <span />}

        <NavLink to="/" className="pnb-home" title="Volver a Inicio">
          <i className="ti ti-home"></i>
        </NavLink>

        {next ? (
          <NavLink to={next.to} className="pnb-next">
            <span className="pnb-info">
              <span className="pnb-dir">Siguiente</span>
              <span className="pnb-name">{next.label}</span>
            </span>
            <span className="pnb-arrow"><i className="ti ti-arrow-right"></i></span>
          </NavLink>
        ) : <span />}
      </div>
    </nav>
  );
}
