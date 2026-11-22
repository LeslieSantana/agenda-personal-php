
CREATE TABLE IF NOT EXISTS usuarios (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  fecha_registro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categorias (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

INSERT IGNORE INTO categorias (nombre) VALUES
('Familia'), ('Amigos'), ('Trabajo'), ('Universidad'), ('Otro');

CREATE TABLE IF NOT EXISTS contactos (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT UNSIGNED NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  telefono VARCHAR(30) NOT NULL,
  correo VARCHAR(150) NULL,
  ciudad VARCHAR(100) NULL,
  id_categoria INT UNSIGNED NOT NULL,
  favorito TINYINT(1) NOT NULL DEFAULT 0,
  CONSTRAINT fk_contactos_usuarios
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_contactos_categorias
    FOREIGN KEY (id_categoria) REFERENCES categorias(id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  INDEX idx_contactos_usuario (id_usuario),
  INDEX idx_contactos_categoria (id_categoria),
  INDEX idx_contactos_favorito (favorito)
) ENGINE=InnoDB;
