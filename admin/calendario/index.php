<?php
$conn = mysql_connect ( $db_host, $db_user, $db_pass ) or die ( "Error en la conexión con la Base de Datos!" );
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
echo '<h4><span class="fa fa-calendar fa-fw"></span> ' . $monthlong . '</h4>';
echo "<table class='table table-bordered table-condensed table-centered'><thead><tr>";

//Nombres de Días
foreach ( $alldays as $value ) {
	echo "<th>$value</th>";
}
echo "</tr></thead><tr>";

//Días en blanco
for($i = 0; $i < $dayone; $i ++) {
	echo "<td >&nbsp;</td>\n";
}

//Días
for($zz = 1; $zz <= $numdays; $zz ++) {
	if ($i >= 7) {
		print ("</tr>\n<tr>\n") ;
		$i = 0;
	}
	//Comprobar si hay actividad en el día
	$result_found = 0;
	if ($zz == $today) { //Marcar días actuales
    echo "<td class=\"calendar-today\">$zz</td>\n";
		$result_found = 1;
	}
	if ($result_found != 1) { //Buscar actividad para el día y marcarla
		
		

		// Principio
		$sql_currentday = "$year-$month-$zz";
		$eventQuery = "SELECT title FROM cal WHERE eventdate = '$sql_currentday';";
		$eventExec = mysql_query ( $eventQuery );
		$diari = mysql_query("SELECT id FROM diario WHERE fecha = '$sql_currentday' and calendario = '1' and profesor='".$_SESSION['profi']."'");
		
		if (mysql_num_rows($eventExec)>0) {
			while ( $row = mysql_fetch_array ( $eventExec ) ) {
			if (strlen ( $row ["title"] ) > 0) {
			$bg = "calendar-orange";
				if (mysql_num_rows($diari)>0) {
					$bg = "calendar-blue";
				}
				echo "<td class=\"$bg\">$zz</td>\n";
				$result_found = 1;
			}
		}	
		}
		else{
		$sql_currentday = "$year-$month-$zz";
		$fest = mysql_query("select distinct fecha from festivos WHERE fecha = '$sql_currentday'");
		if (mysql_num_rows($fest)>0) {
		$festiv=mysql_fetch_array($fest);
			echo "<td class=\"calendar-red\">$zz</td>\n";
				$result_found = 1;
				}	
		}
		// Fin					
	}
	
	if ($result_found != 1) { //Celda por defecto
		echo "<td style=''>$zz</td>\n";
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
	echo "<td class=\"cellbg\"  colspan=\"$create_emptys\"></td>\n";
}

echo "</tr></table>";

$mes = date ( 'm' );
$mes8 = date ( 'm' ) + 1;
$dia = date ( 'd' );
$dia7 = date ( 'd' ) + 7;
$año = date ( 'Y' );
$hoy = mktime ( 0, 0, 0, $mes, $dia, $año );
$hoy7 = mktime ( 0, 0, 0, $mes, $dia7, $año );
$hoy8 = mktime ( 0, 0, 0, $mes8, $dia, $año );
$rango0 = date ( 'Y-m-d', $hoy );
$rango7 = date ( 'Y-m-d', $hoy7 );
$rango8 = date ( 'Y-m-d', $hoy8 );

$sql_diario="SELECT id, fecha, titulo, observaciones, grupo FROM diario WHERE (profesor='".$_SESSION['profi']."' ";
$asig = mysql_query("select distinct grupo from profesores where profesor = '".$_SESSION['profi']."'");
while ($asign = mysql_fetch_array($asig)) {
	//$sql_diario.=" or grupo like '%$asign[0]%'";
}
$sql_diario.=") and date(fecha) >= '$rango0' and date(fecha) <= '$rango8' and calendario = '1'  order by fecha limit 3";

$diari = mysql_query($sql_diario);
if (mysql_num_rows ( $diari ) > 0){
	echo "<h4>Calendario personal</h4>";
	echo "<div class=\"list-group\">";
	while ( $diar = mysql_fetch_array ( $diari ) ) {
		$n_reg+=1;
		$fecha_reg = cambia_fecha($diar[1]);
		echo "<a class=\"list-group-item\" href=\"admin/calendario/diario/index.php?id=$diar[0]\"><span class=\"pull-right badge\">".strftime('%d %b', strtotime($fecha_reg))."</span> $diar[2]</a>";	
	}
	echo "</div>";
}
$n_noticias=5-$n_reg;
$query = "SELECT distinct title, eventdate, event FROM cal WHERE date(eventdate) >= '$rango0'  order by eventdate asc limit $n_noticias";
$result = mysql_query ( $query );

if (mysql_num_rows ( $result ) > 0) {
	
	$SQLcurso1 = "select distinct grupo from profesores where profesor = '$pr'";
	//echo $SQLcurso1;
	$resultcurso1 = mysql_query ( $SQLcurso1 );
	$string1="";
	while ( $rowcurso1 = mysql_fetch_array ( $resultcurso1 ) ) {
		$curso1 = $rowcurso1 [0];
		$curso1 = str_replace ( "-", "", $curso1 );
		$string1 .= $curso1 . " ";
	}
	$string1 = substr ( $string1, 0, (strlen ( $string1 ) - 1) );
	$count = "";
	
	echo "<h4>Calendario del centro</h4>";
	echo "<div class=\"list-group\">";
	while ( $row = mysql_fetch_array ( $result ) ) {
		$color="";
		$pajar = "";
		$pajar = join ( ',', $row );
		$count = $count + 1;
		$trozos = explode ( "-", $row[1] );
		$ano = $trozos [0];
		$mes = $trozos [1];
		$dia = $trozos [2];
		$string3 = explode ( " ", $string1 );
		
		// echo "$aguja => $pajar<br>";
		if ($n_curso > 0) {
			foreach ( $string3 as $aguja ) {
				$con_guion1 = substr ( $aguja, 0, 2 );
				$con_guion2 = substr ( $aguja, 2, 1 );
				$grupo_con = $con_guion1 . "-" . $con_guion2;
				if ((stristr ( $pajar, $aguja ) == TRUE or stristr ( $pajar, $grupo_con ) == TRUE) and $_SESSION ['n_cursos'] > 0) {				
	$color+= 1;
				} 
				else {
				}
			}		

		
		}
		
		if($color == ""){
		echo "";	
		$texto = $row[0];
		$titulo = nl2br ( $texto );
		echo "<a class=\"list-group-item\" href=\"admin/calendario/eventos/index.php?year=$ano&month=$mes&today=$dia\"><span class=\"pull-right badge\">".strftime('%d %b', strtotime($row[1]))."</span> $texto</a>";		
			}
		else{
		echo "";	
		$texto = $row[0];
		$titulo = nl2br ( $texto );
		echo "<a class=\"list-group-item\" href=\"admin/calendario/eventos/index.php?year=$ano&month=$mes&today=$dia\"><span class=\"pull-right badge\">".strftime('%d %b', strtotime($row[1]))."</span> <span class=\"text-warning\">$texto</span></a>";	
			}	
	}
	echo "</div>";
}
?>
	<a class="btn btn-primary btn-sm" href="admin/calendario/eventos/index.php"><?php echo (stristr($carg, '1') == TRUE) ? 'Añadir evento' : 'Ver calendario'; ?></a>