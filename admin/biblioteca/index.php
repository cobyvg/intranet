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

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
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
  <h2>Biblioteca del Centro <small> Consultas en los Fondos de la Biblioteca</small></h2>
</div>
<br>

<div class='well well-large col-sm-6 col-sm-offset-3'>  

  <form action="biblioteca.php" method="post" name="libros" id="libros" >
  <div class="form-group">
        <label class="control-label" for="autor">Autor</label>
        <div class="controls">
                  <input type="text" name="autor" id="autor" class="form-control" /> 
                  </div> 
        <br /><label class="control-label" for="titulo0">T&iacute;tulo </label>
        <div class="controls">
                 <input type="text" name="titulo0" id="titulo0" class="form-control" /> 
                 </div>      
        <br /><label class="control-label" for="editorial">Editorial</label>
        <div class="controls">
                  <input type="text" name="editorial" id="editorial" class="form-control" />
                  </div>
                  <br>
  <input type="submit" name="enviar" value="Buscar Libros" class="btn btn-block btn-primary" />   
  <br>
    <p class="help-block">
    La Biblioteca del Centro ha registrado más de 10.000 volúmenes en el Fondo general, y el trabajo continúa. En estas páginas puedes buscar textos u otros materiales en nuestra base de datos.<br>
    La consulta de materiales en el Fondo es abierta, por lo que no es necesario escribir autor, título o editorial <em>exactos</em>. Si, por ejemplo, introduzco la expresión
  "Cer" en el campo "Autor", la consulta me devolverá libros de "<b>Cer</b>nuda" y de "<b>Cer</b>vantes".
   </p>
  </form>
  </div>
  </div>
</div>
  </div>
<? include("../../pie.php");?>