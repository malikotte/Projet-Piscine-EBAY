<?php
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
    if (isset($_POST['forminscription']))
    {
        $username = htmlspecialchars($_POST['username']); // htmlspecialchars  - Convertit les caractères spéciaux en entités HTML
        $mail = htmlspecialchars($_POST['email']);
        $genre = $_POST['genre'];
        if(!empty($_POST['username']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['cpassword']))
        {
            $requsername = $bdd->prepare("SELECT * FROM users WHERE username = ?"); // Vérification du pseudo Si déjà présent dans la BDD
            $requsername->execute(array($username));
            $usernameexiste= $requsername->rowCount();
            $pseudolength = strlen($username);
            if($usernameexiste ==0)
            {
                if ($pseudolength <= 12)
                {
                    if (filter_var($mail,FILTER_VALIDATE_EMAIL))
                    {
                        $reqmail = $bdd->prepare("SELECT * FROM users WHERE email = ?"); // Vérification de l'adresse mail Si déjà présente dans la BDD
                        $reqmail->execute(array($mail));
                        $mailexiste= $reqmail->rowCount();
                        if($mailexiste ==0)
                        {

                            if ($_POST['password'] == $_POST['cpassword'])
                            {
                                $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashage du mot de passe
                                $cpassword = password_hash($_POST['cpassword'], PASSWORD_DEFAULT);//
                                $sql = $bdd->prepare("INSERT INTO users(username,email,genre,password) VALUES ('$username','$mail','$genre','$password')");
                                $sql->execute(array($username,$mail,$genre,$password));
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
        $usernameconnect= htmlspecialchars($_POST['username']);
        $passwordconnect = $_POST['password'];
        //Nous vérifions que l'utilisateur a bien envoyé les informations demandées 
        if(!empty($usernameconnect) AND !empty($passwordconnect))
        {
            //Nous allons demander le hash pour cet utilisateur à notre base de données :
            $query = $bdd->prepare('SELECT password FROM users WHERE username = :username');
            $query->bindParam(':username', $usernameconnect);
            $query->execute();
            $result = $query->fetch();
            $hash = $result[0];
            //Nous vérifions si le mot de passe utilisé correspond bien à ce hash à l'aide de password_verify :
            $correctPassword = password_verify($_POST["password"], $hash);


            if($correctPassword)
            {
                $req = $bdd->prepare('SELECT * FROM users WHERE username=:username');
                $req -> execute(array('username'=> $_POST['username']));
                $sql = $req->fetch();
                $_SESSION['id'] = $sql['id'];
                $_SESSION['username'] = $sql['username'];
                $_SESSION['email'] = $sql['email'];
                header("Location:profil.php?id=".$_SESSION['id']);
                die();
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
                    <h1 class="display-4 typewriter">Evo | Ece Paris</h1>
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
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
                        </div>
                    </div>
                    <button type="submit" name="formconnection" class="btn btn-primary btn-lg btn-block">Se connecter</button>
                </form>
                <div class="texte  mt-2 text-center">
                    <small class="mdp"> Mot de passe oublié ?</small>
                    <a data-toggle="modal" data-target="#modal-default"><small>· S'inscrire sur Evo</small></a>
                </div>
            <div class="pro mt-6">
                <div class="progress-wrapper">
                    <div class="progress-info">
                        <div class="progress-label">
                            <span class="text-primary">Développement du site</span>
                        </div>
                        <div class="progress-percentage">
                            <span>5%</span>
                        </div>
                    </div>
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
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
                                    <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur" value="<?php if(isset($username)){echo $username;}?>" required>
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
                                        <span class="input-group-text"><i class="fa fa-venus-mars"></i></span>
                                    </div>
                                    <select name="genre" class="form-control">
                                        <option value="Homme" name="Homme">Homme</option> 
                                        <option value="Femme" name="Femme">Femme</option>     
                                    </select>
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
