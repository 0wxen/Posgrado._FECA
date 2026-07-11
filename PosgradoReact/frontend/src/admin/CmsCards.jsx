// Portado de los render*Card() de Posgrado/pages/admin.html: una
// tarjeta distinta por sección (convocatoria, persona, oferta,
// investigación, comunidad, blog), cada una con su propio diseño.
function trunc(s, n) {
  return (s || '').length > n ? `${s.slice(0, n)}…` : (s || '');
}

function CardActions({ sec, id, onEditar, onEliminar }) {
  return (
    <div className="admin-card-actions">
      <button className="admin-btn-edit" onClick={() => onEditar(sec, id)}>
        <i className="ti ti-pencil"></i> Editar
      </button>
      <button className="admin-btn-delete" title="Eliminar" onClick={() => onEliminar(sec, id)}>
        <i className="ti ti-trash"></i>
      </button>
    </div>
  );
}

// Aspecto horizontal (16:9), no vertical: las convocatorias reales del
// sitio (Inicio, Convocatorias) siempre se muestran como cartel ancho,
// nunca como retrato -- admin.html original asumía "cartel vertical 2:3"
// pero eso no coincide con cómo se usan de verdad las imágenes.
const CONV_IMG_STYLE = { aspectRatio: '16/9', objectFit: 'cover', objectPosition: 'top center', display: 'block', width: '100%' };

export function ConvocatoriaCard({ item, onEditar, onEliminar }) {
  const est = { vigente: 'vigente', 'próxima': 'proxima', proxima: 'proxima', cerrada: 'cerrada' }[(item.estado || '').toLowerCase()] || 'proxima';
  return (
    <div className="admin-card">
      {item.imagen ? <img src={item.imagen} alt="" style={CONV_IMG_STYLE} /> : <div className="admin-conv-img-ph" style={{ aspectRatio: '16/9' }}><i className="ti ti-file-text"></i></div>}
      <div className="admin-card-body">
        <div style={{ marginBottom: 5 }}><span className={`admin-badge admin-badge-${est}`}>{item.estado || 'Vigente'}</span></div>
        <div className="admin-card-title">{item.titulo}</div>
        {item.programa && <div className="admin-card-subtitle">{item.programa}</div>}
        <div className="admin-card-tags">
          {item.ciclo && <span className="admin-card-tag"><i className="ti ti-calendar"></i>{item.ciclo}</span>}
          {item.limite && <span className="admin-card-tag"><i className="ti ti-clock-hour-4"></i>Límite: {item.limite}</span>}
        </div>
      </div>
      <CardActions sec="convocatorias" id={item.id} onEditar={onEditar} onEliminar={onEliminar} />
    </div>
  );
}

export function PersonaCard({ item, onEditar, onEliminar }) {
  return (
    <div className="admin-card">
      {item.foto ? <img className="admin-person-img" src={item.foto} alt="" /> : <div className="admin-person-img-ph"><i className="ti ti-user"></i></div>}
      <div className="admin-card-body">
        <div className="admin-card-title">{item.nombre}</div>
        {item.cargo && <div className="admin-card-subtitle">{item.cargo}</div>}
        {item.area && <div style={{ margin: '3px 0' }}><span className="admin-card-tag"><i className="ti ti-building"></i>{item.area}</span></div>}
        {item.email && <div className="admin-card-desc" style={{ marginTop: 4, fontSize: 11 }}><i className="ti ti-mail" style={{ fontSize: 11, marginRight: 3, color: 'var(--dorado)' }}></i>{item.email}</div>}
      </div>
      <CardActions sec="nosotros" id={item.id} onEditar={onEditar} onEliminar={onEliminar} />
    </div>
  );
}

export function OfertaCard({ item, onEditar, onEliminar }) {
  const lvl = (item.nivel || '').toLowerCase().replace('é', 'e');
  return (
    <div className="admin-card">
      <div className={`admin-oferta-hdr admin-oferta-hdr--${lvl}`}>
        {item.imagen && <img className="admin-oferta-img-bg" src={item.imagen} alt="" />}
        <span className="admin-oferta-nivel-tag">{item.nivel}</span>
        <span className="admin-oferta-sigla-label">{item.sigla}</span>
        <span className="admin-oferta-sigla-deco">{item.sigla}</span>
      </div>
      <div className="admin-card-body">
        <div className="admin-card-title">{item.nombre}</div>
        {item.reconocimiento && (
          <div style={{ margin: '4px 0' }}>
            <span className="admin-badge" style={{ background: '#e3f2fd', color: '#1565c0', border: '1px solid #90caf9' }}>{item.reconocimiento}</span>
          </div>
        )}
        {item.descripcion && <div className="admin-card-desc">{trunc(item.descripcion, 80)}</div>}
        <div className="admin-card-tags">
          {item.duracion && <span className="admin-card-tag"><i className="ti ti-clock"></i>{item.duracion}</span>}
          {item.modalidad && <span className="admin-card-tag"><i className="ti ti-map-pin"></i>{item.modalidad}</span>}
        </div>
      </div>
      <CardActions sec="oferta" id={item.id} onEditar={onEditar} onEliminar={onEliminar} />
    </div>
  );
}

