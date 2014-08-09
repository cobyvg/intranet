<?php
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

// COMPROBACION DE ACCESO AL MODULO
if(!stristr($_SESSION['cargo'],'1') == TRUE || stristr($_SESSION['cargo'],'2') == TRUE || stristr($_SESSION['cargo'],'8') == TRUE) {
	
	if (isset($_SESSION['mod_tutoria'])) unset($_SESSION['mod_tutoria']);
	die ("<h1>FORBIDDEN</h1>");
	
}
else {
	
	// COMPROBAMOS SI ES EL TUTOR, SINO ES DEL EQ. DIRECTIVO U ORIENTADOR
	if (stristr($_SESSION['cargo'],'2') == TRUE) {
		
		$_SESSION['mod_tutoria']['tutor']  = $_SESSION['tut'];
		$_SESSION['mod_tutoria']['unidad'] = $_SESSION['s_unidad'];
		
	}
	else {
	
		if(isset($_POST['tutor'])) {
			$exp_tutor = explode('==>', $_POST['tutor']);
			$_SESSION['mod_tutoria']['tutor'] = trim($exp_tutor[0]);
			$_SESSION['mod_tutoria']['unidad'] = trim($exp_tutor[1]);
		}
		else{
			if (!isset($_SESSION['mod_tutoria'])) {
				header('Location:'.'tutores.php');
			}
		}
		
	}
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

include("../../menu.php");
include("menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Tutoría de <?php echo $_SESSION['mod_tutoria']['unidad']; ?> <small>Credenciales de alumnos/as</small></h2>
			<h4 class="text-info">Tutor/a: <?php echo mb_convert_case($_SESSION['mod_tutoria']['tutor'], MB_CASE_TITLE, "iso-8859-1"); ?></h4>
		</div>
		
		<!-- MENSAJES -->
		<?php if(isset($msg_error)): ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $msg_error; ?>
		</div>
		<?php endif; ?>
		
		<?php if(isset($msg_success)): ?>
		<div class="alert alert-success" role="alert">
			<?php echo $msg_success; ?>
		</div>
		<?php endif; ?>
		
		
		<!-- SCAFFOLDING -->		
		<div class="row">
			
			
			<!-- COLUMNA CENTRAL -->
			<div class="col-sm-12">

				
			</div><!-- /.col-sm-12 -->
			
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

</body>
</html>
