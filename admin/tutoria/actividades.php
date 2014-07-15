    
<table class="table table-condensed" style="width:100%">
<?
$meses = "select distinct month(fecha) from actividades order by month(fecha)";
$meses0 = mysql_query($meses);
while ($mes = mysql_fetch_array($meses0))
{
$mes1 = $mes[0];
 echo "<tr>
  <th colspan='2' style='background-color:#f9f9f9'>";
  echo "<div align=center>";
  if($mes1 ==  "01") $mes2 = "Enero";
  if($mes1 ==  "02") $mes2 = "Febrero";
  if($mes1 ==  "03") $mes2 = "Marzo";
  if($mes1 ==  "04") $mes2 = "Abril";
  if($mes1 ==  "05") $mes2 = "Mayo";
  if($mes1 ==  "06") $mes2 = "Junio";
  if($mes1 ==  "09") $mes2 = "Septiembre";
  if($mes1 ==  "10") $mes2 = "Octubre";
  if($mes1 ==  "11") $mes2 = "Noviembre";
  if($mes1 ==  "12") $mes2 = "Diciembre";
   echo "$mes2";
   echo "</div>";
 echo "</th>
  </tr>";
 $grupo_activ = str_replace("-","",$unidad);
$datos0 = "select * from actividades where month(fecha) = '$mes1' and grupos like '%$grupo_activ-%' order by fecha";
  $datos1 = mysql_query($datos0);
while($datos = mysql_fetch_array($datos1))
{
$fecha0 = explode("-",$datos[7]);
$fecha = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
?>
  <tr>
    <td><a href="det_actividades.php?id=<? echo $datos[0];?>"><? echo $datos[2];?></a><br /><? echo $datos[4];?></td>
    <td nowrap><? echo $fecha;?></td>
  </tr>
<? }}?>
</table>
