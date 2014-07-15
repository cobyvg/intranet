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
include("../../menu.php");
if (isset($_FILES['archivo1'])) {$archivo1 = $_FILES['archivo1'];}
if (isset($_FILES['archivo2'])) {$archivo2 = $_FILES['archivo2'];}
?>
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Administración <small> Actualización de alumnos</small></h2>
</div>
<br />
<div class="well well-large" style="width:600px;margin:auto;text-align:left">
<?
if($archivo1 and $archivo2){
	
 // Conexión
mysql_connect ($db_host, $db_user, $db_pass) or die("Error de conexión");
// Copia de Seguridad
mysql_query("DROP TABLE alma_seg") ;
mysql_query("create table alma_seg select * from alma");
// Copia de Seguridad 2
mysql_query("DROP TABLE FALUMNOS_seg") ;
mysql_query("create table FALUMNOS_seg select * from FALUMNOS");

// Creamos Base de datos y enlazamos con ella.
 $base0 = "DROP TABLE `alma`";
 mysql_query($base0);

 // Creación de la tabla alma
 $alumnos = "CREATE TABLE  `alma` (
`Alumno/a` varchar( 255 ) default NULL ,
 `ESTADOMATRICULA` varchar( 255 ) default NULL ,
 `CLAVEAL` varchar( 12 ) default NULL ,
 `DNI` varchar( 10 ) default NULL ,
 `DOMICILIO` varchar( 255 ) default NULL ,
 `CODPOSTAL` varchar( 255 ) default NULL ,
 `LOCALIDAD` varchar( 255 ) default NULL ,
 `FECHA` varchar( 255 ) default NULL ,
 `PROVINCIARESIDENCIA` varchar( 255 ) default NULL ,
 `TELEFONO` varchar( 255 ) default NULL ,
 `TELEFONOURGENCIA` varchar( 255 ) default NULL ,
 `CORREO` varchar( 64 ) default NULL ,
 `CURSO` varchar( 255 ) default NULL ,
 `NUMEROEXPEDIENTE` varchar( 255 ) default NULL ,
 `UNIDAD` varchar( 255 ) default NULL ,
 `apellido1` varchar( 255 ) default NULL ,
 `apellido2` varchar( 255 ) default NULL ,
 `NOMBRE` varchar( 30 ) default NULL ,
 `DNITUTOR` varchar( 255 ) default NULL ,
 `PRIMERAPELLIDOTUTOR` varchar( 255 ) default NULL ,
 `SEGUNDOAPELLIDOTUTOR` varchar( 255 ) default NULL ,
 `NOMBRETUTOR` varchar( 255 ) default NULL ,
 `SEXOPRIMERTUTOR` varchar( 255 ) default NULL ,
 `DNITUTOR2` varchar( 255 ) default NULL ,
 `PRIMERAPELLIDOTUTOR2` varchar( 255 ) default NULL ,
 `SEGUNDOAPELLIDOTUTOR2` varchar( 255 ) default NULL ,
 `NOMBRETUTOR2` varchar( 255 ) default NULL ,
 `SEXOTUTOR2` varchar( 255 ) default NULL ,
 `LOCALIDADNACIMIENTO` varchar( 255 ) default NULL ,
  `FECHAMATRICULA` varchar( 255 ) default NULL ,
 `MATRICULAS` varchar( 255 ) default NULL ,
 `OBSERVACIONES` varchar( 255 ) default NULL,
 `PROVINCIANACIMIENTO` varchar( 255 ) default NULL ,
 `PAISNACIMIENTO` varchar( 255 ) default NULL ,
 `EDAD` varchar( 2 ) default NULL ,
 `NACIONALIDAD` varchar( 32 ) default NULL,
 `SEXO` varchar( 1 ) default NULL 
)";
mysql_query($alumnos) or die ('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido crear la tabla <strong>Alma</strong>. Ponte en contacto con quien pueda resolver el problema.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');
  
// Importamos los datos del fichero CSV (todos_alumnos.csv) en la tabña alma2.

$fp = fopen ($_FILES['archivo1']['tmp_name'] , "r" ) or die('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido abrir el archivo RegAlum.txt. O bien te has olvidado de enviarlo o el archivo está corrompido.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>'); 
 while (!feof($fp))
  {
  	$linea="";
  	$lineasalto="";
  	$dato="";
    $linea=fgets($fp);
    $lineasalto = "INSERT INTO alma VALUES (";
    $tr=explode("|",$linea);
    
    foreach ($tr as $valor){ 
  $dato.= "\"". trim($valor) . "\", ";
        }
    $dato=substr($dato,0,strlen($dato)-2); 
    $lineasalto.=$dato;  
    $lineasalto.=");";
    mysql_query($lineasalto);
  }
fclose($fp);

// Descomprimimos el zip de las calificaciones en el directorio exporta/
include('../../lib/pclzip.lib.php');   
$archive = new PclZip($_FILES['archivo2']['tmp_name']);  
      if ($archive->extract(PCLZIP_OPT_PATH, '../exporta') == 0) 
	  {
        die("Error : ".$archive->errorInfo(true));
      }  

