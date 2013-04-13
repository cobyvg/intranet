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
?>
<link rel="stylesheet" type="text/css" href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css">    
<?
include("menu.php");
$datatables_activado = true;  
?>
<div align="center">
<div class="page-header">
  <h1>Centro de Mensajes <small> Recibir mensajes...</small></h1>
</div>
<br />
<?
if ($borrar=='1') {
	mysql_query("delete from mens_profes where id_profe='$id_borrar'");
	// echo "delete from mens_profes where id_profe='$id_borrar'";
       echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4 class="alert-heading">Valió!</h4> 
            El mensaje ha sido eliminado correctamente.
          </div></div>';
}
$query0 = "SELECT ahora, asunto, id from mens_profes, mens_texto where mens_texto.id = mens_profes.id_texto and profesor = '$profesor' ORDER BY ahora DESC";
$result0 = mysql_query($query0);
$num_mens = mysql_num_rows($result0);
$query1 = "SELECT ahora, asunto, id from mens_texto where origen = '$profesor' ORDER BY ahora DESC";
$result1 = mysql_query($query1);
$num_mens1 = mysql_num_rows($result1);
?>
<?
$query = "SELECT ahora, asunto, id, origen, id_profe from mens_profes, mens_texto where mens_texto.id = mens_profes.id_texto and profesor = '$profesor' ORDER BY ahora DESC limit 500";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
if (mysql_num_rows($result) > 0)
{
	echo ' <div class="well well-large well-transparent lead" id="t_larga_barra" style="width:320px">
        <i class="icon-spinner icon-spin icon-2x pull-left"></i> Cargando los datos...
      </div>
   ';
    echo "</div>";
    echo "<div id='t_larga' style='display:none' >";
?>

<div class="container-fluid">  
	<div class="row-fluid">
<div class="span2"></div>
<div class="span8">
 <div align="center">
    <table class="table table-striped tabladatos" style="width:100%">
<thead>
<tr><th>Fecha</th><th>Título</th><th>Origen</th><th></th></tr>
</thead><tbody><?	while($row = mysql_fetch_object($result))
	{
	?>
      <TR> 
		<TD align="left" nowrap id="filasecundaria"><? echo fecha_actual($row->ahora); ?></td>        
        <TD style="padding-left:8px;"><a href="mensaje.php?id=<? echo $row->id;?>&profesor=<? echo $profesor;?>">
	<? echo $row->asunto; ?></a></td><td nowrap align="left" id="filaprincipal"><? echo $row->origen;?></td>
	<td nowrap align="left" id=""><a href="recibidos.php?borrar=1&id_borrar=<? echo $row->id_profe;?>"><i class="icon-trash"></i></a></td>
      </tr>
	<?
	}
}
?>
</td></tr></TABLE>
</div>
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
