<?
session_start ();
include ("../../config.php");
if ($_SESSION ['autentificado'] != '1') {
	session_destroy ();
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
if (!(strstr($_SESSION['cargo'],"1") == TRUE)) {
	session_destroy ();
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}
$profesor = $_SESSION ['profi'];
?>
<?
include ("../../menu.php");
include ("menu.php");
/*
if (empty($departamento) and stristr($_SESSION['cargo'],'4') == TRUE){
	$departamento=$_SESSION['dpt'];
	$departament=$departamento;
}
else{
	$departament="Dirección del Centro";
}*/
echo '<div align="center">';
  echo '<div class="page-header">
  <h2>Actas del Departamento <small> Todos los Registros</small></h2>
</div>
<br />';
?>
<table class="table table-bordered" style="width:auto">

<?
$datatables_activado = true; 
$n_col=0;
$n_fila=0;
$dep0 = mysql_query("select distinct departamento from departamentos where departamento not like '' order by departamento");
while ($dep = mysql_fetch_array($dep0)) {
	
$departamento = $dep[0];
if (!($pag)) {
	$pag = "";
}
if($pag == "") {$pag = "0";} else {$pag = $pag + 100;}
$query = "SELECT id, fecha, departamento, contenido, impreso, numero FROM r_departamento where departamento = '$departamento' ORDER BY fecha desc limit $pag,50";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
$n_actas = mysql_num_rows($result);

if($n_col%4==0) {
	echo "<tr>";
	$n_filas++;
}

$n_col++;
?>
<td valign="top">
<p class="lead text-info" align="center"><? echo $departamento;?></p>
	<TABLE class="table table-striped table-bordered" style="width:auto;">
<?	while($row = mysql_fetch_object($result))
	{
	?>
      <TR> 
        <TD nowrap><? echo $row->numero; ?></td> 
		<TD nowrap><? echo fecha_sin($row->fecha); ?></td>        
        <TD nowrap>
        <?
	if(($row->departamento == $_SESSION['dpt']) or (strstr($_SESSION['cargo'],"1") == TRUE)){	
		?>
<a href="story.php?id=<? echo $row->id; ?>"  style="color:#08c;margin-right:10px;"><i class="fa fa-search" rel="Tooltip" title='Ver el Acta'> </i></a> 
<a href="pdf.php?id=<? echo $row->id; ?>&imprimir=1"  style="color:#990000;margin-right:10px;"> <i class="fa fa-print" rel="Tooltip" title='Crear PDF del Acta para imprimir o guardar'> </i></a>
<? 
if ($row->impreso == '0') {
?>
<i class="fa fa-exclamation-triangle" rel="Tooltip" title='El Acta aún no ha sido imprimida.'> </i>
<?
}
else{
?>
<i class="fa fa-check" rel="Tooltip" title='El Acta ya ha sido imprimida.'> </i>
<?
}
?>
</td>
<?
		}
		?>
      </tr>
	<?
	}
	echo "</TABLE>";
}
?>
</td>
<?
if($n_actas < ($n_col * $n_filas)) echo '<td></td>';
if($n_col%4==0) echo "</tr>";

echo "</table>";
?>
<br />
<!--<form action="pdf.php" method="POST">
<input type="submit" name="imp_todas" value="Imprimir actas no impresas" class="btn btn-primary">
</form>
--></div>
<?
include("../../pie.php");
?>
</body>
</html>
