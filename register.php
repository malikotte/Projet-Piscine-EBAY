<?php
if(isset($_POST['submit']))
{
	$username = htmlspecialchars($_POST['username']); // htmlspecialchars  - Convertit les caractères spéciaux en entités HTML
	$password = htmlspecialchars($_POST['password']);
	$cpassword = htmlspecialchars($_POST['cpassword']);
	if(!empty($username)) AND !empty($password))
	{
		echo"o4k";
	}

}
?>