<?php
session_start();
$bdd= new PDO('mysql:host=localhost;dbname=login','root','');

$id=$_GET['id'];

$liste = $bdd->query("SELECT * FROM panier WHERE id_acheteur= '".$id."' ");
$compteur=$liste->rowCount();
if($compteur!=0){
	while($hit = $liste->fetch())
	{
		$sql1 = "DELETE FROM items_achat WHERE item_nom = '".$hit['Nom']."'";
		$bdd->query($sql1);
	}



	$sql = "DELETE FROM panier WHERE id_acheteur = '".$id."'";
	$bdd->query($sql);
	header("location:success.php");
}else{

	header('Location:monpanier.php?error=1');
}


?>