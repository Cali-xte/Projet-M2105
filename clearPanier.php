<?php
    $db = new SQLite3('amazon2.db'); //Base de donnée
    $c_user = $_COOKIE["user"]; //Récupération cookie de conexion
    $querry = "DELETE FROM commande WHERE refclient=(SELECT refclient FROM client WHERE mailClient='$c_user') AND etat='Panier' "; //Requete SQL supprime "panier"
    $send= $db->exec($querry); //execution de la requete
    header('Location: /panier.php');  //redirection
?>
