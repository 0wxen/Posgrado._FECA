import { useEffect, useState } from 'react';
import PageBanner from '../components/PageBanner.jsx';

const STORAGE_KEY = 'dep_perfil_v1';
const VACIO = { nombres: '', apellidoP: '', apellidoM: '', email: '', telefono: '', fechaNac: '', curp: '', rol: '', programa: '', matricula: '', semestre: '', bio: '' };

function cargar() {
  try { return { ...VACIO, ...JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}') }; } catch { return VACIO; }
}

// Portado de Posgrado/pages/profile.html ("Mi Perfil"): editor de perfil
// en modo invitado que antes persistía en localStorage vía <script>
// inline; aquí es el mismo comportamiento con useState + useEffect.
export default function Profile() {
  const [datos, setDatos] = useState(cargar);
  const [editando, setEditando] = useState(false);
  const [borrador, setBorrador] = useState(datos);

  useEffect(() => {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(datos));
  }, [datos]);

  const nombreCompleto = [datos.nombres, datos.apellidoP, datos.apellidoM].filter(Boolean).join(' ') || 'Invitado';
  const campo = (v) => v || <span className="perfil-campo-vacio">Sin datos</span>;

  const onEditar = () => { setBorrador(datos); setEditando(true); };
  const onCancelar = () => setEditando(false);
  const onGuardar = (e) => { e.preventDefault(); setDatos(borrador); setEditando(false); };
  const onLimpiar = () => { setDatos(VACIO); localStorage.removeItem(STORAGE_KEY); };
  const onCambio = (campo) => (e) => setBorrador((b) => ({ ...b, [campo]: e.target.value }));

  return (
    <>
      <PageBanner title="Mi Perfil">
        <p className="page-banner-desc">
          Gestiona tu información personal y académica. Los cambios se sincronizarán con PostgreSQL una vez habilitada la conexión.
        </p>
      </PageBanner>

      <section className="seccion seccion-gris">
        <div className="inner">
          <div className="perfil-aviso-invitado">
            <i className="ti ti-info-circle"></i>
            <div>
              <strong>Modo de vista previa (sin sesión iniciada)</strong>
              Los datos que ingreses se almacenan localmente en tu navegador. La persistencia completa estará
              disponible al conectar con la base de datos PostgreSQL.
            </div>
          </div>

          <div className="perfil-layout">
            <aside className="perfil-sidebar">
              <div className="perfil-foto-card">
                <div className="perfil-foto-card-hdr">
                  <div className="perfil-avatar-wrap">
                    <div className="perfil-avatar"><i className="ti ti-user"></i></div>
                  </div>
                  <div className="perfil-nombre-display">{nombreCompleto}</div>
                  <div className="perfil-rol-badge">
                    <i className="ti ti-user-circle" style={{ fontSize: 13 }}></i>
                    <span>{datos.rol || 'Visitante'}</span>
                  </div>
                  <div className="perfil-db-chip">
                    <i className="ti ti-database-off"></i> Sin conexión a BD
                  </div>
                </div>
                <div className="perfil-foto-card-body">
                  <div className="perfil-stat-row">
                    <i className="ti ti-mail"></i>
                    <div><div className="perfil-stat-label">Correo</div><div className="perfil-stat-value">{datos.email || '—'}</div></div>
                  </div>
                  <div className="perfil-stat-row">
                    <i className="ti ti-building"></i>
                    <div><div className="perfil-stat-label">Programa</div><div className="perfil-stat-value">{datos.programa || '—'}</div></div>
                  </div>
                  <div className="perfil-stat-row">
                    <i className="ti ti-calendar"></i>
                    <div><div className="perfil-stat-label">Semestre / Generación</div><div className="perfil-stat-value">{datos.semestre || '—'}</div></div>
                  </div>
                </div>
              </div>

              <div className="perfil-sidebar-acciones">
                {!editando ? (
                  <button className="btn-sm-rojo" onClick={onEditar}><i className="ti ti-pencil"></i> Editar perfil</button>
                ) : (
                  <button className="btn-sm-outline" onClick={onCancelar}><i className="ti ti-x"></i> Cancelar</button>
                )}
                <button className="btn-outline-dark" onClick={onLimpiar} style={{ marginTop: 4 }} title="Eliminar datos locales">
                  <i className="ti ti-trash"></i> Limpiar datos
                </button>
              </div>

              <div className="perfil-crud-nota">
                <i className="ti ti-database"></i>
                <div>
                  <strong>CRUD con PostgreSQL</strong>
                  Crear, leer, actualizar y eliminar perfiles estará disponible al conectar con la base de datos institucional.
                </div>
              </div>
            </aside>

            <div>
              {!editando ? (
                <div className="perfil-card">
                  <div className="perfil-card-hdr">
                    <h2>Información del perfil</h2>
                    <span className="perfil-modo-tag perfil-modo-tag--lectura"><i className="ti ti-eye" style={{ fontSize: 12 }}></i> Lectura</span>
                  </div>
                  <div className="perfil-card-body">
                    <div className="perfil-seccion-titulo"><i className="ti ti-user"></i> Información Personal</div>
                    <div className="perfil-campos-grid">
                      <div className="perfil-campo"><span className="perfil-campo-label">Nombre(s)</span><span className="perfil-campo-valor">{campo(datos.nombres)}</span></div>
                      <div className="perfil-campo"><span className="perfil-campo-label">Apellido Paterno</span><span className="perfil-campo-valor">{campo(datos.apellidoP)}</span></div>
                      <div className="perfil-campo"><span className="perfil-campo-label">Apellido Materno</span><span className="perfil-campo-valor">{campo(datos.apellidoM)}</span></div>
                      <div className="perfil-campo"><span className="perfil-campo-label">Correo electrónico</span><span className="perfil-campo-valor">{campo(datos.email)}</span></div>
                      <div className="perfil-campo"><span className="perfil-campo-label">Teléfono</span><span className="perfil-campo-valor">{campo(datos.telefono)}</span></div>
                      <div className="perfil-campo"><span className="perfil-campo-label">Fecha de nacimiento</span><span className="perfil-campo-valor">{campo(datos.fechaNac)}</span></div>
                      <div className="perfil-campo"><span className="perfil-campo-label">CURP</span><span className="perfil-campo-valor">{campo(datos.curp)}</span></div>
                    </div>

                    <div className="perfil-seccion-titulo"><i className="ti ti-school"></i> Información Académica</div>
                    <div className="perfil-campos-grid">
                      <div className="perfil-campo"><span className="perfil-campo-label">Rol</span><span className="perfil-campo-valor">{campo(datos.rol)}</span></div>
                      <div className="perfil-campo"><span className="perfil-campo-label">Programa de Posgrado</span><span className="perfil-campo-valor">{campo(datos.programa)}</span></div>
                      <div className="perfil-campo"><span className="perfil-campo-label">Matrícula / Clave</span><span className="perfil-campo-valor">{campo(datos.matricula)}</span></div>
                      <div className="perfil-campo"><span className="perfil-campo-label">Semestre / Generación</span><span className="perfil-campo-valor">{campo(datos.semestre)}</span></div>
                    </div>

                    <div className="perfil-seccion-titulo"><i className="ti ti-notes"></i> Descripción</div>
                    <div style={{ fontSize: 14, color: '#666', lineHeight: 1.7, minHeight: 36 }}>
                      {datos.bio || <span className="perfil-campo-vacio">Sin descripción.</span>}
                    </div>
                  </div>
                </div>
              ) : (
                <div className="perfil-card">
                  <div className="perfil-card-hdr">
                    <h2>Editar perfil</h2>
                    <span className="perfil-modo-tag perfil-modo-tag--edicion"><i className="ti ti-pencil" style={{ fontSize: 12 }}></i> Edición</span>
                  </div>
                  <div className="perfil-card-body">
                    <form onSubmit={onGuardar} noValidate>
                      <div className="perfil-seccion-titulo"><i className="ti ti-user"></i> Información Personal</div>
                      <div className="perfil-form-grid">
                        <div className="form-group">
                          <label className="form-label">Nombre(s) *</label>
                          <input className="form-control" required placeholder="Ej. Juan Carlos" value={borrador.nombres} onChange={onCambio('nombres')} />
                        </div>
                        <div className="form-group">
                          <label className="form-label">Apellido Paterno *</label>
                          <input className="form-control" required placeholder="Ej. García" value={borrador.apellidoP} onChange={onCambio('apellidoP')} />
                        </div>
                        <div className="form-group">
                          <label className="form-label">Apellido Materno</label>
                          <input className="form-control" placeholder="Ej. López" value={borrador.apellidoM} onChange={onCambio('apellidoM')} />
                        </div>
                        <div className="form-group">
                          <label className="form-label">Correo electrónico *</label>
                          <input type="email" className="form-control" required placeholder="usuario@ujed.mx" value={borrador.email} onChange={onCambio('email')} />
                        </div>
                        <div className="form-group">
                          <label className="form-label">Teléfono</label>
                          <input type="tel" className="form-control" placeholder="(618) 000 0000" value={borrador.telefono} onChange={onCambio('telefono')} />
                        </div>
                        <div className="form-group">
                          <label className="form-label">Fecha de nacimiento</label>
                          <input type="date" className="form-control" value={borrador.fechaNac} onChange={onCambio('fechaNac')} />
                        </div>
                        <div className="form-group">
                          <label className="form-label">CURP</label>
                          <input className="form-control" maxLength={18} style={{ textTransform: 'uppercase' }} value={borrador.curp} onChange={(e) => setBorrador((b) => ({ ...b, curp: e.target.value.toUpperCase() }))} />
                        </div>
                      </div>

                      <div className="perfil-seccion-titulo" style={{ marginTop: 8 }}><i className="ti ti-school"></i> Información Académica</div>
                      <div className="perfil-form-grid">
                        <div className="form-group">
                          <label className="form-label">Rol</label>
                          <select className="form-control" value={borrador.rol} onChange={onCambio('rol')}>
                            <option value="">Seleccionar…</option>
                            <option>Estudiante</option>
                            <option>Docente</option>
                            <option>Administrativo</option>
                            <option>Investigador</option>
                            <option>Visitante</option>
                          </select>
                        </div>
                        <div className="form-group">
                          <label className="form-label">Programa de Posgrado</label>
                          <select className="form-control" value={borrador.programa} onChange={onCambio('programa')}>
                            <option value="">Seleccionar…</option>
                            <option value="Doctorado en Gestión de las Organizaciones">DGO</option>
                            <option value="Especialidad en Administración de Hospitales">EAH</option>
                            <option value="Maestría en Auditoría Gubernamental">MAG</option>
                            <option value="Maestría en Economía">ME</option>
                            <option value="Maestría en Estrategias Contables">MEC</option>
                            <option value="Maestría en Gestión de Negocios">MGN</option>
                            <option value="Maestría en Gestión Pública">MGP</option>
                            <option value="Maestría en Mercadotecnia">MM</option>
                          </select>
                        </div>
                        <div className="form-group">
                          <label className="form-label">Matrícula / Clave de empleado</label>
                          <input className="form-control" placeholder="Ej. 20-0000" value={borrador.matricula} onChange={onCambio('matricula')} />
                        </div>
                        <div className="form-group">
                          <label className="form-label">Semestre / Generación</label>
                          <input className="form-control" placeholder="Ej. 3er semestre · Gen. 2024" value={borrador.semestre} onChange={onCambio('semestre')} />
                        </div>
                      </div>

                      <div className="perfil-seccion-titulo" style={{ marginTop: 8 }}><i className="ti ti-notes"></i> Descripción personal</div>
                      <div className="form-group">
                        <label className="form-label">Bio breve</label>
                        <textarea className="form-control" rows={3} placeholder="Escribe una breve descripción sobre ti…" value={borrador.bio} onChange={onCambio('bio')} />
                      </div>

                      <div className="perfil-form-acciones">
                        <button type="submit" className="btn-primary"><i className="ti ti-device-floppy"></i> Guardar cambios</button>
                        <button type="button" className="btn-outline-dark" onClick={onCancelar}><i className="ti ti-x"></i> Cancelar</button>
                      </div>
                      <p style={{ fontSize: 11, color: '#ccc', marginTop: 14, textAlign: 'center' }}>
                        <i className="ti ti-database-off" style={{ fontSize: 12 }}></i> Los datos se guardan localmente. La sincronización con PostgreSQL estará disponible próximamente.
                      </p>
                    </form>
                  </div>
                </div>
              )}
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
