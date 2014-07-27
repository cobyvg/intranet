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

$msg = $_GET['msg'];

// ELIMINAR ITEM
if(isset($_GET['eliminar'])) {
	if ($id = intval($_GET['eliminar'])) {
		mysql_query("DELETE FROM listafechorias WHERE id=$id");
		$msg = "La regla ha sido eliminada";
	}
}
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
include("../../../menu.php");
?>
<br />
<div class="page-header" align="center">
  <h2>Reglamento de Organización y Funcionamiento del Centro</h2>
</div>

<div class="row">
	<div class="col-sm-offset-1 col-sm-11">
	  
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
	    $result = mysql_query("SELECT DISTINCT tipo FROM listafechorias");
	    
	    while ($tipos = mysql_fetch_array($result)) {
	    	$tipo = $tipos[0];
	    	
	    	echo "<tr class=\"info\">\n";
	    	echo "  <td colspan=\"4\"><strong>$tipo</strong></td>\n";
	    	echo "</tr>\n";
	    	
	    	$result2 = mysql_query("SELECT id, fechoria, medidas, medidas2 FROM listafechorias WHERE tipo='$tipo' ORDER BY id");
	    	
	    	while ($fechoria = mysql_fetch_array($result2)) {
	    		$id = $fechoria[0];
	    		
	    		echo "<tr>\n";
	    		echo "  <td>$fechoria[1]</td>\n";
	    		echo "  <td>$fechoria[2]</td>\n";
	    		echo "  <td>$fechoria[3]</td>\n";
	    		echo "  <td nowrap>\n";
	    		echo "    <a href=\"regla.php?id=$id\"><i class=\"fa fa-pencil-square-o fa-lg\"></i></a>\n";
	    		echo "    <a href=\"index.php?eliminar=$id\"><i class=\"fa fa-trash-o fa-lg\" onClick='return confirmacion();'></i></a>\n";
	    		echo "  </td>\n";
	    		echo "</tr>\n";
	    	}
	    }
	    
	    
	    
	    ?>
	    </tbody>
	  </table>
	</div>
</div>

<br>
<div align="center">
  <a href="../../index.php" class="btn btn-default">Volver</a>
  <a href="regla.php" class="btn btn-primary">Añadir regla</a>
</div>
<br>
<br>
</body>
</html>
