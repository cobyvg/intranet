<?php
require('../bootstrap.php');


include("../menu.php");
include("menu.php");
?>

<div class="container">

	<div class="page-header">
	  <h2>Reservas <small> 
<?php 

if (isset($_POST['nuevo_tipo'])) {	$recurso = $_POST['nuevo_tipo'];}elseif (isset($_GET['nuevo_tipo'])) {	$recurso = $_GET['nuevo_tipo'];} else{ $recurso="";}
if (isset($_POST['observaciones'])) {$observaciones = $_POST['observaciones'];}elseif (isset($_GET['observaciones'])) {	$observaciones = $_GET['observaciones'];}

if(!empty($recurso)){
?>
	  <?php echo "Edición de ".$recurso;?>
<?php
}
else{
?>
	  Nuevo Tipo de Recurso en el sistema de reservas
<?php	
}
?>
</small></h2>
	</div>

<?
if (isset($_POST['nuevo_item'])) {
		$nuevo_tipo = $_POST['nuevo_tipo'];
		$id_tipo = $_POST['id_tipo'];
		$actual=0;
		
		if ($_POST['nuevo_item']=="Enviar datos") {
			$n_tipo = mysqli_query($db_con,"select id from reservas_tipos where id = '$id_tipo'");
			if (mysqli_num_rows($n_tipo) > 0) {
				$id_actual = mysqli_fetch_array($n_tipo);
				$id_tipo = $id_actual[0];
				$actual = 1;
			}
		}
		if ($actual <> 1) {
				mysqli_query($db_con,"insert into reservas_tipos values ('','$nuevo_tipo','$observaciones')");
				if (mysqli_affected_rows($db_con)>0) {
					$msg = "Los datos se han registrado correctamente. Un nuevo Tipo de Recurso aparecerá en el sistema de reservas a partir de ahora.";
				}			}			
		
		else {
				mysqli_query($db_con,"update reservas_tipos set  tipo='$nuevo_tipo', observaciones='$observaciones' where id = '".$_POST['id_tipo']."'");
				if (mysqli_affected_rows($db_con)>0) {
					$msg = "Los datos se han actualizado correctamente.";
				}
		}							
?>
		<div class="alert alert-success">
			<p><?php echo $msg;?><p>
		</div>
<?	
	}	

if (isset($_GET['eliminar_tipo'])) {
	$id_tipo = $_GET['id_tipo'];
				mysqli_query($db_con,"delete from reservas_tipos where id = '$id_tipo'");
				if (mysqli_affected_rows($db_con)>0) {
					$msg = "El Tipo de Recurso ha sido eliminado del sistema de reservas.";
		}
?>
		<div class="alert alert-success">
			<p><?php echo $msg;?><P>
		</div>
<?				
}

if (isset($_GET['editar_tipo'])) {
	$id_tipo = $_GET['id_tipo'];
	$ya = mysqli_query($db_con,"select * from reservas_tipos where id = '$id_tipo'");
			if (mysqli_num_rows($ya)>0) {
				$ya_id = mysqli_fetch_array($ya);
				$nuevo_tipo =  $ya_id[1];
				$recurso = $nuevo_tipo;
			}
}
?>

<!-- Tipos -->
<div class="row">
<div class="col-sm-5 col-sm-offset-1">
<h3>Tipos de Recursos</h3>
<br>
<table class="table table-striped">

<?
$srv = mysqli_query($db_con,"select distinct tipo, id, observaciones from reservas_tipos order by tipo");
echo "<thead><th colspan=3>$recurso</th></thead>";

while ($rc = mysqli_fetch_array($srv)) {
	$check="";
	$nombre_tipo = $rc[0];
	$id_tipo_rec = $rc[1];
	$observaciones_rec = $rc[2];
		
	echo "<tr>";
	echo "<td>$nombre_tipo <span class='pull-right'><a href='gestion_tipo.php?editar_tipo=1&id_tipo=$id_tipo_rec&nuevo_tipo=$nombre_tipo&observaciones=$observaciones_rec'><span class='fa fa-edit fa-fw fa-lg' data-bs='tooltip' title='Editar'></span></a>
	<a href='gestion_tipo.php?id_tipo= $id_tipo_rec&observaciones=$observaciones_rec&eliminar_tipo=1' data-bb='confirm-delete'><span class='fa fa-trash-o fa-fw fa-lg' data-bs='tooltip' title='Eliminar'></span></a></span></td>";
	echo "</tr>";
}
?>
</tbody>
</table>
</div>
<div class="col-sm-5">
<h3>Crear y Editar Tipos de Recursos</h3>
<br>
<form action="gestion_tipo.php" method="post">
<div class="form-group"> 
<label>Nombre del Recurso</label>
<input class="form-control" type = "text" name="nuevo_tipo" value="<?php echo $nuevo_tipo;?>" required>
</div>
<div class="form-group"> 
<label>Observaciones</label>
<textarea class="form-control" rows="2" name="observaciones"><?php echo $observaciones;?></textarea>
</div>
<input type="hidden" name="id_tipo" value="<?php if (!empty($id_tipo)) {echo $id_tipo;}?>">
<input class="btn btn-default" type="submit" name="nuevo_item" value="Enviar datos" />
<a href="gestion_tipo.php" class="btn btn-primary pull-right">Nuevo Tipo de Recurso</a>
</form>


</div>
</div>
</div>
<?php include("../pie.php");?>  

</body>
</html>









