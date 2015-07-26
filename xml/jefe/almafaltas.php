<?
require('../../bootstrap.php');


if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');
	exit;
}

include '../../menu.php';
if (isset($_FILES['archivo1'])) {$archivo1 = $_FILES['archivo1'];}
if (isset($_FILES['archivo2'])) {$archivo2 = $_FILES['archivo2'];}
?>
<br />
<div align="center">
<div class="page-header">
<h2>Administración <small> Creación de la tabla de alumnos</small></h2>
</div>
<br />
<div class="well well-large"
	style="width: 600px; margin: auto; text-align: left"><?
	if($archivo1 and $archivo2){
		// Comprobamos si es la primera vez que se ha creado una base de datos.
		$fechorias = mysqli_query($db_con, "select * from Fechoria");
		$mensajes = mysqli_query($db_con, "select * from mens_texto");
		$reg_int = mysqli_query($db_con, "select * from reg_intranet");

		if (mysqli_num_rows($fechorias)<"5" and mysqli_num_rows($mensajes)<"5" and mysqli_num_rows($reg_int)<"5") {}
		else{
			include("copia_bd.php");
		}

		// Creamos Base de datos y enlazamos con ella.
		$base0 = "DROP TABLE `alma`";
		mysqli_query($db_con, $base0);

		// CreaciÃƒÂ³n de la tabla alma
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

		// echo $alumnos;
		mysqli_query($db_con, $alumnos) or die ('<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓ“N:</legend>
No se ha podido crear la tabla <strong>Alma</strong>. Ponte en contacto con quien pueda resolver el problema.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');

		$SQL6 = "ALTER TABLE  `alma` ADD INDEX (  `CLAVEAL` )";
		$result6 = mysqli_query($db_con, $SQL6);

		// Importamos los datos del fichero CSV (todos_alumnos.csv) en la tabÃƒÂ±a alma.

		$fp = fopen ($_FILES['archivo1']['tmp_name'] , "r" ) or die('<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÃ“N:</h5>
No se ha podido abrir el archivo RegAlum.txt. O bien te has olvidado de enviarlo o el archivo estÃ¡ corrompido.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrÃ¡s" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>'); 
		$row = 1;
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
			mysqli_query($db_con, $lineasalto);
		}
		fclose($fp);

		// Descomprimimos el zip de las calificaciones en el directorio exporta/
		include('../../lib/pclzip.lib.php');
		$archive = new PclZip($_FILES['archivo2']['tmp_name']);
		if ($archive->extract(PCLZIP_OPT_PATH, '../exporta') == 0)
		{
			die("Error : ".$archive->errorInfo(true));
		}

		// Procesamos datos
		$crear = "ALTER TABLE  alma
ADD  `COMBASI` VARCHAR( 250 ) NULL FIRST ,
ADD  `APELLIDOS` VARCHAR( 40 ) NULL AFTER  `UNIDAD` ,
ADD  `CLAVEAL1` VARCHAR( 8 ) NULL AFTER  `CLAVEAL`,
ADD  `PADRE` VARCHAR( 78 ) NULL AFTER  `CLAVEAL1`,
ADD  `NIVEL` VARCHAR( 5) NULL AFTER  `APELLIDOS` ,
ADD  `GRUPO` VARCHAR( 1 ) NULL AFTER  `NIVEL`
";
		mysqli_query($db_con, $crear);

		// Separamos Nivel y Grupo si sigue el modelo clÃ¡sico del guiÃ³n (1E-F, 2B-C, etc)
		$SQL_1 = "SELECT UNIDAD, CLAVEAL  FROM  alma where unidad not like 'Unida%' and unidad not like ''";
		$result_1 = mysqli_query($db_con, $SQL_1);
		$row_1 = mysqli_fetch_array($result_1);
		if (strstr($row_1[0],"-")==TRUE) {
			$SQL0 = "SELECT UNIDAD, CLAVEAL  FROM  alma";
			$result0 = mysqli_query($db_con, $SQL0);

			while  ($row0 = mysqli_fetch_array($result0))
			{
				$trozounidad0 = explode("-",$row0[0]);
				$actualiza= "UPDATE alma SET NIVEL = '$trozounidad0[0]', GRUPO = '$trozounidad0[1]' where CLAVEAL = '$row0[1]'";
				mysqli_query($db_con, $actualiza);
			}
		}

		// Apellidos unidos formando un solo campo.
		$SQL2 = "SELECT apellido1, apellido2, CLAVEAL, NOMBRE FROM  alma";
		$result2 = mysqli_query($db_con, $SQL2);
		while  ($row2 = mysqli_fetch_array($result2))
		{
			$apellidos = trim($row2[0]). " " . trim($row2[1]);
			$apellidos1 = trim($apellidos);
			$nombre = $row2[3];
			$nombre1 = trim($nombre);
			$actualiza1= "UPDATE alma SET APELLIDOS = \"". $apellidos1 . "\", NOMBRE = \"". $nombre1 . "\" where CLAVEAL = \"". $row2[2] . "\"";
			mysqli_query($db_con, $actualiza1);
		}

		// Apellidos y nombre del padre.
		$SQL3 = "SELECT PRIMERAPELLIDOTUTOR, SEGUNDOAPELLIDOTUTOR, NOMBRETUTOR, CLAVEAL FROM  alma";
		$result3 = mysqli_query($db_con, $SQL3);
		while  ($row3 = mysqli_fetch_array($result3))
		{
			$apellidosP = trim($row3[2]). " " . trim($row3[0]). " " . trim($row3[1]);
			$apellidos1P = trim($apellidosP);
			$actualiza1P= "UPDATE alma SET PADRE = \"". $apellidos1P . "\" where CLAVEAL = \"". $row3[3] . "\"";
			mysqli_query($db_con, $actualiza1P);
		}

		// EliminaciÃƒÂ³n de campos innecesarios por repetidos
		$SQL3 = "ALTER TABLE alma
  DROP `apellido1`,
  DROP `Alumno/a`,
  DROP `apellido2`";
		$result3 = mysqli_query($db_con, $SQL3);

		// EliminaciÃƒÂ³n de alumnos dados de baja
		$SQL4 = "DELETE FROM alma WHERE `unidad` = ''";
		$result4 = mysqli_query($db_con, $SQL4);

		include("exportacodigos.php");

		// Eliminamos alumnos sin asignaturas que tienen la matricula pendiente, y que no pertenecen a los Ciclos
		$SQL6 = "DELETE FROM alma WHERE (COMBASI IS NULL and (curso like '%E.S.O.%' or curso like '%Bach%' or curso like '%P.C.P.I.%') and ESTADOMATRICULA != 'Obtiene Título' and ESTADOMATRICULA != 'Repite' and ESTADOMATRICULA != 'Promociona' and ESTADOMATRICULA != 'Pendiente de confirmacion de traslado')";
		$result6 = mysqli_query($db_con, $SQL6);

		// Eliminamos a los alumnoos de Ciclos con algun dato en estadomatricula
		$SQL7 = "DELETE FROM alma WHERE ESTADOMATRICULA != '' and ESTADOMATRICULA != 'Obtiene Título' and ESTADOMATRICULA != 'Repite' and ESTADOMATRICULA != 'Promociona'  and ESTADOMATRICULA != 'Pendiente de confirmacion de traslado'";
		mysqli_query($db_con, $SQL7);

		// Creamos una asignatura ficticia para que los alumnos sin Asignaturas puedan aparecer en las listas
		$SQL8 = "update alma set combasi = 'Sin_Asignaturas' where combasi IS NULL";
		mysqli_query($db_con, $SQL8);

		// Creamos version corta para FALTAS
		mysqli_query($db_con, "CREATE TABLE almafaltas select CLAVEAL, NOMBRE, APELLIDOS, unidad from alma") or die('<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
No se ha podido crear la tabla <strong>Almafaltas</strong>. Ponte en contacto con quien pueda resolver el problema.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');

		// Claveal primaria e indice
		$SQL6 = "ALTER TABLE  `almafaltas` ADD INDEX (  `CLAVEAL` )";
		$result6 = mysqli_query($db_con, $SQL6);

		// Si la tabla existe, la vaciamos.
		$vaciar = "truncate table FALUMNOS";
		mysqli_query($db_con, $vaciar);

		// Rellenamos datos en FALUMNOS desde almafaltas
		$SQL0 = "SELECT distinct unidad FROM  alma order by unidad";
		$result0 = mysqli_query($db_con, $SQL0);
		while  ($row0 = mysqli_fetch_array($result0))
		{
			$SQL1 = "SELECT distinct CLAVEAL, APELLIDOS, NOMBRE, unidad FROM  alma WHERE unidad = '$row0[0]'";
			$result1 = mysqli_query($db_con, $SQL1);

			// Calculamos el numero de alumnos en cada curso
			$numero = mysqli_num_rows($result1);
			for($i=0; $i <= $numero -1; $i++)
			{
				while  ($row1= mysqli_fetch_array($result1))
				{
					$i = $i + 1 ;

					// Insertamos los datos en FALUMNOS
					$SQL2 = "INSERT INTO FALUMNOS (CLAVEAL, APELLIDOS, NOMBRE, unidad, NC) VALUES
(\"". $row1[0] . "\",\"". $row1[1] . "\",\"". $row1[2] . "\",\"". $row1[3] . "\",\"". $i . "\")";
					$result2 = mysqli_query($db_con, $SQL2);
				}
			}
		}
		echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Tabla <strong>Alma</strong>: los Alumnos se han introducido correctamente en la Base de datos.
</div></div><br />';
		// Eliminamos temporales
		mysqli_query($db_con, "drop table almafaltas");

		// Caracteristicas propias de cada centro
		include("alma_centros.php");

		// Datos para el alta masiva de usuarios TIC
		include("exportaTIC.php");

		// Alumnos con pendientes
		include("pendientes.php");

		// Alumnos con hermanos
		include("crear_hermanos.php");

		// Copia de la primera versiÃƒÂ³n de alma
		mysqli_query($db_con, "DROP TABLE alma_primera");
		mysqli_query($db_con, "DROP TABLE FALUMNOS_primero");
		mysqli_query($db_con, "create table alma_primera select * from alma");
		mysqli_query($db_con, "ALTER TABLE  `alma_primera` ADD INDEX (  `CLAVEAL` )");
		mysqli_query($db_con, "CREATE TABLE FALUMNOS_primero SELECT claveal, nc, apellidos, nombre, unidad FROM FALUMNOS WHERE claveal IN (SELECT claveal FROM alma_primera)");
		mysqli_query($db_con, "ALTER TABLE  `FALUMNOS_primero` ADD INDEX (  `CLAVEAL` )");
	}
	else{
		echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
Parece que te estás olvidando de enviar todos los archivos con los datos de los alumnos. Asegúrate de enviar ambos archivos descargados desde Séneca.
</div></div><br />';
	}
	?> <br />
<div align="center"><a href="../index.php" class="btn btn-primary" />Volver
a Administración</a></div>
</div>
</div>
</body>
</html>
