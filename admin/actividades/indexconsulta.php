<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}

if($_SESSION['cambiar_clave']) {
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/clave.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/clave.php');
		exit();
	}
}


registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?php
 include("../../menu.php");
 include("menu.php");
 ?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Actividades Complementarias y Extraescolares <small> Edición de actividades</small></h2>
</div>
<br />

 <?
 if(isset($_POST['submit2']))
  {
  if ($actividad == "" or $departamento == "" or $hoy == "" or $horario == "" or $descripcion == "" or $justificacion == "" or $fecha_act == "") {

echo '<br /><div align="center"><div class="alert alert-danger alert-block fade in">
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
<br /><div align="center"><div class="alert alert-danger alert-block fade in">
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
<br /><div align="center"><div class="alert alert-danger alert-block fade in">
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
mysqli_query($db_con, "UPDATE  actividades SET  grupos = '$grupos', actividad =  '$actividad', fecha = '$fecha', departamento = '$departamento', profesor = '$profe', descripcion = '$descripcion', justificacion = '$justificacion', horario = '$horario' WHERE id = '$id'");
// Para cambiar la fecha simultaneamente, primero borramos los datos de la actividad actual en el calendario,...

//$idactiv="$id;";
//$calen = mysqli_query($db_con, "select * from cal where idact like '%$idactiv%' and eventdate = '$fecha'");
//$num_filas = mysqli_num_rows($calen);
//echo $num_filas."<br>";
//if (mysqli_num_rows($calen) > 0 and !($fecha == $fecha_origen)) {
//$calend = mysqli_fetch_row($calen);
//$borrar_titulo = str_replace($actividad,'',$calend[3]);
//echo "TITULO: $actividad --->>> <br>$calend[3] --->>> <br>$borrar_titulo<br>";
//$borrar_descripcion = str_replace($descripcion,'',$calend[4]);
//echo "DESCRIPCION: $borrar_descripcion<br>";
//$borrar_idact = str_replace($idactiv,'',$calend[5]);

// mysqli_query($db_con, "update cal set title = '$borrar_titulo', event = '$borrar_descripcion', idact = '$borrar_idact'");	
//$frase = "update cal set title = '$borrar_titulo', event = '$borrar_descripcion', idact = '$borrar_idact'";
//$frase = 
//<<<FIN
//update cal set title = '$borrar_titulo', event = '$borrar_descripcion', idact = '$borrar_idact'
//FIN;
//echo $frase."<br>";
//}

//  y luego los añadimos en la nueva fecha.

//$sq0 = "select fecha, actividad, descripcion, grupos from actividades where id = '$id'";
//$sq1 = mysqli_query($db_con, $sq0);
//$sq2 = mysqli_fetch_row($sq1);
//$texto = $sq2[2] . "<br>Grupos que participan: " . $sq2[3];
//mysqli_query($db_con, "UPDATE  cal SET  title =  '$sq2[1]', eventdate = '$sq2[0]', event = '$texto' WHERE idact = '$id'");

  echo '
<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			Los datos de la Actividad han sido modificados correctamente.
			</div></div>';
  }
else{
	
if($modificar == '1')
{
$datos1 = mysqli_query($db_con, "select * from actividades where id = '$id'");
$datos = mysqli_fetch_array($datos1);

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
<div class="col-sm-6">

<div class="well">
            
<FORM action="indexconsulta.php" method="POST" name="Cursos">
           
                <label>Fecha de la actividad:</label> 
            <div class="form-group" id="datetimepicker1">
            <div class="input-group">
              <input name="fecha_act" type="text" class="form-control" value="<? echo "$dia-$mes-$ano"; ?>" data-date-format="DD-MM-YYYY" id="fecha_act" >
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div> 
            </div>
              
                <div class="form-group"><label>Titulo: </label>
                <input name="actividad" type="text" id="actividad" value="<? echo $actividad; ?>" class="form-control">
                </div>

                <div class="form-group"><label>Departamento:  </label>
                <SELECT name="departamento" onChange="submit()"  class="form-control">
                    <OPTION><? echo $departamento;?></OPTION>

                    <?
if (!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'5') == TRUE)) {
	  // Datos del alumno que hace la consulta. No aparece el nombre del a&ntilde;o de la nota. Se podr&iacute;a incluir.
  $profe = mysqli_query($db_con, " SELECT distinct departamento FROM departamentos  where departamento = '". $_SESSION['dpt'] ."' order by departamento asc");
  if ($filaprofe = mysqli_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      echo "$opcion1";

	} while($filaprofe = mysqli_fetch_array($profe));
        }
}
else{
	?>
	    <OPTION>Actividades Extraescolares</OPTION>
        <OPTION>Relaciones de Género</OPTION>
		<OPTION>Religión</OPTION>
	<?
  // Datos del alumno que hace la consulta. No aparece el nombre del a&ntilde;o de la nota. Se podr&iacute;a incluir.
  $profe = mysqli_query($db_con, " SELECT distinct departamento FROM departamentos  where departamento not like '%Admin%' and departamento not like '%Conserjeria%' and departamento not like '%Administracion%' order by departamento asc");
  if ($filaprofe = mysqli_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      echo "$opcion1";

	} while($filaprofe = mysqli_fetch_array($profe));
        }		
	}

	?>
                  </select>
                </div>

                <div class="form-group"><label>Profesor: </label>
                <SELECT multiple name='profesor[]' class="form-control">
                    <?
					if($departamento == "Actividades Extraescolares"){
					echo "<OPTION selected>Mart&iacute;nez Mart&iacute;nez, M&ordf; Pilar</OPTION>";
					}
					elseif($departamento == "Relaciones de Género"){	
					$texto = " where departamento = '$departamento'";
					echo "<OPTION selected>Cabezas Sánchez, Esther</OPTION>";
					}
					else{$texto = " where departamento = '$departamento'";}

  $profe = mysqli_query($db_con, " SELECT distinct NOMBRE FROM departamentos " . $texto. " order by NOMBRE asc");
