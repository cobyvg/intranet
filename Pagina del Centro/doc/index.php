<?
define('IN_PHPATM', true);
include('include/conf.php');
include('include/common.'.$phpExt);
//
function msdos_time_to_unix($DOSdate, $DOStime)
{
	$year = (($DOSdate & 65024) >> 9) + 1980;
	$month = ($DOSdate & 480) >> 5;
	$day = ($DOSdate & 31);
	$hours = ($DOStime & 63488) >> 11;
	$minutes = ($DOStime & 2016) >> 5;
	$seconds = ($DOStime & 31) * 2;
	return mktime($hours, $minutes, $seconds, $month, $day, $year);
}

//
//
function list_zip($filename)
{
	global $bordercolor, $headercolor, $tablecolor, $font, $headerfontcolor;
	global $normalfontcolor, $datetimeformat, $me;

	$fp = @fopen($filename,'rb');
	if (!$fp)
	{
		return;
	}
	fseek($fp, -22, SEEK_END);

	// Get central directory field values
	$headersignature = 0;
	do
	{
		// Search header
		$data = fread($fp, 22);
		list($headersignature,$numberentries, $centraldirsize, $centraldiroffset) =
			array_values(unpack('Vheadersignature/x6/vnumberentries/Vcentraldirsize/Vcentraldiroffset', $data));

		fseek($fp, -23, SEEK_CUR);
	} while (($headersignature != 0x06054b50) && (ftell($fp) > 0));

	if ($headersignature != 0x06054b50)
	{
		echo "<p><font face=\"$font\" size=\"3\" color=\"$normalfontcolor\">$mess[45]</p>";
		fclose($fp);
		return;
	}

	fseek($fp, $centraldiroffset, SEEK_SET);

	// Read central dir entries
	echo "<h3>$mess[46]</h3><br />";
	echo "<table class='table table-bordered' align='center'>";
	echo "<tr>
	<td>
		<b>$mess[15]</b>
	</td>
	<td>
		<b>$mess[17]</b>
	</td>
	<td>
		<b>$mess[47]</b>
	</td>
	</tr>";

	for ($i = 1; $i <= $numberentries; $i++)
	{
		// Read central dir entry
		$data = fread($fp, 46);
		list($arcfiletime,$arcfiledate,$arcfilesize,$arcfilenamelen,$arcfileattr) =
			array_values(unpack("x12/varcfiletime/varcfiledate/x8/Varcfilesize/Varcfilenamelen/x6/varcfileattr", $data));
		$filenamelen = fread($fp, $arcfilenamelen);

		$arcfiledatetime = msdos_time_to_unix($arcfiledate, $arcfiletime);

		echo "<tr>";

		// Print FileName
		echo '<td>';
		echo "";
		if ($arcfileattr == 16)
		{
			echo "<b>$filenamelen</b>";
		}
		else
		{
			echo $filenamelen;
		}

		echo '';
		echo '</td>';

		// Print FileSize column
		echo "<td>";

		if ($arcfileattr == 16)
			echo $mess[48];
		else
			echo $arcfilesize . ' bytes';

		echo '</td>';

		// Print FileDate column
		echo "<td>";
		echo date($datetimeformat, $arcfiledatetime);
		echo '</td>';
		echo '</tr>';
	}
	echo '</table></p>';
	fclose($fp);
	return;
}

//
//
function unix_time()
{
	global $timeoffset;
	$tmp = time() + 3600 * $timeoffset;
	return $tmp;
}

//
//
function file_time($filename)
{
	global $timeoffset;
	$tmp = filemtime($filename) + 3600 * $timeoffset;
	return $tmp;
}

//
//
function delete_file($filename)
{
	if (file_exists($filename))
		unlink($filename);

//	if (file_exists("$filename.desc"))
//		unlink("$filename.desc");

//	if (file_exists("$filename.dlcnt"))
//		unlink("$filename.dlcnt");
}

//echo "<br>";

