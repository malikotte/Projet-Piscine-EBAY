<?php
    date_default_timezone_set('Europe/Paris');
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');


    if(isset($_SESSION['id_acheteur']) AND $_SESSION['id_acheteur'] > 0)
    {
      $getid=intval($_SESSION['id_acheteur']);
      $requser = $bdd->prepare('SELECT * FROM acheteurs WHERE id_acheteur=?');
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
    <link rel="icon" href="../../img/favicon-16x16.png"/>
    <!-- Pixel CSS -->
    <!-- Mon CSS -->
    <link type="text/css" href="../css/animate.css" rel="stylesheet">
    <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <!-- Core -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/popper/popper.min.js"></script>
    <script src="../vendor/bootstrap/bootstrap.min.js"></script>
    <script src="../vendor/headroom/headroom.min.js"></script>

    <!-- Vendor JS -->
    <script src="../vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="../vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="../vendor/smooth-scroll/smooth-scroll.polyfills.min.js"></script>
    <!-- pixel JS -->
    <script src="../js/pixel.js"></script>
    <script src="../js/jquery.min.js"></script>


    <link type="text/css" href="../css/pixel.css?v=1.0.1" rel="stylesheet">
    <link type="text/css" href="css/stylesferraile.css" rel="stylesheet">

    <script type="text/javascript">
      $(document).ready( function () {
    $('.table').DataTable();
} );
    </script>
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
              <li><a href="../../produits.php"><i class="fas fa-shopping-bag"></i>Annonces</a></li>
              <li><a href="ferraille.php"><i style="font-size:0.5rem;" class="fas fa-circle fa-sm"></i>Ferraille ou Trésor</a></li>
              <li><a href="musee.php"><i style="font-size:0.5rem;" class="fas fa-circle fa-sm"></i>Pour le musée</a></li>
              <li><a href="vip.php"><i style="font-size:0.5rem;" class="fas fa-circle fa-sm"></i>Accessoires VIP</a></li>
              <li><a href="../monpanier.php"><i class="fas fa-cart-plus"></i>Mon panier</a></li>
              <li><a href="../profil.php"><i class="fas fa-user"></i>Mon compte</a></li>
              <li><a href="../notifications/notifications.php"><i class="fas fa-bell"></i>Notifications</a></li>
              <li><a href="../deconnexion.php"><i class="fas fa-power-off"></i>Se déconnecter</a></li>
          </ul> 
        </div>
    </div>
    <div class="main_content">
        <div class="header">
          Ferraille et Trésor 
          <?php if (isset($_SESSION['id_acheteur']))
          {
            echo '<div style="float:right;">';
            echo "Vous êtes connecté en tant que ";
            echo $userinfo['email'];
            echo '</div>';
          }
          else{
           header("Location:../index.php");
          }
          ?>
    
          </div>  
          <?php
if(isset($_GET['error'])){
            $msg = '<div class="alert alert-warning">Votre montant doit être supérieur au prix de lancement !</div>';
      
     }else{

      $msg = NULL;

     }
     ?>
     <?php
if(isset($_GET['error1'])){
            $msg1 = '<div class="alert alert-warning">Vous avez déjà enchéri !</div>';
      
     }else{

      $msg1 = NULL;

     }
     ?>
     <?php
if(isset($_GET['success'])){
            $msg2 = '<div class="alert alert-success">Votre enchère a bien été envoyée !</div>';
      
     }else{

      $msg2 = NULL;

     }
     ?>
     <?php
if(isset($_GET['error3'])){
            $msg3 = '<div class="alert alert-warning">Votre montant doit être supérieur à la dernière offre !</div>';
      
     }else{

      $msg3 = NULL;

     }
     ?>
          <?php
          if(isset($msg)){
            echo $msg;
          }
          ?>
          <?php
          if(isset($msg1)){
            echo $msg1;
          }
          ?>
          <?php
          if(isset($msg2)){
            echo $msg2;
          }
          ?>
          <?php
          if(isset($msg3)){
            echo $msg3;
          }
          ?>
          <?php
          $liste = $bdd->query("SELECT * FROM items_enchere WHERE itemcat = 'Ferraille' ");
          $tab= NULL;
          $compteur=$liste->rowCount();
          if($compteur !=0){
            while($produits = $liste->fetch())
            {
              $maxprix =$bdd->query("SELECT MAX(Prixpropose) AS nummax FROM proposition_enchere WHERE nomItem = '".$produits['item_nom']."' ");
              $max=$maxprix->fetch();

              $today = date("Y-m-d"); 
              if($today < $produits['date_fin']){

                $tab .= '<div class="col-sm-3">
                            <div class="card mb-3">
                            <form method="POST" action="faireOffreferr.php?id='.$produits['item_nom'].'">
                              <img class="card-img-top" src="../articlesimg/'.$produits['itemphoto'].'" style="width:200px;height:200px;margin-left:auto;margin-right:auto;border-radius:50px;"alt="Card image cap">
                              <div class="card-body">
                                <h5 class="card-title" style="text-align: center;"> '.$produits['item_nom'].'</h5>
                                <p class="card-text" style="font-size: 14px;text-align: center;"><i>'.$produits['item_desc'].'</i></p>
                                <p class="card-text" style="font-size: 14px;text-align: center;">Prix de lancement<br>'.$produits['prix'].'€</p>
                                <p class="card-text" style="font-size: 14px;text-align: center;">Dernier prix proposé<br>'.$max['nummax'].'€</p>
                                <p class="card-text" style="font-size: 14px;text-align: center;">Date de fin<br>'.$produits['date_fin'].'</p>
                                <div class="form-group">
                                  <input type="text" name="prix" style="text-align:center;" placeholder="Votre prix" class="form-control"/>
                                </div>
                                <center><button data-toggle="modal" data-target="#modal-default" class="btn btn-secondary" style="color:white,margin:auto">Faire une offre</button></center>
                                </div>
                            </form>
                            </div>
                          </div>';
              }

            }
          }else{
            echo '<img src="empty_cart.png" style="display:block;margin-top:100px;">';
          }
        
          ?>

  <div class="container-fluid">
      <div class="row mt-5 pl-5">
        <?php
          echo $tab;
        ?>

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