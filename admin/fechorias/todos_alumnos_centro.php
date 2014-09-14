<?
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>Atención:</h4>
			Registrar un problema de convivencia a todos los alumnos del Centro es algo que sólo puede hacer la Jefatura de Estudios. Por lo tanto, debes consultar con Jefatura esta posibilidad si lo consideras necesario.
          </div></div>';
exit();	
}
else{
// Control de errores
if (!$notas or !$grave or ($nombre == 'Selecciona un Alumno') or !$asunto or !$fecha or !$informa)
{
echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>Atención:</h4>
			No has introducido datos en alguno de los campos, y <strong>todos son obligatorios</strong>. Vuelve atrás e inténtalo de nuevo.          
			</div></div>';
exit();
}

foreach($nombre as $nombre_al) {
$tr = explode ( " --> ", $nombre_al );
		$claveal = $tr [1];
	
$alumno = mysqli_query($db_con, " SELECT distinct FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALUMNOS.nc, FALUMNOS.CLAVEAL, alma.TELEFONO, alma.TELEFONOURGENCIA FROM FALUMNOS, alma WHERE FALUMNOS.claveal = alma.claveal and FALUMNOS.claveal = '$claveal'");
$rowa = mysqli_fetch_array($alumno);
echo "<div class='oculto'><center><table class='tabla' style='padding:2px 10px;'>";
$apellidos = trim($rowa[0]);
$nombre = trim($rowa[1]);
$unidad = trim($rowa[2]);
$claveal = trim($rowa[4]);
$tfno = trim($rowa[5]);
$tfno_u = trim($rowa[6]);
// SMS
if(($grave == "grave" or $grave == "muy grave") and (substr($tfno,0,1)=="6" or substr($tfno,0,1)=="7" or substr($tfno_u,0,1)=="6" or substr($tfno_u,0,1)=="7"))
{
$sms_n = mysqli_query($db_con, "select max(id) from sms");
$n_sms =mysqli_fetch_array($sms_n);
$extid = $n_sms[0]+1;

if(substr($tfno,0,1)=="6" or substr ( $tfno, 0, 1 ) == "7"){$mobile=$tfno;}else{$mobile=$tfno_u;}
$message = "Le comunicamos que su hijo/a ha cometido una falta contra las normas de Convivencia del Centro. Por favor, p&oacute;ngase en contacto con nosotros.";
mysqli_query($db_con, "insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$mobile','$message','$informa')");
$login=$usuario_smstrend;
$password=$clave_smstrend;;
?>
<body>
<script language="javascript">
function enviarForm() 
{
ventana=window.open("", "ventanaForm", "top=100, left=100, toolbar=no,location=no, status=no,menubar=no,scrollbars=no, resizable=no, width=100,height=66,directories=no")
document.enviar.submit()
/*AQUÕ PUEDES PONER UN TIEMPO*/
/*ventana.close()*/
}
</script>
<form  name="enviar" action="http://www.smstrend.net/esp/sendMessageFromPost.oeg" target="ventanaForm" method="POST" enctype="application/x-www-form-urlencoded">   
			<input name="login" type="hidden" value="<? echo $login;?>" />
            <input name="password" type="hidden" value="<? echo $password;?>"  />   
            <input name="extid" type="hidden" value="<? echo $extid;?>" /> 
            <input name="tpoa" type="hidden" value="<? echo $nombre_corto; ?>" /> 
            <input name="mobile" type="hidden" value="<?echo $mobile;?>"/>
 			<input name="messageQty" type="hidden" value="GOLD" />
            <input name="messageType" type="hidden" value="PLUS" />        
			<input name="message" type="hidden" value="<?echo $message;?>" maxlength="159" size="60"/>    
</form>
<script>
enviarForm();
</script>
<?
$fecha2 = date('Y-m-d');
$observaciones = $message;
$accion = "Envío de SMS";
$causa = "Problemas de convivencia";
mysqli_query($db_con, "insert into tutoria (apellidos, nombre, tutor,unidad,observaciones,causa,accion,fecha, claveal) values ('".$apellidos."','".$nombre."','".$informa."','".$unidad."','".$observaciones."','".$causa."','".$accion."','".$fecha2."','".$claveal."')");
}
else
{
echo "<body>";
}
// Mensaje SMS a la base de datos
$dia = explode("-",$fecha);
$fecha2 = "$dia[2]-$dia[1]-$dia[0]";
$query="insert into Fechoria (CLAVEAL,FECHA,ASUNTO,NOTAS,INFORMA,grave,medida,expulsionaula) values ('".$claveal."','".$fecha2."','".$asunto."','".$notas."','".$informa."','".$grave."','".$medida."','".$expulsionaula."')";
mysqli_query($db_con, $query);
}
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El problema de convivencia se ha registrado correctamente para <strong>todos los Alumnos</strong> de este grupo.
          </div></div>';
?>

 <br /><INPUT class ='btn btn-primary' TYPE='button' VALUE='Volver atrás'
   onClick='history.back()'> </center>   
   <?
   include("../../pie.php");
   ?>
</body>
</html>
<?
}
?>