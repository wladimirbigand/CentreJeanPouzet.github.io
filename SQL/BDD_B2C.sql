DROP database IF exists admin_panel;
CREATE database IF NOT exists admin_panel;

use admin_panel;

DROP TABLE IF EXISTS Equipe;
DROP TABLE IF EXISTS Administrateur;
DROP TABLE IF EXISTS Section;
DROP TABLE IF EXISTS Multimedia;
DROP TABLE IF EXISTS Page;

-- Création de la table Administrateur
CREATE TABLE Administrateur (
    Identifiant VARCHAR(50) PRIMARY KEY,
    Mot_de_passe VARCHAR(255) NOT NULL
);

-- Table Colos
CREATE TABLE colos (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       titre VARCHAR(255),
                       affiche VARCHAR(255),
                       image1 VARCHAR(255),
                       image2 VARCHAR(255),
                       image3 VARCHAR(255),
                       image4 VARCHAR(255),
                       image5 VARCHAR(255),
                       image6 VARCHAR(255),
                       date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO colos (id, titre, affiche, image1, image2, image3, image4, image5, image6) VALUES
(1, "Colo d'été 2024","../../Images/Colos/Affiche%20séjour%202024%20été_page-0001.jpg",
"../../Images/Colos/photo%20été%201.jpeg","../../Images/Colos/photo%20été%202.jpeg",
"../../Images/Colos/photo%20été%204.jpeg","../../Images/Colos/IMG_6612.jpg",
"../../Images/Colos/photo%20été%206.jpeg","../../Images/Colos/photo%20été%207.jpeg"),

(2, "Colo d'hiver 2025", "../../Images/Colos/AFFICHE%20SKI%202025_page-0001.jpg",
"../../Images/PHOTOS VRAC COLO/IMG_8473.jpg","../../Images/PHOTOS VRAC COLO/IMG_8475.jpg",
"../../Images/PHOTOS VRAC COLO/IMG_8477.jpg","../../Images/PHOTOS VRAC COLO/IMG_8478.jpg",
"../../Images/PHOTOS VRAC COLO/IMG_8482.jpg","../../Images/PHOTOS VRAC COLO/IMG_8487.jpg");

-- Création de la table Section
CREATE TABLE Section (
    id INT PRIMARY KEY,
    titre VARCHAR(100),
    description TEXT
);

INSERT INTO Section (id, titre, description) VALUES
                                                 (1, 'Qui sommes-nous ?', 'Le Centre Jean Pouzet est avant tout une association loi 1901 qui a pour vocation de permettre à toutes et tous de découvrir la montagne.
                Le site se compose d''hébergements (82 places) et d''un parc boisé clôturé de 1,5ha. Il convient aussi bien à des classes de découvertes qu''à des grands groupes : groupes scolaires, particuliers, comités d’entreprises, clubs de sport et randonneurs peuvent se réunir chez nous et profiter de nos formules de pensions toute l’année.
                <br>
                Et vous… C’est quand qu’on vous y retrouve ?'),
                                                 (2, 'Où sommes-nous', 'Le Centre Jean Pouzet est situé au cœur de la Vallée d’Aure dans l’authentique village de Guchen, à 750m d’altitude !
                Aux portes du prestigieux Parc National des Pyrénées et à 6 km de Saint-Lary-Soulan la localisation du Centre offre des choix presque illimités d’activités ou de visites à faire à proximité toute l’année.
                Pour l’hiver, les premières stations de ski (Peyragudes, Saint-Lary-Soulan, Val-Louron, Piau-Engaly) se trouvent dans un rayon de 30 min.
                Pour l’été, outre le Tour de France qui passe quasiment chaque année devant la porte, des sociétés proposent du canyoning, du rafting, de l’accrobranche, de la trottinette, du VTT en montagne et de nombreux circuits de randonnées se font au départ du centre.… et beaucoup d’autres. Nos équipes se feront un plaisir de vous renseigner !
                Pour voir le détail des hébergements, rendez-vous dans l’onglet intitulé « hébergement » et pour toutes demandes de devis dans celui intitulé « nous contacter », à bientôt dans la vallée.');

-- Création de la table Multimédia
CREATE TABLE Multimedia (
    id INT PRIMARY KEY AUTO_INCREMENT,
    description TEXT,
    image VARCHAR(255),
    chemin_acces VARCHAR(255)
);

-- Création de la table Page
CREATE TABLE Page (
    id INT PRIMARY KEY,
    nom VARCHAR(100),
    id_multimedia INT,
    id_section INT,
    FOREIGN KEY (id_multimedia) REFERENCES Multimedia(id),
    FOREIGN KEY (id_section) REFERENCES Section(id)
);

CREATE TABLE IF NOT EXISTS Equipe (
    id int auto_increment unique PRIMARY KEY,
    img VARCHAR(50) unique NOT NULL,
    name VARCHAR(50) NOT NULL,
    role VARCHAR(50) NOT NULL,
    description VARCHAR(700) unique NOT NULL
    );

INSERT INTO Equipe (img, name, role, description) VALUES
                                                      ('Xavier.png', 'Xavier', 'Directeur de la structure', 'Xavier est salarié de l\'association et travaille à l\'intendance de la structure et à l\'accueil des groupes. Il sera votre interlocuteur particulier concernant les devis et les réservations (hors colonie Jean Pouzet).'),
('FABIENNE.jpg', 'Fabienne', 'Cheffe cuisinière', 'Fabienne est salariée de l\'association et s\'occupe de préparer avec ses équipes vos délicieux repas chauds et pique-niques. N\'hésitez pas à lui dire quand vous vous êtes régalé !'),
                                                      ('Olivier.png', 'Olivier', 'Président de l\'association', 'L\'histoire d\'amour entre Guchen et Olivier a commencé il y a un moment... Quand il est venu en colonie de vacances. Depuis, il a été colon, animateur, sous-directeur de la colonie et maintenant Président de l\'association. Demandez-lui les secrets du centre si vous le croisez, il en connaît un paquet !'),
                                                      ('Laurianne.png', 'Laurianne', 'Présidente adjointe', 'Elle est tombée dans la marmite enfant ! Tous ses frères et cousins ont été colons et animateurs... Étant la plus jeune, il a bien fallu qu\'elle continue dans les pas de ses anciens. Aujourd\'hui, Laurianne est animatrice sur les séjours d\'été et d\'hiver au centre, et s\'occupe de leur promotion et de leur organisation.'),
('Alice.png', 'Alice', 'Secrétaire générale', 'Ancienne colon et animatrice, Alice s\'occupe des réseaux sociaux et du digital de l\'association (n\'hésitez pas à nous taguer dans vos publications ou stories !) et participe à l\'organisation des séjours de colonies de vacances.'),
('Iana.png', 'Iana', 'Trésorière', 'Iana découvre l\'association lors d\'un séjour de colonie de vacances où elle est animatrice... Elle n\'a plus jamais coupé les ponts !'),
                                                       ('Marie-Agnès.png', 'Marie-Agnès', 'Secrétaire et trésorière', 'Ancienne colon, animatrice et maintenant secrétaire et trésorière de la colonie de vacances, Marie-Agnès vous contactera en cas d\'irrégularités. Attention !');

INSERT INTO Multimedia (description, image, chemin_acces) VALUES
-- Accueil
('image_accueil', '1.jpg',       '/Images/Accueil/1.jpg'),
('image_accueil', '2.jpg',       '/Images/Accueil/2.jpg'),
('image_accueil', '3.jpg',       '/Images/Accueil/3.jpg'),
('image_accueil', 'att.ZTpSPc5f1NLQimyKcQq8SvXkYlRJ3dfFtSyZy...png', '/Images/Accueil/att.ZTpSPc5f1NLQimyKcQq8SvXkYlRJ3dfFtSyZy...png'),
('image_accueil', 'B&W.png',     '/Images/Accueil/B&W.png'),
('image_accueil', 'B&W1.png',    '/Images/Accueil/B&W1.png'),
('image_accueil', 'B&W2.png',    '/Images/Accueil/B&W2.png'),
('image_accueil', 'JPrando.jpg', '/Images/Accueil/JPrando.jpg');

INSERT INTO Multimedia (description, image, chemin_acces) VALUES
-- Actus
('image_actus', '2025_ACTUS.jpg',        '/Images/Actus/2025_ACTUS.jpg'),
('image_actus', 'CLASSE_DECOUVERTE_1.jpg','/Images/Actus/CLASSE_DECOUVERTE_1.jpg'),
('image_actus', 'entreprises.jpg',       '/Images/Actus/entreprises.jpg'),
('image_actus', 'IMG_8602.JPG',          '/Images/Actus/IMG_8602.JPG'),
('image_actus', 'SAISON_HIVERNALE.JPG',  '/Images/Actus/SAISON_HIVERNALE.JPG'),
('image_actus', 'vélo.jpg',              '/Images/Actus/vélo.jpg');

INSERT INTO Multimedia (description, image, chemin_acces) VALUES
-- Équipe
('image_equipe', 'Alice.png',          '/Images/Equipe/Alice.png'),
('image_equipe', 'ALICE.webp',         '/Images/Equipe/ALICE.webp'),
('image_equipe', 'FABIENNE.jpg',       '/Images/Equipe/FABIENNE.jpg'),
('image_equipe', 'Fabienne.png',       '/Images/Equipe/Fabienne.png'),
('image_equipe', 'Fabienne.webp',      '/Images/Equipe/Fabienne.webp'),
('image_equipe', 'lana.jpg',           '/Images/Equipe/lana.jpg'),
('image_equipe', 'lana.png',           '/Images/Equipe/lana.png'),
('image_equipe', 'LAURIANNE.jpg',      '/Images/Equipe/LAURIANNE.jpg'),
('image_equipe', 'Laurianne.png',      '/Images/Equipe/Laurianne.png'),
('image_equipe', 'Marie-Agnès.jpeg',   '/Images/Equipe/Marie-Agnès.jpeg'),
('image_equipe', 'Marie-Agnès.png',    '/Images/Equipe/Marie-Agnès.png'),
('image_equipe', 'Olivier.jpeg',       '/Images/Equipe/Olivier.jpeg'),
('image_equipe', 'Olivier.png',        '/Images/Equipe/Olivier.png'),
('image_equipe', 'Xavier.jpg',         '/Images/Equipe/Xavier.jpg'),
('image_equipe', 'Xavier.png',         '/Images/Equipe/Xavier.png');

INSERT INTO Multimedia (description, image, chemin_acces) VALUES
-- Hebergement
('image_hebergement', 'batiment1.jpg', '/Images/hebergement/batiment1.jpg'),
('image_hebergement', 'batiment1.png', '/Images/hebergement/batiment1.png'),
('image_hebergement', 'batiment2.jpg', '/Images/hebergement/batiment2.jpg'),
('image_hebergement', 'batiment2.png', '/Images/hebergement/batiment2.png'),
('image_hebergement', 'batiment3.JPG', '/Images/hebergement/batiment3.JPG'),
('image_hebergement', 'batiment3.png', '/Images/hebergement/batiment3.png'),
('image_hebergement', 'batiment4.jpg', '/Images/hebergement/batiment4.jpg'),
('image_hebergement', 'batiment4.png', '/Images/hebergement/batiment4.png'),
('image_hebergement', 'batiment5.jpg', '/Images/hebergement/batiment5.jpg'),
('image_hebergement', 'batiment5.png', '/Images/hebergement/batiment5.png'),
('image_hebergement', 'batiment6.jpg', '/Images/hebergement/batiment6.jpg'),
('image_hebergement', 'batiment6.png', '/Images/hebergement/batiment6.png'),
('image_hebergement', 'batiment7.jpg', '/Images/hebergement/batiment7.jpg'),
('image_hebergement', 'batiment7.png', '/Images/hebergement/batiment7.png'),
('image_hebergement', 'batiment8.png', '/Images/hebergement/batiment8.png'),
('image_hebergement', 'batiment9.png', '/Images/hebergement/batiment9.png'),
('image_hebergement', 'batiment10.png', '/Images/hebergement/batiment10.png'),
('image_hebergement', 'batiment11.JPG', '/Images/hebergement/batiment11.JPG'),
('image_hebergement', 'batiment12.png', '/Images/hebergement/batiment12.png'),
('image_hebergement', 'batiment13.png', '/Images/hebergement/batiment13.png'),
('image_hebergement', 'batiment14.png', '/Images/hebergement/batiment14.png'),
('image_hebergement', 'chalet.jpg', '/Images/hebergement/chalet.jpg'),
('image_hebergement', 'chalet1.jpg', '/Images/hebergement/chalet1.jpg'),
('image_hebergement', 'chalet2.JPG', '/Images/hebergement/chalet2.JPG'),
('image_hebergement', 'chalet2.png', '/Images/hebergement/chalet2.png'),
('image_hebergement', 'chalet3.JPG', '/Images/hebergement/chalet3.JPG'),
('image_hebergement', 'chalet3.png', '/Images/hebergement/chalet3.png'),
('image_hebergement', 'chalet4.jpg', '/Images/hebergement/chalet4.jpg'),
('image_hebergement', 'chalet5.jpg', '/Images/hebergement/chalet5.jpg'),
('image_hebergement', 'chalet5.png', '/Images/hebergement/chalet5.png'),
('image_hebergement', 'chalet6.png', '/Images/hebergement/chalet6.png'),
('image_hebergement', 'chalet7.png', '/Images/hebergement/chalet7.png'),
('image_hebergement', 'chalet8.png', '/Images/hebergement/chalet8.png'),

-- Salle de jeux
('image_sallejeux', 'sallejeux1.JPG', '/Images/hebergement/sallejeux1.JPG'),
('image_sallejeux', 'sallejeux1.png', '/Images/hebergement/sallejeux1.png'),
('image_sallejeux', 'sallejeux2.jpg', '/Images/hebergement/sallejeux2.jpg'),
('image_sallejeux', 'sallejeux2.png', '/Images/hebergement/sallejeux2.png'),
('image_sallejeux', 'sallejeux3.jpg', '/Images/hebergement/sallejeux3.jpg'),
('image_sallejeux', 'sallejeux3.png', '/Images/hebergement/sallejeux3.png'),
('image_sallejeux', 'sallejeux4.jpg', '/Images/hebergement/sallejeux4.jpg'),
('image_sallejeux', 'sallejeux4.png', '/Images/hebergement/sallejeux4.png'),
('image_sallejeux', 'sallejeux5.jpg', '/Images/hebergement/sallejeux5.jpg'),
('image_sallejeux', 'sallejeux6.jpg', '/Images/hebergement/sallejeux6.jpg'),
('image_sallejeux', 'sallejeux6.png', '/Images/hebergement/sallejeux6.png');

INSERT INTO Multimedia (description, image, chemin_acces) VALUES
-- Logo
('image_logo', 'enveloppe.png', '/Images/Logo/enveloppe.png'),
('image_logo', 'Icone_Facebook.svg', '/Images/Logo/Icone_Facebook.svg'),
('image_logo', 'Icone_Instagram.svg', '/Images/Logo/Icone_Instagram.svg'),
('image_logo', 'JPLogo.png', '/Images/Logo/JPLogo.png'),
('image_logo', 'logo.png', '/Images/Logo/logo.png'),
('image_logo', 'LOGO good.webp', '/Images/Logo/LOGO good.webp'),
('image_logo', 'LOGO vectoriel.webp', '/Images/Logo/LOGO vectoriel.webp'),
('image_logo', 'LogoJeanPouzet.svg', '/Images/Logo/LogoJeanPouzet.svg'),
('image_logo', 'PNG-removebg-preview.png', '/Images/Logo/PNG-removebg-preview.png'),
('image_logo', 'telephone.png', '/Images/Logo/telephone.png');

INSERT INTO Multimedia (description, image, chemin_acces) VALUES
-- Mentions de confidentialité
('image_mentions', 'Guchen.jpeg', '/Images/Mentions_confidentialite/Guchen.jpeg'),
('image_mentions', 'Guchen.jpg', '/Images/Mentions_confidentialite/Guchen.jpg'),
('image_mentions', 'Photo_du_centre_avec_des_arbres.JPG', '/Images/Mentions_confidentialite/Photo_du_centre_avec_des_arbres.JPG');

INSERT INTO Multimedia (description, image, chemin_acces) VALUES
-- Photo archives
('image_archive', 'IMG_8011.HEIC', '/Images/Photo archives/IMG_8011.HEIC'),
('image_archive', 'IMG_8011.jpg', '/Images/Photo archives/IMG_8011.jpg'),
('image_archive', 'IMG_8459.heic', '/Images/Photo archives/IMG_8459.heic'),
('image_archive', 'IMG_8459.jpg', '/Images/Photo archives/IMG_8459.jpg'),
('image_archive', 'IMG_8463.HEIC', '/Images/Photo archives/IMG_8463.HEIC'),
('image_archive', 'IMG_8463.jpg', '/Images/Photo archives/IMG_8463.jpg'),
('image_archive', 'IMG_8464.HEIC', '/Images/Photo archives/IMG_8464.HEIC'),
('image_archive', 'IMG_8464.jpg', '/Images/Photo archives/IMG_8464.jpg'),
('image_archive', 'IMG_8469.heic', '/Images/Photo archives/IMG_8469.heic'),
('image_archive', 'IMG_8469.jpg', '/Images/Photo archives/IMG_8469.jpg'),
('image_archive', 'IMG_8470.HEIC', '/Images/Photo archives/IMG_8470.HEIC'),
('image_archive', 'IMG_8470.jpg', '/Images/Photo archives/IMG_8470.jpg'),
('image_archive', 'IMG_8473.jpg', '/Images/Photo archives/IMG_8473.jpg'),
('image_archive', 'IMG_8475.heic', '/Images/Photo archives/IMG_8475.heic'),
('image_archive', 'IMG_8475.jpg', '/Images/Photo archives/IMG_8475.jpg'),
('image_archive', 'IMG_8477.heic', '/Images/Photo archives/IMG_8477.heic'),
('image_archive', 'IMG_8477.jpg', '/Images/Photo archives/IMG_8477.jpg'),
('image_archive', 'IMG_8478.heic', '/Images/Photo archives/IMG_8478.heic'),
('image_archive', 'IMG_8478.jpg', '/Images/Photo archives/IMG_8478.jpg'),
('image_archive', 'IMG_8482.jpg', '/Images/Photo archives/IMG_8482.jpg'),
('image_archive', 'IMG_8487.heic', '/Images/Photo archives/IMG_8487.heic'),
('image_archive', 'IMG_8487.jpg', '/Images/Photo archives/IMG_8487.jpg'),
('image_archive', 'IMG_8488.jpg', '/Images/Photo archives/IMG_8488.jpg'),
('image_archive', 'IMG_8489.HEIC', '/Images/Photo archives/IMG_8489.HEIC'),
('image_archive', 'IMG_8489.jpg', '/Images/Photo archives/IMG_8489.jpg'),
('image_archive', 'IMG_8490.jpg', '/Images/Photo archives/IMG_8490.jpg');

INSERT INTO Multimedia (description, image, chemin_acces) VALUES
-- PHOTOS VRAC COLO
('image_vrac', 'IMG_6608.HEIC', '/Images/PHOTOS VRAC COLO/IMG_6608.HEIC'),
('image_vrac', 'IMG_6608.jpg', '/Images/PHOTOS VRAC COLO/IMG_6608.jpg'),
('image_vrac', 'IMG_6612.HEIC', '/Images/PHOTOS VRAC COLO/IMG_6612.HEIC'),
('image_vrac', 'IMG_6612.jpg', '/Images/PHOTOS VRAC COLO/IMG_6612.jpg'),
('image_vrac', 'IMG_6619.jpg', '/Images/PHOTOS VRAC COLO/IMG_6619.jpg'),
('image_vrac', 'IMG_6626.HEIC', '/Images/PHOTOS VRAC COLO/IMG_6626.HEIC'),
('image_vrac', 'IMG_6626.jpg', '/Images/PHOTOS VRAC COLO/IMG_6626.jpg'),
('image_vrac', 'IMG_6642.jpg', '/Images/PHOTOS VRAC COLO/IMG_6642.jpg'),
('image_vrac', 'IMG_8011.HEIC', '/Images/PHOTOS VRAC COLO/IMG_8011.HEIC'),
('image_vrac', 'IMG_8011.jpg', '/Images/PHOTOS VRAC COLO/IMG_8011.jpg'),
('image_vrac', 'IMG_8473.jpg', '/Images/PHOTOS VRAC COLO/IMG_8473.jpg'),
('image_vrac', 'IMG_8473.heic', '/Images/PHOTOS VRAC COLO/IMG_8473.heic'),
('image_vrac', 'IMG_8475.heic', '/Images/PHOTOS VRAC COLO/IMG_8475.heic'),
('image_vrac', 'IMG_8475.jpg', '/Images/PHOTOS VRAC COLO/IMG_8475.jpg'),
('image_vrac', 'IMG_8477.heic', '/Images/PHOTOS VRAC COLO/IMG_8477.heic'),
('image_vrac', 'IMG_8477.jpg', '/Images/PHOTOS VRAC COLO/IMG_8477.jpg'),
('image_vrac', 'IMG_8478.heic', '/Images/PHOTOS VRAC COLO/IMG_8478.heic'),
('image_vrac', 'IMG_8478.jpg', '/Images/PHOTOS VRAC COLO/IMG_8478.jpg'),
('image_vrac', 'IMG_8482.heic', '/Images/PHOTOS VRAC COLO/IMG_8482.heic'),
('image_vrac', 'IMG_8482.jpg', '/Images/PHOTOS VRAC COLO/IMG_8482.jpg'),
('image_vrac', 'IMG_8487.heic', '/Images/PHOTOS VRAC COLO/IMG_8487.heic'),
('image_vrac', 'IMG_8487.jpg', '/Images/PHOTOS VRAC COLO/IMG_8487.jpg'),
('image_vrac', 'IMG_8488.heic', '/Images/PHOTOS VRAC COLO/IMG_8488.heic'),
('image_vrac', 'IMG_8488.jpg', '/Images/PHOTOS VRAC COLO/IMG_8488.jpg'),
('image_vrac', 'IMG_8490.heic', '/Images/PHOTOS VRAC COLO/IMG_8490.heic'),
('image_vrac', 'IMG_8490.jpg', '/Images/PHOTOS VRAC COLO/IMG_8490.jpg'),
('image_vrac', '20230224_091417.jpg', '/Images/20230224_091417.jpg'),
('image_vrac', 'IMG_20230824_142853.jpg', '/Images/IMG_20230824_142853.jpg');

-- Emeric

INSERT INTO multimedia(id,description, image, chemin_acces)VALUES 
(200,'#', '#', '#'),
(201,'#', '#', '#'),
(202,'#', '#', '#'),
(203,'#', '#', '#'),
(204,'#', '#', '#'),
(205,'#', '#', '#'),
(206,'#', '#', '#'),
(207,'#', '#', '#'),
(208,'#', '#', '#'),
(209,'#', '#', '#'),
(210,'#', '#', '#'),
(211,'#', '#', '#'),
(212,'#', '#', '#'),
(213,'#', '#', '#'),
(214,'#', '#', '#'),
(215,'#', '#', '#'),
(216,'#', '#', '#'),
(217,'#', '#', '#'),
(218,'#', '#', '#'),
(219,'#', '#', '#'),
(220,'#', '#', '#');

INSERT INTO section(id,titre,description)VALUES 
(201,'#', '#'),
(202,'#', '#'),
(203,'#', '#');