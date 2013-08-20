<? include("../menu_solo.php"); ?>
<br />
<div align="center">
<div class="page-header">
  <h2>Configuración de la Intranet <small> Datos básicos de la aplicación</small></h2>
</div>
<?php

if (isset($_POST['enviar'])){
	echo $mens; 
	echo $form;
}
if($mens_bd=="1"){
	echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
No se encuentra el archivo de configuracion <strong>config.php</strong> en el directorio <em>/opt/e-smith/</em>. Debes crearlo en primer lugar y conceder permiso de escritura al mismo.
          </div><br /><input type="button" value="Volver atrás" name="boton" onClick="history.back(1)" class="btn btn-inverse" /></div>';
}

/*$activo1='';
$activo2="";
$activo3="";
$activo4="";
$activo5="";
if (strstr($_SERVER['REQUEST_URI'],'#tab1')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'#tab2')==TRUE) {$activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'#tab3')==TRUE) {$activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'#tab4')==TRUE) {$activo4 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'#tab5')==TRUE) {$activo5 = ' class="active" ';}*/
?>

<form enctype="multipart/form-data" action="index.php" method="post" name="configura">
<fieldset class="control-group info">
<div class="tabbable" style="margin-bottom: 18px;">
<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">Datos generales de la configuración</a></li>
<li><a href="#tab2" data-toggle="tab">Módulos de la Intranet</a></li>
<li><a href="#tab3" data-toggle="tab">Personal del Centro</a></li>
<li><a href="#tab4" data-toggle="tab">Base de Datos</a></li>
<li><a href="#tab5" data-toggle="tab">Sistema de Reservas</a></li>
</ul>
<div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
<div class="tab-pane fade in active" id="tab1">
<h3>Datos generales de la configuración</h3><br />

  <table class="table table-condensed table-bordered table-striped" style="width:60%">
      <td width="190">Dominio<span style='color:#9d261d'> (*)</span>
        </td>
      
      <td><input type="text" name="dominio" size="30" value="<?php if($dominio){echo $dominio;}else{echo "iesmonterroso.org";} ?>" required onclick="this.value=''" /></td>
      <td>Nombre del dominio contratado por el IES donde se encuentra la Intranet..</td>
    </tr>
    <tr>
      <td>Nombre del Centro<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="nombre_del_centro" size="30" value="<?php if($nombre_del_centro){echo $nombre_del_centro;}else{echo "I.E.S. Monterroso";} ?>" required onclick="this.value=''" /></td>
      <td>Eso mismo.</td>
    </tr>
    <tr>
      <td>Nombre corto
        </td>
      <td><input type="text" name="nombre_corto" size="30" value="<?php if($nombre_corto){echo $nombre_corto;}else{echo "Monterroso";} ?>" onclick="this.value=''" /></td>
      <td>Versi&oacute;n corta del anterior.</td>
    </tr>
    <tr>
      <td>Código  del Centro<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="codigo_del_centro"  size="30"  value="<?php if($codigo_del_centro){echo $codigo_del_centro;}else{echo "29002885";} ?>" required onclick="this.value=''" /></td>
      <td>Eso mismo.</td>
    </tr>
    <tr>
      <td>Email del Centro<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="email_del_centro" size="30" value="<?php if($email_del_centro){echo $email_del_centro;}else{echo "director@iesmonterroso.org";} ?>" required onclick="this.value=''" /></td>
      <td>Correo del IES para recibir mensajes, normalmente el correo
        de la Direcci&oacute;n del Centro</td>
    </tr>
    <tr>
      <td>Dirección<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="direccion_del_centro" size="30" value="<?php if($direccion_del_centro){echo $direccion_del_centro;}else{ echo"C/. Santo Tomás de Aquino, s/n";}?>" required /></td>
      <td>Direcci&oacute;n postal del Centro para recibir correspondencia.</td>
    </tr>
    <tr>
      <td>Localidad<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="localidad_del_centro" size="30" value="<?php if($localidad_del_centro){echo $localidad_del_centro;}else{echo "Estepona";} ?>" required /></td>
      <td>Eso
        mismo.</td>
    </tr>
    <tr>
      <td>Código postal<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="codigo_postal_del_centro" size="30" value="<?php if($codigo_postal_del_centro){echo $codigo_postal_del_centro;}else{echo "29680";} ?>" required /></td>
      <td>Eso
        mismo.</td>
    </tr>
    <tr>
      <td>Teléfono<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="telefono_del_centro" size="30" value="<?php if($telefono_del_centro){echo $telefono_del_centro;}else{echo "952795802";} ?>" required /></td>
      <td>Eso
        mismo.</td>
    </tr>
    <tr>
      <td>Fax:
        </td>
      <td><input type="text" name="fax_del_centro" size="30" value="<?php echo $fax_del_centro; ?>"/></td>
      <td>Eso
        mismo.</td>
    </tr>
    <tr>
      <td>Curso actual<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="curso_actual" size="30" value="<?php if(empty($curso_actual)) { echo "2012/13"; } else { echo $curso_actual; } ?>" required /></td>
      <td>A&ntilde;os acad&eacute;micos, en la forma 2012/13, por ejemplo.</td>
    </tr>
    <tr>
      <td>Inicio del Curso Escolar<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="inicio_curso" size="30" value="<?php if(empty($inicio_curso)) { echo "2012-09-17"; } else { echo $inicio_curso; } ?>" required /></td>
      <td>Fecha de comienzo del Curso Escolar. Formato: 2012-09-17</td>
    </tr>
    <tr>
      <td>Final del Curso Escolar<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="fin_curso" size="30" value="<?php if(empty($fin_curso)) { echo "2013-06-21"; } else { echo $fin_curso; }?>" required /></td>
      <td>Fecha de terminación del Curso Escolar. Formato: 2013-06-21</td>
    </tr>
    </table>
