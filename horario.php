<?
echo "<p class='lead'>Horario</p>";
echo "<table  class='table table-condensed table-bordered table-striped' style='width:100%;'><tr>";
?>
<td></td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">L</span></div>
</td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">M</span></div>
</td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">X</span></div>
</td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">J</span></div>
</td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">V</span></div>
</div></td>
</tr>
<?php	
// Horas del día
$todas_horas = array (1 => "1", 2 => "2", 3 => "3", 4 => "4", 5 => "5", 6 => "6" );
foreach ( $todas_horas as $n_hora => $nombre ) {	
				echo "<tr><td  valign='middle' align='center'  style='color:#555; font-weight:bold;'>".$nombre."ª</td>";

	//Días
	for($z = 1; $z < 6; $z ++) {

		?>
<td valign="top">
<div align=center>
      <?php
		if (! (empty ( $z ) and ! ($n_hora))) {
			$extra = "and dia = '$z' and hora = '$n_hora'";
		}
		$asignatur1 = mysql_query ( "SELECT distinct  c_asig, a_asig FROM  horw where prof = '$pr' $extra" );
		//echo "SELECT distinct  c_asig, a_asig FROM  horw where prof = '$pr' $extra<br>";
		
		$rowasignatur1 = mysql_fetch_row ( $asignatur1 );
		if (($rowasignatur1 [1] == "GUCON")) {
			$rowasignatur1 [1] = "CON";
		}
		if (is_numeric ( $rowasignatur1 [0] ) and ! ($rowasignatur1 [1] == "GU")) {
			echo "<h5 class='badge badge-inverse'>" . $rowasignatur1 [1] . "</h5><br />";
		}
		
		if (! (is_numeric ( $rowasignatur1 [0] )) and ! ($rowasignatur1 [1] == "GU")) {
			echo "<h5 class='badge'>" . $rowasignatur1 [1] . "</h5><br />";
		}
		if ($link=='1') {
if($rowasignatur1[1]=="GU" and $mod_faltas=='1'){echo "<a href='guardias_admin.php?no_dia=$z&hora=$n_hora&profeso=$profeso#marca' class='badge badge-warning'>".$rowasignatur1[1]."</h5><br />"; }	
}
else{
		if ($rowasignatur1 [1] == "GU" and $mod_faltas == '1') {
			echo "<a href='http://$dominio/intranet/admin/guardias/index.php?n_dia=$z&hora=$n_hora&profeso=$pr' class='badge badge-warning'>" . $rowasignatur1 [1] . "</a>";
		} else { //echo $rowasignatur1[1];
		}
}
		// Recorremos los grupos a los que da en ese hora.
		$asignaturas1 = mysql_query ( "SELECT distinct  c_asig, nivel, n_grupo FROM  horw where prof = '$pr' and dia = '$z' and hora = '$n_hora'" );
		while ( $rowasignaturas1 = mysql_fetch_array ( $asignaturas1 ) ) {
			$grupo = $rowasignaturas1 [1] . "-" . $rowasignaturas1 [2];
			if (! ($grupo == "TUT") and !($link == "1")) {
				echo "<a href='http://$dominio/intranet/cuaderno.php?dia=$z&hora=$n_hora&curso=1&asignatura=$rowasignatur1[0]' style='font-size:0.8em'>";
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
</table>



