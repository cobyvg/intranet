<?
if (isset($_GET['profe'])) {$profe = $_GET['profe'];}elseif (isset($_POST['profe'])) {$profe = $_POST['profe'];}else{$profe="";}
if (isset($_GET['curso'])) {$curso = $_GET['curso'];}elseif (isset($_POST['curso'])) {$curso = $_POST['curso'];}else{$curso="";}
if (isset($_GET['curso1'])) {$curso1 = $_GET['curso1'];}elseif (isset($_POST['curso1'])) {$curso1 = $_POST['curso1'];}else{$curso1="";}
if (isset($_GET['asignatura'])) {$asignatura = $_GET['asignatura'];}elseif (isset($_POST['asignatura'])) {$asignatura = $_POST['asignatura'];}else{$asignatura="";}
if (isset($_GET['alumno'])) {$alumno = $_GET['alumno'];}elseif (isset($_POST['alumno'])) {$alumno = $_POST['alumno'];}else{$alumno="";}
if (isset($_GET['posicion'])) {$posicion = $_GET['posicion'];}elseif (isset($_POST['posicion'])) {$posicion = $_POST['posicion'];}else{$posicion="";}
if (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];}elseif (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];}else{$unidad="";}
if (isset($_GET['carrito'])) {$carrito = $_GET['carrito'];}elseif (isset($_POST['carrito'])) {$carrito = $_POST['carrito'];}else{$carrito="";}
if (isset($_GET['numeroserie'])) {$numeroserie = $_GET['numeroserie'];}elseif (isset($_POST['numeroserie'])) {$numeroserie = $_POST['numeroserie'];}else{$numeroserie="";}
if (isset($_GET['profesor'])) {$profesor = $_GET['profesor'];}elseif (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];}else{$profesor="";}
if (isset($_GET['fecha'])) {$fecha = $_GET['fecha'];}elseif (isset($_POST['fecha'])) {$fecha = $_POST['fecha'];}else{$fecha="";}
if (isset($_GET['hora'])) {$hora = $_GET['hora'];}elseif (isset($_POST['hora'])) {$hora = $_POST['hora'];}else{$hora="";}
if (isset($_GET['descripcion'])) {$descripcion = $_GET['descripcion'];}elseif (isset($_POST['descripcion'])) {$descripcion = $_POST['descripcion'];}else{$descripcion="";}
if (isset($_GET['estado'])) {$estado = $_GET['estado'];}elseif (isset($_POST['estado'])) {$estado = $_POST['estado'];}else{$estado="";}
if (isset($_GET['nincidencia'])) {$nincidencia = $_GET['nincidencia'];}elseif (isset($_POST['nincidencia'])) {$nincidencia = $_POST['nincidencia'];}else{$nincidencia="";}
if (isset($_GET['parte'])) {$parte = $_GET['parte'];}elseif (isset($_POST['parte'])) {$parte = $_POST['parte'];}else{$parte="";}
if (isset($_GET['borrar'])) {$borrar = $_GET['borrar'];}elseif (isset($_POST['borrar'])) {$borrar = $_POST['borrar'];}else{$borrar="";}

$activo1="";
$activo2="";
$activo3="";
$activo4="";
$activo5="";
$activo6="";
if (strstr($_SERVER['REQUEST_URI'],'protocolo.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'/intranet/TIC/documentos.php')==TRUE) {$activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'cpartes')==TRUE or strstr($_SERVER['REQUEST_URI'],'edparte')==TRUE or strstr($_SERVER['REQUEST_URI'],'clista')==TRUE) {$activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'usuarioprofesor')==TRUE) {$activo4 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'intro')==TRUE) {$activo5 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'informes')==TRUE) {$activo6 = ' class="active" ';}
?>
 <div class="container">   
          <ul class="nav nav-tabs">
<li <? echo $activo1;?>><a href="http://<? echo $dominio; ?>/intranet/TIC/protocolo.php">Protocolo de Uso</a></li>
<!--    
	<li <? echo $activo1;?>><a href="http://<? echo $dominio; ?>/intranet/admin/recursos/index.php">Recursos Educativos</a></li>
 -->    
 	<li <? echo $activo2;?>><a href="http://<? echo $dominio; ?>/intranet/TIC/documentos.php">Documentos</a></li>
    <li <? echo $activo3;?>><a href="http://<? echo $dominio; ?>/intranet/TIC/cpartes.php">Registrar Incidencias</a></li>
    <li <? echo $activo4;?>><a href="http://<? echo $dominio; ?>/intranet/TIC/usuarios/usuarioprofesor.php">Usuario Profesor</a></li>
	<li <? echo $activo5;?>><a href="http://<? echo $dominio; ?>/intranet/TIC/usuarios/intro.php">Usuario Alumno</a></li>
    <li <? echo $activo6;?>><a href="http://<? echo $dominio; ?>/intranet/reservas/informes.php">Estad&iacute;sticas</a></li>
  
    </ul>
        </div>
        </div>