<?php
/*

 Xtream Codes Playlist Generator TEST #1
 GET by_username.php?username=test&password=test
 GET by_username.php?username=test&password=test&type=m3u

*/

ob_start();
error_reporting(0);
date_default_timezone_set("Europe/Tirane");

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
  $protocol = 'http://';
} else {
  $protocol = 'https://';
}
$ROOT_PATH = $protocol . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']) . "";

// SETTING IP PORT ETC
$PANEL_HOST = "192.168.1.10"; // PANEL IP
$PANEL_PORT = 8888; // PANEL PORT
$HTTP_PROTOCOL = "http"; // PROTOCOL http or https
// SETTING IP PORT ETC

$GET_JSON_DATA = json_decode(file_get_contents("{$HTTP_PROTOCOL}://{$PANEL_HOST}:{$PANEL_PORT}/panel_api.php?username={$_GET['username']}&password={$_GET['password']}"), true);

$RECEIVER_FROM_PANEL = "{$HTTP_PROTOCOL}://{$GET_JSON_DATA['server_info']['url']}:{$GET_JSON_DATA['server_info']['port']}";
// PLAYLIST TYPE
if(!isset($_GET['type']) || empty($_GET['type'])){
$LIST_TYPE = 'ts'; // ts or m3u
}else{
$LIST_TYPE = $_GET['type'];
}
$BUILD_PLAYLIST_URL = [[]];
$i = 0;
$id = 1;
foreach ($GET_JSON_DATA['available_channels'] as $channel)
{
// KJO PJESA KETU DUHET RREGULLUAR, KA DISA PROBLEME ME MARJEN E TE DHENAVE
$BUILD_PLAYLIST_URL[$i]['name'] = "#EXTINF:0 channel-id=\"{$id}\" tvg-id=\"{$channel['name']}\" tvg-logo=\"{$channel['stream_icon']}\" channel-id=\"{$channel['name']}\" group-title=\"{$channel['category_name']}{$channel['stream_type']}\",{$channel['name']}";

// BACK {$channel['name']}\" group-title=\"{$channel['category_name']}|{$channel['stream_type']}\",{$channel['name']}";
//                                                    EXTRA ON TITLES |

$BUILD_PLAYLIST_URL[$i]['url'] = $RECEIVER_FROM_PANEL."/live{$channel['stream_type']}/{$GET_JSON_DATA['user_info']['username']}/{$GET_JSON_DATA['user_info']['password']}/".$channel['stream_id'].".".$LIST_TYPE;

$id++;
$i++;
}
$PLAYLIST_DIRECTIVE = "#EXTM3U";
if(!$channel)
die("<title>Xtream Codes Playlist Generator</title>
<link rel='shortcut icon' href='https://kodi.al/panel.ico'/>
<link rel='icon' href='https://kodi.al/panel.ico'/>
<b>
<center>
<font color=lime>Xtream Codes Playlist Generator<font color=red>!</b>
</center>
<b>
<br/>
<b>
<center>
<font color=lime>Platform: VLC Smart TV Kodi ETC</b>
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
<font color=lime>Pershembull: $ROOT_PATH/by_username.php<font color=red>?username=test&password=test<br>
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
<br/>"
);
$BUILD_PLAYLIST = $PLAYLIST_DIRECTIVE."\n";
foreach($BUILD_PLAYLIST_URL as $item){
$BUILD_PLAYLIST .= "{$item['name']}\n"."{$item['url']}\n";
}
if(!$item)
die("<title>Xtream Codes Playlist Generator</title>
<link rel='shortcut icon' href='https://kodi.al/panel.ico'/>
<link rel='icon' href='https://kodi.al/panel.ico'/>
<b>
<center>
<font color=red>Error To GET Playlist Data</b>
</center>
</font>
<br/>
<body style='background-color:black'>
<b>
<center>
<font color=lime>Don't Fetching Data From Remote Server<br/>
<br>
<font color=red>Check Credentials if is Valid<br/>
<br/> Or You Do Not Have Communication With The Remote Server</b>
</center>
</font>
<br/>
<b>
<center>
<font color=lime>Contact: TRC4@USA.COM</b></center></font><br/><b><center><font color=lime>Facebook:  /albdroid.official/</b></center></font><br/>");
header("Content-type: text/plain");
//header("Content-Disposition: attachment; filename={$_GET['username']}"."_tv_channels.m3u"); // PLAYLIST.M3U
echo $BUILD_PLAYLIST;
ob_end_flush();