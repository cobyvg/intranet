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
?>
  <?php
include("../../menu.php");
include("menu.php");
?>
<div align="center">
<div class="page-header">
  <h2>Centro de Mensajes <small> Mensajes enviados</small></h2>
</div>
<br />
<?
if (isset($_POST['id_borrar'])) {$id_borrar = $_POST['id_borrar'];} elseif (isset($_GET['id_borrar'])) {$id_borrar = $_GET['id_borrar'];} else{$id_borrar="";}
if (isset($_POST['borrar'])) {$borrar = $_POST['borrar'];} elseif (isset($_GET['borrar'])) {$borrar = $_GET['borrar'];} else{$borrar="";}

$datatables_activado = true;  
$lista = mysql_list_fields($db,"mens_texto");
$col_oculto = mysql_field_name($lista,5);
if ($col_oculto=="oculto") { }else{
	mysql_query("ALTER TABLE  `mens_texto` ADD  `oculto` TINYINT( 1 ) NOT NULL DEFAULT  '0';");
}
if ($borrar=="1") {
	mysql_query("update mens_texto set oculto='1' where id = '$id_borrar'")	;
	echo '<div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4 class="alert-heading"> 
            El mensaje ha sido eliminado correctamente.
          </div>';
}
$query0 = "SELECT ahora, asunto, id from mens_profes, mens_texto where mens_texto.id = mens_profes.id_texto and profesor = '$profesor' and oculto not like '1' ORDER BY ahora DESC";
$result0 = mysql_query($query0);
$num_mens = mysql_num_rows($result0);
$query1 = "SELECT ahora, asunto, id from mens_texto where origen = '$profesor' and oculto not like '1' ORDER BY ahora DESC";
$result1 = mysql_query($query1);
$num_mens1 = mysql_num_rows($result1);
?>
<?
$query = "SELECT ahora, asunto, id, destino from mens_texto where origen = '$profesor' and oculto not like '1' ORDER BY ahora DESC limit 500";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
$numero = mysql_num_rows($result);
if ($numero > 0)
{
	echo ' <div class="well well-large well-transparent lead" id="t_larga_barra" style="width:320px;">
        <i class="icon-spinner icon-spin icon-2x pull-left"></i> Cargando los datos...
      </div>
   ';
    echo "</div>";
    echo "<div id='t_larga' style='display:none' >";
?>
<div class="container-fluid">  
	<div class="row-fluid">
<div class="span10 offset1">
 <div align="center">

    <table class="table table-striped tabladatos" style="width:100%">
<thead>
<tr><th>Fecha</th><th>Título</th><th>Destino</th><th></th></tr>
</thead><tbody>
<?	while($row = mysql_fetch_object($result))
	{
	?>
      
      <TR> 
		<TD nowrap><? echo fecha_actual2($row->ahora); ?></td>        
        <TD><a href="mensaje.php?id=<? echo $row->id;?>&profesor=<? echo $profesor;?>">
	<? echo $row->asunto; ?></a></td>
	<TD  width="260">
	<?
	$trozos = explode(";",$row->destino);
	$destino = count($trozos);
	$num_profes = $destino - 1;
	if($num_profes > 1){echo $trozos[0]." (+) ";}else{echo $trozos[0];}
	 ?>
     
     </td> 
     <TD><a href="enviados.php?borrar=1&id_borrar=<? echo $row->id;?>"><i class="icon-trash"></i></a></td>
      </tr>
	<?
	}
	echo "</tbody></TABLE></div>";
}
?>
<?
include("../../pie.php");
?>
<script>
function espera( ) {
        document.getElementById("t_larga").style.display = '';
        document.getElementById("t_larga_barra").style.display = 'none';        
}
window.onload = espera;
</script> 
</body>

</html>
