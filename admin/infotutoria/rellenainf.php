<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


?>

<?php
include("../../menu.php");
include("menu.php");
$id_alumno=$_POST['ident'];
$asignatura=$_POST['asignatura'];
$informe=$_POST['informe'];
$profesor =$_POST['profesor'];
?>
<div align="center"> 
<div class="page-header">
  <h2>Informes de Tutoría <small> Redactar Informe</small></h2>
</div>
<br />
    
<?
if (empty($informe) or empty($asignatura)) {
	echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Los datos no están completos.<br>Debes seleccionar Asignatura y rellenar el Informe.<br>Vuelve a la página anterior y rellena todos los datos.
<br /><br /><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-danger">
		</div></div>';
	exit;
}
$ya_hay=mysql_query("select informe from infotut_profesor where asignatura = '$asignatura' and id_alumno = '$id'");
$ya_hay1=mysql_fetch_row($ya_hay);
if (strlen($ya_hay1[0]) > '0') {
mysql_query("update infotut_profesor set informe = '$informe' where id_alumno = '$id' and asignatura = '$asignatura'") or die("<br><center><p>El Informe no ha podido ser actualizado. Busca ayuda. </p></center>");
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido actualizado correctamente. Puedes comprobar los datos más abajo. 
		</div></div>';
}
else{
mysql_query("insert into infotut_profesor (id_alumno,profesor,asignatura,informe) values ('$id_alumno','$profesor','$asignatura','$informe')") or die("<br><center><p>El Informe no ha podido ser registrado. Busca ayuda. </p></center>");
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido guardado correctamente. Puedes comprobar los datos más abajo. 
		</div></div>';	
}

$alumno=mysql_query("SELECT APELLIDOS,NOMBRE,unidad,id,TUTOR, F_ENTREV FROM infotut_alumno WHERE ID='$id_alumno'");
$dalumno = mysql_fetch_array($alumno);
echo "<br /><h4>$dalumno[1] $dalumno[0] ($dalumno[2])<br> Visita: $dalumno[5]<br>Tutor: $dalumno[4]</h4><br />";
$datos=mysql_query("SELECT asignatura, informe, id FROM infotut_profesor WHERE id_alumno='$id_alumno'");
if(mysql_num_rows($datos) > 0)
{
echo "<table class='table' align='center' style='width:800px;'>";
while($informe = mysql_fetch_array($datos))
{
$fondo = "";
if($informe[0] == $asignatura){$fondo="background-color:#ffc40d;";}
	echo "<tr><td style='color:black;$fondo' nowrap>$informe[0]</td>
		  <td style='$fondo'>$informe[1]</td>";
	if (strlen($fondo) > '0') {
		echo "<td><a href='borrar.php?del=1&id_del=$informe[2]&id_alumno=$id_alumno&asignatura=$asignatura&profesor=$profesor'><i class='fa fa-trash-o' title='Borrar' data-bb='confirm-delete'> </i> </a></td>";
	}
	echo"</tr>";
}
echo"</table>";
}
?>
<? include("../../pie.php");?>		
</body>
</html>
