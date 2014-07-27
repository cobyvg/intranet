<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?php
include("../../menu.php");
?>
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Administración <small> Copiar datos de un profesor a otro</small></h2>
</div>
<?
if ($_POST['enviar']) {
	if (empty($_POST['sustituido'])) {
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />
El profesor que va a ser sustituido no ha sido seleccionado. Vuelve atrás y selecciónalo.</div></div>';
		exit();
	}
	elseif (empty($_POST['sustituto'])){
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />
El profesor sustituto no ha sido seleccionado. Vuelve atrás y selecciónalo.</div></div>';
		exit();
	}
	else{
		$sustituido = $_POST['sustituido'];
		$sustituto = $_POST['sustituto'];
		mysql_query("update horw set prof = '$sustituto' where prof = '$sustituido'") or die(
		'<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />No se han podido cambiar los datos del horario. Busca ayuda si lo consideras necesario, o bien cambia los datos en la tabla horw manualmente.</div></div>');
		mysql_query("update horw_faltas set prof = '$sustituto' where prof = '$sustituido'") or die('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />
No se han podido cambiar los datos del horario de faltas. Busca ayuda si lo consideras necesario, o bien cambia los datos en la tabla horw_faltas manualmente.</div></div>');
		mysql_query("update FTUTORES set tutor = '$sustituto' where tutor = '$sustituido'") or die('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />
No se han podido cambiar los datos de Tutoría. Busca ayuda si lo consideras necesario, o bien cambia los datos en la tabla FTUTORES manualmente.</div></div>');
		mysql_query("update profesores set profesor = '$sustituto' where profesor = '$sustituido'") or die('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />
No se han podido cambiar los datos de la tabla Profesores. Busca ayuda si lo consideras necesario, o bien cambia los datos en la tabla profesores manualmente.</div></div>');
		mysql_query("update guardias set profesor = '$sustituto' where profesor = '$sustituido'") or die('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />
No se han podido cambiar los datos de las Guardias. Busca ayuda si lo consideras necesario, o bien cambia los datos en la tabla Guardias manualmente.</div></div>');
	}
	echo'<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos han sido modificados correctamente.</div></div>';
}
?>
<FORM ENCTYPE="multipart/form-data" ACTION="index_hor.php" METHOD="post">
  <div class="form-group"><p class="help-block" style="width:400px; text-align:left"><span style="color:#9d261d">(*) </span>Para copiar los datos de un profesor que se ha dado de baja al profesor que lo sustituye, es necesario en primer lugar copiar el horario de un profesor a otro en Séneca. A continuación, debes actualizar los Departamentos y los Profesores en la página de Administración de la Intranet. Si ya lo has hecho, en este formulario selecciona el profesor de baja y luego el profesor que lo susituye, y envía los datos.</p>
  <br />
  <div class="well well-large" style="width:360px; margin:auto;" align="left">
    <div class="controls">
  
  <label class="control-label" for="prof1">Profesor sustituido</label>
 <SELECT  name="sustituido" class="input-xlarge" id="prof1">
    <option></option>
    <?
  $profe = mysql_query(" SELECT distinct prof FROM horw order by prof asc");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      echo "$opcion1";

	} while($filaprofe = mysql_fetch_array($profe));
        }
	?>
  </select>
  <hr>
  <label class="control-label" for="prof2">Profesor sustituto</label>
 <SELECT  name="sustituto" class="input-xlarge" id="prof2">
    <option></option>
    <?
  $profe = mysql_query(" SELECT distinct nombre FROM departamentos where nombre not like 'admin' and nombre not like 'conserje' and departamento not like 'Administ%' order by nombre asc");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      echo "$opcion1";

	} while($filaprofe = mysql_fetch_array($profe));
        }
	?>
  </select>

  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
  </div>
  </div>
</FORM>

</body>
</html>
