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


if (isset($_POST['enviar'])) {
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
	$mail->IsHTML(true);
	$mail->Subject = $_POST['tema'];
	$mail->Body = $_POST['texto'];

	foreach($_POST as $var => $valor) {
		$dni=$var;
		$cambia[$dni]=$valor;
	}

	foreach($cambia as $eldni => $valor){
		$mail0=mysql_query("select correo, PROFESOR from c_profes where dni='$eldni'");
		$mail1=mysql_fetch_row($mail0);
		$direccion = $mail1[0];
		$profes = $mail1[1];
		$mail->AddAddress($direccion, $profes);
	}

	for ($i=1;$i<6;$i++) {
		$varname{$i} = $_FILES['fil'.$i]['name'];
		$vartemp{$i} = $_FILES['fil'.$i]['tmp_name'];
		if ($varname != "") {
			$mail->AddAttachment($vartemp{$i}, $varname{$i});
		}
	}

	if(!$mail->Send()) {
		$msg_class = "alert-error";
		$msg = "Error: " . $mail->ErrorInfo;
	} else {
		$msg_class = "alert-success";
		$msg = "El mensaje ha sido enviado.";
	}
}


$page_header = "Enviar correo electrónico";
include("../../menu.php");
include("menu.php");
?>

<div class="container-fluid">

<div class="page-header" align="center">
<h2>Mensajes <small><?php echo $page_header; ?></small></h2>
</div>

<div class="row-fluid">

<form name="cargos" method="post" enctype="multipart/form-data"
	role="form">
<div class="span12">
<button type="submit" class="btn btn-primary" name="enviar">Enviar
correo</button>
<a href="index.php" class="btn btn-default">Cancelar</a></div>

<br>
<br>
<br>

<?php if($msg): ?>
<div class="alert <?php echo $msg_class; ?> alert-block"><?php echo $msg; ?>
</div>
<?php endif; ?>

<div class="row-fluid">

<div class="span7"><input type="text" class="input-block-level"
	name="tema" placeholder="Asunto del correo"> <br />
<textarea class="input-block-level" name="texto" rows="10"></textarea>
<br>
<br>

<div class="well">
<fieldset id="fiel"><legend class="text-warning">Archivos adjuntos <small>(5
archivos máximo)</small></legend> <input type="button"
	class="btn btn-success" value="Añadir archivo adjunto"
	onclick="crear(this)"> <br>
<br>
</fieldset>
</div>

</div>

<div class="span5">

<div class="well">
	<a href="javascript:seleccionar_todo()"	class="btn btn-small btn-info">Todos</a>&nbsp;
	<a href="javascript:seleccionar_tutor()" class="btn btn-small btn-info">Tutores</a>&nbsp;
	<a href="javascript:seleccionar_jd()" class="btn btn-small btn-info">J.de Departamento</a>&nbsp;
	<a href="javascript:seleccionar_ca()" class="btn btn-small btn-info">C. de Área</a>&nbsp;
	<a href="javascript:seleccionar_ed()" class="btn btn-small btn-info">Dirección</a>
<br>
<br>

<div class="accordion" id="departamentos">

<?php
$result = mysql_query("select distinct departamento from departamentos where departamento not like '%conserje%' order by departamento");
$i=0;
while ($departamento = mysql_fetch_array($result)):
?>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#departamentos" href="#departamento<?php echo $i; ?>">
        <span class="text-warning"><?php echo $departamento['departamento']; ?></span>
      </a>
    </div>
    <div id="departamento<?php echo $i; ?>" class="accordion-body collapse <?php if($i==0) echo 'in'; ?>">
      <div class="accordion-inner">
  
<?php
    $profesores = mysql_query("SELECT distinct profesor, c_profes.dni, correo, cargo FROM c_profes, departamentos WHERE departamentos.idea = c_profes.idea AND departamento='$departamento[0]' AND correo IS NOT NULL ORDER BY profesor");
    
    if(mysql_num_rows($profesores)>0):
    
        while($profesor = mysql_fetch_array($profesores)):
	         $pro = $profesor[0];
	         $dni = $profesor[1];
	         $correo = $profesor[2];
	         $perf = $profesor[3];
	         $n_i = $n_i + 1;
