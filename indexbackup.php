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
    <link type="text/css" href="./css/styles.css" rel="stylesheet">
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
    <script>
    $(document).ready(function(){
       $("#show").click(function(){
         $("p").show();
         $("#show").hide();
        });
    });
    </script>
    
</head>
<body>
	<div class="container">
		<div class="loginform mr-auto ml-auto animated fadeIn">
            <img class="fit-picture" src="img/logo.png" style="width: 55px;height: 75px;position: relative;left:45%;" alt="Grapefruit slice atop a pile of other slices">
                <form method="POST" action="login.php">
                    <h1 class="display-4 typewriter">Evo | Ece Paris</h1>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-address-book"></i></span>
                            </div>
                            <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Se connecter</button>
                </form>
                <div class="texte  mt-2 text-center">
                    <small class="mdp"> Mot de passe oublié ?</small>
                    <a data-toggle="modal" data-target="#modal-default"><small>· S'inscrire sur Evo</small></a>
                </div>
            <div class="pro mt-6">
                <div class="progress-wrapper">
                    <div class="progress-info">
                        <div class="progress-label">
                            <span class="text-primary">Développement du site</span>
                        </div>
                        <div class="progress-percentage">
                            <span>5%</span>
                        </div>
                    </div>
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                </div>
            </div>
	    </div>
        <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">Nous rejoindre</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="register.php">
                            <h1 class="display-4">Créer votre compte</h1>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-address-book"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    </div>
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-venus-mars"></i></span>
                                    </div>
                                    <select class="form-control">
                                        <option value="Masculin">Masculin</option> 
                                        <option value="Féminin">Féminin</option>     
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="cpassword" placeholder="Confirmez votre mot de passe" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit">S'inscrire</button>
                        </form> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">J'ai déjà un compte !</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
