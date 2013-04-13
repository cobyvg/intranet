# [Intranet del I.E.S. Monterroso](http://www.iesmonterroso.org/intranet_ies/)

Lo que aquí llamamos la Intranet del Monterroso es una aplicación web creada y probada a lo largo de más de seis años en el Instituto del mismo nombre dentro del Programa de Autoevaluación y Mejora de la Consejería de Educación de la Junta de Andalucía.

Ha sido pensada para facilitar y simplificar el trabajo diario de los profesores en general, y especialmente del Equipo directivo, los Tutores, los Jefes de Departamento, etc. La aplicación es en realidad un conjunto de módulos interconectados que responden a tareas específicas que debe realizar un profesor en su trabajo diario. Estos módulos, a su vez, han surgido de necesidades planteadas por profesores determinados: el Jefe de Estudios, el Secretario, los Tutores, etc.

* Código: [https://github.com/IESMonterroso/intranet](https://github.com/IESMonterroso/intranet)
* Página web: [http://iesmonterroso.org/intranet_ies/](http://iesmonterroso.org/intranet_ies/)


## Requisitos

Puede ser ejecutada sobre cualquier sistema operativo en el que funcionen Apache, PHP y MySQL.
La Intranet es entregada bajo la licencia GPL, por lo que el código que liberamos puede ser editado, modificado, personalizado y, por supuesto, mejorado a vuestro gusto.


## Características

La Intranet funciona a partir de un conjunto de datos que son importados desde Séneca: profesores, alumnos, asignaturas, etc. La compatibilidad con Séneca es tan alta como lo permite la propia aplicación de la Junta de Andalucía, que, no debe olvidarse, es una aplicación propietaria y cerrada. Dispone de un sencillo proceso de instalación que permite ajustar los datos esenciales a un Centro determinado, y un sistema de importación de datos a partir de Séneca que en pocos minutos la pone a funcionar. Los módulos más importantes que contiene son los siguientes:

* un conjunto de páginas de consulta que presentan datos de los alumnos, listas de grupos y horarios tanto de grupos como de profesores y aulas.
* un módulo para registrar los problemas de convivencia, las expulsiones del Centro, etc. (Asociado al módulo de envío de SMS)
* otro módulo para poner y justificar las faltas de asistencia de los alumnos, que posteriormente pueden ser exportadas a Séneca, y que nos ahorra el penoso trabajo de realizar la misma tarea con esa aplicación (Asociado al módulo de envío de SMS).
* un módulo para generar informes para el Tutor que recibe la visita de los padres de un alumno, y pide a los miembros de su equipo educativo que le digan cómo va el alumno en su asignatura.
* otro módulo para rellenar tareas para un alumno que va a ser expulsado del centro durante un tiempo, activado por un Tutor o el Jefe de Estudios.
* un conjunto de páginas destinadas al Tutor de un grupo, donde este puede ver todos los datos relevantes de los alumnos de su tutoría (faltas de asistencia, problemas de convivencia, tareas por expulsión, visitas de padres, actividades extraescolares de su grupo, etc.), así como registrar las distintas intervenciones que realiza en su tarea de tutor. Todo ello se presenta en un informe de Tutoría que sólo tendrá que imprimir a final de curso y presentar a la Dirección.
* un módulo de comunicación interna entre los usuarios de la Intranet que permite enviar y recibir mensajes.
* un sistema de envío de mensajes SMS, que se activará automáticamente en caso de problemas de convivencia graves, faltas de asistencia continuadas, o que se podrá utilizar para poner en contacto rápido al tutor o la Dirección con los padres de un alumno.
* un módulo para registrar y gestionar las Actividades Extraescolares.
* dos módulos para los libros de texto. El primero permite crear la lista de los libros de texto por Departamento para os distintos niveles del centro (para consulta de padres y librerías, por ejemplo). El segundo es un módulo completo para la gestión de los libros de textos gratuitos por parte de los Tutores y la Secretaría del Centro dentro del Programa de la Consejería de Educación.
* un conjunto de páginas destinadas a generar Memorias para Jefatura de estudios y Tutores a final de Curso.

La aplicación ha sido pensada también para realizar tareas específicas de un Centro TIC. Los siguientes módulos están orientados a las tareas propias de un Centro TIC:

* un sistema de reservas para los carros de portátiles o aulas con ordenadores.
* otro sistema de reservas para las aulas específicas y medios audiovisuales.
* un módulo para la gestión y registro de incidencias y problemas con los ordenadores.
* un módulo para la creación de los usuarios TIC, tanto alumnos como profesores, preparado para el alta masiva en Gesuser y en la Plataforma educativa (en nuestro caso, Moodle).
* un módulo para la creación de una base de datos de Recursos educativos por departamento, asignatura, etc.
* una página que concentra los documentos esenciales de un Centro TIC.
* una página de estadísticas de uso de los recursos TIC por profesor, carrito, etc.


## Notas de la instalación

La primera vez que se instala la Intranet, hay que tener en cuenta que se ha creado un único usuario `admin`, con contraseña `12345678`.

Si ya está operativa la Intranet, es necesario editar el campo DNI y ponerlo como `12345678` en las tablas `c_profes` y `departamentos`, y borrar la antigua contraseña de `admin` antes de acceder a la aplicación.

El campo `PASS` de `c_profes` debe aumentarse a 48 caracteres mediante phpMyAdmin si la Intranet ya está operativa y las bases de datos se mantienen.

Una vez entramos por primera vez, nos vamos a la página de configuración de la Intranet (Administración --> Cambiar configuración) y rellenamos los datos que queden pendientes, completando el proceso de configuración. Una vez terminado, puede comenzar la importación de datos desde los archivos descargados de Séneca.

La aplicación es compatible con las versiones 4.X y 5.X de PHP.


## Más información

Más información sobre los requisitos y condiciones de la instalación de la aplicación se pueden encontrar en [http://iesmonterroso.org/intranet_ies/](http://iesmonterroso.org/intranet_ies/)
