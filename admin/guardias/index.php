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

if (isset($_GET['n_dia'])) {$n_dia = $_GET['n_dia'];}elseif (isset($_POST['n_dia'])) {$n_dia = $_POST['n_dia'];}else{$n_dia="";}
if (isset($_GET['hora'])) {$hora = $_GET['hora'];}elseif (isset($_POST['hora'])) {$hora = $_POST['hora'];}else{$hora="";}
if (isset($_GET['profeso'])) {$profeso = $_GET['profeso'];}elseif (isset($_POST['profeso'])) {$profeso = $_POST['profeso'];}else{$profeso="";}
if (isset($_GET['h_profe'])) {$h_profe = $_GET['h_profe'];}elseif (isset($_POST['h_profe'])) {$h_profe = $_POST['h_profe'];}else{$h_profe="";}
if (isset($_GET['borrar'])) {$borrar = $_GET['borrar'];}elseif (isset($_POST['borrar'])) {$borrar = $_POST['borrar'];}else{$borrar="";}
if (isset($_GET['submit'])) {$submit = $_GET['submit'];}elseif (isset($_POST['submit'])) {$submit = $_POST['submit'];}else{$submit="";}
if (isset($_GET['sustituido'])) {$sustituido = $_GET['sustituido'];}elseif (isset($_POST['sustituido'])) {$sustituido = $_POST['sustituido'];}else{$sustituido="";}
if (isset($_GET['historico'])) {$historico = $_GET['historico'];}elseif (isset($_POST['historico'])) {$historico = $_POST['historico'];}else{$historico="";}


if ($n_dia == '1') {$nombre_dia = 'Lunes';}
if ($n_dia == '2') {$nombre_dia = 'Martes';}
if ($n_dia == '3') {$nombre_dia = 'Miércoles';}
if ($n_dia == '4') {$nombre_dia = 'Jueves';}
if ($n_dia == '5') {$nombre_dia = 'Viernes';}
$mes=date('m');
$dia_n = date('d');
$ano = date('Y');
$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia_n,$ano));
if ($n_dia > $numerodiasemana) {
	$dif = $n_dia - $numerodiasemana;
	$dif2 = $numerodiasemana-$n_dia;
	$g_dia = date('d')+$dif;
 } 
 if ($n_dia < $numerodiasemana) {
	$dif = $numerodiasemana - $n_dia;
	$dif2 = $numerodiasemana - $n_dia;	
	$g_dia = date('d')-$dif;
 } 
 if ($n_dia == $numerodiasemana) {
 	$dif = 0;
 	$g_dia = date('d');
 }
 	$g_fecha = date("Y-m-$g_dia");
 	$fecha_sp = formatea_fecha($g_fecha);
?>
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Guardias de Aula <small> Registro de guardias</small></h2>
</div>

  <h3 class="text-info"><? echo $nombre_dia.", ".$fecha_sp.", $hora"."ª hora";?></h3><br />

