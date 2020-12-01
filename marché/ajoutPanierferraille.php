<?php

  session_start();
  $bdd= new PDO('mysql:host=localhost;dbname=login','root','');

// Activation des erreurs PDO
  $id=$_GET['id'];
  $liste = $bdd->query("SELECT prix FROM items_achat WHERE item_nom= '".$id."' ");
  $hit = $liste->fetch();


  $id2 =$_SESSION['id_acheteur']; // Vérification si article déjà présent dans panier !

  $reqitem = $bdd->prepare("SELECT Nom,id_acheteur FROM panier WHERE id_acheteur = '".$id2."' AND Nom = '".$id."' ");
  $reqitem->execute();
  $euh1 = $reqitem->rowCount();


    if($euh1 == 0){

    	$sql = $bdd->prepare("INSERT INTO `panier` (`id_panier`, `Prix`, `Nom`, `id_acheteur`) VALUES (NULL, '".$hit['prix']."', '".$id."' , '".$_SESSION['id_acheteur']."')");
    	$sql->execute(array());
    	header('Location:ferraille.php?success=1');

    }else{

    	

    	header('Location:ferraille.php?error=1');
   	
    	
    }







 
?>