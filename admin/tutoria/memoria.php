<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
if(!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'2') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
//include_once("../../funciones.php");
?>
<!DOCTYPE html>  
<html lang="es">  
  <head>  
    <meta charset="iso-8859-1">  
    <title>Intranet</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta name="description" content="Intranet del http://<? echo $nombre_del_centro;?>/">  
    <meta name="author" content="">  
  
    <!-- Le styles -->  

    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap.css" rel="stylesheet"> 
    <?
	if($_SERVER ['REQUEST_URI'] == "/intranet/index0.php"){
		?>
    <link href="http://<? echo $dominio;?>/intranet/css/otros_index.css" rel="stylesheet">  
        <?
	}
		else{
		?>
    <link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">     
        <?	
		}
	?>
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->  
    <!--[if lt IE 9]>  
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>  
    <![endif]-->  
  
    <!-- Le fav and touch icons -->  
    <link rel="shortcut icon" href="http://<? echo $dominio;?>/intranet/img/favicon.ico">  
    <link rel="apple-touch-icon" href="http://<? echo $dominio;?>/intranet/img/apple-touch-icon.png">  
    <link rel="apple-touch-icon" sizes="72x72" href="http://<? echo $dominio;?>/intranet/img/apple-touch-icon-72x72.png">  
    <link rel="apple-touch-icon" sizes="114x114" href="http://<? echo $dominio;?>/intranet/img/apple-touch-icon-114x114.png"> 
    <script type="text/javascript"
	src="http://<? echo $dominio;?>/intranet/recursos/js/buscar_alumnos.js"></script>  
<script language="JavaScript">
function doPrint(){
document.all.item("noprint").style.visibility='hidden' 
window.print()
document.all.item("noprint").style.visibility='visible'
}
</script>
</head>

<body onload="cleanForm();">
<script type="text/javascript">
function countLines(strtocount, cols) {
    var hard_lines = 1;
    var last = 0;
    while ( true ) {
        last = strtocount.indexOf("\n", last+1);
        hard_lines ++;
        if ( last == -1 ) break;
    }
    var soft_lines = Math.round(strtocount.length / (cols-1));
    var hard = eval("hard_lines  " + unescape("%3e") + "soft_lines;");
    if ( hard ) soft_lines = hard_lines;
    return soft_lines;
}
function cleanForm() {
    var the_form = document.forms[0];
    for ( var x in the_form ) {
        if ( ! the_form[x] ) continue;
        if( typeof the_form[x].rows != "number" ) continue;
        the_form[x].rows = countLines(the_form[x].value,the_form[x].cols) +3;
    }
    setTimeout("cleanForm();", 300);
}
</script>
<?

if (isset($_POST['nivel'])) {
	$nivel = $_POST['nivel'];
} 
elseif (isset($_GET['nivel'])) {
	$nivel = $_GET['nivel'];
} 
else
{
$nivel="";
}
if (isset($_POST['grupo'])) {
	$grupo = $_POST['grupo'];
}
elseif (isset($_GET['grupo'])) {
	$grupo = $_GET['grupo'];
} 
else
{
$grupo="";
}
if (isset($_GET['tutor'])) {
	$tutor = $_GET['tutor'];
}
elseif (isset($_POST['tutor'])) {
	$tutor = $_POST['tutor'];
}
else{$tutor = "";}

