<?
$activo1="";
$activo2="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'introducir.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'buscar.php')==TRUE){ $activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE){ $activo3 = ' class="active" ';}
?>
        <div class="container">
        <div class="tabbable">
          <ul class="nav nav-tabs">

     <li <? echo $activo1;?>><a href="introducir.php">Introducir un nuevo registro</a></li>
     <li <? echo $activo2;?>> <a href="buscar.php">Buscar / Consultar / Imprimir</a></li>
     <?
     if(stristr($_SESSION ['cargo'],'1') == TRUE){?>
     <li <? echo $activo3;?>><a href="index.php">Seleccionar Departamento</a></li>
     <? }?>
    </ul>
        </div>
        </div>