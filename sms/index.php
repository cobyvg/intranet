<?
require('../bootstrap.php');


$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'2') == TRUE) and !(stristr($_SESSION['cargo'],'6') == TRUE) and !(stristr($_SESSION['cargo'],'7') == TRUE) and !(stristr($_SESSION['cargo'],'8') == TRUE))
{
header('Location:'.'http://'.$dominio.'/intranet/salir.php');
exit;	
}
include("../menu.php");
if (isset($_GET['submit0'])) {$submit0 = $_GET['submit0'];}elseif (isset($_POST['submit0'])) {$submit0 = $_POST['submit0'];}else{$submit0="";}
if (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];}elseif (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];}else{$unidad="";}
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
<div class="container">

<div class="page-header">
  <h2>SMS <small> Envío de mensajes</small></h2>
<?
if(strlen($unidad)>1){
	$t0 = mysqli_query($db_con,"select Tutor from FTUTORES where unidad='$unidad'");
	if (mysqli_num_rows($t0)>0) {
		$t1 = mysqli_fetch_row($t0);
?>
<h4 class="text-info">Tutor/a: <?php echo nomprofesor($t1[0]); ?></h4>
<?		
	}
?>
<h4 class="text-info">Grupo: <?php echo $unidad; ?></h4>
<?	 		
	 	}
?>
</div>
<br>
<div class="row">

