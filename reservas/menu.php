<?
$activo1="";
$activo2="";
$activo3="";
$activo4="";
if (strstr($_SERVER['REQUEST_URI'],'index.php?recurso=aula')==TRUE OR strstr($_SERVER['REQUEST_URI'],'index.php?servicio=aula')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'recurso=aula_grupo')==TRUE OR strstr($_SERVER['REQUEST_URI'],'index_aula')==TRUE) {$activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'recurso=carrito')==TRUE OR strstr($_SERVER['REQUEST_URI'],'servicio=carrito')==TRUE) {$activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'recurso=medio')==TRUE OR strstr($_SERVER['REQUEST_URI'],'servicioo=medio')==TRUE) {$activo4 = ' class="active" ';}
?>
 <div class="container">   
          <ul class="nav nav-tabs">
<li <? echo $activo1;?>><a href="http://<? echo $dominio; ?>/intranet/reservas/index.php?recurso=aula">Aulas compartidas</a></li>
    <li <? echo $activo2;?>><a href="http://<? echo $dominio; ?>/intranet/reservas/index_aula_grupo.php?recurso=aula_grupo">Aulas de Grupo</a></li>
    <li <? echo $activo3;?>><a href="http://<? echo $dominio; ?>/intranet/reservas/index.php?recurso=carrito">Carritos de
      Port&aacute;tiles</a></li>
    <li <? echo $activo4;?>><a href="http://<? echo $dominio; ?>/intranet/reservas/index.php?recurso=medio">Videoproyectores,
            Port&aacute;tiles</a></li>
    </ul>
        </div>
