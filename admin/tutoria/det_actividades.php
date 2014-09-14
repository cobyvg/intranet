<?
session_start();
include("../../config.php");
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
  <h3>Información completa de Actividad Extraescolar
  </h3><br />
  
  <?
 

  $datos0 = "select * from actividades where id = '$id'";
  //echo $datos0;
  $datos1 = mysqli_query($db_con, $datos0);
  $datos = mysqli_fetch_array($datos1);
  $fecha0 = explode("-",$datos[7]);
  $fecha = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
  $fecha1 = explode("-",$datos[8]);
  $registro = "$fecha1[2]-$fecha1[1]-$fecha1[0]";
  ?>
  <h4><? echo $datos[2];?></h4><br />
<table class="table table-striped" style="width:650px">
 
    <th>Grupos</th><td><? echo $datos[1];?></td>
  </tr>
  <tr>
    <th>Descripción</th><td><? echo $datos[3];?></td>
  </tr>
  <tr>
    <th>Departamento</th><td><? echo $datos[4];?></td>
  </tr>
  <tr>
    <th>Profesor</th><td><? echo $datos[5];?></td>
  </tr>
  <tr>
    <th>Horario</th><td><? echo $datos[6];?></td>
  </tr>
  <tr>
    <th>Fecha</th><td><? echo $fecha;?></td>
  </tr>
  <tr>
    <th>Registro</th><td><? echo $registro;?></td>
  </tr>
      <tr>
    <th>Justificación</th><td><? echo $datos[10];?></td>
  </tr>
    <tr>
    <th>Autorizada</th><td><? echo $datos[9];?></td>
  </tr>
</table>
</div>
</body>
</html>