<?
session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?
include("../menu.php");
?>
<?
include("menu.php");
?>
<?
if($recurso=="carrito"){$num=$num_carrito+1;$nombre_rec="Carritos de Portátiles";}elseif($recurso=="aula"){$num=$num_aula+1;$nombre_rec="Aulas compartidas";}elseif($recurso=="medio"){$num=$num_medio+1;$nombre_rec="Medios Audiovisuales";}
?>
<div align="center">
<div class="page-header" align="center">
  <h2>Reserva de Medios <small> <? echo $nombre_rec; ?></small></h2>
</div>
<br />
<?php
if ($recurso=="aula") {
 		echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <legend>Atención:</legend>
            Esta sección esta en vías de desaparición. El espacio preferido para reservar las Aulas y dependencias varias del Centro es la opción <em><b>Aulas de Grupo</b></em>, que puedes encontrar en el menú de las reservas más arriba.<br />Las Aulas de Grupo suponen que las aulas han sido registradas con su nombre en el Horario generado por la apilación Horwin. Busca el aula entre las Aulas de Grupo y procede con la reserva.
          </div></div>';
 } 
$conn = mysql_connect($db_host, $db_user, $db_pass) or die("Error en la conexión con la Base de Datos!");
mysql_select_db($db_reservas, $conn);

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
?>
 <div class="container-fluid">  
       
        
