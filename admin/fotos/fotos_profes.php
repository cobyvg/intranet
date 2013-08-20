<?
ini_set("memory_limit","192M");
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

<?php
include("../../menu.php");
$idea = $_SESSION ['ide'];
if (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];} else{$profesor="";}
?>
<br />
   <div align=center>
  <div class="page-header" align="center">
  <h2>Fotos de los Profesores <small></small></h2>
</div>
</div>
<div class="row-fluid">
<div class="span1"></div>
<div class="span5">
<h3 align="center"><? echo mb_strtolower($_SESSION['profi']); ?></h3><br />
 <div class="well" align='center' style="width:100%">
<?
	echo "<legend>Registro de fotos</legend>";
echo "<p class='help-block' style='text-align:left;'>Haz click en el botón de abajo para seleccionar el archivo con la fotografía que quieres registrar o actualizar. La fotografía debe tener una resolución mínima de 40KB y máxima de 1MB. El archivo de imagen debe ser JPG.</p>" ;
if (strlen($idea) > '5') 
{

if(file_exists("../../xml/fotos_profes/".$idea.".jpg")){
		$grande=filesize("../../xml/fotos_profes/".$idea.".jpg");
		$foto_ya='1';	
	}
}

if (isset($_POST['enviar']) and empty($_POST['File']))
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
            No has seleccionado ninguna fotograf&iacute;a. Elige una archivo con la fotografía e inténtalo de nuevo.
          </div></div>';
}
if (!(empty($File))) {
		$fotos_dir = "../../xml/fotos_profes/";
	if ($File_size>'30000' and $File_size<'1200000') {
		
		if (stristr($File_type,"image/jp")==TRUE) {
			$extension="jpg";
			$n_foto=$idea.".".$extension;
			$n_foto0=$idea."0.".$extension;
			$arch0 = $fotos_dir.$n_foto0;

			$arch = $fotos_dir.$n_foto;
			move_uploaded_file($_FILES['File']['tmp_name'], $arch0) or die("No se ha actualizado");
			chmod($arch0,0777);

			function redimensionar_jpeg($img_original, $img_nueva, $img_nueva_anchura, $img_nueva_altura, $img_nueva_calidad) {
				// crear imagen desde original
				$img = ImageCreateFromJPEG($img_original);
				// crear imagen nueva
				$thumb = ImageCreatetruecolor($img_nueva_anchura,$img_nueva_altura);
				// redimensionar imagen original copiandola en la imagen
				ImageCopyResampled($thumb,$img,0,0,0,0,$img_nueva_anchura,$img_nueva_altura,ImageSX($img),ImageSY($img));
				// guardar la imagen redimensionada donde indicia $img_nueva
				ImageJPEG($thumb,$img_nueva,$img_nueva_calidad);
			}
			// Calcular tamaño ideal
			$tam = getimagesize($arch0);
			$ancho0 = $tam[0];
			$alto0 = $tam[1];
			$cent = 600 * 100 / $ancho0;
			$cent_alto = $cent *$alto0 / 100;

			redimensionar_jpeg($arch0,$arch,600,$cent_alto,100);
			$nuevo_tamaño = filesize($arch);
			$foto_ya='1';
			unlink($arch0);
		}
		else {
			echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
El archivo que est&aacute;s enviando no es un tipo de imagen v&aacute;lido. Selecciona un archivo de imagen con formato JPG.
          </div></div>';
		}
	}
	else{
		if ($File_size< '30000') {
		echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
La fotograf&iacute;a no tiene suficiente resoluci&oacute;n, por lo que su visualizaci&oacute;n ser&aacute; necesariamente defectuosa. Es conveniente que actualizes la foto eligiendo una nueva con mayor calidad. 
          </div></div>';
		}
		else{
		echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
La fotograf&iacute;a tiene excesiva resoluci&oacute;n. Es conveniente que actualices la foto eligiendo una nueva con menor resolución (o tamaño, como quieras). 
          </div></div>';	
		}
	}
}

if (strlen($idea) > '5')
 {
	echo "<Form action='fotos_profes.php' METHOD=Post ENCTYPE='multipart/form-data'>";
	echo '<INPUT TYPE="hidden" NAME="idea" value="'.$idea.'">';
	?>
	<?
	print("<INPUT TYPE=FILE NAME='File' class='btn-mini' ><br /> ");

if(file_exists("../../xml/fotos_profes/".$idea.".jpg")){
		$grande=filesize("../../xml/fotos_profes/".$idea.".jpg");
		$foto_ya='1';	
	}
	
	echo "<br />";
	if ($foto_ya=='1') {
		print("<INPUT TYPE=SUBMIT NAME='enviar' VALUE='Actualizar fotograf&iacute;a' class='btn btn-primary' ></FORM>\n");
	}
	else {
		print("<INPUT TYPE=SUBMIT NAME='enviar' VALUE='Enviar fotograf&iacute;a' class='btn btn-primary'></FORM>");
	}

	echo "<div align='center'><hr>";
	if ($foto_ya=='1') {
		echo "<img src='../../xml/fotos_profes/".$idea.".jpg' border='2' width='100' height='119' style='margin-top:10px;border:1px solid #bbb;'  /><br /><br />";
	}
	else {
		echo "<div style='margin-top:10px;border:1px solid #bbb;width:100px;height:119px;color:#9d261d;' />Sin Foto</div><br />";
	}
	if ($foto_ya=='1' and $grande < '30000') {
						
		
		echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
La fotograf&iacute;a no tiene suficiente resoluci&oacute;n, por lo que su visualizaci&oacute;n ser&aacute; necesariamente defectuosa. Es conveniente que actualices la foto eligiendo una nueva con mayor calidad. 
          </div></div>';
	}
	if ($foto_ya=='1' and $grande > '1200000') {
		echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
La fotograf&iacute;a tiene excesiva resoluci&oacute;n. Es conveniente que actualices la foto eligiendo una nueva con menor resolución (o tamaño, como quieras). 
          </div></div>';
	}
}
  ?>
</div>
</div>
</div>
<div class="span4">
<h3 align="center">Ver fotos</h3><br />
<div class="well pull-right" style="width:80%">
  <legend> Selecciona profesor</legend>
<FORM action="fotos_profes.php" method="POST" name="fotos">
  <label>
    <select  name="profesor" class="input-xlarge" onChange="submit()">
      <option><? echo $profesor;?></option>
                    <?
  $tipo = "select distinct profesor from profesores order by profesor";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<option>".$tipo2[0]."</option>";
        }				
					?>
    </select>
  </label>
  <?
  if ($profesor) {
  	$profe0 =mysql_query("select idea from departamentos where nombre = '$profesor'");
  	$profe1 = mysql_fetch_array($profe0);
if(file_exists("../../xml/fotos_profes/".$idea.".jpg")){
		echo "<div align='center'><img src='../../xml/fotos_profes/".$profe1[0].".jpg' border='2' width='150' height='180' style='margin-top:10px;border:1px solid #bbb;'  /></div>";
	}
	echo "<br />";
  }
  ?>
   </form>
    <hr>
   <FORM action="profes.php" method="POST" name="fotos">
   <legend>Fotos del Claustro de Profesores</legend>
  <label>
    <INPUT TYPE=SUBMIT NAME='ver_todos' VALUE='Ver todas las fotos' class='btn btn-primary'>
  </label>
          </FORM>  
</div>
<? include("../../pie.php");?>
</body>
</html>
