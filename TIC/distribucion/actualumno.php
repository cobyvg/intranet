<? 
foreach($_POST['checkbox'] AS $clave)
{
	$trozos=explode("_",$clave);
	$clave_nc=explode("-",$trozos[1]);
	$claveal=$clave_nc[0];
	$nc=$clave_nc[1];
	//asigno por defecto el no_mesa dependiendo de su nc
	if (strlen($nc)=='1'){$no_mesa='0'.$nc;}
	elseif($nc>'15' and $nc<='30'){$no_mesa1=$nc-15;
	if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
	else {$no_mesa=$no_mesa1;}
	}
	elseif($nc>'30'){$no_mesa1=$nc-30;
	if (strlen($no_mesa1)=='1'){$no_mesa='0'.$no_mesa1;}
	else {$no_mesa=$no_mesa1;}
	}
	else {$no_mesa=$nc;}
	if($trozos[0]=="SI"){
		mysql_query("update AsignacionMesasTIC set no_mesa='$no_mesa' where prof='$profe' and agrupamiento='$agrupamiento' and c_asig = '$asig' and CLAVEAL='$claveal'") or die ("No se han podido actualizar las listas de los alumnos admitidos<br>");
	$si+ mysql_affected_rows();
	}
	//los alumnos que no son de tu agrupamiento se marcan como no_mesa=' '
	else{  
		mysql_query("update AsignacionMesasTIC set no_mesa=' ' where prof='$profe' and agrupamiento='$agrupamiento' and c_asig = '$asig' and CLAVEAL='$claveal'")  or die ("No se han podido actualizar las listas de los alumnos excluídos");
	$no+=mysql_affected_rows();
	}
}
if ($si > 0 OR $no > 0) {
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La distribución de alumnos ha sido actualizada.
</div></div>';
}
else{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h5>ATENCIÓN:</h5>
La distribución no ha sido modificada porque nos has seleccionado nada.
</div></div>';
}
?>
