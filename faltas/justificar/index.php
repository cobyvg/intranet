<?
require('../../bootstrap.php');
	
include("../../menu.php");
include("../menu.php");
if (isset($_GET['profesor'])) {$profesor = $_GET['profesor'];} elseif (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];}
if (isset($_GET['year'])) {$year = $_GET['year'];}elseif (isset($_POST['year'])) {$year = $_POST['year'];}
if (isset($_GET['month'])) {$month = $_GET['month'];}elseif (isset($_POST['month'])) {$month = $_POST['month'];}
if (isset($_GET['today'])) {$today = $_GET['today'];}elseif (isset($_POST['today'])) {$today = $_POST['today'];}else{$today="";}
if (isset($_GET['alumno'])) {$alumno = $_GET['alumno'];}elseif (isset($_POST['alumno'])) {$alumno = $_POST['alumno'];}else{$alumno="";}
if (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];}elseif (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];}else{$unidad="";}
if (isset($_GET['falta'])) {$falta = $_GET['falta'];}elseif (isset($_POST['falta'])) {$falta = $_POST['falta'];}else{$falta="";}
?>

<div class="container">
<div class="row">

<div class="page-header">
  <h2 style="display:inline">Faltas de Asistencia <small> Justificar faltas</small></h2>
  
  <!-- Button trigger modal -->
<a href="#" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#myModal" style="display:inline">
 <span class="fa fa-question fa-lg"></span>
</a>

 <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Instrucciones de uso.</h4>
      </div>
      <div class="modal-body">
		<p class="help-block">
		Para justificar una falta selecciona en primer lugar un alumno en la columna de la derecha. Una vez el alumno aparece seleccionado elige el mes correspondiente. Aparecerán en rojo las faltas de asistencia del alumno y en verde las faltas justificadas. <br>Al hacer click sobre una celda del calendario cambiamos su estado: si está vacía se pone roja, si está roja se pone verde, y si está verde la dejamos a cero.<br> <br>Si la falta no ha sido registrada todavía (el día del calendario no es verde ni rojo), aparecerá un cuadro de diálogo en el que deberás seleccionar las horas en que el alumno ha estado ausente. Una vez marcadas las horas de la falta podrás justificarlas haciendo click de nuevo sobre el día elegido.
		</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</div>
  
    <?php
// Se presenta la estructura de las tablas del formulario.
include("estructura.php");
?>
</form>
<? 
mysqli_close();
include("../../pie.php"); ?>
</body>
</html>
