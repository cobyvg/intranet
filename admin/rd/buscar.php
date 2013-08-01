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

if (empty($departamento) and stristr($_SESSION['cargo'],'4') == TRUE){
	$departamento=$_SESSION['dpt'];
	$departament=$departamento;
}
else{
	$departament="Dirección del Centro";
}
echo '<div align="center">';
  echo '<div class="page-header">
  <h2>Jefaturas de los Departamentos <small> Registro de Reuniones</small></h1>
  <h3 style="color:#08c;">'.$departament.'</h3>
</div>
<br />';
?>
<p class="lead" align="center">Actas que contienen la expresión<a href="#"><h6> &quot;<? echo strtoupper($expresion);?></a>&quot;</h6></p><br /><br /><?
$trozos = explode(" ",$expresion,5);
for($i=0;$i<5;$i++)
{
if(!(empty($trozos[$i]))){
$frase.=" and (contenido like '%$trozos[$i]%')";
}
}
if (stristr($_SESSION['cargo'],'4') == TRUE){
	$dep = " and departamento = '".$_SESSION['dpt']."' ";
}
else{
	$dep = "";
}
$query = "SELECT  id, fecha, departamento, contenido, jefedep, numero FROM r_departamento where 1=1".$frase." ". $dep ." order BY id DESC limit 50";
// echo $query;
$result = mysql_query($query);

if (mysql_num_rows($result) > 0)
{
?>
	<div align="center">
    <TABLE class="table table-striped" style="width:auto;">
<?	while($row = mysql_fetch_object($result))
	{
	?>      <tr> 
        <td>       
      <?
	echo $row->numero; 
	?>	
</td>
 <td>       
      <?
	echo $row->fecha; 
	?>	
</td>
 <td>       
      <?
	echo $row->departamento; 
	?>	
</td>
<td style="text-align:right;">
<a href="story.php?id=<? echo $row->id; ?>"  style="color:#08c;margin-right:10px;"><i class="icon icon-search" rel="Tooltip" title='Ver el Acta'> </i></a> 
<a href="pdf.php?id=<? echo $row->id; ?>"  style="color:#990000"> <i class="icon icon-print" rel="Tooltip" title='Crear PDF del Acta para imprimir o guardar'> </i></a>  
</div>
        </td>
      </tr>

	<?
	}
		echo "</TABLE></div>";

}
else
{
?>
<div align="center"><div class="alert alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Lo sentimos, pero ninguna noticia responde a ese criterio de búsqueda.          
</div>
</div>
<?
}
?>

</div><?

include("../../pie.php");
?>

</body>
</html>
