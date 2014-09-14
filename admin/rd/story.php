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


if (stristr ( $_SESSION ['cargo'], '4' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE) { } else { $j_s = 'disabled'; }
?>
<?
include("../../menu.php");
echo '<div class="no_imprimir">';
include("menu.php");
echo '</div>';
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
<div class="page-header">
  <h2>Actas del Departamento <small> Registro de Reuniones ( <?  echo $row->departamento;?> )</small></h2>
</div>
</div>
<div class="container-fluid">
<div class="row">
<div class="col-sm-1"></div>
<div class="col-sm-10">
<?
		?>

<div class="well-transparent" style="width:925px;margin:auto;">
<legend class="no_imprimir">
<?
//fecha_actual($row->fecha);
?>
</legend>
<?
if (!($j_s=='disabled')) {
?>
<a href="pdf.php?id=<? echo $id; ?>&imprimir=1"  style="margin-right:20px;" class="btn btn-primary pull-right no_imprimir"> 
<i class="fa fa-print " rel="Tooltip" title='Crear PDF del Acta para imprimir o guardar'> </i> Imprimir PDF</a>
<?
}
?>


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
<div class="page-header">
  <h2>Actas del Departamento <small> Contenido de la Reunión ( <?  echo $row->departamento;?> )</small></h2>
</div>

<div class="container-fluid">
<div class="row">
<div class="col-sm-4 col-sm-offset-4">
<div class="alert alert-danger alert-block fade in">
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
