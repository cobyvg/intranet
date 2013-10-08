<?
session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?
include("../menu.php");
?>
<br />
<div class="container-fluid">  
      <div class="row-fluid">  
      <div class="page-header" align="center">
  <h2>Administraci&oacute;n <small> Funciones, Configuraci&oacute;n, Importaci&oacute;n de datos...</small></h2>
</div>
        <div class="span1"> </div>
        <div class="span3"> 
          <div class="well well-large sidebar-nav">  
            <ul class="nav nav-list">
            <? include("menu.php");?> 
           </ul>  
          </div><!--/.well -->  
        </div><!--/span-->  
        <div class="span7"> 
        <div class="well-transparent">
        <h3> Descripci&oacute;n de los m&oacute;dulos e instrucciones.</h3><br />
<div style="text-align:justify">
<p>	
Esta es la pagina de Administraci&oacute;n de la Intranet y de las Bases de Datos de la misma. A continuaci&oacute;n siguen algunas explicaciones sobre la mayor&iacute;a de los m&oacute;dulos que componen la aplicaci&oacute;n.</p>
<hr>
<p>La <strong>primera opci&oacute;n (<span style='color:#08c'>Cambiar la Configuraci&oacute;n</span>)</strong> permite editar y modificar los datos de la configuraci&oacute;n que se crearon cuando se instal&oacute; la Intranet.</p> 

<hr>
<p>	
El <strong>segundo grupo de opciones (<span style='color:#08c'>A Principio de curso...</span>)</strong> crea las tablas principales: Alumnos, Profesores, Asignaturas, Calificaciones y Horarios. Hay que tener a mano varios archivos que descargamos de Seneca y Horw: </p>
<ul>
<li>Los Alumnos se crean una sola vez a comienzo de curso, aunque luego podemos actualizarlos cuando queramos. En este proceso se crean las tablas de Alumnos y se les asigna un n&uacute;mero de aula. Tambi&eacute;n se generan dos archivos preparados para el Alta masiva de Alumnos y Profesores en Gesuser (los coloca en intranet/xml/jefe/TIC/). Necesitamos dos archivos de S&eacute;neca: 
<ul>
  <li>el de los alumnos. Lo descargamos desde S&eacute;neca. Alumnado --&gt; Alumnado --&gt; Alumnado del Centro --&gt; Aceptar (arriba a la derecha) --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano. El archivo que se descarga se llama RelPerCen.txt</li>
  <li>el de las evaluaciones. Se descarga de Seneca desde &quot;Intercambio de Informacion --&gt; Exportacion desde Seneca --&gt; Exportacion de Calificaciones&quot;. Arriba a la derecha hay un icono para crear un nuevo documento con los datos de las evaluaciones; seleccionar todos los grupos del Centro para una evaluaci&oacute;n (la primera vale, por ejemplo) y añadirlos a la lista. Cuando hayais terminado, haced click en el icono de confirmaci&oacute;n y al cabo de un minuto volved a la p&aacute;gina de exportaci&oacute;n de calificaciones y ver&eacute;is que se ha generado un archivo comprimido que pod&eacute;is descargaros. </li>
</ul>
</li>
  <li>Los profesores. Se descarga desde S&eacute;neca --&gt; Personal --&gt; Personal del centro --&gt; Unidades y Materias  --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano.</li>
  <li>Asignaturas y Calificaciones supone que los archivos XML de alguna de las Evaluaciones del curso se encuentren en el directorio exporta/, porque ya se ha creado la tabla de los alumnos o se ha actualizado la misma.</li>
  <li>Los Departamentos. Se descarga desde S&eacute;neca --&gt; Personal --&gt; Personal del centro  --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano.</li>
  <li>Los Horarios (que generamos con Horw). S&oacute;lo se genera una vez a principio de Curso. Las instrucciones de la descarga est&aacute;n en el formulario correspondiente, al pinchar en el enlace.</li>
 
      <li>La Asignaci&oacute;n TIC, en caso de que se hayan marcado las opciones 'Horario' y 'Centro TIC' en la p&aacute;gina de configuraci&oacute;n, permiten asignar a cada alumno un ordenador TIC en cada clase que este tenga, de tal modo que sea posible seguir la historia de un ordenador TIC a trav&eacute;s de los alumnos que lo han utilizado.</li>
