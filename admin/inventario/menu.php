    <div class="container" align="center">  
        <div class="subnav subnav-fixed">
          <ul class="nav nav-pills">

     <li><a href="introducir.php">Introducir un nuevo registro</a></li>
     <li> <a href="buscar.php">Buscar / Consultar / Imprimir</a></li>
     <?
     if(stristr($_SESSION ['cargo'],'1') == TRUE){?>
     <li><a href="index.php">Seleccionar Departamento</a></li>
     <? }?>
    </ul>
        </div>
        </div>