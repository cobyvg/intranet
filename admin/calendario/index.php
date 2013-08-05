<?php
$conn = mysql_connect ( $db_host, $db_user, $db_pass ) or die ( "Error en la conexión con la Base de Datos!" );
mysql_select_db ( $db, $conn );

if (isset ( $_GET ['month'] )) {
	$month = $_GET ['month'];
	$month = ereg_replace ( "[[:space:]]", "", $month );
	$month = ereg_replace ( "[[:punct:]]", "", $month );
	$month = ereg_replace ( "[[:alpha:]]", "", $month );
}
if (isset ( $_GET ['year'] )) {
	$year = $_GET ['year'];
	$year = ereg_replace ( "[[:space:]]", "", $year );
	$year = ereg_replace ( "[[:punct:]]", "", $year );
	$year = ereg_replace ( "[[:alpha:]]", "", $year );
	if ($year < 1990) {
		$year = 1990;
	}
	if ($year > 2035) {
		$year = 2035;
	}
}
if (isset ( $_GET ['today'] )) {
	$today = $_GET ['today'];
	$today = ereg_replace ( "[[:space:]]", "", $today );
	$today = ereg_replace ( "[[:punct:]]", "", $today );
	$today = ereg_replace ( "[[:alpha:]]", "", $today );
}

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
echo "<legend><i class='icon icon-calendar-empty'> </i> " . $monthlong . "</legend>";
echo "<table class='table table-striped table-bordered table-condensed'><thead><tr>";

//Nombres de Días
foreach ( $alldays as $value ) {
	echo "<th align=\"center\">
  <span class='badge badge-info'>$value</span></th>";
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
	if ($zz == $today) { //Marcar días actuales
    echo "<td align=\"center\" style='background-color:#46a546;color:#fff;font-size:0.8em'>$zz</td>\n";
		$result_found = 1;
	}
	if ($result_found != 1) { //Buscar actividad para el dóa y marcarla
		$sql_currentday = "$year-$month-$zz";
		$eventQuery = "SELECT title FROM cal WHERE eventdate = '$sql_currentday';";
		$eventExec = mysql_query ( $eventQuery );
		while ( $row = mysql_fetch_array ( $eventExec ) ) {
			if (strlen ( $row ["title"] ) > 0) {
echo "<td valign=\"middle\" align=\"center\" style='background-color:#f89406;color:#fff;font-size:0.8em'>$zz</td>\n";
				$result_found = 1;
			}
		}
	}
	
	if ($result_found != 1) { //Celda por defecto
		echo "<td valign=\"middle\" align=\"center\" style='font-size:0.8em'>$zz</td>\n";
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

echo "</tr></table>";
$mes = date ( 'm' );
$dia = date ( 'd' );
$dia7 = date ( 'd' ) + 7;
$año = date ( 'Y' );
$hoy = mktime ( 0, 0, 0, $mes, $dia, $año );
$hoy7 = mktime ( 0, 0, 0, $mes, $dia7, $año );
$rango0 = date ( 'Y-m-d', $hoy );
$rango7 = date ( 'Y-m-d', $hoy7 );
$query = "SELECT distinct title, eventdate, event FROM cal WHERE eventdate >= '$rango0' and eventdate < '$rango7'";
$result = mysql_query ( $query );
if (mysql_num_rows ( $result ) > 0) {
	echo "<br /><legend><i class='icon icon-calendar'> </i>Próximos días</legend>";
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
	while ( $row = mysql_fetch_array ( $result ) ) {
		$color="";
		$pajar = "";
		$pajar = join ( ',', $row );
		$count = $count + 1;
		$trozos = explode ( "-", $row[1] );
		$ano = $trozos [0];
		$mes = $trozos [1];
		$dia = $trozos [2];
		$fecha = "$dia-$mes-$ano";
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
		echo "<p><small>  $fecha. </small><a href='admin/calendario/jcal_admin/index.php?year=$ano&month=$mes&today=$dia' rel='tooltip' title='$row[2]'>  $texto</a></p>";		
			}
		else{
echo "";	
		$texto = $row[0];
		$titulo = nl2br ( $texto );
		echo "<p><a href='admin/calendario/jcal_admin/index.php?year=$ano&month=$mes&today=$dia' style='color:#f89406' rel='tooltip' title='$row[2]' >$fecha.  $texto</a></p>
	";	
			}	
	}
}
if (stristr ( $carg, '1' ) == TRUE) {
	?>
	<a href='admin/calendario/jcal_admin/index.php' class='btn btn-primary'
		style='margin-top:8px;'>Añadir Actividad</a>
<?

} else {
	?>
<a href='admin/calendario/jcal_admin/index.php' class='btn btn-primary'
		style='margin-top:8px;'>Ver Calendario</a>
<?
}

?>




