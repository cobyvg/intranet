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

<div class="container-fluid">
  
  <div class="page-header">
    <h2>Mensaje: <?php echo $page_header; ?> <br><small>Enviado por <?php echo $mensaje['origen']; ?> el <?php echo fecha_actual2($mensaje['ahora']); ?></small></h2>
  </div>
  <div class="row-fluid no_imprimir">
    <div class="span12">
      <a href="index.php" class="btn btn-default"><span class="icon icon-remove"></span> Cerrar</a>
      <a href="redactar.php?profes=1&origen=<?php echo $mensaje['origen']; ?>&asunto=RE: <?php echo $mensaje['asunto']; ?>" class="btn btn-primary"><span class="icon icon-reply"></span> Responder</a>
      <a href="javascript:void(0);" class="btn btn-info" onclick="print()"><span class="icon icon-print"></span> Imprimir</a>
      <?php
      $id !== $idprof ? $buzon='recibidos' : $buzon='enviados';
      ?>
      <a href="index.php?inbox=<?php echo $buzon; ?>&delete=<?php echo $idprof; ?>" class="btn btn-danger"><span class="icon icon-trash"></span> Eliminar</a>
    </div>
  </div>
  
  <br>
  
  <div class="row-fluid">
  
    <div class="span8">
      <?php echo $mensaje['texto']; ?>
    </div>
    
    <div class="span4">
      <div class="well no_imprimir">
        <fieldset>
          <legend class="text-warning">Destinatario(s)</legend>
        
        <?php
        $result = mysql_query("SELECT recibidoprofe, profesor from mens_profes where id_texto = '$id'");
        while($destinatario = mysql_fetch_array($result)) {
	        $n_profesor = $destinatario[1];
	        if ($destinatario[0] == '1') {
	        	echo "<span class=\"text-success\">$n_profesor; </span>";
	        }
	        else {
	        	echo "<span class=\"text-error\">$n_profesor; </span>";
	        }
        }
        ?>
        </fieldset>
        
      </div>
    </div>
    
  </div>
  
</div>

<?php include('../../pie.php'); ?>
</body>
</html>