<?
$hoy = date('Y')."-".date('m')."-".date('d');
$num_au = mysql_query("SELECT profesor, id, tareas FROM ausencias WHERE date(inicio) <= '$hoy' and date(fin) >= '$hoy'");
if(mysql_num_rows($num_au)>0) {
?>
<div class="widget widget-nopad stacked visible-desktop">
						
	<div class="widget-header">
		<i class="icon icon-user"></i>
		<h3>Profesorado ausente</h3>
		<div class="btn-group hidden-phone pull-right">
				<a href="admin/ausencias/diario.php" class="btn"><i class="icon-th-list"></i> <small>Ausentes hoy</small></a>
				<!--
				<a href="javascript:;" class="btn"><i class="icon-cog"></i> <small>Pref.</small></a>
				-->
		</div>
	</div> <!-- /widget-header -->
	
	<div class="widget-content">
		
		<ul class="search-items">
<?php
$result = mysql_query("SELECT profesor, id, tareas from ausencias where  date(inicio) <= '$hoy' and date(fin) >= '$hoy'");

while ($row = mysql_fetch_array($result)) {
	$t_b='';
	
	if (strlen($row[2]) > '1') {
		$t_b='<i class="icon icon-star"> </i>';
	}
	else{
		$t_b='<i class="icon icon-star-empty"> </i>';
	}
?>

			<li>
				<div class="search-item-detail">
					<a href="admin/ausencias/baja.php?profe_baja=<?= $row['profesor']; ?>&id=<?= $row['id']; ?>"><?= $t_b; ?> <?= $row['profesor']; ?></a>
				</div>
			</li>
<?php
}
?>
		</ul>
		
	</div> <!-- /widget-content -->
	
</div> <!-- /widget -->
<?php
}
?>