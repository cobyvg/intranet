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
$profesor = $_SESSION['profi'];
$cargo = $_SESSION['cargo'];
?>
<?php
include("../../menu.php");
include("menu.php");

$prof=mysql_query("SELECT TUTOR FROM FTUTORES WHERE NIVEL like '$nivel%' and GRUPO like '$grupo%'");
$fprof = mysql_fetch_array($prof);
if(!($tutor)){$tutor=$fprof[0];}else{$fprof[0] = $tutor;}
?>
<div align="center">
<div class="page-header" align="center">
  <h2>Informes de Tareas <small> Activar Informe</small></h2>
</div>
<br />
  <div class="well well-large" style='width:380px;'>
    <div align="left">
      <?
if($nivel and $grupo)
{
echo '<h4>Grupo: <span style="color:#08c">';
echo $nivel."-".$grupo;
echo '</span><br /> Tutor: <span class="text-info">';
echo $tutor;
echo '</span></h4><br />';
}
else
{
?>
      <form name="curso" method="POST" action="infotut.php" class="form-inline">
        <label>Nivel
          <SELECT name="nivel" onChange="submit()" class="input input-mini">
            <option style="width:30px;"><? echo $nivel;?></option>
            <? nivel();?>
          </SELECT>
        </label>
        &nbsp;&nbsp;&nbsp;
        <label>Grupo
          <select  name="grupo" onChange="submit()" class="input input-mini">
            <option style="width:30px;"><? echo $grupo;?></option>
            <? grupo($nivel);?>
          </select>
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
echo"<select name='alumno' class='span3'>";
echo "<OPTION></OPTION>";
if ($nivel == "" and $grupo == ""){ echo "<OPTION></OPTION>";} 
else
{
$alumno=mysql_query("SELECT CLAVEAL, APELLIDOS, NOMBRE, NIVEL, GRUPO FROM alma WHERE NIVEL like '$nivel%' and GRUPO like '$grupo%' ORDER BY APELLIDOS ASC, NOMBRE ASC");
 while($falumno = mysql_fetch_array($alumno))
 {
	 echo "<OPTION>$falumno[1], $falumno[2] --> $falumno[0]</OPTION>";
	}
	}
echo "</select></label>";

echo"<label>Profesor que activa el informe<br />";
echo "<input size='35' name='tutor' type='text' value='$profesor'  class='span3' readonly>";
echo "</label>";
$today = date("j, n, Y");
$hoy = explode(",", $today);
$dia = $hoy[0];
$mes = $hoy[1];
$año = $hoy[2];
?>
         <label>Fecha prevista de la ausencia<br />
 <div class="input-append" style="display:inline;" >
            <input name="fecha" type="text" class="input input-small" value="" data-date-format="dd-mm-yyyy" id="fecha" >
  <span class="add-on"><i class="icon-calendar"></i></span>
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
