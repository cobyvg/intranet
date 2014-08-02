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
if(!(strstr($_SESSION['cargo'],'1') == TRUE) and !(strstr($_SESSION['cargo'],'8') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
        <?php	
include("../../menu.php");
//
?>
<br />
<div align="center">
<div class="page-header">
  <h2>Página del Tutor <small> Entrada</small></h2>
</div>
<br />
   <div class="well well-large" style="width:400px;">           
    <form action="global.php" method="post" name="form1" id="form1" class="form-inline">
       <legend>Selecciona Tutor</legend>
        <select name="tutor" onchange='submit()' class="input-xlarge">
        <option> <? echo $profe; ?></option>		
          <?
  // Seleccion de Profesor en profes.
$SQL = "select distinct tutor, unidad from FTUTORES order by unidad asc";
$result = mysql_query($SQL);

	while($row = mysql_fetch_array($result))
	{
	$tutor0 = $row[0];
	$nivel = $row[1];
	echo "<option  class=content>$tutor0 ==> $nivel</option>";
}
?>
        </select>
        </form>
<?php
	include("../../pie.php");
?>
</body>
</html>
