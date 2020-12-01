<?php
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
    if (isset($_POST['forminscription']))
    {
        $nom = htmlspecialchars($_POST['nom']); // htmlspecialchars  - Convertit les caractères spéciaux en entités HTML
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['cpassword']))
        {
            
            $nomlength = strlen($nom);
            $prenomlength = strlen($prenom);
            
                if ($nomlength <= 20 && $prenomlength <= 20)
                {
                    if (filter_var($email,FILTER_VALIDATE_EMAIL))
                    {
                        $reqmail = $bdd->prepare("SELECT * FROM acheteurs WHERE email = ?"); // Vérification de l'adresse mail Si déjà présente dans la BDD
                        $reqmail->execute(array($email));
                        $mailexiste= $reqmail->rowCount();
                        if($mailexiste ==0)
                        {

                            if ($_POST['password'] == $_POST['cpassword'])
                            {
                                $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashage du mot de passe
                                $cpassword = password_hash($_POST['cpassword'], PASSWORD_DEFAULT);//
                                $sql = $bdd->prepare("INSERT INTO acheteurs(email,nom,prenom,password) VALUES ('$email','$nom','$prenom','$password')");
                                $sql->execute(array($email,$nom,$prenom,$password));
                                $req = $bdd->prepare('SELECT * FROM acheteurs WHERE nom=:nom');
                                $req -> execute(array('nom'=> $_POST['nom']));
                                $sql = $req->fetch();
                                $_SESSION['id_acheteur'] = $sql['id_acheteur'];
                                header("Location:etape2.php?id=".$_SESSION['id_acheteur']);
                                $info = '<div class="alert alert-success">Votre inscription a bien été enregistrée !</div>';
                                echo $info;
                            }
                            else
                            {
                                $info = '<div class="alert alert-danger">Vos mots de passe ne sont pas identiques</div>';
                                echo $info; 
                            }
                        }
                        else
                        {
                            $info = '<div class="alert alert-danger">Adresse mail déjà utilisée !</div>';
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
            $info = '<div class="alert alert-danger">Une erreur est survenue</div>';
            echo $info;
        }
    }


    if (isset($_POST['formconnection']))
    {
        $email= htmlspecialchars($_POST['email']);
        $passwordconnect = $_POST['password'];
        //Nous vérifions que l'utilisateur a bien envoyé les informations demandées 
        if(!empty($email) AND !empty($passwordconnect))
        {
            //Nous allons demander le hash pour cet utilisateur à notre base de données :
            $query = $bdd->prepare('SELECT password FROM acheteurs WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
            $result = $query->fetch();
            $hash = $result[0];
            //Nous vérifions si le mot de passe utilisé correspond bien à ce hash à l'aide de password_verify :
            $correctPassword = password_verify($_POST["password"], $hash);


            if($correctPassword)
            {
                $req = $bdd->prepare('SELECT * FROM acheteurs WHERE email=:email');
                $req -> execute(array('email'=> $_POST['email']));
                $sql = $req->fetch();
                $_SESSION['id_vendeur'] = $sql['id_vendeur'];
                $_SESSION['id_acheteur'] = $sql['id_acheteur'];
                $_SESSION['email'] = $sql['email'];
                header("Location:produits.php");
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
     <script src="./js/pixel.js"></script>

</head>
<body>
    <div class="content toggle-custom-snow">
        <div class="loginform mr-auto ml-auto animated fadeIn">
            <img class="fit-picture" src="img/logo.png" style="width: 55px;height: 75px;position: relative;left:45%;" alt="Grapefruit slice atop a pile of other slices">
                <form method="POST" action="">
                    <h1 class="display-4 typewriter">Ebay ECE</h1>
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
                <div class="texte  mt-2 text-center">
                    <small class="mdp"> Mot de passe oublié ?</small>
                    <a data-toggle="modal" data-target="#modal-default"><small>· S'inscrire sur Evo</small></a><br><br><br>
                    <a href="vendeur/index.php"><button class="btn mr-2 mb-2  btn-pill btn-dark" type="button">Accès vendeur</button></a>
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
                                    <input type="text" class="form-control" name="nom" placeholder="Nom" value="<?php if(isset($nom)){echo $nom;}?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-address-book"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="prenom" placeholder="Prénom" value="<?php if(isset($prenom)){echo $prenom;}?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    </div>
                                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?php if(isset($mail)){echo $mail;}?>" required>
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
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="cpassword" placeholder="Confirmez votre mot de passe" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block" name="forminscription">Etape 2</button>
                            <div class="form-check round-check mb-3"><label class="form-check-label" required><input class="form-check-input" type="checkbox" required> <span class="form-check-sign" required></span>Je certifie avoir pris connaissance des conditions générales des ventes aux enchères.</label></div>
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