// Procesamos los datos de RegAlum para crear la tabla alma
$crear = "ALTER TABLE  alma
ADD  `COMBASI` VARCHAR( 250 ) NULL FIRST ,
ADD  `APELLIDOS` VARCHAR( 40 ) NULL AFTER  `UNIDAD` ,
ADD  `NIVEL` VARCHAR( 5) NULL AFTER  `APELLIDOS` ,
ADD  `GRUPO` VARCHAR( 1 ) NULL AFTER  `NIVEL`,
ADD  `CLAVEAL1` VARCHAR( 8 ) NULL AFTER  `CLAVEAL`,
ADD  `PADRE` VARCHAR( 78 ) NULL AFTER  `CLAVEAL1`
";
mysql_query($crear);

// índices
mysql_query("ALTER TABLE  `alma` ADD INDEX (  `CLAVEAL` )");
mysql_query("ALTER TABLE  `alma` ADD INDEX (  `CLAVEAL1` )");
mysql_query("ALTER TABLE  `alma` ADD INDEX (  `NOMBRE` )");
mysql_query("ALTER TABLE  `alma` ADD INDEX (  `APELLIDOS` )");

// Separamos Nivel y Grupo si sigue el modelo clásico del guión (1E-F, 2B-C, etc)
  $SQL_1 = "SELECT UNIDAD, CLAVEAL  FROM  alma";
  $result_1 = mysql_query($SQL_1);
  $row_1 = mysql_fetch_row($result_1);
  if (strstr("-",$row_1[0])==TRUE) {
  	 
  $SQL0 = "SELECT UNIDAD, CLAVEAL  FROM  alma";
  $result0 = mysql_query($SQL0);

 while  ($row0 = mysql_fetch_array($result0))
 {
$trozounidad0 = explode("-",$row0[0]);
$actualiza= "UPDATE alma SET NIVEL = '$trozounidad0[0]', GRUPO = '$trozounidad0[1]' where CLAVEAL = '$row0[1]'";
	mysql_query($actualiza);
 }
  	
  }
  
 // Apellidos unidos formando un solo campo.
   $SQL2 = "SELECT apellido1, apellido2, CLAVEAL, NOMBRE FROM  alma";
  $result2 = mysql_query($SQL2);
 while  ($row2 = mysql_fetch_array($result2))
 {
 	$apellidos = trim($row2[0]). " " . trim($row2[1]);
	$apellidos1 = trim($apellidos);
	$nombre = $row2[3];
	$nombre1 = trim($nombre);
	$actualiza1= "UPDATE alma SET APELLIDOS = \"". $apellidos1 . "\", NOMBRE = \"". $nombre1 . "\" where CLAVEAL = \"". $row2[2] . "\"";
	mysql_query($actualiza1);
 }
 
 // Apellidos y nombre del padre.
   $SQL3 = "SELECT PRIMERAPELLIDOTUTOR, SEGUNDOAPELLIDOTUTOR, NOMBRETUTOR, CLAVEAL FROM  alma";
  $result3 = mysql_query($SQL3);
 while  ($row3 = mysql_fetch_array($result3))
 {
 	$apellidosP = trim($row3[2]). " " . trim($row3[0]). " " . trim($row3[1]);
	$apellidos1P = trim($apellidosP);
	$actualiza1P= "UPDATE alma SET PADRE = \"". $apellidos1P . "\" where CLAVEAL = \"". $row3[3] . "\"";
	mysql_query($actualiza1P);
 }
 
  // Eliminación de campos innecesarios por repetidos
  $SQL3 = "ALTER TABLE alma
  DROP `apellido1`,
  DROP `Alumno/a`,
  DROP `apellido2`";
  $result3 = mysql_query($SQL3);
  $cambiar_nombre = "ALTER TABLE alma MODIFY COLUMN NOMBRE VARCHAR(30) AFTER APELLIDOS";
mysql_query($cambiar_nombre);

  // Eliminación de alumnos dados de baja
  $SQL4 = "DELETE FROM alma WHERE unidad = ''";
  $result4 = mysql_query($SQL4);
   // Eliminación de alumnos dados de baja
  $SQL5 = "DELETE FROM alma WHERE unidad = 'Unida'";
  $result5 = mysql_query($SQL5);

// Exportamos códigos de asignaturas de los alumnos y CLAVEAL1 para las consultas de evaluación
if(phpversion() < '5'){
 include("exportacodigos_xslt.php");
}
else{
 include("exportacodigos.php");
}
?>
<?
mysql_connect ($db_host, $db_user, $db_pass) or die("Error de conexión");

// Eliminamos alumnos sin asignaturas que tienen la matricula pendiente, y que no pertenecen a los Ciclos
$SQL6 = "DELETE FROM alma WHERE (COMBASI IS NULL and (curso like '%E.S.O.' or unidad like '%Bach' or unidad like 'P.C.P.I.') and ESTADOMATRICULA != 'Obtiene Título' and ESTADOMATRICULA != 'Repite' and ESTADOMATRICULA != 'Promociona' and ESTADOMATRICULA != 'Pendiente de confirmacion de traslado')";
$result6 = mysql_query($SQL6);
// Eliminamos a los alumnoos de Ciclos con algun dato en estadomatricula
$SQL7 = "DELETE FROM alma WHERE ESTADOMATRICULA != '' and ESTADOMATRICULA != 'Obtiene Tí­tulo' and ESTADOMATRICULA != 'Repite' and ESTADOMATRICULA != 'Promociona'  and ESTADOMATRICULA != 'Pendiente de confirmacion de traslado'";
mysql_query($SQL7);

