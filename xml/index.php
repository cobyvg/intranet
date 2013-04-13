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

<div class="container-fluid">  
      <div class="row-fluid">  
      <div class="page-header" align="center">
  <h1>Administración <small> Funciones, Configuración, Importación de datos...</small></h1>
</div>
<br />
        <div class="span1"> </div>
        <div class="span3"> 
          <div class="well-2 well-large sidebar-nav">  
            <ul class="nav nav-list">
            <? include("menu.php");?> 
           </ul>  
          </div><!--/.well -->  
        </div><!--/span-->  
        <div class="span7"> 
        <div class="well well-large" style="background-color:transparent">
        <h3> Descripción de los módulos e instrucciones.</h3><br />
<div style="text-align:justify">
<p>	
Esta es la pagina de Administraci&oacute;n de la Intranet y de las Bases de Datos de la misma. A continuación siguen algunas explicaciones sobre la mayoría de los módulos que componen la aplicación.</p>
<p>La <strong>primera opci&oacute;n (<span style='color:#08c'>Configuraci&oacute;n General</span>)</strong> incluye en primer lugar <span style='color:#08c'>Cambiar configuración</span>, que permite editar y modificar los datos de la configuraci&oacute;n que se crearon cuando se instal&oacute; la Intranet. Una vez que se hayan importado los Departamentos y Profesores, es necesario seleccionar los <span style='color:#08c'>Pérfiles de los Profesores</span> para que la aplicación se ajuste a las funciones propias de cada profesor ( Tutor, Dirección, Jefe de Departamento, etc. ). También desde aquí se puede <span style='color:#08c'>Reiniciar la contraseña</span> de los profesores que se hayan olvidado de la misma. Al resetearla, el profesor deberá entrar de nuevo con el DNI como contraseña, lo que le llevará a la página desde la que tendrá que cambiarla con los criterios de Séneca. La última opción, <span style='color:#08c'>Copiar datos de un profesor a otro</span> cambia el horario de un profesor que ha sido sustituido al profesor que lo sustituye, de tal manera que el nuevo profesor pueda entrar en la Intranet con su usuario iDEA normalmente.</p> 
<hr>
<p>  La <strong>segundo opci&oacute;n (<span style='color:#08c'>S&oacute;lo una vez...</span>)</strong> se ejecuta una vez al principio de cada curso para crear las tablas de Alumnos y asignarles un n&uacute;mero en clase. Tambi&eacute;n genera dos ficheros a principio de Curso preparados para el Alta masiva de Alumnos y Profesores en Gesuser (los coloca en intranet/xml/jefe/TIC/). Los ficheros necesarios para la operaci&oacute;n son: </p>
<ul>
  <li>el fichero de los alumnos. Lo descargamos desde S&eacute;neca. Alumnado --&gt; Alumnado --&gt; Alumnado del Centro --&gt; Aceptar (arriba a la derecha) --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano. El archivo que se descarga se llama RelPerCen.txt</li>
  <li>el de las evaluaciones. Se descarga de Seneca desde &quot;Intercambio de Informacion --&gt; Exportacion desde Seneca --&gt; Exportacion de Calificaciones&quot;. Arriba a la derecha hay un icono para crear un nuevo documento con los datos de las evaluaciones; seleccionar todos los grupos del Centro para una evaluación (la primera vale, por ejemplo) y añadirlos a la lista. Cuando hayais terminado, haced click en el icono de confirmación y al cabo de un minuto volved a la página de exportación de calificaciones y veréis que se ha generado un archivo comprimido que podéis descargaros. </li>
</ul>
</p>
<hr>
<p>	
El <strong>tercer grupo de opciones (<span style='color:#08c'>A Principio de curso...</span>)</strong> crea las dem&aacute;s tablas principales: Profesores, Asignaturas, Calificaciones y Horarios. Hay que tener a mano varios archivos que descargamos de Seneca y Horw: </p>
<ul>
  <li>Los profesores. Se descarga desde S&eacute;neca --&gt; Personal --&gt; Personal del centro --&gt; Unidades y Materias  --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano.</li>
  <li>Asignaturas y Calificaciones supone que los archivos XML de alguna de las Evaluaciones del curso se encuentren en el directorio exporta/, porque ya se ha creado la tabla de los alumnos o se ha actualizado la misma.</li>
  <li>Los Departamentos. Se descarga desde S&eacute;neca --&gt; Personal --&gt; Personal del centro  --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano.</li>
  <li>Los Horarios (que generamos con Horw). S&oacute;lo se genera una vez a principio de Curso. Las instrucciones de la descarga est&aacute;n en el formulario correspondiente, al pinchar en el enlace.</li>
  <li>las Listas de Grupos. Supone que se han realizado todas las tareas anteriores(Horario, Profesores, Alumnos, etc.). Presenta la lista de todos los Grupos del Centro preparada para ser imprimida y entregada a los Profesores a principios de Curso. </li>
  <li>Los Perfiles del Profesorado permiten asignar cargos y funciones a profesores y Personal vario del Centro. Es necesario que la tabla de Departamentos haya sido creada.</li>
      <li>La Asignaci&oacute;n TIC, en caso de que se hayan marcado las opciones 'Horario' y 'Centro TIC' en la página de configuración, permiten asignar a cada alumno un ordenador TIC en cada clase que este tenga, de tal modo que sea posible seguir la historia de un ordenador TIC a través de los alumnos que lo han utilizado.</li>
