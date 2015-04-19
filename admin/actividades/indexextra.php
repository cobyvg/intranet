<?
session_start();
include("../../config.php");
include("../../config/version.php");


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


if(!(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'5') == TRUE OR stristr($_SESSION['cargo'],'4') == TRUE))
{
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');
	exit;
}

$PLUGIN_DATATABLES = 1;

include("../../menu.php");
include("menu.php");

// Actualizar datos de las actividades extraescolares

$actua = mysqli_query($db_con, "select modulo from actualizacion where modulo = 'Actividades Extraescolares'");
if (mysqli_num_rows($actua)>0) {}else{

	$query3 = mysqli_query($db_con, "select distinct grupos, id from actividades");
	while ($result4 = mysqli_fetch_array($query3)) {
		if (strstr($result4[0],";")==TRUE) {}
		else{
			$nuevo="";
			$tr = explode("-",$result4[0]);
			foreach ($tr as $val){
					
				$nivel = substr($val,0,2);
				$grupo = substr($val,2,1);
					
				$nuevo.="$nivel-$grupo;";
			}
			$nuevo = substr($nuevo,0,-2);
			mysqli_query($db_con, "update actividades set grupos = '$nuevo' where id = '$result4[1]'");
		}
	}
	mysqli_query($db_con, "insert into actualizacion (modulo, fecha) values ('Actividades Extraescolares', NOW())");
}

?>
<div class='container'>
<div class="page-header">
<h2>Actividades Complementarias y Extraescolares <small> Administración</small></h2>
</div>

<div class="row">

<div class="col-sm-12"><?   
if ($_GET['eliminar']=="1") {
	mysqli_query($db_con, "delete from actividades where id = '".$_GET['id']."'");
	if (mysqli_affected_rows()>'0') {
		echo '
<br /><div><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			La actividad ha sido borrada correctamente de la base de datos.         
			</div></div>';  	
	}
}

