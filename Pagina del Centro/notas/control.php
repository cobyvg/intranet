<?
session_start();
	include("../conf_principal.php");
	//include("../funciones.php");	
if (isset($_POST['clave'])) {

// Se ha enviado la clave	
$clave = $_POST['clave'];
	
if ($_POST['primaria']==1) {
	$clave_al = $_POST['clave'];
}
else{
	$clave_al = $_POST['user'];
}
	$_SESSION['clave_al'] = $clave_al;
	mysql_connect ($host, $user, $pass);
	mysql_select_db ($db);
	$cod_sha = sha1($clave);
	$claveal_sha = sha1($clave_al);
		
	// Es un alumno de Primaria
	$al_primaria = "SELECT distinct APELLIDOS, NOMBRE, NIVEL, grupo, curso, claveal, unidad, dni, correo, colegio FROM alma_primaria WHERE dnitutor = '$clave_al' or claveal = '$clave_al'";
	//echo $al_primaria;
	$alum_primaria = mysql_query($al_primaria);
	$es_primaria = mysql_num_rows($alum_primaria);
if ($es_primaria > 1) {
include "../cabecera.php"; 
	?>
<br />	
<form name="form1" method="post" action="control.php" class="form-vertical">
<input type="hidden" name="primaria" value="1" />
<br /><div class='well well-large' style='max-width:450px;margin:auto'><legend class="text-info">ATENCIÓN:</legend><p>Hay más de un alumno con ese DNI de Tutor. Selecciona el Alumno en cuya página quieres entrar:</p>
	<?
	while ($row_alma = mysql_fetch_array($alum_primaria)) {
		$claveal = $row_alma[5];
		?> 
		<label class="radio text-info">
		<input type="radio" name="clave" value="<? echo $row_alma[5]; ?>"	onclick="submit()" />
		<? echo $row_alma[1]." ".$row_alma[0]; ?></label>
		<?
	}
	echo "</div>";
	exit();
}	

	$mes = date('m');
	if ($es_primaria > 0 and $mes=='6') {

	$_SESSION['aut']="1";
	$datos = mysql_fetch_array($alum_primaria);	
	$_SESSION['esdeprimaria'] = "1";
	$_SESSION['todosdatos'] = "$datos[1] $datos[0]";
	$_SESSION['alumno'] =  "$datos[0], $datos[1]";
	$_SESSION['curso'] = $datos[4];
	$_SESSION['sen_nivel'] = $datos[4];
	$_SESSION['nivel'] = $datos[2];
	$_SESSION['grupo'] = $datos[3];
	$_SESSION['claveal'] = $datos[5];
	$_SESSION['clave_al'] = $datos[5];
	$_SESSION['unidad'] = $datos[6];
	$_SESSION['dni'] = $datos[7];
	$_SESSION['correo'] = $datos[8];
	$_SESSION['colegio'] = $datos[9];
	registraPagina($_SERVER['REQUEST_URI'],$clave_al);
	header('location:datos.php');
	exit();	
	}
	else
	{
	// Se ha registrado anteriormente
	$alu0 = mysql_query("SELECT control.pass, control.claveal from control, alma WHERE control.claveal=alma.claveal and control.claveal = '$clave_al'");
	$n_pass=mysql_num_rows($alu0);
	$alu00 = mysql_fetch_array($alu0);
	$al1 = "SELECT distinct APELLIDOS, NOMBRE, NIVEL, grupo, curso, claveal, unidad, dni, correo FROM alma WHERE claveal = '$clave_al'";
	//echo $al1;
	$alumno1 = mysql_query($al1);
	$n_al = mysql_num_rows($alumno1);
	//echo $n_al;
	// Contraseñas coinciden: podemos entrar
	if ($alu00[0]===$cod_sha) {
	$_SESSION['aut']="1";
	$alum0 = mysql_fetch_array($alu0);

	$datos = mysql_fetch_row($alumno1);
	$_SESSION['todosdatos'] = "$datos[1] $datos[0]";
	$_SESSION['alumno'] =  "$datos[0], $datos[1]";
	$_SESSION['curso'] = $datos[4];
	$_SESSION['sen_nivel'] = $datos[4];
	$_SESSION['nivel'] = $datos[2];
	$_SESSION['grupo'] = $datos[3];
	$_SESSION['claveal'] = $datos[5];
	$_SESSION['unidad'] = $datos[6];
	$_SESSION['dni'] = $datos[7];
	$_SESSION['correo'] = $datos[8];
	$todosdatos = $_SESSION['todosdatos'];
	$alumno = $_SESSION['alumno'];
	$curso = $_SESSION['curso'];
	$sen_nivel = $_SESSION['sen_nivel'];
	$nivel = $_SESSION['nivel'];
	$grupo = $_SESSION['grupo'];
	$claveal = $_SESSION['claveal'];
	$unidad = $_SESSION['unidad'];
	$dni = $_SESSION['dni'];
	$correo = $_SESSION['correo'];
	//include 'datos.php';
	include("../funciones.php");
	registraPagina($_SERVER['REQUEST_URI'],$clave_al);
	header('location:datos.php');
	exit();
	}
	
	// Alumno del Centro y contraseña mal escrita
	elseif ($n_pass>0 and $alu00[0]!==$cod_sha){
	session_start();
	
	include ("../cabecera.php");
	include ("../menu.php");
	echo '<div class="span9">
	<div class="span8 offset2">
	<div align="center">
	<h3>Acceso privado para los Alumnos del Centro.</h3>
	<hr />';

	echo "<br /><div class='alert alert-error' style='max-width:450px;margin:auto'><legend>Atenci&oacute;n:</legend><p>La <b>Clave del Alumno</b> que estás escribiendo no es correcta. Vuelve atrás e inténtalo de nuevo.</p></div>";
			session_destroy ();
			exit;		
	}
	
	// No se ha registrado
	elseif ($n_al>0 and ($n_pass<>1 or ($cod_sha === $claveal_sha))) {
		// Comprobamos si es alumno del Centro
	$alu1 = mysql_query("SELECT claveal, apellidos, nombre, unidad, nivel, grupo, curso, dni, correo from alma WHERE claveal = '$clave_al'");
		// Si es alumno no registrado lo enviamos a la página de regsitro
	$ya_al = mysql_fetch_array($alu1);
		$_SESSION['clave_al'] = $clave_al;
		$_SESSION['nombre'] = $ya_al[2];
		$_SESSION['apellidos'] = $ya_al[1];
		$_SESSION['unidad'] = $ya_al[3];
		$_SESSION['todosdatos'] = $_SESSION['nombre']." ". $_SESSION['apellidos'];
		$_SESSION['alumno'] = $ya_al[1].", ". $ya_al[2];
		$_SESSION['sen_nivel'] = $ya_al[6];
		$_SESSION['nivel'] = $ya_al[4];
		$_SESSION['grupo'] = $ya_al[5];
		$_SESSION['dni'] = $ya_al[7];
		$_SESSION['correo'] = $ya_al[8];
		$todosdatos = $_SESSION['todosdatos'];
		$alumno = $_SESSION['alumno'];
		$curso = $_SESSION['curso'];
		$sen_nivel = $_SESSION['sen_nivel'];
		$nivel = $_SESSION['nivel'];
		$grupo = $_SESSION['grupo'];
		$claveal = $_SESSION['claveal'];
		$unidad = $_SESSION['unidad'];
		$dni = $_SESSION['dni'];
		$correo = $_SESSION['correo'];
		include ("clave.php");
		exit ();
		}

		// No es alumno del Centro o no conoce claveal
		elseif (mysql_num_rows($alu0)==0 and $n_al==0)  {
			session_start();
			include ("../cabecera.php");
			include ("../menu.php");
			echo '<div class="span9">
<div class="span8 offset2">
<div align="center">
<h3>Acceso privado para los Alumnos del Centro.</h3>
<hr />';
			echo "<br /><div class='alert alert-error' style='max-width:450px;margin:auto'><legend>Atenci&oacute;n:</legend><p>Debes introducir una <b>Clave del Centro</b> válida para entrar en estas páginas. Si eres alumno de este Centro, <em>debes conseguir tu clave de acceso a través del Tutor, Administración o Jefatura de Estudios del Centro</em> para poder entrar en estas páginas</p></div>";
			session_destroy ();
			exit;
		}
	}
}
?>


