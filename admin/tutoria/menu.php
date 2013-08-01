<?
$activo1="";
$activo2="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'global.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'tutor.php')==TRUE){ $activo2 = ' class="active" ';}
?>
<div class="container">  
	<ul class="nav nav-tabs">
<li<? echo $activo1;?>><a href="global.php?tutor=<? echo $tutor;?>">Resumen General</a></li>
      <li<? echo $activo2;?>><a href="tutor.php?tutor=<? echo $tutor;?>" >Nueva Acci&oacute;n tutorial</a></li>
      <?    if ($mod_sms) {?>
      <li><a href="../../sms/index.php?nivel=<? echo $nivel;?>&grupo=<? echo $grupo;?>">Enviar SMS</a></li>
      <? }?>
       <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Consultas <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a data-toggle="tab" href="../cursos/ccursos.php?submit1=1&nivel=<? echo $nivel;?>&grupo=<? echo $grupo;?>">Lista del Grupo</a></li>
          <li><a  data-toggle="tab" href="../fotos/grupos.php?curso=<? echo $nivel;?>-<? echo $grupo;?>">Fotos del Grupo</a></li>
          <li><a  data-toggle="tab" href="../fotos/fotos.php?nivel=<? echo $nivel;?>&grupo=<? echo $grupo;?>">Registrar Fotos</a></li>
                    <li><a  data-toggle="tab" href="../../xml/jefe/form_carnet.php">Crear Carnet del Alumno</a></li>
          <li><a  data-toggle="tab" href="../datos/datos.php?nivel=<? echo $nivel;?>&grupo=<? echo $grupo;?>">Datos de los Alumnos</a></li>
          <li><a  data-toggle="tab" href="absentismo.php?tutor=<? echo $tutor;?>" >Alumnos Absentistas</a></li>
          <li><a  data-toggle="tab" href="http://<? echo $dominio; ?>/intranet/upload/index.php?&direction=0&order=&directory=programaciones/orientacion" >Materiales de Orientación</a></li>
        </ul>
      </li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Informes <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="../informes/cinforme.php?nivel=<? echo $nivel;?>&grupo=<? echo $grupo;?>">Informe de un Alumno</a></li>
          <li><a href="../infotutoria/index.php" style="border-top:none;border-left:none;">Informes de Tutoría</a></li>
          <li><a href="../tareas/index.php" style="border-top:none;border-left:none;">Informes de Tareas</a></li>
          <li><a  href="memoria.php?nivel=<? echo $nivel;?>&tutor=<? echo $tutor;?>&grupo=<? echo $grupo;?>"  >Memoria de Tutoría</a></li>
        </ul>
      </li>
      <?
  if(substr($nivel,1,1) == "E"){
  ?>
      <li><a  href="../libros/libros.php?nivel=<? echo $nivel;?>&amp;grupo=<? echo $grupo;?>&amp;tutor=1">Libros de Texto</a></li>
      <? } ?>
    </ul>
</div>