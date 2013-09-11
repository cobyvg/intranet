<?
session_start();
include("../../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?php
include("../../../menu.php");
?>
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Administración <small> Restaurar la Base de Datos</small></h2>
</div>
<br />
<?
echo '<div class="well well-large span6 offset3" align="left"><center><p class="lead muted">Restaurar la Base de Datos de la Intranet</p>';
echo '</center>';

		//  Conexión con la Base de Datos.
	
	$db_server			= $db_host; 
	$db_name			= $db; 
	$db_username		= $db_user; 
	$db_password		= $db_pass; 

	$filename 			= $_FILES['archivo']['tmp_name'];
	$filenombre			= $_FILES['archivo']['name'];


//------------------------------------------------------------------------------------------
//  No tocar
	error_reporting( E_ALL & ~E_NOTICE );
	define( 'Str_VERS', "1.1.1" );
	define( 'Str_DATE', "18 de Marzo de 2005" );
//------------------------------------------------------------------------------------------

///////  El área protegida empieza DESPUÉS de la SIGUIENTE línea  /////
?>


	<strong>
<?php 
	@set_time_limit( 0 );

	echo( "- Base de Datos: '$db_name' en '$db_server'.<br>" );
	$error = false;

	if ( !@function_exists( 'gzopen' ) ) {
		$hay_Zlib = false;
		echo( "- Ya que no está disponible Zlib, usaré el BackUp de la Base de Datos sin comprimir: '$filenombre'<br>" );
	}
	else {
		$hay_Zlib = true;
		#$filename = $filename . ".gz";
		echo( "- Ya que está disponible Zlib, usaré el BackUp de la Base de Datos comprimido: '$filenombre'<br>" );
	}

	if( !$file = @fopen( $filename,"r" ) ) { 
	    echo ("<br>- Lo siento, no encuentro o no puedo abrir: '$filenombre'.<br>");
	    $error = true;
	}
	else { 
	    if( fseek($file, 0, SEEK_END)==0 )
	        $filesize_comprimido = ftell( $file );
	    else { 
	       echo ("<br>- Lo siento, no puedo obtener las dimensiones de '$filenombre'.<br>");
	       $error = true;
	    }
	 	  fclose( $file );
	}

	if ( !$error ) {
		if( $hay_Zlib ) {
			if ( !$file = @gzopen( $filename, "rb" ) ) { 
				echo( "<br>- Lo siento, no encuentro o no puedo abrir: '$filenombre'.<br>" );
				$error = true;
			}
			else {
				gzrewind( $file );
			}
		}
		else {
			if ( !$file = @fopen( $filename, "rb" ) ) { 
				echo( "<br>- Lo siento, no encuentro o no puedo abrir: '$filenombre'.<br>" );
				$error = true;
			}
			else {
				rewind( $file );
			}
		}
	}

	if (!$error) { 
	    $dbconnection = @mysql_connect( $db_server, $db_username, $db_password ); 
	    if ($dbconnection) 
	        $db = mysql_select_db( $db_name );
	    if ( !$dbconnection || !$db ) { 
	        echo( "<br>" );
	        echo( "- Lo siento, la conexion con la Base de datos ha fallado: ".mysql_error()."<br>" );
	        $error = true;
	    }
	    else {
	        echo( "<br>" );
	        echo( "- He establecido conexion con la Base de datos.<br>" );
	    }
	}

	if (!$error) { 
	    $result = mysql_list_tables( $db_name );
			if (!$result) {
					print "<br>- Error, no puedo obtener la lista de las tablas.<br>";
					print '<br>- MySQL Error: ' . mysql_error(). '<br>';
					$error = true;
			}
			else {
					// $count es el número de tablas en la base de datos
					$count = mysql_num_rows($result);
					if( !$count ) {
							echo "- No ha sido necesario borrar la estructura de la Base de datos, estaba vacía.<br>";
					}
					else {
							while ($row = mysql_fetch_row($result)) {
									$deleteIt = mysql_query("DROP TABLE $row[0]");
									if( !$deleteIt ) {
	        						echo( "<br>" );
											print "- Lo siento, error al borrar la tabla $row[0].<br>";
											$error = true;
											break;
									}
							}
							echo "- He borrado la estructura de la Base de Datos.<br>";
					}
					mysql_free_result($result);
			}
	}

	if( !$error ) { 
	    $query = "";
	    $last_query = "";
	    $total_queries = 0;
	    $total_lineas = 0;
	
			$t_start = time();

			while( 1 ) {
				if( $hay_Zlib )
					$seacabo = gzeof( $file ) OR $error;
				else
					$seacabo = feof( $file ) OR $error;
				if( $seacabo )
					break;
				if( $hay_Zlib )
					$statement = utf8_decode(gzgets( $file ));
				else
					$statement = utf8_decode(fgets( $file ));
					
	        $statement = trim( $statement );
	        $total_lineas++;
	        // no se procesan comentarios ni lineas en blanco
	        if ( $statement=="--" || $statement=="" || strpos ($statement, "#") === 0) { 
	            continue;
	        }
	        // pasa a query
	        $query .= $statement;
	        // ejecuta query si esta completo
	        if( preg_match('/;$/', $statement ) ) { 
	            if ( !mysql_query( $query, $dbconnection) ) { 
	                echo(" <br>" );
	                echo("- Error en statement: $statement<br>" );
	                echo("- Query: $query<br>");
	                echo("- MySQL: ".mysql_error()."<br>" );
	                $error = true;
	                break;
	            }
	            $last_query = $query;
	            $query = "";
	            $total_queries++;
	        }
	    }

			if( $hay_Zlib )
				$file_offset = gztell($file);
	    else
	    	$file_offset = ftell($file);
	
	    echo( "<pre>" );
	    echo( "- Líneas procesadas......................... $total_lineas<br>" );
	    echo( "- Queries procesadas........................ $total_queries<br>" );
	    echo( "- Último Query procesado.................... '$last_query'<br>" );
			if( $hay_Zlib ) {
	    	echo( "- Base de Datos comprimida.................. $filesize_comprimido bytes<br>");
	    	echo( "- Base de Datos descomprimida y procesada... $file_offset bytes<br>" );
	  	}
	  	else {
	    	echo( "- Base de Datos procesada................... $file_offset bytes<br>" );
	  	}
	    echo( "</pre>" );
			$t_now = time();
			$t_delta = $t_now - $t_start;
			if( !$t_delta )
				$t_delta = 1;
			$t_delta = floor(($t_delta-(floor($t_delta/3600)*3600))/60)." minutos y "
			.floor($t_delta-(floor($t_delta/60))*60)." segundos.";
			echo( "- He completado el Restore de la Base de Datos en $t_delta<br>" );
	}

	if ( $dbconnection )
	    mysql_close();
	if ( $file )
		if( $hay_Zlib )
			gzclose($file);
	   else
	    fclose($file);


echo '</div>';
//------------------------------------------------------------------------------------------
//  END
?>

