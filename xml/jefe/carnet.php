<?
ini_set("memory_limit","1024M");
session_start();
include("../../config.php");
// Conexión con MySql
mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db);
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

if(!(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'2') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?
include_once ("../../funciones.php");
//variables();
require('../../pdf/fpdf.php');
################ Definimos la clase extendida PDF ########### 
class PDF extends FPDF {
	function fondoverde($x,$y) {
      $tam=8.4;
	  $div=0;
		 for ($n=1;$n<=10;$n+=1) {  #columnas
		   for ($s=1;$s<=6;$s+=1)	{	#fila
				if ($dib==1) {	$this->Image('./carnet/JUNTA3.jpg',$x,$y,$tam);}
				if ($dib==0) {	$this->Image('./carnet/JUNTA4.jpg',$x,$y,$tam);}
				if ($dib==0) {$dib=1;} else {$dib=0;}
		    	$y=$y+$tam; 
			}
		  if ($dib==0) {$dib=1;} else {$dib=0;}
		  $y=$y-6*$tam;
		  $x=$x+$tam;
		  }
				
	}

	function fondonaranja($x,$y) {
      $tam=8.4;
	  $dib=0;
		 for ($n=1;$n<=10;$n+=1) {  #columnas
		   for ($s=1;$s<=6;$s+=1)	{	#fila
				if ($dib==1) {	$this->Image('./carnet/JUNTA15.jpg',$x,$y,$tam);}
				if ($dib==0) {	$this->Image('./carnet/JUNTA16.jpg',$x,$y,$tam);}
				if ($dib==0) {$dib=1;} else {$dib=0;}
		    	$y=$y+$tam; 
			}
		  if ($dib==0) {$dib=1;} else {$dib=0;}
		  $y=$y-6*$tam;
		  $x=$x+$tam;
		  }
				
	}

	function uno($x,$y) {
      $tam=8.4;
	  $this->Image('./carnet/JUNTA14.jpg',$x+5*$tam,$y+$tam,$tam);
      $this->Image('./carnet/JUNTA14.jpg',$x+6*$tam,$y+2*$tam,$tam);
	  $this->Image('./carnet/JUNTA14.jpg',$x+6*$tam,$y+4*$tam,$tam);
	  $this->Image('./carnet/JUNTA13.jpg',$x+6*$tam,$y+$tam,$tam);
	  $this->Image('./carnet/JUNTA13.jpg',$x+6*$tam,$y+3*$tam,$tam);
	  $this->Image('./carnet/JUNTA13.jpg',$x+6*$tam,$y+5*$tam,$tam);
	}

	function dos($x,$y) {
      $tam=8.4;
	  $this->Image('./carnet/JUNTA14.jpg',$x+5*$tam,$y+$tam,$tam);
      $this->Image('./carnet/JUNTA14.jpg',$x+7*$tam,$y+$tam,$tam);
	  $this->Image('./carnet/JUNTA14.jpg',$x+5*$tam,$y+5*$tam,$tam);
      $this->Image('./carnet/JUNTA14.jpg',$x+7*$tam,$y+5*$tam,$tam);
	  $this->Image('./carnet/JUNTA13.jpg',$x+6*$tam,$y+$tam,$tam);
	  $this->Image('./carnet/JUNTA13.jpg',$x+7*$tam,$y+2*$tam,$tam);
	  $this->Image('./carnet/JUNTA13.jpg',$x+5*$tam,$y+4*$tam,$tam);
	  $this->Image('./carnet/JUNTA13.jpg',$x+6*$tam,$y+3*$tam,$tam);
	  $this->Image('./carnet/JUNTA13.jpg',$x+6*$tam,$y+5*$tam,$tam);
	}
	function tres($x,$y) {
      $tam=8.4;
	  $this->Image('./carnet/JUNTA14.jpg',$x+5*$tam,$y+$tam,$tam);
      $this->Image('./carnet/JUNTA14.jpg',$x+7*$tam,$y+$tam,$tam);
	  $this->Image('./carnet/JUNTA14.jpg',$x+5*$tam,$y+5*$tam,$tam);
      $this->Image('./carnet/JUNTA14.jpg',$x+7*$tam,$y+5*$tam,$tam);
	  $this->Image('./carnet/JUNTA14.jpg',$x+7*$tam,$y+3*$tam,$tam);
	  $this->Image('./carnet/JUNTA13.jpg',$x+6*$tam,$y+$tam,$tam);
	  $this->Image('./carnet/JUNTA13.jpg',$x+7*$tam,$y+2*$tam,$tam);
	  $this->Image('./carnet/JUNTA13.jpg',$x+7*$tam,$y+4*$tam,$tam);
	  $this->Image('./carnet/JUNTA13.jpg',$x+6*$tam,$y+3*$tam,$tam);
	  $this->Image('./carnet/JUNTA13.jpg',$x+6*$tam,$y+5*$tam,$tam);
	}
}

function codigo_control($x){
	$long=strlen($x);
	$sum=206;
	
    #  La fórmula para el cálculo del código de control es valida para restos menores a 95. Para restos entre 95 y 102 son:
	#  95-chr(187) ; 96-chr(133) ; 97-¿? ; 98-chr(192) ; 99-chr(195) ; 100-¿? ; 101-chr(140) ; 102-chr(156)
	#  Únicamente tengo los códigosa hasta el chr(211) y no encuentro los corresxpondientes al resto 97 y 100.
	#  Prueba a imprimirme el pdf con los códigos hasta el chr(255).
	
	for ($n=1;$n<=strlen($x);$n+=1) {
		$num=substr($x,$n-1,1);
		$sum=$sum+($n+1)*($num+16);
	}
	$codigo= $sum%103;
	if ($codigo==0) {
		return (chr(174));}
	elseif ($codigo < 91) {
		return (chr($codigo+32));}
	else {
		return (chr($codigo+70));
	}
}
############### Abrimos la base de datos y creamos la consulta
#mysql_select_db($database_intranet, $c);  #abre la base de datos
if (strlen($_POST['alumnos'])>0) {
		#elige selección múltiple
		$sel=explode("*",$_POST['alumnos']);
		foreach($sel as  $valor) {
			if (!isset($seleccion)) { $seleccion="'".$valor;}
			else {$seleccion=$seleccion."','".$valor;}		
		}
	$seleccion=$seleccion."'";
	$query_Recordset1 = "SELECT * FROM alma WHERE claveal In (".$seleccion.") ORDER BY Apellidos ASC";
	$opcion=2;
	}

	elseif (isset($_POST['select'])) {		#elige selección de un curso
	$selecc=trim($_POST['select']);
	$query_Recordset1 = "SELECT * FROM alma where Unidad = '" .$selecc ."' order by Apellidos ASC";
	}
	
	else {
		$query_Recordset1 = "SELECT * FROM alma order by Unidad,Apellidos"; #otro caso, es decir, todos los alumnos
}
$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error("No es posible conectar"));  #crea la consulata
$totalRows_Recordset1 = mysql_num_rows($Recordset1);  #cantidad de registros

