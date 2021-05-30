<?php
    $c_value = "unknown";
    setcookie("user", $c_value, time() + 7200, "/");
?>
<!DOCTYPE html>
<html lang="en">
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
        $email = $_POST["email"];
        $passwd = $_POST["passwd"];
        //------------------------------//
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
            
            if ($email != '' && $nemail == '') {
                if (Authentification($email,$passwd) == 0) {
                    UserConnexion($email);
                }else {
                    echo "Mauvais mot de passe ou email";
                }
            } elseif ($email == '' && $nemail != '') {
                if (DoesMailExists($nemail) == 0) {
                    CreateUser($nom,$npasswd,$addr,$nemail);
                    if (Authentification($nemail,$npasswd) == 0) {
                        UserConnexion($nemail);
                    }
                }else{
                    echo "Mail d&eacute;ja utilis&eacute;";
                }
            } elseif ($email != '' && $nemail != '') {
                echo "error";
            }else{
                echo "";
            }
            
            function Authentification($user,$password) { // 0-> ok ; 1-> wrong-email ; 2-> wrong-password
                $db = new SQLite3('amazon2.db');
                $mail = $db->query('SELECT mailclient FROM client');
                $mdp = $db->querySingle("SELECT mdpclient FROM client WHERE mailclient='$user'");
                while ($mails = $mail->fetchArray()) {
                    $bddmail = $mails['mailClient'];
                    $testm = strcmp($bddmail, $user);
                    if ($testm == 0) {
                        $testp = strcmp($mdp,$password);
                        if ($testp == 0) {
                            return 0;
                        }else {
                            return 2;
                        }
                    }
                    
                }return 1;
            }

            function UserConnexion($user) {
               setcookie("user", $user, time() + 7200, "/");
                header('Location: /index.php');     
            }

            function DoesMailExists($user){ // 0-> ok ; 1-> mail-existe-deja
                $db = new SQLite3('amazon2.db');
                $mail = $db->query('SELECT mailclient FROM client');
                while ($mails = $mail->fetchArray()) {
                    $bddmail = $mails['mailClient'];
                    $testm = strcmp($bddmail, $user);
                    if ($testm == 0) {
                        return 1;
                    }            
                }return 0;
            }

            function CreateUser($name,$mdp,$addr,$mail){
                $db = new SQLite3('amazon2.db');
                $ref = RandomRefGen(6);
                $querry = "INSERT INTO client(nomclient, refclient, mdpclient, addrClient, mailClient) VALUES ('$name', '$ref', '$mdp', '$addr', '$mail')";
                $send = $db->exec($querry);
            }

            function RandomRefGen($length){
                $chars = '0123456789';
                $string = '';
                for($i=0; $i<$length; $i++){
                    $string .= $chars[rand(0, strlen($chars)-1)];
                }
                return $string;
            }

        ?>
</body>
</html>
