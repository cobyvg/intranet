<?
session_start ();
include ("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );

$PLUGIN_DATATABLES = 1;

include ("../../menu.php");
include ("menu.php");
?>
<div class="container">
<div class="page-header">
  <h2>Problemas de convivencia <small> Ranking de Fechorías</small></h2>
</div>
<br />

<div class="row">

<div class="col-sm-12">	
    <div class="well text-center" id="t_larga_barra" style="width:320px; margin:0 auto;">
        		<span class="lead"><span class="fa fa-circle-o-notch fa-spin"></span> Cargando...</span>
     		 </div>
   <div id='t_larga' style='display:none' >		
<?php

		echo "<table class='table table-bordered table-striped table-vcentered datatable'>";
		$fecha1 = (date ( "d" ) . - date ( "m" ) . - date ( "Y" ));
		echo "<thead>
		<th>ALUMNO</th>
		<th>CURSO</th>
		<th>TOTAL</th>
		<th>Leves</th>
		<th>Graves</th>
		<th nowrap>Muy Graves</th>
		<th>Expulsion</th>
		<th>Convivencia</th>
		</thead><tbody>";
		mysql_query ( "create table Fechoria_temp SELECT DISTINCT claveal, COUNT( * ) as total FROM Fechoria GROUP BY claveal" );
		$num0 = mysql_query ( "select * from Fechoria_temp order by total desc" );
		while ( $num = mysql_fetch_array ( $num0 ) ) {
			$query0 = "select apellidos, nombre, unidad from FALUMNOS where claveal = '$num[0]'";
			$result = mysql_query ( $query0 );
			$row = mysql_fetch_array ( $result );
			$claveal = $num [0];
			$apellidos = $row [0];
			$nombre = $row [1];
			$unidad = $row [2];
			$rownumero = $num [1];
			$rowcurso = $unidad ;
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
		$foto="<span class='fa fa-user fa-4x'></span>";
		if(file_exists('../../xml/fotos/'.$claveal.'.jpg')) $foto = "<img class='img-thumbnail' src='../../xml/fotos/$claveal.jpg' width='55' height='64'>";
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

        <? include("../../pie.php");?>
   <script>
   $(document).ready(function() {
     var table = $('.datatable').DataTable({
     		"paging":   true,
         "ordering": true,
         "info":     false,
         
     		"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
     		
     		"order": [[ 2, "desc" ]],
     		
     		"language": {
     		            "lengthMenu": "_MENU_",
     		            "zeroRecords": "No se ha encontrado ningún resultado con ese criterio.",
     		            "info": "Página _PAGE_ de _PAGES_",
     		            "infoEmpty": "No hay resultados disponibles.",
     		            "infoFiltered": "(filtrado de _MAX_ resultados)",
     		            "search": "Buscar: ",
     		            "paginate": {
     		                  "first": "Primera",
     		                  "next": "Última",
     		                  "next": "",
     		                  "previous": ""
     		                }
     		        }
     	});
   });
   </script>
  <script>
function espera( ) {
        document.getElementById("t_larga").style.display = '';
        document.getElementById("t_larga_barra").style.display = 'none';        
}
window.onload = espera;
</script>     
  </body>
</html>
