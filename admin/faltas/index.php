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
<div class="page-header">
  <h2>Faltas de Asistencia <small> Consultas</small></h2>
  </div>
<br />
<div class="container-fluid">
<div class="row">
  <form action='index.php' method='post' name='f1' class="form-inline">

  <div class="col-sm-4">
  <div class="well well-large">

  <legend>Faltas de un Grupo.</legend>
<br />
    <label> Grupo:<br />
    <SELECT name="unidad" onChange="submit()" class="input"  style="display:inline">
      <OPTION><? echo $_POST['unidad'];?></OPTION>
      <? unidad();?>
    </SELECT>
  </label>
  <hr>
   <label>
  Mes:&nbsp;
  <SELECT name='mes' class="input-mini">
    <OPTION></OPTION>
    <?
	for($i=1;$i<13;$i++){
	echo "<OPTION>$i</OPTION>";	
	}
	?>    
  </SELECT>
  <!-- <INPUT name="mes" type="text" value="<? //echo date(m); ?>" class="input-mini" maxlength="2" >-->
  </label>
  <br />
  <label>
  Falta:
  <SELECT name='FALTA' class="input-mini">
    <OPTION>F</OPTION>
    <OPTION>J</OPTION>
  </SELECT>
  </label>
  <br />
  <label>
  N&uacute;mero m&iacute;nimo de
  Faltas
  <INPUT name="numero2" type="text" class="input-mini" maxlength="3" alt="Mes" value="1">
  </label>
  <hr />
  <input name="submit1" type="submit" id="submit1" value="Enviar Datos" class="btn btn-primary btn-block">
  </div>
  </div>
  
  
  
   <div class="col-sm-4">
  <div class="well well-large">
  <legend>Faltas de un alumno</legend>
  <br />
  <label> Grupo:<br />
    <SELECT name="unidad1" onChange="submit()" class="input"  style="display:inline">
      <OPTION><? echo $unidad1;?></OPTION>
      <? unidad();?>
    </SELECT>
  </label>
  <hr>
  <label>
  Alumno:
  <select name='nombre' class="input-xlarge">
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
  </label>
  <hr>
    <legend>Rango de fechas...</legend>
         <label>Inicio<br />
 <div class="input-group" style="display:inline;" >
            <input name="fecha4" type="text" class="input input-small" value="" data-date-format="dd-mm-yyyy" id="fecha4" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 

</label>
  &nbsp;&nbsp;&nbsp;&nbsp;
<label>Fin<br />
 <div class="input-group" style="display:inline;" >
            <input name="fecha3" type="text" class="input input-small" value="" data-date-format="dd-mm-yyyy" id="fecha3" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 
    </label> 

  <hr />
  <input name=submit2 type=submit id="submit2" value='Lista detallada de Faltas' class="btn btn-primary btn-block">
  <br>
</div>
</div>



<div class="col-sm-4">
<div class="well well-large pull-left">
  <legend> Faltas y días sin justificar</legend>
  <br />
  <span class="help-block">( Alumnos que tienen un número mínimo de faltas entre el rango de fechas seleccionadas. )</span>
  <label>
  Número mínimo de Faltas <INPUT name="numero" type="text" id="numero" class="input-mini" maxlength="3" value="1">
  </label>
 <hr>
   <legend>Rango de fechas...</legend>
         <label>Inicio<br />
 <div class="input-group" style="display:inline;" >
            <input name="fecha10" type="text" class="input input-small" value="" data-date-format="dd-mm-yyyy" id="fecha10" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 

</label>
  &nbsp;&nbsp;&nbsp;&nbsp;
<label>Fin<br />
 <div class="input-group" style="display:inline;">
            <input name="fecha20" type="text" class="input input-small" value="" data-date-format="dd-mm-yyyy" id="fecha20" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 

    </label> <hr />
  <INPUT name="submit4" type="submit" value="Enviar Datos" id="submit4" class="btn btn-primary btn-block">
  </div>
  </div>
  <? }?>
</form>
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
