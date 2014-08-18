<?
session_start();
include("../../config.php");
	if((!(stristr($_SESSION['cargo'],'1') == TRUE)) and (!(stristr($_SESSION['cargo'],'c') == TRUE)) )
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


?>
<?
include("../../menu.php");
include("menu.php");
?>

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
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Biblioteca del Centro <small> Ejemplares sin devolver</small></h2>
</div>
<br>

<div class="col-sm-4 col-sm-offset-4">

<legend align = 'center'>Consulta de los listados.</legend><br>
<FORM action="consulta.php" method="POST">
  <div class="well well-large">
  <div class="form-group">
 <label> Elige una fecha</label>
  <select name="fecha" class="form-control">
    <?
  $tipo = "select distinct hoy from morosos order by hoy desc";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<option>".$tipo2[0]."</option>";
        }				
					?>
  </select>
  </div>
  <button class="btn btn-primary btn-block" type="submit" name="submit1" value="Enviar datos">Enviar datos</button>
  </div>
</FORM>
</div>
</div>
</div>








