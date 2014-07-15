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

$grupo=$_GET['unidad'];

## estrutura de la clase
#$estructura_clase='222';
$estructura_clase='232';
if ($estructura_clase=='232') {$mesas_col=8;}
if ($estructura_clase=='222') {$mesas_col=7;}
## fin estructura

function al_con_nie($var_nie,$var_grupo)
{
	$fquery="SELECT Nombre, Apellidos FROM alma WHERE unidad='".$var_grupo."'and claveal='".$var_nie."' order by Apellidos, Nombre limit 1";
	$fresultado = mysql_query($fquery);
	$fqry = mysql_fetch_array($fresultado);
	return($fqry[1].', '.$fqry[0]);
}


echo '<div align="center">';
echo '<h3><br>Asignación de puestos de los Alumnos de ',$_GET['undad'],'<br><br></h3>';

#mysql_close();
############################## si se han guardado
if (isset($_POST['listOfItems'])){
mysql_query("UPDATE puestos_alumnos SET puestos='".$_POST['listOfItems']."' WHERE unidad='".$grupo."'");
#	echo 'jhkjshfd: '.$_POST['listOfItems'];
# crear registr en la tabla puestos o actualizar (unidad y cadena de asignacion)


}

# cargar la cadena de asignación. Si no existe crear el registro
$qry="SELECT * FROM puestos_alumnos WHERE unidad='".$grupo."' limit 1";
$resultado = mysql_query($qry);
$numero_rows = mysql_num_rows($resultado);
if ($numero_rows<>1){mysql_query("INSERT INTO puestos_alumnos (unidad, puestos) VALUES ('".$grupo."', '')");}
else {$qrypuestos = mysql_fetch_array($resultado);
	$cadena_puestos=$qrypuestos[1];}
#echo $cadena_puestos;
#crear función alumno(NIE)=alumno
#echo $cadena_puestos;
# explode con ; para cada alumno y luego explode con | para dividir puesto y nie
$matriz_puestos=explode(';',$cadena_puestos);
foreach ($matriz_puestos as $value) {
    $los_puestos=explode('|',$value);
	if ($los_puestos[0]=='allItems'){$sin_puesto[]=$los_puestos[1];}
	else {$con_puesto[$los_puestos[0]]=$los_puestos[1];}

}
#print_r($sin_puesto);
#print_r($con_puesto)
# Crear los array de alumnos con puesto y sin puesto (no asignados)
# con[puesto]=nie 
# sin[puesto]=nie


############################
?>


<style type="text/css">
body{
	font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;	/* Font to use */
	background-color:#FFF;
}
#footer{
	height:30px;
	vertical-align:middle;
	text-align:center;
	clear:both;
	padding-right:3px;
	background-color:#FFF;
	margin-top:2px;
	width:990px;
}
#footer form{
	margin:0px;
	margin-top:2px;
}
#dhtmlgoodies_dragDropContainer{	/* Main container for this script */
	width:1050px;
	height:100px;
	border:0px solid #317082;
	background-color:#FFF;
	-moz-user-select:none;
}
#dhtmlgoodies_dragDropContainer ul{	/* General rules for all <ul> */
	margin-top:0px;
	margin-left:0px;
	margin-bottom:0px;
	padding:2px;
}

#dhtmlgoodies_dragDropContainer li,#dragContent li,li#indicateDestination{	/* Movable items, i.e. <LI> */
	text-align:left;
	list-style-type:none;
	height:40px;
	background-color:#EEE;
	border:1px solid #000;
	padding:2px;
	margin-bottom:2px;
	cursor:pointer;
	font-size:0.7em;
}

li#indicateDestination{	/* Box indicating where content will be dropped - i.e. the one you use if you don't use arrow */
	border:1px solid #317082;
	background-color:#FFF;
}

/* LEFT COLUMN CSS */
div#dhtmlgoodies_listOfItems{	/* Left column "Available students" */

	float:left;
	margin-left:60px;
	padding-left:10px;
	padding-right:10px;

	/* CSS HACK */
	width: 122px;	/* IE 5.x */
	width/* */:/**/180px;	/* Other browsers */
	width: /**/180px;

}
#dhtmlgoodies_listOfItems ul{	/* Left(Sources) column <ul> */
/*	height:960px;*/
}

div#dhtmlgoodies_listOfItems div{
	border:1px solid #999;
}
div#dhtmlgoodies_listOfItems div ul{	/* Left column <ul> */
	margin-left:5px;	/* Space at the left of list - the arrow will be positioned there */
}
#dhtmlgoodies_listOfItems div p{	/* Heading above left column */
	margin:0px;
	font-weight:bold;
	padding-left:12px;
	background-color:#317082;
	color:#FFF;
	margin-bottom:5px;
}
/* END LEFT COLUMN CSS */

