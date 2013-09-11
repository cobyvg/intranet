<?
// Extraemos las variables empaquetadas en Curso.
$trozos = explode("-->",$curso);
$grupo = $trozos[0];
$cod = $trozos[3];
if (empty($profe)) {
$profe=$_SESSION['profi'];	
}
?>
<div align=center>
<div class="page-header" align="center">
  <h2>Centro TIC <small> Usuarios del Grupo <? echo $grupo;?> .</small></h2>
</div>
<br />

<?
$mes0 = mysql_query("select distinct agrupamiento, c_asig from AsignacionMesasTIC where prof='$profe' and agrupamiento like '%$grupo%'");

$mes_al0= mysql_fetch_array($mes0);
$agrup0=str_replace(":",",",$mes_al0[0]);
$agrup0=substr($agrup0,0,-1)."-->$mes_al0[1]";
echo "<a href='../distribucion/distribucion.php?curso=$grupo&profe=$profe&asignatura=$cod' class='btn btn-primary'> Cambiar Alumnos y Ordenadores </a><br /><br /><br />";
?>

<table  class="table table-striped" style="width:auto">
<tr><th>Alumno</th>
<th>Usuario T.I.C.</th>

<th>Ordenador</th>
</tr>
<?
// Código y abreviatura de la asignatura.
$codigo = "select distinct usuarioalumno.nombre, usuarioalumno.usuario, usuarioalumno.unidad, FALUMNOS.nombre, FALUMNOS.apellidos, usuarioalumno.pass, FALUMNOS.claveal from usuarioalumno, FALUMNOS, alma where FALUMNOS.claveal = alma.claveal and FALUMNOS.claveal = usuarioalumno.claveal and usuarioalumno.unidad = '$grupo' and combasi like '%$cod%' order by nc";
// echo $codigo . "<br>";
$sqlcod = mysql_query ($codigo);
while($row = mysql_fetch_array($sqlcod))
{

$no_mesa="";
$agrup="";
$mes = mysql_query("select distinct no_mesa from AsignacionMesasTIC where prof='$profe' and AsignacionMesasTIC.claveal='$row[6]' and agrupamiento like '%$grupo%'");
$mes_al= mysql_fetch_array($mes);
$no_mesa=$mes_al[0];

echo "<tr>
<td>$row[4], $row[3]</td>
<td>$row[1]</td>

<td>$no_mesa</td>
</tr>";
$linea = "$row[1];$row[1];$row[4];$row[3]\n";
$todo .= $linea;
		}
?>
</table>
</div>