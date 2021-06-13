<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="recherche.css">
    <link rel="icon" type="image/png" href="assets/logominibleu.png" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Amazon&sup2; </title>
</head>
<body>
    <?php
        $motcle = $_GET['motcle'];  // On récupère le(s) mot(s) clé(s) de recherche par GET
        $db = new SQLite3('amazon2.db');
        // On cherche une ligne de la base de données qui contient le mot-clé recherché:
        $rech = $db->query("SELECT * FROM article WHERE nomarticle LIKE '%$motcle%' or marque LIKE '%$motcle%' or categorie LIKE '%$motcle%' or refarticle LIKE '%$motcle%'");
        // On compte le nombre de résultats
        $nbrrech = $db->querySingle("SELECT count(*) FROM article WHERE nomarticle LIKE '%$motcle%' or marque LIKE '%$motcle%' or categorie LIKE '%$motcle%' or refarticle LIKE '%$motcle%'");
        ?>
    <header>
        <a href="index.php">
            <img src="assets/logo.png" alt="logo de l'entreprise" class="logo">
        </a>
        <form action="recherche.php" method="GET" class="recherche">
            <input type="text" name="motcle" class="ch_rez">
            <input type="submit" value="Rechercher" id="recherche">
            <input type="image" src="assets/chercher.png" alt="Submit Form" id  ="mobilButLink" />
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
            echo "<h1>{$nbrrech} résultats pour la recherche \"{$motcle}\" :</h1>"; // Affichage du nombre de résultats trouvés
            echo "<div class=listeprod>";
            while ($row = $rech->fetchArray()) {
                echo "<a href='produit.php?produit={$row[refarticle]}' class='divprod'>";   // Lien vers la page du produit
                echo "<center><img src='assets/produits/{$row[refarticle]}.png' alt='Image non disponible' class='imgproduit'><br>";    // Image
                echo "<div class='prodtext'>{$row[marque]} {$row[nomarticle]}</div></center>";  // Nom
                echo "</a>";
            }
            echo "</div>";
            ?>
    </div>
    <footer>
        <p class="foot-talk">Projet M2105</p>
        <p class="foot-talk">CLEMENTE Guillaume - MEUNIER Calixte</p>
        <p class="foot-talk">2020/2021</p>
    </footer>
</body>
</html>
