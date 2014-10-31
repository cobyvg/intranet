<?
$activo1="";
$activo2="";
$activo3="";
$activo4="";
$activo5="";
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'infotut.php')==TRUE) {$activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'buscar.php')==TRUE){ $activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index_buscar.php')==TRUE){ $activo4 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'control.php')==TRUE){ $activo5 = ' class="active" ';}

if (isset($_GET['profesor'])) {
	$profesor = $_GET['profesor'];
}
elseif (isset($_POST['profesor'])) {
	$profesor = $_POST['profesor'];
}
else {
	$profesor = $_SESSION['profi'];
}
if (isset($_GET['dia'])) {
	$dia = $_GET['dia'];
}
elseif (isset($_POST['dia'])) {
	$dia = $_POST['dia'];
}

if (isset($_GET['hora'])) {
	$hora = $_GET['hora'];
}
elseif (isset($_POST['hora'])) {
	$hora = $_POST['hora'];
}

if (isset($_GET['curso'])) {
	$curso = $_GET['curso'];
}
elseif (isset($_POST['curso'])) {
	$curso = $_POST['curso'];
}

if (isset($_GET['asignatura'])) {
	$asignatura = $_GET['asignatura'];
}
elseif (isset($_POST['asignatura'])) {
	$asignatura = $_POST['asignatura'];
}

?>
<div class="container hidden-print">
<div class="tabbable">
<ul class="nav nav-tabs">
	<li <? echo $activo1;?>><a href="http://<? echo $dominio;?>/intranet/cuaderno.php?menu_cuaderno=1&profesor=<? echo $_SESSION['profi'];?>&dia=<? echo $dia;?>&hora=<? echo $hora;?>&curso=<? echo $curso;?>&asignatura=<? echo $asignatura;?>">Cuaderno de notas</a></li>
	
	<li <? echo $activo2;?>><a href="http://<? echo $dominio;?>/intranet/faltas/index.php?menu_cuaderno=1&profesor=<? echo $_SESSION['profi'];?>&dia=<? echo $dia;?>&hora=<? echo $hora;?>&curso=<? echo $curso;?>&asignatura=<? echo $asignatura;?>">Faltas de asistencia</a></li>

	<li <? echo $activo3;?>><a href="http://<? echo $dominio;?>/intranet/admin/calendario/diario/index_cal.php?menu_cuaderno=1&profesor=<? echo $_SESSION['profi'];?>&dia=<? echo $dia;?>&hora=<? echo $hora;?>&curso=<? echo $curso;?>&asignatura=<? echo $asignatura;?>">Actividades del Grupo</a></li>

	<li <? echo $activo4;?>><a href="#?menu_cuaderno=1&profesor=<? echo $_SESSION['profi'];?>&dia=<? echo $dia;?>&hora=<? echo $hora;?>&curso=<? echo $curso;?>&asignatura=<? echo $asignatura;?>">Diario del Grupo</a></li>

</ul>
</div>
</div>