</div>

<div class="tab-pane fade in" id="tab2">
<h3>Módulos de la Intranet</h3><br />
   <table class="table table-condensed table-bordered table-striped" style="width:60%">
    <tr>
      <td>Centro TIC:
        </td>
      <td><input type="checkbox" name="mod_tic" <?php if($mod_tic) { echo "checked";} ?> /></td>
      <td>Aplicaciones propias de un Centro TIC: Incidencias, usuarios, etc.</td>
    </tr>
    <tr>
      <td>Horario compatible con Horwin:
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
      <td>Activar envío de SMS:
        </td>
      <td><input type="checkbox" id = "mod_sms" name="mod_sms" onclick="activarMod_sms()" <?php if($mod_sms) { echo "checked"; } ?> /></td>
      <td>Pone en funcionamiento el envío de SMS en distintos lugares de la Intranet (Problemas de convivencia, faltas de asistencia, etc.)</td>
    </tr>
    <tr>
      <td>Usuario SMS:
        </td>
      <td><input type="text" name="usuario_smstrend" id="usuario_smstrend" size="30" <?php if(!($mod_sms=='1')){ echo "disabled";} ?> value="<?php echo $usuario_smstrend; ?>" /></td>
      <td>Nombre del usuario registrado para enviar mensajes SMS a los
        padres.</td>
    </tr>
    <tr>
      <td>Clave SMS:
        </td>
      <td><input type="text" name="clave_smstrend" size="30" id="clave_smstrend" <?php if(!($mod_sms=='1')){ echo "disabled";} ?> value="<?php echo $clave_smstrend; ?>" /></td>
      <td>Clave o contrase&ntilde;a del usuario SMS.</td>
    </tr>
    <tr>
      <td>Directorio raiz de la Intranet<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="raiz_dir" size="30" value="<?php if(empty($raiz_dir)){ echo "/home/e-smith/files/ibays/intranet/html/"; } else { echo $raiz_dir; }?>" required /></td>
      <td>Lugar dentro del Sistema de Archivos en el que se encuentra la carpeta con la Intranet. La ruta es absoluta (p.ej. "/home/e-smith/files/ibays/intranet/html/")</td>
    </tr>
    <tr>
      <td>Directorio de Documentos<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="doc_dir" size="30" value="<?php if(empty($doc_dir)){ echo "/home/e-smith/files/ibays/intranet/files/"; } else { echo $doc_dir; } ?>" required /></td>
      <td>Directorio en el Servidor local donde tenemos documentos que queremos gestionar con la Intranet . La ruta es absoluta (p.ej. "/home/e-smith/files/ibays/intranet/files/")</td>
    </tr> 
    </table> 
     
    </div>
    
<div class="tab-pane fade in" id="tab3">
<h3>Personal del Centro</h3><br />
   <table class="table table-condensed table-bordered table-striped" style="width:60%">
    <tr>
      <td>Director/a<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="director_del_centro" size="30" value="<?php echo $director_del_centro; ?>" required /></td>
      <td>Nombre y apellidos.</td>
    </tr>
    <tr>
      <td>Jefe/a de Estudios<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="jefatura_de_estudios" size="30" value="<?php echo $jefatura_de_estudios; ?>" required /></td>
      <td>Nombre y apellidos.</td>
    </tr>
    <tr>
      <td>Secretario/a<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="secretario_del_centro" size="30" value="<?php echo $secretario_del_centro; ?>" required /></td>
      <td>Nombre y apellidos.</td>
    </tr>
    <tr>
      <?php
