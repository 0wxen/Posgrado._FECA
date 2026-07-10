import { useState } from 'react';
import ModuleField from './ModuleField.jsx';

// Portado de renderizar_grid() + renderizar_formulario() en
// Posgrado/php/admin/modulos.php. Sin API conectada todavía, la grilla
// siempre parte vacía -- mismo estado "Sin elementos todavía" que ya
// mostraba el PHP original cuando $pdo es null.
export default function AdminModulePanel({ modulo, definicion }) {
  const [filas] = useState([]); // CONTENIDO: filas reales vía GET /api/admin/:modulo
  const [formAbierto, setFormAbierto] = useState(false);
  const [valores, setValores] = useState({});

  const abrirNuevo = () => {
    setValores({});
    setFormAbierto(true);
  };

  const onGuardar = (e) => {
    e.preventDefault();
    // CONTENIDO: POST a /api/admin/:modulo (crear/editar), equivalente a guardar.php
    setFormAbierto(false);
  };

  return (
    <>
      {formAbierto && (
        <div className="admin-card" style={{ padding: '20px 22px', marginBottom: 26 }} id="formulario">
          <h3 style={{ marginTop: 0, fontFamily: "'Barlow Condensed',sans-serif", color: 'var(--rojo-oscuro)' }}>
            Agregar {definicion.etiquetaItem}
          </h3>
          <form onSubmit={onGuardar}>
            {definicion.campos.map((campo) => (
              <ModuleField
                key={campo.nombre}
                campo={campo}
                value={valores[campo.nombre]}
                onChange={(v) => setValores((prev) => ({ ...prev, [campo.nombre]: v }))}
              />
            ))}
            <button type="submit" className="btn-primary"><i className="ti ti-device-floppy"></i> Guardar</button>{' '}
            <button type="button" className="btn-outline-dark" onClick={() => setFormAbierto(false)}>Cancelar</button>
          </form>
        </div>
      )}

      <div className="admin-panel-hdr">
        <div className="admin-panel-hdr-left">
          <h3>{definicion.etiqueta}</h3>
          <span className="admin-count-badge">{filas.length} elemento{filas.length !== 1 ? 's' : ''}</span>
        </div>
        <button type="button" className="btn-sm-rojo" onClick={abrirNuevo}>
          <i className="ti ti-plus"></i> Agregar {definicion.etiquetaItem}
        </button>
      </div>

      {filas.length === 0 ? (
        <div className="admin-empty">
          <i className="ti ti-inbox"></i>
          <p>Sin elementos todavía.</p>
        </div>
      ) : (
        <div className="admin-grid">
          {/* CONTENIDO: tarjetas por fila (imagen, título, descripción, estado, editar/eliminar) */}
        </div>
      )}
    </>
  );
}
