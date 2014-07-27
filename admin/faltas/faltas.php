<?php
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
<!DOCTYPE html>  
<html lang="es">  
  <head>  
    <meta charset="iso-8859-1">  
    <title>Intranet</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta name="description" content="Intranet del http://<? echo $nombre_del_centro;?>/">  
    <meta name="author" content="">  
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">   
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
    <link href="http://<? echo $dominio;?>/intranet/js/google-code-prettify/prettify.css" rel="stylesheet">
    <link rel="stylesheet" href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css">  
    <link href="http://<? echo $dominio;?>/intranet/css/datepicker.css" rel="stylesheet" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://<? echo $dominio;?>/intranet/css/DataTable.bootstrap.css">   
     <script type="text/javascript">
function confirmacion() {
	var answer = confirm("ATENCIÓN:\n ¿Estás seguro de que quieres borrar el registro de la base de datos? Esta acción es irreversible. Para borrarlo, pulsa Aceptar; de lo contrario, pulsa Cancelar.")
	if (answer){
return true;
	}
	else{
return false;
	}
}
</script>
    <!--[if lt IE 9]>  
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>  
    <![endif]-->    
</head>

<body>
 
<?
include("../../menu_solo.php");
include("../../faltas/menu.php");
?>
<style type="text/css">
.table td{
	vertical-align:middle;
}
</style>

<div class="page-header" align="center">
  <h2>Faltas de Asistencia <small> Resumen de faltas por Grupo</small></h2>
  </div>
<br />
<div class="container">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">

<?
  $AUXSQL == "";
  
 IF (TRIM("$unidad")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and FALUMNOS.unidad like '%$unidad%'";
    }

 IF (TRIM("$mes")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and (month(fecha)) = $mes";
    }
	 
 $SQLTEMP = "create table FALTASTEMP select FALUMNOS.claveal, FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, FALUMNOS.nc,  FALTAS.falta, count(*) as NUMERO from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal " . $AUXSQL . "  and FALTAS.falta = '$FALTA' GROUP BY FALUMNOS.apellidos";

$resultTEMP= mysql_query($SQLTEMP);
 mysql_query("ALTER TABLE FALTASTEMP ADD INDEX (CLAVEAL)");
$SQL = "select FALTASTEMP.claveal, FALTASTEMP.apellidos, FALTASTEMP.nombre, FALTASTEMP.unidad, FALTASTEMP.falta, FALTASTEMP.NUMERO from FALTASTEMP where FALTASTEMP.claveal = FALTASTEMP.claveal  and NUMERO >= '$numero2' GROUP BY FALTASTEMP.apellidos";

$result = mysql_query($SQL);
if (mysql_num_rows($result)>50) {
$datatables_min = true;
}
  if ($row = mysql_fetch_array($result))
        {
        echo "<table class='table table-striped tabladatos' style='width:96%'>\n";
        echo "<thead><th>Alumno</th><th>Grupo</th><th>Falta</th><th>Total</th></thead><tbody>";
                do {
                echo "<tr><td>";
        $foto="";
		$foto = "<img src='../../xml/fotos/$row[0].jpg' width='55' height='64' class=''  />";
		echo $foto."&nbsp;&nbsp;";
                echo "<a href='informes.php?claveal=$row[0]&fechasp1=$inicio_curso&fechasp3=$fin_curso&submit2=2'>$row[1], $row[2]</a></td><td>$row[3]</td><td>$row[4]</td><td style='color:#9d261d'><strong>$row[5]</strong></td></tr>\n"; 
        } while($row = mysql_fetch_array($result));
        echo "</tbody></table>";
        } else
        {
			echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;text-align:left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIï¿½N:</h5>
No hay registros coincidentes, bien porque te has equivocado
        al introducir los datos, bien porque ningun dato se ajusta a tus criterios.
		</div></div><br />';
?>
        <?
        }
// Eliminar Tabla temporal
 $SQLDEL = "DROP table `FALTASTEMP`";
 mysql_query($SQLDEL);
  ?>
 <?
include("../../pie.php");
 ?>
</div>
</div>
</div>
</body>
</html>
