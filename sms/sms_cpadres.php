<?
session_start();
include("../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


$profe = $_SESSION['profi'];
if ($mod_sms) {
	if (isset($_GET['padres2'])) {$padres2 = $_GET['padres2'];}elseif (isset($_POST['padres2'])) {$padres2 = $_POST['padres2'];}else{$padres2="";}
	if (isset($_GET['padres3'])) {$padres3 = $_GET['padres3'];}elseif (isset($_POST['padres3'])) {$padres3 = $_POST['padres3'];}else{$padres3="";}
	if (isset($_GET['padres4'])) {$padres4 = $_GET['padres4'];}elseif (isset($_POST['padres4'])) {$padres4 = $_POST['padres4'];}else{$padres4="";}
	if (isset($_GET['padres5'])) {$padres5 = $_GET['padres5'];}elseif (isset($_POST['padres5'])) {$padres5 = $_POST['padres5'];}else{$padres5="";}
	if (isset($_GET['padres6'])) {$padres6 = $_GET['padres6'];}elseif (isset($_POST['padres6'])) {$padres6 = $_POST['padres6'];}else{$padres6="";}
	if (isset($_GET['padres7'])) {$padres7 = $_GET['padres7'];}elseif (isset($_POST['padres7'])) {$padres7 = $_POST['padres7'];}else{$padres7="";}
	if (isset($_GET['padres8'])) {$padres8 = $_GET['padres8'];}elseif (isset($_POST['padres8'])) {$padres8 = $_POST['padres8'];}else{$padres8="";}
	if (isset($_GET['padres9'])) {$padres9 = $_GET['padres9'];}elseif (isset($_POST['padres9'])) {$padres9 = $_POST['padres9'];}else{$padres9="";}
	if (isset($_GET['fecha12'])) {$fecha12 = $_GET['fecha12'];}elseif (isset($_POST['fecha12'])) {$fecha12 = $_POST['fecha12'];}else{$fecha12="";}
	if (isset($_GET['fecha22'])) {$fecha22 = $_GET['fecha22'];}elseif (isset($_POST['fecha22'])) {$fecha22 = $_POST['fecha22'];}else{$fecha22="";}
	if (isset($_GET['hermanos'])) {$hermanos = $_GET['hermanos'];}elseif (isset($_POST['hermanos'])) {$hermanos = $_POST['hermanos'];}else{$hermanos="";}
	if (isset($_GET['login'])) {$login = $_GET['login'];}elseif (isset($_POST['login'])) {$login = $_POST['login'];}else{$login="";}
	if (isset($_GET['password'])) {$password = $_GET['password'];}elseif (isset($_POST['password'])) {$password = $_POST['password'];}else{$password="";}
	if (isset($_GET['extid'])) {$extid = $_GET['extid'];}elseif (isset($_POST['extid'])) {$extid = $_POST['extid'];}else{$extid="";}
	if (isset($_GET['tpoa'])) {$tpoa = $_GET['tpoa'];}elseif (isset($_POST['tpoa'])) {$tpoa = $_POST['tpoa'];}else{$tpoa="";}
	if (isset($_GET['mobile'])) {$mobile = $_GET['mobile'];}elseif (isset($_POST['mobile'])) {$mobile = $_POST['mobile'];}else{$mobile="";}
	if (isset($_GET['messageQty'])) {$messageQty = $_GET['messageQty'];}elseif (isset($_POST['messageQty'])) {$messageQty = $_POST['messageQty'];}else{$messageQty="";}
	if (isset($_GET['messageType'])) {$messageType = $_GET['messageType'];}elseif (isset($_POST['messageType'])) {$messageType = $_POST['messageType'];}else{$messageType="";}
	// Si se han mandado datos desde el Formulario principal de mas abajo...
	$n_cur = mysql_query("select nomcurso from cursos");
	$pc = mysql_num_rows($n_cur);
	for ($i = 2; $i < $pc+2; $i++) {
	//echo "$i<br>";
	if(${padres.$i})
	{
echo ${padres.$pc};
		// Fechas y demás...
		$fechasp0=explode("-",$_POST['fecha12']);
		$fechasp1=$fechasp0[2]."-".$fechasp0[1]."-".$fechasp0[0];
		$fechasp11=$fechasp0[0]."-".$fechasp0[1]."-".$fechasp0[2];
		$fechasp2=explode("-",$_POST['fecha22']);
		$fechasp3=$fechasp2[2]."-".$fechasp2[1]."-".$fechasp2[0];
		$fechasp31=$fechasp2[0]."-".$fechasp2[1]."-".$fechasp2[2];
		$cursos_sen = mysql_query("select nomcurso from cursos");
		$n_c=1;
		while ($cursos_seneca = mysql_fetch_array($cursos_sen)) {
			$n_c+=1;
			if(${padres.$n_c}){
				$nivel_sms = "and curso like '$cursos_seneca[0]'";
			}
		}

		$SQLTEMP = "create table faltastemp2 SELECT FALTAS.CLAVEAL, falta, (count(*)) AS numero, curso FROM  FALTAS, alma where alma.claveal=FALTAS.claveal and falta = 'F' and FALTAS.fecha >= '$fechasp1' and FALTAS.fecha <= '$fechasp3' $nivel_sms group by FALTAS.claveal";
		//echo $SQLTEMP;
		$resultTEMP= mysql_query($SQLTEMP);
		mysql_query("ALTER TABLE faltastemp2 ADD INDEX ( claveal ) ");
		$SQL0 = "SELECT distinct CLAVEAL FROM  faltastemp2 where numero > '4'";
		$result0 = mysql_query($SQL0);
		while ($row0 = mysql_fetch_array($result0)):
		$claveal = $row0[0];
		$clave_carta .= $claveal.",";
		$SQL3 = "SELECT distinct alma.claveal, alma.telefono, alma.telefonourgencia, alma.apellidos, alma.nombre, alma.unidad
	from alma where alma.claveal like '$claveal' and (alma.telefono not in (select telefono from hermanos) 
	or alma.telefonourgencia not in (select telefonourgencia from hermanos))";

		$result3 = mysql_query($SQL3);
		$rowsql3 = mysql_fetch_array($result3);
		$tfno2 = $rowsql3[1];
		$tfno_u2 = $rowsql3[2];
		$apellidos = $rowsql3[3];
		$nombre = $rowsql3[4];
		$unidad = $rowsql3[5];

		// Telefonos móviles o sin telefono
		if(substr($tfno2,0,1)=="6" or substr($tfno2,0,1)=="7"){$mobil2=$tfno2;$sin="";}elseif((substr($tfno_u2,0,1)=="6" or substr($tfno_u2,0,1)=="7") and !(substr($tfno2,0,1)=="6") or substr($tfno2,0,1)=="7"){$mobil2=$tfno_u2;$sin="";}else{$mobil2="";$sin=$claveal;}

		if(strlen($mobil2) > 0)
		{
			$mobile2 .= $mobil2.",";
			// Variables para la acción de tutoría
			$causa = "Faltas de Asistencia";
			$observaciones = "Comunicación de Faltas de Asistencia a la familia del Alumno.";
			$accion = "Envío de SMS";
			$tuto = "Jefatura de Estudios";
			$fecha2 = date('Y-m-d');
			mysql_query("insert into tutoria (apellidos, nombre, tutor,unidad,observaciones,causa,accion,fecha,claveal) values ('".$apellidos."','".$nombre."','".$tuto."','".$unidad."','".$observaciones."','".$causa."','".$accion."','".$fecha2."','".$claveal."')");
		}

		if(strlen($sin) > 0){$sin2 .= $sin.";";}
		endwhile;
		// Identificador del mensaje
		$sms_n = mysql_query("select max(id) from sms");
		$n_sms =mysql_fetch_array($sms_n);
		$extid = $n_sms[0]+1;
	}
	}
	?>
	<?
	include("../menu.php");
	?>
<br />
<div align=center>
<div class="page-header">
<h2>SMS <small> Comunicación de Faltas de Asistencia a los Padres </small></h2>
</div>

	<?php
	if ($hermanos) {
		include("hermanos.php");
	}
	// Enviamos los datos
	if($padres2 or $padres3 or $padres4 or $padres5 or $padres6 or $padres7 or $padres8 or $padres9)
	{
		// Variables del memnsaje
		if($padres2)$niv = "1º de ESO";if($padres3)$niv = "2º de ESO";if($padres4)$niv = "3º de ESO";if($padres5)$niv = "4º de ESO";if($padres6)$niv = "1º Bach.";if($padres7)$niv = "2º Bach.";if($padres8)$niv = "Ciclos Form.";if($padres9)$niv = "PCPI";

		$text = "Entre el ".$_POST['fecha12']." y el ".$_POST['fecha22']." su hijo/a de ".$niv." ha faltado al menos 5 horas injustificadas al centro. Más info en nuestra web: http://".$dominio;
		$login = $usuario_smstrend;
		$password = $clave_smstrend;
		?> <script language="javascript">
function enviarForm() /*el formulario se llama crear*/
{
ventana=window.open("", "ventanaForm", "top=100, left=100, toolbar=no,location=no, status=no,menubar=no,scrollbars=no, resizable=no, width=100,height=66,directories=no")
document.enviar.submit()
/*AQUÕ PUEDES PONER UN TIEMPO*/
/*ventana.close()*/
}
</script>

<form name="enviar"
	action="http://www.smstrend.net/esp/sendMessageFromPost.oeg"
	target="ventanaForm" method="POST"
	enctype="application/x-www-form-urlencoded"><input name="login"
	type="hidden" value="<? echo $login;?>" /> <input name="password"
	type="hidden" value="<? echo $password;?>" /> <input name="extid"
	type="hidden" value="<? echo $extid;?>" /> <input name="tpoa"
	type="hidden" value="<? echo $nombre_corto; ?>" /> <input name="mobile"
	type="hidden" value="<? echo $mobile2;?>" /> <input name="messageQty"
	type="hidden" value="GOLD" /> <input name="messageType" type="hidden"
	value="PLUS" /> <input name="message" type="hidden"
	value="<?echo $text;?>" maxlength="159" size="60" /></form>
<script>
 enviarForm();
</script> <?
mysql_query("insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$mobile2','$text','Jefatura de Estudios')");
echo '<div align="center"><div class="alert alert-success alert-block fade in" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El mensaje SMS se ha enviado correctamente para los alumnos con faltas sin justificar de'. $niv.'.<br>Una nueva acción tutorial ha sido también registrada.
          </div></div><br />';
if(strlen($sin2) > '0'){
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
<p align="left">Los siguientes alumnos no tienen teléfono móvil al que enviar comunicación de Faltas de Asistencia:</p>
<ul style="text-align:left;">';
	// Marcamos alumnos sin movil para enviarlos al tutor
	$sin2 = substr($sin2,0,strlen($sin2)-1);
	$sin0 = explode(";",$sin2);
	foreach ($sin0 as $no_tel)
	{
		$no_tel0 = mysql_query("select apellidos, nombre, unidad, telefono, claveal from alma where claveal = '$no_tel'");
		$dat_al = mysql_fetch_array($no_tel0);
		$herm = mysql_query("select telefono from hermanos where telefono = '$dat_al[4]'");
		if (mysql_num_rows($herm) == '1' or empty($dat_al[4])) {}
		else {
			$clave_sin .= $dat_al[5].";";
			echo "<li>$dat_al[1] $dat_al[0] => $dat_al[2]</li>";
		}
	}
	echo "</ul></div></div>";
}
	}
	$fecha_inicio_0 = mysql_query("select date_add(curdate(),interval -21 day)");
	$fecha_inicio = mysql_fetch_array($fecha_inicio_0);
	$anterior = $fecha_inicio[0];
	$fc1 = explode("-",$anterior);
	$fech1 = "$fc1[2]-$fc1[1]-$fc1[0]";
	$fecha_fin_0 = mysql_query("select date_add(curdate(),interval -7 day)");
	$fecha_fin = mysql_fetch_array($fecha_fin_0);
	$posterior = $fecha_fin[0];
	$fc2 = explode("-",$posterior);
	$fech2 = "$fc2[2]-$fc2[1]-$fc2[0]";
	?> <br />

<div class="container">
<div class="row">
<div class="col-sm-4 col-sm-offset-4 well well-large">
<form enctype='multipart/form-data' action='sms_cpadres.php'
	method='post' class="form-inline"><br />
<table class="table" style="width: auto">

	<legend align="center">Selecciona el rango de fechas</legend>

	<tr>
		<td align="center"><label>Inicio</label><br />
		<div class="form-group"  id="datetimepicker1">
		<div class="input-group" style="display: inline;"><input
			name="fecha12" type="text" class="input input-small"
			value="<? if(empty($fecha12)){echo $fech1;} else {echo $fecha12;}?>"
			data-date-format="DD-MM-YYYY" id="fecha12"> <span class="input-group-addon"><i
			class="fa fa-calendar"></i></span></div>
		</div></td>
		<td><label>Fin</label><br />
		<div class="form-group"  id="datetimepicker2">
		<div class="input-group" style="display: inline;"><input
			name="fecha22" type="text" class="input input-small"
			value="<? if(empty($fecha22)){echo $fech2;} else {echo $fecha22;} ?>"
			data-date-format="DD-MM-YYYY" id="fecha22"> <span class="input-group-addon"><i
			class="fa fa-calendar"></i></span></div>
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="azimuth: 6px" align="center"><br>

			<?
			$cursos_sen = mysql_query("select nomcurso from cursos");
			$n_c=1;
			while ($cursos_seneca = mysql_fetch_array($cursos_sen)) {
				$n_c+=1;
				echo '<input name="padres'.$n_c.'" type="submit" value="'.$cursos_seneca[0].'"
				class="btn btn-primary btn-block" />';
			}
			?>
			<!--
				<td align="center"><input name="padres2" type="submit" value='1 ESO'
					class="btn btn-primary" /></td>
				<td align="center"><input name="padres4" type="submit" value='3 ESO'
					class="btn btn-primary" /></td>
				<td align="center"><input name="padres6" type="submit"
					value='1 Bachillerato' class="btn btn-primary" /></td>
				<td align="center"><input name="padres8" type="submit"
					value='Ciclos Formativos' class="btn btn-primary" /></td>
			</tr>
			<tr>
				<td align="center"><input name="padres3" type="submit" value='2 ESO'
					class="btn btn-primary" /></td>
				<td align="center"><input name="padres5" type="submit" value='4 ESO'
					class="btn btn-primary" /></td>
				<td align="center"><input name="padres7" type="submit"
					value='2 Bachillerato' class="btn btn-primary" /></td>
				<td align="center"><input name="padres9" type="submit" value='PCPI'
					class="btn btn-primary" /></td>
			-->
				<input name="hermanos" type="submit"
				value='Hermanos' class="btn btn-primary btn-block" />
			</td>
	</tr>
</table>

</form>
</div>

</div>
</div>
			<?
			// Tabla temporalñ y recogida de datos
			mysql_query("DROP table `faltastemp2`");
}
else {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
El módulo de envío de SMS debe ser activado en la Configuración general de la Intranet para poder accede a estas páginas, y ahora mismo está desactivado.
          </div></div>';
}
?> <? include("../pie.php");?>
<script>  
$(function ()  
{ 
	$('#datetimepicker1').datetimepicker({
		language: 'es',
		pickTime: false
	});
	
	$('#datetimepicker2').datetimepicker({
		language: 'es',
		pickTime: false
	});
});  
</script>
</body>
</html>