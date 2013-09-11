<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?
include("../../menu.php");
?>
 <br />
   <div align=center>
  <div class="page-header" align="center">
  <h2>Administración <small> Distribución de los Alumnos TIC</small></h2>
</div>
<br />
<? 
// Creación de tabla temporal.
mysql_query("CREATE TABLE IF NOT EXISTS `AsignacionMesasTICtmp` (
  `prof` varchar(50) NOT NULL,
  `agrupamiento` varchar(50) NOT NULL default '',
  `c_asig` varchar(30) NOT NULL,
  KEY `prof` (`prof`)
) ");

$borrar = mysql_query ("truncate table AsignacionMesasTIC") ;

//comenzamos a tomar los varlores de los campos que necesitaremos
$profe=mysql_query("select distinct profesor from profesores");
while ($profer=mysql_fetch_array($profe)){
	//// echo$profer[0];
	$diahora=mysql_query("select distinct dia,hora,c_asig from horw where prof='$profer[0]' and c_asig<>''") or die ('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se han podido tomar los datos de la tabla <strong>Horw</strong>. ¿Has creado la tabla de los horarios a partir del archivo exportado desde HORW? este módulo necesita una tabla de horarios compatible con HORW.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');
	while ($diahorar=mysql_fetch_array($diahora))
	{
		$c_asig=$diahorar[2];
		$agrup=mysql_query("select distinct a_grupo from horw where dia='$diahorar[0]' and hora='$diahorar[1]' and c_asig='$diahorar[2]' and prof='$profer[0]' order by n_grupo");
		$n=mysql_num_rows($agrup); //// echo$n;
		//if($n=='3'){
		$acumula='';
		while($agrupr=mysql_fetch_array($agrup)){
			$acumula=$acumula.$agrupr[0].':';
		} //// echo$profer[0].'-->'.$acumula.'-->'.$c_asig.'<br>';
		//// echo"insert into AsignacionMesasTICtmp (prof,agrupamiento,c_asig) values ('$profer[0]','$acumula','$c_asig')";
		$insert=mysql_query("insert into AsignacionMesasTICtmp (prof,agrupamiento,c_asig) values ('$profer[0]','$acumula','$c_asig')") or die ("error al insertar");
	}
	//ahora vamos a por los diferentes alumnos de cada agrupamiento.
	$ag=mysql_query("select distinct agrupamiento,c_asig from AsignacionMesasTICtmp where prof='$profer[0]'") or die ("no toma asignaciontictmp");
	while ($agr=mysql_fetch_array($ag)){
		$casig=$agr[1].':';
		$trozo=explode(":",$agr[0]);
		$total=count($trozo)-1;
		//// echo$total;
		if ($total=='2')
		{//// echo$trozo[0].$trozo[1];
			//// echo"ASIGNATURAS CON DOS GRUPOS<BR>";
			$comb=mysql_query("select distinctrow alma.claveal,alma.unidad,FALUMNOS.NC from alma,FALUMNOS where alma.CLAVEAL=FALUMNOS.CLAVEAL and (alma.combasi like '%$casig%') and (alma.unidad='$trozo[0]' or alma.unidad='$trozo[1]') order by alma.unidad") or die ("error");

			while($combr=mysql_fetch_array($comb)){
				if($combr[2]>'0' and $combr[2]<='19'){$no_mesa1=$combr[2];
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				//// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'19' and $combr[2]<='38'){$no_mesa1=$combr[2]-19;
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				//// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'38'){$no_mesa1=$combr[2]-38;
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				//// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				else {$no_mesa=$combr[2];
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
			}
		}
		elseif ($total=='1')
		{//// echo$trozo[0].$trozo[1];
			// echo"ASIGNATURAS CON UN GRUPO<BR>";
			$comb=mysql_query("select distinctrow alma.claveal,alma.unidad,FALUMNOS.NC from alma,FALUMNOS where alma.CLAVEAL=FALUMNOS.CLAVEAL and (alma.combasi like '%$casig%') and alma.unidad='$trozo[0]' order by alma.unidad") or die ("error");
			while($combr=mysql_fetch_array($comb)){
				if($combr[2]>'0' and $combr[2]<='19'){
					$no_mesa1=$combr[2];
					if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
					else {$no_mesa=$no_mesa1;}
					// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
					$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'19' and $combr[2]<='38'){
					$no_mesa1=$combr[2]-19;
					if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
					else {$no_mesa=$no_mesa1;}
					// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
					$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'38'){
				$no_mesa1=$combr[2]-38;
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
			}
		}
		elseif ($total=='3')
		{//// echo$trozo[0].$trozo[1];
			// echo"ASIGNATURAS CON TRES GRUPOS<BR>";
			$comb=mysql_query("select distinctrow alma.claveal,alma.unidad,FALUMNOS.NC from alma,FALUMNOS where alma.CLAVEAL=FALUMNOS.CLAVEAL and (alma.combasi like '%$casig%') and (alma.unidad='$trozo[0]' or alma.unidad='$trozo[1]' or alma.unidad='$trozo[2]') order by alma.unidad") or die ("error");
			while($combr=mysql_fetch_array($comb)){
				if($combr[2]>'0' and $combr[2]<='19'){$no_mesa1=$combr[2];
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'19' and $combr[2]<='38'){$no_mesa1=$combr[2]-19;
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'38'){$no_mesa1=$combr[2]-38;
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				else {$no_mesa=$combr[2];
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
			}
		}
	}
}
mysql_query ("drop TABLE AsignacionMesasTICtmp");
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los Ordenadores TIC han sido asignados correctamente a los Alumnos.
</div></div><br />';
?>
<div align="center">
<input type="button" value="Volver atrás" name="boton" onclick="history.back(2)" class="btn btn-success" />
</div>
</div>
</body>
</html>