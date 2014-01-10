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
?>
 <!DOCTYPE html>  
<html lang="es">  
  <head>  
    <meta charset="iso-8859-1">  
    <title>Intranet</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta name="description" content="Intranet del http://<? echo $nombre_del_centro;?>/">  
    <meta name="author" content="">  
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.min.css" rel="stylesheet">    
    <link href="http://<? echo $dominio;?>/intranet/css/datepicker.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/DataTable.bootstrap.css" rel="stylesheet">    
    <link href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css" rel="stylesheet" >
    <link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
    
<script>

function seleccionar_todo(){
	for (i=0;i<document.Cargos.elements.length;i++)
		if(document.Cargos.elements[i].type == "checkbox")	
			document.Cargos.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.Cargos.elements.length;i++)
		if(document.Cargos.elements[i].type == "checkbox")	
			document.Cargos.elements[i].checked=0
}
function seleccionar_tutor(){
for (i=0;i<document.Cargos.elements.length;i++){
		if(document.Cargos.elements[i].type == "hidden"){
		valorCasilla = document.Cargos.elements[i].value;		
		valorReal = valorCasilla.indexOf("2");
		if(valorReal >= "0"){
			document.Cargos.elements[i-1].checked=1;
}
}
}
}
function seleccionar_jd(){
	for (i=0;i<document.Cargos.elements.length;i++){
		if(document.Cargos.elements[i].type == "hidden"){
		valorCasilla = document.Cargos.elements[i].value;		
		valorReal = valorCasilla.indexOf("4");
		if(valorReal >= "0"){
			document.Cargos.elements[i-1].checked=1;
}
}
}
}
function seleccionar_ed(){
	for (i=0;i<document.Cargos.elements.length;i++){
		if(document.Cargos.elements[i].type == "hidden"){
		valorCasilla = document.Cargos.elements[i].value;		
		valorReal = valorCasilla.indexOf("1");
		if(valorReal >= "0"){
			document.Cargos.elements[i-1].checked=1;
}
}
}
}
function seleccionar_ca(){
	for (i=0;i<document.Cargos.elements.length;i++){
		if(document.Cargos.elements[i].type == "hidden"){
		valorCasilla = document.Cargos.elements[i].value;		
		valorReal = valorCasilla.indexOf("9");
		if(valorReal >= "0"){
			document.Cargos.elements[i-1].checked=1;
}
}
}
}
</script>
<script type="text/javascript">
<!--
num=0;
function crear(obj) {
  num++;
  fi = document.getElementById('fiel'); // 1
  contenedor = document.createElement('div'); // 2
  contenedor.id = 'div'+num; // 3
  fi.appendChild(contenedor); // 4

  ele = document.createElement('input'); // 5
  ele.type = 'file'; // 6
  ele.name = 'fil'+num; // 6
  contenedor.appendChild(ele); // 7
  
  ele = document.createElement('input'); // 5
  ele.type = 'button'; // 6
  ele.value = 'Borrar'; // 8
  ele.name = 'div'+num; // 8
  ele.onclick = function () {borrar(this.name)} // 9
  contenedor.appendChild(ele); // 7
}
function borrar(obj) {
  fi = document.getElementById('fiel'); // 1 
  fi.removeChild(document.getElementById(obj)); // 10
}
--> 
</script>

</head>
<body>
<?
include("../../menu_solo.php");
include("menu.php");
?>

<div align="center">
<div class="page-header">
  <h2>Correo del Centro <small>Envío de Correo a los Profesores</small></h2>
</div>
<br />

