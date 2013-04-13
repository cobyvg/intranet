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
if(stristr($_SESSION['cargo'],'1') == TRUE)
{
	$profe = $prof;
	
}
else{
	$profe = $_SESSION['profi'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Seleccionar Profesor ...</title>
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css">
</head>
<body>
<? include("../../menu.php");?>
<div class="titulogeneral" align="center">Evaluación de Competencias.</div>           


        <table width="300" align='center' cellpadding="5" cellspacing="1" bgcolor='#666666'>
<?
if(stristr($_SESSION['cargo'],'1') == TRUE)
{
?>
          <tr>
            <td align='center' id="filaprincipal">Selección del Profesor. </td>
          </tr>
          <tr>
            <td align="center" >
            
            <? 
            
            $SQLprof = "select distinct profesor from profesores order by profesor";
//echo $SQLcurso;
?>
    <form enctype="multipart/form-data" action="index.php" method="post">
  <select name="prof" onchange="submit()">
    <?
	echo "<option>$prof</option>";

$resultprof = mysql_query($SQLprof);
	while($rowprof = mysql_fetch_array($resultprof))
	{
	$prof = $rowprof[0];
	$materia = $rowprof[1];
	$nivel = $rowprof[2];
	$codigo = $rowprof[3];
	echo "<option>" . $prof . "</option>";
}
?>
  </select></form>
                <br /></td>
          </tr>
<?
}
?>
        <tr>
            <td align='center' id="filaprincipal">Selección del Grupo para evaluar. </td>
          </tr>
          <tr>
            <td align="center" >
            
            <? 
            
            $SQLcurso = "select distinct GRUPO, MATERIA, NIVEL, codigo from profesores, asignaturas where materia = nombre and abrev not like '%\_%' and PROFESOR = '$profe' and nivel = curso and (curso like '%E.S.O.%' or curso like '2º de P.C.P.I.%') order by grupo";
//echo $SQLcurso;
?>
    <form enctype="multipart/form-data" action="competencias.php" method="post">
  <select name="datos" onchange="submit()">
    <?
	echo "<option></option>";

$resultcurso = mysql_query($SQLcurso);
	while($rowcurso = mysql_fetch_array($resultcurso))
	{
	$curso = $rowcurso[0];
	$materia = $rowcurso[1];
	$nivel = $rowcurso[2];
	$codigo = $rowcurso[3];
	echo "<option>" . $curso . "-->" . $materia . "-->" . $nivel . "-->" . $codigo. "</option>";
}
?>
  </select></form>
                <br /></td>
          </tr>
        </table>
<br>
 
</body>
</html>