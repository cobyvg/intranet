<?php 
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


?>
<?
include("../../menu.php"); 
//include("menu.php"); 

$query_Recordset1 = "SELECT * FROM asignaturas GROUP BY nombre ORDER BY nombre ASC";
$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_array($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$query_Recordset2 = "SELECT Unidad FROM alma GROUP BY unidad ORDER BY Unidad";
$Recordset2 = mysql_query($query_Recordset2) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
	echo '<br />
<div align=center>
<div class="page-header">
  <h2>Listas de Alumnos <small> Lista de Alumnos con asignaturas pendientes</small></h2>
</div>
</div>
<div class="container">
<div class="row">';
?>
<div class="col-sm-4 col-sm-offset-2 well well-large">

<legend>
Listado de pendientes por Asignatura</legend>
<form id="form1" name="form1" method="post" action="lista_pendientes.php">
  <label>
	<div class="text-info">
    <p>Selecciona la(s) asignatura(s):  </p>
  </div>
  <select name="select[]" multiple size="10" class="input-xlarge">
    <?php 
do {  
?>
    <option><?php  echo $row_Recordset1[1]?></option>
    <?php 
} while ($row_Recordset1 = mysql_fetch_array($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_array($Recordset1);
  }
?>
  </select>
  </label><br>
  <label> 
  <input class='btn btn-primary btn-block' type="submit" name="Submit" value="Enviar" />
  </label>
</form>
</div>
<div class="col-sm-4 well well-large">
<legend>
Listado de pendientes por Unidad</legend>
<form id="form2" name="form2" method="post" action="pendientes_unidad.php">
  <label>
	<div class="text-info">
    <p>Selecciona la(s) unidad(es):</p>
  </div>
  <select name="select1[]" size="10" multiple class="input-xlarge">
    <?php 
do {  
	if (strstr($row_Recordset2['Unidad'],"E") or strstr($row_Recordset2['Unidad'],"B")) {	
?>
    <option value="<?php  echo $row_Recordset2['Unidad']?>"><?php  echo $row_Recordset2['Unidad']?></option>
    <?php 
	}
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
  </select>
  </label><br>
  <label> 
  <input class='btn btn-primary btn-block' type="submit" name="Submit" value="Enviar" />
  </label>
</form>
</div>
</div>
</div>
	<?php 	
mysql_free_result($Recordset1);
?>
</html>
