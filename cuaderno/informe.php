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
?>
<?
include("../menu.php");
echo "<br /><div align='center' class='page-header'><h2>Cuaderno de Notas 
	 <small>Informe individual de los alumnos</small></h2></div>";
echo '<div align="center">';

	 
if($siguiente == '1'){
  $trozos = explode("-",$curso);
  $nivel = $trozos[0]; 
  $grupo = $trozos[1];
  $adelante1 = "select nc, claveal from FALUMNOS where nivel = '$nivel' and grupo = '$grupo' and nc>$nc order by nc asc limit 2";
  $adelante0 = mysql_query($adelante1);
  $adelante = mysql_fetch_array($adelante0);
  $nc = $adelante[0];
  $claveal = $adelante[1];
  }
   if($anterior == '1'){
  $trozos = explode("-",$curso);
  $nivel = $trozos[0]; 
  $grupo = $trozos[1];
  $menor = $nc - 1;
  $anterior1 = "select nc, claveal from FALUMNOS where nivel = '$nivel' and grupo = '$grupo' and nc < '$nc' order by nc desc limit 1";
  $anterior0 = mysql_query($anterior1);
  $anterior = mysql_fetch_array($anterior0);
  $nc = $anterior[0];
  $claveal = $anterior[1];
  }
  $alum = mysql_query("select nc, nivel, grupo , nombre, apellidos from FALUMNOS where claveal = '$claveal'");
  $alumno = mysql_fetch_array($alum);
  $nc = $alumno[0];
  $nivel = $alumno[1];
  $grupo = $alumno[2];    
  $nombre = $alumno[4];
  $apellidos = $alumno[3];
  $curso = $nivel."-".$grupo;

	
	$max_nc = mysql_query("select max(nc) from FALUMNOS where nivel = '$nivel' and grupo = '$grupo'");
  	$max = mysql_fetch_row($max_nc);
	$ultimo = $max[0];
	
   	$foto = '../xml/fotos/'.$claveal.'.jpg';
	if (file_exists($foto)) {
		echo "<div style='width:150px;margin:auto;'>";
		echo "<img src='../xml/fotos/$claveal.jpg' border='2' width='100' height='119' style='margin-top:10px;margin-bottom:10px;border:1px solid #bbb;'  />";
		echo "</div>";
	}
	
  echo "<br /><table align='center' class='table table-bordered table-striped' style='width:auto'>";
  echo "<tr><td align='center'>";
  
  if($nc > 1){$mens_ant = "informe.php?profesor=$profesor&clave=$clave&nc=$nc&curso=$curso&asignatura=$asignatura&nombre=$nombre&apellidos=$apellidos&anterior=1";
  echo '<button class="btn btn-warning" name="anterior" onclick="window.location=\'';	
  echo $mens_ant;
  echo '\'" style="cursor: pointer;"><i class="icon icon-chevron-left icon-white"> </i> Anterior</button>';}
  
  echo "</td><td align='center' >$nc</td><th align='center' style='color:#08c'> $apellidos $nombre</th><td align='center' >$nivel-$grupo</td><td align='center'>"; 
   
  if($nc < $ultimo){
 $mens_sig = "informe.php?profesor=$profesor&clave=$clave&nc=$nc&curso=$curso&asignatura=$asignatura&nombre=$nombre&apellidos=$apellidos&siguiente=1";
	echo '<button class="btn btn-warning" name="siguiente" onclick="window.location=\'';	
	echo $mens_sig;
	echo '\'" style="cursor: pointer;">Siguiente <i class="icon icon-chevron-right icon-white"> </i> </button>';}

  echo "</td></tr>";
  echo "</table>"; 
  if(!$detalles){        
  $mens = "informe.php?profesor=$profesor&clave=$clave&nc=$nc&curso=$curso&asignatura=$asignatura&claveal=$claveal&nombre=$nombre&apellidos=$apellidos&detalles=1";
	echo '<br /><input  type="button" class="btn btn-primary" name="otros" value="Datos Personales del Alumno" onclick="window.location=\'';	
	echo $mens;
	echo '\'" style="cursor: pointer;"><br /><br />';}

  else {
  	include("informes/datos.php");
	echo '<hr style="width:400px;">';

  }
  
// Procesamos los datosxxxx
$datos1 = "select distinct fecha, nombre, nota from datos, notas_cuaderno where  notas_cuaderno.id = datos.id and profesor = '$profesor' and curso like '%$curso%,' and claveal = '$claveal' and asignatura = '$asignatura' order by orden";
$datos0 = mysql_query($datos1);
	if (mysql_num_rows($datos0) > 0) {
		?>
    <div align="center"><br /><h4>
 Notas en la Columnas</h4><br /></div>
    <?
echo "<table align='center' class='table table-striped' style='width:auto'>\n"; 
echo "<tr><th>Fecha</td><th>Columna</td><th>Nota</td>";
		while($datos = mysql_fetch_array($datos0))
		{
		echo "<tr><td>$datos[0]</th><td>$datos[1]</th><td align='center' style='color:brown;'> $datos[2]</th></tr>";
		}
echo "</table>";
		}
		else	
		{
echo '<br /><div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
El alumno no tiene notas registradas.
</div></div>';		}
echo '<hr style="width:400px;">';
   if(!$otros){ 
    $mens = "informe.php?profesor=$profesor&clave=$clave&asignatura=$asignatura&claveal=$claveal&nombre=$nombre&apellidos=$apellidos&otros=1";
	echo '<input type="button" class="btn btn-success" name="otros" value="Otros datos académicos del Alumno..." onclick="window.location=\'';	
	echo $mens;
	echo '\'" style="cursor: pointer;" />';
}
else{
include("informes/faltas.php");
echo '<hr style="width:400px;">';
include("informes/fechorias.php");
echo '<hr style="width:400px;">';
include("informes/notas.php");
echo '<hr style="width:400px;">';
echo "<br /><input type=button value=Volver onClick='history.back(-1)' class='btn btn-primary'>";
}
?>
</div>
