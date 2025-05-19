CREATE DATABASE JeanPouzet;
use JeanPouzet;

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



CREATE TABLE IF NOT EXISTS equipe (
                                      id int auto_increment PRIMARY KEY,
                                      img VARCHAR(50) NOT NULL,
    name VARCHAR(50) NOT NULL,
    role VARCHAR(50) NOT NULL,
    description VARCHAR(700) NOT NULL
    );

INSERT INTO equipe (img, name, role, description) VALUES
                                                      ('Xavier.jpg', 'Xavier', 'Directeur de la structure', 'Xavier est salarié de l\'association et travaille à l\'intendance de la structure et à l\'accueil des groupes. Il sera votre interlocuteur particulier concernant les devis et les réservations (hors colonie Jean Pouzet).'),
('FABIENNE.jpg', 'Fabienne', 'Cheffe cuisinière', 'Fabienne est salariée de l\'association et s\'occupe de préparer avec ses équipes vos délicieux repas chauds et pique-niques. N\'hésitez pas à lui dire quand vous vous êtes régalé !'),
                                                      ('Olivier.png', 'Olivier', 'Président de l\'association', 'L\'histoire d\'amour entre Guchen et Olivier a commencé il y a un moment... Quand il est venu en colonie de vacances. Depuis, il a été colon, animateur, sous-directeur de la colonie et maintenant Président de l\'association. Demandez-lui les secrets du centre si vous le croisez, il en connaît un paquet !'),
                                                      ('Laurianne.png', 'Laurianne', 'Présidente adjointe', 'Elle est tombée dans la marmite enfant ! Tous ses frères et cousins ont été colons et animateurs... Étant la plus jeune, il a bien fallu qu\'elle continue dans les pas de ses anciens. Aujourd\'hui, Laurianne est animatrice sur les séjours d\'été et d\'hiver au centre, et s\'occupe de leur promotion et de leur organisation.'),
('Alice.png', 'Alice', 'Secrétaire générale', 'Ancienne colon et animatrice, Alice s\'occupe des réseaux sociaux et du digital de l\'association (n\'hésitez pas à nous taguer dans vos publications ou stories !) et participe à l\'organisation des séjours de colonies de vacances.'),
('Iana.png', 'Iana', 'Trésorière', 'Iana découvre l\'association lors d\'un séjour de colonie de vacances où elle est animatrice... Elle n\'a plus jamais coupé les ponts !'),
                                                       ('Marie-Agnès.png', 'Marie-Agnès', 'Secrétaire et trésorière', 'Ancienne colon, animatrice et maintenant secrétaire et trésorière de la colonie de vacances, Marie-Agnès vous contactera en cas d\'irrégularités. Attention !');
