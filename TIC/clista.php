<?
session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?
include("../menu.php");
include("menu.php");
$datatables_activado = true;
?>
<div align=center>
<div class="page-header" align="center">
  <h2>Centro TIC <small> Listado de incidencias</small></h2>
</div>
<br />
</div>
<div class="container-fluid">
  <div class="row-fluid">
  <div class="span10 offset1">
<?
if (isset($borrar) and $borrar=='1') {
		$result1 = mysql_query("DELETE FROM partestic WHERE parte = $parte");
		if($result1 == "1")
		{
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos de la incidencia se han borrado correctamente.
		</div></div><br />';
		}
}
?>
<?
if(stristr($_SESSION['cargo'],'1') == TRUE){$user="";}else{$user=" where profesor = '".$_SESSION['profi']."' ";}
  $SQL = "SELECT parte, nivel, grupo, carro, nserie, fecha, hora, alumno, profesor, descripcion, estado FROM  partestic $user ORDER BY parte DESC";
  $result = mysql_query($SQL);
  if(mysql_num_rows($result)<"1"){
	  echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Parece que no has registrado ninguna incidencia que puedas editar. Sólo pueden ser editadas las incidencias registradas personalmente.
</div></div>';
  }
  if ($row = mysql_fetch_array($result))
        {
echo "<br /><table class='table table-bordered table-striped tabladatos' style='width:auto'>";
echo "<thead><th>Profesor</th><th>Fecha</th><th>Número</th><th>Descripción</th><th>Estado</th><th>Carro</th><th></th></thead><tbody>";
		do {
$obs = substr($row[9],0,115)."...";
	echo "<tr>";
echo "<td>$row[8]</td><td nowrap>$row[5]</td>
<td>$row[4]</td><td>$obs</td><td>";
		if($row[10] == 'activo'){echo "<i class='icon icon-warning-sign'> </i>";}else{echo "<i class='icon icon-ok'> </i>";}
		echo "</td>
<td>$row[3]</td>
";
echo "<TD>
	<a href='edparte.php?parte=$row[0]'><i class='icon icon-pencil'> </i> </a>";
echo "<a href='clista.php?borrar=1&parte=$row[0]'><i class='icon icon-trash'> </i> </a>";	
echo "</td></tr>";
        } while($row = mysql_fetch_array($result));
		  echo "</tbody></table>";
		}
?>
</div>
</div>
</div>
<? include("../pie.php");?>
</body>
</html>
