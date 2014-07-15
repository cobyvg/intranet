  <?php
       $nivelgrupo = mysql_query("select unidad from FALUMNOS where claveal = '$claveal'");
     $nivelgrupo1 = mysql_fetch_array($nivelgrupo);
   
horario_alumno($nivelgrupo1[0])
     ?>
