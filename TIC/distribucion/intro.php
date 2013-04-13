       <?
// Si ya hemos enviado los datos, nos vamos a distribucion.php
if(strlen($curso)>0)
{
include("distribucion.php");
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
?>      
<?php
include("../../menu.php");
include("../menu.php");
?>
<div align=center>
  <h3>Distribución de los alumnos en aulas TIC.</h3><br />
</div>
<div align=center>
 <?
 if(stristr($_SESSION['cargo'],'1') == TRUE)
{
 ?> 
  	<div class="well-2 well-large" align="center" style="width:450px;">
  	<form action="intro.php" method="post" name="form1" id="form1">
			
        <label>Profesor<br />
        <select name="profe" onchange="submit()" class="input-xlarge">
		<option><? echo $profe; ?></option>
<? // Seleccion de Profesor en profes.
$SQL = "select distinct PROFESOR from profesores order by PROFESOR asc";
//echo $SQL;
$result = mysql_query($SQL);	
while($row = mysql_fetch_array($result))
{
	$profesor = $row[0];?>
	<option><? echo $profesor;?></option>   
<? 
}
?>
</select>
</label>
</form>

<form action="distribucion.php?profe=<? echo $profe; ?>" method="post" name="form1" id="form1">	
	<label>Curso o Agrupamiento<br />
<?
$SQLcurso = "select distinct agrupamiento,c_asig from AsignacionMesasTIC where prof='$profe'" or die ("error al seleccionar");
?>
   <select name='curso' onchange='submit()' class="input-xlarge">
      	<option></option>
   	<? 
   	$resultcurso = mysql_query($SQLcurso);
	while($rowcurso = mysql_fetch_array($resultcurso))
	{ //echo $rowcurso[0];
	$trozos=explode(":",$rowcurso[0]);
	if (count($trozos)==4) {$grupo=$trozos[0].','.$trozos[1].','.$trozos[2];}
	elseif (count($trozos)==3) {$grupo=$trozos[0].','.$trozos[1];}
	else {$grupo=$trozos[0];}
	//$asig = substr ($rowcurso[1], 2, 0);
	$asig=$rowcurso[1];
	$curs=$grupo."-->".$asig;
	echo "<option>".$grupo."-->".$asig."</option>";
} ?>  </select>            
</label>
    </form>	
	<? }
	// si no es administrador ni tiene perfil de direccion
else
{
$profe = $_SESSION['profi']; //echo $profe;
?> <form action="distribucion.php?profe=<? echo $profe; ?>" method="post" name="form1" id="form1">
<label>Curso o Agrupamiento	
    <select name='curso' onchange='submit()' class="input-xlarge"><?
$SQLcurso = "select distinct agrupamiento, c_asig from AsignacionMesasTIC where prof='$profe'";
//echo $SQLcurso;
?>	
<option></option>
<?
$resultcurso = mysql_query($SQLcurso);// echo $resultcurso;
	while($rowcurso = mysql_fetch_array($resultcurso))
	{ //echo $rowcurso[0];
	$trozos=explode(":",$rowcurso[0]);
	if (count($trozos)==4) {$grupo=$trozos[0].','.$trozos[1].','.$trozos[2];}
	elseif (count($trozos)==3) {$grupo=$trozos[0].','.$trozos[1];}
	else {$grupo=$trozos[0];}
	//$asig = substr ($rowcurso[1], 2, 0);
	//$asig=substr ($rowcurso[1], 5);
	echo "<option>".$grupo."-->".$rowcurso[1]."</option>";	 
} }
?>  
</select>  
</label>
    </form>
</div>
</body>
</html>
<?
}
?>

