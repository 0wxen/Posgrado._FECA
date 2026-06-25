require('dotenv').config();
const express  = require('express');
const { Pool } = require('pg');
const bcrypt   = require('bcryptjs');
const jwt      = require('jsonwebtoken');
const multer   = require('multer');
const path     = require('path');
const fs       = require('fs');
const cors     = require('cors');

const app  = express();
const PORT = process.env.PORT || 3000;
const JWT_SECRET = process.env.JWT_SECRET || 'cambia_esta_clave_secreta';

// ─── PostgreSQL pool ───────────────────────────────────────────────────
const pool = new Pool({
    host:     process.env.DB_HOST     || 'localhost',
    port:     parseInt(process.env.DB_PORT || '5432', 10),
    database: process.env.DB_NAME     || 'ca_feca',
    user:     process.env.DB_USER     || 'postgres',
    password: process.env.DB_PASSWORD || 'postgres',
});

// ─── Multer (image uploads) ────────────────────────────────────────────
const uploadsDir = path.join(__dirname, 'uploads');
if (!fs.existsSync(uploadsDir)) fs.mkdirSync(uploadsDir, { recursive: true });

const storage = multer.diskStorage({
    destination: (_, __, cb) => cb(null, uploadsDir),
    filename:    (_, file, cb) => {
        const ext  = path.extname(file.originalname);
        const name = Date.now() + '-' + Math.round(Math.random() * 1e6) + ext;
        cb(null, name);
    }
});
const upload = multer({ storage, limits: { fileSize: 10 * 1024 * 1024 } }); // 10 MB

// ─── Content file path ─────────────────────────────────────────────────
const CONTENT_FILE = path.join(__dirname, 'content.json');

function readContent() {
    if (!fs.existsSync(CONTENT_FILE)) return null;
    try { return JSON.parse(fs.readFileSync(CONTENT_FILE, 'utf8')); }
    catch { return null; }
}

function writeContent(data) {
    fs.writeFileSync(CONTENT_FILE, JSON.stringify(data, null, 2), 'utf8');
}

// ─── Middleware ────────────────────────────────────────────────────────
app.use(cors());
app.use(express.json());
app.use(express.static(__dirname));           // serve HTML, CSS, JS files
app.use('/uploads', express.static(uploadsDir)); // serve uploaded images

// ─── Auth middleware ───────────────────────────────────────────────────
function requireAuth(req, res, next) {
    const header = req.headers['authorization'] || '';
    const token  = header.replace(/^Bearer\s+/i, '');
    if (!token) return res.status(401).json({ message: 'Token requerido' });
    try {
        req.user = jwt.verify(token, JWT_SECRET);
        next();
    } catch {
        res.status(401).json({ message: 'Token inválido o expirado' });
    }
}

// ─── Routes ───────────────────────────────────────────────────────────

// POST /api/auth/login — authenticate against PostgreSQL
app.post('/api/auth/login', async (req, res) => {
    const { username, password } = req.body || {};
    if (!username || !password) {
        return res.status(400).json({ message: 'Usuario y contraseña requeridos' });
    }
    try {
        const result = await pool.query(
            'SELECT id, username, password_hash, role FROM users WHERE username = $1 LIMIT 1',
            [username]
        );
        const user = result.rows[0];
        if (!user) {
            return res.status(401).json({ message: 'Credenciales incorrectas' });
        }
        const valid = await bcrypt.compare(password, user.password_hash);
        if (!valid) {
            return res.status(401).json({ message: 'Credenciales incorrectas' });
        }
        const token = jwt.sign(
            { id: user.id, username: user.username, role: user.role },
            JWT_SECRET,
            { expiresIn: '8h' }
        );
        res.json({ token, username: user.username, role: user.role });
    } catch (err) {
        console.error('DB error:', err.message);
        res.status(500).json({ message: 'Error interno del servidor' });
    }
});

// GET /api/content — public, returns current page content
app.get('/api/content', (req, res) => {
    const data = readContent();
    if (!data) return res.status(404).json({ message: 'Contenido no configurado aún' });
    res.json(data);
});

// PUT /api/content — protected, update page content
app.put('/api/content', requireAuth, (req, res) => {
    const data = req.body;
    if (!data || typeof data !== 'object') {
        return res.status(400).json({ message: 'Datos inválidos' });
    }
    writeContent(data);
    res.json({ message: 'Contenido actualizado correctamente' });
});

// POST /api/upload — protected, upload a single image
app.post('/api/upload', requireAuth, upload.single('image'), (req, res) => {
    if (!req.file) return res.status(400).json({ message: 'No se recibió imagen' });
    const relativePath = 'uploads/' + req.file.filename;
    res.json({ path: relativePath, filename: req.file.filename });
});

// GET /api/users — protected, list users (admin only)
app.get('/api/users', requireAuth, async (req, res) => {
    if (req.user.role !== 'admin') {
        return res.status(403).json({ message: 'Acceso denegado' });
    }
    const result = await pool.query('SELECT id, username, role, created_at FROM users ORDER BY id');
    res.json(result.rows);
});

// POST /api/users — protected, create new user
app.post('/api/users', requireAuth, async (req, res) => {
    if (req.user.role !== 'admin') {
        return res.status(403).json({ message: 'Acceso denegado' });
    }
    const { username, password, role = 'editor' } = req.body || {};
    if (!username || !password) {
        return res.status(400).json({ message: 'Usuario y contraseña requeridos' });
    }
    const hash = await bcrypt.hash(password, 10);
    try {
        await pool.query(
            'INSERT INTO users (username, password_hash, role) VALUES ($1, $2, $3)',
            [username, hash, role]
        );
        res.status(201).json({ message: 'Usuario creado' });
    } catch (err) {
        if (err.code === '23505') {
            res.status(409).json({ message: 'El usuario ya existe' });
        } else {
            res.status(500).json({ message: 'Error al crear usuario' });
        }
    }
});

// ─── Start ─────────────────────────────────────────────────────────────
app.listen(PORT, () => {
    console.log(`\n  Servidor CA-FECA corriendo en http://localhost:${PORT}`);
    console.log(`  Panel de admin: http://localhost:${PORT}/admin.html\n`);
});
