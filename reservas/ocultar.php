<?php
session_start();
include("../config.php");
include_once('../config/version.php');
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

include("../menu.php");
include("menu.php");
?>

<div class="container">

	<div class="page-header">
	  <h2>Reservas <small> Ocultar Aulas / Dependencias del centro</small></h2>
	</div>
<div class="row">
<?
if (isset($_POST['enviar'])) {

mysqli_query($db_con,"
CREATE TABLE IF NOT EXISTS $db_reservas.ocultas (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `aula` varchar(48) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

	$num = count($_POST);
	if ($num>1) {
		mysqli_query($db_con,"truncate table $db_reservas.ocultas");
		foreach ($_POST as $valor){
			if ($valor!=="Enviar datos") {
			mysqli_query($db_con,"insert into $db_reservas.ocultas values ('','$valor')");
		}
	}	
?>
		<br>
		<div class="alert alert-success">
			<p>Los datos se han regsitrado correctamente. Las aulas y dependencias seleccionadas dejarán de aparecer en el sistema de reservas a partir de ahora.<P>
		</div>
<?		
	}
}
?>
<div class="col-sm-6 col-sm-offset-3">
<p class="help-block well">
A través de esta página puedes seleccionar los espacios del centro que quedan fuera del sistema de resrevas.
Marca la casilla de aquellas dependencias que quieres ocultar y envía los datos. A partir de ese momento
las dependencias elegidas quedarán ocultas en la selección de aulas del sistema de reservas. 
</p>
<form action="ocultar.php" method="post">
<table class="table table-striped">
<thead><th colspan="3">Dependencias del Centro</th></thead>
<tbody>
<?
$aulas = mysqli_query($db_con,"select distinct a_aula, n_aula from horw where n_aula not like 'GU%' and a_aula not like ''");
while ($aula = mysqli_fetch_array($aulas)) {
	$check="";
	$abrev = $aula[0];
	$nombre = $aula[1];
	$ya = mysqli_query($db_con,"select * from $db_reservas.ocultas where aula = '$abrev'");
	if (mysqli_num_rows($ya)>0) {
		$check = " checked";
	}
	
	echo "<tr>";
	echo "<td><input type='checkbox' name='$abrev' value='$abrev' $check/></td>";
	echo "<td>$abrev</td><td>$nombre</td>";
	echo "</tr>";
}
?>
<tr><td colspan="3"><center><input type="submit" name="enviar" value="Enviar datos" class="btn btn-default"></center></td></tr>
</tbody>
</table>
</form>
</div>
</div>
</div>
<? include("../pie.php");?>  

</body>
</html>