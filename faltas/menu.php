<?
$activo1="";
$activo3="";
$activo4="";
$activo5="";
$activo6="";
$activo7="";
if (strstr($_SERVER['REQUEST_URI'],'importar')==TRUE) {$activo4 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'seneca/index.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'poner')==TRUE) {$activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'justificar')==TRUE) {$activo5 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'intranet/faltas/index.php')==TRUE) {$activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'admin/faltas/index.php')==TRUE) {$activo6 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'absentismo')==TRUE) {$activo7 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index_admin.php')==TRUE) {$activo2 = ' class="active" ';}

?>
<div class="container">
<ul class="nav nav-tabs">
<?
if(stristr($_SESSION['cargo'],'3') == TRUE or stristr($_SESSION['cargo'],'1') == TRUE)
{
	?>
	<li <? echo $activo3;?>><a
		href="http://<? echo $dominio; ?>/intranet/faltas/poner2/index.php">
	Poner</a></li>
	<?
} else {
	?>
	<li <? echo $activo3;?>><a
		href="http://<? echo $dominio; ?>/intranet/faltas/poner/index.php">
	Poner</a></li>
	<?
}
?>

<?
if(stristr($_SESSION['cargo'],'2') == TRUE or stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'3') == TRUE)
{
	?>
	<li <? echo $activo5;?>><a
		href="http://<? echo $dominio; ?>/intranet/faltas/justificar/index.php">
	Justificar</a></li>
	<?
}
?>
	<li <? echo $activo6;?>><a
		href="http://<? echo $dominio; ?>/intranet/admin/faltas/index.php">
	Consultar</a></li>
	<?
	if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'3') == TRUE)
	{
		?>
	<li <? echo $activo7;?>><a
		href="http://<? echo $dominio; ?>/intranet/faltas/absentismo/index.php">
	Alumnos Absentistas</a></li>
	<?
	}
	?>
	<?
	if(stristr($_SESSION['cargo'],'1') == TRUE)
	{
		?>

	<li <? echo $activo1;?>><a href="http://<? echo $dominio; ?>/intranet/faltas/seneca/index.php">
	Subir Faltas a S&eacute;neca</a></li>
	<li <? echo $activo4;?>><a
		href="http://<? echo $dominio; ?>/intranet/faltas/seneca/importarSeneca.php">Descargar
	Faltas de Séneca</a></li>
	<?
	}
	?>

</ul>
</div>
</div>

	<?
	// Comprobación de Festivos
	$festivos="";
	if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'3') == TRUE)
	{
		$repe0=mysqli_query($db_con, "select fecha from festivos");
		if (mysqli_num_rows($repe0)<'1') {
			$festivos='actualizar';
		}

		$repe=mysqli_query($db_con, "select fecha from festivos where date(fecha) < date('$inicio_curso')");
		if (mysqli_num_rows($repe) > '0') {
			$festivos='actualizar';
		}
	}

	if($festivos == 'actualizar'){
		echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;text-align:left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>Atenci&oacute;n:</legend>
No se han importado los <strong>Días festivos </strong>de este Curso Escolar en la Base de datos.</span> Hazlo antes de comenzar a utilizar la aplicación de Faltas de asistencia, o tendrás problemas para exportar posteriormente los datos a Séneca. Sigue el enlace del menú ( <strong><em>Importar Días festivos</em></strong> ) para proceder a la importación de las fechas.
		</div></div>';	
	}
	?>