</ul>
</p>
<hr>
<p>
El <strong>tercer grupo de opciones</strong> afecta a los <strong><span style='color:#08c'>Profesores</span></strong>. 
 Una vez se han creado los Departamentos y Profesores, es necesario seleccionar los <span style='color:#08c'>P&eacute;rfiles de los Profesores</span> para que la aplicaci&oacute;n se ajuste a las funciones propias de cada profesor ( Tutor, Direcci&oacute;n, Jefe de Departamento, etc. ). Tambi&eacute;n desde aqu&iacute; se puede <span style='color:#08c'>Reiniciar la contraseña</span> de los profesores que se hayan olvidado de la misma. Al resetearla, el profesor deber&aacute; entrar de nuevo con el DNI como contraseña, lo que le llevar&aacute; a la p&aacute;gina desde la que tendr&aacute; que cambiarla con los criterios de S&eacute;neca. La &uacute;ltima opci&oacute;n, <span style='color:#08c'>Copiar datos de un profesor a otro</span> cambia el horario de un profesor que ha sido sustituido al profesor que lo sustituye, de tal manera que el nuevo profesor pueda entrar en la Intranet con su usuario iDEA normalmente.
 </p>
 <hr>
<p>
    El <strong>cuarto grupo (<span style='color:#08c'>Actualizaci&oacute;n</span>)</strong> permite actualizar los datos de Alumnos, Profesores y Departamentos del Centro. Esta pensado para la actualizacion de los alumnos que se van matriculando a lo largo del Curso, as&iacute; como para la puesta al d&iacute;a de la lista de Profesores y Departamentos. Necesita el archivo de alumnos y el de la evaluaci&oacute;n correspondiente como en la primera opci&oacute;n, ambos actualizados. Los m&oacute;dulos de Profesores y Departamentos, as&iacute; como el de Horarios, requieren de sus respectivos archivos, especificados en su propia p&aacute;gina. Es importante tener en cuenta que despu&eacute;s de actualizar los horarios deben actualizarse los profesores para garantizar la compatibilidad de los datos de Horwin con S&eacute;neca. La &uacute;ltima opci&oacute;n, Limpiar Horarios, se debe ejecutar cuando los cambios en los horarios se han dado por terminados y se encuentran en perfecto estado en S&eacute;neca. Supone que los profesores se encuentran actualizados.</p>
    <hr>
<p>	
El <strong>quinto grupo (<span style='color:#08c'>Notas de Evaluaci&oacute;n</span>)</strong> crea y actualiza la tabla de las Notas de Evaluacion que aparecen en los Informes de la Intranet, pero tambien presenta las Calificaciones del alumno en la pagina principal. Los archivos necesarios se descargan de S&eacute;neca desde &quot;Intercambio de Informacion --&gt; Exportacion desde Seneca --&gt; Exportacion de Calificaciones&quot;.</p>
<hr>
<p>El <strong>sexto grupo <span style='color:#08c'>(Faltas de asistencia</span>)</strong> contiene un grupo de funciones que aparecen si el m&oacute;dulo de Faltas de asistencia ha sido activado en la p&aacute;gina de Configuraci&oacute;n de la intranet.</p>
<ul>
  <li>&quot;Alumnos Absentistas&quot; da entrada al m&oacute;dulo de Absentismo, desde el cual se registran los alumnos y permite al Tutor, Direcci&oacute;n y Orientaci&oacute;n informar sobre los mismos. </li>
  <li>El &quot;Parte de Faltas completo&quot; genera todos los partes de aula de Faltas de Asistencia para todas las clases,  todos los d&iacute;as de la semana. </li>
  <li>El &quot;Informe de Faltas para Padres&quot; presenta las cartas que se env&iacute;an a los pap&aacute;s con las faltas del nene,
    preparadas para imprimir, pero s&oacute;lo en aquellos casos para los que no se env&iacute;en SMS con la siguiente opci&oacute;n, &quot;SMS de Faltas para Padres&quot;. </li>
  <li>&quot;Horario de faltas para profesores&quot; crea los horarios que los profesores necesitan para registrar las faltas de asistencia de los alumnos. Cada profesor marca en su horario el n&uacute;mero de clase de los alumnos ausentes en una semana, y, o bien las registra posteriormente en el m&oacute;dulo de &quot;Poner faltas&quot;, o bien lo entrega para que los Tutores de Faltas lo hagan.</li>
  <li>&quot;SMS de faltas para los Padres&quot; permite enviar regularmente un SMS de faltas a los padres de modo masivo. Se env&iacute;an SMS a los padres de todos los alumnos que tengan un m&iacute;nimo de una falta de asistencia en el plazo de tiempo seleccionado.</li>
