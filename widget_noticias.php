<?
// Compatibilidad con versiones anteriores
$hay = mysql_query("show tables");
while ($tabla=mysql_fetch_array($hay)) {
	if ($tabla[0]=="profes") {
	$ya_hay = mysql_query("select * from profes");
if (mysql_num_rows($ya_hay)>0) {
		mysql_query("RENAME TABLE  `profes` TO  `noticias`");
		mysql_query("ALTER TABLE  `noticias` ADD  `pagina` TINYINT( 2 ) NOT NULL");
		mysql_query("update noticias set pagina = '1'");
}
	else{
	mysql_query("RENAME TABLE  `profes` TO  `noticias`");
	mysql_query("ALTER TABLE  `noticias` ADD  `pagina` TINYINT( 2 ) NOT NULL");
		}
	}
}
?>
<div class="widget widget-nopad stacked">
						
	<div class="widget-header">
		<i class="icon icon-list-alt"></i>
		<h3>Noticias recientes</h3>
		<div class="btn-group hidden-phone pull-right">
		  <a href="admin/noticias/add.php" class="btn"><i class="icon-pencil"></i> <small>Añadir</small></a>
		  <a href="admin/noticias/list.php" class="btn"><i class="icon-th-list"></i> <small>Más noticias</small></a>
		  <!--
		  <a href="javascript:;" class="btn"><i class="icon-cog"></i> <small>Pref.</small></a>
		  -->
		</div>
	</div> <!-- /widget-header -->
	
	<div class="widget-content">

		<ul class="news-items">
<?
function nombreMes($MES) {
	switch ($MES) {
		case 1 : return ('Ene'); break;
		case 2 : return ('Feb'); break;
		case 3 : return ('Mar'); break;
		case 4 : return ('Abr'); break;
		case 5 : return ('May'); break;
		case 6 : return ('Jun'); break;
		case 7 : return ('Jul'); break;
		case 8 : return ('Ago'); break;
		case 9 : return ('Sep'); break;
		case 10 : return ('Oct'); break;
		case 11 : return ('Nov'); break;
		case 12 : return ('Dic'); break;
	}
}

function nombreMesCompleto($MES) {
	switch ($MES) {
		case 1 : return ('Enero'); break;
		case 2 : return ('Febrero'); break;
		case 3 : return ('Marzo'); break;
		case 4 : return ('Abril'); break;
		case 5 : return ('Mayo'); break;
		case 6 : return ('Junio'); break;
		case 7 : return ('Julio'); break;
		case 8 : return ('Agosto'); break;
		case 9 : return ('Septiembre'); break;
		case 10 : return ('Octubre'); break;
		case 11 : return ('Noviembre'); break;
		case 12 : return ('Diciembre'); break;
	}
}
$result = mysql_query("SELECT id, slug, content, contact, clase, fechafin, DATE_FORMAT(timestamp,'%d') AS dia, DATE_FORMAT(timestamp,'%c') AS mes FROM noticias WHERE pagina LIKE '1' ORDER BY timestamp DESC LIMIT 0, 5");

if(mysql_num_rows($result)>0) {
	while($row = mysql_fetch_array($result)) {
		
		$contenido = explode(".", strip_tags($row['content']));
		if (strlen(strip_tags($row['content'])>140 || strlen($contenido[0])>140)) {
			$contenido[0] = substr($contenido[0], 0, 140).'...';
		}
		else { $contenido[0] = $contenido[0].'.';}
		
		echo '
			<li>
				
				<div class="news-item-detail">										
					<a href="admin/noticias/story.php?id='.$row['id'].'" class="news-item-title">';
		
		if($row['fechafin'] != "0000-00-00") echo '<i class="icon-bookmark"></i> ';
		
		echo $row['slug'].'</a>
					<p class="news-item-preview">'.$contenido[0].'</p>';
		
		echo '<small>';
		if(!$row['clase']) echo 'Autor: '.$row['contact'];
		else echo 'Categoría: '.$row['clase'];
		echo '</small>';
					
		echo '
				</div>
				
				<div class="news-item-date">
					<span class="news-item-day">'.$row['dia'].'</span>
					<span class="news-item-month">'.nombreMes($row['mes']).'</span>
				</div>
			</li>';
	}
}
?>
		</ul>

	</div> <!-- /widget-content -->

</div> <!-- /widget -->	