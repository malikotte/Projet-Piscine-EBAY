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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <h3><img style="position:relative;top:35px;left:25px" src="http://jimy.co/res/icon-success.jpg"><center style="color:#26cf36;">Commande confirmée !</center></h3><br><br>
                            <label>Nous vous remercions pour la commande passée ! N'hésitez pas à revenir plus souvent sur notre site :)</label>
                            
                    </div>
                    <div class="modal-footer">
                        <a href="produits.php"><button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Revenir au site</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        
        


</body>

</html>
