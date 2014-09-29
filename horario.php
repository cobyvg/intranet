<h4><span class="fa fa-clock-o fa-fw"></span> Horario</h4>
<table class="table table-bordered table-condensed table-striped table-centered">
<thead>
  <tr>
	<th width="20">&nbsp;</th>
	<th width="20">L</th>
	<th width="20">M</th>
	<th width="20">X</th>
	<th width="20">J</th>
	<th width="20">V</th>
  </tr>
</thead>
<tbody>
<?php	
// Horas del día
$todas_horas = array (1 => "1", 2 => "2", 3 => "3", 4 => "4", 5 => "5", 6 => "6" );
foreach ( $todas_horas as $n_hora => $nombre ) {	
echo '<tr><th>'.$nombre.'ª</th>';
	
	//Días
	for($z = 1; $z < 6; $z ++) {

		?>
<td valign="top">
<div align=center>
      <?php
		if (! (empty ( $z ) and ! ($n_hora))) {
			$extra = "and dia = '$z' and hora = '$n_hora'";
		}
/*	$conv = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo like '%b%' AND nombre = '$pr'");
	if(mysqli_num_rows($conv) > '0'){
	$gucon = "1";
	}*/
		$asignatur1 = mysqli_query($db_con, "SELECT distinct  c_asig, a_asig FROM  horw where prof = '$pr' $extra" );		
		$rowasignatur1 = mysqli_fetch_row ( $asignatur1 );
		
/*		if ($gucon=='1') {
			$rowasignatur1 [1] = "CON";
		}*/
		if (is_numeric ( $rowasignatur1 [0] ) and ! ($rowasignatur1 [1] == "GU")) {
			echo "<span class='label label-default'>" . $rowasignatur1 [1] . "</span><br />";
		}
		
		if (! (is_numeric ( $rowasignatur1 [0] )) and ! ($rowasignatur1 [1] == "GU")) {
			echo "<span class='label label-info'>" . $rowasignatur1 [1] . "</span><br />";
		}


		if ($rowasignatur1 [1] == "GU" and $mod_faltas == '1') {
			if (strstr($_SESSION ['cargo'],"1")==TRUE) {
				echo "<a href='http://$dominio/intranet/admin/guardias/guardias_admin.php?no_dia=$z&hora=$z&profeso=$profeso#marca'><span class='label label-danger'>".$rowasignatur1[1]."</span>";
			}
			else{
				echo "<a href='http://$dominio/intranet/admin/guardias/index.php?n_dia=$z&hora=$n_hora&profeso=$pr' class='label label-danger'>" . $rowasignatur1 [1] . "</a>";
			}
		}
		// Recorremos los grupos a los que da en ese hora.
		$asignaturas1 = mysqli_query($db_con, "SELECT distinct  c_asig, a_grupo FROM  horw where prof = '$pr' and dia = '$z' and hora = '$n_hora'" );
		while ( $rowasignaturas1 = mysqli_fetch_array ( $asignaturas1 ) ) {
			$grupo = $rowasignaturas1 [1];
			if (! ($grupo == "TUT")) {
				echo "<a href='http://$dominio/intranet/cuaderno.php?dia=$z&hora=$n_hora&curso=$grupo&asignatura=$rowasignatur1[0]' style='font-size:0.8em'>";
			}
			if (is_numeric ( substr ( $grupo, 0, 1 ) )) {
				echo $grupo . "<br />";
			}
			if (! ($grupo == "TUT")) {
				echo "</a>";
			}
		}
		?>
    </span></div>
</td>
<?
	}
	?></tr><?
}
?>
</tbody>
</table>



