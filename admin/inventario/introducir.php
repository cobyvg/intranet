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
<script>
function confirmacion() {
	var answer = confirm("ATENCIÓN:\n ¿Estás seguro de que quieres borrar los datos? Esta acción es irreversible. Para borrarlo, pulsa Aceptar; de lo contrario, pulsa Cancelar.")
	if (answer){
return true;
	}
	else{
return false;
	}
}
</script>
<?php
include("../../menu.php");
include("menu.php");
?>
<div class="page-header" align="center">
  <h2>Material del Centro <small> Inventario</small></h2>
</div>
<br />
<?
if (empty($departamento) and stristr($_SESSION['cargo'],'4') == TRUE){
	$departamento=$_SESSION['dpt'];
	$departament=$departamento;
}
else{
	$departament="Dirección";
}
?>
<?
if ($_GET['eliminar']=="1") {
	mysql_query("delete from inventario where id='".$_GET['id']."'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido borrado en la Base de datos.
</div></div><br />';
}
$profe=$_SESSION['profi'];
if($enviar == "Enviar datos")
{
if (!(empty($familia) or empty($clase) or empty($lugar))) 
{
	$tipo=mysql_query("select id from inventario_clases where familia = '$familia' and clase = '$clase'");
	$tip=mysql_fetch_array($tipo);
	mysql_query("INSERT INTO  `inventario` (  `id` ,  `clase` ,  `lugar` ,  `descripcion` ,  `marca` ,  `modelo` ,  `serie` ,  `unidades` ,  `fecha` ,  `ahora` ,  `departamento` ,  `profesor` ) 
VALUES (
NULL ,  '$tip[0]',  '$lugar',  '$descripcion',  '$marca',  '$modelo',  '$serie',  '$unidades',  '$fecha',  now(), '$departamento',   '$profe'
)");
	$num = mysql_affected_rows();
if ($num==1) {
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han registrado correctamente.
</div></div><br />';
}
}
else {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Parece que no has escrito nada en alguno de los campos obligatorios del formulario. Inténtalo de nuevo.
</div></div><br />';
}
}
?>
<div class="row-fluid">
<div class="span2"></div>
<div class="span4">

<h3>Registro de Material <span style="color:#9d261d">(<? echo $departament;?>)</span></h3>
<br />
<div class="well well-large" align="left">
<form name="textos" method="post" action="introducir.php">
<div align="center"><p class="help-block"> <span style="color:#9d261d">(*)</span> --> Campos obligatorios</p></div>
<input type="hidden" name="departamento" value="<? echo $departamento;?>">

<label>Familia<span style="color:#9d261d;font-size:12px;"> (*) </span><br />
<select name="familia" onchange="submit()" class="span10">
        <?
echo "<option>$familia</option>";
$famil = mysql_query(" SELECT distinct familia FROM inventario_clases order by familia asc");
while($fam = mysql_fetch_array($famil))
	{
	echo "<OPTION>$fam[0]</OPTION>";
	} 
	?>
</select>
</label>
<label>Clase<span style="color:#9d261d;font-size:12px;"> (*) </span><br />
<select name="clase" class="span7">
        <?
echo "<option></option>";
$cla = mysql_query(" SELECT distinct clase FROM inventario_clases where familia='$familia' order by familia asc");
while($clas = mysql_fetch_array($cla))
	{
	echo "<OPTION>$clas[0]</OPTION>";
	} 
	?>
</select>
</label>
<label>Lugar<span style="color:#9d261d;font-size:12px;"> (*) </span><br />
<select name="lugar" class="span9">
        <?
echo "<option></option>";
$luga = mysql_query(" SELECT distinct lugar FROM inventario_lugares order by lugar asc");
while($lug = mysql_fetch_array($luga))
	{
	echo "<OPTION>$lug[0]</OPTION>";
	} 
	?>
</select>
</label>
<label>Descipción<br />
<textarea name="descripcion" cols="45" rows="5" class="span11"></textarea>
</label>
<label>Marca<br />
<input type="text" name="marca" size="40" class="span8"/>
</label>
<label>Modelo<br />
<input type="text" name="modelo" size="40"class="span8" />
</label>
<label>Nº Serie<br />
<input type="text" name="serie" size="25" class="span8"/>
</label>
<label>Nº de Unidades<span style="color:#9d261d;font-size:12px;"> (*) </span><br />
<input type="text" name="unidades" size="5" value="1" class="span2"/>
</label>
<label>Fecha de Alta<span style="color:#9d261d;font-size:12px;"> (*) </span><br />
<div class="input-append" style="display:inline;" >
            <input name="fecha" type="text" class="input input-small" value="" data-date-format="dd-mm-yyyy" id="fecha" >
  <span class="add-on"><i class="icon-calendar"></i></span>
</div> 
</label>
<br />
<input type="submit" name="enviar"  value="Enviar datos" class="btn btn-primary"/>
</form>
</div>
</div>
<div class="span4">
<?
$it = mysql_query("select inventario_clases.clase, marca, modelo, unidades, inventario.id from inventario, inventario_clases where inventario_clases.id=inventario.clase and departamento='$departamento'");
if (mysql_num_rows($it)>0) {
	echo '<h3>Inventario: ';
	if($departamento){echo "<span style=color:#9d261d>".$departamento."</span>";}
	else{echo "<span style=color:#9d261d>Dirección del Centro</span>";}
	echo '</h3><br />
<table class="table table-striped">
<tr><th>Tipo</th><th>Marca / Modelo</th><th>Núm.</th><th></th><th></th></tr>';
while($item = mysql_fetch_row($it))
{
	if (empty($item[1])) {
		$marca = $item[2];
	}
	else{
		$marca = $item[1];
	}
?>
<tr><td><? echo $item[0];?></td><td><? echo $marca;?></td><td><? echo $item[3];?></td><td><a href="introducir.php?id=<? echo $item[4];?>&eliminar=1"><i class="icon icon-trash" title="Borrar registro" onClick='return confirmacion();'> </i> </a></td><td><a href="editar.php?id=<? echo $item[4];?>&departamento=<? echo $departamento;?>"><i class="icon icon-pencil" title="Editar registro"> </i> </a></td></tr>
<?
}
	echo '
</table>	';
}
?>
</div>
</div>
<? include("../../pie.php");?>	
<script>  
	$(function ()  
	{ 
		$('#fecha').datepicker()
		.on('changeDate', function(ev){
			$('#fecha').datepicker('hide');
		});
		});  
	</script>	
</body>
</html>
