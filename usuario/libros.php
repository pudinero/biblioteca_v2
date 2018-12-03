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


//if form has been submitted process it
if(isset($_POST['submit'])){

  $a = $_POST['art'];
  $value = $_POST['value'];
  $stock = $_POST['stock'];

  if($stock == NULL || $stock = 0){
    $error[] = 'No hay stock de este artículo.';
  }

  //if no errors have been created carry on
  if(!isset($error)){

    try {
      
      $stmt = $db->prepare('SELECT * FROM Clientes WHERE Usuario = :username');
      $stmt->execute(array(':username' => $_SESSION['username']));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      //insert into database with a prepared statement
      $stmt = $db->prepare('INSERT INTO Facturas (ID_Cliente, Fecha, Importe) VALUES (:idcliente, :date_today, :importe)');
      $stmt->execute(array(
        ':idcliente' => $row['ID_Cliente'],
        ':date_today' => date("Y-m-d H:i:s"),
        ':importe' => $value
      )); 

      $stmt = $db->prepare('SELECT * FROM Stock WHERE ID_Articulo = :a');
      $stmt->execute(array(':a' => $a));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $stmt = $db->prepare("UPDATE Stock SET Stock_Actual = (:s_actual), Stock_Minimo = (:s_minimo), Stock_Reponer = (:s_reponer) WHERE ID_Articulo = (:idarticulo)");
      $stmt->execute(array(
        ':s_actual' => ($row['Stock_Actual'] - 1),
        ':s_minimo' => $row['Stock_Minimo'],
        ':s_reponer' => $row['Stock_Reponer'],
        ':idarticulo' => $a
      ));
      
      //redirect
			header('Location: comprar.php');
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
      if($user->is_logged_in()){
        
        $con  =mysqli_connect("localhost","root","12345","Biblioteca");
        $stmt = $db->prepare('SELECT * FROM Articulos');
        $stmt->execute(array(':username' => $_SESSION['username']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $result = mysqli_query($con,"SELECT * FROM Articulos");

        while($row = mysqli_fetch_array($result)){
          
          $descripcion = iconv('ISO-8859-1','UTF-8',$row['Descripcion']);
          
          echo '<div class="col s12 m6">';

          echo '<div class="card purple lighten-5">';
          echo '  <div class="card-content black-text">';
          echo '    <span class="card-title">', $descripcion, '</span>';
          echo '    <p>Libro de ', $descripcion, '</p>';
          echo '  </div>';
          
          $a = $row['ID_Articulo'];

          echo '  <div class="card-action">';
          echo '    <form method="post" action="" role="form">';

          $stmt = $db->prepare('SELECT Stock_Actual FROM Stock WHERE ID_Articulo = :idarticulo');
          $stmt->execute(array(':idarticulo' => $row['ID_Articulo']));
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if($row['Stock_Actual'] == NULL || $row['Stock_Actual'] == 0){
            echo '    <a class="black-text">STOCK: NO HAY.</a>';
          }
          else {
            echo '    <a class="black-text">STOCK: ', $row['Stock_Actual'],' unidades</a>';
          }

          echo '      <input type="hidden" name="art" value="', $a, '">';
          echo '      <input type="hidden" name="stock" value="', $row['Stock_Actual'], '">';

          $stmt = $db->prepare('SELECT * FROM Precios WHERE ID_Articulo = :idarticulo');
          $stmt->execute(array(':idarticulo' => $a));
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if($row['Precio'] == NULL || $row['Precio'] == 0){
            echo '    <a class="black-text">PRECIO: --</a>';
          }
          else {
            echo '    <a class="black-text">PRECIO: $', $row['Precio'],'.-</a>';
          }

          echo '      <input type="hidden" name="value" value="', $row['Precio'], '">';

          $stmt = $db->prepare('SELECT Stock_Actual FROM Stock WHERE ID_Articulo = :idarticulo');
          $stmt->execute(array(':idarticulo' => $row['ID_Articulo']));
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if($row['Stock_Actual'] == NULL || $row['Stock_Actual'] == 0){
            echo '      <input type="submit" name="submit" class="waves-effect light-green darken-4 btn-small disabled" value="No disponible">';          
          }
          else {
            echo '      <input type="submit" name="submit" class="waves-effect light-green darken-4 btn-small" value="Comprar">';         
          }

          echo '    </form>';

          echo '  </div>'; 
          echo '</div>';
          echo '</div>';

        }
      }
      else {
        echo '<!-- saraza -->';
        echo '<div class="row">';
        echo '  <div class="col s12 m6">';
        echo '    <h5>No hay libros disponibles</h5>';
        echo '  </div>';
        echo '</div>';
        }
    ?>
    
          <?php
				        //check for any errors
				        if(isset($error)){
					        foreach($error as $error){
						        echo '<p class="header col s12 red">'.$error.'</p>';
					        }
				        }
          ?>

        <h5 class="header col s12 light">- <a href="/">Volver al inicio</a>.</h5>
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
