<?php
//		
// Importación del horario a partir del XML que se exporta desde Horwin
//

		$N_DIASEMANA=$codigos->item(0)->nodeValue;
		if (strlen($N_DIASEMANA)>4) {
			$COD_PROF = $N_DIASEMANA;
			$num_prof+=1;
		}
		elseif (strlen($N_DIASEMANA)==1){
			$DIASEMANA = $N_DIASEMANA;
		}

		if (strlen($codigos->item(1)->nodeValue)<9 and strlen($codigos->item(1)->nodeValue)>0) {
			$X_TRAMO=$codigos->item(1)->nodeValue;
		}
		else{
			$X_TRAMO="";
		}

		$X_DEPENDENCIA=$codigos->item(2)->nodeValue;

		if ($codigos->item(3)->nodeValue!=="") {
				
			$X_UNIDAD=$codigos->item(3)->nodeValue;
				
			$X_OFERTAMATRIG=$codigos->item(4)->nodeValue;

			if ($codigos->item(5)->nodeValue =="") {
				$X_MATERIAOMG="";
			}
			else
			{
				$X_MATERIAOMG=$codigos->item(5)->nodeValue;
			}

		}

		$F_INICIO=$codigos->item(6)->nodeValue;
		$F_FIN=$codigos->item(7)->nodeValue;
		$N_HORINI=$codigos->item(8)->nodeValue;
		$N_HORFIN=$codigos->item(9)->nodeValue;
		$X_ACTIVIDAD=$codigos->item(10)->nodeValue;

		if (strlen($codigos->item(1)->nodeValue)<9 and strlen($codigos->item(1)->nodeValue)>0) {
			$n_i+=1;

			$tramos = mysql_query("select hora from tramos where tramo = '$X_TRAMO'");
			$tramo = mysql_fetch_row($tramos);

			$nom_prof = mysql_query("select concat(ape1profesor,' ',ape2profesor,', ',nomprofesor) from profesores_seneca where idprofesor = '$COD_PROF'");
			$nom_profe = mysql_fetch_row($nom_prof);
			$nombre_profesor = $nom_profe[0];

			if ($codigos->item(3)->nodeValue!=="") {
				$unid = mysql_query("select nomunidad from unidades where idunidad = '$X_UNIDAD'");
				$unidad = mysql_fetch_row($unid);
				$grupo = $unidad[0];
			}
			else{
				$grupo="";
			}

			$nombre_asignatura="";
			$abrev = "";
			$codigo_asig="";

			if ($codigos->item(3)->nodeValue == "" or $codigos->item(5)->nodeValue =="") {

				$activ = mysql_query("select nomactividad, idactividad from actividades_seneca where idactividad = '$X_ACTIVIDAD'");
				$activida = mysql_fetch_row($activ);
				$nombre_asigna = $activida[0];
				$idactividad = $activida[1];
				$nombre_asignatura = $activida[0];
				
				$nombre_asigna = str_replace(" de "," ",$nombre_asigna);
				$nombre_asigna = str_replace("/","",$nombre_asigna);
				$nombre_asigna = str_replace(" y "," ",$nombre_asigna);
				$nombre_asigna = str_replace(" á"," a",$nombre_asigna);
				$nombre_asigna = str_replace(" a "," ",$nombre_asigna);
				$nombre_asigna = str_replace(" la "," ",$nombre_asigna);
				$nombre_asigna = str_replace("(","",$nombre_asigna);
				$nombre_asigna = str_replace(")","",$nombre_asigna);

				$codigo_asig = $X_ACTIVIDAD;

				$tr_abrev = explode(" ",$nombre_asigna);

				$letra1 = strtoupper(substr($tr_abrev[0],0,1));
				$letra2 = strtoupper(substr($tr_abrev[1],0,1));
				$letra3 = strtoupper(substr($tr_abrev[2],0,1));
				$letra4 = strtoupper(substr($tr_abrev[3],0,1));


				$abrev = $letra1.$letra2.$letra3.$letra4;

			}
			else{
				$nom_asig = mysql_query("select abrev, nombre from asignaturas where codigo = '$X_MATERIAOMG' and abrev not like '%\_%'");
				$nom_asigna = mysql_fetch_row($nom_asig);
				$abrev = $nom_asigna[0];
				$nombre_asignatura = $nom_asigna[1];
				$codigo_asig = $X_MATERIAOMG;
			}


			$sql = "INSERT INTO `horw` VALUES('$n_i', '$DIASEMANA', '$tramo[0]', '$abrev', '$nombre_asignatura', '$codigo_asig', '$nombre_profesor', '$num_prof', '$COD_PROF', '$X_DEPENDENCIA', '$X_DEPENDENCIA', '$grupo', '', '', '')";
			mysql_query($sql);
			
			//echo "$sql<br>";
		}
		
//
// Fin de la Importación del horario.		
//
//echo Tarari;
	?>