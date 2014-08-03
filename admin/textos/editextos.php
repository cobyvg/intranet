<?
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['nivel'])) {$nivel = $_GET['nivel'];}elseif (isset($_POST['nivel'])) {$nivel = $_POST['nivel'];}else{$nivel="";}

if(isset($_POST['enviar']) or isset($_POST['insertar'])){
include("edtextos.php");
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

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


?>
<?php
include("../../menu.php");
include 'menu.php';
	
echo '<div align="center">';		
?>
<br />
<div class="page-header">
  <h2>Libros de Texto <small> Edición de libros</small></h2>
</div>
<?
echo "<h3>
			Modificar Datos de un Libro de Texto</h3><br />";
 

  $textos = mysql_query("SELECT Departamento, Asignatura, Autor, Titulo, Editorial, Notas, Id, isbn, nivel, grupo, Obligatorio FROM Textos where Id='$id'");
	$row = mysql_fetch_array($textos);
	$id = $row[6];
	$nivel = $row[8];
	$obliga = $row[10];
?>
<div class="well well-large" style="width:450px;" align="left">
  <p class="lead">Selecciona el Curso y los Grupos</p>
<hr>
  		<form method="post" action="editextos.php" 
  		echo $nivel;>
          <label>
  Nivel:
    <select name="nivel" id="select4" onChange="submit()" style="width:100%">
            <?
 echo "<option>$nivel</option>";
  $tipo = "select distinct curso from alma order by NIVEL";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
$completo = "$tipo2[0]";
if($completo == $nivel){}
else{
	echo "<option>$completo</option>";
		}
        }
?>
          </select>
          </label>
          <input type="hidden" name="id" value="<? echo $id; ?>" />
     </form>
     
  <form name="textos" method="post" action="editextos.php">
  <input type="hidden" name="id" value="<? echo $id; ?>" />
  <input type="hidden" name="nivel" value="<? echo $nivel; ?>" />      
  <label>Grupos:
      <?	
$tipo0 = "select distinct unidad from alma where curso = '$nivel' order by unidad";
$tipo10 = mysql_query($tipo0);
  while($tipo20 = mysql_fetch_array($tipo10))
        {	
$sql = mysql_query("select grupo from Textos where id = '$id'");

while ($sql_w = mysql_fetch_array($sql)) {	
	if (strstr($sql_w[0],$tipo20[0])==TRUE) {
		$extra = " checked";		
	}
}
echo "<span class='badge badge-info'>".$tipo20[0]."</span>&nbsp;";
echo "<input name='$tipo20[0]' type='checkbox' id='$tipo20[0]' value='$tipo20[0]' $extra >&nbsp;&nbsp;";
        }
						
	?>
    <br /><br /><br />
    <p class="lead">Datos del Libro de
      Texto</p>
    <hr>
    <label>T&iacute;tulo<br />
    <input name="titulo" type="text" id="titulo" size="45" value='<? echo $row[3];?>' style="width:97%">
  </label>
  
    <label>Autor<br />
    <input name="autor" type="text" id="autor" size="50" value='<? echo $row[2];?>' style="width:97%">
  </label>
  
    <label>Editorial<br />
    <input name="editorial" type="text" id="editorial" size="50" value="<? echo $row[4];?>" style="width:97%">
  </label>
  
    <label>Departamento<br />
    <select name="departamento" id="departamento"  value ="Todos ..." onChange="submit()" style="width:100%">
        <option><? if($departamento){echo $departamento;}else{echo $row[0];}?></option>
        <?
  $profe = mysql_query(" SELECT distinct departamento FROM departamentos order by departamento asc");
  while($filaprofe = mysql_fetch_array($profe))
	{
	if ($filaprofe[0] == "Lengua Castellana" or $filaprofe[0] == "Lengua Extranjera-Inglés (Secundaria)" or $filaprofe[0] == "Matemáticas")
	{}
	else {$departamen = $filaprofe[0];}
	      $opcion1 = printf ("<OPTION>$departamen</OPTION>");
	      echo "$opcion1";
	} 
	?>
      </select>
    </label>
  
  
    <label>Asignatura<br />
    <select name="asignatura" id="asignatura" style="width:100%">
        <option><? if($asignatura){echo $asignatura;}else{echo $row[1];}?></option>
        <option>
        <?
   // Datos de la Asignatura
   $asignatu = "SELECT DISTINCT asignaturas.NOMBRE, ABREV FROM asignaturas, departamentos, profesores where asignaturas.nombre=profesores.materia and profesores.profesor=departamentos.nombre and curso = '$nivel' ";
   if($departamento){$asignatu.="and departamento like '$departamento%'";}else{$asignatu.="and departamento like '$row[1]%'";}
   $asignatu.=" ORDER BY NOMBRE asc";
  $asignatur = mysql_query($asignatu); 
        while($fasignatur = mysql_fetch_array($asignatur)) {
		if(strlen($fasignatur[1]) > 3)	{ }
		else{ 
	      $opcion = printf ("<OPTION>$fasignatur[0]</OPTION>");
	      echo "$opcion"; }
	} 
	?>
        </option>
      </select>
  </label>
  
    <label>Tipo de Libro<br />
    <select name="clase" style="width:100%">
        <option>Texto</option>
        <option>Lectura</option>
      </select>
      <select name="obligatorio" style="width:100%">
              <option><? if($obliga){echo $obliga;}?></option>
      
        <option>Obligatorio</option>
        <option>Recomendado</option>
      </select>
  </label>
  
    <label>Observaciones<br />
    <textarea name="NOTAS" cols="50" rows="6" style="width:97%"><? echo $row[5];?></textarea>
  </label>
  
    <label>ISBN<br />
    <input name="isbn" type="text" id="isbn" size="50" value="<? echo $row[7];?>" style="width:97%">
  </label>
  
<center>
<input type="submit" name="enviar" value="Actualizar datos" size=15 maxlength=25 alt="Introducir" class="btn btn-warning" style="width:45%">
<input type="submit" name="insertar" value="Insertar como nuevo Libro" size=15 maxlength=25 alt="Introducir2"  class="btn btn-success" style="width:45%">
</center>
</form>
</div>
</div>
<?php
	include("../../pie.php");
?>
</body>
</html>
