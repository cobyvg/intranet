<!-- MODULO HORARIO Y PROFESORES -->
<?
// Asignaturas
mysqli_query($db_con,"CREATE TABLE IF NOT EXISTS `asig_tmp` (
  `claveal` varchar(12) collate latin1_spanish_ci NOT NULL,
  `codigo` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");
mysqli_query($db_con,"TRUNCATE TABLE asig_tmp");

$comb = mysqli_query($db_con,"select combasi from alma where claveal = '$claveal'");
$combasi = mysqli_fetch_array($comb);
$tr_combasi = explode(":",$combasi[0]);
foreach ($tr_combasi as $codigo){
	 mysqli_query($db_con,"insert into asig_tmp(claveal, codigo) VALUES ('$claveal','$codigo')");
}
?>
<a name="horario"></a>
<h3>Horario de la unidad</h3>
<br>

<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<thead>
			<tr class="text-info">
				<th>&nbsp;</th>
				<th>Lunes</th>
				<th>Martes</th>
				<th>Miércoles</th>
				<th>Jueves</th>
				<th>Viernes</th>
			</tr>
		</thead>
		<tbody>
			<?php $horas = array(1 => "8.15-9.15", 2 => "9.15-10.15", 3 => "10.15-11.15", 4 => "11.45-12.45", 5 => "12.45-13.45", 6 => "13.45-14.45" ); ?>
			<?php foreach($horas as $hora => $desc): ?>
			<tr>
				<th nowrap class="text-warning"><?php echo $desc; ?></th>
				<?php for($i = 1; $i < 6; $i++): ?>
				<td width="20%">
					<?php $result = mysqli_query($db_con, "SELECT DISTINCT asig, c_asig, a_aula, n_aula FROM horw WHERE (a_grupo=(select unidad from alma where claveal = '$claveal') or a_grupo = (select distinct a_grupo from horw where c_asig='25204') or a_grupo = (select distinct a_grupo from horw where c_asig='25226')) AND dia='$i' AND hora='$hora' and c_asig in (select codigo from asig_tmp)"); ?>
					<?php while($row = mysqli_fetch_array($result)): ?>
					<?php echo $row[0]."<div class='text-success' data-bs='tooltip' title='".$row[3]."'>".$row[2]."</div>"; ?>
					<?php endwhile; ?>
				</td>
				<?php endfor; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?
mysqli_query($db_con,"DROP TABLE asig_tmp");
?>
<br>
<h3>Equipo educativo</h3>
<br>

<div class="table-responsive">
<table class="table table-striped" style="width:auto">
		<thead>
			<tr>
				<th class="col-sm-4">Asignatura</th>
				<th class="col-sm-8">Profesor/a</th>
			</tr>
		</thead>
<?php 
	//echo "<br><div class='row'><div class='span8 offset2'><table class='table table-striped'>";
				
$comb = mysqli_query($db_con,"select combasi, unidad, curso from alma where claveal = '$claveal'");
$combasi = mysqli_fetch_array($comb);
$tr_combasi = explode(":",$combasi[0]);
foreach ($tr_combasi as $codigo){
	  $SQL = mysqli_query($db_con,"select distinct materia, nivel, profesor from profesores, asignaturas where materia= nombre and grupo = '".$combasi[1]."' and codigo = '$codigo' and abrev not like '%\_%' and curso = '".$combasi[2]."'");

  while ($rowasig = mysqli_fetch_array($SQL))
        {
	printf ("<tr><td>$rowasig[0]</td><td class='text-info'>$rowasig[2]</tr>");				
	}	
}

echo "</table>
</div>";
?>
<!-- FIN MODULO HORARIO Y PROFESORES -->
