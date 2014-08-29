<?
// Actualizar datos de libros de texto a la desaparición de nivel-grupo
$actua = mysql_query("select modulo from actualizacion where modulo = 'Libros de Texto'");
if (mysql_num_rows($actua)>0) {}else{
mysql_query("ALTER TABLE  `Textos` CHANGE  `Grupo`  `Grupo` TEXT CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT  ''");
	$lib = mysql_query("select id, nivel, grupo, departamento from Textos");
	//echo "select id, nivel, grupo from Textos<br>";
	while($libro = mysql_fetch_array($lib))
	{
		$total="";
		$id = $libro[0];
		$nv = $libro[1];
		$gr = $libro[2];
		$nomdepto = str_replace(" P.E.S.","",$libro[3]);
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
		mysql_query ("update Textos set grupo = '$total', departamento = '$nomdepto' where id = '$id'");
		}
	}
	if ($num>0) {
		mysql_query("insert into actualizacion (modulo, fecha) values ('Libros de Texto', NOW())");
	}
}
?>

<div class="container">

	<ul class="nav nav-tabs">
		<li<?php echo ((strstr($_SERVER['REQUEST_URI'],'intextos.php') == true)) ? ' class="active"' : '' ; ?>><a href="intextos.php">Nuevo libro de texto</a></li>
		<li<?php echo ((strstr($_SERVER['REQUEST_URI'],'consulta') == true)) ? ' class="active"' : '' ; ?>> <a href="consulta.php">Consultar libros</a></li>
	</ul>
	
</div>
      