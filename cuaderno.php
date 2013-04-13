<?
ini_set("session.cookie_lifetime","2800"); 
ini_set("session.gc_maxlifetime","3600");
session_start();
include("config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$pr = $_SESSION['profi'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="iso-8859-1">
<title>Intranet</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Intranet del http://<? echo $nombre_del_centro;?>/">
<meta name="author" content="">
<link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
<link href="http://<? echo $dominio;?>/intranet/css/bootstrap.css" rel="stylesheet">
<link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">
<link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.css" rel="stylesheet">
<link href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css" rel="stylesheet">
<link rel="shortcut icon" href="http://<? echo $dominio;?>/intranet/img/favicon.ico">
<link rel="apple-touch-icon" href="http://<? echo $dominio;?>/intranet/img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="http://<? echo $dominio;?>/intranet/img/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="http://<? echo $dominio;?>/intranet/img/apple-touch-icon-114x114.png">
<style type="text/css">
.nota {
	border:none;
	color:#9d261d;
}
</style>
<?
echo "
<script>
function seleccionar_tod(){
	for (i=0;i<document.imprime.elements.length;i++)
		if(document.imprime.elements[i].type == 'checkbox')	
			document.imprime.elements[i].checked=1
}
function deseleccionar_tod(){
	for (i=0;i<document.imprime.elements.length;i++)
		if(document.imprime.elements[i].type == 'checkbox')	
			document.imprime.elements[i].checked=0
}
</script>
";
?>
</head>
<body>
<?
include("menu_solo.php");
?>

<?
// Elegir Curso y Asignatura.
if(empty($curso))
{
include("index0.php");
exit;
}
// Enviar datos y procesarlos
if($enviar == "Enviar datos")
{
	include("cuaderno/poner_notas.php");
	//include("horario.php");
	//exit;
}
// Conecxión con la base de datos.
 
  
if($pr and $dia and $hora)
{
?>
  <?php
// Distintos códigos de la asignatura cuando hay varios grupos en una hora.
$n_c = mysql_query("SELECT distinct  a_grupo, profesores.nivel FROM  horw, profesores where prof = profesor and a_grupo = profesores.grupo and prof = '$pr' and dia = '$dia' and hora = '$hora'");
while($varias = mysql_fetch_array($n_c))
{
	if (substr($varias[0],3,2) == "Dd" ) {
	$varias[0] = substr($varias[0],0,4);
	}
	$nombre_asig = $varias[1];
	$nombre_materia = strtolower($nombre_asig);
}
$num_cursos0 = mysql_query("SELECT distinct  a_grupo, c_asig FROM  horw where prof = '$pr' and dia = '$dia' and hora = '$hora'");
  // Todos los Grupos juntos
  while($n_cur = mysql_fetch_array($num_cursos0))
  {
	$curs .= $n_cur[0].", ";
	$codigos.= $n_cur[1]." ";
}		
$codigos = substr($codigos,0,-1);
// Eliminamos el espacio
  	$curs0 = substr($curs,0,(strlen($curs)-1));
// Eliminamos la última coma para el título.
	$curso_sin = substr($curs0,0,(strlen($curs0)-1));
//Número de columnas
	
	$col = "select distinct id, nombre, orden from notas_cuaderno where profesor = '$pr' and curso = '$curs0' and asignatura='$asignatura'  and oculto = '0' order by orden asc";
	$col0 = mysql_query($col);
	$cols = mysql_num_rows($col0);
	
	
	
	echo "</div>";
	
	echo "<div align='center'>";
// Titulos
$n_profe = explode(", ",$pr);
echo "<h2 style='margin-top:0px' class='no_imprimir'>Cuaderno de Notas</h2>";
echo "<h4>$n_profe[1] $n_profe[0]<br /><h6 align='center' style='color:#999'>".$curso_sin." (".$nombre_materia.")</h6></h4><br />";
echo '<form action="cuaderno.php" method="post" name="imprime" class="form-inline">';
	if($seleccionar == "1"){
	?>
 <div class="well" align="center" style="width:300px;">
 <h4>Selecciona tus Alumnos...</h4><br />
  <a href="javascript:seleccionar_tod()" class="btn btn-success">Marcarlos todos</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:deseleccionar_tod()" class="btn btn-danger">Desmarcarlos todos</a>
  </div><br />
  <?
}
?>
<div class="container">
<div class="row-fluid">
<div class="span9">

<?
echo "<table class='table table-striped table-bordered table-condensed' style='width:auto'>\n"; 
echo "<tr><th>NC</th><th>Alumnos</th>";
// Número de las columnas de la tabla	
	$cols2=0;
	while($col20 = mysql_fetch_array($col0)){
	
	$col2=mysql_query("select distinct id from datos where id = '$col20[0]' ");
	$cols2 += mysql_num_rows($col2); //echo $cols2;
	$ident= $col20[2];
	$id = $col20[0];
	$mens0 = "cuaderno/c_nota.php?profesor=$pr&asignatura=$asignatura&curso=$curs0&dia=$dia&hora=$hora&id=$id&orden=$ident";
	echo "<th><a href='$mens0' rel='tooltip' title='$col20[1]'>$ident</a></th>";
	}
	if($seleccionar == 1){echo "<th></th>";}

// Tabla para cada Grupo
  $curso0 = "SELECT distinct  a_grupo, c_asig, asig FROM  horw where prof = '$pr' and dia = '$dia' and hora = '$hora'";
  //echo $curso0;
  $curso20 = mysql_query($curso0);
  while ($curso11 = mysql_fetch_array($curso20))
    {
	$curso = $curso11[0];
	$nombre = $curso11[2];
// Número de Columnas para crear la tabla
	$num_col = 2 + $cols + $cols2;
	if(substr($curso,4,1) == 'd')
	{
	$div = $curso;
	//	Problemas con Diversificación (4E-Dd)
		$curso_sin1 =  substr($curso,0,strlen($curso) - 1);
		$curso30 = substr($curso,0,strlen($curso) - 1).",";
		if(strstr($curs,$curso30)){$curso = "";}	
		else{ 
		$curso = $curso_sin1;
		echo "<tr><td colspan='$num_col'>";
   		echo $curso." ".$nombre;
   		echo "</td></tr>";
		}
	}
else{
if($seleccionar=="1"){	$num_col += 1;	}
	echo "<tr><td colspan='$num_col'>";
   	echo "<h4 align='center' style='display:inline;'>".$nombre."&nbsp;(".$curso_sin.")</h4>&nbsp;&nbsp;";
// Enlace para crear nuevos Alumnos y para crear nuevas columnasx
$mens1 = "cuaderno.php?profesor=$pr&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curs0&seleccionar=1'";
$mens2 = "cuaderno/c_nota.php?profesor=$pr&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curs0";
echo '<ul style="display:inline;float:right;margin:0px;">';
	   $mens1 = "cuaderno.php?profesor=$pr&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curs0&seleccionar=1";
	echo '<li style="display:inline"><i class="icon icon-user icon-large" title="Seleccionar Alumnos de la materia. Los alumnos no seleccionados ya no volverán a aparecer en el Cuaderno." rel="Tooltip" onclick="window.location=\'';	
	echo $mens1;
	echo '\'" style="cursor: pointer;"></i>&nbsp;&nbsp;</li>';
	echo '<li style="display:inline"><i class="icon icon-print icon-large" title="Imprimir la tabla de alumnos" onclick="print()"';
	echo '\'" style="cursor: pointer;"> </i>&nbsp;&nbsp;</li>';
    $mens2 = "cuaderno/c_nota.php?profesor=$pr&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curs0";
	echo '<li style="display:inline"><i class="icon icon-plus-sign icon-large" rel="Tooltip" title="Añadir un columna de datos al Cuaderno" onclick="window.location=\'';	
	echo $mens2;
	echo '\'" style="cursor: pointer;"> </i></li>';
	echo ''; 
	
	
   	echo "</ul></td></tr>";
	}
	if($seleccionar=="1"){
	// Si seleccionamos alumnos, se lo indicamos a poner_notas.php
	echo '<input name=seleccionar type=hidden value="1" />';	
	}
	// Codigo Curso
	echo '<input name=curso type=hidden value="';
	echo $curs0; 
	echo '" />';
	// Profesor
	echo '<input name=profesor type=hidden value="'; 
	echo $pr; 
	echo '" />';
	// Asignatura.
	echo '<input name=asignatura type=hidden value="'; 
	echo $asignatura; 
	echo '" />';
	if (empty($seleccionar)) {	
	if(!(empty($div))){$curso_orig = $div;}else{$curso_orig = $curso;}
	mysql_select_db($db);
	$hay0 = "select alumnos from grupos where profesor='$pr' and asignatura = '$asignatura' and curso = '$curso_orig'";
	$hay1 = mysql_query($hay0);
	$hay = mysql_fetch_row($hay1);	
	
	if(mysql_num_rows($hay1) == "1"){
	$seleccionados = substr($hay[0],0,strlen($hay[0])-1);
	$t_al = explode(",",$seleccionados);
	$todos = " and (nc = '300'";
	foreach($t_al as $cadauno){
	$todos .=" or nc = '$cadauno'";
	}
	$todos .= ")";
	}
	}
	
// Alumnos para presentar que tengan esa asignatura en combasi
$resul = "select distinctrow FALUMNOS.CLAVEAL, FALUMNOS.NC, FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, alma.MATRICULAS, alma.combasi, alma.nivel, alma.grupo from FALUMNOS, alma WHERE FALUMNOS.CLAVEAL = alma.CLAVEAL and unidad = '$curso' and (";
 //Alumnos de 2º de Bachillerato 
 if (stristr($curso,"1B")==TRUE or stristr($curso,"2B")==TRUE) {
if (strlen($codigos)>'6') {
$cod_var='';
$d_cod = explode(" ",$codigos);
foreach ($d_cod as $cod_var){
	$resul.=" combasi like '%$cod_var:%' or";
}
	$resul = substr($resul,0,-3);
	//echo $varias."<br>";
}
else{
	$resul.=" combasi like '%$asignatura:%' ";
}
 }
else{
	$resul.=" combasi like '%$asignatura:%' ";
}
$resul.=") ". $todos ." order by NC";

//echo $resul;
$result = mysql_query ($resul);	
        while($row = mysql_fetch_array($result))
		{  		
		$claveal = $row[0];   
		$nombre_al =   $row[3]; 
		$apellidos =   $row[2]; 
		$nc =   $row[1];    
		$grupo_simple =  $row[6]."-".$row[7];	
		if ($row[5] == "") {}
		else
			{
$inf = "cuaderno/informe.php?profesor=$pr&curso=$curso&asignatura=$asignatura&nc=$nc&claveal=$claveal&nombre=$nombre_al&apellidos=$apellidos";
	echo "<tr>";
	echo "<td nowrap><a href='$inf'>$row[1]</a></td><td nowrap><a href='$inf'>$row[2], $row[3]</a></td>";
  	
// Si hay datos escritos rellenamos la casilla correspondiente
	$colu10 = "select distinct id from notas_cuaderno where profesor = '$pr' and curso like '%$curso%' and asignatura = '$asignatura' and oculto = '0' order by id";
	$colu20 = mysql_query($colu10);
	while($colus10 = mysql_fetch_array($colu20)){
	$id = $colus10[0];
    $dato0 = mysql_query("select nota,ponderacion from datos where claveal = '$claveal' and id = '$id'");
	$dato1 = mysql_fetch_array($dato0);
	if($dato1[0] < 5){$color="#9d261d";}else{$color="navy";}
echo "<td><input type='text' name='$id-$claveal' value='$dato1[0]' class='input-mini' style='color:$color;max-width:28px;height:15px;'></td>";             


}}	

	if($seleccionar == "1")
	{
		if(!(empty($div))){$curso_orig = $div;}else{$curso_orig = $grupo_simple;}
	$grupos2 = "select alumnos from grupos where profesor = '$pr' and curso = '$curso_orig' and asignatura = '$asignatura'";
	$marcado = "";
	$grupos0 = mysql_query($grupos2);
	$grupos1 = mysql_fetch_array($grupos0);
	$sel = explode(",",$grupos1[0]);
	foreach($sel as $nc_sel){if($nc_sel == $nc)
	{
	$marcado = "1";
	}
	}
	if(!(empty($div))){$curso = $div;}
	?>
  <td style="border:1px solid #62c462; border-bottom:none;background-color:#dff0d8"><input name="select_<? echo $row[1]."_".$curso;?>" type="checkbox" <? if ($marcado == "1") {echo "checked ";}?> value="1" /></td>
  <?
	}
echo "</tr>";              	
        }  
	}
$num_col+=1;
echo '</table><div align=center class=no_imprimir><input name="enviar" type="submit" value="Enviar datos" class="btn btn-primary" /></div>'; 

  ?>
</FORM>

<?
	
	$colum24= "select distinct id, nombre, orden from notas_cuaderno where profesor = '$pr' and curso = '$curs0' and asignatura='$asignatura' order by orden asc";
	$colu = mysql_query($colum24); 
    if (mysql_num_rows($colu) > 0) { 
    ?>
    
</div>
<div class="span3">

<div class="no_imprimir">


    <div class="well-transparent well-small" align="left">
    <h4 style="display:inline"><small>Cosas que puedes hacer...</small></h4>
    
      
<a data-toggle="modal" href="#ayuda">
<i class="icon icon-large icon-border icon-question-sign icon-large pull-right" style="color:#888"> </i>
</a>  
<div class="modal hide fade" id="ayuda"  style="display:inline">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
  </div>
  <div class="modal-body">
  <p class="lead">
  Instrucciones de uso.
  </p>
<p class="help-block">
Hay varias funciones que puedes realizar sobre las columnas que contienen los datos (ocultar, elimar, calcular medias, etc). Marca las columnas sobre las que quieres trabajar, y luego presiona el botón que realiza una determinada operación sobre esas columnas. No te olvides de seleccionar las columnas coreespondientes.
</p>
</div>
</div>
<br />
<br />
    <?    
	$colum= "select distinct id, nombre, orden, oculto from notas_cuaderno where profesor = '$pr' and curso = '$curs0' and asignatura='$asignatura' order by orden asc";
	$colum0 = mysql_query($colum); 

	if (mysql_num_rows($colum0) > 0) {
$h=0;
			while($colum00=mysql_fetch_array($colum0)){
				
				$otra=mysql_query("select distinct ponderacion from datos where id='$colum00[0]' and ponderacion<>'1' ");
				if (mysql_num_rows($otra) > 0){     $h+=1;}											}
			echo "<table class='table table-striped' style='width:100%;'>"; 
	$otra2=mysql_query("select distinct id, nombre, orden, oculto from notas_cuaderno where profesor = '$pr' and curso = '$curs0' and asignatura='$asignatura' order by orden asc");
	while ($colum1 = mysql_fetch_array($otra2)) {
	$n_col = $colum1[2];
	$id = $colum1[0];
	$nombre = $colum1[1];
	$oculto = $colum1[3];
	$pon=mysql_query("select distinct ponderacion from datos where id='$id'");
	$pon0=mysql_fetch_array($pon);
	$pond= $pon0[0];
	$mens0 = "cuaderno/c_nota.php?profesor=$pr&curso=$curs0&dia=$dia&hora=$hora&id=$id&orden=$ident";
	  echo "<tr><td>$n_col &nbsp;&nbsp;</td><td><a href='$mens0'>$nombre</a></td>";
	  echo "<td>";
	  ?>
    &nbsp;&nbsp;<input name="<? echo $id;?>" type="checkbox"  value="<? if(mysql_num_rows($pon)==0){echo 1;} else{ echo $pond;}?>" />
    <?
	  echo "</td>";
	
     if ($h > 0 ) {echo "<td align='center'>$pond</td>"; }
	  echo "</tr>";		  								
	}
	} 					 
	  echo "</table>";
	// Codigo Curso
	echo '<input name=curso type=hidden value="';
	echo $curs0;
	echo '" />';
	// Profesor
	echo '<input name=profesor type=hidden value="'; 
	echo $pr; 
	echo '" />';
	// Asignatura.
	echo '<input name=asignatura type=hidden value="'; 
	echo $asignatura; 
	echo '" />';
	// Día.
	echo '<input name=dia type=hidden value="'; 
	echo $dia; 
	echo '" />';
	// Hora.
	echo '<input name=hora type=hidden value="'; 
	echo $hora; 
	echo '" />';

?>
<hr>   
<h4><small>Operaciones y Funciones</small></h4>
    <form action="cuaderno/editar.php" method="POST" id="editar">
    <input name="media" type="submit" value="Media Aritmética" class="btn btn-info" style="width:100%"/>
        <input name="media_pond2" type="submit" value="Media Ponderada" class="btn btn-info" style="width:100%"/>
        <input name="estadistica" type="submit" value="Estadística" class="btn btn-info" style="width:100%"/>
    <input name="ocultar" type="submit" value="Ocultar" class="btn btn-info" style="width:100%"/>
        <input name="mostrar" type="submit" value="Mostrar" class="btn btn-info" style="width:100%"/>
        <input name="eliminar" type="submit" value="Eliminar" class="btn btn-info" style="width:100%"/>
  </form>
</div>
</div>
<?
}
}
?>

</div>
</div>
<? 
include("pie.php");
?>
  </body>
</html>
