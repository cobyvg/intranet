 <?
$activo1="";
if (strstr($_SERVER['REQUEST_URI'],'previsiones.php')==TRUE) {$activo1 = ' class="active" ';}
?>
 <div class="container">   
          <ul class="nav nav-tabs">
      <li <? echo $activo1;?>><a href="previsiones.php"> Previsones de matrícula</a></li>

      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Consultar <b class="caret"></b></a>
        <ul class="dropdown-menu">
      <li><a href="consultas.php"> Consultar ESO</a></li>
      <li><a href="consultas_bach.php"> Consultar Bachillerato</a></li>
        </ul>
      </li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Matricular <b class="caret"></b></a>
        <ul class="dropdown-menu">
      <li><a href="index.php"> Matricular ESO</a></li>
      <li><a href="index_bach.php"> Matricular Bachillerato</a></li>
        </ul>
      </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Importar datos <b class="caret"></b></a>
        <ul class="dropdown-menu">
     <li><a href="index_primaria.php">Alumnos de Primaria</a></li>
        <li><a href="index_secundaria.php">Alumnos de Secundaria</a></li>
        </ul>
      </li>          
       
    </ul>
</div>
