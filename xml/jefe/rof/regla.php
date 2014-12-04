<?
session_start();
include("../../../config.php");
include_once('../../../config/version.php');
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


$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}

// COMPROBAMOS SI SE AÑADE O SE MODIFICA UNA REGLA
if(isset($_GET['id'])) {
	if (!intval($_GET['id'])) die ("<h1>Forbidden</h3>");
	
	$titulo = "Modificación de regla";
	$boton = "Actualizar";
	$id = $_GET['id'];
}
else {
	$titulo = "Añadir nueva regla";
	$boton = "Añadir regla";
}

// ENVIO DE FORMULARIO
if(isset($_POST['submit'])) {
	
	// Modificamos tabla
	mysqli_quety($db_con,"ALTER TABLE `listafechorias` CHANGE `ID` `ID` INT(4) NOT NULL AUTO_INCREMENT");
	
	$asunto = $_POST['asunto'];
	$medida = $_POST['medida'];
	$medida2 = $_POST['medida2'];
	$gravedad = $_POST['gravedad'];
	
	if(empty($asunto) || empty($medida2)) {
		$msg = "Todos los campos son obligatorios";
	}
	else {
		if(isset($_GET['id'])) {
			mysqli_query($db_con, "UPDATE listafechorias SET fechoria='$asunto', medidas='$medida', medidas2='$medida2', tipo='$gravedad' WHERE id='$id'") or die(mysqli_error($db_con));
			header("Location:"."index.php?msg=update");
		}
		else {
			mysqli_query($db_con, "INSERT listafechorias (fechoria, medidas, medidas2, tipo) VALUES ('$asunto', '$medida', '$medidas2', '$gravedad')") or die(mysqli_error($db_con));
			header("Location:"."index.php?msg=insert");
		}
	}
}
?>
<?php
include("../../../menu.php");
?>
<div class="container">
	
	<div class="page-header">
	  <h2>ROF <small>Añadir nueva regla</small></h2>
	</div>
	
	
	<div class="row">
	
		<div class="col-sm-6 col-sm-offset-3">
		
			<div class="well">
		
				<form method="post" action="">
			
					<?php 
					if($msg) {
					 echo "<div class=\"alert alert-danger\">\n";
					 echo "  $msg";
					 echo "</div>\n";
					}
					?>
					
					<?php
					echo '<fieldset>';
					echo '  <legend>'.$titulo.'</legend>';
					
					$result = mysqli_query($db_con, "SELECT fechoria, medidas, medidas2, tipo FROM listafechorias WHERE id='$id'");
					
					$fechoria = mysqli_fetch_array($result);
						
					echo '  <label for="asunto">Asunto</label>';
					echo '  <input type="text" id="asunto" class="form-control" name="asunto" value="'.$fechoria[0].'" required>';
					echo '  <br><br>';
					echo '  <label for="medida">Medida</label>';
					echo '  <select class="form-control" name="medida" required>';
					
					if($fechoria[1]=="Amonestación oral") $selected1="selected";
					if($fechoria[1]=="Amonestación oral. Llamada telefónica.") $selected2="selected";
					if($fechoria[1]=="Amonestación escrita") $selected3="selected";
					if($fechoria[1]=="Llamada telefónica. Comunicación escrita") $selected4="selected";
					
					echo '    <option '.$selected1.'>Amonestación oral</option>';
					echo '    <option '.$selected2.'>Amonestación oral. Llamada telefónica.</option>';
					echo '    <option '.$selected3.'>Amonestación escrita</option>';
					echo '    <option '.$selected4.'>Llamada telefónica. Comunicación escrita</option>';
					echo '  </select>';
					echo '  <br><br>';
					echo '  <label for="medida2">Medida complementaria</label>';
					echo '  <textarea type="text" id="medida2" class="form-control" name="medida2" rows="5" required>'.$fechoria[2].'</textarea>';
					echo '  <br>';
					echo '  <label for="gravedad">Gravedad</label>';
					echo '  <select class="form-control" name="gravedad" required>';
					
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
					
					<button type="submit" class="btn btn-primary" name="submit"><?php echo $boton; ?></button>
					<a class="btn btn-default" href="index.php">Volver</a>
					
				</form>
				
			</div>
			
		</div><!-- /.col-sm-6 -->
		
	</div><!-- /.row -->

</div><!-- /.container -->

<?php include("../../../pie.php"); ?>

</body>
</html>
