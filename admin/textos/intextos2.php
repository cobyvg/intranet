<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
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
include("../../menu.php");
if (isset($_GET['nivel'])) {$nivel = $_GET['nivel'];}elseif (isset($_POST['nivel'])) {$nivel = $_POST['nivel'];}else{$nivel="";}
if (isset($_GET['titulo'])) {$titulo = $_GET['titulo'];}elseif (isset($_POST['titulo'])) {$titulo = $_POST['titulo'];}else{$titulo="";}
if (isset($_GET['asignatura'])) {$asignatura = $_GET['asignatura'];}elseif (isset($_POST['asignatura'])) {$asignatura = $_POST['asignatura'];}else{$asignatura="";}
if (isset($_GET['departamento'])) {$departamento = $_GET['departamento'];}elseif (isset($_POST['departamento'])) {$departamento = $_POST['departamento'];}else{$departamento="";}
if (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];}elseif (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];}else{$grupo="";}
if (isset($_GET['editorial'])) {$editorial = $_GET['editorial'];}elseif (isset($_POST['editorial'])) {$editorial = $_POST['editorial'];}else{$editorial="";}
if (isset($_GET['isbn'])) {$isbn = $_GET['isbn'];}elseif (isset($_POST['isbn'])) {$isbn = $_POST['isbn'];}else{$isbn="";}
if (isset($_GET['ano'])) {$ano = $_GET['ano'];}elseif (isset($_POST['ano'])) {$ano = $_POST['ano'];}else{$ano="";}
if (isset($_GET['autor'])) {$autor = $_GET['autor'];}elseif (isset($_POST['autor'])) {$autor = $_POST['autor'];}else{$autor="";}
if (isset($_GET['NOTAS'])) {$NOTAS = $_GET['NOTAS'];}elseif (isset($_POST['NOTAS'])) {$NOTAS = $_POST['NOTAS'];}else{$NOTAS="";}
if (isset($_GET['obligatorio'])) {$obligatorio = $_GET['obligatorio'];}elseif (isset($_POST['obligatorio'])) {$obligatorio = $_POST['obligatorio'];}else{$obligatorio="";}
if (isset($_GET['clase'])) {$clase = $_GET['clase'];}elseif (isset($_POST['clase'])) {$clase = $_POST['clase'];}else{$clase="";}
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
$uni = mysql_query("select distinct unidad from alma where curso = '$nivel'");
while ($unid = mysql_fetch_array($uni)) {
	$unida = $unid[0];
	if (isset($_GET[$unida])) {$unida = $_GET[$unida];}elseif (isset($_POST[$unida])) {$unida = $_POST[$unida];}else{$unida="";}
	$grupo .= $unida.";";
}
		
	// echo $grupo;
	echo '<br />
<div align="center">
<div class="page-header">
  <h2>Libros de Texto <small> Departamento de '.$departamento.'</small></h2>
</div><br />';

//$grupo = "$A$B$C$D$E$F$G$H";
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
//echo $query;
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
			<td><a href='editextos.php?id=$row[6]'><i class='fa fa-pencil' title='Editar'> </i> </a> <a href=deltextos.php?id=$row[6] style='color:brown;'><i class='fa fa-trash-o' title='Borrar' onClick='return confirmacion();'> </i></a></td>
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
