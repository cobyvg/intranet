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
?>
  <?
  	include("../../menu.php");
  ?>
  <br />
   <div align=center>
  <div class="page-header">
  <h2>Administración <small> Crear el Carnet del Alumno</small></h2>
</div>
<div class="container-fluid">
<div class="row">
<div class="col-sm-6 col-sm-offset-3">
<?
$id=$_POST['seleccion'];
if ($id>0){$modificar=1;}
else {$modificar=0;}
$alumnos='';

$query_Recordset1 = "SELECT distinct unidad FROM alma ORDER BY unidad ASC";
$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$query_Recordset2 = "SELECT * FROM alma ORDER BY Apellidos ASC";
$Recordset2 = mysql_query($query_Recordset2) or die(mysql_error());
$row_Recordset2 = mysql_fetch_array($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$unidad = $row_Recordset1[16];
?>
<div align="center" class="well well-large" style="width:550px">
<form id="form1" name="form1" method="post" action="carnet.php">
  <div class="form-group">
       <div class="controls">
<legend>Impresión de Carnet por Grupo</legend>
  <label class="control-label" for="grupo">Selecciona un Grupo:</label>

<?
if (stristr($_SESSION['cargo'],'2') == TRUE and stristr($_SESSION['cargo'],'1') == FALSE) {
	$unidad_tutor = $_SESSION ['s_unidad'];
	echo "<input type='text' name='select' value='$unidad_tutor' readonly class='input-small'/>"; 
}
else{
?>
  <select name="select" class="input-small" id = "grupo">
    <?php
 while ($row_Recordset1 = mysql_fetch_array($Recordset1)) { 
 	$unidad = $row_Recordset1[0];
?>
    <option value="<?php echo $unidad;?>"><?php echo $unidad;?></option>
    <?php
}
?>
  </select>
<?
}
?>
<hr />
  <input type="submit" name="Submit" value="Enviar" class="btn btn-primary" />
  </div>
  </div>
</form>
 </div>




 <div align="center" class="well well-large" style="width:550px">

<form name="crear" action="carnet.php" method="POST" onsubmit="placeInHidden('*', this.form.al2,this.form.profes)">
 <div class="form-group">
       <div class="controls">
<legend>Impresión de Carnet por Alumno</legend>

<?############################?>
<SCRIPT language="JavaScript" type="text/javascript">

<!-- Begin

function selectAllOptions(desel,sel,desel1,sel1){
  for (var i=0; i<sel.options.length; i++) {
    sel.options[i].selected = true;
  }
for (var i=0; i<desel.options.length; i++) {
    desel.options[i].selected = false;
  }
 for (var i=0; i<sel1.options.length; i++) {
    sel1.options[i].selected = true;
  }
for (var i=0; i<desel1.options.length; i++) {
    desel1.options[i].selected = false;
  }
}

sortitems = 1;  // Automatically sort items within lists? (1 or 0)

function move(fbox,tbox) {
for(var i=0; i<fbox.options.length; i++) {
if(fbox.options[i].selected && fbox.options[i].value != "") {
var no = new Option();
no.value = fbox.options[i].value;
no.text = fbox.options[i].text;
tbox.options[tbox.options.length] = no;
fbox.options[i].value = "";
fbox.options[i].text = "";
   }
}
BumpUp(fbox);
if (sortitems) SortD(tbox);
}
function BumpUp(box)  {
for(var i=0; i<box.options.length; i++) {
if(box.options[i].value == "")  {
for(var j=i; j<box.options.length-1; j++)  {
box.options[j].value = box.options[j+1].value;
box.options[j].text = box.options[j+1].text;
}
var ln = i;
break;
   }
}
if(ln < box.options.length)  {
box.options.length -= 1;
BumpUp(box);
   }
}

function SortD(box)  {
var temp_opts = new Array();
var temp = new Object();
for(var i=0; i<box.options.length; i++)  {
temp_opts[i] = box.options[i];
}
for(var x=0; x<temp_opts.length-1; x++)  {
for(var y=(x+1); y<temp_opts.length; y++)  {
if(temp_opts[x].text > temp_opts[y].text)  {
temp = temp_opts[x].text;
temp_opts[x].text = temp_opts[y].text;
temp_opts[y].text = temp;
temp = temp_opts[x].value;
temp_opts[x].value = temp_opts[y].value;
temp_opts[y].value = temp;
      }
   }
}
for(var i=0; i<box.options.length; i++)  {
box.options[i].value = temp_opts[i].value;
box.options[i].text = temp_opts[i].text;
   }
}

function placeInHidden(delim, selStr, hidStr)
{
  hidStr.value = '';
  for (var i=0; i<selStr.options.length; i++) {
    hidStr.value = hidStr.value + delim + selStr.options[i].value;
  }
}




// End -->
</script>
<?

if (stristr($_SESSION['cargo'],'2') == TRUE) {
	$unidad_tuto = " and unidad = '$unidad_tutor'";
}
else{
	$unidad_tuto = "";
}
if ($modificar==1) {                  #elige selección múltiple
		foreach($alumnos as  $valor) {
			if (!isset($seleccion1)) { $seleccion1="'".$valor;}
			else {$seleccion1=$seleccion1."','".$valor;}		
		}
	$seleccion1=$seleccion1."'";
	$query_al = "SELECT claveal, Unidad, Apellidos, Nombre FROM alma WHERE claveal In (".$seleccion1.") ".$unidad_tuto." ORDER BY Unidad, Apellidos, Nombre ASC";
	$query_noal = "SELECT claveal, Unidad, Apellidos, Nombre FROM alma WHERE claveal Not In (".$seleccion1.") ".$unidad_tuto." ORDER BY Unidad, Apellidos, Nombre ASC";
	#echo '<br>'.$query_al.'<br>';
}
else {
$query_al = "SELECT claveal, Unidad, Apellidos, Nombre FROM alma WHERE 1=2 ".$unidad_tuto." ORDER BY Unidad, Apellidos, Nombre ASC";
$query_noal = "SELECT claveal, Unidad, Apellidos, Nombre FROM alma where 1=1 ".$unidad_tuto." ORDER BY Unidad, Apellidos, Nombre ASC";
}

?>

<table align="center" cellpadding="3">
<tr>
<td>
  <label class="control-label" for="al1">Alumnos disponibles</label>
<select multiple size="15" textcolor="ffff99" name="al1" id="al1">
	<? $alumnos = mysql_query($query_noal);
	while ($alumnado = mysql_fetch_row($alumnos)){ 
		echo "<Option value='$alumnado[0]'>$alumnado[1] $alumnado[2] , $alumnado[3] "; 
	} #del while
	?>
</select></td>
<td>
<input type="button" value="   >>   " onclick="move(this.form.al1,this.form.al2)" name="B5" class="btn btn-warning"><br><br />
<input type="button" value="   <<   " onclick="move(this.form.al2,this.form.al1)" name="B6"class="btn btn-warning"><br>

</td>
<td>
  <label class="control-label" for="al2">Alumnos seleccionados</label>
<select multiple size="15" name="al2" id="al2">
	<? $alumnos = mysql_query($query_al);
	while ($alumnado = mysql_fetch_row($alumnos)){ 
		echo "<Option value='$alumnado[0]'>$alumnado[1] $alumnado[2] , $alumnado[3] "; 
	} #del while ?>
</select><br>
<input type='hidden' name='alumnos' value=''>
</td>
</tr>
</table>



<? ############
# <input type=submit value="Añadir actividad" onclick="selectAllOptions(this.form.prof1,this.form.prof2,this.form.al1,this.form.al2)">
###########################?>




<br />
<input type=submit value="Aceptar" class="btn btn-primary" onclick="placeInHidden('*', this.form.al2,this.form.alumnos);">
</div>
</div>

</form>
</div>
<? if(stristr($_SESSION['cargo'],'1') == TRUE) {
	echo ' <div align="center" class="well well-large" style="width:550px">';
	echo '<legend>Impresión de todos los Alumnos</legend>';
	echo "<div align='center'>";
	echo "<a href='carnet.php?todos=1' class='btn btn-primary'><i class='fa fa-print '> </i> Imprimir todos los cursos</a></div>";
	echo '</div>';
}
?>
</div>
</div>
</div>



<?
#}
mysql_close();
include ("../../pie.php");
?>
</html>