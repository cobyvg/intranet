<?
require('../../bootstrap.php');


if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header('Location:'.'http://_'.$dominio.'/intranet/salir.php');
	exit;
}


include("../../menu.php");
?>
	<div class="container">
			<div class="page-header">
			<h2>Administración <small>Importación del horario con archivo DEL de Horw</small></h2>
		</div>	
			<div class="row">
<?

$fp = fopen ( $_FILES['archivo']['tmp_name'] , "r" );
if (( $data = fgetcsv ( $fp , 1000 , "," )) !== FALSE ) {
	$num_col=count($data);
	if ($num_col<>13) {
		echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>Atención:</legend>
El archivo de Horw que estás intentando exportar contiene <strong>'.$num_col.' columnas</strong> de datos y debe contener <strong>13 columnas</strong>. Asegúrate de que el archivo de Horw sigue las instrucciones de la imagen, y vuelve a intentarlo.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div><br />';
		exit();
	}
}

// Backup
mysqli_query($db_con,"truncate table horw_seg");
mysqli_query($db_con,"insert into horw_seg select * from horw");
mysqli_query($db_con,"truncate table horw_seg_faltas");
mysqli_query($db_con,"insert into horw_seg_faltas select * from horw_faltas");

mysqli_query($db_con,"truncate table horw");

while (( $data = fgetcsv ( $fp , 1000 , "," )) !== FALSE ) {
	// Mientras hay líneas que leer... si necesitamos añdir sólo las clases hay que hacer aquí un if ($data[9]!='')
	$sql="INSERT INTO horw (dia,hora,a_asig,asig,c_asig,prof,no_prof,c_prof,a_aula,n_aula,a_grupo) ";
	$sql.=" VALUES ( ";
	foreach ($data as $indice=>$clave){
		if ($indice<11) {
			$sql.="'".trim($clave)."', ";
		}		
	}
	$sql=substr($sql,0,strlen($sql)-2);
	$sql.=" )";
	//echo $sql."<br>";
	mysqli_query($db_con,$sql) or die ('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se han podido insertar los datos en la tabla <strong>Horw</strong>. Ponte en contacto con quien pueda resolver el problema.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');	
}
fclose ( $fp );

// Eliminamos el Recreo como 4ª Hora.
$recreo = "update horw set hora = 'R' WHERE hora ='4'";
mysqli_query($db_con,$recreo);
$hora4 = "UPDATE  horw SET  hora =  '4' WHERE  hora = '5'";
mysqli_query($db_con,$hora4);
$hora5 = "UPDATE  horw SET  hora =  '5' WHERE  hora = '6'";
mysqli_query($db_con,$hora5);
$hora6 = "UPDATE  horw SET  hora =  '6' WHERE  hora = '7'";
mysqli_query($db_con,$hora6);
mysqli_query($db_con,"OPTIMIZE TABLE  `horw`");

// Quitamos las S del codigo de las Actividades
$s_l="";
$s_cod = mysqli_query($db_con,"select distinct c_asig from horw where c_asig like 'S%'");
while($s_asigna = mysqli_fetch_array($s_cod)){
	$trozos = explode(" ",$s_asigna[0]);
	$s_l = substr($trozos[0],1,strlen($trozos[0]));
	mysqli_query($db_con,"update horw set c_asig = '$s_l', asig = (select nomactividad from actividades_seneca where idactividad = '$s_l') where c_asig = '$s_asigna[0]'");
}

// Detectamos asignaturas sin código
$sin_codigo="";
$sin_cd = mysqli_query($db_con,"select distinct a_asig, asig from horw where c_asig = '' or c_asig is null");
if (mysqli_num_rows($sin_cd)>0) {
	
echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:600px;" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha registrado un código para las asignaturas que aparecen abajo. Esta situación producirá problemas en módulos fundamentales de la Intranet. Asigna el código correcto y actualiza el horario cuanto antes, a menos que sepas lo que haces.
<br><br><ul>';
	
while($sin_codi = mysqli_fetch_array($sin_cd)){
	echo "<li>$sin_codi[0] => $sin_codi[1]</li>";
}
echo '</ul></div></div>';	
}


