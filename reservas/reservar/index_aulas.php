<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


$pr = $_SESSION['profi'];   
?>
<?php
include("../../menu.php");
include("../menu.php");
mysqli_select_db($db_con, $db_reservas);

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
$numero_dia = $hoy['wday'];

$eventQuery = "SELECT id FROM `$db_reservas`.`$servicio` WHERE eventdate = '$sql_date';";
//echo $eventQuery;
$eventExec = mysqli_query($db_con, $eventQuery); 
$event_found = "";
while($row = mysqli_fetch_array($eventExec)) {
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
    $postExec = mysqli_query($db_con, $postQuery) or die("Could not Post UPDATE `$db_reservas`.`$servicio` Event to database!");
    mysqli_query($db_con, "DELETE FROM `$db_reservas`.`$servicio` WHERE event1 = '' and event2 = ''  and event3 = ''  and event4 = ''  and event5 = ''  and event6 = ''  and event7 = '' ");
$mens="actualizar";
} else {
  //INSERT   `reservas`.`A1B-C` (
    $postQuery = "INSERT INTO `$servicio` (eventdate,dia,event1,event2,event3,event4,event5,event6,event7,html) VALUES ('$sql_date','$numero_dia','".$_POST['day_event1']."','".$_POST['day_event2']."','".$_POST['day_event3']."','".$_POST['day_event4']."','".$_POST['day_event5']."','".$_POST['day_event6']."','".$_POST['day_event7']."','$show_html');";
	       // echo $postQuery;
    $postExec = mysqli_query($db_con, $postQuery) or die("Could not Post INSERT `$db_reservas`.`$servicio` Event to database!");
    
mysqli_query($db_con, "DELETE FROM `$db_reservas`.`$servicio` WHERE event1 = '' and event2 = ''  and event3 = ''  and event4 = ''  and event5 = ''  and event6 = ''  and event7 = '' ");
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
$dayone = date("w",mktime(1,1,1,$month,1,$year))-1;
$numdays = date("t",mktime(1,1,1,$month,1,$year));
$alldays = array('Lun','Mar','Mié','Jue','Vie','Sáb','Dom');
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
$reg = mysqli_query($db_con, "show tables from reservas");
while ($t_reg = mysqli_fetch_array($reg)){
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE latin1_spanish_ci ";
	//echo $sql_hor;
mysqli_query($db_con, $sql_hor);
}
// Estructura de la Tabla
?>

<div class="container">

	<div class="page-header">
	  <h2>Reservas <small> Reserva de <?php echo $servicio; ?></small></h2>
	</div>

	<?php if (isset($mens)): ?>
	<?php if ($mens == 'actualizar'): ?>
		<div class="alert alert-success">
			La reserva se ha actualizado correctamente.
	  </div>
	<?php elseif ($mens == 'insertar'): ?>
		<div class="alert alert-success">
			La reserva se ha realizado correctamente.
		</div>
	<?php endif; ?>
	<?php endif; ?>
	
 <div class="row">
 
 <div class="col-sm-5">
 <?
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
 
 //Nombre del Mes
 echo "<table class=\"table table-bordered table-centered\"><thead><tr>";
 echo "<th><h4><a href=\"".$_SERVER['PHP_SELF']."?servicio=$aula&year=".$ano_ant."&month=".$mes_ant."\"><span class=\"fa fa-arrow-circle-left fa-fw fa-lg\"></span></a></h4></th>";
 echo "<th colspan=\"5\"><h4>".$monthlong.' '.$year."</h4></th>";
 echo "<th><h4><a href=\"".$_SERVER['PHP_SELF']."?servicio=$aula&year=".$ano_sig."&month=".$mes_sig."\"><span class=\"fa fa-arrow-circle-right fa-fw fa-lg\"></span></a></h4></th>";
 echo "</tr><tr>";
 
 
 //Nombre de Días
 foreach($alldays as $value) {
   echo "<th>
   $value</th>";
 }
 echo "</tr></thead><tbody><tr>";
 
 
 //Dí­as vací­os
 if ($dayone < 0) $dayone = 6;
for ($i = 0; $i < $dayone; $i++) {
   echo "<td>&nbsp;</td>";
 }
 
 //DÃ­as
 for ($zz = 1; $zz <= $numdays; $zz++) {
   if ($i >= 7) {  print("</tr><tr>"); $i=0; }
   
   // Enlace
   $enlace = $_SERVER['PHP_SELF'].'?year='.$year.'&today='.$zz.'&month='.$month.'&servicio='.$aula;
   
   // Mirar a ver si hay alguna ctividad en el dÃ­as
   $result_found = 0;
   if ($zz == $today) { 
     echo '<td class="calendar-today"><a href="'.$enlace.'">'.$zz.'</a></td>';
     $result_found = 1;
   }
   
   // Enlace
   $enlace = $_SERVER['PHP_SELF'].'?year='.$year.'&today='.$zz.'&month='.$month.'&servicio='.$aula;
   
   if ($result_found != 1) { 
 		//Buscar actividad para el dóa y marcarla
 		$sql_currentday = "$year-$month-$zz";
 
     $eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7 FROM `$aula` WHERE eventdate = '$sql_currentday';";
 				$eventExec = mysqli_query($db_con, $eventQuery );
 		if (mysqli_num_rows($eventExec)>0) {
 			while ( $row = mysqli_fetch_array ( $eventExec ) ) {
         echo '<td class="calendar-orange"><a href="'.$enlace.'">'.$zz.'</a></td>';				
 				$result_found = 1;
 			}
 		}	
 		else{
 		$sql_currentday = "$year-$month-$zz";
 		$fest = mysqli_query($db_con, "select distinct fecha, nombre from $db.festivos WHERE fecha = '$sql_currentday'");
 		if (mysqli_num_rows($fest)>0) {
 		$festiv=mysqli_fetch_array($fest);
 			       echo '<td class="calendar-red">'.$zz.'</td>';
 				$result_found = 1;
 				}	
 		}
 		
 	}
 
   if ($result_found != 1) {
     echo '<td><a href="'.$enlace.'">'.$zz.'</a></td>';
   }
 
   $i++; $result_found = 0;
 }
 
 $create_emptys = 7 - (($dayone + $numdays) % 7);
 if ($create_emptys == 7) { $create_emptys = 0; }
 
 if ($create_emptys != 0) {
   echo "<td colspan=\"$create_emptys\">&nbsp;</td>";
 }
 
 echo "</tr></tbody>";
 echo "</table>";
 echo "";
 ?>
 </div>
 
		<div class="col-sm-7">
		
			<div class="well">
    <?
  echo "<form method=\"post\" action=\"index_aulas.php?servicio=$aula&year=$year&today=$today&month=$month\" name=\"jcal_post\">";
	echo "<legend>Reserva para el $daylong, $today de $monthlong</legend><br />";	
$sql_date = "$year-$month-$today";
$semana = date( mktime(0, 0, 0, $month, $today, $year));
$hoy = getdate($semana);
$numero_dia = $hoy['wday'];
$eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7, html FROM `$aula` WHERE eventdate = '$sql_date'";
$eventExec = mysqli_query($db_con, $eventQuery);
while($row = mysqli_fetch_array($eventExec)) {
   $event_event1 = stripslashes($row["event1"]);
   $event_event2 = stripslashes($row["event2"]);
   $event_event3 = stripslashes($row["event3"]);
   $event_event4 = stripslashes($row["event4"]);
   $event_event5 = stripslashes($row["event5"]);
   $event_event6 = stripslashes($row["event6"]);
   $event_event7 = stripslashes($row["event7"]);
}

if($_SESSION['profi'] == 'conserje' or stristr($_SESSION['cargo'],'1') == TRUE){$SQL = "select distinct nombre from $db.departamentos order by nombre";}
else{$SQL = "select distinct nombre from $db.departamentos where nombre = '". $_SESSION['profi'] ."'";}

if($aula){
$eventQuery22 = "SELECT hora1 FROM ".$aula."hor WHERE dia = '$numero_dia'";
$reservado00 = mysqli_query($db_con, $eventQuery22);
if (mysqli_num_rows($reservado00) == 1) {
$reservado11 = mysqli_fetch_row($reservado00);
}
}

if($aula){$eventQuery2 = "SELECT a_grupo FROM $db.horw WHERE dia = '$numero_dia' and hora='1' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
$reservado1 = mysqli_fetch_row($reservado0);}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0])) or !(empty($reservado11[0]))) {echo "<label>1ª hora</label> &nbsp;&nbsp; <p class=\"help-block\">Asignada por horario</p>"; }
	else
	{
if ($event_event1  == "") { echo "<label>1ª hora</label> &nbsp;&nbsp; <select name=\"day_event1\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event1)) {echo "<label>1ª hora</label> &nbsp;&nbsp; <input class='form-control' type='text' name=\"day_event1\"  value=\"$event_event1\">";
	 } 
	else{
		echo "<label>1ª hora</label> &nbsp;&nbsp; <input disabled class='form-control' type='text'  value='$event_event1'><input type=\"hidden\" value=\"$event_event1\" name=\"day_event1\">"; }
	}
	}
	echo '</div>';
		
