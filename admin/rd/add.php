<?
ini_set("session.cookie_lifetime","5600"); 
ini_set("session.gc_maxlifetime","7200");
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
<title>Intranet</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Intranet del http://<? echo $nombre_del_centro;?>/">
<meta name="author" content="">
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.min.css" rel="stylesheet">    
    <link href="http://<? echo $dominio;?>/intranet/css/datepicker.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/DataTable.bootstrap.css" rel="stylesheet">    
    <link href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css" rel="stylesheet" >
    <link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">

<script src="http://<? echo $dominio;?>/intranet/js/tinymce/tinymce.min.js"></script>
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
include ("../../menu_solo.php");
include ("menu.php");

mysql_select_db($db);
mysql_query("CREATE TABLE IF NOT EXISTS r_departamento (
`id` SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
`contenido` LONGTEXT NOT NULL ,
`jefedep` VARCHAR( 255 ) DEFAULT NULL ,
`timestamp` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`departamento` VARCHAR( 48 ) DEFAULT NULL ,
`fecha` DATE NOT NULL ,
`impreso` TINYINT( 1 ) NOT NULL ,
`numero` INT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1");

mysql_query("CREATE TABLE IF NOT EXISTS r_departamento_backup (
`id` SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
`contenido` LONGTEXT NOT NULL ,
`jefedep` VARCHAR( 255 ) DEFAULT NULL ,
`timestamp` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`departamento` VARCHAR( 48 ) DEFAULT NULL ,
`fecha` DATE NOT NULL ,
`numero` INT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1");

if (empty($departamento) and stristr($_SESSION['cargo'],'4') == TRUE){
	$departamento=$_SESSION['dpt'];
	$departament=$departamento;
/*if ($departamento=="FrancÃ©s P.E.S." or $departamento=="AlemÃ¡n P.E.S.") {
		$departament=="FrancÃ©s y AlemÃ¡n P.E.S.";
	}*/
}
else{
	$departament="Dirección del Centro";
}
?>
<div align="center">

  <?
  echo '<div class="page-header">
  <h2>Actas del Departamento <small> Registro de Reuniones</small></h2>
  <h3 style="color:#08c;">'.$departament.'</h3>
</div>
<br />';
		?>
<?
if($borrar=="1"){
$query = "DELETE from r_departamento WHERE id = '$id'";
$result = mysql_query($query) or die ('<div align="center">
<div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Se ha borrado el registro de la base de datos.          
</div>
</div>');
}
if($edicion=="1"){
$ed0 = mysql_query("select * from r_departamento where id = '$id'");
$ed = mysql_fetch_object($ed0);
}
   if($submit=="Registrar Acta del Departamento")
   {
   		$errorList = array ();
   		$count = 0;
   		if (!$contenido) { $errorList[$count] = "Entrada inválida: Contenido del Acta"; $count++; }
   		if (!$fecha) { $errorList[$count] = "Entrada inválida: Fecha"; $count++; }		
   		$tr_fecha = explode("-",$fecha);
   		$fecha = "$tr_fecha[2]-$tr_fecha[1]-$tr_fecha[0]";
   		if (sizeof ( $errorList ) == 0) {
 		if (strstr($contenido,"_____________")==TRUE) {
 			$fecha_real = formatea_fecha($fecha);
 			$contenido = str_replace("_____________",$fecha_real,$contenido);
 		}
   			$query1 = "INSERT INTO r_departamento ( contenido, jefedep, timestamp, departamento, fecha, numero) VALUES( '$contenido', '$jefedep', NOW(), '$departament', '$fecha', '$numero')";
   			//echo $query1;
   			$query2 = "INSERT INTO r_departamento_backup ( contenido, jefedep, timestamp, departamento, fecha, numero) VALUES('$contenido', '$jefedep', NOW(), '$departament', '$fecha', '$numero')";
   			$result1 = mysql_query ( $query1 ) or die ( '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Se ha producido un error grave al registar el Acta en la base de datos. Busca ayuda.</div></div>' );
   			echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Acta del Departamento ha sido registrada correctamente.
</div></div><br />';
			$result2 = mysql_query ( $query2 );
			echo '<div align="center"><a href="add.php" class="btn btn-primary">Volver atrás</a></div>';
   		   exit();
   		} 
   		else {
   			echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">Se encontraron los siguientes errores al enviar los datos del formulario: <br />';
   			echo "<div align='left'><ul>";
   			for($x = 0; $x < sizeof ( $errorList ); $x ++) {
   				echo "<li>$errorList[$x]</li>";
   			}
   			echo "</ul></div></div></div><br />";
   		}
   	}

   	elseif ($actualiza) {
   		   mysql_query("update r_departamento set contenido = '$contenido' where id = '$id'") ;
   		   echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Acta del Departamento ha sido actualizada correctamente.
</div></div><br />';
   		   echo '<div align="center"><a href="add.php" class="btn btn-primary">Volver atrás</a></div>';
   		   exit();
   		   
   	}
$nm0 = mysql_query("select max(numero) from r_departamento where departamento = '$departament'");
$numer = mysql_fetch_array($nm0);
if ($edicion=="1") {
	$numero = $ed->numero;
}
else{
$numero = $numer[0]+1;
}
$fecha2 = date ( 'Y-m-d' );
$hoy = formatea_fecha ( $fecha2 );
$d_rd0 = mysql_query("select hora from horw where prof = '$profesor' and a_asig = 'RD'");
$d_rd = mysql_fetch_array($d_rd0);
$hor = $d_rd[0];
$reunion = array("1" => "8.15","2" => "9.15","3" => "10.15","4" => "11.45","5" => "12.45","6" => "13.45", "10" => "17");
foreach ($reunion as $key => $val){
	if ($key == $hor){
		$hora = $val;
	}
}
if ($edicion=="1") {
	$fecha_r =  $ed->fecha;
}

	?>
<div class="container-fluid">
<div class="row-fluid">
<div class="span7 offset1">	

    <form action="add.php" method="POST" name='f1' class="form-inline">
      <label style="display:inline">Fecha de la Reunión &nbsp;
      <div class="input-append" >
            <input name="fecha" type="text" class="input input-small" data-date-format="dd-mm-yyyy" required id="fecha" value="<? if (isset($fecha_r)) {
            	echo $fecha_r;
            }?>" >
  <span class="add-on"><i class="icon-calendar"></i></span>
</div> 
</label>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label style="display:inline">Nº de Acta &nbsp;
      <input class="input-mini" type="text" name="numero"  value="<? echo $numero; ?>">
</label>
<br /><br />
      <label>
        <textarea name="contenido" id="editor" style="width:100%;height:450px;">
<? if ($edicion=="1") {
	echo $ed->contenido;
}
else{
?>	
         <script type="text/php">

        if ( isset($pdf) ) {

          $font = Font_Metrics::get_font("helvetica", "bold");
          $pdf->page_text(542, 775, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));

        }
        </script>
		<p style="text-align: left;">
		<?
if ($departament == "Dirección del Centro") {
	$texto_dep = $departament;
}
else{
	$texto_dep = "Departamento de $departament";
}
		?>
		
		<? echo $texto_dep; ?><br /><? echo $nombre_del_centro ?> (<? echo $localidad_del_centro ?>) <br />Curso Escolar: <? echo $curso_actual;?><br /> Acta N&ordm; <? echo $numero; ?></p>
<p style="text-align: center;">&nbsp;</p>
<p style="text-align: center;"><span style="text-decoration: underline;"><strong>ACTA DE REUNIÓN DEL DEPARTAMENTO</strong></p>
<br />
<p align="JUSTIFY">En Estepona, a las <? echo $hora;?> horas del _____________, se re&uacute;ne el Departamento de <? echo $departament; ?> del <? echo $nombre_del_centro ?> de <? echo $localidad_del_centro ?>, con el siguiente <span style="text-decoration: underline;"> orden del d&iacute;a:</p>
<br />
<br />
<br />
<br />
<br />
<p align="JUSTIFY"><u>Profesores Asistentes:</u></p>
<p align="JUSTIFY"></p>
<p align="JUSTIFY"><u>Profesores&nbsp;Ausentes:</u></p>
<p align="JUSTIFY"></p>
<?
}
?>
      </textarea>
      </label>
      <hr>
      <fieldset class="control-group warning">
      <label>Jefe del Departamento<br />
        <input type="text" name='jefedep' class='input-xlarge' value='<? echo $profesor;?>' readonly>
      </label>
      </fieldset>

      <hr>
      <?
if ($edicion=="1") {
	echo '<input type="hidden" name="id" value="'.$id.'" class="btn btn-primary">';
	echo '<input type="submit" name="actualiza" value="Actualizar Acta del Departamento" class="btn btn-primary">';
}
else{
	echo '<input type="submit" name="submit" value="Registrar Acta del Departamento" class="btn btn-primary">';
}
      ?>

    </form>

 </div>
 <div class="span3">

<?
if($pag == "") {$pag = "0";} else {$pag = $pag + 25;}
$query = "SELECT id, fecha, departamento, contenido, numero, impreso FROM r_departamento where departamento = '$departament' ORDER BY numero DESC limit $pag,25";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
$n_actas = mysql_num_rows($result);
if (mysql_num_rows($result) > 0)
{
?>
<p class="help-block" align="left">(*) Tened en cuenta que las actas se bloquean en el momento en que hagáis click en el botón de '<b>Imprimir</b>'. A partir de entonces pueden verse (botón de la lupa) pero no es posible editarlas.</p>
	<TABLE class="table table-striped pull-left" style="width:97%;">
	<thead><th colspan="3">Actas del departamento</th></thead><tbody>
<?	while($row = mysql_fetch_object($result))
	{
	?>
      <TR> 
      <TD nowrap><? echo $row->numero; ?></td> 
		<TD nowrap><? echo fecha_sin($row->fecha); ?></td>        
        <TD>
        <?
	if(($row->departamento == $_SESSION['dpt']) or (strstr($_SESSION['cargo'],"1") == TRUE)){	
		?>
<a href="story.php?id=<? echo $row->id; ?>"  style="color:#08c;margin-right:10px;"><i class="icon icon-search" rel="Tooltip" title='Ver el Acta'> </i></a> 
<? 
if($row->impreso<>1){
?>
<a href="add.php?edicion=1&id=<? echo $row->id; ?>"  style="color:#08c;margin-right:10px;"><i class="icon icon-pencil" rel="Tooltip" title='Editar el Acta'> </i></a> 
<a href="pdf.php?id=<? echo $row->id; ?>&imprimir=1"  style="color:#990000;margin-right:10px"> <i class="icon icon-print" rel="Tooltip" title='Crear PDF del Acta para imprimir o guardar'> </i></a>
<a href="add.php?borrar=1&id=<? echo $row->id; ?>"  style="color:#08c;margin-right:10px;"><i class="icon icon-trash" rel="Tooltip" title='Borrar el Acta'> </i></a> 
<?
}
else{
?>
<a href="#"  style="color:#990000;margin-right:10px"><i class="icon icon-ok" rel="Tooltip" title='El Acta no puede editarse por haber sido impresa.'> </i></a> 
<a href="pdf.php?id=<? echo $row->id; ?>"  style="color:#990000;margin-right:10px"> <i class="icon icon-print" rel="Tooltip" title='Crear PDF del Acta para imprimir o guardar'> </i></a>
<?
}
?>
</td>
<?
		}
		?>
      </tr>
	<?
	}
	echo "</tbody></TABLE>";
}
else
{
?>
<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-disiss="alert">&times;</button>
            <h5>ATENCIÓN:</h5>
            No hay Actas disponibles en la base de datos. Tu puedes ser el primero en inaugurar la lista.
          </div></div>
		  <?
}

// close connection
?>
</div>
<?
if ($n_actas > 24) {
	?>
	<div align="center"><a href="list.php?pag=<? echo $pag;?>" class="btn btn-primary">Siguientes 25 Actas</a></div>
	<?
}
?>
</div>
<? include("../../pie.php"); ?>
	<script>  
	$(function ()  
	{ 
		$('#fecha').datepicker()
		.on('changeDate', function(ev){
			$('#fecha').datepicker('hide');
		});
		});  
	</script>
</body>
</html>
