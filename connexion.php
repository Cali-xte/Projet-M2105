<?php
    // Création du cookie d'authentification avec valeur par défault
    $c_value ="unknown";
    setcookie("user",$c_value, time() + 7200, "/");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/logominibleu.png" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Connexion - Inscription</title>
    <link rel="stylesheet" href="../connexion.css">
</head>
<body>
    <?php
        // Variables conexion :
        $email = $_POST["email"];
        $passwd = $_POST["passwd"];
        // Variable Inscription :
        $nom = $_POST["nom"];
        $nemail = $_POST["nemail"];
        $npasswd = $_POST["npasswd"];
        $addr = $_POST["addr"];  
    ?>
    <form action="" method="post">
        <fieldset class="fmain">
            <img src="assets/logo.png" alt="logo de l'entreprise" class="logo">
            <fieldset>
                <legend>Connexion</legend>
                <div>
                    <p>Email :</p>
                    <input type="email" name="email">
                </div>
                <div>
                    <p>Mot de passe :</p>
                    <input type="password" name="passwd">
                </div>
            </fieldset>
            <fieldset>
                <legend>Inscription</legend>
                <div>
                    <p>Nom :</p>
                    <input type="text" name="nom">
                </div>
                <div>
                    <p>Mot de passe :</p>
                    <input type="password" name="npasswd">
                </div>
                <div>
                    <p>Email :</p>
                    <input type="email" name="nemail">
                </div>
                <div>
                    <p>Addresse de livraison :</p>
                    <input type="text" name="addr">
                </div>
                <br>
                
            </fieldset>
            <br>
            <div>
                <button type="submit" id="env">Envoyer</button> 
            </div>
        </fieldset>
    </form>
        <?php
            // Affiche un message si l'utilisateur est déjà connecté
            $db = new SQLite3('amazon2.db'); 
            $c_user = $_COOKIE["user"]; // Récupere la valeur du cookie
            $c_nom= $db->querySingle("SELECT nomclient FROM client WHERE mailclient='$c_user'"); // Requète SQL pour récupérer le nom de l'utilisateur connecté
            if ($c_nom!= '') { //Si le non existe il sera alors afficher
                UserInUseMessage("D&eacute;j&agrave; connect&eacute; sous $c_nom"); //Affiche le message
            }
 
            // Main programme pour formulaire
            // On se base sur l'addresse mail entrée par l'utilisateur
            // Si email != '' -> cela veut dire que l'utilisateur tente de se connecter
            // Si nemail != '' -> cela veut dire que l'utilisateur tente de s'inscrire
            
            if ($email != '' && $nemail == '') {
                // Dans ce cas l'utilisateur tente de se connecter
                if (Authentification($email,$passwd) == 0) { // On teste si ce qu'il a saisi correspond a nos donnes dans la BDD
                    UserConnexion($email); //Si oui -> modification du cookie + redirection page acceuil
                }          
            } elseif ($email == '' && $nemail != '' && $nom!='' && $npasswd!='' && $addr!='') {
                // Dans ce cas l'utilisateur tente de s'inscrire
                // Le test force l'utilisateur a rentrer correctement tous les champs du formulaire qui nous sont nécéssaire
                if (DoesMailExists($nemail) == 0) { 
                    CreateUser($nom,$npasswd,$addr,$nemail); 
                    if (Authentification($nemail,$npasswd) == 0) {
                        UserConnexion($nemail);
                    }
                }else{
                    // Si le mail est déjà utilisé
                    echo "Mail d&eacute;ja utilis&eacute;";
                }
            } elseif ($nemail != '' && (($nom == '')||($npasswd == '')||($addr == ''))) {
                // Cas ou il manque une information pour l'inscription
                ErrorMessage("Veuiller bien remplir le formulaire");
            } elseif ($email != '' && $nemail != '') {
                // Cas ou l'utilisateur repli le champ connexion et inscription a même temps
                ErrorMessage("Connectez vous ou creez un compte");
            }else{
                echo "";
            }
            
            function Authentification($user,$password) { // 0-> ok ; 1-> wrong-email ; 2-> wrong-password
                $db = new SQLite3('amazon2.db');
                $mail = $db->query('SELECT mailclient FROM client');// Requete SQL mails
                $mdp = $db->querySingle("SELECT mdpclient FROM client WHERE mailclient='$user'"); // Requete SQL mdp
                while ($mails = $mail->fetchArray()) {  // Chercher corespondance avec mail saisi et mail BDD
                    $bddmail = $mails['mailClient'];
                    $testm = strcmp($bddmail, $user);
                    if ($testm == 0) {  // Si correspondance mail -> test sur mdp
                        $testp = strcmp($mdp,$password);
                        if ($testp == 0) {
                            return 0;
                        }else {
                            ErrorMessage("Le mot de passe est incorrect");
                            return 2;
                        }
                    }  
                }
                ErrorMessage("Votre email nous est inconnu, inscrivez vous !");
                return 1;
            }

            function UserConnexion($user) { // Modifie le cookie d'authentification
               setcookie("user", $user, time() + 7200, "/");
                header('Location: /index.php');     
            }

            function DoesMailExists($user){ // 0-> ok ; 1-> mail-existe-deja
                $db = new SQLite3('amazon2.db');
                $mail = $db->query('SELECT mailclient FROM client'); // Reque SQL recupere tous les mails dans BDD
                while ($mails = $mail->fetchArray()) {  //Compare chque mail avec celui saisi si correspondance -> le mail existe sinon -> ok
                    $bddmail = $mails['mailClient'];
                    $testm = strcmp($bddmail, $user);
                    if ($testm == 0) {
                        ErrorMessage("Le mail saisi est d&eacute;j&agrave; utilis&eacute;");
                        return 1;
                    }            
                }return 0;
            }

            function CreateUser($name,$mdp,$addr,$mail){ // Creer un nouvel utilisateur dans la BDD
                $db = new SQLite3('amazon2.db'); // BDD concernée
                $ref = GenRefClient(6); // Creation d'un id client aléatoire 
                $querry = "INSERT INTO client(nomclient, refclient, mdpclient, addrClient, mailClient) VALUES ('$name', '$ref', '$mdp', '$addr', '$mail')"; // Requete SQL qui creer une nouvelle ligne dans la table client
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
            
            function ErrorMessage($message){ // Affiche un message sur fond rouge
                echo "<div class='parent-message'>";
                echo    "<p class='error-message'>";
                echo $message;
                echo    "</p></div>";
            }

            function UserInUseMessage($message){ // Affiche un message sur fond vert
                echo "<div class='parent-user'>";
                echo    "<p class='user-message'>";
                echo $message;
                echo    "</p></div>";
            }
        ?>
</body>
</html>
