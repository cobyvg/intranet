<?
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['edicion'])) {$edicion = $_GET['edicion'];}elseif (isset($_POST['edicion'])) {$edicion = $_POST['edicion'];}else{$edicion="";}
if (isset($_GET['submit'])) {$submit = $_GET['submit'];}elseif (isset($_POST['submit'])) {$submit = $_POST['submit'];}else{$submit="";}
if (isset($_GET['borrar'])) {$borrar = $_GET['borrar'];}elseif (isset($_POST['borrar'])) {$borrar = $_POST['borrar'];}else{$borrar="";}
if (isset($_GET['departamento'])) {$departamento = $_GET['departamento'];}elseif (isset($_POST['departamento'])) {$departamento = $_POST['departamento'];}else{$departamento="";}
if (isset($_GET['contenido'])) {$contenido = $_GET['contenido'];}elseif (isset($_POST['contenido'])) {$contenido = $_POST['contenido'];}else{$contenido="";}
if (isset($_GET['fecha'])) {$fecha = $_GET['fecha'];}elseif (isset($_POST['fecha'])) {$fecha = $_POST['fecha'];}else{$fecha="";}
if (isset($_GET['actualiza'])) {$actualiza = $_GET['actualiza'];}elseif (isset($_POST['actualiza'])) {$actualiza = $_POST['actualiza'];}else{$actualiza="";}
if (isset($_GET['numero'])) {$numero = $_GET['numero'];}elseif (isset($_POST['numero'])) {$numero = $_POST['numero'];}else{$numero="";}
if (isset($_GET['jefedep'])) {$jefedep = $_GET['jefedep'];}elseif (isset($_POST['jefedep'])) {$jefedep = $_POST['jefedep'];}else{$jefedep="";}
if (isset($_GET['pag'])) {$pag = $_GET['pag'];}elseif (isset($_POST['pag'])) {$pag = $_POST['pag'];}else{$pag="";}
if (isset($_GET['expresion'])) {$expresion = $_GET['expresion'];}elseif (isset($_POST['expresion'])) {$expresion = $_POST['expresion'];}else{$expresion="";}

$activo1="";
$activo2="";
if (strstr($_SERVER['REQUEST_URI'],'add.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index_admin.php')==TRUE) {$activo2 = ' class="active" ';}
?>
 <div class="container">   
          <ul class="nav nav-tabs">
 <li <? echo $activo1;?>><a href="add.php">Nueva Acta</a></li>                 		
 <?
          if (strstr($_SESSION['cargo'],"1") == TRUE) {
          	?>
          	<li <? echo $activo2;?>><a href="index_admin.php">Todas las Actas</a></li>
          	<?
          }
          ?>
<form method="post" action="buscar.php" class="form-search" style="margin-top:4px;">
      	<div class="input-append pull-right">
    <input type="search" class="search-query" placeholder="Buscar en las Actas" name="expresion" onClick="this.value=''">   
    <button type="submit" class="btn btn-success">Buscar</button>
  		</div>    
</form>          
    </ul>
        </div>
        </div>
