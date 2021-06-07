<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="produit.css">
    <link rel="icon" type="image/png" href="assets/logominibleu.png" />

    <title>Amazon&sup2; </title>
</head>
<body>
    <?php
        $db = new SQLite3('amazon2.db');
        $produit = $_GET['produit'];
        $info = $db->query("SELECT * FROM article WHERE refarticle = '$produit'");
        $pabx = $db->query("SELECT * FROM PABX WHERE refarticle = '$produit'");
        $fixe = $db->query("SELECT * FROM Fixe WHERE refarticle = '$produit'");
        $mobile = $db->query("SELECT * FROM Mobile WHERE refarticle = '$produit'");
    ?>
    <header>
        <img src="assets/logo.png" alt="logo de l'entreprise" class="logo">
        <form action="recherche.php" method="GET" class="recherche">
            <input type="text" name="motcle" class="ch_rez">
            <input type="submit" value="Rechercher" id="recherche">
            <input type="image" src="assets/chercher.png" alt="Submit Form" id="mobilBut" />
        </form>
        
        <a href="connexion.php" class="iconsLink">
            <img src="assets/utilisateurs.png" alt="userImage" class="icons">
        </a>
        <a href="assets/archiver.png" class="iconsLink">
            <img src="assets/archiver.png" alt="panier" class="icons">
        </a>
    </header>
    <div class="main">
        <?php
            while ($data = $info->fetchArray()){
                echo "<div class='vue'>";
                echo "<h1>{$data[nomarticle]}</h1>";
                echo "<img class='imgprod' src='assets/produits/{$produit}.png' alt='Image non disponible'>";
                echo "</div>";
                echo "<div class='vue'>";
                echo "<h2>{$data[prix]} &euro;</h2></div>";
            }
        ?>
        
        <div class='vue'>
            <form action=NULL class='achat' alt='Ajouter au panier'>
                <input type="button" value="Ajouter au panier" id="ajoutpanier" onclick="myFunction()">
        </div>
	<div id="snackbar">Ajouté au panier</div>
    </div>

    <footer>
        <p class="foot-talk">Projet M2105</p>
        <p class="foot-talk">CLEMENTE Guillaume - MEUNIER Calixte</p>
        <p class="foot-talk">2020/2021</p>
    </footer>
    <script>
	function myFunction() {
	var x = document.getElementById("snackbar");
 	x.className = "show";
	setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
	}
</script>
</body>
</html>