while($filaprofe = mysqli_fetch_array($profe))        {
if($departamento == "Religión")
{} 
else{
	      $opcion1 = printf ("<OPTION selected>$filaprofe[0]</OPTION>");
	      echo "$opcion1";}

        }
	?>
                  </select>
                  </div>
                  <p class="help-block" > (*) Para seleccionar varios profesores, mantén apretada la tecla Ctrl mientras los vas marcando con el ratón.</p> 
             
             <div class="form-group"><label>Justificacion: </label>
                <textarea name="justificacion" id="textarea" cols="35" rows="4" class="form-control"><? echo $justificacion; ?></textarea>
              </div>

            <div class="form-group"><label>Horario: </label>
                <input name="horario" type="text" value="<? echo $horario; ?>"  class="form-control">
              </div>  
              
                    <input type="hidden" name="hoy"  value="<? $hoy = date('Y\-m\-d'); echo $hoy;?>">
                <div class="form-group"><label>Descripci&oacute;n: </label>
                <textarea name="descripcion" id="textarea" rows='4' class="form-control"><? echo $descripcion; ?></textarea>
              </div>
              
</div>
</div>

<div class="col-sm-6">
<div class="well well-lg">          
<a href="javascript:seleccionar_todo()" class="btn btn-success">Marcar todos los Grupos</a>
<a href="javascript:deseleccionar_todo()" class="btn btn-warning pull-right">Desmarcarlos todos</a> <br />

              <br><h4>Grupos de alumnos que realizan la actividad</h4>
            
<?

$curso0 = "select distinct curso from alma order by curso";
$curso1 = mysqli_query($db_con, $curso0);
while($curso = mysqli_fetch_array($curso1))
{
$niv = $curso[0];
?>
           <? echo "<p class='text-info'> ".$niv." </p>"; ?>
                <?  
$alumnos0 = "select distinct unidad from alma where curso = '$niv' order by curso, unidad";

$alumnos1 = mysqli_query($db_con, $alumnos0);
while($alumno = mysqli_fetch_array($alumnos1))
{
$chk="";
$grupo = $alumno[0];
if(strstr($todosgrupos,$grupo)==TRUE){$chk=" checked ";}
?>

<div class="checkbox-inline"><label><input name="<? echo "grt".$grupo;?>" type="checkbox" id="A" value="<? echo $grupo;?>" <? echo $chk;?>>
                  <?
 echo "".$grupo."</label></div>";
                  
} ?>              
       <br />     
 <? } ?>
       
            <input name="id" type="hidden" value="<? echo $id;?>" />                                                                                                               
    <input name="fecha_origen" type="hidden" value="<? echo '$ano-$mes-$dia'; ?>" /> 
  </div>
  </div>
  
  </div>
<center>
      <INPUT type="submit" name="submit2" value="Actualizar datos de la  Actividad" class="btn btn-primary">
</center>
  </FORM>

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
