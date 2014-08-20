<?
ini_set("session.cookie_lifetime","5600"); 
ini_set("session.gc_maxlifetime","7200");
session_start ();
include ("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
$profesor = $_SESSION ['profi'];
if (stristr ( $_SESSION ['cargo'], '4' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE) { } else { $j_s = 'disabled'; }

include ("../../menu.php");
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

if (stristr ( $_SESSION ['cargo'], '1' ) == TRUE){
	$departament="Dirección del Centro";
}
else{
	if (empty($departamento)) {
	$departamento=$_SESSION['dpt'];
	$departament=$departamento;
	}	
}
?>
<div class="container">

  <?
  echo '<div class="page-header">
  <h2>Actas del Departamento <small> Registro de Reuniones</small></h2>
  <h3 class="text-info">'.$departament.'</h3>
</div>';
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
 			$contenido = '
<script type="text/php">
if (isset($pdf)) {
  $font = Font_Metrics::get_font("helvetica", "bold");
  $pdf->page_text(542, 775, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
}
</script>'.$contenido;
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
</div></div><br>';
			$result2 = mysql_query ( $query2 );
			echo '<div align="center"><a href="add.php" class="btn btn-primary">Volver atrás</a></div>';
   		   exit();
   		} 
   		else {
   			echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">Se encontraron los siguientes errores al enviar los datos del formulario: <br>';
   			echo "<div align='left'><ul>";
   			for($x = 0; $x < sizeof ( $errorList ); $x ++) {
   				echo "<li>$errorList[$x]</li>";
   			}
   			echo "</ul></div></div></div><br>";
   		}
   	}

   	elseif ($actualiza) {
   		   mysql_query("update r_departamento set contenido = '$contenido' where id = '$id'") ;
   		   echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Acta del Departamento ha sido actualizada correctamente.
</div></div><br>';
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
		<div class="row">
		
		
			<div class="col-sm-8">	
			
				<div class="well">

    		<form method="post" action="" name="f1">
    			
    			<div class="row">
    			
    				<div class="col-sm-5">
    					
    					<div class="form-group" id="datetimepicker1">
    						<label for="fecha">Fecha de la Reunión</label>
    						<div class="input-group">
    					  	<input type="text" class="form-control" name="fecha" id="fecha" value="<?php echo (isset($fecha_r)) ? $fecha_r : date('d-m-Y'); ?>" data-date-format="DD-MM-YYYY" required>
    					  	<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
    					  </div>
    					</div>
    					
    				</div>
    				
    				<div class="col-sm-3 col-sm-offset-4">
    					
    					<div class="form-group">
    						<label for="numero">Nº de Acta</label>
    						<input type="text" class="form-control" id="numero" name="numero" value="<? echo $numero; ?>">
    					</div>
    					
    				</div>
    			
    			</div>
    			
    			<div class="form-group">
      			<label for="editor">Acta</label>
        		<textarea class="form-control" id="editor" name="contenido">
<? if ($edicion=="1") {
echo $ed->contenido;
}
else{
?>	
<p>
<?
if ($departament == "Dirección del Centro") {
	$texto_dep = $departament;
}
else{
	$texto_dep = "Departamento de $departament";
}
?></p>

<? echo $texto_dep; ?><br><? echo $nombre_del_centro ?> (<? echo $localidad_del_centro ?>) <br>Curso Escolar: <? echo $curso_actual;?><br> Acta N&ordm; <? echo $numero; ?></p>
<p><br></p>
<p style="text-align: center; "><strong style="text-decoration: underline;">ACTA DE REUNIÓN DEL DEPARTAMENTO</strong></p>
<p><br></p>
<p>En <? echo $localidad_del_centro ?>, a las <? echo $hora;?> horas del _____________, se re&uacute;ne el Departamento de <? echo $departament; ?> del <? echo $nombre_del_centro ?> de <? echo $localidad_del_centro ?>, con el siguiente <span style="text-decoration: underline;"> orden del d&iacute;a:</span></p>
<p><br></p>
<p><br></p>
<p><br></p>
<p><u>Profesores Asistentes:</u></p>
<p><br></p>
<p><br></p>
<p><u>Profesores&nbsp;Ausentes:</u></p>
<p><br></p>
<p><br></p>
<?
}
?>
        		</textarea>
        	</div>
      
		      <div class="form-group">
			      <label for="jefedep">Jefe del Departamento</label>
			      <input type="text" class="form-control" id="jefedep" name="jefedep" value="<? echo $profesor; ?>" readonly>
		      </div>

<?
if ($edicion=="1") {
	echo '<input type="hidden" name="id" value="'.$id.'" class="btn btn-primary">';
	echo '<input type="submit" name="actualiza" value="Actualizar Acta del Departamento" class="btn btn-primary"'.$j_s.'>';
}
	else{
	echo '<input type="submit" name="submit" value="Registrar Acta del Departamento" class="btn btn-primary" '.$j_s.'>';
}
?>

    		</form>
    		
    		</div><!-- /.well -->

 			</div><!-- /.col-sm-8 -->
 			
		 <div class="col-sm-4">

<?
if($pag == "") {$pag = "0";} else {$pag = $pag + 25;}
$query = "SELECT id, fecha, departamento, contenido, numero, impreso FROM r_departamento where departamento = '$departament' ORDER BY numero DESC limit $pag,50";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
$n_actas = mysql_num_rows($result);
if (mysql_num_rows($result) > 0)
{
?>
<p class="help-block">Tened en cuenta que las actas se bloquean en el momento en que hagáis click en el botón de '<b>Imprimir</b>'. A partir de entonces pueden verse (botón de la lupa) pero no es posible editarlas.</p>
	<table class="table table-striped">
		<thead>
			<tr>
				<th colspan="3">Actas del departamento</th>
			</tr>
		</thead>
		<tbody>
			<? while($row = mysql_fetch_object($result)) { ?>
      <tr> 
	      <td nowrap><? echo $row->numero; ?></td> 
				<td nowrap><? echo fecha_sin($row->fecha); ?></td>        
	       <td nowrap>
	       	<a href="story.php?id=<? echo $row->id; ?>"><span class="fa fa-search fa-fw fa-lg" rel="tooltip" title='Ver'></span></a> 
					<? 
					if($row->impreso<>1){
					if ($j_s == 'disabled') {} else {
					?>
					<a href="pdf.php?id=<? echo $row->id; ?>&imprimir=1"><span class="fa fa-print fa-fw fa-lg" rel="tooltip" title='Imprimir'> </span></a>
					<a href="add.php?borrar=1&id=<? echo $row->id; ?>" data-bb="confirm-delete"><span class="fa fa-trash-o fa-fw fa-lg" rel="tooltip" title="Borrar el Acta"></span></a> <a href="add.php?edicion=1&id=<? echo $row->id; ?>"><span class="fa fa-pencil fa-fw fa-lg" rel="tooltip" title="Editar"></span></a> 
					<?
					}
					}
					else{
					?>
					<a href="#"><span class="fa fa-check fa-fw fa-lg" rel="tooltip" title="El acta ha sido impresa"></span></a> 
					<?
					if ($j_s == 'disabled') {} else {
					?>
					<a href="pdf.php?id=<? echo $row->id; ?>"><span class="fa fa-print fa-fw fa-lg" rel="tooltip" title="Imprimir"></span></a>
					<?
					}
					}
					?>
				</td>
      </tr>
			<?
			}
			?>
		</tbody>
	</table>
	<?
	}
	else
	{
	?>
	<div class="alert alert-warning alert-block fade in">
		<button type="button" class="close" data-disiss="alert">&times;</button>
		<h5>ATENCIÓN:</h5>
		No hay Actas disponibles en la base de datos. Tu puedes ser el primero en inaugurar la lista.
	</div>
<?
}
?>
</div>
<? if ($n_actas > 24) { ?>
<a href="list.php?pag=<? echo $pag;?>" class="btn btn-primary">Siguientes 25 actas</a>
<?
}
?>
</div>

<?php include("../../pie.php"); ?>

	<script>  
	$(function ()  
	{ 
		$('#datetimepicker1').datetimepicker({
			language: 'es',
			pickTime: false
		})
	});  

	$(document).ready(function() {
	
		// EDITOR DE TEXTO
		$('#editor').summernote({
			height: 360,
			lang: 'es-ES',
		});

	});
	</script>
</body>
</html>
