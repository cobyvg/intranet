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



?>

<?
  include("../../menu.php"); 
include("menu.php"); 
$PLUGIN_DATATABLES = 1;
?>
<div class="container">
<div class="row">
<br>
<?
 $imprimir_activado = true;  
  if($confirmado == '1')
  {
  mysql_query("UPDATE  actividades SET  confirmado =  '1' WHERE id = '$id'");
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad ha sido confirmada por la Autoridad.
          </div></div>';  
  }
  if ($_GET['eliminar']=='1') {
  	mysql_query("delete from actividades where id = '".$_GET['id']."'");
  	if (mysql_affected_rows()>'0') {
    	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad ha sido borrada correctamente.
          </div></div>';		
  	}
  }	
  if($detalles == '1')
  {
  ?>
<div class="row">
<div class="page-header">
  <h2>Actividades Complementarias y Extraescolares <small> Información sobre actividad</small></h2>
</div>
<div class="col-md-8 col-md-offset-2">
<?
  $datos0 = "select * from actividades where id = '$id'";
  $datos1 = mysql_query($datos0);
  $datos = mysql_fetch_array($datos1);
  $fecha0 = explode("-",$datos[7]);
  $fecha = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
  $fecha1 = explode("-",$datos[8]);
  $registro = "$fecha1[2]-$fecha1[1]-$fecha1[0]";
  ?>
<table class="table table-striped" align="center">
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
</table>
</div>
</div>
  <?
 } 
?>
<div class="row">
  <div class="page-header">
  <h2>Actividades Complementarias y Extraescolares <small> Listado</small></h2>
  
  <div class="col-sm-12">
  <br>
<table class="table table-striped datatable" style="width:100%;" align="center">
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
    <td nowrap><a href="consulta.php?id=<? echo $datos[0];?>&detalles=1"><span class="fa fa-search fa-fw fa-lg"></span></a>
    <?
    //echo $_SESSION['depto'] ."== $datos[4]";
	if(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'5') == TRUE){
			echo '<a href="indexconsulta.php?id='.$datos[0].'&modificar=1"><span class="fa fa-pencil fa-fw fa-lg"></span></a>';	
			echo '<a href="consulta.php?id='.$datos[0].'&eliminar=1" data-bb="confirm-delete"><span class="fa fa-trash-o fa-fw fa-lg"></span></a>';
}
elseif ($_SESSION['depto'] == $datos[4]){	 
		if(stristr($_SESSION['cargo'],'4') == TRUE){
			echo '<a href="indexconsulta.php?id='.$datos[0].'&modificar=1"><span class="fa fa-pencil fa-fw fa-lg"></span></a>';	
			echo '<a href="consulta.php?id='.$datos[0].'&eliminar=1"><span class="fa fa-trash-o fa-fw fa-lg"></span></a>';
	}
}
	?>

    </td>
  </tr>
<? }}?>
</tbody></table>
</div>
</div>
</div>
<? include("../../pie.php");?>
	<script>
	$(document).ready(function() {
	  var table = $('.datatable').DataTable({
	  		"paging":   true,
	      "ordering": true,
	      "info":     false,
	      
	  		"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
	  		
	  		"order": [[ 1, "desc" ]],
	  		
	  		"language": {
	  		            "lengthMenu": "_MENU_",
	  		            "zeroRecords": "No se ha encontrado ningún resultado con ese criterio.",
	  		            "info": "Página _PAGE_ de _PAGES_",
	  		            "infoEmpty": "No hay resultados disponibles.",
	  		            "infoFiltered": "(filtrado de _MAX_ resultados)",
	  		            "search": "Buscar: ",
	  		            "paginate": {
	  		                  "first": "Primera",
	  		                  "next": "Última",
	  		                  "next": "",
	  		                  "previous": ""
	  		                }
	  		        }
	  	});
	});
	</script>
</body>
</html>
