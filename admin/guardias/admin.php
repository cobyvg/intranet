<?
session_start();
include("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


$profesor = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>

  <?
  	include("../../menu.php");
if (isset($_GET['profeso'])) {$profeso = $_GET['profeso'];}elseif (isset($_POST['profeso'])) {$profeso = $_POST['profeso'];}else{$profeso="";}
if (isset($_GET['sustituido'])) {$sustituido = $_GET['sustituido'];}elseif (isset($_POST['sustituido'])) {$sustituido = $_POST['sustituido'];}else{$sustituido="";}
if (isset($_GET['hora'])) {$hora = $_GET['hora'];}elseif (isset($_POST['hora'])) {$hora = $_POST['hora'];}else{$hora="";}
if (isset($_GET['submit2'])) {$submit2 = $_GET['submit2'];}elseif (isset($_POST['submit2'])) {$submit2 = $_POST['submit2'];}else{$submit2="";}
if (isset($_GET['gu_fecha'])) {$gu_fecha = $_GET['gu_fecha'];}elseif (isset($_POST['gu_fecha'])) {$gu_fecha = $_POST['gu_fecha'];}else{$gu_fecha="";}

  ?>
<br />
  <div class="page-header">
  <h2>Guardias de Aula <small> Registro de guardias</small></h2>
</div>
<br />
 <div class="container-fluid">  
      <div class="row">  
        <div class="col-sm-4 col-sm-offset-2" >
        <? if ($mod_horario) {
?>
<div align="left" class="well well-large">
	   <FORM action="admin.php" method="POST" name="Cursos">
          <legend>
             Selecciona Profesor </legend>
              <SELECT  name=profeso onChange="submit()" class="input input-xlarge">
              <option><? echo $profeso;?></option>
		        <?
  $profe = mysql_query(" SELECT distinct prof FROM horw where a_asig = 'GU' order by prof asc");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      echo "$opcion1";

	} while($filaprofe = mysql_fetch_array($profe));
        }
	?>
              </select>
            
          </FORM>
<? 
	if ($profeso) {
		$pr=$profeso;
		$link="1";
include("../../horario.php");
			?>

	<?
	}
	?>
    </div>
            <div class="well">
<blockquote style="text-align:justify"><strong>Instrucciones de uso.</strong><br>Selecciona el Profesor al que quieres apuntar una sustitución no registrada. Te aparecerá el horario del Profesor, para que puedas determinar con precisión la hora de la guardia (1ª hora, 2ª hora, etc) del día en cuestión. Seleccionas a continuación el Profesor sustituido. Al hacer click en el campo de la fecha, aparecerá una nueva ventana con el calendario en el que debes pinchar sobre la fecha elegida. Escribe la hora de la guardia (1, 2, 3, etc) y envía los datos.<br />Si quieres consultar el historial de guardias de un Profesor, pincha en <em>Consultar guardias y profesores</em>. Selecciona el Profesor y aparecerá un histórico con todas las sustituciones realizadas. Si pinchas en una de las fuardias de su horario, podrás ver las sutituciones de todos los profesores de esa guardia en esa hora a lo largo del curso.</blockquote>
</div>
        </div>
        <div class="col-sm-4">
        <div class="well well-large" align="left">
   	<FORM action="guardias.php" method="POST" name="f1" class="form-inline">
	<label>Profesor a sustituir<br />
              <SELECT  name="sustituido" class="input input-xlarge">
              <option><? echo $sustituido;?></option>
		        <?
  $profe = mysql_query(" SELECT distinct prof FROM horw order by prof asc");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      echo "$opcion1";

	} while($filaprofe = mysql_fetch_array($profe));
        }
	?>
              </select>
              </label>
              <hr>
	<label>Fecha de la sustitución<br />
	<input type="hidden" name="profeso" value="<? echo $profeso;?>">
	     <div class="input-group" >
            <input name="gu_fecha" type="text" class="input input-small" value="" data-date-format="DD-MM-YYYY" id="gu_fecha" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>    
</label>
<hr>
	<label>Hora de la Guardia: 
	<select name="hora" class="input input-mini">
	<option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option>
	</select>
</label>
<hr>
<input type="submit" name="submit2" value="Enviar datos" class="btn btn-success">
</form>
<br />
<a href='guardias_admin.php' class="btn btn-primary">Consultar Guardias y Profesores</a>     
</div>


           

</div>
    <?	
}
 else {
	 echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
El módulo de Horarios debe ser activado en la Configuración general de la Intranet para poder acceder a estas páginas, y ahora mismo está desactivado
          </div></div>';
 }
 ?>
<? include("../../pie.php");?>
<script>  
$(function ()  
{ 
	$('#gu_fecha').datetimepicker({
		language: 'es',
		pickTime: false
	})
});  
</script>
</BODY>
</HTML>
