<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="theme-color" content="#C62828" />
  <title>PI</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>

  <?php
  //include config
  require_once('includes/config.php');

  //check if already logged in move to home page
  if( $user->is_logged_in() ){ header('Location: index.php'); exit(); }

  //process login form if submitted
  if(isset($_POST['submit'])){

	  if (!isset($_POST['username'])) $error[] = "Por favor completá todos los campos.";
	  if (!isset($_POST['password'])) $error[] = "Por favor completá todos los campos.";

	  $username = $_POST['username'];
	  if ( $user->isValidUsername($username)){
		  if (!isset($_POST['password'])){
			  $error[] = 'Por favor ingresá tu contraseña';
		  }
		  $password = $_POST['password'];

		  if($user->login($username,$password)){
			  $_SESSION['username'] = $username;
			  header('Location: index.php');
			  exit;

		  } else {
			  $error[] = 'El usuario y la contraseña ingresada no son válidos.';
		  }
	  } else{
		$error[] = 'El usuario debe ser alfanumérico y debe contener más de 3 caracteres.';
	  }



  }//end if submit

  //define page title
  $title = 'PI';

  //include header template
  //require('layout/header.php'); 
  ?>

  <!-- NAVEGACION -->
  <nav class="red darken-3" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="/" class="brand-logo white-text">Biblioteca</a>
    </div>
  </nav>

  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>
        <h1 class="header center white-text">Ingresar</h1>
        <div class="row">
            <form class="col s12" role="form" method="post" action="">
              <div class="row">
                <div class="input-field col s6">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="icon_prefix username" type="text" class="validate white-text" name="username" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="1">
                  <label for="icon_prefix" class="white-text z-depth-3">Usuario</label>
                </div>
                <div class="input-field col s6">
                  <i class="material-icons prefix">vpn_key</i>
                  <input id="icon_telephone password" type="password" class="validate white-text" name="password" tabindex="2">
                  <label for="icon_telephone" class="white-text z-depth-3">Clave</label>
                </div>
                <div class="row col s6">
						      <a href='reset.php'>Olvidaste tu contraseña?</a>
					      </div>
              </div>

              <div class="row center">
                <?php
				        //check for any errors
				        if(isset($error)){
					        foreach($error as $error){
						        echo '<p class="error">'.$error.'</p>';
					        }
				        }

				        if(isset($_GET['action'])){

					        //check the action
					        switch ($_GET['action']) {
						        case 'active':
							        echo "<h2 class='green'>Tu cuenta ha sido activada, ahora podés ingresar al sistema.</h2>";
							      break;
					  	      case 'reset':
							        echo "<h2 class='green'>Te hemos enviado un enlace por correo electrónico para reiniciar tu contraseña.</h2>";
							      break;
						        case 'resetAccount':
							        echo "<h2 class='green'>La contraseña ha sido modificada, ahora podés ingresar al sistema.</h2>";
							      break;
					        }

				        }

				
				      ?>
                <input type="submit" name="submit" value="Ingresar" class="btn-large waves-effect waves-light red darken-3" tabindex="3">
                <!-- <a href="/" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Ingresar</a> -->
              </div>

            </form>
          </div>
        
        <br><br>

      </div>
    </div>
    <div class="parallax"><img src="/images/1.jpg" alt="Unsplashed background img 1"></div>
  </div>

  <!-- FIN DE LA PÁGINA -->
  <footer class="page-footer red darken-3">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Pie de página</h5>
          <p class="grey-text text-lighten-4">Fecha de finalización: 23/11/2018</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text"></h5>
          <ul>
            <li><a class="white-text" href="#!"></a></li>
            <li><a class="white-text" href="#!"></a></li>
            <li><a class="white-text" href="#!"></a></li>
            <li><a class="white-text" href="#!"></a></li>
          </ul>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text"></h5>
          <ul>
            <li><a class="white-text" href="#!"></a></li>
            <li><a class="white-text" href="#!"></a></li>
            <li><a class="white-text" href="#!"></a></li>
            <li><a class="white-text" href="#!"></a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      <center>
          Hecho con <i class="tiny material-icons">favorite</i> por <a class="brown-text text-lighten-3" href="http://www.instagram.com/pudinero">@pudinero</a> usando <a class="brown-text text-lighten-3" href="http://materializecss.com">Materialize</a>
      </center>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>
</html>
