<?
session_start();
include("../../config.php");
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

// Estructura de la Tabla
?>

<div class="container">

	<div class="page-header">
	  <h2>Reservas <small> Reserva del <?php echo $servicio; ?></small></h2>
	</div>

	<?php if (isset($_GET['mens'])): ?>
	<?php if ($_GET['mens'] == 'actualizar'): ?>
		<div class="alert alert-success">
			La reserva se ha actualizado correctamente.
	  </div>
	<?php elseif ($_GET['mens'] == 'insertar'): ?>
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
	echo "<th><h4><a href=\"".$_SERVER['PHP_SELF']."?servicio=$servicio&year=".$ano_ant."&month=".$mes_ant."\"><span class=\"fa fa-arrow-circle-left fa-fw fa-lg\"></span></a></h4></th>";
	echo "<th colspan=\"5\"><h4>".$monthlong.' '.$year."</h4></th>";
	echo "<th><h4><a href=\"".$_SERVER['PHP_SELF']."?servicio=$servicio&year=".$ano_sig."&month=".$mes_sig."\"><span class=\"fa fa-arrow-circle-right fa-fw fa-lg\"></span></a></h4></th>";
	echo "</tr></thead><tbody><tr>";
	
	
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
	  
	  // Enlace
	  $enlace = $_SERVER['PHP_SELF'].'?year='.$year.'&today='.$zz.'&month='.$month.'&servicio='.$servicio;
	  
	  // Mirar a ver si hay alguna ctividad en el dÃ­as
	  $result_found = 0;
	  if ($zz == $today) { 
	    echo '<td class="calendar-today"><a href="'.$enlace.'">'.$zz.'</a></td>';
	    $result_found = 1;
	  }
	  
	  // Enlace
	  $enlace = $_SERVER['PHP_SELF'].'?year='.$year.'&today='.$zz.'&month='.$month.'&servicio='.$servicio;
	  
	  if ($result_found != 1) { 
			//Buscar actividad para el dóa y marcarla
			$sql_currentday = "$year-$month-$zz";
	
	    $eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7 FROM `$servicio` WHERE eventdate = '$sql_currentday';";
					$eventExec = mysql_query ( $eventQuery );
			if (mysql_num_rows($eventExec)>0) {
				while ( $row = mysql_fetch_array ( $eventExec ) ) {
	        echo '<td class="calendar-orange"><a href="'.$enlace.'">'.$zz.'</a></td>';				
					$result_found = 1;
				}
			}	
			else{
			$sql_currentday = "$year-$month-$zz";
			$fest = mysql_query("select distinct fecha, nombre from $db.festivos WHERE fecha = '$sql_currentday'");
			if (mysql_num_rows($fest)>0) {
			$festiv=mysql_fetch_array($fest);
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
  echo "<form method=\"post\" action=\"jcal_post.php?servicio=$servicio&year=$year&today=$today&month=$month\" name=\"jcal_post\">";
	echo "<legend>Reserva para el $daylong, $today de $monthlong</legend><br />";	
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

if($_SESSION['profi'] == 'conserje' or stristr($_SESSION['cargo'],'1') == TRUE){$SQL = "select distinct nombre from $db.departamentos order by nombre";}
else{$SQL = "select distinct nombre from $db.departamentos where nombre = '". $_SESSION['profi'] ."'";}

if($servicio){
$eventQuery2 = "SELECT hora1 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_numrows($reservado0) == 1) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>1ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event1)) { echo "<label>1ª hora</label> &nbsp;&nbsp; <select name=\"day_event1\" class=\"form-control\"><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event1)) {echo "<label>1ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input class=\"form-control\" type=\"text\" name=\"day_event1\"  value=\"$event_event1\"></div>";
	 } 
	else{
		echo "<label>1ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event1'></div><input type=\"hidden\" value=\"$event_event1\" name=\"day_event1\">"; }
	}
	}	
	echo '</div>';
		
	
if($servicio){$eventQuery2 = "SELECT hora2 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_num_rows($reservado0)>0) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "<label>2ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
		echo '<div class="form-group">';
if (empty($event_event2)) { echo "<label>2ª hora</label> &nbsp;&nbsp; <select name=\"day_event2\" class='form-control'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event2)) {echo "2 Hora &nbsp;&nbsp; <div class=\"form-group\"><input class=\"form-control\" type=\"text\" name=\"day_event2\"  value=\"$event_event2\"></div>"; } 
	else{echo "<label>2ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event2'></div><input type=\"hidden\" value=\"$event_event2\" name=\"day_event2\">"; }}	}	
	echo '</div>';
		
	
