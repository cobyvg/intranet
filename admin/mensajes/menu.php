<?
$activo1="";
$activo2="";
$activo3="";
$activo4="";
if (strstr($_SERVER['REQUEST_URI'],'inbox=recibidos')==TRUE) {$activo1 = ' class="active" ';}
elseif (strstr($_SERVER['REQUEST_URI'],'inbox=enviados')==TRUE) {$activo2 = ' class="active" ';}
elseif (strstr($_SERVER['REQUEST_URI'],'redactar.php')==TRUE) {$activo3 = ' class="active" ';}
elseif (strstr($_SERVER['REQUEST_URI'],'correo')==TRUE) {$activo4 = ' class="active" ';}
else $activo1=' class="active" ';
?>
 <div class="container-fluid">   
   <ul class="nav nav-tabs">
     <li <? echo $activo1;?>><a href="index.php?inbox=recibidos">Mensajes recibidos</a></li>
     <li <? echo $activo2;?>><a href="index.php?inbox=enviados">Mensajes enviados</a></li>
     <li <? echo $activo3;?>><a href="redactar.php">Redactar mensaje...</a></li>
     <li <? echo $activo4;?>><a href="correo.php">Redactar correo</a></li>
    </ul>
 </div>
        