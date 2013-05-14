
<p class="lead">Novedades en la Consejería</p>
<small>(<?
fecha_actual ();
echo " " . date ( "H:i:s" );
?>) </small>
<br />
<br />
<?
require_once ('magpierss/rss_fetch.inc');
define ( "MAGPIE_CACHE_ON", 1 );
define ( "MAGPIE_CACHE_AGE", 60*60 );
//define('MAGPIECACHEDIR', './cache')
$url = "http://www.juntadeandalucia.es/educacion/www/novedades.xml";
$num_items = 5;
$rss = fetch_rss ( $url );
$items = array_slice ( $rss->items, 0, $num_items );

foreach ( $items as $item ) {
	$href = $item ['link'];
	$title = $item ['title'];
	$tit = explode ( " ", $title );
	$num = count ( $tit );
	echo "";
		
	echo "<blockquote><p><a href=$href>";
	for($i = 0; $i < 5; $i ++)
	echo " ".$tit [$i]." " ;
	for($i = 5; $i < $num; $i ++)
	echo " " . $tit [$i] . " ";
		
	echo "</a></p></blockquote>";
}
?>
<hr>