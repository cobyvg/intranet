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

$result = mysql_query("SELECT asunto, ahora, texto, origen FROM mens_texto where id = '$id'") or die (mysql_error());
$mensaje = mysql_fetch_array($result);

if(mysql_num_rows($result)<1) {
	header('Location:'.'index.php');
	exit();
}


mysql_query("UPDATE mens_profes SET recibidoprofe = '1' WHERE id_profe = '$idprof'");

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
	    
	    	<h3 class="text-info"><?php echo $mensaje['asunto']; ?></h3>
	    	<h5 class="text-muted">Enviado por <?php echo $mensaje['origen']; ?> el <?php echo fecha_actual2($mensaje['ahora']); ?></h5>
	    	
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
			    $result = mysql_query("SELECT recibidoprofe, profesor from mens_profes where id_texto = '$id'");
			    while($destinatario = mysql_fetch_array($result)) {
			      $n_profesor = $destinatario[1];
			      if ($destinatario[0] == '1') {
			      	echo "<span class=\"text-success\">$n_profesor; </span>";
			      }
			      else {
			      	echo "<span class=\"text-danger\">$n_profesor; </span>";
			      }
			    }
			    ?>
			    </fieldset>
			    
			  </div><!-- /.well -->
	  	
	  	</div><!-- /.col-sm-12 -->
	  
	  </div><!-- /.row -->
	  
	</div><!-- /.container -->

<?php include('../../pie.php'); ?>

</body>
</html>