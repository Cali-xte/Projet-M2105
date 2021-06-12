<?php
    $db = new SQLite3('amazon2.db');
    $c_user = $_COOKIE["user"];
    $c_nom = $db->querySingle("SELECT nomclient FROM client WHERE mailclient='$c_user'");
    $type = $_GET['type'];

    // Seulement si admin
    if ($c_nom != 'Administrateur' || $c_user != 'admin@admin.rt') {
        header('Location: index.php');
        exit();
    }

    if ($type == 'produit') {
        $ref = $_GET['ref'];
        $rm = "DELETE FROM article WHERE refarticle='$ref'";
        $exe = $db->exec($rm);
    }

    header('Location: admin.php');
?>