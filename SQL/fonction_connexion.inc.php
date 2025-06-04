<?php
function connectionPDO($param)
{
    include_once ($param.".inc.php");

    try {
        $idcom = new PDO('mysql:host='.HOST.';dbname='.NAME.';charset=utf8',USER,PASS);
        //echo "connection réussie";
        return $idcom;
    } catch (PDOException $e) {
        //echo "Erreur lors de la connexion à la base de donnée :".$e->getMessage();
        return false;
    }
}

?>

