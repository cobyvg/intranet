<?
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



$pr = $_SESSION['profi'];

$id = intval($_GET['id']);
$idprof = intval($_GET['idprof']);

$result = mysqli_query($db_con, "SELECT asunto, ahora, texto, origen FROM mens_texto where id = '$id'") or die (mysqli_error($db_con));
$mensaje = mysqli_fetch_array($result);

if(mysqli_num_rows($result)<1) {
	header('Location:'.'index.php');
	exit();
}


mysqli_query($db_con, "UPDATE mens_profes SET recibidoprofe = '1' WHERE id_profe = '$idprof'");

$page_header = $mensaje['asunto'];
include("../../menu.php");
include("menu.php");
?>

	<div class="container">
	  
	  <!-- TITULO DE LA PAGINA -->
	  <div class="page-header">
	    <h2>Mensajes <small>Leer un mensaje</small></h2>
	  </div>
		
	  <!-- SCAFFOLDING -->
	  <div class="row">
	  	
	  	<!-- COLUMNA CENTRAL -->
	    <div class="col-sm-12">
	    	<?php $exp_profesor = explode(',', $mensaje['origen']); ?>
	    	<?php $profesor = $exp_profesor[1].' '.$exp_profesor[0]; ?>
	    	
	    	<h3 class="text-info"><?php echo $mensaje['asunto']; ?></h3>
	    	<h5 class="text-muted">Enviado por <?php echo $profesor; ?> el <?php echo fecha_actual2($mensaje['ahora']); ?></h5>
	    	
	    	<br>
	    	
	      <?php echo $mensaje['texto']; ?>
	      
				<br>
				<br>
	      
	      <div class="hidden-print">
	      	<a href="index.php" class="btn btn-default">Volver</a>
	      	<a href="redactar.php?profes=1&origen=<?php echo $mensaje['origen']; ?>&asunto=RE: <?php echo $mensaje['asunto']; ?>" class="btn btn-primary">Responder</a>
	      	<a href="#" class="btn btn-info" onclick="javascript:print();">Imprimir</a>
	      	<?php $id !== $idprof ? $buzon='recibidos' : $buzon='enviados'; ?>
	      	<a href="index.php?inbox=<?php echo $buzon; ?>&delete=<?php echo $idprof; ?>" class="btn btn-danger" data-bb="confirm-delete">Eliminar</a>
	      </div>
	      
	    </div><!-- /.col-sm-12 -->
	    
	  </div><!-- /.row -->
	  
	  <br>
	  
	  <div class="row hidden-print">
	  
	  	<div class="col-sm-12">
	  	
			  <div class="well">
			    <fieldset>
			      <legend>Destinatarios</legend>
			    
			    <?php
			    $result = mysqli_query($db_con, "SELECT recibidoprofe, profesor from mens_profes where id_texto = '$id'");
			    $destinatarios = '';
			    while($destinatario = mysqli_fetch_array($result)) {
			      $exp_nomprofesor = explode(', ',$destinatario[1]);
			      $nom_profesor = $exp_nomprofesor[1].' '.$exp_nomprofesor[0];
			      if ($destinatario[0] == '1') {
			      	$destinatarios .= '<span class="text-success">'.$nom_profesor.'</span> | ';
			      }
			      else {
			      	$destinatarios .= '<span class="text-danger">'.$nom_profesor.'</span> | ';
			      }
			    }
			    
			    echo trim($destinatarios, ' | ');
			    ?>
			    </fieldset>
			    
			  </div><!-- /.well -->
	  	
	  	</div><!-- /.col-sm-12 -->
	  
	  </div><!-- /.row -->
	  
	</div><!-- /.container -->

<?php include('../../pie.php'); ?>

</body>
</html>