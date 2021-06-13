<?php
    $db = new SQLite3('amazon2.db');
    $c_user = $_COOKIE["user"];
    $c_nom = $db->querySingle("SELECT nomclient FROM client WHERE mailclient='$c_user'");
    $action = $_POST['action'];
    $type = $_POST['type'];

    // Seulement si admin
    if ($c_nom != 'Administrateur' || $c_user != 'admin@admin.rt') {
        header('Location: index.php');
        exit();
    }

    elseif ($type == 'stock') {
        $ref = $_POST['ref'];
        $vendeur = $_POST['refvendeur'];
        if ($action == 'suppr') {
            $rm = "DELETE FROM stock WHERE refarticle='$ref' AND refvendeur='$vendeur'";
            $exe = $db->exec($rm);
        }
        elseif ($action == 'aj') {
            $qte = $_POST['qte'];
            $test = $db->querySingle("SELECT count(refarticle) FROM stock WHERE refarticle='$ref' AND refvendeur='$vendeur'");
            if ($test == 0) {
                $add = "INSERT INTO stock VALUES ('$ref', $qte, '$vendeur')";
                $exe = $db->exec($add);
            }
            elseif ($test != 0) {
                $count = $db->querySingle("SELECT qte FROM stock WHERE refarticle='$ref' AND refvendeur='$vendeur'");
                $nouvtot = $count+$qte;
                $update = "UPDATE stock SET qte=$nouvtot WHERE refarticle='$ref' AND refvendeur='$vendeur'";
                $exe = $db->exec($update);
            }
        }
    }

    elseif ($type == 'client') {
        $ref = $_POST['ref'];
        echo $action;
        if ($action == 'suppr') {
            $rm = "DELETE FROM client WHERE refclient='$ref'";
            $exe = $db->exec($rm);
        }
        elseif ($action == 'aj') {
            $nom = $_POST['nomclient'];
            $addr = $_POST['addrclient'];
            $mail = $_POST['mailclient'];
            $mdp = $_POST['mdpclient'];
            $add = "INSERT INTO client VALUES ('$nom', '$ref', '$mdp', '$addr', '$mail')";
            $exe = $db->exec($add);
        }
    }

    elseif ($type == 'vendeur') {
        $ref = $_POST['ref'];
        if ($action == 'suppr') {
            $rm = "DELETE FROM vendeur WHERE refvendeur='$ref'";
            $exe = $db->exec($rm);
        }
        elseif ($action == 'aj') {
            $nom = $_POST['nomvendeur'];
            $addr = $_POST['addrvendeur'];
            $mail = $_POST['mailvendeur'];
            $add = "INSERT INTO vendeur VALUES ('$nom', '$ref', '$addr', '$mail')";
            $exe = $db->exec($add);
        }
    }
    
    header('Location: admin.php');
?>