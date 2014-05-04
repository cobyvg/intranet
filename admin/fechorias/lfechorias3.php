<?
session_start ();
include ("../../config.php");
if ($_SESSION ['autentificado'] != '1') {
	session_destroy ();
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
?>
<?php
		include ("../../menu.php");
		include ("menu.php");
		$datatables_activado = true;
		?>
<style type="text/css">
.table td{
	vertical-align:middle;
}
</style>
<div align="center">  
<?php
 echo '
<div class="page-header" align="center">
  <h2>Problemas de Convivencia <small> Ranking de Fechorías</small></h2>
</div>
<br />';
		
    echo ' <div class="well well-large well-transparent lead" id="t_larga_barra" style="width:320px">
        <i class="icon-spinner icon-spin icon-2x pull-left"></i> Cargando los datos...
      </div>
   ';
    echo "</div>";
    echo "<div id='t_larga' style='display:none' >";
    
		echo "<div class='container'>";
		echo '<div class="row-fluid">
  <div class="span10 offset1">';
		echo "<table class='table table-striped tabladatos' align='center'>";
		$fecha1 = (date ( "d" ) . - date ( "m" ) . - date ( "Y" ));
		echo "<thead><tr>
		<th>ALUMNO</th>
		<th>CURSO</th>
		<th>TOTAL</th>
		<th>Leves</th>
		<th>Graves</th>
		<th nowrap>Muy Graves</th>
		<th>Expulsion</th>
		<th>Convivencia</th>
		</tr></thead><tbody>";
		mysql_query ( "create table Fechoria_temp SELECT DISTINCT claveal, COUNT( * ) as total FROM Fechoria GROUP BY claveal" );
		$num0 = mysql_query ( "select * from Fechoria_temp order by total desc" );
		while ( $num = mysql_fetch_array ( $num0 ) ) {
			$query0 = "select apellidos, nombre, nivel, grupo from FALUMNOS where claveal = '$num[0]'";
			$result = mysql_query ( $query0 );
			$row = mysql_fetch_array ( $result );
			$claveal = $num [0];
			$apellidos = $row [0];
			$nombre = $row [1];
			$nivel = $row [2];
			$grupo = $row [3];
			$rownumero = $num [1];
			$rowcurso = $nivel . "-" . $grupo;
			$rowalumno = $nombre . "&nbsp;" . $apellidos;
		$lev = mysql_query("select grave from Fechoria where grave='leve' and claveal = '$claveal'");
		$leve = mysql_num_rows($lev);
		$grav = mysql_query("select grave from Fechoria where grave='grave' and claveal = '$claveal'");
		$grave = mysql_num_rows($grav);
		$m_grav = mysql_query("select grave from Fechoria where grave='muy grave' and claveal = '$claveal'");
		$m_grave = mysql_num_rows($m_grav);
		$expulsio = mysql_query("select expulsion from Fechoria where expulsion > '0' and claveal = '$claveal'");
		$expulsion = mysql_num_rows($expulsio);
		if ($expulsion == '0'){$expulsion='';}
		$conviv = mysql_query("select aula_conv from Fechoria where aula_conv > '0' and claveal = '$claveal'");
		$conv = mysql_num_rows($conviv);
		if ($conv== '0'){$conv='';}
		if(!(empty($apellidos))){
			echo "<tr>
		<td nowrap>";
		$foto="";
		$foto = "<img src='../../xml/fotos/$claveal.jpg' width='55' height='64' class=''  />";
		echo $foto."&nbsp;&nbsp;";			
		echo "<a href='lfechorias2.php?clave=$claveal'>$rowalumno</a></td>
		<td $bgcolor>$rowcurso</td>
		<td $bgcolor>$rownumero</td>
		<td $bgcolor>$leve</td>
		<td $bgcolor>$grave</td>
		<td $bgcolor>$m_grave</td>
		<td $bgcolor>$expulsion</td>
		<td $bgcolor>$conv</td>
		</tr>";
		}
		}
		mysql_query ( "drop table Fechoria_temp" );		
		echo "</tbody></table>\n";
		mysql_query ( "drop table Fechoria_temp" );
		?>
		</div>
		</div>
		</div>
		</div>

        <? include("../../pie.php");?>
  <script>
function espera( ) {
        document.getElementById("t_larga").style.display = '';
        document.getElementById("t_larga_barra").style.display = 'none';        
}
window.onload = espera;
</script>     
  </body>
</html>
