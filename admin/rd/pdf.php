<?
session_start ();
include ("../../config.php");
if ($_SESSION ['autentificado'] != '1') {
	session_destroy ();
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
$profesor = $_SESSION ['profi'];
?>
<?
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['imprimir'])) {$imprimir = $_GET['imprimir'];}elseif (isset($_POST['imprimir'])) {$imprimir = $_POST['imprimir'];}else{$imprimir="";}

require_once("../../pdf/dompdf_config.inc.php"); 

if ($imprimir=="1") {
		mysql_query("update r_departamento set impreso = '1' where id = '$id'");
}
	$query = "SELECT contenido, fecha, departamento FROM r_departamento WHERE id = '$id'";
   	$result = mysql_query($query) or die ("Error en la Consulta: $query. " . mysql_error());
   	if (mysql_num_rows($result) > 0)
   	{
   		$row = mysql_fetch_array($result);
   		$contenido = $row[0];
   		$fecha = $row[1];
   		$departamento = $row[2];
   	}
 
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->render();
$dompdf->stream("Reunion Departamento $departamento $fecha.pdf", array("Attachment" => 0));

?>