if($confirmado == '1')
{
	mysqli_query($db_con, "UPDATE  actividades SET  confirmado =  '1' WHERE id = '$id'");

	$result = mysqli_query($db_con, "SELECT actividad, CONCAT(descripcion,' ',justificacion) AS descripcion, departamento, profesor, grupos, fecha, hoy FROM actividades WHERE id='$id'");
	$row = mysqli_fetch_assoc($result);
	$fechaini = $row['fecha'];
	$nombre = mysqli_real_escape_string($db_con, $row['actividad']);
	$descripcion = mysqli_real_escape_string($db_con, $row['descripcion']);
	$departamento = mysqli_real_escape_string($db_con, $row['departamento']);
	$profesores = mysqli_real_escape_string($db_con, $row['profesor']);
	$unidades = mysqli_real_escape_string($db_con, $row['grupos']);
	$fechareg = mysqli_real_escape_string($db_con, $row['hoy']);

	$query = "INSERT INTO `calendario` (`categoria`, `nombre`, `descripcion`, `fechaini`, `horaini`, `fechafin`, `horafin`, `departamento`, `profesores`, `unidades`, `fechareg`, `profesorreg`) VALUES (2, '$nombre', '$descripcion', '".$fechaini."', '08:15', '".$fechaini."', '09:15', '$departamento', '$profesores', '$unidades', '".$fechareg."', 'admin')";
	mysqli_query($db_con, $query) or die(mysqli_error($db_con));
	echo '
<div><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La Actividad ha sido confirmada por la Autoridad.
			</div></div>'; 

}
if($detalles == '1')
{
	?> <?
	$datos0 = "select * from actividades where id = '$id'";
	$datos1 = mysqli_query($db_con, $datos0);
	$datos = mysqli_fetch_array($datos1);
	$fecha0 = explode("-",$datos[7]);
	$fecha = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
	$fecha1 = explode("-",$datos[8]);
	$registro = "$fecha1[2]-$fecha1[1]-$fecha1[0]";
	?>
<div>
<h3>Información completa de Actividad Extraescolar</h3>
<br />
</div>
<div>
<table align="center" class="table table-bordered table-striped" style="width:auto;">
	<tr>
		<th colspan="2">
		<h4 class="text-info"><? echo $datos[2];?></h4>
		</th>
	</tr>
	<tr>
		<th>Grupos</th>
		<td><? echo substr($datos[1],0,-1);?></td>
	</tr>
	<tr>
		<th>Descripción</th>
		<td><? echo $datos[3];?></td>
	</tr>
	<tr>
		<th>Departamento</th>
		<td><? echo $datos[4];?></td>
	</tr>
	<tr>
		<th>Profesor</th>
		<td><? echo $datos[5];?></td>
	</tr>
	<tr>
		<th>Horario</th>
		<td><? 
		if ($datos[6]=="00:00:00 - 00:00:00") {
			echo "Todo el día.";
		}
		else{
		echo $datos[6];
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
</table>
</div>
<br />


	<?
}
?>

<table class="table table-striped table-hover datatable"
	style="width: auto;">
	<thead>
		<tr>
			<th>Fecha</th>
			<th>Actividad</th>
			<th>Mes</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?
	$meses = "select distinct month(fecha) from actividades order by fecha";
	$meses0 = mysqli_query($db_con, $meses);
	while ($mes = mysqli_fetch_array($meses0))
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
		$datos0 = "select * from actividades where month(fecha) = '$mes1' order by fecha";
		$datos1 = mysqli_query($db_con, $datos0);
		while($datos = mysqli_fetch_array($datos1))
		{
			$fecha0 = explode("-",$datos[7]);
			$fecha = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
			$autoriz = $datos[9];
			$datos[2]= str_replace("\\","",$datos[2]);
			?>
		<tr>
			<td nowrap="nowrap"><? echo $datos[7];?></td>
			<td><? echo $datos[2];?></td>
			<td><? echo $mes2;?></td>
			<td nowrap>
			 <?
				if(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'5') == TRUE OR (stristr($_SESSION['cargo'],'4') == TRUE and $_SESSION['dpt'] == $datos[4])){
					?> <a href="extraescolares.php?id=<? echo $datos[0];?>"><span
				class="fa fa-users fa-fw fa-lg" data-bs="tooltip"
				title="Seleccionar alumnos que realizan la Actividad"></span></a> <? } ?>
			<a href="indexextra.php?id=<? echo $datos[0];?>&detalles=1"
				data-bs="tooltip" title="Detalles"><span
				class="fa fa-search fa-fw fa-lg"></span></a> 
				<a href="<? echo 'indexconsulta.php?id='.$datos[0];?>" data-bs="tooltip" title="Editar"><span class="fa fa-edit fa-fw fa-lg"></span></a>
					<?
				if((stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'5') == TRUE)){
					?> <? if($autoriz=="1"){
					?>
					<span
				class="fa fa-check-circle fa-fw fa-lg text-success"></span>
					<?	
					}else{ ?> <a
				href="indexextra.php?id=<? echo $datos[0];?>&confirmado=1"
				data-bs="tooltip" title="Autorizar"><span
				class="fa fa-check-circle fa-fw fa-lg text-danger"></span></a> <? } ?> <? 
				$id_repe = "select id, idact from cal where eventdate = '$datos[7]'";
				$repe0 = mysqli_query($db_con, $id_repe);
				$id = mysqli_fetch_array($repe0);
				$br = "$id[1]";
				$cal_idact = $datos[0].";";
				if(ereg($cal_idact, $br)) {$si = "1";} else{$si = "0";}
				$n_idact = strstr($br,$cal_idact);
				?> <?
				// echo  $_SESSION['dpt']." == ".$datos[4];
				if(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'5') == TRUE  OR (stristr($_SESSION['cargo'],'4') == TRUE and $_SESSION['dpt'] == $datos[4])){
					?> <a href="indexextra.php?id=<? echo $datos[0];?>&eliminar=1"
				data-bs="tooltip" title="Eliminar" data-bb="confirm-delete"><span
				class="fa fa-trash-o fa-fw fa-lg"></span></a> <? } ?></td>
				<? }?>
		</tr>
		<?
		}
	}
	?>
	</tbody>
</table>
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
			
			"order": [[ 0, "desc" ]],
			
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
