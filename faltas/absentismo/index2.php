<?
session_start();
include("../../config.php");
if(!($_SESSION['autentificado']=='1'))
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
?>
<?
if (strstr($_SESSION['cargo'],'8')==TRUE) {
	$mas="";
	$titulo="Departamento de orientación  ";
	$upd=" orientacion='$texto' ";
}
if (strstr($_SESSION['cargo'],'2')==TRUE and strstr($_SESSION['cargo'],'8')==FALSE) {
	$tut=$_SESSION['profi'];
	$tutor=mysql_query("select nivel, grupo from FTUTORES where tutor='$tut'");
	$d_tutor=mysql_fetch_array($tutor);
	$mas=" and absentismo.nivel='$d_tutor[0]' and absentismo.grupo='$d_tutor[1]' and tutoria IS NULL ";
	$mas2=" and tutoria IS NULL ";
	$titulo="Tutor: $d_tutor[0]";
	$upd=" tutoria='$texto' ";
}
if (strstr($_SESSION['cargo'],'1')==TRUE) {
	$mas="";
	$titulo="Jefatura de Estudios ";
	$upd=" jefatura='$texto' ";
}
?>
<br />
<h3 align="center">Alumnos con informes de absentismo pendiente <br /><span style='color:#08c'><? echo  $titulo;?></span> </h3><br /><br />
<?
// Borramos alumnos
if ($del=='1') {
	mysql_query("delete from absentismo where claveal = '$claveal' and mes = '$mes'");
	echo '<div align="center""><div class="alert alert-warning alert-block fade in" style="max-width:500px;" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos del alumno han sido borrados de la Base de datos.
			</div></div><br />';
}
// Procesamos datos si se ha dado al botón 
if ($submit) {
mysql_query("update absentismo set $upd where claveal='$claveal' and mes='$mes'")	;
// echo "update absentismo set $upd where claveal='$claveal' and mes='$mes'";
echo '<div align="center""><div class="alert alert-success alert-block fade in" style="max-width:500px;" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos de los alumnos absentistas se han actualizado.
			</div></div><br />';
	}

                    if($mes=='Septiembre'){$mes='09';}
                    if($mes=='Octubre'){$mes='10';}
                    if($mes=='Noviembre'){$mes='11';}
                    if($mes=='Diciembre'){$mes='12';}
                    if($mes=='Enero'){$mes='01';}
                    if($mes=='Febrero'){$mes='02';}
                    if($mes=='Marzo'){$mes='03';}
                    if($mes=='Abril'){$mes='04';}
                    if($mes=='Mayo'){$mes='05';}
                    if($mes=='Junio'){$mes='06';}
// Vamos a rellenar informe

if ($inf=="1") {
	echo '<div align="center" class="well well-large" style="width:600px;margin:auto">';
echo "<h4 align='center'>Datos del Alumno</h4><br />";
$al=mysql_query("SELECT distinct apellidos, nombre, absentismo.nivel, absentismo.grupo, numero, jefatura, orientacion, tutoria FROM absentismo, alma WHERE alma.claveal = absentismo.claveal and absentismo.claveal='$claveal' and mes='$mes' $mas2");

if (mysql_num_rows($al)>0) {

$datos=mysql_fetch_array($al);
if (strstr($_SESSION['cargo'],'1')==TRUE) {$obs=$datos[5];}elseif (strstr($_SESSION['cargo'],'8')==TRUE){$obs=$datos[6];}else {$obs=$datos[7];}
echo  "<center><table class='table table-striped table-bordered' style='width:auto'><tr><th align='center'> NOMBRE </th><th align='center'> CURSO </th>
<th align='center'> MES </th><th align='center'> Nº FALTAS </th></tr>
<tr><td align='center'>$datos[0], $datos[1]</td><td id='' align='center'>$datos[2]-$datos[3]</td><td id='' align='center'>$mes</td><td id='' align='center'>$datos[4]</td></tr></table><br />";
echo "<form enctype='multipart/form-data' action='index2.php' method='post'>";
?>
<input name="claveal" type="hidden" value="<? echo $claveal;?>">
<input name="mes" type="hidden" value="<? echo $mes;?>">
<label>Observaciones<br />
<textarea name="texto" title="Informe de Alumno absentista." class="span6" rows="12"><? echo $obs;?></textarea>
</label>
<br />
<input type="submit" name="submit" value="Enviar Informe" class="btn btn-primary">
<?
echo "</form>";
echo "</div></center><br /><br /><br />";
}
}


$SQL0 = "SELECT absentismo.CLAVEAL, apellidos, nombre, absentismo.nivel, absentismo.grupo, numero, mes, jefatura, orientacion, tutoria FROM absentismo, alma WHERE alma.claveal = absentismo.claveal and mes='$mes' $mas  order by nivel, grupo";
  $result0 = mysql_query($SQL0);
  if (mysql_num_rows($result0)>0) {
echo  "<center><table class='table table-striped table-bordered' style='width:auto'>\n";
        echo "<tr><th align='center'>NOMBRE DEL ALUMNO</th><th align='center'>CURSO</th>
        <th align='center'>MES</th><th align='center'>Nº FALTAS</th>";

        if (strstr($_SESSION['cargo'],'1')==TRUE OR strstr($_SESSION['cargo'],'8')==TRUE) {
        	echo "<th>Jef.</th><th>Orienta.</th><th>Tut.</th><th></th>";
        }
		echo "</tr>";
 while  ($row0 = mysql_fetch_array($result0)){
 	$claveal=$row0[0];
 	$mes=$row0[6];
 	$numero=$row0[5];
 	$grupo=$row0[4];
 	$nivel=$row0[3];
 	$nombre=$row0[2];
 	$apellidos=$row0[1];
 	$jefatura=$row0[7];
 	$orientacion=$row0[8];
 	$tutoria=$row0[9];
 	if (strlen($jefatura)>0) {$chj=" checked ";}else{$chj="";}if(strlen($orientacion)>0) {$cho=" checked ";}else{$cho="";}if (strlen($tutoria)>0) {$cht=" checked ";}else{$cht="";}
	echo "<tr><td  align='left'>$apellidos, $nombre</td><td>$nivel-$grupo</td><td>$mes</td><td>$numero</td>";
        if (strstr($_SESSION['cargo'],'1')==TRUE OR strstr($_SESSION['cargo'],'8')==TRUE) {
	echo "<td><input type='checkbox' $chj></td><td><input type='checkbox' $cho></td><td><input type='checkbox' $cht></td>";
        }
	echo "<td align='center'><a href='index2.php?claveal=$claveal&mes=$mes&inf=1'> <i class='icon icon-pencil'> </i></a>";
if (strstr($_SESSION['cargo'],'1')==TRUE) {
		echo "<a href='index2.php?claveal=$claveal&mes=$mes&del=1'> <i class='icon icon-trash'> </i></a>";
}

	echo "</td>";
	
	echo "</tr>";
	}
	echo "</table>";
	echo "<br /><input type='button' value='Imprimir todos' name='boton2' class='btn btn-primary' onclick='window.location=\"imprimir.php?mes=".$mes."\"' /></center>";   
	}
else
{
	echo '<div align="center""><div class="alert alert-warning alert-block fade in" style="max-width:500px;" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Parece que no hay alumnos absentistas registrados en ese mes. Si te has equivocado, vueve atr&aacute;s e int&eacute;ntalo de nuevo.			</div></div>';
}
  ?>

</div>
<? include("../../pie.php");?>
</body>
</html>