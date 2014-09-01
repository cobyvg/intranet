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
elseif(strstr($_GET['directory'],$departamento2) == TRUE)
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
// text
'.css'  => array('img' => 'css.png',    'mime' => 'text/css'),
'.djvu' => array('img' => 'djvu.png',   'mime' => 'image/vnd.djvu'),
'.epub' => array('img' => 'epub.png',   'mime' => 'application/epub+zip'),
'.html' => array('img' => 'html.png',   'mime' => 'text/html'),
'.htm'  => array('img' => 'html.png',   'mime' => 'text/html'),
'.log'  => array('img' => 'log.png',    'mime' => 'text/plain'),
'.php'  => array('img' => 'php.png',    'mime' => 'text/php'),
'.rtf'  => array('img' => 'rtf.png',    'mime' => 'application/rtf'),
'.sql'  => array('img' => 'sql.png',    'mime' => 'application/x-sql'),
'.txt'  => array('img' => 'txt.png',    'mime' => 'text/plain'),
'.xml'  => array('img' => 'xml.png',    'mime' => 'application/xml'),

// documents
'.csv'  => array('img' => 'csv.png',    'mime' => 'text/csv'),
'.doc'  => array('img' => 'doc.png',    'mime' => 'application/msword'),
'.dot'  => array('img' => 'doc.png',    'mime' => 'application/msword'),
'.docx' => array('img' => 'docx.png',   'mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
'.pdf'  => array('img' => 'pdf.png',    'mime' => 'application/pdf'),
'.ppt'  => array('img' => 'ppt.png',    'mime' => 'application/vnd.ms-powerpoint'),
'.pps'  => array('img' => 'ppt.png',    'mime' => 'application/vnd.ms-powerpoint'),
'.pot'  => array('img' => 'ppt.png',    'mime' => 'application/vnd.ms-powerpoint'),
'.pptx' => array('img' => 'pptx.png',   'mime' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation'),
'.ppsx' => array('img' => 'ppsx.png',   'mime' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow'),
'.pub'  => array('img' => 'pub.png',    'mime' => 'application/x-mspublisher'),
'.odt'  => array('img' => 'odt.png',    'mime' => 'application/vnd.oasis.opendocument.text'),
'.ott'  => array('img' => 'odt.png',    'mime' => 'application/vnd.oasis.opendocument.text-template'),
'.ods'  => array('img' => 'ods.png',    'mime' => 'application/vnd.oasis.opendocument.spreadsheet'),
'.ots'  => array('img' => 'ots.png',    'mime' => 'application/vnd.oasis.opendocument.spreadsheet-template'),
'.odp'  => array('img' => 'odp.png',    'mime' => 'application/vnd.oasis.opendocument.presentation'),
'.otp'  => array('img' => 'odp.png',    'mime' => 'application/vnd.oasis.opendocument.presentation-template'),
'.xls'  => array('img' => 'xls.png',    'mime' => 'application/vnd.ms-excel'),
'.xlsx' => array('img' => 'xlsx.png',   'mime' => 'application/vnd.ms-excel'),

// image

'.bmp'  => array('img' => 'bmp.png',    'mime' => 'image/bmp'),
'.gif'  => array('img' => 'gif.png',    'mime' => 'image/gif'),
'.ico'  => array('img' => 'ico.png',    'mime' => 'image/x-icon'),
'.jpg'  => array('img' => 'jpg.png',    'mime' => 'image/jpeg'),
'.jpeg' => array('img' => 'jpeg.png',   'mime' => 'image/jpeg'),
'.png'  => array('img' => 'jpg.png',    'mime' => 'image/png'),
'.skp'  => array('img' => 'skp.png',    'mime' => 'application/vnd.koan'),
'.tiff' => array('img' => 'tiff.png',   'mime' => 'image/tiff'),
'.tif'  => array('img' => 'tiff.png',   'mime' => 'image/tiff'),

// compression
'.gz'   => array('img' => 'gz.png',     'mime' => 'application/x-compressed'),
'.rar'  => array('img' => 'rar.png',    'mime' => 'application/x-rar-compressed'),
'.tar'  => array('img' => 'tar.png',    'mime' => 'application/x-tar'),
'.tgz'  => array('img' => 'tgz.png',    'mime' => 'application/x-compressed'),
'.zip'  => array('img' => 'zip.png',    'mime' => 'application/zip'),

// compression images
'.dmg'  => array('img' => 'dmg.png',    'mime' => 'application/x-apple-diskimage'),
'.iso'  => array('img' => 'iso.png',    'mime' => 'application/x-iso9660-image'),

// executable
'.deb'  => array('img' => 'deb.png',    'mime' => 'application/x-debian-package'),
'.exe'  => array('img' => 'exe.png',    'mime' => 'application/x-msdownload'),
'.msi'  => array('img' => 'msi.png',    'mime' => 'application/x-msdownload'),
'.xpi'  => array('img' => 'xpi.png',    'mime' => 'application/x-xpinstall'),


// audio
'.mid'  => array('img' => 'midi.png',   'mime' => 'audio/mid'),
'.midi' => array('img' => 'midi.png',   'mime' => 'audio/mid'),
'.m4a'  => array('img' => 'm4a.png',    'mime' => 'audio/mp4'),
'.mp3'  => array('img' => 'mp3.png',    'mime' => 'audio/mpeg'),
'.ogg'  => array('img' => 'ogg.png',    'mime' => 'audio/ogg'),
'.wav'  => array('img' => 'wav.png',    'mime' => 'audio/x-wav'),

// video
'.3g2'  => array('img' => '3g2.png',    'mime' => 'video/3gpp2'),
'.3gp'  => array('img' => '3gp.png',    'mime' => 'video/3gpp'),
'.asf'  => array('img' => 'asf.png',    'mime' => 'video/x-ms-asf'),
'.avi'  => array('img' => 'avi.png',    'mime' => 'video/x-msvideo'),
'.flv'  => array('img' => 'flv.png',    'mime' => 'video/x-flv'),
'.m4v'  => array('img' => 'm4v.png',    'mime' => 'video/x-m4v'),
'.mkv'  => array('img' => 'mkv.png',    'mime' => 'video/x-matroska'),
'.mp4'  => array('img' => 'mp4.png',    'mime' => 'video/mp4'),
'.mpg'  => array('img' => 'mpeg.png',   'mime' => 'video/mpeg'),
'.mpeg' => array('img' => 'mpeg.png',   'mime' => 'video/mpeg'),
'.mov'  => array('img' => 'qt.png',     'mime' => 'video/quicktime'),
'.ogv'  => array('img' => 'ogv.png',    'mime' => 'video/ogg'),
'.qt'   => array('img' => 'qt.png'  ,   'mime' => 'video/quicktime'),
'.wmv'  => array('img' => 'wmv.png',    'mime' => 'video/x-ms-wmv'),

// tipography
'.ttf'  => array('img' => 'ttf.png',    'mime' => 'application/x-font-ttf'),

// postscript
'.ai'   => array('img' => 'ai.png',     'mime' => 'application/postscript'),
'.psd'  => array('img' => 'psd.png',    'mime' => 'image/vnd.adobe.photoshop'),
'.eps'  => array('img' => 'eps.png',    'mime' => 'application/postscript'),
'.ps'   => array('img' => 'eps.png',    'mime' => 'application/postscript'),

// directoy and default
'directory' => array('img' => 'folder.png', 'mime' => ''),
'default' =>   array('img' => 'default.png',  'mime' => 'application/octet-stream')
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
