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
$n_col="";
$dep0 = mysql_query("select distinct departamento from departamentos");
while ($dep = mysql_fetch_array($dep0)) {
	
if (!(strstr($dep[0],"Informática") == TRUE) and !(strstr($dep[0],"Economía") == TRUE) and !(strstr($dep[0],"Religión") == TRUE) and !(stristr($dep[0],"Programas Cual") == TRUE) and !(strstr($dep[0],"Pcpi") == TRUE) and !(strstr($dep[0],"Pedagogía") == TRUE) and !(strstr($dep[0],"Apoyo") == TRUE) and !(strstr($dep[0],"Latín") == TRUE) and !(strstr($dep[0],"Interculturalidad") == TRUE)) {
$n_col+=1;
$departamento = $dep[0];
if (!($pag)) {
	$pag = "";
}
if($pag == "") {$pag = "0";} else {$pag = $pag + 100;}
$query = "SELECT id, fecha, departamento, contenido, impreso, numero FROM r_departamento where departamento = '$departamento' ORDER BY fecha ASC limit $pag,25";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
$n_actas = mysql_num_rows($result);

if ($n_col=="1" or $n_col=="5" or $n_col=="9" or $n_col=="13" or $n_col=="17") {
	echo "</tr>";
}
?>
<td valign="top">
<h5 align="center"><? echo $departamento;?></h5><br />
	<TABLE class="table table-striped table-bordered" style="width:300px;">
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
<a href="pdf.php?id=<? echo $row->id; ?>&imprimir=1"  style="color:#990000;margin-right:10px;"> <i class="icon icon-print" rel="Tooltip" title='Crear PDF del Acta para imprimir o guardar'> </i></a>
<? 
if ($row->impreso == '0') {
?>
<i class="icon-warning-sign" rel="Tooltip" title='El Acta aún no ha sido imprimida.'> </i>
<?
}
else{
?>
<i class="icon icon-ok" rel="Tooltip" title='El Acta ya ha sido imprimida.'> </i>
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
if ($n_col=="4" or $n_col=="8" or $n_col=="12" or $n_col=="16" or $n_col=="18") {
	echo "</tr>";
}
}
echo "</table>";
?>
<br />
<!--<form action="pdf.php" method="POST">
<input type="submit" name="imp_todas" value="Imprimir actas no impresas" class="btn btn-primary">
</form>
--></div>
</body>
</html>