<?
if (isset($_POST['enviar'])){$enviar=$_POST['enviar'];}else{$enviar='';}
if ($enviar=="Enviar") {
$profe_envia = $_SESSION['profi'];
$cor_pr = mysql_query("select correo from c_profes where profesor = '$profe_envia'");
$cor_pr0 = mysql_fetch_array($cor_pr);
$mail_from = $cor_pr0[0];
require("../../lib/class.phpmailer.php");
$mail = new PHPMailer();		
$mail->Host = "localhost";
$mail->From = $mail_from;
$mail->FromName = $profe_envia;
$mail->Sender = $mail_from;
$mail->Subject = $tema;
$mail->Body = $texto;

foreach($_POST as $var => $valor)
{
if ($valor!='Enviar'){
$dni=$var;
$cambia[$dni]=$valor;
} 
} 

foreach($cambia as $eldni => $valor){
$mail0=mysql_query("select correo, PROFESOR from c_profes where dni='$eldni'");
$mail1=mysql_fetch_row($mail0);
$direccion = $mail1[0];
$profes = $mail1[1];
$mail->AddAddress($direccion, $profes);	
}
for ($i=1;$i<6;$i++)
{
	$varname{$i} = $_FILES['fil'.$i]['name'];
	$vartemp{$i} = $_FILES['fil'.$i]['tmp_name'];
	if ($varname != "") {
        $mail->AddAttachment($vartemp{$i}, $varname{$i});
    }
}

$mail->Send();
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El correo se ha enviado correctamente a los profesores seleccionados.            
          </div></div>';
} 

?>
<form name="Cargos" action="correo.php" method="post" enctype="multipart/form-data">
<div class="container-fluid">
<div class="row-fluid">
<div class="span4 offset2">
<div class="well" align="left">
<label>Asunto:<br />
 <textarea name="tema" style="width:97%"><? echo $tema;?></textarea>
 </label>
 <hr>
 <label>
Texto:<br />
<textarea name="texto" rows="8" style="width:97%"><? echo $texto;?></textarea>
</label>
<hr>
<label>
Adjunto:
<fieldset id="fiel">
<input type="button" class="btn btn-success btn-mini" value="Añadir archivo adjunto" onclick="crear(this)" /> (5 archivos como máximo)
</fieldset>
</label>
<hr>
<label>Marcar destinatarios;</label>
<a href="javascript:seleccionar_todo()" class="btn  btn-mini btn-primary">Todos</span></a>
<a href="javascript:seleccionar_tutor()" class="btn  btn-mini btn-primary">Tutores</span></a>
<a href="javascript:seleccionar_jd()" class="btn  btn-mini btn-primary">J. de Departamento</span></a>
<a href="javascript:seleccionar_ca()" class="btn  btn-mini btn-primary">C. de Área</span></a>
<a href="javascript:seleccionar_ed()" class="btn  btn-mini btn-primary">Dirección</span></a>
<br /><br />
<a href="javascript:deseleccionar_todo()" class="btn btn-danger btn-mini">Desmarcarlos todos</span></a>
 </div>
</div>
<div class="span4">
<table class="table table-striped table-bordered" style="width:auto">
<?
$dep0=mysql_query("select distinct departamento from departamentos where departamento not like '%admin%' and departamento not like '%conserje%' order by departamento");
while ($dep=mysql_fetch_array($dep0)) {
echo "<tr><td colspan='3' style='color:#f5f5f5;background-color:#555' align='center'>$dep[0]</td></tr>";
$carg0=mysql_query("select distinct profesor, c_profes.dni, correo, cargo from c_profes, departamentos where departamentos.idea = c_profes.idea and departamento='$dep[0]' and correo is not NULL order by profesor");
$num_profes=mysql_num_rows($carg0);
while($carg1=mysql_fetch_array($carg0))
{
$pro=$carg1[0];
$dni=$carg1[1];
$correo=$carg1[2];
$perf=$carg1[3];
$n_i=$n_i+1;
?>
<tr>
<td><? echo $pro;?></td> 
  <td align="center"><input type="checkbox" name="<? echo $dni;?>" value="cambio" id="dato0" />
  <input type="hidden" name="<? echo $dni.":".$perf;?>" value="<? echo $perf;?>" /></td>
  
</tr>
<?
}
}
?>
</td></tr>
</table>

<input type="submit" name="enviar" value="Enviar" class="btn btn-primary" />
</form>
</div>
</body>
</html>