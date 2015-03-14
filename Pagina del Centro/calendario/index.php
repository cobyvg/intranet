<?php
$conn = mysql_connect ( $host, $user, $pass ) or die ( "Error en la conexión con la Base de Datos!" );
mysql_select_db ( $db, $conn );

if (isset($_GET['month'])) { $month = $_GET['month']; $month = preg_replace ("/[[:space:]]/", "", $month); $month = preg_replace ("/[[:punct:]]/", "", $month); $month = preg_replace ("/[[:alpha:]]/", "", $month); }
if (isset($_GET['year'])) { $year = $_GET['year']; $year = preg_replace ("/[[:space:]]/", "", $year); $year = preg_replace ("/[[:punct:]]/", "", $year); $year = preg_replace ("/[[:alpha:]]/", "", $year); if ($year < 1990) { $year = 1990; } if ($year > 2035) { $year = 2035; } }
if (isset($_GET['today'])) { $today = $_GET['today']; $today = preg_replace ("/[[:space:]]/", "", $today); $today = preg_replace ("/[[:punct:]]/", "", $today); $today = preg_replace ("/[[:alpha:]]/", "", $today); }

$month = (isset ( $month )) ? $month : date ( "n", time () );
$year = (isset ( $year )) ? $year : date ( "Y", time () );
$today = (isset ( $today )) ? $today : date ( "j", time () );
$daylong = date ( "l", mktime ( 1, 1, 1, $month, $today, $year ) );
$monthlong = date ( "F", mktime ( 1, 1, 1, $month, $today, $year ) );
$dayone = date ( "w", mktime ( 1, 1, 1, $month, 1, $year ) );
$numdays = date ( "t", mktime ( 1, 1, 1, $month, 1, $year ) );
$alldays = array ('D', 'L', 'M', 'X', 'J', 'V', 'S' );
$next_year = $year + 1;
$last_year = $year - 1;
if ($daylong == "Sunday") {
	$daylong = "Domingo";
} elseif ($daylong == "Monday") {
	$daylong = "Lunes";
} elseif ($daylong == "Tuesday") {
	$daylong = "Martes";
} elseif ($daylong == "Wednesday") {
	$daylong = "Miércoles";
} elseif ($daylong == "Thursday") {
	$daylong = "Jueves";
} elseif ($daylong == "Friday") {
	$daylong = "Viernes";
} elseif ($daylong == "Saturday") {
	$daylong = "Sábado";
}

if ($monthlong == "January") {
	$monthlong = "Enero";
} elseif ($monthlong == "February") {
	$monthlong = "Febrero";
} elseif ($monthlong == "March") {
	$monthlong = "Marzo";
} elseif ($monthlong == "April") {
	$monthlong = "Abril";
} elseif ($monthlong == "May") {
	$monthlong = "Mayo";
} elseif ($monthlong == "June") {
	$monthlong = "Junio";
} elseif ($monthlong == "July") {
	$monthlong = "Julio";
}
if ($monthlong == "August") {
	$monthlong = "Agosto";
} elseif ($monthlong == "September") {
	$monthlong = "Septiembre";
} elseif ($monthlong == "October") {
	$monthlong = "Octubre";
} elseif ($monthlong == "November") {
	$monthlong = "Noviembre";
} elseif ($monthlong == "December") {
	$monthlong = "Diciembre";
}

if ($today > $numdays) {
	$today --;
}

//Nombre del Mes
echo "<div class='well well-small well-transparent'>";
echo ' <li class="nav-header">'.$monthlong.' <i class="icon icon-calendar icon-large pull-right"> </i></li><hr />';
echo "<table class='table table-striped'><thead><tr>";

//Nombres de Días
foreach ( $alldays as $value ) {
	echo "<th align=\"center\">$value</th>";
}
echo "</tr></thead><tr>";

//Días en blanco
for($i = 0; $i < $dayone; $i ++) {
	echo "<td valign=\"middle\" align=\"center\">&nbsp;</td>\n";
}

