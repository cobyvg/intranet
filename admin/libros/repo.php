<? 
include_once ("../../funciones.php"); 
include ("../../config.php");
# creamos la clase extendida de fpdf.php 


// Alumnos que deben reponer libros
$repo1 = "select distinct textos_alumnos.claveal from textos_alumnos, FALUMNOS where FALUMNOS.claveal = textos_alumnos.claveal and estado = 'M' or estado = 'N' order by nivel, grupo";
echo $repo1."<br>";
$repo0 = mysql_query($repo1);
while ($repo = mysql_fetch_array($repo0)) {
	$claveal = $repo[0];
// Datos del alumno	
	$sqlal="SELECT concat(Nombre,' ',Apellidos),Unidad,Domicilio,Localidad,codpostal,Tutor FROM alma, FTUTORES WHERE alma.nivel = FTUTORES.nivel and alma.grupo = FTUTORES.grupo and claveal='".$claveal."'";
	echo "$sqlal<br>";
	$resultadoal = mysql_query($sqlal);
	$registroal = mysql_fetch_row($resultadoal);
	$nivel = substr($registroal[1],0,2);
//echo $sqlal."<br>";
// Libros en mal estado o perdidos
$sqlasig="SELECT distinct asignaturas.nombre, textos_gratis.titulo, textos_gratis.editorial, importe from textos_alumnos, textos_gratis, asignaturas where textos_alumnos.claveal='$claveal' and asignaturas.codigo = textos_alumnos.materia and textos_gratis.materia=asignaturas.nombre";
echo $sqlasig."<br>";
#recogida de variables.
$hoy=formatea_fecha(date('Y-m-d'));
$alumno=$registroal[0];
$unidad=$registroal[1];
$domicilio=$registroal[2];
$localidad=$registroal[3];
$codigo=$registroal[4];
$tutor="Tutor/a: ".$registroal[5];
$director_del_centro='Francisco Medina Infante';
$jefatura_de_estudios='Francisco Javier Márquez Garcia';
$secretario_del_centro='María Lourdes Barrutia Navarrete';
$direccion_del_centro='Dirección del Centro';
$fecha = date('d/m/Y');
$texto2=" Se debe reponer o en su caso abonar el importe indicado ";

$titulo2="NOTIFICACIÓN DE REPOSICIÓN DE LIBROS DE TEXTO";
$cuerpo21="D. $secretario_del_centro, como Secretario del centro $nombre_del_centro, y con el visto bueno de la Direccción, ";
$cuerpo22="CERTIFICA que el/la alumno/a: $alumno matriculado/a en el curso $unidad, revisados sus libros con fecha $fecha, debe ";
$cuerpo22.="reponer (o en su caso abonar el importe segun tarifa marcada por la Junta de Andalucía) los siguientes libros: ";
$importante2='En caso de no atender a este requerimiento el/la alumno/a no podrá disfrutar del programa de gratuidad el curso próximo.'; 

}


			
?>

