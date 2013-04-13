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
if(!(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'2') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
if($imprimir == "si")
{
	
	include("cert_pdf.php");
	exit;
}
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
    <SCRIPT LANGUAGE=javascript>

function wait(){
string="document.forms.libros.submit();";
setInterval(string,540000);
}

</SCRIPT>
  </head>  
<body onload=wait()>
<?
include("../../menu.php");
$lista = mysql_list_fields($db,"mens_texto");
$col_curso = mysql_field_name($lista,6);
if ($col_curso=="curso") { }else{
	mysql_query("ALTER TABLE  `textos_alumnos` ADD  `curso` VARCHAR( 7 ) NOT NULL ");
}
?>

<div align="center">
<h2>
Informe sobre el estado de los Libros de Texto: <span style=" color:#08c;"><? echo $nivel."-".strtoupper($grupo);?></span></h2>
<br />
<?
foreach($_POST as $key0 => $val0)
{
if(strlen($val0) > "0"){$tarari=$tarari+1;}
}
if($tarari>"0"){
foreach($_POST as $key => $val)
{
//	echo "$key --> $val <br>";
$trozos = explode("-",$key);
$claveal = $trozos[0];
if($val == "B" or $val == "R" or $val == "M" or $val == "N" or $val == "S"){$asignatura = $trozos[1];$fila_asig = $fila_asig + "1";}

if(is_numeric($claveal) and ($val == "B" or $val == "R" or $val == "M" or $val == "N" or $val == "S"))
{
		$query = "select estado from textos_alumnos where claveal = '$claveal' and materia = '$asignatura' and curso = '$curso_actual'";
		//echo $query;
		$edit = mysql_query($query);
		$estado0 = mysql_fetch_array($edit);
		$estado = $estado0[0];
		if(strlen($estado) > 0){
		mysql_query("update textos_alumnos set estado = '$val' where claveal = '$claveal' and materia = '$asignatura'");		
		}
		else{
		mysql_query("insert into textos_alumnos (claveal, materia, estado, fecha,curso) values ('$claveal','$asignatura','$val',now(),'$curso_actual')");
		}
}
}
if($procesar == "Enviar"){
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han actualizado correctamente en la base de datos.
</div></div><br />';
}
}
$claveal = "";
?>
<form action="libros.php" method="post" name="libros" class="formu">
<p class="help-block">OPCIONES: <span class="badge badge-info">R</span> = Bien, <span class="badge badge-warning">R</span> = Regular, <span class="badge badge-important">M</span> = Mal, <span class="badge badge-inverse">N</span> = No hay Libro, <span class="badge badge-success">S</span> = Septiembre.</p>
<?
$curso = substr($nivel,0,1);
//$fila_asig = $fila_asig + 1;

echo "<br /><table class='table' style='width:auto'>";


echo "<thead><tr><th style='background-color:#eee'></th>";
$asignaturas0 = "select distinct nombre, codigo, abrev from asignaturas where (curso like '".$curso."º de E%' or curso like '".$curso."º E%' or curso like '".$curso."º Curs%') and abrev not like '%\_%' and nombre in (select distinct materia from textos_gratis where nivel = '".$curso."E') order by codigo";

$num_col = 1;
$asignaturas1 = mysql_query($asignaturas0);
$num_asig = mysql_num_rows($asignaturas1);
while ($asignaturas = mysql_fetch_array($asignaturas1)) {	
	$col{$num_col} = $asignaturas[1];
	echo "<th style='background-color:#eee;'>$asignaturas[2]</th>";
	$num_col = $num_col + 1;
}
if(!(empty($grupo))){$extra=" and FALUMNOS.grupo = '$grupo' ";}
if(stristr($_SESSION['cargo'],'1') == TRUE){echo "<th style='background-color:#eee'>Estado</th></tr></thead><tbody>";}

$alumnos0 = "select nc, FALUMNOS.apellidos, FALUMNOS.nombre, combasi, FALUMNOS.claveal, unidad from FALUMNOS, alma where alma.claveal = FALUMNOS.claveal and FALUMNOS.nivel = '$nivel' $extra order by FALUMNOS.apellidos, FALUMNOS.nombre, nc"; 
//echo $alumnos0;
$alumnos1 = mysql_query($alumnos0);
while ($alumnos = mysql_fetch_array($alumnos1)) {
	if(empty($jefe)){$nc="$alumnos[0]. $alumnos[1], $alumnos[2]";}else{$nc="$alumnos[1], $alumnos[2] ($alumnos[5])";}
	$fila_asig = $alumnos[0];
	if($fila_asig == "5" or $fila_asig == "10" or $fila_asig == "15" or $fila_asig == "20" or $fila_asig == "25" or $fila_asig == "30" or $fila_asig == "35" or $fila_asig == "40")
{
echo "<tr><td style='background-color:#eee'></td>";
$asignaturas0 = "select distinct nombre, codigo, abrev from asignaturas where (curso like '".$curso."º de E%' or curso like '".$curso."º E%' or curso like '".$curso."º Curs%') and abrev not like '%\_%' and nombre in (select distinct materia from textos_gratis where nivel = '".$curso."E') order by codigo";
// echo $asignaturas0."<br>";
$num_col = 1;
$asignaturas1 = mysql_query($asignaturas0);
$num_asig = mysql_num_rows($asignaturas1);
while ($asignaturas = mysql_fetch_array($asignaturas1)) {	
	$col{$num_col} = $asignaturas[1];
	echo "<th style='background-color:#eee'>$asignaturas[2]</th>";
	$num_col = $num_col + 1;
}
if(stristr($_SESSION['cargo'],'1')){$extra=" order by apellidos";}else{$extra=" and FALUMNOS.grupo = '$grupo' order by nc";}
if(stristr($_SESSION['cargo'],'1')){echo "<th style='background-color:#eee'>Estado</th></tr>";}
}

	echo "<tr><td>$nc";
$clave = $alumnos[4];
   	$foto = '../../xml/fotos/'.$clave.'.jpg';
	if (file_exists($foto)) {
		echo "<br /><img src='../../xml/fotos/$clave.jpg' border='2' width='95' height='11' style='border:1px solid #bbb;display:inline;float:left;'  />";
	}           	
	echo "</td>";
	for ($i=1;$i<$num_asig+1;$i++){
		echo "<td nowrap style='padding:0px;margin:0px;'>";
		//echo $col{$i}."-";
		if(strstr($alumnos[3], $col{$i}))
		{
		$r_nombre = $alumnos[4]."-".$col{$i};
		$trozos = explode("-",$r_nombre);
		$claveal = $trozos[0];
		$asignatura = $trozos[1];
		$query = "select estado from textos_alumnos where claveal = '$claveal' and materia like '$asignatura' and curso = '$curso_actual'";
		//echo $query;
		$edit = mysql_query($query);
		$estado0 = mysql_fetch_array($edit);
		$estado = $estado0[0];
?>
	<Label style="color:black;">N
    <input type="radio" name="<? echo $r_nombre;?>" <? echo "checked=\"checked\""; ?> value="N" id="botones_3" /></Label>
    <Label style="color:#3a87ad;">B
    <input type="radio" name="<? echo $r_nombre;?>" <? if($estado == "B"){echo "checked=\"checked\"";} ?> value="B" id="botones_0" /></Label>
    <Label style="color:#f89406;">R
    <input type="radio" name="<? echo $r_nombre;?>" <? if($estado == "R"){echo "checked=\"checked\"";} ?> value="R" id="botones_1" /></Label>
    <Label style="color:#9d261d;">M
    <input type="radio" name="<? echo $r_nombre;?>" <? if($estado == "M"){echo "checked=\"checked\"";} ?> value="M" id="botones_2" /></Label>    
    <Label style="color:#46a546;">S
    <input type="radio" name="<? echo $r_nombre;?>" <? if($estado == "S"){echo "checked=\"checked\"";} ?> value="S" id="botones_4" /></Label> 
<?
//			echo $col{$i};
		}
		echo "</td>";
		
	}
	
		$query2 = "select devuelto from textos_alumnos where claveal = '$claveal' and curso = '$curso_actual'";
		$edit2 = mysql_query($query2);
		$estado2 = mysql_fetch_array($edit2);
		$estadoP = $estado2[0];
	if(stristr($_SESSION['cargo'],'1'))
	{
				echo '<td>';

?>
<a  href="libros.php?claveal=<? echo $claveal;?>&imprimir=si&nivel=<? echo $nivel;?>" ><button class="btn btn-primary"><i class="icon icon-print icon-white" title="imprimir"> </i> </button></a> <br><br>
<?
	if($estadoP == "1" ){ echo '<button class="btn btn-success"><i class="icon icon-ok icon-white" title="Devueltos"> </i> </button>';}
	echo "</td>";
	}

echo "</tr>";
	}
echo "</table>";
?>
<br />
<input type="hidden" name="nivel" value="<? echo $nivel;?>" />
<input type="hidden" name="grupo" value="<? echo $grupo;?>" />
<input type="submit" name="procesar" value="Enviar" class="btn btn-primary" />
</form>
</div>
<? include("../../pie.php");?>		
</body>
</html>