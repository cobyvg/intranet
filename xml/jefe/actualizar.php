<? 
// Buscamos los registros de almafaltas, que es actualizada desde Seneca cuando hay nuevas altas (a traves de intranet/xml/alma.php, y luego de intranet/faltas/almafaltas.php)), que no aparecen en FALUMNOS.
// Creamos versión corta para FALTAS
mysql_query("drop table almafaltas");
mysql_query("CREATE TABLE almafaltas select CLAVEAL, NOMBRE, APELLIDOS, Unidad from alma") or die('<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido crear la tabla <strong>AlmaFaltas</strong> en la base de datos. Ponte en contacto con quien pueda resolver el problema.
</div></div><br /><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');
mysql_query("ALTER TABLE almafaltas ADD PRIMARY KEY (  `CLAVEAL` )");

$elimina = "select distinct FALUMNOS.claveal, FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad from FALUMNOS, almafaltas where FALUMNOS.claveal NOT IN (select distinct claveal from almafaltas)";
$elimina1 = mysql_query($elimina);
if(mysql_num_rows($elimina1) > 0)
{
echo "<br /><div class='form-group success'><p class='help-block' style='text-align:left'>Tabla FALUMNOS: los siguientes alumnos han sido eliminados de la tabla FALUMNOS. <br>Comprueba los registros 
creados:</p></div>";
while($elimina2 = mysql_fetch_array($elimina1))
{
echo "<li>".$elimina2[2] . " " . $elimina2[1] . " -- " . $elimina2[3] . "</li>";
  $SQL6 = "DELETE FROM FALUMNOS where claveal = '$elimina2[0]'";
  $SQL16 = "DELETE FROM usuarioalumno where claveal = '$elimina2[0]'";
  $SQL17 = "DELETE FROM AsignacionMesasTic where claveal = '$elimina2[0]'";
  $result6 = mysql_query($SQL6);
  $result16 = mysql_query($SQL16);
  $result17 = mysql_query($SQL17);
}
}

$SQL1 = "select distinct almafaltas.claveal, almafaltas.apellidos, almafaltas.nombre, almafaltas.unidad from almafaltas, FALUMNOS where almafaltas.claveal NOT IN (select distinct claveal from FALUMNOS)";
$result1 = mysql_query($SQL1);
$total = mysql_num_rows($result1);
if ($total !== 0)
{
echo "<br /><div class='form-group warning'><p class='help-block' style='text-align:left'>Tabla FALUMNOS: los nuevos alumnos han sido añadidos a la tabla FALUMNOS. <br>Comprueba en la lista de abajo los registros 
creados:</p></div>";
while  ($row1= mysql_fetch_array($result1))
 {
// Buscamos el ultimo numero del Grupo del Alumno
$SQL3 = "select MAX(NC) from FALUMNOS where unidad = '$row1[3]'";
$result3 = mysql_query($SQL3);
while ($row3= mysql_fetch_row($result3))
 {
// Aumentamos el NC del ultimo en 1
 $numero = $row3[0] + 1;
// Insertamos los datos en FALUMNOS
$SQL2 = "INSERT INTO FALUMNOS (CLAVEAL, APELLIDOS, NOMBRE, unidad, NC) VALUES (\"". $row1[0] . "\",\"". $row1[1] . "\",\"". $row1[2] . "\",\"". $row1[3] . "\",\"". $row1[4] . "\",\"". $numero . "\")";
echo "<li>".$row1[2] . " " . $row1[1] . " -- " . $row1[3] . " -- " . $numero .  "</li>";
$result2 = mysql_query($SQL2);

// Usuario TIC
	$apellidos = $row1[1] ;
	$apellido = explode(" ",$row1[1] );
	$alternativo = strtolower(substr($row1[3],0,2));
	$nombreorig = $row1[2]  . " " . $row1[1] ;
	$nombre = $row1[2] ;
	$claveal = $row1[0] ;
	if (substr($nombre,0,1) == "Á") {$nombre = str_replace("Á","A",$nombre);}
	if (substr($nombre,0,1) == "É") {$nombre = str_replace("É","E",$nombre);}
	if (substr($nombre,0,1) == "Í") {$nombre = str_replace("Í","I",$nombre);}
	if (substr($nombre,0,1) == "Ó") {$nombre = str_replace("Ó","O",$nombre);}
	if (substr($nombre,0,1) == "Ú") {$nombre = str_replace("Ú","U",$nombre);}
	
	$apellido[0] = str_replace("Á","A",$apellido[0]);
	$apellido[0] = str_replace("É","E",$apellido[0]);
	$apellido[0] = str_replace("Í","I",$apellido[0]);
	$apellido[0] = str_replace("Ó","O",$apellido[0]);
	$apellido[0] = str_replace("Ú","U",$apellido[0]);
	$apellido[0] = str_replace("á","a",$apellido[0]);
	$apellido[0] = str_replace("é","e",$apellido[0]);
	$apellido[0] = str_replace("í","i",$apellido[0]);
	$apellido[0] = str_replace("ó","o",$apellido[0]);
	$apellido[0] = str_replace("ú","u",$apellido[0]);
	
	$userpass = "a".strtolower(substr($nombre,0,1)).strtolower($apellido[0]);
	$userpass = str_replace("ª","",$userpass);
	$userpass = str_replace("ñ","n",$userpass);
	$userpass = str_replace("-","_",$userpass);
	$userpass = str_replace("'","",$userpass);
	$userpass = str_replace("º","",$userpass);
	$userpass = str_replace("ö","o",$userpass);
	
	$usuario  = $userpass;
	$passw = $userpass . preg_replace('/([ ])/e', 'rand(0,9)', '   ');
	$unidad = $row1[3]."-".$row1[4] ;

$repetidos = mysql_query("select usuario from usuarioalumno where usuario like '$usuario%'");
$n_a=0;
while($num = mysql_fetch_array($repetidos))
{
	$n_a+=1;
}
$n_a+=1;
$usuario = $usuario.$n_a;
mysql_query("insert into usuarioalumno set nombre = '$nombreorig', usuario = '$usuario', pass = '$passw', perfil = 'a', unidad = '$unidad', claveal = '$claveal'");
echo "<li>TIC: ".$nombreorig . " " . $usuario . " -- " . $unidad . "  " . $claveal. "</li>";
}
}
}
else 
{
echo "<div class='form-group warning'><p class='help-block' style='text-align:left'>Tabla FALUMNOS: No se ha encontrado ningun registro nuevo para añadir en FALUMNOS.<br>Si crees que hay un problema, ponte en contacto con quien sepa arreglarlo</p></div><br />";	
}

// Cambio de grupo de un alumno.
$cambio0 = mysql_query("select claveal, unidad, apellidos, nombre from alma");
while($cambio = mysql_fetch_array($cambio0)){
$f_cambio0 = mysql_query("select unidad from FALUMNOS where claveal = '$cambio[0]'");
$f_cambio = mysql_fetch_array($f_cambio0);
if($cambio[1] == $f_cambio[0]){}
else{
	$cambio_al+=1;
$resultf = mysql_query("select MAX(NC) from FALUMNOS where unidad = '$cambio[1]'");
$f_result = mysql_fetch_array($resultf);
$f_numero = $f_result[0] + 1;
mysql_query("update FALUMNOS set NC = '$f_numero', unidad = '$cambio[1]' where claveal = '$cambio[0]'");
}
}
?>

