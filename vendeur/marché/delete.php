<?php

  session_start();
  $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
  $id=$_GET['id'];
   

  $sql = "DELETE FROM items_achat WHERE item_nom = '$id'";
  $sql2 = "DELETE FROM panier WHERE Nom = '".$id."'";
  $bdd->query($sql2);
  $bdd->query($sql);
  header("location:marche.php");


?>