<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed');

// Cobntrol de faltas leves reiteradas
$rep0 = mysqli_query($db_con, "select id, Fechoria.claveal, count(*) as numero from Fechoria, FALUMNOS where Fechoria.claveal = FALUMNOS.claveal and unidad = '".$_SESSION['mod_tutoria']['unidad']."' and grave = 'Leve' and medida not like 'Sancionada' group by Fechoria.claveal");
while ($rep = mysqli_fetch_array($rep0)) {
	
	if ($rep[2] > 4) {
	$count_fech=1;		
	$claveal = $rep[1];	
	$alumno = mysqli_query($db_con, "SELECT distinct FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALUMNOS.nc, FALUMNOS.CLAVEAL, alma.TELEFONO, alma.TELEFONOURGENCIA FROM FALUMNOS, alma WHERE FALUMNOS.claveal = alma.claveal and FALUMNOS.claveal = '$claveal'" );
		
	$rowa = mysqli_fetch_array ( $alumno );
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
		$sms_n = mysqli_query($db_con, "select max(id) from sms" );
		$n_sms = mysqli_fetch_array ( $sms_n );
		$extid = $n_sms [0] + 1;
		
		if (substr ( $tfno, 0, 1 ) == "6") {
			$mobile = $tfno;
		} else {
			$mobile = $tfno_u;
		}
		$message = "Le comunicamos que su hijo/a ha cometido una falta contra las normas de Convivencia del Centro. Por favor, pongase en contacto con nosotros.";
		mysqli_query($db_con, "insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$mobile','$message','$informa')" );
		$login = $config['mod_sms_user'];
		$password = $config['mod_sms_pass'];
	}
?>	
<script>
function enviarForm()  {
	ventana = window.open("", "ventanaForm", "top=100, left=100, toolbar=no,location=no, status=no,menubar=no,scrollbars=no, resizable=no, width=100,height=66,directories=no");
	document.enviar.submit();
}
</script>
<form name="enviar" action="http://www.smstrend.net/esp/sendMessageFromPost.oeg" target="ventanaForm" method="POST" enctype="application/x-www-form-urlencoded">
	<input name="login" type="hidden" value="<?php echo $config['mod_sms_user']; ?>" />
	<input name="password" type="hidden" value="<?php echo $config['mod_sms_pass']; ?>" />
	<input name="extid" type="hidden" value="<?php echo $extid; ?>" />
	<input name="tpoa" type="hidden" value="<?php echo $config['mod_sms_id']; ?>" />
	<input name="mobile" type="hidden" value="<?php echo $mobile; ?>" />
	<input name="messageQty" type="hidden" value="GOLD" />
	<input name="messageType" type="hidden" value="PLUS" />
	<input name="message" type="hidden" value="<?php echo $message; ?>" maxlength="159" size="60" />
</form>

<script>
enviarForm();
</script>
<?
		$fecha2 = date ( 'Y-m-d' );
		$observaciones = "Le comunicamos que su hijo/a ha cometido una falta contra las normas de Convivencia del Centro. Por favor, p&oacute;ngase en contacto con nosotros.";
		$accion = "Envío de SMS";
		$causa = "Problemas de convivencia";
		mysqli_query($db_con, "insert into tutoria (apellidos, nombre, tutor,unidad,observaciones,causa,accion,fecha, claveal) values ('" . $apellidos . "','" . $nombre . "','" . $informa . "','".$_SESSION['mod_tutoria']['unidad']."','" . $observaciones . "','" . $causa . "','" . $accion . "','" . $fecha2 . "','" . $claveal . "')" );

	
	// Mensaje SMS a la base de datos
	$query = "insert into Fechoria (CLAVEAL,FECHA,ASUNTO,NOTAS,INFORMA,grave,medida,expulsionaula) values ('" . $claveal . "','" . $fecha2 . "','" . $asunto . "','" . $notas . "','" . $informa . "','grave','" . $medida . "','0')";
	mysqli_query($db_con, $query );	
	
	// Actualizamos la Fechoría para amortizarla
	$rep1 = mysqli_query($db_con, "select id from Fechoria where claveal = '$claveal' and grave = 'Leve' and medida not like 'Sancionada'");
	while ($rep11 = mysqli_fetch_array($rep1)) {
		mysqli_query($db_con, "update Fechoria set medida = 'Sancionada' where id = '$rep11[0]'");
	}	
	}

}

// Problemas varios de convivencia

