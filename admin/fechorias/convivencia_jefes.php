<?
session_start ();
include ("../../config.php");
if ($_SESSION ['autentificado'] != '1') {
	session_destroy ();
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );

if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?php
include ("../../menu.php");
include ("menu.php");
if ($borrar == '1') {
	$del = mysql_query("delete from convivencia where id='$id'");
	$comprobar = mysql_query("select id from convivencia where id = '$id'");
	if (mysql_num_rows($comprobar) == '0') {
		echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos se han borrado correctamente.
          </div></div>';
	}
	else{
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
            Algún problema impide borrar los datos, así que deberías ponerte en contacto con quien pueda ayudarte.
          </div></div>';
	}
}

if ($enviar == 'Registrar'){
if (empty($hoy)) {
		$hoy = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . date ( 'd' );
	}
foreach ( $_POST as $clave => $valor ) {
	if(is_numeric($clave)) {
	$tr=explode("-", $valor);
	// Comprobacion de duplicacion de datos 
	$sel1 =  mysql_query("select * from convivencia where claveal = '$tr[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'");
	//echo "select * from convivencia where claveal = '$tr[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'";
	if (mysql_num_rows($sel1) == 0) {
		mysql_query("insert into convivencia (claveal, dia, hora, fecha) VALUES ('$tr[0]','$tr[1]','$tr[2]', '$hoy')");
			$mens = '1';	
			}
	else{
			mysql_query("update convivencia set dia = '$tr[1]', hora = '$tr[2]' where claveal = '$tr[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'");	
			$mens = '2';	
	}
	}
if ($valor == "1") {
	$tr1=explode("-", $clave);
	mysql_query("update convivencia set trabajo = '1' where claveal = '$tr1[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'");
}
if (!($valor == "1")) {
	$tr1=explode("-", $clave);
	mysql_query("update convivencia set trabajo = '0' where claveal = '$tr1[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'");
}
}
if ($mens == '1') {
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos se han registrado correctamente.
          </div></div>';	}
if ($mens == '2') {
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos se han registrado y actualizado correctamente.
          </div></div>';	}
}

if ($fecha1) {
	if (strlen($fecha0)<'6' and strlen($fecha11) > '6') {
		$fecha0 = $fecha11;
	}
	elseif (strlen($fecha0)<'6' and strlen($fecha11) < '6') {
		$fecha0 = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . date ( 'd' );
	}else{		
		$fechasp0 = explode ( "-", $fecha0 );
		$fecha0 = $fechasp0 [2] . "-" . $fechasp0 [1] . "-" . $fechasp0 [0];
	}
}
else
{
$fecha0=$hoy;
}
echo '<div aligna="center">
<div class="page-header" align="center">
  <h2>Problemas de Convivencia <small> Aula de Convivencia</small></h2>
';
echo " <h3 align='center' style='color:#08c'>";
if (empty($hor))  {$hoy0 = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . date ( 'd' );}else {$hoy0 = $fecha0;}
if ($hoy) {
	$hoy0=$hoy;
}
$tr_h = explode("-", $hoy0);
$hoy0 = "$tr_h[2]-$tr_h[1]-$tr_h[0]";
echo "$hoy0</h3>";
echo '</div>
</div>
';

	echo "<center><form name='conv' action='convivencia_jefes.php' method='post' enctype=multipart/form-data' class='form form-inline'>";
	?>
	<label>Selecciona el Día 
<div class="input-append" >
            <input name="fecha0" type="text" class="input input-small" value="<? echo $hoy0;?>" data-date-format="dd-mm-yyyy" id="fecha0" >
  <span class="add-on"><i class="icon-calendar"></i></span>
</div>   
	</label>
    <label style="margin-left:15px;">
	<?
	echo "  y la Hora ";
	echo "<select name = 'hor' class='input input-mini'>";
	if (empty($hor)) {
	}else{
		echo "<option>$hor</option>";
	}
	echo "<option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option>
	</select>
	<input type='hidden' name = 'fecha11' value = '$fecha0' />
	<input type='submit' name = 'fecha1' value = 'Enviar fecha' style = 'margin-left:25px;' class='btn btn-primary' />
	</form></center>";
if (empty($fecha0)) {$hoy = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . date ( 'd' );}else{$hoy = $fecha0;}
$trf = explode("-", $hoy);

// Horas y dÃŒas segË™n el horario

$minutos = date ( "i" );
$diames = date ( "j", mktime(0, 0, 0, $trf[1], $trf[2], $trf[0]) );
$nmes = date ( "n", mktime(0, 0, 0, $trf[1], $trf[2], $trf[0]) );
$nano = date ( "Y", mktime(0, 0, 0, $trf[1], $trf[2], $trf[0]) );
$ndia = date ( "w", mktime(0, 0, 0, $trf[1], $trf[2], $trf[0])  );
//echo "$minutos --> $diames --> $nmes --> $nano<br>";
if (empty($hor)) {$hora_dia = '1';}
if ($hor) {
	$hora_dia = $hor;
}
$result = mysql_query ( "select distinct FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel,
  FALUMNOS.grupo, aula_conv, inicio_aula, fin_aula, id, Fechoria.claveal, horas from Fechoria,
  FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and aula_conv > '0' and inicio_aula <= '$hoy' and fin_aula >= '$hoy' and horas like '%$hora_dia%' order by apellidos, nombre " );
?>
<?php
	echo "<center><table class='table table-striped' style='width:auto'>";
	echo "<tr><th>Alumno</td>
		<th>Nivel</th><th>Grupo</th><th>Días</th><th>Inicio</th><th>Detalles</th><th>Asistencia</th><th>Trabajo</th><th align='center'>1</th><th align='center'>2</th><th align='center'>3</th><th align='center'>4</th><th align='center'>5</th><th align='center'>6</th><th align='center'></th><th></th></tr>";
	echo '<form name="conviv" action="convivencia_jefes.php" method="post" enctype="multipart/form-data">';
while ( $row = mysql_fetch_array ( $result ) ) {
	$sel =  mysql_query("select * from convivencia where claveal = '$row[8]' and hora = '$hora_dia'  and fecha = '$hoy'");
	$ya = mysql_fetch_array($sel);
	$id0 = $ya[0];
	if (empty($ya[0])) {$ch = '';} else{$ch=" checked";}
	if ($ya[4] == 0) {$ch_tr = '';$trab = "";} else{$ch_tr=" checked";}
		echo "<tr ><td>$row[0], $row[1]</td>
		<td>$row[2]</td>
		<td>$row[3]</td>
		<td>$row[4]</td>
		<td>$row[5]</td>
		<td align='center'><A HREF='detfechorias.php?id=$row[7]&claveal=$row[8]'><i title='Detalles' class='icon icon-search'> </i> </A>$comentarios</td>
		<td align='center'>
	
		<input type='checkbox' name='$row[8]' value='$row[8]-$ndia-$hora_dia' $ch /></td>
		<td align='center'>
		<input type='checkbox' name='$row[8]-trabajo'  value='1' $ch_tr/>
		<input type='hidden' name='hoy'  value='$fecha0' />
		<input type='hidden' name='hor'  value='$hora_dia' /></td>";
		
	for ($i = 1; $i < 7; $i++) {
		echo "<td>";
		$asiste0 = "select hora, trabajo, id from convivencia where claveal = '$row[8]' and fecha = '$hoy' and hora = '$i'";
		//echo $asiste0;
		$asiste1 = mysql_query($asiste0);
			$asiste = mysql_fetch_array($asiste1);
			if ($asiste[1] == '0') {
			echo "<center><i title='No trabaja' class='icon icon-warning-sign'> </i> </center";
			}
			if ($asiste[1] == '1') {
			echo "<center><i title='Trabaja' class='icon icon-ok'> </i> </center";
			}
		echo "</td>";
	}
	echo "<td>";
	if (!empty($id0)) {
		echo "<A HREF='convivencia_jefes.php?id=$id0&borrar=1&hoy=$hoy'><i title='Borrar' class='icon icon-trash'> </i> </A>";
	}
	echo "</td><td>";
	$foto="";
		$foto = "<div align='center'><img src='../../xml/fotos/$row[8].jpg' border='2' width='50' height='60' style='margin:auto;border:1px solid #bbb;'  /></div>";
		echo $foto;
	
	echo "</td></tr>";
		
} 
	echo "</table><br /><input type='submit' name = 'enviar' value = 'Registrar' class='btn btn-primary' /></form></center>";
?>
<? include("../../pie.php");?>
<script>  
	$(function ()  
	{ 
		var startDate = new Date(2012,1,20);
		$('#fecha0').datepicker()
		.on('changeDate', function(ev){
			$('#fecha0').datepicker('hide');
		});
		});  
	</script>
  </body>
</html>