export function InvestCard({ item, onEditar, onEliminar }) {
  const tipoShort = (item.tipo || 'Investigación').replace('Cuerpo Académico ', 'CA ').replace('Grupo Disciplinar', 'GD');
  const lineas = (item.lineas || '').split('\n').filter(Boolean);
  return (
    <div className="admin-card">
      <div className="admin-invest-hdr">
        <span className="admin-invest-hdr-deco">CA</span>
        <i className="ti ti-microscope"></i>
        <span className="admin-invest-tipo-tag">{tipoShort}</span>
      </div>
      <div className="admin-card-body">
        <div className="admin-card-title">{item.nombre}</div>
        {item.prodep && <div style={{ margin: '4px 0' }}><span className="admin-card-tag"><i className="ti ti-award"></i>PRODEP: {item.prodep}</span></div>}
        {lineas.length > 0 && (
          <ul style={{ listStyle: 'none', display: 'flex', flexDirection: 'column', gap: 4, marginTop: 6 }}>
            {lineas.slice(0, 3).map((l) => (
              <li key={l} style={{ fontSize: 12, color: '#666', display: 'flex', alignItems: 'flex-start', gap: 6, lineHeight: 1.4 }}>
                <span style={{ width: 5, height: 5, borderRadius: '50%', background: 'var(--dorado)', flexShrink: 0, marginTop: 5 }}></span>
                {l}
              </li>
            ))}
            {lineas.length > 3 && <li style={{ fontSize: 11, color: '#bbb' }}>+{lineas.length - 3} más…</li>}
          </ul>
        )}
      </div>
      <CardActions sec="investigacion" id={item.id} onEditar={onEditar} onEliminar={onEliminar} />
    </div>
  );
}

export function ComunidadCard({ item, onEditar, onEliminar }) {
  const tipo = (item.tipo || 'otro').toLowerCase();
  const icon = { evento: 'calendar-event', recurso: 'file-description', servicio: 'tool', tutoria: 'user-check', otro: 'star' }[tipo] || 'star';
  return (
    <div className="admin-card">
      <div className={`admin-comunidad-hdr admin-comunidad-hdr--${tipo}`}>
        {item.imagen && <img src={item.imagen} alt="" />}
        <i className={`ti ti-${icon}`}></i>
        <span className="admin-comunidad-tipo-txt">{item.tipo || 'Comunidad'}</span>
      </div>
      <div className="admin-card-body">
        <div className="admin-card-title">{item.titulo}</div>
        {item.categoria && <div className="admin-card-subtitle">{item.categoria}</div>}
        {item.fecha && <div className="admin-card-meta" style={{ marginTop: 3 }}><i className="ti ti-calendar" style={{ fontSize: 11 }}></i> {item.fecha}</div>}
        {item.descripcion && <div className="admin-card-desc">{trunc(item.descripcion, 85)}</div>}
      </div>
      <CardActions sec="comunidad" id={item.id} onEditar={onEditar} onEliminar={onEliminar} />
    </div>
  );
}

export function BlogCard({ item, onEditar, onEliminar }) {
  return (
    <div className="admin-card">
      {item.imagen ? <img className="admin-blog-img" src={item.imagen} alt="" /> : <div className="admin-blog-img-ph"><i className="ti ti-news"></i></div>}
      <div className="admin-card-body">
        <div className="admin-card-meta">
          {item.categoria && <span className="meta-cat">{item.categoria}</span>}
          {item.fecha && <span>{item.fecha}</span>}
        </div>
        <div className="admin-card-title" style={{ fontSize: 17 }}>{item.titulo}</div>
        {item.extracto && <div className="admin-card-desc">{trunc(item.extracto, 90)}</div>}
      </div>
      <CardActions sec="blog" id={item.id} onEditar={onEditar} onEliminar={onEliminar} />
    </div>
  );
}

export const RENDERERS = {
  convocatorias: ConvocatoriaCard,
  nosotros: PersonaCard,
  oferta: OfertaCard,
  investigacion: InvestCard,
  comunidad: ComunidadCard,
  blog: BlogCard,
};
