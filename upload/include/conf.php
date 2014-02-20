<?

if ( !defined('IN_PHPATM') )
{
	die("Hacking attempt");
}

//
//
$phpExt = 'php';

//
//
include('include/constants.'.$phpExt);
//include("../../config.php");
//
//
$homeurl = $dominio."/intranet/upload/index.php";

//
$admin_name = 'Admin';

//
//
$admin_email = 'admin@'.$dominio;

//
$use_smtp = false;
$smtp_host ='mail';
$smtp_username = 'admin';
$smtp_password = '';

//

$domain_name = $dominio;
$script_folder_path = 'intranet/upload/';
$installurl = 'http://' . $domain_name . '/' . $script_folder_path;

//
$users_folder_name = 'users';
$userstat_folder_name = 'userstat';

switch ($_GET['index']) {
	default :
	case 'publico' : $uploads_folder_name = $doc_dir; $index="publico"; break;
	case 'privado' : $uploads_folder_name = '../varios/'.$_SESSION['ide'].'/'; $index="privado"; break;
}

$languages_folder_name = 'languages';

//

$cookiedomain = '';
$cookiepath = '';
$cookiesecure = false;
$cookievalidity = 8760; //hours

//  STATUS    => array(view,    modown,  delown,  download, mail,    upload,  mkdir,   modall,  delall,  mailall,  webcopy)
//                       V        V        V        V         V        V        V        V        V        V         V
if(stristr($_SESSION['cargo'],'1') == TRUE){
$grants = array(
	POWER     => array(TRUE,    TRUE,    TRUE,    TRUE,     TRUE,    TRUE,    TRUE,    TRUE,    TRUE ,   TRUE,     TRUE ),
);
}
else
{
if(!(strstr($directory,$departamento2)) == FALSE)
{
$grants = array(
	POWER     => array(TRUE,    TRUE,    TRUE,    TRUE,     TRUE,    TRUE,    TRUE,    TRUE,    TRUE ,   TRUE,     TRUE ),
);
}
elseif($_GET['index']=='privado') {
$grants = array(
	POWER     => array(TRUE,    TRUE,    TRUE,    TRUE,     TRUE,    TRUE,    TRUE,    TRUE,    TRUE ,   TRUE,     TRUE ),
);
}
else
{
$grants = array(
	POWER     => array(TRUE,    FALSE,    FALSE,    TRUE,     FALSE,    FALSE,    FALSE,    FALSE,    FALSE ,   FALSE,     FALSE ),
);
}
}

//
$default_user_status = ANONYMOUS;

//
$page_title = 'Archivos del '.$nombre_del_centro;

//
$GMToffset = date('Z')/3600;

$maintenance_time = 2;

//

$mail_functions_enabled = false;

//
$max_filesize_to_mail = 10000;

$require_email_confirmation = false;

//
$max_last_files = 12;

//
$max_topdownloaded_files = 10;

//
$dft_language = 'es';


//
$max_allowed_filesize = 50000;

//
$direction = 1;


//
$datetimeformat = 'd/m/Y H:i';

//
$file_name_max_caracters = 150;

//
$file_out_max_caracters = 40;

//
//
$comment_max_caracters = 300;

//

$rejectedfiles = "^index\.|\.desc$|\.dlcnt$|\.php$|\.php3$|\.cgi$|\.pl$";

//
$showhidden = false;

//
//
$hidden_dirs = "^_vti_";

//
$skins = array(
  array(
    'bordercolor' => '#A7BFFE',    // The table border color
    'headercolor' => '#FFFFCC',    // The table header color
    'tablecolor' => '#ffffff',     // The table background color
    'lightcolor' => '#FFFFFF',     // Table date field color
    'headerfontcolor' => '#CC3333',
    'normalfontcolor' => '#000000',
    'selectedfontcolor' => '#4682B4',
    'bodytag' => "bgcolor=\"#E5E5E5\" text=\"#000000\" link=\"#000000\" vlink=\"#333333\" alink=\"#000000\""
  )
);

//
$font = 'Verdana';

