<?php
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
    if(isset($_SESSION['id'])){
        $requser = $bdd->prepare("SELECT * FROM users WHERE id=?");
        $requser -> execute(array($_SESSION['id']));
        $user = $requser->fetch();
        if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo'] AND $_POST['newpseudo'] != $user['username'])){
            $newpseudo=htmlspecialchars($_POST['newpseudo']);
            $insertpseudo = $bdd->prepare("UPDATE users SET username = ? WHERE id= ?");
            $insertpseudo -> execute(array($newpseudo,$_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        }

        if(isset($_POST['newmail']) AND !empty($_POST['newmail'] AND $_POST['newmail'] != $user['email'])){
            $newmail=htmlspecialchars($_POST['newmail']);
            $insertmail = $bdd->prepare("UPDATE users SET email = ? WHERE id= ?");
            $insertmail -> execute(array($newmail,$_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        }

        if(isset($_POST['newmdp']) AND !empty($_POST['newmdp'] AND $_POST['newmdp'] != $user['password'])){
            $newmdp=password_hash($_POST['newmdp'], PASSWORD_DEFAULT);
            $insertmdp = $bdd->prepare("UPDATE users SET password = ? WHERE id= ?");
            $insertmdp -> execute(array($newmdp,$_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
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
    <link type="text/css" href="./css/settings.css" rel="stylesheet">
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
    <header>
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-dark navbar-theme-primary p-0">
            <div class="container position-relative">
                <span id="Titre" style="color:white;">Evo</span>
                <div class="navbar-collapse collapse" id="navbar-primary">
                    <div class="navbar-collapse-header">
                        <div class="row">
                            <div class="col-6 collapse-brand">
                                <a href="../../index.html">
                                    <img src="../../img/brand/secondary.svg" alt="menuimage">
                                </a>
                            </div>
                            <div class="col-6 collapse-close">
                                <i class="fas fa-times" data-toggle="collapse" role="button"
                                    data-target="#navbar-primary" aria-controls="navbar-primary"
                                    aria-expanded="false" aria-label="Toggle navigation"></i>
                            </div>
                        </div>
                    </div>
                    <ul class="navbar-nav navbar-nav-hover ml-5">
                        <li class="nav-item"><a href="#" class="nav-link">Accueil</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Profile</a></li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link" data-toggle="dropdown" role="button">
                                <span class="nav-link-inner-text">Mon compte</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../../html/sections/about.html">Messagerie</a></li>
                                <li><a class="dropdown-item" href="../../html/sections/blog.html">Mes paramètres</a></li>
                                <li><a class="dropdown-item" href="deconnexion.php">Se déconnecter</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        

    </header>

    <div class="content ml-auto mr-auto">
       <h4 class="p-3">Détails du compte</h4>
       <div class="formulaire">
        <form method="POST" action="" class="mt-4 ml-3">
            <div class="form-group">
                <label> Pseudo :<input type="text" placeholder="<?php echo $user['username']?>" class="form-control" style="width: 400px;" name="newpseudo"/></label>
                <label> Adresse mail :<input type="text" placeholder="<?php echo $user['email']?>" class="form-control" style="width: 400px;" name="newmail"/></label>
                <label> Mot de passe :<input type="password" placeholder="Mot de passe" class="form-control" style="width: 400px;" name="newmdp"/></label>
                <label> Avatar :<input type="file" class="form-control-file" name="avatar"></label>
            </div>
            <input type="submit" class="btn mb-2 mr-2 btn-primary" name="submit" value="Mettre à jour mes infos"></button>

        </form>

       </div>
    </div>




    <footer>
        <div class="container text-center">
            <div class="row p-4">
                <div class="col flex-center">
                  <!-- Facebook -->
                  <a class="fb-ic">
                    <i class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                  </a>
                  <!-- Twitter -->
                  <a class="tw-ic">
                    <i class="fab fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                  </a>
                  <!-- Google +-->
                  <a class="gplus-ic">
                    <i class="fab fa-google-plus-g fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                  </a>
                  <!--Linkedin -->
                  <a class="li-ic">
                    <i class="fab fa-linkedin-in fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                  </a>
                  <!--Instagram-->
                  <a class="ins-ic">
                    <i class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                  </a>
                  <!--Pinterest-->
                  <a class="pin-ic">
                    <i class="fab fa-pinterest fa-lg white-text fa-2x"> </i>
                  </a>
                </div>
                
            </div>
        </div>
        <div class="cop text-center">
            <small>Copyright © Malik Derkaoui 2020</small>
        </div>
    </footer>

</body>

</html>



