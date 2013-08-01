  <?
$activo1="";
$activo2="";
$activo3="";
$activo4="";
if (strstr($_SERVER['REQUEST_URI'],'protocolo.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'/intranet/TIC/documentos.php')==TRUE) {$activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'cpartes')==TRUE or strstr($_SERVER['REQUEST_URI'],'edparte')==TRUE or strstr($_SERVER['REQUEST_URI'],'clista')==TRUE) {$activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'usuarioprofesor')==TRUE) {$activo4 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'intro')==TRUE) {$activo5 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'informes')==TRUE) {$activo6 = ' class="active" ';}
?>
 <div class="container">   
          <ul class="nav nav-tabs">
<li <? echo $activo1;?>><a href="http://<? echo $dominio; ?>/intranet/TIC/protocolo.php">Protocolo de Uso</a></li>
<!--    
	<li <? echo $activo1;?>><a href="http://<? echo $dominio; ?>/intranet/admin/recursos/index.php">Recursos Educativos</a></li>
 -->    
 	<li <? echo $activo2;?>><a href="http://<? echo $dominio; ?>/intranet/TIC/documentos.php">Documentos</a></li>
    <li <? echo $activo3;?>><a href="http://<? echo $dominio; ?>/intranet/TIC/cpartes.php">Registrar Incidencias</a></li>
    <li <? echo $activo4;?>><a href="http://<? echo $dominio; ?>/intranet/TIC/usuarios/usuarioprofesor.php">Usuario Profesor</a></li>
	<li <? echo $activo5;?>><a href="http://<? echo $dominio; ?>/intranet/TIC/usuarios/intro.php">Usuario Alumno</a></li>
    <li <? echo $activo6;?>><a href="http://<? echo $dominio; ?>/intranet/reservas/informes.php">Estad&iacute;sticas</a></li>
  
    </ul>
        </div>
        </div>