//Días
for($zz = 1; $zz <= $numdays; $zz ++) {
	if ($i >= 7) {
		print ("</tr>\n<tr>\n") ;
		$i = 0;
	}
	//Comprobar si hay actividad en el día
	$result_found = 0;
	if ($zz == $today) { 
	//Marcar días actuales
	
    echo "<td align=\"center\" style='background-color:#555;color:#fff;font-size:0.8em;'>$zz</td>\n";
		$result_found = 1;
	}
	if ($result_found != 1) { 
		//Buscar actividad para el día y marcarla
		$sql_currentday = "$year-$month-$zz";

		$eventQuery = "SELECT nombre FROM calendario WHERE date(fechaini)='$sql_currentday' and categoria < '3'";
		//echo $eventQuery;
		$eventExec = mysql_query ( $eventQuery );
		$row = mysql_fetch_array ( $eventExec );
			if (strlen ( $row ["nombre"] ) > 0) {
echo "<td valign=\"middle\" align=\"center\" style='background-color:#f89406;color:#fff;font-size:0.8em;'>$zz</td>\n";
				$result_found = 1;
		}	
		else{
		$sql_currentday = "$year-$month-$zz";
		$fest = mysql_query("select distinct fecha from festivos WHERE fecha = '$sql_currentday'");
		if (mysql_num_rows($fest)>0) {
		$festiv=mysql_fetch_array($fest);
			echo "<td valign=\"middle\" align=\"center\" style='background-color:#46A546;color:#fff;font-size:0.8em;cursor:pointer' onClick=\"window.location='" ."<? echo $dominio;?>calendario/jcal_admin/index.php". 
	"?year=$year&month=$month&today=$zz';\">$zz</td>\n";
				$result_found = 1;
				}	
		}
		
	}
	
	if ($result_found != 1) { //Celda por defecto
		echo "<td valign=\"middle\" align=\"center\" style='font-size:0.8em'>$zz</td>";
	}
	
	$i ++;
	$result_found = 0;
}

$create_emptys = 7 - (($dayone + $numdays) % 7);
if ($create_emptys == 7) {
	$create_emptys = 0;
}

//Celdas en blanco 
if ($create_emptys != 0) {
	echo "<td class=\"cellbg\" valign=\"middle\" align=\"center\" colspan=\"$create_emptys\"></td>\n";
}

echo "</tr></table><hr />";
$rango7 = date ( 'Y-m-d');
//$query = "SELECT distinct title, eventdate, event FROM cal WHERE eventdate >= '$rango0' limit 5";

$query = "SELECT distinct nombre, fechaini FROM calendario WHERE date(fechaini)>='$rango7' and categoria < '3' order by fechaini limit 5";
$result = mysql_query ( $query );
if (mysql_num_rows ( $result ) > 0) {
	echo '<li class="nav-header" style="margin-bottom:5px;"><i  class="icon-list"></i><small> Próximos días</li><br>';
	while ( $row = mysql_fetch_array ( $result ) ) {
		$trozos = explode ( "-", $row[1] );
		$ano = $trozos [0];
		$mes = $trozos [1];
		$dia = $trozos [2];
		$fecha = "$dia-$mes-$ano";

		$texto = $row[0];
		$titulo = nl2br ( $texto );
		echo "<p><i  class='icon-calendar'></i><small> &nbsp;$fecha.&nbsp;</small><a href='http://".$dominio."calendario/jcal_admin/index.php?year=$ano&month=$mes&today=$dia' rel='tooltip' title='$row[2]'>  $texto</a></p>";	
	}
	//echo "</div>";
}
else{
	$sql_currentday = "$year-$month-$zz";
		$fest = mysql_query("select distinct fecha, nombre from festivos WHERE fecha = '$rango0' limit 5");
		if (mysql_num_rows($fest)>0) {
		$festiv=mysql_fetch_array($fest);
		echo "<p><i  class='icon-calendar'></i><small> &nbsp;$festiv[0].&nbsp;</small>  $festiv[1]</p>";	
				}	
}
mysql_close($conn);
?>
</div>



