<?php
    
   
  session_start();
  $bdd= new PDO('mysql:host=localhost;dbname=login','root','');       
  $id=$_GET['id'];
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
  $prix = $_POST['prix'];

  $id2 =$_SESSION['id_acheteur'];

  $reqitem = $bdd->prepare("SELECT * FROM proposition_offre WHERE nomOffre = '".$id."' AND id_acheteur = '".$id2."' ");
  $reqitem->execute();
  $hit0 = $reqitem->fetch();
  $euh1 = $reqitem->rowCount();

  $reqvendeur = $bdd->query("SELECT id_vendeur FROM `items_negociation` WHERE `item_nom` = '".$id."' "); // Recherche id vendeur correspondant au produit
  $hit = $reqvendeur->fetch();

$reqessai = $bdd->query("SELECT Nbessais FROM `proposition_offre` WHERE `nomOffre` = '".$id."' AND `id_acheteur` = '".$id2."'" ); 
$hit1 = $reqessai->fetch();
$compteurve = $bdd->query("SELECT Nomitem,id_vendeur FROM `notif_vendeur` WHERE `Nomitem` = '".$id."' AND `id_acheteur` = '".$id2."'" ); 
$compteurve->execute();
$euh2 = $compteurve->rowCount();


  if($euh1 == 0 AND $euh2 == 0){
    
      
        
      $sql = $bdd->prepare("INSERT INTO `proposition_offre` (`id_proposition`, `prix`, `Nbessais`, `nomOffre`, `id_vendeur`, `id_acheteur`) VALUES (NULL, '".$prix."', '5', '".$id."', '".$hit['id_vendeur']."', '".$id2."')");
      $sql2 = $bdd->prepare("INSERT INTO `notif_vendeur`(`id_notifvendeur`, `Statut`, `Nomitem`, `Prixitem`, `id_vendeur`, `id_acheteur`) VALUES (NULL,'En cours','".$id."','".$prix."','".$hit['id_vendeur']."','".$id2."')");
      $sql->execute(array());
      $sql2->execute(array());
      header('Location:musee.php');


    }
    if($euh1==1 AND $euh2 == 1){
      
      header('Location: ' . $referer);
      header('Location:musee.php?error2=1');

    }else{
      if($hit1['Nbessais']==0){
        header('Location: ' . $referer);
      }else{   
      $sql3 = $bdd->prepare("INSERT INTO `notif_vendeur`(`id_notifvendeur`, `Statut`, `Nomitem`, `Prixitem`, `id_vendeur`, `id_acheteur`) VALUES (NULL,'En cours','".$id."','".$prix."','".$hit['id_vendeur']."','".$id2."')");
          $sql3->execute(array());
          header('Location: ' . $referer);


         }
          header('Location: ' . $referer);


      
    }
  



    
?>



  




