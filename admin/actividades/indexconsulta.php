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
registraPagina($_SERVER['REQUEST_URI']);
?>

<?php
 include("../../menu.php");
 include("menu.php");
 ?>
 <div align="center">
<div class="page-header">
  <h2>Actividades Complementarias y Extraescolares <small> Edición de actividades</small></h2>
</div>
<br />
</div>
 <?
mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db);
 if(isset($_POST['submit2']))
  {
  if ($actividad == "" or $departamento == "" or $hoy == "" or $horario == "" or $descripcion == "" or $justificacion == "" or $fecha_act == "") {

echo '<br /><div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
			Todos los campos del formulario son obligatorios, así que vuelve atrás y rellena los que has dejado vacíos.
          </div></div>';	
exit;	
}
$todosgrupos="";
foreach($_POST as $key => $val)
{
$todosgrupos .= $key;
}
$dominio = strstr($todosgrupos, 'grt');
if(strlen($dominio) == 0)
{
	
echo '
<br /><div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
			No has seleccionado ningún Grupo de Alumnos. Vuelve atrás y selecciona algún Grupo para la Actividad.
          </div></div>';
exit;	
}
foreach($_POST as $key => $val)
{
if(substr($key,0,3) == "grt")
{
$grupos .= $val.";";
}
}

$profesor=$_POST["profesor"]; 
if(empty($profesor))
{
	echo '
<br /><div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
			No has seleccionado ningún Profesor como responsable de la Actividad. Vuelve atrás y selecciona algún Grupo para la Actividad.          
			</div></div>';
exit;	
}
for ($i=0;$i<count($profesor);$i++)    
{     
$profe .= $profesor[$i].";";
}   
$fecha = cambia_fecha($fecha_act);
mysql_query("UPDATE  actividades SET  grupos = '$grupos', actividad =  '$actividad', fecha = '$fecha', departamento = '$departamento', profesor = '$profe', descripcion = '$descripcion', justificacion = '$justificacion', horario = '$horario' WHERE id = '$id'");
// Para cambiar la fecha simultaneamente, primero borramos los datos de la actividad actual en el calendario,...

//$idactiv="$id;";
//$calen = mysql_query("select * from cal where idact like '%$idactiv%' and eventdate = '$fecha'");
//$num_filas = mysql_num_rows($calen);
//echo $num_filas."<br>";
//if (mysql_num_rows($calen) > 0 and !($fecha == $fecha_origen)) {
//$calend = mysql_fetch_row($calen);
//$borrar_titulo = str_replace($actividad,'',$calend[3]);
//echo "TITULO: $actividad --->>> <br>$calend[3] --->>> <br>$borrar_titulo<br>";
//$borrar_descripcion = str_replace($descripcion,'',$calend[4]);
//echo "DESCRIPCION: $borrar_descripcion<br>";
//$borrar_idact = str_replace($idactiv,'',$calend[5]);

// mysql_query("update cal set title = '$borrar_titulo', event = '$borrar_descripcion', idact = '$borrar_idact'");	
//$frase = "update cal set title = '$borrar_titulo', event = '$borrar_descripcion', idact = '$borrar_idact'";
//$frase = 
//<<<FIN
//update cal set title = '$borrar_titulo', event = '$borrar_descripcion', idact = '$borrar_idact'
//FIN;
//echo $frase."<br>";
//}

//  y luego los añadimos en la nueva fecha.

//$sq0 = "select fecha, actividad, descripcion, grupos from actividades where id = '$id'";
//$sq1 = mysql_query($sq0);
//$sq2 = mysql_fetch_row($sq1);
//$texto = $sq2[2] . "<br>Grupos que participan: " . $sq2[3];
//mysql_query("UPDATE  cal SET  title =  '$sq2[1]', eventdate = '$sq2[0]', event = '$texto' WHERE idact = '$id'");

  echo '
<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			Los datos de la Actividad han sido modificados correctamente.
			</div></div>';
  }
else{
	
if($modificar == '1')
{
$datos1 = mysql_query("select * from actividades where id = '$id'");
$datos = mysql_fetch_array($datos1);

$fecha0 = explode("-",$datos[7]);
$ano = $fecha0[0];
$mes = $fecha0[1];
$dia = $fecha0[2];
$todosgrupos = $datos[1];
$actividad = $datos[2];
$descripcion = $datos[3];
$departamento = $datos[4];
$horario = $datos[6];
$justificacion = $datos[10];
}
?>
                <? 
                if ($modificar == "1" and $_SESSION['cargo'] == "4") {
                	$jd = "readonly";
                }
                ?>
<div class="row">
<div class="col-sm-1"></div>
<div class="col-sm-5">
<div class="well ">            
<FORM action="indexconsulta.php" method="POST" name="Cursos">
           
                <label>Fecha de la actividad:<br /> 
                      <div class="input-group" id="datetimepicker1">
            <input name="fecha_act" type="text" class="input input-small" value="<? echo "$dia-$mes-$ano"; ?>" data-date-format="DD-MM-YYYY" id="fecha_act" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 
              </label>
              <hr>
                <label>Titulo: <br />
                <input name="actividad" type="text" id="actividad" value="<? echo $actividad; ?>" size="30" maxlength="128" style="width:90%"></label>
               <br />
                <label>Departamento:  <br />
                <SELECT name="departamento" onChange="submit()" >
                    <OPTION><? echo $departamento;?></OPTION>

                    <?
if (!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'5') == TRUE)) {
	  // Datos del alumno que hace la consulta. No aparece el nombre del a&ntilde;o de la nota. Se podr&iacute;a incluir.
  $profe = mysql_query(" SELECT distinct departamento FROM departamentos  where departamento = '". $_SESSION['dpt'] ."' order by departamento asc");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      echo "$opcion1";

	} while($filaprofe = mysql_fetch_array($profe));
        }
}
else{
	?>
	    <OPTION>Actividades Extraescolares</OPTION>
        <OPTION>Relaciones de Género</OPTION>
		<OPTION>Religión</OPTION>
	<?
  // Datos del alumno que hace la consulta. No aparece el nombre del a&ntilde;o de la nota. Se podr&iacute;a incluir.
  $profe = mysql_query(" SELECT distinct departamento FROM departamentos  where departamento not like '%Admin%' and departamento not like '%Conserjeria%' and departamento not like '%Administracion%' order by departamento asc");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      echo "$opcion1";

	} while($filaprofe = mysql_fetch_array($profe));
        }		
	}

	?>
                  </select>
                </label>
               <br />
                <label>Profesor: <br />
                <SELECT multiple name='profesor[]' class="input-xlarge">
                    <?
					if($departamento == "Actividades Extraescolares"){
					echo "<OPTION selected>Mart&iacute;nez Mart&iacute;nez, M&ordf; Pilar</OPTION>";
					}
					elseif($departamento == "Relaciones de Género"){	
					$texto = " where departamento = '$departamento'";
					echo "<OPTION selected>Cabezas Sánchez, Esther</OPTION>";
					}
					else{$texto = " where departamento = '$departamento'";}

  $profe = mysql_query(" SELECT distinct NOMBRE FROM departamentos " . $texto. " order by NOMBRE asc");
