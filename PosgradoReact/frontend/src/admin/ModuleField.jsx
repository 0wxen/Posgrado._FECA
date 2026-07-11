// Portado de campo_input() en Posgrado/php/admin/modulos.php: un
// switch por tipo de campo que decide qué <input>/<select>/<textarea>
// dibujar. Aquí es un componente controlado; el valor real se maneja
// desde AdminModulePanel (useState), no desde PHP $_POST.
export default function ModuleField({ campo, value, onChange }) {
  const id = `f-${campo.nombre}`;
  const label = (
    <label className="form-label" htmlFor={id}>
      {campo.etiqueta}{campo.requerido ? ' *' : ''}
    </label>
  );

  switch (campo.tipo) {
    case 'textarea':
      return (
        <div className="form-group">
          {label}
          <textarea className="form-control" id={id} required={campo.requerido} value={value ?? ''} onChange={(e) => onChange(e.target.value)} />
        </div>
      );

    case 'html':
      return (
        <div className="form-group">
          {label}
          <textarea className="form-control" id={id} rows={10} value={value ?? ''} onChange={(e) => onChange(e.target.value)} />
          <small style={{ color: '#999' }}>Se permite HTML básico: párrafos, listas, negritas, enlaces, imágenes, tablas.</small>
        </div>
      );

    case 'select':
      return (
        <div className="form-group">
          {label}
          <select className="form-control" id={id} required={campo.requerido} value={value ?? ''} onChange={(e) => onChange(e.target.value)}>
            <option value="">Selecciona…</option>
            {Object.entries(campo.opciones).map(([val, etiqueta]) => (
              <option key={val} value={val}>{etiqueta}</option>
            ))}
          </select>
        </div>
      );

    case 'programa_id':
      // CONTENIDO: opciones reales cargadas desde la tabla `programas` vía API
      return (
        <div className="form-group">
          {label}
          <select className="form-control" id={id} value={value ?? ''} onChange={(e) => onChange(e.target.value)}>
            <option value="">— Ninguno —</option>
          </select>
        </div>
      );

    case 'checkbox':
      return (
        <div className="form-group">
          <label className="inline-field">
            <input type="checkbox" id={id} checked={!!value} onChange={(e) => onChange(e.target.checked)} /> Sí
          </label>
        </div>
      );

    case 'imagen':
    case 'documento': {
      const esImagenConValor = campo.tipo === 'imagen' && typeof value === 'string' && value;
      const onFile = (e) => {
        const file = e.target.files?.[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (ev) => onChange(ev.target.result);
        reader.readAsDataURL(file);
      };
      return (
        <div className="form-group">
          {label}
          <div className="admin-upload-zona" onClick={() => document.getElementById(id).click()}>
            {esImagenConValor ? (
              <img className="admin-upload-preview" src={value} alt="" />
            ) : (
              <>
                <i className="ti ti-upload"></i>
                <span>{value ? 'Archivo cargado' : 'Sin archivo todavía'}</span>
              </>
            )}
            <input
              type="file"
              id={id}
              accept={campo.tipo === 'imagen' ? 'image/*' : '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.png,.jpg,.jpeg,.gif,.webp'}
              style={{ display: 'none' }}
              onChange={onFile}
            />
          </div>
        </div>
      );
    }

    default: {
      const tipoInput = ['text', 'email', 'url', 'date', 'number'].includes(campo.tipo) ? campo.tipo : 'text';
      return (
        <div className="form-group">
          {label}
          <input type={tipoInput} className="form-control" id={id} required={campo.requerido} value={value ?? ''} onChange={(e) => onChange(e.target.value)} />
        </div>
      );
    }
  }
}
