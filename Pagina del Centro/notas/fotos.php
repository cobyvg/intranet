<? 
session_start();
if($_SESSION['aut']<>1)
{
header("location:http://iesmonterroso.org");
exit;	
}

	$clave_al = $_SESSION['clave_al'];
	$todosdatos = $_SESSION['todosdatos'];
	$unidad = $_SESSION['unidad'];
	include("../conf_principal.php");
	include("../funciones.php");
	mysql_connect ($host, $user, $pass);
	mysql_select_db ($db);
	registraPagina($_SERVER['REQUEST_URI'],$clave_al);
?>
<? include "../cabecera.php"; ?>
<? include('consultas.php'); ?>
<?
if (isset($_FILES['File'])) {$File = $_FILES['File'];}elseif (isset($_POST['File'])) {$File = $_POST['File'];}else{$File="";}

?>
<div class="span9">	
<?
if(isset($_POST['enviar'])){$enviar=$_POST['enviar'];}else{$enviar="";}   
   	echo "<h3 align='center'>$todosdatos<br /></h3>";   	
   	echo "<p class='lead muted' align='center'><i class='icon icon-picture'> </i> Fotografía del Alumno</p><br>";
?>
<?

$ft=mysql_query("select datos, tamaño from fotos where nombre = '$clave_al.jpg'");
	if (mysql_num_rows($ft)>'0') {
		$ft1=mysql_fetch_array($ft);
		$grande=$ft1[1];
		$foto_ya='1';
	}
	else{
		$foto_ya="";
		$grande="";
	}
if ($enviar and empty($File))
{
	echo "<div class='alert alert-warning' style='max-width:360px;margin:auto'><legend>Atenci&oacute;n:</legend>No has seleccionado ninguna fotograf&iacute;a. Elige una archivo con la fotografía e inténtalo de nuevo.</div><br />";
}
if (!(empty($File))) {
// ENVIO DEL FORMULARIO
if (isset($_POST['enviar'])) {
	if (stristr($_FILES['File']['type'],"image/jp")==TRUE) {
// Copiamos la foto original al servidor y recortamos para la Intranet	
		$extension="jpg";
		$n_foto=$clave_al.".".$extension;
		$arch =  $fotos_dir.$n_foto;
		move_uploaded_file($_FILES['File']['tmp_name'], $arch);
		chmod($arch,0777);
		$dir_intranet = $raiz_dir."xml/fotos/";
		copy($arch,$dir_intranet.".".$clave_al.".jpg");
		
		require('../lib/class.Images.php');
		$image = new Image($arch);
		$image->resize(240,320,'crop');
		$image->save($clave_al, $dir_intranet, 'jpg');		
		

		$arch_nuevo = $dir_intranet.$clave_al.".jpg";
		$imagen = addslashes(file_get_contents($arch_nuevo));
		//chmod($arch_nuevo,0777);
// Insertamos en Base de datos.
			$nuevo_tamaño = filesize($arch_nuevo);	
			$ft_ya=mysql_query("select * from fotos where nombre = '$clave_al.jpg'");
			if (mysql_num_rows($ft_ya)>'0') {$foto_ya='1';}else{$foto_ya='0';}
			if ($foto_ya=='1') {
				//echo "update fotos set datos=LOAD_FILE('$arch_nuevo'), fecha=now(), tamaño='$nuevo_tamaño' where nombre='$n_foto'";
				mysql_query("update fotos set datos='$imagen', fecha=now(), tamaño='$nuevo_tamaño' where nombre='$n_foto'") or die("<div class='alert alert-error'><h4>Atenci&oacute;n:</h4>Se ha producido un problema al subir tu foto a nuestro Servidor (actualización). Es conveniente que lo comuniques a la Administración del Centro.</div><br />");
			}
			else{
				//echo "insert INTO fotos (nombre, datos, fecha, tamaño) VALUES('$n_foto', LOAD_FILE('".$arch_nuevo."'),now(), '$nuevo_tamaño')";
				mysql_query("insert INTO fotos (nombre, datos, fecha, tamaño) VALUES('$n_foto', '$imagen',now(), '$nuevo_tamaño')") or die("<div class='alert alert-error'><h4>Atenci&oacute;n:</h4>Se ha producido un problema al subir tu foto a nuestro Servidor. Es conveniente que lo comuniques a la Administración del Centro.</div><br />");
			}
			if (mysql_affected_rows()>0) {
				echo "<br /><div class='alert alert-success' >Tu foto ha sido descargada sin problemas en nuestro servidor.
     	     				Recuerda que debe ser actualizada al comienzo de cada Curso escolar.</div><br />";
			}
		
}	
}
}
echo "<div class='well well-large span6 offset3'>";
echo "<div class='muted' align=center style='text-align:left'>Haz click en \"Examinar\" para seleccionar el archivo con la fotografía que quieres registrar o actualizar. El archivo de imagen debe ser JPG.</div><hr />" ;
	print("<Form action='fotos.php' METHOD=Post ENCTYPE='multipart/form-data' >");
	print("<INPUT TYPE='FILE' NAME='File' required><br /> ");
	// Repetimos consulta por si la foto ha sido actualizada
	$ft=mysql_query("select datos, tamaño from fotos where nombre = '$clave_al.jpg'");
	if (mysql_num_rows($ft)>'0') {
		$ft1=mysql_fetch_array($ft);
		$grande=$ft1[1];
		$foto_ya='1';
	}
	if ($foto_ya=='1') {
		print("<br /><INPUT TYPE=SUBMIT NAME='enviar' VALUE='Actualizar fotograf&iacute;a' class='btn btn-primary' ></FORM>\n");
	}
	else {
		print("<br /><INPUT TYPE=SUBMIT NAME='enviar' VALUE='Enviar fotograf&iacute;a' class='btn btn-primary'></FORM>");
	}

	if ($foto_ya=='1') {
		echo "<hr /><div align=center><img src='./muestra_imagen.php?clave_al=$clave_al' width='200' height='238' class='img-polaroid' /></div><br />";
	}
	else {
			echo "<hr /><div class='alert alert-warning'><h4>Atenci&oacute;n:</h4>Te recordamos que es <b><u>obligación</u></b> del alumno/a subir una fotografía como parte del proceso de matriculación en el Centro. <br /><strong>Sigue las instrucciones de esta página y hazlo cuanto antes.</strong></div><br />";
	}

  ?>


	</div>
   </div><!-- Central -->
</div><!-- Contenedor -->
</body>
</html>

