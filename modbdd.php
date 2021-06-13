<?php
    // Ce fichier contient les scripts de gestion de la base de donnée utilisés par la page d'administration

    $db = new SQLite3('amazon2.db');
    $c_user = $_COOKIE["user"];     // Récup utilisateur
    $c_nom = $db->querySingle("SELECT nomclient FROM client WHERE mailclient='$c_user'");   // Nom utilisateur
    $action = $_POST['action'];     // Action souhaitée (ajout/suppression)
    $type = $_POST['type'];         // Type (stock/client/vendeur)

    // Seulement si admin, sinon redirige vers la page principale
    if ($c_nom != 'Administrateur' || $c_user != 'admin@admin.rt') {
        header('Location: index.php');
        exit();
    }

    elseif ($type == 'stock') {             // Si l'admin souhaite agir sur le stock
        $ref = $_POST['ref'];               // On récupère la référence du produit
        $vendeur = $_POST['refvendeur'];    // On récupère son vendeur
        if ($action == 'suppr') {               // Si l'admin souhaite supprimer une ligne
            $rm = "DELETE FROM stock WHERE refarticle='$ref' AND refvendeur='$vendeur'";    // Préparation de la suppression
            $exe = $db->exec($rm);                                                          // Execution
        }
        elseif ($action == 'aj') {              // Si l'admin souhaite ajouter
            $qte = $_POST['qte'];               // Quelle quantité ? (peut être négative)
            $test = $db->querySingle("SELECT count(refarticle) FROM stock WHERE refarticle='$ref' AND refvendeur='$vendeur'"); // L'association produit/vendeur existe-t-elle ?
            if ($test == 0) {       // Si non
                $add = "INSERT INTO stock VALUES ('$ref', $qte, '$vendeur')"; // On crée une nouvelle ligne
                $exe = $db->exec($add);
            }
            elseif ($test != 0) {   // Si oui
                $count = $db->querySingle("SELECT qte FROM stock WHERE refarticle='$ref' AND refvendeur='$vendeur'");   // On regarde le stock correspondant
                $nouvtot = $count+$qte;                                                                                 // On calcule le nouveau stock
                $update = "UPDATE stock SET qte=$nouvtot WHERE refarticle='$ref' AND refvendeur='$vendeur'";            // On modifie la valeur correspondante dans la base de données
                $exe = $db->exec($update);
            }
        }
    }

    elseif ($type == 'client') {                // Si l'admin veut agir sur un client
        $ref = $_POST['ref'];                   // On récupère sa référence
        if ($action == 'suppr') {                   // S'il veut supprimer
            $rm = "DELETE FROM client WHERE refclient='$ref'";  // On supprime la ligne client correspondante
            $exe = $db->exec($rm);
        }
        elseif ($action == 'aj') {                  // S'il veut ajouter, on récupère les paramètres POST nécessaires :
            $nom = $_POST['nomclient'];
            $addr = $_POST['addrclient'];
            $mail = $_POST['mailclient'];
            $mdp = $_POST['mdpclient'];
            $add = "INSERT INTO client VALUES ('$nom', '$ref', '$mdp', '$addr', '$mail')";      // Et on l'ajoute à la base de données
            $exe = $db->exec($add);
        }
    }

    elseif ($type == 'vendeur') {               // Si l'admin veut agir sur un vendeur
        $ref = $_POST['ref'];                   // On récupère sa référence
        if ($action == 'suppr') {                   // S'il veut supprimer
            $rm = "DELETE FROM vendeur WHERE refvendeur='$ref'";    // On supprime la ligne correspondante
            $exe = $db->exec($rm);
        }
        elseif ($action == 'aj') {                  // S'il veut ajouter, on récupère les paramètres POST nécessaires :
            $nom = $_POST['nomvendeur'];
            $addr = $_POST['addrvendeur'];
            $mail = $_POST['mailvendeur'];
            $add = "INSERT INTO vendeur VALUES ('$nom', '$ref', '$addr', '$mail')";     // Et on l'ajoute à la base de données
            $exe = $db->exec($add);
        }
    }
    /* Dès que les demandes ont été traitées, on retourne vers la page d'administration
    Les tableaux sont ainsi recréés avec la base de donnée modifiée */
    header('Location: admin.php');
?>