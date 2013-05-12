<div class="widget widget-nopad stacked visible-desktop">
						
	<div class="widget-header">
		<i class="icon icon-search"></i>
		<h3>Buscar...</h3>
	</div> <!-- /widget-header -->
	
	<div class="widget-content">
		
		<ul class="search-items">
			<li>
				<div class="search-item-detail">
					<form action="admin/noticias/buscar.php" method="POST">
						<input type="text" name="expresion" class="input-block-level" maxlength="255" placeholder="Buscar noticias y mensajes en la intranet...">
					</form>
				</div>
			</li>
			<li>
				<div class="search-item-detail">
					<form action="http://www.google.com/search" method="GET">
					    <input type="text" name="as_q" class="input-block-level" maxlength="255" placeholder="Buscar en <?= $dominio; ?>..." > 
					    <input type="hidden" name="hl" value="es">
					    <input type="hidden" name="as_sitesearch" value="<?= $dominio; ?>">
					</form>
				</div>
			</li>
		</ul>
		
	</div> <!-- /widget-content -->
	
</div> <!-- /widget -->
