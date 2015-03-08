<?
include_once("../conf_principal.php");

if ( !defined('IN_PHPATM') )
{
	die("Hacking attempt");
}

//
//
$phpExt = 'php';

//
include('include/constants.'.$phpExt);

//
$homeurl = "http://".$dominio."doc/index.php";
$domain_name = $dominio;
$script_folder_path = $domain_name.'doc';
$installurl = 'http://' . $domain_name.$script_folder_path;

$admin_name = 'Admin';
$admin_email = $email_del_centro;
$use_smtp = false;

//
$users_folder_name = 'users';
$userstat_folder_name = 'userstat';
$uploads_folder_name = $doc_dir;
$languages_folder_name = 'languages';

//
$cookiesecure = false;
$cookievalidity = 8760; //hours

//  STATUS    => array(view,    modown,  delown,  download, mail,    upload,  mkdir,   modall,  delall,  mailall,  webcopy)
//                       V        V        V        V         V        V        V        V        V        V         V
$grants = array(
	ANONYMOUS => array(FALSE,    FALSE,    FALSE,    FALSE,     FALSE,    FALSE,    FALSE,    FALSE,    FALSE ,   FALSE,     FALSE ),
	www       => array(FALSE,    FALSE,    FALSE,    FALSE,     FALSE,    FALSE,    FALSE,    FALSE,    FALSE ,   FALSE,     FALSE ),
	UPLOADER  => array(FALSE,    FALSE,    FALSE,    FALSE,     FALSE,    FALSE,    FALSE,    FALSE,    FALSE ,   FALSE,     FALSE ),
	VIEWER    => array(FALSE,    FALSE,    FALSE,    FALSE,     FALSE,    FALSE,    FALSE,    FALSE,    FALSE ,   FALSE,     FALSE ),
	NORMAL    => array(FALSE,    FALSE,    FALSE,    FALSE,     FALSE,    FALSE,    FALSE,    FALSE,    FALSE ,   FALSE,     FALSE ),
	POWER     => array(TRUE,    FALSE,    FALSE,    TRUE,     FALSE,    FALSE,    FALSE,    FALSE,    FALSE ,   FALSE,     FALSE ),
	ADMIN     => array(FALSE,    FALSE,    FALSE,    FALSE,     FALSE,    FALSE,    FALSE,    FALSE,    FALSE ,   FALSE,     FALSE )
);

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
$datetimeformat = 'd.m.Y H:i';

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
$mimetypes = array (
'.txt'  => array('img' => 'txt.gif',    'mime' => 'text/plain'),
'.html' => array('img' => 'html.gif',   'mime' => 'text/html'),
'.htm'  => array('img' => 'html.gif',   'mime' => 'text/html'),
'.doc'  => array('img' => 'doc.gif',    'mime' => 'application/msword'),
'.pdf'  => array('img' => 'pdf.gif',    'mime' => 'application/pdf'),
'.xls'  => array('img' => 'xls.gif',    'mime' => 'application/msexcel'),
'.gif'  => array('img' => 'gif.gif',    'mime' => 'image/gif'),
'.jpg'  => array('img' => 'jpg.gif',    'mime' => 'image/jpeg'),
'.jpeg' => array('img' => 'jpg.gif',    'mime' => 'image/jpeg'),
'.bmp'  => array('img' => 'bmp.gif',    'mime' => 'image/bmp'),
'.png'  => array('img' => 'gif.gif',    'mime' => 'image/png'),
'.zip'  => array('img' => 'zip.gif',    'mime' => 'application/zip'),
'.rar'  => array('img' => 'rar.gif',    'mime' => 'application/x-rar-compressed'),
'.gz'   => array('img' => 'zip.gif',    'mime' => 'application/x-compressed'),
'.tgz'  => array('img' => 'zip.gif',    'mime' => 'application/x-compressed'),
'.z'    => array('img' => 'zip.gif',    'mime' => 'application/x-compress'),
'.exe'  => array('img' => 'exe.gif',    'mime' => 'application/x-msdownload'),
'.mid'  => array('img' => 'mid.gif',    'mime' => 'audio/mid'),
'.midi' => array('img' => 'mid.gif',    'mime' => 'audio/mid'),
'.wav'  => array('img' => 'wav.gif',    'mime' => 'audio/x-wav'),
'.mp3'  => array('img' => 'mp3.gif',    'mime' => 'audio/x-mpeg'),
'.avi'  => array('img' => 'avi.gif',    'mime' => 'video/x-msvideo'),
'.mpg'  => array('img' => 'mpg.gif',    'mime' => 'video/mpeg'),
'.mpeg' => array('img' => 'mpg.gif',    'mime' => 'video/mpeg'),
'.mov'  => array('img' => 'avi.gif',    'mime' => 'video/quicktime'),
'.swf'  => array('img' => 'flash.gif',  'mime' => 'application/x-shockwave-flash'),
'.gtar' => array('img' => 'rar.gif',    'mime' => 'application/x-gtar'),
'.tar'  => array('img' => 'rar.gif',    'mime' => 'application/x-tar'),
'.tiff' => array('img' => 'defaut.gif', 'mime' => 'image/tiff'),
'.tif'  => array('img' => 'defaut.gif', 'mime' => 'image/tiff'),
'.rtf'  => array('img' => 'doc.gif',    'mime' => 'application/rtf'),
'.eps'  => array('img' => 'defaut.gif', 'mime' => 'application/postscript'),
'.ps'   => array('img' => 'defaut.gif', 'mime' => 'application/postscript'),
'.qt'   => array('img' => 'avi.gif'  ,  'mime' => 'video/quicktime'),
'directory' => array('img' => 'Folder.gif', 'mime' => ''),
'default' =>   array('img' => 'default.gif',  'mime' => 'application/octet-stream')
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
