<?php
    $db = new SQLite3('amazon2.db');
    $c_user = $_COOKIE["user"];
    $querry = "DELETE FROM commande WHERE refclient=(SELECT refclient FROM client WHERE mailClient='$c_user') AND etat='Panier' ";
    $send= $db->exec($querry);
    header('Location: /panier.php');  
?>