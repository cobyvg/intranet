<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

?>
<script>
function confirmacion() {
	var answer = confirm("ATENCIÓN:\n ¿Estás seguro de que quieres borrar los datos? Esta acción es irreversible. Para borrarlo, pulsa Aceptar; de lo contrario, pulsa Cancelar.")
	if (answer){
return true;
	}
	else{
return false;
	}
}
</script>
<?
  include("../../menu.php"); 
include("menu.php"); 
 $imprimir_activado = true;  
  if($confirmado == '1')
  {
  mysql_query("UPDATE  actividades SET  confirmado =  '1' WHERE id = '$id'");
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad ha sido confirmada por la Autoridad.
          </div></div>';  
  }
  if ($_GET['eliminar']=='1') {
  	mysql_query("delete from actividades where id = '".$_GET['id']."'");
  	if (mysql_affected_rows()>'0') {
    	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad ha sido borrada correctamente.
          </div></div>';		
  	}
  }	
  if($detalles == '1')
  {
  ?>
<div align="center">
<div class="page-header">
  <h2>Actividades Complementarias y Extraescolares <small> Información sobre actividad</small></h2>
</div>
</div>
  <?
  $datos0 = "select * from actividades where id = '$id'";
  $datos1 = mysql_query($datos0);
  $datos = mysql_fetch_array($datos1);
  $fecha0 = explode("-",$datos[7]);
  $fecha = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
  $fecha1 = explode("-",$datos[8]);
  $registro = "$fecha1[2]-$fecha1[1]-$fecha1[0]";
  ?>
<div align="center">
<table class="table table-striped" style="width:750px;" align="center">
  <thead><tr>
   <th colspan="2"><h4 align="center"><? echo $datos[2];?></h4></th>
  </tr>
  </thead>
  <tr>
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
</table></div>
<br />
  <?
 } 
?>
<div align="center">
<div class="page-header">
  <h2>Actividades Complementarias y Extraescolares <small> Listado</small></h2>
</div>
</div>
   <div class='container-fluid'>
  <div class="row-fluid">
  <div class="span1"> </div>
  <div class="span10">
<table class="table table-striped tabladatos" style="width:100%;" align="center">
  <thead><tr>
    <th>Actividad</th>
    <th>Grupos</th>
    <th>Departamento</th>
    <th>Fecha</th>
    <th>Mes</th>
    <th></th>

  </tr></thead>
  <tbody>
<?
if($expresion){
	$extra = " and (actividad like '%$expresion%' or descripcion like '%$expresion%') ";
}
$meses = "select distinct month(fecha) from actividades where 1=1 $extra order by fecha";
$meses0 = mysql_query($meses);
while ($mes = mysql_fetch_array($meses0))
{
$mes1 = $mes[0];
  if($mes1 ==  "01") $mes2 = "Enero";
  if($mes1 ==  "02") $mes2 = "Febrero";
  if($mes1 ==  "03") $mes2 = "Marzo";
  if($mes1 ==  "04") $mes2 = "Abril";
  if($mes1 ==  "05") $mes2 = "Mayo";
  if($mes1 ==  "06") $mes2 = "Junio";
  if($mes1 ==  "09") $mes2 = "Septiembre";
  if($mes1 ==  "10") $mes2 = "Octubre";
  if($mes1 ==  "11") $mes2 = "Noviembre";
  if($mes1 ==  "12") $mes2 = "Diciembre";

$datos0 = "select * from actividades where month(fecha) = '$mes1' $extra order by fecha";
  $datos1 = mysql_query($datos0);
while($datos = mysql_fetch_array($datos1))
{
if(strlen($datos[1]) > 96){
$gr1 = substr($datos[1],0,48)."<br>";
$gr2 = substr($datos[1],48,48)."<br>";
$gr3 = substr($datos[1],96)."<br>";
$grupos = $gr1.$gr2.$gr3;
}

elseif(strlen($datos[1]) > 48 and strlen($datos[1]) < 96){
$gr1 = substr($datos[1],0,48)."<br>";
$gr2 = substr($datos[1],48,96)."<br>";
$grupos = $gr1.$gr2;
}
elseif(strlen($datos[1]) < 50){
$gr1 = substr($datos[1],0,50)."<br>";
$grupos = $gr1;
}
$fecha0 = explode("-",$datos[7]);
$fecha = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
?>
  <tr>
    <td style="color:#08c;"><? echo $datos[2];?></td>
    <td><? echo $grupos;?></td>
    <td><? echo $datos[4];?></td>
    <td nowrap><? echo $fecha;?></td>
	<td><? echo $mes2;?></td>
    <td nowrap><a href="consulta.php?id=<? echo $datos[0];?>&detalles=1"><i class="icon icon-search"> </i> </a>
    <?
    //echo $_SESSION['depto'] ."== $datos[4]";
	if(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'5') == TRUE){
				echo '<a href="indexconsulta.php?id='.$datos[0].'&modificar=1"><i class="icon icon-pencil"> </i> </a>';	
			echo '<a href="consulta.php?id='.$datos[0].'&eliminar=1"><i class="icon icon-trash" onClick="return confirmacion();"> </i> </a>';
}
elseif ($_SESSION['depto'] == $datos[4]){	 
			echo '<a href="indexconsulta.php?id='.$datos[0].'&modificar=1"><i class="icon icon-pencil"> </i>  </a>';	
			echo '<a href="consulta.php?id='.$datos[0].'&eliminar=1"> <i class="icon icon-trash"> </i> </a>';
	}
	?>

    </td>
  </tr>
<? }}?>
</tbody></table>
<? include("../../pie.php");?>
</body>
</html>
