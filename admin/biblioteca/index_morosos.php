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
include("menu.php");
?>
<div align=center>
<div class="page-header" align="center">
  <h2>Morosos de la Biblioteca <small> Ejemplares sin devolver</small></h2>
</div>
</div>
<?
$crea ="CREATE TABLE IF NOT EXISTS `morosos` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `curso` varchar(64) NOT NULL,
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
<br />
<div class="container-fluid">
<div class="row-fluid">


<div class="span4 offset4">
<legend align = 'center'>Consulta de los listados.</legend>
<FORM action="consulta.php" method="POST" class="form-inline"">
  <div class="well well-large" align="center">
 <p class='lead text-info'> Elige una fecha</p>
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
</div>
</div>








