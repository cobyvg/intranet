<?
if($enviar=="Introducir datos"){
include("intextos2.php");
exit;
}
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
?>
<br />
<div align="center">
<div class="page-header">
  <h2>Libros de Texto <small> Registro y Consultas</small></h2>
</div>
<div class="container-fluid">
<div class="row-fluid">
<div class="span5 offset1">	
<? if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'4') == TRUE)
{ ?>
<h3>Registro de Libros de Texto </h3>
<br />
<div class="well well-large" style="width:95%;" align="left">
  <legend>Selecciona el Curso y los Grupos</legend>
<hr>
    <form method="post" action="intextos.php" class="form-vertical">
  <label>
  Nivel:<br />
    <select name="nivel" id="select4" onChange="submit()" class="input-xxlarge">
      <?
 if($nivel)
        {echo "<option>$nivel</option>";}
		else{echo "<option></option>";}
  $tipo = "select distinct curso from alma order by curso";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
$completo = $tipo2[0];
echo "<option>$completo</option>";
}
?>
    </select>
    </label>
     </form>
     <form method="post" action="intextos.php" class="form-vertical">   
    <label>Grupos:
      <input name="año" type="hidden" value="<? 
// Cosas de la Fecha
$fecha = (date("Y"));
echo $fecha;
?>" size="4" maxlength="4">
      <?	
//$cur = explode(" --> ",$nivel);					
$tipo0 = "select distinct GRUPO from alma where curso = '$nivel' order by GRUPO";
$tipo10 = mysql_query($tipo0);
  while($tipo20 = mysql_fetch_array($tipo10))
        {	
echo "<span class='badge badge-info'>".$tipo20[0]."</span>&nbsp;";
echo "<input name='$tipo20[0]' type='checkbox' id='$tipo20[0]' value='$tipo20[0]' class='checkbox' checked>&nbsp;&nbsp;";
        }
						
	?>
    </label>
    <input name="nivel" type="hidden" value="<? echo $nivel;?>" size="4" maxlength="4">
    <br />
    <legend>Datos del Libro de
      Texto</legend>
    <hr>
    <label>T&iacute;tulo <span style="color:#9d261d"> (*)</span><br />
      <input name="titulo" type="text" id="titulo" class="input-xxlarge" value="<? echo $titulo; ?>">
    </label>
    <label>Autor<br />
      <input name="autor" type="text" id="autor" class="input-xxlarge" value="<? echo $autor; ?>">
    </label>
    <label>Editorial<span style="color:#9d261d"> (*)</span><br />
      <input name="editorial" type="text" id="editorial" class="input-xxlarge" value="<? echo $editorial; ?>">
    </label>
    <label>Departamento<span style="color:#9d261d"> (*)</span><br />
      <select name="departamento" id="departamento"  value =" value="<? echo $departamento; ?>"" onChange="submit()"  class="input-xxlarge">
        <option>
        <?  echo $departamento;?>
        </option>
        <?
  $profe = mysql_query(" SELECT distinct departamento FROM departamentos, profesores where departamento not like 'admin' and departamento not like 'Administracion' and departamento not like 'Conserjeria' order by departamento asc");
  while($filaprofe = mysql_fetch_array($profe))
	{
	if ($filaprofe[0] == "Lengua Castellana" or $filaprofe[0] == "Lengua Extranjera-Inglés (Secundaria)" or $filaprofe[0] == "Matemáticas")
	{}
	else
	{
	$departamen = $filaprofe[0]; 
	$opcion1 = printf ("<OPTION>$departamen</OPTION>");
	echo "$opcion1";
	}
	} 
	?>
      </select>
    </label>
    <label>Asignatura <span style="color:#9d261d"> (*)</span><br />
      <select name="asignatura" id="asignatura" class="input-xlarge"  value="<? echo $asignatura; ?>">
        <option>
        <?
   // Datos de la Asignatura
  $asignatur = mysql_query("SELECT DISTINCT asignaturas.NOMBRE, ABREV FROM asignaturas, departamentos, profesores where asignaturas.nombre=profesores.materia and profesores.profesor=departamentos.nombre and curso = '$nivel' and departamento like '$departamento%' ORDER BY NOMBRE asc"); 
        while($fasignatur = mysql_fetch_array($asignatur)) {
		if(strstr($fasignatur[1],"_"))	{ }

		else{ 
	      echo"<OPTION>$fasignatur[0]</OPTION>";
	     }
	} 
	?>
        </option>
      </select>
    </label>
    <label>Tipo de Libro<br />
      <select name="clase" class="input-small">
        <option>Texto</option>
        <option>Lectura</option>
      </select>
      <select name="obligatorio" class="input-large" >
        <option>Obligatorio</option>
        <option>Recomendado</option>
      </select>
    </label>
    <label>ISBN<span style="color:#9d261d"> (*)</span><br />
      <input name="isbn" type="text" id="isbn" class="input-xlarge" value="<? echo $isbn; ?>">
    </label>
    <label>Observaciones<br />
      <textarea name="NOTAS" class="input-xxlarge" rows="6"> <? echo $NOTAS; ?></textarea>
    </label>
    <p class="help-block"><span style="color:#9d261d">(*)</span> Campos obligatorios del formulario.</p>
    <br />
    <input type="submit" name="enviar" value="Introducir datos" size=15 maxlength=25 alt="Introducir" class="btn btn-primary btn-large">
  </form>
  </div>
  <?
}
?>
</div>
<div class="span5">	
  <form name="textos" method="post" action="textos.php">
    <h3>Consulta de Textos por Departamento. </h3>
    <br />
    <div class="well well-large" style="width:95%;" align="left">
      <label>Nivel<br />
        <select name="nivel" id="select6" class="input-xxlarge">
          <?
  $tipo = "select distinct curso from alma order by curso";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
$completo = $tipo2[0];
echo "<option>$completo</option>";
} ?>
        </select>
      </label>
      <label>Departamento:<br />
        <select name="departamento" id="select7"  value ="Todos ..." onChange="submit()" class="input-xxlarge">
          <option></option>
          <?
  $profe = mysql_query(" SELECT distinct departamento FROM departamentos order by departamento asc");
  while($filaprofe = mysql_fetch_array($profe))
	{
	if ($filaprofe[0] == "Lengua Castellana" or $filaprofe[0] == "Lengua Extranjera-Inglés (Secundaria)" or $filaprofe[0] == "Matemáticas")
	{}
	else
	{
	$departamen = $filaprofe[0]; }
	$opcion1 = printf ("<OPTION>$departamen</OPTION>");
	echo "$opcion1";
	} 
	?>
        </select>
      </label>
      <input type="submit" name="enviar2" value="Buscar Textos" size=15 maxlength=25 alt="Introducir" class="btn btn-primary btn-large">
    </div>
  </form>
</div>
<?php
	include("../../pie.php");
?>
</BODY>
</HTML>