?>        
        <label class="checkbox">
           <input type="checkbox" name="<? echo $dni;?>" value="cambio" id="dato0"> <?php echo $pro; ?>
        </label>
        <input type="hidden" name="<? echo $dni.":".$perf;?>" value="<? echo $perf;?>">
<?php
		endwhile;
	else:
?>
	     <p class="muted">No hay profesores en este departamento</p>
<?php
	endif;
?>

</div>
</div>
</div>
	<?php
	$i++;
	endwhile;
	?></div>
</div>

</div>

</div>

</form>

</div>

</div>


	<?php include('../../pie.php'); ?>

<script>

function seleccionar_todo(){
	for (i=0;i<document.cargos.elements.length;i++)
		if(document.cargos.elements[i].type == "checkbox")	
			document.cargos.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.cargos.elements.length;i++)
		if(document.cargos.elements[i].type == "checkbox")	
			document.cargos.elements[i].checked=0
}
function seleccionar_tutor(){
for (i=0;i<document.cargos.elements.length;i++){
		if(document.cargos.elements[i].type == "hidden"){
		valorCasilla = document.cargos.elements[i].value;		
		valorReal = valorCasilla.indexOf("2");
		if(valorReal >= "0"){
			document.cargos.elements[i-1].checked=1;
}
}
}
}
function seleccionar_jd(){
	for (i=0;i<document.cargos.elements.length;i++){
		if(document.cargos.elements[i].type == "hidden"){
		valorCasilla = document.cargos.elements[i].value;		
		valorReal = valorCasilla.indexOf("4");
		if(valorReal >= "0"){
			document.cargos.elements[i-1].checked=1;
}
}
}
}
function seleccionar_ed(){
	for (i=0;i<document.cargos.elements.length;i++){
		if(document.cargos.elements[i].type == "hidden"){
		valorCasilla = document.cargos.elements[i].value;		
		valorReal = valorCasilla.indexOf("1");
		if(valorReal >= "0"){
			document.cargos.elements[i-1].checked=1;
}
}
}
}
function seleccionar_ca(){
	for (i=0;i<document.cargos.elements.length;i++){
		if(document.cargos.elements[i].type == "hidden"){
		valorCasilla = document.cargos.elements[i].value;		
		valorReal = valorCasilla.indexOf("9");
		if(valorReal >= "0"){
			document.cargos.elements[i-1].checked=1;
}
}
}
}

num=0;
function crear(obj) {
  if(num<5) {
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
	  ele.className = 'btn btn-danger';
	  ele.value = 'Borrar'; // 8
	  ele.name = 'div'+num; // 8
	  ele.onclick = function () {borrar(this.name)} // 9
	  contenedor.appendChild(ele); // 7
	  num++;
  }
}
function borrar(obj) {
  fi = document.getElementById('fiel'); // 1 
  fi.removeChild(document.getElementById(obj)); // 10
  num--;
}
</script>
<!-- TinyMCE -->
<script
	src="//<?php echo $dominio; ?>/intranet/js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
        selector: "textarea",
        language: "es",
        plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor filemanager"
            ],

        toolbar1: "bold italic underline strikethrough | forecolor backcolor  | alignleft aligncenter alignright alignjustify | outdent indent blockquote | bullist numlist",
        toolbar2: "cut copy paste | link unlink image media | emoticons",
        
        relative_urls: false,
        filemanager_title:"Administrador de archivos",
        external_filemanager_path:"../../filemanager/",
        external_plugins: { "filemanager" : "../../filemanager/plugin.min.js"},
        

        menubar: false,
        statusbar: false
});

<!-- /TinyMCE -->
</script>
</body>
</html>
