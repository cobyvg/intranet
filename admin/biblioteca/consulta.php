<?php
if(isset($_POST['submit2'])){
	$fecha = $_POST['fecha'];
	$fecha_act = $_POST['fecha_act'];
	include("lpdf.php");
}
else
{

session_start();
include("../../config.php");
	
if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


if((!(stristr($_SESSION['cargo'],'1') == TRUE)) and (!(stristr($_SESSION['cargo'],'c') == TRUE)) )
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}

if (!isset($_POST['fecha'])) {
	header('Location:'.'http://'.$dominio.'/intranet/admin/biblioteca/index_morosos.php');
}

include("../../menu.php");
include("menu.php");
	

if(isset($_POST['submit1'])){
$fecha = $_POST['fecha'];
?>
<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
	  <h2>Biblioteca <small>Gestión de los Préstamos</small></h1>
		<h3 class="text-info">Fecha elegida: <?php echo $fecha; ?></small></h3>
	</div>
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
	<!-- COLUMNA CENTRAL -->
  <div class="col-sm-12">
<form name="form1" action="edicion.php" method="post">
<table class='table table-striped'>
<thead>
	<thead>
		<th><input type="checkbox" onclick="selectall(form1)"></th>
		<th>Grupo </th>
		<th>Alumno </th>
		<th>Título </th>
		<th>Fecha dev.</th>
		<th> </th>
	</thead>
	</thead><tbody>
	<?
	$fecha_act = date('Y-m-d');
	$lista=mysql_query("select curso, apellidos, nombre, ejemplar, devolucion, amonestacion, id, sms from morosos where hoy='$fecha' and devolucion<'$fecha_act'  order by curso, apellidos asc");

	$n=0;
	while ($list=mysql_fetch_array($lista)){
	?>
	<tr>
	<? 
	if ($list[5]=='NO') { 
		$n+=1   
	?>
		<td style="text-align: center"><input type="checkbox" name="id[]"
			value="<? echo $list[6] ;?>" /></td>
		<td style="text-align: center"><? echo $list[0];   ?></td>
		<td><? echo $list[1].', '.$list[2];   ?></td>
		<td><? echo $list[3];   ?></td>
		<td style="text-align: center"><? echo $list[4];   ?></td>
		<td style="text-align: left" nowrap>
		<?
		if ($list[7] == "SI") {
			echo '<span class="fa fa-comment fa-fw fa-lg" data-toggle="tooltip" title="Se ha enviado SMS de advertencia"></span>';
		}
		?>
		</td>
			<? }
			else {?>
		<td style="text-align: center"></td>
		<td style="text-align: center"><? echo $list[0];   ?></td>
		<td><? echo $list[1].', '.$list[2];   ?></td>
		<td><? echo $list[3];   ?></td>
		<td style="text-align: center"><? echo $list[4];   ?></td>
		<td style="text-align: center"><i class="fa fa-check"></i></td>

		<? } ?>
	</tr>
	<?	} ?>
	</tbody>
</table>

	<? if($n==0){?>
	<br /><br />
<div class="alert alert-info">
	Todos los alumnos de esta lista han sido registrados. Ahora solo podrás consultarla.
</div>
	<? }
	else {?>
<hr>
<button type="submit" class="btn btn-danger" name="borrar" value="Borrar"><span class="fa fa-trash-o fa-fw"></span> Borrar</button>
<button type="submit" class="btn btn-info" name="sms" value="sms"><span class="fa fa-mobile fa-fw"></span> Enviar SMS</button>
<button type="submit" class="btn btn-warning" name="registro" value="registro"><span class="fa fa-gavel fa-fw"></span> Registrar Amonestaciones</button>

	<? } ?></form>

<form action="consulta.php"
	method="POST" name="listas" class="form-inline">
<input type="hidden" name="fecha" value="<? echo $fecha; ?>" />
<input type="hidden" name="fecha_act" value="<? echo $fecha_act; ?>" />
<button class="btn btn-primary" type="submit" name="submit2" value="Lista del Curso">Listado en PDF</button>
<a href="index_morosos.php" class="btn btn-default">Realizar otra consulta</a>
</form>
	<? }  ?> 
	<? }  ?>
	
<?php include("../../pie.php");?>
	
	<script>
	function selectall(form) {  
	 var formulario = eval(form)  
	 for (var i=0, len=formulario.elements.length; i<len ; i++)  
	  {  
	    if ( formulario.elements[i].type == "checkbox" )  
	      formulario.elements[i].checked = formulario.elements[0].checked  
	  }  
	}  
	</script>  

</body>
</html>