for($i=1;$i<3;$i++){
?>
    <tr>
      <td>Administrativos <?php echo $i;?>:
        </td>
      <td valign="top"><input type="text" name="administ<?php echo $i;?>" size="30" value="<?php if(empty(${'administ'.$i})){ echo "Administrativo $i";}else{echo ${'administ'.$i};}?>"/></td>
      <td><input type="text" name="dnia<?php echo $i;?>" size="30" value="<?php if(empty(${'dnia'.$i})){ echo "1234567$i";}else{echo ${'dnia'.$i};}?>"/>
        NIF <br />
        <input type="text" name="idea<?php echo $i;?>" size="30" value="<?php if(empty(${'idea'.$i})){ echo "";}else{echo ${'idea'.$i};}?>"/>
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
      <td><input type="text" name="conserje<?php echo $i;?>" size="30" value="<?php if(empty(${'conserje'.$i})){ echo "conserje";}else{echo ${'conserje'.$i};}?>"/></td>
      <td><input type="text" name="dnic<?php echo $i;?>" size="30" value="<?php if(empty(${'dnic'.$i})){ echo "1234567C";}else{echo ${'dnic'.$i};}?>"/></td>
    </tr>
    <?php
}
?>
</table>

    </div>
    
<div class="tab-pane fade in" id="tab4">
<h3>Bases de datos</h3><br />
   <table class="table table-condensed table-bordered table-striped" style="width:60%">        
   <tr>
   <td>Base de datos principal</td>
      <td><input type="text" name="db" size="30" value="<?php if(empty($db)) { echo "intranet"; } else { echo $db; } ?>" required /></td>
      <td>Nombre de la base de datos principal.</td>
    </tr>
    <tr>
      <td>Servidor<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="db_host" size="30" value="<?php if(empty($db_host)) { echo "localhost"; } else { echo $db_host; } ?>" required /></td>
      <td>Servidor de MySQL</td>
    </tr>
    <tr>
      <td>Usuario<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="db_user" size="30" value="<?php if(empty($db_user)) { echo "usuario_de_mysql"; } else { echo $db_user; } ?>" required /></td>
      <td>Usuario de MySQL</td>
    </tr>
    <tr>
      <td>Contraseña<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="db_pass" size="30" value="<?php if(empty($db_pass)) { echo "contraseña_de_mysql"; } else { echo $db_pass; } ?>" required /></td>
      <td>Clave de MySQL</td>
    </tr>
    </table>
    
        </div>
    
<div class="tab-pane fade in" id="tab5">
<h3>Sistema de Reservas</h3><br />
   <table class="table table-condensed table-bordered table-striped" style="width:60%"> 
    <tr>
      <td>Base de datos de Reservas<span style='color:#9d261d'> (*)</span>
        </td>
      <td><input type="text" name="db_reservas" size="30" value="<?php if(empty($db_reservas)) { echo "reservas"; } else { echo $db_reservas; } ?>" required /></td>
      <td>Nombre
        de la base de datos para las reservas de port&aacute;tiles, aulas
        y medios diversos.</td>
    </tr>
    <?php          
if(empty($num_carrito))
{
?>
    <tr>
      <td>Número de Carritos TIC:
        </td>
      <td><select name="num_carrito" onchange="carritos();">
          <option value="0"></option>
          <?php
		for($i=1;$i<16;$i++) { echo '<option value="'.$i.'">'.$i.'</option>'; }
	?>
        </select></td>
      <td>Número de Carritos con Ordenadores TIC.</td>
    </tr>
    <tr>
      <td></td>
      <td><?php
for($i=1;$i<16;$i++){
echo '<input  type="text" size="30" id="carrito'.$i.'" name="carrito'.$i.'" style="display:none;margin-bottom:5px;"/>';
}
?></td>
      <td>Lugar o Descripción de los Carritos de Portátiles</td>
    </tr>
    <SCRIPT LANGUAGE="JavaScript"> 
function carritos(){ 
var elementos = document.forms[0].length;
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
document.forms[0].elements[i].value = "Carrito nº "+n_car; 
}
else{
document.forms[0].elements[i].style.display = "none";
}}}}
	}

