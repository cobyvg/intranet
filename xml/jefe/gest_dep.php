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
<script>
function confirmacion() {
	var answer = confirm("ATENCIÓN:\n ¿Estás seguro de que quieres borrar los datos? Esta acción es irreversible. Para borrarlo, pulsa Aceptar; de lo contrario, pulsa Cancelar.")
	if (answer){
return true;
	}
	else{
return false;
	}
}
</script>
<?php
include("../../menu.php");
?>
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Administración <small> Gestión de los Departamentos</small></h2>
</div>

<div class="container-fluid">
<div class="row-fluid">
<div class="span7">
<p class="help-block" align="left">(*) Este formulario permite tanto <em>Cambiar el nombre</em> a una Especialidad o Departamento como <em>Incorporar a los miembros</em> de una Especialidad en otro Departamento. Para cambiar el nombre simplemente escribe el nuevo nombre en el campo de texto; para incorporar una Especialidad en un Departamento, selecciónalo en la lista desplegable. Una vez realizados los cambios, haz click en el botón <em><b>Enviar datos</b></em>. Si actualizas los Departamentos, no te olvides incorporar a los profesores nuevos en el Departamento correspondiente, ya que aparecerán asociados a su <em>Especialidad de Séneca</em>.</p><br />
<?
if (isset($_POST['enviar']) and $_POST['enviar'] == "Enviar datos") {
$n_reg="";
foreach ($_POST as $key=>$val){
if (is_numeric(substr($key,0,1)) and strlen($val)>2) {
	$n_reg+=1;
	$tr_cambio = explode("#",$key);
	$origen = $tr_cambio[1];
	$q1 = mysql_query("select distinct departamento from departamentos");
	while ($q2 = mysql_fetch_array($q1)) {
		$trasform1 = str_ireplace(" ","_",$q2[0]);
		$trasform2 = str_ireplace(".","_",$trasform1);
		if ($origen==$trasform2) {
// Actualizamos tabla departamentos
	mysql_query("update departamentos set departamento = '$val' where departamento = \"$q2[0]\"");
// Actualizamos departamento en tablas relacionadas
	$n_dep = array("inventario","actividades","mem_dep","r_departamento","Textos");
	foreach ($n_dep as $sust_dep){
	mysql_query("update $sust_dep set departamento = '$val' where departamento = '$q2[0]'");
	}		
	}
	}
}
elseif (strlen($val)>2 and !($key=="enviar")){
	$n_reg+=1;
	$q1 = mysql_query("select distinct departamento from departamentos");
		while ($q2 = mysql_fetch_array($q1)) {
		$trasform1 = str_ireplace(" ","_",$q2[0]);
		$trasform2 = str_ireplace(".","_",$trasform1);
		if ($key==$trasform2) {
// Actualizamos tabla departamentos
	mysql_query("update departamentos set departamento = '$val' where departamento = '$q2[0]'");
	//echo "update departamentos set departamento = '$val' where departamento = '$q2[0]'<br>";
// Actualizamos departamento en tablas relacionadas
	$n_dep = array("inventario","actividades","mem_dep","r_departamento","Textos");
	foreach ($n_dep as $sust_dep){
	mysql_query("update $sust_dep set departamento = '$val' where departamento = '$q2[0]'");
	//echo "update $sust_dep set departamento = '$val' where departamento = '$key'<br>";	
}
}
}
}
}
}
if ($n_reg>0) {
		echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Departamento ha sido actualizado en la base de datos.
          </div></div><br />';
}
//exit();
if ($_GET['borrar']=='1') {
	mysql_query("update departamentos set departamento = '' where departamento = '".$_GET['departament']."'");	
	//echo "update departamentos set departamento = '' where departamento = '".$_GET['departament']."'";
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Departamento ha sido borrado de la base de datos..
          </div></div><br />';
}
?>
<legend>Departamentos del Centro</legend>

<form action="gest_dep.php" method="POST" name="form1">
<table class="table table-striped table-condensed">
<thead>
<th>Departamento</th><th>Cambiar el nombre</th><th>Incorporar a Departamento</th></th><th></th>
</thead>
<tbody>
<?
$dep0 = "select distinct departamento from departamentos where departamento not like '' order by departamento";
$dep1 = mysql_query($dep0);
$n_d="";
while ($dep = mysql_fetch_array($dep1)) {
	$n_d+=1;
	echo "<tr><td>$dep[0]</td><td><input type='text' name=\"$n_d#$dep[0]\" class='input' /></td>";
  
echo '<td><select name="'.$dep[0].'" id="departamento" class="input input-medium"><option></option>';
$profe = mysql_query(" SELECT distinct departamento FROM departamentos where departamento not like '' order by departamento asc");
  while($filaprofe = mysql_fetch_array($profe))
	{
	$departamen = $filaprofe[0]; 
	echo "<OPTION>$departamen</OPTION>";	
	} 
  echo "</select>
  </td><td><a href='gest_dep.php?borrar=1&departament=$dep[0]'><i class='fa fa-trash-o fa-lg' onClick='return confirmacion();'></i></a></td></tr>";	
  }
?>
</tbody>
</table>
<div align="center"><input class="btn btn-block btn-primary" type="submit" name = "enviar" value="Enviar datos" /></div>
</form>
</div>

<div class="span5">
<p class="help-block" align="left">(*) Este formulario permite cambiar el Departamento al que pertenece un profesor. Selecciona el Departamento al que quieres asignar al Profesor y envía los datos. Si actualizas los Departamentos, no te olvides incorporar a los profesores nuevos en el Departamento correspondiente, ya que aparecerán asociados a su <em>Especialidad de Séneca</em>.</p><br />
<?
if (isset($_POST['cambiar']) and $_POST['cambiar'] == "Cambiar Departamento") {
	foreach ($_POST as $key=>$val){
// Actualizamos tabla departamentos
	mysql_query("update departamentos set departamento = '$val' where idea = '$key'");
	}	
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Profesor ha sido asignado al nuevo Departamento.
          </div></div><br />';
}
?>
<legend>Profesores del Centro</legend>
<form action="gest_dep.php" method="POST" name="form2">
<table class="table table-striped table-condensed">
<thead>
<th>Profesor</th><th>Departamento</th>
</thead>
<tbody>
<?
$prof0 = "select distinct nombre, idea from departamentos  order by nombre";
$prof1 = mysql_query($prof0);

while ($prof = mysql_fetch_array($prof1)) {
	echo "<tr><td>$prof[0]</td>";
	$act = mysql_query("select departamento from departamentos where idea = '$prof[1]'");
	$actual = mysql_fetch_row($act);
	echo '<td><select name="'.$prof[1].'" id="departamento" class="input-large">';
	if (strlen($actual[0])>0) {
			echo '<option>'.$actual[0].'</option><option></option>';
	}
	else{ echo '<option></option>';}
	$profes = mysql_query(" SELECT distinct departamento FROM departamentos where departamento not like '' order by departamento asc");
  while($filaprofes = mysql_fetch_array($profes))
	{
	$departamens = $filaprofes[0]; 
	echo "<OPTION>$departamens</OPTION>";	
	} 
  echo "</select></td></tr>";
}
?>
</tbody>
</table>
<div align="center"><input class="btn btn-block btn-primary" type="submit" name = "cambiar" value="Cambiar Departamento" /></div>
</form>
</div>
</div>
</body>
</html>
ü 