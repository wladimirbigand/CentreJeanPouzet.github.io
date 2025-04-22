CREATE DATABASE admin_panel;
use admin_panel;

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    identifiant varchar(50) NOT NULL,
    motdepasse varchar(255) NOT NULL
);

DROP TABLE page_accueil;
CREATE TABLE page_accueil (
    id INT PRIMARY KEY,
    image_fond VARCHAR(255) NOT NULL
);

INSERT INTO page_accueil (id, image_fond) VALUES (1, '/Images/Accueil/3.jpg');
SELECT image_fond FROM page_accueil WHERE id = 1;
ALTER TABLE page_accueil ADD COLUMN video_fond VARCHAR(255);