//
//
$mimetypes = array (
'.txt'  => array('img' => 'txt.jpg',    'mime' => 'text/plain'),
'.html' => array('img' => 'html.jpg',   'mime' => 'text/html'),
'.htm'  => array('img' => 'html.jpg',   'mime' => 'text/html'),
'.doc'  => array('img' => 'doc.jpg',    'mime' => 'application/msword'),
'.docx'  => array('img' => 'docx.jpg',    'mime' => 'application/msword'),
'.pdf'  => array('img' => 'pdf.jpg',    'mime' => 'application/pdf'),
'.xls'  => array('img' => 'xls.jpg',    'mime' => 'application/msexcel'),
'.xlsx'  => array('img' => 'xlsx.jpg',    'mime' => 'application/msexcel'),
'.odt'  => array('img' => 'odt.jpg',    'mime' => 'application/vnd.oasis.opendocument.text'),
'.ots'  => array('img' => 'ots.jpg',    'mime' => 'application/vnd.oasis.opendocument.text'),
'.ott'  => array('img' => 'ott.jpg',    'mime' => 'application/vnd.oasis.opendocument.text'),
'.gif'  => array('img' => 'gif.jpg',    'mime' => 'image/gif'),
'.jpg'  => array('img' => 'jpg.jpg',    'mime' => 'image/jpeg'),
'.jpeg' => array('img' => 'jpg.jpg',    'mime' => 'image/jpeg'),
'.bmp'  => array('img' => 'bmp.jpg',    'mime' => 'image/bmp'),
'.png'  => array('img' => 'gif.jpg',    'mime' => 'image/png'),
'.zip'  => array('img' => 'zip.jpg',    'mime' => 'application/zip'),
'.rar'  => array('img' => 'rar.jpg',    'mime' => 'application/x-rar-compressed'),
'.gz'   => array('img' => 'zip.jpg',    'mime' => 'application/x-compressed'),
'.tgz'  => array('img' => 'zip.jpg',    'mime' => 'application/x-compressed'),
'.z'    => array('img' => 'zip.jpg',    'mime' => 'application/x-compress'),
'.exe'  => array('img' => 'exe.jpg',    'mime' => 'application/x-msdownload'),
'.mid'  => array('img' => 'mid.jpg',    'mime' => 'audio/mid'),
'.midi' => array('img' => 'mid.jpg',    'mime' => 'audio/mid'),
'.wav'  => array('img' => 'wav.jpg',    'mime' => 'audio/x-wav'),
'.mp3'  => array('img' => 'mp3.jpg',    'mime' => 'audio/x-mpeg'),
'.avi'  => array('img' => 'avi.jpg',    'mime' => 'video/x-msvideo'),
'.mpg'  => array('img' => 'mpg.jpg',    'mime' => 'video/mpeg'),
'.mpeg' => array('img' => 'mpg.jpg',    'mime' => 'video/mpeg'),
'.mov'  => array('img' => 'avi.jpg',    'mime' => 'video/quicktime'),
'.swf'  => array('img' => 'flash.jpg',  'mime' => 'application/x-shockwave-flash'),
'.gtar' => array('img' => 'rar.jpg',    'mime' => 'application/x-gtar'),
'.tar'  => array('img' => 'tar.jpg',    'mime' => 'application/x-tar'),
'.tiff' => array('img' => 'tiff.jpg', 'mime' => 'image/tiff'),
'.tif'  => array('img' => 'tiff.jpg', 'mime' => 'image/tiff'),
'.rtf'  => array('img' => 'rtf.jpg',    'mime' => 'application/rtf'),
'.eps'  => array('img' => 'defaut.jpg', 'mime' => 'application/postscript'),
'.ps'   => array('img' => 'defaut.jpg', 'mime' => 'application/postscript'),
'.qt'   => array('img' => 'avi.jpg'  ,  'mime' => 'video/quicktime'),
'directory' => array('img' => 'folder.png', 'mime' => ''),
'default' =>   array('img' => 'txt.jpg',  'mime' => 'application/octet-stream')
);

//
$invalidchars = array (
"'",
"\"",
"\"",
'&',
',',
';',
'/',
"\\",
'`',
'<',
'>',
':',
'*',
'|',
'?',
'§',
'+',
'^',
'(',
')',
'=',
'$',
'%'
);

//
//$ip_black_list = array (
//'127.0.0.2',
//'127.0.0.3',
//);

?>
