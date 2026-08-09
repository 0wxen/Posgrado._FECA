<?php
declare(strict_types=1);

/**
 * Registro central de módulos "normales" del panel: cada uno es una
 * lista de filas con crear/editar/eliminar sobre UNA tabla real.
 * Este es el ÚNICO lugar donde un nombre de módulo (que sí puede venir
 * del navegador, vía ?tab= o POST modulo=) se traduce a un nombre de
 * tabla real -- guardar.php nunca construye SQL con un nombre de tabla
 * que no haya salido de aquí.
 *
 * "usuarios" e "imagenes" NO están aquí: usuarios necesita hashear
 * contraseña y solo lo puede ver el rol control_maestro; imagenes es
 * de clave fija (no se crean/borran filas). Ambos se manejan aparte
 * en panel.php / guardar.php.
 *
 * Tipos de campo soportados: text, textarea, html, date, email, url,
 * number, select, checkbox, imagen (sube a `archivos`, guarda su id),
 * documento (igual que imagen pero sin exigir que sea imagen),
 * programa_id / profesor_id (select con las opciones de esa tabla).
 */
const MODULOS = [

  'convocatorias' => [
    'tabla'     => 'convocatorias',
    'etiqueta'  => 'Convocatorias',
    'etiqueta_item' => 'Convocatoria',
    'icono'     => 'ti-file-text',
    'orden'     => 'fecha_cierre ASC NULLS LAST, creado_en DESC',
    'titulo_campo' => 'titulo',
    'campos' => [
      ['nombre' => 'titulo',              'etiqueta' => 'Título',                     'tipo' => 'text', 'requerido' => true],
      ['nombre' => 'programa_id',         'etiqueta' => 'Programa relacionado',       'tipo' => 'programa_id'],
      ['nombre' => 'ciclo',               'etiqueta' => 'Ciclo (Ej. A-2025)',         'tipo' => 'text'],
      ['nombre' => 'descripcion',         'etiqueta' => 'Descripción',                'tipo' => 'textarea'],
      ['nombre' => 'requisitos',          'etiqueta' => 'Requisitos',                 'tipo' => 'textarea'],
      ['nombre' => 'proceso_seleccion',   'etiqueta' => 'Proceso de selección',       'tipo' => 'textarea'],
      ['nombre' => 'fecha_inicio',        'etiqueta' => 'Inicio de registro',         'tipo' => 'date'],
      ['nombre' => 'fecha_cierre',        'etiqueta' => 'Límite de registro',         'tipo' => 'date'],
      ['nombre' => 'imagen_id',           'etiqueta' => 'Cartel (imagen)',            'tipo' => 'imagen'],
      ['nombre' => 'archivo_id',          'etiqueta' => 'Documento (PDF)',            'tipo' => 'documento'],
      ['nombre' => 'destacado',           'etiqueta' => 'Destacar en Inicio',         'tipo' => 'checkbox'],
      ['nombre' => 'es_publicado',        'etiqueta' => 'Publicar en el sitio',       'tipo' => 'checkbox'],
    ],
  ],

  'profesores' => [
    'tabla'     => 'profesores',
    'etiqueta'  => 'Nosotros',
    'etiqueta_item' => 'Profesor(a)',
    'icono'     => 'ti-users',
    'orden'     => 'orden_display, nombre',
    'titulo_campo' => 'nombre',
    'campos' => [
      ['nombre' => 'nombre',              'etiqueta' => 'Nombre completo',          'tipo' => 'text', 'requerido' => true],
      ['nombre' => 'titulo_cargo',        'etiqueta' => 'Cargo (Ej. Director, Profesor Investigador)', 'tipo' => 'text', 'requerido' => true],
      ['nombre' => 'grado_academico',     'etiqueta' => 'Grado académico',          'tipo' => 'text'],
      ['nombre' => 'especialidad',        'etiqueta' => 'Especialidad',             'tipo' => 'text'],
      ['nombre' => 'email',               'etiqueta' => 'Correo electrónico',       'tipo' => 'email'],
      ['nombre' => 'telefono_extension',  'etiqueta' => 'Teléfono / extensión',     'tipo' => 'text'],
      ['nombre' => 'orcid',               'etiqueta' => 'ORCID',                    'tipo' => 'text'],
      ['nombre' => 'google_scholar_url',  'etiqueta' => 'Google Scholar (URL)',     'tipo' => 'url'],
      ['nombre' => 'foto_id',             'etiqueta' => 'Fotografía',               'tipo' => 'imagen'],
      ['nombre' => 'orden_display',       'etiqueta' => 'Orden (menor = primero)',  'tipo' => 'number', 'evitar_null' => true],
      ['nombre' => 'activo',              'etiqueta' => 'Publicado en el sitio',    'tipo' => 'checkbox', 'defecto' => true],
    ],
  ],

  'oferta' => [
    'tabla'     => 'programas',
    'etiqueta'  => 'Oferta Educativa',
    'etiqueta_item' => 'Programa',
    'icono'     => 'ti-school',
    'orden'     => 'orden_display, nombre',
    'titulo_campo' => 'nombre',
    'campos' => [
      ['nombre' => 'codigo',             'etiqueta' => 'Código (Ej. DGO, ME)',        'tipo' => 'text',   'requerido' => true],
      ['nombre' => 'nombre',             'etiqueta' => 'Nombre completo',             'tipo' => 'text',   'requerido' => true],
      ['nombre' => 'nivel',              'etiqueta' => 'Nivel',                       'tipo' => 'select', 'opciones' => ['especialidad' => 'Especialidad', 'maestria' => 'Maestría', 'doctorado' => 'Doctorado'], 'requerido' => true],
      ['nombre' => 'modalidad',          'etiqueta' => 'Modalidad',                   'tipo' => 'select', 'opciones' => ['presencial' => 'Presencial', 'virtual' => 'Virtual', 'mixta' => 'Mixta'], 'requerido' => true],
      ['nombre' => 'duracion_semestres', 'etiqueta' => 'Duración (semestres)',        'tipo' => 'number'],
      ['nombre' => 'creditos',           'etiqueta' => 'Créditos',                    'tipo' => 'number'],
      ['nombre' => 'campo_formacion',    'etiqueta' => 'Campo de formación',          'tipo' => 'text'],
      ['nombre' => 'descripcion',        'etiqueta' => 'Descripción',                 'tipo' => 'textarea'],
      ['nombre' => 'objetivo',           'etiqueta' => 'Objetivo general',            'tipo' => 'textarea'],
      ['nombre' => 'perfil_ingreso',     'etiqueta' => 'Perfil de ingreso (un requisito por línea)', 'tipo' => 'textarea'],
      ['nombre' => 'perfil_egreso',      'etiqueta' => 'Perfil de egreso (una competencia por línea)', 'tipo' => 'textarea'],
      ['nombre' => 'acreditacion',       'etiqueta' => 'Acreditación (Ej. SNP · CONAHCYT)', 'tipo' => 'text'],
      ['nombre' => 'admision_nota',      'etiqueta' => 'Requisitos de admisión (paso 3, Ej. Curso propedéutico · Entrevista)', 'tipo' => 'text'],
      ['nombre' => 'imagen_id',          'etiqueta' => 'Imagen del programa',         'tipo' => 'imagen'],
      ['nombre' => 'orden_display',      'etiqueta' => 'Orden (menor = primero)',     'tipo' => 'number', 'evitar_null' => true],
      ['nombre' => 'activo',             'etiqueta' => 'Publicado en el sitio',       'tipo' => 'checkbox', 'defecto' => true],
    ],
  ],

  'titulacion' => [
    'tabla'     => 'programa_titulacion',
    'etiqueta'  => 'Oferta Educativa · Titulación',
    'etiqueta_item' => 'Modalidad de titulación',
    'icono'     => 'ti-certificate',
    'oculto_en_nav' => true, // se edita dentro del formulario del programa, no tiene tab propio
    'orden'     => 'programa_id, orden_display',
    'titulo_campo' => 'titulo',
    'campos' => [
      ['nombre' => 'programa_id',        'etiqueta' => 'Programa',                    'tipo' => 'programa_id', 'requerido' => true],
      ['nombre' => 'titulo',             'etiqueta' => 'Título (Ej. Tesis)',          'tipo' => 'text', 'requerido' => true],
      ['nombre' => 'icono',              'etiqueta' => 'Ícono (clase Tabler, ej. ti-file-text)', 'tipo' => 'text'],
      ['nombre' => 'descripcion',        'etiqueta' => 'Descripción',                 'tipo' => 'textarea'],
      ['nombre' => 'orden_display',      'etiqueta' => 'Orden (menor = primero)',     'tipo' => 'number', 'evitar_null' => true],
    ],
  ],

  'campo_laboral' => [
    'tabla'     => 'programa_campo_laboral',
    'etiqueta'  => 'Oferta Educativa · Campo Laboral',
    'etiqueta_item' => 'Sector laboral',
    'icono'     => 'ti-briefcase',
    'oculto_en_nav' => true, // se edita dentro del formulario del programa, no tiene tab propio
    'orden'     => 'programa_id, orden_display',
    'titulo_campo' => 'titulo',
    'campos' => [
      ['nombre' => 'programa_id',        'etiqueta' => 'Programa',                    'tipo' => 'programa_id', 'requerido' => true],
      ['nombre' => 'titulo',             'etiqueta' => 'Sector (Ej. Sector Público)', 'tipo' => 'text', 'requerido' => true],
      ['nombre' => 'icono',              'etiqueta' => 'Ícono (clase Tabler, ej. ti-building)', 'tipo' => 'text'],
      ['nombre' => 'descripcion',        'etiqueta' => 'Descripción breve',           'tipo' => 'text'],
      ['nombre' => 'orden_display',      'etiqueta' => 'Orden (menor = primero)',     'tipo' => 'number', 'evitar_null' => true],
    ],
  ],

  'investigacion' => [
    'tabla'     => 'grupos_disciplinares',
    'etiqueta'  => 'Investigación',
    'etiqueta_item' => 'Grupo disciplinar',
    'icono'     => 'ti-microscope',
    'orden'     => 'nombre',
    'titulo_campo' => 'nombre',
    'campos' => [
      ['nombre' => 'nombre',             'etiqueta' => 'Nombre',                          'tipo' => 'text', 'requerido' => true],
      ['nombre' => 'area_conocimiento',  'etiqueta' => 'Área de conocimiento',            'tipo' => 'text'],
      ['nombre' => 'descripcion',        'etiqueta' => 'Descripción / líneas de trabajo', 'tipo' => 'textarea'],
      ['nombre' => 'activo',             'etiqueta' => 'Publicado en el sitio',           'tipo' => 'checkbox', 'defecto' => true],
    ],
  ],

  'faq' => [
    'tabla'     => 'preguntas_frecuentes',
    'etiqueta'  => 'Preguntas Frecuentes',
    'etiqueta_item' => 'Pregunta',
    'icono'     => 'ti-help-circle',
    'oculto_en_nav' => true, // se edita dentro de la pestaña Comunidad, no tiene tab propio
    'orden'     => 'orden_display, id',
    'titulo_campo' => 'pregunta',
    'campos' => [
      ['nombre' => 'pregunta',      'etiqueta' => 'Pregunta',                'tipo' => 'text', 'requerido' => true],
      ['nombre' => 'respuesta',     'etiqueta' => 'Respuesta',               'tipo' => 'textarea', 'requerido' => true],
      ['nombre' => 'orden_display', 'etiqueta' => 'Orden (menor = primero)', 'tipo' => 'number', 'evitar_null' => true],
      ['nombre' => 'activo',        'etiqueta' => 'Publicar en el sitio',    'tipo' => 'checkbox', 'defecto' => true],
    ],
  ],

  'documentos' => [
    'tabla'     => 'documentos',
    'etiqueta'  => 'Comunidad',
    'etiqueta_item' => 'Documento',
    'icono'     => 'ti-users-group',
    'orden'     => 'orden_display, creado_en DESC',
    'titulo_campo' => 'titulo',
    'campos' => [
      ['nombre' => 'titulo',        'etiqueta' => 'Título',                  'tipo' => 'text', 'requerido' => true],
      ['nombre' => 'categoria',     'etiqueta' => 'Categoría',               'tipo' => 'select', 'opciones' => ['reglamento' => 'Reglamento', 'formato' => 'Formato', 'calendario' => 'Calendario', 'plan_estudios' => 'Plan de estudios', 'guia' => 'Guía', 'plantilla' => 'Plantilla', 'informe' => 'Informe', 'otro' => 'Otro'], 'requerido' => true],
      ['nombre' => 'audiencia',     'etiqueta' => 'Audiencia',               'tipo' => 'select', 'opciones' => ['todos' => 'Todos', 'alumnado' => 'Alumnado', 'profesorado' => 'Profesorado'], 'requerido' => true],
      ['nombre' => 'descripcion',   'etiqueta' => 'Descripción',             'tipo' => 'textarea'],
      ['nombre' => 'archivo_id',    'etiqueta' => 'Archivo descargable',     'tipo' => 'documento', 'requerido' => true],
      ['nombre' => 'orden_display', 'etiqueta' => 'Orden (menor = primero)', 'tipo' => 'number', 'evitar_null' => true],
      ['nombre' => 'es_publicado',  'etiqueta' => 'Publicar en el sitio',    'tipo' => 'checkbox', 'defecto' => true],
    ],
  ],

  'blog' => [
    'tabla'     => 'blog',
    'etiqueta'  => 'Blog / Noticias',
    'etiqueta_item' => 'Entrada',
    'icono'     => 'ti-news',
    'orden'     => 'destacado DESC, publicado_en DESC NULLS LAST',
    'titulo_campo' => 'titulo',
    'campos' => [
      ['nombre' => 'titulo',            'etiqueta' => 'Título',                  'tipo' => 'text', 'requerido' => true],
      ['nombre' => 'slug',              'etiqueta' => 'URL amigable (se genera sola si se deja vacía)', 'tipo' => 'text'],
      ['nombre' => 'resumen',           'etiqueta' => 'Resumen / extracto',      'tipo' => 'textarea'],
      ['nombre' => 'cuerpo',            'etiqueta' => 'Cuerpo de la nota',       'tipo' => 'html'],
      ['nombre' => 'autor_profesor_id', 'etiqueta' => 'Autor (profesor)',        'tipo' => 'profesor_id'],
      ['nombre' => 'fecha_evento',      'etiqueta' => 'Fecha del evento (si aplica)', 'tipo' => 'date'],
      ['nombre' => 'lugar_evento',      'etiqueta' => 'Lugar del evento',        'tipo' => 'text'],
      ['nombre' => 'imagen_id',         'etiqueta' => 'Imagen destacada',        'tipo' => 'imagen'],
      ['nombre' => 'destacado',         'etiqueta' => 'Destacar en Inicio',      'tipo' => 'checkbox'],
      ['nombre' => 'es_publicado',      'etiqueta' => 'Publicar en el sitio',    'tipo' => 'checkbox'],
    ],
  ],

  'publicaciones' => [
    'tabla'     => 'publicaciones',
    'etiqueta'  => 'Publicaciones',
    'oculto_en_nav' => true, // se edita dentro de la pestaña Investigación, no tiene tab propio
    'etiqueta_item' => 'Publicación',
    'icono'     => 'ti-book-2',
    'orden'     => 'anio DESC NULLS LAST, titulo',
    'titulo_campo' => 'titulo',
    'campos' => [
      ['nombre' => 'tipo',              'etiqueta' => 'Tipo',                     'tipo' => 'select', 'opciones' => ['articulo' => 'Artículo', 'capitulo' => 'Capítulo de libro', 'libro' => 'Libro', 'memoria' => 'Memoria de congreso', 'otro' => 'Otro'], 'requerido' => true],
      ['nombre' => 'titulo',            'etiqueta' => 'Título',                   'tipo' => 'text', 'requerido' => true],
      ['nombre' => 'autores_texto',     'etiqueta' => 'Autores (Ej. Pérez J., García M.)', 'tipo' => 'text', 'requerido' => true],
      ['nombre' => 'anio',              'etiqueta' => 'Año',                      'tipo' => 'number'],
      ['nombre' => 'revista_editorial', 'etiqueta' => 'Revista / editorial',      'tipo' => 'text'],
      ['nombre' => 'volumen_numero',    'etiqueta' => 'Volumen / número',         'tipo' => 'text'],
      ['nombre' => 'paginas',           'etiqueta' => 'Páginas',                  'tipo' => 'text'],
      ['nombre' => 'doi',               'etiqueta' => 'DOI',                      'tipo' => 'text'],
      ['nombre' => 'url_externo',       'etiqueta' => 'Enlace externo',           'tipo' => 'url'],
      ['nombre' => 'resumen',           'etiqueta' => 'Resumen',                  'tipo' => 'textarea'],
      ['nombre' => 'archivo_id',        'etiqueta' => 'Archivo (PDF)',            'tipo' => 'documento'],
      ['nombre' => 'es_publicado',      'etiqueta' => 'Publicar en el sitio',     'tipo' => 'checkbox', 'defecto' => true],
    ],
  ],

];
