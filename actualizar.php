<?php
/*
	@descripcion: Fotos de alumnos y profesores en base de datos se mueven a directorio.
	@fecha: 5 de agosto de 2013
*/
$fotos_dir = "./xml/fotos";

$d = dir($fotos_dir);
while (false !== ($entry = $d->read())) {
   $fotos_ya+=1;
}

$result=mysql_query("SELECT datos, nombre FROM fotos");
if (mysql_num_rows($result)>0 and $fotos_ya < "10") {
	while($row = mysql_fetch_array($result)){
		$foto_al = $fotos_dir."/".$row[1];
		# Creamos cada uno de los archivos
		file_put_contents($foto_al,$row[0], FILE_APPEND);	
	}
} 

$fotos_profe_dir = "./xml/fotos_profes"; 
$d_profes = dir($fotos_profe_dir);
while (false !== ($entry_profes = $d_profes->read())) {
   $fotos_profes_ya+=1;
}
$result_profe=mysql_query("SELECT datos, nombre FROM fotos_profes");
if (mysql_num_rows($result_profe)>0 and $fotos_profes_ya < "10") {
	while($row_profe = mysql_fetch_array($result_profe)){
		$foto_profe = $fotos_profe_dir."/".$row_profe[1];
		# Creamos cada uno de los archivos
		file_put_contents($foto_profe,$row_profe[0], FILE_APPEND);	
	}   
}

/*
	@descripcion: Actualización de la tabla de noticias
	@fecha: 5 de agosto de 2013
*/
$hay = mysql_query("show tables");

while ($tabla=mysql_fetch_array($hay)) {
	if ($tabla[0]=="profes") {
		$ya_hay = mysql_query("select * from profes");
		
		if (mysql_num_rows($ya_hay)>0) {
			mysql_query("RENAME TABLE  `profes` TO  `noticias`");
			mysql_query("ALTER TABLE  `noticias` ADD  `pagina` TINYINT( 2 ) NOT NULL");
			mysql_query("update noticias set pagina = '1'");
		}
		else {
			mysql_query("RENAME TABLE  `profes` TO  `noticias`");
			mysql_query("ALTER TABLE  `noticias` ADD  `pagina` TINYINT( 2 ) NOT NULL");
		}
	}
}
?>