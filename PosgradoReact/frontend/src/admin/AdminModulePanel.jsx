import { useEffect, useState } from 'react';
import ModuleField from './ModuleField.jsx';
import { CONTROL_MAESTRO_SEED } from '../data/controlMaestroSeed.js';

const STORAGE_KEY = 'dep_control_maestro_v1';

function cargarTodo() {
  try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || {}; } catch { return {}; }
}
function genId() { return Date.now() + Math.floor(Math.random() * 999); }
function trunc(s, n) { return (s || '').length > n ? `${s.slice(0, n)}…` : (s || ''); }

// Portado de renderizar_grid() + renderizar_formulario() en
// Posgrado/php/admin/modulos.php. Sin backend PHP conectado, este panel
// parte con los mismos datos reales que ya usa el sitio público
// (CONTROL_MAESTRO_SEED) y persiste los cambios en localStorage --
// mismo patrón que ContentCMS.jsx, para que "editable" sea real y no
// solo un formulario que no guarda nada.
export default function AdminModulePanel({ modulo, definicion }) {
  const [todo, setTodo] = useState(cargarTodo);
  const [formAbierto, setFormAbierto] = useState(false);
  const [editandoId, setEditandoId] = useState(null);
  const [valores, setValores] = useState({});

  useEffect(() => {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(todo));
  }, [todo]);

  const filas = todo[modulo] !== undefined ? todo[modulo] : (CONTROL_MAESTRO_SEED[modulo] || []);

  const abrirNuevo = () => {
    setEditandoId(null);
    setValores({});
    setFormAbierto(true);
  };

  const abrirEditar = (fila) => {
    setEditandoId(fila.id);
    setValores(fila);
    setFormAbierto(true);
  };

  const cerrarForm = () => {
    setFormAbierto(false);
    setEditandoId(null);
    setValores({});
  };

  const onGuardar = (e) => {
    e.preventDefault();
    const esNuevo = editandoId === null;
    const fila = esNuevo ? { ...valores, id: genId() } : { ...valores, id: editandoId };
    setTodo((prev) => ({
      ...prev,
      [modulo]: esNuevo ? [...filas, fila] : filas.map((f) => (f.id === editandoId ? fila : f)),
    }));
    cerrarForm();
  };

  const onEliminar = (id) => {
    if (!confirm('¿Eliminar este elemento? Esta acción no se puede deshacer.')) return;
    setTodo((prev) => ({ ...prev, [modulo]: filas.filter((f) => f.id !== id) }));
  };

  const campoImagen = definicion.campos.find((c) => ['imagen', 'documento'].includes(c.tipo))?.nombre;
  const campoDesc = definicion.campos.find((c) => c.tipo === 'textarea')?.nombre;
  const campoEstado = definicion.campos.find((c) => c.tipo === 'checkbox' && ['es_publicado', 'activo'].includes(c.nombre))?.nombre;

  return (
    <>
      {formAbierto && (
        <div className="admin-card" style={{ padding: '20px 22px', marginBottom: 26 }} id="formulario">
          <h3 style={{ marginTop: 0, fontFamily: "'Barlow Condensed',sans-serif", color: 'var(--rojo-oscuro)' }}>
            {editandoId === null ? 'Agregar ' : 'Editar '}{definicion.etiquetaItem}
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
            <button type="button" className="btn-outline-dark" onClick={cerrarForm}>Cancelar</button>
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
          {filas.map((fila) => {
            const imagenVal = campoImagen ? fila[campoImagen] : null;
            const esImagen = typeof imagenVal === 'string' && imagenVal;
            const publicado = campoEstado ? !!fila[campoEstado] : null;
            return (
              <div className="admin-card" key={fila.id}>
                {esImagen ? (
                  <img className="admin-card-img" src={imagenVal} alt="" />
                ) : (
                  <div className="admin-card-img-placeholder"><i className={`ti ${definicion.icono}`}></i></div>
                )}
                <div className="admin-card-body">
                  <div className="admin-card-title">{fila[definicion.tituloCampo] || ''}</div>
                  {campoDesc && fila[campoDesc] && (
                    <div className="admin-card-desc">{trunc(fila[campoDesc], 110)}</div>
                  )}
                  {publicado !== null && (
                    <span className={`admin-badge ${publicado ? 'admin-badge-vigente' : 'admin-badge-borrador'}`}>
                      {publicado ? 'Publicado' : 'Borrador'}
                    </span>
                  )}
                </div>
                <div className="admin-card-actions">
                  <button className="admin-btn-edit" onClick={() => abrirEditar(fila)}>
                    <i className="ti ti-pencil"></i> Editar
                  </button>
                  <button className="admin-btn-delete" title="Eliminar" onClick={() => onEliminar(fila.id)}>
                    <i className="ti ti-trash"></i>
                  </button>
                </div>
              </div>
            );
          })}
        </div>
      )}
    </>
  );
}
