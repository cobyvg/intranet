<?
require_once ('magpierss/rss_fetch.inc');
define ( "MAGPIE_CACHE_ON", 1 );
define ( "MAGPIE_CACHE_AGE", 60*60 );
//define('MAGPIECACHEDIR', './cache')
$url = "http://www.juntadeandalucia.es/educacion/www/novedades.xml";
$num_items = 5;
$rss = fetch_rss ( $url );
$items = array_slice ( $rss->items, 0, $num_items );

echo '<legend><i class="icon icon-rss"></i> '.$rss->channel['title'].'</legend>';

foreach ( $items as $item ) {
	$href = $item ['link'];
	$title = $item ['title'];
	$time = $item ['pubdate'];
	
	setlocale(LC_TIME, "es_ES");
	echo '
	  <p><a href="'.$href.'">'.$title.'</a><br /><small>Publicado el '.strftime('%e de %B de %Y, a las %H:%Mh',strtotime($time)).'.</small></p><br />
	  ';
}
?>
<hr />