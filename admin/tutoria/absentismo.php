<?
session_start();
include("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


?>
<?
include("../../menu.php");
if (isset($_GET['tutor'])) {
	$tutor = $_GET['tutor'];
}
elseif (isset($_POST['tutor'])) {
	$tutor = $_POST['tutor'];
}
else{$tutor = "";}

	$tutor0=mysql_query("select unidad from FTUTORES where tutor='$tutor'");
	$d_tutor=mysql_fetch_array($tutor0);
	$grupo_tutor = $d_tutor[0];
	$mas=" and absentismo.unidad='$grupo_tutor' ";
	$mas2=" and tutoria IS NULL ";
	$titulo=" DEL TUTOR ";
	$upd=" tutoria='$texto' ";
?>
<div align="center">
<div class="page-header">
  <h2>Página del tutor <small> Alumnos absentistas<br /><? echo "$grupo_tutor";?></small></h2>
</div>
<br />
<?

// Procesamos datos si se ha dado al botón
if ($submit) {
	mysql_query("update absentismo set $upd where claveal='$claveal' and mes='$mes'")	;
	// echo "update absentismo set $upd where claveal='$claveal' and mes='$mes'";
	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos de los alumnos absentistas se han actualizado.
</div></div><br />';
	echo '<center><input type="button" value="Volver atrás" name="boton" onclick="history.back(2)" class="btn btn-primary" /></center>';
	//exit();
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
$al=mysql_query("SELECT distinct apellidos, nombre, absentismo.unidad, alma.matriculas, numero, jefatura, orientacion, tutoria FROM absentismo, alma WHERE alma.claveal = absentismo.claveal and absentismo.claveal='$claveal' and mes='$mes'");

	if (mysql_num_rows($al)>0) {
		$datos=mysql_fetch_array($al);
		$obs=$datos[7];
		echo  "<br /><table class='table table-striped' style='width:auto'><tr><th> Nombre </th><th> Curso </th>
<th> Mes </th><th> Nº faltas </th></tr>
<tr><td>$datos[0], $datos[1]</td><td>$datos[2]</td><td>$mes</td><td>$datos[4]</td></tr></table><hr><br />";
		echo "<form enctype='multipart/form-data' action='absentismo.php' method='post'>";
?>
<input name="claveal" type="hidden" value="<? echo $claveal;?>">
<input name="mes" type="hidden" value="<? echo $mes;?>">
<label>Observaciones del Tutor<br />
<textarea name="texto" title="Informe de Alumno absentista." rows="5" class="col-sm-5"><? echo $obs;?></textarea>
</label>
<br />
<label>Observaciones de Jefatura<br />
<textarea disabled name="texto_jefe"  class="col-sm-5" rows="5"><? echo $datos[5];?></textarea>
</label>
<br />
<label>Observaciones de Orientación<br />
<textarea disabled name="texto_orienta"  class="col-sm-5" rows="5"><? echo $datos[6];?></textarea>
</label>
<br />
<input type="submit" name="submit" value="Enviar Informe" class="btn btn-primary">
<input type="hidden" name="tutor" value="<? echo $tutor;?>" >
<?
echo "</form>";
	}
}

$SQL0 = "SELECT absentismo.CLAVEAL, apellidos, nombre, absentismo.unidad, alma.matriculas, numero, mes, jefatura, orientacion, tutoria FROM absentismo, alma WHERE alma.claveal = absentismo.claveal $mas  order by mes, absentismo.unidad";
$result0 = mysql_query($SQL0);
if (mysql_num_rows($result0)>0) {
	echo  "<br /><table class='table table-striped' style='width:auto'>";
	echo "<tr><th>Alumno</th><th>Curso</th>
        <th>Mes</th><th>Nº faltas</th><th></th></tr>";
	while  ($row0 = mysql_fetch_array($result0)){
		$claveal=$row0[0];
		$mes=$row0[6];
		$numero=$row0[5];
		$unidad=$row0[3];
		$nombre=$row0[2];
		$apellidos=$row0[1];
		$jefatura=$row0[7];
		$orientacion=$row0[8];
		$tutoria=$row0[9];
		if (strlen($jefatura)>0) {$chj=" checked ";}else{$chj="";}if(strlen($orientacion)>0) {$cho=" checked ";}else{$cho="";}if (strlen($tutoria)>0) {$cht=" checked ";}else{$cht="";}
		echo "<tr><td >$apellidos, $nombre</td><td>$unidad</td><td>$mes</td><td>$numero</td>";
		echo "<td><a href='absentismo.php?claveal=$claveal&mes=$mes&inf=1&tutor=$tutor'> <i class='fa fa-search' title='Detalles'> </i> </a>";
		echo "</td>";

		echo "</tr>";
	}
	echo "</table></center>";
}
else
{
	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Parece que no hay alumnos absentistas registrados en ese mes.<br>Si te has equivocado, vuelve atr&aacute;s e int&eacute;ntalo de nuevo.
</div></div><br />';
	}

  ?>
</div>
</div>
  <? include("../../pie.php");?>		
</body>
</html>