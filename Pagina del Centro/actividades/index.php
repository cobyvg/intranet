<? include("../conf_principal.php");?>
<? include "../cabecera.php"; ?>
<? include('../menu.php'); ?>
<div class="span9">	
<h3 align='center'>Actividades Extraescolares en este Curso Escolar</h3>
<hr />
<div class="span10 offset1">
 <p class="muted" align="center"><small>(Las Fechas son aproximadas. Pueden variar en funcion de la Actividad, o bien si la misma se realiza fuera del Centro.)</small></p>
  <?
  mysql_connect ($host, $user, $pass);
  mysql_select_db ($db);
  
  if($_GET['detalles'] == '1')
  {
  	$id = $_GET['id'];
  ?>
  
  <?
  $datos0 = "select * from actividades where id = '$id'";
  $datos1 = mysql_query($datos0);
  $datos = mysql_fetch_array($datos1);
  $fecha0 = explode("-",$datos[7]);
  $fecha = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
  $fecha1 = explode("-",$datos[8]);
  $registro = "$fecha1[2]-$fecha1[1]-$fecha1[0]";
  if(strlen($datos[1]) > 96){
$gr1 = substr($datos[1],0,48)."<br>";
$gr2 = substr($datos[1],48,48)."<br>";
$gr3 = substr($datos[1],96)."<br>";
$grupos = $gr1.$gr2.$gr3;
$grupos0 =  substr($grupos,0,strlen($grupos)-5);
}

elseif(strlen($datos[1]) > 48 and strlen($datos[1]) < 96){
$gr1 = substr($datos[1],0,48)."<br>";
$gr2 = substr($datos[1],48,96)."<br>";
$grupos = $gr1.$gr2;
$grupos0 =  substr($grupos,0,strlen($grupos)-5);

}
elseif(strlen($datos[1]) < 50){
$gr1 = substr($datos[1],0,50)."<br>";
$grupos = $gr1;
$grupos0 =  substr($grupos,0,strlen($grupos)-5);
}
  ?>
<br /><table class="table table-striped table-bordered">
  <tr class="text-error">
    <th colspan=2><h4 align="center"><? echo $datos[2];?></h4></th>
    </tr>
    <tbody>
  <tr>
    <th class="text-info">Grupos</th><td><? echo $grupos0;?></td>
    </tr>
  <tr>
    <th class="text-info">Descripción</th><td><? echo $datos[3];?></td>
    </tr>
  <tr>
    <th class="text-info">Departamento</th><td><? echo $datos[4];?></td>
    </tr>
  <tr>
    <th class="text-info">Profesor</th><td><? echo $datos[5];?></td>
    </tr>
  <tr>
    <th class="text-info">Horario</th><td><? echo $datos[6];?></td>
    </tr>
  <tr>
    <th class="text-info">Fecha</th><td><? echo $fecha;?></td>
    </tr>
  
  <tr>
    <th>Información</th><td><? echo $datos[10];?></td>
    </tr>
  </tbody>
</table>
<hr />
  <?
 } 
?>
 <br />
<table class="table table-hover table-bordered">
  <tr class="success">
    <td>Actividad</td>
    <td>Grupos</td>
    <td>Departamento</td>
    <td nowrap>Fecha</td>
    <td></td>
    
    </tr>
    <tbody>
  <?
$meses = "select distinct month(fecha) from actividades order by fecha";
$meses0 = mysql_query($meses);
while ($mes = mysql_fetch_array($meses0))
{
$mes1 = $mes[0];
 echo "<tr class='info'>
  <td colspan=5>";
  echo "<div align=center><strong>";
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
 echo "</strong></div></td>
  </tr>";
$datos0 = "select * from actividades where month(fecha) = '$mes1' order by fecha";
  $datos1 = mysql_query($datos0);
while($datos = mysql_fetch_array($datos1))
{
if(strlen($datos[1]) > 96){
$gr1 = substr($datos[1],0,48)."<br>";
$gr2 = substr($datos[1],48,48)."<br>";
$gr3 = substr($datos[1],96)."<br>";
$grupos = $gr1.$gr2.$gr3;
$grupos0 =  substr($grupos,0,strlen($grupos)-5);
}

elseif(strlen($datos[1]) > 48 and strlen($datos[1]) < 96){
$gr1 = substr($datos[1],0,48)."<br>";
$gr2 = substr($datos[1],48,96)."<br>";
$grupos = $gr1.$gr2;
$grupos0 =  substr($grupos,0,strlen($grupos)-5);

}
elseif(strlen($datos[1]) < 50){
$gr1 = substr($datos[1],0,50)."<br>";
$grupos = $gr1;
$grupos0 =  substr($grupos,0,strlen($grupos)-5);
}
$fecha0 = explode("-",$datos[7]);
$fecha = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
?>
  <tr>
    <td class="text-success"><? echo $datos[2];?></td>
    <td><? echo $grupos0;?></td>
    <td><? echo $datos[4];?></td>
    <td nowrap><? echo $fecha;?></td>
    
    <td><a href="index.php?id=<? echo $datos[0];?>&amp;detalles=1"><i class="icon icon-search" title='Detalles'> </i></a>
      </td>
    </tr>
  <? }}?>
  </tbody>
</table>

</div><!-- Plantilla -->
</div>

<? include("../pie.php");?>
