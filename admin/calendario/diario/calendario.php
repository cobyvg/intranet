<?
if (isset($_GET['month'])) { $month = $_GET['month']; $month = preg_replace ("/[[:space:]]/", "", $month); $month = preg_replace ("/[[:punct:]]/", "", $month); $month = preg_replace ("/[[:alpha:]]/", "", $month); }
if (isset($_GET['year'])) { $year = $_GET['year']; $year = preg_replace ("/[[:space:]]/", "", $year); $year = preg_replace ("/[[:punct:]]/", "", $year); $year = preg_replace ("/[[:alpha:]]/", "", $year); if ($year < 1990) { $year = 1990; } if ($year > 2035) { $year = 2035; } }
if (isset($_GET['today'])) { $today = $_GET['today']; $today = preg_replace ("/[[:space:]]/", "", $today); $today = preg_replace ("/[[:punct:]]/", "", $today); $today = preg_replace ("/[[:alpha:]]/", "", $today); }

$month = (isset($month)) ? $month : date("n",time());
$year = (isset($year)) ? $year : date("Y",time());
$today = (isset($today))? $today : date("j", time());
$daylong = date("l",mktime(1,1,1,$month,$today,$year));
$monthlong = date("F",mktime(1,1,1,$month,$today,$year));
$dayone = date("w",mktime(1,1,1,$month,1,$year));
$numdays = date("t",mktime(1,1,1,$month,1,$year));
$alldays = array('Do','Lu','Ma','Mi','Ju','Vi','Sa');
$next_year = $year + 1;
$last_year = $year - 1;
    if ($daylong == "Sunday")
	{$daylong = "Domingo";}
    elseif ($daylong == "Monday")
	{$daylong = "Lunes";}
    elseif ($daylong == "Tuesday")
	{$daylong = "Martes";}
    elseif ($daylong == "Wednesday")
	{$daylong = "Mércoles";}
    elseif ($daylong == "Thursday")
	{$daylong = "Jueves";}
    elseif ($daylong == "Friday")
	{$daylong = "Viernes";}
    elseif ($daylong == "Saturday")
	{$daylong = "Sábado";}
    

    if ($monthlong == "January")
	{$monthlong = "Enero";}
    elseif ($monthlong == "February")
	{$monthlong = "Febrero";}
    elseif ($monthlong == "March")
	{$monthlong = "Marzo";}
    elseif ($monthlong == "April")
	{$monthlong = "Abril";}
    elseif ($monthlong == "May")
	{$monthlong = "Mayo";}
    elseif ($monthlong == "June")
	{$monthlong = "Junio";}
    elseif ($monthlong == "July")
	{$monthlong = "Julio";}
    if ($monthlong == "August")
	{$monthlong = "Agosto";}
    elseif ($monthlong == "September")
	{$monthlong = "Septiembre";}
    elseif ($monthlong == "October")
	{$monthlong = "Octubre";}
    elseif ($monthlong == "November")
	{$monthlong = "Noviembre";}
    elseif ($monthlong == "December")
	{$monthlong = "Diciembre";}
if ($today > $numdays) { $today--; }

// Estructura de la Tabla
?>
<br />
<div class="row">
<div class=col-sm-6>
<legend class='text-warning' align='center'><br />Instrucciones de uso</legend>
<p class="help-block text-default" style="text-align:justify">
A través de esta página puedes registrar las pruebas, controles o actividades de distinto tipo para los alumnos de los Grupos a los que das clase, o bien puedes utilizar esta página para registrar entradas pèrsonales como si fuera un calendario. <em>Los registros que estén relacionados con tus Grupos y Asignaturas aparecerán en el Calendario de la Intranet, pero también en la página personal del alumno en la Página del Centro</em>, de tal modo que Padres y Alumnos puedan ver en todo momento las fechas de las pruebas; <em>si la actividad no contiene Grupo alguno aparecerá sólo en el Calendario de la Intranet a modo de recordatorio</em>. La fecha y el Tíulo de la actividad son los únicos campos obligatorios. Puedes editar, ver y borrar los registros mediante los iconos de la tabla que presenta todas tus actividades.
</p>
</div>
<div class=col-sm-6>
    <?
	echo "<legend class='text-warning' align='center'><br />$daylong $today, $year</legend>";	
	
	echo "<table class='table table-bordered table-striped table-condensed' style='width:100%;'><thead><th>
<div align='center'>
	<a href='".$_SERVER['PHP_SELF']."?year=$last_year&today=$today&month=$month'>
