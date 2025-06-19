<?php
//Connexion à la BDD
try{
    $pdo = new PDO("mysql:host=localhost;dbname=admin_panel", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

//MISE A JOUR DE LA BD SELON LES DONNEES ENVOYER PAR LE FORMULAIRE

if ($_SERVER["REQUEST_METHOD"] === "POST"){

    //MISE A JOUR DES TEXTES DES HEBERGEMENTS
    //SECTION DU CHALET
    if(!empty($_POST['nouvtitreChalet'])){
        $nouvtitreChalet = $_POST['nouvtitreChalet'];
        $requete = $pdo->prepare("UPDATE section SET titre = :nouvtitreChalet WHERE id = 201;");
        $requete->bindValue(':nouvtitreChalet', $nouvtitreChalet);
        $requete->execute();
    }
    if(!empty($_POST['nouvtexteChalet'])){
        $nouvtexteChalet = $_POST['nouvtexteChalet'];
        $requete = $pdo->prepare("UPDATE section SET description = :nouvtexteChalet WHERE id = 201;");
        $requete->bindValue(':nouvtexteChalet', $nouvtexteChalet);
        $requete->execute();
    }

    //SECTION DU BATIMENT
    if(!empty($_POST['nouvtitreBatiment'])){
        $nouvtitreBatiment = $_POST['nouvtitreBatiment'];
        $requete = $pdo->prepare("UPDATE section SET titre = :nouvtitreBatiment WHERE id = 202;");
        $requete->bindValue(':nouvtitreBatiment', $nouvtitreBatiment);
        $requete->execute();
    }
    if(!empty($_POST['nouvtexteBatiment'])){
        $nouvtexteBatiment = $_POST['nouvtexteBatiment'];
        $requete = $pdo->prepare("UPDATE section SET description = :nouvtexteBatiment WHERE id = 202;");
        $requete->bindValue(':nouvtexteBatiment', $nouvtexteBatiment);
        $requete->execute();
    }

    //SECTION DE LA SALLE DE JEUX
    if(!empty($_POST['nouvtitreSalle'])){
        $nouvtitreSalle = $_POST['nouvtitreSalle'];
        $requete = $pdo->prepare("UPDATE section SET titre = :nouvtitreSalle WHERE id = 203;");
        $requete->bindValue(':nouvtitreSalle', $nouvtitreSalle);
        $requete->execute();
    }
    if(!empty($_POST['nouvtexteSalle'])){
        $nouvtexteSalle = $_POST['nouvtexteSalle'];
        $requete = $pdo->prepare("UPDATE section SET description = :nouvtexteSalle WHERE id = 203;");
        $requete->bindValue(':nouvtexteSalle', $nouvtexteSalle);
        $requete->execute();
    }








    //INITIALISATION DE LA VARIABLE DOSSIER
    $dossier = '../../Images/hebergement/';
    //IMAGES EN TETE DE LA PAGE DES HEBERGEMENTS
    //IMAGE DU CHALET
    if (!empty($_FILES['nouvimageChalet']) && $_FILES['nouvimageChalet']['error'] === 0){
        $nomFichier = basename($_FILES['nouvimageChalet']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['nouvimageChalet']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = 'Image global du chalet',image='Chalet' WHERE id = 201;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }
    //IMAGE DU BATIMENT
    if (!empty($_FILES['nouvimageBatiment']) && $_FILES['nouvimageBatiment']['error'] === 0){
        $nomFichier = basename($_FILES['nouvimageBatiment']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['nouvimageBatiment']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = 'Image global du batiment',image='Batiment' WHERE id = 202;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }
    //IMAGE DE LA SALLE DE JEUX
    if (!empty($_FILES['nouvimageSalle']) && $_FILES['nouvimageSalle']['error'] === 0){
        $nomFichier = basename($_FILES['nouvimageSalle']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['nouvimageSalle']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = 'Image global de la salle',image='Salle de jeux' WHERE id = 203;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }

    function uploadCarrousel(array $carrouselIds, string $prefixDescription, PDO $pdo, string $dossier) {
        foreach ($carrouselIds as $inputName => $id) {
            if (!empty($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
                $nomFichier = basename($_FILES[$inputName]['name']);
                $chemin = $dossier . $nomFichier;

                if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $chemin)) {
                    $verif = $pdo->prepare("SELECT COUNT(*) FROM multimedia WHERE id = ?");
                    $verif->execute([$id]);
                    if ($verif->fetchColumn() == 0) {
                        echo "<p style='color:red;'>ID $id manquant dans la base pour $inputName</p>";
                        continue;
                    }

                    $numero = substr($inputName, -1);
                    $description = "{$numero}ème image du carrousel {$prefixDescription}";

                    $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin, description = :description, image = :image WHERE id = :id");
                    $stmt->execute([
                        ':chemin' => $chemin,
                        ':description' => $description,
                        ':image' => $inputName,
                        ':id' => $id
                    ]);
                } else {
                    echo "<p style='color:red;'>Erreur lors du déplacement du fichier pour $inputName</p>";
                }
            } elseif (!empty($_FILES[$inputName]) && $_FILES[$inputName]['error'] !== UPLOAD_ERR_NO_FILE) {
                echo "<p style='color:orange;'>Erreur upload pour $inputName : code {$_FILES[$inputName]['error']}</p>";
            }
        }
    }

    $chaletIds = [
        'chaletcarrousel1' => 204,
        'chaletcarrousel2' => 205,
        'chaletcarrousel3' => 206,
        'chaletcarrousel4' => 207,
        'chaletcarrousel5' => 208,
        'chaletcarrousel6' => 209,
    ];
    uploadCarrousel($chaletIds, "du chalet", $pdo, $dossier);

    $batimentIds = [
        'batimentcarrousel1' => 210,
        'batimentcarrousel2' => 211,
        'batimentcarrousel3' => 212,
        'batimentcarrousel4' => 213,
        'batimentcarrousel5' => 214,
        'batimentcarrousel6' => 215,
    ];
    uploadCarrousel($batimentIds, "du bâtiment", $pdo, $dossier);

    $salleIds = [
        'sallecarrousel1' => 216,
        'sallecarrousel2' => 217,
        'sallecarrousel3' => 218,
        'sallecarrousel4' => 219,
        'sallecarrousel5' => 220,
        'sallecarrousel6' => 221,
    ];
    uploadCarrousel($salleIds, "de la salle de jeux", $pdo, $dossier);

    header("Location: TableauDeBordHebergements.php?success=1");
    exit;
}