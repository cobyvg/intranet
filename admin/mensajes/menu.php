<?
$activo1="";
$activo2="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'enviados.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'recibidos.php')==TRUE) {$activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'enviados')==FALSE and strstr($_SERVER['REQUEST_URI'],'recibidos')==FALSE and strstr($_SERVER['REQUEST_URI'],'correo')==FALSE) {$activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'correo')==TRUE) {$activo4 = ' class="active" ';}
?>
 <div class="container">   
          <ul class="nav nav-tabs">
 <li <? echo $activo1;?>><a href="enviados.php">
      Mensajes Enviados</a></li>
      <li <? echo $activo2;?>><a href="recibidos.php">
      Mensajes Recibidos</a></li>
      <li <? echo $activo3;?>><a href="index.php">
      Enviar Mensaje...</a></li>
      <li <? echo $activo4;?>><a href="correo.php">
      Enviar Correo</a></li>
    </ul>
 </div>
        