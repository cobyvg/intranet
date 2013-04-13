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
?>
<div class="page-header" align="center">
  <h1>Noticias del Centro <small> Buscar en las Noticias</small></h1>
</div>
<br />
<h3 align="center" class="muted">Noticias que contienen la expresión &quot;<a href="#"><? echo strtoupper($expresion);?></a>&quot;</h3><br /><br /><?
$trozos = explode(" ",$expresion,5);
for($i=0;$i<5;$i++)
{
if(!(empty($trozos[$i]))){
$frase.=" and (slug like '%$trozos[$i]%' or content like '%$trozos[$i]%')";
}
}
$query = "SELECT distinctrow id, slug, content, timestamp, contact from noticias where 1=1 ".$frase." order BY id DESC limit 50";
$result = mysql_query($query);

if (mysql_num_rows($result) > 0)
{
?>
	<div align="center">
    <TABLE class="table table-striped" style="width:900px;">
<?	while($row = mysql_fetch_object($result))
	{
	?>      <tr> 
		<td nowrap><? echo fecha_sin($row->timestamp); ?></td>        
        <td>       
        <a href="story.php?id=<? echo $row->id;?>">
        <?
	echo strip_tags($row->slug,'<br>'); 
	?>	

	</a></td>
		<td nowrap>
<?        	
if(($row->contact == $profesor) or (strstr($_SESSION['cargo'],"1") == TRUE))	
{
?>
        <a href="add.php?id=<? echo $row->id; ?>"><i class="icon icon-pencil" rel="Tooltip" title="Editar la noticia"> </i> </a> | <a href="delete.php?id=<? echo $row->id; ?>&fech_princ=<? echo $row->timestamp; ?>"><i class="icon icon-trash" rel="Tooltip" title="Borrar la noticia"> </i></a>
<? } else{echo $row->contact;}?>
        </td>
      </tr>
      <tr><td colspan="3">
      <?
          $buffer0 = strip_tags($row->content);
								if(strlen($row->content) <= 150)	  
								{
								$cambiado = "<span class='label label-important'>$expresion</span>";
								$buffer = str_replace($expresion,$cambiado,$buffer0);
								echo strip_tags($buffer);}
								else
								{ 
								$cambiado = "<span class='label label-important'>$expresion</span>";
								$buffer = str_replace($expresion,$cambiado,$buffer0);
								echo strip_tags(substr($buffer,0,200));
								echo "...";
								}
								?>
      </td></tr>
	
	<?
	}
		echo "</TABLE></div><hr>";

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
<h3 align="center">Mensajes Enviados que contienen la expresión &quot;<a href="#"><? echo strtoupper($expresion);?></a>&quot;</h3><br /><?
$trozos = explode(" ",$expresion,5);
for($i=0;$i<5;$i++)
{
if(!(empty($trozos[$i]))){
$frase0.=" and (asunto like '%$trozos[$i]%' or texto like '%$trozos[$i]%')";
}
}
$query = "SELECT distinctrow id, asunto, texto, ahora, origen FROM mens_texto where 1=1 ".$frase0." and origen = '$profesor'order BY id DESC";
$result = mysql_query($query);

if (mysql_num_rows($result) > 0)
{
?>
	<div align="center">
    <TABLE class="table table-striped" style="width:900px;">
<?	while($row = mysql_fetch_object($result))
	{
	?>      <tr > 
		<td ><? echo fecha_sin($row->ahora); ?></td>        
        <td >       
        <a href="../mensajes/mensaje.php?id=<? echo $row->id;?>">
        <?
	echo strip_tags($row->asunto,'<br>'); 
	?>	

	</a></td>
		<td nowrap><? echo $row->origen;?></td>
      </tr>
      <tr><td colspan="3" >
      <?
          $buffer0 = strip_tags($row->texto,'<br>');
								if(strlen($row->texto) <= 150)	  
								{
								$cambiado = "<span class='label label-important'>$expresion</span>";
								$buffer = str_replace($expresion,$cambiado,$buffer0);
								echo $buffer;}
								else
								{ 
								$cambiado = "<span class='label label-important'>$expresion</span>";
								$buffer = str_replace($expresion,$cambiado,$buffer0);
								echo substr($buffer,0,200);
								echo "...";
								}
								?>
      </td></tr>
	
	<?
	}
		echo "</TABLE></div><hr>";

}
else
{
?>
<div align="center"><div class="alert alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Lo sentimos, pero ningún mensaje enviado responde a ese criterio de búsqueda.          
</div>
</div>
<?
}
?>

<h3 align="center">Mensajes Recibidos que contienen la expresión &quot;<a href="#"><? echo strtoupper($expresion);?></a>&quot;</h3><br />

<?
$trozos = explode(" ",$expresion,5);
for($i=0;$i<5;$i++)
{
if(!(empty($trozos[$i]))){
$frase0.=" and (asunto like '%$trozos[$i]%' or texto like '%$trozos[$i]%')";
}
}

$query = "SELECT id, asunto, texto, ahora, origen FROM mens_texto, mens_profes where mens_texto.id = mens_profes.id_texto ".$frase0." and profesor = '$profesor' order BY id DESC";
$result = mysql_query($query);

if (mysql_num_rows($result) > 0)
{
?>
	<div align="center">
    <TABLE class="table table-striped" style="width:900px;">
<?	while($row = mysql_fetch_object($result))
	{

	?>      <tr> 
		<td><? echo fecha_sin($row->ahora); ?></td>        
        <td>       
        <a href="../mensajes/mensaje.php?id=<? echo $row->id;?>">
        <?
	echo strip_tags($row->asunto,'<br>'); 
	?>	

	</a></td>
		<td nowrap><? echo $row->origen;?></td>
      </tr>
      <tr><td colspan="3">
      <?
          $buffer0 = strip_tags($row->texto,'<br>');
								if(strlen($row->texto) <= 150)	  
								{
								$cambiado = "<span class='label label-important'>$expresion</span>";
								$buffer = str_replace($expresion,$cambiado,$buffer0);
								echo $buffer;}
								else
								{ 
								$cambiado = "<span class='label label-important'>$expresion</span>";
								$buffer = str_replace($expresion,$cambiado,$buffer0);
								echo substr($buffer,0,200);
								echo "...";
								}
								?>
      </td></tr>
	
	<?
	}
		echo "</TABLE></div><hr>";

}
else
{
?>
<br /><div align="center"><div class="alert alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Lo sentimos, pero ningún mensaje recibido responde a ese criterio de búsqueda.          
</div>
</div><?
}
include("../../pie.php");
?>

</body>
</html>