function scan_dir_for_digest($current_dir, &$message)
{
	global $timeoffset, $comment_max_caracters, $datetimeformat, $uploads_folder_name;
	global $hidden_dirs, $showhidden;

	$currentdate = getdate();
	$time1 = mktime(0, 0, 0, $currentdate['mon'], $currentdate['mday']-1, $currentdate['year']);
	$time2 = $time1 + 86400;

	list($liste, $totalsize) = listing($current_dir);

	$filecount = 0;
	if (is_array($liste))
	{
		while (list($filename, $mime) = each($liste))
		{
			if(is_dir("$current_dir/$filename"))
			{
		      	if (preg_match('/'.$hidden_dirs.'/i', $filename) && !$showhidden)
		      	{
		      		continue;
		      	}

				$filecount += scan_dir_for_digest("$current_dir/$filename", $message);
				continue;
			}

			$file_modif_time = filemtime("$current_dir/$filename");
			if (($file_modif_time < $time1) || ($file_modif_time >= $time2))
				continue;

		    $filecount++;

			list($upl_user, $upl_ip, $contents) = get_file_description("$current_dir/$filename", $comment_max_caracters);

			$message.="
			    <tr valign=\"top\">
			        <td align=\"left\" width=\"45%\">
			          <font size=3>$filename<BR>
			          <font size=2>$contents
			        </td>
			        <td align=\"left\" width=\"30%\" valign=\"middle\">
			        	Documentos".ereg_replace($uploads_folder_name, '', $current_dir)."
			        </td>
			        <td align=\"right\"  nowrap valign=\"middle\">\n";
			$message.= get_filesize("$current_dir/$filename");
			$message.= "</td>
			 		<td align=\"left\"  nowrap valign=\"middle\">\n";
			$message.=date($datetimeformat, $file_modif_time - $timeoffset * 3600);
			$message.= "</td>
					<td align=\"left\"  valign=\"middle\">\n";

			if ($upl_user != "")
			$message.= "<b>$upl_user</b><br>";

			$message.= "
					</td>
				</tr>\n";
		}
	}

	return $filecount;
}

function init($directory)
{
	global $uploads_folder_name, $direction, $mess, $font, $normalfontcolor;

	$direction = ($direction == DIRECTION_UP) ? DIRECTION_DOWN : DIRECTION_UP;

	$current_dir = $uploads_folder_name;
	if ($directory != '')
		$current_dir = "$current_dir/$directory";

	if (!is_dir($uploads_folder_name))
	{
		echo "$mess[196]<br><br>
			  <a href=\"index.$phpExt?".SID."\">$mess[29]</a>\n";
		exit;
	}

	if (!is_dir($current_dir))
	{
		echo "$mess[30]<br><br>
			  <a href=\"javascript:window.history.back()\">$mess[29]</a>\n";
		exit;
	}

	return $current_dir;
}

//
//
function assemble_tables($tab1, $tab2)
{
	global $direction;

	$liste = '';

	if (is_array($tab1))
	{
		while (list($cle, $val) = each($tab1))
			$liste[$cle] = $val;
	}

	if (is_array($tab2))
	{
		while (list($cle, $val) = each($tab2))
			$liste[$cle] = $val;
	}

	return $liste;
}

//
//
function txt_vers_html($text)
{
	$text = str_replace('&', '&amp;', $text);
	$text = str_replace('<', '&lt;', $text);
	$text = str_replace('>', '&gt;', $text);
	$text = str_replace('\"', '&quot;', $text);
	return $text;
}

//
function listing($current_dir)
{
	global $direction, $order;

	$totalsize = 0;
	$handle = opendir($current_dir);
	$list_dir = '';
	$list_file = '';
	while (false !== ($filename = readdir($handle)))
    {
	    if ($filename != '.' && $filename != '..'
//	    	&& !eregi("\.desc$|\.dlcnt$|^index\.", $filename)
	    	&& show_hidden_files($filename))
		{
			$filesize=filesize("$current_dir/$filename");
			$totalsize += $filesize;
			if (is_dir("$current_dir/$filename"))
			{
				if($order == 'mod')
					$list_dir[$filename] = filemtime("$current_dir/$filename");
				else
					$list_dir[$filename] = $filename;
            }
            else
            {
            	switch($order)
            	{
					case 'taille';
						$list_file[$filename] = $filesize;
						break;
					case 'mod';
						$list_file[$filename] = filemtime("$current_dir/$filename");
						break;
					//case 'rating';
					//	$list_file[$filename] = count_file_download("$current_dir/$filename");
					//	break;
					default;
						$list_file[$filename] = get_mimetype_img("$current_dir/$filename");
						break;
				}
			}
		}
	}
    closedir($handle);

	if(is_array($list_file))
	{
       	switch($order)
    	{
			case 'taille':
			//case 'rating':
			//	$direction == DIRECTION_DOWN ? asort($list_file) : arsort($list_file);
			//	break;
			case 'mod':
				$direction == DIRECTION_DOWN ? arsort($list_file) : asort($list_file);
				break;
			default:
				$direction == DIRECTION_DOWN ? ksort($list_file) : krsort($list_file);
				break;
		}
	}

	if(is_array($list_dir))
	{
		if ($order == "mod")
		{
			$direction == DIRECTION_UP ? arsort($list_dir) : asort($list_dir);
		}
		else
		{
			$direction == DIRECTION_UP ? krsort($list_dir) : ksort($list_dir);
		}
	}

	$liste = assemble_tables($list_dir, $list_file);

	if ($totalsize >= 1073741824)
		$totalsize = round($totalsize / 1073741824 * 100) / 100 . " Gb";
	elseif ($totalsize >= 1048576)
		$totalsize = round($totalsize / 1048576 * 100) / 100 . " Mb";
	elseif ($totalsize >= 1024)
		$totalsize = round($totalsize / 1024 * 100) / 100 . " Kb";
	else
		$totalsize = $totalsize . " b";

    return array($liste, $totalsize);
}

