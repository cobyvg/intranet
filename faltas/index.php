<?
session_start();
include("../config.php");
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
$pr = $_SESSION['profi'];
$prof1 = "SELECT distinct no_prof FROM horw where prof = '$pr'";
$prof0 = mysql_query($prof1);
$filaprof0 = mysql_fetch_array($prof0);
$profesi = $filaprof0[0]."_ ".$pr;
$_SESSION['todo_profe'] = $profesi;

if (isset($_POST['fecha_dia'])) {$fecha_dia = $_POST['fecha_dia'];}elseif (isset($_GET['fecha_dia'])) {$fecha_dia = $_GET['fecha_dia'];} 
if (isset($_POST['hora_dia'])) {$hora_dia = $_POST['hora_dia'];}elseif (isset($_GET['hora_dia'])) {$hora_dia = $_GET['hora_dia'];} 

if (isset($fecha_dia) and isset($hora_dia)) {
	$tr_fech = explode("/", $fecha_dia);
	$di = $tr_fech[0];
	$me = $tr_fech[1];
	$an = $tr_fech[2];
	$ndia = date("N", mktime(0, 0, 0, $me, $di, $an));
	$hoy = "$an-$me-$di";
	$hoy_actual = "$di-$me-$an";

	//echo "$ndia $hora_dia $fecha_dia $hoy $an-$me-$di";
}
else {
	$hora = date("G");// hora ahora
	$minutos = date("i");
	$diames = date("j");
	$nmes = date("n");
	$nano = date("Y");
	$hoy = $nano."-".$nmes."-".$diames;
	if(empty($hora_dia)){
		if(($hora == '8' and $minutos > 15 ) or ($hora == '9' and $minutos < 15 ) ){$hora_dia = '1';}
		elseif(($hora == '9' and $minutos > 15 ) or ($hora == '10' and $minutos < 15 ) ){$hora_dia = '2';}
		elseif(($hora == '10' and $minutos > 15 ) or ($hora == '11' and $minutos < 15 ) ){$hora_dia = '3';}
		elseif(($hora == '11' and $minutos > 15 ) or ($hora == '11' and $minutos < 45 ) ){$hora_dia = 'R';}
		elseif(($hora == '11' and $minutos > 45 ) or ($hora == '12' and $minutos < 45 ) ){$hora_dia = '4';}
		elseif(($hora == '12' and $minutos > 45 ) or ($hora == '13' and $minutos < 45 ) ){$hora_dia = '5';}
		elseif(($hora == '13' and $minutos > 45 ) or ($hora == '14' and $minutos < 45 ) ){$hora_dia = '6';}
		else{ $hora_dia = "Fuera del Horario Escolar";}
	}
		$ndia = date("w");// nº de día de la semana (1,2, etc.)
}
	if($ndia == "1"){$nom_dia = "Lunes";}
	if($ndia == "2"){$nom_dia = "Martes";}
	if($ndia == "3"){$nom_dia = "Miércoles";}
	if($ndia == "4"){$nom_dia = "Jueves";}
	if($ndia == "5"){$nom_dia = "Viernes";}
	
//$nl_curs10 = "select distinct a_grupo from horw where no_prof = '30' and dia = '1' and hora = '1'";
$nl_curs10 = "select distinct a_grupo from horw where no_prof = '$filaprof0[0]' and dia = '$ndia' and hora = '$hora_dia'";
$nl_curs11 = mysql_query($nl_curs10);
$nml0 = mysql_fetch_array($nl_curs11);
$nml = $nml0[0];





