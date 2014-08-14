<?
session_start();
include("../../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);



include("../../../menu.php");
include("menu.php");
echo "<br />";
$profe = $_SESSION['profi'];
// Estructura de la Tabla
?>
<div class="container">
<div class="row">
<div class="page-header">
<? $tr_pr=explode(", ",$profe);?>
  <h2>Calendario de Pruebas y Actividades <small> <? echo $tr_pr[1]." ".$tr_pr[0]; ?></small></h2>
</div>
<br />
<?
if (isset($_GET['mens'])) {
	if($_GET['mens']=="actualizar"){ 
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad se ha actualizado correctamente.
          </div></div>';
}
if($_GET['mens']=="insertar"){
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad se ha registrado correctamente.
          </div></div>';}
}
if($_GET['borrar']=="1"){
mysql_query("delete from diario where id='".$_GET['id']."'");
echo '<div align="center"><div class="alert alert-success alert-block fade in">
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
<div class="col-sm-5">

<?
	echo "<legend class='text-warning' align='center'>Nueva actividad</legend>";
	echo "<form name=\"jcal_post\" action=\"jcal_post.php?\" method=\"post\" class='well'>";
?>
<div class="form-group">
<label>Fecha de la actividad</label>
<div class="input-group" >
  <input required name="fecha" type="text" class="input form-control" data-date-format="YYYY-MM-DD" id="fecha" value="<? echo  $diar[1];?>" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>
</div>

<div class="form-group">
<label>Grupo(s)</label>
<?
echo "<select name=\"grupos[]\" multiple class='form-control'>";
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

<div class="form-group">
<label>Tipo de actividad</label>
<?
$tipos = array("Examen escrito", "Examen oral", "Actividad", "Revisión de actividad", "Otras pruebas", "Anotación personal");
echo "<select name=\"tipo\" class='form-control'>";
	echo "<option>$tipo</option>";
foreach ($tipos as $prueba){
	echo "<option>" . $prueba . "</option>";
}
echo "</select>";
?>
</div>

<div class="form-group">
<label>Título de la actividad</label>
<?
echo "<input name='titulo' type='text' value = '$titulo' class='form-control' required >";
?>
</div>
<div class="form-group">
<label>Observaciones</label>
<?
echo "<textarea name='observaciones' rows='4' cols='45' class='form-control'>$observaciones</textarea>";
?>
</div>

<div class="checkbox">
<label>
<?
if ($calendario == '1' or !$id) { $cal = "checked";}
echo "<input type=\"checkbox\" value='1' name='calendario' $cal /> Enviar al Calendario </label>";
?>
</div>
<?
echo "<input type=\"hidden\" value='$id' name='id'>";
echo "<div class='form-group'>";
echo "<a href='index.php' class='btn btn-success btn-block'>Borrar datos</a>";
echo "<input type=\"submit\" id='formsubmit' value='Enviar datos' class='btn btn-primary btn-block' $aut /></div>";
echo "</form>";
?>
</div>
<div class="col-sm-6">
<legend class='text-warning' align='center'>Registro de actividades</legend>
<?
$eventQuery = mysql_query("SELECT id, fecha, grupo, materia, tipo, titulo FROM diario WHERE profesor='".$_SESSION['profi']."' order by fecha desc");
echo "<table class='table table-striped' style='width:auto' align='center'><thead><th>Fecha</th><th>Grupo</th><th>Materia</th><th>Título</th><th></th></thead><tbody>";
while ($reg=mysql_fetch_array($eventQuery)) {
	echo "<tr style='font-size:12px'>
	<td nowrap>$reg[1]</td>
	<td>$reg[2]</td>
	<td>$reg[3]</td>
	<td>$reg[5]</td>
	<td nowrap>
	<a href='index.php?id=$reg[0]'><i class='fa fa-search'></i></a>&nbsp;
	<a href='index.php?id=$reg[0]&borrar=1'><i class='fa fa-trash-o' data-bb='confirm-delete'></i></a>
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
		$('#fecha').datetimepicker({
			language: 'es',
			pickTime: false
		})
	});  
	</script>
</body>
</html>
