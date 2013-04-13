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
	$diahora=mysql_query("select distinct dia,hora,c_asig from horw where prof = '$profer[0]' and c_asig<>''") or die ("fallo al tomar dia hora del profe");

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
//echo "insert into AsignacionMesasTICtmp (prof,agrupamiento,c_asig) values ('$profer[0]','$acumula','$c_asig')<br>";
	}
	//ahora vamos a por los diferentes alumnos de cada agrupamiento.
	$ag=mysql_query("select distinct agrupamiento,c_asig from AsignacionMesasTICtmp where prof='$profer[0]'") or die ("no toma asignaciontictmp");
	while ($agr=mysql_fetch_array($ag)){
		if (is_numeric($agr[1])) {
		$casig=$agr[1].':';
		$trozo=explode(":",$agr[0]);
		$total=count($trozo)-1;
		if ($total=='2')
		{//// echo$trozo[0].$trozo[1];
			//// echo"ASIGNATURAS CON DOS GRUPOS<BR>";
			$comb=mysql_query("select distinctrow alma.claveal,alma.unidad,FALUMNOS.NC from alma,FALUMNOS where alma.CLAVEAL=FALUMNOS.CLAVEAL and (alma.combasi like '%$casig%') and (alma.unidad='$trozo[0]' or alma.unidad='$trozo[1]') order by alma.unidad") or die ("error 2");


			while($combr=mysql_fetch_array($comb)){
				if($combr[2]>'0' and $combr[2]<='15'){$no_mesa1=$combr[2];
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				//// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				
				}
				elseif($combr[2]>'15' and $combr[2]<='30'){$no_mesa1=$combr[2]-15;
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				//// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'30'){$no_mesa1=$combr[2]-30;
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
			$comb=mysql_query("select distinctrow alma.claveal,alma.unidad,FALUMNOS.NC from alma,FALUMNOS where alma.CLAVEAL=FALUMNOS.CLAVEAL and (alma.combasi like '%$casig%') and alma.unidad='$trozo[0]' order by alma.unidad") or die ("error 1");
			while($combr=mysql_fetch_array($comb)){
				if($combr[2]>'0' and $combr[2]<='15'){
					$no_mesa1=$combr[2];
					if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
					else {$no_mesa=$no_mesa1;}
					// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
					$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'15' and $combr[2]<='30'){
					$no_mesa1=$combr[2]-15;
					if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
					else {$no_mesa=$no_mesa1;}
					// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
					$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'30'){
				$no_mesa1=$combr[2]-30;
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
			}
		}
		elseif ($total == '3')
		{//// echo$trozo[0].$trozo[1];
			// echo"ASIGNATURAS CON TRES GRUPOS<BR>";
			$comb=mysql_query("select distinctrow alma.claveal,alma.unidad,FALUMNOS.NC from alma,FALUMNOS where alma.CLAVEAL=FALUMNOS.CLAVEAL and (alma.combasi like '%$casig%') and (alma.unidad='$trozo[0]' or alma.unidad='$trozo[1]' or alma.unidad='$trozo[2]') order by alma.unidad") or die ("error 3");
			while($combr=mysql_fetch_array($comb)){
				if($combr[2]>'0' and $combr[2]<='15'){$no_mesa1=$combr[2];
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'15' and $combr[2]<='30'){$no_mesa1=$combr[2]-15;
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'30'){$no_mesa1=$combr[2]-30;
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
		elseif ($total == '4')
		{//// echo$trozo[0].$trozo[1];
			// echo"ASIGNATURAS CON TRES GRUPOS<BR>";
			$comb=mysql_query("select distinctrow alma.claveal,alma.unidad,FALUMNOS.NC from alma,FALUMNOS where alma.CLAVEAL=FALUMNOS.CLAVEAL and (alma.combasi like '%$casig%') and (alma.unidad='$trozo[0]' or alma.unidad='$trozo[1]' or alma.unidad='$trozo[2]' or alma.unidad='$trozo[3]') order by alma.unidad") or die ("error 4");
			while($combr=mysql_fetch_array($comb)){
				if($combr[2]>'0' and $combr[2]<='15'){$no_mesa1=$combr[2];
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'15' and $combr[2]<='30'){$no_mesa1=$combr[2]-15;
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'30'){$no_mesa1=$combr[2]-30;
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
		elseif ($total == '5')
		{//// echo$trozo[0].$trozo[1];
			// echo"ASIGNATURAS CON TRES GRUPOS<BR>";
			$comb=mysql_query("select distinctrow alma.claveal,alma.unidad,FALUMNOS.NC from alma,FALUMNOS where alma.CLAVEAL=FALUMNOS.CLAVEAL and (alma.combasi like '%$casig%') and (alma.unidad='$trozo[0]' or alma.unidad='$trozo[1]' or alma.unidad='$trozo[2]' or alma.unidad='$trozo[3]' or alma.unidad='$trozo[4]') order by alma.unidad") or die ("error 5");

			while($combr=mysql_fetch_array($comb)){
				if($combr[2]>'0' and $combr[2]<='15'){$no_mesa1=$combr[2];
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'15' and $combr[2]<='30'){$no_mesa1=$combr[2]-15;
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'30'){$no_mesa1=$combr[2]-30;
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
		elseif ($total == '6')
		{//// echo$trozo[0].$trozo[1];
			// echo"ASIGNATURAS CON TRES GRUPOS<BR>";
			$comb=mysql_query("select distinctrow alma.claveal,alma.unidad,FALUMNOS.NC from alma,FALUMNOS where alma.CLAVEAL=FALUMNOS.CLAVEAL and (alma.combasi like '%$casig%') and (alma.unidad='$trozo[0]' or alma.unidad='$trozo[1]' or alma.unidad='$trozo[2]' or alma.unidad='$trozo[3]' or alma.unidad='$trozo[4]' or alma.unidad='$trozo[5]') order by alma.unidad") or die ("error 6");
			while($combr=mysql_fetch_array($comb)){
				if($combr[2]>'0' and $combr[2]<='15'){$no_mesa1=$combr[2];
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'15' and $combr[2]<='30'){$no_mesa1=$combr[2]-15;
				if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
				else {$no_mesa=$no_mesa1;}
				// echo$profer[0].'-->'.$agr[0].'-->'.$agr[1].'-->'.$combr[0].'-->'.$combr[1].'-->'.$no_mesa.'<br>';
				$insert=mysql_query("insert into AsignacionMesasTIC (prof,c_asig,agrupamiento,CLAVEAL,no_mesa) values ('$profer[0]','$agr[1]','$agr[0]','$combr[0]','$no_mesa')") or die ("error al insertar");
				}
				elseif($combr[2]>'30'){$no_mesa1=$combr[2]-30;
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
}
mysql_query ("drop TABLE AsignacionMesasTICtmp");
?>
<p id='texto_en_marco'>Los Ordenadores TIC han sido asignados correctamente a los Alumnos.</p>