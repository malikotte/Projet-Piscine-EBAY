<?php

  session_start();
  $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
  $id=$_GET['id'];
   $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

  $id1 = $_SESSION['id_vendeur'];

  $sql = "DELETE FROM notif_vendeur WHERE Nomitem = '$id'";

  $sql2 = "DELETE FROM items_negociation WHERE item_nom = '$id'";

  $liste = $bdd->query("SELECT Statut,Nomitem,Prixitem,id_acheteur FROM notif_vendeur WHERE id_vendeur = '".$_SESSION['id_vendeur']."' ");
  $notif = $liste->fetch();

  $liste2 = $bdd->query("SELECT * FROM proposition_offre WHERE nomOffre = '".$id."' ");
  $notif2 = $liste2->fetch();

  $sql3=$bdd->prepare("INSERT INTO `notif_acheteur`(`id_notifacheteur`, `Statut`, `Nomitem`, `Prixitem`, `id_acheteur`,`id_vendeur`) VALUES (NULL,'Acceptée','".$id."','".$notif['Prixitem']."','".$notif['id_acheteur']."','".$id1."')");
$sql3->execute(array());

  $bdd->query($sql);
  $bdd->query($sql2);


      header('Location: ' . $referer);

?>