//

function contents_dir($current_dir, $directory)
{
  global $font,$direction,$order,$totalsize,$mess,$tablecolor,$lightcolor;
  global $file_out_max_caracters,$normalfontcolor, $phpExt, $hidden_dirs, $showhidden;
  global $comment_max_caracters,$datetimeformat, $logged_user_name;
  global $user_status,$activationcode,$max_filesize_to_mail,$mail_functions_enabled, $timeoffset, $grants;

  // Read directory
  list($liste, $totalsize) = listing($current_dir);

  if(is_array($liste))
  {
    while (list($filename,$mime) = each($liste))
    {
      if (is_dir("$current_dir/$filename"))
      {

      	if (preg_match('/'.$hidden_dirs.'/i', $filename) && !$showhidden)
      	{
      		continue;
      	}

        $filenameandpath = "index.$phpExt?".SID."&direction=$direction&order=$order&directory=";

        if ($directory != '')
        	$filenameandpath .= "$directory/";

        $filenameandpath .= $filename;
      }
      else
      {
        $filenameandpath = '';
        if ($directory != '')
        {
        	$filenameandpath .= "$directory/";
        }
        $filenameandpath .= $filename;
      }

echo "
    <tr valign=\"top\">
      <td nowrap>
        <div align=\"left\">

    		  <img src=\"images/".get_mimetype_img("$current_dir/$filename")."\"align=\"ABSMIDDLE\" border=\"0\" style='margin-right:5px;'>";
		          if (is_dir("$current_dir/$filename"))
		          {
		          	echo "<a href=\"$filenameandpath\">";
		          }
		          else
		          {
		          	if (is_viewable($filename) || is_image($filename) || is_browsable($filename))
		            	{echo "<a href=\"javascript:popup('$filename', '$directory')\">";}
		          }
		echo      substr($filename,0,$file_out_max_caracters);
		          if(is_viewable($filename) || is_image($filename) || is_browsable($filename) || is_dir("$current_dir/$filename"))
		            {echo "</a>\n";}

		// Load description
		list($upl_user, $upl_ip, $contents) = get_file_description("$current_dir/$filename", $comment_max_caracters);

		echo "$contents";
		echo "</td>
      <td nowrap>
        <div align=\"left\">";


if ($grants[$user_status][DELALL] || ($upl_user == $logged_user_name && $grants[$user_status][DELOWN]))
{
	if (!is_dir("$current_dir/$filename"))
	{
		echo "&nbsp;
		      <a href=\"index.${phpExt}?action=deletefile&filename=$filename&directory=$directory\">
		        <i class='icon icon-trash' title='Borrar' alt=\"$mess[169]\" > &nbsp;&nbsp;</i></a>";
    }
    else
    {
    	if ($grants[$user_status][DELALL])
    	{
		    echo "&nbsp;
		      <a href=\"index.${phpExt}?action=deletedir&filename=$filename&directory=$directory\">
		        <i class='icon icon-trash' title='Borrar' alt=\"$mess[169]\" > &nbsp;&nbsp;</i></a>";
		}
    }
}
else
{
	echo "&nbsp; ";
}

//
//
if ($grants[$user_status][MODALL] || ($upl_user == $logged_user_name && $grants[$user_status][MODOWN]))
{
	if (!is_dir("$current_dir/$filename") || $grants[$user_status][MODALL])
	{
    }
}
else
{
	echo "&nbsp;";
}


//
//
//
if ($grants[$user_status][DOWNLOAD] && !is_dir("$current_dir/$filename"))
{
echo "        <a href=\"index.${phpExt}?action=downloadfile&filename=$filename&directory=$directory\">
              <i class='icon icon-download-alt' title='Descargar' alt=\"$mess[23]\" > &nbsp;&nbsp;</i>&nbsp;</a>";
echo       count_file_download("$current_dir/$filename");
}
else
	echo " ";

echo "    </div>
      </td>
      <td  nowrap>";

if (is_dir("$current_dir/$filename"))
	echo "directorio";
else
	echo      get_filesize("$current_dir/$filename");


echo "</td>
      <td  nowrap>";
$file_modif_time = filemtime("$current_dir/$filename") - $timeoffset * 3600;
echo      date($datetimeformat, $file_modif_time);

echo " </td></tr>\n";
    }
  }
}

