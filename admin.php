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

        <button onclick="affstock()">Stock</button>
        <button onclick="affclient()">Clients</button>
        <button onclick="affvendeur()">Vendeurs</button>

        <div class='cat' id='stock' style="display:none">
            <table><?php
            echo "<tr class='titre'><td>refarticle</td><td>qte</td><td>refvendeur</td></tr>";
            while ($liststock = $stock->fetchArray()) {
                echo "<tr><td>{$liststock['refarticle']}</td><td>{$liststock['qte']}</td><td>{$liststock['refvendeur']}</td>";
                echo "<td><form action='modbdd.php' method='post'>";
                echo "<button type='submit' name='action' value='suppr' class='rm'>X</button>";
                echo "<input type='hidden' name='type' value='stock'/><input type='hidden' name='ref' value='{$liststock['refarticle']}'/><input type='hidden' name='refvendeur' value='{$liststock['refvendeur']}'/>";
                echo "</form></td></tr>";
            }

            echo "<tr><form action='modbdd.php' method='post' class='form'><td><select name='ref' id='refprodstocksel'>";
            while ($listrefprod = $produits->fetchArray()) {
                echo "<option value='{$listrefprod['refarticle']}'>{$listrefprod['refarticle']}</option>";
            }
            echo "</td>";

            echo "<td><select name='qte' id='qtestocksel'>";
            for ($i=-200; $i <= 200; $i++) {
                if ($i==0) {echo "<option value='{$i}' selected>{$i}</option>";}
                else {echo "<option value='{$i}'>{$i}</option>";}
            }
            echo "</td>";

            echo "<td><select name='refvendeur' id='vendstocksel'>";
            while ($listerefvendeur = $vendeurs->fetchArray()) {
                echo "<option value='{$listerefvendeur['refvendeur']}'>{$listerefvendeur['refvendeur']}</option>";
            }
            echo "</td>";

            echo "<td>";
            echo "<input type='hidden' name='action' value='aj'/><input type='hidden' name='type' value='stock'/><input type='submit' value='+'>";
            echo "</td></tr></form>";
            ?></table>
            
        </div>

        <div class='cat' id='clients' style="display:none">
            <table><?php
            echo "<tr class='titre'><td>nomclient</td><td>refclient</td><td>addrclient</td><td>mailclient</td><td>mdpclient</td></tr>";
            while ($listclient = $utilisateurs->fetchArray()) {
                echo "<tr><td>{$listclient['nomclient']}</td><td>{$listclient['refclient']}</td><td>{$listclient['addrClient']}</td><td>{$listclient['mailClient']}</td><td>**************</td>";
                echo "<td><form action='modbdd.php' method='post'>";
                echo "<button type='submit' name='action' value='suppr' class='rm'>X</button>";
                echo "<input type='hidden' name='type' value='client'/><input type='hidden' name='ref' value='{$listclient['refclient']}'/>";
                echo "</form></td></tr>";
            }

            echo "<tr><form action='modbdd.php' method='post' class='form'>";
            echo "<td><input type=text id='nomclientsel' name=nomclient required>";
            echo "</td>";
            echo "<td><input type=text id='refclientsel' name='ref' required size='6'>";
            echo "</td>";
            echo "<td><input type=text id='addrclientsel' name=addrclient required>";
            echo "</td>";
            echo "<td><input type=email id='mailclientsel' name=mailclient required>";
            echo "</td>";
            echo "<td><input type=password id='mdpclientsel' name=mdpclient required>";
            echo "</td>";
            echo "<td><input type='hidden' name='action' value='aj'/><input type='hidden' name='type' value='client'/><input type='submit' value='+'>";
            echo "</td></tr></form>";
            ?></table>
        </div>

        <div class='cat' id='vendeurs' style="display:none">
            <table><?php
            echo "<tr class='titre'><td>nomvendeur</td><td>refvendeur</td><td>addrvendeur</td><td>mailvendeur</td></tr>";
            while ($listvendeur = $vendeurs->fetchArray()) {
                echo "<tr><td>{$listvendeur['nomvendeur']}</td><td>{$listvendeur['refvendeur']}</td><td>{$listvendeur['addrvendeur']}</td><td>{$listvendeur['mailvendeur']}</td>";
                echo "<td><form action='modbdd.php' method='post'>";
                echo "<button type='submit' name='action' value='suppr' class='rm'>X</button>";
                echo "<input type='hidden' name='type' value='vendeur'/><input type='hidden' name='ref' value='{$listvendeur['refvendeur']}'/>";
                echo "</form></td></tr>";
                //<input type='button' value='X' id='del'></a></td></tr>";
            }

            echo "<tr><form action='modbdd.php' method='post' class='form'>";
            echo "<td><input type=text id='nomvendeursel' name=nomvendeur required>";
            echo "</td>";
            echo "<td><input type=text id='refvendeursel' name='ref' required size='3'>";
            echo "</td>";
            echo "<td><input type=text id='addrvendeursel' name=addrvendeur required>";
            echo "</td>";
            echo "<td><input type=email id='mailvendeursel' name=mailvendeur required>";
            echo "</td>";
            echo "<td><input type='hidden' name='action' value='aj'/><input type='hidden' name='type' value='vendeur'/><input type='submit' value='+'>";
            echo "</td></tr></form>";

            ?></table>
        </div>
    </div>
        
    <script>

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

    </script>  

    <footer>
        <p class="foot-talk">Projet M2105</p>
        <p class="foot-talk">CLEMENTE Guillaume - MEUNIER Calixte</p>
        <p class="foot-talk">2020/2021</p>
    </footer>
</body>
</html>
