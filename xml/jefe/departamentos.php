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
<?php
include("../../menu.php");
?>
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Administración <small> Departamentos del Centro</small></h2>
</div>
<br />
<div class="well well-large" style="width:700px;margin:auto;text-align:left">
<?
if(isset($_FILES['archivo'])){  
mysql_connect ($db_host, $db_user, $db_pass) or die("Error de conexión");
mysql_select_db($db);
// BacKup de la tabla
mysql_query("drop table departamentos_seg");
mysql_query("create table departamentos_seg select * from departamentos");
 
 //  Estructura de tabla para la tabla `departamento_temp`
mysql_query("drop table departamento_temp");	
mysql_query("CREATE TABLE IF NOT EXISTS `departamento_temp` (
  `NOMBRE` varchar(48) NOT NULL default '',
  `DNI` varchar(10) NOT NULL default '',
  `DEPARTAMENTO` varchar(48) NOT NULL default '',
  `CARGO` varchar(16) default NULL,
  `IDEA` varchar(12) NOT NULL default '',
   KEY `NOMBRE` (`NOMBRE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE latin1_spanish_ci");

if(isset($_POST['actualizar'])){	
}
else{
 $base0 = "delete from departamentos where idea not like 'admin' and departamento not like 'Administracion' and departamento not like 'Conserjeria' and cargo not like '%1%'";
  mysql_query($base0);
}
 

// Importamos los datos del fichero CSV 
$handle = fopen ($_FILES['archivo']['tmp_name'] , "r" ) or die('<br /><div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido abrir el archivo RelPerCen.txt. O bien te has olvidado de enviarlo o el archivo está corrompido.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div><br />'); 
while (($data1 = fgetcsv($handle, 1000, "|")) !== FALSE) 
{
$dep_mod = trim($data1[2]);
$dep_mod = str_replace("(Inglés)","",$dep_mod);
$dep_mod = str_replace("(Francés)","",$dep_mod);
$dep_mod = str_replace("(Alemán)","",$dep_mod);
$dep_mod = str_replace("P.E.S.","",$dep_mod);
$dep_mod = str_replace(" P.T.F.P","",$dep_mod);
$dep_mod = str_replace("(Secundaria)","",$dep_mod);
$dep_mod = trim($dep_mod);
$datos1 = "INSERT INTO departamento_temp (NOMBRE, DNI, DEPARTAMENTO, IDEA) VALUES (\"". trim($data1[0]) . "\",\"". trim($data1[1]) . "\",\"". $dep_mod . "\",\"". trim($data1[6]) . "\")";
mysql_query($datos1);
}
fclose($handle);
$borrarvacios = "delete from departamento_temp where DNI = ''";
mysql_query($borrarvacios);
$borrarpuesto = "delete from departamento_temp where DEPARTAMENTO LIKE '%Puesto%'";
mysql_query($borrarpuesto);
// Eliminar duplicados e insertar nuevos
$elimina = "select distinct NOMBRE, DNI, DEPARTAMENTO, IDEA from departamento_temp where dni NOT IN (select distinct dni from departamentos where departamento not like '%Conserjeria%' and departamento not like 'Administracion' and idea not like 'admin')";
$elimina1 = mysql_query($elimina);
 if(mysql_num_rows($elimina1) > 0)
{
echo "<div class='control-group success'><p class='help-block' style='text-align:left'>
Tabla Departamentos: los siguientes Profesores han sido añadidos a la tabla. <br>Comprueba los registros creados:</p></div>";
while($elimina2 = mysql_fetch_array($elimina1))
{
echo "<li>".$elimina2[0] . " -- " . $elimina2[1] . " -- " . $elimina2[2] . "</li>";
  $SQL6 = "insert into departamentos  (NOMBRE, DNI, DEPARTAMENTO, IDEA) VALUES (\"". $elimina2[0] . "\",\"". $elimina2[1] . "\",\"". $elimina2[2] . "\",\"". $elimina2[3] . "\")";
  $result6 = mysql_query($SQL6);
}
echo "<br />";
}
else {
	echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Tabla <strong>Departamentos</strong>: No se ha añadido ningún registro a la tabla.
</div></div><br />';
	}

// Actualizamos nombre de los depratmentos en la tabla y tablas relacionadas
include("actualiza_dep.php");
// Registramos los tutores desde FTUTORES
$tut0=mysql_query("select distinct tutor from FTUTORES");
while($tut=mysql_fetch_array($tut0))
{
$cargo0=mysql_query("select cargo from departamentos where nombre = '$tut[0]'");
$cargo1=mysql_fetch_array($cargo0);
$cargo_tutor="2".$cargo1[0];
if(strstr($cargo1[0],"2")==TRUE){}else{
mysql_query("update departamentos set cargo = '$cargo_tutor' where  nombre='$tut[0]'");
}
}
// Usuario
  // Actualización de IDEA de los Profesores del Centro.
$SQL1 = "select distinct nombre, dni, idea from departamentos where nombre NOT IN (select distinct profesor from c_profes) and departamento not like '%Conserjeria%' and departamento not like 'Administracion' and idea not like 'admin'";
$result1 = mysql_query($SQL1);
$total = mysql_num_rows($result1);
if ($total !== 0)
{
	echo "<div class='control-group success'><p class='help-block' style='text-align:left'>Tabla <strong>c_profes</strong>: los nuevos Profesores han sido añadidos a la tabla de usuarios de la Intranet. <br>Comprueba en la lista de abajo los registros creados:</p></div>";
while  ($row1= mysql_fetch_array($result1))
 {
$SQL2 = "INSERT INTO c_profes (profesor, dni, pass, idea) VALUES (\"". $row1[0]. "\",\"". $row1[1] . "\",\"". $row1[1] . "\",\"". $row1[2] . "\")";
echo "<li>".$row1[0] . "</li>";
$result2 = mysql_query($SQL2);
}
echo "<br />";
}

mysql_query("drop table departamento_temp");

//------------------------------------------------------------------------------------------------------------
//  Profesores TIC
	$borrar = "truncate table usuarioprofesor";
	mysql_query($borrar);
// Primera parte, trabajamos sobre alma, que se actualiza regularmente.
$profesores = "select distinct nombre, idea from departamentos";
$sqlprof = mysql_query($profesores);
while ($sqlprof0 = mysql_fetch_array($sqlprof)) {
	$nombreorig = $sqlprof0[0];
	$usuario = $sqlprof0[1];
	$insertar = "insert into usuarioprofesor set nombre = '$nombreorig', usuario = '$usuario', perfil = 'p'";
	mysql_query($insertar);
}
$repetidos = mysql_query("select usuario from usuarioprofesor");
while($num = mysql_fetch_row($repetidos))
{
$n_a = "";
$repetidos1 = mysql_query("select usuario, nombre from usuarioprofesor where usuario = '$num[0]'");
if (mysql_num_rows($repetidos1) > 1) {
while($num1 = mysql_fetch_row($repetidos1))
{
$n_a = $n_a +1;
$nuevo = $num1[0].$n_a;
mysql_query("update usuarioprofesor set usuario = '$nuevo' where nombre = '$num1[1]'");
}	
}
}
mysql_query("delete from usuarioprofesor where usuario like 'pprofesor%'");
// Archivo de exportacion para Gesuser.
$codigo = "select  usuario, nombre, perfil from usuarioprofesor";
//echo $codigo . "<br>";
$sqlcod = mysql_query ($codigo);
while($rowprof = mysql_fetch_array($sqlcod))
{
$lineaprof = "$rowprof[0];$rowprof[1];$rowprof[2];\n";
$todoprof .= $lineaprof;
}
 if (!(file_exists("TIC/profesores.txt")))
{
$fpprof=fopen("TIC/profesores.txt","w+");
 }
 else
 {
 $fpprof=fopen("TIC/profesores.txt","w+") or die('<br /><div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido escribir en el archivo TIC/profesores.txt. ¿Has concedido permiso de escritura en ese directorio?
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>'); 
 }
 $pepito=fwrite($fpprof,$todoprof);
 fclose ($fpprof);
 echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos de los profesores se han importado correctamente en la tabla <strong>usuarioprofesor</strong>.<br> Se ha generado un fichero (profesores.txt) en el subdirectorio "xml/jefe/TIC/" preparado para el alta masiva en el Servidor TIC.
</div></div><br />';
 
// Moodle
$codigo1 = "select  c_profes.idea, c_profes.dni, c_profes.profesor, correo from c_profes, departamentos where c_profes.idea = departamentos.idea";
$sqlcod1 = mysql_query ($codigo1);
$todos_moodle="username;password;firstname;lastname;email;city;country\n";
while($rowprof = mysql_fetch_array($sqlcod1))
{
if (!($rowprof[0]=='admin') and !($rowprof[0]=='conserje') and !($rowprof[4]=='7')) {
		$n_pro = explode(", ",$rowprof[2]);
$nombre_profe = $n_pro[1];	
$apellidos_profe = $n_pro[0];

$linea_moodle = "$rowprof[0];$rowprof[1];$nombre_profe;$apellidos_profe;$rowprof[3];Estepona;ES\n";
$todos_moodle.=$linea_moodle;
	}
}

 if (!(file_exists("TIC/profesores_moodle.txt")))
{
$fpprof1=fopen("TIC/profesores_moodle.txt","w+");
 }
 else
 {
 $fpprof1=fopen("TIC/profesores_moodle.txt","w+") or die('<br /><div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido escribir en el archivo TIC/profesores.txt. ¿Has concedido permiso de escritura en ese directorio?
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>'); 
 }
 $pepito1=fwrite($fpprof1,$todos_moodle);
 fclose ($fpprof1);
 echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
 Se ha generado un fichero (profesores_moodle.txt) en el subdirectorio "xml/jefe/TIC/" preparado para el alta masiva de usuarios en la Plataforma Moodle.
</div></div><br />'; 
}
else{
	echo '<br /><div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Parece que te está olvidando de enviar el archivo con los datos de los Profesores. Asegúrate de enviar el archivo descargado desde Séneca.
</div></div><br />';
}
?>
<br />
<div align="center">
<input type="button" value="Volver atrás" name="boton" onclick="history.back(2)" class="btn btn-inverse" />
</div>
</div>
</body>
</html>