//
//
function list_dir($directory)
{
	global $mess,$direction,$uploads_folder_name;
	global $font,$order,$totalsize,$tablecolor,$headercolor,$bordercolor;
	global $headerfontcolor, $normalfontcolor, $phpExt;
	$directory = clean_path($directory);
	$current_dir = init($directory);
	$filenameandpath = ($directory != '') ? "&directory=".$directory : '';

	echo "<script language=\"javascript\">\n";
	echo "function popup(file, dir) {";
	echo "var fen=window.open('index.${phpExt}?action=view&filename='+file+'&directory='+dir+'','filemanager','status=yes,scrollbars=yes,resizable=yes,width=500,height=400');\n";
	echo "}\n";
	echo "function popupmail(file, dir) {\n";
	echo "var fen=window.open('index.${phpExt}?action=mailfile&filename='+file+'&directory='+dir+'','filemanager','status=yes,scrollbars=yes,resizable=yes,width=500,height=400');\n";
	echo "}\n";
	echo "</script>\n";

		echo "

	  <table class='table table-striped table-bordered' align='center'>
	    <tr>
	      <th>$mess[15]<a href=\"index.${phpExt}?order=nom&direction=$direction".$filenameandpath."\">\n";
	          
	echo "</th>
	      <th nowrap>
	        $mess[16]<b>
	          <a href=\"index.${phpExt}?order=rating&direction=$direction".$filenameandpath."\">\n";
	       
	echo "
	      </th>
	      <th nowrap>$mess[17]
	          <a href=\"index.${phpExt}?order=taille&direction=$direction".$filenameandpath."\">\n";
	         
	echo "</th>
	      <th nowrap>
	        $mess[18]</th>";
	echo " </tr>\n";

	    $direction = ($direction == DIRECTION_DOWN) ? DIRECTION_UP : DIRECTION_DOWN;
        contents_dir($current_dir, $directory);
echo "<tr>
      <td align=\"right\" colspan=\"4\">
        <h5>$mess[43]: $totalsize</h5></td>
    </tr>
  </table>
	<br>";
}

//
function delete_dir($location)
{
	if(is_dir($location))
	{
		$all = opendir($location);
		while (false !== ($file = readdir($all)))
		{
			if (is_dir("$location/$file") && $file != '..' && $file != '.')
			{
				// echo "ESTAS SEGURO";
				delete_dir("$location/$file");
				rmdir("$location/$file");
			}
			elseif (is_file("$location/$file"))
			{
				//echo "ESTAS SEGURO $location/$file";
				unlink("$location/$file");
			}
			unset($file);
		}
		closedir($all);
		rmdir($location);
	}
	else
	{
		if (file_exists($location))
		{
			unlink($location);
		}
	}
}

//
function normalize_filename($name)
{
	global $file_name_max_caracters, $invalidchars;

	$name = stripslashes($name);

	reset($invalidchars);
	while (list($key, $value) = each($invalidchars))
	{
		$name = str_replace($value, '', $name);
	}

	$name = substr($name, 0, $file_name_max_caracters);
	return $name;
}

//
//
function show_contents()
{
global $current_dir,$directory,$uploads_folder_name,$mess,$direction,$timeoffset;
global $order,$totalsize,$font,$tablecolor,$bordercolor,$headercolor;
global $headerfontcolor,$normalfontcolor,$user_status, $grants, $phpExt;

echo "<div class='span10 offset1'>";
?>
<? 
echo "<div align='center'><br>
  <h3><i class='icon icon-file'> </i> Documentos del Centro</h3>
<hr />
<p class='lead muted'> Directorio público del IES Monterroso</p>
</div>
<div class='span10 offset1'>";
$directory = clean_path($directory);
if (!file_exists("$uploads_folder_name/$directory"))
{
	$directory = '';
}

if ($directory != '')
{

    $name = dirname($directory);
    if ($directory == $name || $name == '.')
    	$name = '';
echo "<h5 align='left'><a href=\"index.${phpExt}?direction=$direction&order=$order&directory=$name\">";
    echo "<i class='icon icon-chevron-up'> &nbsp;&nbsp;</i> \n";
    echo "</a>\n";
	echo split_dir("$directory");
	echo "</h5><br />";	

}


if ($grants[$user_status][VIEW])
{
  list_dir($directory);
}
if ($grants[$user_status][UPLOAD])
{
  echo "<div align='center' style='width:860px;'><div style='width:360px;margin:auto;text-align:left' class='well-2 pull-left'>";
  echo "<h6 align='center'>$mess[20]</h6><hr>";

  echo "        <form name=\"upload\" action=\"index.$phpExt?".SID."\" enctype=\"multipart/form-data\" method=\"post\" style=\"margin: 0\">\n";
  echo "          <input type=\"hidden\" name=\"action\" value=\"upload\">\n";
  echo "          <input type=\"hidden\" name=\"directory\" value=\"$directory\">\n";
  echo "          <input type=\"hidden\" name=\"order\" value=\"$order\">\n";
  echo "          <input type=\"hidden\" name=\"direction\" value=\"$direction\">\n";

  echo "<label>$mess[21]<br />";
  echo "                <input type=\"file\" name=\"userfile\" class='input-file span3' /></label>";
  echo "              <label>$mess[22]</br />";
  echo "                <input type=\"text\" name=\"description\" class=\"span3\" size=62></label>";
  echo "<input type=\"submit\" class=\"btn btn-primary\" value=\"$mess[20]\" />\n";
  echo "        </form></div>";

}

if ($grants[$user_status][MKDIR])
{
  echo "<div style='width:360px;margin:auto;text-align:left' class='well-2 pull-right'>";
  echo "<h6 align='center'>$mess[186]</h6><hr>";

  echo "        <form name=\"newdir\" action=\"index.$phpExt?".SID."\" enctype=\"multipart/form-data\" method=\"post\" style=\"margin: 0\">\n";
  echo "          <input type=\"hidden\" name=\"action\" value=\"createdir\">\n";
  echo "          <input type=\"hidden\" name=\"directory\" value=\"$directory\">\n";
  echo "          <input type=\"hidden\" name=\"order\" value=\"$order\">\n";
  echo "          <input type=\"hidden\" name=\"direction\" value=\"$direction\">\n";
  echo "            <tr> \n";
  echo "              <label>$mess[187]";
  echo "                <input type=\"text\" name=\"filename\" class=\"span3\"></label>";
  echo "                <input type=\"submit\" class=\"btn btn-primary\" value=\"$mess[188]\" />\n";
  echo "        </form></div>";

}

echo "</div>\n";
}

