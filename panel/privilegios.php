<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="theme-color" content="#C62828" />
  <title>PI</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>

  <?php require('../includes/config.php'); 

    //if not logged in redirect to login page
    if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

    //define page title
    $title = 'PI';

    //include header template
    //require('layout/header.php');
?>


<?php
  if(isset($_POST['submit'])){

	  if (!isset($_POST['username'])) $error[] = "Por favor completá todos los campos.";
	  if (!isset($_POST['password'])) $error[] = "Por favor completá todos los campos.";

    if($_POST['username'] == NULL){ $error[] = "No ingresaste el usuario."; }
    if($_POST['password'] == NULL){ $error[] = "No ingresaste ID de tipo de usuario."; }
    else {
      $con  = mysqli_connect("localhost","root","12345","Biblioteca");
      $stmt = $db->prepare('SELECT Usuario FROM Clientes WHERE Usuario = :username');
			$stmt->execute(array(':username' => $_POST['username']));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

		  if(!empty($row['Usuario'])){
        $stmt = $db->prepare('UPDATE Clientes SET ID_Tipo_Usuario = :idtipo WHERE Usuario = :idusuario');
			  $stmt->execute(array(
        ':idusuario' => $_POST['username'],
        ':idtipo' => $_POST['password']
			  ));
		  }
      else {
        $error[] = 'Ese usuario no existe.';  
      }
    }
    

  }//end if submit

  //define page title
  $title = 'PI';

  ?>


  <!-- NAVEGACION -->
  <nav class="red darken-3" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="#" class="brand-logo white-text">Biblioteca</a>
      <?php
            if($user->is_logged_in()){
              echo '<ul class="right hide-on-med-and-down">';
              echo '  <li><a href="../logout.php" class="white-text">Finalizar sesión</a></li>';
              echo '</ul>';
              echo ' ';
              echo '<ul id="nav-mobile" class="sidenav">';
              echo '  <li><a href="../logout.php">Finalizar sesión</a></li>';
              echo '</ul>';
            }
            else {
              echo '<ul class="right hide-on-med-and-down">';
              echo '  <li><a href="../login.php" class="white-text">Ingresá</a></li>';
              echo '  <li><a href="../registrar.php" class="white-text">Registrate</a></li>';
              echo '</ul>';
              echo ' ';
              echo '<ul id="nav-mobile" class="sidenav">';
              echo '  <li><a href="../login.php">Ingresá</a></li>';
              echo '  <li><a href="../registrar.php">Registrate</a></li>';
              echo '</ul>';
            }
						
				?>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons white-text">menu</i></a>
    </div>
  </nav>

  <div class="container">
    <br />
    <div class="row">
    
    <h5 class="header light col s12 left">Lista de usuarios - Establecer privilegios.</h5><br>
            
      <table class="striped responsive-table truncate col s6">
      
        <thead>
          <tr>
              <th>ID Cliente</th>
              <th>ID Tipo Usuario</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Usuario</th>
          </tr>
        </thead>
      <?php
        if($user->is_logged_in()){
          
          $con  =mysqli_connect("localhost","root","12345","Biblioteca");
          $stmt = $db->prepare('SELECT * FROM Clientes');
					$stmt->execute(array(':username' => $_SESSION['username']));
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          $result = mysqli_query($con,"SELECT * FROM Clientes");

          

          while($row = mysqli_fetch_array($result)){
            $nombre = iconv('ISO-8859-1','UTF-8',$row['Nombre']);
            $apellido = iconv('ISO-8859-1','UTF-8',$row['Apellido']);
            echo '<tr>';
            echo '  <td>', htmlspecialchars($row['ID_Cliente'], ENT_QUOTES), '</td>';
            echo '  <td>', htmlspecialchars($row['ID_Tipo_Usuario'], ENT_QUOTES), '</td>';
            echo '  <td>', htmlspecialchars($nombre, ENT_QUOTES), '</td>';
            echo '  <td>', htmlspecialchars($apellido, ENT_NOQUOTES) , '</td>';
            echo '  <td>', htmlspecialchars($row['Usuario'], ENT_QUOTES), '</td>';
            echo '</tr>';
          }
        }
        else {
          echo '<!-- saraza -->';
          echo '<div class="row">';
          echo '  <div class="col s12 m6">';
          echo '    <a href="login.php">';
          echo '      <div class="icon-block">';
          echo '        <h2 class="center brown-text"><i class="material-icons">person</i></h2>';
          echo '        <h5 class="center">Iniciar sesión</h5>';
          echo '      </div>';
          echo '    </a>';
          echo '  </div>';
          echo ' ';
          echo '  <div class="col s12 m6">';
          echo '    <a href="registrar.php">';
          echo '      <div class="icon-block">';
          echo '        <h2 class="center brown-text"><i class="material-icons">person_add</i></h2>';
          echo '        <h5 class="center">Registrarse</h5>';
          echo '      </div>';
          echo '    </a>';
          echo '  </div>';
          echo '</div>';
          }
			?>

          </tbody>
        </table>

          <form class="col s6" role="form" method="post" action="">
              <div class="row">
                <div class="input-field col s6">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="icon_prefix username" type="text" class="validate black-text" name="username" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="1">
                  <label for="icon_prefix" class="black-text">Usuario</label>
                </div>
                <div class="input-field col s6">
                  <i class="material-icons prefix">vpn_key</i>
                  <input id="icon_telephone password" type="text" class="validate black-text" name="password" tabindex="2">
                  <label for="icon_telephone" class="black-text">ID Tipo Usuario</label>
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
        
        <!--<br><br>-->


        <h5 class="header col s12 light">- <a href="/panel">Ir al panel</a>.</h5>
        <h5 class="header col s12 light">- <a href="/">Inicio</a>.</h5>
      </div>

    </div>
  </div>

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
