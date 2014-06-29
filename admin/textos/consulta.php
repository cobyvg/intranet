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

include 'menu.php';
?>
<br />
<div align="center">
<div class="page-header">
  <h2>Libros de Texto <small> Consulta de Textos</small></h2>
</div>
<div class="container">
<div class="row">
<div class="span6 offset3">
    <div class="well well-large" align="left" style="width:80%">
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
      <hr />
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
      <hr />
      <input type="submit" name="enviar2" value="Buscar Textos" size=15 maxlength=25 alt="Introducir" class="btn btn-primary btn-block">
            </form>
      
    </div>
  </form>
</div>
</div>
</div>
</div>
<?php
	include("../../pie.php");
?>
</BODY>
</HTML>
