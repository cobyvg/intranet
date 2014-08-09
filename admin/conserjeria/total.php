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



if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Páginas de Conserjería</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css">
</head>
  <body onload="document.getElementById('n_numero').style.backgroundColor='#cde';document.getElementById('n_total').style.backgroundColor='#afc';
document.getElementById('n_numero').style.border='#aaaaaa solid 1px'; 
document.getElementById('n_numero').focus()">
  <?
  	include("../../menu.php");
  ?>
<div align=center>
  <div class=titulogeneral style="margin:auto;margin-top:25px;margin-bottom:5px;width:500px;">Registro de Fotocopias</div>
</div>
<div align="center">
<?
echo "<table class='tabla'><tr><td id=filasecundaria>Total Depto.</td><td id=filasecundaria>Total Adm.</td><td id=filasecundaria>Total Pers.</td></tr>";
	$t_copia0=mysql_query("select numero from fotocopias where tipo = '3'");
	while ($t_copia=mysql_fetch_array($t_copia0)) {
		$t_copias+=$t_copia[0];
	}
	$t_per0=mysql_query("select numero from fotocopias where tipo = '2'");
	while ($t_per=mysql_fetch_array($t_per0)) {
		$t_pers+=$t_per[0];
	}	
	$t_adm0=mysql_query("select numero from fotocopias where tipo = '1'");
	while ($t_adm=mysql_fetch_array($t_adm0)) {
		$t_admin+=$t_adm[0];
	}
	echo "<tr><td style='color:red;font-weight:bold;text-align:center'> $t_copias </td><td style='color:blue;font-weight:bold;text-align:center;'>$t_admin</td><td style='color:green;font-weight:bold;text-align:center;'>$t_pers</td></tr>";
	echo "</table>";
	
echo "<table class='tabla'><tr><td id=filasecundaria>Profesor</td><td id=filasecundaria>Total Depto.</td><td id=filasecundaria>Trabajos Depto.</td><td id=filasecundaria>Total Adm.</td><td id=filasecundaria>Trabajos Adm.</td><td id=filasecundaria>Total Pers.</td><td id=filasecundaria>Trabajos Pers.</td></tr>";
$num0=mysql_query("select distinct nombre from departamentos where nombre not like 'admin' order by nombre");
while ($num=mysql_fetch_array($num0)) {
	$total_copias="";
	$total_veces="";
	$total_admin="";
	$totala_veces="";
	$total_per="";
	$totalp_veces="";
	$t_copias="";
	$t_admin="";
	$t_pers="";
	$num_profe0=mysql_query("select numero from fotocopias where nombre = '$num[0]' and tipo = '3'");
	while ($num_profe=mysql_fetch_array($num_profe0)) {
		$total_copias+=$num_profe[0];
		$n_veces=mysql_query("select nombre from fotocopias where nombre = '$num[0]' and tipo = '3'");
		$total_veces=mysql_num_rows($n_veces);
	}
	$num_profe1=mysql_query("select numero from fotocopias where nombre = '$num[0]' and tipo='1'");
	while ($admin_profe=mysql_fetch_array($num_profe1)) {
		$total_admin+=$admin_profe[0];
		$na_veces=mysql_query("select nombre from fotocopias where nombre = '$num[0]' and tipo = '1'");
		$totala_veces=mysql_num_rows($na_veces);
		}
	$num_profe2=mysql_query("select numero from fotocopias where nombre = '$num[0]' and tipo='2'");
	while ($per_profe=mysql_fetch_array($num_profe2)) {
		$total_per+=$per_profe[0];
		$np_veces=mysql_query("select nombre from fotocopias where nombre = '$num[0]' and tipo = '2'");
		$totalp_veces=mysql_num_rows($np_veces);
		}	
		
		if ($totala_veces=="0") {$totala_veces="";}
		if ($total_copias >'0' or $total_admin > '0' or $total_per > '0') {
	echo "<tr><td>$num[0]</td><td style='color:brown;font-weight:bold;text-align:center;background-color:#eef;'> $total_copias </td><td style='color:brown;text-align:center;'>$total_veces</td><td style='color:blue;font-weight:bold;text-align:center;background-color:#efe;'>$total_admin</td><td style='color:blue;text-align:center;'>$totala_veces</td><td style='color:green;font-weight:bold;text-align:center;background-color:#fee;'>$total_per</td><td style='color:green;text-align:center;'>$totalp_veces</td></tr>";			
		}
}
echo "</table>";




echo "<table class='tabla'><tr><td id=filasecundaria>Departamento</td><td id=filasecundaria>Total Depto.</td></tr>";
$numd0=mysql_query("select distinct departamento from departamentos where nombre not like 'admin' order by departamento");
while ($numd=mysql_fetch_array($numd0)) {
	$totald_copias="";
	$num_profed0=mysql_query("select numero from fotocopias, departamentos where departamentos.nombre = fotocopias.nombre and departamento = '$numd[0]' and tipo = '3'");
//	echo "select numero from fotocopias, departamentos where departamentos.nombre = fotocopias.nombre and departamento = '$numd[0]' and tipo = '3'<br>";
	while ($num_profed=mysql_fetch_array($num_profed0)) {
		$totald_copias+=$num_profed[0];
	}
		
		if ($totald_copias >'0') {
	echo "<tr><td>$numd[0]</td><td style='color:brown;font-weight:bold;text-align:center;background-color:#eef;'> $totald_copias </td></tr>";			
		}
}


echo "</table>";
?>
<br>
<a href="index.php" style="color:#261;font-size:1.0em;word-spacing:1px;border:1px solid #aaa;background-color:#feb;padding:5px 15px;">Volver al Registro de Fotocopias</a>
</div>
</body>
</html>