<?php

  session_start();
  $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
  $id=$_GET['id'];
   

  $sql = "DELETE FROM panier WHERE Nom = '$id'";
  $bdd->query($sql);
  header("location:monpanier.php");


?>