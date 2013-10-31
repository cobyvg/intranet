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

if (!isset($_POST['iniciofalta']) && !isset($_POST['finfalta'])) {
	die("Error: Debe introducir los parámetros FECHA_DESDE y FECHA_HASTA para generar el archivo.");
}

$FECHA_DESDE = $_POST['iniciofalta'];
$FECHA_HASTA = $_POST['finfalta'];

function fecha_mysql($fecha) {
	$trozo = explode("/", $fecha);
	return $trozo[2]."-".$trozo[1]."-".$trozo[0];
}

function fecha_seneca($fecha_mysql) {
	$trozo = explode("-", $fecha_mysql);
	return $trozo[2]."/".$trozo[1]."/".$trozo[0];
}

function obtenerProvincia($codpostal) {
	
	$prov = substr($codpostal,0,2);
	
	switch ($prov) {
		case 04 : return "Almería";
		case 11 : return "Cádiz";
		case 14 : return "Córdoba";
		case 18 : return "Granada";
		case 21 : return "Huelva";
		case 23 : return "Jaén";
		case 29 : return "Málaga";
		case 41 : return "Sevilla";
	}
}

$MYSQL_FECHA_DESDE = fecha_mysql($FECHA_DESDE);
$MYSQL_FECHA_HASTA = fecha_mysql($FECHA_HASTA);

$fechaHoy = date('d/m/Y H:i:s');
$anio_curso = substr($inicio_curso,0,4);
$provincia = utf8_decode(obtenerProvincia($codigo_postal_del_centro));

// FLAGS DE CONTROL
$flag=0;			// Controla que la creación de la tabla tramos se ejecute una vez.
$flag_fincurso=0;	// Controla que no imprima las etiquetas </UNIDADES> u </CURSO> al comienzo.
$flag_curso="";		// Controla que no imprima el curso por cada unidad.


// CABECERA DEL DOCUMENTO XML
$docXML  = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n\n";
$docXML .= "<SERVICIO>\n";
$docXML .= "  <DATOS_GENERALES>\n";
$docXML .= "    <MODULO>FALTAS DE ASISTENCIA</MODULO>\n";
$docXML .= "    <TIPO_INTERCAMBIO>I</TIPO_INTERCAMBIO> \n";
$docXML .= "    <AUTOR>SENECA</AUTOR>\n";
$docXML .= "    <FECHA>$fechaHoy</FECHA>\n";
$docXML .= "    <C_ANNO>$anio_curso</C_ANNO>\n";
$docXML .= "    <FECHA_DESDE>$FECHA_DESDE</FECHA_DESDE>\n";
$docXML .= "    <FECHA_HASTA>$FECHA_HASTA</FECHA_HASTA>\n";
$docXML .= "    <CODIGO_CENTRO>$codigo_del_centro</CODIGO_CENTRO>\n";
$docXML .= "    <NOMBRE_CENTRO>$nombre_del_centro</NOMBRE_CENTRO>\n";
$docXML .= "    <LOCALIDAD_CENTRO>$localidad_del_centro ($provincia)</LOCALIDAD_CENTRO>\n";
$docXML .= "  </DATOS_GENERALES>\n";
$docXML .= "  <CURSOS>\n";


