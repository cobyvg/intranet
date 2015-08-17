<?php
require('../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../menu.php");
include("menu.php");
?>

<div class="container">

<div class="page-header">
<h2>Reservas <small> Gestión del Sistema de Reservas</small></h2>
</div>
<?php
if (isset($_POST['recurso'])) {	$recurso = $_POST['recurso'];}elseif (isset($_GET['recurso'])) {$recurso = $_GET['recurso'];}
if (isset($_POST['nuevo_elm'])) {$nuevo_elm = $_POST['nuevo_elm'];}elseif (isset($_GET['nuevo_elm'])) {	$nuevo_elm = $_GET['nuevo_elm'];}
if (isset($_POST['id_tipo'])) {$id_tipo = $_POST['id_tipo'];}elseif (isset($_GET['id_tipo'])) {	$id_tipo = $_GET['id_tipo'];}
if (isset($_POST['observaciones'])) {$observaciones = $_POST['observaciones'];}elseif (isset($_GET['observaciones'])) {	$observaciones = $_GET['observaciones'];}


if(!empty($recurso)){
	?>
<h3 class="text-center text-info"><?php echo $_POST['recurso'];?></h3>
<br>
<?php
}
?>

<div class="row"><?php
if (isset($_POST['enviar_elm'])) {
	$nuevo_elm = $_POST['nuevo_elm'];
	$id_elm = $_POST['id_elm'];

	if (isset($_POST['nuevo_elm'])) {
		$n_elm = mysqli_query($db_con,"select id, elemento from reservas_elementos where id = '".$_POST['id_elm']."'");
		if (mysqli_num_rows($n_elm) > 0) {
			$elm_old = mysqli_fetch_array($n_elm);
			$viejo_elm =  $elm_old[1];
			$actual = 1;
		}
	}

	if ($actual <> 1) {
		
		mysqli_query($db_con,"insert into reservas_elementos values ('','".mysqli_real_escape_string($db_con, $nuevo_elm)."','$id_tipo','0','".mysqli_real_escape_string($db_con,$observaciones)."')");
		if (mysqli_affected_rows($db_con)>0) {
			$msg = "Los datos se han registrado correctamente. Un nuevo Tipo de Recurso aparecerá en el sistema de reservas a partir de ahora.";
		}			}

		else {
			mysqli_query($db_con,"update reservas_elementos set  elemento='".mysqli_real_escape_string($db_con, $nuevo_elm)."', observaciones = '".mysqli_real_escape_string($db_con, $observaciones)."' where id = '$id_elm'");
			mysqli_query($db_con,"update reservas set servicio='".mysqli_real_escape_string($db_con, $nuevo_elm)."' where servicio = '".mysqli_real_escape_string($db_con, $viejo_elm)."')");
			
			if (mysqli_affected_rows($db_con)>0) {
				$msg = "Los datos se han actualizado correctamente.";
			}
		}
		?>
<div class="alert alert-success">
<p>
<?php echo $msg;?>
</p>
</div>
<?php
}

if (isset($_GET['eliminar_elm'])) {
	$id_elm = $_GET['id_elm'];
	mysqli_query($db_con,"delete from reservas_elementos where id = '$id_elm'");
	if (mysqli_affected_rows($db_con)>0) {
		$msg = "El Recurso ha sido eliminado del sistema de reservas.";
	}
	?>
<div class="alert alert-success">
<p>
<?php echo $msg;?>
</p>
</div>
<?php
}

if (isset($_GET['editar_elm'])) {
	$id_elm = $_GET['id_elm'];
	$ya = mysqli_query($db_con,"select * from reservas_elementos where id = '$id_elm'");
	if (mysqli_num_rows($ya)>0) {
		$ya_id = mysqli_fetch_array($ya);
		$nuevo_elm =  $ya_id[1];
	}
}
?>
<form action="" method="post" method="post">
<div class="col-sm-4 col-sm-offset-4">
<div class="form-group"><label>Tipo de Recurso</label> <select
	class="form-control" name="recurso" onchange="submit()">
	<option></option>
	<?php
	$srv = mysqli_query($db_con,"select distinct tipo from reservas_tipos order by tipo");
	if (mysqli_num_rows($srv)<1) {
		?>
	<div class="alert alert-warning">
	<p>No se han definido Tipos de Recursos en el sistema de reservas.
	Pulsa en el botón para crearlos en primer lugar. Una vez definidos los
	Tipos de Recursos, puedes volver a esta página y crear Elementos dentro
	de cada categoría. 
	</p>
</div>
<?php
	}
	while ($rc = mysqli_fetch_array($srv)) {
		$nombre_tipo = $rc[0];
		?>
	<option <?php if($recurso==$nombre_tipo){echo " selected";}?>><?php echo $nombre_tipo;?></option>
	<?php
	}
	?></select></div>
</div>
</form>
</div>
<!-- Tipos -->
<div class="row"></div>
	<?php
	if (isset($recurso) and $recurso!=="") {
		?> <!-- Elementos -->

<hr>
<div class="row">
<div class="col-sm-5 col-sm-offset-1">
<h3>Elementos del Recurso</h3>
<form action="gestion_elementos.php" method="post">
<table class="table table-striped">

<?php
$elm = mysqli_query($db_con,"select distinct elemento, id, id_tipo, observaciones from reservas_elementos where id_tipo = (select id from reservas_tipos where tipo = '$recurso')");
if (mysqli_num_rows($elm)>0) {
	echo "<thead><th colspan=3>$recurso</th></thead>";
	while ($rc = mysqli_fetch_array($elm)) {
		$nombre_elm = $rc[0];
		$id_elm_rec = $rc[1];
		$id_tipo = $rc[2];
		$observaciones_elm = $rc[3];
		?>
	<tr>
		<td><?php echo $nombre_elm;?> <span class='pull-right'><a
			href='gestion_elementos.php?editar_elm=1&id_elm=<?php echo $id_elm_rec;?>&nuevo_elm=<?php echo $nombre_elm;?>&id_tipo=<?php echo $id_tipo;?>&recurso=<?php echo $recurso;?>&observaciones=<?php echo $observaciones_elm;?>'><span
			class='fa fa-edit fa-fw fa-lg' data-bs='tooltip' title='Editar'></span></a>
		<a
			href='gestion_elementos.php?id_elm= <?php echo $id_elm_rec;?>&recurso=<?php echo $recurso;?>&observaciones=<?php echo $observaciones_elm;?>&eliminar_elm=1'
			data-bb='confirm-delete'><span class='fa fa-trash-o fa-fw fa-lg'
			data-bs='tooltip' title='Eliminar'></span></a></span></td>
	</tr>
	<?php
	}
}
else{
	$srv = mysqli_query($db_con,"select distinct id from reservas_tipos where tipo = '$recurso'");
	$tp = mysqli_fetch_array($srv);
	$id_tipo = $tp[0];
	?>
<br>
<div class="alert alert-warning">
<p>
No se han definido elementos del sistema de reservas en esta categoría.	
	<p>
</div>
<?php
}

?>
	</tbody>
</table>
</form>
</div>
<div class="col-sm-5">
<h3>Crear y Editar Recursos</h3>
<form action="gestion_elementos.php" method="post">
<div class="form-group"><label>Nombre del Recurso</label> 
<input class="form-control" type="text" name="nuevo_elm"
	value="<?php echo $nuevo_elm;?>">
</div>
<div class="form-group"> 
<label>Observaciones (lugar, descripción, instrucciones, etc.)</label>
<textarea class="form-control" rows="2" name="observaciones"><?php echo $observaciones;?></textarea>
</div>
<input type="hidden" name="recurso" value="<?php echo $recurso;?>"> 
<input type="hidden" name="id_tipo"
	value="<?php if (!empty($id_tipo)) {echo $id_tipo;}?>"> 
<input type="hidden" name="id_elm"
	value="<?php if (!empty($id_elm)) {echo $id_elm;}?>"> 
<input class="btn btn-default" type="submit" name="enviar_elm"
	value="Enviar datos" /> 
<a href="gestion_elementos.php?recurso=<?php echo $recurso;?>"
	class="btn btn-primary pull-right">Nuevo Elemento del Recurso</a>

</form>

</div>
</div>
<?php } ?></div>
	<?php include("../pie.php");?>

</body>
</html>









