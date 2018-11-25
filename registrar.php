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

  <?php require('includes/config.php');

  //if logged in redirect to members page
  if( $user->is_logged_in() ){ header('Location: index.php'); exit(); }

  //if form has been submitted process it
  if(isset($_POST['submit'])){

  if (!isset($_POST['username'])) $error[] = "Por favor completá todos los campos.";
  if (!isset($_POST['nombre'])) $error[] = "Por favor completá todos los campos.";
  if (!isset($_POST['apellido'])) $error[] = "Por favor completá todos los campos.";
  if (!isset($_POST['direccion'])) $error[] = "Por favor completá todos los campos.";
  if (!isset($_POST['localidad'])) $error[] = "Por favor completá todos los campos.";
  if (!isset($_POST['phone'])) $error[] = "Por favor completá todos los campos.";
  if (!isset($_POST['email'])) $error[] = "Por favor completá todos los campos.";
  if (!isset($_POST['password'])) $error[] = "Por favor completá todos los campos.";

  $username = $_POST['username'];
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $direccion = $_POST['direccion'];
  $localidad = $_POST['localidad'];
  $phone = $_POST['phone'];

	//very basic validation
	if(!$user->isValidUsername($username)){
		$error[] = 'El usuario debe tener 3 caracteres alfanuméricos.';
	} else {
		$stmt = $db->prepare('SELECT Usuario FROM Clientes WHERE Usuario = :username');
		$stmt->execute(array(':username' => $username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Ese usuario ya está en uso.';
		}

	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'La contraseña debe tener más de 3 caracteres.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Por favor confirma tu contraseña.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Las contraseñas no coinciden.';
	}

  //email validation
	$email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Ingresá un email válido.';
	} else {
		$stmt = $db->prepare('SELECT Correo FROM Clientes WHERE Correo = :email');
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Ese email ya está en uso.';
		}

	}

	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO Clientes (ID_Tipo_Usuario, Nombre, Apellido, Direccion, Localidad, Telefono, Fecha_Alta, Correo, Usuario, Clave) VALUES (2, :nombre, :apellido, :direccion, :localidad, :phone, :date_today, :email, :username, :password)');
			$stmt->execute(array(
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':direccion' => $direccion,
        ':localidad' => $localidad,
        ':phone' => $phone,
        ':date_today' => date("Y-m-d H:i:s"),
        ':email' => $email,
				':username' => $username,
				':password' => $hashedpassword
			));
			$id = $db->lastInsertId('ID_Cliente');

			//send email
			$to = $_POST['email'];
			$subject = "Confirmación de registro.";
			$body = "<p>Gracias por registrarte en nuestra página.</p>
			<p>Para activar tu cuenta, sigue el siguiente enlace: <a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
			<p>Muchas gracias.</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to login page
			header('Location: login.php');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'PI';

//include header template
//require('layout/header.php');
?>

  <!-- NAVEGACION -->
  <nav class="red darken-3" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="/" class="brand-logo">Biblioteca</a>
    </div>
  </nav>

  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>
        <h1 class="header center white-text">Registrate</h1>
        <div class="row">
            <form class="col s12" role="form" method="post" action="">
              <div class="row">
                <div class="input-field col s6">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="icon_prefix username" type="text" class="validate white-text z-depth-3" name="username" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="1">
                  <label for="icon_prefix" class="white-text z-depth-3">Usuario</label>
                </div>
                <div class="input-field col s6">
                  <i class="material-icons prefix">vpn_key</i>
                  <input id="icon_telephone password" type="password" class="validate white-text" name="password" tabindex="2">
                  <label for="icon_telephone" class="white-text z-depth-3">Contraseña</label>
                </div>
                <div class="input-field col s6">
                  <i class="material-icons prefix">vpn_key</i>
                  <input id="icon_telephone passwordConfirm" type="password" class="validate white-text" name="passwordConfirm" tabindex="3">
                  <label for="icon_telephone" class="white-text z-depth-3">Confirmar contraseña</label>
                </div>
		            <div class="input-field col s12">
                  <i class="material-icons prefix">edit</i>
                  <input id="icon_prefix nombre" type="text" class="validate white-text" name="nombre" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['nombre'], ENT_QUOTES); } ?>" tabindex="4">
                  <label for="icon_prefix" class="white-text z-depth-3">Nombre</label>
                </div>
		            <div class="input-field col s12">
                  <i class="material-icons prefix">edit</i>
                  <input id="icon_prefix apellido" type="text" class="validate white-text" name="apellido" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['apellido'], ENT_QUOTES); } ?>" tabindex="5">
                  <label for="icon_prefix" class="white-text z-depth-3">Apellido</label>
                </div>
		            <div class="input-field col s12">
                  <i class="material-icons prefix">my_location</i>
                  <input id="icon_prefix direccion" type="text" class="validate white-text" name="direccion" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['direccion'], ENT_QUOTES); } ?>" tabindex="6">
                  <label for="icon_prefix" class="white-text z-depth-3">Direccion</label>
                </div>
		            <div class="input-field col s12">
                  <i class="material-icons prefix">location_on</i>
                  <input id="icon_prefix localidad" type="text" class="validate white-text" name="localidad" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['localidad'], ENT_QUOTES); } ?>" tabindex="7">
                  <label for="icon_prefix" class="white-text z-depth-3">Localidad</label>
                </div>
		            <div class="input-field col s12">
                  <i class="material-icons prefix">phone</i>
                  <input id="icon_prefix phone" type="tel" class="validate white-text" name="phone" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['phone'], ENT_QUOTES); } ?>" tabindex="8">
                  <label for="icon_prefix" class="white-text z-depth-3">Teléfono</label>
                </div>
                <div class="input-field col s12">
                  <i class="material-icons prefix">mail</i>
                  <input id="icon_prefix email" type="text" class="validate white-text" name="email" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['email'], ENT_QUOTES); } ?>" tabindex="9">
                  <label for="icon_prefix" class="white-text z-depth-3">Correo electrónico</label>
                </div>
              </div>
              <div class="row center">

                <?php
				        //check for any errors
				        if(isset($error)){
					        foreach($error as $error){
						        echo '<p class="red">'.$error.'</p>';
					        }
				        }

				        //if action is joined show sucess
				        if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					        echo "<h2 class='bg-success'>Te has registrado al sistema, verifica tu bandeja de correo electrónico para verificar tu cuenta.</h2>";
				        }
				        ?>
                
                <input type="submit" name="submit" value="Registrate" class="btn-large waves-effect waves-light red darken-3" tabindex="10">
                <!-- <a href="/" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Registrate</a> -->
              </div>
            </form>
          </div>
        
        <br><br>

      </div>
    </div>
    <div class="parallax"><img src="/images/4.jpg" alt="Unsplashed background img 1"></div>
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