if($aula){
$eventQuery22 = "SELECT hora2 FROM ".$aula."hor WHERE dia = '$numero_dia'";
$reservado00 = mysqli_query($db_con, $eventQuery22);
if (mysqli_num_rows($reservado00) == 1) {
$reservado11 = mysqli_fetch_row($reservado00);
}
}	
if($aula){$eventQuery2 = "SELECT a_grupo FROM $db.horw WHERE dia = '$numero_dia' and hora='2' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
$reservado1 = mysqli_fetch_row($reservado0);}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0])) or !(empty($reservado11[0]))) {echo "<label>2ª hora</label> &nbsp;&nbsp; <p class=\"help-block\">Asignada por horario</p>"; }
	else
	{
if ($event_event2  == "") { echo "<label>2ª hora</label> &nbsp;&nbsp; <select name=\"day_event2\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event2)) {echo "<label>2ª hora</label> &nbsp;&nbsp; <input class='form-control' type='text' name=\"day_event2\"  value=\"$event_event2\">"; } 
	else{echo "<label>2ª hora</label> &nbsp;&nbsp; <input disabled class='form-control' type='text'  value='$event_event2'><input type=\"hidden\" value=\"$event_event2\" name=\"day_event2\">"; }}	}
	echo '</div>';
		
if($aula){
$eventQuery22 = "SELECT hora3 FROM ".$aula."hor WHERE dia = '$numero_dia'";
$reservado00 = mysqli_query($db_con, $eventQuery22);
if (mysqli_num_rows($reservado00) == 1) {
$reservado11 = mysqli_fetch_row($reservado00);
}
}	
if($aula){$eventQuery2 = "SELECT a_grupo FROM $db.horw WHERE dia = '$numero_dia' and hora='3' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
$reservado1 = mysqli_fetch_row($reservado0);}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0])) or !(empty($reservado11[0]))) {echo "<label>3ª hora</label> &nbsp;&nbsp; <p class=\"help-block\">Asignada por horario</p>"; }
	else
	{
if(($event_event3 == "")) { echo "<label>3ª hora</label> &nbsp;&nbsp; <select name=\"day_event3\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event3)) {echo "<label>3ª hora</label> &nbsp;&nbsp; <input class='form-control' type='text' name=\"day_event3\"  value=\"$event_event3\">"; } 
	else{echo "<label>3ª hora</label> &nbsp;&nbsp; <input disabled class='form-control' type='text'  value='$event_event3'><input type=\"hidden\" value=\"$event_event3\" name=\"day_event3\">"; }}	}	
	echo '</div>';
		
