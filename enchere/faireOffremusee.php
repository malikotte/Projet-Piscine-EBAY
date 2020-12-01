<?php


session_start();
$bdd= new PDO('mysql:host=localhost;dbname=login','root',''); 


$id = $_GET['id'];

$prix = $_POST['prix'];

$id2 =$_SESSION['id_acheteur'];

$liste = $bdd->query("SELECT * FROM items_enchere WHERE itemcat = 'musee' ");
$produits = $liste->fetch();

$reqitem = $bdd->prepare("SELECT * FROM proposition_enchere WHERE nomItem = '".$id."' AND id_acheteur = '".$id2."' ");
$reqitem->execute();
$hit0 = $reqitem->fetch();

$reqprix = $bdd->prepare("SELECT * FROM proposition_enchere WHERE nomItem = '".$id."' ");
$reqprix->execute();
$hit1 = $reqprix->fetch();



$euh1 = $reqitem->rowCount(); // Compteur vérifiant si déjà existant dans la bdd





$euh2 = $reqprix->rowCount();
$maxprix = $bdd->query("SELECT MAX(Prixpropose) AS nummax FROM proposition_enchere WHERE nomItem = '".$produits['item_nom']."' ");
$max=$maxprix->fetch();

if($euh1 == 0){
	if($euh2 == 1){
		if($prix <= $max['nummax']){
	      header('Location:musee.php?error3=1');

		}else{
		$sql = $bdd->prepare("INSERT INTO `proposition_enchere` (`id_propenchere`, `Prixpropose`, `Prixprecedent`, `nomItem`, `id_acheteur`, `id_vendeur`) VALUES (NULL, '".$prix."', '".$max['nummax']."', '".$id."', '".$id2."', '".$produits['id_vendeur']."')");
		$sql->execute(array());
		header('Location:musee.php?success=1');

		}
	}else{
		if($prix > $produits['prix']){

			$sql = $bdd->prepare("INSERT INTO `proposition_enchere` (`id_propenchere`, `Prixpropose`, `Prixprecedent`, `nomItem`, `id_acheteur`, `id_vendeur`) VALUES (NULL, '".$prix."', '".$produits['prix']."', '".$id."', '".$id2."', '".$produits['id_vendeur']."')");
			$sql->execute(array());
			header('Location:musee.php?success=1');
		}
		header('Location:musee.php?error=1');
	}
}else{

	header('Location:musee.php?error1=1');
}


?>