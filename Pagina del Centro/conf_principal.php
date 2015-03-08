<?

///////////////// Datos de la configuración de la Intranet

$dominio='localhost/iesmonterroso.org/';

// Personal del Equipo Directivo
$director_del_centro='Francisco Javier Márquez';
$email_del_centro='director@iesmonterroso.org';
$jefatura_de_estudios='Juna Serrano Pérez';
$mail_jefatura='jefatura@iesmonterroso.org';
$secretario_del_centro='Lourdes Barrutia';
$mail_secretaria='instituto@iesmonterroso.org';
$vicedirector_del_centro='Francisco Pérez Gomar';
$mail_vicedirector='vicedirector@iesmonterroso.org';

//Datos del Centro
$nombre_del_centro='I.E.S. Monterroso';
$nombre_corto='Monterroso';
$codigo_del_centro='29002885';
$direccion_del_centro='C/ Santo Tomás de Aquino, s/n';
$localidad_del_centro='Estepona';
$codigo_postal_del_centro='29680';
$telefono_del_centro='952795802';
$fax_del_centro='952804309';

// Datos del Curso actual. Deben actulaizarse al comienzo de cada curso escolar
$curso_actual='2014/15';
$inicio_curso='2014-09-15';
$fin_curso='2015-06-24';

// Directorio donde guardar las fotos originales en el servidor. Debe tener permiso de escritura.
$fotos_dir = "/opt/e-smith/fotos/";

// Directorio raiz donde se encuentra la Intranet del Centro
$raiz_dir = '/Applications/MAMP/htdocs/intranet/';

// Directorio de los documentos
$doc_dir = '/opt/e-smith/';

// Variables para acceder a la Bases de Datos
$host = "localhost";
$user = "usuario_bd"; 
$pass = "pass_bd";
$db = "intranet";

// El Centro ha activado el módulo de gestión de la Biblioteca de la Intranet y dispone de 
// una base de datos donde se han importado los fondos de la misma. Se habilita la consulta de
// estos fondos desde la Intranet
$mod_biblio=1;
if($mod_biblio==1){
//Variables para acceder a la Base de datos de  la Biblioteca si $mod_bilio = 1;
$biblio_host = "localhost";
$biblio_user = "php";
$biblio_pass = "camell";
$biblio_db = "dbiblioteca";
}

// Fotos del centro. Valores posibles:1 ó 0
$mod_fotos=1;

// Directorio para los Departamentos en el directorio de documentación. Valores posibles:1 ó 0
$mod_departamentos=1;

// Estilo de la web. Comenta / descomenta para cambiar el estilo, colores y tipografías de estas páginas

//$css_estilo = "bootstrap.min_cerulean.css";
//$css_estilo = "bootstrap.min_cosmo.css";
//$css_estilo = "bootstrap.min_cyborg.css";
//$css_estilo = "bootstrap.min_default.css";
//$css_estilo = "bootstrap.min_flatly.css";
//$css_estilo = "bootstrap.min_journal.css";
//$css_estilo = "bootstrap.min_metro.css";
//$css_estilo = "bootstrap.min_readable.css";
//$css_estilo = "bootstrap.min_simplex.css";
//$css_estilo = "bootstrap.min_slate.css";
//$css_estilo = "bootstrap.min_superhero.css";
$css_estilo = "bootstrap.min_united.css";

// Fin del cambio de estilo


// Sólo válido para nuestro Centro: IES Monterroso
if(stristr($_SERVER['SERVER_NAME'],"monterroso")==TRUE){
	$monterroso=1;
}
// Fin Monterroso


// En la página principal aparecen a la izquierda dos categorías relacionadas con los Proyectos en los que podría participar el Centro, y un conjunto de enlaces a páginas que el Centro considera interesantes para la comunidad educativa.

//Proyectos en los que participa el Centro. Sigue el esquema: dirección web del proyecto - Nombre del Proyecto.
$proyectos=array(
    "http://www.juntadeandalucia.es/educacion/lecturaybiblioteca"=>"Lectura y Biblioteca",
    "http://www.juntadeandalucia.es/averroes/impe/web/portadaEntidad?pag=/contenidos/B/InnovacionEInvestigacion/ProyectosInnovadores/EscuelaEspacioDePaz/"=>"Escuela: Espacio de Paz",
    "http://www.juntadeandalucia.es/averroes/impe/web/portadaEntidad?pag=/contenidos/B/InnovacionEInvestigacion/ProyectosInnovadores/DeporteEnLaEscuela/"=>"Deporte en la Escuela",
	"http://www.juntadeandalucia.es/averroes/impe/web/portadaEntidad?pag=/contenidos/B/InnovacionEInvestigacion/ProyectosInnovadores/IntegracionDeLasTIC/"=>"Centro TIC",
	"http://www.juntadeandalucia.es/averroes/bilingue/"=>"Centro Bilingue",						
    "http://www.juntadeandalucia.es/averroes/impe/web/contenido?pag=/contenidos/B/ProfesoradoEnRed/OrientacionEducativa/Seccion/ProgramaAcompanamiento/PresentacionAcompanamiento&idMenu=mE4&idSeccion=27391"=>"Plan de Acompañamiento",
    "http://www.juntadeandalucia.es/averroes/impe/web/contenido?pag=/contenidos/B/InnovacionEInvestigacion/ProyectosInnovadores/EscuelaSaludable/Seccion/Forma_joven/forma_joven"=>"Forma Joven");

// Enlaces de interés
$enlaces=array(
    "http://erasmusmonterroso.blogspot.com.es"=>"Erasmus+ con Alemania",		
    "http://iesmonterroso.org/dbiblioteca"=>"Biblioteca",
    "http://misionesdegrupo.blogspot.com.es/"=>"Misiones de grupo",
    "http://iesmonterroso2014.blogspot.com"=>"Blog viaje 2º Bachillerato",
    "http://feiemonterroso.blogspot.com.es/"=>"DFEIE",
	"http://allegralia.blogspot.com.es"=>"Blog de Música",
	"http://sectionfle.wordpress.com"=>"Blog de Francés",
	"http://feiemonterroso.blogspot.com.es/"=>"Departamento de Formación",
	"http://bilimonterroso.symbaloo.com"=>"Portal de Bilinguismo",	
	"http://trinity.iesmonterroso.org"=>"Pruebas del Trinity");

// Fin Categorías de Proyectos y enlaces


// Si el Centro dispone de una plataforma Moodle a la que enlazar $moodle=1;
// Si el Centro no dispone de una plataforma Moodle a la que enlazar $moodle=0;
$moodle=1;

						
?>