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
<!DOCTYPE html>  
<html lang="es">  
  <head>  
    <meta charset="iso-8859-1">  
    <title>Intranet &middot; <?php echo $nombre_del_centro; ?></title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta name="description" content="Intranet del <?php echo $nombre_del_centro; ?>o">  
    <meta name="author" content="IESMonterroso (https://github.com/IESMonterroso/intranet/)">
      
    <link href="//<?php echo $dominio; ?>/intranet/css/bootstrap.min.css" rel="stylesheet">
    <link href="//<?php echo $dominio; ?>/intranet/css/otros.css" rel="stylesheet">
    <link href="//<?php echo $dominio; ?>/intranet/css/bootstrap-responsive.min.css" rel="stylesheet">    
    <link href="//<?php echo $dominio; ?>/intranet/css/datepicker.css" rel="stylesheet">
    <link href="//<?php echo $dominio; ?>/intranet/css/DataTable.bootstrap.css" rel="stylesheet">    
    <link href="//<?php echo $dominio; ?>/intranet/css/font-awesome.min.css" rel="stylesheet" >
    <link href="//<?php echo $dominio; ?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
    <script type="text/javascript" src="//<?php echo $dominio; ?>/intranet/js/buscarAlumnos.js"></script>                 

	<!-- TinyMCE -->
	<script src="//<?php echo $dominio; ?>/intranet/js/tinymce/tinymce.min.js"></script>
	<script>
	tinymce.init({
	        selector: "textarea",
	        language: "es",
	        plugins: [
	                "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
	                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
	                "table contextmenu directionality template textcolor paste fullpage textcolor"
	        ],
	
	        toolbar1: " undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent blockquote | spellchecker | styleselect",
	        toolbar2: "cut copy paste | searchreplace | link unlink anchor image media code | hr removeformat | table | subscript superscript | charmap | pagebreak",
	
	        menubar: false
	});
	</script>
	<!-- /TinyMCE -->

</head>

<body>
<?
?>
<?php
		include ("../../menu_solo.php");
		include ("menu.php");
		?>
<div align="center">
<div class="page-header" align="center">
  <h2>Noticias del Centro <small> Redactar Noticias</small></h2>
</div>
<br />
   <?
