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

$profesor = $_SESSION['profi'];

include("../../menu.php");
include("menu.php");

$datatables_activado = true;  

isset($_GET['inbox']) ? $_buzon = $_GET['inbox'] : $_buzon = 'recibidos';
isset($_GET['delete']) ? $idmensaje = intval($_GET['delete']) : $idmensaje=0;

switch ($_buzon) {
	default:
	case 'recibidos' :
		$page_header = "Mensajes recibidos";
		$active1 = "class=\"active\"";

		if ($idmensaje > 0) {
			$delete = mysql_query("DELETE FROM mens_profes WHERE id_profe='$idmensaje' LIMIT 1") or die (mysql_error());
			if($delete) $msg_delete = 1;
		}
		
		$tabla_encabezado = array('De', 'Asunto', 'Fecha', ' ');
		$result = mysql_query("SELECT ahora, asunto, id, origen, id_profe, texto, recibidoprofe FROM mens_profes JOIN mens_texto ON mens_texto.id = mens_profes.id_texto WHERE profesor = '$profesor' ORDER BY ahora DESC LIMIT 0, 200");
		break;
	
	case 'enviados'  :
		$page_header = "Mensajes enviados";
		$active2 = "class=\"active\"";
		
		if ($idmensaje > 0) {
			$delete = mysql_query("UPDATE mens_texto SET oculto='1' WHERE id='$idmensaje' LIMIT 1") or die (mysql_error());
			if($delete) $msg_delete = 1;
		}
		
		$tabla_encabezado = array('Para', 'Asunto', 'Fecha', ' ');
		$result = mysql_query("SELECT ahora, asunto, id, destino, id, texto FROM mens_texto WHERE origen = '$profesor' AND oculto NOT LIKE '1' ORDER BY ahora DESC LIMIT 0, 200");
		break;
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

<div class="container">
  
  <div class="page-header" align="center">
    <h2>Mensajes <small><?php echo $page_header; ?></small></h2>
  </div>
  
  <div class="row-fluid">
    
    <!-- MENSAJES -->
    <div class="span12">
    
      <!-- Mensaje eliminado -->
      <?php if(isset($msg_delete) && $msg_delete==1): ?>
      <div class="alert alert-success alert-block alert-fadeout" style="width:400px;margin:auto">
        El mensaje ha sido eliminado.
      </div>
      <br />
      <?php endif; ?>
      
      <!-- Mensaje enviado -->
      <?php if($_GET['action']=='send'): ?>
      <div class="alert alert-success alert-block alert-fadeout" style="width:400px;margin:auto">
        El mensaje ha sido enviado correctamente.
      </div>
      <br />
      <?php endif; ?>
      
      <style class="text/css">
        a.link-msg, a.link-msg:hover { color: #444; display: block; text-decoration:none; }
        #DataTables_Table_0_wrapper div.row-fluid:nth-child(1) { display: none; }
      </style>
      
      <ul class="nav nav-tabs">
        <li><a href="redactar.php" class="btn-danger"><span class="fa fa-pencil-square-o"></span> Redactar mensaje</a></li>
        <li><a href="correo.php" class="btn-info"><span class="fa fa-envelope-o"></span> Redactar correo</a></li>
        <li <?php echo $active1; ?>><a href="?inbox=recibidos"><span class="fa fa-inbox"></span> Recibidos</a></li>
        <li <?php echo $active2; ?>><a href="?inbox=enviados"><span class="fa fa-reply"></span> Enviados</a></li>
      </ul>
      
      <table class="table table-striped table-hover table-condensed table-datatable">
        <thead>
          <tr>
            <?php $i=0; while ($tabla_encabezado[$i] != FALSE): ?>
            	<th><?php echo $tabla_encabezado[$i]; $i++ ?></th>
            <?php endwhile; ?>
          </tr>
        </thead>
        <tbody>
        <?php 
        while($row = mysql_fetch_array($result)):
        $texto = htmlentities($row[5]);
        
        if(strpos($texto,'a href')) $pos = true;
        elseif(strpos($texto,'img src')) $pos = true;
        elseif(strpos($texto,'iframe src')) $pos = true;
        else $pos=false;
        
        $_buzon=='recibidos' ? $leido = $row[6] : $leido=1;
        ?>
          <tr> 
            <td width="25%"><?php if(!$leido) echo '<strong>'; ?><a class="link-msg" href="mensaje.php?id=<?php echo $row[2]; ?>&idprof=<?php echo $row[4]; ?>"><? echo $row[3]; ?><?php if(!$leido) echo '</strong>'; ?></a></td>        
            <td width="55%"><?php if(!$leido) echo '<strong>'; ?><a class="link-msg" href="mensaje.php?id=<?php echo $row[2]; ?>&idprof=<?php echo $row[4]; ?>"><? echo $row[1]; if($pos !== false) echo ' <span class="pull-right fa fa-paperclip fa-lg"></span>'; ?></a><?php if(!$leido) echo '</strong>'; ?></td>
            <td width="15%" nowrap><?php if(!$leido) echo '<strong>'; ?><a class="link-msg" href="mensaje.php?id=<?php echo $row[2]; ?>&idprof=<?php echo $row[4]; ?>"><?php echo fecha_actual2($row[0]); ?></a><?php if(!$leido) echo '</strong>'; ?></td>
            <td width="5%"><a class="link-msg" href="?inbox=<?php echo $_buzon; ?>&delete=<? echo $row[4] ;?>" onclick="return confirm('Esta acción eliminará permanentemente el mensaje seleccionado ¿Está seguro que desea continuar?');"><span class="fa fa-trash-o fa-lg"></span></a></td>
          </tr>
      	<?php endwhile; ?>
      	</tbody>
      </table>
    </div>
    
  </div>
  
  <br>
  <br>

</div>

<?php include("../../pie.php"); ?>

<script>
$(document).ready(function() {
	$('.alert-fadeout').delay(5000).fadeOut('slow');
	
    $('.table-datatable').dataTable( {
        "sPaginationType": "bootstrap",
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": false,
        "bInfo": false,
        "bAutoWidth": false 
    });
});
</script>
   
</body>
</html>