$result1 = mysqli_query($db_con, "select distinct id, recibido, Fechoria.claveal, expulsionaula, expulsion, inicio, aula_conv, inicio_aula, fin_aula, Fechoria.fecha, Fechoria.medida from Fechoria, FALUMNOS where Fechoria.claveal = FALUMNOS.claveal and unidad = '".$_SESSION['mod_tutoria']['unidad']."' and medida = 'Amonestación escrita'");
if(mysqli_num_rows($result1)>0)
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
$alumno1 = mysqli_query($db_con, "select nombre, apellidos from alma where claveal = '$claveal'");
$alumno0 = mysqli_fetch_array($alumno1);
$alumno = $alumno0[1].", ".$alumno0[0];

// Expulsión al Aula de Convivencia
if($aula > 0 and strtotime($fechareg) <= strtotime($hoy) and strtotime($inicioaula) >= strtotime($hoy)){
	$count_fech=1;
	?>

<div class="alert alert-warning">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
	<h4><?php echo $alumno; ?> ha sido expulsado al Aula de convivencia</h4>
	<p>El siguiente alumno ha sido expulsado al Aula de convivencia entre los días <strong><?php echo $inicioaula; ?></strong> y <strong><?php echo $finaula; ?></strong>. Ponte en contacto con Jefatura de estudios si necesitas detalles.</p>
	
	<br>

	<a class="btn btn-primary btn-sm" href="//<?php echo $config['dominio']; ?>/intranet/admin/fechorias/detfechorias.php?claveal=<?php echo $claveal; ?>&id=<?php echo $id; ?>">Ver detalles</a>
</div>

<?php 
}

// Expulsión del Centro
if($expulsion > 0 and $fechareg <= $hoy and $inicio >= $hoy) {
	$count_fech=1;
 	?>
    <?
$inicio= explode("-",$row1[5]);
$fechainicio = $inicio[2] . "-" . $inicio[1] . "-" . $inicio[0];
?> 

<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
	<h4><?php echo $alumno; ?> ha sido expulsado del centro</h4>
	<p>El alumno/a ha sido expulsado del centro. Ponte en contacto con Jefatura de estudios si necesitas detalles.</p>
	
	<br>

	<a class="btn btn-primary btn-sm" href="//<?php echo $config['dominio']; ?>/intranet/admin/fechorias/detfechorias.php?claveal=<?php echo $claveal; ?>&id=<?php echo $id; ?>">Ver detalles</a>
</div>

<?php 
}
if($recibido == 0)
{ 
if($expulsionaula == 1 and $expulsion == "0")
{
$count_fech=1;
?> 

<div class="alert alert-warning">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
	<h4><?php echo $alumno; ?> ha sido expulsado del aula</h4>
	<p>El alumno/a ha sido expulsado del aula y está pendiente de la amonestación escrita del tutor.</p>
	
	<br>

	<form method="post" action="//<?php echo $config['dominio']; ?>/intranet/admin/fechorias/imprimir/expulsionaula.php">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<a class="btn btn-primary btn-sm" href="//<?php echo $config['dominio']; ?>/intranet/admin/fechorias/detfechorias.php?claveal=<?php echo $claveal; ?>&id=<?php echo $id; ?>">Ver detalles</a>
		<button type="submit" class="btn btn-primary btn-sm" name="amonestacion">Imprimir parte de expulsión</button>
	</form>
</div>

<?php } 
elseif($expulsionaula == 0 and $expulsion == "0"  and $medida == "Amonestación escrita") 
{
	$count_fech=1;
//Amonestación Escrita	
	?>
	
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
	<h4><?php echo $alumno; ?> tiene una amonestación escrita</h4>
	<p>El alumno/a está pendiente de la amonestación escrita del tutor.</p>
	
	<br>

	<form method="post" action="//<?php echo $config['dominio']; ?>/intranet/admin/fechorias/imprimir/amonestescrita.php">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<a class="btn btn-primary btn-sm" href="//<?php echo $config['dominio']; ?>/intranet/admin/fechorias/detfechorias.php?claveal=<?php echo $claveal; ?>&id=<?php echo $id; ?>">Ver detalles</a>
		<button type="submit" class="btn btn-primary btn-sm" name="amonestacion">Imprimir amonestación escrita</button>
	</form>
</div>


<?php }?>
<?php 
}
}while($row1 = mysqli_fetch_array($result1));
?>
<?php
}

?>
