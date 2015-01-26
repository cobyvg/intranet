<?php 
if (isset($_POST['force_ssl']) && $_POST['force_ssl'] == true) {
	
	$fp = fopen('../.htaccess', 'w');
	fwrite($fp, "Options +FollowSymLinks\r\n");
	fwrite($fp, "RewriteEngine On\r\n");
	fwrite($fp, "RewriteCond %{SERVER_PORT} 80\r\n");
	fwrite($fp, "RewriteCond %{REQUEST_URI} intranet\r\n");
	fwrite($fp, "RewriteRule ^(.*)$ https://".$_POST['dominio']."/intranet/$1 [R,L]\r\n");
	fclose($fp);
	
}
?>