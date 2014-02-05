<?
session_start();
include("../../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<script>
function confirmacion() {
	var answer = confirm("ATENCIÓN:\n ¿Estás seguro de que quieres borrar los datos? Esta acción es irreversible. Para borrarlo, pulsa Aceptar; de lo contrario, pulsa Cancelar.")
	if (answer){
return true;
	}
	else{
return false;
	}
}
</script>
<?php
include("../../../menu.php");
include("menu.php");
echo "<br />";
$profe = $_SESSION['profi'];
// Estructura de la Tabla
?>
<div class="page-header" align="center">
<? $tr_pr=explode(", ",$profe);?>
  <h2>Calendario de Pruebas y Actividades <small> <? echo mb_strtolower($tr_pr[1]." ".$tr_pr[0]); ?></small></h2>
</div>
<br />
<?
if (isset($_GET['mens'])) {
	if($_GET['mens']=="actualizar"){ 
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad se ha actualizado correctamente.
          </div></div>';
}
if($_GET['mens']=="insertar"){
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad se ha registrado correctamente.
          </div></div>';}
}
if($_GET['borrar']=="1"){
mysql_query("delete from diario where id='".$_GET['id']."'");
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad se ha eliminado de la base de datos.
          </div></div>';
}
if (isset($_GET['id'])) {
	$id =$_GET['id'];
	$dia = mysql_query(("select * from diario where id = '$id'"));
	$diar = mysql_fetch_array($dia);
	$fecha = $diar[1];
	$grupo = $diar[2];
	$tr_grupo = explode("; ",$grupo);
	$n_grupo = count($tr_grupo);
	$materia = $diar[3];
	$tr_materia = explode("; ",$materia);
	for ($i=0;$i<$n_grupo;$i++){
		$grupo_total.="$tr_grupo[$i] => $tr_materia[$i];";
	}
	$tipo = $diar[4];
	$titulo = $diar[5];
	$observaciones = $diar[6];
	$calendario = $diar[7];
	$reg_profe = $diar[8];
	if ($profe == $reg_profe) {$aut = '';} else{$aut = "disabled";}
}
	?>
 <div class="row-fluid">
<div class="span6">

<?
	echo "<legend class='text-warning' align='center'>Nueva actividad</legend>";
	echo "<form name=\"jcal_post\" action=\"jcal_post.php?\" method=\"post\" class='well'>";
	echo "<div align='center'>";	
	echo "<p class='lead'><small>Fecha</small></p>";
?>
<div class="input-append" >
  <input required name="fecha" type="text" class="input input-block-level" data-date-format="yyyy-mm-dd" id="fecha" value="<?if($fecha == "") { echo date('Y-m-d'); } else { echo $fecha;}?>" >
  <span class="add-on"><i class="icon-calendar"></i></span>
</div>

</div>


<hr />
<div class="row-fluid">
<div class="span6">
<?
echo "<p class='lead'><small>Grupo(s)</small></p> <select name=\"grupos[]\" multiple style='height:130px%;width:100%'>";
	$sql1 = mysql_query("select distinct grupo, materia from profesores where profesor = '".$profe."'");
	while($row1 = mysql_fetch_array($sql1)){ 

		if (stristr($grupo_total,"$row1[0] => $row1[1]")==TRUE) {
				echo "<option selected>" . $row1[0]." => ". $row1[1] . "</option>";
		}

			else{
	echo "<option>" . $row1[0]." => ". $row1[1] . "</option>";
		}
	
	} 

	
echo "</select>";
?>
</div>
<div class="span6">
<?
$tipos = array("Examen escrito", "Examen oral", "Actividad", "Revisión de actividad", "Otras pruebas", "Anotación personal");
echo "<p class='lead'><small>Tipo de actividad</small></p> <select name=\"tipo\" style='width:100%'>";
	echo "<option>$tipo</option>";
foreach ($tipos as $prueba){
	echo "<option>" . $prueba . "</option>";
}
echo "</select>";
?>
</div>
</div>
<?
echo "<hr>";
echo "<p class='lead'><small>Título de la actividad</small></p><input name='titulo' type='text' value = '$titulo' class='span12' required >";
echo "<hr />";
echo "<p class='lead'><small>Observaciones</small></p><textarea name='observaciones' rows='4' cols='45' class='span12'>$observaciones</textarea>";
echo "<hr />";
if ($calendario == '1' or !$id) { $cal = "checked";}
echo "<label class='checkbox'>Enviar al Calendario <input type=\"checkbox\" value='1' name='calendario' $cal /> </label><hr />";
echo "<input type=\"hidden\" value='$id' name='id'>";
echo "<div class='row-fluid'>";
echo "<div class='span6'>";
echo "<a href='index.php' class='btn btn-success btn-block'>Borrar datos</a>";
echo "</div><div class='span6'>";
echo "<input type=\"submit\" id='formsubmit' value='Enviar datos' class='btn btn-primary btn-block' $aut /></div></div>";
echo "</form>";
?>
</div>
<div class="span6">
<legend class='text-warning' align='center'>Registro de actividades</legend>
<?
$eventQuery = mysql_query("SELECT id, fecha, grupo, materia, tipo, titulo FROM diario WHERE profesor='".$_SESSION['profi']."' order by fecha desc");
echo "<table class='table table-striped' style='width:auto' align='center'><thead style='font-size:14px'><th>Fecha</th><th>Grupo</th><th>Materia</th><th>Título</th><th></th></thead><tbody>";
while ($reg=mysql_fetch_array($eventQuery)) {
	echo "<tr style='font-size:12px'>
	<td nowrap>$reg[1]</td>
	<td>$reg[2]</td>
	<td>$reg[3]</td>
	<td>$reg[5]</td>
	<td nowrap>
	<a href='index.php?id=$reg[0]'><i class='icon icon-search'></i></a>&nbsp;
	<a href='index.php?id=$reg[0]&borrar=1'><i class='icon icon-trash' onClick='return confirmacion();'></i></a>
	</td></tr>";
}
echo "</tbody></table>";
include("calendario.php");
echo "";
?>
</div>
</div>
</div>
<?
include("../../../pie.php");
?>
	<script>  
	$(function ()  
	{ 
		$('#fecha').datepicker()
		.on('changeDate', function(ev){
			$('#fecha').datepicker('hide');
		});
		});  
	</script>
</body>
</html>
