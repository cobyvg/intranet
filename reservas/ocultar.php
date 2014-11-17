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
	  <h2>Reservas <small> Crear y Ocultar Aulas / Dependencias del centro</small></h2>
	</div>
<div class="row">
<?
if (isset($_POST['nueva'])) {
mysqli_query($db_con,"
CREATE TABLE IF NOT EXISTS $db_reservas.nuevas (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `abrev` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `nombre` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `texto` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

	$num = count($_POST);
	if ($num>1) {
		$abrev_nueva = $_POST['abrev_nueva'];
		$nombre_nueva = $_POST['nombre_nueva'];
		$texto = $_POST['texto'];
		if ($_POST['nueva']=="Crear nueva Aula / Dependencia") {
				mysqli_query($db_con,"insert into $db_reservas.nuevas values ('','$abrev_nueva','$nombre_nueva','$texto')");
				if (mysqli_affected_rows($db_con)>0) {
					$msg = "Los datos se han registrado correctamente. Las aulas / dependencias creadas aparecerán en el sistema de reservas a partir de ahora.";
				}			}			
		
		elseif ($_POST['nueva']=="Actualizar datos del Aula / Dependencia") {
				mysqli_query($db_con,"update $db_reservas.nuevas set abrev='$abrev_nueva', nombre='$nombre_nueva', texto='$texto' where id = '".$_POST['id']."'");
				if (mysqli_affected_rows($db_con)>0) {
					$msg = "Los datos se han actualizado correctamente. Las aulas / dependencias actualizadas aparecerán en el sistema de reservas con los nuevos datos.";
				}
		}			
		}		
?>
		<br>
		<div class="alert alert-success">
			<p><? echo $msg;?><p>
		</div>
<?		
	}

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
			<p>Los datos se han registrado correctamente. Las aulas y dependencias seleccionadas dejarán de aparecer en el sistema de reservas a partir de ahora.<P>
		</div>
<?		
	}
}

if (isset($_GET['eliminar'])) {
	$id = $_GET['id'];
				mysqli_query($db_con,"delete from $db_reservas.nuevas where id = '$id'");
				if (mysqli_affected_rows($db_con)>0) {
					$msg = "El aula/dependencia ha sido eliminada del sistema de reservas.";
		}
?>
		<br>
		<div class="alert alert-success">
			<p><? echo $msg;?><P>
		</div>
<?				
}

if (isset($_GET['editar'])) {
	$id = $_GET['id'];
	$ya = mysqli_query($db_con,"select * from $db_reservas.nuevas where id = '$id'");
			if (mysqli_num_rows($ya)>0) {
				$ya_id = mysqli_fetch_array($ya);
				$abrev_nueva = $ya_id[1];
				$nombre_nueva =  $ya_id[2];
				$texto = $ya_id[3];
			}
}
?>
<div class="col-sm-5 col-sm-offset-1">
<h3>Ocultar Aulas / Dependencias</h3>
<p class="help-block text-justify well">
A través de esta página puedes seleccionar los espacios del centro que quedan fuera del sistema de reservas.
Marca la casilla de aquellas dependencias que quieres ocultar y envía los datos. A partir de ese momento
las dependencias elegidas quedarán ocultas en la selección de aulas del sistema de reservas. 
</p>
<form action="ocultar.php" method="post">
<table class="table table-striped">
<?
echo "<thead><th colspan=3>Aulas en el Horario</th></thead>";
$aulas = mysqli_query($db_con,"select distinct a_aula, n_aula from horw where n_aula not like 'GU%' and a_aula not like ''");
while ($aula = mysqli_fetch_array($aulas)) {
	$check="";
	$abrev0 = $aula[0];
	$nombre0 = $aula[1];
	$ya = mysqli_query($db_con,"select * from $db_reservas.ocultas where aula = '$abrev0'");
	if (mysqli_num_rows($ya)>0) {
		$check = " checked";
	}
	
	echo "<tr>";
	echo "<td><input type='checkbox' name='$abrev0' value='$abrev0' $check/></td>";
	echo "<td>$abrev0</td><td>$nombre0</td>";
	echo "</tr>";
}
?>
<?
$aulas_nueva = mysqli_query($db_con,"select distinct abrev, nombre, id from $db_reservas.nuevas order by abrev");
echo "<thead><th colspan=3>Aulas fuera del Horario</th></thead>";
while ($aula_nueva = mysqli_fetch_array($aulas_nueva)) {
	$check="";
	$abrev_nueva0 = $aula_nueva[0];
	$nombre_nueva0 = $aula_nueva[1];
	$id_nueva0 = $aula_nueva[2];
	$ya_nueva = mysqli_query($db_con,"select * from $db_reservas.ocultas where aula = '$abrev_nueva0'");
	if (mysqli_num_rows($ya_nueva)>0) {
		$check = " checked";
	}
	
	echo "<tr>";
	echo "<td><input type='checkbox' name='$abrev_nueva0' value='$abrev_nueva0' $check/>";
	echo "</td>";	
	echo "<td>$abrev_nueva0</td><td>$nombre_nueva0 <span class='pull-right'><a href='ocultar.php?editar=1&id=$id_nueva0'><span class='fa fa-edit fa-fw fa-lg' data-bs='tooltip' title='Editar'></span></a>
	<a href='ocultar.php?id= $id_nueva0&eliminar=1' data-bb='confirm-delete'><span class='fa fa-trash-o fa-fw fa-lg' data-bs='tooltip' title='Eliminar'></span></a></td>";
	echo "</tr>";
}
?>
<tr><td colspan="3"><center><input type="submit" name="enviar" value="Enviar datos" class="btn btn-default"></center></td></tr>
</tbody>
</table>
</form>
</div>
<div class="col-sm-5">
<h3>Crear y editar Aula / Dependencia</h3>
<p class="help-block text-justify well">
Si el Centro no ha importado el Horario en la Base de datos, o bien si quieres poder reservar una dependencia o aula que no aparece en el Horario, es posible crear aulas para introducirlas en el sistema de reservas. Crea las aulas rellenando los datos en el formulario para que la misma aparezca en la lista de reservas.
</p>
<form action="ocultar.php" method="post">
<div class="form-group">
<label>Abreviatura</label>
<input class="form-control" type = "text" maxlength="5" name="abrev_nueva" value="<? echo $abrev_nueva;?>" placeholder="5 caracteres como máximo">
</div>
<div class="form-group"> 
<label>Nombre del Aula</label>
<input class="form-control" type = "text" name="nombre_nueva" value="<? echo $nombre_nueva;?>">
</div>
<div class="form-group">
<label>Observaciones</label>
<textarea class="form-control" name="texto"><? echo $texto;?></textarea>
</div>
<? 
if ($id) {
?>
<input type="hidden" name="id" value="<? echo $id;?>">
<input class="btn btn-default" type="submit" name="nueva" value="Actualizar datos del Aula / Dependencia" />
<?	
}
else{
?>
<input class="btn btn-default" type="submit" name="nueva" value="Crear nueva Aula / Dependencia" />
<?
}
?>
</form>


</div>
</div>
</div>
<? include("../pie.php");?>  

</body>
</html>









