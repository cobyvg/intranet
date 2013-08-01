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

// Asignatura ese día a esa hora
$asig0 = "SELECT distinct c_asig FROM  horw where prof = '$pr' and dia = '$dia' and hora = '$hora'";
$asig1 = mysql_query($asig0);
$asig = mysql_fetch_array($asig1);
$asignatura = $asig[0];

// Nueva Columna
echo "<div align='center'><h2>Cuaderno de Notas</h2><br />
	<h3>Nueva Columna</span></h3><br />";
if(strlen($orden) > '0'){
$ident1 = mysql_query("select id, nombre, texto, texto_pond from notas_cuaderno where id='$id'") or die ("error notas_cuaderno"); //echo $ident2; 
$ident0 = mysql_fetch_array($ident1);
$id = $ident0[0];
$nombre = $ident0[1];
$texto =$ident0[2]; } 


// Formulario general y datos ocultos
?>
<form action="n_col.php" method="post">
<input type="hidden" name="asignatura" value = "<? echo $asignatura;?>" />
<input type="hidden" name="curso" value = "<? echo $curso;?>" />
<input type="hidden" name="dia" value = "<? echo $dia;?>" />
<input type="hidden" name="hora" value = "<? echo $hora;?>" />
<input type="hidden" name="id" value = "<? echo $id;?>" />
<br />
<div class="well well-large" style="width:350px;" align="left">
<label>Nombre de la columna<br />
<input type="text" name="nombre" size="32" value="<? echo $nombre;?>" class="span4" />
</label>
<label>Observaciones<br />
<textarea name="texto" rows="20" class="span4"><? echo $texto;?></textarea>
</label>
<br />
<input type="submit" name="crear" value="Crear o Modificar" class="btn btn-primary"/>
</form>
</div>
  <script type="text/javascript">
  document.forms[0].elements['nombre'].focus(); 
  </script>
  </div>
</body>
</html>