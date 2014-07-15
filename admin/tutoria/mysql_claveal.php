<?
include("../../config.php");
  $al0 = mysql_query("select distinct id, FALUMNOS.claveal, tutoria.claveal from tutoria, FALUMNOS where tutoria.apellidos=FALUMNOS.apellidos and tutoria.nombre=FALUMNOS.nombre and tutoria.unidad=FALUMNOS.unidad order by id");
  while($al1 = mysql_fetch_array($al0))
  {
 $claveal = $al1[1];
 $clave_tut = $al1[2];
 $id = $al1[0];
 if (empty($clave_tut)) {
 	mysql_query("update tutoria set claveal='$claveal' where id='$id'");
echo "OK<br />";
 }

}
?>
