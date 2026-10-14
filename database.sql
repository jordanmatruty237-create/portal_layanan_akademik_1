CREATE DATABASE IF NOT EXISTS portal_akademik CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portal_akademik;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  student_id VARCHAR(40) NULL,
  faculty VARCHAR(120) NULL,
  study_program VARCHAR(120) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS services (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL UNIQUE,
  description VARCHAR(500) NOT NULL,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS requests (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  service_id INT UNSIGNED NULL,
  service_name VARCHAR(120) NOT NULL,
  purpose VARCHAR(180) NOT NULL,
  details TEXT NULL,
  status ENUM('Menunggu','Diproses','Selesai','Ditolak') NOT NULL DEFAULT 'Menunggu',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_requests_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_requests_service FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL,
  INDEX idx_requests_status (status),
  INDEX idx_requests_created (created_at)
) ENGINE=InnoDB;

INSERT IGNORE INTO services (id,name,description,active) VALUES
(1,'Surat Aktif Kuliah','Permohonan surat keterangan mahasiswa aktif untuk keperluan administrasi, beasiswa, dan kebutuhan resmi lainnya.',1),
(2,'Transkrip Sementara','Permohonan transkrip nilai sementara untuk melengkapi dokumen akademik.',1),
(3,'Cuti Akademik','Permohonan cuti akademik beserta alasan dan informasi pendukung.',1),
(4,'Permohonan Legalisir','Permohonan legalisir dokumen akademik yang dibutuhkan mahasiswa.',1);

-- Demi keamanan, akun admin dibuat lewat langkah instalasi di README.md.
-- Jangan menyimpan password admin dalam file SQL yang dipublikasikan.
