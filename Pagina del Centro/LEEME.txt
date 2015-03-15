

INSTRUCCIONES PARA PONER EN FUNCIONAMIENTO ESTAS PÁGINAS.

-----------------------------------------------------------------------------------------------------------------------------------------------

Esta web que ofrecemos de modo complementario a la aplicación de la Intranet está vinculada por completo a la misma. Se supone que la Intranet 
ha sido instalada y está operativa tras importar los datos de Séneca y adaptarla a las características del Centro. Elementos esenciales de 
la web no podrán funcionar sin los datos de la Intranet por lo que no debe instalarse si la Intranet no está operativa. Estas páginas han sido 
pensadas para ofrecer información pública a la comunidad educativa de un Centro, pero también para ofrecer información privada mediante acceso 
restringido a padres / alumnos. Se presenta a modo de plantilla que los Centros pueden adaptar fácilmente a sus peculiaridades. 

El elemento más importante de la web es el módulo que permite el <<Acceso para Alumnos>> y sus padres de forma privada. Este espacio privado y 
protegido por clave de usuario (NIE de Séneca suministrado por el Centro) y contraseña (generada por el propio usuario) ofrece datos contenidos 
o creados en la Intranet, y está indisolublemte unido a esa aplicación. Las posibilidades ofrecidas son todas las que nuestro Centro ha 
considerado relevantes, pero puede suceder que otro Centro considere inoportuno ofrecerlas a su comunidad educativa. Si alguna de las 
secciones es considerada inadecuada (los Informes de Tutoría, la descripción detallada de los problemas de convivencia, etc.) para ser visible 
por los padres, editar el menú de la sección y comentarla para que desaparezca de la vista.  

------------------------------------------------------------------------------------------------------------------------------------------------

1. Comienza editando el archivo conf_principal.php. Aquí se encuentran las opciones fundamentales de la configuración de estas páginas. Los datos
 que se solicitan son simples y no plantean problemas.
 
2. Puedes adaptar estas páginas a tu Centro y elegir las opciones que deseas presentar al público simplemente borrando o comentando 
las opciones del Menú principal que es común a todas las páginas. 
Abre la página "/menu.php" y procede a cambiarlo a tu gusto. Como puedes ver, algunas opciones (AMPA, Situeción del Centro, Plan del Centro, etc) 
sólo están activas para el IES Monterroso, pero las páginas están  presentes y preparadas para que las adaptes a tu Centro y actives la opción 
correspondiente en este menu.

3. El logo del Centro que aparece colocado en la parte superior izquierda de la barra de menú es un archivo GIF de 60px de ancho. Se encuentra en el
directorio raíz de la página.

4. En el directorio /css vienen un conjunto de archivos que cambian los estilos, colores y tipografías de estas páginas. En el archivo de 
configuración (/conf_principal.php) puedes elegir entre los múltiples archivos que modifican el estilo de la web. Prueba y selecciona el preferido.

5. Las fotos del Centro se encuentran en el directorio /reportajes. Sustitúyelas por las que consideres convenientes o simplemente elmina el enlace 
 poniendo a 0 el valor de <<$mod_fotos>> en el archivo de configuración.
 
6. La página dedicada al Equipo Directivo contiene datos de nuestro Centro en <<Teléfonos y Contacto>>, así como en el apartado <<Funciones>> 
(que ha sido extraído del Plan del Centro). Edita la página con un editor de textos y sustituye los datos por los de tu propio Centro.
 En el menú de esta sección hay un enlace llamado <<Documentación>> que lleva a un directorio con nombre <<Documentos del Centro>>. Este 
 directorio se encuentra dentro del directorio de los Documentos que hemos escrito en el archivo de configuración. Nosotros colocamos ahí archivos de
 texto en formato PDF con el Plan del Centro, por ejemplo, y otros archivos que el Centro considera que es conveniente exponer a la Comunidad Educativa
 del mismo.
 
7. La página de los Departamentos toma los datos de los Departamentos importados en la Intranet y supone que en el directorio de documentación 
existe un subdirectorio llamado <<departamentos>> con subdirectorios con el nombre de los mismos (departamentos/Filosofia, departamentos/Educacion Fisica, 
etc.). 
Estos directorios deben ser creados a mano con un nombre igual al del departamento en la Intranet, pero sin acentos. ni añadidos 
(P.E.S., Bil, etc). Ahí se pueden colocar materiales que los Departamentos consideren útiles y visibles para la comunidad educativa. 
Si no quieres crear un directorio para los Departamentos, modifica el valor de <<$mod_departamentos>> en el archivo de configuración escribiendo 
un 0 como valor.

8. Las páginas dedicadas a los diferentes estudios ofertados por el Centro contienen datos generales para la ESO y el Bachillerato. Pero también
contienen datos particulares sobre estudios específicos de nuestro Centro. Para adaptar la información a tu Centro debes editar estas páginas 
y para ello te puedes servir de cualquiera de ellas como plantilla. La estructura es sencilla y no debe plantear dificultades.

9. En la parte derecha de la página principal hay una sección con el título <<Otras páginas>>
 que contiene enlaces a páginas relacionadas con nuestro Centro. Edítalas a tu gusto para adaptarlas a tu Centro. 
 Esta sección se encuentra en el archivo <<fijos.php> que puedes encontrar en el directorio raíz. 
 
10. El <<Calendario>> de la página principal toma los datos del Calendario del Centro que edita el Equipo directivo desde la Intranet. De la misma manera, 
las <<Noticias>> se toman de la Intranet cuando hayan sido creadas por el Equipo directivo (y marcadas para enviar a la página pública del Centro).
 
