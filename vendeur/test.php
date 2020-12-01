<?php
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
    //Activation des erreurs
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_SESSION['idvendeur']) AND $_SESSION['idvendeur'] > 0)
    {
      $getid=intval($_SESSION['idvendeur']);
      $requser = $bdd->prepare('SELECT * FROM vendeurs WHERE idvendeur=?');
      $requser->execute(array($getid));
      $userinfo = $requser->fetch();

    }

  if(isset($_POST['envoie'])){

    $itemnom = htmlspecialchars($_POST['itemnom']); // htmlspecialchars  - Convertit les caractères spéciaux en entités HTML

    $item_desc = htmlspecialchars($_POST['item_desc']);
    $itemprix = htmlspecialchars($_POST['itemprix']);
    $itemcat = htmlspecialchars($_POST['itemcat']);


    if(isset($_FILES["itemphoto"]) AND !empty($_FILES["itemphoto"]["name"]))
   {
      $tailleMax = 2097152;
      $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
      if($_FILES["itemphoto"]["size"] <= $tailleMax)
      {
         $extensionsUpload = strtolower(substr(strrchr($_FILES['itemphoto']['name'], '.'), 1));
         if(in_array($extensionsUpload, $extensionsValides))
      {
         $chemin = "../articlesimg/".$_FILES['itemphoto']['name'].".".$extensionsUpload;
         $resultat = move_uploaded_file($_FILES["itemphoto"]["tmp_name"], $chemin);
         $itemphoto=$_FILES['itemphoto']['name'];
         if($resultat)
         {
            $sql = $bdd->prepare("INSERT INTO items(item_nom,itemcat,itemphoto,item_desc,prix,id_vendeur) VALUES ('$itemnom','$itemcat','$itemphoto','$item_desc','$itemprix','".$_SESSION['idvendeur']."')");
            $sql->execute(array($itemnom,$itemcat,$itemphoto,$item_desc,$itemprix));

         }
         else
         {
            $msg ='<div class="alert alert-warning">Erreur durant l\'importation de la photo</div>';
            echo $msg;
         }
      }
      else
      {
        $msg ='<div class="alert alert-warning">L\'image doit être en jpg, jpeg, gif ou png</div>';
        echo $msg;
      }
      }
      else
      {
        $msg ='<div class="alert alert-warning">La photo ne doit pas dépasser 2Mo</div>';
        echo $msg;
      }
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
  </head>

  <body>

    <div class="container-fluid">

      <div class="row">
        <div class="col-sm-3">
          <div class="card">
            <img class="card-img-top" src="img/encheres550.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Aux enchères !</h5>
              <p class="card-text"><small>Comment fonctionne la vente par enchère ?</small></p>
              <p class="card-text" style="font-size: 14px;">Vous souhaitez vendre votre article au meilleur prix ? La vente par enchère est faite pour vous ! <br>En tant que vendeur, vous bénéficiez d'un prix de réserve alors n'hésitez plus !</p>
              <a href="#" class="btn btn-primary">J'accède aux enchères</a>
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
              <a href="#" class="btn btn-primary">J'accède aux enchères</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="card">
            <img class="card-img-top" src="img/negociation.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">La meilleure offre !</h5>
              <p class="card-text"><small>Comment fonctionne la vente par meilleure offre ?</small></p>
              <p class="card-text" style="font-size: 14px;">Vous souhaitez vendre votre article au plus offrant ? <br>La vente par négociation est faite pour vous ! <br>Les clients négocient avec vous pour conclure une vente. <br> Alors n'hésitez plus !</p>
              <a href="#" class="btn btn-primary">J'accède aux ventes</a>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>


	</body>
</html>