<?php
    date_default_timezone_set('Europe/Paris');
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
     $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if(isset($_SESSION['idadmin']) AND $_SESSION['idadmin'] > 0)
    {
      $getid=intval($_SESSION['idadmin']);
      $requser = $bdd->prepare('SELECT * FROM administrateur WHERE idadmin=?');
      $requser->execute(array($getid));
      $userinfo = $requser->fetch();

    }

  if(isset($_POST['envoie'])){

    $itemnom = htmlspecialchars($_POST['itemnom']); // htmlspecialchars  - Convertit les caractères spéciaux en entités HTML

    $item_desc = htmlspecialchars($_POST['item_desc']);
    $itemprix = htmlspecialchars($_POST['itemprix']);
    $itemcat = htmlspecialchars($_POST['itemcat']);
    $objdate = date_create_from_format('Y/m/d', $_POST['meeting-time']); 
    $id = $_POST['id'];
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

            $sql = $bdd->prepare("INSERT INTO items_enchere(item_nom,itemcat,itemphoto,item_desc,prix,id_vendeur,date_fin)VALUES('$itemnom','$itemcat','$itemphoto','$item_desc','$itemprix','$id','$date_fin')");
            $sql->execute(array($itemnom,$itemcat,$itemphoto,$item_desc,$itemprix,$id,$date_fin));

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
              <li><a href="../produits.php"><i class="fas fa-shopping-bag"></i>Gestionnaire</a></li>

              <li><a href="offres.php"><i class="fas fa-shopping-bag"></i>Offres d'enchères</a></li>
              <li><a href="../deconnexion.php"><i class="fas fa-power-off"></i>Se déconnecter</a></li>
          </ul> 
        </div>
    </div>
    <div class="main_content">
        <div class="header">
          Bienvenue sur Ebay ECE ! 
          <?php if (isset($_SESSION['idadmin']))
          {
            echo '<div style="float:right;">';
            echo "Vous êtes connecté en tant que ";
            echo $userinfo['email'];
            echo '</div>';
          }
          else{
           header("Location:../index.php");
            echo $userinfo['idadmin']; 
          }
          ?></div>  

          <?php
          

          
          $liste = $bdd->query("SELECT * FROM `items_enchere`");
          $tab = NULL;
          
           while ($produits = $liste->fetch())
            { 
                $tab .= '<tr></th>
                <th>'.$produits['item_nom'].'</th>
                <th><img src="../../articlesimg/'.$produits['itemphoto'].'" style="width:50px;height:50px;border-radius:50px;"></th>
                <th>'.$produits['item_desc'].'</th>
                <th>'.$produits['itemcat'].'</th>
                <th>'.$produits['prix'].'€</th>
                <th>'.$produits['date_fin'].'</th>
                <th><a href="delete.php?id='.$produits['item_nom'].'"<button class="btn mb-2 mr-2 btn-sm btn-danger" type="button">Supprimer</button></a></th>
                </tr>';
  }


       ?>


          <div class="container ml-5 p-5">
            <button type="button" class="btn btn-block btn-secondary mb-1" data-toggle="modal" data-target="#modal-default" style="width: 100px;float:left;">Ajouter</button>
        <table class="table"> 

          <thead class="thead-dark">
            <tr>
             <th>Nom</th>
             <th>Photo</th>
             <th>Description</th>
             <th>Catégorie</th>
             <th>Prix</th>
             <th>Fin</th>
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
          <div class="modal fade" tabindex="-1" role="dialog" id="modal-default">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un produit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="" enctype="multipart/form-data">
                    <label for="exampleForm2" style="float: left;">Nom :</label>
                    <input type="text"  class="form-control mb-3" name="itemnom" placeholder="Nom de l'article" required>
                    <label for="exampleForm2" style="float: left;">Catégorie :</label>
                    <select name="itemcat" class="form-control mb-3">
                      <option value="Ferraille" name="Ferraille">Ferraile ou Trésor</option> 
                      <option value="musee" name="musee">Bon pour le musée</option>  
                      <option value="vip" name="vip" style="text-align: center;">Accessoire VIP</option>   
                    </select>
                    <label for="exampleForm2" style="float: left;">Prix :</label>
                    <input type="text"  class="form-control mb-3" name="itemprix" placeholder="500€" required>
                    <div class="form-group mb-3">
                    <label for="exampleForm2" style="float: left;">Description :</label>
                      <textarea class="form-control rounded-0" id="exampleFormControlTextarea2" rows="3" name="item_desc" required></textarea>
                    </div>
                    <label for="exampleForm2" style="float: left;">Photo :</label>
                    <div class="btn mb-2 mr-2 btn-sm btn-indigo">
                      <input type="file" name="itemphoto" required>
                    </div>
                    <label for="exampleForm2" style="float: left;">Fin de l'enchère :</label><br>
                    <input type="date" id="meeting-time" name="meeting-time" class="mb-3"><br>
                    <label for="exampleForm2" style="float: left;">Id du vendeur:</label><br>
                    <?php
                        $liste = $bdd->query("SELECT id_vendeur FROM `vendeurs`");
                        $tab = NULL;
                        while ($id = $liste->fetch())
                        {
                          $tab .= '<option value="'.$id['id_vendeur'].'" name="'.$id['id_vendeur'].'">'.$id['id_vendeur'].'</option>';
                        }
                        
                      ?>
                    <select name="id" class="form-control mb-3">
                      <?php
                        echo $tab;
                      ?>                    

                    </select>
                    <input type="submit" class="btn btn-dark" name="envoie" value="Envoyer" required>
                  </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm btn-indigo" data-dismiss="modal">Fermer</button>
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