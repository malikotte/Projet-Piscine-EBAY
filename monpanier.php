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

      $reqcb = $bdd->prepare('SELECT * FROM carte_bancaire WHERE id_acheteur=?');
      $reqcb->execute(array($getid));
      $carte = $reqcb->fetch();

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
    <script src="js/pixel.js"></script>
    <script src="js/jquery.min.js"></script>


    <link type="text/css" href="css/pixel.css?v=1.0.1" rel="stylesheet">
    <link type="text/css" href="css/stylesenchere.css" rel="stylesheet">

    <script type="text/javascript">
      $(document).ready( function () {
    $('.table').DataTable();
} );
    </script>
  </head>
<?php
if(isset($_GET['error'])){
            $msg5 = '<div class="alert alert-warning">Votre panier est vide !</div>';
      
     }else{

      $msg5 = NULL;

     }
     ?>
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
              <li><a href="../produits.php"><i class="fas fa-shopping-bag"></i>Annonces</a></li>
              <li><a href="../monpanier.php"><i class="fas fa-cart-plus"></i>Mon panier</a></li>
              <li><a href="../profil.php"><i class="fas fa-user"></i>Mon compte</a></li>              
              <li><a href="notifications/notifications.php"><i class="fas fa-bell"></i>Notifications</a></li>
              <li><a href="../deconnexion.php"><i class="fas fa-power-off"></i>Se déconnecter</a></li>
          </ul> 
        </div>
    </div>
    <div class="main_content">
        <div class="header">
          Mon Panier
          <?php if (isset($_SESSION['id_acheteur']))
          {
            echo '<div style="float:right;">';
            echo "Vous êtes connecté en tant que ";
            echo $userinfo['email'];
            echo '</div>';
          }
          else{
           header("Location:../index.php");
            echo $userinfo['email']; 
          }
          ?></div>  
          <?php echo $msg5 ?>

          <?php
          

          
          $liste = $bdd->query("SELECT Prix,Nom FROM panier WHERE id_acheteur = '".$_SESSION['id_acheteur']."' ");
          $tab = NULL;

           while ($produits = $liste->fetch())
            { 
            	$photo = $bdd->query("SELECT * FROM items_achat WHERE item_nom= '".$produits['Nom']."' ");
            	$hit = $photo->fetch();
                $tab .= '<tr></th>
                <th><img src="articlesimg/'.$hit['itemphoto'].'" style="width:50px;height:50px;border-radius:50px;"></th>
                <th>'.$produits['Nom'].'</th>
                <th>'.$produits['Prix'].'€</th>
                <th><a href="deletepanier.php?id='.$produits['Nom'].'"<button class="btn mb-2 mr-2 btn-sm btn-danger" type="button">Supprimer</button></a></th>
                </tr>';
  			}


       ?>


          <div class="container ml-5 p-5">
            <a href="confirmationCommande.php?id=<?php echo $_SESSION['id_acheteur']?>"><button type="button" class="btn btn-block btn-secondary mb-1" data-toggle="modal" data-target="#modal-default" style="width: 100px;left:940px;">Valider</button></a>
        <table class="table"> 

          <thead class="thead-dark">
            <tr>
             <th>Photo</th>
             <th>Nom</th>
             <th>Prix</th>
             <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              echo $tab;
            ?>

          </tbody>
          <?php
          	
  			$total=$bdd->query("SELECT SUM(Prix) FROM panier WHERE id_acheteur = '".$_SESSION['id_acheteur']."'");
  			$tot = $total->fetch();
  			

          ?>
        </table>
        <label style="color:black;">Montant de la commande : <?php echo $tot['SUM(Prix)'];?> €</label>
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