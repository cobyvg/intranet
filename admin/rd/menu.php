<?
$activo1="";
$activo2="";
if (strstr($_SERVER['REQUEST_URI'],'add.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index_admin.php')==TRUE) {$activo2 = ' class="active" ';}
?>
 <div class="container">   
          <ul class="nav nav-tabs">
 <li <? echo $activo1;?>><a href="add.php">Nueva Acta</a></li>                 		
 <?
          if (strstr($_SESSION['cargo'],"1") == TRUE) {
          	?>
          	<li <? echo $activo2;?>><a href="index_admin.php">Todas las Actas</a></li>
          	<?
          }
          ?>
<form method="post" action="buscar.php" class="form-search">
      	<div class="input-append pull-right">
    <input type="search" class="search-query" placeholder="Buscar en las Actas" name="expresion" onClick="this.value=''">   
    <button type="submit" class="btn btn-success">Buscar</button>
  		</div>    
</form>          
    </ul>
        </div>
        </div>
