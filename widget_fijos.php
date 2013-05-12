<?php
$result = mysql_query("SELECT id, slug, DATE_FORMAT(timestamp,'%Y-%m-%d') AS timestamp, content, clase FROM noticias WHERE pagina LIKE '%1%' AND fechafin > current_date() ORDER BY timestamp DESC");

if (mysql_num_rows($result)>0) {
?>
<div class="widget widget-nopad stacked visible-desktop">
						
	<div class="widget-header">
		<i class="icon icon-bookmark"></i>
		<h3>Noticias destacadas</h3>
		<div class="btn-group hidden-phone pull-right">
				<!--
				<a href="javascript:;" class="btn"><i class="icon-cog"></i> <small>Pref.</small></a>
				-->
		</div>
	</div> <!-- /widget-header -->
	
	<div class="widget-content">
		
		<ul class="search-items">
<?php
while($row = mysql_fetch_array($result)) {
	$dia = explode("-",$row['timestamp']);

	echo '
			<li>
				<div class="search-item-detail">
					<a href="admin/noticias/story.php?id='.$row['id'].'">'.$row['slug'].' <small class="pull-right">'.$dia[2].' '.nombreMes($dia[1]).'</small></a>
				</div>
			</li>';
}
?>
		</ul>
		
	</div> <!-- /widget-content -->
	
</div> <!-- /widget -->
<?php
}
?>
