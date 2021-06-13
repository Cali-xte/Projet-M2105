<?php
    $db = new SQLite3('amazon2.db');
    $c_user = $_COOKIE["user"];
    $c_nom= $db->querySingle("SELECT nomclient FROM client WHERE mailclient='$c_user'");
    $refclient= $db->querySingle("SELECT refclient FROM client WHERE mailclient='$c_user'");
    $prod = $_GET['produit'];
    $exist = $db->querySingle("SELECT refcommande FROM commande WHERE etat='Panier' AND refclient='$refclient' AND refarticle='$prod'");

    if ($c_nom != "") {

        if ($exist != "") {
            $qte = $db->querySingle("SELECT qte FROM commande WHERE refcommande='$exist'");
            $nqte = $qte + 1;
            $update = "UPDATE commande SET qte='$nqte' WHERE refcommande='$exist'";
            $exe = $db->exec($update);
            header('Location: ..');
        }else {
            $date = date("d/m/Y");
            $vendeur = $db->querySingle("SELECT refvendeur FROM Stock WHERE refarticle='$prod'");
            CreateCommande($prod,$refclient,$vendeur,$date);
            header('Location: ..');
        }  
    }else{
        header('Location: /connexion.php');
    }

    function CreateCommande($refart,$refcl,$refve,$date){ // Creer une ligne commande dans la BDD
        $db = new SQLite3('amazon2.db'); // BDD concernée
        $ref = GenRefClient(9); // Creation d'un id commande aléatoire 
        $querry = "INSERT INTO commande(refcommande, refarticle, refclient, refvendeur, qte, dateachat, etat) VALUES ('$ref', '$refart', '$refcl', '$refve', 1, '$date', 'Panier')"; // Requete SQL qui creer une nouvelle ligne dans la table commande
        $send = $db->exec($querry); // Execute la requete
    }

    function GenRefClient($length){ // Génère une chaine de caractère de n chiffre 
        $chars = '0123456789';
        $string = '';
        for($i=0; $i<$length; $i++){
            $string .= $chars[rand(0, strlen($chars)-1)];
        }
        return $string;
    }
?>