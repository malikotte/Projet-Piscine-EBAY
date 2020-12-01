<?php

  session_start();
  $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
  $id=$_GET['id'];
   
  $id1 = $_SESSION['id_vendeur'];

  $sql2 = "UPDATE `proposition_offre` SET `Nbessais` = Nbessais-1 WHERE nomOffre = '".$id."' AND id_vendeur = '".$id1."'";

  $liste2 = $bdd->query("SELECT * FROM proposition_offre WHERE nomOffre = '".$id."' ");
  $notif2 = $liste2->fetch();
  $sql = "DELETE FROM notif_vendeur WHERE Nomitem = '".$id."' AND id_acheteur = '".$notif2['id_acheteur']."'" ;

  $reqprix = $bdd->prepare("SELECT * FROM notif_acheteur WHERE nomOffre = '".$id."' AND id_acheteur = '".$notif2['id_acheteur']."' ");
  $reqprix->execute();
  $euh1 = $reqprix->rowCount();
  $liste = $bdd->query("SELECT Statut,Nomitem,Prixitem FROM notif_vendeur WHERE id_vendeur = '".$_SESSION['id_vendeur']."' ");
  $notif = $liste->fetch();

  if ($euh1 == 1){
    $sql3=$bdd->prepare("INSERT INTO `notif_acheteur`(`id_notifacheteur`, `Statut`, `Nomitem`, `Prixitem`, `id_acheteur`,`id_vendeur`) VALUES (NULL,'Refusée','".$id."','".$notif['Prixitem']."','".$notif2['id_acheteur']."','".$id1."')");
    $sql3->execute(array());
    $bdd->query($sql);
    $bdd->query($sql2);
  }
  else{
    $sql3=$bdd->prepare("INSERT INTO `notif_acheteur`(`id_notifacheteur`, `Statut`, `Nomitem`, `Prixitem`, `id_acheteur`,`id_vendeur`) VALUES (NULL,'Refusée','".$id."','".$notif['Prixitem']."','".$notif2['id_acheteur']."','".$id1."')");
    $sql3->execute(array());
    $bdd->query($sql);
    
    $bdd->query($sql2);
  }

  header("location:notifications.php");


?>