</SCRIPT>
<?php 
}
else
{
?>
    <tr>
      <th>Número de Carritos TIC:
        </th>
      <td><select name="num_carrito" onchange="carritos();">
          <option>
          <?php if($num_carrito){echo $num_carrito;}?>
          </option>
          <?php
for($i=1;$i<15;$i++){
echo "<option>$i</option>";
}
?>
        </select></td>
      <td>Número de Carritos con Ordenadores TIC.</td>
    </tr>
      <?php
for($i=1;$i<$num_carrito+1;$i++){
?>
    <tr>
      <td>Carrito<?php echo $i;?>:
        </td>
      <td><input type="text" name="carrito<?php echo $i;?>" size="30" value="<?php if(empty(${'carrito'.$i})){ echo "";}else{echo ${'carrito'.$i};}?>"/></td>
      <td>Nombre o Lugar del Carrito nº <?php echo $i;?></td>
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
      <td><select name="num_medio" onchange="medios()">
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
echo '<input  type="text" size="30" id="medio'.$i.'" name="medio'.$i.'" style="display:none;margin-bottom:5px;"/>';
}
?></td>
      <td>Nombre, Lugar o Descripción de los Medios Audiovisuales</td>
    </tr>
    <SCRIPT LANGUAGE="JavaScript"> 
function medios(){ 
var elementos = document.forms[0].length;
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
</SCRIPT>
    <?php }
else
{
?>
    <tr>
      <th nowrap>Número de Medios Audiovisuales:
        </th>
      <td><select name="num_medio" onchange="submit()">
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
      <td><input type="text" name="medio<?php echo $i;?>" size="30" value="<?php if(empty(${'medio'.$i})){ echo "";}else{echo ${'medio'.$i};}?>"/></td>
      <td>Nombre o Lugar del Medio Audiovisual nº <?php echo $i;?></td>
    </tr>
    <?php
}
}
?>
    <?php          
if(empty($num_aula))
{
?>
    <tr>
      <td>Número de Aulas Específicas:
        </td>
      <td><select name="num_aula" onchange="aulas()">
          <option value="0"><?php echo $num_aula;?>
          <?php
for($i=1;$i-6;$i++){ echo '<option value="'.$i.'">'.$i; }
?>
        </select></td>
      <td>Número de Aulas para compartir en el Centro</td>
    </tr>
    <tr>
      <td></td>
      <td><?php
for($i=1;$i-6;$i++){
echo '<input  type="text" size="30" id="carularito'.$i.'" name="aula'.$i.'" style="display:none;margin-bottom:5px;"/>';
}
?></td>
      <td>Nombre, Lugar o Descripción de las Aulas</td>
    </tr>
    <SCRIPT LANGUAGE="JavaScript"> 
function aulas(){ 
var elementos = document.forms[0].length;
	for(z = 0; z <= elementos; z++) {
var nombre = document.forms[0].elements[z].name;
if(nombre == "num_aula"){
num_aula = z;
total = eval(num_aula + 5);
var valor = eval(document.configura.num_aula[document.configura.num_aula.selectedIndex].value);
	for(i = num_aula + 1; i <= total; i++) { 
val = eval(num_aula + valor);
if(i <= val){
var n_aul = eval(i - num_aula)
document.forms[0].elements[i].style.display = "inline";
document.forms[0].elements[i].value = "aula nº "+n_aul; 
}
else{
document.forms[0].elements[i].style.display = "none";
}}}}}
</SCRIPT>
    <?php 
}
else
{
?>
    <tr>
      <th>Número de Aulas para compartir:
        </th>
      <td><select name="num_aula" onchange="submit()">
          <option>
          <?php if(empty($num_aula)){ echo "";}else{echo $num_aula;}?>
          </option>
          <?php
for($i=1;$i<6;$i++){
echo "<option>$i</option>";
}
?>
        </select></td>
      <td>Número de Aulas.</td>
    </tr>
      <?php
for($i=1;$i<$num_aula+1;$i++){
?>
    <tr>
      <td>Aula<?php echo $i;?>:
        </td>
      <td><input type="text" name="aula<?php echo $i;?>" size="30" value="<?php if(empty(${'aula'.$i})){ echo "";}else{echo ${'aula'.$i};}?>"/></td>
      <td>Nombre o Lugar del Aula nº <?php echo $i;?></td>
    </tr>
    <?php
}
}
?>
  </table>
  <br />
 <div  align="center">
      <input  type="submit" name="enviar" value="Aplicar cambios" class="btn btn-danger btn-large" style="color:#fff" />
      </div>
   </fieldset>
</form>
<?php include("../pie.php");?>
</body>
</html>