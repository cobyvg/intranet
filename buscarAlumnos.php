<?php
header('Content-Type: text/html; charset=ISO-8859-1');
include("config.php");
// Fichero que realiza la consulta en la base de datos y devuelve los resultados
if(isset($_POST["word"]))
{

	if($_POST["word"]{0}=="*"){
		$result=mysql_query("SELECT CONCAT(apellidos,', ',nombre) AS alumno, claveal, unidad FROM alma WHERE CONCAT(apellidos,' ',nombre) LIKE '%".substr($_POST["word"],1)."%' and CONCAT(apellidos,' ',nombre)<>'".$_POST["word"]."' ORDER BY alumno LIMIT 10");}
	else{
		$result=mysql_query("SELECT CONCAT(apellidos,', ',nombre) AS alumno, claveal, unidad FROM alma WHERE (CONCAT(apellidos,' ',nombre) LIKE '%".$_POST["word"]."%' and CONCAT(apellidos,' ',nombre) like '%".$_POST["word"]."%') or (CONCAT(nombre,' ',apellidos) LIKE '%".$_POST["word"]."%' and CONCAT(nombre,' ',apellidos) like '%".$_POST["word"]."%') ORDER BY alumno LIMIT 10");
	}
	echo '<ul class="nav nav-tabs nav-stacked">';
	while($row=mysql_fetch_array($result))
	{
		// Mostramos las lineas que se mostraran en el desplegable. Cada enlace
		// tiene una funcion javascript que pasa los parametros necesarios a la
		// funcion selectItem
		$datos=$row[0];
		$clave_al=$row[1];
		$curso_al=$row[2];
		echo '
<li><a href="admin/datos/datos.php?seleccionado=1&alumno='.$datos.' --> '.$clave_al.'"> '.$datos.' <span class="label pull-right">'.$curso_al.'</span></a></li>';
	}
	echo '</ul>';
}
?>
