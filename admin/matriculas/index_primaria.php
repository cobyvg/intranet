<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$profe = $_SESSION['profi'];
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
<div align="center">
<div class="page-header" align="center">
  <h2>Matriculación de Alumnos <small> Importar Alumnos de Primaria</small></h2>
</div>
<br />
<FORM ENCTYPE="multipart/form-data" ACTION="../../xml/jefe/alma_primaria.php" METHOD="post">
  <div class="control-group success">
    <p class="help-block" style="width:800px; text-align:justify;"><span style="color:#9d261d">(*) </span>El m&oacute;dulo de Matriculaci&oacute;n permite importar los datos de los alumnos de Colegios adscritos al IES, facilitando enormemente la tarea al tomar los datos de las criaturas de la base de datos. Para contar con los datos de los Colegios, los Directores de los mismos deben proporcionar el archivo de S&eacute;neca RegAlum.txt (lo descargamos desde S&eacute;neca: Alumnado --&gt; Alumnado del Centro --&gt; Aceptar (arriba a la derecha) --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano). Una vez en nuestras manos, le cambiamos el nombre por el del Colegio respectivo, y comprimimos todos los archivos en formato .zip. Este es el archivo que debes seleccionar en el formulario.<br /><em><strong>Hay que tener en cuenta que el módulo de importación supone que el formato de las grupos de los Colegios es semejante al de los Institutos</strong></em>, por lo que se espera que el nombre sea del tipo <strong>6P-A</strong>, <strong>6P-B</strong>, etc. Si el Colegio no sigue ese criterio, es necesario editar los archivos de Séneca y buscar / reemplazar el nombre de las Unidades para ajustarlo a los criterios de la Intranet antes de proceder a la importación. También se les puede pedir a los Colegios que normalicen el nombre de los grupos a largo plazo con el nuevo sistema de nombres, considerando los beneficios que derivan del proceso de matriculación de la Intranet.</p></div><br />
  <div class="well well-large" style="width:500px; margin:auto;" align="left">
  <p class="lead">Selecciona el archivo con los datos<br />
  </p>
  <input type="file" name="archivo1" class="input input-file span4">
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
</FORM>
<br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>
</div>
<? include("../../pie.php");

