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
include("../../menu.php");
include("menu.php");
?>
<div align="center">
<div class="page-header" align="center">
  <h2>Noticias del Centro <small> Noticias en la base de datos</small></h2>
</div>
<br />

<?
$connection = mysql_connect($db_host, $db_user, $db_pass) or die ("No es posible conectar con la base de datos!");
mysql_select_db($db) or die ("No es posible conectar con la base de datos!");
if (isset($_GET['id'])) {
$id = $_GET['id'];	
}
if (isset($_GET['fech_princ'])) {
$fech_princ = $_GET['fech_princ'];	
}
if (isset($_GET['borrar'])) {
$borrar = $_GET['borrar'];
}
if(isset($borrar) and $borrar == "1")
{
$query = "DELETE from noticias WHERE id = '$id'";
$result = mysql_query($query) or die ('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
			El Artículo no ha podido ser borrado de la Base de Datos. Busca ayuda.
          </div></div>');
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			El Artículo ha sido borrado de la Base de Datos.
          </div></div>';
}
?>
<?
if(!(isset($pag))) {$pag = "0";} else {$pag = $pag + 100;}
$query = "SELECT id, slug, timestamp, contact from noticias ORDER BY timestamp DESC limit $pag,100";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
if (mysql_num_rows($result) > 0)
{
?>
	<TABLE class="table table-striped" style="width:900px;">
<?	while($row = mysql_fetch_object($result))
	{
	?>
      <TR> 
		<TD nowrap><? echo fecha_sin($row->timestamp); ?></td>        
        <TD><a href="story.php?id=<? echo $row->id;?>">
	<? echo $row->slug; ?></a></td>
        <?
	if(($row->contact == $profesor) or (strstr($_SESSION['cargo'],"1") == TRUE)){	
		?>
<TD nowrap><a href="add.php?id=<? echo $row->id; ?>"  style="color:#08c"><i class="icon icon-pencil" rel="Tooltip" title='Editar la noticia'> </i></a> <a href="list.php?id=<? echo $row->id; ?>&fech_princ=<? echo $row->timestamp;?>&borrar=1"  style="color:#990000"> <i class="icon icon-trash" rel="Tooltip" title='Borrar noticia de la lista' onClick='return confirmacion();'> </i></a></td>
<?
		}
		?>
      </tr>
	<?
	}
	echo "</TABLE>";
}
else
{
?>
<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h5>ATENCIÓN:</h5>
            No hay noticias disponibles en la base de datos. Tu puedes ser el primero en inaugurar la lista.
          </div></div>
		  <?
}

// close connection
mysql_close($connection);
?>
</div>
<div align="center"><a href="list.php?pag=<? echo $pag;?>" class="btn btn-primary">Siguientes 100 Noticias</a></div>
<? include("../../pie.php");?>
</body>

</html>
