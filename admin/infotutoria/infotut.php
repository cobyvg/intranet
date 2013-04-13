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
?>
<?php
include("../../menu.php");
include("menu.php");
$prof=mysql_query("SELECT TUTOR FROM FTUTORES WHERE NIVEL like '$nivel%' and GRUPO like '$grupo%'");
$fprof = mysql_fetch_array($prof);
if(!($tutor)){$tutor=$fprof[0];}else{$fprof[0] = $tutor;}
?>
 <div align="center"><div class="page-header" align="center">
  <h1>Informes de Tutoría <small> Activar Informe</small></h1>
</div>
<br />
 <div class="well-2 well-large" style='width:380px;'>
 <div align="left">
<?
if($nivel and $grupo)
{
echo '<h4>Grupo: <span style="color:#08c">';
echo $nivel."-".$grupo;
echo '</span><br /> Tutor: <span style="color:#08c">';
echo $fprof[0];
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
        &nbsp;&nbsp;&nbsp;<label>Grupo
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

if ($nivel == "" or $grupo == ""){ echo "";} 
else
{
echo"<label>Tutor/a del grupo<br />";
echo "<input type='text' value ='$fprof[0]' name='tutor' class='span3' readonly>";
echo "</label>";
}
echo "<label style='display:inline'>Fecha (dd/mm/aa) prevista para la
 entrevista<br /> ";
$today = date("j, n, Y");
$hoy = explode(",", $today);
$dia = $hoy[0];
$mes = $hoy[1];
$año = $hoy[2];
echo "<select name='fecha[2]' class='input input-mini'>";
echo "<option>$dia</option>";
for ($i=1;$i<32;$i++){echo "<option>$i</option>";}
echo "</select></label><label style='display:inline'> &nbsp;&nbsp;del ";
echo "<select name='fecha[1]' class='input input-mini'>";
echo "<option>$mes</option>";
for ($i=1;$i<13;$i++){echo "<option>$i</option>";}
echo "</select></label><label style='display:inline'>&nbsp;&nbsp; de ";
echo "<select name='fecha[0]' class='input input-mini'>";
echo "<option>$año</option>";
for ($i=2012;$i<2020;$i++){echo "<option>$i</option>";}
echo "</select> ";
echo"</label><br />";
echo '<div align="center"><input type=submit value="Activar informe" class="btn btn-primary"></div>';
?>
 </form>
 </div>
 </div>
 <?php
 include("../../pie.php");
 ?>
 </body>
</html>
