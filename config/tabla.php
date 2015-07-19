<?php if($primera==1): ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="iso-8859-1">
	<title>Configuración de la Intranet</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/otros.css" rel="stylesheet">
	<link href="../css/bootstrap-responsive.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet" >

</head>
<body>

<style type="text/css">
	body {
		padding-top: 0 !important;
		margin-top: 0;
	}
</style>
<?php 
else:

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}

include("../menu.php");
endif; 
?>

<div class="container">
<div class="row">
<div class="page-header">
  <h2>Configuración de la Intranet <small> Datos básicos de la aplicación</small></h2>
</div>
<?php

//Raiz intranet

$raiz_intranet = __FILE__;
$exp_raiz_intranet = explode('intranet', $raiz_intranet);
$raiz_intranet = $exp_raiz_intranet[0].'intranet/';

if (isset($_POST['enviar'])){
	echo $mens; 
	echo $form;
}
if($mens_bd=="1"){
	echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
No se encuentra el archivo de configuracion <strong>config.php</strong> en el directorio <em>/opt/e-smith/</em>. Debes crearlo en primer lugar y conceder permiso de escritura al mismo.
          </div><br /><input type="button" value="Volver atrás" name="boton" onClick="history.back(1)" class="btn btn-inverse" /></div>';
}
?>
<form enctype="multipart/form-data" action="index.php" method="post" name="configura">
<fieldset class="form-group warning">

<div class="tabbable" style="margin-bottom: 18px;">

<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">Datos generales de la configuración</a></li>
<li><a href="#tab2" data-toggle="tab">Módulos de la Intranet</a></li>
<li><a href="#tab3" data-toggle="tab">Personal del Centro</a></li>
<li><a href="#tab4" data-toggle="tab">Base de Datos</a></li>
<li><a href="#tab5" data-toggle="tab">Sistema de Reservas</a></li>
</ul>

<div class="tab-content">

