<?
$activo1="";
$activo2="";
if (strstr($_SERVER['REQUEST_URI'],'intext')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'consulta')==TRUE or strstr($_SERVER['REQUEST_URI'],'editext')==TRUE) {$activo2 = ' class="active" ';}
?>      
    <div class="container">  
  <div class="tabbable">
     <ul class="nav nav-tabs">
     <li <? echo $activo1;?>> <a href="intextos.php">Nuevo Libro de Texto</a></li>
     <li <? echo $activo2;?>> <a href="consulta.php">Consultar y Editar Libros</a></li>
    </ul>
        </div>
        </div>
      