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
/*if(!(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'4') == TRUE OR stristr($_SESSION['cargo'],'5') == TRUE OR stristr($_SESSION['cargo'],'8') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}  */
$pr = $_SESSION['profi'];   
?>
<?php
include("../../menu.php");
include("../menu.php");
mysql_select_db($db_reservas);

if (isset($_POST['enviar']) or isset($_GET['enviar'])) {

for ($i=1;$i<=7;$i++)
{
if (isset($_POST['day_event'.$i])) { $day_event{$i} = $_POST['day_event'.$i]; }
elseif (isset($_GET['day_event'.$i])) { $day_event{$i} = $_GET['day_event'.$i]; }
else{$day_event{$i}="";}
}
if (isset($_GET['month'])) { $month = intval($_GET['month']); }
if (isset($_POST['month'])) { $month = intval($_POST['month']); }

if (isset($_GET['year'])) { $year = intval ($_GET['year']); }
if (isset($_POST['year'])) { $year = intval ($_POST['year']); }

if ($year < 1990) { $year = 1990; } if ($year > 2035) { $year = 2035; }

if (isset($_GET['today'])) { $today = intval ($_GET['today']); }
if (isset($_POST['today'])) { $today = intval ($_POST['today']); }


$month = (isset($month)) ? $month : date("n",time());
$year = (isset($year)) ? $year : date("Y",time());
$today = (isset($today))? $today : date("j", time());

$sql_date = "$year-$month-$today";
$semana = date( mktime(0, 0, 0, $month, $today, $year));
$hoy = getdate($semana);
$numero_dia = $hoy[wday];

$eventQuery = "SELECT id FROM `$db_reservas`.`$servicio` WHERE eventdate = '$sql_date';";
//echo $eventQuery;
$eventExec = mysql_query($eventQuery); 
$event_found = "";
while($row = mysql_fetch_array($eventExec)) {
  $event_found = 1;
}
$day_event_safe1 = addslashes($day_event1);
$day_event_safe2 = addslashes($day_event2);
$day_event_safe3 = addslashes($day_event3);
$day_event_safe4 = addslashes($day_event4);
$day_event_safe5 = addslashes($day_event5);
$day_event_safe6 = addslashes($day_event6);
$day_event_safe7 = addslashes($day_event7);
//$aula = htmlspecialchars($aula);

if ($event_found == 1) {
  //UPDATE
  $postQuery = "UPDATE `$servicio` SET event1 = '".$_POST['day_event1']."', event2 = '".$_POST['day_event2']."', event3 = '".$_POST['day_event3']."', 
    event4 = '".$_POST['day_event4']."', event5 = '".$_POST['day_event5']."', event6 = '".$_POST['day_event6']."', event7 = '".$_POST['day_event7']."' WHERE eventdate = '$sql_date';";
    // echo $postQuery;
    $postExec = mysql_query($postQuery) or die("Could not Post UPDATE `$db_reservas`.`$servicio` Event to database!");
    mysql_query("DELETE FROM `$db_reservas`.`$servicio` WHERE event1 = '' and event2 = ''  and event3 = ''  and event4 = ''  and event5 = ''  and event6 = ''  and event7 = '' ");
$mens="actulaizar";
} else {
  //INSERT   `reservas`.`A1B-C` (
    $postQuery = "INSERT INTO `$servicio` (eventdate,dia,event1,event2,event3,event4,event5,event6,event7,html) VALUES ('$sql_date','$numero_dia','".$_POST['day_event1']."','".$_POST['day_event2']."','".$_POST['day_event3']."','".$_POST['day_event4']."','".$_POST['day_event5']."','".$_POST['day_event6']."','".$_POST['day_event7']."','$show_html');";
	       // echo $postQuery;
    $postExec = mysql_query($postQuery) or die("Could not Post INSERT `$db_reservas`.`$servicio` Event to database!");
    
mysql_query("DELETE FROM `$db_reservas`.`$servicio` WHERE event1 = '' and event2 = ''  and event3 = ''  and event4 = ''  and event5 = ''  and event6 = ''  and event7 = '' ");
$mens="insertar";
}
}

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
	{$daylong = "Miércoles";}
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
if ($servicio) {
$aula = $servicio;
$nombre_aula = $servicio;
$n_servicio = strtoupper($servicio);
}else{
$tr_serv = explode(" ==> ",$servicio_aula);
$servicio=$tr_serv[0];
$nombre_aula = $tr_serv[1];
$aula = $tr_serv[0];
$n_servicio = strtoupper($tr_serv[0]);
}
// Comprobamos que existe la tabla del aula
$reg = mysql_query("show tables from reservas");
while ($t_reg = mysql_fetch_array($reg)){
	if ($t_reg[0]==$servicio){$existe = "1";}
}
if ($existe == "1") {}else{
	$sql_hor = "CREATE TABLE `$db_reservas`.`$n_servicio` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `eventdate` date DEFAULT NULL,
  `dia` tinyint(1) NOT NULL DEFAULT '0',
  `html` tinyint(1) NOT NULL DEFAULT '0',
  `event1` varchar(64) DEFAULT NULL,
  `event2` varchar(64) NOT NULL DEFAULT '',
  `event3` varchar(64) NOT NULL DEFAULT '',
  `event4` varchar(64) NOT NULL DEFAULT '',
  `event5` varchar(64) NOT NULL DEFAULT '',
  `event6` varchar(64) NOT NULL DEFAULT '',
  `event7` varchar(64) NOT NULL DEFAULT '',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `date` (`eventdate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
	//echo $sql_hor;
mysql_query($sql_hor);
}
// Estructura de la Tabla
?>
<div class="page-header" align="center">
  <h2>Reserva de Medios <small><strong><? echo $nombre_aula; ?></strong></small></h2>
</div>
<br />
<?
	if($mens=="actualizar"){ 
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos de la reserva han sido actualizados correctamente.
          </div></div>';
}
if($mens=="insertar"){
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos de la reserva han sido registrados correctamente.
          </div></div>';}
	?>
 <div class="row-fluid">
<div class="span4 offset2">
<div class="well well-small">
    <?
	echo "<legend>$daylong, $monthlong $today, $year</legend><br />";	
$sql_date = "$year-$month-$today";
$semana = date( mktime(0, 0, 0, $month, $today, $year));
$hoy = getdate($semana);
$numero_dia = $hoy[wday];
$eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7, html FROM `$aula` WHERE eventdate = '$sql_date'";
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

echo "<form name=\"jcal_post\" action=\"index_aulas.php?servicio=$aula&year=$year&today=$today&month=$month\" method=\"post\" class='form-vertical'>
<div align='left'>";

if($_SESSION['profi'] == 'Conserjeria' or stristr($_SESSION['cargo'],'1') == TRUE){$SQL = "select distinct nombre from $db.departamentos order by nombre";}
else{$SQL = "select distinct nombre from $db.departamentos where nombre = '". $_SESSION['profi'] ."'";}

if($aula){$eventQuery2 = "SELECT a_grupo FROM horw WHERE dia = '$numero_dia' and hora='1' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysql_query($eventQuery2);
$reservado1 = mysql_fetch_row($reservado0);}
	if(!(empty($reservado1[0]))) {echo "1ª Hora &nbsp;&nbsp; <span class='label label-warning'>Asignada por Horario</span>"; }
	else
	{
if ($event_event1  == "") { echo "1ª Hora &nbsp;&nbsp; <select name=\"day_event1\" class='input-xlarge'><option></option>";
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
if($aula){$eventQuery2 = "SELECT a_grupo FROM horw WHERE dia = '$numero_dia' and hora='2' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysql_query($eventQuery2);
$reservado1 = mysql_fetch_row($reservado0);}
	if(!(empty($reservado1[0]))) {echo "2ª Hora &nbsp;&nbsp; <span class='label label-warning'>Asignada por Horario</span>"; }
	else
	{
if ($event_event2  == "") { echo "2ª Hora &nbsp;&nbsp; <select name=\"day_event2\" class='input-xlarge'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event2)) {echo "2ª Hora &nbsp;&nbsp; <fieldset class='control-group success' style='display:inline'><input class='input-xlarge' type='text' name=\"day_event2\"  value=\"$event_event2\"></fieldset>"; } 
	else{echo "2ª Hora &nbsp;&nbsp; <fieldset class='control-group warning' style='display:inline'><input disabled class='input-xlarge' type='text'  value='$event_event2'></fieldset><input type=\"hidden\" value=\"$event_event2\" name=\"day_event2\">"; }}	}	
		
	echo "<hr>";
if($aula){$eventQuery2 = "SELECT a_grupo FROM horw WHERE dia = '$numero_dia' and hora='3' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysql_query($eventQuery2);
$reservado1 = mysql_fetch_row($reservado0);}
	if(!(empty($reservado1[0]))) {echo "3ª Hora &nbsp;&nbsp; <span class='label label-warning'>Asignada por Horario</span>"; }
	else
	{
if(($event_event3 == "")) { echo "3ª Hora &nbsp;&nbsp; <select name=\"day_event3\" class='input-xlarge'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event3)) {echo "3ª Hora &nbsp;&nbsp; <fieldset class='control-group success' style='display:inline'><input class='input-xlarge' type='text' name=\"day_event3\"  value=\"$event_event3\"></fieldset>"; } 
	else{echo "3ª Hora &nbsp;&nbsp; <fieldset class='control-group warning' style='display:inline'><input disabled class='input-xlarge' type='text'  value='$event_event3'></fieldset><input type=\"hidden\" value=\"$event_event3\" name=\"day_event3\">"; }}	}	
		
	echo "<hr>";
if($aula){$eventQuery2 = "SELECT a_grupo FROM horw WHERE dia = '$numero_dia' and hora='4' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysql_query($eventQuery2);
$reservado1 = mysql_fetch_row($reservado0);}
	if(!(empty($reservado1[0]))) {echo "4ª Hora &nbsp;&nbsp; <span class='label label-warning'>Asignada por Horario</span>"; }
	else
	{
if ($event_event4  == "") { echo "4ª Hora &nbsp;&nbsp; <select name=\"day_event4\" class='input-xlarge'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event4)) {echo "4ª Hora &nbsp;&nbsp; <fieldset class='control-group success' style='display:inline'><input class='input-xlarge' type='text' name=\"day_event4\"  value=\"$event_event4\"></fieldset>"; } 
	else{echo "4ª Hora &nbsp;&nbsp; <fieldset class='control-group warning' style='display:inline'><input disabled class='input-xlarge' type='text'  value='$event_event4'></fieldset><input type=\"hidden\" value=\"$event_event4\" name=\"day_event4\">"; } }	}	
		
	echo "<hr>";
if($aula){$eventQuery2 = "SELECT a_grupo FROM horw WHERE dia = '$numero_dia' and hora='5' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysql_query($eventQuery2);
$reservado1 = mysql_fetch_row($reservado0);}
	if(!(empty($reservado1[0]))) {echo "5ª Hora &nbsp;&nbsp; <span class='label label-warning'>Asignada por Horario</span>"; }
	else
	{
if ($event_event5  == "") { echo "5ª Hora &nbsp;&nbsp; <select name=\"day_event5\" class='input-xlarge'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event5)) {echo "5ª Hora &nbsp;&nbsp; <fieldset class='control-group success' style='display:inline'><input class='input-xlarge' type='text' name=\"day_event5\"  value=\"$event_event5\"></fieldset>"; } 
	else{echo "5ª Hora &nbsp;&nbsp; <fieldset class='control-group warning' style='display:inline'><input disabled class='input-xlarge' type='text'  value='$event_event5'></fieldset><input type=\"hidden\" value=\"$event_event5\" name=\"day_event5\">"; }}	}	
		
	echo "<hr>";
if($aula){$eventQuery2 = "SELECT a_grupo FROM horw WHERE dia = '$numero_dia' and hora='6' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysql_query($eventQuery2);
$reservado1 = mysql_fetch_row($reservado0);}
	if(!(empty($reservado1[0]))) {echo "6ª Hora &nbsp;&nbsp; <span class='label label-warning'>Asignada por Horario</span>"; }
	else
	{
if ($event_event6  == "") { echo "6ª Hora &nbsp;&nbsp; <select name=\"day_event6\" class='input-xlarge'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event6)) {echo "6ª Hora &nbsp;&nbsp; <fieldset class='control-group success' style='display:inline'><input class='input-xlarge' type='text' name=\"day_event6\"  value=\"$event_event6\"></fieldset>"; } 
	else{echo "6ª Hora &nbsp;&nbsp; <fieldset class='control-group warning' style='display:inline'><input disabled class='input-xlarge' type='text'  value='$event_event6'></fieldset><input type=\"hidden\" value=\"$event_event6\" name=\"day_event6\">"; } }	}	
		
	echo "<hr>";
if($aula){$eventQuery2 = "SELECT a_grupo FROM horw WHERE dia = '$numero_dia' and hora='7' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysql_query($eventQuery2);
$reservado1 = mysql_fetch_row($reservado0);}
	if(!(empty($reservado1[0]))) {echo "7ª Hora &nbsp;&nbsp; <span class='label label-warning'>Asignada por Horario</span>"; }
	else
	{
if ($event_event7  == "") { echo "7ª Hora &nbsp;&nbsp; <select name=\"day_event7\" class='input-xlarge'><option></option>";
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
      <input name = 'enviar' type=\"submit\" id='formsubmit' value='Enviar datos' class='btn btn-primary'> </center>
    </form>";
echo "</div>";
?>
</div>
</div>
<div class="span4">
<?
echo "<table class='table table-bordered table-striped'><tr><th>
<div align='center'>
	<a href='".$_SERVER['PHP_SELF']."?servicio=$aula&year=$last_year&today=$today&month=$month'>
<i class='icon icon-arrow-left' name='calb2' style='margin-right:20px;'> </i> </a>
<h3 style='display:inline'>$year</h3>
<a href='".$_SERVER['PHP_SELF']."?servicio=$aula&year=$next_year&today=$today&month=$month'>
<i class='icon icon-arrow-right' name='calb1' style='margin-left:20px;'> </i> </a></div></th></tr></table>";

echo "<table class='table table-bordered' align='center'>
      <tr>";
	  $meses = array(1=>Ene, 2=>Feb, 3=>Mar, 4=>Abr, 5=>May, 6=>Jun, 7=>Jul, 8=>Ago, 9=>Sep, 10=>Oct, 11=>Nov, 12=>Dic);
	  foreach ($meses as $num_mes => $nombre_mes) {
	  	
	  	if ($num_mes==$month) {
	  		echo "<th  onClick=\"window.location='" .$_SERVER['PHP_SELF']. 
		"?servicio=$aula&year=$year&today=$today&month=1';\" style='background-color:#08c'> 
		<a href=\"".$_SERVER['PHP_SELF']."?servicio=$aula&year=$year&today=$today&month=".$num_mes."\" style='color:#efefef'>".$nombre_mes."</a> </th>";
	  	}
	  	else{
	  		echo "<th  onClick=\"window.location='" .$_SERVER['PHP_SELF']. 
		"?servicio=$aula&year=$year&today=$today&month=1';\" > 
		<a href=\"".$_SERVER['PHP_SELF']."?servicio=$aula&year=$year&today=$today&month=".$num_mes."\">".$nombre_mes."</a> </th>";
	  	}
	  if ($num_mes=='6') {
	  		echo "</tr><tr>";
	  	}
	  }
	  echo "</tr>
    </table>";


//Nombre del Mes
echo "<table class='table table-bordered'><tr>";
echo "<td colspan=\"7\" valign=\"middle\" align=\"center\"><h3 align='center'>" . $monthlong . 
"</h3></td>";
echo "</tr><tr>";


//Nombre de Días
foreach($alldays as $value) {
  echo "<th style='background-color:#eee'>
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
	.$_SERVER['PHP_SELF']. "?servicio=$aula&year=$year&today=$zz&month=$month';\" style='background-color:#08c;color:#fff;cursor:pointer;'>$zz</td>";
    $result_found = 1;
  }
  if ($result_found != 1) {//Buscar actividad  y marcarla.
    $sql_currentday = "$year-$month-$zz";
    $eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7 FROM `$aula` WHERE eventdate = '$sql_currentday';";
    //echo $eventQuery;
    $eventExec = mysql_query($eventQuery);
    while($row = mysql_fetch_array($eventExec)) {
      if (mysql_num_rows($eventExec) == 1) {
echo "<td onClick=\"window.location='" .$_SERVER['PHP_SELF']. "?servicio=$aula&year=$year&today=$zz&month=$month';\" style='background-color:#f89406;color:#fff;cursor:pointer;'>$zz</td>";
        $result_found = 1;
      }
    }
  }

  if ($result_found != 1) {
    echo "<td onClick=\"window.location='" .$_SERVER['PHP_SELF']. "?servicio=$aula&year=$year&today=$zz&month=$month';\" style='cursor:pointer;'><a href='".$_SERVER['PHP_SELF']."?servicio=$aula&year=$year&today=$zz&month=$month'>$zz</a></td>";
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
