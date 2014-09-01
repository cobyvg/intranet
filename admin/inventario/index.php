<?
if(stristr($_SESSION['cargo'],'4') == TRUE)
{
	include("introducir.php");
}
else{
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


	if(!(stristr($_SESSION['cargo'],'1') == TRUE))
	{
		header("location:http://$dominio/intranet/salir.php");
		exit;
	}
	?>
	<?php
	include("../../menu.php");
	include("menu.php");
	?>
<div class="container">
<div class="page-header">
<h2>Material del Centro <small> Selección de Departamento</small></h2>
</div>
<div class="row">
<div class="col-sm-4 col-sm-offset-4"><br />
<div class="well well-lg" align="center"><br />
<form name="textos" method="post" action="introducir.php"><select
	name="departamento" id="departamento" class="form-control"
	value="Todos ...">
	<option></option>
	<?
	$profe = mysql_query(" SELECT distinct departamento FROM departamentos, profesores where departamento not like 'admin' and departamento not like 'Administracion' and departamento not like 'Conserjeria' order by departamento asc");
	while($filaprofe = mysql_fetch_array($profe))
	{
		$departamen = $filaprofe[0];
		$opcion1 = printf ("<OPTION>$departamen</OPTION>");
		echo "$opcion1";
	}
	?>
	<option>-------------------------------</option>
	<option>Plan de Autoprotección</option>
	<option>Plan de Biblioteca</option>
	<option>Plan Espacio de Paz</option>
	<option>Plan de Deporte en la Escuela</option>
	<option>Centro TIC</option>
</select> <br />
<button type="submit" name="enviar2" value="Enviar"
	class="btn btn-primary btn-block"><i class="fa fa-search "> </i> Enviar
</button>
</form>
</div>
</div>
</div>
</div>
	<?
}
include("../../pie.php");
?>
</body>
</html>