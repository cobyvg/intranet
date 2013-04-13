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
?>
<?
include("../menu.php");
include("menu.php");
?>

<div align="center">
 <div class="page-header" align="center">
  <h1>Centro TIC <small> Normas de uso</small></h1>
</div>
<br />

  <div class="well-2 well-large" style="width:800px;" align="left">
    <h6>1. Protocolo de uso. </h6>
    <br />
    <h5>1.1. Reserva del carro de port&aacute;tiles.</h5>
    <p>La reserva de los Ordenadores o Aulas TIC se realizar&aacute;
      a trav&eacute;s de la Intranet del Centro o de la Conserjer&iacute;a del mismo.</p>
    <h5>1.2. Solicitud de la llave.</h5>
    <p>En conserjer&iacute;a se debe pedir la llave correspondiente
      al carro que se ha reservado. En ning&uacute;n caso se dar&aacute; esta llave a un/a
      alumno/a. Junto con la llave de la dependencia donde se guarda el carro
      estar&aacute; la llave que abre el propio carro.</p>
    <h5>1.3. Llevando el carro a clase.</h5>
    <p>El carro con los ordenadores puede ser llevado al aula
      por el profesor o los alumnos, pero en ning&uacute;n caso s&oacute;lo por los alumnos.
      El profesor debe supervisar en todo momento el transporte del carro hasta
      el aula. </p>
    <h5>1.4. Repartiendo los port&aacute;tiles.</h5>
    <p>El reparto de los port&aacute;tiles se llevar&aacute; acabo con la
      colaboraci&oacute;n de los Ayudantes TIC. El alumno que recibe el ordenador debe
      revisar el estado en el que se le entrega el equipo y dar parte de forma
      inmediata en caso de encontrar cualquier problema. En este caso, el profesor
      tomar&aacute; nota para proceder a continuaci&oacute;n a registrar la incidencia mediante
      el formulario habilitado en la Intranet. Durante el reparto se debe rellenar
      la hoja de asignaci&oacute;n ordenador-alumnado. Esta hoja, debidamente cumplimentada,
      se entregar&aacute; en Conserjer&iacute;a para su archivo. Los ordenadores llevan un
      n&uacute;mero identificativo que facilitar&aacute; esta labor.</p>
    <h5>1.5. Encendiendo los port&aacute;tiles.</h5>
    <p>La conexi&oacute;n inal&aacute;mbrica de los ordenadores provoca
      que el arranque pueda llegar a ser extremadamente lento. Es mejor que los
      alumnos vayan encendiendo el ordenador conforme lo vayan recibiendo y que
      el proceso de reparto se haga con tranquilidad. En principio todos, alumnado
      y profesorado, pueden acceder con nombre de usuario &ldquo;usuario” y contraseña también “usuario”. Sin embargo, el acceso recomendado
      es el acceso personalizado, tanto de Alumnos como Profesores, mediante
      el uso de nombres de usuario y contraseñas individuales. El profesor puede
      obtener los nombres de usuario y contraseña de sus alumnos mediante el
      enlace “Usuario Alumno” en la Intranet, y los suyos mediante el enlace
      “Usuario Profesor”. Es muy recomendable que la primera vez que el profesor
      o el alumno entren en el sistema procedan a cambiar la contrase&ntilde;a abriendo
      el Navegador y dirigi&eacute;ndose a la p&aacute;gina <span
 style='color:#261'>http://c0/gesuser.</span> <br>
      Nota: si el ordenador avisa de que no hay red se debe comprobar que el bot&oacute;n
      de la red inal&aacute;mbrica est&aacute; en la posici&oacute;n ON y que el led correspondiente
      est&aacute; encendido (de color naranja). </p>
    <h5>1.6. Usando los port&aacute;tiles.</h5>
    <p>Durante la clase procuraremos que el uso de los port&aacute;tiles
      sea cuidadoso y adecuado. Debemos hacer entender a los/las alumnos/as lo
      importante que es cuidar un material que usar&aacute;n y compartir&aacute;n varios a&ntilde;os.
      No debemos dudar en tomar nota y sancionar a los alumnos responsables de
      un mal uso intencionado del equipo.</p>
    <h5>1.7. Recogida de los equipos.</h5>
    <p>Los ordenadores ser&aacute;n recogidos con la colaboraci&oacute;n
      de los Ayudantes TIC que revisar&aacute;n su estado. En caso de que se contemplen
      desperfectos se registrar&aacute; la incidencia en la Intranet. Se comprobar&aacute;
      que est&aacute;n apagados y se enchufar&aacute;n a su cargador en la bandeja correspondiente.
      Se comprobar&aacute; que se han devuelto todos los port&aacute;tiles, que la carpeta
      est&eacute; en la bandeja inferior de la izquierda y se cerrar&aacute;n las puertas.</p>
    <h5>1.8. Y para terminar.</h5>
    <p>El carro lo debemos llevar al lugar donde se guarda
      y dejarlo enchufado para que la pr&oacute;xima vez que se use est&eacute;n los port&aacute;tiles
      cargados. Nunca dejaremos abierta la estancia donde se guarda el carro.
      Devolveremos las llaves y registraremos, si los hubiera, los partes de
      incidencias en la Intranet.</p>
      <hr>
    <h6>2. Recomendaciones</h6><br />
    <p>1.1. Es recomendable que, antes de usar
      los port&aacute;tiles en clase, comprobemos que la actividad que hemos programado
      funcione en los ordenadores de la red TIC. Esto se puede hacer c&oacute;modamente
      en el ordenador del Departamento (siempre que se conecte a la red TIC).</p>
    <p>1.2. Una vez comprobado el funcionamiento
      debemos prever que, en caso de usar un recurso directamente desde internet,
      varias decenas de ordenadores trabajando a la vez en una p&aacute;gina puede no
      permitir un trabajo fluido. Una clase con ordenadores que no funcionan
      puede ser muy frustrante y provocar&aacute; que el alumnado no se concentre y
      se pierda la hora.</p>
    <p>1.3. Si lo que queremos es mostrar a
      los alumnos un recurso no interactivo (una presentaci&oacute;n. una p&aacute;gina web,
      un v&iacute;deo etc..) es m&aacute;s f&aacute;cil usar un port&aacute;til y un proyector en vez de
      repartir 15 ordenadores. Se pondr&aacute; a disposici&oacute;n del profesorado un sistema
      de reserva de proyectores en la Intranet.</p>
    <p>1.4. A continuaci&oacute;n se enumeran algunas circunstancias
      que pueden da&ntilde;ar gravemente el material:</p>
    <p>a) Dejar caer sobre la mesa un port&aacute;til
      desde una altura de cinco cent&iacute;metros puede da&ntilde;ar diversos componentes,
      entre ellos el disco duro.</p>
    <p>b) Abrir o cerrar bruscamente el port&aacute;til
      puede provocar da&ntilde;os en el mecanismo de la pantalla.</p>
    <p>c) Tocar la pantalla con los dedos
      o con cualquier objeto puede dejar marcas y ara&ntilde;azos permanentes.</p>
    <p>d) El teclado es de tacto suave y por tanto
      no es necesario aporrearlo. Un teclado de port&aacute;til no se puede cambiar
      como uno de sobremesa.</p>
    <p>e) La suciedad en general y los l&iacute;quidos
      en particular son incompatibles con el ordenador port&aacute;til. No debemos dejar
      que se use con las manos sucias o mojadas y, por supuesto, no debemos tener
      cerca ning&uacute;n tipo de l&iacute;quido para evitar derramarlo por accidente sobre
      el equipo.</p>
    <hr>
    <h6>3. El Portátil</h6>
    <br />
    <p>El
      ordenador es un TOSHIBA Tecra M5. Pantalla de 14'' y procesador de
      doble n&uacute;cleo. Tiene 512 Mb de memoria RAM, uno de sus pocos puntos
      d&eacute;biles.</p>
    <div align="center">
    <img width=188 height=126
  src="archivos/image002.jpg"> 
  <img width=235 height=157
  src="archivos/image004.jpg">
  </div><br />
    <p>En
      el lateral izquierdo disponemos de un conector VGA (en azul) en el
      que podremos acoplar un proyector, un puerto FireWire para conectar una
      c&aacute;mara de v&iacute;deo digital y un puerto USB. Adem&aacute;s dispone de ranuras
      para tarjetas PCMCIA y SD/MMC. </p>
