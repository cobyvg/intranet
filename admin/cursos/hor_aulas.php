<?php
require('../../bootstrap.php');


$profesor = $_SESSION['profi'];

if (isset($_POST['aula'])) {$aula = $_POST['aula'];} elseif (isset($_GET['aula'])) {$aula = $_GET['aula'];} else{$aula="";}

include("../../menu.php");
?>

<div
	class="container"><!-- TITULO DE LA PAGINA -->
<div class="page-header">
<form method="post" action="">
<h2><?php echo $aula; ?> <small>Consulta de horario de horario <?php $result = mysqli_query($db_con, "SELECT DISTINCT n_aula FROM horw where n_aula not like 'G%' ORDER BY n_aula ASC"); ?>
<?php if(mysqli_num_rows($result)): ?>
<div class="pull-right"><select
	class="form-control input-small col-sm-3" id="curso" name="aula"
	onChange="submit()">
	<option value="<?php echo $_POST['aula']; ?>"><?php echo $_POST['aula']; ?></option>
	<?php while($row = mysqli_fetch_array($result)): ?>
	<option value="<?php echo $row['n_aula']; ?>"><?php echo $row['n_aula']; ?></option>
	<?php endwhile; ?>
	<?php endif; ?>
</select></div>
</small></h2>
</form>
</div>

<!-- SCAFFOLDING -->
<div class="row">

<div class="col-sm-12">

<div class="table-responsive">
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Lunes</th>
			<th>Martes</th>
			<th>Miércoles</th>
			<th>Jueves</th>
			<th>Viernes</th>
		</tr>
	</thead>
	<tbody>
	<?php $horas = array(1 => "1ª", 2 => "2ª", 3 => "3ª", 4 => "4ª", 5 => "5ª", 6 => "6ª"); ?>
	<?php foreach($horas as $hora => $desc): ?>
		<tr>
			<th><?php echo $desc; ?></th>
			<?php for($i = 1; $i < 6; $i++): ?>
			<td width="20%"><?php $result = mysqli_query($db_con, "SELECT DISTINCT asig, prof,a_grupo FROM horw WHERE n_aula='$aula' AND dia='$i' AND hora='$hora'"); ?>
			<?php $grupo=""; $asignatura=""; $profesor="";?> <?php while($row = mysqli_fetch_array($result)): ?>
			<?php $grupo .= "<abbr class='text-warning'>".$row['a_grupo']."<abbr>&nbsp;&nbsp;"; ?>
			<?php $asignatura = $row['asig']; ?> <?php $profesor = nomprofesor($row['prof']);?>
			<?php endwhile; ?> <?php echo "<span class='text-danger'>$asignatura</span><br><span class='text-info'>$profesor</span><br>$grupo";?>
			</td>
			<?php endfor; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>

<div class="hidden-print"><a class="btn btn-primary" href="#"
	onclick="javascript:print();">Imprimir</a> <a class="btn btn-default"
	href="chorarios.php">Volver</a></div>

</div>
<!-- /.col-sm-12 --></div>
<!-- /.row --></div>
<!-- /.container -->

		<?php include("../../pie.php"); ?>

</body>
</html>
