<div class="well well-large">
   <a href="./notas/"><li class="nav-header">Acceso para Alumnos<i class="icon icon-user icon-large pull-right"> </i></li></a>  
   <hr />                 
   <p>
                        Los alumnos y sus padres pueden acceder a las páginas personales del alumno mediante la clave privada que proporciona el Centro. En esas paginas se puede encontrar información personalizada sobre los siguientes aspectos:</p>
                        <a href="./notas/">
                        <li>Profesores</li>
                        <li>Libros de Texto</li>
                        <li>Horario</li>
                        <li>Calificaciones</li> 
                        <li>Actividades</li> 
                        <li>Foto del alumno</li> 
                        <li>Convivencia Escolar</li>
                        <li>Faltas de Asistencia</li>
                        <li>Mensajería</li>
                      	</a>
  </div>   

<div class="well well-large">
 <li class="nav-header">Otras P&aacute;ginas<i class="icon icon-external-link icon-large pull-right"> </i></li>
 <hr />
 <ul class="unstyled">	
	 <? foreach($enlaces as $index=>$valor){
     	echo '<li><a href="'.$index.'">'.$valor.'</a></li>';
     }
     ?>				
 </ul>
</div>

<? if ($monterroso==1) { ?>

<div class="well well-large">
 <li class="nav-header"> Portal Escuela de Familias. <i class="icon icon-external-link icon-large pull-right"> </i></li>
 <hr />
<a href="http://www.juntadeandalucia.es/educacion/webportal/web/escuela-de-familias"><img class="img-polaroid" src="./img/imagenpresentacion1.jpg" /></a>
<hr />
<a href="http://www.juntadeandalucia.es/educacion/webportal/ishare-servlet/content/b9669569-4093-414c-8f20-c03b9b7f1524" 
target = "_blank">Guía de Derechos y Responsabilidades de las Familias Andaluzas en la Educación.</a>
 <hr />
<a href="http://www.juntadeandalucia.es/educacion/webportal/ishare-servlet/content/b9669569-4093-414c-8f20-c03b9b7f1524"><img class="img-polaroid" 
src="./img/familia250.jpg" /></a>
</div>	

<? } ?>
