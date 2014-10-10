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


?>

 <?
   
  
  
  
  mysqli_query($db_con, "delete from calseg2 where idact IS NOT NULL");
  // Selecionamos los siguientes 7 dias con actividades
  $act0 = "select distinct fecha from actividades where fecha >= curdate() and fecha <= (curdate() + interval 8 day) order by fecha";
  $act1 = mysqli_query($db_con, $act0);
  while($act2 = mysqli_fetch_array($act1))
  {
  $fecha = $act2[0];
  // Miramos si hay actividades en cada una de esas fechas.
  $datos0 = "select id, fecha, actividad, grupos, descripcion from actividades where fecha = '$fecha'";
  $datos1 = mysqli_query($db_con, $datos0);
  while($datos2 = mysqli_fetch_array($datos1))
  {
  $id_act = $datos2[0];
  $fecha_act = $datos2[1];
  $actividad = $datos2[2];
  $contenido = $datos2[4]. "<br>Grupos que participan: " . $datos2[3];
  $idact = $datos2[5];
  // Para cada actividad, miramos si hay algun registro en el Calendario con esa fecha. 
  $cal0 = "select id, title, event, idact from calseg2 where eventdate = '$fecha_act'";
  echo $cal0. "<br>";
  $cal1 = mysqli_query($db_con, $cal0);
  // Si no lo hay, insertamos datos de actividad en el calendario.
   if (mysqli_num_rows($cal1) == 0)
  {
  $querycal = "insert into calseg2 (eventdate,title,event,html,idact) values ('".$fecha_act."','".$actividad."','".$contenido."','".$html."','".$idact."')";
  echo $querycal. "<br>";
  mysqli_query($db_con, $querycal);  
  }
  else
  // Si hay algun dato ya registrado con esa fecha, actualizamos los datos con los nuevos registros de actividades.
  {
  while($cal2 = mysqli_fetch_array($cal1))
  {
  $id_cal = $cal2[0];
  $title = $cal2[1];
  $event = $cal2[2];
  $idact = $cal2[3];
  $html = "1";
  $titulo = "$title<br>$actividad";
  $texto = "$event<br>$contenido";
  $id_idact = "$id_cal<br>$contenido";
  $actualiza_datos0 = "update calseg2 set title = '$titulo', event = '$texto', idact = '$id_idact' where eventdate = '$fecha_act'";
  echo $actualiza_datos0. "<br>";
  mysqli_query($db_con, $actualiza_datos0);
  }
  }
  }
  }
  ?>
