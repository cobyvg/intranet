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


if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
        
<?php
include("../../menu.php");
?>
<br />
<div align="center">
<div class="page-header">
  <h2>Administraci&oacute;n <small> Depuraci&oacute;n y limpieza de las tablas de Horarios</small></h2>
</div>
<br />
<div class="text-center" id="t_larga_barra">
	<span class="lead"><span class="fa fa-circle-o-notch fa-spin"></span> Cargando...</span>
</div>
<div id='t_larga' style='display:none' >

<div class="well well-large" style="width:700px;margin:auto;text-align:left">
<?

// Limpiamos Tabla de Horarios de grupos que no da el profesor
echo "<p class='lead text-important' style='text-align:left'>Profesores y Asignaturas de<strong> Horw </strong>que no aparecen en S&eacute;neca.</p>";

$hor0 = "select id, prof, a_grupo, asig from horw where a_grupo in (select nomunidad from unidades) and asig not like 'OPTATIVA EXENTOS'";
$hor1 = mysql_query($hor0);
echo "<ul>";
while($hor = mysql_fetch_array($hor1))
{
$id = $hor[0];
$profesor = $hor[1];
$grupo = $hor[2];
$materia = $hor[3];

$prof0 = "select * from profesores where profesor = '$profesor' and grupo = '$grupo'";
$prof1 = mysql_query($prof0);
if(mysql_num_rows($prof1) < 1)
{
echo "<li>Borrado: $profesor => $materia  => $grupo</li>";
mysql_query("delete from horw where id = '$id'");
}
}

echo "</ul>";
mysql_query("OPTIMIZE TABLE `horw`");  

// creamos Horw para las Faltas
$base0 = "DROP TABLE horw_faltas";
mysql_query($base0);
mysql_query("create table horw_faltas select * from horw where (a_asig not like '%TTA%' and a_asig not like '%TPESO%')");
//Elimina las horas no lectivas
  $nolectiva = "UPDATE  horw_faltas SET  nivel =  '', a_grupo = '', n_grupo = '' WHERE  a_grupo NOT LIKE '1%' and a_grupo NOT LIKE '2%' and a_grupo NOT LIKE '3%' and a_grupo NOT LIKE '4%' and a_asig not like 'TUT%'";
  mysql_query($nolectiva);
  mysql_query("ALTER TABLE  ".$db."horw_faltas ADD INDEX (`prof`)");
  mysql_query("ALTER TABLE  ".$db."horw_faltas ADD index (`c_asig`)");
  mysql_query("delete from horw_faltas where a_grupo='' or a_grupo is null");
  mysql_query("OPTIMIZE TABLE  `horw_faltas`");  
  
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Tablas de Horarios</strong>: los datos se han modificado correctamente.
</div></div><br />';

?>
<div align="center">
<input type="button" value="Volver atr&aacute;s" name="boton" onclick="history.back(2)" class="btn btn-inverse" />
</div>
</div>
</div>
 <? include("../../pie.php");?>
  <script>
function espera( ) {
        document.getElementById("t_larga").style.display = '';
        document.getElementById("t_larga_barra").style.display = 'none';        
}
window.onload = espera;
</script>  
</body>
</html>
