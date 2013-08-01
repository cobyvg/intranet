
         <!-- Navbar
    ================================================== -->
<?
$activo1="";
$activo2="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'indexextra.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE){ $activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'consulta.php')==TRUE){ $activo3 = ' class="active" ';}
?>
    <div class="container">  
          <ul class="nav nav-tabs">
<?

if (stristr ( $_SESSION ['cargo'], '5' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE) {
	?>
    
       <li<? echo $activo1;?>><a href="indexextra.php">Administrar Actividades</a></li>
 <?
}
?>
       <li<? echo $activo2;?>><a href="index.php">Introducir Nueva Actividad</a></li>
      <li<? echo $activo3;?>><a href="consulta.php">Lista de Actividades</a></li>
          
          <form method="post" action="consulta.php" class="form-search" style="margin-top:5px;">
      	<div class="input-append pull-right">
    <input type="search" class="search-query" placeholder="Buscar en las Actividades" name="expresion" id="exp" onClick="this.value=''">
    <button type="submit" class="btn btn-success">Buscar</button>
  		</div>    
    </form>
    </ul>
        </div>
