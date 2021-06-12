<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <link rel="icon" type="image/png" href="assets/logominibleu.png" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Amazon&sup2; </title>
</head>
<body>
    <?php
        $db = new SQLite3('amazon2.db');
        $cat = $db->query('SELECT DISTINCT categorie FROM article');
        $c_user = $_COOKIE["user"];
        $c_nom = $db->querySingle("SELECT nomclient FROM client WHERE mailclient='$c_user'");
        $produits = $db->query("SELECT * FROM article");
        $stock = $db->query("SELECT * FROM stock");
        $utilisateurs = $db->query("SELECT * FROM client");
        $vendeurs = $db->query("SELECT * FROM vendeur");
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
    <?php
        if ($c_nom != 'Administrateur' || $c_user != 'admin@admin.rt') {
            header('Location: index.php');
            exit();
    }?>
    <div class='main'><h1>Bienvenue, <?php{$c_nom}?></h1> <!-- PB -->

        <button onclick="affprod()">Produits</button>
        <button onclick="affstock()">Stock</button>
        <button onclick="affclient()">Clients</button>
        <button onclick="affvendeur()">Vendeurs</button>

        <div class='cat' id='produits' style="display:none">
            <table><?php
            echo "<tr class='titre'><td>nomarticle</td><td>refarticle</td><td>marque</td><td>prix</td><td>categorie</td></tr>";
            while ($listprod = $produits->fetchArray()) {
                echo "<tr><td>{$listprod['nomarticle']}</td><td>{$listprod['refarticle']}</td><td>{$listprod['marque']}</td><td>{$listprod['prix']}</td><td>{$listprod['categorie']}</td>";
                echo "<td><a href='modbdd.php?action=suppr&type=produit&ref={$listprod['refarticle']}'><input type='button' value='X' id='del'></a></td></tr>";
            }
            ?></table>
        </div>

        <div class='cat' id='stock' style="display:none">
            <table><?php
            echo "<tr class='titre'><td>refarticle</td><td>qte</td><td>refvendeur</td></tr>";
            while ($liststock = $stock->fetchArray()) {
                echo "<tr><td>{$liststock['refarticle']}</td><td>{$liststock['qte']}</td><td>{$liststock['refvendeur']}</td>";
                echo "<td><a href='modbdd.php?action=suppr&type=stock&ref={$liststock['refarticle']}&vendeur={$liststock['refvendeur']}'><input type='button' value='X' id='del'></a></td></tr>";
            }
            ?></table>
        </div>

        <div class='cat' id='clients' style="display:none">
            <table><?php
            echo "<tr class='titre'><td>nomclient</td><td>refclient</td><td>addrclient</td><td>mailclient</td></tr>";
            while ($listclient = $utilisateurs->fetchArray()) {
                echo "<tr><td>{$listclient['nomclient']}</td><td>{$listclient['refclient']}</td><td>{$listclient['addrClient']}</td><td>{$listclient['mailClient']}</td>";
                echo "<td><a href='modbdd.php?action=suppr&type=client&ref={$listclient['refclient']}'><input type='button' value='X' id='del'></a></td></tr>";
            }
            ?></table>
        </div>

        <div class='cat' id='vendeurs' style="display:none">
            <table><?php
            echo "<tr class='titre'><td>nomvendeur</td><td>refvendeur</td><td>addrvendeur</td><td>mailvendeur</td></tr>";
            while ($listvendeur = $vendeurs->fetchArray()) {
                echo "<tr><td>{$listvendeur['nomvendeur']}</td><td>{$listvendeur['refvendeur']}</td><td>{$listvendeur['addrvendeur']}</td><td>{$listvendeur['mailvendeur']}</td>";
                echo "<td><a href='modbdd.php?action=suppr&type=vendeur&ref={$listvendeur['refvendeur']}'><input type='button' value='X' id='del'></a></td></tr>";
            }
            ?></table>
        </div>
    </div>
        
    <script>

    var ref = "<?php echo $listprod['refarticle']; ?>";

    function affprod() {                              //Au clic :
        var x = document.getElementById("produits");
        if (x.style.display == "none") {              // Si div cachée
            x.style.display = "block";                // on la montre
        } else {                                      // sinon
            x.style.display = "none";                 // on la cache
        }
    }

    function affstock() {
        var x = document.getElementById("stock");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function affclient() {
        var x = document.getElementById("clients");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function affvendeur() {
        var x = document.getElementById("vendeurs");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    // function delprod{$listprod['refarticle']}() {
    //     var x = document.getElementById("vendeurs");
    //     if (x.style.display === "none") {
    //         x.style.display = "block";
    //     } else {
    //         x.style.display = "none";
    //     }
    // }
    </script>  

    <footer>
        <p class="foot-talk">Projet M2105</p>
        <p class="foot-talk">CLEMENTE Guillaume - MEUNIER Calixte</p>
        <p class="foot-talk">2020/2021</p>
    </footer>
</body>
</html>
