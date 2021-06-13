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
        // Initialisation des variables
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
        if ($c_nom != 'Administrateur' || $c_user != 'admin@admin.rt') {    // Si l'utilisateur connecté n'est pas l'administrateur
            header('Location: index.php');                                  // On renvoie vers la page d'accueil
            exit();
    }?>
    <div class='main'><h1>Bienvenue, <?php echo $c_nom ?></h1>

        <!-- Boutons d'ouverture des tableaux de contrôle -->
        <button onclick="affstock()">Stock</button>
        <button onclick="affclient()">Clients</button>
        <button onclick="affvendeur()">Vendeurs</button>

        <div class='cat' id='stock' style="display:none">   <!-- Tableau de contrôle du stock -->
            <table><?php
            echo "<tr class='titre'><td>refarticle</td><td>qte</td><td>refvendeur</td></tr>"; // En-têtes de colonnes
            while ($liststock = $stock->fetchArray()) {                                                                             // Pour chaque ligne de la table Stock
                echo "<tr><td>{$liststock['refarticle']}</td><td>{$liststock['qte']}</td><td>{$liststock['refvendeur']}</td>";      // On crée une ligne dans le tableau avec ses valeurs
                echo "<td><form action='modbdd.php' method='post'>";
                echo "<button type='submit' name='action' value='suppr' class='rm'>X</button>";                                     // Bouton de suppression de la ligne
                // On fait passer les paramètres manquant par POST grâce à des champs de formulaire invisibles :
                echo "<input type='hidden' name='type' value='stock'/><input type='hidden' name='ref' value='{$liststock['refarticle']}'/><input type='hidden' name='refvendeur' value='{$liststock['refvendeur']}'/>";
                echo "</form></td></tr>";
            }
            
            // Champs de gestion du stock
            echo "<tr><form action='modbdd.php' method='post' class='form'><td><select name='ref' id='refprodstocksel'>";           // Formulaire en POST + liste déroulante des refs de produits
            // Génération dynamique de la liste déroulante
            while ($listrefprod = $produits->fetchArray()) {
                echo "<option value='{$listrefprod['refarticle']}'>{$listrefprod['refarticle']}</option>";
            }
            echo "</td>";

            echo "<td><select name='qte' id='qtestocksel'>";                        // Idem pour la quantité
            for ($i=-200; $i <= 200; $i++) {                                        // La liste déroulante va de -200 à 200 pour ajouter/supprimer du stock
                if ($i==0) {echo "<option value='{$i}' selected>{$i}</option>";}    // La valeur selectionnée par défaut sera 0 (ne fait rien) au lieu de -200
                else {echo "<option value='{$i}'>{$i}</option>";}
            }
            echo "</td>";

            echo "<td><select name='refvendeur' id='vendstocksel'>";                                                    // Idem pour les refs des vendeurs
            while ($listerefvendeur = $vendeurs->fetchArray()) {
                echo "<option value='{$listerefvendeur['refvendeur']}'>{$listerefvendeur['refvendeur']}</option>";
            }
            echo "</td>";

            echo "<td>";
            echo "<input type='hidden' name='action' value='aj'/><input type='hidden' name='type' value='stock'/><input type='submit' value='+'>";  // Bouton d'envoi + paramètres POST supplémentaires
            echo "</td></tr></form>";
            ?></table>
            
        </div>

        <div class='cat' id='clients' style="display:none">                 <!-- Tableau de contrôle des clients -->
            <table><?php
            echo "<tr class='titre'><td>nomclient</td><td>refclient</td><td>addrclient</td><td>mailclient</td><td>mdpclient</td></tr>";     // En-têtes de colonnes
            while ($listclient = $utilisateurs->fetchArray()) {             // Pour chaque utilisateur
                // On crée une ligne (le mot de passe ne sort pas du serveur) :
                echo "<tr><td>{$listclient['nomclient']}</td><td>{$listclient['refclient']}</td><td>{$listclient['addrClient']}</td><td>{$listclient['mailClient']}</td><td>**************</td>";
                if ($listclient['refclient'] != '0000007') {                // Si l'utilisateur n'est pas l'admin
                    echo "<td><form action='modbdd.php' method='post'>";    // Formulaire de suppression de la ligne
                    echo "<button type='submit' name='action' value='suppr' class='rm'>X</button>";     // Bouton de suppression de la ligne
                    echo "<input type='hidden' name='type' value='client'/><input type='hidden' name='ref' value='{$listclient['refclient']}'/>";   // Paramètres POST de suppression
                    echo "</form>";
                } else {                                                    // Si l'utilisateur est l'admin
                    echo "<td><button type='button' disabled>X</button>";    // On crée un faux bouton, non cliquable
                }
                echo "</td></tr>";
            }

            echo "<tr><form action='modbdd.php' method='post' class='form'>";               // Formulaire d'ajout d'un client
            echo "<td><input type=text id='nomclientsel' name=nomclient required>";         // Champ d'entrée du nom du client
            echo "</td>";
            echo "<td><input type=text id='refclientsel' name='ref' required size='6'>";    // Champ d'entrée de la référence du client
            echo "</td>";
            echo "<td><input type=text id='addrclientsel' name=addrclient required>";       // Champ d'entrée de l'addresse du client
            echo "</td>";
            echo "<td><input type=email id='mailclientsel' name=mailclient required>";      // Champ d'entrée du mail du client (n'accepte que le format *@*)
            echo "</td>";
            echo "<td><input type=password id='mdpclientsel' name=mdpclient required>";     // Champ d'entrée du nmot de pass du client (caractères cachés)
            echo "</td>";
            echo "<td><input type='hidden' name='action' value='aj'/><input type='hidden' name='type' value='client'/><input type='submit' value='+'>"; // Paramètres POST cachés + bouton d'envoi
            echo "</td></tr></form>";
            ?></table>
        </div>

        <div class='cat' id='vendeurs' style="display:none">    <!-- Tableau de contrôle des vendeurs -->
            <table><?php
            echo "<tr class='titre'><td>nomvendeur</td><td>refvendeur</td><td>addrvendeur</td><td>mailvendeur</td></tr>";       // En-têtes de colonnes
            while ($listvendeur = $vendeurs->fetchArray()) {    // Pour chaque vendeur, on crée une ligne :
                echo "<tr><td>{$listvendeur['nomvendeur']}</td><td>{$listvendeur['refvendeur']}</td><td>{$listvendeur['addrvendeur']}</td><td>{$listvendeur['mailvendeur']}</td>";
                echo "<td><form action='modbdd.php' method='post'>";                                // Formulaire de suppression d'une ligne
                echo "<button type='submit' name='action' value='suppr' class='rm'>X</button>";     // Bouton de suppression
                echo "<input type='hidden' name='type' value='vendeur'/><input type='hidden' name='ref' value='{$listvendeur['refvendeur']}'/>";    // Paramètres POST cachés
                echo "</form></td></tr>";
            }

            echo "<tr><form action='modbdd.php' method='post' class='form'>";               // Formulaire de création d'un vendeur
            echo "<td><input type=text id='nomvendeursel' name=nomvendeur required>";       // Champ d'entrée du nom du vendeur
            echo "</td>";
            echo "<td><input type=text id='refvendeursel' name='ref' required size='3'>";   // Champ d'entrée de la référence du vendeur
            echo "</td>";
            echo "<td><input type=text id='addrvendeursel' name=addrvendeur required>";     // Champ d'entrée de l'addresse du vendeur
            echo "</td>";
            echo "<td><input type=email id='mailvendeursel' name=mailvendeur required>";    // Champ d'entrée du mail du vendeur
            echo "</td>";
            echo "<td><input type='hidden' name='action' value='aj'/><input type='hidden' name='type' value='vendeur'/><input type='submit' value='+'>";    // Paramètres POST cachés + bouton d'envoi
            echo "</td></tr></form>";

            ?></table>
        </div>
    </div>
        
    <script>
    // Scripts des boutons d'affichage des divs de tableaux
    function affstock() {                           // Au clic
        var x = document.getElementById("stock");   // On met lie la div à une variable
        if (x.style.display === "none") {           // Si elle est cachée
            x.style.display = "block";              // On l'affiche
        } else {                                    // Sinon
            x.style.display = "none";               // On la masque
        }
    }

    function affclient() { // Idem
        var x = document.getElementById("clients");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function affvendeur() { // Idem
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
