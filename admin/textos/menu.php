<?
// Actualizar datos de libros de texto a la desaparición de nivel-grupo
$actua = mysql_query("select modulo from actualizacion where modulo = 'Libros de Texto'");
if (mysql_num_rows($actua)>0) {}else{
mysql_query("ALTER TABLE  `Textos` CHANGE  `Grupo`  `Grupo` VARCHAR( 64 ) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT  ''");
	$lib = mysql_query("select id, nivel, grupo, departamento from Textos");
	//echo "select id, nivel, grupo from Textos<br>";
	while($libro = mysql_fetch_array($lib))
	{
		$total="";
		$id = $libro[0];
		$nv = $libro[1];
		$gr = $libro[2];
		$departamento = str_replace(" P.E.S.","",$libro[3]);
		if (strstr(";",$gr)==FALSE) {
			$num+=1;
			$arr = str_split($gr);
			foreach ($arr as $grup){
				$act = mysql_query("select distinct unidad from alma where curso = '$nv'");
				//echo "select distinct unidad from alma where curso = '$nv'<br>";
				while ($actu = mysql_fetch_array($act)) {
					$ult = substr($actu[0],-1);
					//echo "$ult ==> $grup<br>";
					if ($ult==$grup) {
						$total.=$actu[0].";";
					}
				}
				
			}
		mysql_query ("update Textos set grupo = '$total', departamento = '$departamento' where id = '$id'");
		}
	}
	if ($num>0) {
		mysql_query("insert into actualizacion (modulo, fecha) values ('Libros de Texto', NOW())");
	}
}

$activo1="";
$activo2="";
if (strstr($_SERVER['REQUEST_URI'],'intext')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'consulta')==TRUE or strstr($_SERVER['REQUEST_URI'],'editext')==TRUE) {$activo2 = ' class="active" ';}
?>      
    <div class="container">  
  <div class="tabbable">
     <ul class="nav nav-tabs">
     <li <? echo $activo1;?>> <a href="intextos.php">Nuevo Libro de Texto</a></li>
     <li <? echo $activo2;?>> <a href="consulta.php">Consultar Libros</a></li>
    </ul>
        </div>
        </div>
      