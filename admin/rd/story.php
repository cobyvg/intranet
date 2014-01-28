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
if (stristr ( $_SESSION ['cargo'], '4' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE) { } else { $j_s = 'disabled'; }
?>
<?
include("../../menu.php");
include("menu.php");
?>

<? 
   	$query = "SELECT contenido, fecha, numero, departamento FROM r_departamento WHERE id = '$id'";
   	$result = mysql_query($query) or die ("Error en la Consulta: $query. " . mysql_error());
   	if (mysql_num_rows($result) > 0)
   	{
   		$row = mysql_fetch_object($result);
   	}
 
if ($row)
{?>
 <div align="center">
<div class="page-header" align="center">
  <h2>Actas del Departamento <small> Registro de Reuniones ( <?  echo $row->departamento;?> )</small></h2>
</div>

<div class="container-fluid">
<div class="row-fluid">
<div class="span1"></div>
<div class="span10">
<?
		?>
<h3>
<?

		fecha_actual($row->fecha);
if (!($j_s=='disabled')) {
?>
<a href="pdf.php?id=<? echo $id; ?>&imprimir=1"  style="margin-right:20px;" class="btn btn-primary pull-right"> <i class="icon icon-print icon-white" rel="Tooltip" title='Crear PDF del Acta para imprimir o guardar'> </i> Imprimir Acta</a>
<?
}
?>
</h3>

<br />
<div class="well-transparent">
<?  
			echo $row->contenido;
?>
 </div>
<br /> 
  <?
}
else
{
?>
 <div align="center">
<div class="page-header" align="center">
  <h2>Actas del Departamento <small> Contenido de la Reunión ( <?  echo $row->departamento;?> )</small></h2>
</div>

<div class="container-fluid">
<div class="row-fluid">
<div class="span4 offset4">
<div class="alert alert-error alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>ATENCIÓN:</h4>Esa noticia no se encuentra en la base de datos
          </div>
<?
}
?>
</div>
</div>
</div>
<? include("../../pie.php");?>
</body>
</html>
