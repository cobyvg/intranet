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
<?
include("../../menu.php");
include("../menu.php");

// Si ya hemos enviado los datos, nos vamos a alumnos.php
if($enviar=='Enviar datos')
{
include("alumnos.php");
}
else
{

?>

<div align=center>
<div class="page-header" align="center">
  <h1>Centro TIC <small> Nombres de Usuario de Alumnos</small></h1>
</div>
<br />
</div>
<br />
<div align=center>
<div class="well-2 well-large" style="width:450px; text-align:left">
  <form action="intro.php" method="post" name="form1" id="form1">
      <?
 if(stristr($_SESSION['cargo'],'1') == TRUE)
{
 ?>
 <label>Profesor<br />
 <select name="profe" onchange='submit()' class="span3">
            <?
echo "<option>$profe</option>";

// Seleccion de Profesor en profes.
$SQL = "select distinct PROFESOR from profesores order by PROFESOR asc";
//echo $SQL;
$result = mysql_query($SQL);

	while($row = mysql_fetch_array($result))
	{
	$profesor = $row[0];
	echo "<option>" . $profesor . "</option>";
}
	// Selección de las asignaturas del profesor
?>
          </select>
          </label>
      <? }
else
{
echo "<h6>Selecciona el Curso</h6>";
$profe = $_SESSION['profi'];
}
?>
      <label>Curso<br /> 
	  <? $SQLcurso = "select distinct GRUPO, MATERIA, NIVEL, codigo from profesores, asignaturas where materia = nombre and abrev not like '%\_%' and PROFESOR = '$profe' and nivel = curso order by grupo";
//echo $SQLcurso;
?>
          <select name="curso" class="span4">
            <?
	echo "<option></option>";

$resultcurso = mysql_query($SQLcurso);
	while($rowcurso = mysql_fetch_array($resultcurso))
	{
	$curso = $rowcurso[0];
	$materia = $rowcurso[1];
	$nivel = $rowcurso[2];
	$codigo = $rowcurso[3];
	echo "<option>" . $curso . "-->" . $materia . "-->" . $nivel . "-->" . $codigo . "</option>";
}
?>
          </select>
          </label>
          <br />
          <input name="enviar" type="submit" value="Enviar datos" class="btn btn-primary">
  </form>
</div>
</div>
<?
}

include("../../pie.php");
?>
</body>
</html>