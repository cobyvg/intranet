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
?>
<?
include("../../menu.php");
?>
<div align="center">
<div class="page-header" align="center">
  <h2>Faltas de Asistencia <small> Subir faltas a S&eacute;neca</small></h2>
</div>
<br />
<?
if (isset($_GET['iniciofalta'])) {$iniciofalta = $_GET['iniciofalta'];}elseif (isset($_POST['iniciofalta'])) {$iniciofalta = $_POST['iniciofalta'];}else{$iniciofalta="";}
if (isset($_GET['finfalta'])) {$finfalta = $_GET['finfalta'];}elseif (isset($_POST['finfalta'])) {$finfalta = $_POST['finfalta'];}else{$finfalta="";}
if (isset($_GET['Submit'])) {$Submit = $_GET['Submit'];}elseif (isset($_POST['Submit'])) {$Submit = $_POST['Submit'];}else{$Submit="";}

?>
<?

if (strlen($iniciofalta) == '10' and strlen($finfalta) == '10') {
$fecha0 = explode("/",$iniciofalta);
$fecha10 = explode("/",$finfalta);

// Construimos el fichero de exportación para Séneca. Este fichero elimina datos innecesarios y coloca sólo los datos del alumno y sus notas. Hay que ir recortando los trozos necesarios para luego soldarlos en la variable total.
// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
$dir = "./origen/";
// Abrir un directorio conocido, y proceder a leer sus contenidos
if (is_dir($dir)) {
    if ($gd = opendir($dir)) {
        while (($fichero = readdir($gd)) !== false) {
		if ($fichero != "." && $fichero != ".."&& $fichero != ".xml")
		{	
$xml = file_get_contents("./origen/" . $fichero . "");
// Texto a selecionar para la cirugía.
$principio1 = "<SERVICIO>";
$principio2 = "<TRAMOS_HORARIOS>";
$principio3 = "<CURSOS>";

// Trozos de texto
$id1 = strstr ($xml, $principio1);
$id2 = strstr ($id1, $principio2);
$inicio0 = substr($id1,0,strlen($id1)-strlen($id2));

// Sustituir el intercambio de Exportación a Importación.
$inic0 = str_replace("<TIPO_INTERCAMBIO>E</TIPO_INTERCAMBIO>", "<TIPO_INTERCAMBIO>I</TIPO_INTERCAMBIO> ", $inicio0);
$hoy = date('d/m/Y')." 08:00:00"; 
$inic1 = ereg_replace("[<^]FECHA[>]([0-9]{1,2}/([0-9]{1,2})/([0-9]{4})) ([0-9]{1,2}:([0-9]{1,2}):([0-9]{1,2}))[<]\/FECHA[>$]", "<FECHA>$hoy</FECHA>", $inic0);
$inic2 = ereg_replace("[<^]FECHA_DESDE[>]([0-9]{1,2}/([0-9]{1,2})/([0-9]{4}))[<]\/FECHA_DESDE[>$]", "<FECHA_DESDE>$iniciofalta</FECHA_DESDE>", $inic1);
$inic3 = ereg_replace("[<^]FECHA_HASTA[>]([0-9]{1,2}/([0-9]{1,2})/([0-9]{4}))[<]\/FECHA_HASTA[>$]", "<FECHA_HASTA>$finfalta</FECHA_HASTA>", $inic2);
$inicio1 = $inic3;
$id3 = strstr($id1, $principio3);
$id4 = strstr($id1,$principio4);
$inicio2 = substr($id3,0,strlen($id3)-strlen($id4));

$string = str_replace("<T_APELLIDO2></T_APELLIDO2>", "", $inicio2);
$string0 = str_replace("", " ", $string);
$string1 = ereg_replace("[<^]C_NUMESCOLAR[>$][0-9a-zA-ZáéíóöúªñÁÉÍÓÚü_-]+[<^]\/C_NUMESCOLAR[>$]\n", "", $string0);
//$string2 = ereg_replace("[<^]T_NOMBRE_ALU[>][a-zA-ZáéíóöúªñÁÉÍÓÚüà\.'¨- ]+[<]\/T_NOMBRE_ALU[>$]\n", "", $string1);
//$string3 = ereg_replace("[<^]T_APELLIDO1[>][a-zA-ZáéíóöúªñÁÉÍÓÚüà\.'¨- ]+[<]\/T_APELLIDO1[>$]\n", "", $string2);
//$string4 = ereg_replace("[<^]T_APELLIDO2[>][a-zA-ZáéíóöúªñÁÉÍÓÚüà\.\n\n\n'¨- ]+[<]\/T_APELLIDO2[>$]\n", "", $string3);

$string2 = ereg_replace("[<^]T_NOMBRE_ALU[>][a-zA-ZáéíóöúªñÁÉÍÓÚüà\.'-¨ ]+[<]\/T_NOMBRE_ALU[>$]\n", "", $string1);
$string3 = ereg_replace("[<^]T_APELLIDO1[>][a-zA-ZáéíóöúªñÁÉÍÓÚüà\.'-¨ ]+[<]\/T_APELLIDO1[>$]\n", "", $string2);
$string4 = ereg_replace("[<^]T_APELLIDO2[>][a-zA-ZáéíóöúªñÁÉÍÓÚüà\.'-¨ ]+[<]\/T_APELLIDO2[>$]\n", "", $string3);

$string5 = ereg_replace("                                                                      ", "			  ", $string4);
$string6 = ereg_replace("                            \n", "", $string5);
$string7 = ereg_replace("                                             <FALTAS_ASISTENCIA>", "                 <FALTAS_ASISTENCIA>", $string6);
$string8 = ereg_replace("                                          <FALTAS_ASISTENCIA>", "             <FALTAS_ASISTENCIA>", $string7);
$total = $inicio1.$string8;


 //echo htmlentities($total); 
 $curso = explode("_",$fichero);
 $nivel = strtoupper(substr($curso[0],0,2));
 $grupo = strtoupper(substr($curso[0],2,1));

$fp=fopen("./exportado/" . $fichero . "","w")  or die("<p id='texto_en_marco'>No se han podido abrir los archivos de Faltas de Séneca. ¿Estás seguro de haberlos colocado en el directorio correspondiente (intranet/faltas/seneca/origen/)?</p>");
if (flock($fp, LOCK_EX)) {
   $pepito=fwrite($fp,$total);
   flock($fp, LOCK_UN);
} else {
   sleep (10);
   $pepito=fwrite($fp,$total);
   flock($fp, LOCK_UN);//
}
fclose ($fp);	
include("exportado.php");
	   }
        }
	//	unlink($fichero);
        closedir($gd);
    }
}

	$dir2 = "./exportado/";
	if (is_dir($dir2)) {
    if ($gd = opendir($dir2)) {
        while (($fichero = readdir($gd)) !== false) {
		if ($fichero != "." && $fichero != ".."&& $fichero != ".xml")
		{	
$fecha_inicial = $fecha0[2].$fecha0[1].$fecha0[0];
$fecha_final = $fecha10[2].$fecha10[1].$fecha10[0];
if(strlen($fichero) == '27')
{
$nombre_curso = substr($fichero,0,3)."_".$fecha_inicial."_".$fecha_final."_1.xml";
} 
else
{
$nombre_curso = substr($fichero,0,3)."_".$fecha_inicial."_".$fecha_final.".xml";
}
rename("exportado/".$fichero."", "exportado/".$nombre_curso."");
}}}}
?>
<div align="center""><div class="alert alert-success alert-block fade in" style="max-width:500px;" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
	 Las Faltas de Asistencia se han escrito correctamente en los archivos  del directorio exportado/. <br />Puedes proceder a importarlos a Séneca.
			</div></div><br />
<?
}
else{
	
	?>
<div align="center""><div class="alert alert-success alert-block fade in" style="max-width:500px;" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El formato de la fecha no parece correcto. No olvides que tanto los días como los meses debes escribirlos con dos cifras. No es correcto: 1/1/2011, sino 01/01/2011.
			</div></div><br />	
	<?
}
?>