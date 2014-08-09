<?
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


$profesor = $_SESSION['profi'];
$cargo = $_SESSION['cargo'];
?>
<?php
include("../../menu.php");
include("menu.php");

$prof=mysql_query("SELECT TUTOR FROM FTUTORES WHERE unidad like '$unidad%'");
$fprof = mysql_fetch_array($prof);
if(!($tutor)){$tutor=$fprof[0];}else{$fprof[0] = $tutor;}
?>
<div align="center">
<div class="page-header">
  <h2>Informes de Tareas <small> Activar Informe</small></h2>
</div>
<br />
  <div class="well well-large" style='width:380px;'>
    <div align="left">
      <?
if($unidad)
{
echo '<h4>Grupo: <span style="color:#08c">';
echo $unidad;
echo '</span><br /> Tutor: <span class="text-info">';
echo $tutor;
echo '</span></h4><br />';
}
else
{
?>
      <form name="curso" method="POST" action="infotut.php" class="form-inline">
        <label>Grupo
          <SELECT name="unidad" onChange="submit()" class="input">
            <option style="width:30px;"><? echo $unidad;?></option>
            <? unidad();?>
          </SELECT>
        </label>
      </FORM>
    </div>
    <hr>
    <?
}
?>
    <form name="alumno" method="POST" action="ejecutactivar.php">
      <?php

echo "<div align='left'><form name='alumno' method='POST' action='activar.php'>";
echo "<label>Alumno <br />";
echo"<select name='alumno' class='col-sm-3'>";
echo "<OPTION></OPTION>";
if ($unidad == ""){ echo "<OPTION></OPTION>";} 
else
{
$alumno=mysql_query("SELECT CLAVEAL, APELLIDOS, NOMBRE, unidad FROM alma WHERE unidad like '$unidad%' ORDER BY APELLIDOS ASC, NOMBRE ASC");
 while($falumno = mysql_fetch_array($alumno))
 {
	 echo "<OPTION>$falumno[1], $falumno[2] --> $falumno[0]</OPTION>";
	}
	}
echo "</select></label>";

echo"<label>Profesor que activa el informe<br />";
echo "<input size='35' name='tutor' type='text' value='$profesor'  class='col-sm-3' readonly>";
echo "</label>";
$today = date("j, n, Y");
$hoy = explode(",", $today);
$dia = $hoy[0];
$mes = $hoy[1];
$ano = $hoy[2];
?>
         <label>Fecha prevista de la ausencia<br />
 <div class="input-group" style="display:inline;" >
            <input name="fecha" type="text" class="input input-small" value="" data-date-format="dd-mm-yyyy" id="fecha" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 

</label>

<?

echo "<label>Duracion de la ausencia (en d&iacute;as)<br />";
echo "<select name='duracion' class='input-mini'>";
for ($i=1;$i<32;$i++){echo "<option>$i</option>";}
echo "</select> ";
echo"</label><br />";
echo '<div align="center"><input type="submit" value="Activar informe de Tareas" class="btn btn-primary"></div>';
?>
    </form>
  </div>
</div>
<? 	
include("../../pie.php");
?>
<script>  
	$(function ()  
	{ 
		$('#fecha').datepicker()
		.on('changeDate', function(ev){
			$('#fecha').datepicker('hide');
		});
		});  
	</script>
</body>
</html>
