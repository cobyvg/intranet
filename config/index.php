<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="iso-8859-1">
<title>Configuración de la Intranet</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Intranet del http://<? echo $nombre_del_centro;?>/">
<meta name="author" content="">

<link href="../css/bootstrap.css" rel="stylesheet">
<? if($_SERVER ['REQUEST_URI'] == "/intranet/index0.php"){?>
<link href="../css/otros_index.css" rel="stylesheet"><?	}	else{ ?><link href="../css/otros.css" rel="stylesheet"><?}?>
<link href="../css/bootstrap-responsive.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>  
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>  
    <![endif]-->
<script language="javascript">
function activarMod_faltas() {
	var elemHorario = document.getElementById("mod_horario") ;
	var elemFaltas = document.getElementById("mod_faltas") ;
	
	 if (elemHorario.checked == true) {
		elemFaltas.disabled = false ;
	}
	else {
		elemFaltas.disabled = true ;
	}
	
}
function activarMod_sms() {
	var usuario_sms = document.getElementById("usuario_smstrend") ;
	var clave_sms = document.getElementById("clave_smstrend") ;
	var sms = document.getElementById("mod_sms") ;
	
	 if (sms.checked == false) {
		usuario_sms.disabled = true ;
		clave_sms.disabled = true ;
	}
	else {
		usuario_sms.disabled = false ;
		clave_sms.disabled = false ;
	}
	
}
</script>
</head>
<body>
<?php		
if (strlen($_SESSION['mens_error']) > 10) {
	echo $_SESSION['mens_error'];
	$_SESSION['mens_error'] = "";
}
if ($_POST['enviar'] or $_POST['num_carrito'] or $_POST['num_aula'] or $_POST['num_medio'])
{	
if(!(file_exists("../config.php")) OR filesize("../config.php")<10)
{
$primera = "1";
}
if(!(empty($_POST['db']) or empty($_POST['db_reservas']) or empty($_POST['db_host']) or empty($_POST['db_user']) or empty($_POST['db_pass']) or empty($_POST['dominio']) or empty($_POST['nombre_del_centro']) or empty($_POST['codigo_del_centro']) or empty($_POST['email_del_centro']) or empty($_POST['director_del_centro']) or empty($_POST['jefatura_de_estudios']) or empty($_POST['secretario_del_centro']) or empty($_POST['direccion_del_centro']) or empty($_POST['localidad_del_centro']) or empty($_POST['codigo_postal_del_centro']) or empty($_POST['telefono_del_centro']) or empty($_POST['curso_actual']) or empty($_POST['inicio_curso']) or empty($_POST['fin_curso'])))
{	
$db = $_POST['db'];
$db_reservas = $_POST['db_reservas'];
$db_host = $_POST['db_host'];
$db_user = $_POST['db_user'];
$funcion = '
mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db);
function registraPagina($pagina,$host,$user,$pass,$base)
{
mysql_connect ($host, $user, $pass);
mysql_select_db ($base);
$id_reg = $_SESSION[\'id_pag\'];
mysql_query("insert into reg_paginas (id_reg,pagina) values (\'$id_reg\',\'$pagina\')");	
}
';
$f1=fopen("../config.php","w+");
?>
<?			
if($f1==FALSE){
	echo '<br /><br /><div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
No es posible crear o abrir el archivo de configuración.<br>
Esto quiere decir que no le has concedido permiso de escritura al directorio donde has colocado la Intranet, y es un requisito necesario para el funcionamiento de la aplicación. Debes permitir la escritura en ese directorio o la aplicación no podrá funcionar.
          </div><br /><input type="button" value="Volver atrás" name="boton" onClick="history.back(1)" class="btn btn-inverse" /></div>';
	exit();
}
else{

include 'escribe_archivo.php';
}
if($primera == "1"){
// Comprobamos estado de las Bases de datos para saber si podemos ofrecer el botón de creación de las mismas o bien ya han sido creadas
mysql_connect($db_host, $db_user, $db_pass);
$hay_bd = mysql_select_db($db);
if ($hay_bd) {
$hay_tablas = mysql_list_tables($db);
if (mysql_num_rows($hay_tablas) == 0) {
	$no_tablas = '1';
} 
}
else{
	$no_tablas ='1';
}	

// Si no hay bases de datos o bien estas no contiene tablas...
if($no_tablas=="1")
{
$form = "<br /><div class='well-2' align='center' style='width:500px;margin:auto'>Es el momento de crear o reparar la Base de datos y la estructura de las Tablas. <br />Presiona el botón para proceder."; 
$form.= '<form enctype="multipart/form-data" action="crea_tablas.php" method="post">';
$form.= '<br /><input  type="submit" name="bdatos" value="Crear Bases de Datos y Tablas" class="btn btn-primary" />';
$form.= '</form></div><br />';
}
}
}
else{
$mens = '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
Todos los campos marcados con (<span style="color:#9d261d">*</span>) en el formulario son obligatorios. <br>Escribe los datos en los campos vacíos y envíalos de nuevo
          </div></div>';
}
$mens = '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han guardado correctamente en el archivo de configuración de la aplicación.     
</div></div>';
} // Final de envío de datos


if(file_exists("../config.php") AND filesize("../config.php")>10)
{
include("../config.php");
$admin=mysql_query("select * from departamentos, c_profes where profesor=nombre and profesor='admin'");
$hay_admin = mysql_num_rows($admin);
if($hay_admin>0)
{
}
else{
	$adm=sha1("12345678");
	mysql_query("INSERT INTO c_profes ( `pass` , `PROFESOR` , `dni`, `idea` ) VALUES ('$adm', 'admin', '12345678', 'admin');");
	mysql_query("insert into departamentos (nombre, dni, departamento, cargo, idea) values ('admin', '12345678', 'Admin', '1', 'admin')");
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
if (!($primera=="1")) {
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit();	
}
}
}
?>
<? 
}
include 'tabla.php';
include("../pie.php");
?>
</body>
</html>
