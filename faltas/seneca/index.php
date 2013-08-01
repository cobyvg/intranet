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

if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?
 include("../../menu.php");
 include("../menu.php");
?>
<div align="center">
<div class="page-header" align="center">
  <h2>Faltas de Asistencia <small> Subir faltas a S&eacute;neca</small></h2>
</div>
<br />
  <div class="well well-large" align="left" style="width:500px;">
			<div class="help-block" style="text-align:justify"><h4>Instrucciones de Uso.</h4><br />
Es importante que las listas de Alumnos est&eacute;n actualizadas para evitar errores en la importaci&oacute;n de las Faltas. <br />Adem&aacute;s, ten en cuenta que S&eacute;neca s&oacute;lo acepta importaciones de un mes m&aacute;ximo de Faltas de Asistencia. Por esta raz&oacute;n, el Primer D&iacute;a que introduces debe ser el primer d&iacute;a del mes (o el mas pr&oacute;ximo en caso de que sea un mes de vacaciones, o puente coincidente con los primeros dias de un mes, etc.). <br />El mismo criterio se aplica para el ultimo d&iacute;a del mes. <br />Es muy importante que selecciones dias lectivos, as&iacute; que echa un vistazo al Calendario oficial de la Consejer&iacute;a para asegurarte. <br />Una vez le damos a enviar se generan los ficheros que posteriormente se importan a S&eacute;neca, as&iacute; que ya puedes abrir la pagina de S&eacute;neca y empezar a importar las Faltas de Asistencia. </div>
	<hr>		
        <form id="form1" name="form1" method="post" action="exportar.php">
        
         <label >Primer d&iacute;a: 
      <div class="input-append" >
            <input name="iniciofalta" type="text" class="input input-small" data-date-format="dd/mm/yyyy" id="iniciofalta" >
  <span class="add-on"><i class="icon-calendar"></i></span>
</div> 
</label>
 &nbsp;&nbsp;&nbsp;&nbsp;
<label>Ultimo d&iacute;a: 
 <div class="input-append" >
  <input name="finfalta" type="text" class="input input-small" data-date-format="dd/mm/yyyy" id="finfalta" >
  <span class="add-on"><i class="icon-calendar"></i></span>
</div> 

      </label>
   <br />
  <div align="center"><input type="submit" name="Submit" value="Enviar" class="btn btn-primary" /></div>
        </form>
        </div>
      <hr style="width:550px;">
	          <?php	
include("../..//admin/cursos/calendario2.php");
echo "<br>";
?>
      </div>
        <?php	
include("../../pie.php");
?>   
<script>  
	$(function ()  
	{ 
		$('#iniciofalta').datepicker()
		.on('changeDate', function(ev){
			$('#iniciofalta').datepicker('hide');
		});
		});  
	</script>
	<script>  
	$(function ()  
	{ 
		$('#finfalta').datepicker()
		.on('changeDate', function(ev){
			$('#finfalta').datepicker('hide');
		});
		});  
	</script>
</body>
</html>
