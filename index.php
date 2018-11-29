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

    //if not logged in redirect to login page
    //if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

    //define page title
    $title = 'PI';

    //include header template
    //require('layout/header.php');
?>

  <!-- NAVEGACION -->
  <nav class="red darken-3" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="#" class="brand-logo white-text">Biblioteca</a>
      <?php
            if($user->is_logged_in()){
              echo '<ul class="right hide-on-med-and-down">';
              echo '  <li><a href="logout.php" class="white-text">Finalizar sesión</a></li>';
              echo '</ul>';
              echo ' ';
              echo '<ul id="nav-mobile" class="sidenav">';
              echo '  <li><a href="logout.php">Finalizar sesión</a></li>';
              echo '</ul>';
            }
            else {
              echo '<ul class="right hide-on-med-and-down">';
              echo '  <li><a href="login.php" class="white-text">Ingresá</a></li>';
              echo '  <li><a href="registrar.php" class="white-text">Registrate</a></li>';
              echo '</ul>';
              echo ' ';
              echo '<ul id="nav-mobile" class="sidenav">';
              echo '  <li><a href="login.php">Ingresá</a></li>';
              echo '  <li><a href="registrar.php">Registrate</a></li>';
              echo '</ul>';
            }
						
				?>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons white-text">menu</i></a>
    </div>
  </nav>

  <div id="index-banner" class="parallax-container black">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>

        <?php
            if($user->is_logged_in()){
              $stmt = $db->prepare('SELECT * FROM Clientes WHERE Usuario = :username');
						  $stmt->execute(array(':username' => $_SESSION['username']));
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              echo '<h1 class="header center white-text">Hola, '; echo htmlspecialchars($row['Nombre'], ENT_QUOTES); echo '.</h1>';
              echo '<div class="row center">';
              echo '<h5 class="header col s12 light"><a href="logout.php">Hace clic acá para salir del sistema</a></h5>';
              echo '</div>';
            }
            else {
              echo '<h1 class="header center white-text">Bienvenido</h1>';
              echo '<div class="row center">';
              echo '<h5 class="header col s12 light">Ingresá al sistema para continuar</h5>';
              echo '</div>';
            }
						
				?>


        <br><br>

      </div>
    </div>
    <div class="parallax"><img src="/images/1.jpg" alt="Unsplashed background img 1"></div>
  </div>


  <div class="container">
    <br />
    <div class="section">
    
      <?php
        if($user->is_logged_in()){
          $stmt = $db->prepare('SELECT * FROM Clientes WHERE Usuario = :username');
					$stmt->execute(array(':username' => $_SESSION['username']));
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          echo "<h3 class=\"header rteal-text\">Hola, ", htmlspecialchars($row['Nombre'], ENT_QUOTES), " ", htmlspecialchars($row['Apellido'], ENT_QUOTES), ".</h3>";
          echo "   <div class=\"row\">";
          if ($row['ID_Tipo_Usuario'] == 1){
            echo "    <h5 class=\"header col s12 light\"> - <a href=\"/phpmyadmin\">Administrar base de datos (phpMyAdmin)</a>.</h5>";
            echo "    <h5 class=\"header col s12 light\"> - <a href=\"/panel\">Ir al panel</a>.</h5>";
            echo "    <h5 class=\"header col s12 light\"> - <a href=\"logout.php\">Finalizar sesión</a>.</h5>"; 
          }
          else {
            echo "    <h5 class=\"header col s12 light\"> - <a href=\"logout.php\">Finalizar sesión</a>.</h5>";
          }
          echo "      </div>";
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

      
      </div>

    </div>


    <!-- supo ser un buen menú de botones -->
    <!--
    <div class="row">
        <div class="col s12 m4">
            <a href="uwu.html" id="download-button" class="btn-large waves-effect waves-light deep-purple lighten-3">mandale cumbia</a>
        </div>
        <div class="col s12 m4">
            <a href="uwu.html" id="download-button" class="btn-large waves-effect waves-light deep-purple lighten-3">mandale cumbia 2</a>
          </div>
          <div class="col s12 m4">
              <a href="uwu.html" id="download-button" class="btn-large waves-effect waves-light deep-purple lighten-3">mandale cumbia tres</a>
            </div>
      </div>
    -->

  </div>


  <div class="parallax-container valign-wrapper black">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h5 class="header col s12 light">.</h5>
        </div>
      </div>
    </div>
    <div class="parallax"><img src="/images/4.jpg" alt="Unsplashed background img 2"></div>
  </div>

  <div class="container">
    <div class="section">

      <div class="row">
        <div class="col s12 center">
          <h3><i class="mdi-content-send brown-text"></i></h3>
          <h4>Lorem ipsum (porque no puede faltar)</h4>
          <p class="left-align light">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam scelerisque id nunc nec volutpat. Etiam pellentesque tristique arcu, non consequat magna fermentum ac. Cras ut ultricies eros. Maecenas eros justo, ullamcorper a sapien id, viverra ultrices eros. Morbi sem neque, posuere et pretium eget, bibendum sollicitudin lacus. Aliquam eleifend sollicitudin diam, eu mattis nisl maximus sed. Nulla imperdiet semper molestie. Morbi massa odio, condimentum sed ipsum ac, gravida ultrices erat. Nullam eget dignissim mauris, non tristique erat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>
        </div>
      </div>

    </div>
  </div>


  <div class="parallax-container valign-wrapper black">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h5 class="header col s12 light">.</h5>
        </div>
      </div>
    </div>
    <div class="parallax"><img src="/images/6.jpg" alt="Unsplashed background img 3"></div>
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
