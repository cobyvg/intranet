<?
if (isset($_GET['recurso'])) {$recurso = $_GET['recurso'];}elseif (isset($_POST['recurso'])) {$recurso = $_POST['recurso'];}else{$recurso="";}
if (isset($_GET['servicio'])) {$servicio = $_GET['servicio'];}elseif (isset($_POST['servicio'])) {$servicio = $_POST['servicio'];}else{$servicio="";}
if (isset($_GET['mens'])) {$mens = $_GET['mens'];}elseif (isset($_POST['mens'])) {$mens = $_POST['mens'];}else{$mens="";}
if (isset($_GET['servicio_aula'])) {$servicio_aula = $_GET['servicio_aula'];}elseif (isset($_POST['servicio_aula'])) {$servicio_aula = $_POST['servicio_aula'];}else{$servicio_aula="";}

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
