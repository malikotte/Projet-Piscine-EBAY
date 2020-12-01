<?php

  session_start();
  $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
  $id=$_GET['id'];
   
  
  $maxprix =$bdd->query("SELECT MAX(Prixpropose) AS nummax FROM proposition_enchere WHERE nomItem = '".$id."' ");

  $max=$maxprix->fetch();


  $req=$bdd->query("SELECT * FROM proposition_enchere WHERE Prixpropose = '".$max['nummax']."' ");
  $requete=$req->fetch();
  echo $requete['Prixpropose'];

$requete['Prixprecedent'] = $requete['Prixprecedent'] +1;

	$sql3 = $bdd->prepare("INSERT INTO `notif_acheteur`(`id_notifacheteur`, `Statut`, `Nomitem`, `Prixitem`, `id_acheteur`, `id_vendeur`) VALUES (NULL,'Acceptée','".$id."','".$requete['Prixprecedent']."','".$requete['id_acheteur']."','".$requete['id_vendeur']."')");


	$sql3->execute(array());


  $sql = "DELETE FROM items_enchere WHERE item_nom = '$id'";
  $bdd->query($sql);
  header("location:offres.php");

?>