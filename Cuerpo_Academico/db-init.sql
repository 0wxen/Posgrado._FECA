-- ══════════════════════════════════════════════════════════════════════
--  Inicialización de la base de datos — Cuerpos Académicos FECA
--  Ejecutar una sola vez: psql -U postgres -f db-init.sql
-- ══════════════════════════════════════════════════════════════════════

-- Crear la base de datos (ejecutar conectado a 'postgres')
-- CREATE DATABASE ca_feca;
-- \c ca_feca

-- ─── Tabla de usuarios ────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
    id            SERIAL PRIMARY KEY,
    username      VARCHAR(50)  UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role          VARCHAR(20)  NOT NULL DEFAULT 'editor'
                      CHECK (role IN ('admin', 'editor')),
    created_at    TIMESTAMPTZ  NOT NULL DEFAULT NOW()
);

-- ─── Usuario administrador por defecto ───────────────────────────────
-- Contraseña: admin123  (cámbiala inmediatamente tras el primer acceso)
-- Hash bcrypt generado con 10 rondas para "admin123"
INSERT INTO users (username, password_hash, role)
VALUES (
    'admin',
    '$2a$10$7EqJtq98hPqEX7fNZaFWoOe8LqPGpJe4oXH2e5MeE5uFxWcjfn5Ky',
    'admin'
)
ON CONFLICT (username) DO NOTHING;

-- ─── Tabla de sesiones (opcional, para auditoría) ─────────────────────
CREATE TABLE IF NOT EXISTS sessions (
    id         SERIAL PRIMARY KEY,
    user_id    INTEGER REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    ip_address VARCHAR(45),
    user_agent TEXT
);

-- ─── Índices ──────────────────────────────────────────────────────────
CREATE INDEX IF NOT EXISTS idx_users_username ON users(username);
CREATE INDEX IF NOT EXISTS idx_sessions_user  ON sessions(user_id);
