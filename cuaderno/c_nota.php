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

 foreach($_GET as $key => $val)
	{
		${$key} = $val;
	}
echo "<p class='lead'>$curso <span class='muted'>( $nom_asig )</span></p>";		
// Asignatura ese día a esa hora
$asig0 = "SELECT distinct c_asig FROM  horw where prof = '$pr' and dia = '$dia' and hora = '$hora'";
$asig1 = mysql_query($asig0);
$asig = mysql_fetch_array($asig1);
$asignatura = $asig[0];

if(strlen($orden) > '0'){
$ident1 = mysql_query("select id, nombre, texto, texto_pond, visible_nota from notas_cuaderno where id='$id'") or die ("error notas_cuaderno"); //echo $ident2; 
$ident0 = mysql_fetch_array($ident1);
$id = $ident0[0];
$nombre = $ident0[1];
$texto =$ident0[2];

$ident0[4] ? $visible_nota = 1 : $visible_nota = 0;
} 


// Formulario general y datos ocultos
?>
<form action="n_col.php" method="post">
	<input type="hidden" name="asignatura" value = "<? echo $asignatura;?>" />
	<input type="hidden" name="curso" value = "<? echo $curso;?>" />
	<input type="hidden" name="dia" value = "<? echo $dia;?>" />
	<input type="hidden" name="hora" value = "<? echo $hora;?>" />
	<input type="hidden" name="id" value = "<? echo $id;?>" />
	<input type="hidden" name="nom_asig" value = "<? echo $nom_asig;?>" />
	
	<div class="well well-large" style="width:350px;" align="left">
	
		<label for="cmp_nombre">Nombre de la columna</label>
		<input type="text" id="cmp_nombre" name="nombre" size="32" value="<? echo $nombre;?>" class="input-block-level" />
		
		<label for="cmp_observaciones">Observaciones</label>
		<textarea name="texto" rows="6" id="cmp_observaciones" class="input-block-level"><? echo $texto;?></textarea>
		
		<div class="checkbox">
			<input type="checkbox" id="cmp_visible_nota" name="visible_nota" value="1" <?php if($visible_nota) echo 'checked'; ?>>
			<label for="cmp_visible_nota">Visible en la página externa <strong rel="tooltip" title="Si está marcada, permite a los padres y alumnos ver la nota de la actividad o examen en la página externa">(?)</strong></label>
		</div>
		<br />
		<input type="submit" name="crear" value="Crear o Modificar" class="btn btn-primary"/>
	</div>
</form>

<?php include('../pie.php'); ?>

  <script type="text/javascript">
  document.forms[0].elements['nombre'].focus(); 
  </script>
  </div>
</body>
</html>