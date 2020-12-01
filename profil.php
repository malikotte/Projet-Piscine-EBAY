<?php
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
    //Activation des erreurs
    if(isset($_SESSION['id_acheteur']) AND $_SESSION['id_acheteur'] > 0)
    {
      $getid=intval($_SESSION['id_acheteur']);
      $requser = $bdd->prepare('SELECT * FROM acheteurs WHERE id_acheteur=?');
      $requser->execute(array($getid));
      $userinfo = $requser->fetch();
      $reqadresse = $bdd->prepare('SELECT * FROM adresse WHERE id_acheteur=?');
      $reqadresse->execute(array($getid));
      $adresse = $reqadresse->fetch();
    }


    if(isset($_SESSION['id_acheteur']))
    {
      $requser = $bdd->prepare("SELECT * FROM acheteurs WHERE id_acheteur=?");
      $requser->execute(array($_SESSION['id_acheteur']));
      $user = $requser->fetch();

      if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo'])
      {
        $newpseudo=htmlspecialchars($_POST['newpseudo']);
        $insertpseudo = $bdd->prepare("UPDATE acheteurs SET nom =? where email=?");
        $insertpseudo->execute(array($newpseudo,$_SESSION['email']));
        header("Location : profil.php");
      }

      if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['email'])
      {
        $newmail=htmlspecialchars($_POST['newmail']);
        if(filter_var($newmail,FILTER_VALIDATE_EMAIL))
        {
          $insertpseudo = $bdd->prepare("UPDATE acheteurs SET email =? where email=?");
          $insertpseudo->execute(array($newmail,$_SESSION['email']));
          header("Location : profil.php");
        }
        else{
          $info = '<div class="alert alert-danger">Votre adresse email n\'est pas valide !</div>';
          echo $info;
        }
      }
    }else{
    header("Location:index.php");
  }


    // Banniere AVATAR
if(isset($_POST['photo'])){
    if(isset($_FILES["avatar"]) AND !empty($_FILES["avatar"]["name"]) || isset($_FILES["banniere"]) AND !empty($_FILES["banniere"]["name"]))
   {
      $tailleMax = 2097152;
      $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
      if($_FILES["avatar"]["size"] <= $tailleMax || $_FILES["banniere"]["size"] <= $tailleMax)
      {
         $extensionsUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
         $extensionsUpload = strtolower(substr(strrchr($_FILES['banniere']['name'], '.'), 1));
         if(in_array($extensionsUpload, $extensionsValides))
      {
         $chemin = "avatars/".$_SESSION['id_acheteur'].".".$extensionsUpload;
         $chemin2 = "bannieres/".$_SESSION['id_acheteur'].".".$extensionsUpload;
         $resultat = move_uploaded_file($_FILES["avatar"]["tmp_name"], $chemin);
         $resultat2 = move_uploaded_file($_FILES["banniere"]["tmp_name"], $chemin2);
         if($resultat || $resultat2)
         {
            $updateavatar = $bdd->prepare('UPDATE acheteurs SET avatar = :avatar WHERE id_acheteur = :id_acheteur');
            $updatebanniere = $bdd->prepare('UPDATE acheteurs SET banniere = :banniere WHERE id_acheteur = :id_acheteur');
            $updateavatar->execute(array('avatar' => $_SESSION['id_acheteur'].".".$extensionsUpload,
               'email' => $_SESSION['id_acheteur']));
            $updatebanniere->execute(array('banniere' => $_SESSION['id_acheteur'].".".$extensionsUpload,
               'email' => $_SESSION['id_acheteur']));
            header('Location: profil.php');
         }
         else
         {
            $msg ='<div class="alert alert-warning">Erreur durant l\'importation de la photo</div>';
            echo $msg;
         }
      }
      else
      {
        $msg ='<div class="alert alert-warning">Votre photo de profil doit être en jpg, jpeg, gif ou png</div>';
        echo $msg;
      }
      }
      else
      {
        $msg ='<div class="alert alert-warning">Votre photo de profil ne doit pas dépasser 2Mo</div>';
        echo $msg;
      }
   }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Ebay ECE</title>

    <link rel="icon" href="img/favicon-16x16.png" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link type="text/css" href="pixel.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mdb.min.css">
    <link type="text/css" href="pixel.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

  </head>
  <body>

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
              <li><a href="produits.php"><i class="fas fa-shopping-bag"></i>Annonces</a></li>
              <li><a href="monpanier.php"><i class="fas fa-cart-plus"></i>Mon panier</a></li>
              <li><a href="profil.php"><i class="fas fa-user"></i>Mon compte</a></li>
              <li><a href="notifications/notifications.php"><i class="fas fa-bell"></i>Notifications</a></li>
              <li><a href="../deconnexion.php"><i class="fas fa-power-off"></i>Se déconnecter</a></li>
          </ul> 
        </div>
    </div>
    <div class="main_content">
        <div class="header">Bienvenue sur Ebay ECE ! 
          <?php 
          if (isset($_SESSION['id_acheteur']))
          {
            echo '<div style="float:right;">';
            echo "Vous êtes connecté en tant que ";
            echo $userinfo['email'];
            echo '</div>';
          }
          else{
          }
          ?></div>

        <div class="info">
          <div class="container">
            <div class="row">
              <div class="col-sm-9">
                <div class="formulaire">
                  <div class="header-form">
                    <label style="font-size:20px; margin-top: 15px;margin-left:20px;"> Editer mon profil</label>
                  </div>
                  <form method="POST" action="" style="margin-top: 50px;">
                    <div class="form-group">
                      <label style="font-size: 15px;">Nom d'utilisateur :</label><input type="text" name="newpseudo" placeholder="<?php echo $userinfo['nom'];?>" class="form-control form-after"/>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 15px;">Adresse email :</label><input type="email" name="newmail" placeholder="<?php echo $userinfo['email'];?>" class="form-control form-after" />
                    </div>
                    <div class="form-group">
                      <label style="font-size: 15px;">Adresse postale :</label><input type="email" name="newmail" placeholder="<?php echo $adresse['AdresseLigne1'];?>" class="form-control form-after" disabled/>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 15px;">Ville :</label><input type="email" name="newmail" placeholder="<?php echo $adresse['Ville'];?>" class="form-control form-after" disabled/>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 15px;">Téléphone :</label><input type="email" name="newmail" placeholder="<?php echo $adresse['Tel'];?>" class="form-control form-after" disabled/>
                    </div>

                    <input type="submit" name="photo" class="btn btn-indigo" value="Modifier mes informations">
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div style="padding-top:355px;">
            <footer id="sticky-footer" class="mt-5" style="flex-shrink: none; border-top:1px solid rgba(0, 0, 0, 0.1);">
              <div class="container-fluid mt-2">
                <small>Ebay ECE Paris | Malik Derkaoui, Pierre Jenselme, Ayoub Ouboujemaa © 2020 Tous droits réservés.</small>
              </div>
            </footer>
        </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <!-- Your custom scripts (optional) -->
  <script type="text/javascript"></script>
  </body>
</html>