<i class='fa fa-arrow-circle-o-left fa-lg' name='calb2' style='margin-right:20px;'> </i> </a>
<h4 style='display:inline'>$year</h4>
<a href='".$_SERVER['PHP_SELF']."?year=$next_year&today=$today&month=$month'>
<i class='fa fa-arrow-circle-o-right fa-lg' name='calb1' style='margin-left:20px;'> </i> </a></div></th></thead></table>";

echo "<table class='table table-bordered table-condensed' style='width:100%;' align='center'>
      <tr>";
	  $meses = array("1"=>"Ene", "2"=>"Feb", "3"=>"Mar", "4"=>"Abr", "5"=>"May", "6"=>"Jun", "7"=>"Jul", "8"=>"Ago", "9"=>"Sep", "10"=>"Oct", "11"=>"Nov", "12"=>"Dic");
	  foreach ($meses as $num_mes => $nombre_mes) {
	  	
	  	if ($num_mes==$month) {
	  		echo "<td class='info'> 
		<a href='".$_SERVER['PHP_SELF']."?year=$year&today=$today&month=$num_mes' style='font-size:10px'>".$nombre_mes."</a> </td>";
	  	}
	  	else{
	  		echo "<td class='active'> 
		<a href='".$_SERVER['PHP_SELF']."?year=$year&today=$today&month=$num_mes' style='font-size:10px'>".$nombre_mes."</a> </td>";
	  	}
	  if ($num_mes=='6') {
	  		echo "</tr><tr>";
	  	}
	  }
	  echo "</tr></table>";
	  
$sql_date = "$year-$month-$today";
$semana = date( mktime(0, 0, 0, $month, $today, $year));
$hoy = getdate($semana);
$numero_dia = $hoy['wday'];

//Nombre del Mes
echo "<table class='table table-bordered table-striped table-condensed' style='' align='center'><thead>";
echo "<td colspan=\"7\" align=\"center\"><div align='center'>" . $monthlong . 
"</div></td>";
echo "</thead><tr>";


//Nombre de DÃ­as
foreach($alldays as $value) {
  echo "<th style=''>
  $value</th>";
}
echo "</tr><tr>";


//DÃ­as vacÃ­os
for ($i = 0; $i < $dayone; $i++) {
  echo "<td>&nbsp;</td>";
}


//DÃ­as
for ($zz = 1; $zz <= $numdays; $zz++) {
  if ($i >= 7) {  print("</tr><tr>"); $i=0; }
  // Mirar a ver si hay alguna ctividad en el dÃ­as
  $result_found = 0;
  if ($zz == $today) { 
    echo "<td class='info'>$zz</td>";
    $result_found = 1;
  }

if ($result_found != 1) {//Buscar actividad  y marcarla.
    $sql_currentday = "$year-$month-$zz";
    $eventQuery = "SELECT fecha, profesor FROM diario WHERE fecha = '$sql_currentday' and calendario = '1' and (grupo='Sin grupo' ";
    
$asig = mysql_query("select distinct grupo from profesores where profesor = '".$_SESSION['profi']."'");
while ($asign = mysql_fetch_array($asig)) {
	$eventQuery.=" or grupo like '%$asign[0]%'";
}
$eventQuery.=")";
$n_ex="";
$n_pr="";
    //echo $eventQuery."<br>";
    $eventExec = mysql_query($eventQuery);
    $colores="";
    while($row = mysql_fetch_array($eventExec)) {
    	$n_ex+=1;
      if (mysql_num_rows($eventExec) > 0) {
      	if ($row[1]!==$_SESSION['profi']) {
      		$yo='';
      	}
      	else{
      		$yo+='1';
      	}
      	if ($yo>0) {
      		$colores=" class='success'";
      	}
      	else{
      		$colores=" class='warning'";
      	}
        //break;
      }
  }
  
  $fest = mysql_query("select distinct fecha from festivos WHERE fecha = '$sql_currentday'");
		if (mysql_num_rows($fest)>0) {
		$festiv=mysql_fetch_array($fest);
			echo "<td valign=\"middle\" align=\"center\" class='danger'>$zz</td>\n";
				$result_found = 1;
				}
				else{
        		echo "<td $colores>$zz</td>";					
				}
          $result_found = 1;
    }
  if ($result_found != 1) {
    echo "<td>$zz</td>";
  }

  $i++; $result_found = 0;
}

$create_emptys = 7 - (($dayone + $numdays) % 7);
if ($create_emptys == 7) { $create_emptys = 0; }

if ($create_emptys != 0) {
  echo "<td colspan=\"$create_emptys\">&nbsp;</td>";
}

echo "</tr>";
echo "</table>";
?>
<hr />
<table class="table"><tr><td class='warning' style="width:25px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td> <small>Exámenes de otros Profesores</small></td></tr><tr><td  class='success'></td><td> <small>Exámenes propios</small></td></tr></table>

<?
echo "</div>";
?>

