<?
if(isset($_POST['padres']))
{
include("padres.php");
exit;
}
?>
<?
session_start();
include("../../config.php");
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


?>
  <?php
include("../../menu.php");
include("../../faltas/menu.php");
if (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];}elseif (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];}else{$unidad="";}
if (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];}elseif (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];}else{$grupo="";}
if (isset($_GET['nombre'])) {$nombre = $_GET['nombre'];}elseif (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];}else{$nombre="";}
if (isset($_GET['fecha12'])) {$fecha12 = $_GET['fecha12'];}elseif (isset($_POST['fecha12'])) {$fecha12 = $_POST['fecha12'];}else{$fecha12="";}
if (isset($_GET['fecha22'])) {$fecha22 = $_GET['fecha22'];}elseif (isset($_POST['fecha22'])) {$fecha22 = $_POST['fecha22'];}else{$fecha22="";}
if (isset($_GET['numero'])) {$numero = $_GET['numero'];}elseif (isset($_POST['numero'])) {$numero = $_POST['numero'];}else{$numero="";}

?>
  <div align="center"> 
<div class="page-header">
  <h2>Faltas de Asistencia <small> Informe para los Padres</small></h2>
  </div>
<br />
  <form enctype='multipart/form-data' action='cpadres.php' method='post'>
<div class="row">
  <div class="col-sm-3"></div>
  <div class="col-sm-3">
   <div class="well well-large">        
        <h6>Selecciona unidad o Grupo</h6><br />
          <label> Grupo: <select  name="unidad" class="input" onChange="submit()">
            <option><? echo $unidad;?></option>
            <?
unidad();
?>
            </label>
<hr>
            <h6>
        Selecciona los Alumnos...</h6><br />
          <select name="nombre[]" multiple style="height:560px;">
            <? 
$alumno = mysql_query(" SELECT distinct APELLIDOS, NOMBRE, claveal FROM FALUMNOS WHERE unidad like '$unidad%'  order by APELLIDOS asc");
  while($falumno = mysql_fetch_array($alumno))
        {
	      echo "<OPTION>$falumno[0], $falumno[1] --> $falumno[2]</OPTION>";

        }
	?>
    </select>
    
         </div>
         
         
       </div>
<div class="col-sm-3">
 
  <div class="well well-large">
          <?
	$fecha32 = date('d')."-".date('m')."-".date('Y');
  $tr = explode("-",$inicio_curso);
  $inicio = "$tr[2]-$tr[1]-$tr[0]";
?>
         <h6> Rango de fechas</h6><br />      
         <label> Inicio: 
      <div class="form-group"  id="datetimepicker1">
      <div class="input-group">
            <input name="fecha12" type="text" class="input input-small" data-date-format="DD/MM/YYYY" id="fecha12" value="<?if($fecha12){ echo $fecha12;}?>" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 
</div>
</label>
 &nbsp;&nbsp;&nbsp;&nbsp;
<label>Fin: 
	<div class="form-group"  id="datetimepicker2">
 <div class="input-group">
  <input name="fecha22" type="text" class="input input-small" data-date-format="DD/MM/YYYY" id="fecha22" value="<?if($fecha22){ echo $fecha22;}?>" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
 </div>
</div> 
      </label>
 <hr>
          <h6>
        N&uacute;mero m&iacute;nimo
            de Faltas&nbsp;</h6><br />
          <label><input name="numero" type="text" value="1" class="input-mini" maxlength="3" alt="Mes" /></label>
          <br /><br />
          <input name="padres" type="submit" id="padres" value='Enviar Datos' class="btn btn-primary" />
       </div>
         </div>
         </div>
</form>

        <?php	
include("../../pie.php");
?>   

	<script>  
	$(function ()  
	{ 
		$('#datetimepicker1').datetimepicker({
			language: 'es',
			pickTime: false
		});
		
		$('#datetimepicker2').datetimepicker({
			language: 'es',
			pickTime: false
		});
	});  
	</script>
</body>
</html>
