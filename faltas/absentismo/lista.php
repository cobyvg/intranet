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
<?
include("../../menu.php");
include("../menu.php");

if (isset($_GET['mes'])) {$mes = $_GET['mes'];}elseif (isset($_POST['mes'])) {$mes = $_POST['mes'];}else{$mes="";}
if (isset($_GET['num_mes'])) {$num_mes = $_GET['num_mes'];}elseif (isset($_POST['num_mes'])) {$num_mes = $_POST['num_mes'];}else{$num_mes="";}
if (isset($_GET['numero'])) {$numero = $_GET['numero'];}elseif (isset($_POST['numero'])) {$numero = $_POST['numero'];}else{$numero="";}
?>
<style type="text/css">
.table td{
	vertical-align:middle;
}
</style>

<h3 align="center"> Alumnos absentistas </h3><br /><br />
<?
if (isset($_POST['submit'])) {
	          if($mes=='Septiembre'){$n_mes='09';}
                    if($mes=='Octubre'){$n_mes='10';}
                    if($mes=='Noviembre'){$n_mes='11';}
                    if($mes=='Diciembre'){$n_mes='12';}
                    if($mes=='Enero'){$n_mes='01';}
                    if($mes=='Febrero'){$n_mes='02';}
                    if($mes=='Marzo'){$n_mes='03';}
                    if($mes=='Abril'){$n_mes='04';}
                    if($mes=='Mayo'){$n_mes='05';}
                    if($mes=='Junio'){$n_mes='06';}
	//mysql_query("delete from absentismo where mes='$num_mes'");
	foreach ($_POST as $num=>$key)
	{
// echo "$num --> $key<br>";
$claveal=$num;
$trozos=explode(";",$key);
$n_mes=$trozos[0];
$n_faltas=$trozos[1];
$curso=$trozos[2];
$trozos2=explode("-",$curso);
$nivel=$trozos2[0];
$grupo=$trozos2[1];
 $insert0=mysql_query("select claveal, mes from absentismo where claveal='$claveal' and mes='$n_mes'");
 
 	if (mysql_num_rows($insert0)>0) {}
 	else {
 		if (is_numeric($claveal)) {
  	 	$abs = mysql_query("insert into absentismo (  claveal ,  mes ,  numero ,  nivel ,  grupo )  VALUES (  '$claveal', '$n_mes', '$n_faltas', '$nivel', '$grupo' )");	
		
 		}
 	}
	}
	echo '<br /><div align="center""><div class="alert alert-success alert-block fade in" style="max-width:500px;" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			Los datos de los alumnos absentistas se han actualizado. Se ha enviado un mensaje al <b>Departamento de Orientaci�n</b> y los <b>Tutores</b> para que procedan con el Informe de Absentismo.
			</div></div>';
}
else 
{
?> 
<form enctype='multipart/form-data' action='lista.php' method='post'> 
 <? 
                    if($mes=='Septiembre'){$n_mes='09';}
                    if($mes=='Octubre'){$n_mes='10';}
                    if($mes=='Noviembre'){$n_mes='11';}
                    if($mes=='Diciembre'){$n_mes='12';}
                    if($mes=='Enero'){$n_mes='01';}
                    if($mes=='Febrero'){$n_mes='02';}
                    if($mes=='Marzo'){$n_mes='03';}
                    if($mes=='Abril'){$n_mes='04';}
                    if($mes=='Mayo'){$n_mes='05';}
                    if($mes=='Junio'){$n_mes='06';}
                    $mes=strtoupper($mes);
        echo "<center> <h4>Alumnos con m�s de <span class='badge badge-warning'>$numero</span> faltas de asistencia en <span class='badge badge-warning'>$mes</span></h4>";
		echo '<br /><TABLE class="table table-striped" style="width:auto" align="center">
';
        echo "<tr><th></th><th align='center'>Alumno</th><th align='center'>Curso</th>
        <th align='center'>N� faltas</th><th align='center'>N� d�as</th></tr>";

// Creaci�n de la tabla temporal donde guardar los registros. La variable para el bucle es 10224;  
  $SQLTEMP = "create table faltastemp2 SELECT FALTAS.CLAVEAL, falta, (count(*)) AS numero, FALTAS.nivel, FALTAS.grupo FROM FALTAS, FALUMNOS where FALTAS.CLAVEAL=FALUMNOS.claveal and  falta = 'F' and month(FALTAS.fecha)= '$n_mes'   group by apellidos, nombre";
  $resultTEMP= mysql_query($SQLTEMP);
  mysql_query("ALTER TABLE faltastemp2 ADD INDEX (CLAVEAL)");
  $SQL0 = "SELECT CLAVEAL  FROM  faltastemp2 WHERE numero > '$numero' order by nivel, grupo";
  //print $SQL0;
  $result0 = mysql_query($SQL0);
 while  ($row0 = mysql_fetch_array($result0)){
 	//reset($claveal);
$claveal = $row0[0];
// No justificadas
  $SQLF = "select faltastemp2.claveal, alma.apellidos, alma.nombre, alma.nivel, alma.grupo,
  FALTAS.falta,  faltastemp2.numero, alma.DOMICILIO, alma.CODPOSTAL, alma.LOCALIDAD  
  from faltastemp2, FALTAS, alma where alma.claveal = FALTAS.claveal  
  and faltastemp2.claveal = FALTAS.claveal and FALTAS.claveal like '$claveal' 
  and FALTAS.falta = 'F' GROUP BY alma.apellidos";
  //echo $SQLF;
  $resultF = mysql_query($SQLF);	
//Fecha del d�a
$fhoy=getdate();
$fecha=$fhoy[mday]."-".$fhoy[mon]."-".$fhoy[year];
// Bucle de Consulta.
  while($rowF = mysql_fetch_array($resultF))
        {
        	$sel="";
        	$registrado = mysql_query("select claveal from absentismo where claveal='$claveal' and mes='$n_mes'");
        	if (mysql_num_rows($registrado)>0) {
        		$sel=" checked";
        	}
	echo "<tr><td align='center'>";
        $foto="";
		$foto = "<img src='../../xml/fotos/$rowF[0].jpg' width='55' height='64'  />";
		echo $foto."&nbsp;&nbsp;&nbsp;";	
	echo "<input name='$rowF[0]' type='checkbox' value='$n_mes;$rowF[6];$rowF[3]-$rowF[4]' $sel /></td>";
	echo "<td  align='left'>$rowF[2] $rowF[1]</td><td>$rowF[3]-$rowF[4]</td>
	<td>$rowF[6]</td>";
  $SQL2 = "SELECT distinct FALTAS.fecha from FALTAS where FALTAS.CLAVEAL like '$claveal' and month(FALTAS.fecha) = '$n_mes'";
  $result2 = mysql_query($SQL2);
  $rowsql = mysql_num_rows($result2);
  echo "<td>$rowsql</td></tr>";
	}         
	} 
	echo '</table';      
// Eliminar Tabla temporal
 mysql_query("DROP table `faltastemp2`");
  ?>
 <INPUT name="num_mes" type="hidden" value="<? echo $n_mes;?>"> 
 <br />
 <INPUT name="submit" type="submit" value="Enviar Datos" id="submit" align="center" class="btn btn-danger"> 

</form>
<?
}
if (strstr($_SESSION['cargo'],'1')==TRUE OR strstr($_SESSION['cargo'],'8')==TRUE) {echo '<br><div align="center"><br /><a href="index.php" class="btn btn-primary">Volver a la P�gina de Absentismo</a>';}
?>
<? include("../../pie.php");?>
</body>
</html>