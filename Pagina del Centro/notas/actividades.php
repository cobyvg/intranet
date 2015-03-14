<? 
session_start();
if($_SESSION['aut']<>1)
{
header("location:http://iesmonterroso.org");
exit;	
}
	$clave_al = $_SESSION['clave_al'];
	$claveal = $_SESSION['clave_al'];
	$todosdatos = $_SESSION['todosdatos'];
	$unidad = $_SESSION['unidad'];
	$curso = $unidad;
	include("../conf_principal.php");
	include("../funciones.php");
	mysql_connect ($host, $user, $pass);
	mysql_select_db ($db);
?>
<? include "../cabecera.php"; ?>
<? include('consultas.php'); ?>
<div class="span9">	
<?
   echo "<h3 align='center'>$todosdatos<br /></h3>";   
   echo "<p class='lead muted' align='center'><i class='icon icon-plus-sign'> </i> Actividades Complementarias y Extraescolares del Grupo 
$unidad</p><br />";

  $datos0 = "select unidades, descripcion, departamento, profesores, concat (horaini,' - ', horafin), concat(fechaini,' - ',fechafin), profesorreg, nombre from calendario where unidades like '%$curso%' and date(fechaini)>'$inicio_curso' and categoria = '2'";
  $datos1 = mysql_query($datos0);
  if(mysql_num_rows($datos1)>0){
  while($datos = mysql_fetch_array($datos1))
  {
  if(strlen($datos[0]) > 96){
$gr1 = substr($datos[0],0,48)."<br>";
$gr2 = substr($datos[0],48,48)."<br>";
$gr3 = substr($datos[0],96)."<br>";
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
if ($datos[6]=='admin') {
	$profe_reg = "Departamento de Actividades Extraescolares";
}
else{
	$profe_reg = $datos[6];
}
  ?>
      <div class="well well-large span9 offset1">
          <h4 class="text-success"><? echo $datos[7];?></h4>
          <hr>
      <dl class="dl-horizontal">

        <dt class="text-info">Grupos</dt><dd><? echo $grupos0;?></dd>

        <dt class="text-info">Descripción</dt><dd><? echo $datos[1];?></dd>

        <dt class="text-info">Departamento</dt><dd><? echo $datos[2];?></dd>

        <dt class="text-info">Profesor</dt><dd><? echo $datos[3];?></dd>

        <dt class="text-info">Horario</dt><dd><? echo $datos[4];?></dd>

        <dt class="text-info">Fecha</dt><dd><? echo $datos[5];?></dd>

        <dt class="text-info">Información</dt><dd><? echo $profe_reg;?></dd>
      
      </dl>
      </div>
    <?
 }
  }
  else{
echo "<div class='alert alert-warning' style='max-width:450px;margin:auto'>El 
grupo $unidad no tiene programada ninguna Actividad Complementaria durante este 
curso a día de hoy.</div></div>";	  
  }
?>


	</div>
 <? include "../pie.php"; ?>

