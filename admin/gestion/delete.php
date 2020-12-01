<?php

  session_start();
  $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
  $id=$_GET['id'];
   

  $sql = "DELETE FROM vendeurs WHERE id_vendeur = '$id'";
  $sql1 = "DELETE FROM items_achat WHERE id_vendeur = '$id'";
  $sql2 = "DELETE FROM items_negociation WHERE id_vendeur = '$id'";
  $sql3 = "DELETE FROM items_enchere WHERE id_vendeur = '$id'";
  $sql4 = "DELETE FROM panier WHERE Nom = '$id'";
  $bdd->query($sql);
  $bdd->query($sql1);
  $bdd->query($sql2);
  $bdd->query($sql3);
   $bdd->query($sql4);
  header("location:gestion.php");


?>