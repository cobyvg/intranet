<?
$activo1="";
$activo2="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'infotut.php')==TRUE) {$activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'buscar.php')==TRUE){ $activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index_buscar.php')==TRUE){ $activo4 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'control.php')==TRUE){ $activo5 = ' class="active" ';}
?>
        <div class="container">
        <div class="tabbable">
          <ul class="nav nav-tabs">
 <li <? echo $activo1;?>> <a href="index.php">Página de Informes de Tutoría</a></li>
<?
if(stristr($_SESSION ['cargo'],'2') == TRUE or stristr($_SESSION ['cargo'],'1') == TRUE)
{
	if(stristr($_SESSION ['cargo'],'2') == TRUE){
	$tutor = $_SESSION ['tut'];
}
?>
     <li <? echo $activo2;?>><a href="infotut.php?nivel=<? echo  $_SESSION ['s_nivel'];?>&grupo=<? echo $_SESSION ['s_grupo'];?>&tutor=<? echo $tutor;?>">Activar Nuevo Informe</a></li>
     <? }?>
     <li <? echo $activo3;?>> <a href="buscar.php?todos=1">Ver Todos los Informes</a></li>
     <li <? echo $activo4;?>> <a href="index_buscar.php">Buscar Informes</a></li>
     <?
     if(stristr($_SESSION ['cargo'],'1') == TRUE){?>
     <li <? echo $activo5;?>> <a href="control.php">Control de Informes</a></li>
     <? }?>
    </ul>
        </div>
        </div>
