<? 
 // Creamos tabla hermanos para enviar SMS al telefono de varios hermanos.
mysql_query("truncate table hermanos");
mysql_query("create table hermanos_temp select * from hermanos");
mysql_query("create table hermanos_temp2 select * from hermanos");
mysql_query("insert into hermanos_temp select distinct telefono, telefonourgencia, count(*) from alma group by telefono");
mysql_query("delete from hermanos_temp where hermanos < '2'");
$sel0 = mysql_query("select unidad, claveal, hermanos_temp.telefono, hermanos_temp.telefonourgencia from alma, hermanos_temp where alma.telefono=hermanos_temp.telefono and alma.telefonourgencia=hermanos_temp.telefonourgencia");
while ($sel=mysql_fetch_array($sel0)) {
	$dup0=mysql_query("select claveal from alma where telefono = '$sel[2]' and telefonourgencia = '$sel[3]' and unidad = '$sel[0]'");
	$numero = mysql_num_rows($dup0);
	if (mysql_num_rows($dup0)>'1') {
		mysql_query("insert into hermanos_temp2 (telefono, telefonourgencia, hermanos ) VALUES ('$sel[2]','$sel[3]','$numero')");
	}
}
 mysql_query("insert into hermanos select distinct telefono, telefonourgencia, hermanos from hermanos_temp2");
 mysql_query("drop table hermanos_temp");
 mysql_query("drop table hermanos_temp2");
 ?>
 