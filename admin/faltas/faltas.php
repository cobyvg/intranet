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
                echo "<tr><td><a href='informes.php?claveal=$row[0]&fechasp1=$inicio_curso&fechasp3=$fin_curso&submit2=2'>$row[1], $row[2]</a></td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td style='color:#9d261d'><strong>$row[6]</strong></td></tr>\n"; 
        } while($row = mysql_fetch_array($result));
        echo "</table>";
        } else
        {
			echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;text-align:left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
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
t' name='f1' class="form-inline">
<div class="row-fluid">
  <div class="span4">
  <div class="well well-large pull-right"  style="width:340px;">
  <legend>Resumen de faltas de un Grupo.</legend>
<br />
  <h6>Selecciona Nivel y Grupo</h6>
    <label> Nivel:
    <SELECT name="nivel" onChange="submit()" class="input-mini"  style="display:inline">
      <OPTION><? echo $nivel;?></OPTION>
      <? nivel();?>
    </SELECT>
  </label>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <label style="display:inline">
  Grupo:
  <SELECT name="grupo" onChange="submit()" class="input-mini"  style="display:inline">
    <OPTION><? echo $grupo;?></OPTION>
    <? grupo($nivel);?>
  </SELECT>
  </label>
  <hr>
   <label>
  Mes:&nbsp;
  <SELECT name='mes' class="input-mini">
    <OPTION></OPTION>
    <?
	for($i=1;$i<13;$i++){
	echo "<OPTION>$i</OPTION>";	
	}
	?>    
  </SELECT>
  <!-- <INPUT name="mes" type="text" value="<? echo date(m); ?>" class="input-mini" maxlength="2" >-->
  </label>
  <br />
  <label>
  Falta:
  <SELECT name='FALTA' class="input-mini">
    <OPTION>F</OPTION>
    <OPTION>J</OPTION>
  </SELECT>
  </label>
  <br />
  <label>
  N&uacute;mero m&iacute;nimo de
  Faltas
  <INPUT name="numero2" type="text" class="input-mini" maxlength="3" alt="Mes" value="1">
  </label>
  <hr />
  <input name="submit1