<?
for($ci=1;$ci<$num;$ci++){

	// Lugares y situación
	$servicio = $recurso.$ci;
	$lugar = ${$servicio};	
if ($ci==1 or $ci==4 or $ci==7 or $ci==10){echo '<div class="row-fluid">';}
echo '<div class="span4" style="overflow:auto;">';
echo '<a name=';
echo $servicio;
echo '></a>';

echo "<table class='table table-striped table-condensed table-bordered' style=''><thead>";
echo "<tr><th colspan='7' style='text-align:center'><h3 style='color:#9d261d'>$servicio</h3><h4>( $lugar )</h4></th></tr>
<tr><th colspan='7'><center><p class='lead text-info'>" 
. $monthlong . "</p></th>";
echo "</center></tr><tr>";
//Nombres de Días
foreach ( $alldays as $value ) {
	echo "<th>
  <span class='badge badge-info'>$value</span></th>";
}
echo "</tr></thead><tr>";

//Días en blanco
for($i = 0; $i < $dayone; $i ++) {
	echo "<td>&nbsp;</td>\n";
}

//Días
for ($zz = 1; $zz <= $numdays; $zz++) {
  if ($i >= 7) {  print("</tr><tr>"); $i=0; }
  // Mirar a ver si hay alguna ctividad en el días
  $result_found = 0;
  if ($zz == $today) { 
    echo "<td valign=\"middle\" align=\"center\" style='background-color:#0072E6;color:#fff'>$zz</td>\n";
		$result_found = 1;
  }
  
  
  if ($result_found != 1) { 
		//Buscar actividad para el dóa y marcarla
		$sql_currentday = "$year-$month-$zz";
    	$eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7 FROM $servicio WHERE eventdate = '$sql_currentday';";
		$eventExec = mysql_query ( $eventQuery );
		if (mysql_num_rows($eventExec)>0) {
			while ( $row = mysql_fetch_array ( $eventExec ) ) {
echo "<td valign=\"middle\" align=\"center\" style='background-color:#f89406;color:#fff'>$zz</td>\n";
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
  
  
/*  if ($result_found != 1) {
  	//Buscar actividad  y marcarla.
    $sql_currentday = "$year-$month-$zz";
    $eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7 FROM $servicio WHERE eventdate = '$sql_currentday';";
    //echo $eventQuery;
    $eventExec = mysql_query($eventQuery);
    if (mysql_num_rows($eventExec)==1) {
     while($row = mysql_fetch_array($eventExec)) {
echo "<td valign=\"middle\" align=\"center\" style='background-color:#f89406;color:#fff'>$zz</td>\n";
        $result_found = 1;
    }
    }
   
  }*/
  if ($result_found != 1) {//Celda por defecto
   echo "<td>$zz</td>\n";
  }

  $i++; $result_found = 0;
}

$create_emptys = 7 - (($dayone + $numdays) % 7);
if ($create_emptys == 7) { $create_emptys = 0; }

//Celdas en blanco 
if ($create_emptys != 0) {
	echo "<td class=\"cellbg\"></td>\n";
}

echo "</tr>";
echo "</table>";

//Semana
	echo "<div class='well' align='left' style=''><legend class='text-success'>Próximos días</legend>";

for ($i = $today; $i <= ($today + 6); $i++) {
  $current_day = $i;
  $current_year = $year;
  $current_month = $month;
  if ($i > $numdays) {
    $current_day = ($i - $numdays);
    $current_month = $month + 1;
    if ($current_month > 12) {
      $current_month = 1; $current_year = $year + 1;
    }
  }
  $dayname = date("l",mktime(1,1,1,$current_month,$current_day,$current_year));
    if ($dayname == "Sunday")
	{$dayname = "Domingo";}
    elseif ($dayname == "Monday")
	{$dayname = "Lunes";}
    elseif ($dayname == "Tuesday")
	{$dayname = "Martes";}
    elseif ($dayname == "Wednesday")
	{$dayname = "Miércoles";}
    elseif ($dayname == "Thursday")
	{$dayname = "Jueves";}
    elseif ($dayname == "Friday")
	{$dayname = "Viernes";}
    elseif ($dayname == "Saturday")
	{$dayname = "Sábado";}
    
    $sql_currentday = "$current_year-$current_month-$current_day";
    $eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7 FROM $servicio WHERE eventdate = '$sql_currentday';";
    $eventExec = mysql_query($eventQuery);
    if (mysql_num_rows($eventExec)==1) {
    while($row = mysql_fetch_array($eventExec)) {
        // $this_days_title = stripslashes($row["title"]);
   $event_event1 = stripslashes($row["event1"]);
   $event_event2 = stripslashes($row["event2"]);
   $event_event3 = stripslashes($row["event3"]);
   $event_event4 = stripslashes($row["event4"]);
   $event_event5 = stripslashes($row["event5"]);
   $event_event6 = stripslashes($row["event6"]);
   $event_event7 = stripslashes($row["event7"]);
    }
    }
	echo "<p><i  class='fa fa-calendar'></i>&nbsp;$dayname - $current_day. </p>
	 <a href=\"http://$dominio/intranet/reservas/jcal_admin/index.php
	?year=$current_year&today=$current_day&month=$current_month&servicio=$servicio\">";

  //Nombre del día
 if (mysql_num_rows($eventExec) == 1) 
 {
 	 if ($event_event1 !== "") { 
 	    echo "<p>1ª Hora -->   $event_event1</p>";
 	}
 	 	 if ($event_event2 !== "") { 
 	    echo "<p>2ª Hora -->  $event_event2</p>";
 	}
 	 	 if ($event_event3 !== "") { 
 	    echo "<p>3ª Hora --> $event_event3</p>";
 	}
 	 	 if ($event_event4 !== "") { 
 	    echo "<p>4ª Hora -->  $event_event4</p>";
 	}
 	 	 if ($event_event5 !== "") { 
 	    echo "<p>5ª Hora -->  $event_event5</p>";
 	}
 	 	 if ($event_event6 !== "") { 
 	    echo "<p>6ª Hora -->  $event_event6</p>";
 	}
 	 	 if ($event_event7 !== "") { 
 	    echo "<p>7ª Hora -->  $event_event7</p>";
 	}
 }

echo "</a></p>";

   //$this_days_title = "";
   $event_event1 = "";
   $event_event2 = "";
   $event_event3 = "";
   $event_event4 = "";
   $event_event5 = "";
   $event_event6 = "";
   $event_event7 = "";
}
echo "<br /><div align='center'><a href=\"http://$dominio/intranet/reservas/jcal_admin/index.php?servicio=$servicio\"><button  class='btn btn-block btn-primary'>Reservar...</button></a><br /></div>";
echo '</div>';
echo '</div>';
if ($ci==3 or $ci==6 or $ci==9 or $ci==12){echo '</div>';}
}

echo "</div>";
?>
<? include("../pie.php");?>  

</body>
</html>