// Creamos una asignatura ficticia para que los alumnos sin Asignaturas puedan aparecer en las listas
$SQL8 = "update alma set combasi = 'Sin_Asignaturas' where combasi IS NULL";
mysql_query($SQL8);
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Tabla <strong>ALMA</strong>: los Alumnos se han introducido correctamente en la Base de datos.
</div></div>';
?>	
<?
include("actualizar.php");
?>
<?
if ($mod_sms=='1') {
	include("crear_hermanos.php");
}
}
else{
	echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Parece que te está olvidando de enviar todos los archivos con los datos de los alumnos. Asegúrate de enviar ambos archivos descargados desde Séneca.
</div></div><br />';
}

// Si se ha creado la tabla matriculas y el mes es mayor que sept. y menor que Diciembre, actualizamos los datos de alma con los datos de la tabla matriculas.
$matr = mysql_query("select * from matriculas");
  if (mysql_num_rows($matr)>0 and (date('m')>8 and date('m')<=12)) {
		$pro = mysql_query("select claveal,	apellidos,	nombre,	provincia,	domicilio,	localidad,	dni, padre,	dnitutor, telefono1, telefono2, nacido, madre, dnitutor2 from matriculas where curso like '%ESO%'");
	while ($prf = mysql_fetch_array($pro)) {
		
		$pap = explode(", ",$prf[7]);
		$papa = $pap[1]." ".$pap[0];	
		$papa=trim($papa);
		
		$mam = explode(", ",$prf[12]);
		$nombretutor2 = $mam[1];
		$apel_mam = explode(" ",$mam[0]);	
		$primerapellidotutor2 = $apel_mam[0];
		$segundoapellidotutor2 = "$apel_mam[1] $apel_mam[2] $apel_mam[3]";
		$segundoapellidotutor2=trim($segundoapellidotutor2);		
		
		$alm = mysql_query("select claveal,	apellidos,	nombre,	provinciaresidencia, domicilio, localidad, dni, padre, dnitutor, telefono, telefonourgencia, localidadnacimiento, primerapellidotutor2, segundoapellidotutor2, nombretutor2, dnitutor2 from alma where claveal = '$prf[0]' and (apellidos not like '$prf[1]' or nombre not like '$prf[2]' or provinciaresidencia not like '$prf[3]' or domicilio not like '$prf[4]' or localidad not like '$prf[5]' or dni not like '$prf[6]' or padre not like '$papa'  or telefono not like '$prf[9]' or telefonourgencia not like '$prf[10]' or localidadnacimiento not like '$prf[11]' or dnitutor2 not like '$prf[13]')");

		if (mysql_num_rows($alm)>0) {
		
			$num+=1;
			$alma = mysql_fetch_array($alm);

				$com = explode(", ",$prf[7]);
				$nom = trim($com[1]);
				$apel = explode(" ", $com[0]);
				$apel1 = $apel[0];
				$apel2 = $apel[1]." ".$apel[2]." ".$apel[3]." ".$apel[4];
				$apel2 = trim($apel2);					
				
				$com2 = explode(", ",$prf[12]);
				$nom2 = trim($com2[1]);
				$apel0 = explode(" ", $com2[0]);
				$apel21 = $apel0[0];
				$apel22 = $apel0[1]." ".$apel0[2]." ".$apel0[3]." ".$apel0[4];
				$apel22 = trim($apel22);
				
				$padre_alma = ", padre = '$nom $apel1 $apel2'";
				$padre_completo = ", nombretutor = '$nom', primerapellidotutor = '$apel1', segundoapellidotutor = '$apel2'";
				$madre_completo = ", nombretutor2 = '$nom2', primerapellidotutor2 = '$apel21', segundoapellidotutor2 = '$apel22', dnitutor2 = '$prf[13]'";
				
			
			 mysql_query("update alma set apellidos = '$prf[1]', nombre = '$prf[2]', provinciaresidencia = '$prf[3]', domicilio = '$prf[4]', localidad = '$prf[5]', dni = '$prf[6]', padre = '$prf[7]', dnitutor = '$prf[8]', telefono = '$prf[9]', telefonourgencia = '$prf[10]', localidadnacimiento = '$prf[11]' $padre_alma $padre_completo $madre_completo where claveal = '$prf[0]'");
			$num_filas+=mysql_affected_rows();
		}
	}
	echo '<br />
	<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Se han modificado los datos personales de '.$num_filas.' alumnos para ajustarlos a la tabla de las matrículas. Este proceso se termina el mes de Diciembre, momento en el que los adminstrativos han podido registrar los nuevos datos en Séneca. </div></div><br />';
}
include("exportaTIC.php");
 ?>
<br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div></div>
</div>
</body>
</html>