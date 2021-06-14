<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="panier.css">
    <link rel="icon" type="image/png" href="assets/logominibleu.png" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Amazon&sup2; </title>
</head>
<?php
    $db = new SQLite3('amazon2.db'); //BDD
    $c_user = $_COOKIE["user"]; //Récupération cookie authentification
    //Requetes utiles
    $c_nom= $db->querySingle("SELECT nomclient FROM client WHERE mailclient='$c_user'"); 
    $nbarticle = $db->querySingle("SELECT count(*) FROM commande WHERE refclient=(SELECT refclient FROM client WHERE mailClient='$c_user') AND etat='Panier' ");
    $article = $db->query("SELECT * FROM article WHERE refarticle IN(SELECT refarticle FROM commande WHERE refclient=(SELECT refclient FROM client WHERE mailClient='$c_user') AND etat='Panier') ");
    $refclient= $db->querySingle("SELECT refclient FROM client WHERE mailclient='$c_user'");
?>
<body>
    <header>
        <a href="index.php">
            <img src="assets/logo.png" alt="logo de l'entreprise" class="logo">
        </a>
        <form action="recherche.php" method="GET" class="recherche">
            <input type="text" name="motcle" class="ch_rez">
            <input type="submit" value="Rechercher" id="recherche">
            <input type="image" src="assets/chercher.png" alt="Submit Form" id="mobilBut" />
        </form>
        
        <a href="connexion.php" class="iconsLink">
            <img src="assets/utilisateurs.png" alt="userImage" class="icons">
        </a>
        <a href="" class="iconsLink">
            <img src="assets/archiver.png" alt="panier" class="icons">
        </a>
    </header>
    <?php
        if ($c_nom == '') { //Si l'utilisateur n'est pas connecté le panier ne s'affiche pas 
            echo "<p class='msgnon'>Connectez vous pour accéder à votre panier</p>";
        }else{
            $totalht = 0; //Instanciation du prix hors taxes
            
            //Affichage du panier
            echo "<div class='parent'>";
            echo "<h1>Panier de $c_nom</h1>";
            $articletot = 0;
            while ($row = $article->fetchArray()) {
                echo "<div class='child'>";
                echo "<img src='assets/produits/{$row[refarticle]}.png' alt='Image Produit' class='imgproduit'>"; //Affiche l'image
                echo "<div class='prodNom'>{$row[marque]} {$row[nomarticle]}</div>"; //Afiche nom + marque
                $qte = $db->querySingle("SELECT qte FROM commande WHERE refarticle='$row[refarticle]' AND refclient='$refclient'"); //Requete SQL récupère la qte dans le panier de chaque article
                echo "Qte : x$qte"; //Affichage de la quantite dans le panier
                echo "<div class='prodPrix'>{$row[prix]} €</div>"; //Affiche le prix
                echo "</div>";
                $articletot += $qte; //Calcule le nombre d'article total
                $totalht += ($row['prix']*$qte); //Calcul du prix total en fonction de l'article et de sa quantitee
            }
            $tva = $totalht*0.20; // Calcul TVA (20%)
            $total = $totalht + $tva; //Prix total
            //echo "Prix HT : $totalht €<br>";
            //echo "TVA : $tva €<br>";
            echo "<p>Article dans le panier : $articletot</p>"; //Afiche nb article total 
            echo "<p class='total'>Total (TVA comprise) : $total €<br><br></p>"; // Prix a payer
            echo "<div class='decision' action='clearPanier.php'><input type='button' value='Acheter' id='buy'>"; //bouton acheter ! ne fonctionne pas ! -> utilisable ensuite
            echo "<a href='clearPanier.php'><input type='button' value='Vider Panier' id='clear' ></a></div>"; //bouton pour vider le panier
            echo "</div>";
        }

    ?>
    
    <footer>
        <p class="foot-talk">Projet M2105</p>
        <p class="foot-talk">CLEMENTE Guillaume - MEUNIER Calixte</p>
        <p class="foot-talk">2020/2021</p>
    </footer>
</body>
</html>
