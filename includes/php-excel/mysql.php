<?php 
require_once("excel.php"); 
require_once("excel-ext.php"); 
include("../../includes/conexion.inc.php");
$queEmp = $_GET['sentencia'];
#$queEmp = "SELECT * FROM alumnos";
$resEmp = mysql_query($queEmp, $c) or die(mysql_error());
$totEmp = mysql_num_rows($resEmp);

while($datatmp = mysql_fetch_assoc($resEmp)) { 
	$data[] = $datatmp; 
}  
createExcel("datos_excel.xls", $data);
exit;
?>