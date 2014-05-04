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
<?
include("../../menu.php");
include("../../faltas/menu.php");
?>
<style type="text/css">
.table td{
	vertical-align:middle;
}
</style>

<div class="page-header" align="center">
  <h2>Faltas de Asistencia <small> Resumen de faltas por Nivel y Grupo</small></h2>
  </div>
<br />
<?
echo "<div align='center'>";
  $AUXSQL == "";
  #Comprobamos Grupo del mismo modo.
 IF (TRIM("$grupo")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and FALUMNOS.grupo = '$grupo'";
    }
  #Comprobamos d y mes.
 IF (TRIM("$nivel")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and FALUMNOS.nivel like '%$nivel%'";
    }

 IF (TRIM("$mes")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and (month(fecha)) = $mes";
    }
	 
 $SQLTEMP = "create table FALTASTEMP select FALUMNOS.claveal, FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo,  FALTAS.falta, count(*) as NUMERO from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal " . $AUXSQL . "  and FALTAS.falta = '$FALTA' GROUP BY FALUMNOS.apellidos";

$resultTEMP= mysql_query($SQLTEMP);
 mysql_query("ALTER TABLE FALTASTEMP ADD INDEX (CLAVEAL)");
$SQL = "select FALTASTEMP.claveal, FALTASTEMP.apellidos, FALTASTEMP.nombre, FALTASTEMP.nivel, FALTASTEMP.grupo, FALTASTEMP.falta, FALTASTEMP.NUMERO from FALTASTEMP where FALTASTEMP.claveal = FALTASTEMP.claveal  and NUMERO >= '$numero2' GROUP BY FALTASTEMP.apellidos";

$result = mysql_query($SQL);

  if ($row = mysql_fetch_array($result))
        {
        echo "<table class='table table-striped' style='width:auto'>\n";
        echo "<tr ><th>Alumno</th><th>Nivel</th><th>Grupo</th>\n
        <th>Falta</th><th>Total</th></tr>";
                do {
                echo "<tr><td>";
        $foto="";
		$foto = "<img src='../../xml/fotos/$row[0].jpg' width='55' height='64' class=''  />";
		echo $foto."&nbsp;&nbsp;";
                echo "<a href='informes.php?claveal=$row[0]&fechasp1=$inicio_curso&fechasp3=$fin_curso&submit2=2'>$row[1], $row[2]</a></td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td style='color:#9d261d'><strong>$row[6]</strong></td></tr>\n"; 
        } while($row = mysql_fetch_array($result));
        echo "</table>";
        } else
        {
			echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;text-align:left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCI�N:</h5>
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
</div>
</body>
</html>
