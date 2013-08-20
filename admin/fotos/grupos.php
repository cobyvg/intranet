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
?>
<?
include '../../menu.php';
if (isset($_POST['curso'])) {$curso = $_POST['curso'];} elseif (isset($_GET['curso'])) {$curso = $_GET['curso'];} else{$curso="";}
?>
     <div align=center>
  <div class="page-header" align="center">
  <h2><? echo $nombre_del_centro;?> <small><br />Alumnos de <? echo " $curso ($curso_actual)";?></small></h2>
</div>
  
<?
$num="";
echo "<div class='container'>";
$gr=mysql_query("select claveal, apellidos, nombre from alma where unidad='$curso'");
	while ($al_gr=mysql_fetch_array($gr)) {	
	$num=$num+1;
	if($num=="1" or $num=="7" or $num=="13" or $num=="19" or $num=="25" or $num=="31" or $num=="36"){
		echo "<div class='row-fluid'>";}	
		$claveal=$al_gr[0];
		if (strlen($al_gr[1])>'17') {
				$apellidos = substr($al_gr[1],0,16).".";
				}	
				else {
				$apellidos = $al_gr[1];
				}
		if (strlen($al_gr[2])>'17') {
				$nombre = substr($al_gr[2],0,16).".";
				}	
				else {
				$nombre = $al_gr[2];
				}
		echo "<div class='span2'><img src='../../xml/fotos/$claveal.jpg' width='140' height='165' align='center' class='img-polaroid'></img><br><h6 align='center'><small>$apellidos, <br />$nombre<br /></small></h6></div>";
				if($num=="6" or $num=="12" or $num=="18" or $num=="24" or $num=="30" or $num=="36" or $num=="42"){
					echo "</div>";}	
	}
echo "</div>";
mysql_close();
?>
</body>
</html>