if($servicio){$eventQuery2 = "SELECT hora3 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_num_rows($reservado0)>0) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "<label>3ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
		echo '<div class="form-group">';
if(empty($event_event3)) { echo "<label>3ª hora</label> &nbsp;&nbsp; <select name=\"day_event3\" class='form-control'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
		
	if(mb_strtolower($pr) == mb_strtolower($event_event3)) {echo "<label>3ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input class=\"form-control\" type=\"text\" name=\"day_event3\"  value=\"$event_event3\"></div>"; } 
	else{echo "<label>3ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event3'></div><input type=\"hidden\" value=\"$event_event3\" name=\"day_event3\">"; }}	}	
	echo '</div>';
		
	
if($servicio){$eventQuery2 = "SELECT hora4 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_num_rows($reservado0)>0) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "<label>4ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
		echo '<div class="form-group">';
if (empty($event_event4)) { echo "<label>4ª hora</label> &nbsp;&nbsp; <select name=\"day_event4\" class='form-control'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event4)) {echo "<label>4ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input class=\"form-control\" type=\"text\" name=\"day_event4\"  value=\"$event_event4\"></div>"; } 
	else{echo "<label>4ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event4'></div><input type=\"hidden\" value=\"$event_event4\" name=\"day_event4\">"; } }	}	
	echo '</div>';
		
	
if($servicio){$eventQuery2 = "SELECT hora5 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_num_rows($reservado0)>0) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "5 Hora &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
		echo '<div class="form-group">';
if (empty($event_event5)) { echo "<label>5ª hora</label> &nbsp;&nbsp; <select name=\"day_event5\" class='form-control'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event5)) {echo "<label>5ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input class=\"form-control\" type=\"text\" name=\"day_event5\"  value=\"$event_event5\"></div>"; } 
	else{echo "5Âª Hora &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event5'></div><input type=\"hidden\" value=\"$event_event5\" name=\"day_event5\">"; }}	}	
	echo '</div>';
		
	
if($servicio){$eventQuery2 = "SELECT hora6 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_num_rows($reservado0)>0) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>6ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event6)) { echo "<label>6ª hora</label> &nbsp;&nbsp; <select name=\"day_event6\" class='form-control'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event6)) {echo "<label>6ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input class=\"form-control\" type=\"text\" name=\"day_event6\"  value=\"$event_event6\"></div>"; } 
	else{echo "<label>6ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event6'></div><input type=\"hidden\" value=\"$event_event6\" name=\"day_event6\">"; } }	}	
	echo '</div>';
		
	
if($servicio){$eventQuery2 = "SELECT hora7 FROM ".$servicio."hor WHERE dia = '$numero_dia'";
$reservado0 = mysql_query($eventQuery2);
if (mysql_num_rows($reservado0)>0) {
$reservado1 = mysql_fetch_row($reservado0);
}
}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>7ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event7)) { echo "<label>7ª hora</label> &nbsp;&nbsp; <select name=\"day_event7\" class='form-control'><option></option>";
	$result1 = mysql_query($SQL);
	while($row1 = mysql_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";} 
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event7)) {echo "<label>7ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input class=\"form-control\" type=\"text\" name=\"day_event7\"  value=\"$event_event7\"></div>"; } 
	else{echo "<label>7ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value=\"$event_event7\"></div><input type=\"hidden\" value=\"$event_event7\" name=\"day_event7\">"; }}
	}
	echo '</div>';


echo "<input type=\"hidden\" value=\"$year\" name=\"year\">
      <input type=\"hidden\" value=\"$month\" name=\"month\">
      <input type=\"hidden\" value=\"$today\" name=\"today\">
      <input type=\"submit\" class=\"btn btn-primary\" id=\"formsubmit\" value=\"Reservar\">
    </form>";
echo "</div>";
?>
</div>
</div>
</div>

<?
include("../../pie.php");
?>
</body>
</html>
