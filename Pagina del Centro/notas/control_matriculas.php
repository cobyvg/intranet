<?
function control($contra)
{
	if(!(is_numeric(substr($contra,3,2))))
	{
		include ("../menu.php");
		echo "<div class='span9'><br /><br /><div class='alert alert-warning' style='max-width:450px;margin:auto'><h4>ATENCI&Oacute;N:</h4> Parece que tenemos problemas para procesar tu c&oacute;digo de acceso. O bien te has equivocado al introducirlo, o bien debes acudir a la Administraci&oacute;n del Centro para solucionar tu problema. Perdona las molestias.</div></div>";
		exit;
	}
}
if ($frmpass) {
	control($frmpass);
}else {
	control($claveal);
}
include("../conf_principal.php");
include("../funciones.php");
registraPagina($_SERVER['REQUEST_URI'],$frmpass);

if (empty($claveal)) {
	$conditio=" DNI = '$frmpass' or DNITUTOR = '$frmpass' or DNITUTOR2 = '$frmpass'";

}
else{
	$conditio=" claveal = '$claveal'";
	$al_ntro = "1";
}
$frmpass = trim($frmpass);
mysql_connect ($host, $user, $pass);
mysql_select_db ($db);
if ($al_ntro=="1") {
	$al1 = "SELECT distinct APELLIDOS, NOMBRE, NIVEL, GRUPO, curso, claveal
FROM alma WHERE ". $conditio ." ";
	$nuestro="1";
}
else{
//$pri = mysql_query("select claveal from alma_primaria where dni = '$frmpass' or dnitutor = '$frmpass' or dnitutor2 = '$frmpass' or claveal='$frmpass'");
$sec = mysql_query("select claveal from alma_secundaria where dni = '$frmpass' or dnitutor = '$frmpass' or dnitutor2 = '$frmpass' or claveal='$frmpass'");
$ntro = mysql_query("select claveal from alma where dni = '$frmpass' or dnitutor = '$frmpass' or dnitutor2 = '$frmpass' or claveal='$frmpass'");

//if (mysql_num_rows($pri)>0) {
//$al1 = "SELECT distinct APELLIDOS, NOMBRE, NIVEL, GRUPO, curso, claveal
//FROM alma_primaria WHERE ". $conditio ." ";
//}
if (mysql_num_rows($sec)>0) {
$al1 = "SELECT distinct APELLIDOS, NOMBRE, NIVEL, GRUPO, curso, claveal
FROM alma_secundaria WHERE ". $conditio ." ";
}
elseif (mysql_num_rows($ntro)>0){
	$al1 = "SELECT distinct APELLIDOS, NOMBRE, NIVEL, GRUPO, curso, claveal
FROM alma WHERE ". $conditio ." ";
	$nuestro="1";
}
}

//echo $al1;
$alumno1 = mysql_query($al1);
$n_al = mysql_num_rows($alumno1);

if (empty($claveal))
{

if($frmpass == "")
{
	include ("../menu.php");
	echo "<div class='span9'><br /><br /><div class='alert alert-error' style='max-width:450px;margin:auto'><h4>ATENCI&Oacute;N:</h4>Debes introducir una clave válida. Si eres alumno de este Centro, <em>debes registrar tu DNI en la Administración del Instituto</em> para poder entrar en estas páginas</div></div>";
	exit;
}
if($n_al < 1)
{
	include ("../menu.php");
	echo "<div class='span9'><br /><br /><div class='alert alert-warning' style='max-width:450px;margin:auto'><h4>ATENCI&Oacute;N:</h4>La clave de acceso no es válida. Si eres alumno de este Centro, <em>debes registrar tu DNI en la Administración del Instituto</em> para poder entrar en estas páginas</div></div>";
	exit;
}

// Comprobación de padre con varios hijos en el Centro
if ($n_al > 1) {
	?>
<form name="form1" method="post" action="datos.php" class="form-vertical">
<br /><div class='alert alert-info' style='max-width:450px;margin:auto'><h4>ATENCIÓN:</h4>Hay más de un alumno con ese DNI de Tutor. <br>Selecciona el Alumno en cuya página quieres entrar:<br />
	<?
	while ($row_alma = mysql_fetch_array($alumno1)) {
		$claveal = $row_alma[5];
		?> 
		<label class="radio">
		<input type="radio" name="claveal" value="<? echo $claveal; ?>"	onclick="submit()" />
		<? echo $row_alma[1]." ".$row_alma[0]; ?></label>
		<?
	}
	echo "</div>";
	exit();

}

if ($n_al=='1'){	
$al2 = mysql_query("SELECT distinct claveal, nivel FROM alma WHERE DNI = '$frmpass' or DNITUTOR = '$frmpass'");
$cl = mysql_fetch_array($al2);
$claveal = $cl[0];
}

}

