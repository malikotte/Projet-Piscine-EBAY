<?php
    date_default_timezone_set('Europe/Paris');
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');


    if(isset($_SESSION['id_vendeur']) AND $_SESSION['id_vendeur'] > 0)
    {
      $getid=intval($_SESSION['id_vendeur']);
      $requser = $bdd->prepare('SELECT * FROM vendeurs WHERE id_vendeur=?');
      $requser->execute(array($getid));
      $userinfo = $requser->fetch();

    }

  if(isset($_POST['envoie'])){

    $itemnom = htmlspecialchars($_POST['itemnom']); // htmlspecialchars  - Convertit les caractères spéciaux en entités HTML

    $item_desc = htmlspecialchars($_POST['item_desc']);
    $itemprix = htmlspecialchars($_POST['itemprix']);
    $itemcat = htmlspecialchars($_POST['itemcat']);
    $objdate = date_create_from_format('Y/m/d', $_POST['meeting-time']); 
    
    if(isset($_FILES["itemphoto"]) AND !empty($_FILES["itemphoto"]["name"]))
   {
      $tailleMax = 2097152;
      $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
      if($_FILES["itemphoto"]["size"] <= $tailleMax)
      {
         $extensionsUpload = strtolower(substr(strrchr($_FILES['itemphoto']['name'], '.'), 1));
         if(in_array($extensionsUpload, $extensionsValides))
      {
         $chemin = "../../articlesimg/".$_FILES['itemphoto']['name'].".".$extensionsUpload;
         $resultat = move_uploaded_file($_FILES["itemphoto"]["tmp_name"], $chemin);
         $itemphoto=$_FILES['itemphoto']['name'];
         if($resultat)
         {
            // $date_inscri= date("Y-m-d");
            $objdate = date_create_from_format('Y-m-d', $_POST['meeting-time']);
            $date_fin = $objdate->format('Y-m-d'); 

            $sql = $bdd->prepare("INSERT INTO items_enchere(item_nom,itemcat,itemphoto,item_desc,prix,id_vendeur,date_fin)VALUES('$itemnom','$itemcat','$itemphoto','$item_desc','$itemprix','".$_SESSION['id_vendeur']."','$date_fin')");
            $sql->execute(array($itemnom,$itemcat,$itemphoto,$item_desc,$itemprix,$date_fin));

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
   }else{
    header('Location:enchere.php');
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
    <link type="text/css" href="css/stylesenchere.css" rel="stylesheet">

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
              <li><a href="../produits.php"><i class="fas fa-shopping-bag"></i>Mes produits</a></li>
              <li><a href="../profil.php"><i class="fas fa-user"></i>Mon profil</a></li>
              <li><a href="notifications.php"><i class="fas fa-bell"></i>Notifications</a></li>
              <li><a href="../../deconnexion.php"><i class="fas fa-power-off"></i>Se déconnecter</a></li>
          </ul> 
        </div>
    </div>
    <div class="main_content">
        <div class="header">
          <?php
if(isset($_GET['error'])){
            $info = '<div class="alert alert-warning">Nombre max atteint !</div>';
      
     }else{

      $info = NULL;

     }
     ?>

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
            echo $userinfo['id_vendeur']; 
          }
          ?></div>  

          <?php
          

          
          $liste = $bdd->query("SELECT Statut,Nomitem,Prixitem FROM notif_vendeur WHERE id_vendeur = '".$_SESSION['id_vendeur']."' ");
          $tab = NULL;
          
           while ($notif = $liste->fetch())
            { 
                $tab .= '<tr></th>
                <th>'.$notif['Nomitem'].'</th>
                <th>'.$notif['Prixitem'].'€</th>
                <th>'.$notif['Statut'].'</th>
                <th><a href="accepter.php?id='.$notif['Nomitem'].'"><button class="btn mb-2 mr-2 btn-sm btn-success" type="button">Accepter</button></a><a href="delete.php?id='.$notif['Nomitem'].'"<button class="btn mb-2 mr-2 btn-sm btn-danger" type="button">Décliner</button></a></th>
                </tr>';
  }


       ?>


          <div class="container ml-5 p-5">
            
        <table class="table"> 

          <thead class="thead-dark">
            <tr>
             <th>Nom</th>
             <th>Prix</th>
             <th>Statut</th>
             <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              echo $tab;
            ?>
          </tbody>
        </table>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          
          
    </div>
    
</div>

<!-- Footer -->
          <div style="padding-top:260px;padding-left: 200px;">
            <footer id="sticky-footer" class="mt-5" style="flex-shrink: none; border-top:1px solid rgba(0, 0, 0, 0.1);">
              <div class="container-fluid mt-2">
                <small>Ebay ECE Paris | Malik Derkaoui, Pierre Jenselme, Ayoub Ouboujemaa © 2020 Tous droits réservés.</small>
              </div>
            </footer>
        </div>

  </body>
</html>