<?
session_start ();
include ("../../config.php");
if ($_SESSION ['autentificado'] != '1') {
	session_destroy ();
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
$profesor = $_SESSION ['profi'];
?>
<?
include ("../../menu.php");
include ("menu.php");

if (empty($departamento) and stristr($_SESSION['cargo'],'4') == TRUE){
	$departamento=$_SESSION['dpt'];
	$departament=$departamento;
}
else{
	$departament="Dirección del Centro";
}
?>
<div align="center">
<?
  echo '<div class="page-header">
  <h1>Jefatura del Departamento <small> Registro de Reuniones</small></h1>
  <h3 style="color:#08c;">'.$departament.'</h3>
</div>
<br />';
		?>

<?
if($pag == "") {$pag = "0";} else {$pag = $pag + 100;}
$query = "SELECT id, fecha, departamento, contenido, numero FROM r_departamento where departamento = '$departament' ORDER BY fecha DESC limit $pag,25";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
$n_actas = mysql_num_rows($result);
if (mysql_num_rows($result) > 0)
{
?>
	<TABLE class="table table-striped" style="width:300px;">
<?	while($row = mysql_fetch_object($result))
	{
	?>
      <TR> 
      <TD nowrap><? echo $row->numero; ?></td> 
		<TD nowrap><? echo fecha_sin($row->fecha); ?></td>        
        <TD>
        <?
	if(($row->departamento == $_SESSION['dpt']) or (strstr($_SESSION['cargo'],"1") == TRUE)){	
		?>
<a href="story.php?id=<? echo $row->id; ?>"  style="color:#08c;margin-right:10px;"><i class="icon icon-search" rel="Tooltip" title='Ver el Acta'> </i></a> 
<a href="pdf.php?id=<? echo $row->id; ?>"  style="color:#990000"> <i class="icon icon-print" rel="Tooltip" title='Crear PDF del Acta para imprimir o guardar'> </i></a>
</td>
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
            No hay Actas disponibles en la base de datos. Tu puedes ser el primero en inaugurar la lista.
          </div></div>
		  <?
}

// close connection
?>
</div>
<?
if ($n_actas > 24) {
	?>
	<div align="center"><a href="list.php?pag=<? echo $pag;?>" class="btn btn-primary">Siguientes 25 Actas</a></div>
	<?
}
?>

