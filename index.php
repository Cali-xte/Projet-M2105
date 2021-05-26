<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" type="image/png" href="assets/logominibleu.png" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Amazon&sup2; </title>
</head>
<body>
    <?php
        $db = new SQLite3('amazon2.db');
        $pabx = $db->query('SELECT nomarticle FROM article WHERE categorie = "PABX"');
        $fixe = $db->query('SELECT nomarticle FROM article WHERE categorie = "Fixe"');
        $mobi = $db->query('SELECT nomarticle FROM article WHERE categorie = "Mobile"');
        $cat = $db->query('SELECT DISTINCT categorie FROM article');
        ?>
    <header>
        <img src="assets/logo.png" alt="logo de l'entreprise" class="logo">
        <form action="" method="GET" class="recherche">
            <input type="text" name="barre_recherche" class="ch_rez">
            <input type="button" value="Rechercher" id="recherche">
            <a href="assets/chercher.png" id="mobilButLink">
                <img src="assets/chercher.png" alt="reserch button" id="mobilBut">
            </a>
        </form>
        
        <a href="connexion.html" class="iconsLink">
            <img src="assets/utilisateurs.png" alt="userImage" class="icons">
        </a>
        <a href="assets/archiver.png" class="iconsLink">
            <img src="assets/archiver.png" alt="panier" class="icons">
        </a>
    </header>

    <ul>
        <?php
            while ($list = $cat->fetchArray()) {
                echo "<h1><li>Nos {$list['categorie']}s</li></h1>";
                echo "<div class=listeprod>";
                if ($list['categorie'] == "PABX") {
                    while ($row = $pabx->fetchArray()) {
                    echo "<div class = divprod>";
                    echo "<center><img src='assets/pabxtest.jpeg' alt='produit' class='imgproduit'><br>";
                    echo "{$row[nomarticle]}</center>";
                    echo "</div>";
                    }
                }
                if ($list['categorie'] == "Fixe") {
                    while ($row = $fixe->fetchArray()) {
                    echo "<div class = divprod>";
                    echo "<center><img src='assets/fixetest.png' alt='produit' class='imgproduit'><br>";
                    echo "{$row[nomarticle]}</center>";
                    echo "</div>";
                    }
                }
                if ($list['categorie'] == "Mobile") {
                    while ($row = $mobi->fetchArray()) {
                    echo "<div class = divprod>";
                    echo "<center><img src='assets/mobiletest.jpg' alt='produit' class='imgproduit'><br>";
                    echo "{$row[nomarticle]}</center>";
                    echo "</div>";
                    }
                }
                echo "</div>";
            }
        ?>
    </ul>

    <footer>
        <p class="foot-talk">Projet M2105</p>
        <p class="foot-talk">CLEMENTE Guillaume - MEUNIER Calixte</p>
        <p class="foot-talk">2020/2021</p>
    </footer>
</body>
</html>