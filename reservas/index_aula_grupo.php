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
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?
include("../menu.php");
?>
<?
include("menu.php");
?>
<?
if($recurso=="aula_grupo"){$num=$num_aula_grupo+1;$nombre_rec="Aulas de Grupo";}
?>
<div align="center">
<div class="page-header" align="center">
  <h2>Reserva de Medios <small> <? echo $nombre_rec; ?></small></h2>
</div>
<br />
 
<form action="jcal_admin/index_aulas.php" method="post" class="well well-large" style="width:400px; margin:auto;" name = "form_aula">
<legend>Selecciona el aula</legend>
  <SELECT  name=servicio_aula onChange="submit()" class="input-xlarge">
    <option><? echo $servicio_aula;?></option>
    <?
  $profe = mysql_query(" SELECT DISTINCT a_aula, n_aula FROM horw where a_aula not like 'G%' and a_aula not like ''  and n_aula not like 'audi%' and a_aula not like 'dir%' ORDER BY a_aula ASC");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0] ==> $filaprofe[1]</OPTION>");
	      echo "$opcion1";

	} while($filaprofe = mysql_fetch_array($profe));
        }
	?>
  </select>
</FORM>
<br />
</div>
<?php
 
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
// Lugares y situación
$a1=mysql_query("select distinct a_aula, n_aula from horw where a_aula not like 'G%' and a_aula not like '' and n_aula not like 'audi%' and a_aula not like 'DIR%' order by a_aula");

$num_aula_grupo=mysql_num_rows($a1);
while($au_grupo = mysql_fetch_array($a1)){
	$servicio=$au_grupo[0];
	$lugar = $au_grupo[1];	
	$ci+=1;
	
if ($ci==1 or $ci==4 or $ci==7 or $ci==10 or $ci==13 or $ci==16 or $ci==19 or $ci==22 or $ci==25 or $ci==28 or $ci==31 or $ci==34 or $ci==37 or $ci==40 or $ci==43 or $ci==46 or $ci==49 or $ci==52 or $ci==55 or $ci==58 or $ci==61 or $ci==64 or $ci==67){echo '<div class="row-fluid">';}					
					
echo '<div class="span4" style="overflow:auto;">';
echo '<a name=';
echo $servicio;
echo '></a>';

echo "<table class='table table-striped table-condensed table-bordered' style=''><thead>";
echo "<tr><th colspan='7' style='text-align:center'><h3 style='color:#9d261d'>$servicio</h3><h6>( $lugar )</h6></th></tr>
<tr><th colspan='7'><center><h4>" 
. $monthlong . "</h4></th>";
echo "</center></tr><tr>";
//Nombres de Días
foreach ( $alldays as $value ) {
	echo "<th>
  <span class='badge'>$value</span></th>";
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
    echo "<td valign=\"middle\" align=\"center\" style='background-color:#46a546;color:#fff'>$zz</td>\n";
		$result_found = 1;
  }
  if ($result_found != 1) {//Buscar actividad  y marcarla.
    $sql_currentday = "$year-$month-$zz";
    $eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7 FROM $servicio WHERE eventdate = '$sql_currentday';";
    //echo $eventQuery;
    $eventExec = mysql_query($eventQuery);
    while($row = mysql_fetch_array($eventExec)) {
      if (mysql_num_rows($eventExec) == 1) {
echo "<td valign=\"middle\" align=\"center\" style='background-color:#f89406;color:#fff'>$zz</td>\n";
        $result_found = 1;
      }
    }
  }
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
	echo "<div class='well' align='left' style=''><h4>Próximos días</h4><hr>";

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
    $eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7 FROM `$servicio` WHERE eventdate = '$sql_currentday';";
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
	echo "<p><i  class='icon-calendar'></i>&nbsp;$dayname - $current_day. </p>
	 <a href=\"http://$dominio/intranet/reservas/jcal_admin/index_aulas.php
	?year=$current_year&today=$current_day&month=$current_month&servicio=$servicio\">";

  //Nombre del día
 if (mysql_num_rows($eventExec) == 1) 
 {
 	 if ($event_event1 !== "") { 
 	    echo "<p>1 Hora -->   $event_event1</p>";
 	}
 	 	 if ($event_event2 !== "") { 
 	    echo "<p>2 Hora -->  $event_event2</p>";
 	}
 	 	 if ($event_event3 !== "") { 
 	    echo "<p>3 Hora --> $event_event3</p>";
 	}
 	 	 if ($event_event4 !== "") { 
 	    echo "<p>4 Hora -->  $event_event4</p>";
 	}
 	 	 if ($event_event5 !== "") { 
 	    echo "<p>5 Hora -->  $event_event5</p>";
 	}
 	 	 if ($event_event6 !== "") { 
 	    echo "<p>6 Hora -->  $event_event6</p>";
 	}
 	 	 if ($event_event7 !== "") { 
 	    echo "<p>7 Hora -->  $event_event7</p>";
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
echo "<br /><div align='center'><a href=\"http://$dominio/intranet/reservas/jcal_admin/index_aulas.php?servicio=$servicio\"><button  class='btn btn-primary'>Reservar...</button></a><br /></div>";
echo '</div>';
echo '<hr></div>';
if ($ci==3 or $ci==6 or $ci==9 or $ci==12 or $ci==15 or $ci==18 or $ci==21 or $ci==24 or $ci==27 or $ci==30 or $ci==33 or $ci==36 or $ci==39 or $ci==42 or $ci==45 or $ci==48 or $ci==51 or $ci==54 or $ci==57 or $ci==60 or $ci==63 or $ci==66 or $ci==69){echo '</div>';}
}
echo '</div>';
echo '</div>';
?>
<? include("../pie.php");?>  

</body>
</html>