?>
<?
if ($mod_faltas) {
	include("../menu.php");
	include("menu.php");
	?>
<div class="container">

<div class="page-header">
<h2>Faltas de Asistencia <small> Poner faltas</small></h2>
</div>
<div class="row">
<?
// Unir todos los grupos para luego comprobar que no hay duplicaciones (4E-E,4E-Dd)
//$n_curs0 = "select distinct a_grupo, c_asig from horw where no_prof = '30' and dia = '1' and hora = '1'";
$n_curs0 = "select distinct a_grupo, c_asig from horw where no_prof = '$filaprof0[0]' and dia = '$ndia' and hora = '$hora_dia'";
$n_curs1 = mysql_query($n_curs0);
while($n_cur = mysql_fetch_array($n_curs1))
{
	$curs .= $n_cur[0].", ";
	$cod.=$n_cur[1]." ";
}
//echo $n_curs0;
if($mensaje){
	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Las Faltas han sido registradas correctamente.
          </div></div>'; 
}

$t_grupos = $curs;
if(!($t_grupos=="")){
	echo "<p class='lead' align='center'><span style='color:#9d261d'>Fecha</span>: $hoy_actual &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#9d261d'>Día</span>: $nom_dia &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#9d261d'>Hora:</span> $hora_dia";
	if(!($hora_dia == "Fuera del Horario Escolar")){echo "ª hora";}
	echo "</p>";
}
?>
<div class="col-md-7">
<div align="left">
	<?

//$hora1 = "select distinct c_asig, a_grupo, asig from horw where no_prof = '30' and dia = '1' and hora = '1'";
$hora1 = "select distinct c_asig, a_grupo, asig from horw where no_prof = '$filaprof0[0]' and dia = '$ndia' and hora = '$hora_dia' and a_grupo not like ''";
$hora0 = mysql_query($hora1);
if (mysql_num_rows($hora0)<1) {
		echo '<br /><div align="lef"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            No tienes alumnos en esta hora del día.
            <br>Selecciona una fecha y hora en el formulario para registrar faltas de asistencia.
          </div></div>'; 
}
while($hora2 = mysql_fetch_row($hora0))
{

	$codasi= $hora2[0];
	if (empty($hora2[1])) {
		$curso="";
	}
	else{
	$curso = $hora2[1];
	}
	$asignatura = $hora2[2];

	$nivel_curso = substr($curso,0,1);
	
	//	Problemas con Diversificación (4E-Dd)
	$diversificacion = "";
	$profe_div = mysql_query("select * from profesores where grupo = '$curso'");
	if (mysql_num_rows($profe_div)<1) {

		$grupo_div = mysql_query("select distinct unidad from alma where unidad like '$nivel_curso%' and (combasi like '%25204%' or combasi LIKE '%25226%')");
		if (mysql_num_rows($grupo_div)>0) {
				$diversificacion = 1;
				$div = $curso;
				$grupo_diver = mysql_fetch_row($grupo_div);
				$curso = $grupo_diver[0];
		}
	}
	?>
<form action="poner_falta.php" method="post" name="Cursos">
<?php

// Codigo del profe
//echo "$hora_dia -- $ndia -- $hoy -- $codasi -- $pr -- $clave<br>";
$c_a="";
$res = "select distinctrow FALUMNOS.CLAVEAL, FALUMNOS.NC, FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, alma.MATRICULAS, alma.combasi from FALUMNOS, alma WHERE FALUMNOS.CLAVEAL = alma.CLAVEAL and FALUMNOS.unidad = '$curso' and ( ";
//$n_curs10 = "select distinct c_asig from horw where no_prof = '30' and dia = '1' and hora = '1'";
$n_curs10 = "select distinct c_asig from horw where no_prof = '$filaprof0[0]' and dia = '$ndia' and hora = '$hora_dia'";
$n_curs11 = mysql_query($n_curs10);
$nm = mysql_num_rows($n_curs11);
while ($nm_asig0=mysql_fetch_array($n_curs11)){
	$c_a.="combasi like '%".$nm_asig0[0]."%' or ";
}

$res.=substr($c_a,0,strlen($c_a)-3);
$res.=") order by NC";
//echo $res;
$result = mysql_query ($res);
if ($result) {
	echo "<br><table class='table table-striped table-bordered table-condensed' style='max-width:auto'>\n";
	$filaprincipal = "<tr><th colspan='8'><h4 align='center'><span class='text-info'>";

	$filaprincipal.= substr($t_grupos,0,-2);

	$filaprincipal.= "</span> <small class='text-warning'>$asignatura</small></h4></th></tr>";
	if ($diversificacion!==1) {
		$curso = $hora2[1];
	}
	echo $filaprincipal;
	
	while($row = mysql_fetch_array($result)){
	$n+=1;
	$chk="";
	$combasi = $row[5];
	if ($row[5] == "") {}
	else{
		$pares = $n%2;
		if ($pares=="") {}else{	echo "<tr>";}
		
		
		$foto="";
		$foto = "<img src='../xml/fotos/$row[0].jpg' width='50' height='60' class=''  />";
		echo "<td>".$foto."</td>";

		echo "<td style='vertical-align:middle'>$row[1]</td><td style='vertical-align:middle'>$row[2], $row[3]";
		if ($row[4] == "2" or $row[4] == "3") {echo " (R)";}
	}
	echo "</td><td style='vertical-align:middle'>";


	$fecha_hoy = date('Y')."-".date('m')."-".date('d');
	$falta_d = mysql_query("select distinct falta from FALTAS where dia = '$ndia' and hora = '$hora_dia' and claveal = '$row[0]' and fecha = '$hoy'");
	$falta_dia = mysql_fetch_array($falta_d);
	if ($falta_dia[0] == "F") {
		$chk = "checked";
	}
	?> <input name="falta_<? echo $row[1]."_".$curso;?>" type="checkbox"
	<? echo $chk; ?> value="F" /> <?
	echo "</td>";
	if ($pares=="") {echo "</tr>";}
}
}
?>
<tr><td colspan=8  align="center">
<div class="btn-group"><a
	href="javascript:seleccionar_todo()" class="btn btn-success">Marcar
todos</a> <a href="javascript:deseleccionar_todo()"
	class="btn btn-warning">Desmarcar todos</a></div>
</td></tr>
<?
echo '</table><br />';
}
echo '<input name=nprofe type=hidden value="';
echo $filaprof0[0];
echo '" />';
// Hora escolar
echo '<input name=hora type=hidden value="';
echo $hora_dia;
echo '" />';
// dia de la semana
echo '<input name=ndia type=hidden value="';
echo $ndia;
echo '" />';
// Hoy
echo '<input name=hoy type=hidden value="';
echo $hoy;
echo '" />';
// Codigo asignatura
echo '<input name=codasi type=hidden value="';
echo $codasi;
echo '" />';
// Profesor
echo '<input name=profesor type=hidden value="';
echo $pr;
echo '" />';
// Clave
echo '<input name=clave type=hidden value="';
echo $clave;
echo '" />';
echo '<input name=fecha_dia type=hidden value="';
echo $fecha_dia;
echo '" />';
$gr = mysql_query("select nomunidad from unidades where nomunidad = '$curso'");
if(mysql_num_rows($gr)>0 or $diversificacion==1){echo '<button name="enviar" type="submit" value="Enviar datos" class="btn btn-primary btn-large btn-block"><i class="fa fa-check"> </i> Registrar faltas de asistencia</button>';}

?>

</FORM>
</div>
</div>
<div class="col-md-5">
<br>
<div class="well">
<legend>Selecciona Hora y Día...</legend>
<form action="index.php" method="POST">

<div class="form-group">
<label for="hora_dia">Hora </label> 
<select	class="form-control" id="hora_dia" name="hora_dia" required>
<?
if (isset($_POST['hora_dia'])) {
	echo "<option>".$_POST['hora_dia']."</option>";
}
echo "<option></option>";
for ($i = 1; $i < 7; $i++) {
	echo "<option>$i</option>";
}
?>
</select>
</div>
<div class="form-group">
<label for="fecha_dia">Fecha </label> 
<div class="input-group" >
<input name="fecha_dia" type="text" class="form-control" value="<? echo $fecha_dia;?>" data-date-format="dd/mm/yyyy" id="fecha_dia" required >
<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
 </div> 
<hr>
<button type="submit" class="btn btn-primary btn-block" name="submit">Enviar</button>
</form>
</div>
</div>
</div>
<?
}

