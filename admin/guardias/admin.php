<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

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

if($_SESSION['cambiar_clave']) {
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/clave.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/clave.php');
		exit();
	}
}


registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


$profesor = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');
	exit;
}
?>

<?
include("../../menu.php");
if (isset($_GET['profeso'])) {$profeso = $_GET['profeso'];}elseif (isset($_POST['profeso'])) {$profeso = $_POST['profeso'];}else{$profeso="";}
if (isset($_GET['sustituido'])) {$sustituido = $_GET['sustituido'];}elseif (isset($_POST['sustituido'])) {$sustituido = $_POST['sustituido'];}else{$sustituido="";}
if (isset($_GET['hora'])) {$hora = $_GET['hora'];}elseif (isset($_POST['hora'])) {$hora = $_POST['hora'];}else{$hora="";}
if (isset($_POST['gu_fecha'])) {$gu_fecha = $_POST['gu_fecha'];}else{$gu_fecha="";}

?>
<div class="container">
<div class="row">
<br />
<div class="page-header">
<h2>Guardias de Aula <small> Registro de guardias</small></h2>
</div>
<div class="col-sm-5 col-sm-offset-1"><br>
<? if ($mod_horario) {
	?>
<div class="well well-large">
<FORM action="admin.php" method="POST" name="Cursos">
<div class="form-group"><label> Selecciona Profesor </label> 
<SELECT
	name=profeso onChange="submit()" class="form-control" required>
	<option value="<? echo $profeso;?>"><?php echo nomprofesor($profeso); ?></option>
	<?
	$profe = mysqli_query($db_con, "SELECT distinct prof FROM horw where a_asig = 'GU' order by prof asc");
	if ($filaprofe = mysqli_fetch_array($profe))
	{
		do {

			$opcion1 = printf ('<OPTION value="'.$filaprofe[0].'">'.nomprofesor($filaprofe[0]).'</OPTION>');
			echo "$opcion1";

		} while($filaprofe = mysqli_fetch_array($profe));
	}
	?>
</select></div>
</FORM>
	<?
	if ($profeso) {
		$pr=$profeso;
		$link="1";
		include("../../horario.php");
		?> <?
	}
	?></div>
<div class="well">
<p class="text-justify"><strong>Instrucciones de uso.</strong><br>
Selecciona el Profesor al que quieres apuntar una sustitución no
registrada. Te aparecerá el horario del Profesor, para que puedas
determinar con precisión la hora de la guardia (1ª hora, 2ª hora, etc)
del día en cuestión. Seleccionas a continuación el Profesor sustituido.
Al hacer click en el campo de la fecha, aparecerá una nueva ventana con
el calendario en el que debes pinchar sobre la fecha elegida. Escribe la
hora de la guardia (1, 2, 3, etc) y envía los datos.<br />
Si quieres consultar el historial de guardias de un Profesor, pincha en
<em>Consultar guardias y profesores</em>. Selecciona el Profesor y
aparecerá un histórico con todas las sustituciones realizadas. Si
pinchas en una de las fuardias de su horario, podrás ver las
sutituciones de todos los profesores de esa guardia en esa hora a lo
largo del curso.</p>
</div>
</div>
<div class="col-sm-5">
<br>
<div class="well well-large">
<FORM action="guardias.php" method="POST" name="f1">
	<input type="hidden" name="profeso" value="<? echo $profeso;?>">	<div class="form-group">
	<label>Profesor a sustituir</label>
              <SELECT  name="sustituido" class="form-control" required>
              <option value="<? echo $sustituido; ?>"><? echo nomprofesor($sustituido); ?></option>
		        <?
  $profe = mysqli_query($db_con, " SELECT distinct prof FROM horw order by prof asc");
  if ($filaprofe = mysqli_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ('<OPTION value="'.$filaprofe[0].'">'.nomprofesor($filaprofe[0]).'</OPTION>');
	      echo "$opcion1";

	} while($filaprofe = mysqli_fetch_array($profe));
        }
	?>
              </select>
    </div>    
    
    <div class="form-group" id="datetimepicker1">     
	<label>Fecha de la sustitución</label>
	     <div class="input-group">
<input name="gu_fecha" type="text" class="form-control" value="<? echo $gu_fecha;?>" data-date-format="DD-MM-YYYY" id="gu_fecha" required>
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>   
</div>


<div class="form-group">
<label>Hora de la Guardia: </label> 
<select	name="hora" class="form-control">
	<option>1</option>
	<option>2</option>
	<option>3</option>
	<option>4</option>
	<option>5</option>
	<option>6</option>
</select>
</div>

<input type="submit" name="submit2" value="Enviar datos"
	class="btn btn-success">
</form>
<br />

</div>
<a href='guardias_admin.php' class="btn btn-primary btn-block">Consultar Guardias
y Profesores</a>
</div>
</div>
</div>

	<?
}
else {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
El módulo de Horarios debe ser activado en la Configuración general de la Intranet para poder acceder a estas páginas, y ahora mismo está desactivado
          </div></div>';
}
?> <? include("../../pie.php");?> <script>  
$(function ()  
{ 
	$('#datetimepicker1').datetimepicker({
		language: 'es',
		pickTime: false
	})
});  
</script>
</BODY>
</HTML>