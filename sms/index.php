<?
session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'2') == TRUE) and !(stristr($_SESSION['cargo'],'6') == TRUE) and !(stristr($_SESSION['cargo'],'7') == TRUE) and !(stristr($_SESSION['cargo'],'8') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
include("../menu.php");
if (isset($_GET['submit0'])) {$submit0 = $_GET['submit0'];}elseif (isset($_POST['submit0'])) {$submit0 = $_POST['submit0'];}else{$submit0="";}
if (isset($_GET['nivel'])) {$nivel = $_GET['nivel'];}elseif (isset($_POST['nivel'])) {$nivel = $_POST['nivel'];}else{$nivel="";}
if (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];}elseif (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];}else{$grupo="";}
if (isset($_GET['text'])) {$text = $_GET['text'];}elseif (isset($_POST['text'])) {$text = $_POST['text'];}else{$text="";}
if (isset($_GET['causa'])) {$causa = $_GET['causa'];}elseif (isset($_POST['causa'])) {$causa = $_POST['causa'];}else{$causa="";}
if (isset($_GET['nombre'])) {$nombre = $_GET['nombre'];}elseif (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];}else{$nombre="";}
if (isset($_GET['login'])) {$login = $_GET['login'];}elseif (isset($_POST['login'])) {$login = $_POST['login'];}else{$login="";}
if (isset($_GET['password'])) {$password = $_GET['password'];}elseif (isset($_POST['password'])) {$password = $_POST['password'];}else{$password="";}
if (isset($_GET['extid'])) {$extid = $_GET['extid'];}elseif (isset($_POST['extid'])) {$extid = $_POST['extid'];}else{$extid="";}
if (isset($_GET['tpoa'])) {$tpoa = $_GET['tpoa'];}elseif (isset($_POST['tpoa'])) {$tpoa = $_POST['tpoa'];}else{$tpoa="";}
if (isset($_GET['mobile'])) {$mobile = $_GET['mobile'];}elseif (isset($_POST['mobile'])) {$mobile = $_POST['mobile'];}else{$mobile="";}
if (isset($_GET['messageQty'])) {$messageQty = $_GET['messageQty'];}elseif (isset($_POST['messageQty'])) {$messageQty = $_POST['messageQty'];}else{$messageQty="";}
if (isset($_GET['messageType'])) {$messageType = $_GET['messageType'];}elseif (isset($_POST['messageType'])) {$messageType = $_POST['messageType'];}else{$messageType="";}

?>
<script>
function contar(form,name) {
  n = document.forms[form][name].value.length;
  t = 160;
  if (n > t) {
    document.forms[form][name].value = document.forms[form][name].value.substring(0, t);
  }
  else {
    document.forms[form]['result'].value = t-n;
  }
}
</script> 
<br />
 <div align=center>
  <div class="page-header" align="center">
  <h2>SMS <small> Envío de mensajes</small></h2>
</div>
<br />

