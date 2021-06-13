<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="produit.css">
    <link rel="icon" type="image/png" href="assets/logominibleu.png" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Amazon&sup2;</title>
</head>
<body>
    <?php
        $db = new SQLite3('amazon2.db');
        $produit = $_GET['produit'];        // On récupère la référence du produit demandé par GET
        $info = $db->query("SELECT * FROM article WHERE refarticle = '$produit'");  // On récupère les infos générales du produit
        $cat = $db->querySingle("SELECT categorie FROM article WHERE refarticle = '$produit'"); // On récupère sa catégorie
        $prod = $db->query("SELECT * FROM $cat WHERE refarticle = '$produit'");     // On récupère les infos spécifiques du produit
        $qte = $db->querySingle("SELECT qte FROM stock WHERE refarticle = '$produit'");     // On récupère le nombre de produits restants en stock
        $vendeur =  $db->query("SELECT * FROM vendeur WHERE refvendeur IN (SELECT refvendeur FROM stock WHERE refarticle = '$produit')");   // On regarde qui vend le produit

    ?>
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
        <a href="panier.php" class="iconsLink">
            <img src="assets/archiver.png" alt="panier" class="icons">
        </a>
    </header>
    <div class="main">
        <?php
            while ($data = $info->fetchArray()){
                echo "<div class='vue'>";
                echo "<h1>{$data['nomarticle']}</h1>";  // Nom du produit
                echo "<img class='imgprod' src='assets/produits/{$produit}.png' alt='Image non disponible'>";   // Photo
                echo "</div>";
                echo "<div class='vue'>";
                echo "<h2>{$data['prix']} &euro;</h2></div>";   // Prix
                echo "<div class='vue'>";
            }
        ?>
     
        <div class='vue'>   <!-- Affichage des caractéristiques -->
            <h2>Caract&eacute;ristiques</h2>
            <ul>
            <?php
                while ($list = $info->fetchArray()){
                    while ($spec = $prod->fetchArray()) {
                        if ($list['categorie'] == 'PABX') {     // Si c'est un pabx, on affiche les caractéristiques correspondantes
                            echo "<h3><li>Modulable : {$spec['modulable']}</li>";
                            echo "<li>Support de la téléphonie IP : {$spec['supportip']}</li>";
                            echo "<li>Nombre maximum de lignes téléphoniques (cartes d'extensions comprises) : {$spec['nblignesmax']} lignes</li></h3>";
                        }

                        if ($list['categorie'] == 'Fixe') {     // Idem pour un fixe
                            echo "<h3><li>Filaire : {$spec['filaire']}</li>";
                            echo "<li>Type : {$spec['type']}</li>";
                            echo "<li>Destiné à une utilisation {$spec['utilisation']}</li>";
                            echo "<li>Touches multifonctions : {$spec['touchefonction']}</li></h3>";
                        }
                
                        if ($list['categorie'] == 'Mobile') {   // Idem pour un mobile
                            echo "<h3><li>5g disponnible : {$spec['cinqg']}</li>";
                            echo "<li>Stockage : {$spec['stockage']} Go</li>";
                            echo "<li>RAM : {$spec['ram']} Go</li>";
                            echo "<li>OS : {$spec['os']}</li>";
                            echo "<li>Capacité de la batterie : {$spec['batterie']} mAh</li>";
                            echo "<li>Capteur photo : {$spec['photo']} Mpx</li></h3>";
                        }
                    }
                }
            ?>
            </ul>
            <?php
                echo "<div class='vue'><i>Vendu par :";
                while ($vend = $vendeur->fetchArray()) {    // Liste des vendeurs du produit
                    echo "<br>{$vend['nomvendeur']}";
                }
                echo "</i></div>";
                echo "<div class='vue'>{$qte} en stock</div>";  // Quantité en stock
            ?>
            
            
            <?php
                // Lien pour ajouter l'article au panier
                echo "<a href='complete.php?produit=$produit' method='get'><input type='submit' value='Ajouter au panier' id='ajoutpanier' onclick='myFunction()'></a>";
            ?>

        </div>
	<div id="snackbar">Ajouté au panier</div>
    </div>

    <footer>
        <p class="foot-talk">Projet M2105</p>
        <p class="foot-talk">CLEMENTE Guillaume - MEUNIER Calixte</p>
        <p class="foot-talk">2020/2021</p>
    </footer>

    <script>
        function myFunction() { // Confirmation d'ajout au panier
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        }
    </script>
</body>
</html>
