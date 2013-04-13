<?
session_start();
include("../../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<title>RECURSOS EDUCATIVOS, ENLACES, etc.</title>

<link href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css" media="screen" />
<link href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css" media="screen" />

<style type="text/css">
<!--
.style1 {
	color: #281;
}

-->
</style>
</head>

<body>

  <?php
include("../../../menu.php");
include("../mrecursos.php");
   echo "<div class='titulin' style='margin-left:150px; color:#281;margin-top:0px'>Enlaces, Marcadores, Favoritos...</div>";
?>
<div  align="center"><table><tr><td>
        <span class='titulin' style="width:280px;">Selecciona una Categor&iacute;a</span>

        	<form name="categoria" method="POST" action="index.php" style="margin-left:22px;"> 
          <input style="color:#281;" type='radio' name='categoria' value='ARTE Y CULTURA' onClick="submit()" <? if ($categoria == "ARTE Y CULTURA") {echo "checked";}?>>
          Arte y Cultura<br>
          
          <input type='radio' name='categoria' value='CIENCIA Y TECNOLOG&Iacute;A'onclick="submit()" <? if ($categoria == "CIENCIA Y TECNOLOGÍA") {echo "checked";}?>>
          Ciencia y Tecnología<br>
          
          <input type="radio" name='categoria' value='CIENCIAS SOCIALES' onClick="submit()" <? if ($categoria == "CIENCIAS SOCIALES") {echo "checked";}?>>
          Ciencias Sociales<br>
          
          <input type='radio' name='categoria' value='DEPORTES' onClick="submit()" <? if ($categoria == "DEPORTES") {echo "checked";}?>>
          Deportes<br>
          
          <input type='radio' name='categoria' value='EDUCACI&Oacute;N Y FORMACI&Oacute;N' onClick="submit()" <? if ($categoria == "EDUCACIÓN Y FORMACIÓN") {echo "checked";}?>>
          Educación y Formación<br>
          
          <input type='radio' name='categoria' value='GEOGRAF&Iacute;A' onClick="submit()" <? if ($categoria == "GEOGRAFÍA") {echo "checked";}?>>
          Geografía<br>
          
          <input type='radio' name='categoria' value='IDIOMAS' onClick="submit()" <? if ($categoria == "IDIOMAS") {echo "checked";}?>>
          Idiomas<br>
          
          <input type='radio' name='categoria' value='INFORM&Aacute;TICA E INTERNET' onClick="submit()" <? if ($categoria == "INFORMÁTICA E INTERNET") {echo "checked";}?>>
          Informática e Internet<br>
          
          <input type='radio' name='categoria' value='LENGUA Y LITERATURA' onClick="submit()" <? if ($categoria == "LENGUA Y LITERATURA") {echo "checked";}?>>
          Lengua y Literatura<br>
          
          <input type='radio' name='categoria' value='LENGUAS CL&Aacute;SICAS' onClick="submit()" <? if ($categoria == "LENGUAS CLÁSICAS") {echo "checked";}?>>
          Lenguas clásicas<br>
          
          <input type='radio' name='categoria' value='MATERIALES DE CONSULTA' onClick="submit()" <? if ($categoria == "MATERIALES DE CONSULTA") {echo "checked";}?>>
          Materiales de Consulta<br>
          
          <input type='radio' name='categoria' value='M&Uacute;SICA' onClick="submit()" <? if ($categoria == "MÚSICA") {echo "checked";}?>>
          Música<br>
          
          <input type='radio' name='categoria' value='ORGANISMOS P&Uacute;BLICOS' onClick="submit()" <? if ($categoria == "ORGANISMOS PÚBLICOS") {echo "checked";}?>>
          Organismos públicos<br>
          
          <input type='radio' name='categoria' value='CAJ&Oacute;N DE SASTRE' onClick="submit()" <? if ($categoria == "CAJÓN DE SASTRE") {echo "checked";}?>>
          Cajón de Sastre 	
        </form>
</td>
<td valign="top">
    <form name="apartado" method="POST" action="consulta.php" target="_top">
      <?php
  
$categoria=$_POST['categoria'];
echo "<input type ='hidden' name='categ' value='$categoria'>";
if($categoria){echo "<span class='titulin' style='width:300px;'>Apartados de <span style='color:#369'>$categoria</span></span>";
echo"<select name='apartado' class='formselect' style='margin-left:40px; margin-top:10px;'>";
$apartado=mysql_query("SELECT apartado FROM categorias WHERE categoria like '$categoria%'  ORDER BY apartado ASC");
if ($fapartado = mysql_fetch_array($apartado))
        {
        do {
	      echo "<OPTION class='formoption'>$fapartado[0]</OPTION>";
	} while($fapartado = mysql_fetch_array($apartado));
	}
echo "</select>";
}else{
echo "<span class='titulin' style='width:300px'>Apartados</span>";
echo "<select name='apartado' class='formselect' style='margin-left:40px; margin-top:10px;width:150px;'>";
echo "</select>";
}
?>
  <span class='titulin' style='width:300px'>Texto a Buscar</span><input name="texto" type=input id="forminput" style="margin-left:40px; margin-top:10px">
      <input name="submit" type=submit id="formsubmit" value="Consultar Enlaces" style=" display:block;margin-left:40px; margin-top:10px" onMouseOver="this.style.color='#281';this.style.backgroundColor='#ddd'" onMouseOut="this.style.color='#369';this.style.backgroundColor='#eee'"></form>
</td></tr></table></div>
</body>
</html>
