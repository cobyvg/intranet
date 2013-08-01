<?
session_start();
include("../../config.php");
	if((!(stristr($_SESSION['cargo'],'1') == TRUE)) and (!(stristr($_SESSION['cargo'],'c') == TRUE)) )
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?
include("../../menu.php");
?>
<div align=center>
<div class="page-header" align="center">
  <h2>Biblioteca <small> Ejemplares sin devolver</small></h2>
</div>
</div>
<?
$crea ="CREATE TABLE IF NOT EXISTS `morosos` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `curso` varchar(50) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `ejemplar` varchar(100) NOT NULL,
  `devolucion` varchar(10) NOT NULL,
  `hoy` date NOT NULL ,
  `amonestacion` varchar(2) NOT NULL DEFAULT 'NO',
  `sms` VARCHAR( 2 ) NOT NULL DEFAULT  'NO', 
  PRIMARY KEY (`id`)
) ";
mysql_query($crea);

?>
<div align="center">
<h3>Actualizaci&oacute;n de la lista de ejemplares sin devolver.</h3>
<FORM ENCTYPE="multipart/form-data" ACTION="morosos.php" METHOD="post" class="form-inline">
  <div  class="control-group success" style="width:500px;">
  <p class="help-block" style="text-align:center"><span style="color:#9d261d">(*) </span>Primero debes proceder a importar los datos de los morosos del archivo que has generado con Abies. Si ya has exportado el archivo de Abies en formato .txt, puedes continuar con el segundo paso (Consulta de los Listados).</p>
  </div>
  <div class="well well-large" style="width:450px; margin:auto;" align="center">
  <h5 align="center">Selecciona el archivo de Abies</h5>
  <hr>
  <input type="file" name="archivo">
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
  </div>
</FORM>
<br>
<div align="center">
<h3>Consulta de los listados.</h3>
</div>
<FORM action="consulta.php" method="POST" class="form-inline"">
  <div class="well well-large" style="width:450px; margin:auto;" align="center">
 <h5> Elige una fecha</h5>
 <hr>
  <select name="fecha" class="input-medium">
    <?
  $tipo = "select distinct hoy from morosos order by hoy desc";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<option>".$tipo2[0]."</option>";
        }				
					?>
  </select>
  <button class="btn btn-primary" type="submit" name="submit1" value="Enviar datos">Enviar datos</button>
  </div>
</FORM>
</div>









