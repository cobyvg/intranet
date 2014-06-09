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
  ?>
 <br />
  <div align=center>
  <div class="page-header" align="center">
  <h2>Información sobre Guardias <small><br /> Datos y Estadísticas</small></h2>
</div>
</div>
<div class="container">
<div class="row">
<div class="well well-larfe" style="width:750px;margin:auto">
<p class="block-help">
<legend class=" text-warning" align="center">Aclaraciones sobre los datos presentados sobre las Guardias.</legend>
<ul class=" text-info">
<li>Las Guardias de Pasillo presentan las guardias de pasillo totales registradas en el Horario en Séneca. Quedan excluidas las guardias de Biblioteca, las guardias en el Aula de Convivencia y las guardias de Recreo. Si el profesor tiene además guardias de recreo, aparece un asterisco azul moradito; si el profesor tiene guardias de Biblioteca, aparece un asterisco verde; y si el profesor tiene guardias de Convivencia, aparece un asterisco naranja.</li>
<li>Las Guardias de Biblioteca, Aula de Convivencia y Recreo aparecen en tablas específicas para cada grupo.</li>
<li>Las Guardias en el Aula se refieren a las sustituciones realizadas por los profesores de guardia hasta la fecha. En letra gris aparece el número de guardias asignadas en horario para cada profesor.</li>
</ul>
</p>
</div>
<hr />
<br />
<?
$datatables_min = true;

$profes_tot = mysql_query("select distinct prof from horw");
$profes_total = mysql_num_rows($profes_tot);

$sql = "SELECT DISTINCT prof, COUNT( * ) AS num
FROM  `horw` 
WHERE a_asig =  'GU'
GROUP BY prof
ORDER BY  `prof` ASC ";

$sql_gu = "SELECT DISTINCT prof, COUNT( * ) AS num
FROM  `horw` 
WHERE a_asig LIKE  'GU%'
GROUP BY prof
ORDER BY  `num` ASC ";

$sql_bib = "SELECT DISTINCT prof, COUNT( * ) AS num
FROM  `horw` 
WHERE a_asig LIKE  '%GUB%'
GROUP BY prof
ORDER BY  `prof` ASC ";

$sql_conv = "SELECT DISTINCT prof, COUNT( * ) AS num
FROM  `horw` 
WHERE a_asig LIKE  '%GUC%'
GROUP BY prof
ORDER BY  `prof` ASC ";

$sql_reg = "SELECT DISTINCT profesor, COUNT( * ) AS numero
FROM  `guardias` where profesor not like ''
GROUP BY profesor
ORDER BY  `numero` ASC ";

$sql_rec = "SELECT profesor, numero
FROM  `recreo` where profesor not like ''
ORDER BY  profesor, numero ASC ";
?>

<div class="span4">
<legend align="center" class="text-info">Guardias de Pasillo</legend>
<table class="table table-striped table-bordered tabladatos" align="center">
<thead>
<th>
Profesor
</th>
<th>

</th>
</thead>
<?
$query = mysql_query($sql);
while ($arr = mysql_fetch_array($query)) {
	
	$bibl="";
	$convi=""; 
	$recr="";	
	
	$biblio = mysql_query("select * from horw where prof = '$arr[0]' and a_asig like 'GUB%'");
	$conviven = mysql_query("select * from horw where prof = '$arr[0]' and a_asig like 'GUC%'");
	$recreo = mysql_query("select * from recreo where profesor = '$arr[0]'");
	
	if (mysql_num_rows($biblio)>0) { $bibl =  "<span class='text-success' style='font-size:18px'>*</span>";}
	if (mysql_num_rows($conviven)>0) {$convi =  "<span class='text-warning' style='font-size:18px'>*</span>";}
	if (mysql_num_rows($recreo)>0) { $recr =  "<span class='text-info' style='font-size:18px'>*</span>";}
	
	echo "<tr><td>$arr[0]</td><td>$arr[1]  $bibl $convi $recr</td></tr>";
	$num_gu+=$arr[1];
	$num_prof+=1;
}
echo "</table>";
$media = substr($num_gu/$num_prof,0,3);

echo '<br /><table class="table table-striped table-bordered" align="center">';
echo "<tr><td class='text-info'><strong>Profesores con Guardias</strong></td><td nowrap class='text-warning'><strong>$num_prof <span class='muted'>($profes_total)</span></strong></td></tr>";
echo "<tr><td class='text-info'><strong>Número de Guardias en total</strong></td><td class='text-warning'><strong>$num_gu</strong></td></tr>";
echo "<tr><td class='text-info'><strong>Media de Guardias por Profesor</strong></td><td class='text-warning'><strong>$media</strong></td></tr>";
echo "</table>";
?>
</div>

<div class="span4">
<legend align="center" class="text-info">Guardias de Biblioteca</legend>
<table class="table table-striped table-bordered" align="center">
<thead>
<th>
Profesor
</th>
<th>

</th>
</thead>
<?
$query_bib = mysql_query($sql_bib);
while ($arr_bib = mysql_fetch_array($query_bib)) {
	
	echo "<tr><td>$arr_bib[0]</td><td>$arr_bib[1]</td></tr>";
}
echo "</table>";
?>
<br />
<hr />
<legend align="center" class="text-info">Guardias de Convivencia</legend>
<table class="table table-striped table-bordered" align="center">
<thead>
<th>
Profesor
</th>
<th>

</th>
</thead>
<?
$query_conv = mysql_query($sql_conv);
while ($arr_conv = mysql_fetch_array($query_conv)) {
	echo "<tr><td>$arr_conv[0]</td><td>$arr_conv[1]</td></tr>";
}
echo "</table>";
?>

<br />
<hr />
<legend align="center" class="text-info">Guardias de Recreo</legend>
<table class="table table-striped table-bordered" align="center">
<thead>
<th>
Profesor
</th>
<th>

</th>
</thead>
<?
$query_rec = mysql_query($sql_rec);
while ($arr_rec = mysql_fetch_array($query_rec)) {
	echo "<tr><td>$arr_rec[0]</td><td>$arr_rec[1]</td></tr>";
}
echo "</table>";
?>

</div>

<div class="span4">
<legend align="center" class="text-info">Guardias en las Aulas</legend>
<table class="table table-striped table-bordered tabladatos">
<thead>
<th>
Profesor
</th>
<th>

</th>
<th>

</th>
</thead>
<?
$query_reg = mysql_query($sql_reg);
while ($arr_reg = mysql_fetch_array($query_reg)) {
	
$sql1 = mysql_query("SELECT prof
FROM  `horw` 
WHERE a_asig = 'GU' and prof = '$arr_reg[0]'");
$num_gu = mysql_num_rows($sql1);	

echo "<tr><td>$arr_reg[0]</td><td nowrap>$arr_reg[1] </td><td nowrap class='muted'>$num_gu</td></tr>";

$num_gureg+=$arr_reg[1];
$num_profreg+=1;
}
echo "</table>";

	
echo "</table>";
$media_reg = substr($num_gureg/$num_profreg,0,4);

echo '<br /><table class="table table-striped table-bordered" align="center">';
echo "<tr><td class='text-info'><strong>Guardias totales en Aulas</strong></td><td class='text-warning'><strong>$num_gureg</strong></td></tr>";
echo "<tr><td class='text-info'><strong>Media de Guardias por Profesor</strong></td><td class='text-warning'><strong>$media_reg</strong></td></tr>";
echo "</table>";
?>

</div>

</div>
</div>
<?
include("../../pie.php");
?>
