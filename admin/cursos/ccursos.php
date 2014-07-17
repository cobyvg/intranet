<?php
if (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];} else{$unidad="";}
if (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];} elseif (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];} else{$unidad="$unidad-$grupo";}

if ($_POST['submit1'] or $_GET['submit1'])
{
	include("cursos.php");
}
else
{
?>
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
?>
<?
include("../../menu.php");
?>
<br />
<div align=center>
<div class="page-header" align="center">
  <h2>Listas de Alumnos <small> Listas de Grupo</small></h2>
</div>
</div>
<div class="container-fluid">
<div class="row-fluid">
<?
if(stristr($_SESSION['cargo'],'1') == TRUE){
 echo '<div class="span4 offset2">';
}
else{
echo '<div class="span5 offset1">';
}
?>

<form class="well well-large form-inline" action="ccursos.php" method="POST" name="listas">
<legend>Lista PDF de Alumnos por Grupo</legend>
<p class="block-help">Selecciona múltiples Grupos manteniendo apretada la tecla Ctrl mientras los seleccionas.</p>
<hr />
<SELECT  name="unidad[]" multiple class="input-block-level" required>
<?
if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE or stristr($_SESSION['cargo'],'5') == TRUE or stristr($_SESSION['cargo'],'d') == TRUE){
 unidad();
 $SQLcurso = "SELECT DISTINCT unidad
FROM alma
WHERE combasi like '%25204%' or combasi LIKE '%25226%'
";
$resultcurso = mysql_query($SQLcurso);
while($rowcurso = mysql_fetch_array($resultcurso)){
	echo "<option>$rowcurso[0] DIV</option>";	
}
}
else{

$SQLcurso = "select grupo, materia, nivel from profesores where profesor = '$profesor'";
$resultcurso = mysql_query($SQLcurso);
$curso="";
$asignatura="";	
	while($rowcurso = mysql_fetch_array($resultcurso))
	{
	$curso = $rowcurso[0];
	$asignatura = $rowcurso[1];
	$n_curs = substr($rowcurso[2],0,1);
	if (stristr($rowcurso[2],"bach")) {
		$asigna0 = "select codigo from asignaturas where nombre = '$asignatura' and curso like '%bach%' and curso like '$n_curs%' and abrev not like '%\_%'";
	}
	else{
	$asigna0 = "select codigo from asignaturas where nombre = '$asignatura' and curso = '$rowcurso[2]' and abrev not like '%\_%'";
	}
	$asigna1 = mysql_query($asigna0);
	$codasi="";
	while ($asigna2 = mysql_fetch_array($asigna1)) {
		$codasi.=$asigna2[0]."-";
	}
	$codasi = substr($codasi,0,-1)	;
	//echo "<option>select codigo from asignaturas where nombre = '$asignatura' and curso = '$rowcurso[2]' and abrev not like '%\_%'</option>";
	echo "<option value='$curso -> $asignatura -> $codasi'>$curso -> $asignatura</option>";
 }
 
}
?>
          </SELECT>
        <br /><br />
         
         <label class="checkbox"> 
    <input type="checkbox" name="asignaturas" value="1"> &nbsp; Mostrar asignaturas
  </label>
  <br /><br />
  <button class="btn btn-primary btn-block" type="submit" name="submit1" value="Lista del Curso">Lista del curso</button>
</form>
</div>
<div  class="span4">
<?
$query_Recordset1 = "SELECT distinct unidad FROM alma ORDER BY unidad ASC";
$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_array($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$query_Recordset2 = "SELECT * FROM alma ORDER BY apellidos ASC";
$Recordset2 = mysql_query($query_Recordset2) or die(mysql_error());
$row_Recordset2 = mysql_fetch_array($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<form id="form1" name="form1" method="post" action="excel.php" class="well well-large ">
<legend>Lista para Hoja de Cálculo</legend>
<p class="block-help">Selecciona el Grupo para exportar los datos al formato de las Hojas de Cálculo, como Calc o Excel.</p>
<hr />
 <label><select name="select" class="input-block-level" required>
    <?php 
do {  
?>
    <option><?php  echo $row_Recordset1[0]?></option>
    <?php 
} while ($row_Recordset1 = mysql_fetch_array($Recordset1));
  $rows = mysql_num_rows($Recordset1);
?>
  </select>
 </label>
 <br />
    <label class="checkbox"><input type="checkbox" name="tipo" value="2"> Mostrar asignaturas
 </label>
  <br /><br />
   <button class="btn btn-primary btn-block" type="submit" name="boton1" value="Enviar">Lista del curso</button>
 
</form>
</div>
</div>
  </div> 

<?  
}
	include("../../pie.php");
?>
</BODY>
</HTML>
