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
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?
include("../../menu.php");
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
	$g_dia = date('d')+$dif;
 } 
 if ($n_dia < $numerodiasemana) {
	$dif = $numerodiasemana - $n_dia;
	$g_dia = date('d')-$dif;
 } 
 if ($n_dia == $numerodiasemana) {
 	$dif = 0;
 }
 	$g_fecha = date("Y-m-$g_dia");
 	$fecha_sp = formatea_fecha($g_fecha);
?>

<div align=center>
 <div class="page-header" align="center" style="margin-top:-15px">
  <h1>Guardias de Aula <small> Registro de guardias<br />Fecha de la guardia: <span style="color:#9d261d;"><? echo $fecha_sp;?></span><br />
Profesor de guardia: <span style='color:#08c;'><? echo $profeso;?></small></h1>
</div>
<br />

</div><br />
<?
$sql = "SHOW TABLES FROM $db";
$result = mysql_query($sql);

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

if ($submit2) {
	$fecha_guardia = explode("-",$gu_fecha);
	$g_dia = $fecha_guardia[0];
	$g_mes = $fecha_guardia[1];
	$g_ano = $fecha_guardia[2];
	$g_fecha = "$g_ano-$g_mes-$g_dia";
	$n_dia = date('w', mktime(0,0,0,$g_mes,$g_dia,$g_ano));
	if (!(empty($sustituido))) {
		
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
			exit();
		}

		
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
$sustituido.' ya ha sido sustituido a la $hora hora el día '.$fecha_reg.'. <br>Selecciona otro profesor y continúa.
          </div></div>';
exit();
			}
		if (!($c1) > '0') {				 	
			$r_profe = mb_strtoupper($profeso, "ISO-8859-1");
			mysql_query("insert into guardias (profesor, profe_aula, dia, hora, fecha, fecha_guardia) VALUES ('$r_profe', '$sustituido', '$n_dia', '$hora', NOW(), '$g_fecha')");
			if (mysql_affected_rows() > 0) {
				echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Has registrado correctamente a '.$sustituido.' a '.$hora.' hora para sustituirle en el Aula.
          </div></div>';
			}	
		}


	}
	else{
		echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No has seleccionado a ningún profesor para sustituir. Elige uno de la lista desplegable para registrar esta hora.
          </div></div>';
		}
}
?>
<? include("../../pie.php");?>
</BODY>
</HTML>
