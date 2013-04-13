<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<LINK href="../estilo.css" rel="stylesheet" type="text/css">
<LINK href="../esquema.css" rel="stylesheet" type="text/css">

<title>Modificar Datos</title>
</head>

<body>
<?
define('IN_PHPATM', true);
include('include/conf.php');
include('include/common.'.$phpExt);

function show_rename_file($filename, $owner_name, $description)
{
include('../menu.php');	
echo '';
		global $bordercolor, $headercolor, $font, $headerfont, $headerfontcolor, $tablecolor,
		   $directory, $order, $direction, $normalfontcolor, $mess, $phpExt;
  echo "  <table width=\"90%\"class=tabla align=center>\n";
  echo "    <tr>\n";
  echo "      <th align=\"left\" valign=\"middle\" id=filaprincipal>$mess[193]</th>\n";
  echo "    </tr>\n";
  echo "    <tr>\n";
  echo "        <td align=\"left\" valign=\"middle\">\n";
  echo "        <form name=\"rename\" action=\"index.$phpExt?".SID."\" enctype=\"multipart/form-data\" method=\"post\" style=\"margin: 0\">\n";
  echo "          <input type=\"hidden\" name=\"old_description\" value=\"$description\">\n";
  echo "          <input type=\"hidden\" name=\"filename\" value=\"$filename\">\n";
  echo "          <input type=\"hidden\" name=\"action\" value=\"rename\">\n";
  echo "          <input type=\"hidden\" name=\"directory\" value=\"$directory\">\n";
  echo "          <input type=\"hidden\" name=\"order\" value=\"$order\">\n";
  echo "          <input type=\"hidden\" name=\"direction\" value=\"$direction\">\n";
  echo "          <table border=\"0\" width=\"100%\" >\n";
  echo "            <tr>\n";
  echo "              <td align=\"left\" width=\"15%\">$mess[19]</td>\n";
  echo "              <td align=\"left\" width=\"90%\" colspan=\"2\">\n";
  echo "                $owner_name";
  echo "              </td>\n";
  echo "            </tr>\n";
  echo "            <tr>\n";
  echo "              <td align=\"left\" width=\"15%\">$mess[192]</td>\n";
  echo "              <td align=\"left\" width=\"90%\" colspan=\"2\">\n";
  echo "                <input type=\"text\" class=\"vform\" name=\"userfile\" size=\"62\" value=\"$filename\" />\n";
  echo "              </td>\n";
  echo "            </tr>\n";
  echo "            <tr> \n";
  echo "              <td align=\"left\" width=\"15%\">$mess[22]</td>\n";
  echo "              <td align=\"left\" width=\"70%\">\n";
  echo "                <input type=\"text\" name=\"new_description\" class=\"vform\" size=62 value=\"$description\">\n";
  echo "              </td>\n";
  echo "              <td align=\"right\" width=\"15%\">\n";
  echo "                <input type=\"submit\" class=\"vform\" value=\"$mess[191]\" />\n";
  echo "              </td>\n";
  echo "            </tr>\n";

  echo "          </table>\n";
  echo "        </form>\n";

  echo "        </td>\n";
  echo "    </tr>\n";
  echo "    </table>\n";
}

function show_rename_dir($filename)
{
	global $bordercolor, $headercolor, $font, $headerfont, $headerfontcolor, $tablecolor,
		   $directory, $order, $direction, $normalfontcolor, $mess, $phpExt;

  echo "  <br>";
  echo "  <table border=\"0\" width=\"90%\" class=tabla>\n";
  echo "    <tr>\n";
  echo "      <th align=\"left\" valign=\"middle\" id=filaprincipal>$mess[193]</th>\n";
  echo "    </tr>\n";
  echo "    <tr>\n";
  echo "        <td align=\"left\" valign=\"middle\">\n";
  echo "        <form name=\"rename\" action=\"index.$phpExt?".SID."\" enctype=\"multipart/form-data\" method=\"post\" style=\"margin: 0\">";
  echo "          <input type=\"hidden\" name=\"action\" value=\"rename\">\n";
  echo "          <input type=\"hidden\" name=\"filename\" value=\"$filename\">\n";
  echo "          <input type=\"hidden\" name=\"directory\" value=\"$directory\">\n";
  echo "          <input type=\"hidden\" name=\"order\" value=\"$order\">\n";
  echo "          <input type=\"hidden\" name=\"direction\" value=\"$direction\">\n";
  echo "          <table border=\"0\" width=\"100%\" cellpadding=\"4\">\n";
  echo "            <tr>\n";
  echo "              <td align=\"left\" width=\"15%\">$mess[187]</td>\n";
  echo "              <td align=\"left\" width=\"70%\" colspan=\"2\">\n";
  echo "                <input type=\"text\" class=\"vform\" name=\"userfile\" size=\"62\" value=\"$filename\" />\n";
  echo "              </td>\n";
  echo "              <td align=\"right\" width=\"15%\">\n";
  echo "                <input type=\"submit\" class=\"vform\" value=\"$mess[191]\" />\n";
  echo "              </td>\n";
  echo "            </tr>\n";
  echo "          </table>\n";
  echo "        </form>\n";

  echo "        </td>\n";
  echo "    </tr>\n";
  echo "    </table>\n";
}

switch($action)
{
	case 'rename';
		list($upl_user, $upl_ip, $contents) = get_file_description("$uploads_folder_name/$directory/$filename", 0, 0);
		place_message($mess[191], $mess[193], basename(__FILE__));

		if (!is_dir("$uploads_folder_name/$directory/$filename"))
			show_rename_file($filename, $upl_user, $contents);
		else
			show_rename_dir($filename);

		break;

	default;
		header($header_location.'index.'.$phpExt.'?'.SID);
		break;
}

//show_footer_page();
?>
