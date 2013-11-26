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

$error=0;
if(isset($_POST['Submit'])) {
	
	$tipo = $_POST['tipo'];
	$iniciofalta = $_POST['iniciofalta'];
	$finfalta = $_POST['finfalta'];
	
	if (!empty($iniciofalta) && !empty($finfalta)) {
		switch ($tipo) {
			default :
			case 1 : header("Location:"."exportarSeneca.php?iniciofalta=$iniciofalta&finfalta=$finfalta"); break;
			case 2 : header("Location:"."exportar.php?iniciofalta=$iniciofalta&finfalta=$finfalta"); break;
		}
	}
	else {
		$error=1;
	}
}
?>
<?
 include("../../menu.php");
 include("../menu.php");
?>
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Faltas de Asistencia <small> Subir faltas a S&eacute;neca</small></h2>
</div>
<br />
  <div class="well well-large" align="left" style="width:500px;">
			<div class="help-block" style="text-align:justify; <?php if($error) echo 'color: red;';?>"><h4>Instrucciones de Uso.</h4><br />
Para poder importar las faltas de los alumnos, es necesario en primer lugar descargar un archivo desde S&eacute;neca --> Utilidades --> Imprtaci&oacute;n/Exportaci&oacute;n
 --> Exportaci&oacute;n de Faltas del alumnado. Crea un nuevo archivo de todos los grupos del Centro, y acepta la fecha propuesta. Tardar&aacute; unos instantes en aparecer, as&iacute; que vuelve al cabo de un minuto a la misma p&aacute;gina y te aparecer&aacute; un mensaje confirmando que el archivo ha sido generado.
 Descarga el archivo y descompr&iacute;melo. Copia todos los archivos descomprimidos en el directorio de la intranet, en /faltas/seneca(origen/. Eso es todo.
 <br />Es importante que las listas de Alumnos est&eacute;n actualizadas para evitar errores en la
importaci&oacute;n de las Faltas. <br />Adem&aacute;s, ten en cuenta que S&eacute;neca s&oacute;lo acepta 
importaciones de un mes m&aacute;ximo de Faltas de Asistencia. Por esta raz&oacute;n, el Primer D&iacute;a que 
introduces debe ser el primer d&iacute;a del mes (o el mas pr&oacute;ximo en caso de que sea un mes de vacaciones, o 
puente coincidente con los primeros dias de un mes, etc.). <br />El mismo criterio se aplica para el ultimo 
d&iacute;a del mes. <br />Es muy importante que selecciones dias lectivos, as&iacute; que echa un vistazo al 
Calendario oficial de la Consejer&iacute;a para asegurarte. <br />Una vez le damos a enviar se generan los 
ficheros que posteriormente se importan a S&eacute;neca, as&iacute; que ya puedes abrir la pagina de S&eacute;neca 
y empezar a importar las Faltas de Asistencia. </div>
	<hr>		
        <form id="form1" name="form1" method="post" action="index.php">
        
         <label >Primer d&iacute;a: 
      <div class="input-append" >
            <input name="iniciofalta" type="text" class="input input-small" data-date-format="dd/mm/yyyy" id="iniciofalta" required />
  <span class="add-on"><i class="icon-calendar"></i></span>
</div> 
</label>
 &nbsp;&nbsp;&nbsp;&nbsp;
<label>Ultimo d&iacute;a: 
 <div class="input-append" >
  <input name="finfalta" type="text" class="input input-small" data-date-format="dd/mm/yyyy" id="finfalta" required />
  <span class="add-on"><i class="icon-calendar"></i></span>
</div> 

      </label>
      
      <br>
      
      <legend>Tipo de exportaci&oacute;n</legend>
      
      <label class="radio">
        <input type="radio" name="tipo" value="1" checked> Generar un archivo con todas las unidades.
      </label>
      
      <label class="radio">
        <input type="radio" name="tipo" value="2"> Generar un archivo por cada unidad.
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
���������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������������
