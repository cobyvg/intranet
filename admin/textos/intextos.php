<?
if(isset($_POST['enviar']) and $_POST['enviar']=="Introducir datos"){
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
if (stristr ( $_SESSION ['cargo'], '4' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE) { } else { $j_s = '1'; }
?>
<?php
include("../../menu.php");
if (isset($_GET['titulo'])) {$titulo = $_GET['titulo'];}elseif (isset($_POST['titulo'])) {$titulo = $_POST['titulo'];}else{$titulo="";}
if (isset($_GET['asignatura'])) {$asignatura = $_GET['asignatura'];}elseif (isset($_POST['asignatura'])) {$asignatura = $_POST['asignatura'];}else{$asignatura="";}

if(stristr($_SESSION['cargo'],'4') == TRUE or stristr($_SESSION['cargo'],'1') == FALSE)
    {
    	$departamento = $_SESSION['dpt'];
    }
    else{	
		if (isset($_GET['departamento'])) {$departamento = $_GET['departamento'];}
		elseif (isset($_POST['departamento'])) {$departamento = $_POST['departamento'];}
		else{$departamento="";}
    }    
  
if (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];}elseif (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];}else{$grupo="";}
if (isset($_GET['editorial'])) {$editorial = $_GET['editorial'];}elseif (isset($_POST['editorial'])) {$editorial = $_POST['editorial'];}else{$editorial="";}
if (isset($_GET['isbn'])) {$isbn = $_GET['isbn'];}elseif (isset($_POST['isbn'])) {$isbn = $_POST['isbn'];}else{$isbn="";}
if (isset($_GET['ano'])) {$ano = $_GET['ano'];}elseif (isset($_POST['ano'])) {$ano = $_POST['ano'];}else{$ano="";}
if (isset($_GET['autor'])) {$autor = $_GET['autor'];}elseif (isset($_POST['autor'])) {$autor = $_POST['autor'];}else{$autor="";}
if (isset($_GET['NOTAS'])) {$NOTAS = $_GET['NOTAS'];}elseif (isset($_POST['NOTAS'])) {$NOTAS = $_POST['NOTAS'];}else{$NOTAS="";}
if (isset($_GET['obligatorio'])) {$obligatorio = $_GET['obligatorio'];}elseif (isset($_POST['obligatorio'])) {$obligatorio = $_POST['obligatorio'];}else{$obligatorio="";}
if (isset($_GET['clase'])) {$clase = $_GET['clase'];}elseif (isset($_POST['clase'])) {$clase = $_POST['clase'];}else{$clase="";}
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['nivel'])) {$nivel = $_GET['nivel'];}elseif (isset($_POST['nivel'])) {$nivel = $_POST['nivel'];}else{$nivel="";}

?>
<br />
<div align="center">
<div class="page-header">
  <h2>Libros de Texto <small> Registro y Consultas</small></h2>
</div>
<div class="container-fluid">
<div class="row-fluid">
<? 
if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'4') == TRUE)
{ ?>
<div class="span5 offset1">	
<legend>Registro de Libros de Texto </legend>
<div class="well well-large" style="width:95%;" align="left">
  <legend>Selecciona el Curso y los Grupos</legend>
<hr>
    <form method="post" action="intextos.php" class="form-vertical">
  <label>
  Nivel:<br />
    <select name="nivel" id="select4" onChange="submit()" class="input-block-level">
      <?
 if(isset($_POST['nivel']))
        {
        $nivel = $_POST['nivel'];
        echo "<option>$nivel</option>";}
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
      <input name="ano" type="hidden" value="<? 
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
    <label>T&iacute;tulo <span style="color:#9d261d"> (*)</span></label>
      <input name="titulo" type="text" id="titulo" class="input-block-level" value="<? echo $titulo; ?>" required>
    
    <label>Autor</label>
      <input name="autor" type="text" id="autor" class="input-block-level" value="<? echo $autor; ?>">
    
    <label>Editorial<span style="color:#9d261d"> (*)</span></label>
      <input name="editorial" type="text" id="editorial" class="input-block-level" value="<? echo $editorial; ?>" required>
    
    <label>Departamento<span style="color:#9d261d"> (*)</span></label>
    <?
    if(stristr($_SESSION['cargo'],'4') == TRUE and stristr($_SESSION['cargo'],'1') == FALSE)
    {
    ?>
        <input type="text" name="departamento" id="departamento"  value ="<? echo  $departamento;?>" readonly class="input-xxlarge">
    
    <?	
    }
    else{
    ?>
    <select name="departamento" id="departamento"  value =" value="<? echo $departamento; ?>"" onChange="submit()"  class="input-block-level">
        <option>
        <?  echo $departamento;?>
        </option>
        <?
  $profe = mysql_query(" SELECT distinct departamento FROM departamentos, profesores where departamento not like 'admin' and departamento not like 'Administracion' and departamento not like 'Conserjeria' order by departamento asc");
  while($filaprofe = mysql_fetch_array($profe))
	{

	$departamen = $filaprofe[0]; 
	$opcion1 = printf ("<OPTION>$departamen</OPTION>");
	echo "$opcion1";
	} 
	?>
      </select>
      <? } ?>
    </label>
    <label>Asignatura <span style="color:#9d261d"> (*)</span><br />
      <select name="asignatura" id="asignatura" class="input-block-level"  value="<? echo $asignatura; ?>" required>
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
      <input name="isbn" type="text" id="isbn" class="input-block-level" value="<? echo $isbn; ?>" required>
    </label>
    <label>Observaciones<br />
      <textarea name="NOTAS" class="input-block-level" rows="6"> <? echo $NOTAS; ?></textarea>
    </label>
    <p class="help-block"><span style="color:#9d261d">(*)</span> Campos obligatorios del formulario.</p>
    <br />
    <input type="submit" name="enviar" value="Introducir datos" size=15 maxlength=25 alt="Introducir" class="btn btn-primary btn-block">
  </form>
  </div>
  </div>
  <?
}
if ($j_s == '1') {
	echo '<div class="span4 offset4">';
}
else{
	echo '<div class="span5">';
}
?>
    <legend>Consulta de Textos por Departamento. </legend>
    <div class="well well-large" align="left">
      <form name="intextos" method="post" action="textos.php">
      <label>Nivel<br />
        <select name="nivel" id="select6" class="input-block-level">
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
        <select name="departamento" id="select7"  value ="Todos ..." onChange="submit()" class="input-block-level">
          <option></option>
          <?
  $profe = mysql_query(" SELECT distinct departamento FROM departamentos order by departamento asc");
  while($filaprofe = mysql_fetch_array($profe))
	{
	$departamen = $filaprofe[0]; 
	$opcion1 = printf ("<OPTION>$departamen</OPTION>");
	echo "$opcion1";
	} 
	?>
        </select>
      </label>
      <input type="submit" name="enviar2" value="Buscar Textos" size=15 maxlength=25 alt="Introducir" class="btn btn-primary btn-block">
    </div>
  </form>
</div>
<?php
	include("../../pie.php");
?>
</BODY>
</HTML>
