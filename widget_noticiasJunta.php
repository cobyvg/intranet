<?php
require_once('magpierss/rss_fetch.inc');

define('MAGPIE_CACHE_ON', 1);
define('MAGPIE_CACHE_AGE', 60*60);
//define('MAGPIECACHEDIR', './cache');

$url = "http://www.juntadeandalucia.es/educacion/www/novedades.xml";
$num_items = 5;

$rss = fetch_rss($url);
$items = array_slice($rss->items, 0, $num_items);
?>
<div class="widget widget-nopad stacked">
						
	<div class="widget-header">
		<i class="icon icon-bullhorn"></i>
		<h3><?= $rss->channel['title']; ?></h3>
		<div class="btn-group hidden-phone pull-right">
		  <a href="<?= $rss->channel['link']; ?>" target="_blank" class="btn"><i class="icon-th-list"></i> <small>Más noticias</small></a>
		  <!--
		  <a href="javascript:;" class="btn"><i class="icon-cog"></i> <small>Pref.</small></a>
		  -->
		</div>
	</div> <!-- /widget-header -->
	
	<div class="widget-content">
	
		<ul class="news-items">
<?php
foreach($items as $item) {		
	echo '
			<li>
				<div class="news-item-detail">
					<a href="'.$item['link'].'" class="news-item-title">'.$item['title'].'</a>';
					
	if ($item['description']) echo '<p>'.$item['description'].'</p>';
	
	echo '
				</div>
				
				<div class="news-item-date">
					<span class="news-item-day">'.strftime("%d", strtotime($item['pubdate'])).'</span>
					<span class="news-item-month">'.nombreMes(strftime("%m", strtotime($item['pubdate']))).'</span>
				</div>
			</li>';
}
?>
		</ul>
		
	</div> <!-- /widget-content -->
	
</div> <!-- /widget -->	