</ul>
</p>
<hr>
<p>
    El <strong>cuarto grupo (<span style='color:#08c'>Actualizaci&oacute;n</span>)</strong> permite actualizar los datos deAlumnos y Profesores/Departamentos del Centro. Esta pensado para la actualizacion de los alumnos que se van matriculando a lo largo del Curso, así como para la puesta al día de la lista de Profesores y Departamentos. Necesita el archivo de alumnos y el de la evaluaci&oacute;n correspondiente como en la primera opci&oacute;n, ambos actualizados. Los módulos de Profesores y Departamentos requieren de sus respectivos archivos, especificados en su propia página.</p>
    <hr>
<p>	
El <strong>quinto grupo (<span style='color:#08c'>Notas de Evaluaci&oacute;n</span>)</strong> crea y actualiza la tabla de las Notas de Evaluacion que aparecen en los Informes de la Intranet, pero tambien presenta las Calificaciones del alumno en la pagina principal. Los archivos necesarios se descargan de Séneca desde &quot;Intercambio de Informacion --&gt; Exportacion desde Seneca --&gt; Exportacion de Calificaciones&quot;.</p>
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
<p>El <strong>s&eacute;ptimo grupo <span style='color:#08c'>(Otras cosas</span>)</strong> toca tareas diversas. </p>
<ul>
<li>"Carnet de los Alumnos" permite generar los carnet de los alumnos del Centro preparados para ser imprimidos. Este módulo supone que se han subido las fotos de los alumnos a la intranet utilizando el enlace "Subir fotos de alumnos", a continuación. Es necesario cambiar la imagen <em>junta10.jpg</em> que se encuentra en el directorio <em>/xml/jefe/carnet/</em> para adaptarla al nombre del Centro (por defecto viene el nuestro).</li>
<li>"Subir fotos de alumnos" permite hacer una subida en bloque de todas las fotos de los alumnos para se utilizadas por los distintos módulos de la Intranet. Para ello, necesitaremos crear un archivo comprimido ( .zip ) con todos los archivos de fotos de los alumnos. Cada archivo de foto tiene como nombre el NIE de Séneca (el Número de Identificación que Séneca asigna a cada alumno ) seguido de la extensión .jpg o .jpeg. El nombre típico de un archivo de foto quedaría por ejemplo así: 1526530.jpg. Las fotos de los profesores se suben del mismo modo, pero el nombre se construye a partir del usuario IdEA ( mgargon732.jpg, por ejemplo).</li>

  <li>&quot;Libros de Texto gratuitos&quot; es un conjunto de p&aacute;ginas pensadas para registrar el estado de los libros de cada alumno dentro del Programa de Ayudas al Estudio de la Junta, e imprimir los certificados correspondientes (incluidas las facturas en caso de mal estado o p&eacute;rdidad del material).</li>

  <!--   <li>&quot;Registro de Fotocopias&quot; es un módulo que permite a los Conserjes y Dirección registrar las fotocopias que se hacen en el centro. La Dirección también puede ver estadísticas por profesor y departamento.</li>
    
<li>&quot;Importar fotos de alumnos&quot; permite insertar o reemplazar fotos de alumnos en la tabla <em>Fotos</em> de la Base de datos general. El directorio donde se encuentran las fotos debe ser registrado en la página de Administracción de la intranet, y es conveniente que se encuentre dentro del alcanze de PHP. El nombre de los archivos de las fotos debe contener como primera parte el identificador Personal del Alumno en Séneca (<strong>claveal</strong> en la tabla <strong>Alma</strong>, por ejemplo), seguido del formato de imagen (<em>.jpeg</em> o <em>.jpg</em>). Una vez insertadas o actualizadas las fotos, pueden ser consultadas desde varios módulos de la Intranet. </li>-->
    <li>&quot;Matriculación de alumnos&quot; es un módulo que permite matricular a los alumnos a través de la intranet o, en su caso, a través de internet (si el módulo se ha incorporado a la página principal del Centro). Los tutores, a final de curso, ayudan a los alumnos a matricularse en una sesión de tutoría. Posteriormente el Centro imprime los formularios de la matrícula y se los entregan a los alumnos para ser firmados por sus padres y entregados de nuevo en el IES. El Equipo directivo cuenta entonces con la ventaja de poder administrar los datos fácilmente para formar los grupos de acuerdo a una gran variedad de criterios. El módulo incluye una página que realiza previsiones de matriculación de alumnos en las distintas evaluaciones.</li> 
</ul>
</blockquote>    
</div>
</div>
</div> 
</div>
</div>
<? include("../pie.php");?>  
</body>
</html>
