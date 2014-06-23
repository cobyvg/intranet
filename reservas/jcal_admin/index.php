<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$pr = $_SESSION['profi'];
?>
<?php
include("../../menu.php");
include("../menu.php");
mysql_select_db($db_reservas);

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

$n_servicio = strtoupper($servicio);
// Estructura de la Tabla
?>
<div class="page-header" align="center">
  <h2>Reserva de Medios <small> Reserva del <? echo $n_servicio; ?></small></h2>
</div>
<br />
<?
if (isset($_GET['mens'])) {
	if($_GET['mens']=="actualizar"){ 
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos de la reserva han sido actualizados correctamente.
          </div></div>';
}
if($_GET['mens']=="insertar"){
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos de la reserva han sido registrados correctamente.
          </div></div>';}
}
	?>
 <div class="row-fluid">
 <div class="span2"></div>
<div class="span4">
<div class="well well-small">
    <?
	echo "<legend>$daylong, $monthlong $today, $year</legend><br />";	
$sql_date = "$year-$month-$today";
$semana = date( mktime(0, 0, 0, $month, $today, $year));
$hoy = getdate($semana);
$numero_dia = $hoy['wday'];
$eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7, html FROM $servicio WHERE eventdate = '$sql_date';";
$eventExec = mysql_query($eventQuery);
while($row = mysql_fetch_array($eventExec)) {
   $event_event1 = stripslashes($row["event1"]);
   $event_event2 = stripslashes($row["event2"]);
   $event_event3 = stripslashes($row["event3"]);
   $event_event4 = stripslashes($row["event4"]);
   $event_event5 = stripslashes($row["event5"]);
   $event_event6 = stripslashes($row["event6"]);
   $event_event7 = stripslashes($row["event7"]);
}

echo "<form name=\"jcal_post\" action=\"jcal_post.php?servicio=$servicio&year=$year&today=$today&month=$month\" method=\"post\" class='form-vertical'>
<div align='left'>";

if($_SESSION['profi'] == 'Conserjeria' or stristr($_SESSION['cargo'],'1') == TRUE){$SQL = "select distinct nombre from $db.departamentos order by nombre";}
else{$SQL = "select distinct nombre from $db.departamentos where nombre = '". $_SESSION['profi'] ."'";}

if($servicio){
$eventQuery2 = "SELECT hora1 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_numrows($reservado0) == 1) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "1ª Hora &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event1)) { echo "1ª Hora &nbsp;&nbsp; <select name=\"day_event1\" class='input-xlarge'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event1)) {echo "1ª Hora &nbsp;&nbsp; <fieldset class='control-group success' style='display:inline'><input class='input-xlarge' type='text' name=\"day_event1\"  value=\"$event_event1\"></fieldset>";
	 } 
	else{
		echo "1ª Hora &nbsp;&nbsp; <fieldset class='control-group warning' style='display:inline'><input disabled class='input-xlarge' type='text'  value='$event_event1'></fieldset><input type=\"hidden\" value=\"$event_event1\" name=\"day_event1\">"; }
	}
	}	
		
echo "<hr>";	
if($servicio){$eventQuery2 = "SELECT hora2 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_num_rows($reservado0)>0) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "2ª Hora &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event2)) { echo "2ª Hora &nbsp;&nbsp; <select name=\"day_event2\" class='input-xlarge'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event2)) {echo "2 Hora &nbsp;&nbsp; <fieldset class='control-group success' style='display:inline'><input class='input-xlarge' type='text' name=\"day_event2\"  value=\"$event_event2\"></fieldset>"; } 
	else{echo "2ª Hora &nbsp;&nbsp; <fieldset class='control-group warning' style='display:inline'><input disabled class='input-xlarge' type='text'  value='$event_event2'></fieldset><input type=\"hidden\" value=\"$event_event2\" name=\"day_event2\">"; }}	}	
		
	echo "<hr>";
