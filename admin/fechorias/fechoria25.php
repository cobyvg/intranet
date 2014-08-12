<?
session_start ();
include ("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
?>

<?
include ("../../menu.php");
include ("menu.php");
?>
<div class="container">
<div class="page-header">
  <h2>Problemas de Convivencia <small> Informe del alumno</small></h2>
</div>
<br />

<div class="row">

<div class="col-sm-10 col-sm-offset-1">	

<div align="center">
 <?
$notas = $_POST['notas']; $grave = $_POST['grave'];$nombre = $_POST['nombre']; $asunto = $_POST['asunto'];$fecha = $_POST['fecha'];$informa = $_POST['informa']; $medidaescr = $_POST['medidaescr']; $medida = $_POST['medida']; $expulsionaula = $_POST['expulsionaula']; $id = $_POST['id']; $claveal = $_POST['claveal'];

$tr0 = explode ( " --> ", $nombre );
$claveal0 = $tr0[1];
$dia0 = explode ( "-", $fecha );
$fecha3 = "$dia0[2]-$dia0[1]-$dia0[0]";
$ya_esta = mysql_query("select claveal, fecha, grave, asunto, notas, informa from Fechoria where claveal = '$claveal0' and fecha = '$fecha3' and grave = '$grave' and asunto = '$asunto' and informa = '$informa'");

if (mysql_num_rows($ya_esta)>0) {
		echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <legend>Atenci&oacute;n:</legend>
            Ya hay un problema de convivencia registrado que contiene los mismos datos que estás enviando, y no queremos repetirlos... .
          </div></div><br />';
		$back=2;
}
else{
 	// Control de errores
	if (! $notas or ! $grave or ($nombre == 'Selecciona un Alumno') or ! $asunto or ! $fecha or ! $informa) {
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
            No has introducido datos en alguno de los campos, y <strong>todos son obligatorios</strong>.<br> Vuelve atrás, rellena los campos vacíos e inténtalo de nuevo.
          </div></div>';
		  echo " <br />
<INPUT class='btn btn-primary' TYPE='button' VALUE='Volver atrás'
	onClick='history.back()'>";
			exit ();			
	}
 	if (($grave == 'grave' OR $grave == 'muy grave') AND strlen ($notas) < '60' ) {
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
            La descripción de lo sucedido es demasiado breve. Es necesario que proporciones más detalles de lo ocurrido para que Jefatura de Estudios pueda hacerse una idea precisa del suceso.<br />Vuelve atrás e inténtalo de nuevo.
          </div></div>';
		  echo " <br />
<INPUT class='btn btn-primary' TYPE='button' VALUE='Volver atrás'
	onClick='history.back()'>";
			exit ();		
 	}
	if ($grave == 'leve' AND strlen ($notas) < '25' ) {
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
            La descripción de lo sucedido es demasiado breve. Es necesario que proporciones más detalles de lo ocurrido para que Jefatura de Estudios pueda hacerse una idea precisa del suceso.<br />Vuelve atrás e inténtalo de nuevo.
          </div></div>';
		  echo " <br />
<INPUT class='btn btn-primary' TYPE='button' VALUE='Volver atrás'
	onClick='history.back()'>";
			exit ();		
 	}
	if ($nombre == "Todos los alumnos") {
		include ("todos_alumnos.php");
		exit ();
	}
	if (empty ( $claveal )) {
		$tr = explode ( " --> ", $nombre );
		$claveal = $tr [1];
	}
	
	if ($unidad == "Cualquiera") {
		include ("todos_alumnos_centro.php");
		exit ();
	}
	$alumno = mysql_query ( " SELECT distinct FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALUMNOS.nc, FALUMNOS.CLAVEAL, alma.TELEFONO, alma.TELEFONOURGENCIA FROM FALUMNOS, alma WHERE FALUMNOS.claveal = alma.claveal and FALUMNOS.claveal = '$claveal'" );
	$rowa = mysql_fetch_array ( $alumno );
	echo "<table class='tabla' style='padding:2px 10px;'>";
	$apellidos = trim ( $rowa [0] );
	$nombre = trim ( $rowa [1] );
	$unidad = trim ( $rowa [2] );
	$claveal = trim ( $rowa [4] );
	$tfno = trim ( $rowa [5] );
	$tfno_u = trim ( $rowa [6] );
	// SMS
	$hora_f = date ( "G" );
	if (($grave == "grave" or $grave == "muy grave") and (substr ( $tfno, 0, 1 ) == "6" or substr ( $tfno, 0, 1 ) == "7" or substr ( $tfno_u, 0, 1 ) == "6" or substr ( $tfno_u, 0, 1 ) == "7") and $hora_f > '8' and $hora_f < '17') {
		$sms_n = mysql_query ( "select max(id) from sms" );
		$n_sms = mysql_fetch_array ( $sms_n );
		$extid = $n_sms [0] + 1;
		
		if (substr ( $tfno, 0, 1 ) == "6" or substr ( $tfno, 0, 1 ) == "6") {
			$mobile = $tfno;
		} else {
			$mobile = $tfno_u;
		}
		$message = "Su hijo/a ha cometido una falta contra las normas de convivencia del Centro. Hable con su hijo/a y, ante cualquier duda, consulte en http://".$dominio;
		mysql_query ( "insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$mobile','$message','$informa')" );
		$login = $usuario_smstrend;
		$password = $clave_smstrend;
		;
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
		$fecha2 = date ( 'Y-m-d' );
		$observaciones = $message;
		$accion = "Envío de SMS";
		$causa = "Problemas de convivencia";
		mysql_query ( "insert into tutoria (apellidos, nombre, tutor,unidad,observaciones,causa,accion,fecha, claveal) values ('" . $apellidos . "','" . $nombre . "','" . $informa . "','" . $unidad ."','" . $observaciones . "','" . $causa . "','" . $accion . "','" . $fecha2 . "','" . $claveal . "')" );
	} else {
		echo "<body>";
	}
	
	// Mensaje SMS a la base de datos
	

	printf ("<legend class='text-info'>$rowa[1] $rowa[0] --> $rowa[2]</legend>");
	$dia = explode ( "-", $fecha );
	$fecha2 = "$dia[2]-$dia[1]-$dia[0]";
	$query = "insert into Fechoria (CLAVEAL,FECHA,ASUNTO,NOTAS,INFORMA,grave,medida,expulsionaula) values ('" . $claveal . "','" . $fecha2 . "','" . $asunto . "','" . $notas . "','" . $informa . "','" . $grave . "','" . $medida . "','" . $expulsionaula . "')";
	mysql_query ( $query );
	$nfechoria = "select max(id) from Fechoria where claveal = '$claveal'";
	$nfechoria0 = mysql_query ( $nfechoria );
	$nfechoria1 = mysql_fetch_row ( $nfechoria0 );
	$id = $nfechoria1 [0];
	echo "<table class='table table-striped' style='width:940px;'>";
	echo "<tr>
		<th>Fecha</th>
		<th>Tipo</th>
		<th>Informa</th>
		<th>Gravedad</th>
		<th></th>
		</tr>";
	// Consulta de datos del alumno.
	$result = mysql_query ( "select distinct FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, FALUMNOS.nc,
  Fechoria.fecha, Fechoria.notas, Fechoria.asunto, Fechoria.informa, Fechoria.claveal, Fechoria.grave, Fechoria.id from Fechoria, 
  FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and FALUMNOS.claveal = '$claveal' and Fechoria.fecha >= '$inicio_curso' 
  order by Fechoria.fecha DESC, Fechoria.grave, FALUMNOS.unidad, FALUMNOS.apellidos" );
	
	while ( $row = mysql_fetch_array ( $result ) ) {
		$claveal = $row [8];
		//print $claveal;
		$numero = mysql_query ( "select claveal from Fechoria where claveal = '$claveal' and Fechoria.fecha >= '$inicio_curso'" );
		$rownumero = mysql_num_rows ( $numero );
		$rowcurso = $row [2];
		$rowalumno = $row [0] . ",&nbsp;" . $row [1];
		echo "<tr>
	<td nowrap>$row[4]</td>
	<td>$row[6]</td>
	<td>$row[7]</td>
	<td>$row[9]</td>
	<td nowrap><a href='detfechorias.php?id= $row[10]&claveal=$claveal'><i class='fa fa-search' title='Detalles'></i></a>&nbsp;&nbsp;<a href='delfechorias.php?id= $row[10]'><i class='fa fa-trash-o' title='Borrar' data-bb='confirm-delete'></i></a></td>
	</tr>";
	}
	echo "</table>\n";
	$back=1;
}
	?>
 <br />
<a href="infechoria.php" class='btn btn-primary'>Registrar otro problema</a>
    </div>
    </div>
    </div>
    </div>
 
<? include("../../pie.php");?>
    </body>
</html>