$directorio = opendir("./origen/");
while ($archivo = readdir($directorio)) {
	
    if (!is_dir($archivo))
    {
    	// Obtenemos el nivel y grupo
        $curso = explode("_",$archivo);
        $nivel = strtoupper(substr($curso[0],0,2));
        $grupo = strtoupper(substr($curso[0],2,1));
        
        
        $doc = new DOMDocument('1.0', 'iso-8859-1');
        $doc->load( './origen/'.$archivo );
        
        // CREACION DE LA TABLA TRAMOS
        $tramos = $doc->getElementsByTagName("TRAMO_HORARIO");
        
        if (!$flag) {
        	foreach( $tramos as $tramo ) {
        		$tag_tramo = $tramo->getElementsByTagName("X_TRAMO");
	        	$tag_horcen = $tramo->getElementsByTagName("T_HORCEN");
	        	$X_TRAMO = $tag_tramo->item(0)->nodeValue;
	        	$T_HORCEN = $tag_horcen->item(0)->nodeValue;
	        	
	        	mysql_query('TRUNCATE TABLE tramos');
	        	$result = mysql_query("INSERT INTO tramos VALUES ('$T_HORCEN', '$X_TRAMO')");
	        	if (!$result) echo mysql_error();
	        	else $flag=1;
	        }
        }
        
        // Obtenemos los datos del curso
        $tag_xofertamatrig	= $doc->getElementsByTagName("X_OFERTAMATRIG");
        $tag_dofertamatrig	= $doc->getElementsByTagName("D_OFERTAMATRIG");
        $tag_xunidad 		= $doc->getElementsByTagName("X_UNIDAD");
        $tag_tnombre		= $doc->getElementsByTagName("T_NOMBRE");
        $X_OFERTAMATRIG 	= $tag_xofertamatrig->item(0)->nodeValue;
        $D_OFERTAMATRIG		= utf8_decode($tag_dofertamatrig->item(0)->nodeValue);
        $X_UNIDAD			= $tag_xunidad->item(0)->nodeValue;
        $T_NOMBRE			= utf8_decode($tag_tnombre->item(0)->nodeValue);
        
        
        // COMIENZO/FIN DE UNIDADES Y CURSOS DEL CENTRO
        if ($flag_curso != $X_OFERTAMATRIG) {
        	if ($flag_fincurso) {
        		$docXML .= "      </UNIDADES>\n";
        		$docXML .= "    </CURSO>\n";
        	}
        	$docXML .= "    <CURSO>\n";
        	$docXML .= "      <X_OFERTAMATRIG>$X_OFERTAMATRIG</X_OFERTAMATRIG>\n";
        	$docXML .= "      <D_OFERTAMATRIG>$D_OFERTAMATRIG</D_OFERTAMATRIG>\n";
        	$docXML .= "      <UNIDADES>\n";
        	
        	$flag_fincurso = 1;
        }
        $flag_curso = $X_OFERTAMATRIG;
        
        
        // COMIENZO DE UNIDAD
        $docXML .= "        <UNIDAD>\n";
        $docXML .= "          <X_UNIDAD>$X_UNIDAD</X_UNIDAD>\n";
        $docXML .= "          <T_NOMBRE>$T_NOMBRE</T_NOMBRE>\n";
        
        
        // ALUMNOS DE LA UNIDAD
        $docXML .= "          <ALUMNOS>\n";
        
        $tag_alumno = $doc->getElementsByTagName("ALUMNO");
        foreach( $tag_alumno as $alumno ) {
        	$tag_xmatricula = $alumno->getElementsByTagName("X_MATRICULA");
        	$tag_cnumescolar = $alumno->getElementsByTagName("C_NUMESCOLAR");
        	$X_MATRICULA = $tag_xmatricula->item(0)->nodeValue;	
        	$C_NUMESCOLAR = $tag_cnumescolar->item(0)->nodeValue;
        	
        	// COMIENZO ALUMNO
        	$docXML .= "            <ALUMNO>\n";
        	$docXML .= "              <X_MATRICULA>$X_MATRICULA</X_MATRICULA>\n";
        	
        	// COMIENZO FALTAS DE ASISTENCIA
        	$docXML .= "              <FALTAS_ASISTENCIAS>\n";
        	
        	$result = mysql_query("SELECT FALTAS.FECHA, FALTAS.HORA FROM FALTAS JOIN alma ON FALTAS.CLAVEAL=alma.CLAVEAL WHERE FALTAS.FECHA BETWEEN '$MYSQL_FECHA_DESDE' AND '$MYSQL_FECHA_HASTA' AND FALTAS.FALTA='F' AND alma.CLAVEAl1='$X_MATRICULA'");
        	if (!$result) echo mysql_error();
        	
        	while($faltas = mysql_fetch_array($result)) {
	        	
	        	// Obtenemos la fecha de la falta en formato Séneca
	        	$F_FALASI = fecha_seneca($faltas[0]);
	        	
	        	// Obtenemos el código de tramo
	        	$result_tramos = mysql_query("SELECT tramo FROM tramos WHERE hora='$faltas[1]'");
	        	$tramos = mysql_fetch_array($result_tramos);
	        	
	        	$docXML .= "                <FALTA_ASISTENCIA>\n";
	        	$docXML .= "                  <F_FALASI>$F_FALASI</F_FALASI>\n";
	        	$docXML .= "                  <X_TRAMO>$tramos[0]</X_TRAMO>\n";
	        	$docXML .= "                  <C_TIPFAL>I</C_TIPFAL>\n";
	        	$docXML .= "                  <L_DIACOM>N</L_DIACOM>\n";
	        	$docXML .= "                </FALTA_ASISTENCIA>\n";
        	}

        	
        	// FIN FALTAS DE ASISTENCIA
        	$docXML .= "              </FALTAS_ASISTENCIAS>\n";
        	
        	// FIN ALUMNO
        	$docXML .= "            </ALUMNO>\n";
        }
		
		// FIN DE ALUMNOS DE LA UNIDAD
        $docXML .= "          </ALUMNOS>\n";
        
        // FIN DE UNIDAD
        $docXML .= "        </UNIDAD>\n";
    }
}

// PIE DEL DOCUMENTO
$docXML .= "      </UNIDADES>\n";
$docXML .= "    </CURSO>\n";
$docXML .= "  </CURSOS>\n";
$docXML .= "</SERVICIO>";


// CREACIÓN DEL DOCUMENTO XML
$directorio = "./exportado/";
$archivo = "Importacion_Faltas_Alumnado.xml";
$fopen = fopen($directorio.$archivo, "w");
fwrite($fopen, $docXML);

header("Content-disposition: attachment; filename=$archivo");
header("Content-type: application/octet-stream");
readfile($directorio.$archivo);