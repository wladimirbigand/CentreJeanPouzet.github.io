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



    //IMAGES DES CAROUSSELS

    //CAROUSEL DU CHALET
    //IMAGE 1
    if (!empty($_FILES['chaletcarrousel1']) && $_FILES['chaletcarrousel1']['error'] === 0){
        $nomFichier = basename($_FILES['chaletcarrousel1']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['chaletcarrousel1']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '1er image du carrousel du chalet',image='chaletcarrousel1' WHERE id = 204;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }
    //IMAGE 2
    if (!empty($_FILES['chaletcarrousel2']) && $_FILES['chaletcarrousel2']['error'] === 0){
        $nomFichier = basename($_FILES['chaletcarrousel2']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['chaletcarrousel2']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '2eme image du carrousel du chalet',image='chaletcarrousel2' WHERE id = 205;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }

    //IMAGE 3
    if (!empty($_FILES['chaletcarrousel3']) && $_FILES['chaletcarrousel3']['error'] === 0){
        $nomFichier = basename($_FILES['chaletcarrousel3']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['chaletcarrousel3']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '3eme image du carrousel du chalet',image='chaletcarrousel3' WHERE id = 206;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }

    //IMAGE 4
    if (!empty($_FILES['chaletcarrousel4']) && $_FILES['chaletcarrousel4']['error'] === 0){
        $nomFichier = basename($_FILES['chaletcarrousel4']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['chaletcarrousel4']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '4eme image du carrousel du chalet',image='chaletcarrousel4' WHERE id = 207;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }

    //IMAGE 5
    if (!empty($_FILES['chaletcarrousel5']) && $_FILES['chaletcarrousel5']['error'] === 0){
        $nomFichier = basename($_FILES['chaletcarrousel5']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['chaletcarrousel5']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '5eme image du carrousel du chalet',image='chaletcarrousel5' WHERE id = 208;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }

    //IMAGE 6
    if (!empty($_FILES['chaletcarrousel6']) && $_FILES['chaletcarrousel6']['error'] === 0){
        $nomFichier = basename($_FILES['chaletcarrousel6']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['chaletcarrousel6']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '6eme image du carrousel du chalet',image='chaletcarrousel6' WHERE id = 209;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }


    //CAROUSEL DU BATIMENT
    //IMAGE 1
    if (!empty($_FILES['batimentcarrousel1']) && $_FILES['batimentcarrousel1']['error'] === 0){
        $nomFichier = basename($_FILES['batimentcarrousel1']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['batimentcarrousel1']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '1er image du carrousel du batiment',image='batimentcarrousel1' WHERE id = 210;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }
    //IMAGE 2
    if (!empty($_FILES['batimentcarrousel2']) && $_FILES['batimentcarrousel2']['error'] === 0){
        $nomFichier = basename($_FILES['batimentcarrousel2']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['batimentcarrousel2']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '2eme image du carrousel du batiment',image='batimentcarrousel2' WHERE id = 211;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }

    //IMAGE 3
    if (!empty($_FILES['batimentcarrousel3']) && $_FILES['batimentcarrousel3']['error'] === 0){
        $nomFichier = basename($_FILES['batimentcarrousel3']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['batimentcarrousel3']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '3eme image du carrousel du batiment',image='batimentcarrousel3' WHERE id = 212;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }

    //IMAGE 4
    if (!empty($_FILES['batimentcarrousel4']) && $_FILES['batimentcarrousel4']['error'] === 0){
        $nomFichier = basename($_FILES['batimentcarrousel4']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['batimentcarrousel4']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '4eme image du carrousel du batiment',image='batimentcarrousel4' WHERE id = 213;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }

    //IMAGE 5
    if (!empty($_FILES['batimentcarrousel5']) && $_FILES['batimentcarrousel5']['error'] === 0){
        $nomFichier = basename($_FILES['batimentcarrousel5']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['batimentcarrousel5']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '5eme image du carrousel du batiment',image='batimentcarrousel5' WHERE id = 214;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }

    //IMAGE 6
    if (!empty($_FILES['batimentcarrousel6']) && $_FILES['batimentcarrousel6']['error'] === 0){
        $nomFichier = basename($_FILES['batimentcarrousel6']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['batimentcarrousel6']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '6eme image du carrousel du batiment',image='batimentcarrousel6' WHERE id = 215;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }


    //CAROUSEL DE LA SALLE DE JEUX
    //IMAGE 1
    if (!empty($_FILES['sallecarrousel1']) && $_FILES['sallecarrousel1']['error'] === 0){
        $nomFichier = basename($_FILES['sallecarrousel1']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['sallecarrousel1']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '1er image du carrousel de la salle de jeux',image='sallecarrousel1' WHERE id = 216;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }
    //IMAGE 2
    if (!empty($_FILES['sallecarrousel2']) && $_FILES['sallecarrousel2']['error'] === 0){
        $nomFichier = basename($_FILES['sallecarrousel2']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['sallecarrousel2']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '2eme image du carrousel de la salle de jeux',image='sallecarrousel2' WHERE id = 217;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }

    //IMAGE 3
    if (!empty($_FILES['sallecarrousel3']) && $_FILES['sallecarrousel3']['error'] === 0){
        $nomFichier = basename($_FILES['sallecarrousel3']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['sallecarrousel3']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '3eme image du carrousel de la salle de jeux',image='sallecarrousel3' WHERE id = 218;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }

    //IMAGE 4
    if (!empty($_FILES['sallecarrousel4']) && $_FILES['sallecarrousel4']['error'] === 0){
        $nomFichier = basename($_FILES['sallecarrousel4']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['sallecarrousel4']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '4eme image du carrousel de la salle de jeux',image='sallecarrousel4' WHERE id = 219;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }

    //IMAGE 5
    if (!empty($_FILES['sallecarrousel5']) && $_FILES['sallecarrousel5']['error'] === 0){
        $nomFichier = basename($_FILES['sallecarrousel5']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['sallecarrousel5']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '5eme image du carrousel de la salle de jeux',image='sallecarrousel5' WHERE id = 220;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }

    //IMAGE 6
    if (!empty($_FILES['sallecarrousel6']) && $_FILES['sallecarrousel6']['error'] === 0){
        $nomFichier = basename($_FILES['sallecarrousel6']['name']);
        $chemin = $dossier . $nomFichier;

        if (move_uploaded_file($_FILES['sallecarrousel6']['tmp_name'], $chemin)) {
            $stmt = $pdo->prepare("UPDATE multimedia SET chemin_acces = :chemin,description = '6eme image du carrousel de la salle de jeux',image='sallecarrousel6' WHERE id = 221;");
            $stmt->bindValue(':chemin', $chemin);
            $stmt->execute();
        }
        else {
            echo "Erreur : " . $_FILES['image']['error'];
        }
    }
    header("Location: TableauDeBordHebergements.php?success=1");
    exit;
}