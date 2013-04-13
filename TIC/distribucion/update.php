<? 
$trozos=explode("-->",$alumno);
$codigo=$trozos[1];
     if ($posicion=='Absentista' or $posicion=='Sin asignación'){    
     	$upd=mysql_query("update AsignacionMesasTIC set no_mesa='00' where prof='$profe' and CLAVEAL='$codigo' and agrupamiento='$curso1'");
}
     else{
    $upd=mysql_query("update AsignacionMesasTIC set no_mesa='$posicion' where prof='$profe' and CLAVEAL='$codigo' and agrupamiento='$curso1'");
    // echo "update AsignacionMesasTIC set no_mesa='$posicion' where prof='$profe' and CLAVEAL='$codigo' and agrupamiento='$curso1'";
	}
	?>
