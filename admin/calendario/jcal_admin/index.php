<?
session_start();
include("../../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

$profesor = $_SESSION['profi'];
$cargo = $_SESSION['cargo'];
?>
<?php
include("../../../menu.php");
?>
<br />
  <div class="page-header" align="center">
  <h2>Calendario de actividades <small> Crear o editar registros</small></h2>
</div>
<br />
<?
$conn = mysql_connect($db_host, $db_user, $db_pass) or die("Could not connect to database!");
mysql_select_db($db, $conn);

/*$event_title="";
$event_event="";
$hor="";
$n_act0="";
$id_act="";
$idact="";
$del="";
$mens="";*/
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


// Estructura de la Tabla
?>
<?
if (isset($_GET['mens'])) {
$mes = $_GET['mens'];
if($mens==1){ 
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad ha sido actualizada correctamente.
          </div></div><br />';
}
if($mens==2){
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad ha sido actualizada correctamente.
          </div></div><br />';}
if($mens==3){
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad ha sido borrada correctamente.
          </div></div><br />';}
}

?>
<div class="row-fluid">
 <div class="span2"></div>
<div class="span4">
<div class="well well-large">
<?
echo "<h3>$daylong, $monthlong $today, $year</h3><hr />";


$sql_date = "$year-$month-$today";
$eventQuery = "SELECT title, event, idact FROM cal WHERE eventdate = '$sql_date'";
$eventExec = mysql_query($eventQuery);
if (mysql_num_rows($eventExec)>0) {
while($row = mysql_fetch_array($eventExec)) {
   $event_title = $row[0];
   $title = $row[0];
   $event_event = $row[1];
   $idact = $row[2];
}	
}
else{
$fest = mysql_query("select distinct nombre from festivos WHERE fecha = '$sql_date'");
		if (mysql_num_rows($fest)>0) {
		$festiv=mysql_fetch_array($fest);
		$event_title = "Festivo: ".$festiv[0];
				}
}


/*$sql_date = "$year-$month-$today";
$eventQuery = "SELECT title, event, idact FROM cal WHERE eventdate = '$sql_date'";
$eventExec = mysql_query($eventQuery);
while($row = mysql_fetch_array($eventExec)) {
   $event_title = $row[0];
   $title = $row[0];
   $event_event = $row[1];
   $idact = $row[2];
}
*/
echo "<form name='jcal_post' action='jcal_post.php?year=$year&today=$today&month=$month' method='post'>";
echo "<div align='left'>";
		  $tr0 = explode("<br>",$event_title);
		  $n_act="";
		  $actividad0="";
		  foreach($tr0 as $val0){
			$n_act = $n_act + 1;
		  	$actividad0.= $val0."<br>";
		}
		  echo "<p class='lead text-warning'>Actividades del día</p>";
		  if(stristr($cargo,'1') == TRUE or stristr($cargo,'8') == TRUE or stristr($cargo,'5') == TRUE){echo "<textarea name='day_title' rows='6' cols='45' class='span12'>$event_title</textarea>";}else{echo "<p>$actividad0</p>";}
		  echo "<hr />";
      echo "<p class='lead text-warning'>Información sobre las actividades</p>";
	  if(stristr($cargo,'1') == TRUE or stristr($cargo,'8') == TRUE or stristr($cargo,'5') == TRUE){echo "<textarea name='day_event' cols='45' rows='8' class='span12'>$event_event</textarea>";}else{echo "<p>$event_event</p>";}
	  echo "<hr />";

      echo "<input type='hidden' value='$year' name='year'>
      <input type='hidden' value='$month' name='month'>
      <input type='hidden' value='$today' name='today'>";
	  
	  
	  if(strlen($idact) > "0"){
	  	
	  	$n_act="";
		  $idact = (substr($idact,0,strlen($idact)-1));
		  $tr = explode(";",$idact);
		  foreach($tr as $val){$id_act.= "'".$val."',";}
		  $id_act = (substr($id_act,0,strlen($id_act)-1));	
	  	  $act0 = mysql_query("select horario, id, actividad from actividades where id in ($id_act)");
		  while($act = mysql_fetch_row($act0)){
			  	$n_act0 = $n_act0 + 1;
		  		$hor.= "".$act[2]." ==> ".$act[0]."";
		  }		
echo "<p class='lead text-warning'>Horario de las actividades</p>
<textarea class='input span12' disabled />$hor</textarea>";
	  echo "<hr />";	  
		}	  
	  if(stristr($cargo,'1') == TRUE or stristr($cargo,'8') == TRUE or stristr($cargo,'5')== TRUE ){echo "<input type='submit' name='actualizar' value='Introducir datos' class='btn btn-primary'>";}
	  if(stristr($cargo,'1') == TRUE or stristr($cargo,'5') == TRUE){echo "<input type='submit' name='del' value='Borrar registro'  class='btn btn-danger' style='margin-left:40px;'>";}
	  echo "</form></div>";
?>
</div>
</div>
<div class="span4 pull-left">

<?             
	echo "<table class='table table-bordered table-striped' style='width:400px;margin:auto'><tr><th>
<div align='center'>
	<a href='".$_SERVER['PHP_SELF']."?year=$last_year&today=$today&month=$month'>
<i class='fa fa-arrow-o-left' name='calb2' style='margin-right:20px;'> </i> </a>
<h3 style='display:inline'>$year</h3>
<a href='".$_SERVER['PHP_SELF']."?year=$next_year&today=$today&month=$month'>
<i class='fa fa-arrow-o-right' name='calb1' style='margin-left:20px;'> </i> </a></div></th></tr></table><br />";

echo "<table class='table table-bordered' style='width:400px;' align='center'>
      <tr>";
	  $meses = array("1"=>"Ene", "2"=>"Feb", "3"=>"Mar", "4"=>"Abr", "5"=>"May", "6"=>"Jun", "7"=>"Jul", "8"=>"Ago", "9"=>"Sep", "10"=>"Oct", "11"=>"Nov", "12"=>"Dic");
	  foreach ($meses as $num_mes => $nombre_mes) {
	  	
	  	if ($num_mes==$month) {
	  		echo "<th  onClick=\"window.location='" .$_SERVER['PHP_SELF']. 
		"?year=$year&today=$today&month=1';\" style='background-color:#08c'> 
		<a href=\"".$_SERVER['PHP_SELF']."?year=$year&today=$today&month=".$num_mes."\" style='color:#efefef'>".$nombre_mes."</a> </th>";
	  	}
	  	else{
	  		echo "<th  onClick=\"window.location='" .$_SERVER['PHP_SELF']. 
		"?year=$year&today=$today&month=1';\" > 
		<a href=\"".$_SERVER['PHP_SELF']."?year=$year&today=$today&month=".$num_mes."\">".$nombre_mes."</a> </th>";
	  	}
	  if ($num_mes=='6') {
	  		echo "</tr><tr>";
	  	}
	  }
	  echo "</tr>
    </table>";

//Nombre del Mes
echo "<table class='table table-bordered' style='width:400px;margin:auto'><tr>";
echo "<td colspan=\"7\" valign=\"middle\" align=\"center\"><h6 align='center'>" . $monthlong . 
"</h6></td>";
echo "</tr><tr>";

//Nombre de Días
foreach($alldays as $value) {
  echo "<th style='background-color:#eee'>
  $value</th>\n";
}
echo "</tr>\n<tr>\n";

//Días vacíos
for ($i = 0; $i < $dayone; $i++) {
  echo "<td ></td>\n";
}


//Días
for ($zz = 1; $zz <= $numdays; $zz++) {
  if ($i >= 7) {  print("</tr>\n<tr>\n"); $i=0; }
  // Mirar a ver si hay alguna ctividad en el día
  $result_found = 0;
  if ($zz == $today) { 
    echo "<td valign='middle' style='background-color:#08c;cursor:pointer;' align='center' onClick='window.location='" 
	.$_SERVER['PHP_SELF']. "?year=$year&today=$zz&month=$month';'><a href='".$_SERVER['PHP_SELF'].
	"?year=$year&today=$zz&month=$month' style='color:#fff'>$zz</a></td>\n";
    $result_found = 1;
  }
  
  
	if ($result_found != 1) { 
		//Buscar actividad para el dóa y marcarla
		$sql_currentday = "$year-$month-$zz";

		$eventQuery = "SELECT title FROM cal WHERE eventdate = '$sql_currentday';";
		$eventExec = mysql_query ( $eventQuery );
		if (mysql_num_rows($eventExec)>0) {
			while ( $row = mysql_fetch_array ( $eventExec ) ) {
			if (strlen ( $row ["title"] ) > 0) {
        echo "<td style='background-color:#f89406;cursor:pointer;' onClick='window.location='" .$_SERVER['PHP_SELF']. "?year=$year&today=$zz&month=$month';'><a href='".$_SERVER['PHP_SELF']."?year=$year&today=$zz&month=$month' style='color:#fff'>$zz</a></td>\n";				
				$result_found = 1;
			}
		}	
		}
		else{
		$sql_currentday = "$year-$month-$zz";
		$fest = mysql_query("select distinct fecha, nombre from festivos WHERE fecha = '$sql_currentday'");
		if (mysql_num_rows($fest)>0) {
		$festiv=mysql_fetch_array($fest);
			        echo "<td style='background-color:#46A546;cursor:pointer;' onClick='window.location='" .$_SERVER['PHP_SELF']. "?year=$year&today=$zz&month=$month';'><a href='".$_SERVER['PHP_SELF']."?year=$year&today=$zz&month=$month' style='color:#fff'>$zz</a></td>\n";
				$result_found = 1;
				}	
		}
		
	}
  
  
/*  if ($result_found != 1) {
  //Buscar actividad  y marcarla.
    $sql_currentday = "$year-$month-$zz";
    $eventQuery = "SELECT title FROM cal WHERE eventdate = '$sql_currentday';";
    $eventExec = mysql_query($eventQuery);
    while($row = mysql_fetch_array($eventExec)) {
      if (strlen($row["title"]) > 0) {
        echo "<td style='background-color:#f89406;cursor:pointer;' onClick='window.location='" .$_SERVER['PHP_SELF']. "?year=$year&today=$zz&month=$month';'><a href='".$_SERVER['PHP_SELF']."?year=$year&today=$zz&month=$month' style='color:#fff'>$zz</a></td>\n";
        $result_found = 1;
      }
    }
  }*/

  if ($result_found != 1) {
    echo "<td style='cursor:pointer;' onClick='window.location='" .$_SERVER['PHP_SELF']. "?year=$year&today=$zz&month=$month';'><a href='".$_SERVER['PHP_SELF']."?year=$year&today=$zz&month=$month'>$zz</a></td>\n";
  }
  $i++; $result_found = 0;
}
$create_emptys = 7 - (($dayone + $numdays) % 7);
if ($create_emptys == 7) { $create_emptys = 0; }

if ($create_emptys != 0) {
  echo "<td  colspan='$create_emptys'>&nbsp;</td>\n";
}
echo "</tr>\n";
echo "</table><br>\n";

mysql_close();

?>
</div>
</div>
</div>
<?
include("../../../pie.php");
?>
</body>
</html>
