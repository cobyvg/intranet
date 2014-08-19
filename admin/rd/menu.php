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
if (isset($_GET['q'])) {$expresion = $_GET['q'];}elseif (isset($_POST['q'])) {$expresion = $_POST['q'];}else{$expresion="";}

$activo1="";
$activo2="";
if (strstr($_SERVER['REQUEST_URI'],'add.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index_admin.php')==TRUE) {$activo2 = ' class="active" ';}
?>
 <div class="container">   
 	
 	<form method="get" action="buscar.php">
 	
 		<div class="pull-right col-lg-3">
 		   <div class="input-group">
 		     <input type="text" class="form-control input-sm" id="q" name="q" maxlength="60" value="<?php echo (isset($_GET['q'])) ? $_GET['q'] : '' ; ?>" placeholder="Buscar...">
 		     <span class="input-group-btn">
 		       <button class="btn btn-default btn-sm" type="submit"><span class="fa fa-search fa-lg"></span></button>
 		     </span>
 		   </div><!-- /input-group -->
 		 </div><!-- /.col-lg-3-->
 		 
 	</form>  
 
 
          <ul class="nav nav-tabs">
 <li <? echo $activo1;?>><a href="add.php">Nueva Acta / Lista de Actas</a></li>                 		
 <?
          if (strstr($_SESSION['cargo'],"1") == TRUE) {
          	?>
          	<li <? echo $activo2;?>><a href="index_admin.php">Todas las Actas</a></li>
          	<?
          }
          ?>
      
    </ul>
        </div>
        </div>
