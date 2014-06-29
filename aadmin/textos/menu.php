<?
$activo1="";
$activo2="";
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'infotut.php')==TRUE) {$activo2 = ' class="active" ';}
?>      
    <div class="container">  
  <div class="tabbable">
     <ul class="nav nav-tabs">
     <li <? echo $activo1;?>> <a href="intexto">Nuevo Libro de Texto</a></li>
     <li <? echo $activo2;?>> <a href="consult">Consultar Libros</a></li>
    </ul>
        </div>
        </div>
      