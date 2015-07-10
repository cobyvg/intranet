<?
require('../../bootstrap.php');


$profesor = $_SESSION ['profi'];


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
   	  
         if($_SERVER['SERVER_NAME'] == 'iesmonterroso.org') {
      	  	$html .= '<html><body>';
      	  	$html .='<style type="text/css">
      	  	body {
      	  		font-size: 10pt;
      	  	}
      	  	#footer {
      	  		position: fixed;
      	  	 left: 0;
      	  		right: 0;
      	  		bottom: 0;
      	  		color: #aaa;
      	  		font-size: 0.9em;
      	  		text-align: right;
      	  	}
      	  	.page-number:before {
      	  	  content: counter(page);
      	  	}
      	  	</style>
      	  	<div id="footer">
      	  	  Página <span class="page-number"></span>
      	  	</div>';
         }
   	  	
   		$row = mysqli_fetch_array($result);
   		$contenido = $row[0];
   		$html .= mb_convert_encoding($contenido, 'UTF-8', 'ISO-8859-1');
   		$fecha = $row[1];
   		$departamento = $row[2];
   	}
 
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("Reunion Departamento $departamento $fecha.pdf", array("Attachment" => 0));

?>