if($aula){
$eventQuery22 = "SELECT hora4 FROM ".$aula."hor WHERE dia = '$numero_dia'";
$reservado00 = mysqli_query($db_con, $eventQuery22);
if (mysqli_num_rows($reservado00) == 1) {
$reservado11 = mysqli_fetch_row($reservado00);
}
}	
if($aula){$eventQuery2 = "SELECT a_grupo FROM $db.horw WHERE dia = '$numero_dia' and hora='4' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
$reservado1 = mysqli_fetch_row($reservado0);}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0])) or !(empty($reservado11[0]))) {echo "<label>4ª hora</label> &nbsp;&nbsp; <p class=\"help-block\">Asignada por horario</p>"; }
	else
	{
if ($event_event4  == "") { echo "<label>4ª hora</label> &nbsp;&nbsp; <select name=\"day_event4\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event4)) {echo "<label>4ª hora</label> &nbsp;&nbsp; <input class='form-control' type='text' name=\"day_event4\"  value=\"$event_event4\">"; } 
	else{echo "<label>4ª hora</label> &nbsp;&nbsp; <input disabled class='form-control' type='text'  value='$event_event4'><input type=\"hidden\" value=\"$event_event4\" name=\"day_event4\">"; } }	}	
	echo '</div>';
		
if($aula){
$eventQuery22 = "SELECT hora5 FROM ".$aula."hor WHERE dia = '$numero_dia'";
$reservado00 = mysqli_query($db_con, $eventQuery22);
if (mysqli_num_rows($reservado00) == 1) {
$reservado11 = mysqli_fetch_row($reservado00);
}
}	
if($aula){$eventQuery2 = "SELECT a_grupo FROM $db.horw WHERE dia = '$numero_dia' and hora='5' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
$reservado1 = mysqli_fetch_row($reservado0);}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0])) or !(empty($reservado11[0]))) {echo "<label>5ª hora</label> &nbsp;&nbsp; <p class=\"help-block\">Asignada por horario</p>"; }
	else
	{
if ($event_event5  == "") { echo "<label>5ª hora</label> &nbsp;&nbsp; <select name=\"day_event5\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event5)) {echo "<label>5ª hora</label> &nbsp;&nbsp; <input class='form-control' type='text' name=\"day_event5\"  value=\"$event_event5\">"; } 
	else{echo "<label>5ª hora</label> &nbsp;&nbsp; <input disabled class='form-control' type='text'  value='$event_event5'><input type=\"hidden\" value=\"$event_event5\" name=\"day_event5\">"; }}	}	
	echo '</div>';
		
