<?php
    date_default_timezone_set('Europe/Paris');
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
    //Activation des erreurs

    if(isset($_SESSION['idadmin']) AND $_SESSION['idadmin'] > 0)
    {
      $getid=intval($_SESSION['idadmin']);
      $requser = $bdd->prepare('SELECT * FROM administrateur WHERE idadmin=?');
      $requser->execute(array($getid));
      $userinfo = $requser->fetch();

    }

    if (isset($_POST['envoie']))
    {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        if(!empty($_POST['pseudo']) AND !empty($_POST['email']))
        {
            
            $pseudolength = strlen($pseudo);
            
                if ($pseudolength <= 20)
                {
                    if (filter_var($email,FILTER_VALIDATE_EMAIL))
                    {
                        $reqmail = $bdd->prepare("SELECT * FROM vendeurs WHERE email = ?"); // Vérification de l'adresse mail Si déjà présente dans la BDD
                        $reqmail->execute(array($email));
                        $mailexiste= $reqmail->rowCount();
                        if($mailexiste ==0)
                        {
                          $sql = $bdd->prepare("INSERT INTO vendeurs(`id_vendeur`, `email`, `pseudo`, `avatar`, `banniere`) VALUES (NULL,'$email','$pseudo',NULL,NULL)");
                          $sql->execute(array($email,$pseudo));
                          $info = '<div class="alert alert-success">Ajout effectué!</div>';
                          echo $info;
                           
                        }
                        else
                        {
                            $info = '<div class="alert alert-danger">Adresse mail déjà utilisée !</div>';
                            echo $info; 
                        }
                    }
                    else
                    {
                        $info='<div class="alert alert-danger">L\'adresse mail est incorrecte</div>';
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
              <li><a href="../../deconnexion.php"><i class="fas fa-power-off"></i>Se déconnecter</a></li>
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
          

          
          $liste = $bdd->query("SELECT * FROM `vendeurs`");
          $tab = NULL;
          
           while ($produits = $liste->fetch())
            { 
                $tab .= '<tr>
                <th>'.$produits['email'].'</th>
                <th>'.$produits['pseudo'].'</th>
                <th><img src="../../avatars/'.$produits['id_vendeur'].'" style="width:50px;height:50px;border-radius:50px;"></th>
                <th><a href="delete.php?id='.$produits['id_vendeur'].'"<button class="btn mb-2 mr-2 btn-sm btn-danger" type="button">Supprimer</button></a></th>
                </tr>';
  }


       ?>


          <div class="container ml-5 p-5">
            <button type="button" class="btn btn-block btn-secondary mb-1" data-toggle="modal" data-target="#modal-default" style="width: 100px;left:990px;">Ajouter</button>
        <table class="table"> 

          <thead class="thead-dark">
            <tr>
             <th>Email</th>
             <th>Pseudo</th>
             <th>Avatar</th>
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
                    <h5 class="modal-title">Ajouter un vendeur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="" enctype="multipart/form-data">
                    <label for="exampleForm2" style="float: left;">Pseudo :</label>
                    <input type="text"  class="form-control mb-3" name="pseudo" placeholder="Pseudo du vendeur" required>
                    <label for="exampleForm2" style="float: left;">Email :</label>
                    <input type="email"  class="form-control mb-3" name="email" placeholder="Email du vendeur" style="text-align:left"required>
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