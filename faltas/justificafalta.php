<?
 
mysql_connect ($db_host, $db_user, $db_pass) or die("Error de conexión");

mysql_query("drop table FALTASJ");
mysql_query("create table FALTASJ select distinct fecha, claveal from FALTAS where falta='J'");
mysql_query("ALTER TABLE  FALTASJ ADD INDEX ( claveal )");
mysql_query("ALTER TABLE  FALTASJ ADD INDEX ( fecha )");
$faltasj = "select distinct claveal, fecha from FALTASJ";
$faltasj0 = mysql_query($faltasj);
/*echo "Numero de dias con al menos una Falta Justificada: " . mysql_num_rows($faltasj0) . "<br>";*/
while ($faltasj1 = mysql_fetch_row($faltasj0))
{
$faltasf = "select distinct falta, fecha, claveal from FALTAS where fecha = '$faltasj1[1]' and claveal = '$faltasj1[0]' and falta = 'F'";
$faltasf0 = mysql_query($faltasf);
while ($faltasf1 = mysql_fetch_row($faltasf0))
{
/*echo "Datos concretos: $faltasf1[2] -- $faltasf1[1] -- $faltasf1[0]<br>";*/
$actualiza = "update FALTAS set falta = 'J' where fecha = '$faltasf1[1]' and claveal = '$faltasf1[2]' and falta = 'F'";
$actualiza0 = mysql_query($actualiza);
}
}
?>

