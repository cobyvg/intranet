<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}

if($_SESSION['cambiar_clave']) {
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/clave.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/clave.php');
		exit();
	}
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
<p class="lead" align="center">Actas que contienen la expresión<a href="#"> &quot;<? echo $expresion;?></a>&quot;</p><br /><?
$trozos = explode(" ",$expresion,5);
$frase="";
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
$result = mysqli_query($db_con, $query);
if(mysqli_num_rows($result) > 0)
{
?>
	<div align="center">
    <TABLE class="table table-striped" style="width:auto;">
<?	while($row = mysqli_fetch_object($result))
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
<a href="story.php?id=<? echo $row->id; ?>"  style="color:#08c;margin-right:10px;"><i class="fa fa-search" data-bs="tooltip" title='Ver el Acta'> </i></a> 
<a href="pdf.php?id=<? echo $row->id; ?>"  style="color:#990000"> <i class="fa fa-print" data-bs="tooltip" title='Crear PDF del Acta para imprimir o guardar'> </i></a>  
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
<div align="center"><div class="alert alert-block fade in">
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
