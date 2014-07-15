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
<script>
function confirmacion() {
	var answer = confirm("ATENCIÓN:\n ¿Estás seguro de que quieres borrar los datos? Esta acción es irreversible. Para borrarlo, pulsa Aceptar; de lo contrario, pulsa Cancelar.")
	if (answer){
return true;
	}
	else{
return false;
	}
}
</script>
<?php
//Conecxión con la base de datos.
 
include("../../menu.php");
include 'menu.php';

if (isset($_GET['departamento'])) {$departamento = $_GET['departamento'];}elseif (isset($_POST['departamento'])) {$departamento = $_POST['departamento'];}else{$departamento="";}
if (strstr(" P.E.S.",$departamento)==TRUE) {
	$departamento = str_replace(" P.E.S","",$departamento);
}
if (isset($_GET['nivel'])) {$nivel = $_GET['nivel'];}elseif (isset($_POST['nivel'])) {$nivel = $_POST['nivel'];}else{$nivel="";}

$AUXSQL = "";
  if  (TRIM("$departamento")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and Textos.Departamento = '$departamento'";
    }
// Base de datos
?>
<br />
<div align="center">
<div class="page-header">
  <h2>Libros de Texto <small> Búsqueda de textos</small></h2>
</div>
<?
	print "<h3>$nivel</h3><br />"; 
$textos = mysql_query("SELECT distinct Departamento, Asignatura, Autor, Titulo, Editorial, Notas, Id, nivel, grupo FROM Textos where nivel = '$nivel' " . $AUXSQL . " order by Asignatura");
   if ($row = mysql_fetch_array($textos))
   {

	echo "<br /><table class='table table-striped' style='width:90%'>
  <tr> 
    
    <th>DEPARTAMENTO</th>
	<th>ASIGNATURA</th>
	<th>AUTOR</th>
	<th>TITULO</th>
	<th>EDITORIAL</th>
	<th>GRUPOS</th>";
	 if(stristr($_SESSION['cargo'],'1') == TRUE OR (stristr($_SESSION['cargo'],'4') == TRUE and $_SESSION['depto'] == $row[0]))
{
	echo "<th></th>";
			 }

  echo "</tr>";
do
{
             echo "<tr>";		 
			 echo "
			 <td>$row[0]</td>
			 <td>$row[1]</td>
			 <td>$row[2]</td><td>$row[3]</td><td>$row[4]</td>
		  <td>$row[8]</td>";
		   if(stristr($_SESSION['cargo'],'1') == TRUE OR (stristr($_SESSION['cargo'],'4') == TRUE and $_SESSION['depto'] == $row[0]))
{
	echo "<td nowrap><a href='editextos.php?id=$row[6]'><i class='fa fa-pencil' title='Editar'> </i> </a>&nbsp;&nbsp;<a href=deltextos.php?id=$row[6] style='color:brown;'><i class='fa fa-trash-o' title='Borrar' onClick='return confirmacion();'> </i></a></td>";
			 }
		  
		  echo "</tr>";

        } while($row = mysql_fetch_array($textos));	
		}
		else
		{
			echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No hubo suerte, bien porque te has equivocado
        al introducir los datos, bien porque ningún dato se ajusta a tus criterios.
		</div></div><br />';
		echo '<input type="submit" name="enviar2" value="Volver atrás" onClick="history.back(1)" class="btn btn-primary">';
		}

?>
 <? include("../../pie.php");?>		
</BODY>
</HTML>
