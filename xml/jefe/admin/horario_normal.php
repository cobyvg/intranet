<? 
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}

$fp = fopen ( $_FILES['archivo']['tmp_name'] , "r" );
if (( $data = fgetcsv ( $fp , 1000 , "," )) !== FALSE ) { 
$num_col=count($data);
if ($num_col<>13) {
	echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>Atención:</legend>
El archivo de Horwin que estás intentando exportar contiene <strong>'.$num_col.' columnas</strong> de datos y debe contener <strong>13 columnas</strong>. Asegúrate de que el archivo de Horwin sigue las instrucciones de la imagen, y vuelve a intentarlo.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div><br />';
	exit();
}
}	
$c=mysql_connect($db_host,$db_user,$db_pass); 
mysql_select_db($db,$c);  
mysql_query("drop table horw"); 
$crea =" CREATE TABLE IF NOT EXISTS horw (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  dia char(1) NOT NULL default '',
  hora char(2) NOT NULL default '',
  a_asig varchar(8) NOT NULL default '',
  asig varchar(64) NOT NULL default '',
  c_asig varchar(30) NOT NULL default '',
  prof varchar(50) NOT NULL default '',
  no_prof tinyint default NULL,
  c_prof varchar(30) NOT NULL default '',
  a_aula varchar(5) NOT NULL default '',
  n_aula varchar(64) NOT NULL default '',
  a_grupo varchar(64) NOT NULL default '',
  nivel varchar(10) NOT NULL default '',
  n_grupo varchar(10) NOT NULL default '',
  clase varchar(16) NOT NULL default ''
)";
mysql_query($crea,$c) or die ('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido crear la tabla <strong>Horw</strong>. Ponte en contacto con quien pueda resolver el problema.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');
// Claveal primaria e índice
  $SQL6 = "ALTER TABLE  `horw` ADD INDEX (  `prof` )";
  $result6 = mysql_query($SQL6);
    $SQL7 = "ALTER TABLE  `horw` ADD INDEX (  `c_asig` )";
  $result7 = mysql_query($SQL7);
while (( $data = fgetcsv ( $fp , 1000 , "," )) !== FALSE ) { 
// Mientras hay líneas que leer... si necesitamos añdir sólo las clases hay que hacer aquí un if ($data[9]!='')
$sql="INSERT INTO horw (dia,hora,a_asig,asig,c_asig,prof,no_prof,c_prof,a_aula,n_aula,a_grupo,nivel,n_grupo) ";
$sql.=" VALUES ( ";
foreach ($data as $indice=>$clave){
$sql.="'".trim($clave)."', ";
}
$sql=substr($sql,0,strlen($sql)-2);
$sql.=" )";
// echo $sql."<br>";
mysql_query($sql,$c) or die ('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se han podido insertar los datos en la tabla <strong>Horw</strong>. Ponte en contacto con quien pueda resolver el problema.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');	
}
fclose ( $fp );

// Separamos Nivel y Grupo si sigue el modelo clásico del guión (1E-F, 2B-C, etc)
  $SQL_1 = "SELECT a_grupo  FROM  horw where a_grupo is not null and a_grupo not like ''";
  $result_1 = mysql_query($SQL_1);
  $row_1 = mysql_fetch_row($result_1);
  if (strstr("-",$row_1[0])==TRUE) {
    $SQL0 = "SELECT a_grupo, id FROM  horw";
  $result0 = mysql_query($SQL0);
 while  ($row0 = mysql_fetch_array($result0))
 {
 	if (is_numeric(substr($row0[0],0,1))) 
 	{
$nivel0 = substr($row0[0], 0, 2);
$grupo0 = substr($row0[0], 3, 1);
$actualiza= "UPDATE horw SET nivel = '$nivel0', n_grupo = '$grupo0' where id = '$row0[1]'";
 	}
 	else {
$actualiza= "UPDATE horw SET nivel = '', n_grupo = '' where a_grupo = '$row0[0]'";
 	}
mysql_query($actualiza); 
 }
  }

 // Eliminamos el Recreo como 4ª Hora.
 $recreo = "DELETE FROM horw WHERE hora ='4'";
 mysql_query($recreo);
 $hora4 = "UPDATE  horw SET  hora =  '4' WHERE  hora = '5'";
 mysql_query($hora4);
 $hora5 = "UPDATE  horw SET  hora =  '5' WHERE  hora = '6'";
 mysql_query($hora5);
 $hora6 = "UPDATE  horw SET  hora =  '6' WHERE  hora = '7'";
 mysql_query($hora6);
 mysql_query("OPTIMIZE TABLE  `horw`"); 

// Metemos a los profes en la tabla profesores hasta que el horario se haya exportado a Séneca y consigamos los datos reales de los mismos
$tabla_profes = mysql_query("select * from profesores");
if (mysql_num_rows($tabla_profes) > 0) {}
else{
// Recorremos la tabla Profesores bajada de Séneca
	$pro = mysql_query("select distinct asig, a_grupo, prof from horw where a_grupo like '1%' or a_grupo like '2%' or a_grupo like '3%' or a_grupo like '4%' order by prof");
	while ($prf = mysql_fetch_array($pro)) {	
		$materia = $prf[0];
		$grupo = $prf[1];
		$profesor = $prf[2];
		$niv = mysql_query("select distinct curso from alma where unidad = '$grupo'");
		$nive = mysql_fetch_array($niv);
		$nivel = $nive[0];

	mysql_query("INSERT INTO  profesores (
`nivel` ,
`materia` ,
`grupo` ,
`profesor`
) VALUES ('$nivel', '$materia', '$grupo', '$profesor')");
	}
}

 // Tutores
 $tabla_tut = mysql_query("select * from FTUTORES");
if(mysql_num_rows($tabla_tut) > 0){}
	else{
mysql_query("insert into FTUTORES (unidad, tutor) select distinct a_grupo, prof from horw where a_asig like '%TUT%'");	

//Primera version de Profesores.
mysql_query("truncate table profesores");
mysql_query("insert into profesores SELECT DISTINCT asignaturas.curso, asignaturas.nombre, a_grupo, prof FROM asignaturas, horw WHERE asignaturas.codigo = c_asig and abrev not like '%\_%'");
mysql_query("truncate table reservas.profesores");
mysql_query("insert into reservas.profesores SELECT DISTINCT alma.curso, asignaturas.nombre, a_grupo, prof
FROM alma, asignaturas, horw
WHERE alma.unidad = horw.a_grupo
AND asignaturas.codigo = c_asig");
}
?> 