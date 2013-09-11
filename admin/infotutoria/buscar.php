<?php
  if(isset($_GET['todos']) and $_GET['todos'] == "1") { 
  $titulo = "Todos los Informes en este año escolar";
} else { 
  $titulo = "Informes que responden a los datos introducidos";
}
  if(isset($_GET['ver']) or isset($_POST['ver'])) { 
  $id = $_GET['ver'];
  include("infocompleto.php");
exit;}
  if(isset($_GET['meter']) or isset($_POST['meter'])) { 
  $id = $_GET['llenar'];
  include("informar.php");
exit;
}
$profesor = $_SESSION['profi'];
?>
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
  <?php

include("../../menu.php");
include("menu.php");
$datatables_activado = true;
?>
<div align="center">
<div class="page-header" align="center">
  <h2>Informes de Tutoría <small> Buscar Informes</small></h2>
</div>
 <h4><? echo $titulo;?></h4><br /> 
<form name="buscar" method="POST" action="buscar.php">
<div class='container'>
  <div class="row-fluid">
  <div class="span8 offset2">
<?php
if (isset($_POST['apellidos'])) {$apellidos = $_POST['apellidos'];}else{$apellidos="";}
if (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];}else{$nombre="";}
if (!(empty($unidad))) {
$tr_uni=explode("-",$unidad);
$nivel = $tr_uni[0];
$grupo = $tr_uni[1];
}
// Consulta
 $query = "SELECT ID, CLAVEAL, APELLIDOS, NOMBRE, NIVEL, GRUPO, F_ENTREV
  FROM infotut_alumno WHERE 1=1 "; 
  if(!(empty($apellidos))) {$query .= "and apellidos like '%$apellidos%'";} 
  if(!(empty($nombre))) {$query .=  "and nombre like '%$nombre%'";} 
  if(!(empty($nivel))) {$query .=  "and nivel = '$nivel'";} 
  if(!(empty($grupo))) {$query .=  "and grupo = '$grupo'";} 
  $query .=  " ORDER BY F_ENTREV DESC";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());

echo "<table class='table table-striped table-bordered tabladatos' align='center' style='width:auto'><thead>";
echo "<th>Alumno </th>
<th>Curso</th>
<Th>Cita con padres</th><th></th></thead><tbody>";
if (mysql_num_rows($result) > 0)
{

	while($row = mysql_fetch_object($result))
	{
   echo "<tr><td> $row->NOMBRE $row->APELLIDOS</TD>
   <TD>$row->NIVEL $row->GRUPO</TD>
   <TD>$row->F_ENTREV</TD>";
echo "<td><a href='infocompleto.php?id=$row->ID' class='btn btn-primary btn-mini'><i class='icon icon-search icon-white' title='Ver Informe'> </i></a>";	

$result0 = mysql_query ( "select tutor from FTUTORES where nivel = '$row->NIVEL' and grupo = '$row->GRUPO'" );
$row0 = mysql_fetch_array ( $result0 );	
$tuti = $row0[0];
		 if (stristr($_SESSION ['cargo'],'1') == TRUE or ($tuti == $_SESSION['profi'])) {
   	echo "&nbsp;&nbsp;<a href='borrar_informe.php?id=$row->ID&del=1' class='btn btn-primary btn-mini'><i class='icon icon-trash icon-white' title='Borrar Informe'> </i> </a> 	";
   	echo "&nbsp;&nbsp;<a href='informar.php?id=$row->ID' class='btn btn-primary btn-mini'><i class='icon icon-edit icon-white' title='Rellenar Informe'> </i> </a>";
   }	
echo '</td></tr>';
	}
echo "</tbody></table><br />";
}
// Si no hay datos
else
{
	echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No hay Informes de Tutor&iacute;a disponibles.</div></div><hr>';
}
?>
<?
if(mysql_num_rows($result0) > 50) {
?>
<a href="buscar.php?pag=<? echo $pag;?>" class="btn btn-primary">Siguientes 50 Informes</a>
<? 
}
?>
</div>
</div>
		</div>
<? include("../../pie.php");?>		
</body>
</html>