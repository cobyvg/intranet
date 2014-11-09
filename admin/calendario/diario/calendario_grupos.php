<?
if (isset($_GET['month'])) { $month = $_GET['month']; $month = preg_replace ("/[[:space:]]/", "", $month); $month = preg_replace ("/[[:punct:]]/", "", $month); $month = preg_replace ("/[[:alpha:]]/", "", $month); }
if (isset($_GET['year'])) { $year = $_GET['year']; $year = preg_replace ("/[[:space:]]/", "", $year); $year = preg_replace ("/[[:punct:]]/", "", $year); $year = preg_replace ("/[[:alpha:]]/", "", $year); if ($year < 1990) { $year = 1990; } if ($year > 2035) { $year = 2035; } }
if (isset($_GET['today'])) { $today = $_GET['today']; $today = preg_replace ("/[[:space:]]/", "", $today); $today = preg_replace ("/[[:punct:]]/", "", $today); $today = preg_replace ("/[[:alpha:]]/", "", $today); }

$month = (isset($month)) ? $month : date("n",time());
$year = (isset($year)) ? $year : date("Y",time());
$today = (isset($today))? $today : date("j", time());
$daylong = date("l",mktime(1,1,1,$month,$today,$year));
$monthlong = date("F",mktime(1,1,1,$month,$today,$year));
$dayone = date("w",mktime(1,1,1,$month,1,$year))-1;
$numdays = date("t",mktime(1,1,1,$month,1,$year));
$alldays = array('Lun','Mar','MiÈ','Jue','Vie','S·b','Dom');
$next_year = $year + 1;
$last_year = $year - 1;
    if ($daylong == "Sunday")
	{$daylong = "Domingo";}
    elseif ($daylong == "Monday")
	{$daylong = "Lunes";}
    elseif ($daylong == "Tuesday")
	{$daylong = "Martes";}
    elseif ($daylong == "Wednesday")
	{$daylong = "MÈrcoles";}
    elseif ($daylong == "Thursday")
	{$daylong = "Jueves";}
    elseif ($daylong == "Friday")
	{$daylong = "Viernes";}
    elseif ($daylong == "Saturday")
	{$daylong = "S·bado";}
    

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


$mes_sig = $month+1;
$mes_ant = $month-1;
$ano_ant = $ano_sig = $year;
if ($mes_ant == 0) {
	$mes_ant = 12;
	$ano_ant = $year-1;
}
if ($mes_sig == 13) {
	$mes_sig = 1;
	$ano_sig = $year+1;
}
if (isset($_GET['menu_cuaderno'])) {
$extra = "&menu_cuaderno=1&profesor=".$_SESSION['profi']."&dia=$dia&hora=$hora&asignatura=$asignatura";
}

//Nombre del Mes
echo "<table class=\"table table-bordered table-centered\"><thead><tr>";
echo "<th><h4>
	<a href='".$_SERVER['PHP_SELF']."?year=$ano_ant&today=$today&month=$mes_ant&curso=$curso$extra'>
<span class=\"fa fa-arrow-circle-left fa-fw fa-lg\"></span></a></h4></th>";
echo "<th colspan=\"5\"><h4>".$monthlong.' '.$year."</h4></th>";
echo "<th><h4><a href='".$_SERVER['PHP_SELF']."?year=$ano_sig&today=$today&month=$mes_sig&curso=$curso$extra'>
<span class=\"fa fa-arrow-circle-right fa-fw fa-lg\"></span></a></h4></th>";
echo "</tr><tr>";


//Nombre de D√≠as
foreach($alldays as $value) {
  echo "<th>
  $value</th>";
}
echo "</tr><thead><tbody><tr>";


//D√≠as vac√≠os
if ($dayone < 0) $dayone = 6;
for ($i = 0; $i < $dayone; $i++) {
  echo "<td>&nbsp;</td>";
}


//D√≠as
for ($zz = 1; $zz <= $numdays; $zz++) {
  if ($i >= 7) {  print("</tr><tr>"); $i=0; }
  // Mirar a ver si hay alguna ctividad en el d√≠as
  $result_found = 0;
  if ($zz == $today) { 
    echo "<td class='calendar-today'>$zz</td>";
    $result_found = 1;
  }  
  
 if ($result_found != 1) { 
		//Buscar actividad para el dÛa y marcarla
		$sql_currentday = "$year-$month-$zz";

    $eventQuery = "SELECT distinct fecha, profesor, titulo, materia FROM diario WHERE grupo like '%$curso%' and fecha = '$sql_currentday';";
    // echo $eventQuery;
		$eventExec = mysqli_query($db_con, $eventQuery );
		if (mysqli_num_rows($eventExec)>0) {
		while ( $row = mysqli_fetch_array ( $eventExec ) ) {
		$titulo = $row[2];
		$mat_arr = explode(";",$row[3]);
		$materia = $mat_arr[0];
      	if ($row[1]!==$_SESSION['profi']) {
      		$ellos++;
      	}
      	else{
      		$yo++;
      	}     	
        //break;
      }
      
		if ($yo>0) {
      		echo "<td class='calendar-blue'><span data-bs='tooltip' data-html='true' title='$materia => $titulo'>$zz</span></td>\n";		
      	}
      	elseif ($ellos>0){
      		echo "<td class='calendar-orange'><span data-bs='tooltip' data-html='true' title='$materia => $titulo'>$zz</span></td>\n";		
      	}
      	$result_found = 1;
		}	
		else{
		$sql_currentday = "$year-$month-$zz";
        $fest = mysqli_query($db_con, "select distinct fecha from festivos WHERE fecha = '$sql_currentday'");
		if (mysqli_num_rows($fest)>0) {
		$festiv=mysqli_fetch_array($fest);
		echo "<td class='calendar-red'>$zz</td>\n";
		$result_found = 1;
				}	
		}
		
	}

  if ($result_found != 1) {
    echo "<td style=''>$zz</td>";
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

<table class="table">
	<tbody>
		<tr>
			<td>
				<span class="fa fa-square fa-fw fa-lg" style="color: #3397db;"></span>
				Actividades registradas por mÌ.
			</td>
		</tr>
		<tr>
			<td>
				<span class="fa fa-square fa-fw fa-lg" style="color: #f29b12;"></span>
				Actividades registradas por otros profesores.
			</td>
		</tr>
		<tr>
			<td>
				<span class="fa fa-square fa-fw fa-lg" style="color: #e14939;"></span>
				DÌas festivos
			</td>
		</tr>
	</tbody>
</table>

