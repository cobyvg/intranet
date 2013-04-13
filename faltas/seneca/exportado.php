<?php
$falta_inicial0 = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
$falta_final0 = "$fecha10[2]-$fecha10[1]-$fecha10[0]";

$faltas0 = "select fecha, claveal, falta, hora from FALTAS where date(fecha) >= '$falta_inicial0' and date(fecha) <= '$falta_final0' and nivel = '$nivel' and grupo = '$grupo' and falta = 'F' order by fecha desc";
$faltas1 = mysql_query($faltas0) or die("No se ha podido abrir la Tabla de Faltas");	
while ($faltas = mysql_fetch_array($faltas1)) 
{	
$fecha20 = explode("-",$faltas[0]); 
$fecha = "$fecha20[2]/$fecha20[1]/$fecha20[0]";
$claveal0 = "select claveal1 from alma where claveal = '$faltas[1]'";
//echo $claveal0;
$claveal1 = mysql_query($claveal0);
$claveal2 = mysql_fetch_array($claveal1);
$claveal = $claveal2[0];
$tramos0 = "select hora, tramo from tramos where hora = '$faltas[3]'";
//echo $tramos0;
$tramos1 = mysql_query($tramos0);
$tramos2 = mysql_fetch_array($tramos1) or die("No se ha podido abrir la tabla tramos");
$tramo = $tramos2[1];
$faltas_asistencia = "<FALTAS_ASISTENCIA>";
$faltas_asistencia_fin = "</FALTAS_ASISTENCIA>";
$texto = "	
			     <FALTA_ASISTENCIA>
                   <F_FALASI>$fecha</F_FALASI>
                   <X_TRAMO>$tramo</X_TRAMO>
                   <C_TIPFAL>I</C_TIPFAL>
                   <L_DIACOM>N</L_DIACOM>
			     </FALTA_ASISTENCIA>";
$xml2 = file_get_contents("exportado/".$fichero."");
$id11 = strstr ($xml2, $claveal);
$inicio11 = substr($xml2,0,strlen($xml2)-strlen($id11));
//echo htmlentities($inicio1). "<br>";
$asig = strstr ($id11, $faltas_asistencia);
$inicio22 = substr($id11,0,strlen($id11)-strlen($asig));
$asig2 = substr ($asig, 0, 70); // 53
$asig3 = substr ($asig, 10, 70); // 53

$inicio33 = str_replace("<FALTAS_ASISTENCIA>", "<FALTAS_ASISTENCIA>" . $texto ,$asig2);
$inicio44 = substr ($asig,70);	// 53
$total_exportado = $inicio11 . $inicio22 . $inicio33 . $inicio44;

$fp1=fopen("exportado/".$fichero."","w");
$pepito2=fwrite($fp1,$total_exportado);

fclose ($fp1);
}
?>

