<?
$activo1="";
if (strstr($_SERVER['REQUEST_URI'],'add.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'list.php')==TRUE) {$activo2 = ' class="active" ';}
?>
 <div class="container">   
          <ul class="nav nav-tabs">
 			<li <? echo $activo1;?>><a href="add.php">Añadir noticia</a></li>           
      		<li <? echo $activo2;?>><a href="list.php">Todas las noticias</a></li>
 
 
<form method="post" action="buscar.php" class="form-search">
      	<div class="input-append pull-right">
    <input type="search" class="search-query" placeholder="Buscar en Noticias y Mensajes" name="expresion" onClick="this.value=''">   
    <button type="submit" class="btn btn-success">Buscar</button>
  		</div>    
</form>
 
    	</ul>
        </div>