#dhtmlgoodies_dragDropContainer .mouseover{	/* Mouse over effect DIV box in right column */
	background-color:#E2EBED;
	border:1px solid #317082;
}

/* Start main container CSS */

div#dhtmlgoodies_mainContainer{	/* Right column DIV */
	width:690px;
	float:left;
}
#dhtmlgoodies_mainContainer div{	/* Parent <div> of small boxes */
	float:left;
	margin-right:10px;
	margin-bottom:10px;
	margin-top:0px;
	border:1px solid #999;

	/* CSS HACK */
	width: 102px;	/* IE 5.x */
	width/* */:/**/100px;	/* Other browsers */
	width: /**/100px;

}
#dhtmlgoodies_mainContainer div ul{
	margin-left:0px;
}

#dhtmlgoodies_mainContainer div p{	/* Heading above small boxes */
	margin:0px;
	padding:0px;
	padding-left:12px;
	font-weight:bold;
	background-color:#317082;
	color:#FFF;
	margin-bottom:5px;
}

#dhtmlgoodies_mainContainer ul{	/* Small box in right column ,i.e <ul> */
	width:100px;
	height:60px;
	border:0px;
	margin-bottom:0px;
	overflow:hidden;

}

#dragContent{	/* Drag container */
	position:absolute;
	width:100px;
	height:60px;
	display:none;
	margin:0px;
	padding:0px;
	z-index:2000;
}

#dragDropIndicator{	/* DIV for the small arrow */
	position:absolute;
	width:7px;
	height:10px;
	display:none;
	z-index:1000;
	margin:0px;
	padding:0px;
}
</style>
<style type="text/css" media="print">
div#dhtmlgoodies_listOfItems{
	display:none;
}
body{
	background-color:#FFF;
}
img{
	display:none;
}
#dhtmlgoodies_dragDropContainer{
	border:0px;
	width:100%;
}
</style>




<div id="dhtmlgoodies_dragDropContainer">

	<div id="dhtmlgoodies_listOfItems">
		<div>
			<p>Alumnos</p>
		<ul id="allItems">
	<?php 	
	$sql="SELECT Apellidos, Nombre, claveal FROM alma WHERE Unidad='".$grupo."' ORDER BY Apellidos, Nombre ";
		$res_alumnos=mysql_query($sql);
					
						while($alumnos = mysql_fetch_array($res_alumnos)){
							if (!in_array($alumnos[2],$con_puesto)){
							echo '<li id="'.$alumnos[2].'">'.$alumnos[0].', '.$alumnos[1].'</li>';}
						
						}

?>
		</ul>
		</div>
	</div>
<div id="dhtmlgoodies_mainContainer">
		<!-- ONE <UL> for each "room" -->

<?php 
if ($estructura_clase=='232') {$nbox=42;}
if ($estructura_clase=='222') {$nbox=36;};
echo "<table>";
for ($i=1;$i<7;$i++){
	echo '<tr>';
	for ($j=1;$j<$mesas_col;$j++){
	echo "<td><div><p align='center'>".$nbox."</p>";
	#Comprobar si existe para colocar.
	echo	'<ul id="'.$nbox.'">';
	if (isset($con_puesto[$nbox])){echo '<li id='.$con_puesto[$nbox].'>'.al_con_nie($con_puesto[$nbox],$grupo).'</li>'; }				   
	echo '</ul></div></td>';
	if ($j==2 or $j==$mesas_col-3) {echo '<td>|</td>';}
	$nbox--;
	}
	echo '</tr>';
}
echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><div align='center'><p>Profesor/a</p><br><br></div></td></tr>";
echo '</table>';



/*	
	</div>
</div>
<div id='footer'>
	<form name="myForm" method="post" action="puestos.php?grupo=<?php  echo $grupo;?>" onsubmit="saveDragDropNodes()">
	<input type="hidden" name="listOfItems" value="">
	<center><input type="submit" value="Guardar" name="saveButton"></center>
	</form>
</div>
<ul id="dragContent"></ul>
<div id="dragDropIndicator"><img src="images/insert.gif"></div>
*/

/*<ul id="dragContent"></ul>
<div id="dragDropIndicator"><img src="images/insert.gif"></div>
<div id="saveContent"><!-- THIS ID IS ONLY NEEDED FOR THE DEMO --></div>*/


#include('../pie.inc.php');?>
