<?
$activo1="";
$activo2="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index_cal.php')==TRUE){ $activo2 = ' class="active" ';}
?>
    <div class="container">  
          <ul class="nav nav-tabs">
        <li<? echo $activo1;?>><a href="index.php">Registro de Examen/Actividad</a></li>	
        <li<? echo $activo2;?>><a href="index_cal.php">Calendario de Actividades por Grupo</a></li>	
    </ul>
        </div>
