<?
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
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
if (isset($_GET['A'])) {$A = $_GET['A'];}elseif (isset($_POST['A'])) {$A = $_POST['A'];}else{$A="";}
if (isset($_GET['B'])) {$B = $_GET['B'];}elseif (isset($_POST['B'])) {$B = $_POST['B'];}else{$B="";}
if (isset($_GET['C'])) {$C = $_GET['C'];}elseif (isset($_POST['C'])) {$C = $_POST['C'];}else{$C="";}
if (isset($_GET['D'])) {$D = $_GET['D'];}elseif (isset($_POST['D'])) {$D = $_POST['D'];}else{$D="";}
if (isset($_GET['E'])) {$E = $_GET['E'];}elseif (isset($_POST['E'])) {$E = $_POST['E'];}else{$E="";}
if (isset($_GET['F'])) {$F = $_GET['F'];}elseif (isset($_POST['F'])) {$F = $_POST['F'];}else{$F="";}
if (isset($_GET['G'])) {$G = $_GET['G'];}elseif (isset($_POST['G'])) {$G = $_POST['G'];}else{$G="";}
if (isset($_GET['H'])) {$H = $_GET['H'];}elseif (isset($_POST['H'])) {$H = $_POST['H'];}else{$H="";}
		
if (isset($_POST['insertar'])) 
	{ 
include("intextos2.php");	
die;
	}
session_start();
include("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
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
		Asignatura = '$asignatura', Notas = '$NOTAS', isbn = '$isbn', nivel = '$nivel', grupo = '$grupo', obligatorio = '$obligatorio' where Id = '$id'";
		//echo $query;
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
		  <td><a href='editextos.php?id=$row[6]'><i class='fa fa-pencil' title='Editar'> </i> </a> <a href=deltextos.php?id=$row[6] style='color:brown;'><i class='fa fa-trash-o' title='Borrar' data-bb='confirm-delete'> </i></a></td>
		  </tr>";

        } while($row = mysql_fetch_array($textos));	
		}
		
?>
</div>
 <? include("../../pie.php");?>		
</BODY>
</HTML>
