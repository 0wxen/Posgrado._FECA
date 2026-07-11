import { useEffect } from 'react';
import { useLocation } from 'react-router-dom';

// Portado de registrarVisita() en Posgrado/js/cargar.js: cuenta visitas
// por sección en localStorage para alimentar la pestaña Estadísticas del
// panel de contenido (ContentCMS.jsx). Mismas claves que STATS_LABELS.
export const STATS_KEY = 'dep_stats_v1';

const RUTA_A_SECCION = {
  '/': 'inicio',
  '/nosotros': 'nosotros',
  '/oferta-educativa': 'oferta_educativa',
  '/investigacion': 'investigacion',
  '/comunidad': 'comunidad',
  '/blog': 'blog',
  '/contacto': 'contacto',
  '/convocatorias': 'convocatorias',
  '/publicaciones': 'publicaciones',
  '/transparencia': 'transparencia',
  '/titulacion': 'titulacion',
  '/grupos-disciplinares': 'grupos_disciplinares',
  '/perfil': 'perfil',
  '/admin/contenido': 'admin',
};

function seccionDeRuta(pathname) {
  if (RUTA_A_SECCION[pathname]) return RUTA_A_SECCION[pathname];
  if (pathname.startsWith('/oferta-educativa/')) return 'oferta_educativa';
  return null;
}

export function useVisitTracking() {
  const location = useLocation();

  useEffect(() => {
    const seccion = seccionDeRuta(location.pathname);
    if (!seccion) return;
    try {
      const stats = JSON.parse(localStorage.getItem(STATS_KEY) || '{}');
      stats[seccion] = (stats[seccion] || 0) + 1;
      localStorage.setItem(STATS_KEY, JSON.stringify(stats));
    } catch {
      // localStorage no disponible; no es crítico para navegar el sitio
    }
  }, [location.pathname]);
}
