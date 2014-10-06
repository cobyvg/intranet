<?php
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
$alldays = array('Lun','Mar','Mie','Jue','Vie','Sáb','Dom');
$next_year = $year + 1;
$last_year = $year - 1;
include("nombres.php");
   
   if ($today > $numdays) { $today--; }

// Estructura de la Tabla
echo "<table class='table table-bordered table-striped' style=''><tr><th style='text-align:center'>
	<a href='".$_SERVER['PHP_SELF']."?year=$last_year&today=$today&month=$month&profesor=$profesor&unidad=$unidad&alumno=$alumno'>
<i class='fa fa-arrow-o-left' name='calb2' style='margin-right:20px;'> </i> </a>
<h3 style='display:inline'>$year</h3>
<a href='".$_SERVER['PHP_SELF']."?year=$next_year&today=$today&month=$month&profesor=$profesor&unidad=$unidad&alumno=$alumno'>
<i class='fa fa-arrow-o-right' name='calb1' style='margin-left:20px;'> </i> </a></th></tr></table>";
     echo "<table class='table table-bordered' style=''>
      <tr>";
	  $meses = array("1"=>"Ene" ,"2"=>"Feb" ,"3"=>"Mar" ,"4"=>"Abr" ,"5"=>"May" ,"6"=>"Jun" ,"7"=>"Jul" ,"8"=>"Ago" ,"9"=>"Sep" ,"10"=>"Oct" ,"11"=>"Nov" ,"12"=>"Dic");
     	  foreach ($meses as $num_mes => $nombre_mes) {
	  	
	  	if ($num_mes==$month) {
	  		echo "<th  onClick=\"window.location='" .$_SERVER['PHP_SELF']. 
		"?profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&today=$today&month=1';\" style='background-color:#08c'> 
		<a href=\"".$_SERVER['PHP_SELF']."?profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&month=".$num_mes."\" style='color:#efefef'>".$nombre_mes."</a> </th>";
	  	}
	  	else{
	  		echo "<th  onClick=\"window.location='" .$_SERVER['PHP_SELF']. 
		"?profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&today=$today&month=1';\" > 
		<a href=\"".$_SERVER['PHP_SELF']."?profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&month=".$num_mes."\">".$nombre_mes."</a> </th>";
	  	}
	  if ($num_mes=='6') {
	  		echo "</tr><tr>";
	  	}
	  }
	  echo "</tr>
    </table>";
   
//Nombre del Mes
echo "<table class='table table-bordered' style=''><tr>";
echo "<td colspan=\"7\" valign=\"middle\" align=\"center\"><h4 align='center'>" . $monthlong . 
"</h4></td>";
echo "</tr><tr>";


//Nombre de Días
foreach($alldays as $value) {
  echo "<th  style='background-color:#eee'>
  $value</th>";
}
echo "</tr><tr>";


//Días vacíos
if ($dayone < 0) $dayone = 6;
for ($i = 0; $i < $dayone; $i++) {
  echo "<td>&nbsp;</td>";
}


//Días

for ($zz = 1; $zz <= $numdays; $zz++) {

  if ($i >= 7) {  print("</tr>\n<tr>\n"); $i=0; }

  if ($result_found != 1) {
/*	  if ($zz == $today) { 
    echo "<td onClick=\"window.location='" 
	.$_SERVER['PHP_SELF']. "?profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&today=$zz&month=$month';\" style=\"background-color:#08c;color:#efefef\">$zz</td>";
    $result_found = 1;
  }*/

//Buscar falta en el día y marcarla
		
    $sql_currentday = "$year-$month-$zz";
   // echo $sql_currentday;
    $eventQuery = "SELECT FALTA FROM FALTAS, FALUMNOS WHERE FALUMNOS.CLAVEAL = FALTAS.CLAVEAL and FALTAS.FECHA = '$sql_currentday' and FALTAS.claveal = '$alumno' ";
    //echo $eventQuery;
    $eventExec = mysqli_query($db_con, $eventQuery);
    if($row = mysqli_fetch_array($eventExec)) {
      if (strlen($row[0]) > 0) {
      	if ($row[0] == "F") {
			
      	echo "<td onClick=\"window.location='" .$_SERVER['PHP_SELF']. 
		"?profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&today=$zz&month=$month';\" style=\"background-color:#9d261d\"><a href=\"".$_SERVER['PHP_SELF']."?profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&today=$zz&month=$month\" class=\"normal\"><span style=color:white>$zz</a></span></td>\n";
        $result_found = 1;
      	}
      	elseif($row[0] == "J") {
//        echo "<td valign=\"middle\" align=\"center\" style=\"background-color:#009933\"><span style=color:white>$zz</span></td>\n";
        echo "<td onClick=\"window.location='" .$_SERVER['PHP_SELF']. 
		"?falta=J&profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&today=$zz&month=$month';\" style=\"background-color:#46a546\"><a href=\"".$_SERVER['PHP_SELF']."?falta=J&profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&today=$zz&month=$month\" class=\"normal\"><span style=color:white>$zz</a></span></td>\n";
        $result_found = 1;
      	}
      }
    }
  }

  if ($result_found != 1) {
    echo "<td onClick=\"window.location='" .$_SERVER['PHP_SELF']. 
    "?profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&today=$zz&month=$month;\" class=\"cellbg\"><a href=\"".$_SERVER['PHP_SELF']."?profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&today=$zz&month=$month\" class=\"normal\">
	<a href=\"".$_SERVER['PHP_SELF']."?profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&today=$zz&month=$month\" class=\"normal\">
    $zz</a></td>\n";
  }

  $i++; $result_found = 0;
}

$create_emptys = 7 - (($dayone + $numdays) % 7);
if ($create_emptys == 7) { $create_emptys = 0; }

if ($create_emptys != 0) {
  echo "<td colspan=\"$create_emptys\">&nbsp;</td>";
}
echo "</tr>
      </table>";
?>
