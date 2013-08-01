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
		echo '<br />
<div align="center">
<div class="page-header">
  <h2>Libros de Texto <small> Departamento de '.$departamento.'</small></h2>
</div><br />';

$grupo = "$A$B$C$D$E$F$G$H";
//Errores posibles
if (empty($titulo) or empty($asignatura) or empty($departamento) or empty($grupo) or empty($editorial) or empty($isbn)) 
{ 
echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No has introducido todos los datos.<br> Vuelve atrás e inténtalo de nuevo.
</div></div><br />';
	}
else
{  
$query="insert into Textos (Autor,Titulo,Editorial,Nivel,Grupo,Notas,Departamento, Asignatura,Obligatorio, Clase, isbn) values ('".$autor."','".$titulo."','".$editorial."','".$nivel."','".$grupo."','".$NOTAS."','".$departamento."','".$asignatura."','".$obligatorio."','".$clase."','".$isbn."')";
mysql_query($query);

	$textos = mysql_query("SELECT Departamento, Asignatura, Autor, Titulo, Editorial, Notas, Id, nivel, grupo  
	FROM Textos where Departamento = '$departamento'");

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
while($row = mysql_fetch_array($textos)) 
{
             echo "<tr>
			 <td>$row[0]</td>
			 <td>$row[1]</td>
			 <td>$row[2]</td><td>$row[3]</td><td>$row[4]</td>
		  	<td>$row[8]</td>
			<td><a href='editexto.php?id=$row[6]'><i class='icon icon-pencil' title='Editar'> </i> </a> <a href=deltextos.php?id=$row[6] style='color:brown;'><i class='icon icon-trash' title='Borrar'> </i></a></td>
			</tr>";
        }
		echo '</table>';
		   			echo '<br /><INPUT TYPE="button" VALUE="Volver Atrás"
   onClick="history.back()" class="btn btn-primary">';

   }	

 ?>
 <? include("../../pie.php");?>		
</BODY>
</HTML>
