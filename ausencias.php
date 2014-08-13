<?
$hoy = date('Y')."-".date('m')."-".date('d');
$num_au = mysql_query("SELECT profesor, id, tareas from ausencias where  date(inicio) <= '$hoy' and date(fin) >= '$hoy'");
if(mysql_num_rows($num_au)>0){
?>
<div class='well'>
<legend><i class="fa fa-user"> </i> Profesores de Baja</legend>
<ul class="list-unstyled">
    <?
    $hoy = date('Y')."-".date('m')."-".date('d');
				$query = "SELECT profesor, id, tareas from ausencias where  date(inicio) <= '$hoy' and date(fin) >= '$hoy'";
				// echo $query;
				$result = mysql_query ( $query ) or die ( "Error in query: $query. " . mysql_error () );
				
				while ( $row = mysql_fetch_array ( $result ) ) {
					$t_b='';
					if (strlen($row[2]) > '1') {
						$t_b='<i class="fa fa-star"> </i>';
					}
					else{
						$t_b='<i class="fa fa-star-o"> </i>';
					}
					?>

<li>
<a href="admin/ausencias/baja.php?profe_baja=<?
					echo $row [0];
					?>&id=<?
					echo $row [1];
					?>" 
		style="margin-top: 0px;"><? echo $t_b; ?> <?
					echo $row [0];
					?></a>
</li>
<?
				}
				?>
</ul>
<br />
<a	href="admin/ausencias/diario.php" class="btn btn-primary">Profesores Ausentes hoy</a>
</div>
<?
}
?>