<?
if ($borrar=='1') {
	mysql_query("delete from guardias where id='$id'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La sustitución ha sido borrada correctamente.
</div></div>';
}

$sql = "SHOW TABLES FROM $db";
$result = mysql_query($sql);
$guardia="";
while ($row = mysql_fetch_row($result)) {
    $guardia.=$row[0].";";
}
if (strstr($guardia,"guardias") == FALSE) {
mysql_query("CREATE TABLE `guardias` (
  `id` int(11) NOT NULL auto_increment,
  `profesor` varchar(64) NOT NULL default '',
  `profe_aula` varchar(64) NOT NULL default '',
  `dia` tinyint(1) NOT NULL default '0',
  `hora` tinyint(1) NOT NULL default '0',
  `fecha` datetime NOT NULL default '0000-00-00 00:00:00',
  `fecha_guardia` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 AUTO_INCREMENT=16");	
}

if ($submit) {
	
	if (!(empty($sustituido))) {
		
					if (isset($dif2) and $dif2 > '1') {
						echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Estás intentando registrar una sustitución con dos días o más de diferencia respecto a la fecha de la Guardia, y eso no es posible. Si por motivo justificado necesitas hacerlo, ponte en contacto con algún miembro del Equipo Directivo.
</div></div>';

 	}
 	else{
		
		$fech_hoy = date("Y-m-d");
		$reg_sust0 = mysql_query("select id, profesor, profe_aula, hora, fecha from guardias where dia = '$n_dia' and hora = '$hora' and date(fecha_guardia) = '$g_fecha' and (profesor = '$profeso' or profe_aula = '$sustituido')");
		
		$fech_hoy = date("Y-m-d");			
// echo "Guardia: $prof_sust --> Sustituido: $sustituido --> Registrado: $prof_reg";
		$reg_sust0 = mysql_query("select id, profesor, profe_aula, hora, fecha_guardia from guardias where dia = '$n_dia' and hora = '$hora' and date(fecha_guardia) = '$g_fecha' and profesor = '$profeso'");
			if (mysql_num_rows($reg_sust0) > '0') {
		$c1 = "1";
		$reg_sust = mysql_fetch_array($reg_sust0);
		$id= $reg_sust[0];
		$prof_sust= $reg_sust[1];
		$prof_reg= $reg_sust[2];
		$hor_reg = $reg_sust[3];
		$fecha_reg0 = explode(" ",$reg_sust[4]);
		$fecha_reg = $fecha_reg0[0];
			mysql_query("update guardias set profe_aula = '$sustituido' where id = '$id'");
			echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Has actualizado correctamente los datos del Profesor que sustituyes.
</div></div>';
		}		
		else{
			
		$reg_sust0 = mysql_query("select id, profesor, profe_aula, hora, fecha_guardia from guardias where dia = '$n_dia' and hora = '$hora' and date(fecha_guardia) = '$g_fecha' and profe_aula = '$sustituido'");
			if (mysql_num_rows($reg_sust0) > '0') {
		$c1 = "2";
		$reg_sust = mysql_fetch_array($reg_sust0);	
		$id= $reg_sust[0];
		$prof_sust= $reg_sust[1];
		$prof_reg= $reg_sust[2];
//		$hor_reg = $reg_sust[3];
		$fecha_reg0 = explode(" ",$reg_sust[4]);
		$fecha_reg = $fecha_reg0[0];
		echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>'.
$sustituido .'ya ha sido sustituido a la '.$hora.' hora el día '.$fecha_reg.'. Selecciona otro profesor y continúa.
</div></div>';
			}	
			else{
			
		if (!($c1) > '0') {				 	
			$r_profe = mb_strtoupper($profeso, "ISO-8859-1");
			mysql_query("insert into guardias (profesor, profe_aula, dia, hora, fecha, fecha_guardia) VALUES ('$r_profe', '$sustituido', '$n_dia', '$hora', NOW(), '$g_fecha')");
			if (mysql_affected_rows() > 0) {
				echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Has registrado correctamente a '.$sustituido.' a '.$hora.' hora para sustituirle en al Aula.
</div></div>';
			}	
		}				
			}
			
		}
	}
}
else{
	echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No has seleccionado a ningún profesor para sustituir. Elige uno de la lista desplegable para registrar esta hora.
</div></div>';
}
}	

$fech_hoy = date("Y-m-d");
$hoy0 = mysql_query("select id, profesor, profe_aula, hora, fecha from guardias where dia = '$n_dia' and hora = '$hora' and date(fecha_guardia) = '$g_fecha'");
if (mysql_num_rows($hoy0) > 0) {
	echo '<div class="well-transparent well-large" style="width:600px;">';
	echo "<legend class='text-warning'>Sustituciones registradas para la Guardia de hoy</legend>";
	echo '<table class="table table-striped" align=center style="">';
	echo "<tr><th>Profesor de Guardia</th><th>Profesor ausente</th></tr>";
	while ($hoy = mysql_fetch_array($hoy0)) {
			echo "<tr><td>$hoy[1]</td><td style='color:#bd362f'>$hoy[2]</td></tr>";
	}
	echo "</table></div>";
}
?>
<div class="well-transparent well-large" style="width:600px;">
<legend class='text-warning'>Sustituciones realizadas durante la <? echo "<span style=''>".$hora."ª</span>";?> hora del <? echo "<span style=''>$nombre_dia</span>";?></legend>
<div class="row-fluid" align="center">
<div class="span6">
<?
echo '<table class="table table-striped" align="center">';
$h_gu0= mysql_query("select prof from horw where dia = '$n_dia' and hora = '$hora' and a_asig = 'GU'");

while ($h_gu = mysql_fetch_array($h_gu0)) {
	echo "<tr><td>";
		echo "<a href='index.php?historico=1&profeso=$profeso&h_profe=$h_gu[0]&n_dia=$n_dia&hora=$hora#marca' style='font-size:0.9em'>$h_gu[0]</a></td>";

	echo "<td>";
	$num_g0=mysql_query("select id from guardias where profesor = '$h_gu[0]' and dia = '$n_dia' and hora = '$hora'");
	$ng_prof = mysql_num_rows($num_g0);
	echo $ng_prof;
	echo "</td>";
	echo "</tr>";
}
echo "</table>";
?>
</div>
<div class="span6">
<div class="well-transparent well-large">
<form action="index.php" method="POST">
<label>Selecciona el Profesor que vas a cubrir
<select name="sustituido" class="span12">
<option></option>
<?
$sust0 = mysql_query("select distinct prof from horw where dia = '$n_dia' and hora = '$hora' and a_asig not like 'GU' and a_grupo not like '' order by prof");
while ($sust = mysql_fetch_array($sust0)) {
	echo "<option>$sust[0]</option>";
}
?>
</select>
</label>
<input type="hidden" name="profeso" value="<? echo $profeso;?>">
<input type="hidden" name="n_dia" value="<? echo $n_dia;?>">
<input type="hidden" name="hora" value="<? echo $hora;?>">
<br /><input type="submit" name="submit" class="btn btn-primary" value="Registrar sustitución del Profesor" />
</form>
</div>
</div>
</div>
</div>
<?
if ($historico == '1') {
	if (stristr($_SESSION['cargo'],'1') == TRUE) {
		$extra = "";
		$extra1 = " en este Curso Escolar";
	}
	else{
		$extra = " and hora = '$hora' and dia = '$n_dia'";
		$extra1 = " a ".$hora."ª hora del ".$nombre_dia;		
	}
	echo '<a name="marca"></a>
<div class="well-transparent well-large" style="width:600px;">';
$h_hoy0 = mysql_query("select id, profesor, profe_aula, hora, fecha_guardia from guardias where profesor = '$h_profe' $extra");
if (mysql_num_rows($h_hoy0) > 0) {
	echo "<legend class='text-warning'>Sustituciones realizadas $extra1:<br /><span style=''>$h_profe</span></legend>";
	echo '<table class="table table-striped" align="center" style="width:600px;">';
	echo "<tr><th>Profesor Ausente</th><th>Fecha de la Guardia</th><th></th></tr>";
	while ($h_hoy = mysql_fetch_array($h_hoy0)) {
		 	$fecha_sp = formatea_fecha($h_hoy[4]);
			echo "<tr><td>$h_hoy[2]</td><td>$fecha_sp</td>
			<td>";
			if ($h_profe==$_SESSION['profi']) {
			echo "<a href='index.php?id=$h_hoy[0]&borrar=1&profeso=$profeso&n_dia=$n_dia&hora=$hora' style='margin-top:5px;color:brown;'><i class='icon icon-trash' title='Borrar'> </i> </a>";				
			}
			echo "</td></tr>";
	}
	echo "</table></div>";
}
}
?>
<? include("../../pie.php");?>
</BODY>
</HTML>
