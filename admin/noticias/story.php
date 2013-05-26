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

?>
<?
include("../../menu.php");
include("menu.php");
?>
<div class="page-header" align="center">
  <h1>Noticias del Centro <small> Noticias en la base de datos</small></h1>
</div>

<div class="container-fluid">
<div class="row-fluid">
<div class="span10 offset1">
<? 
$id = $_GET['id'];
$connection = mysql_connect($db_host, $db_user, $db_pass) or die ("Imposible conectar!");
mysql_select_db($db) or die ("Imposible seleccionar base de datos!");

$query = "SELECT slug, content, contact, timestamp from noticias where id = '$id'";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
$row = mysql_fetch_object($result);

if ($row)
{?>
<p class="lead" align="center">
<?          
            echo $row->slug;
?>
</p>
<h6 align="right">
<?
			$fechan = explode(" ",$row->timestamp);
			fecha_actual($row->timestamp);
?>
</h6>
<br />
<div class="well-2">
<blockquote>
<?             	
			echo $row->content;
?>
 </blockquote>
 </div>
 <p>
            Publicada: <? echo fecha_actual($row->timestamp); ?><br />
            Autor: <? echo $row->contact; ?><br /></p>  
            <div align="center"><a href="../../index0.php" class="btn btn-success">Volver a la página principal</a></div>
<br /> 
  <?
}
else
{
?>
<div class="alert alert-error alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>ATENCIÓN:</h4>Esa noticia no se encuentra en la base de datos
          </div>
<?
}
mysql_close($connection);
?>
</div>
</div>
</div>
<? include("../../pie.php");?>
</body>
</html>