<div class="tab-pane fade in active" id="tab1">
<h3>Datos generales de la configuración</h3><br />

  <table class="table table-condensed table-bordered table-striped">
      <td class="col-sm-3">Dominio<span style='color:#9d261d'> (*)</span>
        </td>
      
      <td class="col-sm-4"><input type="text" class="form-control" name="dominio" <?php echo (isset($dominio)) ? 'value="'.$dominio.'"' : ''; ?> placeholder="iesmonterroso.org" maxlength="60" required></td>
      <td>Nombre del dominio contratado por el IES donde se encuentra la Intranet..</td>
    </tr>
    <tr>
      <td>Nombre del Centro<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="nombre_del_centro" <?php echo (isset($nombre_del_centro)) ? 'value="'.$nombre_del_centro.'"' : ''; ?> placeholder="I.E.S. Monterroso" maxlength="60" required></td>
      <td>Eso mismo.</td>
    </tr>
    <tr>
      <td>Nombre corto
        </td>
      <td><input type="text" class="form-control" name="nombre_corto" <?php echo (isset($nombre_corto)) ? 'value="'.$nombre_corto.'"' : ''; ?> placeholder="Monterroso" maxlength="20"></td>
      <td>Versi&oacute;n corta del anterior.</td>
    </tr>
    <tr>
      <td>Código  del Centro<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="codigo_del_centro"  <?php echo (isset($codigo_del_centro)) ? 'value="'.$codigo_del_centro.'"' : ''; ?> placeholder="29002885" maxlength="8" required></td>
      <td>Eso mismo.</td>
    </tr>
    <tr>
      <td>Email del Centro<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="email_del_centro" <?php echo (isset($email_del_centro)) ? 'value="'.$email_del_centro.'"' : ''; ?> placeholder="29002885.edu@juntadeandalucia.es" required></td>
      <td>Correo del IES para recibir mensajes, normalmente el correo
        de la Direcci&oacute;n del Centro</td>
    </tr>
    <tr>
      <td>Dirección<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="direccion_del_centro" <?php echo (isset($direccion_del_centro)) ? 'value="'.$direccion_del_centro.'"' : ''; ?> placeholder="C/Santo Tomás de Aquino, s/n" maxlength="100" required></td>
      <td>Direcci&oacute;n postal del Centro para recibir correspondencia.</td>
    </tr>
    <tr>
      <td>Localidad<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="localidad_del_centro" <?php echo (isset($localidad_del_centro)) ? 'value="'.$localidad_del_centro.'"' : ''; ?> placeholder="Estepona" maxlength="60" required></td>
      <td>Eso
        mismo.</td>
    </tr>
    <tr>
      <td>Código postal<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="codigo_postal_del_centro" <?php echo (isset($codigo_postal_del_centro)) ? 'value="'.$codigo_postal_del_centro.'"' : ''; ?> placeholder="29680" maxlength="5" required></td>
      <td>Eso
        mismo.</td>
    </tr>
    <tr>
      <td>Teléfono<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="telefono_del_centro" <?php echo (isset($telefono_del_centro)) ? 'value="'.$telefono_del_centro.'"' : ''; ?> placeholder="952795802" maxlength="9" required></td>
      <td>Eso
        mismo.</td>
    </tr>
    <tr>
      <td>Fax:
        </td>
      <td><input type="text" class="form-control" name="fax_del_centro" <?php echo (isset($fax_del_centro)) ? 'value="'.$fax_del_centro.'"' : ''; ?> placeholder="952795802" maxlength="9"></td>
      <td>Eso
        mismo.</td>
    </tr>
    <tr>
      <td>Curso actual<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="curso_actual" <?php echo (isset($curso_actual)) ? 'value="'.$curso_actual.'"' : ''; ?> placeholder="2014/15" maxlength="7" required></td>
      <td>A&ntilde;os acad&eacute;micos, en la forma 2014/15, por ejemplo.</td>
    </tr>
    <tr>
      <td>Inicio del Curso Escolar<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="inicio_curso" <?php echo (isset($inicio_curso)) ? 'value="'.$inicio_curso.'"' : ''; ?> placeholder="2014-09-15" maxlength="10" required></td>
      <td>Fecha de comienzo del Curso Escolar. Formato: 2014-09-15</td>
    </tr>
    <tr>
      <td>Final del Curso Escolar<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="fin_curso" <?php echo (isset($fin_curso)) ? 'value="'.$fin_curso.'"' : ''; ?> placeholder="2015-06-23" maxlength="10" required></td>
      <td>Fecha de terminación del Curso Escolar. Formato: 2015-06-23</td>
    </tr>
    <tr>
      <td>Página cerrada
        </td>
      <td><input type="checkbox" name="mantenimiento" <?php if($mantenimiento) { echo "checked";} ?> /></td>
      <td>Seleccione entre si está permitido acceder a la página, o no. Solo el Administrador y los miembros del equipo directivo pueden acceder a la Intranet.</td>
    </tr>
    <tr>
      <td>Utilizar HTTPS
        </td>
      <td><input type="checkbox" name="force_ssl" <?php if($force_ssl) { echo "checked";} ?> /></td>
      <td>Fuerza el uso de conexiones seguras entre los usuarios y el servidor. Marque esta opción si su dominio tiene un certificado SSL/TLS válido.</td>
    </tr>
    </table>
</div>

