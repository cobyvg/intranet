<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}

if($_SESSION['cambiar_clave']) {
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/clave.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/clave.php');
		exit();
	}
}


registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


if(!$tutor){$tutor = $_SESSION['profi'];}
?>
<? 
include("../../menu.php");
include("menu.php");
  
if (isset($_POST['id'])) {
	$id = $_POST['id'];
} 
elseif (isset($_GET['id'])) {
	$id = $_GET['id'];
} 
else
{
$id="";
}

if(stristr($_SESSION['cargo'],'1') == TRUE and strstr($tutor," ==> ")==TRUE){
$tr = explode(" ==> ",$tutor);
$tutor = $tr[0];
$unidad = $tr[1];
	}
else{
$SQL = "select unidad from FTUTORES where tutor = '$tutor'";
	$result = mysqli_query($db_con, $SQL);
	$row = mysqli_fetch_array($result);
	$unidad = $row[0];
}
?>
  <div align="center">
  <br><h3>Información completa de Actividad Extraescolar
  </h3><br />
  
  <?
 	$datos0 = "select * from calendario where id = '$id'";
	$datos1 = mysqli_query($db_con, $datos0);
	$datos = mysqli_fetch_array($datos1);
	$fecha0 = explode("-",$datos[6]);
	$fecha = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
	$registro = $datos[13];
	?>
<div>
</div>
<div>
<table align="center" class="table table-bordered table-striped" style="width:800px;">
	<tr>
		<th colspan="2">
		<h4 class="text-info"><? echo $datos[2];?></h4>
		</th>
	</tr>
	<tr>
		<th>Grupos</th>
		<td><? echo substr($datos[11],0,-1);?></td>
	</tr>
	<tr>
		<th>Descripción</th>
		<td><? echo $datos[3];?></td>
	</tr>
	<tr>
		<th>Departamento</th>
		<td><? echo $datos[9];?></td>
	</tr>
	<tr>
		<th>Profesores</th>
		<td><? echo $datos[10];?></td>
	</tr>
	<tr>
		<th>Horario</th>
		<td><? 
		if ($datos[5]=="00:00:00") {
			echo "Todo el día.";
		}
		else{
		echo $datos[5]." - ".$datos[7];
		}
		?>
		</td>
	</tr>
	<tr>
		<th>Fecha</th>
		<td><? echo $fecha;?></td>
	</tr>
	<tr>
		<th>Registro</th>
		<td><? echo $registro;?></td>
	</tr>
	<tr>
		<th>Autorizada</th>
		<td><?
		if ($datos[9]=="0") {
			echo "NO";
		}
		else{
			echo "SÍ";
		}	
		?></td>
	</tr>
		<tr>
		<th>Observaciones</th>
		<td><? echo $datos[16];?></td>
	</tr>
</table>
</div>
<br />
</div>
</body>
</html>