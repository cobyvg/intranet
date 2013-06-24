<?
 // Aula de Convivencia
  if($imprimir4)
  {
  	if (empty($horas)) {
		$horas = "123456";
  	}
  /*	if ($fechainicio == '00-00-0000' or $fechafin == '00-00-0000') {
  		$fechainicio = date ( 'd' ) . "-" . date ( 'm' ) . "-" . date ( 'Y' );
  		$fechafin = date ( 'd' ) . "-" . date ( 'm' ) . "-" . date ( 'Y' );
  	}*/
$fechaesp = explode("-",$fechainicio);
$inicio_aula = "$fechaesp[2]-$fechaesp[1]-$fechaesp[0]";
$fechaesp1 = explode("-",$fechafin);
$fin_aula = "$fechaesp1[2]-$fechaesp1[1]-$fechaesp1[0]";
  	if(empty($inicio_aula) OR empty($fin_aula) OR empty($convivencia)){
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No has escrito datos en <u>todos</u> los campos del formulario del Aula de Convivencia. Inténtalo de nuevo.
          </div></div>';
	}
	elseif (strstr($inicio_aula,"-")==FALSE OR strstr($fin_aula,"-")==FALSE)
	{
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
El formato de las fechas no es correcto. Lo correcto es "dia-mes-año" (p.ej. 15-10-2009). Inténtalo de nuevo.
          </div></div>';
	}
	else{
$actualizar ="UPDATE  Fechoria SET  recibido =  '1', aula_conv = '$convivencia', inicio_aula = '$inicio_aula', fin_aula = '$fin_aula', horas = '$horas' WHERE  Fechoria.id = '$id'"; 
mysql_query($actualizar);
 $result = mysql_query ("select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, 
  FALUMNOS.grupo, Fechoria.fecha, Fechoria.notas, Fechoria.asunto, Fechoria.informa, 
  Fechoria.grave, Fechoria.medida, listafechorias.medidas2, Fechoria.expulsion, Fechoria.tutoria, Fechoria.claveal, alma.padre, alma.domicilio, alma.localidad, alma.codpostal, alma.provinciaresidencia,  alma.telefono, alma.telefonourgencia from Fechoria, FALUMNOS, alma, listafechorias where Fechoria.claveal = alma.claveal and Fechoria.claveal = FALUMNOS.claveal and listafechorias.fechoria = Fechoria.asunto  and Fechoria.id = '$id' order by Fechoria.fecha DESC");

  if ($row = mysql_fetch_array($result))
        {
		$apellidos = $row[0];
		$nombre = $row[1];
		$nivel = $row[2];
		$grupo = $row[3];
		$fecha = $row[4];
		$notas = $row[5];
		$asunto = $row[6];
		$informa = $row[7];
		$grave = $row[8];
		$medida = $row[9];
		$medidas2 = $row[10];
		$expulsion = $row[11];
		$tutoria = $row[12];
		$claveal = $row[13];
		$padre = $row[14];
		$direccion = $row[15];
		$localidad = $row[16];
		$codpostal = $row[17];
		$provincia = $row[18];
		$tfno = $row[19];
		$tfno_u = $row[20];
		}
// SMS		
if ($mod_sms and $mens_movil == 'envia_sms') {
if((substr($tfno,0,1)=="6" or substr($tfno_u,0,1)=="6"))
{
$sms_n = mysql_query("select max(id) from sms");
$n_sms =mysql_fetch_array($sms_n);
$extid = $n_sms[0]+1;
$login=$usuario_smstrend;
$password=$clave_smstrend;;
if(substr($tfno,0,1)=="6"){$mobile=$tfno;}else{$mobile=$tfno_u;}
$message1 = "Le comunicamos que su hijo/a va a ser expulsado al Aula de Convivencia. ";
$message2= "Por favor, p&oacute;ngase en contacto con nosotros.";
$repe0 = mysql_query("select * from sms where telefono = '$mobile' and mensaje like '%$message1%' and profesor = '$tutor' and date(fecha) = date(now())");
if (mysql_num_rows($repe0)<"1") {
$mens_total=$message1.$message2;
mysql_query("insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$mobile','$mens_total','$tutor')");	
}
?>
<script language="javascript">
function enviarForm() 
{
ventana=window.open("", "ventanaForm", "top=100, left=100, toolbar=no,location=no, status=no,menubar=no,scrollbars=no, resizable=no, width=100,height=66,directories=no")
document.enviar.submit()
/*AQUâ€™ PUEDES PONER UN TIEMPO*/
/*ventana.close()*/
}
</script>
<form  name="enviar" action="http://www.smstrend.net/esp/sendMessageFromPost.oeg" target="ventanaForm" method="POST" enctype="application/x-www-form-urlencoded">   
	<input name="login" type="hidden" value="<? echo $login;?>" />
            <input name="password" type="hidden" value="<? echo $password;?>"  />   
            <input name="extid" type="hidden" value="<? echo $extid;?>" /> 
            <input name="tpoa" type="hidden" value="<? echo $nombre_corto; ?>" /> 
            <input name="mobile" type="hidden" value="<? echo $mobile;?>"/>
 	<input name="messageQty" type="hidden" value="GOLD" />
            <input name="messageType" type="hidden" value="PLUS" />        
	<input name="message" type="hidden" value="<?echo $mens_total;?>" maxlength="159" size="60"/>    
</form>
<?
if (mysql_num_rows($repe0)<"1") {
echo "
<script>
enviarForm();
</script>
";
}

}
	}
$fechaesp = explode("/",$inicio_aula);
$hoy = formatea_fecha($fecha);
$inicio1 = formatea_fecha($inicio_aula);
$fin1 = formatea_fecha($fin_aula);
$tutor="Jefatura de Estudios";
if(!(empty($tareas)))
{
$repe = mysql_query("select * from tareas_alumnos where claveal = '$claveal' and fecha = '$inicio_aula'");
if(mysql_num_rows($repe)=="0")
{
$insertar=mysql_query("INSERT tareas_alumnos (CLAVEAL,APELLIDOS,NOMBRE,NIVEL,GRUPO,FECHA,DURACION,PROFESOR, FIN) VALUES ('$claveal','$apellidos','$nombre','$nivel','$grupo', '$inicio_aula','$convivencia','$tutor', '$fin_aula')") or die ("Error: no se ha podido activar el informe:".mysql_error());
}
else
{
$mensaje = "Parece que ya hay un <span style='color:brown;'>Informe de Tareas</span> activado para esa fecha, y no queremos duplicarlo";
}
}
}  
}
if($imprimir5)
  {
  include("imprimir/convivencia.php");
  exit;
  }

if($submit){
	if(empty($inicio) OR empty($fin) OR empty($expulsion)){
		echo "$inicio --> $fin --> $expulsion";
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No has escrito datos en <u>todos</u> los campos del formulario de expulsión. Inténtalo de nuevo.
          </div></div>';
	}
		elseif (strstr($inicio,"-")==FALSE OR strstr($fin,"-")==FALSE)
	{
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
>El formato de las fechas no es correcto. Lo correcto es "dia-mes-año" (p.ej. 15-10-2009). Inténtalo de nuevo.
          </div></div>';
	}
	else{
if($inicio){ $inicio1 = explode("-",$inicio); $inicio = $inicio1[2] . "-" . $inicio1[1] ."-" . $inicio1[0];}
if($fin){ $fin1 = explode("-",$fin); $fin = $fin1[2] . "-" . $fin1[1] ."-" . $fin1[0];}
$actualizar ="UPDATE  Fechoria SET  expulsion =  '$expulsion', inicio = '$inicio', fin = '$fin' WHERE  Fechoria.id = '$id'"; 
//echo $actualizar;
mysql_query($actualizar);
$result = mysql_query ("select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, Fechoria.fecha, Fechoria.notas, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.medida, listafechorias.medidas2, Fechoria.expulsion, Fechoria.tutoria, Fechoria.claveal, alma.telefono, alma.telefonourgencia from Fechoria, FALUMNOS, listafechorias, alma where Fechoria.claveal = FALUMNOS.claveal and listafechorias.fechoria = Fechoria.asunto and FALUMNOS.claveal = alma.claveal and Fechoria.id = '$id' order by Fechoria.fecha DESC");
  if ($row = mysql_fetch_array($result))
        {
		$apellidos = $row[0];
		$nombre = $row[1];
		$nivel = $row[2];
		$grupo = $row[3];
		$expulsion = $row[11];
		$claveal = $row[13];
		$tfno = $row[14];
		$tfno_u = $row[15];
		}

// SMS
if ($mod_sms and $mens_movil == 'envia_sms') {
$sms_n = mysql_query("select max(id) from sms");
$n_sms =mysql_fetch_array($sms_n);
$extid = $n_sms[0]+1;
$login=$usuario_smstrend;
$password=$clave_smstrend;
if(substr($tfno,0,1)=="6"){$mobile=$tfno;}else{$mobile=$tfno_u;}	
$repe0 = mysql_query("select * from sms where telefono = '$mobile' and mensaje like '%$message%' and profesor = '$tutor' and date(fecha) = date(now())");
if (mysql_num_rows($repe0)<"1") {	
if ($mens_movil=="envia_sms")
	{

if((substr($tfno,0,1)=="6" or substr($tfno_u,0,1)=="6"))
	{
$message = "Le comunicamos que su hijo/a va a ser expulsado del Centro. Por favor, p&oacute;ngase en contacto con nosotros.";
mysql_query("insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$mobile','$message','$tutor')");
?>
<script language="javascript">
function enviarForm() 
{
ventana=window.open("", "ventanaForm", "top=100, left=100, toolbar=no,location=no, status=no,menubar=no,scrollbars=no, resizable=no, width=100,height=66,directories=no")
document.enviar.submit()
/*AQUâ€™ PUEDES PONER UN TIEMPO*/
/*ventana.close()*/
}
</script>
<form  name="enviar" action="http://www.smstrend.net/esp/sendMessageFromPost.oeg" target="ventanaForm" method="POST" enctype="application/x-www-form-urlencoded">   
			<input name="login" type="hidden" value="<? echo $login;?>" />
            <input name="password" type="hidden" value="<? echo $password;?>"  />   
            <input name="extid" type="hidden" value="<? echo $extid;?>" /> 
            <input name="tpoa" type="hidden" value="<? echo $nombre_corto; ?>" /> 
            <input name="mobile" type="hidden" value="<? echo $mobile;?>"/>
 			<input name="messageQty" type="hidden" value="GOLD" />
            <input name="messageType" type="hidden" value="PLUS" />        
			<input name="message" type="hidden" value="<?echo $message;?>" maxlength="159" size="60"/>    
</form>
<script>
enviarForm();
</script>
<?
$fecha2 = date('Y-m-d');
$tutor = "Jefatura de Estudios";
$causa = "Problemas de Convivencia";
$accion = "Envío de SMS";
mysql_query("insert into tutoria (apellidos, nombre, tutor,nivel,grupo,observaciones,causa,accion,fecha,jefatura) values ('".$apellidos."','".$nombre."','".$tutor."','".$nivel."','".$grupo."','".$message."','".$causa."','".$accion."','".$fecha2."','1')");
}
}
}
}
}
}
?> 