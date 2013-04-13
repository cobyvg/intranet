<?
if($padres=="Enviar Datos")
{
include("padres.php");
exit;
}
?>
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
?>
  <?php
include("../../menu.php");
include("../../faltas/menu.php");
?>
  <div align="center">  <br />
<h3>Informe de Faltas de Asistencia para los Padres</h3><br /></div>
  <br />
  <form enctype='multipart/form-data' action='cpadres.php' method='post'>
<div class="row-fluid">
  <div class="span3"></div>
  <div class="span3">
  <div class="well-2 well-large">
          <?
	$fecha32 = date('d')."-".date('m')."-".date('Y');
  $tr = explode("-",$inicio_curso);
  $inicio = "$tr[2]-$tr[1]-$tr[0]";
?>
         <h6> Rango de fechas</h6><br />      
         <label> Inicio: 
      <div class="input-append" >
            <input name="fecha12" type="text" class="input input-small" data-date-format="dd/mm/yyyy" id="fecha12" value="<?if($fecha12){ echo $fecha12;}?>" >
  <span class="add-on"><i class="icon-calendar"></i></span>
</div> 
</label>
 &nbsp;&nbsp;&nbsp;&nbsp;
<label>Fin: 
 <div class="input-append" >
  <input name="fecha22" type="text" class="input input-small" data-date-format="dd/mm/yyyy" id="fecha22" value="<?if($fecha22){ echo $fecha22;}?>" >
  <span class="add-on"><i class="icon-calendar"></i></span>
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
<div class="span3">
  <div class="well-2 well-large">        
        <h6>Selecciona Nivel o Grupo</h6><br />
          <label> Nivel <select  name="nivel" class="input-mini" onChange="submit()">
            <option><? echo $nivel;?></option>
            <?
nivel();
?>
          </select>
          &nbsp;&nbsp;Grupo 
          <select name="grupo" onChange="submit()"  class="input-mini" >
            <option><? echo $grupo;?></option>
            <?
grupo($nivel);
?>
            </select>
            </label>
<hr>
            <h6>
        Selecciona los Alumnos...</h6><br />
          <select name="nombre[]" multiple style="height:560px;">
            <? 
$alumno = mysql_query(" SELECT distinct APELLIDOS, NOMBRE, claveal FROM FALUMNOS WHERE NIVEL like '$nivel%' AND GRUPO like '$grupo%' order by APELLIDOS asc");
  while($falumno = mysql_fetch_array($alumno))
        {
	      echo "<OPTION>$falumno[0], $falumno[1] --> $falumno[2]</OPTION>";

        }
	?>
    </select>
    
         </div>
         </div>
         </div>
</form>
</body>
        <?php	
include("../../pie.php");
?>   
<script>  
	$(function ()  
	{ 
		$('#fecha12').datepicker()
		.on('changeDate', function(ev){
			$('#fecha12').datepicker('hide');
		});
		});  
	</script>
	<script>  
	$(function ()  
	{ 
		$('#fecha22').datepicker()
		.on('changeDate', function(ev){
			$('#fecha22').datepicker('hide');
		});
		});  
	</script>
</html>
