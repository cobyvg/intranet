<?
session_start();
include("../../config.php");
include("../../config/version.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
?>
<?php
include ("../../menu.php");
include ("menu.php");
$id = $_GET['id'];
$claveal = $_GET['claveal'];
if(isset($_GET['hor'])) {$hor = $_GET['hor'];} elseif(isset($_POST['hor'])) {$hor = $_POST['hor'];}
$fecha1 = $_POST['fecha1'];
$fecha11 = $_POST['fecha11'];
if(isset($_GET['hoy'])) {$hoy = $_GET['hoy'];} elseif(isset($_POST['hoy'])) {$hoy = $_POST['hoy'];}else{$hoy = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . date ( 'd' );}
$hoy = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . date ( 'd' );
$hoy2 = date ( 'd' ) . "-" . date ( 'm' ) . "-" . date ( 'Y' );
$ayer = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . (date ( 'd' ) - 1);

  echo "<div class='container'>";
  echo '<div class="row">';
  echo '<div align="center">
<div class="page-header">
  <h2>Problemas de convivencia <small> &Uacute;ltimos Problemas de Convivencia</small></h2>
</div>
</div>
<div class="col-sm-8 col-sm-offset-2">';
   
echo " <p class='lead text-info' align='center' >";
echo "$hoy2</p>";



if ($_POST['enviar'] == 'Registrar'){
foreach ( $_POST as $clave => $valor ) {
	if(is_numeric($clave)) {
	$tr=explode("-", $valor);
	// Comprobacion de duplicacion de datos
	$sel1 =  mysqli_query($db_con, "select * from convivencia where claveal = '$tr[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'");
	//echo "select * from convivencia where claveal = '$tr[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'";
	if (mysqli_num_rows($sel1) == 0) {
		mysqli_query($db_con, "insert into convivencia (claveal, dia, hora, fecha) VALUES ('$tr[0]','$tr[1]','$tr[2]', '$hoy')");
			$mens = '1';	
			}
	else{
			mysqli_query($db_con, "update convivencia set dia = '$tr[1]', hora = '$tr[2]' where claveal = '$tr[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'");	
			$mens = '2';	
	}
	}
if ($valor == "1") {
	$tr1=explode("-", $clave);
	mysqli_query($db_con, "update convivencia set trabajo = '1' where claveal = '$tr1[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'");
}
if (!($valor == "1")) {
	$tr1=explode("-", $clave);
	mysqli_query($db_con, "update convivencia set trabajo = '0' where claveal = '$tr1[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'");
}
}
if ($mens == '1') {
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos se han registrado correctamente.
          </div></div>';	}
if ($mens == '2') {
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos se han registrado y actualizado correctamente.
          </div></div>';	}
}

// Horas y días según el horario
$minutos = date ( "i" );
$diames = date ( "j" );
$nmes = date ( "n" );
$nano = date ( "Y" );
$hoy = $nano . "-" . $nmes . "-" . $diames;
if (empty ( $hora_dia )) {
	$hora = date ( "G" ); // hora
	$ndia = date ( "w" );
	if (($hora == '8' and $minutos > 15) or ($hora == '9' and $minutos < 15)) {
		$hora_dia = '1';
	} elseif (($hora == '9' and $minutos > 15) or ($hora == '10' and $minutos < 15)) {
		$hora_dia = '2';
	} elseif (($hora == '10' and $minutos > 15) or ($hora == '11' and $minutos < 15)) {
		$hora_dia = '3';
	} elseif (($hora == '11' and $minutos > 15) or ($hora == '11' and $minutos < 45)) {
		$hora_dia = '9';
	} elseif (($hora == '11' and $minutos > 45) or ($hora == '12' and $minutos < 45)) {
		$hora_dia = '4';
	} elseif (($hora == '12' and $minutos > 45) or ($hora == '13' and $minutos < 45)) {
		$hora_dia = '5';
	} elseif (($hora == '13' and $minutos > 45) or ($hora == '14' and $minutos < 45)) {
		$hora_dia = '6';
	} else {
		$hora_dia = "0";
	}	
}

$result = mysqli_query($db_con, "select distinct FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad,
  FALUMNOS.nc, aula_conv, inicio_aula, fin_aula, id, Fechoria.claveal, horas from Fechoria,
  FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and aula_conv > '0' and inicio_aula <= '$hoy' and fin_aula >= '$hoy' and horas like '%$hora_dia%' order by apellidos, nombre " );
?>
<?php
echo "<br /><center><table class='table table-striped' style='width:auto'>";
	echo "<thead><th>Alumno</th>
		<th>Grupo</th><th>Días</th><th>Inicio</th><th>Detalles</th><th>Asistencia</th><th>Trabajo</th><th align='center'>1</th><th align='center'>2</th><th align='center'>3</th><th align='center'>4</th><th align='center'>5</th><th align='center'>6</th><th align='center'></th><th></th></thead>";
	echo '<form name="conviv" action="convivencia.php" method="post" enctype="multipart/form-data">';
while ( $row = mysqli_fetch_array ( $result ) ) {
	$sel =  mysqli_query($db_con, "select * from convivencia where claveal = '$row[8]' and dia = '$ndia' and hora = '$hora_dia' and fecha = '$hoy'");
	$ya = mysqli_fetch_array($sel);
	if (empty($ya[0])) {$ch = '';} else{$ch=" checked";}
	if ($ya[4] == 0) {$ch_tr = '';$trab = "";} else{$ch_tr=" checked";}
		echo "<tr ><td>$row[0], $row[1]</td>
		<td style='vertical-align:middle'>$row[2]</td>
		<td style='vertical-align:middle'>$row[4]</td>
		<td style='vertical-align:middle'>$row[5]</td>
		<td style='vertical-align:middle' align='center'><A HREF='detfechorias.php?id=$row[7]&claveal=$row[8]'><i title='Detalles' class='fa fa-search'> </i> </A>$comentarios</td>
		<td style='vertical-align:middle' align='center'>
	
		<input type='checkbox' name='$row[8]' value='$row[8]-$ndia-$hora_dia' $ch /></td>
		<td style='vertical-align:middle' align='center'>
		<input type='checkbox' name='$row[8]-trabajo'  value='1' $ch_tr/>
		<input type='hidden' name='hoy'  value='$fecha0' />
		<input type='hidden' name='hor'  value='$hora_dia' /></td>";
		
	for ($i = 1; $i < 7; $i++) {
		echo "<td style='vertical-align:middle'>";
		$asiste0 = "select hora, trabajo from convivencia where claveal = '$row[8]' and fecha = '$hoy' and hora = '$i'";
		//echo $asiste0;
		$asiste1 = mysqli_query($db_con, $asiste0);
			$asiste = mysqli_fetch_array($asiste1);
			if ($asiste[1] == '0') {
			echo "<center><i title='No trabaja' class='fa fa-exclamation-triangle'> </i> </center";
			}
			if ($asiste[1] == '1') {
			echo "<center><i title='Trabaja' class='fa fa-check'> </i> </center";
			}
		echo "</td>";
	}
	echo "<td style='vertical-align:middle'>";	
	$foto="";
		$foto = "<div align='center'><img src='../../xml/fotos/$row[8].jpg' border='2' width='50' height='60' style='margin:auto;border:1px solid #bbb;'  /></div>";
		echo $foto;
	
	echo "</td></tr>";	
} 
	echo "</table><input type='submit' name = 'enviar' value = 'Registrar' class='btn btn-primary' /></form></center>";
	echo '</div>
</div>
</div>
';
?>

  </body>
</html>

