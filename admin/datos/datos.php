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
include("../../menu.php");
?>
 <br />
  <div align="center">
<div class="page-header" align="center">
  <h2>Datos de los Alumnos <small> Consultas</small></h2>
</div>
 </div>
 <div class='container-fluid'>
  <div class="row-fluid">
  <div class="span2"></div>
  <div class="span8">
  <?php
  // Si se envian datos desde el campo de búsqueda de alumnos, se separa claveal para procesarlo.
  if (!(isset($_GET['seleccionado']))) {
  	$seleccionado="";
  }else{
  	$seleccionado=$_GET['seleccionado'];
  }
    if (!(isset($_GET['alumno']))) {
  	$alumno="";
  }
  else{
  	$alumno=$_GET['alumno'];
  }
    if (!(isset($AUXSQL))) {
  	$AUXSQL="";
  }
  
  if (isset($seleccionado) and $seleccionado=="1") {
   	$tr=explode(" --> ",$alumno);
   	$clave_al=$tr[1];
	$nombre_al=$tr[0];
	$uni=mysql_query("select unidad, nivel, grupo from alma where claveal='$clave_al'");
	$un=mysql_fetch_array($uni);
	$unidad=$un[0];
   	
  	$foto = '../../xml/fotos/'.$clave.'.jpg';
	if (file_exists($foto)) {
		echo "<div align='center'><img src='../../xml/fotos/$clave.jpg_al' border='2' width='100' height='119' style='margin:auto;border:1px solid #bbb;'  /></div>";
			  echo "<br />";
	}    
   }
    $AUXSQL == "";
  #Comprobamos si se ha metido Apellidos o no.
    if  (TRIM("$APELLIDOS")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and alma.apellidos like '%$APELLIDOS%'";
    }
  if  (TRIM("$NOMBRE")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and alma.nombre like '%$NOMBRE%'";
    }
		  if  (TRIM("$grupo")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and alma.grupo like '$grupo%'";
    }
	  if  (TRIM("$nivel")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and alma.nivel like '$nivel%'";
    }
  	if  (TRIM("$clave_al")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and alma.claveal = '$clave_al'";
    }
if ($seleccionado=='1') {
	    $AUXSQL = " and alma.claveal = '$clave_al'";
}
  
  $SQL = "select distinct alma.claveal, alma.apellidos, alma.nombre, alma.nivel, alma.grupo,\n
  alma.DNI, alma.fecha, alma.domicilio, alma.telefono, alma.telefonourgencia from alma
  where 1 " . $AUXSQL . " order BY alma.apellidos";
  // echo $SQL;
  $result = mysql_query($SQL);
  if (mysql_num_rows($result)>25 and !($seleccionado=="1")) {
  	$imprimir_activado = true;
  }
  if ($row = mysql_fetch_array($result))
        {

echo "<div align=center><table  class='table table-striped tabladatos' style='width:100%;'>";
	echo "<thead><tr><th>
	        Clave</th><th>
		Nombre</th><th width='60'>
		Grupo</th><th>
        		Domicilio</th><th>Teléfono</th>";
				if(stristr($_SESSION['cargo'],'5') == TRUE)
{
echo "
<th> Tfno. Urgencias</th>
<th> Fecha</th>
<th> DNI</th>";
}
echo "</th><th></th>";			
				echo "</tr></thead><tbody>";
                do {
                	$nom=$row[1].", ".$row[2];
                	$unidad = $row[3]."-".$row[4];
		$claveal = $row[0];
		echo "<tr><td>
$row[0]</td><td>
$nom</td><td>
$unidad</td><td>
 $row[7]</td><td>
 $row[8]</td>";

if(stristr($_SESSION['cargo'],'5') == TRUE)
{
echo "<td> $row[9]</td>
<td> $row[6]</td>
<td> $row[5]</td>";
}  
if ($seleccionado=='1'){
	$todo = '&todos=Ver Informe Completo del Alumno';
}
echo "<td><a href='http://$dominio/intranet/admin/informes/index.php?claveal=$claveal&todos=Ver Informe Completo del Alumno'><i class='icon icon-search' title='Ver detalles'> </i> ";
echo '</a></td></tr>';
        } while($row = mysql_fetch_array($result));
        echo "</tbody></table></font></center>\n";
        } else
        {
			echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No hubo suerte, bien porque te has equivocado
        al introducir los datos, bien porque ningún dato se ajusta a tus criterios.
		</div></div>';
        
        }
  ?>
  <?
  if ($seleccionado=='1'){
  echo "<a class='btn btn-primary' href='http://$dominio/intranet/admin/informes/cinforme.php?nombre_al=$alumno&nivel=$un[1]&grupo=$un[2]'>Informe histórico del Alumno</a>&nbsp;&nbsp;";
   	echo "<a class='btn btn-primary' href='../fechorias/infechoria.php?seleccionado=1&nombre_al=$alumno'>Problema de disciplina</a>&nbsp;&nbsp;";
   	echo "<a class='btn btn-primary' href='http://$dominio/intranet/admin/cursos/horarios.php?curso=$unidad'>Horario</a>&nbsp;&nbsp;";
   	if (stristr($_SESSION['cargo'],'1') == TRUE) {
   		$dat = mysql_query("select nivel, grupo from FALUMNOS where claveal='$clave_al'");
   		$tut=mysql_fetch_row($dat);
   		$nivel=$tut[0];
   		$grupo=$tut[1];
   		echo "<a class='btn btn-primary' href='../jefatura/tutor.php?seleccionado=1&alumno=$alumno&nivel=$nivel&grupo=$grupo'>Acción de Tutoría</a>&nbsp;&nbsp;";
   	}
   	if (stristr($_SESSION['cargo'],'8') == TRUE) {
   		$dat = mysql_query("select nivel, grupo from FALUMNOS where claveal='$clave_al'");
   		$tut=mysql_fetch_row($dat);
   		$nivel=$tut[0];
   		$grupo=$tut[1];
   		echo "<a class='btn btn-primary' href='../orientacion/tutor.php?seleccionado=1&alumno=$alumno&nivel=$nivel&grupo=$grupo'>Acción de Tutoría</a>&nbsp;&nbsp;";
   	}
   	if (stristr($_SESSION['cargo'],'2') == TRUE) {
   		$tutor = $_SESSION['profi'];
   		$dat = mysql_query("select nivel, grupo from FALUMNOS where claveal='$clave_al'");
   		$dat_tutor = mysql_query("select nivel, grupo from FTUTORES where tutor='$tutor'");
   		$tut=mysql_fetch_row($dat);
   		$tut2=mysql_fetch_array($dat_tutor);
   		$nivel=$tut[0];
   		$grupo=$tut[1];
   		$nivel_tutor=$tut2[0];
   		$grupo_tutor=$tut2[1];
   		if ($nivel==$nivel_tutor and $grupo==$grupo_tutor) {
   		echo "<a class='btn btn-primary' href='../tutoria/tutor.php?seleccionado=1&alumno=$alumno&nivel=$nivel&grupo=$grupo&tutor=$tutor'>Acción de Tutoría</a>&nbsp;&nbsp;";	
   		}
   	}
  }
	?>
    <? include("../../pie.php");?>
</BODY>
</HTML>