if($servicio){$eventQuery2 = "SELECT hora3 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_num_rows($reservado0)>0) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "3ª Hora &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if(empty($event_event3)) { echo "3ª Hora &nbsp;&nbsp; <select name=\"day_event3\" class='input-xlarge'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";}
	else {
		
	if(mb_strtolower($pr) == mb_strtolower($event_event3)) {echo "3ª Hora &nbsp;&nbsp; <fieldset class='control-group success' style='display:inline'><input class='input-xlarge' type='text' name=\"day_event3\"  value=\"$event_event3\"></fieldset>"; } 
	else{echo "3ª Hora &nbsp;&nbsp; <fieldset class='control-group warning' style='display:inline'><input disabled class='input-xlarge' type='text'  value='$event_event3'></fieldset><input type=\"hidden\" value=\"$event_event3\" name=\"day_event3\">"; }}	}	
		
	echo "<hr>";
if($servicio){$eventQuery2 = "SELECT hora4 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_num_rows($reservado0)>0) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "4ª Hora &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event4)) { echo "4ª Hora &nbsp;&nbsp; <select name=\"day_event4\" class='input-xlarge'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event4)) {echo "4ª Hora &nbsp;&nbsp; <fieldset class='control-group success' style='display:inline'><input class='input-xlarge' type='text' name=\"day_event4\"  value=\"$event_event4\"></fieldset>"; } 
	else{echo "4ª Hora &nbsp;&nbsp; <fieldset class='control-group warning' style='display:inline'><input disabled class='input-xlarge' type='text'  value='$event_event4'></fieldset><input type=\"hidden\" value=\"$event_event4\" name=\"day_event4\">"; } }	}	
		
	echo "<hr>";
if($servicio){$eventQuery2 = "SELECT hora5 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_num_rows($reservado0)>0) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "5 Hora &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event5)) { echo "5ª Hora &nbsp;&nbsp; <select name=\"day_event5\" class='input-xlarge'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event5)) {echo "5ª Hora &nbsp;&nbsp; <fieldset class='control-group success' style='display:inline'><input class='input-xlarge' type='text' name=\"day_event5\"  value=\"$event_event5\"></fieldset>"; } 
	else{echo "5Âª Hora &nbsp;&nbsp; <fieldset class='control-group warning' style='display:inline'><input disabled class='input-xlarge' type='text'  value='$event_event5'></fieldset><input type=\"hidden\" value=\"$event_event5\" name=\"day_event5\">"; }}	}	
		
	echo "<hr>";
if($servicio){$eventQuery2 = "SELECT hora6 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_num_rows($reservado0)>0) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "6ª Hora &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event6)) { echo "6ª Hora &nbsp;&nbsp; <select name=\"day_event6\" class='input-xlarge'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event6)) {echo "6ª Hora &nbsp;&nbsp; <fieldset class='control-group success' style='display:inline'><input class='input-xlarge' type='text' name=\"day_event6\"  value=\"$event_event6\"></fieldset>"; } 
	else{echo "6ª Hora &nbsp;&nbsp; <fieldset class='control-group warning' style='display:inline'><input disabled class='input-xlarge' type='text'  value='$event_event6'></fieldset><input type=\"hidden\" value=\"$event_event6\" name=\"day_event6\">"; } }	}	
		
	echo "<hr>";
if($servicio){$eventQuery2 = "SELECT hora7 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_num_rows($reservado0)>0) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "7ª Hora &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event7)) { echo "7ª Hora &nbsp;&nbsp; <select name=\"day_event7\" class='input-xlarge'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event7)) {echo "7ª Hora &nbsp;&nbsp; <fieldset class='control-group success' style='display:inline'><input class='input-xlarge' type='text' name=\"day_event7\"  value=\"$event_event7\"></fieldset>"; } 
	else{echo "7ª Hora &nbsp;&nbsp; <fieldset class='control-group warning' style='display:inline'><input disabled class='input-xlarge' type='text'  value='$event_event7'></fieldset><input type=\"hidden\" value=\"$event_event7\" name=\"day_event7\">"; }}
	}


echo "<input type=\"hidden\" value=\"$year\" name=\"year\">
      <input type=\"hidden\" value=\"$month\" name=\"month\">
      <input type=\"hidden\" value=\"$today\" name=\"today\">
       <hr><center>
      <input type=\"submit\" id='formsubmit' value='Enviar datos' class='btn btn-block btn-primary'> </center>
    </form>";
