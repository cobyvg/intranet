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


?>

<?php
include("../../menu.php");
include("menu.php");
   $imprimir_activado = true;  
if (empty($departamento) and stristr($_SESSION['cargo'],'4') == TRUE){
	$departamento=$_SESSION['dpt'];
	$departament=$departamento;
}
else{
	$departament="Dirección";
}
$profe=$_SESSION['profi'];
if (empty($buscar)) {
?>
<div class="page-header">
  <h2>Material del Centro <small> Buscar en el Inventario</small></h2>
</div>
<br />
<div class="well well-large" align="center" style="width:400px;margin:auto">
<br />
            <form method="post" action="buscar.php">
                  <input type="text" name="expresion" id="exp" value="<? echo $expresion;?>" class="input-xlarge" />
                  <br /><br /><button type="submit"  name="buscar" value="Buscar datos" class="btn btn-primary"><i class="fa fa-search "> </i> Buscar datos </button>
            </form>
</div>
<br />
<?
		echo '<div class="well" style="width:550px; margin:auto">INSTRUCCIONES.<BR><div style="text-align:left;width:inherit;">1. Puedes buscar en cualquier campo de la tabla de datos: familia, clase, lugar, descripción, marca, modelo, etc. <br>Si introduces varias palabras, se buscarán los registros que contengan <em>todas</em> las palabras.<br>2. La(-s) palabra(-s) que introduzcas no tienen porque ser completas, así que puedes escribir un trozo de palabra para aumentar los resultados de la búsqueda.<br>3. Por esa razón, si no escribes ningún texto en el campo de búsqueda, se presentarán todos los registros que has introducido, lo cual es interesante, por ejemplo, para imprimir un listado completo del material del Departamento. Los miembros del Equipo directivo verán, en este caso, la totalidad de los materiales registrados por todos los Departamentos y la propia Dirección,<br>4. Los nombres de las columnas de la tabla de resultados contienen un enlace que ordena los resultados de modo ascendente o descendente. Haciendo click sobre el nombre de una columna, podemos ordenar los resultados por familia, clase, modelo, etc.</div></div>';
}
?>
</div>
<?
if ($ser) {$ser=" order by $ser";}else{$ser=" order by fecha";}
if ($orden=="desc") {$ord="asc";}else{$orden="asc";	$ord="desc";}
if ($buscar=="Buscar datos") {
$trozos = explode(" ",$expresion,5);
for($i=0;$i<5;$i++)
{
if(!(empty($trozos[$i]))){
$frase.=" and (familia like '%$trozos[$i]%' or inventario_clases.clase like '%$trozos[$i]%' or lugar like '%$trozos[$i]%' or descripcion like '%$trozos[$i]%' or marca like '%$trozos[$i]%' or modelo like '%$trozos[$i]%' or serie like '%$trozos[$i]%'  or departamento like '%$trozos[$i]%')";
}
}
if (strlen($departamento)>0) {
	$dep=" and departamento = '$departamento'";	
	}
$frase.=$dep;

$datos=mysql_query("select familia, inventario_clases.clase, lugar, descripcion, marca, modelo, serie, unidades, fecha, inventario.id, departamento from inventario, inventario_clases where inventario.clase=inventario_clases.id $frase $ser $orden");
//echo "select familia, inventario_clases.clase, lugar, descripcion, marca, modelo, serie, unidades, fecha, inventario.id from inventario, inventario_clases where inventario.clase=inventario_clases.id $frase $ser $orden";

if (mysql_num_rows($datos) > 0)
{
	echo '<div class="container-fluid">  
	<div class="row">
<div class="col-sm-1"></div>
<div class="col-sm-10">';
	echo '<div align="center">';
echo '<h3>Material encontrado en el Inventario</h3><br />
<table class="table table-striped table-bordered tabladatos" style="width:100%">
<thead>
<tr><th>Familia</th><th>Clase</th><th>Lugar</th><th>Descripción</th><th>Marca</th><th>Modelo</th><th nowrap>Nº Serie</th><th>Unidad</th><th>Departamento</th><th></th><th></th></tr>
</thead><tbody>';
while($dat = mysql_fetch_row($datos))
{
$familia=$dat[0];	
$clase=$dat[1];
$lugar=$dat[2];
$descripcion=$dat[3];
$marca=$dat[4];
$modelo=$dat[5];
$serie=$dat[6];
$unidades=$dat[7];
$fecha=$dat[8];
$id=$dat[9];
$departamento=$dat[10];
?>
<tr><td><? echo $familia;?></td><td><? echo $clase;?></td><td><? echo $lugar;?></td><td><? echo $descripcion;?></td><td><? echo $marca;?></td><td><? echo $modelo;?></td><td><? echo $serie;?></td><td><? echo $unidades;?></td><td><? echo $departamento;?></td><td><a href="introducir.php?id=<? echo $id;?>&eliminar=1" data-bb='confirm-delete'><i class="fa fa-trash-o" title="Borrar" > </i> </a></td><td><a href="editar.php?id=<? echo $id;?>&departamento=<? echo $departamento;?>"><i class="fa fa-pencil" title="Modificar"> </i> </a></td></tr>
<?
}
	echo '</table>';
echo '</div>';
}
else
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Ningún registro del Inventario responde a tu criterio.
</div></div><br />';
}
}
	include("../../pie.php");
?>
</body>
</html>