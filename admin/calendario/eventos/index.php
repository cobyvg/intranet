<?
session_start();
include("../../../config.php");
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


$profesor = $_SESSION['profi'];
$cargo = $_SESSION['cargo'];

include("../../../menu.php");
?>

<div class="container">

  <div class="page-header">
  	<h2>Calendario de actividades <small>Añadir nuevo evento</small></h2>
	</div>

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

if (isset($_GET['mens'])) {
$mes = $_GET['mens'];
if($mens==1){ 
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad ha sido actualizada correctamente.
          </div></div><br />';
}
if($mens==2){
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad ha sido actualizada correctamente.
          </div></div><br />';}
if($mens==3){
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad ha sido borrada correctamente.
          </div></div><br />';}
}

?>
	<div class="row">
		
		<div class="col-sm-7">
		
			<div class="well">
<?
echo "<legend>$daylong, $today de $monthlong</legend><br />";	


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
		  $tr0 = explode("<br>",$event_title);
		  $n_act="";
		  $actividad0="";
		  foreach($tr0 as $val0){
			$n_act = $n_act + 1;
		  	$actividad0.= $val0."<br>";
		}
			echo "<div class=\"form-group\">";
		  echo "<label for=\"actividades\">Actividades del día</label>";
		  if(stristr($cargo,'1') == TRUE or stristr($cargo,'8') == TRUE or stristr($cargo,'5') == TRUE){echo "<textarea id=\"actividades\" name='day_title' rows='6' class='form-control'>$event_title</textarea>";}else{echo "<p>$actividad0</p>";}
		  echo "</div>";
		  
		  echo "<div class=\"form-group\">";
      echo "<label for=\"informacion\">Información sobre las actividades</label>";
	 		if(stristr($cargo,'1') == TRUE or stristr($cargo,'8') == TRUE or stristr($cargo,'5') == TRUE){echo "<textarea id=\"informacion\"  name='day_event' rows='8' class='form-control'>$event_event</textarea>";}else{echo "<p>$event_event</p>";}
			echo "</div>";
			
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
echo "<p class='lead'>Horario de las actividades</p>
<textarea class='form-control' disabled />$hor</textarea>";
	  echo "<hr />";	  
		}	  
	  if(stristr($cargo,'1') == TRUE or stristr($cargo,'8') == TRUE or stristr($cargo,'5')== TRUE ){echo "<input type='submit' name='actualizar' value='Introducir datos' class='btn btn-primary'>";}
	  echo "&nbsp;";
	  if(stristr($cargo,'1') == TRUE or stristr($cargo,'5') == TRUE){echo "<input type='submit' name='del' value='Borrar registro'  class='btn btn-danger'>";}
	  echo "</form>";
?>
</div><!-- /.well -->
			
		</div><!-- /.col-sm-7 -->
		
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
echo "<th><h4><a href=\"".$_SERVER['PHP_SELF']."?year=".$ano_ant."&month=".$mes_ant."\"><span class=\"fa fa-arrow-circle-left fa-fw fa-lg\"></span></a></h4></th>";
echo "<th colspan=\"5\"><h4>".$monthlong.' '.$year."</h4></th>";
echo "<th><h4><a href=\"".$_SERVER['PHP_SELF']."?year=".$ano_sig."&month=".$mes_sig."\"><span class=\"fa fa-arrow-circle-right fa-fw fa-lg\"></span></a></h4></th>";
echo "</tr><tr>";


//Nombre de DÃ­as
foreach($alldays as $value) {
  echo "<th>$value</th>";
}
echo "</tr></thead><tbody><tr>";

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
    echo "<td class=\"calendar-today\"><a href='".$_SERVER['PHP_SELF']."?year=$year&today=$zz&month=$month'>$zz</a></td>\n";
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
        echo "<td class=\"calendar-orange\"><a href='".$_SERVER['PHP_SELF']."?year=$year&today=$zz&month=$month'>$zz</a></td>\n";				
				$result_found = 1;
			}
		}	
		}
		else{
		$sql_currentday = "$year-$month-$zz";
		$fest = mysql_query("select distinct fecha, nombre from festivos WHERE fecha = '$sql_currentday'");
		if (mysql_num_rows($fest)>0) {
		$festiv=mysql_fetch_array($fest);
			        echo "<td class=\"calendar-red\"><a href='".$_SERVER['PHP_SELF']."?year=$year&today=$zz&month=$month'>$zz</a></td>\n";
				$result_found = 1;
				}	
		}
		
	}


  if ($result_found != 1) {
    echo "<td><a href='".$_SERVER['PHP_SELF']."?year=$year&today=$zz&month=$month'>$zz</a></td>\n";
  }
  $i++; $result_found = 0;
}
$create_emptys = 7 - (($dayone + $numdays) % 7);
if ($create_emptys == 7) { $create_emptys = 0; }

if ($create_emptys != 0) {
  echo "<td colspan='$create_emptys'>&nbsp;</td>\n";
}
echo "</tr>\n";
echo "</tbody></table><br>\n";

mysql_close();

?>
</div><!-- /.col-sm-5 -->
		
	</div><!-- /.row -->
	
</div><!-- /.container -->

<?php include("../../../pie.php"); ?>

</body>
</html>