echo "</div>";
?>
</div>
</div>
<div class="span4">
<?
echo "<table class='table table-bordered table-striped' style='' align='center'><tr><th>
<div align='center'>
	<a href='".$_SERVER['PHP_SELF']."?servicio=$servicio&year=$last_year&today=$today&month=$month'>
<i class='fa fa-arrow-o-left' name='calb2' style='margin-right:20px;'> </i> </a>
<h3 style='display:inline'>$year</h3>
<a href='".$_SERVER['PHP_SELF']."?servicio=$servicio&year=$next_year&today=$today&month=$month'>
<i class='fa fa-arrow-o-right' name='calb1' style='margin-left:20px;'> </i> </a></div></th></tr></table>";

echo "<table class='table table-bordered' style='' align='center'>
      <tr>";
	  $meses = array("1"=>"Ene", "2"=>"Feb", "3"=>"Mar", "4"=>"Abr", "5"=>"May", "6"=>"Jun", "7"=>"Jul", "8"=>"Ago", "9"=>"Sep", "10"=>"Oct", "11"=>"Nov", "12"=>"Dic");
	  foreach ($meses as $num_mes => $nombre_mes) {
	  	
	  	if ($num_mes==$month) {
	  		echo "<th style='background-color:#08c'> 
		<a href=\"".$_SERVER['PHP_SELF']."?servicio=$servicio&year=$year&month=".$num_mes."\" style='color:#efefef'>".$nombre_mes."</a> </th>";
	  	}
	  	else{
	  		echo "<th> 
		<a href=\"".$_SERVER['PHP_SELF']."?servicio=$servicio&year=$year&month=".$num_mes."\">".$nombre_mes."</a> </th>";
	  	}
	  if ($num_mes=='6') {
	  		echo "</tr><tr>";
	  	}
	  }
	  echo "</tr>
    </table>";


//Nombre del Mes
echo "<table class='table table-bordered' style='' align='center'><tr>";
echo "<td colspan=\"7\" valign=\"middle\" align=\"center\"><h3 align='center'>" . $monthlong . 
"</h3></td>";
echo "</tr><tr>";


//Nombre de DÃ­as
foreach($alldays as $value) {
  echo "<th style='background-color:#eee'>
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
    echo "<td onClick=\"window.location='" 
	.$_SERVER['PHP_SELF']. "?servicio=$servicio&year=$year&today=$zz&month=$month';\" style='background-color:#0072E6;color:#fff;cursor:pointer;'>$zz</td>";
    $result_found = 1;
  }
  
  
  if ($result_found != 1) { 
		//Buscar actividad para el dóa y marcarla
		$sql_currentday = "$year-$month-$zz";

    $eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7 FROM $servicio WHERE eventdate = '$sql_currentday';";
				$eventExec = mysql_query ( $eventQuery );
		if (mysql_num_rows($eventExec)>0) {
			while ( $row = mysql_fetch_array ( $eventExec ) ) {
        echo "<td style='background-color:#f89406;cursor:pointer;' onClick='window.location='" .$_SERVER['PHP_SELF']. "?year=$year&today=$zz&month=$month&servicio=$servicio';'><a href='".$_SERVER['PHP_SELF']."?year=$year&today=$zz&month=$month&servicio=$servicio' style='color:#fff'>$zz</a></td>\n";				
				$result_found = 1;
			}
		}	
		else{
		$sql_currentday = "$year-$month-$zz";
		$fest = mysql_query("select distinct fecha, nombre from $db.festivos WHERE fecha = '$sql_currentday'");
		if (mysql_num_rows($fest)>0) {
		$festiv=mysql_fetch_array($fest);
			        echo "<td style='background-color:#46A546;'><a style='color:#fff'>$zz</a></td>\n";
				$result_found = 1;
				}	
		}
		
	}

  if ($result_found != 1) {
    echo "<td onClick=\"window.location='" .$_SERVER['PHP_SELF']. "?servicio=$servicio&year=$year&today=$zz&month=$month';\" style='cursor:pointer;'><a href='".$_SERVER['PHP_SELF']."?servicio=$servicio&year=$year&today=$zz&month=$month'>$zz</a></td>";
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
echo "";
?>
</div>
</div>
</div>
<?
include("../../pie.php");
?>
</body>
</html>
