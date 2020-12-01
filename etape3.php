<?php
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');
    if (isset($_POST['cbform']))
    {
        $type = htmlspecialchars($_POST['type']); // htmlspecialchars  - Convertit les caractères spéciaux en entités HTML
        $numcarte = htmlspecialchars($_POST['numcarte']);
        $nom = htmlspecialchars($_POST['nom']);
        $dateexp = htmlspecialchars($_POST['dateexp']);
        $cvv = htmlspecialchars($_POST['cvv']);
        if(!empty($_POST['type']) AND !empty($_POST['numcarte']) AND !empty($_POST['nom']) AND !empty($_POST['dateexp']) AND !empty($_POST['cvv']))
        {
            
                        $reqnumcarte = $bdd->prepare("SELECT * FROM carte_bancaire WHERE numero_carte = ?"); // Vérification de l'adresse mail Si déjà présente dans la BDD
                        $reqnumcarte->execute(array($numcarte));
                        $numexiste= $reqnumcarte->rowCount();
                        if($numexiste ==0)
                        {

                                $sess=$_SESSION['id_acheteur'];
                                $sql = $bdd->prepare("INSERT INTO `carte_bancaire` (`type_carte`, `numero_carte`, `nom_carte`, `date_expiration`, `cvv`, `id_acheteur`) VALUES ('$type', '$numcarte', '$nom', '$dateexp', '$cvv', '$sess');");
                                $sql->execute(array($type,$numcarte,$nom,$dateexp,$cvv,$sess));
                                header('location:index.php');
                        }
                        else
                        {
                            $info = '<div class="alert alert-danger">La carte bleue est déjà utilisée !</div>';
                            echo $info; 
                        }            
        }
        else
        {
            $info = '<div class="alert alert-danger">Une erreur est survenue</div>';
            echo $info;
        }
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Themesberg">
    <title>Evo</title>
    <!-- Favicon -->
    <link rel="icon" href="img/favicon-16x16.png" />
    <!-- Pixel CSS -->
    <link type="text/css" href="./css/pixel.css?v=1.0.1" rel="stylesheet">
    <!-- Mon CSS -->
    <link type="text/css" href="./css/etape2.css" rel="stylesheet">
    <link type="text/css" href="./css/animate.css" rel="stylesheet">
    <!-- Core -->
    <script src="./vendor/jquery/jquery.min.js"></script>
    <script src="./vendor/popper/popper.min.js"></script>
    <script src="./vendor/bootstrap/bootstrap.min.js"></script>
    <script src="./vendor/headroom/headroom.min.js"></script>

    <!-- Vendor JS -->
    <script src="./vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="./vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="./vendor/smooth-scroll/smooth-scroll.polyfills.min.js"></script>
    <!-- pixel JS -->
    <script src="./js/pixel.js"></script>
    <style>
        body{
            background: #f1f1f1;  /* fallback for old browsers */
        }

    </style>
</head>
<body>
    
<div class="content">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">3/3</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <h1 class="display-4"><center>Informations bancaires</center></h1>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                    </div>
                                    <select name="type" class="form-control">
                                        <option value="Visa" name="Visa">Visa</option> 
                                        <option value="American" name="American">American</option> 
                                        <option value="Mastercard" name="Mastercard">Mastercard</option>
                                        <option value="Paypal" name="Paypal">Paypal</option> 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="numcarte" placeholder="Numéro de la carte">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-address-book"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="nom" placeholder="Titulaire de la carte" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                                    </div>
                                    <input type="date" class="form-control" name="dateexp" placeholder="Date d'expiration" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="cvv" placeholder="CVV" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block" name="cbform" ><a data-toggle="modal" data-target="#modal-adresse">Etape 3</a></button>
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="index.php"><button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">J'ai déjà un compte !</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        
        


</body>

</html>