if($aula){
$eventQuery22 = "SELECT hora6 FROM ".$aula."hor WHERE dia = '$numero_dia'";
$reservado00 = mysqli_query($db_con, $eventQuery22);
if (mysqli_num_rows($reservado00) == 1) {
$reservado11 = mysqli_fetch_row($reservado00);
}
}	
if($aula){$eventQuery2 = "SELECT a_grupo FROM $db.horw WHERE dia = '$numero_dia' and hora='6' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
$reservado1 = mysqli_fetch_row($reservado0);}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0])) or !(empty($reservado11[0]))) {echo "<label>6ª hora</label> &nbsp;&nbsp; <p class=\"help-block\">Asignada por horario</p>"; }
	else
	{
if ($event_event6  == "") { echo "<label>6ª hora</label> &nbsp;&nbsp; <select name=\"day_event6\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event6)) {echo "<label>6ª hora</label> &nbsp;&nbsp; <input class='form-control' type='text' name=\"day_event6\"  value=\"$event_event6\">"; } 
	else{echo "<label>6ª hora</label> &nbsp;&nbsp; <input disabled class='form-control' type='text'  value='$event_event6'><input type=\"hidden\" value=\"$event_event6\" name=\"day_event6\">"; } }	}	
	echo '</div>';
		
	
if($aula){$eventQuery2 = "SELECT a_grupo FROM $db.horw WHERE dia = '$numero_dia' and hora='7' and a_aula = '$aula' and a_grupo is not null and a_grupo not like 'G%'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
$reservado1 = mysqli_fetch_row($reservado0);}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>7ª hora</label> &nbsp;&nbsp; <p class=\"help-block\">Asignada por horario</p>"; }
	else
	{
if ($event_event7  == "") { echo "<label>7ª hora</label> &nbsp;&nbsp; <select name=\"day_event7\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option  >" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event7)) {echo "<label>7ª hora</label> &nbsp;&nbsp; <input class='form-control' type='text' name=\"day_event7\"  value=\"$event_event7\">"; } 
	else{echo "<label>7ª hora</label> &nbsp;&nbsp; <input disabled class='form-control' type='text'  value='$event_event7'><input type=\"hidden\" value=\"$event_event7\" name=\"day_event7\">"; }}
	echo '</div>';
	}


echo "<input type=\"hidden\" value=\"$year\" name=\"year\">
      <input type=\"hidden\" value=\"$month\" name=\"month\">
      <input type=\"hidden\" value=\"$today\" name=\"today\">
      <input type=\"submit\" class=\"btn btn-primary\" id=\"formsubmit\" name=\"enviar\" value=\"Reservar\">
    </form>";
echo "</div>";
?>
</div>
</div>
</div>
</div>

<?
include("../../pie.php");
?>
</body>
</html>
