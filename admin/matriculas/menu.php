 <?
if (isset($_GET['curso'])) {$curso = $_GET['curso'];}elseif (isset($_POST['curso'])) {$curso = $_POST['curso'];}else{$curso="";}
if (isset($_GET['dni'])) {$dni = $_GET['dni'];}elseif (isset($_POST['dni'])) {$dni = $_POST['dni'];}else{$dni="";}
if (isset($_GET['enviar'])) {$enviar = $_GET['enviar'];}elseif (isset($_POST['enviar'])) {$enviar = $_POST['enviar'];}else{$enviar="";}
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['listados'])) {$listados = $_GET['listados'];}elseif (isset($_POST['listados'])) {$listados = $_POST['listados'];}else{$listados="";}
if (isset($_GET['listado_total'])) {$listado_total = $_GET['listado_total'];}elseif (isset($_POST['listado_total'])) {$listado_total = $_POST['listado_total'];}else{$listado_total="";}
if (isset($_GET['imprimir'])) {$imprimir = $_GET['imprimir'];}elseif (isset($_POST['imprimir'])) {$imprimir = $_POST['imprimir'];}else{$imprimir="";}
if (isset($_GET['cambios'])) {$cambios = $_GET['cambios'];}elseif (isset($_POST['cambios'])) {$cambios = $_POST['cambios'];}else{$cambios="";}
if (isset($_GET['sin_matricula'])) {$sin_matricula = $_GET['sin_matricula'];}elseif (isset($_POST['sin_matricula'])) {$sin_matricula = $_POST['sin_matricula'];}else{$sin_matricula="";}
//echo $imprimir;
 $activo1="";
if (strstr($_SERVER['REQUEST_URI'],'previsiones.php')==TRUE) {$activo1 = ' class="active" ';}
?>

 <div class="container">   
 <div class="no_imprimir">
          <ul class="nav nav-tabs">
      <li <? echo $activo1;?>><a href="previsiones.php"> Previsones de matrícula</a></li>

      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Consultar <b class="caret"></b></a>
        <ul class="dropdown-menu">
      <li><a href="consultas.php"> Consultar ESO</a></li>
      <li><a href="consultas_bach.php"> Consultar Bachillerato</a></li>
        </ul>
      </li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Matricular <b class="caret"></b></a>
        <ul class="dropdown-menu">
      <li><a href="index.php"> Matricular ESO</a></li>
      <li><a href="index_bach.php"> Matricular Bachillerato</a></li>
        </ul>
      </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Importar datos <b class="caret"></b></a>
        <ul class="dropdown-menu">
     <li><a href="index_primaria.php">Alumnos de Primaria</a></li>
        <li><a href="index_secundaria.php">Alumnos de Secundaria</a></li>
        </ul>
      </li>          
       
    </ul>
</div>
</div>