while($filaprofe = mysql_fetch_array($profe))        {
if($departamento == "Religión")
{} 
else{
	      $opcion1 = printf ("<OPTION selected>$filaprofe[0]</OPTION>");
	      echo "$opcion1";}

        }
	?>
                  </select>
                  </label>
                  <p class="help-block" > (*) Para seleccionar varios profesores, mantén apretada la tecla Ctrl mientras los vas marcando con el ratón.</p> <br />
                    <input type="hidden" name="hoy"  value="<? $hoy = date('Y\-m\-d'); echo $hoy;?>">
                <label>Descripci&oacute;n: <br />
                <textarea name="descripcion" id="textarea" cols="35" rows="4" style="width:90%"><? echo $descripcion; ?></textarea>
              </label>
              
</div>
</div>
<div class="col-sm-5">
<div class="well ">          
<a href="javascript:seleccionar_todo()" class="btn btn-success">Marcar todos los Grupos</a>
<a href="javascript:deseleccionar_todo()" class="btn btn-warning pull-right">Desmarcarlos todos</a> <br />
              <br />
              <h4>Grupos de alumnos que realizan la actividad</h4>
            
<?
$curso0 = "select distinct curso from alma order by curso";
$curso1 = mysql_query($curso0);
while($curso = mysql_fetch_array($curso1))
{
	echo "<br />";
$niv = $curso[0];
?>
           <? echo "<strong style='margin-right:10px;'> ".$niv." </strong>"; ?>
                <?  
$alumnos0 = "select distinct unidad from alma where curso = '$niv' order by curso";

$alumnos1 = mysql_query($alumnos0);
while($alumno = mysql_fetch_array($alumnos1))
{
$chk="";
$grupo = $alumno[0];
if(strstr($todosgrupos,$grupo)==TRUE){$chk=" checked ";}
?>
                  <? echo "<span style='margin-right:1px;color:#08c'>".$grupo."</span>";?>
                  <input name="<? echo "grt".$grupo;?>" type="checkbox" id="A" value="<? echo $grupo;?>" <? echo $chk;?> style="margin-right:7px;margin-bottom:6px">
                  <? } ?>              
            
 <? } ?>
     <br /><br />
                <label>Justificacion: <br />
                <textarea name="justificacion" id="textarea" cols="35" rows="4" class="col-sm-11"><? echo $justificacion; ?></textarea>
              </label>
			   <br />
            <label>Horario: <br />
                <input name="horario" type="text" value="<? echo $horario; ?>" size="30" maxlength="64" class="input-xlarge">
              </label>       
            <input name="id" type="hidden" value="<? echo $id;?>" />                                                                                                               
    <input name="fecha_origen" type="hidden" value="<? echo '$ano-$mes-$dia'; ?>" /> 
  </div>
  </div>
  </div>
  </div>
  </div>
  <br />
  <div align="center">
    <INPUT type="submit" name="submit2" value="Actualizar datos de la  Actividad" class="btn btn-primary">
  </FORM>
  <br /><br />
  <div class="well well-large" style="width:500px;text-align:left;">
  <div style="font-weight:bold; color:#08c;">Información sobre Transporte en las Actividades.</div>
  <p>AUTOBUSES RICARDO<br /> 952 80 86 45 (OFICINA);<br /> 671 527 372 (MÓVIL DE CONTACTO PARA CONFIRMACIÓN);<br /> 649 45 70 99 (MÓVIL DE ANTONIO -DUEÑO DE LA EMPRESA- SÓLO EN CASO DE EMERGENCIA).</p>
  </div>
  </div>
<? } ?>
<? include("../../pie.php");?>
<script>

function seleccionar_todo(){
	for (i=0;i<document.Cursos.elements.length;i++)
		if(document.Cursos.elements[i].type == "checkbox")	
			document.Cursos.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.Cursos.elements.length;i++)
		if(document.Cursos.elements[i].type == "checkbox")	
			document.Cursos.elements[i].checked=0
}
</script>
	<script>  
	$(function ()  
	{ 
		$('#datetimepicker1').datetimepicker({
			language: 'es',
			pickTime: false
		})
	});  
	</script>
  </BODY>
</HTML>
