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
	
if ($_GET['horarios']==1) {
		
	$directorio = "../../varios/";
	$archivo = "Importacion_horarios_Seneca.xml";
	$archivo_origen = $_GET['archivo_origen'];
	if ($_GET['depurar']==1) {
		include_once '../../menu.php';
		echo '<br />
<div class="page-header" align="center">
<h2>Administración. <small> Importación del Horario y Preparación de la Exportación del Horario a Séneca</small></h2>
</div>
<br />
<div class="container">

<div class="row">

<div class="col-sm-6 col-sm-offset-3">';
				echo "<legend align='center'>Errores y Advertencias sobre el Horario.</legend>";
		
		echo  "<div align'center><div class='alert alert-danger alert-block fade in'><br />
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
El archivo generado por Horwin ha sido procesado y se ha creado una copia modificada preparada para subir a Séneca. 
<br>Los mesajes que aparecen más abajo indican los cambios realizados y las advertencias sobre problemas que podrías encontrar al importar los datos a Séneca.
</div></div>";		
	}

// Cargamos el XML
	$doc = new DOMDocument('1.0', 'utf-8');
	
	$doc->load( $directorio.$archivo_origen ) or die("No se ha podido leer el archivo para ser procesado.");

// Borramos y creamos la tabla de los horarios Creamos copia de seguridad de la tabla por si acaso
mysql_query("drop table horw_seg"); 
mysql_query("create table horw_seg select * from horw"); 
mysql_query("drop table horw"); 
$crea ="CREATE TABLE IF NOT EXISTS `horw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dia` char(1) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `hora` char(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `a_asig` varchar(8) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `asig` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `c_asig` varchar(30) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `prof` varchar(50) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `no_prof` tinyint(4) DEFAULT NULL,
  `c_prof` varchar(30) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `a_aula` varchar(5) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `n_aula` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `a_grupo` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nivel` varchar(10) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `n_grupo` varchar(10) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `clase` varchar(16) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `prof` (`prof`),
  KEY `c_asig` (`c_asig`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci";
mysql_query($crea) or die ('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido crear la tabla <strong>Horw</strong>. Ponte en contacto con quien pueda resolver el problema.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');

// Recorremos los horarios de los prodes
	$profes = $doc->getElementsByTagName( "grupo_datos");

	foreach ($profes as $materia) {	

		$codigos = $materia->getElementsByTagName( "dato" );
		include 'importarHorarioSeneca.php';

//
// Tuneado del XML para corregir limiraciones de Horwin
//		
		$texto="";
		
		
		$N_DIASEMANA=$codigos->item(0)->nodeValue;
		
		if (strlen($N_DIASEMANA)>4) {
			$COD_PROF = $N_DIASEMANA;
			$num_prof+=1;
		}
		elseif (strlen($N_DIASEMANA)==1){
			$DIASEMANA = $N_DIASEMANA;
		}

		$X_TRAMO=$codigos->item(1)->nodeValue;
		$tram = mysql_query("select hora from tramos where tramo = '$X_TRAMO'");
		$tram_hor = mysql_fetch_row($tram);
		$tramo = $tram_hor[0];
		$X_DEPENDENCIA=$codigos->item(2)->nodeValue;
		$X_UNIDAD=$codigos->item(3)->nodeValue;
		$X_OFERTAMATRIG=$codigos->item(4)->nodeValue;
		$X_MATERIAOMG=$codigos->item(5)->nodeValue;
		$X_MATERIAOMG=trim($X_MATERIAOMG);
		$F_INICIO=$codigos->item(6)->nodeValue;
		$F_FIN=$codigos->item(7)->nodeValue;
		$N_HORINI=$codigos->item(8)->nodeValue;
		$N_HORFIN=$codigos->item(9)->nodeValue;
		$X_ACTIVIDAD=$codigos->item(10)->nodeValue;
		
		if (strlen($X_UNIDAD)>6 and strlen($X_MATERIAOMG)<7) {
//  and $X_UNIDAD > "3174012"
			$un = mysql_query("select unidades.idcurso, nomcurso, nomunidad from unidades, cursos where unidades.idcurso = cursos.idcurso and idunidad = '$X_UNIDAD' order by unidades.idcurso, nomunidad");

			if (mysql_num_rows($un)>0) {	
			
			$uni = mysql_fetch_array($un);


			$nombre_asig = mysql_query("select nombre from asignaturas where codigo = '$X_MATERIAOMG' and abrev not like '%\_%' and curso not like '' and (codigo not in (select idactividad from actividades_seneca WHERE idactividad not like  '2') or codigo not like '2') and codigo not like ''");

			if (mysql_num_rows($nombre_asig)>0) {
				$nombre_asigna= mysql_fetch_array($nombre_asig);
				$no_asig = $nombre_asigna[0];
				$asig = mysql_query("select codigo, nombre from asignaturas where curso = '$uni[1]' and curso not like '' and nombre = '$nombre_asigna[0]' and abrev not like '%\_%' and (codigo not in (select idactividad from actividades_seneca WHERE idactividad NOT LIKE  '2') or codigo not like '2')");


				if (mysql_num_rows($asig)>0) {
					
					$asignatura="";
					
					while ($asignatur = mysql_fetch_array($asig)){
						$asignatura.=$asignatur[0].";";
						$nombre_asignatura = $asignatur[1];
					}

					if (stristr($asignatura,$X_MATERIAOMG)==FALSE) {
						//if (strstr($texto,$asignatura)==FALSE) {
							$asig_corta = substr($asignatura,0,-1);
							if ($_GET['depurar']==1  and $X_UNIDAD < "3174013") {
							echo  "<br /><div align'center><div class='alert alert-success alert-block fade in'><br />
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
El código de la asignatura <u>$X_MATERIAOMG</u> (<em>$nombre_asignatura</em>) no corresponde al Grupo $uni[2] ($uni[1]), sino este código: <strong>$asig_corta</strong>. <br><span clas='text-warning'>Código sustituído..</span>
</div></div>";	
							}	
							//echo	.;:,		
							$codigos->item(5)->nodeValue = $asig_corta;
							$prueba = $codigos->item(5)->nodeValue;
							//echo "$COD_PROF --> $X_MATERIAOMG --> $prueba<br>";
							mysql_query("update horw set c_asig = '$asig_corta' where c_prof = '$COD_PROF' and a_grupo = '$uni[2]' and c_asig = '$X_MATERIAOMG'");
							$texto.=$asignatura.'';
						//}

					}
				}
				else{
					if (strstr($texto,$X_MATERIAOMG)==FALSE and $X_UNIDAD < "3174013") {
						if ($_GET['depurar']==1) {
						echo  '<br /><div align="center"><div class="alert alert-warning alert-block fade in"><br />
            <button type="button" class="close" data-dismiss="alert">&times;</button>
No existe la asignatura <u>'.$X_MATERIAOMG.'</u> (<em>'.$nombre_asignatura.'</em>) en la tabla de asignaturas de '. $uni[1].' ('.$uni[2].').
Comprueba los datos que causan el error: Dia: ' .$DIASEMANA. '; Hora: '.$tramo.'('.$X_TRAMO.'); Profesor: '.$nombre_profesor.'('.$COD_PROF.'); 
</div></div>';
						}
						$texto.=$X_MATERIAOMG.' ';
							
					}
					//echo $texto."<br>";
				}
			}
			else{
				
				if ($X_ACTIVIDAD=="2") {}
				else{
				if ($_GET['depurar']==1) {
				echo  "<br /><div align'center><div class='alert alert-danger alert-block fade in'><br />
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
<strong>$uni[2]</strong>: O bieno existe ninguna asignatura con este código (<u>$X_MATERIAOMG</u>) en la tabla de asignaturas de la base de datos; o bien no has asignado un código a esta materia y el campo está vacío.
Comprueba los datos que causan el error: Dia: $DIASEMANA; Hora: $tramo ($X_TRAMO); Profesor: $nombre_profesor ($COD_PROF);
</div></div>";	
				}
			}
			}
		}
	}
}

// Actualizamos nombre de las materias / actividades para hacerlas más intuitivas y ajustarlas al patrón antiguo
mysql_query("update horw set a_asig = 'TUT' where c_asig = '2'");
mysql_query("update asignaturas set abrev = 'TUT' where codigo = '2'");
mysql_query("update horw set a_asig = 'SG' where c_asig = '25'");
mysql_query("update horw set a_asig = 'SGRE' where c_asig = '353'");
mysql_query("update horw set a_asig = 'GUBIB' where c_asig = '26'");

// Separamos Nivel y Grupo si sigue el modelo clásico del guión (1E-F, 2B-C, etc)
  $SQL_1 = "SELECT a_grupo  FROM  horw where a_grupo is not null and a_grupo not like ''";
  $result_1 = mysql_query($SQL_1);
  $row_1 = mysql_fetch_row($result_1);
  
  if (strstr($row_1[0],"-")==TRUE) {  	
  $SQL0 = "SELECT a_grupo, id FROM  horw";
  $result0 = mysql_query($SQL0);

 while  ($row0 = mysql_fetch_array($result0))
 {
	if (is_numeric(substr($row0[0],0,1))) 
 	{
$nivel0 = substr($row0[0], 0, 2);
$grupo0 = substr($row0[0], 3, 1);
$actualiza= "UPDATE horw SET nivel = '$nivel0', n_grupo = '$grupo0' where id = '$row0[1]'";
 	}
/* 	else {
$actualiza= "UPDATE horw SET nivel = '', n_grupo = '' where a_grupo = '$row0[0]'";
 	}*/
mysql_query($actualiza); 
 } 	
 }

// Eliminamos el Recreo como 4ª Hora.
 $hora0 = "UPDATE  horw SET  hora =  'R' WHERE  hora = '4'";
 mysql_query($hora0);
 $hora4 = "UPDATE  horw SET  hora =  '4' WHERE  hora = '5'";
 mysql_query($hora4);
 $hora5 = "UPDATE  horw SET  hora =  '5' WHERE  hora = '6'";
 mysql_query($hora5);
 $hora6 = "UPDATE  horw SET  hora =  '6' WHERE  hora = '7'";
 mysql_query($hora6);
 mysql_query("OPTIMIZE TABLE  `horw`"); 

 // Metemos a los profes en la tabla profesores hasta que el horario se haya exportado a Séneca y consigamos los datos reales de los mismos
$tabla_profes = mysql_query("select * from profesores");
if (mysql_num_rows($tabla_profes) > 0) {}
else{
// Recorremos la tabla Profesores bajada de Séneca
	$pro = mysql_query("select distinct asig, a_grupo, prof from horw where a_grupo in (select distinct nomunidad from unidades) order by prof");
	while ($prf = mysql_fetch_array($pro)) {	
		$materia = $prf[0];
		$grupo = $prf[1];
		$profesor = $prf[2];
		$niv = mysql_query("select distinct curso from alma where unidad = '$grupo'");
		$nive = mysql_fetch_array($niv);
		$nivel = $nive[0];

	mysql_query("INSERT INTO  profesores (
`nivel` ,
`materia` ,
`grupo` ,
`profesor`
) VALUES ('$nivel', '$materia', '$grupo', '$profesor')");
	}
} 


// Cargos varios

$carg = mysql_query("select distinct prof from horw");
while ($cargo = mysql_fetch_array($carg)) {
	$cargos="";

$profe_dep = mysql_query("select distinct c_asig from horw where prof = '$cargo[0]' and (a_grupo = '' or c_asig = '2' or c_asig = '279' or c_asig = '117')");
while ($profe_dpt = mysql_fetch_array($profe_dep)) {	
	if ($profe_dpt[0]=="44") {
		$cargos="1";
	}
if ($profe_dpt[0]=="45") {
		$cargos.="4";
	}
if ($profe_dpt[0]=="50") {
		$cargos.="8";
	}
if ($profe_dpt[0]=="376") {
		$cargos.="a";
	}
if ($profe_dpt[0]=="384") {
		$cargos.="9";
	}

if ($profe_dpt[0]=="26") {
		$cargos.="c";
	}

if ($profe_dpt[0]=="2") {
	$cargos.="2";
	}
}
// Tutores
$tabla_tut = mysql_query("select * from FTUTORES where tutor = '$cargo[0]'");
	if(mysql_num_rows($tabla_tut) > 0){}
	else{	
if(strstr($cargos,"2")==TRUE)
{
	mysql_query("insert into FTUTORES (unidad, tutor) select distinct a_grupo, prof from horw where c_asig like '2' and prof = '$cargo[0]' and prof in (select nombre from departamentos)");
	}		
}
	mysql_query("update departamentos set cargo = '$cargos' where nombre = '$cargo[0]'");
}

//Primera version de Profesores.
$pr0 = mysql_query("select profesor from profesores");
if (mysql_num_rows($pr0)>1) {} 
else{
mysql_query("truncate table profesores");
mysql_query("insert into profesores SELECT DISTINCT asignaturas.curso, asignaturas.nombre, a_grupo, prof FROM asignaturas, horw WHERE asignaturas.codigo = c_asig and abrev not like '%\_%'");
mysql_query("truncate table reservas.profesores");
mysql_query("insert into reservas.profesores SELECT DISTINCT alma.curso, asignaturas.nombre, a_grupo, prof FROM alma, asignaturas, horw WHERE alma.unidad = horw.a_grupo AND asignaturas.codigo = c_asig");
}


//
// Cramos horw_faltas
//
mysql_query("create table horw_faltas select * from horw");

// Eliminamos residuos y cambiamos alguna cosa.
 
 $sin = mysql_query("SELECT nombre FROM departamentos WHERE nombre not in (select profesor from profesores)");
 if(mysql_num_rows($sin) > "0"){
 while($sin_hor=mysql_fetch_array($sin))
 {
 $prof_sin.=" prof like '%$sin_hor[0]%' or";
 }
 }
 $prof_sin = " and ".substr($prof_sin,0,strlen($prof_sin)-3);
 
 // mysql_query("delete from horw_faltas where (1=1 $prof_sin or c_asig  like '118' or c_asig  like '117')");

 mysql_query("delete from horw_faltas where a_grupo = ''");
 
   // Cambiamos los numeros de Horw para dejarlos en orden alfabético.
$hor = mysql_query("select distinct prof from horw order by prof");
while($hor_profe = mysql_fetch_array($hor)){
	$np+=1;
	$sql = "update horw set no_prof='$np' where prof = '$hor_profe[0]'";
	$sql0 = "update horw_faltas set no_prof='$np' where prof = '$hor_profe[0]'";
	//echo "$sql<br>";
	$sql1 = mysql_query($sql);
	$sql2 = mysql_query($sq0);
}

  mysql_query("OPTIMIZE TABLE  `horw_faltas`");   

// Copia del horario en Reservas
mysql_query("DROP TABLE IF EXISTS  `reservas`.`horw`");

mysql_query("create table reservas.horw select * from horw_faltas");

 

	$contenido=$doc->saveXML();
	$directorio = "../../varios/";
	$archivo = "Importacion_horarios_Seneca.xml";
	$fopen = fopen($directorio.$archivo, "w");
	fwrite($fopen, $contenido);

	
	if ($_GET['depurar']==1) {
		echo "<hr /><legend align='center'>Texto del archivo XML resultante</legend>";
	}
	header("Content-disposition: attachment; filename=$archivo");
	header("Content-type: application/octet-stream");
	readfile($directorio.$archivo);
	
}
?>