<?
 if ($mod_sms) {
// variables(); 
// Procesado de los datos del Formulario
if($submit0 == "Enviar SMS")
{
	if(empty($causa)){
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
No has seleccionado ninguna Causa del Mensaje.<br />Vuelve atrás, selecciónala e inténtalo de nuevo.
          </div></div>';
		  exit();
}
if(empty($text)){
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
No has escrito ningún texto para el Mensaje.<br />Vuelve atrás, redacta el texto e inténtalo de nuevo.
          </div></div>';
		  exit();
}
  	if(strlen($text) > "2")
	{ 
	if($nombre)
	{
	foreach($nombre as $tel)
	{
	$trozos = explode(" --> ",$tel);
	$claveal = trim($trozos[0]);
	$tel0 = mysql_query("select telefono, telefonourgencia, apellidos, nombre, alma.nivel, alma.grupo, tutor from alma, FTUTORES where FTUTORES.nivel = alma.nivel and FTUTORES.grupo = alma.grupo and claveal = '$claveal'");
	
	$tel1 = mysql_fetch_array($tel0);
	$tfno = $tel1[0];	
	$tfno_u = $tel1[1];
	$apellidos = $tel1[2];
	$nombre = $tel1[3];
	$nivel = $tel1[4];
	$grupo = $tel1[5];
	$tutor_mens = $tel1[6];
	if(substr($tfno,0,1)=="6"){$mobil=$tfno;}elseif(substr($tfno_u,0,1)=="6" and !(substr($tfno,0,1)=="6")){$mobil=$tfno_u;}else{$mobil="";}
	if (strlen($mobil)>2) {
		$mobile.=$mobil.",";
	}
	if(stristr($_SESSION['cargo'],'1') == TRUE){$tuto="Jefatura de Estudios";}else{$tuto=$profe;}
$fecha2 = date('Y-m-d');
$observaciones = $text;
$accion = "Envío de SMS";
mysql_query("insert into tutoria (apellidos, nombre, tutor,nivel,grupo,observaciones,causa,accion,fecha,claveal) values ('".$apellidos."','".$nombre."','".$tuto."','".$nivel."','".$grupo."','".$observaciones."','".$causa."','".$accion."','".$fecha2."','".$claveal."')");

// Mensaje al Tutor
if (stristr($_SESSION['cargo'],'1') == TRUE) {
	$query0="insert into mens_texto (asunto,texto, origen) values ('Envío de SMS desde Jefatura de Estudios a los padres de ".$nombre." ".$apellidos."','".$observaciones."','".$profe."')";
mysql_query($query0);
$id0 = mysql_query("select id from mens_texto where asunto = 'Envío de SMS desde Jefatura de Estudios a los padres de ".$nombre." ".$apellidos."' and texto = '$observaciones' and origen = '$profe'");
$id1 = mysql_fetch_array($id0);
$id = $id1[0];
$query1="insert into mens_profes (id_texto, profesor) values ('".$id."','".$tutor_mens."')";
mysql_query($query1);
}

	}
	$mobile=substr($mobile,0,strlen($mobile)-1);
	}
else
{
	echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>ATENCIÓN:</strong>
No has seleccionado ningún alumno para el envío de SMS.<br />Vuelve atrás, selecciónalo e inténtalo de nuevo.
          </div></div>';
		  exit();
}
$sms_n = mysql_query("select max(id) from sms");
$n_sms =mysql_fetch_array($sms_n);
$extid = $n_sms[0]+1;
?>
<script language="javascript">
function enviarForm() /*el formulario se llama crear*/
{
ventana=window.open("", "ventanaForm", "top=100, left=100,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=100,height=66,directories=no")
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
			<input name="message" type="hidden" value="<?echo $text;?>" maxlength="159" size="60"/>    
</form>
<script>
enviarForm();
</script>

<?
mysql_query("insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$mobile','$text','$profe')");
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El mensaje SMS se ha enviado correctamente.<br>Una nueva acción tutorial ha sido también registrada.
          </div></div>';
}
}
else
{
	 if((!(empty($nivel)) and !(empty($grupo))) or (stristr($_SESSION['cargo'],'1') == TRUE)){
		?>
<div class="row-fluid">
 <div class="span2"></div>
<div class="span4">
        <?
	}
	else{
	echo '<div align="center" style="width:400px;">';	
	}
?>
<div class="well well-large" align="left">
<form method="post" action="index.php" name="nameform" class="form-vertical">

      <? if(stristr($_SESSION['cargo'],'2') == TRUE){} else{ ?>
      <label>Nivel: 
		<select  name="nivel" class="input-small" onChange="submit()">
          <option><? echo $nivel;?></option>
          <? if(stristr($_SESSION['cargo'],'1') == TRUE){echo "<option>Cualquiera</option>";} ?>
          <? nivel(); ?>
        </select><? }?>
      <? if(stristr($_SESSION['cargo'],'2') == TRUE){} else{ ?>
      &nbsp;&nbsp;&nbsp;Grupo: <select name="grupo" onChange="submit()" class="input-small">
          <option><? echo $grupo;
// Si queremos que aparezcan los alumnos de un Nivel, y no sólo los de un grupo, descomentar lo siguiente.
          
//          if (strlen($grupo)>0) {
//          	$grup=" and grupo = '$grupo'";
//          }
          ?></option>
          <? 
          grupo($nivel);
          ?>
        </select>
		</label>
		<? }?>  
          	<label>Causa<br />
	<select name="causa" class="input-block-level">
 <? if(stristr($_SESSION['cargo'],'8') == TRUE){?>
		    <option><? echo $causa; ?></option>
		    <option>Orientación académica y profesional</option>
		    <option>Evoluci&oacute;n acad&eacute;mica</option>
		    <option>T&eacute;cnicas de estudio</option>
            <option>Problemas de convivencia</option>
            <option>Dificultades de integraci&oacute;n</option>
            <option>Problemas familiares, personales</option>
            <option>Dificultades de Aprendizaje</option>
            <option>Faltas de Asistencia</option>
            <option>Otras</option>
<? } else{ ?>
            <option><? echo $causa; ?></option>
            <option>Estado general del Alumno</option>
            <option>Evoluci&oacute;n acad&eacute;mica</option>
            <option>Faltas de Asistencia</option>
            <option>Problemas de convivencia</option>
            <option>Otras</option>
<? } ?>        
	</select>
    </label>
<?
if(empty($text)){$text = "";}
echo "<label>Texto del mensaje<br />
<TEXTAREA name='text' class='input-block-level' rows='4'  onkeydown=\"contar('nameform','text')\" onkeyup=\"contar('nameform','text')\">$text</TEXTAREA></label><br />
		<p class='help-block'>Caracteres restantes:&nbsp; <INPUT name=result value=160 class='input-small' readonly='true'></p>";
$sms_n = mysql_query("select max(id) from sms");
$n_sms =mysql_fetch_array($sms_n);
$extid = $n_sms[0]+1;
?>
      	
      	<input name="login" type="hidden" value="<?  echo $usuario_smstrend;?>" />
        <input name="password" type="hidden" value="<?  echo $clave_smstrend;?>"  />
        <input name="extid" type="hidden" value="<? echo $extid;?>" />
        <input name="tpoa" type="hidden" value="<? echo $nombre_corto; ?>" />
        <input name="messageQty" type="hidden" value="GOLD" />
        <input name="messageType" type="hidden" value="PLUS" />
        <br /><input type="submit" name="submit0" value="Enviar SMS" class="btn btn-primary"/>

  <?	  
  if((!(empty($nivel)) and !(empty($grupo))) or (stristr($_SESSION['cargo'],'1') == TRUE))
	    {	
		?>
</div>
</div>
<div class="well span3 pull-left">
<legend>Alumnos</legend>
        <?
  		echo '<SELECT  name=nombre[] multiple=multiple style="padding:15px; width:100%;height:450px;">';
  		if ($nivel=="Cualquiera") {$alumno_sel="";}else{$alumno_sel = "WHERE NIVEL like '$nivel%' and grupo = '$grupo'";}
  $alumno = mysql_query("SELECT distinct APELLIDOS, NOMBRE, claveal FROM alma $alumno_sel order by APELLIDOS asc");
  
       while($falumno = mysql_fetch_array($alumno)) 
	   {
	echo "<OPTION>$falumno[2] --> $falumno[0], $falumno[1]</OPTION>";
		}
	echo  '</select></p>';
		} 	
		
		
		
?>
  </form>
<?
}
 } 
 else {
	 echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
El módulo de envío de SMS debe ser activado en la Configuración general de la Intranet para poder accede a estas páginas, y ahora mismo está desactivado.
          </div></div>';
 }
 
 if((!(empty($nivel)) and !(empty($grupo))) or (stristr($_SESSION['cargo'],'1') == TRUE))
	    {	
		echo '</div>
</div>';
}
?>
</div>
</div>
<? include("../pie.php");?>

</body>
</html>