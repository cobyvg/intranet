<div class="widget widget-nopad stacked visible-desktop">
						
	<div class="widget-header">
		<i class="icon icon-envelope"></i>
		<h3>Mensajes recientes</h3>
		<div class="btn-group hidden-phone pull-right">
				<!--
				<a href="javascript:;" class="btn"><i class="icon-cog"></i> <small>Pref.</small></a>
				-->
		</div>
	</div> <!-- /widget-header -->
	
	<div class="widget-content">
		
		<ul class="search-items">
<?php
$result = mysql_query ("SELECT DATE_FORMAT(ahora,'%Y-%m-%d') AS ahora, asunto, id, recibidoprofe, texto FROM mens_profes JOIN mens_texto ON mens_texto.id = mens_profes.id_texto WHERE profesor = 'admin' ORDER BY ahora DESC LIMIT 0, 5");

while($row = mysql_fetch_array($result)) {
	$dia = explode("-", $row['ahora']);

?>
			<li>
				<div class="search-item-detail">
					<a href="admin/mensajes/mensaje.php?id=<?= $row['id']; ?>" <?php if($row['recibidoprofe']==0) echo 'class="news-item-title text-success"'; ?> rel="tooltip" title="<?php if(strlen($row['texto'])>599){echo substr($row['texto'],0,600)."...";}else{echo $row[4];}?>"><?= $row['asunto']; ?> <small class="pull-right"><?= $dia[2].' '.nombreMes($dia[1]); ?></small></a>
				</div>
			</li>
<?php
}
?>
		</ul>
		
	</div> <!-- /widget-content -->
	
</div> <!-- /widget -->