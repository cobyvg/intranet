<?
session_start();
include("../../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}

// COMPROBAMOS SI SE A�ADE O SE MODIFICA UNA REGLA
if(isset($_GET['id'])) {
	if (!intval($_GET['id'])) die ("<h1>Forbidden</h3>");
	
	$titulo = "Modificaci�n de regla";
	$boton = "Actualizar";
	$id = $_GET['id'];
}
else {
	$titulo = "A�adir nueva regla";
	$boton = "A�adir regla";
}

// ENVIO DE FORMULARIO
if(isset($_POST['submit'])) {
	$asunto = $_POST['asunto'];
	$medida = $_POST['medida'];
	$medida2 = $_POST['medida2'];
	$gravedad = $_POST['gravedad'];
	
	if(empty($asunto) || empty($medida2)) {
		$msg = "Todos los campos son obligatorios";
	}
	else {
		if(isset($_GET['id'])) {
			mysql_query("UPDATE listafechorias SET fechoria='$asunto', medidas='$medida', medidas2='$medida2', tipo='$gravedad' WHERE id='$id'") or die(mysql_error());
			header("Location:"."index.php?msg=update");
		}
		else {
			mysql_query("INSERT listafechorias (fechoria, medidas, medidas2, tipo) VALUES ('$asunto', '$medida', '$medidas2', '$gravedad')") or die(mysql_error());
			header("Location:"."index.php?msg=insert");
		}
	}
}
?>
<?php
include("../../../menu.php");
?>
<br />
<div class="page-header" align="center">
  <h2>Reglamento de Organizaci�n y Funcionamiento del Centro</h2>
</div>


<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
<div class="row">
	<div class="offset3 span7 well">
	
	<?php 
	if($msg) {
	 echo "<div class=\"alert alert-error\">\n";
	 echo "  $msg";
	 echo "</div>\n";
	}
	?>
	
	<?php
	echo '<fieldset>';
	echo '  <legend>'.$titulo.'</legend>';
	
	$result = mysql_query("SELECT fechoria, medidas, medidas2, tipo FROM listafechorias WHERE id='$id'");
	
	$fechoria = mysql_fetch_array($result);
		
	echo '  <label for="asunto">Asunto</label>';
	echo '  <input type="text" id="asunto" class="input-block-level" name="asunto" value="'.$fechoria[0].'" required>';
	echo '  <br><br>';
	echo '  <label for="medida">Medida</label>';
	echo '  <select class="input-block-level" name="medida" required>';
	
	if($fechoria[1]=="Amonestaci�n oral") $selected1="selected";
	if($fechoria[1]=="Amonestaci�n oral. Llamada telef�nica.") $selected2="selected";
	if($fechoria[1]=="Amonestaci�n escrita") $selected3="selected";
	if($fechoria[1]=="Llamada telef�nica. Comunicaci�n escrita") $selected4="selected";
	
	echo '    <option '.$selected1.'>Amonestaci�n oral</option>';
	echo '    <option '.$selected2.'>Amonestaci�n oral. Llamada telef�nica.</option>';
	echo '    <option '.$selected3.'>Amonestaci�n escrita</option>';
	echo '    <option '.$selected4.'>Llamada telef�nica. Comunicaci�n escrita</option>';
	echo '  </select>';
	echo '  <br><br>';
	echo '  <label for="medida2">Medida complementaria</label>';
	echo '  <textarea type="text" id="medida2" class="input-block-level" name="medida2" rows="5" required>'.$fechoria[2].'</textarea>';
	echo '  <br>';
	echo '  <label for="gravedad">Gravedad</label>';
	echo '  <select class="input-block-level" name="gravedad" required>';
	
	if($fechoria[3]=="leve") $selected2_1="selected";
	if($fechoria[3]=="grave") $selected2_2="selected";
	if($fechoria[3]=="muy grave") $selected2_3="selected";
	
	echo '    <option '.$selected2_1.'>leve</option>';
	echo '    <option '.$selected2_2.'>grave</option>';
	echo '    <option '.$selected2_3.'>muy grave</option>';
	echo '  </select>';
	echo '  <br><br>';
	echo "</tr>\n";
	
	echo '</fieldset>';
	
	?>
	</div>
</div>

<br>
<div align="center">
  <a href="index.php" class="btn btn-default">Cancelar</a>
  <input type="submit" name="submit" class="btn btn-primary" value="<?php echo $boton; ?>">
</div>
<br>
<br>
</form>

<?php
include("../../../pie.php");
?>
</body>
</html>