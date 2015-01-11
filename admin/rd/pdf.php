<?
session_start();
include("../../config.php");
include("../../config/version.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
$profesor = $_SESSION ['profi'];
?>
<?
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['imprimir'])) {$imprimir = $_GET['imprimir'];}elseif (isset($_POST['imprimir'])) {$imprimir = $_POST['imprimir'];}else{$imprimir="";}

require_once("../../pdf/dompdf_config.inc.php"); 

if ($imprimir=="1") {
		mysqli_query($db_con, "update r_departamento set impreso = '1' where id = '$id'");
}
	$query = "SELECT contenido, fecha, departamento FROM r_departamento WHERE id = '$id'";
   	$result = mysqli_query($db_con, $query) or die ("Error en la Consulta: $query. " . mysqli_error($db_con));
   	if (mysqli_num_rows($result) > 0)
   	{
   	
   	  
   		$row = mysqli_fetch_array($result);
   		$contenido = $row[0];
   		$html = mb_convert_encoding($contenido, 'UTF-8', 'ISO-8859-1');
   		$fecha = $row[1];
   		$departamento = $row[2];
   	}
 
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("Reunion Departamento $departamento $fecha.pdf", array("Attachment" => 0));

?>