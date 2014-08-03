<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


if(!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'4') == TRUE) and !(stristr($_SESSION['cargo'],'5') == TRUE) and !(stristr($_SESSION['cargo'],'8') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}  
?>
<?php
 include("../../menu.php");
 include("menu.php");
?>
<div align="center">
<div class="page-header">
  <h2>Actividades Complementarias y Extraescolares <small> Registro de actividades</small></h2>
</div>
</div>
<?
if(isset($_POST['submit1'])){
include("inserta.php");
}
 
else{
?>

  <div class="row">
<div class="col-sm-1"></div>
<div class="col-sm-5">
<div class="well">
  <FORM action="index.php" method="POST" name="Cursos">
           
                <center><label>Fecha de la actividad:<br /> 
                      <div class="input-group" >
            <input name="fecha_act" type="text" class="input input-medium" value="<? echo $fecha_act; ?>" data-date-format="dd-mm-yyyy" id="fecha_act" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 
              </label></center>
              <hr>
                <label>Titulo: <br />
                <input name="actividad" type="text" id="actividad" value="<? echo $actividad; ?>" class="col-sm-10">
                </label>
               <hr>
                <label>Departamento:  <br />
                <SELECT name="departamento" onChange="submit()" class="col-sm-10">
                    <OPTION><? echo $departamento; ?></OPTION>

                    <?
$dept_pes = str_ireplace(" P.E.S.","",$_SESSION['dpt']);                    
if (!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'5') == TRUE)) {
	  // Datos del alumno que hace la consulta. No aparece el nombre del a&ntilde;o de la nota. Se podr&iacute;a incluir.
  $profe = mysql_query(" SELECT distinct departamento FROM departamentos  where departamento like '". $dept_pes ."%' order by departamento asc");
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
	    <OPTION>Múltiples Departamentos</OPTION>
	    <OPTION>Actividades Extraescolares</OPTION>
        <OPTION>Relaciones de Género</OPTION>
	<?
  // Datos del alumno que hace la consulta. No aparece el nombre del a&ntilde;o de la nota. Se podr&iacute;a incluir.
 $profe = mysql_query(" SELECT distinct departamento FROM departamentos  where nombre not like 'admin' and departamento not like '%Conserjeria%' and departamento not like '%Administracion%' order by departamento asc");
 if ($filaprofe = mysql_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	     // echo "$opcion1";

	} while($filaprofe = mysql_fetch_array($profe));
        }		
	}

	?>
                  </select>
                </label>
               <hr>
                <label>Profesor: <br />
                <SELECT multiple name='profesor[]' class="col-sm-10" style="height:150px;">
                    <?
                    if($_POST['departamento'] == "Actividades Extraescolares" or $_POST['departamento'] == "Relaciones de Género"){
                    if($_POST['departamento'] == "Actividades Extraescolares"){
						$acti = mysql_query("select nombre from departamentos where cargo like '%5%'");
						while ($activ = mysql_fetch_array($acti)) {
							echo "<OPTION>$activ[0]</OPTION>";
						}
					}
					elseif($_POST['departamento'] == "Relaciones de Género"){
						$rg = mysql_query("select nombre from departamentos where cargo like '%d%'");
						while ($rgen = mysql_fetch_array($rg)) {
							echo "<OPTION>$rgen[0]</OPTION>";
						}
					}
					$texto = "and departamento = ''";
                    }
                    elseif ($_POST['departamento']=="Múltiples Departamentos")
                    {
                    	$texto = "";
                    }
					else{
						$dept_texto = str_ireplace(" P.E.S.","",$departamento);                    
						$texto = "and departamento like '$dept_texto%'";
					}
$profe = mysql_query("SELECT distinct NOMBRE FROM departamentos where nombre not like 'admin' and departamento not like '%Conserjeria%' and departamento not like '%Administracion%'" . $texto. " and departamento not like '' order by NOMBRE asc");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {
if($departamento == "Religión")
{} else{
	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      //echo "$opcion1";
}

	} while($filaprofe = mysql_fetch_array($profe));
        }
	?>
                  </select>
                  </label>
                  <p class="help-block" > (*) Para seleccionar varios profesores, mantén apretada la tecla Ctrl mientras los vas marcando con el ratón.</p> <hr>
                    <input type="hidden" name="hoy"  value="<? $hoy = date('Y\-m\-d'); echo $hoy;?>">
                <label>Descripci&oacute;n: <br />
                <textarea name="descripcion" id="textarea" rows="4" class="col-sm-10"><? echo $descripcion; ?></textarea>
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
           <? echo "<strong style='margin-right:12px;'> ".$niv." </strong>"; ?>
                <?  
$alumnos0 = "select distinct unidad from alma where curso = '$niv'";
//echo $alumnos0;
$alumnos1 = mysql_query($alumnos0);
while($alumno = mysql_fetch_array($alumnos1))
{
$grupo = $alumno[0];
?>
                  <? echo "<span style='margin-right:2px;color:#08c;'>".$grupo."</span>";?>
                  <input name="<? echo "grt".$grupo;?>" type="checkbox" id="A" value="<? echo $grupo;?>"  style="margin-right:5px;margin-top:0px;margin-bottom:2px;">
                  <? } ?>              
 <? } ?>
    <br /><br />
                <label>Justificación: <br />
                <textarea name="justificacion" id="textarea" cols="35" rows="4" class="col-sm-10"><? echo $justificacion; ?></textarea>
              </label>
			   <br />
            <label>Horario: <br />
                <input name="horario" type="text" value="<? echo $horario; ?>" size="30" maxlength="64" class="col-sm-10">
              </label>        
            <input name="id" type="hidden" value="<? echo $id; ?>">
            
       
  </div>
  </div>
  </div>
  </div>
  </div>
  <br />
  <div align="center">
       <? 
		  if($modificar == '1'){?>
            <INPUT type="submit" name="submit2" value="Actualizar datos de la  Actividad" class="btn btn-primary">
  <? }
else{?>
  <? }
  if ((date('m')>4 and date('m')<5)) {
  	if ( stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'5') == TRUE ) {
  	echo '  <INPUT  type="submit" name="submit1" value="Registrar la Actividad" class="btn btn-primary btn-large" >';
  	}
  }
  else{
  	echo '  <INPUT  type="submit" name="submit1" value="Registrar la Actividad" class="btn btn-primary btn-large" >';
  }
  
 
  ?>


  </FORM>
  <br /><br />
  <!-- Información Autobuses de Estepona
  <div class="well well-large" style="width:500px;text-align:left;">
  <div style="font-weight:bold; color:#08c;">Información sobre Transporte en las Actividades.</div>
  <p>Autobusus Ricardo<br /> 952 80 86 45 (Oficina);<br /> 671 527 372 (Móvil de contacto para confirmación);<br /> 649 45 70 99 (Móvil de Antonio -Dueño de la Empresa- Sólo en caso de emergencia).</p>
  </div>
  </div>
  -->
  
 
<? } ?>
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
<? include("../../pie.php");?>
	<script>  
	$(function ()  
	{ 
		$('#fecha_act').datepicker()
		.on('changeDate', function(ev){
			$('#fecha_act').datepicker('hide');
		});
		});  
	</script>
  </BODY>
</HTML>
