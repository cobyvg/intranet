<?
if (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];}elseif (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];}else{$unidad="";}
if (isset($_GET['unidad1'])) {$unidad1 = $_GET['unidad1'];}elseif (isset($_POST['unidad1'])) {$unidad1 = $_POST['unidad1'];}else{$unidad1="";}
if (isset($_GET['mes'])) {$mes = $_GET['mes'];}elseif (isset($_POST['mes'])) {$mes = $_POST['mes'];}else{$mes="";}
if (isset($_GET['FALTA'])) {$FALTA = $_GET['FALTA'];}elseif (isset($_POST['FALTA'])) {$FALTA = $_POST['FALTA'];}else{$FALTA="";}
if (isset($_GET['numero2'])) {$numero2 = $_GET['numero2'];}elseif (isset($_POST['numero2'])) {$numero2 = $_POST['numero2'];}else{$numero2="";}
if (isset($_GET['submit1'])) {$submit1 = $_GET['submit1'];}elseif (isset($_POST['submit1'])) {$submit1 = $_POST['submit1'];}else{$submit1="";}
if (isset($_GET['nombre'])) {$nombre = $_GET['nombre'];}elseif (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];}else{$nombre="";}
if (isset($_GET['fecha4'])) {$fecha4 = $_GET['fecha4'];}elseif (isset($_POST['fecha4'])) {$fecha4 = $_POST['fecha4'];}else{$fecha4="";}
if (isset($_GET['fecha3'])) {$fecha3 = $_GET['fecha3'];}elseif (isset($_POST['fecha3'])) {$fecha3 = $_POST['fecha3'];}else{$fecha3="";}
if (isset($_GET['submit2'])) {$submit2 = $_GET['submit2'];}elseif (isset($_POST['submit2'])) {$submit2 = $_POST['submit2'];}else{$submit2="";}
if (isset($_GET['numero'])) {$numero = $_GET['numero'];}elseif (isset($_POST['numero'])) {$numero = $_POST['numero'];}else{$numero="";}
if (isset($_GET['fecha10'])) {$fecha10 = $_GET['fecha10'];}elseif (isset($_POST['fecha10'])) {$fecha10 = $_POST['fecha10'];}else{$fecha10="";}
if (isset($_GET['fecha20'])) {$fecha20 = $_GET['fecha20'];}elseif (isset($_POST['fecha20'])) {$fecha20 = $_POST['fecha20'];}else{$fecha20="";}
if (isset($_GET['submit4'])) {$submit4 = $_GET['submit4'];}elseif (isset($_POST['submit4'])) {$submit4 = $_POST['submit4'];}else{$submit4="";}

