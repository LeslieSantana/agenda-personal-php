-- EJECUTAR UNA SOLA VEZ sobre la base agenda_personal que ya contiene tus contactos.
-- Esta migración conserva los usuarios y contactos existentes.
USE agenda_personal;

CREATE TABLE IF NOT EXISTS categorias (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

INSERT IGNORE INTO categorias (nombre) VALUES
('Familia'), ('Amigos'), ('Trabajo'), ('Universidad'), ('Otro');

ALTER TABLE contactos
  ADD COLUMN id_categoria INT UNSIGNED NULL AFTER ciudad,
  ADD COLUMN favorito TINYINT(1) NOT NULL DEFAULT 0 AFTER id_categoria;

-- Los contactos anteriores se asignan a la categoría Otro.
UPDATE contactos
SET id_categoria = (SELECT id FROM categorias WHERE nombre = 'Otro' LIMIT 1)
WHERE id_categoria IS NULL;

ALTER TABLE contactos
  MODIFY COLUMN id_categoria INT UNSIGNED NOT NULL,
  ADD CONSTRAINT fk_contactos_categorias
    FOREIGN KEY (id_categoria) REFERENCES categorias(id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD INDEX idx_contactos_categoria (id_categoria),
  ADD INDEX idx_contactos_favorito (favorito);
