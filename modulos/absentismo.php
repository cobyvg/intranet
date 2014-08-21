<?
echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><p class='lead'><i class='fa fa-bell'> </i> Informes de Absentismo</p><hr />";

while ($ausente=mysql_fetch_array($result0)) {	
	echo "<p>$ausente[1], $ausente[2] ($ausente[3]-$ausente[4]) &nbsp;&nbsp; <a href='./faltas/absentismo/index2.php?claveal=$ausente[0]&mes=$ausente[6]&inf=1' /> <span class=' pull-right'><i class='alert-link fa fa-pencil'> </i> </span></a>
	</p>";
}
?>
</div>