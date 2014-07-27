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
?>
<?php
$conn = mysql_connect($db_host, $db_user, $db_pass) or die("Could not connect to database!");
mysql_select_db($db, $conn);

if (isset($_POST['day_title'])) { $day_title = $_POST['day_title']; }
if (isset($_GET['day_title'])) { $day_title = $_GET['day_title']; }
if (isset($_POST['day_event'])) { $day_event = $_POST['day_event']; }
if (isset($_GET['day_event'])) { $day_event = $_GET['day_event']; }
if (isset($_POST['html'])) { $show_html = intval($_POST['html']); }
if (isset($_GET['html'])) { $show_html = intval($_get['html']); }

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

if (isset($_POST['del']) and $_POST['del'] == "Borrar registro") {
  $eventQuery = "DELETE FROM cal WHERE eventdate = '$sql_date'";
  $eventExec = mysql_query($eventQuery)or die("No se ha podido borrar la actividad!");
    header("Location: index.php?year=$year&month=$month&today=$today&mens=3");
exit();
}

if (strlen($_POST['day_title']) < 1 and strlen($_POST['day_event']) < 1 ) {
  $eventQuery = "DELETE FROM cal WHERE eventdate = '$sql_date'";
  $eventExec = mysql_query($eventQuery)or die("No se ha podido borrar la actividad!");
    header("Location: index.php?year=$year&month=$month&today=$today&mens=3");
exit();
}

$eventQuery = "SELECT id FROM cal WHERE eventdate = '$sql_date';";
$eventExec = mysql_query($eventQuery); 
$event_found = "";
while($row = mysql_fetch_array($eventExec)) {
  $event_found = 1;
}

if ($event_found == 1) {
  //UPDATE
  	$postQuery = "UPDATE cal SET title = '$day_title', event = '$day_event'  WHERE eventdate = '$sql_date'";
	//echo $postQuery;
    $postExec = mysql_query($postQuery) or die("No se ha podido actualizar la actividad!!");
    mysql_close($conn);
    header("Location: index.php?year=$year&month=$month&today=$today&mens=2");
} else {
  //INSERT
    $postQuery = "INSERT INTO cal (eventdate,title,event) VALUES ('$sql_date','$day_title','$day_event')";
	//echo $postQuery;
    $postExec = mysql_query($postQuery) or die("No se ha podido registrar la actividad!");
    mysql_close($conn);
    header("Location: index.php?year=$year&month=$month&today=$today&mens=1");
}
?>
