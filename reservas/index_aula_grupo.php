<?php
	//header("location:#$servico_aula");

session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);



if($_GET['recurso'] == "aula_grupo"){
	$naulas = $num_aula_grupo+1;
	$nombre_rec = "Aulas de grupo";
}

include("../menu.php");
include("menu.php");
?>
<div class="container">

	<div class="page-header">
	  <h2>Reserva de medios <small><?php echo $nombre_rec; ?></small></h2>
	</div>
	
	<div class="row">
	
		<div class="col-sm-4 col-sm-offset-4">
			
			<div class="well">
				<form method="post" action="jcal_admin/index_aulas.php">
					<fieldset>
						<legend>Selecciona el aula</legend>
						
						<div class="form-group">
							<?php $result = mysql_query("SELECT DISTINCT a_aula, n_aula FROM horw WHERE a_aula NOT LIKE 'G%' AND a_aula NOT LIKE '' AND n_aula NOT LIKE 'audi%' AND a_aula NOT LIKE 'dir%' ORDER BY n_aula ASC"); ?>
							<?php if(mysql_num_rows($result)): ?>
							<select class="form-control" name="servicio_aula" onchange="submit()">
								<option value=""></option>
								<?php while ($row = mysql_fetch_array($result)):?>
								<?php $value = $row['a_aula'].' ==> '.$row['n_aula']; ?>
								<option value="<?php echo $value; ?>"><?php echo $row['n_aula']; ?></option>
								<?php endwhile; ?>
							</select>
							<?php else: ?>
							<select class="form-control" name="servicio_aula" disabled>
								<option></option>
							</select>
							<?php endif; ?>
						</div>
						
					</fieldset>
				</form>
			</div>
			
		</div>
		
	</div>
	
<?php
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
$alldays = array('D','L','M','X','J','V','S');
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

// Lugares y situación
$a1=mysql_query("select distinct a_aula, n_aula from $db.horw where a_aula not like 'G%' and a_aula not like '' and a_aula not like 'DIR%' order by a_aula");

$num_aula_grupo=mysql_num_rows($a1);
$ci = 0;
$primero = 0;
while($au_grupo = mysql_fetch_array($a1)){
	$servicio=$au_grupo[0];
	$lugar = $au_grupo[1];	
	
	
if ($ci % 3 == 0 || $ci == 0){
	echo ($primero) ? '</div> <hr>' : '';
	echo '<div class="row">';
	$primero = 1;
}					
					
echo '<div class="col-sm-4">';
?>
	<a name="<?php echo $servicio; ?>"></a>
	<h3 class="text-center"><?php echo $lugar; ?> <br><small><?php echo $servicio; ?></small></h3>
	
	<table class="table table-bordered table-centered">
		<thead>
			<tr>
				<th colspan="7"><h4><?php echo $monthlong; ?></h4></th>
			</tr>
			<tr>
				<?php foreach ($alldays as $value): ?>
				<th><?php echo $value; ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
<?
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
    echo "<td class=\"calendar-today\">$zz</td>";
    $result_found = 1;
  }
  
  if ($result_found != 1) { 
		//Buscar actividad para el día y marcarla
		$sql_currentday = "$year-$month-$zz";
    	$eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7 FROM $servicio WHERE eventdate = '$sql_currentday';";
 		$eventExec = mysql_query ( $eventQuery );
		if (mysql_num_rows($eventExec)>0) {
			while ( $row = mysql_fetch_array ( $eventExec ) ) {
echo "<td class=\"calendar-orange\">$zz</td>";
$result_found = 1;
		}	
		}
		else{
		$sql_currentday = "$year-$month-$zz";
		$fest = mysql_query("select distinct fecha, nombre from $db.festivos WHERE fecha = '$sql_currentday'");
		if (mysql_num_rows($fest)>0) {
		$festiv=mysql_fetch_array($fest);
			        echo "<td class=\"calendar-red\">$zz</a></td>\n";
				$result_found = 1;
				}	
		}
		
	}

  if ($result_found != 1) {
    echo "<td>$zz</td>";
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
	<div class="well">
		<h4 class="text-info">Próximos días</h4>
<?
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
    while($row = mysql_fetch_array($eventExec)) {
   if (mysql_num_rows($eventExec) == 1) {
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
    
	echo '<p><span class="fa fa-calendar-o fa-fw"></span> '.$dayname.' - '.$current_day.'</p>';
	echo '<a href="http://'.$dominio.'/intranet/reservas/jcal_admin/index_aulas.php?year='.$current_year.'&today='.$current_day.'&month='.$current_month.'&servicio='.$servicio.'">';

  //Nombre del día
 if (mysql_num_rows($eventExec) == 1) 
 {
 	 if ($event_event1 !== "") { 
 	    echo "<p>1ª hora: $event_event1</p>";
 	}
 	 	 if ($event_event2 !== "") { 
 	    echo "<p>2ª hora: $event_event2</p>";
 	}
 	 	 if ($event_event3 !== "") { 
 	    echo "<p>3ª hora: $event_event3</p>";
 	}
 	 	 if ($event_event4 !== "") { 
 	    echo "<p>4ª hora: $event_event4</p>";
 	}
 	 	 if ($event_event5 !== "") { 
 	    echo "<p>5ª hora: $event_event5</p>";
 	}
 	 	 if ($event_event6 !== "") { 
 	    echo "<p>6ª hora: $event_event6</p>";
 	}
 	 	 if ($event_event7 !== "") { 
 	    echo "<p>7ª hora: $event_event7</p>";
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
echo '<br>';
echo '<a class="btn btn-primary btn-block" href="http://'.$dominio.'/intranet/reservas/jcal_admin/index_aulas.php?servicio='.$servicio.'">Reservar...</a>';
echo '</div>';
echo '</div>';

$ci+=1;
}		
echo '</div>';
?>

</div>

<? include("../pie.php");?>  

</body>
</html>