//
function is_path_safe(&$path, &$filename)
{
	global $uploads_folder_name;

	$path = clean_path($path);
	$filename = clean_path($filename);

	if (!file_exists("$uploads_folder_name/$path")
//		|| eregi("\.desc$|\.dlcnt$|^index\.|\.$",  $filename)
		|| !show_hidden_files($filename)
	   )
	{
		return false;
	}

	return true;
}

//----------------------------------------------------------------------------
//      MAIN
//----------------------------------------------------------------------------
switch($action)
{
	case 'deletefile';
			$current_dir = $uploads_folder_name;
		if ($directory != '')
			$current_dir.="/$directory";

		$filename = basename($filename);


		if (!file_exists("$current_dir/$filename"))
		{
			//// place_header($mess[125]);
			show_Contents();
			break;
		}

		if (is_path_safe($directory, $filename))
	    {
			list($upl_user, $upl_ip, $contents) = get_file_description("$current_dir/$filename", $comment_max_caracters);

			if ($grants[$user_status][DELALL] || ($upl_user == $logged_user_name && $grants[$user_status][DELOWN]))
			{
				delete_file("$current_dir/$filename");
//				// place_header($mess[180]);
			}
			else
			{
				// place_header($mess[181]);
			}
		}
		else
		{
			// place_header($mess[181]);
		}	    
		include("../cabecera.php");
              include("<div class='span10 offset1'>");show_contents();
		break;


	case 'deletedir';
		$current_dir = $uploads_folder_name;
		if ($directory != '')
			$current_dir.="/$directory";

		$filename = basename($filename);

		if (!file_exists("$current_dir/$filename"))
		{
			//// place_header($mess[125]);
			show_Contents();
			break;
		}

		if (is_path_safe($directory, $filename))
	    {
			if ($grants[$user_status][DELALL])
			{
				delete_dir("$current_dir/$filename");
			//	// place_header($mess[182]);
			}
			else
			{
				// place_header($mess[183]);
			}
		}
		else
		{
			// place_header($mess[183]);
		}	    include("../cabecera.php");
              include("<div class='span10 offset1'>");show_contents();
		break;

	case 'createdir';

		$current_dir = $uploads_folder_name;
		if ($directory != '')
			$current_dir.="/$directory";

		$filename = basename($filename);

      	if (preg_match($hidden_dirs, $filename) && !$showhidden)
      	{
      		// place_header($mess[206]);
      		show_contents();
			break;
      	}

		if (is_path_safe($directory, $filename))
		{
			$filename = normalize_filename($filename);

			if ($filename != '')
			{
				if ($grants[$user_status][MKDIR])
				{
					if (!file_exists("$current_dir/$filename"))
					{
						mkdir("$current_dir/$filename", 0777);
//						copy('include/index.html', "$current_dir/$filename/index.html");
//						copy('include/.htaccess', "$current_dir/$filename/.htaccess");
						//// place_header($mess[184]);
					}
					else
					{
//						// place_header($mess[189]);
					}
				}
				else
				{
//					// place_header($mess[185]);
				}
			}
			else
			{
//				// place_header($mess[190]);
			}
		}
		else
		{
//			// place_header($mess[185]);
		}	    include("../cabecera.php");
              include("<div class='span10 offset1'>");show_contents();
		break;

	case 'selectskin';
		setcookie("skinindex", $skinindex, time() + $cookievalidity * 3600);
		$bordercolor = $skins[$skinindex]['bordercolor'];
		$headercolor = $skins[$skinindex]['headercolor'];
		$tablecolor = $skins[$skinindex]['tablecolor'];
		$lightcolor = $skins[$skinindex]['lightcolor'];
		$headerfontcolor = $skins[$skinindex]['headerfontcolor'];
		$normalfontcolor = $skins[$skinindex]['normalfontcolor'];
		$selectedfontcolor = $skins[$skinindex]['selectedfontcolor'];
		// place_header($mess[96]);
		show_contents();
		break;

	case 'downloadfile';
		$current_dir = $uploads_folder_name;
		if ($directory != '')
			$current_dir.="/$directory";

		$filename = basename($filename);

		if (!$grants[$user_status][DOWNLOAD])
		{
			// place_header($mess[111]);
			show_Contents();
			break;
		}

		if (!file_exists("$current_dir/$filename"))
		{
			// // place_header($mess[125]);
			show_Contents();
			break;
		}

		if (!is_path_safe($directory, $filename))
		{
			// // place_header($mess[111]);
			show_Contents();
			break;
		}

		$size = filesize("$current_dir/$filename");
//		increasefiledownloadcount("$current_dir/$filename");

		if (($user_status != ANONYMOUS) && ($logged_user_name != ''))  // Update user statistics
		{
		  list($files_uploaded, $files_downloaded, $files_emailed) = load_userstat($logged_user_name);
		  $files_downloaded++;
		  save_userstat($logged_user_name, $files_uploaded, $files_downloaded, $files_emailed, time());
		}

		header("Content-Type: application/force-download; name=\"$filename\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: $size");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Expires: 0");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		readfile("$current_dir/$filename");
		exit;
		break;

	case 'view';
		$current_dir = $uploads_folder_name;
		if ($directory != '')
			$current_dir.="/$directory";

		$filename = basename($filename);

		if (!$grants[$user_status][VIEW])
		{
			header("Status: 404 Not Found");
			exit;
		}

		if (!file_exists("$current_dir/$filename") || !is_path_safe($directory, $filename))
		{
			header("Status: 404 Not Found");
			exit;
		}

		$filenametoview = basename($filename);
		page_header($mess[26].": ".$filenametoview);

		echo "<center><h4>$mess[26] : ";
		echo "<img src=\"images/".get_mimetype_img("$current_dir/$filename")."\" align=\"ABSMIDDLE\">\n";
		echo "".$filenametoview."<br><br><hr>\n";
		echo "<a href=\"javascript:window.print()\"><i class='icon icon-print' alt=\"$mess[27]\" border=\"0\"> &nbsp;&nbsp;</i></a>\n";
		echo "<a href=\"index.${phpExt}?action=downloadfile&filename=".$filename."&directory=".$directory."h.php\"><i class='icon icon-download-alt' alt=\"$mess[23]\" width=\"20\" height=\"20\" border=\"0\"> &nbsp;&nbsp;</i></a>";
		echo "<a href=\"javascript:window.close()\"><i class='icon icon-chevron-left' alt=\"$mess[28]\" border=\"0\"> &nbsp;&nbsp;</i></a>\n";
		echo "</h4>\n";


		if(!is_image($filename))
		{
			echo "</center>\n";
			if (is_browsable($filename))
			{
				list_zip("$current_dir/$filename");
			}
				else
			{
				$fp=@fopen("$current_dir/$filename", "r");
				if($fp)
				{
					echo "\n";
					while(!feof($fp))
					{
						$buffer=fgets($fp,4096);
						$buffer=txt_vers_html($buffer);
						$buffer=str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$buffer);
						echo $buffer."<br>";
					}
					fclose($fp);
					echo "\n";
				}
				else
				{
					echo "$mess[31] : $current_dir/$filename";
				}
			}
			echo "<center>\n";
		}
		else
		{
			echo "<img src=\"getimg.${phpExt}?image=$directory/$filename\">\n";
		}
		echo "<hr>\n";
		echo "<a href=\"javascript:window.print()\"><i class='icon icon-print' alt=\"$mess[27]\" border=\"0\"> &nbsp;&nbsp;</i></a>\n";
		echo "<a href=\"index.${phpExt}?action=downloadfile&filename=$filename&directory=$directory\"><i class='icon icon-download-alt' alt=\"$mess[23]\" width=\"20\" height=\"20\" border=\"0\"> &nbsp;&nbsp;</i></a>";
		echo "<a href=\"javascript:window.close()\"><i class='icon icon-chevron-left' alt=\"$mess[28]\" border=\"0\"> &nbsp;&nbsp;</i></a>\n";
		echo "<hr></center>\n";
		echo "</body>\n";
		echo "</html>\n";
		exit;
		break;

	case 'mailfile';

		$current_dir = $uploads_folder_name;
		if ($directory != '')
			$current_dir.="/$directory";

		$filename = basename($filename);

		if (!$grants[$user_status][MAIL] && !$grants[$user_status][MAILALL])
		{
			header("Status: 404 Not Found");
			exit;
		}

		if (!is_path_safe($directory, $filename) || !file_exists("$current_dir/$filename"))
		{
			header("Status: 404 Not Found");
			exit;
		}

		page_header($mess[26].": ".$filename);

		echo "<center><h4>$mess[26] : ";
		echo "<img src=\"images/".get_mimetype_img("$current_dir/$filename")."\" align=\"ABSMIDDLE\">\n";
		echo "<b>".$filename."</b><br><br><hr>\n";
		echo "<a href=\"javascript:window.close()\"><i class='icon icon-chevron-left' alt=\"$mess[28]\" border=\"0\"> &nbsp;&nbsp;</i></a>\n";
		echo "</h4>\n";

		if (($user_status != ANONYMOUS) && ($activationcode == USER_ACTIVE))
		{
			if ($grants[$user_status][MAILALL] || ((filesize("$current_dir/$filename") < $max_filesize_to_mail * 1024) && $grants[$user_status][MAIL]))
			{
				$body = $sendfile_email_body;
				// Load file description
				list($upl_user, $upl_ip, $contents) = get_file_description("$current_dir/$filename", 0, 0);

				if ($upl_user != '')
					$body .= sprintf($mess[70], $upl_user);
				$body .= "\n";
				if ($user_status == ADMIN) // If admin
					$body .= "IP: ".$upl_ip;
				$body .= "\n";
				$body .= $mess[92];
				$body .= get_filesize("$current_dir/$filename");
				$body .= "\n";
				$body .= $mess[90];
				$file_modif_time = file_time("$current_dir/$filename");
				$body .= date($datetimeformat, $file_modif_time);
				$body .= "\n\n";
				$body .= $mess[22].":\n";
				$body .= $contents;
				$body .= "\n
				$sendfile_email_end,
				$admin_name
				Email: mailto:$admin_email
				Web Page: $installurl";

				$mm = new MIME_MAIL("$admin_name <$admin_email>", $sendfile_email_subject, $body);
				$mm -> add_file("$current_dir/$filename");
				if ($mm -> send($user_email))
				{
					// Update statistics
					increasefiledownloadcount("$current_dir/$filename");
					if (($user_status != ANONYMOUS) && ($logged_user_name != ''))  // Update user statistics
					{
						list($files_uploaded, $files_downloaded, $files_emailed) = load_userstat($logged_user_name);
						$files_emailed++;
						save_userstat($logged_user_name, $files_uploaded, $files_downloaded, $files_emailed, time());
					}
					echo "<p><font face=\"$font\" size=\"3\" color=\"$normalfontcolor\">";
					echo sprintf($mess[69], "<b>".$user_email."</b>");
					echo "</p>";
				}
				else
				{
					echo "<p><font face=\"$font\" size=\"3\" color=\"$normalfontcolor\">";
					echo $mess[177]." ".$mess[179];
					echo "</p>";
				}
			}
		}

		echo "<hr>\n";
		echo "<a href=\"javascript:window.close()\"><i class='icon icon-chevron-left' alt=\"$mess[28]\" border=\"0\"&nbsp;</a>\n";
		echo "<hr></center>\n";
		echo "</body>\n";
		echo "</html>\n";
		exit;
		break;


	case 'upload';
		$message = $mess[40];
		$userfile_name = $userfile['name'];
		$userfile_size = $userfile['size'];
		$destination = $uploads_folder_name."/$directory";

		if (!$grants[$user_status][UPLOAD])
		{
			// // place_header(sprintf($mess[49], "<b>$userfile_name</b>"));
			show_contents();
			break;
		}

		if (!is_path_safe($directory, $userfile_name))
		{
			// // place_header(sprintf($mess[49], "<b>$userfile_name</b>"));
			show_contents();
			break;
		}

		if ($userfile_name == '')
		{
			$message = $mess[34];
		}

		if ($userfile_size != 0)
		{
			$size_kb = $userfile_size/1024;
		}
		else
		{
			$message = $mess[34];
			$size_kb = 0;
		}

		if ($userfile_name != '' && $userfile_size !=0)
		{
			$userfile_name = normalize_filename($userfile_name);
			if (file_exists("$destination/$userfile_name") || preg_match('/'.$rejectedfiles.'/i', $userfile_name) || ($size_kb > $max_allowed_filesize))
			{
				if ($size_kb > $max_allowed_filesize)
					$message="$mess[38] <b>$userfile_name</b> $mess[50] ($max_allowed_filesize Kb)!";
				else
					if (preg_match('/'.$rejectedfiles.'/i', $userfile_name))  // If file is script
						$message=sprintf($mess[49], "<b>$userfile_name</b>");
					else
						$message="$mess[38] <b>$userfile_name</b> $mess[39]";
			}
			else
			{
				if (($user_status != ANONYMOUS) && ($logged_user_name != ''))  // Update user statistics
				{
					list($files_uploaded, $files_downloaded, $files_emailed) = load_userstat($logged_user_name);
					$files_uploaded++;
					save_userstat($logged_user_name, $files_uploaded, $files_downloaded, $files_emailed, time());
				}

				// Save description
				$ip = getenv('REMOTE_ADDR');
//				save_file_description("$destination/$userfile_name.desc", $description, $logged_user_name, $ip);

				if (!move_uploaded_file($userfile['tmp_name'], "$destination/$userfile_name"))
					$message="$mess[33] $userfile_name";
				else
					$message="$mess[36] <b>$userfile_name</b> $mess[37]";
				chmod("$destination/$userfile_name",0777);
				}
		}
