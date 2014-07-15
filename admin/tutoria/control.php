<?
if (!($unidad)) {
$unidad = $_SESSION ['s_unidad'];
}

// Cobntrol de faltas leves reiteradas
$rep0 = mysql_query("select id, Fechoria.claveal, count(*) as numero from Fechoria, FALUMNOS where Fechoria.claveal = FALUMNOS.claveal and unidad = '$unidad' and grave = 'Leve' and medida not like 'Sancionada' group by Fechoria.claveal");
while ($rep = mysql_fetch_array($rep0)) {
	
	if ($rep[2] > 4) {
		$claveal = $rep[1];	
		$alumno = mysql_query ( "SELECT distinct FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALUMNOS.nc, FALUMNOS.CLAVEAL, alma.TELEFONO, alma.TELEFONOURGENCIA FROM FALUMNOS, alma WHERE FALUMNOS.claveal = alma.claveal and FALUMNOS.claveal = '$claveal'" );
		
	$rowa = mysql_fetch_array ( $alumno );
	$asunto = "Reiteración en el mismo trimestre de cinco o más faltas leves";
	$medida = "Amonestación escrita";
	$apellidos = trim ( $rowa [0] );
	$nombre = trim ( $rowa [1] );
	$unidad = trim ( $rowa [2] );
	$claveal = trim ( $rowa [4] );
	$tfno = trim ( $rowa [5] );
	$tfno_u = trim ( $rowa [6] );
	$informa = $_SESSION ['profi'];
	$grave = 'grave';
	// SMS
	$hora_f = date ( "G" );
	if (($grave == "grave" or $grave == "muy grave") and (substr ( $tfno, 0, 1 ) == "6" or substr ( $tfno, 0, 1 ) == "7" or substr ( $tfno_u, 0, 1 ) == "6" or substr ( $tfno_u, 0, 1 ) == "7") and $hora_f > '8' and $hora_f < '19') {
		$sms_n = mysql_query ( "select max(id) from sms" );
		$n_sms = mysql_fetch_array ( $sms_n );
		$extid = $n_sms [0] + 1;
		
		if (substr ( $tfno, 0, 1 ) == "6") {
			$mobile = $tfno;
		} else {
			$mobile = $tfno_u;
		}
		$message = "Le comunicamos que su hijo/a ha cometido una falta contra las normas de Convivencia del Centro. Por favor, pongase en contacto con nosotros.";
		mysql_query ( "insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$mobile','$message','$informa')" );
		$login = $usuario_smstrend;
		$password = $clave_smstrend;
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
<form name="enviar"
	action="http://www.smstrend.net/esp/sendMessageFromPost.oeg"
	target="ventanaForm" method="POST"
	enctype="application/x-www-form-urlencoded">

<input name="login"
	type="hidden" value="<?
		echo $usuario_smstrend;
		?>" /> <input name="password" type="hidden"
	value="<?
		echo $clave_smstrend;
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
	size="60" />
		</form>
<script>
enviarForm();
</script>
<?
		$fecha2 = date ( 'Y-m-d' );
		$observaciones = "Le comunicamos que su hijo/a ha cometido una falta contra las normas de Convivencia del Centro. Por favor, p&oacute;ngase en contacto con nosotros.";
		$accion = "Envío de SMS";
		$causa = "Problemas de convivencia";
		mysql_query ( "insert into tutoria (apellidos, nombre, tutor,unidad,observaciones,causa,accion,fecha, claveal) values ('" . $apellidos . "','" . $nombre . "','" . $informa . "','" . $unidad . "','" . $observaciones . "','" . $causa . "','" . $accion . "','" . $fecha2 . "','" . $claveal . "')" );

	
	// Mensaje SMS a la base de datos
	$query = "insert into Fechoria (CLAVEAL,FECHA,ASUNTO,NOTAS,INFORMA,grave,medida,expulsionaula) values ('" . $claveal . "','" . $fecha2 . "','" . $asunto . "','" . $notas . "','" . $informa . "','grave','" . $medida . "','0')";
	mysql_query ( $query );	
	
	// Actualizamos la Fechoría para amortizarla
	$rep1 = mysql_query("select id from Fechoria where claveal = '$claveal' and grave = 'Leve' and medida not like 'Sancionada'");
	while ($rep11 = mysql_fetch_array($rep1)) {
		mysql_query("update Fechoria set medida = 'Sancionada' where id = '$rep11[0]'");
	}	
	}

}
?>
<?
// Expulsión al Aula de Convivencia
$result1 = mysql_query ("select distinct id, recibido, Fechoria.claveal, expulsionaula, expulsion, inicio, aula_conv, inicio_aula, fin_aula, Fechoria.fecha, Fechoria.medida from Fechoria, FALUMNOS where Fechoria.claveal = FALUMNOS.claveal and unidad = '$unidad' and medida = 'Amonestación escrita'");
if($row1 = mysql_fetch_array($result1))
{
	do
	{
$id=$row1[0];
$recibido=$row1[1];
$claveal=$row1[2];
$expulsionaula=$row1[3];
$expulsion=$row1[4];
$inicio=$row1[5];
$aula=$row1[6];
$fechareg=$row1[9];
$inicioaula=$row1[7];
$finaula=$row1[8];
$medida=$row1[10];
// El Tutor no ha recibido el mensaje.
$hoy = date('Y')."-".date('m')."-".date('d');
$alumno1 = mysql_query("select nombre, apellidos from alma where claveal = '$claveal'");
$alumno0 = mysql_fetch_array($alumno1);
$alumno = $alumno0[1].", ".$alumno0[0];
if($aula > 0 and strtotime($fechareg) <= strtotime($hoy) and strtotime($inicioaula) >= strtotime($hoy)){
	?>
    <div class="well">
<p class="lead"><i class="fa fa-exclamation-triangle"> </i> Tarea pendiente de Tutoría</p>
<hr /><div align="left"><div class="alert alert-danger alert-block fade in" style="max-width:600px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El siguiente alumno ha sido expulsado al <strong>Aula de Convivencia</strong> entre los días <strong><? echo $inicioaula;?></strong> y <strong><? echo $finaula;?></strong>. Ponte en contacto con Jefatura de Estudios si necesitas detalles.
<br /><br /><pre> <strong><? echo $alumno;?></strong>&nbsp;&nbsp;<A HREF='http://<? echo $dominio;?>/intranet/admin/fechorias/detfechorias.php?claveal=<? echo $claveal;?>&id=<? echo $id;?>'><i class="fa fa-search" title="ver detalles"> </i></A> </pre>
</div></div> </div>
<? 
}

// Expulsión del Centro
if($expulsion > 0 and $fechareg <= $hoy and $inicio >= $hoy) {
 	?>
    <?
$inicio= explode("-",$row1[5]);
$fechainicio = $inicio[2] . "-" . $inicio[1] . "-" . $inicio[0];
?> 
<div class="well">
<p class="lead"><i class="fa fa-exclamation-triangle"> </i> Tarea pendiente de Tutoría</p>
<br /><div align="left"><div class="alert alert-danger alert-block fade in" style="max-width:600px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El siguiente alumno ha sido <strong>expulsado del Centro</strong> . Ponte en contacto con Jefatura de Estudios si necesitas detalles.
<br /><br /><pre> <strong><? echo $alumno;?></strong>&nbsp;&nbsp;<A HREF='http://<? echo $dominio;?>/intranet/admin/fechorias/detfechorias.php?claveal=<? echo $claveal;?>&id=<? echo $id;?>'><i class="fa fa-search" title="ver detalles"> </i></A> </pre>
</div></div> </div>
<? 
}
if($recibido == 0)
{ 
if($expulsionaula == 1 and $expulsion == "0")
{?> 
<div class="well">
<p class="lead"><i class="fa fa-exclamation-triangle"> </i> Tarea pendiente de Tutoría</p>
<hr />
<div align="left"><div class="alert alert-warning alert-block fade in" style="max-width:600px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El siguiente alumno ha sido <strong>expulsado del Aula</strong> y está pendiente de la Amonestación escrita del Tutor.<strong> Debes imprimir una copia de la carta, firmarla y entregarla en la Jefatura de Estudios</strong>.
<br /><br /><pre> <strong><? echo $alumno;?></strong>&nbsp;&nbsp;<A HREF='http://<? echo $dominio;?>/intranet/admin/fechorias/detfechorias.php?claveal=<? echo $claveal;?>&id=<? echo $id;?>'><i class="fa fa-search" title="ver detalles"> </i></A> </pre>
<br />
<form action="http://<? echo $dominio;?>/intranet/admin/fechorias/imprimir/expulsionaula.php">
<input name="id" type="hidden" value="<? echo $id; ?>" />
<input name="amonestacion" type="submit" value="Imprimir Parte de Expulsión del Aula" class="btn btn-primary" />
</form>
</div></div> </div>

<? } 
elseif($expulsionaula == 0 and $expulsion == "0"  and $medida == "Amonestación escrita") 
{
	//echo "$id<br>";
//Amonestación Escrita	
	?>
<div class="well alert alert-warning alert-block fade in" style="max-width:600px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
<p class="lead"><i class="fa fa-exclamation-triangle"> </i> Tarea pendiente de Tutoría</p>
<hr /><div align="left">
El siguiente alumno está pendiente de la <strong>Amonestación escrita</strong> del Tutor. <strong>Debes imprimir una copia de la carta, firmarla y entregarla en la Jefatura de Estudios</strong>.
<br /><br /><pre> <strong><? echo $alumno;?></strong>&nbsp;&nbsp;<A HREF='http://<? echo $dominio;?>/intranet/admin/fechorias/detfechorias.php?claveal=<? echo $claveal;?>&id=<? echo $id;?>'><i class="fa fa-search" title="ver detalles"> </i></A> </pre>
<br />
<form action="http://<? echo $dominio;?>/intranet/admin/fechorias/imprimir/amonestescrita.php">
<input name="id" type="hidden" value="<? echo $id; ?>" />
<input name="amonestacion" type="submit" value="Imprimir Amonestación escrita" class="btn btn-primary" />
</form>
</div></div>
<? }?>
<? 
}
}while($row1 = mysql_fetch_array($result1));
}
?>