$pdf=new PDF();
$curso='Curso '.$curso_actual;
$curso_an=substr($curso,6,4)+1;
$pdf->SetFillColor(255,255,255);
$pdf->AddPage();
$pdf->AddFont('c128ab');
$n=1; # carnet nº 1

while ($row_Recordset1 = mysql_fetch_array($Recordset1)){
$fecha = str_replace("/","-",$row_Recordset1[9]);
//$tr = explode("-",$fecha0);
//$fecha = "$tr[2]-$tr[1]-$tr[0]";
$claveal = $row_Recordset1[2];
$unidad = $row_Recordset1[16];
$apellidos = $row_Recordset1[17];
$nombre = $row_Recordset1[18];
//echo "$claveal --> $unidad --> $apellidos --> $nombre<br />";
########################### Comenzamos con los carnets

	#posición del carnet
	if ($n%2==1) {
		$y=10+(round($n/2)-1)*52;
		$x=10;}
	else {$x=96;}
	$fech_ano=substr($fecha,0,4);
	$fech_mes=substr($fecha,5,2);
	$naranja=0;
	
	if (isset($_POST['alumnos']) && isset($_POST['checkbox'])) { $pdf->fondoverde($x,$y);}

	elseif ($curso_an-$fech_ano>18) {
		$pdf->fondoverde($x,$y);
		$pdf->uno($x,$y); }
	elseif (($curso_an-$fech_ano==18) && ($fech_mes<4)) {
		$pdf->fondoverde($x,$y);
		$pdf->dos($x,$y); }
	elseif (($curso_an-$fech_ano==18) && ($fech_mes<6)) {
		$pdf->fondoverde($x,$y);
		$pdf->tres($x,$y); }
	else {
		$pdf->fondonaranja($x,$y);
		$naranja=1;}
	#Hasta aquí el fondo, ahora el texto:
	if ($naranja==1) {
		$pdf->Image('./carnet/junta62.jpg',$x+3,$y+4,24);
	    $pdf->Image('./carnet/Junta10.jpg',$x+57,$y+4,24);}
	else {
		$pdf->Image('./carnet/Junta6.jpg',$x+3,$y+4,24);
		$pdf->Image('./carnet/Junta10.jpg',$x+57,$y+4,24);}
	
		$longnie=strlen($claveal);
	    $dplz=0;
		if ($longnie<7) {$dplz=4;}

	$pdf->SetFont('Arial','B',7);
	$pdf->Text(33+$x,6+$y,$curso);
	$pdf->Rect(2+$x,12+$y,23,30,'F');
	#$pdf->Rect(46+$x,36+$y,33,11,F);
	$pdf->Rect(29+$x+$dplz,36+$y,52-$dplz,12,'F');

$result=mysql_query("SELECT datos, nombre FROM fotos WHERE nombre='$claveal.jpg'");
# Array con las posibles extensiones que puede haber
$fileExtension=".jpg";
$row = mysql_fetch_array($result);
if (mysql_num_rows($result)>0) {
	$foto_al = $fotos_dir."/".$row[1];
	# Creamos cada uno de los archivos
	file_put_contents($foto_al,$row[0], FILE_APPEND);
		if (file_exists($foto_al)) # Si existe la foto la imprime
 	  {
 	  	$pdf->Image($foto_al,2.5+$x,12.5+$y,22);
 	  	unlink($foto_al);
}
}

	$pdf->SetFont('c128ab','',40);
    $cadena= chr(124) . chr(172). $claveal . codigo_control($claveal) . chr(126);
    $pdf->Text(32+$x+$dplz,47+$y,$cadena);    
	$pdf->SetFont('Arial','',7);
   	$pdf->Text(28+$x,16+$y,'Nombre:');
	$pdf->Text(28+$x,21+$y,'Apellidos:');
	$pdf->Text(28+$x,26+$y,'Curso:');
	$pdf->Text(28+$x,33+$y,'Fecha de Nacimiento:');
#	$pdf->Text(60+$x,25+$y,'N.I.E.');
	$pdf->SetFont('Arial','B',9);
	$pdf->Text(42+$x,16+$y,$nombre);
	$pdf->Text(42+$x,21+$y,$apellidos);
	$pdf->Text(42+$x,26+$y,$unidad);
	$pdf->Text(58+$x,33+$y,$fecha);
#	$pdf->Text(60+$x,30+$y,);
#	$pdf->Text(60+$x,42+$y,$claveal);
	$pdf->SetFont('Arial','',7);
	$pdf->Text(5+$x,49+($y-2),'NIE: ');
    $pdf->SetFont('Arial','B',8);
	$pdf->Text(10+$x,49+($y-2),$claveal);

$n++;		#siguiente carnet
if ($n%10==1){		#cada 10 carnets empezamos en la página siguiente
	$pdf->AddPage();
	$n=1;
	}


}   #cuando termina un registro pasa al siguiente

$pdf->Output();

mysql_free_result($Recordset1);
?>
