<?
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['eliminar'])) {$id = $_GET['eliminar'];}elseif (isset($_POST['eliminar'])) {$eliminar = $_POST['eliminar'];}else{$eliminar="";}
if (isset($_GET['enviar'])) {$enviar = $_GET['enviar'];}elseif (isset($_POST['enviar'])) {$enviar = $_POST['enviar'];}else{$enviar="";}
if (isset($_GET['crear'])) {$crear = $_GET['crear'];}elseif (isset($_POST['crear'])) {$crear = $_POST['crear'];}else{$crear="";}
if (isset($_GET['buscar'])) {$buscar = $_GET['buscar'];}elseif (isset($_POST['buscar'])) {$buscar = $_POST['buscar'];}else{$buscar="";}
if (isset($_GET['modificar'])) {$modificar = $_GET['modificar'];}elseif (isset($_POST['modificar'])) {$modificar = $_POST['modificar'];}else{$modificar="";}
if (isset($_GET['confirmado'])) {$confirmado = $_GET['confirmado'];}elseif (isset($_POST['confirmado'])) {$confirmado = $_POST['confirmado'];}else{$confirmado="";}
if (isset($_GET['calendario'])) {$calendario = $_GET['calendario'];}elseif (isset($_POST['calendario'])) {$calendario = $_POST['calendario'];}else{$calendario="";}
if (isset($_GET['detalles'])) {$detalles = $_GET['detalles'];}elseif (isset($_POST['detalles'])) {$detalles = $_POST['detalles'];}else{$detalles="";}

if (isset($_GET['departamento'])) {$departamento = $_GET['departamento'];}elseif (isset($_POST['departamento'])) {$departamento = $_POST['departamento'];}else{$departamento="";}
if (isset($_GET['act_calendario'])) {$act_calendario = $_GET['act_calendario'];}elseif (isset($_POST['act_calendario'])) {$act_calendario = $_POST['act_calendario'];}else{$act_calendario="";}
if (isset($_GET['fecha'])) {$fecha = $_GET['fecha'];}elseif (isset($_POST['fecha'])) {$fecha = $_POST['fecha'];}else{$fecha="";}
if (isset($_GET['fecha_act'])) {$fecha_act = $_GET['fecha_act'];}elseif (isset($_POST['fecha_act'])) {$fecha_act = $_POST['fecha_act'];}else{$fecha_act="";}
if (isset($_GET['horario'])) {$horario = $_GET['horario'];}elseif (isset($_POST['horario'])) {$horario = $_POST['horario'];}else{$horario="";}
if (isset($_GET['profesor'])) {$profesor = $_GET['profesor'];}elseif (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];}else{$profesor="";}
if (isset($_GET['actividad'])) {$actividad = $_GET['actividad'];}elseif (isset($_POST['actividad'])) {$actividad = $_POST['actividad'];}else{$actividad="";}
if (isset($_GET['descripcion'])) {$descripcion = $_GET['descripcion'];}elseif (isset($_POST['descripcion'])) {$descripcion = $_POST['descripcion'];}else{$descripcion="";}
if (isset($_GET['justificacion'])) {$justificacion = $_GET['justificacion'];}elseif (isset($_POST['justificacion'])) {$justificacion = $_POST['justificacion'];}else{$justificacion="";}
if (isset($_GET['hoy'])) {$hoy = $_GET['hoy'];}elseif (isset($_POST['hoy'])) {$hoy = $_POST['hoy'];}else{$hoy="";}
if (isset($_GET['expresion'])) {$expresion = $_GET['expresion'];}elseif (isset($_POST['expresion'])) {$expresion = $_POST['expresion'];}else{$expresion="";}

$activo1="";
$activo2="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'indexextra.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE){ $activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'consulta.php')==TRUE){ $activo3 = ' class="active" ';}
?>
    <div class="container">  
          <ul class="nav nav-tabs">
<?
if (stristr ( $_SESSION ['cargo'], '5' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE) {
?>
    
       <li<? echo $activo1;?>><a href="indexextra.php">Administrar Actividades</a></li>
 <?
}
if (stristr ( $_SESSION ['cargo'], '5' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE or stristr ( $_SESSION ['cargo'], '4' ) == TRUE) {
?>
       <li<? echo $activo2;?>><a href="index.php">Introducir Nueva Actividad</a></li>
<?
}
?>
      <li<? echo $activo3;?>><a href="consulta.php">Lista de Actividades</a></li>
          
          <form method="post" action="consulta.php" class="form-search" style="margin-top:4px;"style="margin-top:4px;">
      	<div class="input-group pull-right">
    <input type="search" class="search-query" placeholder="Buscar en las Actividades" name="expresion" id="exp" onClick="this.value=''">
    <button type="submit" class="btn btn-success">Buscar</button>
  		</div>    
    </form>
    </ul>
        </div>