<div class="tab-pane fade in" id="tab2">
<h3>Módulos de la Intranet</h3><br />
   <table class="table table-condensed table-bordered table-striped">
    <tr>
      <td class="col-sm-3">Centro TIC:
        </td>
      <td class="col-sm-4"><input type="checkbox" name="mod_tic" <?php if($mod_tic) { echo "checked";} ?> /></td>
      <td>Aplicaciones propias de un Centro TIC: Incidencias, usuarios, etc.</td>
    </tr>
    <tr>
      <td>Horarios de profesores:
        </td>
      <td><input type="checkbox" name="mod_horario" id="mod_horario" onChange="activarMod_faltas()" <?php if($mod_horario) { echo "checked"; } ?> /></td>
      <td>Si disponemos de Horario para la Intranet...</td>
    </tr>
    <tr>
      <td>Activar módulo de Faltas de Asistencia:
        </td>
      <td><input  type="checkbox" id="mod_faltas" name="mod_faltas"  <?php if($mod_horario) { if($mod_faltas){echo "checked";} }  else { echo "disabled";}?> /></td>
      <td>El módulo de faltas permite gestionar las faltas a través de la Intranet para luego exportarlas a Séneca.</td>
    </tr>
    <tr>
      <td>Centro Bilingüe
        </td>
      <td><input  type="checkbox" id="mod_bilingue" name="mod_bilingue" <?php if($mod_bilingue) { echo "checked"; } ?> /></td>
      <td>Activa características para los centros bilingües</td>
    </tr>
    <tr>
      <td>Transporte escolar
        </td>
      <td><input type="checkbox" id="mod_transporte" name="mod_transporte" <?php if($mod_transporte) { echo "checked"; } ?> /></td>
      <td>Activa características para los centros con transporte escolar</td>
    </tr>
    <tr>
      <td>Activar envío de SMS:
        </td>
      <td><input type="checkbox" id = "mod_sms" name="mod_sms" onclick="activarMod_sms()" <?php if($mod_sms) { echo "checked"; } ?> /></td>
      <td>Pone en funcionamiento el envío de SMS en distintos lugares de la Intranet (Problemas de convivencia, faltas de asistencia, etc.)</td>
    </tr>
     <tr>
      <td>Biblioteca del Centro
        </td>
      <td><input type="checkbox" id="mod_biblio" name="mod_biblio" <?php if($mod_biblio) { echo "checked";} ?> onclick="activarMod_biblio()" /></td>
      <td>Si el Centro dispone de Biblioteca que funciona con Abies, y cuenta con un equipo de profesores dedicados a su mantenimiento, puedes activar este módulo.</td>
    </tr>
    <tr>
      <td>Página web de la Biblioteca del Centro
        </td>
      <td><input type="text" class="form-control" id="p_biblio" name="p_biblio" <?php if(!($mod_biblio=='1')){ echo "disabled";} ?> value="<?php echo $p_biblio; ?>" maxlength="60"></td>
      <td>Dirección de la página de la Biblioteca del Centro</td>
    </tr>
         <td>Evaluaciones en la Intranet
        </td>
      <td><input type="checkbox" id="mod_eval" name="mod_eval" <?php if($mod_eval) { echo "checked";} ?> /></td>
      <td>Este módulo permite realizar evaluaciones, especialmente las intermedias, dentro de la Intranet. Los datos pueden ser visualizados por el Equipo educativo del Grupo.</td>
    </tr>
        <tr>
        <td>Matriculación de los alumnos
        </td>
      <td><input type="checkbox" id="mod_matriculas" name="mod_matriculas" <?php if($mod_matriculas) { echo "checked";} ?> /></td>
      <td>Este módulo permite matricular a los alumnos desde la propia aplicación o bien desde la página pública del Centro incluyendo el código correspondiente (ponerese en contacto para descargarlo e instalarlo). </td>
    </tr>
        <tr>  
      <td>Usuario SMS:
        </td>
      <td><input type="text" class="form-control" name="usuario_smstrend" id="usuario_smstrend" <?php if(!($mod_sms=='1')){ echo "disabled";} ?> value="<?php echo $usuario_smstrend; ?>" maxlength="30"></td>
      <td>Nombre del usuario registrado para enviar mensajes SMS a los
        padres.</td>
    </tr>
    <tr>
      <td>Clave SMS:
        </td>
      <td><input type="password" class="form-control" name="clave_smstrend" id="clave_smstrend" <?php if(!($mod_sms=='1')){ echo "disabled";} ?> value="<?php echo $clave_smstrend; ?>" maxlength="30"></td>
      <td>Clave o contrase&ntilde;a del usuario SMS.</td>
    </tr>
    <tr>
      <td>Directorio raiz de la Intranet<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="raiz_dir" <?php echo (isset($raiz_dir)) ? 'value="'.$raiz_dir.'"' : 'value="'.$raiz_intranet.'"'; ?> placeholder="<?php echo $raiz_intranet; ?>" maxlength="255" required></td>
      <td>Lugar dentro del Sistema de Archivos en el que se encuentra la carpeta con la Intranet. La ruta es absoluta (p.ej. "/home/e-smith/files/ibays/intranet/html/")</td>
    </tr>
    <tr>
      <td>Directorio de Documentos<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="doc_dir" <?php echo (isset($doc_dir)) ? 'value="'.$doc_dir.'"' : 'value="'.$raiz_intranet.'varios/"'; ?> placeholder="<?php echo $raiz_intranet; ?>varios/" maxlength="255" required></td>
      <td>Directorio en el Servidor local donde tenemos documentos que queremos gestionar con la Intranet . La ruta es absoluta (p.ej. "/home/e-smith/files/ibays/intranet/files/")</td>
    </tr> 
    </table> 
     
    </div>
    
