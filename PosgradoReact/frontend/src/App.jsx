import { Routes, Route } from 'react-router-dom';
import Layout from './components/Layout.jsx';
import Home from './pages/Home.jsx';
import About from './pages/About.jsx';
import EducationalOffer from './pages/EducationalOffer.jsx';
import ProgramDetail from './pages/ProgramDetail.jsx';
import Research from './pages/Research.jsx';
import Community from './pages/Community.jsx';
import Blog from './pages/Blog.jsx';
import Contact from './pages/Contact.jsx';
import Announcements from './pages/Announcements.jsx';
import Publications from './pages/Publications.jsx';
import DisciplinaryGroups from './pages/DisciplinaryGroups.jsx';
import Transparency from './pages/Transparency.jsx';
import PrivacyNotice from './pages/PrivacyNotice.jsx';
import Terms from './pages/Terms.jsx';
import Sitemap from './pages/Sitemap.jsx';
import Titulacion from './pages/Titulacion.jsx';
import ProcesosAcademicos from './pages/ProcesosAcademicos.jsx';
import UnidadesAprendizaje from './pages/UnidadesAprendizaje.jsx';
import Profile from './pages/Profile.jsx';
import AdminLogin from './admin/AdminLogin.jsx';
import AdminPanel from './admin/AdminPanel.jsx';
import ContentCMS from './admin/ContentCMS.jsx';

// Portado de $pages + el switch de main.php: cada entrada de ese arreglo
// es ahora una <Route>. /admin/* queda fuera del <Layout> público porque
// panel.php y login.php ya traían su propio header/CSS, no el del sitio.
export default function App() {
  return (
    <Routes>
      <Route path="/admin/login" element={<AdminLogin />} />
      <Route path="/admin/panel" element={<AdminPanel />} />

      <Route element={<Layout />}>
        <Route path="/" element={<Home />} />
        <Route path="/nosotros" element={<About />} />
        <Route path="/oferta-educativa" element={<EducationalOffer />} />
        <Route path="/oferta-educativa/:slug" element={<ProgramDetail />} />
        <Route path="/investigacion" element={<Research />} />
        <Route path="/comunidad" element={<Community />} />
        <Route path="/blog" element={<Blog />} />
        <Route path="/contacto" element={<Contact />} />
        <Route path="/convocatorias" element={<Announcements />} />
        <Route path="/publicaciones" element={<Publications />} />
        <Route path="/grupos-disciplinares" element={<DisciplinaryGroups />} />
        <Route path="/transparencia" element={<Transparency />} />
        <Route path="/aviso-privacidad" element={<PrivacyNotice />} />
        <Route path="/terminos" element={<Terms />} />
        <Route path="/mapa-sitio" element={<Sitemap />} />
        <Route path="/titulacion" element={<Titulacion />} />
        <Route path="/procesos-academicos" element={<ProcesosAcademicos />} />
        <Route path="/unidades-aprendizaje" element={<UnidadesAprendizaje />} />
        <Route path="/perfil" element={<Profile />} />
        <Route path="/admin/contenido" element={<ContentCMS />} />
        <Route path="*" element={<Home />} />
      </Route>
    </Routes>
  );
}
