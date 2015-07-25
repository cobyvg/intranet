<?
require('../../bootstrap.php');


if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header('Location:'.'http://'.$dominio.'/intranet/salir.php');
exit;	
}


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
$hor1 = mysqli_query($db_con, $hor0);
echo "<ul>";
while($hor = mysqli_fetch_array($hor1))
{
$id = $hor[0];
$profesor = $hor[1];
$grupo = $hor[2];
$materia = $hor[3];

$prof0 = "select * from profesores where profesor = '$profesor' and grupo = '$grupo'";
$prof1 = mysqli_query($db_con, $prof0);
if(mysqli_num_rows($prof1) < 1)
{
echo "<li>Borrado: $profesor => $materia  => $grupo</li>";
mysqli_query($db_con, "delete from horw where id = '$id'");
}
}

echo "</ul>";
mysqli_query($db_con, "OPTIMIZE TABLE `horw`");  

// creamos Horw para las Faltas
$base0 = "DROP TABLE horw_faltas";
mysqli_query($db_con, $base0);
mysqli_query($db_con, "create table horw_faltas select * from horw where (a_asig not like '%TTA%' and a_asig not like '%TPESO%')");
//Elimina las horas no lectivas
  $nolectiva = "UPDATE  horw_faltas SET a_grupo = '' WHERE  a_grupo NOT LIKE '1%' and a_grupo NOT LIKE '2%' and a_grupo NOT LIKE '3%' and a_grupo NOT LIKE '4%' and a_asig not like 'TUT%'";
  mysqli_query($db_con, $nolectiva);
  mysqli_query($db_con, "ALTER TABLE  ".$db."horw_faltas ADD INDEX (`prof`)");
  mysqli_query($db_con, "ALTER TABLE  ".$db."horw_faltas ADD index (`c_asig`)");
  mysqli_query($db_con, "delete from horw_faltas where a_grupo='' or a_grupo is null");
  mysqli_query($db_con, "OPTIMIZE TABLE  `horw_faltas`");  
  
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
 <?php include("../../pie.php");?>
  <script>
function espera( ) {
        document.getElementById("t_larga").style.display = '';
        document.getElementById("t_larga_barra").style.display = 'none';        
}
window.onload = espera;
</script>  
</body>
</html>