<div class="tab-pane fade in" id="tab3">
<h3>Personal del Centro</h3><br />
   <table class="table table-condensed table-bordered table-striped" >
    <tr>
      <td class="col-sm-3">Director/a<span style='color:#9d261d'> (*)</span>
        </td>
      <td class="col-sm-4"><input type="text" class="form-control" name="director_del_centro" value="<?php echo $director_del_centro; ?>" maxlength="120" required></td>
      <td>Nombre y apellidos.</td>
    </tr>
    <tr>
      <td>Jefe/a de Estudios<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="jefatura_de_estudios" value="<?php echo $jefatura_de_estudios; ?>" maxlength="120" required></td>
      <td>Nombre y apellidos.</td>
    </tr>
    <tr>
      <td>Secretario/a<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="secretario_del_centro" value="<?php echo $secretario_del_centro; ?>" maxlength="120" required></td>
      <td>Nombre y apellidos.</td>
    </tr>
    <tr>
      <?php
for($i=1;$i<3;$i++){
?>
    <tr>
      <td>Administrativos <?php echo $i;?>:
        </td>
      <td valign="top"><input type="text" class="form-control" name="administ<?php echo $i;?>" value="<?php if(empty(${'administ'.$i})){ echo "Administrativo $i";}else{echo ${'administ'.$i};}?>" maxlength="120"/></td>
      <td><input type="text" class="form-control" name="dnia<?php echo $i;?>" value="<?php if(empty(${'dnia'.$i})){ echo "1234567$i";}else{echo ${'dnia'.$i};}?>" maxlength="12"/>
        NIF <br />
        <input type="text" class="form-control" name="idea<?php echo $i;?>" value="<?php if(empty(${'idea'.$i})){ echo "";}else{echo ${'idea'.$i};}?>" maxlength="12"/>
        Usuario Idea de Séneca</td>
    </tr>
    <?php
}
?>
    <tr>
      <?php
for($i=1;$i<2;$i++){
?>
    <tr>
      <td>Conserjería:
        </td>
      <td><input type="text" class="form-control" name="conserje<?php echo $i;?>" value="<?php if(empty(${'conserje'.$i})){ echo "conserje";}else{echo ${'conserje'.$i};}?>" maxlength="12"/></td>
      <td><input type="text" class="form-control" name="dnic<?php echo $i;?>" value="<?php if(empty(${'dnic'.$i})){ echo "1234567C";}else{echo ${'dnic'.$i};}?>" maxlength="12"/></td>
    </tr>
    <?php
}
?>
</table>

    </div>
    
<div class="tab-pane fade in" id="tab4">
<h3>Bases de datos</h3><br />
   <table class="table table-condensed table-bordered table-striped" >        
   <tr>
   <td class="col-sm-3">Base de datos principal</td>
      <td class="col-sm-4"><input type="text" class="form-control" name="db" <?php echo (isset($db)) ? 'value="'.$db.'"' : ''; ?> placeholder="intranet" maxlength="20" required></td>
      <td>Nombre de la base de datos principal.</td>
    </tr>
    <tr>
      <td>Servidor<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="db_host" <?php echo (isset($db_host)) ? 'value="'.$db_host.'"' : ''; ?> placeholder="localhost" maxlength="20" required></td>
      <td>Servidor de MySQL</td>
    </tr>
    <tr>
      <td>Usuario<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" class="form-control" name="db_user" <?php echo (isset($db_user)) ? 'value="'.$db_user.'"' : ''; ?> placeholder="root" maxlength="20" required></td>
      <td>Usuario de MySQL</td>
    </tr>
    <tr>
      <td>Contraseña<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="password" class="form-control" name="db_pass" <?php echo (isset($db_pass)) ? 'value="'.$db_pass.'"' : ''; ?> placeholder="root" maxlength="20" required></td>
      <td>Clave de MySQL</td>
    </tr>
    </table>
    
        </div>
    
<div class="tab-pane fade in" id="tab5">
<h3>Sistema de Reservas</h3><br />
   <table class="table table-condensed table-bordered table-striped" > 
    <?php          
