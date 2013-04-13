<?
if(stristr($_SESSION['cargo'],'4') == TRUE)
{
include("introducir.php");
}
else{
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?php
include("../../menu.php");
include("menu.php");
?>
<div class="page-header" align="center">
  <h1>Material del Centro <small> Seleccionar Departamento</small></h1>
</div>
<br /><div class="well-2 well-large" align="center" style="width:400px;margin:auto">
<br />
<form name="textos" method="post" action="introducir.php">
                 <select name="departamento" id="departamento"  value ="Todos ...">
        <option>
        <? // echo $departamento;?>
        </option>
        <?
  $profe = mysql_query(" SELECT distinct departamento FROM departamentos, profesores where departamento not like 'admin' and departamento not like 'Administracion' and departamento not like 'Conserjeria' order by departamento asc");
  while($filaprofe = mysql_fetch_array($profe))
	{
	if ($filaprofe[0] == "Lengua Castellana" or $filaprofe[0] == "Lengua Extranjera-Inglés (Secundaria)" or $filaprofe[0] == "Matemáticas" or strstr($filaprofe[0],"Religi")==TRUE or strstr($filaprofe[0],"Apoyo")==TRUE or strstr($filaprofe[0],"Pedagog")==TRUE)
	{}
	else
	{
	$departamen = $filaprofe[0]; 
	$opcion1 = printf ("<OPTION>$departamen</OPTION>");
	echo "$opcion1";
	}
	} 
	?>
    <option>-------------------------------</option>
    <option>Plan de Autoprotección</option>
	<option>Plan de Biblioteca</option>
    <option>Plan Espacio de Paz</option>
    <option>Plan de Deporte en la Escuela</option>
    <option>Centro TIC</option>    
      </select>
                  <br /><br />
                  <button type="submit" name="enviar2" value="Enviar" class="btn btn-primary"><i class="icon icon-search icon-white"> </i> Enviar </button>
            </form>
</div>
<br />
<?
}
	include("../../pie.php");
?>
</body>
</html>