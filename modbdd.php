<?php
    $db = new SQLite3('amazon2.db');
    $c_user = $_COOKIE["user"];
    $c_nom = $db->querySingle("SELECT nomclient FROM client WHERE mailclient='$c_user'");
    $action = $_GET['action'];
    $type = $_GET['type'];

    // Seulement si admin
    if ($c_nom != 'Administrateur' || $c_user != 'admin@admin.rt') {
        header('Location: index.php');
        exit();
    }

    if ($type == 'produit') {
        $ref = $_GET['ref'];
        if ($action == 'suppr') {
            $rm = "DELETE FROM article WHERE refarticle='$ref'";
            $exe = $db->exec($rm);
        }
    }

    elseif ($type == 'stock') {
        $ref = $_GET['ref'];
        $vendeur = $_GET['vendeur'];
        if ($action == 'suppr') {
            $rm = "DELETE FROM stock WHERE refarticle='$ref' AND refvendeur='$vendeur'";
            $exe = $db->exec($rm);
        }
    }

    elseif ($type == 'client') {
        $ref = $_GET['ref'];
        if ($action == 'suppr') {
            $rm = "DELETE FROM client WHERE refclient='$ref'";
            $exe = $db->exec($rm);
        }
    }

    elseif ($type == 'vendeur') {
        $ref = $_GET['ref'];
        if ($action == 'suppr') {
            $rm = "DELETE FROM vendeur WHERE refvendeur='$ref'";
            $exe = $db->exec($rm);
        }
    }
    
    header('Location: admin.php');
?>