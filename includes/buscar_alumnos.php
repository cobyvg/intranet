<?php
header('Content-Type: text/html; charset=ISO-8859-1');
include("../config.php");
// Fichero que realiza la consulta en la base de datos y devuelve los resultados
if(isset($_POST["word"]))
{

	if($_POST["word"]{0}=="*"){
		$result=mysql_query("SELECT apellidos, nombre, claveal, unidad FROM alma WHERE apellidos LIKE '%".substr($_POST["word"],1)."%' and apellidos<>'".$_POST["word"]."' ORDER BY apellidos LIMIT 10");}
	else{
		$result=mysql_query("SELECT apellidos, nombre, claveal, unidad FROM alma WHERE (apellidos LIKE '%".$_POST["word"]."%' and apellidos like '%".$_POST["word"]."%') or (nombre LIKE '%".$_POST["word"]."%' and nombre like '%".$_POST["word"]."%') ORDER BY apellidos LIMIT 10");
	}
	while($row=mysql_fetch_array($result))
	{
		// Mostramos las lineas que se mostraran en el desplegable. Cada enlace
		// tiene una funcion javascript que pasa los parametros necesarios a la
		// funcion selectItem
		$datos=$row[0].", ".$row[1];
		$clave_al=$row[2];
		$curso_al=$row[3];
		echo "
<li class='nav'><a href=\"admin/datos/datos.php?seleccionado=1&alumno=".$datos." --> ".$clave_al."\" style='width:100%;line-height:18px;'><i class='icon icon-user'> </i> $datos <SPAN STYLE='FLOAT:RIGHT;'>$curso_al</span></a></li>";
	}
}
?>
