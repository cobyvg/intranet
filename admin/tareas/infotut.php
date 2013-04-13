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
?>
<div align="center">
<div class="page-header" align="center">
  <h1>Informes de Tareas <small> Activar Informe</small></h1>
</div>
<br />
  <div class="well-2 well-large" style='width:380px;'>
    <div align="left">
      <?
if($nivel and $grupo)
{
echo '<h4>Grupo: <span style="color:#08c">';
echo $nivel."-".$grupo;
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
echo "<label><br />Fecha prevista de ausencia<br />";
$today = date("j, n, Y");
$hoy = explode(",", $today);
$dia = $hoy[0];
$mes = $hoy[1];
$año = $hoy[2];
echo "<select name='fecha[2]' class='input input-mini'>";
echo "<option>$dia</option>";
for ($i=1;$i<32;$i++){echo "<option>$i</option>";}
echo "</select> de ";
echo "<select name='fecha[1]' class='input input-mini'>";
echo "<option>$mes</option>";
for ($i=1;$i<13;$i++){echo "<option>$i</option>";}
echo "</select> de ";
echo "<select name='fecha[0]' class='input input-mini'>";
echo "<option>$año</option>";
for ($i=2005;$i<2010;$i++){echo "<option>$i</option>";}
echo "</select> ";
echo"</label>";

echo "<label>Duracion de la ausencia (en d&iacute;as)<br />";
echo "<select name='duracion' class='input-mini'>";
for ($i=1;$i<32;$i++){echo "<option>$i</option>";}
echo "</select> ";
echo"</label><br />";
echo '<div align="center"><input type="submit" value="Activar informe de Tareas" class="btn btn-primary"></div>';

	include("../../pie.php");
?>
    </form>
  </div>
</div>
</body>
</html>
