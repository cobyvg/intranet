<?
session_start();
include("../../config.php");

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


	if((!(stristr($_SESSION['cargo'],'1') == TRUE)) and (!(stristr($_SESSION['cargo'],'c') == TRUE)) )
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
?>
<script language="javascript">
function enviarForm()
{
	ventana=window.open("", "ventanaForm", "top=100, left=100, toolbar=no,location=no, status=no,menubar=no,scrollbars=no, resizable=no, width=100,height=66,directories=no")
	document.enviar.submit()
	/*AQUÕ PUEDES PONER UN TIEMPO*/
	/*ventana.close()*/
}
</script>
<?php
include("../../menu.php");
 include("menu.php");
?>
<br>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Biblioteca <small> Edición de morosos</small></h2>
</div>
<br>

<div class="col-sm-8 col-sm-offset-2">
<?
if(isset($_POST['borrar'])){
	//echo $fecha;
	$i=0;
	$j=0;
	foreach ($_POST as $ide => $valor)
	{
		if(($ide<>'borrar') and (!empty( $valor))){
			for($i=0; $i <= count($valor)-1; $i++){ $j+=1;
			//echo "delete from morosos where id=$valor[$i]";
			$bor = mysql_query ("delete from morosos where id='$valor[$i]'") or die("No se ha podido borrar");
			}

			echo '<div align="center"><div class="alert alert-success alert-block fade in">
 <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCI&Oacute;N:</legend>
El proceso de borrado ha sido completado correctamente. Los alumnos no volver&aacute;n a aparecer en la lista.
	</div></div><br />';

			echo '<div align="center">
  	<input type="button" value="Volver atr&aacute;s" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
			</div>';	
		}
		elseif ($j==0)
		{
			echo '<div align="center"><div class="alert alert-danger alert-block fade in">
 <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCI&Oacute;N:</legend>
No se ha podido borrar porque no has elegido ning&uacute;n alumno de la lista. Vuelve atr&aacute;s para solucionarlo.
	</div></div><br />
<div align="center">
  	<input type="button" value="Volver atr&aacute;s" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
			</div>';			
		}
	}
}
elseif(isset($_POST['registro']) or isset($_POST['sms'])){
if(isset($_POST['registro'])){$registro=$_POST['registro'];}
if(isset($_POST['sms'])){$sms=$_POST['sms'];}
	$i=0;
	$j=0;
	$asunto='Retraso injustificado en la devolución de material a la Biblioteca del Centro';
	$informa='Jefatura de Estudios';
	$grave='grave';
	$medida='Amonestación escrita';
	$expulsionaula='0';
	$enviado='1';
	$recibido='1';
	$causa='Otras';
	$accion='Envío de SMS';

	foreach ($_POST as $ide => $valor) {      
		if(($ide<>'registro') and (!empty( $valor)))
		{ 
?>

<form action="impresion.php" method="post"><? 
$envio='';
for($i=0; $i <= count($valor)-1; $i++)
{ 
$j+=1; //echo $valor[$i];
$duplicado= mysql_query ("select amonestacion from morosos where id=$valor[$i]");
$duplicados=mysql_fetch_array($duplicado);

if($duplicados[0]=='NO'){
	$envio='-'.$valor[$i];?> <input type="hidden" name="hola[]"
	value="<? echo $valor[$i];?>" /> 
	
	<? 

if ($registro) {
		$upd = mysql_query ("update morosos set amonestacion='SI' where id=$valor[$i]") or die ("No se ha podido actualizar el registro");
		//localizo el alumno a travÃ©s de la id de la tabla morosos.
	}
	$al=mysql_query ("select apellidos,nombre,curso from morosos where id=$valor[$i]") or die ("error al localizar alumno");
	while($alu=mysql_fetch_array($al)){

		$nombre=$alu[1];
		$apellido=$alu[0];
		$curso=$alu[2];
		//localizo la clave del alumno en Falumnos.
		$cla=mysql_query("select CLAVEAL, unidad from alma where NOMBRE='$nombre' and APELLIDOS='$apellido' and unidad = '$curso'");
		while($clav=mysql_fetch_array($cla)){

			$dia= date ('Y-m-d',time());
			$clave=$clav[0];// echo $clave.'---'. $dia;
			$unidad=$clav[1]; //echo $nivel;
			//insertamos, por fÃ­n, la fechorÃ­a
if ($registro) {
				$fechoria = mysql_query( "insert into Fechoria (CLAVEAL,FECHA,ASUNTO,NOTAS,INFORMA,grave,medida,expulsionaula,enviado,recibido) values ('" . $clave . "','" . $dia . "','" . $asunto . "','" . $asunto . "','" . $informa . "','" . $grave . "','" . $medida . "','" . $expulsionaula . "','" . $enviado . "','" . $recibido . "')") or die ("error al registrar fechorÃ­a");
				//ahora registramos la intervencion en la tabla tutorÃ­a, debido al tema de los SMS
				$tutoria=mysql_query ( "insert into tutoria (apellidos, nombre, tutor,unidad,observaciones,causa,accion,fecha, claveal,jefatura) values ('" . $apellido . "','" . $nombre . "','" . $informa . "','" . $unidad . "','" . $asunto . "','" . $causa . "','" . $accion . "','" . $dia . "','" . $clave . "','" . $recibido . "')" ) or die ("error al registrar accion en tabla tutoria");
			}
if ($sms) {
		mysql_query ("update morosos set sms='SI' where id=$valor[$i]") or die ("No se ha podido actualizar el registro SMS");
	}
			$alumno = mysql_query ( " SELECT distinct APELLIDOS, NOMBRE, unidad, CLAVEAL, alma.TELEFONO, alma.TELEFONOURGENCIA FROM alma WHERE claveal = '$clave'" );
			$rowa = mysql_fetch_array ( $alumno );
			echo "<table class='table table-striped'>";
			$apellidos = trim ( $rowa [0] );
			$nombre = trim ( $rowa [1] );
			$unidad = trim ( $rowa [2] );
			$claveal = trim ( $rowa [3] );
			$tfno = trim ( $rowa [4] );
			$tfno_u = trim ( $rowa [5] );
			// SMS
			$sms_n = mysql_query ( "select max(id) from sms" );
			$n_sms = mysql_fetch_array ( $sms_n );
			$extid = $n_sms [0] + 1;

			if (substr ( $tfno, 0, 1 ) == "6" or substr ( $tfno, 0, 1 ) == "7") {
				$mobile = $tfno;
			} else {
				$mobile = $tfno_u;
			}
			if ($registro) {
				$message = "Le comunicamos que su hijo/a ha cometido una falta contra las normas de Convivencia del Centro. Por favor, p&oacute;ngase en contacto con nosotros.";
			}
			else{
				$message = "Su hijo/a no ha devuelto material de la Biblioteca en el plazo indicado. Si no lo devuelve en los próximos días se le impondrá un parte disciplinario grave.";
			}
			
			mysql_query ( "insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$mobile','$message','$informa')" );
			$login = $usuario_smstrend;
			$password = $clave_smstrend;
			?>
<form name="enviar"
	action="http://www.smstrend.net/esp/sendMessageFromPost.oeg"
	target="ventanaForm" method="POST"
	enctype="application/x-www-form-urlencoded"><input name="login"
	type="hidden" value="<?
	echo $login;
		?>" /> <input name="password" type="hidden"
	value="<?
	echo $password;
		?>" /> <input name="extid" type="hidden"
	value="<?
	echo $extid;
		?>" /> <input name="tpoa" type="hidden" value="<? echo $nombre_corto; ?>" /> <input
	name="mobile" type="hidden" value="<?
	echo $mobile;
		?>" /> <input name="messageQty" type="hidden" value="GOLD" /> <input
	name="messageType" type="hidden" value="PLUS" /> <input name="message"
	type="hidden" value="<?
	echo $message;
		?>" maxlength="159"
	size="60" /></form>
<script>
enviarForm();
</script>
<?
		}
	}
}
}
if ($registro) {
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
 <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCI&Oacute;N:</legend>
Las amonestaciones se han registrado con &eacute;xito. Ahora debes pulsar en el bot&oacute;n, generar pdf, para poder imprimir las amonestaciones registradas..
	</div></div><br />';
}
elseif($sms){
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
 <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCI&Oacute;N:</legend>
Los mensajes SMS de aviso por retraso en la devolución de ejemplares de la Biblioteca han sido enviados correctamente (si en la pequeña ventana del navegador que aparece en la parte superior izquierda dice <b>OK</b>).
	</div></div><br />';
}

?>
<div align="center">
<button class="btn btn-primary" type="submit" name="impreso"
	value="impreso"><i class="fa fa-file-o  "></i> Imprimir
Amonestaciones en PDF</button>
</div>
</form>
<hr />
<? 
	}
	elseif ($j==0)     {
		echo '<div align="center"><div class="alert alert-danger alert-block fade in">
 <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCI&Oacute;N:</legend>
No se ha podido registrar la amonestaci&oacute;n porque no has elegido ning&uacute;n alumno de la lista. Vuelve atr&aacute;s para solucionarlo.
	</div></div><br />
<div align="center">
  	<input type="button" value="Volver atr&aacute;s" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
			</div>';			
	}
	}
}
?>
</div>
</div>
</div>
<? include ("../../pie.php"); ?>




