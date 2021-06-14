<?php
    $db = new SQLite3('amazon2.db'); //BDD
    $c_user = $_COOKIE["user"]; // Récupération cookie connexion
    $c_nom= $db->querySingle("SELECT nomclient FROM client WHERE mailclient='$c_user'"); //Requete SQL recup nom d'utilisateur
    $refclient= $db->querySingle("SELECT refclient FROM client WHERE mailclient='$c_user'"); // Requete SQL recup refclient
    $prod = $_GET['produit']; //Récupération de l'id produit via l'url
    $exist = $db->querySingle("SELECT refcommande FROM commande WHERE etat='Panier' AND refclient='$refclient' AND refarticle='$prod'"); //Requete SQL voir si l'user a deja cet article dans le panier

    if ($c_nom != "") { // Si user est connecté

        if ($exist != "") { //Et si la commande du produit est deja dans le panier 
            $qte = $db->querySingle("SELECT qte FROM commande WHERE refcommande='$exist'"); //Récupération de la qte dans le panier
            $nqte = $qte + 1; //Calcul de la nouvelle quantite a commander
            $update = "UPDATE commande SET qte='$nqte' WHERE refcommande='$exist'"; // Requete SQL met a jour la quantitee 
            $exe = $db->exec($update); //execution de la requete
            header('Location: ..'); //redirection
        }else {
            $date = date("d/m/Y");//Si le produit n'est pas deja dans le panier du client
            $vendeur = $db->querySingle("SELECT refvendeur FROM Stock WHERE refarticle='$prod'"); //Requete SQL vendeur du produit
            CreateCommande($prod,$refclient,$vendeur,$date); // appel fonction creer une ligne 
            header('Location: ..'); //redirection
        }  
    }else{
        header('Location: /connexion.php'); // Si user non connecté redirection vers connexion
    }

    function CreateCommande($refart,$refcl,$refve,$date){ // Creer une ligne commande dans la BDD
        $db = new SQLite3('amazon2.db'); // BDD concernée
        $ref = GenRefClient(9); // Creation d'un id commande aléatoire appel fonction  
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
