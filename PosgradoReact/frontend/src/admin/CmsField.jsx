// Portado de buildField() en Posgrado/pages/admin.html. El tipo 'image'
// lee el archivo con FileReader y lo guarda como data URL directo en el
// item (igual que el original: no hay backend, todo vive en localStorage).
export default function CmsField({ field, value, onChange }) {
  const id = `mf-${field.id}`;
  const label = (
    <label className="form-label" htmlFor={id}>
      {field.label}{field.req ? ' *' : ''}
    </label>
  );

  if (field.type === 'image') {
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
          {value ? (
            <img className="admin-upload-preview" src={value} alt="" style={field.aspecto ? { aspectRatio: field.aspecto, objectFit: 'cover', width: '100%' } : undefined} />
          ) : (
            <i className="ti ti-upload"></i>
          )}
          <span>{value ? 'Haz clic para cambiar la imagen' : 'Haz clic o arrastra una imagen'}</span>
          <small style={{ fontSize: 11, color: '#bbb' }}>JPG, PNG o WEBP</small>
          <input type="file" id={id} accept="image/*" onChange={onFile} style={{ display: 'none' }} />
        </div>
      </div>
    );
  }

  if (field.type === 'textarea') {
    return (
      <div className="form-group">
        {label}
        <textarea id={id} className="form-control" rows={3} required={field.req} value={value || ''} onChange={(e) => onChange(e.target.value)} />
      </div>
    );
  }

  if (field.type === 'select') {
    return (
      <div className="form-group">
        {label}
        <select id={id} className="form-control" required={field.req} value={value || ''} onChange={(e) => onChange(e.target.value)}>
          <option value="">Seleccionar…</option>
          {field.options.map((o) => <option key={o} value={o}>{o}</option>)}
        </select>
      </div>
    );
  }

  return (
    <div className="form-group">
      {label}
      <input type={field.type} id={id} className="form-control" required={field.req} value={value || ''} onChange={(e) => onChange(e.target.value)} />
    </div>
  );
}
