	<div class="container">
				<form method="get" action="buscar.php">
		
			<div class="navbar-search pull-right col-sm-3">
			   <div class="input-group">
			     <input type="text" class="form-control input-sm" id="q" name="q" value="<?php echo (isset($_GET['q'])) ? $_GET['q'] : '' ; ?>" placeholder="Buscar mensajes...">
			     <span class="input-group-btn">
			       <button class="btn btn-default btn-sm" type="submit"><span class="fa fa-search fa-lg"></span></button>
			     </span>
			   </div><!-- /input-group -->
			 </div><!-- /.col-lg-3-->
			 
		</form>	
		<ul class="nav nav-tabs">
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'inbox=recibidos')==TRUE) ? ' class="active"' : ''; ?>><a href="index.php?inbox=recibidos">Mensajes recibidos</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'inbox=enviados')==TRUE) ? ' class="active"' : ''; ?>><a href="index.php?inbox=enviados">Mensajes enviados</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'redactar.php')==TRUE) ? ' class="active"' : ''; ?>><a href="redactar.php">Redactar mensaje</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'correo.php')==TRUE) ? ' class="active"' : ''; ?>><a href="correo.php">Redactar correo</a></li>
		</ul>
		
	</div>
