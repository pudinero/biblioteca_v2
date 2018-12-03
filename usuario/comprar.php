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

    $a = $_POST['art'];

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
    
    <?php

    /*
    if($a == 1){
      echo '<h5>Tocaste el 1 - ', $a, '</h5>';
    }
    else{
      echo '<h5>Tocaste otro que no era el 1 - ', $a, '</h5>';
    }
    */

    
      if($user->is_logged_in()){
        
        $con  =mysqli_connect("localhost","root","","Biblioteca");
        $stmt = $db->prepare('SELECT * FROM Articulos WHERE ID_Articulo = :a');
        $stmt->execute(array(':a' => $a));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $descripcion = iconv('ISO-8859-1','UTF-8',$row['Descripcion']);

        echo '<h5>Detalles del artículo: </h5>';
        echo '<h6>Nombre: ', $row['Descripcion'],'</h6>';
        
        $stmt = $db->prepare('SELECT * FROM Precios WHERE ID_Articulo = :idarticulo');
        $stmt->execute(array(':idarticulo' => $row['ID_Articulo']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        echo '<h6>Precio: $', $row['Precio'],'</h6>';

        $stmt = $db->prepare('SELECT Stock_Actual FROM Stock WHERE ID_Articulo = :idarticulo');
        $stmt->execute(array(':idarticulo' => $row['ID_Articulo']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row['Stock_Actual'] == NULL || $row['Stock_Actual'] == 0){
          echo '<h6>Stock: No hay.</h6>';
        }
        else {
          echo '<h6>Stock: ', $row['Stock_Actual'],' unidades.</h6>';
        }
        
      }
      else {
        echo '<!-- saraza -->';
        echo '<div class="row">';
        echo '  <div class="col s12 m6">';
        echo '    <h5 class="red">ERROR: ID DE ARTÍCULO INVÁLIDO.</h5>';
        echo '  </div>';
        echo '</div>';
        }
        
    ?>

        <h5 class="header col s12 light">- <a href="/usuario/libros.php">Ver más libros</a>.</h5>
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