<?php
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
    //Activation des erreurs
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_SESSION['id_vendeur']) AND $_SESSION['id_vendeur'] > 0)
    {
      $getid=intval($_SESSION['id_vendeur']);
      $requser = $bdd->prepare('SELECT * FROM vendeurs WHERE id_vendeur=?');
      $requser->execute(array($getid));
      $userinfo = $requser->fetch();

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
    <link type="text/css" href="../css/pixel.css?v=1.0.1" rel="stylesheet">
    <!-- Mon CSS -->
    <link type="text/css" href="./css/animate.css" rel="stylesheet">
    <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link type="text/css" href="./css/styleproduits.css" rel="stylesheet">
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
    <script type="text/javascript">
      $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>
    <style>
      a{
        background-color: #274991;
      }
    </style>
  </head>

  <body>
        <script src="/js/b99e675b6e.js"></script>
<div class="wrapper">
    <div class="sidebar">

        <h2 class="display-4 typewriter">Ebay ECE</h2>
        <div class="profil">
          <div class="row">
            <div class="col-sm-2">
              <div class="profile-userpic">
              </div>
            </div>
          </div>
        </div>
        <div class="boutons">
          <ul>
              <li><a href="produits.php"><i class="fas fa-shopping-bag"></i>Mes produits</a></li>
              <li><a href="profil.php"><i class="fas fa-user"></i>Mon profil</a></li>
              <li><a href="notifications/notifications.php"><i class="fas fa-bell"></i>Notifications</a></li>
              <li><a href="../deconnexion.php"><i class="fas fa-power-off"></i>Se déconnecter</a></li>
          </ul> 
        </div>
    </div>
    <div class="main_content">
        <div class="header">
          Bienvenue sur Ebay ECE ! 
          <?php if (isset($_SESSION['id_vendeur']))
          {
            echo '<div style="float:right;">';
            echo "Vous êtes connecté en tant que ";
            echo $userinfo['pseudo'];
            echo '</div>';
          }
          else{
           header("Location:../index.php");
          }
          ?>
    
          </div>  


  <div class="container-fluid">

      <div class="row mt-5 pl-5">
        <div class="col-sm-3">
          <div class="card">
            <img class="card-img-top" src="img/encheres550.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Aux enchères !</h5>
              <p class="card-text"><small>Comment fonctionne la vente par enchère ?</small></p>
              <p class="card-text" style="font-size: 14px;">Vous souhaitez vendre votre article au meilleur prix ? La vente par enchère est faite pour vous ! <br>En tant que vendeur, vous bénéficiez d'un prix de réserve alors n'hésitez plus !</p>
              <a href="enchere/enchere.php" class="btn btn-primary" style="background-color: #274991;border-color: #274991; color:white;">Vendre aux enchères</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="card">
            <img class="card-img-top" src="img/achat.jpeg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Sur le marché !</h5>
              <p class="card-text"><small>Comment fonctionne la vente par achat immédiat ?</small></p>
              <p class="card-text" style="font-size: 14px;">Vous ne souhaitez prendre aucun risque et vendre au prix de votre choix ? <br> Vous ne risquez rien, votre article, votre prix. <br>Lancez-vous dès maintenant !</p>
              <a href="marché/marche.php" class="btn primary-color-dark" style="background-color: #274991;border-color: #274991; color:white;">Vendre sur le marché</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="card">
            <img class="card-img-top" src="img/negociation.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">La meilleure offre !</h5>
              <p class="card-text"><small>Comment fonctionne la vente par meilleure offre ?</small></p>
              <p class="card-text" style="font-size: 14px;">Vous souhaitez vendre votre article au plus offrant ? La vente par négociation est faite pour vous ! Les clients négocient avec vous pour conclure une vente.</p>
              <a href="negociation/negociation.php" class="btn primary-color-dark" style="background-color: #274991;border-color: #274991; color:white;">Vendre par négociation</a>
            </div>
          </div>
        </div>
  </div>
</div>
<div style="padding-top:215px;">
  <footer id="sticky-footer" class="mt-5" style="flex-shrink: none; border-top:1px solid rgba(0, 0, 0, 0.1);">
    <div class="container-fluid mt-2">
      <small>Ebay ECE Paris | Malik Derkaoui, Pierre Jenselme, Ayoub Ouboujemaa © 2020 Tous droits réservés.</small>
    </div>
  </footer>
</div>


	</body>
</html>