// Cambiamos los numeros de Horw para dejarlos en orden alfabético.
$hor = mysqli_query($db_con, "select distinct prof from horw order by prof");
while($hor_profe = mysqli_fetch_array($hor)){
	$np+=1;
	$sql = "update horw set no_prof='$np' where prof = '$hor_profe[0]'";
	//echo "$sql<br>";
	$sql1 = mysqli_query($db_con, $sql);
}

// Limpiez de codigos
$h1 = mysqli_query($db_con, "select id, c_asig, a_grupo, asig, unidades.idcurso, nomcurso from horw, unidades, cursos where a_grupo=nomunidad and unidades.idcurso=cursos.idcurso and a_grupo not like ''");
while ($h2 = mysqli_fetch_array($h1)) {
	$id_horw = $h2[0];
	$curso = $h2[5];
	$cod = $h2[1];
	$nombre_asignatura = $h2[3];
	
	
// Primera pasada	
	$asig = mysqli_query($db_con, "select codigo, nombre from asignaturas where curso = '$curso' and curso not like '' and nombre = '$nombre_asignatura' and codigo not like '2' and abrev not like '%\_%'");
if (mysqli_num_rows($asig)>0) {
	$asignatur = mysqli_fetch_array($asig);
	$asignatura=$asignatur[0];
	if (!($asignatura==$cod)) {
		$codasi = $asignatura;
		mysqli_query($db_con, "update horw set c_asig = '$codasi' where id = '$id_horw'");
		//echo "update horw set c_asig = '$codasi' where id = '$id_horw'<br>";
	}
	else{
		$codasi="";
	}	
}

// Segunda pasada	
	$asig2 = mysqli_query($db_con, "select codigo, nombre from asignaturas where curso = '$curso' and curso not like '' and (codigo not like '2' and codigo = '$cod') and abrev not like '%\_%'");
if (mysqli_num_rows($asig2)>0) {
	$asignatur2 = mysqli_fetch_array($asig2);
	$asignatura2=$asignatur2[0];
	$nombre_asig2=$asignatur2[1];
	if ($asignatura2==$cod) {
		$codasi2 = $asignatura2;
		mysqli_query($db_con, "update horw set c_asig = '$codasi2', asig='$nombre_asig2' where id = '$id_horw'");
	}
	else{
		$codasi2="";
	}
	
}


}

	// Metemos a los profes en la tabla profesores hasta que el horario se haya exportado a Séneca y consigamos los datos reales de los mismos
	$tabla_profes =mysqli_query($db_con,"select * from profesores");
	if (mysqli_num_rows($tabla_profes) > 0) {}
	else{
		// Recorremos la tabla Profesores bajada de Séneca
		$pro =mysqli_query($db_con,"select distinct asig, a_grupo, prof from horw where a_grupo like '1%' or a_grupo like '2%' or a_grupo like '3%' or a_grupo like '4%' order by prof");
		while ($prf =mysqli_fetch_array($pro)) {
			$materia = $prf[0];
			$grupo = $prf[1];
			$profesor = $prf[2];
			$niv =mysqli_query($db_con,"select distinct curso from alma where unidad = '$grupo'");
			$nive =mysqli_fetch_array($niv);
			$nivel = $nive[0];

			mysqli_query($db_con,"INSERT INTO  profesores (
`nivel` ,
`materia` ,
`grupo` ,
`profesor`
) VALUES ('$nivel', '$materia', '$grupo', '$profesor')");
		}
	}
	
// Horw para Faltas
mysqli_query($db_con, "drop table horw_faltas");
mysqli_query($db_con, "create table horw_faltas select * from horw where a_grupo not like '' and a_grupo not like 'GU%'");

	// Tutores
	$tabla_tut =mysqli_query($db_con,"select * from FTUTORES");
	if(mysqli_num_rows($tabla_tut) > 0){}
	else{
		mysqli_query($db_con,"insert into FTUTORES (unidad, tutor) select distinct a_grupo, prof from horw where c_asig = '2'");
	}
	?>
	<div class="alert alert-success alert-block fade in" >
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Horario ha sido importado correctamente.
</div></div><br />
<div align="center">
  <a  href="../index.php" class="btn btn-primary" />Volver a Administración</a>
</div><br />
	</div>
	</div>
	<? include("../../pie.php");?>