if(empty($num_carrito))
{
?>
    <tr>
      <td>Número de Recursos TIC:
        </td>
      <td><select class="form-control" name="num_carrito" onchange="carritos();">
          <option value="0"></option>
          <?php
		for($i=1;$i<16;$i++) { echo '<option value="'.$i.'">'.$i.'</option>'; }
	?>
        </select></td>
      <td>Número de Recursos TIC.</td>
    </tr>
    <tr>
      <td></td>
      <td><?php
for($i=1;$i<16;$i++){
echo '<input type="text" class="form-control" id="TIC_'.$i.'" name="TIC_'.$i.'" style="display:none"/>';
}
?></td>
      <td>Nombre, Lugar o Descripción de los Recursos TIC</td>
    </tr>

<?php 
}
else
{
?>
    <tr>
      <th>Número de Recursos TIC:
        </th>
      <td><select class="form-control" name="num_carrito" onchange="carritos();">
          <option>
          <?php if($num_carrito){echo $num_carrito;}?>
          </option>
          <?php
for($i=1;$i<15;$i++){
echo "<option>$i</option>";
}
?>
        </select></td>
      <td>Número de Recursos TIC.</td>
    </tr>
      <?php
for($i=1;$i<$num_carrito+1;$i++){
?>
    <tr>
      <td>TIC_<?php echo $i;?>:
        </td>
      <td><input type="text" class="form-control" name="TIC_<?php echo $i;?>" value="<?php if(empty(${'TIC_'.$i})){ echo "";}else{echo ${'TIC_'.$i};}?>"/></td>
      <td>Nombre o Lugar del Recursos TIC nº <?php echo $i;?></td>
    </tr>
    <?php
}
}
?>
    <?php          
if(empty($num_medio))
{
?>
    <tr>
      <td>Número de Medios Audiovisuales:
        </td>
      <td><select class="form-control" name="num_medio" onchange="medios()">
          <option value="0"><?php echo $num_medio;?>
          <?php
for($i=1;$i-11;$i++){ echo '<option value="'.$i.'">'.$i.'</option>'; }
?>
        </select></td>
      <td>Número de Medios para compartir en el Centro</td>
    </tr>
    <tr>
      <td></td>
      <td><?php
for($i=1;$i-11;$i++){
echo '<input type="text" class="form-control" id="medio'.$i.'" name="medio'.$i.'" style="display:none"/>';
}
?></td>
      <td>Nombre, Lugar o Descripción de los Medios Audiovisuales</td>
    </tr>
    <?php }
else
{
?>
    <tr>
      <th nowrap>Número de Medios Audiovisuales:
        </th>
      <td><select class="form-control" name="num_medio" onchange="medios()">
          <option>
          <?php if(empty($num_medio)){ echo "";}else{echo $num_medio;}?>
          </option>
          <?php
for($i=1;$i<11;$i++){
echo "<option>$i</option>";
}
?>
        </select></td>
      <td>Número de Medios.</td>
    </tr>
      <?php
for($i=1;$i<$num_medio+1;$i++){
?>
    <tr>
      <td>Medio<?php echo $i;?>:
        </td>
      <td><input type="text" class="form-control" name="medio<?php echo $i;?>" value="<?php if(empty(${'medio'.$i})){ echo "";}else{echo ${'medio'.$i};}?>"/></td>
      <td>Nombre o Lugar del Medio Audiovisual nº <?php echo $i;?></td>
    </tr>
    <?php
}
}
?>
  </table>
  <br />
  </div>
 
 <div  align="center">
      <input type="submit" class="btn btn-primary" name="enviar" value="Aplicar cambios"  />
 </div>

</div>
</div>

   </fieldset>
</form>

<script> 
function carritos(){ 
var elementos = document.configura.length;
	for(z = 0; z <= elementos; z++) {
var nombre = document.forms[0].elements[z].name;
if(nombre == "num_carrito"){
num_carro = z;
total = eval(num_carro + 15);
var valor = eval(document.configura.num_carrito[document.configura.num_carrito.selectedIndex].value);
	for(i = num_carro + 1; i <= total; i++) { 
val = eval(num_carro + valor );
if(i <= val){
var n_car = eval(i - num_carro)
document.forms[0].elements[i].style.display = "inline";
document.forms[0].elements[i].value = "TIC nº "+n_car; 
}
else{
document.forms[0].elements[i].style.display = "none";
}}}}
	}

function medios(){ 
var elementos = document.configura.length;
	for(z = 0; z <= elementos; z++) {
var nombre = document.forms[0].elements[z].name;
if(nombre == "num_medio"){
num_medio = z;
total = eval(num_medio + 10);
var valor = eval(document.configura.num_medio[document.configura.num_medio.selectedIndex].value);
	for(i = num_medio + 1; i <= total; i++) { 
val = eval(num_medio + valor);
if(i <= val){
var n_med = eval(i - num_medio)
document.forms[0].elements[i].style.display = "inline";
document.forms[0].elements[i].value = "Medio nº "+n_med; 
}
else{
document.forms[0].elements[i].style.display = "none";
}}}}}

</script>


