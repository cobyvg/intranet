<?php
  if($todos == "1") { 
  $titulo = "Todos los Informes en este año escolar";
} else { 
  $titulo = "Informes que responden a los datos introducidos";
}
  if($ver) { 
  $id = $llenar;
  include("infocompleto.php");
exit;}

  if($meter) { 
  $id = $llenar;
  include("informar.php");
exit;
}
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
$profesor = $_SESSION['profi'];
include("../../menu.php");
include("menu.php");
$datatables_activado = true;
?>
<div align="center">
<div class="page-header" align="center">
  <h2>Informes de Tareas <small> Buscar Informes</small></h2>
</div>

<form name="buscar" method="POST" action="buscar.php">
<div class='container'>
  <div class="row-fluid">
  <div class="span2"></div>
  <div class="span8">
 <h3><? echo $titulo;?></h3><br /> 
 <form name="buscar" method="POST" action="buscar.php">
<?php
// Consulta
 $query = "SELECT ID, CLAVEAL, APELLIDOS, NOMBRE, NIVEL, GRUPO, FECHA
  FROM tareas_alumnos WHERE 1=1 "; 
  if(!(empty($apellidos))) {$query .= "and apellidos like '%$apellidos%'";} 
  if(!(empty($nombre))) {$query .=  "and nombre like '%$nombre%'";} 
  if(!(empty($nivel))) {$query .=  "and nivel = '$nivel'";} 
  if(!(empty($grupo))) {$query .=  "and grupo = '$grupo'";} 
  $query .=  " ORDER BY FECHA DESC";

$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());

echo "<table class='table table-striped table-bordered tabladatos' align='center'><thead>";
echo "<tr><th></th><th>Alumno/a </th>
<th>Curso</Th>
<Th>Fecha inicio</th><th>Sí</th><th>No</th><th></th><th></th></TR></thead><tbody>";
if (mysql_num_rows($result) > 0)
{

	while($row = mysql_fetch_object($result))
	{
	$si='';
	$no='';
	$nulo='';
		$t_si=mysql_query("select confirmado from tareas_profesor where confirmado = 'Si' and id_alumno = '$row->ID'");
		$t_no=mysql_query("select confirmado from tareas_profesor where confirmado = 'No' and id_alumno = '$row->ID'");
		$vacio=mysql_query("select confirmado from tareas_profesor where confirmado is NULL and id_alumno = '$row->ID'");
		$si = mysql_num_rows($t_si);
		$no = mysql_num_rows($t_no);
		$nulo = mysql_num_rows($vacio);
		if ($nulo > 0){ $bola = "<i class='icon icon-ok' title='confirmado' />"; } else{ $bola = "<i class='icon icon-warning-sign' title='No confirmado' />"; }

   echo "<tr><TD><input type='radio' name='llenar' value='$row->ID'></td><td> $row->APELLIDOS $row->NOMBRE</TD>
   <TD>$row->NIVEL $row->GRUPO</TD>
   <TD>$row->FECHA</TD><TD>$si</TD><TD>$no</TD><TD>$bola</TD>";
   echo "<td><a href='infocompleto.php?id=$row->ID' class='btn btn-primary btn-mini'><i class='icon icon-search icon-white' title='Ver Informe'> </i></a>";
   $result0 = mysql_query ( "select tutor from FTUTORES where nivel = '$row->NIVEL' and grupo = '$row->GRUPO'" );
$row0 = mysql_fetch_array ( $result0 );	
$tuti = $row0[0];
		 if (stristr($cargo,'1') == TRUE or ($tuti == $_SESSION['profi'])) {
   	   	echo "&nbsp;&nbsp;<a href='informar.php?id=$row->ID' class='btn btn-primary btn-mini'><i class='icon icon-edit icon-white' title='Rellenar Informe'> </i> </a>";
		echo "&nbsp;&nbsp;<a href='borrar_informe.php?id=$row->ID&del=1' class='btn btn-primary btn-mini'><i class='icon icon-trash icon-white' title='Borrar Informe'> </i> </a> 	";
   }	
echo  '</td></tr>';
	}
echo "</tbody></table><br />";
}
// Si no hay datos
else
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
No hay Informes de Tareas disponibles con esos criterios.</div></div><hr>';
?>
<?
}
?>
</div>
</div>
		</div>
		<? include("../../pie.php");?>		
</body>
</html>