if ($_POST['imp_memoria'] == "Enviar datos") {
	mysql_query("update FTUTORES set observaciones1 = '$observaciones1', observaciones2='$observaciones2' where tutor = '$tutor'");
}
$lista = mysql_list_fields($db,"FTUTORES");
$col_obs = mysql_field_name($lista,3);
if ($col_obs=="observaciones1") { }else{
	mysql_query("ALTER TABLE  `FTUTORES` ADD  `observaciones1` TEXT NOT NULL ,
						        ADD  `observaciones2` TEXT NOT NULL");
}
$grupo = strtoupper($grupo);
?>
<div style="width:750px;margin:auto;padding:25px; border:1px solid #ddd">
<h3 align="center">
 Tutoría del grupo: <? echo "$nivel-$grupo";?> <br /><small>Tutor: <? echo $tutor; ?></small></h2>
 <br />
 <?
 $obs1=mysql_query("select observaciones1, observaciones2 from FTUTORES where tutor = '$tutor'");
 $obs2=mysql_fetch_array($obs1);
 if (empty($obs2[0]) and empty($obs[1]) and date('m')=='06') {$boton = "Redactar Observaciones finales para imprimir";$click="onclick=\"window.open('memoria.php?nivel=$nivel&tutor=$tutor&grupo=$grupo&imprimir=1#observaciones',null,'')\"";}
 	else{
		$boton = "Imprimir Memoria final de Tutoría";$click="onClick=print()";}
 ?>
  <div style="margin-bottom:0px;">
 <input type="button" class="btn btn-primary no_imprimir pull-right" value="<? echo $boton;?>" <? echo $click;?>>
</div>
 
<br>
 
 <h3>Datos Generales de los Alumnos</h3><br />

 <? 
// Alumnos que se integran a lo largo del Curso
 $SQL = "select max(NC) from FALUMNOS_primero where nivel = '$nivel' and grupo = '$grupo'";
 $result = mysql_query($SQL);
 $max0 = mysql_fetch_row($result);
 $num_0 =  $max0[0];
 $SQL1 = "select max(NC) from FALUMNOS where nivel = '$nivel' and grupo = '$grupo'";
 $result1 = mysql_query($SQL1);
 $max1 = mysql_fetch_row($result1);
 $num_1 =  $max1[0];
 $nuevos = $num_1-$num_0;
 $nuevos = str_replace("-","",$nuevos);
 
// Alumnos repetidores
 $SQL = "select * from alma where nivel = '$nivel' and grupo = '$grupo' and matriculas > '1'";
 $result = mysql_query($SQL);
 $num_repetidores = mysql_num_rows($result);

// Alumnos a comienzo de Curso
 $SQL = "select * from FALUMNOS_primero where nivel = '$nivel' and grupo = '$grupo'";
 $result = mysql_query($SQL);
 $num_empiezan = mysql_num_rows($result);
 
 // Alumnos a final de Curso
 $SQL = "select * from alma where nivel = '$nivel' and grupo = '$grupo'";
 $result = mysql_query($SQL);
 $num_acaban = mysql_num_rows($result);

 // Alumnos que promocionan en Junio
 $SQL1 = "select notas3, apellidos, nombre from notas, alma where notas.claveal = alma.claveal1  and nivel = '$nivel' and grupo = '$grupo'";
 $result1 = mysql_query($SQL1);
 
/* while ($num_promo0 = mysql_fetch_array($result1)) 
{
 	$n_susp = "";
 	$trozos0 = explode(";",$num_promo0[0]);	
 	foreach ($trozos0 as $val)
 	{
	$trozos1 = explode(":",$val);	
 		{			
 		if ($nivel == "2B") 
 			{
 			if (($trozos1[1] > "416" and $trozos1[1] < "427") or ($trozos1[1] == "439") or ($trozos1[1] > "32" and $trozos1[1] < "37") or ($trozos1[1] == "42" or $trozos1[1] == "43")) 
				{
		$n_susp = $n_susp + 1;
				}		
 			}		
 		elseif ($nivel == "1B") 
 			{
 			if (($trozos1[1] > "416" and $trozos1[1] < "427") or $trozos1[1] == "439") 
				{
		$n_susp = $n_susp + 1;	
				}	
 			} 			
 		elseif(substr($nivel,1,1) == "E")
 			{
 		if (($trozos1[1] > "336" and $trozos1[1] < "347")) 
				{
		$n_susp = $n_susp + 1;	
				}
			}			 		
		}		
 	}
 if ($n_susp > "0" and ($nivel == "2B" or $nivel == "4E")) 
 	{		
// 		$valor = $valor ."$n_susp: $num_promo0[2] $num_promo0[1] --> $num_promo0[0]<br>";	
 		$n_al = $n_al + 1;
 	}
 	elseif($n_susp > "2" and !($nivel == "2B")  and !($nivel == "4E")) 
 	{		
// 		$valor = $valor ."$n_susp: $num_promo0[2] $num_promo0[1] --> $num_promo0[0]<br>";	
 		$n_al = $n_al + 1;
 	}
}*/

 while ($num_promo0 = mysql_fetch_array($result1))                                                                                                                                                           
{                                                                                                                                                                                                          
        $n_susp = "";                                                                                                                                                                                        
        $trozos0 = explode(";",$num_promo0[0]);                                                                                                                                                              
        foreach ($trozos0 as $val)                                                                                                                                                                           
        {                                                                                                                                                                                                    
        $trozos1 = explode(":",$val);                                                                                                                                                                        
                {                                                                                                                                                                                            
                if ($nivel == "2B")                                                                                                                                                                          
                        {                                                                                                                                                                                    
                        if (($trozos1[1] > "416" and $trozos1[1] < "427") or ($trozos1[1] == "439"))          
                                {                                                                                                                                                                            
                $n_susp = $n_susp + 1;                                                                                                                                                                       
                                }                                                                                                                                                                            
                        }                                                                                                                                                                                    
                elseif ($nivel == "1B")                                                                                                                                                                      
                        {                                                                                                                                                                                    
                        if (($trozos1[1] > "416" and $trozos1[1] < "427") or $trozos1[1] == "439")                                                                                                           
                                {                                                                                                                                                                            
                $n_susp = $n_susp + 1;                                                                                                                                                                       
                                }                                                                                                                                                                            
                        }                                                                                                                                                                                    
                elseif(substr($nivel,1,1) == "E")                                                                                                                                                            
                        {                                                                                                                                                                                    
                if (($trozos1[1] > "336" and $trozos1[1] < "347" and $trozos1[1] !== "339" and $trozos1[1] !== ""))                                                                                          
                                {                                                                                                                                                                            
                $n_susp = $n_susp + 1;                                                                                                                                                                       
                                }                                                                                                                                                                            
                        }                                                                                                                                                                                    
                }                                                                                                                                                                                            
        }                                                                                                                                                                                                    
 if ($n_susp > "0" and ($nivel == "2B" or $nivel == "4E"))                                                                                                                                                                       
        {                                                                                                                                                                                                    
//              $valor = $valor ."$n_susp: $num_promo0[2] $num_promo0[1] --> $num_promo0[0]<br>";                                                                                                            
                $n_al = $n_al + 1;                                                                                                                                                                           
        }                                                                                                                                                                                                    
        elseif($n_susp > "2" and !($nivel == "2B") and !($nivel == "4E"))                                                                                                                                                          
        {                                                                                                                                                                                                    
//              $valor = $valor ."$n_susp: $num_promo0[2] $num_promo0[1] --> $num_promo0[0]<br>";                                                                                                            
                $n_al = $n_al + 1;                                                                                                                                                                           
        }                                                                                                                                                                                                    
}    

?>
<table class="table table-striped" style="width:auto;">
<tr>
    <th>Comienzan el Curso</th>
    <th>Terminan el Curso</th>
    <th>No Promocionan</th>
    <th>Promocionan</th>
    <th>Repetidores</th>
    <th>Nuevas Incorporaciones</th>
</tr>
<tr>
	<td><? echo $num_empiezan; ?></td>
    <td><? echo $num_acaban; ?></td>
    <td><? echo $n_al; // echo "<br>".$valor;?></td> 
    <td><? echo $num_acaban-$n_al; ?></td> 
    <td><? echo $num_repetidores; ?></td> 
    <td><? echo $nuevos; ?></td>     
    </tr>
</table>
<?
// Tabla de Absentismo.
 $faltas = "select distinct claveal from absentismo where nivel = '$nivel' and grupo = '$grupo' order by claveal";
 $faltas0 = mysql_query($faltas);
 $num_faltas = mysql_num_rows($faltas0);
  ?>
 <? 
 $SQL = "select distinct id from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and nivel = '$nivel' and grupo = '$grupo' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_conv = mysql_num_rows($result);
 ?>
  <?    
 $SQL = "select distinct id from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and nivel = '$nivel' and grupo = '$grupo' and grave = 'leve' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_leves = mysql_num_rows($result);
 ?>
  <?    
 $SQL = "select distinct id from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and nivel = '$nivel' and grupo = '$grupo' and grave = 'grave' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_graves = mysql_num_rows($result);
 ?>
   <?    
 $SQL = "select distinct id from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and nivel = '$nivel' and grupo = '$grupo' and grave = 'muy grave' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_muygraves = mysql_num_rows($result);
 ?>
  <?    
 $SQL = "select distinct id from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and nivel = '$nivel' and grupo = '$grupo' and expulsion > '0' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsion = mysql_num_rows($result);
 ?>
  <?    
 $SQL = "select distinct Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and nivel = '$nivel' and grupo = '$grupo' and expulsion > '0' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados = mysql_num_rows($result);
 ?>
   <?    
 $SQL = "select distinct Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and nivel = '$nivel' and grupo = '$grupo' and expulsionaula = '1' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsadosaula = mysql_num_rows($result);
 ?>
   <?    
 $SQL = "select distinct id from infotut_alumno where nivel = '$nivel' and grupo = '$grupo' order by claveal";
 $result = mysql_query($SQL);
 $num_informes = mysql_num_rows($result);
 ?>
   <?    
 $SQL = "select id from tutoria where nivel = '$nivel' and grupo = '$grupo' and prohibido not like '1' order by id";
 $result = mysql_query($SQL);
 $num_acciones = mysql_num_rows($result);
 ?>
   <?    
 $SQL = "select * from actividades where grupos like '%$nivel$grupo%' order by id";
 $result = mysql_query($SQL);
 $num_actividades = mysql_num_rows($result);
 ?>
 <table class="table table-striped" style="width:auto;">
<tr>
    <th>Absentismo</th>
    <th>Problemas de Convivencia</th>
    <th>Informes de Tutor&iacute;a (Visitas de Padres)</th>
    <th>Intervenciones del Tutor</th>
    <th>Actividades Extraescolares</th>
</tr>
<tr>
	<td><? echo $num_faltas; ?></td>
    <td><? echo $num_conv; ?></td>
    <td><? echo $num_informes; ?></td> 
    <td><? echo $num_acciones; ?></td>
    <td><? echo $num_actividades; ?></td>
</tr>
</table>
<hr>
 <br /><h3>
 Informaci&oacute;n sobre Problemas de Convivencia</h3><br />
 <table class="table table-striped" style="width:auto;">
<tr>
    <th>Problemas Leves</th>
    <th>Problemas Graves</th>
	<th>Problemas Muy Graves</th>
    <th>Expulsiones</th>
    <th>Alumnos Expulsados</th>
	<th>Expulsi&oacute;n del Aula</th>
</tr>
<tr>
    <td><? echo $num_leves; ?></td>
    <td><? echo $num_graves; ?></td>
    <td><? echo $num_muygraves; ?></td>	
    <td><? echo $num_expulsion; ?></td>
    <td><? echo $num_expulsados; ?></td>
	<td><? echo $num_expulsadosaula; ?></td>
</tr>
</table>

 
 <hr><br /><h3>Información de Tutoría por Alumno</h3>
 <hr><br /><h4>Alumnos absentistas</h4>
                    <br />
<?
$faltas = "select distinct absentismo.claveal, count(*), nombre, apellidos from absentismo, FALUMNOS where absentismo.claveal = FALUMNOS.claveal and absentismo.nivel = '$nivel' and absentismo.grupo = '$grupo' group by apellidos, nombre";
 $faltas0 = mysql_query($faltas);
 if(mysql_num_rows($faltas0) > 0)
 {
 echo '<table class="table table-striped" style="width:auto;">';
 while($absentista = mysql_fetch_array($faltas0))
 {
 echo '<tr>
<td style="text-align:left">'.$absentista[2] .' '. $absentista[3].'</td><td>'.$absentista[1].'</td>
</tr>';
 }
 echo '</table>';
 }
 ?>
                    <hr><br /><h4>Faltas sin Justificar</h4>
                    <br />
<?php
 echo "<table class='table table-striped' style='width:auto;'>";
		
$SQL = "select distinct FALTAS.claveal, count(*), apellidos, nombre from FALTAS, FALUMNOS  where FALTAS .claveal = FALUMNOS .claveal and FALTAS.falta = 'F' and FALTAS.nivel = '$nivel' and FALTAS.grupo = '$grupo' and date(fecha) > '$inicio_curso' group BY apellidos, nombre";
$result = mysql_query($SQL);

  if ($row = mysql_fetch_array($result))
        {
	$hoy = date("d"). "-" . date("m") . "-" . date("Y");
                do {
	$claveal = $row[0];
          echo "<tr><td style='text-align:left'>$row[2], $row[3]</td><td style='text-align:left'>$row[1]</td></tr>";
        } while($row = mysql_fetch_array($result));
        }
		        echo "</table>";
  ?>
                    <hr><br /><h4>Problemas de Convivencia</h4>
                    <br />
<?
$faltas = "select distinct Fechoria.claveal, count(*), nombre, apellidos from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and nivel = '$nivel' and grupo = '$grupo' and date(fecha) > '$inicio_curso' group by NC";
 $faltas0 = mysql_query($faltas);
 if(mysql_num_rows($faltas0) > 0)
 {
 echo '<table class="table table-striped" style="width:auto;">';
  while($fech = mysql_fetch_array($faltas0))
 {
 echo '<tr>
<td style="text-align:left">'.$fech[2] .' '. $fech[3].'</td><td>'.$fech[1].'</td>
</tr>';
 }
 echo '</table>';
 }
 ?>
                    <hr><br /><h4>Alumnos expulsados</h4>
                    <br />
<?
  
 
 $faltas = "select distinct Fechoria.claveal, count(*), nombre, apellidos from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and nivel = '$nivel' and grupo = '$grupo' and expulsion > '0' and date(fecha) > '$inicio_curso' group by NC";
 $faltas0 = mysql_query($faltas);
 if(mysql_num_rows($faltas0) > 0)
 {
 echo '<table class="table table-striped" style="width:auto;">';
 while($exp = mysql_fetch_array($faltas0))
 {
 echo '<tr>
<td style="text-align:left">'.$exp[2] .' '. $exp[3].'</td><td>'.$exp[1].'</td>
</tr>';
 }
 echo '</table>';
 }
 ?>
 <hr><br /><h4>Alumnos expulsados del aula</h4>
                    <br />
 <?
$faltas = "select distinct Fechoria.claveal, count(*), nombre, apellidos from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and nivel = '$nivel' and grupo = '$grupo' and expulsionaula = '1' and date(fecha) > '$inicio_curso' group by NC";
 $faltas0 = mysql_query($faltas);
 if(mysql_num_rows($faltas0) > 0)
 {
 echo '<table class="table table-striped" style="width:auto;">';
 while($exp = mysql_fetch_array($faltas0))
 {
 echo '<tr>
<td style="text-align:left">'.$exp[2] .' '. $exp[3].'</td><td>'.$exp[1].'</td>
</tr>';
 }
 echo '</table>';
 }
 ?>
 <hr><br /><h4>Informes de Tutoría por visita de padres</h4>
                    <br />
<?
 $faltas = "select distinct claveal, count(*), nombre, apellidos from infotut_alumno where nivel = '$nivel' and grupo = '$grupo' and date(F_ENTREV) > '$inicio_curso' group by apellidos";
 $faltas0 = mysql_query($faltas);
 if(mysql_num_rows($faltas0) > 0)
 {
 echo '<table class="table table-striped" style="width:auto;">';
 while($infotut = mysql_fetch_array($faltas0))
 {
 echo '<tr>
<td style="text-align:left">'.$infotut[2] .' '. $infotut[3].'</td><td>'.$infotut[1].'</td>
</tr>';
 }
 echo '</table>';
 }
 ?>
<hr><br /><h4>Intervenciones del Tutor</h4>
                    <br />
<?
 $faltas = "select distinct apellidos, nombre, count(*) from tutoria where nivel = '$nivel' and grupo = '$grupo' and prohibido not like '1' and date(fecha) > '$inicio_curso' group by apellidos";
 $faltas0 = mysql_query($faltas);
 if(mysql_num_rows($faltas0) > 0)
 {
 echo '<table class="table table-striped" style="width:auto;">';
 while($tutoria = mysql_fetch_array($faltas0))
 {
 echo '<tr>
<td style="text-align:left">'.$tutoria[1] .' '. $tutoria[0].'</td><td>'.$tutoria[2].'</td>
</tr>';
 }
 echo '</table>';
 }
 
 $faltas = "select distinct apellidos, nombre, causa, accion, observaciones from tutoria where nivel = '$nivel' and grupo = '$grupo' and prohibido not like '1' and accion not like '%SMS%'  and date(fecha) > '$inicio_curso' order by apellidos";
 $faltas0 = mysql_query($faltas);
 if(mysql_num_rows($faltas0) > 0)
 {
	 ?>
 <hr><br /><h4>Intervenciones de Tutoría (excluidos SMS)</h4>
                    <br />    
     <?
 echo '<table class="table table-striped" style="width:auto;">';
 while($tutoria = mysql_fetch_array($faltas0))
 {
 echo '<tr>
<td style="text-align:left" nowrap>'.$tutoria[0] .', '. $tutoria[1].'</td><td style="text-align:left" >'.$tutoria[2].'</td><td style="text-align:left" >'.$tutoria[3].'</td>
</tr>';
 }
 echo '</table>';
 }
 
  $n_activ = mysql_query("select * from actividades where  grupos like '%$nivel$grupo-%' and date(fecha) > '$inicio_curso'");
  if(mysql_num_rows($n_activ) > "0"){
 ?>
  
 <hr><br /><h4>Informe sobre Actividades Extraescolares del Grupo</h4><br />
 <?
include("actividades.php");
 ?>
 <?
 }
 ?>
<?

if($imprimir == "1" or strlen($obs2[0]) > "1" or strlen($obs[1])>"1")
{
?>
<a name="observaciones" id="obs"></a>
<hr><br /><h4>
 Observaciones sobre dificultades encontradas en el Grupo<br />(Integración, Motivación, Rendimiento académico, etc.)</h4><br />
 <form action="memoria.php" method="POST">
 <textarea name="observaciones1" style="width:100%"><? echo $obs2[0];?></textarea>
 <hr>
<br />
<h4>
 Otras Observaciones</h4><br />
 <textarea name="observaciones2" style="width:100%"><? echo $obs2[1];?></textarea>
 <br />
<input type="hidden" name="tutor" value="<? echo $tutor;?>">
<input type="hidden" name="nivel" value="<? echo $nivel;?>">
<input type="hidden" name="grupo" value="<? echo $grupo;?>">
<br />
<input type="submit" name="imp_memoria" value="Enviar datos" class="btn btn-danger no_imprimir">
</form>
<?
if((strlen($obs2[0]) > "1" or strlen($obs[1])>"1"))
{
?>
<br />
  <p align="center">En Estepona a   <? $today = date("d") . "/" . date("m") . "/" . date("Y"); echo $today;?></p>
  <br>
<p align="center">EL Tutor</p>
<br>
<br>
<br>
<p align="center">Fdo. <?  echo $tutor;?></p>
<br />
<?
}
}
 ?>
</body>
</html>