if ($submit1)
{
	include("faltas.php");
}
elseif ($submit2)
{
	include("informes.php");
}
elseif ($submit3)
{
	include("informes.php");
}
elseif ($submit4)
{
	include("faltasdias.php");
}
else
{
	session_start();
	include("../../config.php");
	// COMPROBAMOS LA SESION
	if ($_SESSION['autentificado'] != 1) {
		$_SESSION = array();
		session_destroy();
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}

	if($_SESSION['cambiar_clave']) {
		header('Location:'.'http://'.$dominio.'/intranet/clave.php');
	}

	registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


	?>
	<?php
	include("../../menu.php");
	include("../../faltas/menu.php");
	?>

<div class="container">
<div class="page-header">
<h2>Faltas de Asistencia <small> Consultas</small></h2>
</div>
<br />

<div class="row">

<div class="col-sm-6">

<div class="well well-large">

<legend>Faltas de un Grupo.</legend>

<form action='index.php' method='post' name='f1' class='form' role='form'>

<fieldset>

<div class="form-group col-md-6">
<label class="control-label" for="unidad"> Grupo </label> 
<SELECT
	id="unidad" name="unidad" onChange="submit()" class="form-control">
	<OPTION><? echo $_POST['unidad'];?></OPTION>
	<? unidad();?>
</SELECT>
</div>

<div class="form-group col-md-6">
<label class="control-label" for="mes"> Mes </label> 
<SELECT name='mes' id='mes'
	class="form-control">
	<OPTION></OPTION>
	<?
	for($i=1;$i<13;$i++){
		echo "<OPTION>$i</OPTION>";
	}
	?>
</SELECT> 
</div>

<div class="form-group col-md-6">
<label class="control-label" for="falta">Falta:</label> 
<SELECT id='falta'  name='FALTA' class="form-control">
	<OPTION>F</OPTION>
	<OPTION>J</OPTION>
</SELECT>
</div>

<div class="form-group col-md-6">
<label class="control-label" for='numero2'> N&uacute;mero m&iacute;nimo de Faltas</label> 
<INPUT id='numero2' name="numero2" type="text" class="form-control" maxlength="3" alt="Mes" value="1">
</div>

<div class="form-group col-md-4">
<input name="submit1" type="submit" id="submit1" value="Enviar Datos"
	class="btn btn-primary">
</div>

</fieldset>

</form>

</div>

<br>


<div class="well well-large">

<form action='index.php' method='post' name='f1' class='form' role='form'>

<fieldset>

<legend> Faltas y días sin justificar</legend>

<span class="help-block">( Alumnos que
tienen un número mínimo de faltas entre el rango de fechas
seleccionadas. )</span> 

<div class="form-group col-md-6">
<label class="control-label" for='numero'> Número mínimo de Faltas</label> 
<INPUT
	name="numero" type="text" id="numero" class="form-control"
	maxlength="3" value="1">
</div>
<legend><small>Rango de fechas...</small></legend>

<div class="form-group col-md-6" style="display: inline;">
<label class="control-label" for="fecha10">Inicio </label>
<div class="input-group">
<input name="fecha10" type="text"
	class="form-control" value="" data-date-format="dd/mm/yyyy"
	id="fecha10" required> <span class="input-group-addon"><i
	class="fa fa-calendar"></i></span>
</div>
</div>

<div class="form-group col-md-6" style="display: inline;">
<label
	for="fecha20" class="control-label">Fin </label>
<div class="input-group"><input name="fecha20" type="text"
	class="form-control" value="" data-date-format="dd/mm/yyyy"
	id="fecha20" required> <span class="input-group-addon"><i
	class="fa fa-calendar"></i></span>
</div>
</div>

<br>

<div class="form-group col-md-4">
<INPUT name="submit4" type="submit" value="Enviar Datos" id="submit4"
	class="btn btn-primary">
</div>

</fieldset>

</form>

</div>

</div>


<div class="col-md-6">

<div class="well well-large">

<form action='index.php' method='post' name='f1' class='form' role='form'>

<fieldset>

<legend>Faltas de un alumno</legend> 

<div class="form-group col-md-3">
<label for="grupo" class="control-label"> Grupo </label> 
<SELECT id="grupo"
	name="unidad1" onChange="submit()" class="form-control">
	<OPTION><? echo $unidad1;?></OPTION>
	<? unidad();?>
</SELECT>
</div>

<div class="form-group col-md-9">
<label for="al" class="control-label"> Alumno </label> 
<select id="al"
	name='nombre' class="form-control">
	<?
	printf ("<OPTION></OPTION>");

	// Datos del alumno que hace la consulta. No aparece el nombre del a&iuml;&iquest;&frac12; de la nota. Se podr&iuml;&iquest;&frac12; incluir.
	$alumnosql = mysql_query("SELECT distinct APELLIDOS, NOMBRE, CLAVEAL FROM FALUMNOS WHERE unidad like '$unidad1%' order by APELLIDOS asc");

	if ($falumno = mysql_fetch_array($alumnosql))
	{

		do {
			$claveal = $falumno[2];
			global $claveal;
			$opcion = printf ("<OPTION>$falumno[0], $falumno[1] --> $falumno[2]</OPTION>");
			echo "$opcion";

		} while($falumno = mysql_fetch_array($alumnosql));
	}
	$fecha = (date("d").-date("m").-date("Y"));
	$comienzo=explode("-",$inicio_curso);
	$comienzo_curso=$comienzo[2]."-".$comienzo[1]."-".$comienzo[0];
	$fecha2 = date("m");
	?>
</select>
</div>

<legend><small>Rango de fechas...</small></legend>

<div class="form-group col-md-6" style="display: inline;">
<label class="control-label"
	for="fecha4">Inicio </label>
<div class="input-group"><input name="fecha4" type="text"
	class="form-control" value="" data-date-format="dd/mm/yyyy" id="fecha4"
	required> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>
</div>

<div class="form-group col-md-6" style="display: inline;">
<label class="control-label"
	for="fecha3">Fin </label>
<div class="input-group">
<input name="fecha3" type="text"
	class="form-control" value="" data-date-format="dd/mm/yyyy" id="fecha3"
	required> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>
</div>

<div class="form-group col-md-4">
<input name=submit2 type=submit id="submit2"
	value='Lista detallada de Faltas' class="btn btn-primary"> 
</div>

</fieldset>

</form>

</div>

<br>

<div class="well well-large">

<legend>Faltas de un Grupo.</legend>

<form action='index.php' method='post' name='f1' class='form' role='form'>

<fieldset>

<div class="form-group col-md-6">
<label class="control-label" for="unidad"> Grupo </label> 
<SELECT
	id="unidad" name="unidad" onChange="submit()" class="form-control">
	<OPTION><? echo $_POST['unidad'];?></OPTION>
	<? unidad();?>
</SELECT>
</div>

<div class="form-group col-md-6">
<label class="control-label" for="mes"> Mes </label> 
<SELECT name='mes' id='mes'
	class="form-control">
	<OPTION></OPTION>
	<?
	for($i=1;$i<13;$i++){
		echo "<OPTION>$i</OPTION>";
	}
	?>
</SELECT> 
</div>

<div class="form-group col-md-6">
<label class="control-label" for="falta">Falta:</label> 
<SELECT id='falta'  name='FALTA' class="form-control">
	<OPTION>F</OPTION>
	<OPTION>J</OPTION>
</SELECT>
</div>

<div class="form-group col-md-6">
<label class="control-label" for='numero2'> N&uacute;mero m&iacute;nimo de Faltas</label> 
<INPUT id='numero2' name="numero2" type="text" class="form-control" maxlength="3" alt="Mes" value="1">
</div>

<div class="form-group col-md-4">
<input name="submit1" type="submit" id="submit1" value="Enviar Datos"
	class="btn btn-primary">
</div>

</fieldset>

</form>

</div>

</div>

	<? }?>

</div>
</div>
	<? include("../../pie.php");?>

<script>  
	$(function ()  
	{ 
		$('#fecha4').datepicker()
		.on('changeDate', function(ev){
			$('#fecha4').datepicker('hide');
		});
		});  
	</script>
<script>  
	$(function ()  
	{ 
		$('#fecha3').datepicker()
		.on('changeDate', function(ev){
			$('#fecha3').datepicker('hide');
		});
		});  
	</script>

<script>  
	$(function ()  
	{ 
		$('#fecha10').datepicker()
		.on('changeDate', function(ev){
			$('#fecha10').datepicker('hide');
		});
		});  
	</script>
<script>  
	$(function ()  
	{ 
		$('#fecha20').datepicker()
		.on('changeDate', function(ev){
			$('#fecha20').datepicker('hide');
		});
		});  
	</script>
</body>
</html>