//		// // place_header($message);	    include("../cabecera.php");
              include("<div class='span10 offset1'>");show_contents();
		break;


	case 'webcopy';

		$message = $mess[40];

		$destination = $uploads_folder_name."/$directory";
		$filename = normalize_filename(basename($filename));

		if (!$grants[$user_status][WEBCOPY])
		{
			// // place_header(sprintf($mess[49], "<b>$filename</b>"));
			show_contents();
			break;
		}

		if (!is_path_safe($directory, $filename))
		{
			// // place_header(sprintf($mess[49], "<b>$filename</b>"));
			show_contents();
			break;
		}

		if (!preg_match("/^http://|^ftp:///i", $fileurl))
		{
			// // place_header($mess[202]);
			show_contents();
			break;
		}

		if ($filename == '')
		{
			// // place_header($mess[34]);
			show_contents();
			break;
		}

		if (file_exists("$destination/$filename") || preg_match('/'.$rejectedfiles.'/i', basename($filename)))
		{
			// // place_header("$mess[38] <b>$filename</b> $mess[39]");
			show_contents();
			break;

		}

		if (preg_match('/'.$rejectedfiles.'/i', basename($filename)))
		{
			// place_header(sprintf($mess[49], "<b>$filename</b>"));
			show_contents();
			break;
		}


	case 'rename';

		$userfile = normalize_filename($userfile);

		$current_dir = $uploads_folder_name;
		if ($directory != '')
			$current_dir.="/$directory";

		if (!file_exists("$current_dir/$filename"))
		{
		//	// place_header($mess[125]);
			show_Contents();
			break;
		}

		if (is_dir("$current_dir/$filename"))
		{
	      	if (preg_match('/'.$hidden_dirs.'/i', $userfile) && !$showhidden)
	      	{
	      		// place_header($mess[206]);
	      		show_contents();
				break;
	      	}
      	}

		if (!is_path_safe($directory, $filename) || !is_path_safe($directory, $userfile))
		{
			// place_header($mess[201]);
			show_Contents();
			break;
		}

		list($upl_user, $upl_ip, $contents) = get_file_description("$current_dir/$filename", $comment_max_caracters);

		if ($grants[$user_status][MODALL] || ($upl_user == $logged_user_name && $grants[$user_status][MODOWN]))
		{
			if (!preg_match('/'.$rejectedfiles.'/i', $userfile))
			{
				if (!file_exists("$current_dir/$userfile") || $filename == $userfile)
				{
					if ($filename != $userfile)
					{
						if (file_exists("$current_dir/$filename"))
							rename("$current_dir/$filename", "$current_dir/$userfile");
					}

					if (!is_dir("$current_dir/$userfile") && ($old_description != $new_description))
					{
						list($upl_user, $upl_ip, $contents) = get_file_description("$current_dir/$userfile", 0, 0);
//						save_file_description("$current_dir/$userfile.desc", $new_description, $upl_user, $upl_ip);
					}
				//	// place_header($mess[194]); 
				}
				else
				{
					// place_header($mess[198]); 
				}
			}
			else
			{
				// place_header($mess[201]); 
			}
		}
		else
		{
			// place_header($mess[195]); 
		}	    include("../cabecera.php");
              include("<div class='span10 offset1'>");show_Contents();
		include("../pie.php");
		break;

	case 'phpinfo';
		echo phpinfo();
		exit();

	default;	    
	include("../cabecera.php");
              echo "<div class='span10 offset1'>";
			  show_contents();
			  echo "</div>";
		include("../pie.php");
		break;
}
?>
        </body>
</html>
