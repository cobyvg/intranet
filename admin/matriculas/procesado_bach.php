<?php
	if ($_POST) {
		foreach ($_POST as $key=>$val){
			$n_curso = substr($curso, 0, 1);
			$curso_anterior = $n_curso-1;
			//echo "$key --> $val<br>";
			$tr = explode("-",$key);
			$id_submit = $tr[1];
			$col = $tr[0];
			if ($col == 'confirmado'){$con.=$id_submit." ";} 
			if ($col == 'revisado'){$revis.=$id_submit." ";}
			if ($col == "grupo_actual"){$val=strtoupper($val);}
		
			//Promocion	
			if ($col=='promociona'){
				if ($val=='2' or $val=='3') {
				// Resplado de datos modificados
				$n_promo = mysql_query("select promociona, repite, claveal from matriculas_bach where id = '$id_submit'");	
				$n_prom = mysql_fetch_array($n_promo);
				//echo $n_prom[0];
				if (!($n_prom[0]=='2') and !($n_prom[0]=='3') and $n_prom[1]<>1) {
				//echo $curso;	
				if ($curso == "2BACH") {
					
				$i2 = mysql_query("select itinierario1 from matriculas_bach where id = '$id_submit'");
				$i1 = mysql_fetch_array($i2);
				if ($i1[0]<1) {
				// Recolocamos datos porque no promociona.						
				mysql_query("insert into matriculas_bach_backup select * from matriculas_bach where id = '$id_submit'");
				$cambia_datos = "update matriculas_bach set curso = '1BACH' where id = '$id_submit'";
				mysql_query($cambia_datos);
				}				
				}
				elseif($curso == "1BACH"){
				$a_bd = substr($curso_actual,0,4);
				mysql_query("insert into matriculas_bach_backup select * from matriculas_bach where id = '$id_submit'");
				echo "insert into matriculas_bach_backup select * from matriculas_bach where id = '$id_submit'<br>";
				$ret_4 = mysql_query("select * from ".$db.$a_bd.".matriculas where claveal = '$n_prom[2]'");
				echo "select * from ".$db.$a_bd.".matriculas where claveal = '$n_prom[2]'<br>";
				$ret = mysql_fetch_array($ret_4);
				$sql="";				
				$sql = "insert into matriculas VALUES (''";
				for ($i = 1; $i < 63; $i++) {
					$sql.=", '$ret[$i]'";
				}
				$sql.=")";
				echo $sql."<br>";
				$n_afect = mysql_query($sql);
				mysql_query("delete from matriculas_bach where id='$id_submit'");
				echo "delete from matriculas_bach where id='$id_submit'<br>";
				}
				}
				}
				else{
					mysql_query("update matriculas_bach set promociona='$val' where id='$id_submit'");
				}
			}
			
			mysql_query("update matriculas_bach set $col = '$val' where id = '$id_submit'");
			mysql_query("update matriculas_bach set confirmado = '' where id = '$id_submit'");
			mysql_query("update matriculas_bach set revisado = '' where id = '$id_submit'");
		}
		
		$tr_con = explode(" ",$con);
		foreach ($tr_con as $clave){
			mysql_query("update matriculas_bach set confirmado = '1' where id = '$clave'");
		}
		$tr_con5 = explode(" ",$revis);
		foreach ($tr_con5 as $clave_revis){
			mysql_query("update matriculas_bach set revisado = '1' where id = '$clave_revis'");
		}
	}
	?>
	
	
	
	
	
	