<?
 if ($mod_sms) {
// variables(); 
// Procesado de los datos del Formulario
if($submit0 == "Enviar SMS")
{
	if(empty($causa)){
		echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
No has seleccionado ninguna Causa del Mensaje.<br />Vuelve atrás, selecciónala e inténtalo de nuevo.
          </div></div>';
		  exit();
}
if(empty($text)){
		echo '<div align="center"><div class="alert alert-danger alert-block fade in">
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
	$tel0 = mysqli_query($db_con, "select telefono, telefonourgencia, apellidos, nombre, alma.unidad, alma.matriculas, tutor from alma, FTUTORES where FTUTORES.unidad = alma.unidad and claveal = '$claveal'");
	
	$tel1 = mysqli_fetch_array($tel0);
	$tfno = $tel1[0];	
	$tfno_u = $tel1[1];
	$apellidos = $tel1[2];
	$nombre = $tel1[3];
	$unidad = $tel1[4];
	$alumno_mens.="$nombre $apellidos|$unidad;";
	$tutor_mens = $tel1[6];
	if (stristr($todos_tutores,"$tutor_mens|$unidad;")==FALSE) {
		$todos_tutores.="$tutor_mens|$unidad;";
	}
	
	if(substr($tfno,0,1)=="6" OR substr($tfno,0,1)=="7"){$mobil=$tfno;}elseif((substr($tfno_u,0,1)=="6" OR substr($tfno_u,0,1)=="7") and !(substr($tfno,0,1)=="6" OR substr($tfno,0,1)=="7")){$mobil=$tfno_u;}else{$mobil="";}
	
	//if(substr($tfno,0,1)=="6"){$mobil=$tfno;}elseif(substr($tfno_u,0,1)=="6" and !(substr($tfno,0,1)=="6")){$mobil=$tfno_u;}else{$mobil="";}
	if (strlen($mobil)>2) {
		$mobile.=$mobil.",";
	}
	if(stristr($_SESSION['cargo'],'1') == TRUE){$tuto="Jefatura de Estudios";}else{$tuto=$profe;}
$fecha2 = date('Y-m-d');
$observaciones = $text;
$accion = "Envío de SMS";
mysqli_query($db_con, "insert into tutoria (apellidos, nombre, tutor,unidad,observaciones,causa,accion,fecha,claveal) values ('".$apellidos."','".$nombre."','".$tuto."','".$unidad."','".$observaciones."','".$causa."','".$accion."','".$fecha2."','".$claveal."')");
	}

	$mobile=substr($mobile,0,strlen($mobile)-1);
	}
else
{
	echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>ATENCIÓN:</strong>
No has seleccionado ningún alumno para el envío de SMS.<br />Vuelve atrás, selecciónalo e inténtalo de nuevo.
          </div></div>';
		  exit();
}


$sms_n = mysqli_query($db_con, "select max(id) from sms");
$n_sms =mysqli_fetch_array($sms_n);
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
mysqli_query($db_con, "insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$mobile','$text','$profe')");
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El mensaje SMS se ha enviado correctamente.<br>Una nueva acción tutorial ha sido también registrada.
          </div></div>';
}
// Mensaje al Tutor
if (stristr($_SESSION['cargo'],'1') == TRUE) {
	$trozos_tutores = explode(";",$todos_tutores);
	
	foreach ($trozos_tutores as $val_tutor){
		$tr_tutor = explode("|",$val_tutor);
		$tut = $tr_tutor[0];
		$unidad_tut = $tr_tutor[1];
		$alumnos_sms="";
		
			$trozos_alumnos = explode(";",$alumno_mens);
			foreach ($trozos_alumnos as $val_alumno){
				$tr_al = explode("|",$val_alumno);
				$al_sms = $tr_al[0];
				$unidad_al = $tr_al[1];
				if ($unidad_tut == $unidad_al) {
					$alumnos_sms.= "$al_sms; ";
				}
			}
if (!empty($tut)) {
				
$query0="insert into mens_texto (asunto, texto, origen, destino) values ('Envío de SMS desde Jefatura de Estudios a los padres de ".$alumnos_sms." con el siguiente texto:<< ".$observaciones.">>','".$observaciones."','".$profe."', '$alumnos_sms')";
//echo "$query0<br>";
mysqli_query($db_con, $query0);
$id0 = mysqli_query($db_con, "select id from mens_texto where asunto like 'Envío de SMS desde Jefatura de Estudios a los padres de ".$alumnos_sms."%' and texto = '$observaciones' and origen = '$profe'");
$id1 = mysqli_fetch_array($id0);
$id = $id1[0];
$query1="insert into mens_profes (id_texto, profesor) values ('".$id."','".$tut."')";
//echo "$query1<br>";
mysqli_query($db_con, $query1);	
echo "<br>";
		}
	}
}
	
}
else
{
	 if((!(empty($unidad))) or (stristr($_SESSION['cargo'],'1') == TRUE)){
	 	
		?>
		
<div class="col-md-4 col-md-offset-2">

        <?
	}
	else{
	echo '<div class="col-md-4 col-md-offset-4">';	
	}
?>
<div class="well well-large" align="left">
<form method="post" action="index.php" name="nameform" class="form-vertical">

      <? if(stristr($_SESSION['cargo'],'2') == TRUE){} else{ ?>
      <div class="form-group">
      <label>Grupo </label>
		<select  name="unidad" class="form-control" onChange="submit()">
          <option><? echo $unidad;?></option>
          <? if(stristr($_SESSION['cargo'],'1') == TRUE){echo "<option>Cualquiera</option>";} ?>
          <? unidad($db_con); ?>
        </select>
        </div>
        <? }?>
      
          	<div class="form-group">
          	<label>Causa</label>
			<select name="causa" class="form-control">
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
    </div>
<?
if(empty($text)){$text = "";}
echo "<div class='form-group'>
<label>Texto del mensaje</label>
<TEXTAREA name='text' class='form-control' rows='4'  onkeydown=\"contar('nameform','text')\" onkeyup=\"contar('nameform','text')\">$text</TEXTAREA></div>
		<div class='form-group'>
		<label>Caracteres restantes:</label> <INPUT name=result value=160 class='form-control' readonly='true'></div>";
$sms_n = mysqli_query($db_con, "select max(id) from sms");
$n_sms =mysqli_fetch_array($sms_n);
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
  if((!(empty($unidad))) or (stristr($_SESSION['cargo'],'1') == TRUE))
	    {	
		?>
</div>
</div>
<div class="col-sm-4">
<div class="well">
<div class='form-group'>
<label>Selección de Alumnos<?echo "<span class='text-info'>: $unidad</span>"; ?></label>
        <?
  		echo '<SELECT  name=nombre[] multiple=multiple class="form-control" style="height:370px">';
  		if ($unidad=="Cualquiera") {$alumno_sel="";}else{$alumno_sel = "WHERE unidad like '$unidad%'";}
  $alumno = mysqli_query($db_con, "SELECT distinct APELLIDOS, NOMBRE, claveal FROM alma $alumno_sel order by APELLIDOS asc");
  
       while($falumno = mysqli_fetch_array($alumno)) 
	   {
	echo "<OPTION>$falumno[2] --> $falumno[0], $falumno[1]</OPTION>";
		}
	echo  '</select></div>';
		} 	
		
		
		
?>
  </form>
<?
}
 } 
 else {
	 echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
El módulo de envío de SMS debe ser activado en la Configuración general de la Intranet para poder accede a estas páginas, y ahora mismo está desactivado.
          </div></div>';
 }
 
 if((!(empty($unidad))) or (stristr($_SESSION['cargo'],'1') == TRUE))
	    {	
echo '</div>
</div></div>';
}
?>
</div>
</div>
</div>
<? include("../pie.php");?>

</body>
</html>