<div align="center">
    <img width=235 height=157
  src="archivos/image006.jpg">
  </div><br />
    <p>En
      el lateral derecho est&aacute; el control de volumen, la entrada y salida
      de audio para micr&oacute;fono y auriculares y dos puerto USB. Aunque la
      mayor&iacute;a no lleva unidad de CD/DVD, si la llevara, en este costado
      es donde estar&iacute;a.</p>
    <p>En
      la parte trasera disponemos de una salida SVHS y los conectores de
      modem, red y corriente el&eacute;ctrica. Tambi&eacute;n podemos apreciar la bater&iacute;a
      de gran capacidad que permite que pueda estar sin conectar a la corriente
      el&eacute;ctrica durante varias horas.</p>
<div align="center">
    <img width=235 height=157
  src="archivos/image008.jpg"> 
  <img width=209 height=140
  src="archivos/image010.jpg">
  </div><br />
    <p>Una
      vez abierto, vemos entre los dos altavoces de la parte superior del
      teclado, entre otros, el bot&oacute;n de encendido. La superficie t&aacute;ctil
      y los botones que la acompa&ntilde;an hacen la funci&oacute;n de rat&oacute;n.</p>
    <p>Este
      ser&iacute;a el aspecto de los leds frontales de un port&aacute;til encendido (en
      verde) y conectado a la red inal&aacute;mbrica (en naranja). Cerca del led
      naranja encontramos el bot&oacute;n que permite habilitar o deshabilitar
      la tarjeta de red inal&aacute;mbrica.</p>
<div align="center">
    <img width=235 height=157
  src="archivos/image012.jpg" align="center"> 
  </div><br />
  
  </div>
</div>
<?php
include("../pie.php");
?>
</body></html>