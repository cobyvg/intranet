<? 
session_start();
if($_SESSION['aut']<>1)
{
header("location:http://iesmonterroso.org");
exit;	
}
	$clave_al = $_SESSION['clave_al'];
	$claveal = $_SESSION['clave_al'];
	$todosdatos = $_SESSION['todosdatos'];
	$unidad = $_SESSION['unidad'];
	$sen_nivel = $_SESSION['sen_nivel'];
	include("../conf_principal.php");
	include("../funciones.php");
	mysql_connect ($host, $user, $pass);
	mysql_select_db ($db);
?>
<? include "../cabecera.php"; ?>
<? include('consultas.php'); ?>
<div class="span9">	
<style>
.table th{
font-weight:bold;
}
</style>
<?php
   echo "<h3 align='center'>$todosdatos<br /></h3>";
     echo "<p class='lead muted' align='center'><i class='icon icon-book'> </i> Libros de Texto del Grupo $unidad</p><hr />";
// Consulta para el Grupo del Alumno.
echo "<br><table class='table table-striped table-bordered' style='width:90%;margin:auto'>";
echo "<tr class='text-info'><th>
	ASIGNATURA</th><th>
	AUTOR</th><th>
	TÍTULO</th><th>
	EDITORIAL</th><th>
	TIPO</th></tr>";

$textos0 = "SELECT distinct Asignatura, Departamento, Autor, Titulo, Editorial, Obligatorio, Nivel, Grupo FROM Textos where Nivel like '" . $sen_nivel . "%' and Grupo like '%" .$grupo ."%' order by Asignatura";
$textos = mysql_query($textos0);
while($row = mysql_fetch_array($textos))
   {
    printf ("<tr><td class='text-info'>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n",
		  $row[0], $row[2], $row[3], $row[4], $row[5]);
        } 
echo "</table>";
?>
</div>
</div>
   </div><!-- Central -->
</div><!-- Contenedor -->
</body>
</html>