else {
	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El módulo de Faltas de Asistencia debe ser activado en la Configuración general de la Intranet para poder accede a estas páginas, y ahora mismo está desactivado.
          </div></div>'; 
	echo "<div style='color:brown; text-decoration:underline;'>Las Faltas han sido registradas.</div>";
}
?> <?
include("../pie.php");
?> 

	<?php  
$inicio = explode('-', $inicio_curso);
$inicio_anio = $inicio[0];
$inicio_mes  = $inicio[1];
$inicio_dia  = $inicio[2];

$fin = explode('-', $fin_curso);
$fin_anio = $fin[0];
$fin_mes  = $fin[1];
$fin_dia  = $fin[2];

$festivos = mysql_query("SELECT fecha FROM festivos");
?>
<script>
$(function ()  {
	var inicio = new Date(<?php echo $inicio_anio; ?>, <?php echo $inicio_mes; ?>-1, <?php echo $inicio_dia; ?>, 0, 0, 0, 0);
	var fin    = new Date(<?php echo $fin_anio; ?>, <?php echo $fin_mes; ?>-1, <?php echo $fin_dia; ?>, 0, 0, 0, 0);
	
	<?php
	$cadena_festivos = '';
	$i=1;
	while ($festivo = mysql_fetch_array($festivos)) {
		$festfecha = explode('-', $festivo['fecha']);
		$festivo_anio = $festfecha[0];
		$festivo_mes  = $festfecha[1];
		$festivo_dia  = $festfecha[2];
		
		echo "var festivo$i = new Date($festivo_anio, $festivo_mes-1, $festivo_dia, 0, 0, 0, 0);";
		
		$cadena_festivos .= " || (date.valueOf() == festivo$i.valueOf())";
		$i++;
	}
	?>
	
	var checkin = $('#fecha_dia').datepicker({
		weekStart: 1,
		onRender: function(date) {
			return (date.valueOf() < inicio.valueOf()) || (date.valueOf() > fin.valueOf()) || (date.getUTCDay() == 5) || (date.getUTCDay() == 6)<?php echo $cadena_festivos; ?> ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
		var newDate = new Date(ev.date);
		newDate.setDate(newDate.getDate() + 1);
		checkout.setValue(newDate);
		checkin.hide();
		$('#finfalta')[0].focus();
	}).data('datepicker');
	
	var checkout = $('#finfalta').datepicker({
		weekStart: 1,
		onRender: function(date) {
			return date.valueOf() <= checkin.date.valueOf() || (date.valueOf() > fin.valueOf()) || (date.getUTCDay() == 5) || (date.getUTCDay() == 6)<?php echo $cadena_festivos; ?> ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
		checkout.hide();
	}).data('datepicker');
});  
</script>

<script>

function seleccionar_todo(){
	for (i=0;i<document.Cursos.elements.length;i++)
		if(document.Cursos.elements[i].type == "checkbox")	
			document.Cursos.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.Cursos.elements.length;i++)
		if(document.Cursos.elements[i].type == "checkbox")	
			document.Cursos.elements[i].checked=0
}
</script>
</body>
</html>
