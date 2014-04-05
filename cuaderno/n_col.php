<?
session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$pr = $_SESSION['profi'];
?>
<?
include("../menu.php");

 echo "<br /><div align='center' class='page-header'>";
$n_profe = explode(", ",$pr);
$nombre_profe = "$n_profe[1] $n_profe[0]";
echo "<h2 class='no_imprimir'>Cuaderno de Notas&nbsp;&nbsp;<small> Crear nueva columna de datos</small></h2>";
echo "</div><br />";
echo '<div align="center">';

 foreach($_POST as $key => $val)
	{
		${$key} = $val;
	}
echo "<p class='lead'>$curso <span class='muted'>( $nom_asig )</span></p>";	
if(empty($nombre)){
	echo '<br /><div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Debes escribir al menos un Nombre para la Columna del cuaderno que estás creando.
</div></div>';
echo '<br /><div align="center"><input name="volver" type="button" onClick="history.go(-1)" value="Volver" class="btn btn-primary"></div>';
exit;
}
// Nueva Columna

if (!$visible_nota) $visible_nota = 0;

$fecha = date('Y-m-d');
// Si hay datos, actualizamos
if(strlen($id) > 0){
$sql = "UPDATE  notas_cuaderno set nombre='$nombre', texto='$texto', visible_nota='$visible_nota' where id = '$id'";
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han modificado correctamente.          
</div></div>';
}
else{
	$serie = mysql_query("select max(orden) from notas_cuaderno where profesor = '$pr' and curso = '$curso' and asignatura = '$asignatura'");
	$num_col = mysql_fetch_array($serie);
	$orden = $num_col[0] + 1;
	// Si no, insertamos
$sql = "INSERT INTO  notas_cuaderno ( profesor ,  fecha ,  nombre ,  texto ,  asignatura, curso, orden, visible_nota ) 
VALUES ( '$pr',  '$fecha',  '$nombre',  '$texto',  '$asignatura', '$curso', '$orden', '$visible_nota')";
//echo $sql;
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La nueva columna ha sido añadida a la tabla del Cuaderno.
</div></div>';
}
mysql_query($sql) or die (mysql_error());
mysql_close();
echo $mens10;
?>

<BR>
</div>
<script language="javascript">
<? 
// Redireccionamos al Cuaderno    
$mens = "../cuaderno.php?profesor=$pr&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curso&clave=$clave";
?>
setTimeout("window.location='<? echo $mens; ?>'", 1000) 
</script>
</body>
</html>
