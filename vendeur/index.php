<?php
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
    if (isset($_POST['forminscription']))
    {
        $pseudo = htmlspecialchars($_POST['pseudo']); // htmlspecialchars  - Convertit les caractères spéciaux en entités HTML
        $email = htmlspecialchars($_POST['email']);
        $cemail = htmlspecialchars($_POST['cemail']);
        if(!empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['cemail']))
        {
            $reqpseudo = $bdd->prepare("SELECT * FROM vendeurs WHERE pseudo = ?"); // Vérification du pseudo Si déjà présent dans la BDD
            $reqpseudo->execute(array($pseudo));
            $pseudoexiste= $reqpseudo->rowCount();
            $pseudolength = strlen($pseudo);
            if($pseudoexiste ==0)
            {
                if($pseudolength <= 12)
                {
                    if(filter_var($email,FILTER_VALIDATE_EMAIL))
                        {
                            $reqmail = $bdd->prepare("SELECT * FROM vendeurs WHERE email = ?"); // Vérification de l'adresse mail Si déjà présente dans la BDD
                            $reqmail->execute(array($email));
                            $mailexiste= $reqmail->rowCount();
                            if($mailexiste==0)
                            {
                                if($email == $cemail)
                                {
                                    $sql = $bdd->prepare("INSERT INTO vendeurs(email,pseudo) VALUES ('$email','$pseudo')");
                                    $sql->execute(array($email,$pseudo));
                                    $info = '<div class="alert alert-success">Votre inscription a bien été enregistrée !</div>';
                                    echo $info;
                                }
                            else
                            {
                                $info = '<div class="alert alert-danger">Vos adresses mails ne sont pas identiques</div>';
                                echo $info; 
                            }
                        }
                        else
                        {
                            $info = '<div class="alert alert-danger">L\'Adresse mail est déjà utilisée !</div>';
                            echo $info; 
                        }
                    }
                    else
                    {
                        $info='<div class="alert alert-danger">Votre adresse mail est incorrecte</div>';
                        echo $info;
                    }
                }
                else
                {
                    $info = '<div class="alert alert-danger">Votre pseudo ne doit pas dépasser 12 caractères !</div>';
                    echo $info;
                }
            }
            else
                {
                    $info = '<div class="alert alert-danger">Le pseudo est déjà utilisé !</div>';
                    echo $info;
                }
        }
        else
        {
            $info = '<div class="alert alert-danger">Une erreur est survenue</div>';
            echo $info;
        }
    }

    if (isset($_POST['formconnection']))
    {
        $pseudoconnect= htmlspecialchars($_POST['username']);
        $emailconnect = htmlspecialchars($_POST['email']);
        //Nous vérifions que l'utilisateur a bien envoyé les informations demandées 
        if(!empty($pseudoconnect) AND !empty($emailconnect))
        {
            $query = $bdd->prepare('SELECT * FROM vendeurs WHERE email = ? AND pseudo = ?');
            $query ->execute(array($emailconnect, $pseudoconnect));
            $pseudoexist = $query->rowCount(); // Compte le nombre de rangée qui existe avec les infos saisies par l'utilisateur
            if ($pseudoexist == 1){
                $sql = $query->fetch();
                $_SESSION['id_vendeur'] = $sql['id_vendeur'];
                $_SESSION['pseudo'] = $sql['pseudo'];
                $_SESSION['email'] = $sql['email'];
                header("Location:produits.php");

            }
            else{
                $info = '<div class="alert alert-danger">L\'Adresse mail ou le nom d\'utilisateur est incorrecte! </div>';
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
                    <h1 class="display-4 typewriter">Ebay ECE | Pro</h1>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-address-book"></i></span>
                            </div>
                            <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                            </div>
                            <input type="email" class="form-control" name="email" placeholder="Email" value="<?php if(isset($email)){echo $email;}?>" required>
                        </div>
                    </div>
                    <button type="submit" name="formconnection" class="btn btn-primary btn-lg btn-block">Se connecter</button>
                </form>
                <div class="texte  mt-2 text-center">
                    <small class="mdp"> Mot de passe oublié ?</small>
                    <a data-toggle="modal" data-target="#modal-default"><small>· S'inscrire sur Evo</small></a><br><br><br>
                    <a href="../index.php"><button class="btn mr-2 mb-2  btn-pill btn-dark" type="button">Accès acheteur</button></a>
                </div>
            
        </div>
    </div>
        <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">Nous rejoindre</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <h1 class="display-4">Créer votre compte</h1>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-address-book"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="pseudo" placeholder="Pseudo" value="<?php if(isset($pseudo)){echo $pseudo;}?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    </div>
                                    <input type="email" class="form-control" name="email" placeholder="Adresse mail" value="<?php if(isset($mail)){echo $mail;}?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    </div>
                                    <input type="email" class="form-control" name="cemail" placeholder="Confirmez votre adresse mail" required>
                                </div>
                            </div>
                           
                            <button type="submit" class="btn btn-primary btn-lg btn-block" name="forminscription">S'inscrire</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">J'ai déjà un compte !</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