if(isset($_POST['submit']) and $_POST['submit']=="Añadir Noticia")
{
	$slug = $_POST['slug'];
	$content = $_POST['content'];
	$contact = $_POST['contact'];
	$ndias = $_POST['ndias'];
	$clase = $_POST['clase'];
	$intranet = $_POST['intranet'];
	$principal = $_POST['principal'];
	
	if($_POST['id']){
		$id = $_POST['id'];
		echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Estás intentando duplicar la misma noticia dos veces. ¿Quizás lo que buscas es cambiar una noticia y actualizar los datos?
</div></div>' ;
	}
	else{
		$errorList = array ();
		$count = 0;
		if (! $slug) {
			$errorList [$count] = "Entrada inválida: Asunto";
			$count ++;
		}
		if (! $content) {
			$errorList [$count] = "Entrada invalida: Contenido";
			$count ++;
		}
		if (! $contact) {
			$errorList [$count] = "Entrada invalida: Autor";
			$count ++;
		}
		if (sizeof ( $errorList ) == 0) {
			if ($ndias == "") {
				$fechafin = "";
			} else {
				$ano = date ( 'Y' );
				$mes = date ( 'm' );
				$dia0 = date ( 'd' ) + $ndias;
				$stamp = mktime ( 0, 0, 0, $mes, $dia0, $ano );
				$fechafin = date ( 'Y-m-d', $stamp );
			}
			$connection = mysql_connect ( $db_host, $db_user, $db_pass ) or die ( '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN“N:</h5>
No es posible conectar con la base de datos! Busca ayuda.
</div></div>' );
			mysql_select_db ( $db ) or die ( '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN“N:</h5>
No es posible conectar con la base de datos! Busca ayuda.
</div></div>'  );
			if ($intranet) {$pagina="1";} if ($principal) {$pagina.="2";} 
				$query2 = "INSERT INTO noticias (slug, content, contact, timestamp, clase, fechafin, pagina) VALUES('$slug', '$content', '$contact', NOW(), '$clase', '$fechafin', '$pagina')";
			$result2 = mysql_query ( $query2 ) or die ( '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN“N:</h5>
Se ha producido un error grave al insertar la noticia en la base de datos(tabla News). Busca ayuda.</div></div>' );			
			
			echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La noticia ha sido registrada correctamente.
</div></div><br />';
			
			mysql_close ( $connection );
		} else {
			echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">Se encontraron los siguientes errores: <br />';
			echo "<div align='left'><ul>";
			for($x = 0; $x < sizeof ( $errorList ); $x ++) {
				echo "<li>$errorList[$x]</li>";
			}
			echo "</ul></div></div></div><br />";
		}
	}
}
if(isset($_POST['submit1']) and $_POST['submit1']){
	$id = $_POST['id'];
	$slug = $_POST['slug'];
	$content = $_POST['content'];
	$contact = $_POST['contact'];
	$ndias = $_POST['ndias'];
	$clase = $_POST['clase'];
	$intranet = $_POST['intranet'];
	$principal = $_POST['principal'];	
	
	$errorList = array();
	$count = 0;
	if (!$slug) { $errorList[$count] = "Entrada invalida: Asunto"; $count++; }
	if (!$content) { $errorList[$count] = "Entrada inválida: Texto"; $count++; }
	if (!$contact) { $contact = $def_contact; }
	if (sizeof($errorList) == 0)		
	{
	if(empty($ndias)) {$fechafin = "";}
	else{	
		$ano = date('Y');
		$mes = date('m');
		$dia0 = date('d') + $ndias;
		$stamp = mktime(0,0,0,$mes,$dia0,$ano);
		$fechafin = date('Y-m-d',$stamp);
		}
		$connection = mysql_connect($db_host, $db_user, $db_pass) or die ("Imposible conectar con la base de datos!");
		if ($intranet) {$pagina="1";} if ($principal) {$pagina.="2";} 
		mysql_select_db($db) or die ("Imposible conectar con la base de datos!");
		$query10 = "UPDATE noticias SET slug = '$slug', content = '$content', contact = '$contact', timestamp = NOW(), clase = '$clase', fechafin = '$fechafin', pagina = '$pagina' WHERE id = '$id'";
		$result10 = mysql_query($query10) or die ("Error in query: $query10. " . mysql_error());
		
?>
<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La noticia se ha modificado correctamente en la base de datos.</div>
</div><br />
<?	}
 else {
			echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">            
			<button type="button" class="close" data-dismiss="alert">&times;</button>
Se encontraron los siguientes errores: <br />';
			echo "<div align='left'><ul>";
			for($x = 0; $x < sizeof ( $errorList ); $x ++) {
				echo "<li>$errorList[$x]</li>";
			}
			echo "</ul></div></div><br />";
		}
		}
		
	
if (isset($_GET['id']))
{
	$id = $_GET['id'];
	$connection = mysql_connect($db_host, $db_user, $db_pass) or die ( '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÃ“N:</h5>
No es posible conectar con la base de datos! Busca ayuda.
</div></div>'  );
	mysql_select_db($db);
	$query = "SELECT slug, content, contact, clase, fechafin, timestamp, pagina from noticias where id = '$id'";
	$result = mysql_query($query) or die ("Error en la Consulta: $query. " . mysql_error());
	if (mysql_num_rows($result) > 0)
	{
		$row = mysql_fetch_object($result);
		$pagina = $row->pagina;
		$dia_dif = "select DATEDIFF('$row->fechafin',current_date())";
		$dif0 = mysql_query($dia_dif);
		$dif = mysql_fetch_row($dif0);
		if($dif[0] > 0) $diff = $dif[0];	
	}
}
else{
	$id = '';
}
if (!(isset($row->slug))) {
	$row->slug="";
}
if (!(isset($row->content))) {
	$row->content="";
}
if (!(isset($row->clase))) {
	$row->clase="";
}
if (!(isset($diff))) {
	$diff="";
}
if (!(isset($pagina))) {
	$pagina="";
}
	?>
    
  <div class="well well-large" style="width:800px; text-align:left">
    <form action="add.php" method="POST">
      <input type="hidden" name="id"  value="<? echo $id; ?>">
      <label>Asunto<br />
        <input type="text" name="slug" id="forminput" class="input-block-level" value="<? echo htmlspecialchars($row->slug); ?>">
      </label>
      <label>Texto<br />
        <textarea name="content" id="editor" style="height: 500px; width: 100%;">
		<? echo $row->content; ?>
      </textarea>
      </label>
      <hr>
      <fieldset class="control-group warning">
      <label>Autor<br />
        <input type="text" name='contact' class='input-xlarge' value='<? echo $profesor;?>' readonly>
      </label>
      </fieldset>
      <?
if(strlen($_SESSION['cargo']) > '0')
{
?>
    <fieldset class="control-group success">
      <hr>
      <label>Clase<br />
        <SELECT name='clase' class='input-xlarge' value=''>
          <OPTION><? echo $row->clase; ?></OPTION>
          <option>Direcci&oacute;n del Centro</option>
          <option>Jefatura de Estudios</option>
          <option>Secretar&iacute;a</option>
          <option>Actividades Extraescolares</option>
          <option>Proyecto Escuela de Paz</option>
          <option>Centro Biling&uuml;e</option>
          <option>Centro TIC</option>
          <option>Ciclos Formativos</option>
        </select>
      </label>
      </fieldset>
      <?
}
?>
      <?
if(stristr($_SESSION['cargo'],'1') == TRUE)
{
?>
    <fieldset class="control-group">
      <hr>
      <p class="lead">Noticia Fija</p>
      <label>Número de Días para mantener la Noticia Fija:
        <input maxlength="2" type="text" name="ndias" class="input-mini" value="<? echo $diff; ?>">
      </label>
       <hr>
      <p class="lead">Página donde se publica</p>
      <label class="checkbox">
        <input type="checkbox" name="intranet" value="1" <? if (strstr($pagina,"1")==TRUE) { echo "checked";} ?> />
        <p>Enviar noticia a la Intranet</p> 
      </label>
      <label class="checkbox">
        <input type="checkbox" name="principal" <? if (strstr($pagina,"2")==TRUE) { echo "checked";} ?> value="2" />
        <p>Enviar noticia a la Página del Centro</p>
      </label>
      
      </fieldset>
      <?
}
else{
?>
<input type="hidden" name="intranet" value="1" />
<?
}
?>
      <hr>
     <?
      if($id){
		  ?>
		  <input type="hidden" name="fech_princ" value="<? echo $row->timestamp;?>" />
		  <input type="hidden" name="id" value="<? echo $id;?>" />
          <input class="btn btn-danger" type="submit" name="submit1" value="Actualizar Noticia" >
		  <? 
      } 
?>
      <input type="submit" name="submit" value="Añadir Noticia" class="btn btn-primary">
 
    </form>
 
  </div>
</div>
<? include("../../pie.php"); ?>
</body>
</html>