</ul>
<hr>
<p>El <strong>s&eacute;ptimo grupo <span style='color:#08c'>(Alumnos)</span></strong> toca asuntos varios relacionados con los mismos. </p>
<ul>
 <li>Las Listas de Grupos. Supone que se han realizado todas las tareas anteriores (Horario, Profesores, Alumnos, etc.). Presenta la lista de todos los Grupos del Centro preparada para ser imprimida y entregada a los Profesores a principios de Curso. </li>
<li>"Carnet de los Alumnos" permite generar los carnet de los alumnos del Centro preparados para ser imprimidos. Este m&oacute;dulo supone que se han subido las fotos de los alumnos a la intranet utilizando el enlace "Subir fotos de alumnos", a continuaci&oacute;n.</li>
<li>"Subir fotos de alumnos" permite hacer una subida en bloque de todas las fotos de los alumnos para se utilizadas por los distintos m&oacute;dulos de la Intranet. Para ello, necesitaremos crear un archivo comprimido ( .zip ) con todos los archivos de fotos de los alumnos. Cada archivo de foto tiene como nombre el NIE de S&eacute;neca (el N&uacute;mero de Identificaci&oacute;n que S&eacute;neca asigna a cada alumno ) seguido de la extensi&oacute;n .jpg o .jpeg. El nombre t&iacute;pico de un archivo de foto quedar&iacute;a por ejemplo as&iacute;: 1526530.jpg. Las fotos de los profesores se suben del mismo modo, pero el nombre se construye a partir del usuario IdEA ( mgargon732.jpg, por ejemplo).</li>
  <li>&quot;Libros de Texto gratuitos&quot; es un conjunto de p&aacute;ginas pensadas para registrar el estado de los libros de cada alumno dentro del Programa de Ayudas al Estudio de la Junta, e imprimir los certificados correspondientes (incluidas las facturas en caso de mal estado o p&eacute;rdidad del material).</li>
    <li>&quot;Matriculaci&oacute;n de alumnos&quot; es un m&oacute;dulo que permite matricular a los alumnos a trav&eacute;s de la intranet o, en su caso, a trav&eacute;s de internet (si el m&oacute;dulo se ha incorporado a la p&aacute;gina principal del Centro). Los tutores, a final de curso, ayudan a los alumnos a matricularse en una sesi&oacute;n de tutor&iacute;a. Posteriormente el Centro imprime los formularios de la matr&iacute;cula y se los entregan a los alumnos para ser firmados por sus padres y entregados de nuevo en el IES. El Equipo directivo cuenta entonces con la ventaja de poder administrar los datos f&aacute;cilmente para formar los grupos de acuerdo a una gran variedad de criterios. El m&oacute;dulo incluye una p&aacute;gina que realiza previsiones de matriculaci&oacute;n de alumnos en las distintas evaluaciones.</li> 
    </ul>
<hr>
<p>El <strong>&uacute;ltimo grupo <span style='color:#08c'>(Base de datos)</span></strong> permite realizar copias de seguridad de las bases de datos que contienen los datos esenciales de la Intranet. La copia de seguridad crea un archivo, comprimido o en formato texto (SQL), en un directorio de la aplicaci&oacute;n ( /intranet/xml/jefe/copia_db/ ). Esta compia puede ser descragada una vez creada. Tambi&eacute;n podemos restaurar la copia de seguridad seleccionando el archivo que hemos creado anteriormente. </p>

    
  <!--   <li>&quot;Registro de Fotocopias&quot; es un m&oacute;dulo que permite a los Conserjes y Direcci&oacute;n registrar las fotocopias que se hacen en el centro. La Direcci&oacute;n tambi&eacute;n puede ver estad&iacute;sticas por profesor y departamento.</li>
    
<li>&quot;Importar fotos de alumnos&quot; permite insertar o reemplazar fotos de alumnos en la tabla <em>Fotos</em> de la Base de datos general. El directorio donde se encuentran las fotos debe ser registrado en la p&aacute;gina de Administracci&oacute;n de la intranet, y es conveniente que se encuentre dentro del alcanze de PHP. El nombre de los archivos de las fotos debe contener como primera parte el identificador Personal del Alumno en S&eacute;neca (<strong>claveal</strong> en la tabla <strong>Alma</strong>, por ejemplo), seguido del formato de imagen (<em>.jpeg</em> o <em>.jpg</em>). Una vez insertadas o actualizadas las fotos, pueden ser consultadas desde varios m&oacute;dulos de la Intranet. </li>-->

</blockquote>    
</div>
</div>
</div> 
</div>
</div>
<? include("../pie.php");?>  
</body>
</html>
