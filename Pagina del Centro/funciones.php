<?
function tipo()
{
  $tipo = "select distinct tipo from listafechorias";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<OPTION>$tipo2[0]</OPTION>";
        }
}

function medida2($tipofechoria)
{
  $tipo = "select distinct medidas2 from listafechorias where fechoria = '$tipofechoria'";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
$texto = trim($tipo2[0]);
echo "<span style='color:brown;font-family:inherit;padding:4px;line-height:18px;margin-left:-4px;font-size:1.1em;'>$texto</span>";
        }
}

function fechoria($clase)
{
  $tipofechoria0 = "select fechoria from listafechorias where tipo = '$clase' order by fechoria";
  $tipofechoria1 = mysql_query($tipofechoria0);
  while($tipofechoria2 = mysql_fetch_array($tipofechoria1))
        {
echo "<option>$tipofechoria2[0]</option>";
        }
}

function horario_alumno($NIVEL1,$GRUPO1)
{
  include("conf_principal.php");
  mysql_connect ($host, $user, $pass);
  mysql_select_db ($db);
   echo "<span class='titulogeneral'>HORARIO DEL GRUPO  $NIVEL1-$GRUPO1</span>";
  ?>
<div align="center">
<table class="tabla" width="98%">
    <tr> 
    <td id="filaprincipal"></td>
    <td height="20" style="font-weight:bold;"> 
      <div align="center">8.15-9.15</div></td>
    <TD style="font-weight:bold;"> 
      <div align="center">9.15-10.15</div></td>
    <TD style="font-weight:bold;"> 
      <div align="center">10.15-11.15</div></td>
    <TD style="font-weight:bold;"> 
      <div align="center">11.45-12.45</div></td>
    <TD style="font-weight:bold;"> 
      <div align="center">12.45-13.45</div></td>
    <TD style="font-weight:bold;"> 
      <div align="center">13.45-14.45</div></td>
  </tr>
  
<?
  include("conf_principal.php");
  mysql_connect ($host, $user, $pass);
  mysql_select_db ($db);

// Días de la semana 
$a=array("1"=>"Lunes","2"=>"Martes","3"=>"Miércoles","4"=>"Jueves","5"=>"Viernes");
foreach($a as $dia => $nombre) {
echo "<tr><td id='filasecundaria'>$nombre</td>";
for($i=1;$i<7;$i++) {
echo "<td>";
$sqlasig0 = "SELECT distinct  asig, c_asig FROM  horw where nivel = '$NIVEL1' and n_grupo = '$GRUPO1' and dia = '$dia' and hora = '$i'";
$asignaturas1 = mysql_query($sqlasig0);
 while ($rowasignaturas1 = mysql_fetch_array($asignaturas1))
{ 

echo "<center>"; 
echo $rowasignaturas1[0];
echo "</center>";

}
echo "</td>";
}
echo "<tr>";
}
echo "</table>
</div>";

 echo "<span class='titulin'>PROFESORES DEL GRUPO $NIVEL1-$GRUPO1</span>";
 echo "<ul>";
 $profe = "SELECT  distinct PROFESOR, MATERIA FROM profesores, alma where alma.unidad = profesores.grupo and alma.nivel = '$NIVEL1' and alma.grupo = '$GRUPO1'";
 $profeq = mysql_query($profe);
 while($profer = mysql_fetch_array($profeq)){
 echo "<li class='notas'>
$profer[1] -->  <span style='color:#260;');'>$profer[0]</span></li>";}
echo "</ul>";
}

function nivel()
{
  include("conf_principal.php");
  mysql_connect ($host, $user, $pass);
  mysql_select_db ($db);
  $tipo = "select distinct NIVEL from alma order by NIVEL";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<option>".$tipo2[0]."</option>";
        }
}
function nivel_completo()
{
  include("conf_principal.php");
  mysql_connect ($host, $user, $pass);
  mysql_select_db ($db);
  $tipo = "select distinct curso from alma order by curso";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<option>".$tipo2[0]."</option>";
        }
}

function grupo($niveles)
{
  include("conf_principal.php");
  mysql_connect ($host, $user, $pass);
  mysql_select_db ($db);
  $tipo = "select distinct GRUPO from alma where NIVEL = '$niveles' order by GRUPO";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<option>".$tipo2[0]."</option>";
        }
}

function grupo_completo($niveles)
{
  include("conf_principal.php");
  mysql_connect ($host, $user, $pass);
  mysql_select_db ($db);
  $tipo = "select distinct grupo from alma where curso = '$niveles' order by GRUPO";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<option>".$tipo2[0]."</option>";
        }
}

function variables()
{
foreach($_POST as $key => $val)
{
echo "$key --> $val<br>";
}
}


function elmes($m){
$mes["01"] = "enero";
$mes["02"] = "febrero";
$mes["03"] = "marzo";
$mes["04"] = "abril";
$mes["05"] = "mayo";
$mes["06"] = "junio";
$mes["07"] = "julio";
$mes["08"] = "agosto";
$mes["09"] = "septiembre";
$mes["10"] = "octubre";
$mes["11"] = "noviembre";
$mes["12"] = "diciembre";
return $mes[$m];
}

function formatea_fecha($fec){
$fec = strtr($fec,"/","-");
$fec_ok=explode("-",$fec);
return ($fec_ok[2]." de ".elmes($fec_ok[1])." de ".$fec_ok[0]);
}
function fecha_actual($valor_fecha){

/*    if($valor_fecha == ""){
*/	$mes = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
                 8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
    $dia = array("domingo", "lunes","martes","miércoles","jueves","viernes","sábado");
	$diames = date("j");
    $nmes = date("n");
    $ndia = date("w");
    $nano = date("Y");
	    echo $diames." de ".$mes[$nmes].", ".$nano;
}

function fecha_actual2($valor_fecha){
	$tm = explode(" ",$valor_fecha);
	$fecha_real = $tm[0];
	$arr = explode("-", $fecha_real);
    $mes0 = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
                 8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
    $dia0 = array("domingo", "lunes","martes","miércoles","jueves","viernes","sábado"); 
	$diames0 = date("j",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
	$nmes0 = $arr[1];
	if(substr($nmes0,0,1) == "0"){$nmes0 = substr($nmes0,1,1);}	
   // $ndia0 = $arr[2];
	$ndia0 = date("w",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
    $nano0 = $arr[0];
	echo "$diames0 de ".$mes0[$nmes0].", $nano0";
}

	function formatDate($val)
{
	$arr = explode("-", $val);
	return date("d M Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));	
}

function fecha_sin($valor_fecha){
	$arr0 = explode(" ", $valor_fecha);
	$arr = explode("-", $arr0[0]);
    $mes0 = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
                 8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
	$diames0 = date("j",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
	$nmes0 = $arr[1];
	if(substr($nmes0,0,1) == "0"){$nmes0 = substr($nmes0,1,1);}	
	$ndia0 = date("w",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
    $nano0 = $arr[0];
	echo "$diames0 de ".$mes0[$nmes0].", $nano0";
}

// Función para regsitrar las entradas en la página de los alumnos
function registraPagina($pagina,$identifica)
{
include("../conf_principal.php");
// Conexion de datos
mysql_connect ($host, $user, $pass) or die ("No Datos");
mysql_select_db ($db) or die ("No DB");
mysql_query("insert into reg_principal (pagina,fecha,ip,claveal) values ('$pagina',now(),'".$_SERVER['REMOTE_ADDR']."','$identifica')"); 
}
?>
