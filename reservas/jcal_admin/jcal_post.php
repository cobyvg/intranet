<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI']);
?>
<?
$conn = mysql_connect($db_host, $db_user, $db_pass) or die("Could not connect to database!");
mysql_select_db($db_reservas, $conn);

if (isset($_GET['month'])) {
	$month = $_GET['month'];
}
if (isset($_GET['year'])) {
	$year = $_GET['year'];
	}
if (isset($_GET['today'])) {
	$today = $_GET['today'];
	}
if (isset($_GET['servicio'])) {
	$servicio = $_GET['servicio'];
}	
for ($i=1;$i<=7;$i++)
{
//echo $_POST['day_event'.$i];
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

$eventQuery = "SELECT id FROM $servicio WHERE eventdate = '$sql_date'";
$eventExec = mysql_query($eventQuery); 
$event_found = "";
while($row = mysql_fetch_array($eventExec)) {
  //$echo = $row["id"];
  $event_found = 1;
}
for ($i=1;$i<=7;$i++)
{
if (isset($_POST['day_event'.$i])) { $day_event{$i} = $_POST['day_event'.$i]; }
else{$day_event{$i}="";}
}

$day_event_safe1 = addslashes($day_event1);
$day_event_safe2 = addslashes($day_event2);
$day_event_safe3 = addslashes($day_event3);
$day_event_safe4 = addslashes($day_event4);
$day_event_safe5 = addslashes($day_event5);
$day_event_safe6 = addslashes($day_event6);
$day_event_safe7 = addslashes($day_event7);
if ($event_found == 1) {
  //UPDATE
    $postQuery = "UPDATE `$servicio` SET event1 = '".$_POST['day_event1']."', event2 = '".$_POST['day_event2']."', event3 = '".$_POST['day_event3']."', 
    event4 = '".$_POST['day_event4']."', event5 = '".$_POST['day_event5']."', event6 = '".$_POST['day_event6']."', event7 = '".$_POST['day_event7']."' WHERE eventdate = '$sql_date';";
    $postExec = mysql_query($postQuery) or die("Could not Post UPDATE $servicio Event to database!");
    mysql_query("DELETE FROM `$servicio` WHERE event1 = '' and event2 = ''  and event3 = ''  and event4 = ''  and event5 = ''  and event6 = ''  and event7 = '' ");
mysql_close($conn);
	header("Location: index.php?servicio=$servicio&year=$year&month=$month&today=$today&mens=actualizar");

} else {
  //INSERT
    $postQuery = "INSERT INTO `$servicio` (eventdate,dia,event1,event2,event3,event4,event5,event6,event7,html) VALUES ('$sql_date','$numero_dia','".$_POST['day_event1']."','".$_POST['day_event2']."','".$_POST['day_event3']."','".$_POST['day_event4']."','".$_POST['day_event5']."','".$_POST['day_event6']."','".$_POST['day_event7']."','$show_html');";
    $postExec = mysql_query($postQuery) or die("Could not Post INSERT $servicio Event to database!");
    
mysql_query("DELETE FROM `$servicio` WHERE event1 = '' and event2 = ''  and event3 = ''  and event4 = ''  and event5 = ''  and event6 = ''  and event7 = '' ");
mysql_close($conn);
    header("Location: index.php?servicio=$servicio&year=$year&month=$month&today=$today&mens=insertar");

}
?>
