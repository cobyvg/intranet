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


if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'c') == TRUE){}
else
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
?>
<?php
include("../../menu.php");
include("menu.php");
?>
<br />
<div class="container">
<div class="row">
<div class="page-header">
<h2>Biblioteca del centro <small> Importación de datos desde Abies</small></h2>
</div>

<div class="tabbable" style="margin-bottom: 18px;">
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab1" data-toggle="tab">Importación del
	Catálogo de Fondos</a></li>
	<li><a href="#tab2" data-toggle="tab">Importación de Lectores</a></li>
	<li><a href="#tab3" data-toggle="tab">Importación de alumnos con
	préstamos</a></li>
</ul>
<div class='col-sm-6 col-sm-offset-3'>

<div class="tab-content">
<div class="tab-pane fade in active" id="tab1"><br>
<div class="well well-lg">
<legend>Catálogo de Fondos</legend><hr>
<form enctype="multipart/form-data" action="importa_biblio.php"
	method="post">
<div class="form-group"><input type="file" id="file" name="archivo1"></div>
<input class='btn btn-primary btn-block' type="submit" name="enviar1"
	value="Aceptar" /> 
	<br>
<p class="help-block">La importación de los Fondos de la Biblioteca
permite consultar en la Intranet, pero también en la página pública del
Centro, los fondos de la Biblioteca del Centro. El archivo que se
solicita es el informe del <b>Catálogo</b> que genera el programa Abies
siguiendo los siguientes pasos:
<ul class="help-block">
	<li>En Abies vamos a Catalogo-Informes y una vez en el asistente de
	creación de informes pulsamos Siguiente.</li>
	<li>Seleccionamos de la lista de campos disponibles los siguientes:
	Autor, Titulo, Editorial, ISBN, TipoFondo, anoEdicion, extension,
	serie, lugaredicion, tipoEjemplar, Ubicacion. Pulsamos Siguiente.</li>
	<li>En la siguiente pantalla elegimos "Archivo de Texto (campos
	delimitados) dejando el punto y coma como delimitador. Siguiente.</li>
	<li>Esta pantalla podemos dejarla como está y pulsamos Siguiente.</li>
	<li>Finalizamos guardando el documento generado en formato .txt.</li>
</ul>
</p>
</form>


<hr />
</div>
</div>
<div class="tab-pane fade in" id="tab2"><br>
<div class="well well-lg">
<legend>Lectores de la Biblioteca</legend><hr>
<form enctype="multipart/form-data" action="importa_biblio.php"
	method="post">
<div class="form-group"><input type="file" id="file" name="archivo2"></div>
<input class='btn btn-primary btn-block' type="submit" name="enviar2"
	value="Aceptar" /> <br>
<p class="help-block">La importación de los Lectores permite incorporar
el codigo del alumno en su Carnet, de tal modo que se pueda utilizar el
Carnet también en la Biblioteca del Centro. El archivo que se solicita
es el informe de <b>Lectores</b> que genera el programa Abies siguiendo
los siguientes pasos:


<ul class="help-block">
	<li>En Abies vamos a Lectores-Informes y una vez en el asistente de
	creación de informes pulsamos Siguiente.</li>
	<li>Seleccionamos de la lista de campos disponibles los siguientes:
	Código, DNI, Apellidos, Nombre, Grupo. Pulsamos Siguiente.</li>
	<li>En la siguiente pantalla elegimos "Archivo de Texto (campos
	delimitados) dejando el punto y coma como delimitador. Siguiente.</li>
	<li>Esta pantalla podemos dejarla como está y pulsamos Siguiente.</li>
	<li>Finalizamos guardando el documento generado en formato .txt.</li>
</ul>
Es importante tener en cuenta que al importar los <b>Lectores de la
Biblioteca</b> a la Base de datos, <em><b>el Carnet del Alumno
incorporará el Código de la Biblioteca tras el NIE</b></em>. De este
modo, se genera un Carnet que es válido también para su suo en la
Biblioteca del Centro.
</p>
</form>
</div>
</div>
<div class="tab-pane fade in" id="tab3"><br>
<div class="well well-lg">
<legend>Préstamos de Ejemplares</legend><hr>
<FORM ENCTYPE="multipart/form-data" ACTION="morosos.php" METHOD="post">
<div class="form-group"><input type="file" id="file" name="archivo"></div>

<INPUT type="submit" name="enviar" value="Aceptar"
	class="btn btn-primary btn-block"> <br />
<p class="help-block">La importación de los Préstamos de ejemplares
permite gestionar las Devoluciones de los libros como asuntos de
Disciplina (considerar elretraso en la devolución como falta grave,
enviar SMS de advertencia, etc.) en <em>Gestón de Préstamos</em>.El
archivo que se solicita es el informe de <b>Préstamos</b> que genera el
programa Abies siguiendo los siguientes pasos:


<ul class="help-block">
	<li>En Abies vamos a Préstamos-Informes y una vez en el asistente de
	creación de informes pulsamos Siguiente.</li>
	<li>Seleccionamos de la lista de campos disponibles los siguientes:
	Curso, Apellidos, Nombre, Título, Devolución. Pulsamos Siguiente.</li>
	<li>En la siguiente pantalla elegimos "Archivo de Texto (campos
	delimitados) dejando el punto y coma como delimitador. Siguiente.</li>
	<li>Esta pantalla podemos dejarla como está y pulsamos Siguiente.</li>
	<li>Finalizamos guardando el documento generado en formato .txt.</li>
</ul>
</p>
</FORM>
</div>

</div>
</div>
</div>
</div>
</div>

<?php include('../../pie.php');?>