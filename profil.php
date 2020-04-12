<?php
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');

    if(isset($_GET['id']) AND $_GET['id']> 0)
    {
        $getid=intval($_GET['id']); // Convertir en nombre
        $requser= $bdd->prepare('SELECT * FROM users WHERE id = ?');
        $requser->execute(array($getid));
        $userinfo = $requser-> fetch();

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
    <link type="text/css" href="./css/profile.css" rel="stylesheet">
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
                                <li><a class="dropdown-item" href="settings.php">Mes paramètres</a></li>
                                <li><a class="dropdown-item" href="deconnexion.php">Se déconnecter</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        

    </header>

    <div class="content ml-auto mr-auto">
        
        <div class="navleft">
            <div class="fond">
                <div class="roundedImage mx-auto" style="background-color:black; no-repeat 0px 0px;"></div>
                <span>
                    <div class="infouser">
                        <center class="nom"><?php echo $userinfo['username'];?></center>
                        <?php 
                        if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
                        {
                        ?>
                        <small><a href="#"><center>Editer mon profil</center></a></small>
                        <?php
                        }
                        ?>
                    </div>
                </span>


            </div>
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
<?php
}
?>


