<h6 align="center">Horario del profesor</h6>
<br />
<table class="table table-striped" align="center">
	<tr>
		<td></td>
		<th>1ª</th>
		<th>2ª</th>
		<th>3ª</th>
		<th>4ª</th>
		<th>5ª</th>
		<th>6ª</th>
	</tr>
	<?php
	// Nombres de los días y variable que recoge el nombre del dia.
	// Días de la semana
	$alldays=array(1=>"L",2=>"M",3=>"X",4=>"J",5=>"V");
	foreach($alldays as $n_dia => $nombre)
	{
		echo "<tr><th><div class='badge badge-warning'>$nombre</div></th>";
		for($z=1;$z<7;$z++)
		{
			?>
	<td>
	<div align=center><?php 
	if(!(empty($n_dia) and !($z))){$extra = "and dia = '$n_dia' and hora = '$z'";}

	$conv = mysql_query("SELECT DISTINCT nombre FROM departamentos WHERE cargo like '%b%' AND nombre = '$pr'");
	if(mysql_num_rows($conv) > '0'){
	$gucon = "1";
	}

	$asignatur1 = mysql_query("SELECT distinct  c_asig, a_asig FROM  horw where prof = '$profeso' $extra");

	$rowasignatur1 = mysql_fetch_row($asignatur1);
	
	if($gucon == "1"){
		$rowasignatur1[1] = "CON";
	}
		if(is_numeric($rowasignatur1[0]) and !($rowasignatur1[1]=="GU")){echo "<span style='color:#9d261d;background-color:#FFEFCC;display:block;margin-bottom:3px;border:1px solid #ccc;'>".$rowasignatur1[1]."</span>"; }

		if(!(is_numeric($rowasignatur1[0])) and !($rowasignatur1[1]=="GU")){echo "<span style='color:#62c462;background-color:#f6eaec;display:block;margin-bottom:3px;border:1px solid #ccc;'>".$rowasignatur1[1]."</span>"; }

		if ($link=='1') {
			if($rowasignatur1[1]=="GU" and $mod_faltas=='1'){echo "<a href='guardias_admin.php?no_dia=$n_dia&hora=$z&profeso=$profeso#marca' style='color:#313131;background-color:#E6F2CF;display:block;margin-bottom:3px;border:1px solid #ccc;'>".$rowasignatur1[1]."</span>"; }
		}
		else{
			if($rowasignatur1[1]=="GU" and $mod_faltas=='1'){echo "<span style='color:#313131;background-color:#E6F2CF;display:block;margin-bottom:3px;border:1px solid #ccc;'>".$rowasignatur1[1]."</span>"; }
			else {//echo $rowasignatur1[1];
			}
		}

		// Recorremos los grupos a los que da en ese hora.
		$asignaturas1 = mysql_query("SELECT distinct  c_asig, a_grupo, a_asig FROM  horw where prof = '$profeso' and dia = '$n_dia' and hora = '$z'");
		while ($rowasignaturas1 = mysql_fetch_array($asignaturas1))
		{

			if(is_numeric(substr($rowasignaturas1[1],0,1))){
				echo $rowasignaturas1[1]."<br />";
			}

		}
		?></div>
	</td>
	<? }?>
	</tr>
	<? }?>
</table>
<br />


