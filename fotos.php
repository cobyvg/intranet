<?php
//	===============================================
//	SCRIPT DE NORMALIZACION DE FOTOGRAFIAS
//	@author:	Rubén López Herrera
//	@date:		2014-08-10
//	===============================================


function normaliza_fotografias($directory = './xml/fotos/') {

	if (@$handle = opendir($directory)) {
		
		require("./lib/class.Images.php");
		
		while (false !== ($filename = readdir($handle))) {
			
			if (! is_dir($filename) && strstr($filename, '.jpg')) {
				
				$nie = substr($filename,0,-4);
				
				$image = new Image($directory.$filename);
				$image->resize(240,320,'crop');
				$image->save($nie, $directory, 'jpg');
			}
	
		}
		
		echo "Terminado!";
		
	}
	else {
		die ("No se pudo abrir el directorio <em>$directory</em>");
	}
	
}

normaliza_fotografias();
normaliza_fotografias('./xml/fotos_profes/');

?>