<?
if ($insertar) 
	{ 
include("intextos2.php");	
die;
	}
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
		echo '<br />
<div align="center">
<div class="page-header">
  <h2>Libros de Texto <small> '.$nivel.'</small></h2>
</div><br />';

	if (!$titulo or !$asignatura or !$departamento or !$isbn) 
	{ 
	echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No has introducido todos los datos necesarios para registrar el texto. <br>Vuelve atrás e inténtalo de nuevo.</div></div><br />';
	exit();
	}
$grupo = "$A$B$C$D$E$F$G$H";
//Introducción de datos si todo va bién
		$query="UPDATE Textos SET Titulo = '$titulo', Autor = '$autor', 
		Editorial = '$editorial', Departamento = '$departamento', 
		Asignatura = '$asignatura', Notas = '$NOTAS', isbn = '$isbn', nivel = '$nivel', grupo = '$grupo' where Id = '$id'";
//		echo $query;
		mysql_query($query);
		echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El texto se ha registrado correctamente. <br>Comprueba los datos en la tabla de abajo, y en caso de no ser correctos, puedes volver a editarlos.</div></div><br />';

	$textos = mysql_query("SELECT Departamento, Asignatura, Autor, Titulo, Editorial, Notas, Id, Nivel, Grupo FROM Textos where Id='$id' order by Asignatura");
   if ($row = mysql_fetch_array($textos))
   {
		echo "<table class='table table-striped' style='width:auto'>
  <tr> 
    <th>DEPARTAMENTO</th>
	<th>ASIGNATURA</th>
	<th>AUTOR</th>
	<th>TITULO</th>
	<th>EDITORIAL</th>
	<th>GRUPOS</th>
	<th></th>
  </tr>";
do
{
             echo "<tr>
			 <td>$row[0]</td>
			 <td>$row[1]</td>
			 <td>$row[2]</td>
			 <td>$row[3]</td>
			 <td>$row[4]</td>
		  <td>$row[8]</td>
		  <td><a href='editexto.php?id=$row[6]'><i class='icon icon-pencil' title='Editar'> </i> </a> <a href=deltextos.php?id=$row[6] style='color:brown;'><i class='icon icon-trash' title='Borrar'> </i></a></td>
		  </tr>";

        } while($row = mysql_fetch_array($textos));	
		}
		
?>
</div>
 <? include("../../pie.php");?>		
</BODY>
</HTML>
