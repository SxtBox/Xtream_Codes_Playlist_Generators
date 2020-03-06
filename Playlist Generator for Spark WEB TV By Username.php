<?php
// Xtream Codes Playlist Generator for Spark WEB TV

// GET file.php?username=test&password=test

ob_start();
error_reporting(0);
date_default_timezone_set("Europe/Tirane");
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
  $protocol = 'http://';
} else {
  $protocol = 'https://';
}
$ROOT_PATH = $protocol . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']) . "";
$PANEL_HOST = "192.168.1.10"; // PANEL IP
$PANEL_PORT = "8888"; // PANEL PORT
$HTTP_PROTOCOL = "http"; // PROTOCOL http or https

// $PORT_PUNCTUATION = ':'; // PORT PUNCTUATION
//$USERNAME = "test";
//$PASSWORD = "test";

$XML_FILE = "webtv_usr.xml";

$GET_PLAYLIST = file_get_contents("{$HTTP_PROTOCOL}://{$PANEL_HOST}:{$PANEL_PORT}/get.php?type=starlivev3&username={$_GET['username']}&password={$_GET['password']}");

if(!$GET_PLAYLIST)
die("<title>Xtream Codes Playlist Generator for Spark WEB TV</title>
<link rel='shortcut icon' href='https://kodi.al/panel.ico'/>
<link rel='icon' href='https://kodi.al/panel.ico'/>
<b>
<center>
<font color=lime>Xtream Codes Playlist Generator for Spark WEB TV<font color=red>!</b>
</center>
<br/>
<center>
<font color=red><b>STRUKTURA!!!</b>
</center>
</font>
<br/>
<body style='background-color:black'>
<b>
<center>
<font color=lime>?username=your username&password=your password</b>
</center>
</font>
<br/>
<center>
<font color=lime><b>EXAMPLE PANEL: <font color=red>http://192.168.1.10:8888</b>
</center>
<br/>
<b>
<center>
<font color=lime>Pershembull: $ROOT_PATH/file.php<font color=red>?username=test&password=test<br>
</b>
</center>
</font>
<br/>
<b>
<center>
<font color=lime>API: https://kodi.al/</b>
</center>
</font>
<br/>
<b>
<center>
<font color=lime>FB: /albdroid.official/</b>
</center>
</font>
<br/>");

$ROWS = explode("\n", $GET_PLAYLIST);
if(empty($ROWS[count($ROWS)-1])) {
unset($ROWS[count($ROWS)-1]);
$ROWS=array_map('trim',$ROWS);
}

$HANDLE = fopen($XML_FILE, "w+") or die('Could not open file');
fwrite($HANDLE, "<?xml version=\"1.0\"?>"."\n");
fwrite($HANDLE, "<!-- Xtream Codes Playlist Generator for Spark WEB TV -->"."\n");

fwrite($HANDLE, "<webtvs>"."\n");
foreach($ROWS as $ROW => $ITEM)
{
//GET ROW ITEM
$WRITE_ITEMS = explode(',', $ITEM);
//REPLACE _ WITH SPACES
$WRITE_ITEMS[0] = str_replace('_', ' ', $WRITE_ITEMS[0]);

//GENERATE PLAYLIST
fwrite($HANDLE, "<webtv title=\"{$WRITE_ITEMS[0]}\" urlkey=\"0\""."\n");
fwrite($HANDLE, "url=\"{$WRITE_ITEMS[1]}\""."\n");
fwrite($HANDLE, "description=\"\" type=\"1\" group=\"1\" iconsrc=\"\"/>"."\n");
}
fwrite($HANDLE, "</webtvs>");
fclose($HANDLE);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($XML_FILE));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($XML_FILE));
readfile($XML_FILE);
//echo ($XML_FILE);
exit;
{
ob_end_flush();
}
?>