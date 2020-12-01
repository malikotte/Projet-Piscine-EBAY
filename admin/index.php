<?php
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gestion des erreurs.

    if (isset($_POST['formconnection']))
    {
        $email= htmlspecialchars($_POST['email']);
        $passwordconnect = $_POST['password'];
        //Nous vérifions que l'utilisateur a bien envoyé les informations demandées 
        if(!empty($email) AND !empty($passwordconnect))
        {
            //Nous allons demander le hash pour cet utilisateur à notre base de données :
            $query = $bdd->prepare('SELECT password FROM administrateur WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
            $result = $query->fetch();
            $hash = $result[0];
            //Nous vérifions si le mot de passe utilisé correspond bien à ce hash à l'aide de password_verify :
            $correctPassword = password_verify($_POST["password"], $hash);


            if($correctPassword)
            {
                $req = $bdd->prepare('SELECT * FROM administrateur WHERE email=:email');
                $req -> execute(array('email'=> $_POST['email']));
                $sql = $req->fetch();
                $_SESSION['idadmin'] = $sql['idadmin'];
                $_SESSION['email'] = $sql['email'];
                header("Location: produits.php");
                /*$r = $bdd->prepare('SELECT statut FROM vendeurs  WHERE username=? AND email=?');
                $r->execute(array($usernameconnect, $emailconnect));

                if ($d = $r->fetch()) {
                    if ('Acheteur' == $d['statut']){
                        header("Location: acheteur.php".$_SESSION['id']);
                    }
                    else if ('Vendeur' == $d['statut']){
                        header("Location: vendeur.php".$_SESSION['id']);
                    }
                    else{
                        header("Location: admin.php?id=".$_SESSION['id']);
                    }
                }*/
            }
            else
            {
                $info = '<div class="alert alert-danger">Mauvais identifiant ou mot de passe ! </div>';
                echo $info;
            }
        }
        else
        {
            $info = '<div class="alert alert-danger">Une erreur est survenue</div>';
            echo $info;
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Themesberg">
    <title>Evo</title>
    <!-- Favicon -->
    <link rel="icon" href="img/favicon-16x16.png" />
    <!-- Pixel CSS -->
    <link type="text/css" href="./css/pixel.css?v=1.0.1" rel="stylesheet">
    <!-- Mon CSS -->
    <link type="text/css" href="./css/styles.css" rel="stylesheet">
    <link type="text/css" href="./css/animate.css" rel="stylesheet">
    <!-- Core -->
    <script src="./vendor/jquery/jquery.min.js"></script>
    <script src="./vendor/popper/popper.min.js"></script>
    <script src="./vendor/bootstrap/bootstrap.min.js"></script>
    <script src="./vendor/headroom/headroom.min.js"></script>

    <!-- Vendor JS -->
    <script src="./vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="./vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="./vendor/smooth-scroll/smooth-scroll.polyfills.min.js"></script>
    <!-- pixel JS -->
    <script src="./js/pixel.js"></script>
</head>
<body>
    <div class="content">
        <div class="loginform mr-auto ml-auto animated fadeIn">
            <img class="fit-picture" src="img/logo.png" style="width: 55px;height: 75px;position: relative;left:45%;" alt="Grapefruit slice atop a pile of other slices">
                <form method="POST" action="">
                    <h1 class="display-4 typewriter">Ebay ECE | Pannel</h1>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                            </div>
                            <input type="text" class="form-control" name="email" placeholder="Adresse mail" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
                        </div>
                    </div>
                    <button type="submit" name="formconnection" class="btn btn-primary btn-lg btn-block">Se connecter</button>
                </form>
            
        </div>
    </div>


</body>

</html>
