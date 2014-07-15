<?
session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$profes = $_SESSION['profi'];
?>
<?
include("../menu.php");
include("menu.php");
?>
<div align=center>
  <div class="page-header" align="center">
  <h2>Centro TIC <small> Registro de incidencias</small></h2>
</div>
<br />
</div>
<?
if(isset($_GET['enviar']))
{
if (!$profesor or !$fecha or !$descripcion) 
	{ 
	$errorList = '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Hay un problema en el Formulario que quieres enviar:<br>No has introducido datos en alguno de los campos obligatorios.<br> Vuelve atrás e inténtalo de nuevo.</div></div></p>';
	echo $errorList;
}
else
	{
$fecha = cambia_fecha($fecha);		
$query="insert into partestic (unidad,carro,nserie,fecha,hora,alumno,profesor,descripcion,estado) values	('".$unidad."','".$carrito."','".$numeroserie."','".$fecha."','".$hora."','".$alumno."','".$profesor."','".$descripcion."','".$estado."')";
		$prueba = mysql_query($query);

echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos de la incidencia han sido actualizados correctamente.
</div></div>';
		$direccion = "admin@$dominio";
		$tema = "Nuevo parte de incidencia";
		$texto = "Datos de la incidencia:
		Grupo --> '$unidad';
		Carrito --> '$carrito';
		Nª de Serie --> '$numeroserie';
		Fecha --> '$fecha';
		Hora --> '$hora';
		Alumno --> '$alumno';
		Profesor --> '$profesor';
		Descripción --> '$descripcion';
		Estado --> '$estado';
		";
		mail($direccion, $tema, $texto); 
		}
		}
	 else{
?>

<div class="row-fluid">
  <div class="span2"></div>
  <div class="span4">
    <div class="well well-large" align="left">
      <form class="form-vertical" action="cpartes.php">
        <legend>Selecciona Grupo</legend>
        <label>
          <select name="unidad" id="unidad" onchange="submit()" class="input">
            <option><? echo $unidad;?></option>
            <? unidad();?>
          </select>
        </label>
       
        <hr />
        <label>Alumno<br />
          <select name="alumno" id="alumno" class="input-block-level">
            <OPTION></OPTION>
            <? 

  // Datos del alumno que hace la consulta. No aparece el nombre del a&iuml;&iquest;&frac12; de la nota. Se podr&iuml;&iquest;&frac12; incluir.
  $alumnosql = mysql_query("SELECT distinct APELLIDOS, NOMBRE FROM FALUMNOS WHERE unidad like '$unidad' order by APELLIDOS asc");

  if ($falumno = mysql_fetch_array($alumnosql))
        {
        do {
	printf ("<OPTION>$falumno[0], $falumno[1]</OPTION>");

	} while($falumno = mysql_fetch_array($alumnosql));
        }
	?>
          </select>
        </label>
        <label> Profesor<br />
          <input type="text" value="<? echo $profes;?>" readonly class="input input-block-level"/>
          <input name="profesor" type="hidden" value="<? echo $profes;?>"  class="input-xlarge"/>
        </label>
        <label>N&ordm; Carrito<br />
          <input name="carrito" type="text" id="carrito" size="2" maxlength="2"  class="input-small" />
        </label>
        <label>N&ordm; del Ordenador<br />
          <input name="numeroserie" type="text" id="numeroserie" size="2" maxlength="2"  class="input-small"/>
        </label>
          <?
$today = date("j, n, Y");
$hoy = explode(",",$today);
$dia = $hoy[0];
$mes = $hoy[1];
$año = $hoy[2];
				?>
		         <label>Fecha<br />
 <div class="input-append" >
            <input name="fecha" type="text" class="input" value="<? echo $fecha;?>" data-date-format="dd-mm-yyyy" id="fecha" >
  <span class="add-on"><i class="fa fa-calendar"></i></span>
</div> 
</label>

        <label>Hora (1, 2, etc.)<br />
          <input name="hora" type="text" id="hora" maxlength="1" size="3" class="input-small"/>
        </label>
        <label>Descripción del problema <span style="color:#cc6600">(*)</span><br />
          <textarea name="descripcion" rows="5" id="descripcion" class="input-block-level"></textarea>
        </label>
        <br />
        <input name="estado" type="hidden" value="activo" />
        <input name="enviar" type="submit" value="Registrar Incidencia" class="btn btn-primary btn-block" />
      </form>
    </div>
  </div>
  <div class="well well-large span4">
  <legend>Instrucciones.</legend><br />
    <p>En esta p&aacute;gina se dan de alta los problemas que pod&aacute;is tener con los ordenadores, tanto port&aacute;tiles como fijos. </p>
    <p id="texto"> Los fallos pueden ser de dos tipos: bien sucede que la m&aacute;quina o alguna de sus partes presenta problemas (la m&aacute;quina no enciende, se ha fastidiado la pantalla o el teclado, etc); o bien el Sistema Operativo o alguna de sus aplicaciones no funcionan. Cualquiera de las dos clases de problemas se registran aqu&iacute;.</p>
    <p id="texto"> Los campos que es obligatorio rellenar aparecen marcados con el signo <span style="color:#cc6600">(*).</span></p>
    <p id="texto"> Si despues de haber enviado los datos quer&eacute;is modificarlos por alguna raz&oacute;n, el enlace &quot;<a href="clista.php">Listar,
      editar o eliminar los ultimos partes de incidencias</a>&quot; os permitir&aacute; seleccionar
      vuestra incidencia y editarla o eliminarla. </p>
    <p id="texto"> Y una recomendacion: si el problema ha sido causado por el mal uso de un Alumno, registrar el asunto en el modulo de <a href="admin/fechorias/infechoria.php" target="_blank">Problemas de Convivencia</a> de la Intranet. </p>
    <br />
    <a href="clista.php">
    <button class="btn btn-danger">Editar las incidencias registradas.</button>
    </a>
    </form>
  </div>
</div>
<? 	
	}
	

include("../pie.php");
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