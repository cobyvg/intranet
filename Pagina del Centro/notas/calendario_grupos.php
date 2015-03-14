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
$alldays = array('Dom','Lun','Mar','Mie','Jue','Vie','Sab');
$next_year = $year + 1;
$last_year = $year - 1;
    if ($daylong == "Sunday")
	{$daylong = "Domingo";}
    elseif ($daylong == "Monday")
	{$daylong = "Lunes";}
    elseif ($daylong == "Tuesday")
	{$daylong = "Martes";}
    elseif ($daylong == "Wednesday")
	{$daylong = "M�rcoles";}
    elseif ($daylong == "Thursday")
	{$daylong = "Jueves";}
    elseif ($daylong == "Friday")
	{$daylong = "Viernes";}
    elseif ($daylong == "Saturday")
	{$daylong = "S�bado";}
    

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

    <?
	echo "<table class='table table-bordered table-striped' style='width:100%;margin:auto'><tr><th>
<div align='center'>
	<a href='".$_SERVER['PHP_SELF']."?year=$last_year&today=$today&month=$month'>
<i class='icon icon-arrow-left icon-2x' name='calb2' style='margin-right:20px;'> </i> </a>
<h3 style='display:inline'>$year</h3>
<a href='".$_SERVER['PHP_SELF']."?year=$next_year&today=$today&month=$month'>
<i class='icon icon-arrow-right icon-2x' name='calb1' style='margin-left:20px;'> </i> </a></div></th></tr></table><br />";

echo "<table class='table table-bordered' style='width:100%;' align='center'>
      <tr>";
	  $meses = array("1"=>"Ene", "2"=>"Feb", "3"=>"Mar", "4"=>"Abr", "5"=>"May", "6"=>"Jun", "7"=>"Jul", "8"=>"Ago", "9"=>"Sep", "10"=>"Oct", "11"=>"Nov", "12"=>"Dic");
	  foreach ($meses as $num_mes => $nombre_mes) {
	  	
	  	if ($num_mes==$month) {
	  		echo "<th style='background-color:#08c'> 
		<a href='".$_SERVER['PHP_SELF']."?year=$year&today=$today&month=$num_mes' style='color:#efefef'>".$nombre_mes."</a> </th>";
	  	}
	  	else{
	  		echo "<th> 
		<a href='".$_SERVER['PHP_SELF']."?year=$year&today=$today&month=$num_mes'>".$nombre_mes."</a> </th>";
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
echo "<table class='table table-bordered table-striped' align='center'><thead>";
echo "<th colspan=\"7\" align=\"center\"><div align='center'>" . $monthlong . 
"</div></th>";
echo "</thead><tr>";


//Nombre de Días
foreach($alldays as $value) {
  echo "<th style=''>
  $value</th>";
}
echo "</tr><tr>";


//Días vacíos
for ($i = 0; $i < $dayone; $i++) {
  echo "<td>&nbsp;</td>";
}


//Días
for ($zz = 1; $zz <= $numdays; $zz++) {
  if ($i >= 7) {  print("</tr><tr>"); $i=0; }
  // Mirar a ver si hay alguna ctividad en el días
  $result_found = 0;
  if ($zz == $today) { 
    echo "<td onClick=\"window.location='" 
	.$_SERVER['PHP_SELF']. "?year=$year&today=$zz&month=$month';\" style='background-color:#08c;color:#fff;cursor:pointer;'>$zz</td>";
    $result_found = 1;
  }
  if ($result_found != 1) {//Buscar actividad  y marcarla.
    $sql_currentday = "$year-$month-$zz";
    $eventQuery = "SELECT distinct fechaini FROM calendario WHERE unidades like '%".$_SESSION['unidad']."%' and fechaini = '$sql_currentday' and categoria > '2'";
    
    //echo $eventQuery;
    $eventExec = mysql_query($eventQuery);
    while($row = mysql_fetch_array($eventExec)) {
      if (mysql_num_rows($eventExec) == 1) {
echo "<td onClick=\"window.location='" .$_SERVER['PHP_SELF']. "?year=$year&today=$zz&month=$month';\" style='background-color:#f89406;color:#fff;cursor:pointer;'>$zz</td>";
        $result_found = 1;
      }
    }
  }

  if ($result_found != 1) {
    echo "<td onClick=\"window.location='" .$_SERVER['PHP_SELF']. "?year=$year&today=$zz&month=$month';\" style='cursor:pointer;'><a href='".$_SERVER['PHP_SELF']."?year=$year&today=$zz&month=$month'>$zz</a></td>";
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

