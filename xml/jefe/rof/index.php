<?
session_start();
include("../../../config.php");
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

$msg = $_GET['msg'];

// ELIMINAR ITEM
if(isset($_GET['eliminar'])) {
	if ($id = intval($_GET['eliminar'])) {
		mysqli_query($db_con, "DELETE FROM listafechorias WHERE id=$id");
		$msg = "La regla ha sido eliminada";
	}
}

include("../../../menu.php");
?>

<div class="container">

	<div class="page-header">
	  <h2>ROF <small>Administración de Reglas de Organización y Funcionamiento</small></h2>
	</div>
	
	
	<div class="row">
	
		<div class="col-sm-12">
		  
		  <?php 
		  if($msg) {
		   echo "<div class=\"alert alert-success\">\n";
		   if($msg=="update") $msg = "La regla ha sido modificada";
		   if($msg=="insert") $msg = "La regla ha sido añadida";
		   echo "  $msg.";
		   echo "</div>\n";
		  }
		  ?>
		  
		  <table class="table table-hover table-bordered">
		    <thead>
		      <tr>
		        <th>Asunto</th>
		        <th>Medida</th>
		        <th>Medida complementaria</th>
		        <th></th>
		      </tr>
		    </thead>
		    <tbody>
		    <?php
		    $result = mysqli_query($db_con, "SELECT DISTINCT tipo FROM listafechorias");
		    
		    while ($tipos = mysqli_fetch_array($result)) {
		    	$tipo = $tipos[0];
		    	
		    	echo "<tr class=\"info\">\n";
		    	echo "  <td colspan=\"4\"><strong>$tipo</strong></td>\n";
		    	echo "</tr>\n";
		    	
		    	$result2 = mysqli_query($db_con, "SELECT id, fechoria, medidas, medidas2 FROM listafechorias WHERE tipo='$tipo' ORDER BY id");
		    	
		    	while ($fechoria = mysqli_fetch_array($result2)) {
		    		$id = $fechoria[0];
		    		
		    		echo "<tr>\n";
		    		echo "  <td>$fechoria[1]</td>\n";
		    		echo "  <td>$fechoria[2]</td>\n";
		    		echo "  <td>$fechoria[3]</td>\n";
		    		echo "  <td nowrap>\n";
		    		echo "    <a href=\"regla.php?id=$id\" rel=\"tooltip\" title=\"Editar\"><span class=\"fa fa-pencil-square-o fa-fw fa-lg\"></span></a>\n";
		    		echo "    <a href=\"index.php?eliminar=$id\" data-bb=\"confirm-delete\" rel=\"tooltip\" title=\"Eliminar\"><span class=\"fa fa-trash-o fa-fw fa-lg\"></span></a>\n";
		    		echo "  </td>\n";
		    		echo "</tr>\n";
		    	}
		    }
		    
		    ?>
		    </tbody>
		  </table>
		  
		  <a class="btn btn-primary" href="regla.php">Nueva regla</a>
		  <a class="btn btn-default" href="../../index.php">Volver</a>
		  
		</div><!-- /.col-sm-12 -->
		
	</div><!-- /.row -->

</div><!-- /.container -->

<?php include("../../../pie.php"); ?>
</body>
</html>
