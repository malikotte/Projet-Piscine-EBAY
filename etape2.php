<?php
    session_start();
    $bdd= new PDO('mysql:host=localhost;dbname=login','root','');

    if (isset($_POST['adresseform']))
    {
        $adresse1 = htmlspecialchars($_POST['adresse']); // htmlspecialchars  - Convertit les caractères spéciaux en entités HTML
        $adresse2 = htmlspecialchars($_POST['adresse2']);
        $ville = htmlspecialchars($_POST['ville']);
        $cp = htmlspecialchars($_POST['cp']);
        $pays = htmlspecialchars($_POST['pays']);
        $tel = htmlspecialchars($_POST['tel']);
        if(!empty($_POST['adresse']) AND !empty($_POST['ville']) AND !empty($_POST['cp']) AND !empty($_POST['pays']) AND !empty($_POST['tel']))
        {
            
                        $reqtel = $bdd->prepare("SELECT * FROM adresse WHERE Tel = ?"); // Vérification du num Si déjà présente dans la BDD
                        $reqtel->execute(array($tel));
                        $telexiste= $reqtel->rowCount();
                        if($telexiste ==0)
                        {
                                $sess=$_SESSION['id_acheteur'];
                                $sql = $bdd->prepare("INSERT INTO `adresse` (`id_adresse`, `AdresseLigne1`, `AdresseLigne2`, `Ville`, `CP`, `Pays`, `Tel`, `id_acheteur`) VALUES (NULL, '$adresse1', '$adresse2', '$ville', '$cp', '$pays', '$tel', '$sess');");
                                $sql->execute(array(NULL,$adresse1,$adresse2,$ville,$cp,$pays,$tel,$sess));
                                header("Location:etape3.php?id=".$_SESSION['id_acheteur']);
                        }
                        else
                        {
                            $info = '<div class="alert alert-danger">Le numéro de téléphone est déjà utilisé !</div>';
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
                        <h6 class="modal-title" id="modal-title-default">2/3</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <h1 class="display-4"><center>Adresse de livraison</center></h1>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-address-book"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="adresse" placeholder="Adresse ligne 1" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-address-book"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="adresse2" placeholder="Adresse ligne 2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-building"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="ville" placeholder="Ville" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="cp" placeholder="Code postal" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="pays" placeholder="Pays" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="tel" placeholder="Téléphone" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block" name="adresseform" >Etape 3</button>
                            
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
