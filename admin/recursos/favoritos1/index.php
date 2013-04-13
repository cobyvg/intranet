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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<title>Páginas del <? echo $nombre_del_centro; ?>: RECURSOS EDUCATIVOS, ENLACES, etc.</title>

<link href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css" media="screen" />
<link href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>
  <?php
  include("../../../menu.php");
  include("../mrecursos.php");
  echo '<div align="center" style="width:620px;margin:auto">';
  echo "<div class='titulogeneral' style='margin-top:0px'>Añadir Enlaces y Marcadores a la Base de datos</div>";
?>

  <div style="float:left; margin-top:5px;border:#aaa solid 1px; text-align:left; width:300px;">
        <div  id='filaprincipal' style='width:100%;border-bottom:#aaa solid 1px;padding:3px 0px; text-align:center'>Selecciona una Categor&iacute;a</div>

        	<form name="categoria" method="POST" action="index.php" style=""> 
          <input style="color:#281;" type='radio' name='categoria' value='ARTE Y CULTURA' onClick="submit()">
          Arte y Cultura<br>
          
          <input type='radio' name='categoria' value='CIENCIA Y TECNOLOG&Iacute;A'onclick="submit()" >
          Ciencia y Tecnología<br>
          
          <input type="radio" name='categoria' value='CIENCIAS SOCIALES' onClick="submit()">
          Ciencias Sociales<br>
          
          <input type='radio' name='categoria' value='DEPORTES' onClick="submit()" >
          Deportes<br>
          
          <input type='radio' name='categoria' value='EDUCACI&Oacute;N Y FORMACI&Oacute;N' onClick="submit()" >
          Educación y Formación<br>
          
          <input type='radio' name='categoria' value='GEOGRAF&Iacute;A' onClick="submit()" >
          Geografía<br>
          
          <input type='radio' name='categoria' value='IDIOMAS' onClick="submit()" >
          Idiomas<br>
          
          <input type='radio' name='categoria' value='INFORM&Aacute;TICA E INTERNET' onClick="submit()">
          Informática e Internet<br>
          
          <input type='radio' name='categoria' value='LENGUA Y LITERATURA' onClick="submit()" >
          Lengua y Literatura<br>
          
          <input type='radio' name='categoria' value='LENGUAS CL&Aacute;SICAS' onClick="submit()">
          Lenguas clásicas<br>
          
          <input type='radio' name='categoria' value='MATERIALES DE CONSULTA' onClick="submit()" >
          Materiales de Consulta<br>
          
          <input type='radio' name='categoria' value='M&Uacute;SICA' onClick="submit()">
          Música<br>
          
          <input type='radio' name='categoria' value='ORGANISMOS P&Uacute;BLICOS' onClick="submit()">
          Organismos públicos<br>
          
          <input type='radio' name='categoria' value='CAJ&Oacute;N DE SASTRE' onClick="submit()" >
          Cajón de Sastre 	
        </form>
  </div>
  <div style="float:right;width:300px; margin-top:5px;border:#aaa solid 1px;">
    <form name="apartado" method="POST" action="entradas.php" target="_top">
      <?php
  
$categoria=$_POST['categoria'];
echo "<input type ='hidden' name='categ' value='$categoria'>";
if($categoria){echo "<div  id='filaprincipal' style='width:100%;border-bottom:#aaa solid 1px;padding:3px 0px;'>Apartados de <span style='color:#281'>$categoria</span></div>";
echo"<select name='apartado' style='float:left; width:150px;margin:12px 3px'>";
$apartado=mysql_query("SELECT apartado
FROM categorias WHERE categoria like '$categoria%'  ORDER BY apartado ASC");
if ($fapartado = mysql_fetch_array($apartado))
        {
        do {
	      echo "<OPTION class='formoption'>$fapartado[0]</OPTION>";
	} while($fapartado = mysql_fetch_array($apartado));
	}
echo "</select>";
}else{
echo "<div  id='filaprincipal' style='width:100%;border-bottom:#aaa solid 1px;padding:3px 0px;'>Apartados</div>";
echo "<select name='apartado'  style='float:left; width:150px;margin:12px 3px'>";
echo "</select>";
}
?>
      
      <input name="submit" type=submit  value="Introducir Enlace" style="float:right;margin:12px 3px" onMouseOver="this.style.color='#281';this.style.backgroundColor='#ddd'" onMouseOut="this.style.color='#369';this.style.backgroundColor='#eee'"></form>
	  </div>
	  </div>

</body>
</html>
