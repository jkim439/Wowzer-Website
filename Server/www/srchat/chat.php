<?
ob_start();
session_start();
/*
 * srchat 192
 * Developed By 사리 (sariputra3@naver.com)
 * License : GNU Public License (GPL)
 * Homepage : http://srboard.styx.kr/srboard/index.php?id=blog&ct=06
 */
$chat = "chat.php";
$chtdate = "chat/"; //데이타파일 저장경로(권한777)
$chtwidth = 450; //채팅내용 넓이 (숫자로만)
$chtheight = 400; //채팅방 높이
$unload = 2; // unload전에 경고창
$chtrefresh = 1500; // 새글 확인하는 인터벌
$chtlastgap = 20; // 단위는 초, 접속여부 판단하는 현재시간-마지막접속시간 간격
$chtemptgap = 180; // 단위는 초, 퇴장으로 판단하는, 자리비움 경과시간
$chtckcnnct = 2500; // 접속중지 여부 확인 인터벌 반값
$chtsound = 20000; // 소리로 표시하는 인터벌(default 20초)
$chtimgwth = 700; // 이미지클릭했을때 최대넓이
$chticodir = "emoticon/"; // 이모티콘 저장된 경로
$chtusrinout = 1; // 사용자 입출력상황 본문기록 여부
$time = time();
$isadmin = 0;
$chtexit = 1;
$chthis = date("H:i:s",$time);
$exxt = array('_GET','_POST','_SESSION','_COOKIE','_FILES','_SERVER','sessid','isadmin');
for($i=0;$i < 8;$i++) if(isset($_GET[$exxt[$i]]) || isset($_POST[$exxt[$i]])) exit;
$chtip = str_pad(str_replace('.','',$_SERVER['REMOTE_ADDR']),12,'x'); /* ip로 사용자구분 할때 */
//$chtip = substr(session_id(),0,12); /* ip로 사용자구분 안할때 */
if($_COOKIE['mck'] == md5($_SESSION['mk'])) {
if($adm = $_SESSION[$_COOKIE[md5($_COOKIE['mck']."\x1b".$_SESSION['mk'])]]) {
if($adm[1] == $_COOKIE['mck']) $isadmin = 1;
}}
$chtnck = ($_SESSION['chtnk'])? $_SESSION['chtnk']:"손님_".substr($chtip,4,4);
if($_SERVER['HTTP_REFERER'] && false === strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST'])) $chtexit = '';
function cht_vnmb($view) {
$ff = opendir($view);
while($fg = readdir($ff)) {
if($fg != '.' && $fg != '..') {$fff = $fg;break;}
}
closedir($ff);
return $fff;
}
if($chtexit && is_dir($chtdate."srchat")) {
$chtdate2 = $chtdate."srchat/".cht_vnmb($chtdate."srchat")."/";
if($chtdate2) {
$chtxwd = $chtdate2."_xword"; // 금지된 표현
$chtxnk = $chtdate2."_xnick"; // 금지닉네임
$chtxip = $chtdate2."__kickout"; // 차단된 ip
$id = ($_POST['id'])? $_POST['id'] : $_GET['id'];
if($id){
if(strpos($id, "%") === false) $id = rawurlencode($id);
$chtuid = urldecode($id);
$chtfid = $chtdate2.$chtuid;
if(file_exists($chtfid."/_ban/".$chtip)) {
echo "<script type=\"text/javascript\">alert('access denied');location.href='?';</script>";
exit;
}
if(file_exists($chtfid."/refresh_".$chtip)) {
@unlink($chtfid."/refresh_".$chtip);
echo "<script type=\"text/javascript\">tout();location.reload();</script>";
exit;
}
if(!is_dir($chtfid)){
echo "<script type=\"text/javascript\">alert('chatroom does not exist');location.href = '?';</script>";
exit;
}
} else $chtfid = $chtdate2."--memo";
$chtdt = $chtfid."/_data/";
$chtbk = $chtfid."/_bak";
$chtgt = $chtfid."/_gst/_guest";
$chtwt = $chtfid."/_gst/wt/";
$chtgv = $chtfid."/_gst/gv";
$chtmip = $chtfid."/_gst/m_";
$chtqip = $chtfid."/_gst/q_";
$chtup = $chtfid."/_upload/";
$dsm = $chtdate2."_fsum";
$chtking = (file_exists($chtfid."/king_".$chtip))? 1:$isadmin;
if(!$_POST['tt'] && ($isadmin || $_FILES['file']) && $id && file_exists($dsm)) {
$fd = fopen($dsm,"r");
$isdsm = (int)fgets($fd);
$isusm = (int)fgets($fd);
fclose($fd);
}
$dwv = cht_vnmb($chtwt);
function chtrmfd($dirName,$n) {
$dirName = urldecode($dirName);
if(is_dir($dirName)) {
if(substr($dirName, -1) != "/") $dirName .= "/";
$d = opendir($dirName);
while($entry = readdir($d)) {
if($entry != "." && $entry != "..") {
if(is_dir($dirName.$entry)) chtrmfd($dirName.$entry,$n);
else @unlink($dirName.$entry);
}
}
closedir($d);
if($n) RmDir($dirName);
}
}
function writee($dwn,$mema) {
 global $chtbk, $chtwt, $chtdt;
$ndwv = $dwn%90 + 1;
$ndwv = str_pad($ndwv, 2, '0', STR_PAD_LEFT);
@rename($chtwt.$dwn, $chtwt.$ndwv);
$fp = fopen($chtdt.$ndwv,"w");
fputs($fp,$mema);
fclose($fp);
$bk=fopen($chtbk,"a");
fputs($bk,str_replace("\x18","\n",$mema)."\n");
fclose($bk);
return $ndwv;
}
function whisp($rno) {
 global $chtip, $chtdt;
$rnt = count($rno);
for($i = 0;$rno[$i];$i++) {
$rnn = str_pad($rno[$i],2,0,STR_PAD_LEFT);
if($fsz = @filesize($chtdt.$rnn)) {
$fp = fopen($chtdt.$rnn,"r");
$fpo = fread($fp,$fsz);
fclose($fp);
if(substr($fpo, 0, 2) == "\x1b\x1b") {
if(substr($fpo,2,12) == $chtip || substr($fpo,14,12) == $chtip)  $dtt .= substr($fpo,26)."\x18";
} else $dtt .= $fpo."\x18";
}
}
return $dtt;
}
function reaad($wtend,$red) {
 global $chtip;
$r = 0;
if($wtend > $red) {
for($i =$red + 1;$i <= $wtend;$i++) {$rno[$r] = $i;$r++;}
} else {
if($red < 90) {for($i = $red + 1;$i <= 90;$i++) {$rno[$r] = $i;$r++;}}
for($i = 1;$i <= $wtend;$i++) {$rno[$r] = $i;$r++;}
}
return whisp($rno);
}
function newtext($text) {
if($text) {
$text = stripslashes($text);
$text = preg_replace("`[\x1b\x18\x7f\t]`", "", $text);
$text = str_replace("<", "&lt;", $text);
$text = str_replace(">", "&gt;", $text);
}
return $text;
}
function guestt($hp,$gp) {
global $chtgt, $chtgv, $chtqip;
while(file_exists($chtgt."_tmp")) {usleep(5000);}
$fg = fopen($chtgt,"r");
$fmp = fopen($chtgt."_tmp","w");
while($fgo = fgets($fg)) {
if(substr($fgo,0,12) == $hp) {
if($gp > 1) {
if(file_exists($chtqip.$hp)) {$fgo = substr($fgo,0,13)."0".substr($fgo,14);unlink($chtqip.$hp);}
else {$fgo = substr($fgo,0,13)."1".substr($fgo,14);fclose(fopen($chtqip.$hp,"w"));}
fputs($fmp,$fgo);
}} else fputs($fmp,$fgo);
}
fclose($fg);
fclose($fmp);
copy($chtgt."_tmp",$chtgt);
@unlink($chtgt."_tmp");
fclose(fopen($chtgv,"w"));
}
if($_POST['tt']) {
// 1.내부데이타처리 시작
header ("Content-Type: text/html; charset=UTF-8");
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");

if($_POST['neme']){
if(file_exists($chtqip.$chtip)) {unlink($chtqip.$chtip);$mdd = 1;}
if($chtnck != $_POST['neme']){ // 닉변경되었으면
if($_POST['neme'] = newtext($_POST['neme'])) {
if($_SESSION['chtnk']) $memo .= "\x1b".$chtnck."<>".$_POST['neme']."\x1b".$chthis."\x1b\x1b\x1b\x1b\x18";
$chtnck = $_POST['neme'];
$_SESSION['chtnk'] = $_POST['neme'];
$mdd = 1;
}}
if($mdd == 1) {
fclose(fopen($chtgv,"w"));
$egv = $time;
}}
if(file_exists($chtmip.$chtip)) {
$fnt = fopen($chtmip.$chtip,"r");
$dgx = fgets($fnt);
$red = substr($dgx,0,2);
$dgx = substr($dgx,2,10);
fclose($fnt);
$egg = filemtime($chtmip.$chtip);
} else {$red = '01';$egg = 0;$dgx = 0;}
$meo = "";
if(!$egv) $egv = filemtime($chtgv);
if($_POST['tt'] == 'a' || $_POST['tt'] == 'x' || $mdd == 1 || $dgx < $egv) { // 방문자목록처리
$vv = 1;
$fg = fopen($chtgt,"a+");
while($fgo = fgets($fg)) {
$vv++;
$fgdo = substr($fgo,0,12);
if($fgdo == $chtip) {$is = 1;$meo .= $chtip.":".(($_POST['neme'])? "0":$fgo[13]).$chtnck."\n";}
else if($time - @filemtime($chtmip.$fgdo) > $chtlastgap || ($fgo[13] == "1" && $time - @filemtime($chtqip.$fgdo) > $chtemptgap)) {@unlink($chtmip.$fgdo);$mdd =1;$mout = substr($fgo,14,-1);}
else $meo .= $fgo;
}
fclose($fg);
if(!$is) $meo .= $chtip.":0".$chtnck."\n";
if($chtusrinout && $id){
if(!$is) $memo .= "\x1b".$chtnck."<<\x1b".$chthis."\x1b\x1b\x1b\x1b\x18";
if($mout) $memo .= "\x1b".$mout."<<\x1b".$chthis."\x1b\x1b\x1b\x1b\x18";
}
echo str_replace("\n","\x18",$meo);
if(!$is || $mdd == 1) {
$fg = fopen($chtgt,"w");
fputs($fg,$meo);
fclose($fg);
if($egv != $time) fclose(fopen($chtgv,"w"));
}
}
if(!$_POST['neme'] && ($_POST['content'] == "69847381" || $_POST['content'] == "95798584")) {
if($_POST['content'] == "69847381") {
guestt($chtip,3);
} else if($_POST['content'] == "95798584") { // 퇴장할때 실행되는
guestt($chtip,1);
if($chtusrinout && $id){
$memo = "\x1b".$chtnck.">>\x1b".$chthis."\x1b\x1b\x1b\x1b";
writee($dwv,$memo);
}
@unlink($chtmip.$chtip);
}
exit;
}
if($chtnck && $_POST['content']){ // 새글처리
$_POST['content'] = newtext($_POST['content']);
if($_POST['content']) {
if(strpos($_POST['content'],'//귓속말//') !== false) {
$wpcnt = explode('//귓속말//',$_POST['content']);
$memo= "\x1b\x1b".$chtip.substr($wpcnt[0],0,12)."_\x1b<span>".substr($wpcnt[0],12)."</span>님에게 <span>".$chtnck."</span>님의 귓속말 &gt;<br />".$wpcnt[1]."\x1b".$chthis."\x1b";
} else {
$ffe = explode('_',$_POST['ff']);
$memo .= $chtnck."\x1b".$_POST['content']."\x1b".$chthis."\x1b".$ffe[0]."\x1b".$ffe[1]."\x1b".$ffe[2]."\x1b".$ffe[3];
}}} else $memo = substr($memo,0,-1);
if($memo) $dwv = writee($dwv,$memo);
if($vv || $red != $dmv || $time - $egg > 4){
$mnt = fopen($chtmip.$chtip,"w");
fputs($mnt,$dwv.$egv."\n".$_SESSION['w_'.$id]);
fclose($mnt);
}
echo "\x7f";
if($_POST['tt'] == 'a' || $red <> $dwv) { // 새글읽기
if($_POST['tt'] == 'a') $red = $dwv;
$reead = reaad($dwv,$red);
if($reead) echo $reead;
}
if(!$id && ($_POST['tt'] == 'a' || $_POST['tt'] == 'x')) {
if(substr($_SERVER['HTTP_USER_AGENT'], 25,6) == 'MSIE 6') $exp = 6;
if(file_exists($chtdate2."_oxempty")) {$fk=fopen($chtdate2."_oxempty","r");$oxmt=fgets($fk);fclose($fk);} else $oxmt = 0;
$dir = opendir($chtdate2);
while($file = readdir($dir)){
if($file != '.' && $file != '..' && $file != '--memo' && is_dir($chtdate2.$file)) {
$ff = fopen($chtdate2.$file."/_gst/_guest","r");
for($fnn = 0;trim(fgets($ff)) != "";$fnn++) {}
fclose($ff);
if($fnn || $oxmt == 'b' || ($oxmt == 'c' && file_exists($chtdate2.$file."/_admin_"))) {
$och[filemtime($chtdate2.$file."/date")] = array($file,$fnn,$chtdate2.$file);
} else chtrmfd($chtdate2.$file,1);
}
}
closedir($dir);
if($och) {
ksort($och);
echo "\x7f";
foreach($och as $otm => $occh) {
echo "{$occh[0]}\x18{$occh[1]}\x18";
echo (file_exists($occh[2]."/_pass"))? 1:0;
echo "\x18".($time - $otm)."\x18";
echo (file_exists($occh[2]."/_monly"))? 1:0;
echo "\x18\x1b";
}}}
exit;
// 1.내부데이타처리 끝
} else if($_GET['view']||$_GET['down']){
// 2.업로드파일출력 시작
$gfile = ($_GET['view'])? $_GET['view']:$_GET['down'];
$filee = $chtup.str_replace("^","",str_replace("/","",$gfile));
if($_GET['delf']) {if($chtking && file_exists($filee)) {unlink($filee);echo "<script>alert('success')</script>";}}
else {
$gfile = str_replace("^","%",$gfile);
if(strchr($_SERVER['HTTP_USER_AGENT'],"Firefox")) $gfile = urldecode($gfile);
if(file_exists($filee) && $chtnck){
if($_GET['view']) $ext = strtolower(substr($gfile,-4));
if($ext=='.jpg' || $ext=='.gif' || $ext=='.png' || $ext=='.bmp'){
header("Content-type:image/jpeg; charset=UTF-8");
header("Content-Disposition: inline; filename=$gfile");
} else {
header("Content-Type: applicaiton/octet-stream; charset=UTF-8");
header("Content-Disposition:attachment; filename=$gfile");
}
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filee));
readfile($filee);
} else {
if($_GET['view']) {
header("Content-type:image/png");
if($im = @imagecreate(100, 60)) {
imagecolorallocate($im,255,255,255);
$text_color = imagecolorallocate($im,0,0,0);
imagestring($im,5,15,20,"no image", $text_color);
imagepng($im);
imagedestroy($im);
}} else {
header ("Content-Type: text/html; charset=UTF-8");
echo "<h1>파일이 없습니다..</h1>";
}}}
exit;
// 2.업로드파일출력 끝
}
// 3.외부출력 시작
header ("Content-Type: text/html; charset=UTF-8");
if($isadmin) {
if(isset($_POST['xword']) || isset($_POST['upload_sum'])) {
if(isset($_POST['upload_sum'])) {
$fs=fopen($dsm,"w");fputs($fs,($_POST['upload_sum']*1048576)."\n");fclose($fs);
} else if(isset($_POST['xword']) && isset($_POST['xnick'])) {
// 3.2.금지된 표현,금지닉처리 시작
$fk = fopen($chtxip,"w");
fputs($fk,str_replace("\r","",$_POST['prhd']));
fclose($fk);
$fph = fopen($chtxwd, "w");
$cnt = count($_POST['xword']);
for($i = 0; $i < $cnt; $i++) if($_POST['xword'][$i]) fputs($fph, $_POST['xword'][$i]."\n");
fclose($fph);
$fpi = fopen($chtxnk, "w");
$cnt = count($_POST['xnick']);
for($i = 0; $i < $cnt; $i++) if($_POST['xnick'][$i]) fputs($fpi, $_POST['xnick'][$i]."\n");
fclose($fpi);
if($_POST['oxempty'] == 'b' || $_POST['oxempty'] == 'c') {$fk=fopen($chtdate2."_oxempty","w");fputs($fk,$_POST['oxempty']);fclose($fk);}
else @unlink($chtdate2."_oxempty");
if($_POST['outin'] == 'b') fclose(fopen($chtdate2."_outin","w"));
else @unlink($chtdate2."_outin");
}
setcookie("open","1");
echo "<script type=\"text/javascript\">location.href='?';</script>";
exit;
// 3.3.금지된 표현,금지닉처리 끝
}
if($_GET['kickout']) {
$fk = fopen($chtxip,"a");fputs($fk,$_GET['kickout']."\n");fclose($fk);
if($_GET['id']) $_GET['ban'] =$_GET['kickout'];
else exit;
}
}}}
if($chtexit) {
if($_POST['nid']) {
// 3.1.채팅방생성처리 시작
$_POST['nid'] = trim($_POST['nid']);
if($_POST['nid'] == '채팅방id') $_POST['nid'] = "";
if($_POST['nid'] !=preg_replace("`[\`\!@#$%^&*\(\)\[\]\"'\.\?/,+=|~\{\}]`", "", $_POST['nid'])) {
echo "<script type=\"text/javascript\">location.href='?';alert('채팅방id에 특수문자 사용 못합니다');</script>";
exit;
}
$id = rawurlencode($_POST['nid']);
$chtfid = $chtdate2. urldecode($_POST['nid']);
$_POST['nid'] = urlencode($_POST['nid']);
if($chtfid && !is_dir($chtfid)) {
if($_POST['pass'] == "비밀번호") $_POST['pass'] = "";
	mkdir($chtfid, 0777);
	mkdir($chtfid."/_upload", 0777);
	mkdir($chtfid."/_gst", 0777);
	mkdir($chtfid."/_ban", 0777);
	mkdir($chtfid."/_data", 0777);
	fclose(fopen($chtfid."/_gst/_guest","w"));
	fclose(fopen($chtfid."/_gst/gv","w"));
	if($_POST['pass']) {
	mkdir($chtfid."/_pass", 0777);
	$fpa = fopen($chtfid."/_pass/".$_POST['pass'],"w");
	fclose($fpa);
	$_SESSION['p_'.$id] = $_POST['pass'];
	}
	fclose(fopen($chtfid."/king_".$chtip,"w"));
	mkdir($chtfid."/_gst/wt", 0777);
	fclose(fopen($chtfid."/_gst/wt/01","w"));
	if($isadmin) fclose(fopen($chtfid."/_admin_","w"));
	$fp=fopen($chtfid."/_data/01","w");
	fputs($fp,"_\x1b환영합니다.\x1b");
	fclose($fp);
	$chtbk = $chtfid."/_bak";
	$bk=fopen($chtbk,"w");fputs($bk,"\x1b환영합니다.\x1b\n");fclose($bk);
	fclose(fopen($chtfid."/date","w"));
echo "<script type=\"text/javascript\">location.href='?id=".$_POST['nid']."'</script>";
} else echo "<script type=\"text/javascript\">location.href='?error=".$_POST['nid']."'</script>";
exit;
// 3.1.채팅방생성처리 끝
}
if($_POST['loginout']){
// 3.4.관리자 로그인/로그아웃처리 시작
if($_POST['loginout'] == "logout") {
$wid = $_SESSION['w_'.$id];
session_unset();
foreach($_COOKIE as $key => $value) {if($key != 'PHPSESSID') setcookie($key,'');}
$_SESSION['w_'.$id] = $wid;
} else if($isadmin && $_POST['install'] == 'uninstall') {
chtrmfd($chtdate."srchat",1);
} else if($isadmin && $_POST['install'] == 'install') {
mkdir($chtdate."srchat", 0777);
$chtfid = $chtdate."srchat/".substr(md5($time),rand(5,20),10);
mkdir($chtfid, 0777);
$fpa = fopen($chtfid."/.htaccess","w");
fputs($fpa,"RewriteEngine On\nRedirectMatch /(.*)$ http://www.yahoo.com");
fclose($fpa);
mkdir($chtfid."/--memo", 0777);
mkdir($chtfid."/--memo/_data", 0777);
mkdir($chtfid."/--memo/_gst", 0777);
mkdir($chtfid."/--memo/_gst/wt", 0777);
fclose(fopen($chtfid."/--memo/_gst/_guest","w"));
fclose(fopen($chtfid."/--memo/_gst/gv","w"));
fclose(fopen($chtfid."/--memo/_gst/wt/00","w"));
fclose(fopen($chtfid."/--memo/_bak","w"));
} else if($_POST['loginout'] == "login" && $_POST['username'] && $_POST['password']) {
foreach($_COOKIE as $key => $value) {if($key != 'PHPSESSID') setcookie($key,'');}
///----------------------------------------------------------------mysql host가 localhost가 아닌경우 아래 수정..
$okcht_ok = mysql_connect("localhost", $_POST['username'], $_POST['password']);
if($okcht_ok && $_POST['username'] == preg_replace("`[^a-z0-9_-]`i","",$_POST['username']) && $_POST['password'] == preg_replace("`[^a-z0-9_-]`i","",$_POST['password'])){
$mk = substr(md5(session_id()),rand(1,25));
$_SESSION['mk'] = $mk;
$yid = md5($mk);
setcookie("mck", $yid);
$xid = md5($yid."\x1b".$mk);
$wid = "w".rand(1000,100000);
setcookie($xid, $wid);
$_SESSION[$wid] = array($_POST['username'],$yid);
}
}
echo "<script type=\"text/javascript\">location.href='?';</script>";
exit;
// 3.4.관리자 로그인/로그아웃처리 끝
}
if(strchr($_SERVER['HTTP_USER_AGENT'],'AppleWebKit')) {$chtdtody = "document.body";$cht100 = "100%";}
else {$chtdtody = "document.documentElement";$cht100 = "0";}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ko" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="generator" content="srchat 192" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type='text/css'>
body {font-size:9pt; font-family:arial,gulim; margin:0; padding:0}
form {margin:0}
label {cursor:pointer}
td,select {font-size:9pt}
input,textarea {font-size:9pt; padding:0}
a:link {color:#828282}
a:visited {color:#828282}
a:hover {color:blue;text-decoration:underline}
hr {border:1px dotted #DBDCD5; height:0}
.hr5 {border-width:2px}
.x {text-decoration:none}
.log {border:2px solid #374169; background-color:#E2ECFF;text-align:center}
.f8 {font-family:tahoma,Gulim; font-size:11px; color:#F9BDAC}
.f7 {font-family:tahoma,Gulim; font-size:7pt; color:#828282} 
.mm {color:#949494;font-weight:bold;font-family:gulim;text-align:center;padding-top:5px}
.cht_button {background:url('chat.png') repeat-x 0% 100%; border:0; border:1px solid #828282; margin-right:1px; margin-left:1px; padding:2px 4px 1px 4px; height:20px; width:38px; cursor:pointer}
.bt {background:url('chat.png') repeat-x 0% 100%; border:0;border:1px solid #828282;cursor:pointer;font-size:11pt;width:15px;font-weight:bold;padding:1px 6px 1px 6px;}
.logn {border:0;border-bottom:1px solid #828282;width:77px;color:#828282}
.n {width:70px;background-color:#FCFCFC;color:#828282;font-weight:bold;padding-left:5px}
div.n {height:19px}
.e {padding:7px 0 7px 5px; width:<?=$chtwidth - 150?>px}
.c {padding:7px 0px 7px 5px}
.d {width:40px; font-family:Tahoma; font-size:6pt; color:#828282}
.cht_ntc div,.cht_ntc td,.cht_ntd div,.cht_ntd td {color:#A3A3A3}
.cht_ntc span,.cht_ntd span,.c span {color:#949494; font-weight:bold}
.nobr {overflow:hidden; white-space:nowrap}
.cht_ipt {width:80px;font-size:8pt;border:0;margin-top:4px;border-width:0px 0px 1px 0px;border-style:solid;border-color:black;background-color:#F9F9F9}
.cht_addv {background:url('chat.png') repeat-x 0% 100%; padding:5px;  margin-top:5px}
#cht_AA {height:<?=$chtheight?>px; overflow:auto; background-color:#FFFFFF; border:1px solid #E4E4E4; border-width:0 1px 0 0}
.corner_1 {table-layout:fixed;border-collapse:collapse; margin-top:30px; border:2px solid #374169; background-color:#FCFCFC}
.corner_2 td {background:url('chat.png') repeat-x 0% 0%; height:30px; border-bottom:1px solid #A4B8FF; font-weight:bold; color:#475488; padding-left:10px}
.corner_4 td {border-top:1px solid #E4E4E4; padding-bottom:10px; padding-left:5px}
.corner_5 td {border-bottom:1px solid #A4B8FF; height:27px}
#cht_CC {text-align:right; font-weight:bold; color:#475488; padding-right:5px}
#cht_DD {height:<?=$chtheight-10?>px; padding:5px; color:#828282; font-weight:bold; overflow:auto; text-align:left; background-color:#FCFCFC}
#cht_DD a {float:left; cursor:pointer}
#cht_DD div.pp {float:left}
#cht_wsp {position:absolute; width:70px; background-color:#FFF; border:1px solid #CEDEFF}
#cht_wsp a {display:block; width:60px; color:#1462FF; font-weight:normal; text-decoration:none; padding:2px 0 2px 10px}
#cht_wsp a:hover {background-color:#CEDEFF}
#logox {display:none}
#cmtd table {border:1px solid #94A5E8}
#cht_img a {padding:2px 5px 0 5px; height:18px; text-decoration:none; width:70px; color:#222}
#cmain div {float:left; padding-top:8px}
#cmain {width:100%; margin-bottom:20px; table-layout:fixed; text-align:left; background-color:#FFF}
#cmain td {border-bottom:1px solid #F5F5F5; text-align:left}
form input {vertical-align:middle}
#cht_fico {padding:5px; text-align:left; margin-top:5px}
#cht_fico img {border:2px solid #F7F7F7; cursor:pointer; width:19px; height:19px}
#cht_fico img:hover {border-color:#FF6633}
input.cht_ckb {vertical-align:middle; padding-left:3px}
h2 {text-align:center}
</style>
<!--[if IE]>
<style type='text/css'>
body {word-break:break-all;scrollbar-highlight-color:#FFFFFF; scrollbar-3dlight-color:#AFAFAF; scrollbar-face-color:#FFFFFF; scrollbar-shadow-color:#AFAFAF; scrollbar-darkshadow-color:#FFFFFF; scrollbar-track-color:#FFFFFF; scrollbar-arrow-color:#AFAFAF;}
td {word-break:break-all}
</style>
<![endif]-->
<!--[if lte IE 6]>
<style type='text/css'>
#cmain {width:<?=($id)? $chtwidth-10:$chtwidth-60?>px}
#cht_AA {text-align:left}
</style>
<![endif]-->
<script type="text/javascript">
//<![CDATA[
function $(val) {
return document.getElementById(val);
}
var cht_imopn;
var cht_popn;
var cht_obj;
var ddval;
var chtbx = 0;
function cht_imgview(src) {
var img = $('cht_img');
if(src == 0 ||img.style.display == "block") {
img.innerHTML = "";
img.style.display = "none";
$('cht_gout').value = '0';
cht_imopn = '';
} else {
setTimeout("cht_imopn = 1",200);
img.style.display = "block";
var srcu = (src.substr(0, 7) != 'http://')? "?id=<?=$id?>&view=" + src:src; 
var imgin = "<div style='width:200px'><a target='_blank' href='" + srcu + "' onclick='cht_imgview(0)' class='cht_button' style='float:left'>새창으로</a>";
if(src != srcu) imgin += "<a target='_blank' href='?id=<?=$id?>&down=" + src + "' onclick='cht_imgview(0)' class='cht_button' style='float:right'>다운로드</a></div>";
img.innerHTML = imgin + "<br /><img onclick='cht_imgview(0)' class='log' style='cursor:pointer' src='" + srcu + "' onload=\"if(this.width > <?=$chtimgwth?>) this.style.width='<?=$chtimgwth?>px';\" alt='' />";
img.style.top  = <?=$chtdtody?>.scrollTop + 100 + 'px';
img.style.width  = (document.layers)?window.innerWidth:window.document.documentElement.clientWidth;
}
}
var cht_ico = Array(''<?
if(is_dir($chticodir)) {
$ep = opendir($chticodir);
while($epp = readdir($ep)) {
if($epp != '.' && $epp != '..') $epps[] = $epp;
}
closedir($ep);
if($epps) {
if($epps[1]) rsort($epps);
foreach($epps as $epp) {
echo ",'{$epp}'";
}}}
?>);


function chtdelf(ths) {
var furl;
var f = ths.nextSibling;
if(f.href.indexOf("#none") == -1) furl = f.href;
else {
var ff = String(f.onclick);
ff = ff.substr(ff.indexOf('cht_imgview') + 13);
furl = '?id=<?=$id?>&view=' + ff.substr(0,ff.indexOf(')') - 1);
}
if(furl) window.open(furl + "&delf=1","exeframe");
}

function cht_tico(f) {
if(f) {
if(f.indexOf("<<") != -1) f = "<span>" + f.replace(/<</g,"<\/span> 님이 입장하셨습니다.");
else if(f.indexOf(">>") != -1) f = "<span>" + f.replace(/>>/g,"<\/span> 님이 퇴장하셨습니다.");
else if(f.indexOf("<>") != -1) f = "<span>" + f.replace(/([^<]+)<>/g,"$1<\/span>  → <span>") + "<\/span> (으)로 바꿨습니다.";
else if(f.indexOf("http:") != -1 || f.indexOf("https:") != -1 || f.indexOf("ftp:") != -1) f = f.replace(/(http|https|ftp):\/\/([^"'<>\r\n\s]+)\.(jpg|gif|png|bmp|jpeg)/gi,"<a href='#none' onclick='cht_imgview(this.innerHTML.replace(/amp;/g,\"\"))'>$1:\\$2.$3</a>").replace(/(http|https|ftp):\/\/([^"'<>\r\n\s]+)/gi,"<a target='_blank' href='$1://$2'>$1://$2</a>").replace(/:\\/gi,"://");
else if('<?=$chtking?>' == '1' && f.indexOf("<a  style='color:red'") != -1) f = f.replace(/<a  style='color:red'/gi,"<input type='button' value='삭제' onclick='chtdelf(this)' style='margin-right:10px' /><a style='color:red'");
else if(f.indexOf("▩") != -1 && f.indexOf(".") != -1) {
var g = f.split("▩");
var gl = g.length;
var fl = -1;
f = g[0];
for(var i=1;i < gl;i++) {
fl = g[i].indexOf(".");
if(fl != -1) {
f += "<img src='<?=$chticodir?>" + cht_ico[g[i].substr(0,fl)] + "' alt='' />";
f += g[i].substr(fl + 1);
} else f += "#" + g[i];
}}}
return f;
}
var fcht_bgclr = Array("","#000000","#7d7d7d","#ff0000","#8c4835","#ff6c00","#ff9900","#ffef00","#a6cf00","#009e25","#006419","#00b0a2","#00ccff","#0095ff","#0075c8","#3a32c3","#7820b9","#ef007c");
var ftface = Array("","굴림","돋움","바탕","궁서","Malgun Gothic","Arial","Tahoma","Verdana");
function cht_tosty(cont) {
var scolor = (cont[3])?" style='color:" + fcht_bgclr[cont[3]] + "'":"";
var nck = "<td class='n'" + scolor + ">" + cont[0] + "<\/td><td class='c' style='";
if(cont[3] || cont[4] || cont[5] || cont[6]) {
if(cont[3]) nck += "color:" + fcht_bgclr[cont[3]] + ";";
if(cont[4]) nck += "font-family:\"" + ftface[cont[4]] + "\";";
if(cont[5]) nck += "font-size:" + cont[5] + "pt;";
if(cont[6] > 0) nck += "font-weight:bold;";
}
nck += "'>" + cht_tico(cont[1]) + "<\/td><td class='d'" + scolor + ">"+ cont[2] +"<\/td>";
return nck;
}
//]]>
</script>
<?
if($chtdate2) {
$iout = ($chtusrinout && file_exists($chtdate2."_outin"))? 1:0;
if($fk = @fopen($chtxip,"r")) {
while(!feof($fk)) {if($chtip."\n" == fgets($fk)) {$kicked =1;break;}}
fclose($fk);
if($kicked) {echo "<h1>접속차단되셨습니다</h1>";exit;}
}
if($_GET['v'] == "p") {
?>
<title><?=$chtuid?> -- [저장된 기록]</title>
</head>
<body onload="settup()"><center>
<table border="0" cellspacing="0px" cellpadding="5px" width="<?=$chtwidth +30?>px" class="corner_1">
<tr><td align="center" id="cmtd">
<script type="text/javascript">
//<![CDATA[
function settup() {
var con = Array(""<?
if(file_exists($chtbk)) {
$fp = fopen($chtbk, "r");
$memo = "";
while($memo = trim(fgets($fp))){
$memo = str_replace("</","<\/",str_replace("`","/",str_replace("\"","\\\"",$memo)));
$con = explode("\x1b", trim($memo));
if($con[4] && substr($memo, 0, 2) == "\x1b\x1b") {
if(substr($con[2],0,12) == $chtip || substr($con[2],12,12) == $chtip) {
$con[0] = ' * ';
$con[1] = $con[3];
$con[2] = $con[4];
}
}
if($con[1] != '') echo ",Array(\"{$con[0]}\",\"{$con[1]}\",\"{$con[2]}\",\"{$con[3]}\",\"{$con[4]}\",\"{$con[5]}\",\"{$con[6]}\",\"{$con[7]}\")";
}
fclose($fp);
}
?>);
var cl = con.length -1;
if(cl > 0) {
var tcon = '<table id="cmain" cellspacing="0px" cellpadding="0px">';
for(var i = 1;i <= cl;i++) {tcon += "<tr>" + cht_tosty(con[i]) + "</tr>";}
$('cmtd').innerHTML = tcon + "</table>";
}}
//]]>
</script>
</td></tr>
</table>
<?
} else {
$exxt = 0;
if(!$_SESSION['w_'.$id]) {
if(file_exists($chtmip.$chtip)) $exxt = 1;
if($exxt == 1 && $time - filemtime($chtmip.$chtip) < 30) $exxt = 9;
else {
$_SESSION['w_'.$id] = rand(100000,900000);
if($exxt == 1) unlink($chtmip.$chtip);
}} else if($fnt = @fopen($chtmip.$chtip,"r")) {
fgets($fnt);
$dgx = trim(fgets($fnt));
fclose($fnt);
if($_SESSION['w_'.$id] != $dgx) $exxt = 9;
}
if($exxt == 9) {
echo "<body><h1 style='text-align:center'>double access denied</h1>";
exit;
}
if($id && is_dir($chtfid)){
// 3.5.채팅방아이디가 있으면 시작
if($_GET['delete'] == "all" && $chtking) {
chtrmfd($chtfid,1);
echo "<script type=\"text/javascript\">location.href = '?';</script>";
exit;
}
if(file_exists($chtfid."/_pass")) $pass = cht_vnmb($chtfid."/_pass/");
if($_POST['epass']) {
if($_POST['epass'] == $pass) {
$_SESSION['p_'.$id] = $pass;
echo "<script type=\"text/javascript\">location.replace('?id=".urlencode($chtuid)."');</script>";
} else if($_POST['epass'] != $pass) {echo "<script type=\"text/javascript\">alert('비밀번호가 틀립니다');location.replace('?id=".urlencode($chtuid)."');</script>";}
exit;
}
if($pass && $pass != $_SESSION['p_'.$id] && !$isadmin) {
$_GET['v'] = "pass";
?>
<div style="width:100%;height:100%;margin-top:100px" align="center">
<form method="post" action="<?=$chat?>">
<input type="hidden" name="id" value="<?=$chtuid?>" />
<table border="0" cellspacing="0px" cellpadding="6px" width="300px" class="log">
<tr><td style="text-align:center">이 채팅방은 비밀번호가 필요합니다.</td></tr>
<tr><td><input type="text" name="epass" value="비밀번호" onclick="if(this.value=='비밀번호') this.value='';" style="width:170px;height:20px;font-size:9pt;">
&nbsp;<input type="submit" value="입력" class="cht_button" />&nbsp;&nbsp;<input type="reset" onclick="location.replace('?')" value="취소" class="cht_button" /></td>
</tr></table>
</form></div>
<?
} else {
if($_FILES['file']){
if($isdsm && $_FILES['file']['size'] > $isdsm) {unlink($_FILES['file']['tmp_name']);$alert = "parent.alert('upload_max_filesize : ".($isdsm/1048576)."mb');";
} else {
$alert = '';
$fme = preg_replace("`[%(){}\+\[\]]`","",str_replace(" ","_",$_FILES['file']['name']));
$ext = strtolower(substr($fme,-4));
if($isdsm) {
$fs = fopen($dsm,"w");
fputs($fs,$isdsm."\n");
$isusm += $_FILES['file']['size'];
if($isusm > $isdsm) {chtrmfd($chtup,0);fputs($fs,$_FILES['file']['size']);}
else fputs($fs,$isusm);
fclose($fs);
}

$dest = $chtup.str_replace("%","",urlencode($fme));
move_uploaded_file($_FILES['file']['tmp_name'], $dest);
$fmee = str_replace("%","^",urlencode($fme));

if($ext=='.jpg' || $ext=='.gif' || $ext=='.png' || $ext=='.bmp'){
$memo = "<a  style='color:red' href='#none' onclick='cht_imgview(\"{$fmee}\")'>{$fme}</a>";
} else {
$memo = "<a  style='color:red' target='_blank' href='{$_SERVER['PHP_SELF']}?id={$id}&amp;down={$fmee}'>{$fme}</a>";
}
$cht_psty = explode('_',$_COOKIE['sty_'.$id]);
$memo= $chtnck."\x1b".$memo."\x1b".$chthis."\x1b".$cht_psty[0]."\x1b".$cht_psty[1]."\x1b".$cht_psty[2]."\x1b".$cht_psty[3];
writee($dwv,$memo);
}
?>
<script type="text/javascript"><?=$alert?>location.replace('<?=$_SERVER['PHP_SELF']?>?id=<?=$id?>&v=file');</script>
<?
exit;
}
if($_GET['ban'] && $chtking) {
fclose(fopen($chtfid."/_ban/".$_GET['ban'],"w"));
$memo = "\x1b<span>".$_GET['nick']."</span>님이 강퇴되셨습니다.\x1b".$chthis."\x1b\x1b\x1b\x1b";
writee($dwv,$memo);
guestt($_GET['ban'],0);
@unlink($chtmip.$_GET['ban']);
exit;
}
if($_GET['handover'] && $chtking) {
fclose(fopen($chtfid."/king_".$_GET['handover'],"w"));
fclose(fopen($chtfid."/refresh_".$_GET['handover'],"w"));
$memo = "\x1b<span>".$_GET['nick']."</span>님으로 방장이 바뀌었습니다.\x1b".$chthis."\x1b\x1b\x1b\x1b";
writee($dwv,$memo);
@unlink($chtfid."/king_".$chtip);
echo "<script type=\"text/javascript\">parent.location.reload();</script>";
exit;
}
if($_GET['v'] == "file") {
?>
<style type='text/css'>
* {overflow:hidden; font-family:Gulim}
body {overflow:hidden; background-color:#F9F9F9; margin:0}
.cht_button {background:url('chat.png') repeat-x 0% 100%; border:0; border:1px solid #828282; margin-right:1px; margin-left:1px; padding:2px 4px 1px 4px; height:20px; width:38px; cursor:pointer}
.file {width:40px; height:40px; opacity:0; position:absolute; top:0; left:0; z-index:2; cursor:pointer}
</style>
<!--[if IE]>
<style type='text/css'>
.file {filter:alpha(opacity=0)}
</style>
<![endif]-->
</head>
<body>
<form enctype="multipart/form-data" action="<?=$chat?>" method="post" style="margin:0">
<input type="hidden" name="id" value="<?=$chtuid?>" />
<input type="button" value="파일" class="cht_button" /><input type="file" class="file" name="file" onchange="if(this.value) submit()" />
</form></body></html>
<?
exit;
}
?>
<title>채팅방 - <?=$chtuid?></title>
</head>
<body onload="setTimeout('cht_setup()', 400);" onclick="if(cht_imopn) cht_imgview(0);if(cht_popn) cht_pmview();">
<center>
<form name="cwf" style="margin:0" onsubmit="cht_go('rpage');return false;" action="" target="exeframe">
<table border="0" cellpadding="0px" cellspacing="0px" class="corner_1">
<tr class="corner_2"><td width="<?=$chtwidth?>px;padding-top:3px"><div style="float:left;text-align:center;width:<?=$chtwidth-90?>px">채팅방 - <?=$chtuid?></div>
<label style="float:right;font-weight:normal;display:none">귓속말<input type="checkbox" id="cht_JJ" onclick="chtipths()" class="cht_ckb" /></label>
<?
if($chtking) {
?>
<input type="button" onclick="tout();location.href='?id=<?=$id?>&amp;delete=all'" value="채팅방삭제" class="cht_button" style="width:80px;float:right" />
<?
}
?></td><td width="140px"><div id="cht_CC"></div></td></tr>
<tr><td class="corner_3"><div id="cht_AA"></div></td>
<td class="corner_3"><div id="cht_DD"></div></td>
</tr>
<tr class="corner_4">
<td>
<div style="padding:6px 0px 8px 6px;text-align:left"><label>이모티콘<input type="checkbox" onclick="cht_toggle('cht_fico');cht_obj.focus()" class="cht_ckb" /></label>
<? if($chtusrinout) {?>
<label>공지삭제<input type="checkbox" id="notixx" onclick="notixe(this.checked);cht_obj.focus()" class="cht_ckb" /></label>
<?}?>
<label>굵게<input id="cht_bold" type="checkbox" value="0" onclick="this.value=(this.checked)?1:0;cht_obj.style.fontWeight=(this.checked)?'bold':'normal';cht_obj.focus()" class="cht_ckb" /></label>
<select id="cht_color" style="width:55px" onchange="cht_fbcolr(this)">
	<option value="" style="background-color:#FFFFFF">색상</option>
	<option value="1" style="background-color:#000000">&nbsp;</option>
	<option value="2" style="background-color:#7d7d7d">&nbsp;</option>
	<option value="3" style="background-color:#ff0000">&nbsp;</option>
	<option value="4" style="background-color:#8c4835">&nbsp;</option>
	<option value="5" style="background-color:#ff6c00">&nbsp;</option>
	<option value="6" style="background-color:#ff9900">&nbsp;</option>
	<option value="7" style="background-color:#ffef00">&nbsp;</option>
	<option value="8" style="background-color:#a6cf00">&nbsp;</option>
	<option value="9" style="background-color:#009e25">&nbsp;</option>
	<option value="10" style="background-color:#1c4827">&nbsp;</option>
	<option value="11" style="background-color:#00b0a2">&nbsp;</option>
	<option value="12" style="background-color:#00ccff">&nbsp;</option>
	<option value="13" style="background-color:#0095ff">&nbsp;</option>
	<option value="14" style="background-color:#0075c8">&nbsp;</option>
	<option value="15" style="background-color:#3a32c3">&nbsp;</option>
	<option value="16" style="background-color:#7820b9">&nbsp;</option>
	<option value="17" style="background-color:#ef007c">&nbsp;</option>
</select>
<select id="cht_face" style="width:58px" onchange="cht_obj.style.fontFamily=ftface[this.options[this.selectedIndex].value];cht_obj.focus()">
	<option value="">글꼴</option>
	<option value="1">굴림</option>
	<option value="2">돋움</option>
	<option value="3">바탕</option>
	<option value="4">궁서</option>
	<option value="5">맑은고딕</option>
	<option value="6">Arial</option>
	<option value="7">Tahoma</option>
	<option value="8">Verdana</option>
</select>
<select id="cht_size" style="width:48px" onchange="cht_obj.style.fontSize=this.options[this.selectedIndex].value + 'pt';cht_obj.focus()">
	<option value="">크기</option>
	<option value="7">7pt</option>
	<option value="8">8pt</option>
	<option value="9">9pt</option>
	<option value="10">10pt</option>
	<option value="11">11pt</option>
	<option value="13">13pt</option>
	<option value="14">14pt</option>
	<option value="15">15pt</option>
</select>
<input type='button' class='cht_button' style='width:58px' value='자리비움' onclick="cht_go('ssetiq')" />
</div>
<input type="text" id="neme" maxlength="10" style="width:72px" value="<?=$chtnck?>" />
<input type="text" id="chcontent" onselect="cht_save_pos(this)" onclick="cht_save_pos(this)" maxlength="200" style="width:<?=$chtwidth - 90?>px;vertical-align:middle" onfocus="this.style.imeMode='active'" onmouseover="this.focus()" />
<div id="cht_fico" style="display:none"></div>
</td>
<td valign="top">
<div style='padding:6px 0px 8px 0px;' align="center"><input type="submit" value="쓰기" class="cht_button" />
<input type="button" value="퇴장" onclick="exit('<?=$_SERVER['PHP_SELF']?>','')" class="cht_button" />
<iframe src="?id=<?=$id?>&amp;v=file" style="width:39px;height:20px;vertical-align:bottom" frameborder="0"></iframe></div>
<a target="_blank" href="<?=$_SERVER['PHP_SELF']?>?id=<?=$id?>&amp;v=p" class="cht_button" style="float:right;margin-right:9px;width:116px;height:16px;padding-top:2px;text-align:center;text-decoration:none;color:#222">저장된 기록</a>
</td></tr>
</table></form>
<script type="text/javascript">
//<![CDATA[
function cht_save_pos(cht_obj) {
if(cht_obj.createTextRange) cht_obj.currentPos = document.selection.createRange().duplicate();
}
function cht_fbcolr(ths) {
var xx = fcht_bgclr[ths.value];
cht_obj.style.color = xx;
$('neme').style.color = xx;
if(xx) ths.style.backgroundColor = xx;
cht_obj.focus();
}
function cht_tag(fvalue) {
if(cht_obj.createTextRange && cht_obj.currentPos && !cht_obj.currentPos.text) cht_obj.currentPos.text = "▩" + fvalue + ".";
else if(cht_obj.selectionStart) cht_obj.value = cht_obj.value.substring(0, cht_obj.selectionStart) + "▩" + fvalue + "." + cht_obj.value.substring(cht_obj.selectionEnd);
else cht_obj.value = cht_obj.value + "▩" + fvalue + ".";
cht_obj.focus();
}
function notixe(tht) {
if(tht) tht = 'none';
else tht = '';
var cht_ntctr = $('cht_AA').getElementsByTagName('tr');
for(var i=cht_ntctr.length-1;i >= 0;i--) {if(cht_ntctr[i].className == 'cht_ntc') cht_ntctr[i].style.display = tht;}
}
//]]>
</script>
<?
}
// 3.5.채팅방아이디가 있으면 끝
} else {
// 3.6.채팅방아이디가 없으면 시작
if($_GET['delete'] == "xext" && $isadmin) {
chtrmfd($chtdate2."--memo/_data",0);
chtrmfd($chtdate2."--memo/_gst",0);
fclose(fopen($chtdate2."--memo/_gst/_guest","w"));
fclose(fopen($chtdate2."--memo/_gst/wt/00","w"));
fclose(fopen($chtdate2."--memo/_gst/gv","w"));
fclose(fopen($chtdate2."--memo/_bak","w"));
echo "<script type=\"text/javascript\">location.href='?';</script>";
exit;
}
if($_GET['error']){
?>
<script type="text/javascript">
//<![CDATA[
if(confirm("<?=$_GET['error']?>방이 이미 있습니다. 그리로 들어가시겠습니까?")) location.href="?id=<?=urlencode($_GET['error'])?>";
else location.href="?";
//]]>
</script>
<?
exit;
}
?>
<title>채팅방</title>
</head>
<body onload="setTimeout('cht_setup()', 400);" onclick="if(cht_imopn) cht_imgview(0);if(cht_popn) cht_pmview();"><center><table border="0" cellspacing="1px" cellpadding="15px" width="<?=$chtwidth +140?>px" class="corner_1">
<tr><td align="center">
<table cellspacing="0px" cellpadding="0px" style="table-layout:fixed;border-collapse:collapse">
<tr><td width="<?=$chtwidth-50?>px"></td><td width="140px"></td></tr>
<tr><td colspan="2" style="text-align:center">
<br /><font color='#828282'><b>채팅방id</b></font>를 넣고, &lt;<font color='#828282'>채팅방</font>&gt;을 개설하세요<br />&lt;<font color='#828282'>비밀번호</font>&gt;는 채팅방을 잠글때만<br /><br />
<form method="post" action="<?=$chat?>" style="margin:0" onsubmit="exit('','');if(document.getElementsByName('pass')[0].value=='비밀번호') document.getElementsByName('pass')[0].value='';">
<input type="text" name="nid" value="채팅방id" onclick="if(this.value=='채팅방id') this.value='';" style="width:<?=$chtwidth -250?>px" />
&nbsp;<input type="submit" value="개설" class="cht_button" style="width:50px" />&nbsp;
<input type="text" name="pass" value="비밀번호" onclick="if(this.value=='비밀번호') this.value='';" style="width:<?=$chtwidth -250?>px" />
</form>
</td></tr>
<tr><td colspan="2" style="text-align:center">
<div id='FF'></div>
<table cellspacing="0px" cellpadding="0px" width="100%" style="table-layout:fixed;text-align:left">
<tr class="corner_2 corner_5"><td colspan="2"><div id="cht_CC"></div></td></tr>
</table></td></tr>
<tr><td><div id="cht_AA" style="height:250px;width:<?=$chtwidth-50?>px;border-width:1px"></div></td>
<td><div id="cht_DD" style="height:250px;width:140px"></div></td></tr>
<tr><td colspan="2" align="left" height="30px">
<form name="cwf" style="margin:0;float:left" onsubmit="cht_go('rpage');return false" action="" target="exeframe">
<input type='text' id='neme' style="width:72px" value="<?=$chtnck?>" />
<input type="text" id="chcontent" maxlength="200" style="width:<?=$chtwidth - 131?>px" />
<input type="submit" value="쓰기" class="cht_button" style="width:50px" />
</form><a target="_blank" href="<?=$_SERVER['PHP_SELF']?>?v=p" class="cht_button" style="float:left;width:68px;padding-top:3px;height:14px;margin-left:3px;text-decoration:none;text-align:center;color:#222">저장된 기록</a>
</td></tr></table>
</td></tr></table>
<p></p><a href="#none" onclick="$('cht_lgn').style.display=($('cht_lgn').style.display=='none')?'block':'none'" class="x"><span>admin</span></a>
<table id="cht_lgn" cellspacing="0px" cellpadding="15px" class="corner_1" style="display:none;width:<?=$chtwidth +136?>px">
<tr><td align="center"><form style="margin:0px;width:100%" method="post" action="<?=$chat?>" onsubmit="tout()">
<?
if($isadmin){
?>
<div class='cht_addv'>금지 단어 지정</div>
<?
if(file_exists($chtxwd)){
$i = 1;
$fph = fopen($chtxwd, "r");
while($fpp = trim(fgets($fph))) {
?>
<input type="text" name="xword[]" class="cht_ipt" value="<?=$fpp?>" />&nbsp;
<?
$i++;
}
fclose($fph);
}
?>
<br /><input type="text" name="xword[]" class="cht_ipt" />
<hr size="3" style="color:#E6E6E6" />
금지 닉네임 지정<hr class="hr1" />
<?
if(file_exists($chtxnk)){
$i = 1;
$fph = fopen($chtxnk, "r");
while($fpp = trim(fgets($fph))) {
?>
<input type='text' name='xnick[]' class='cht_ipt' value='<?=$fpp?>' />&nbsp;
<?
$i++;
}
fclose($fph);
}
?>
<br /><input type="text" name="xnick[]" class="cht_ipt" />
<div class='cht_addv'>접속차단된 IP</div>
<textarea name="prhd" cols="1" rows="5" style="width:150px;height:50px">
<?
if($fk = @fopen($chtxip,"r")) {
while(!feof($fk)) echo fgets($fk);
fclose($fk);
}
if(file_exists($chtdate2."_oxempty")) {$fk=fopen($chtdate2."_oxempty","r");$oxmt=fgets($fk);fclose($fk);} else $oxmt = 0;
?>
</textarea>
<div style='padding:5px;line-height:20px;margin:0 auto;width:190px;text-align:left'>
<? if($chtusrinout) {?><label><input name="outin" type="radio" value="a" <?if(!$iout) echo "checked=\"checked\"";?> /> 출입내역 본문노출</label>&nbsp; <label><input name="outin" type="radio" value="b" <?if($iout) echo "checked=\"checked\"";?> /> 감춤</label><br /><?}?></div>
<select name="oxempty" style="margin-bottom:5px"><option value="a" <? if(!$oxmt) echo "selected=\"selected\"";?>>빈 채팅방 자동삭제</option><option value="b" <? if($oxmt==='b') echo "selected=\"selected\"";?>>모두 유지</option><option value="c" <? if($oxmt==='c') echo "selected=\"selected\"";?>>관리자 개설방만 유지</option></select>
<br />첨부파일 총량제한 : <input type="text" title="각 채팅방의 첨부파일 용량이 이 값에 다다르면 모두 삭제 / 0으로 설정하면 총량제한 사용안함" name="upload_sum" class="cht_ipt" style="width:40px" value="<?=$isdsm/1048576?>" />mb
<br /><input type="submit" value="입력" class="cht_button" style="width:200px" />
</form><hr class='hr5' /><form style="margin:0" method="post" action="<?=$chat?>" onsubmit="tout()">
<input type="button" onclick="if(confirm('채팅을 언인스톨합니까.')) {this.nextSibling.value='uninstall';tout();submit();}" value="uninstall" class="cht_button" style="width:100px" /><input type="hidden" name="install" value="" /><input type="button" onclick="if(confirm('리셋하시겠습니까')) {tout();location.replace('?delete=xext');}" value="대문채팅비움" class="cht_button" style="width:100px" /><input type="hidden" name="request" value="<?=$_SERVER['PHP_SELF']?>" />
<input type="hidden" name="loginout" value="x" /><input type="button" value="로그아웃" class="cht_button" style="width:100px" onclick="this.previousSibling.value='logout';tout();submit()" />
<?
} else {
?>
<input type='hidden' name='loginout' value='login' /><font color='#828282'>아이디</font> : <input type='text' name='username' class='logn' /> &nbsp; <font color='#828282'>비밀번호</font> : <input type='password' name='password' class='logn' /> &nbsp; <input type="submit" value='로그인' class="cht_button" style='width:50px' />
<?}?>
</form></td></tr>
</table>
<?
// 3.6.채팅방아이디가 없으면 끝
}
// 3.7.공통함수 시작
?>
</center>
<script type="text/javascript">
//<![CDATA[
var pxxx;
var chtbx = 0;
var cht_ntime = 0;
var xmlhttp;
var chtnxtr = 0;
function cht_toggle(f) {
f = $(f);
if(f) {f.style.display = (f.style.display == 'none')? '':'none';
}}
function cht_go(view) {
	var param = '';
	var cht_ntime = new Date();
	var gtime = cht_ntime.getTime();
	var stqm = '';
	var cht_etiq = Array(""," style='color:#BABABA' title='자리비움'");
	var cht_ntv = $('cht_ntim').value;
	var cht_ok = '';
	if(view == 'rpage') {
		$('cht_ptim').value = gtime;
		var nam = $('neme').value.replace(/[&'"]/gi,"");
		var contt = cht_obj.value.replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/`/g,"").replace(/%/g,"%25").replace(/&/g,"%26").replace(/\+/g,"%2B").replace(/\\/g,"＼");if(contt =='') return false;
		cht_obj.value = "";
		var dph = Array(<?
		if(file_exists($chtxwd) && !$isadmin){
		$fph = fopen($chtxwd, "r");
		if(!feof($fph)) {
		echo "'".trim(fgets($fph))."'";
		while($ppp = trim(fgets($fph))) echo ",'".$ppp."'";
		}
		fclose($fph);
		}
		?>
		);
		var dpi = Array(<?
		if(file_exists($chtxnk) && !$isadmin){
		$fpi = fopen($chtxnk, "r");
		if(!feof($fpi)) {
		echo "'".trim(fgets($fpi))."'";
		while($ppp = trim(fgets($fpi))) echo ",'".$ppp."'";
		}
		fclose($fpi);
		}
		?>
		);
		if(dph.length) {
		for(var i = 0; dph[i]; i++){
		if(dph[i] && contt.indexOf(dph[i]) != -1) {
		cht_ok = "not";
		alert("금지된 표현 '"+ dph[i] +"' 가 포함되어 있습니다.");
		break;
		}}}
		if(cht_ok == "") {
		if($('cht_pnam').value != nam) {
		if(nam.substr(0,1).replace(/[　\s]/g,"") != "") {
		var dupl = $('cht_DD').getElementsByTagName('a');
		if(dupl && dupl.length > 0) {
		for(var i = dupl.length -1;i >= 0; i--) {
		if(nam == dupl[i].innerHTML) {
		cht_ok = "not";
		alert("중복된 '닉네임' 입니다");
		break;}}}
		for(var i = 0; dpi[i]; i++) {
		if(dpi[i] == nam) {
		cht_ok = "not";
		alert("금지된 '닉네임' 입니다");
		break;
		}
		}
		} else {cht_ok = "not";alert("닉네임 첫글자가 공백입니다");}
		}
		if(cht_ok == "") {
		$('cht_pnam').value = nam;
		if($('prev').value != contt) {
<? if($id) {?>
		var fstyle = $('cht_color').value + '_' + $('cht_face').value + '_' + $('cht_size').value + '_' + $('cht_bold').value;
		if($('cht_psty').value != fstyle) {$('cht_psty').value = fstyle;document.cookie = "sty_<?=$id?>=" + fstyle;}
<?} else echo "var fstyle = '';\n";?>
		if(contt.substr(0,5) == '귓속말//') {
		contt = $('cht_wip').value + '//' + contt;
		if($('cht_JJ').checked == false) $('cht_wip').value = '';
		else cht_obj.value = '귓속말//';
		}
		param = '<?=$chat?>?&id=<?=$id?>&neme='+ nam +'&content='+ contt + '&tt=' + cht_ntv + '&ff=' + fstyle;
		$('prev').value = contt;
		} else alert('중복된 내용입니다');
		}
		}
	} else if(view == 'out') {
		param = "<?=$chat?>?&id=<?=$id?>&content=95798584&tt=" + cht_ntv;
	} else if(view == 'ssetiq') {
		param = "<?=$chat?>?&id=<?=$id?>&content=69847381&tt=" + cht_ntv;
	} else if($('cht_gout').value != '9') {
		var xtval = (parseInt($('cht_xtim').value) + 1)%10;
		$('cht_xtim').value = xtval;
		if(xtval == 0) param = '<?=$chat?>?&id=<?=$id?>&tt=x';
		else param = '<?=$chat?>?&id=<?=$id?>&tt=' + cht_ntv;
	}
if(param != '') {
var cht_ptime = $('cht_ptim').value;
if(window.ActiveXObject) {
var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
}  else if(window.XMLHttpRequest) {
var xmlHttp = new XMLHttpRequest();
}
xmlHttp.open("POST", param, true);
xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
xmlHttp.setRequestHeader("Content-length", param.length);
xmlHttp.setRequestHeader("Connection", "close");
xmlHttp.onreadystatechange = function(){
if(xmlHttp.readyState=='4' && xmlHttp.status=='200') {
	var str = xmlHttp.responseText;
	if(str == "\x7f") {
	var ts = "채팅방 ‥<?=$chtuid?> ";
	var t = cht_ntime.getHours();
	var m = cht_ntime.getMinutes();
	var s = cht_ntime.getSeconds();
	ts += (t < 10)? "0"+t+":":t+":";
	ts += (m < 10)? "0"+m+":":m+":";
	ts += (s < 10)? "0"+s:s;
	pxxx.document.title = ts;
	}
<?if($id){?>
	else if(str.indexOf("<script type=\"text/javascript\">") == 0) eval(str.substr(31,str.length -40));
	else if(str.indexOf("<h1>") == 0) {tout();location.reload();}
<?}?>
	else {
		var strr;
		var isxx =('<?=(int)$chtusrinout?>' != '0' && '<?=$id?>')?$('notixx').checked:'';
		var vew = str.split("\x7f");
		if(vew.length > 0 && vew[0]){
			var sdd = vew[0].split("\x18").length - 1;
			stqm = vew[0].replace(/[0-9a-z]{12}:([01])[^\x18]+\x18/gi,"$1");
			strr = vew[0].replace(/<?=$chtip?>:[01]([^\x18]+)\x18/gi, "< a>*$1</a><div style='clear:left'><\/div>").replace(/([0-9a-z]{12}):[01]([^\x18]+)\x18/gi, "< a onclick='cht_pmview(\"$1\",this)'>$2</a><div class='pp'><\/div><div style='clear:left'><\/div>");
			var stlg = stqm.length;
			for(var i=0;i <= stlg;i++) strr = strr.replace("< a","<a" + cht_etiq[stqm.substr(i,1)]);
			if(cht_popn) ddval = strr;else $('cht_DD').innerHTML = strr;
			$('cht_CC').innerHTML = "참여자 (" + sdd + ")";
		}
		if(vew.length > 1 && vew[1]){
			var aline = vew[1].split("\x18");
			strr = "";
			var alinength = aline.length -1;
			for(var i = 0;i < alinength;i++){
			if(aline[i]) {
			var nam = aline[i].split("\x1b");
			if(nam[0] == '') {var rname = " class='cht_ntc'";
			if(isxx) rname += " style='display:none'";
			} else if(nam[0] == '_') rname = " class='cht_ntd'";
			else var rname = "";
<?if($id){?>
			strr += "<tr"+ rname +">"+ cht_tosty(nam) +"<\/tr>";
<?} else {?>
			strr += "<tr"+ rname +"><td height='25px'><div class='n'>"+ nam[0] +"<\/div><div class='e'>"+ cht_tico(nam[1]) +"<\/div><\/td><\/tr>";
<?}?>
			}}
			strr += "<\/table>";
			if($('cht_AA').innerHTML.length > 51200 || $('cht_AA').innerHTML == '') $('cht_AA').innerHTML = "<table id='cmain' cellspacing='0px' cellpadding='0px'>" + strr;
			else $('cht_AA').innerHTML = $('cht_AA').innerHTML.substring(0,$('cht_AA').innerHTML.length-8)  + strr;
			$('cht_AA').scrollTop = '99000000';
			document.title = '새글이 올라왔습니다. ‥<?=$chtuid?>';
		}
	if('<?=$id?>' == '' && vew[2]) {
strr = "<table cellspacing='0px' cellpadding='0px' width='100%' style='table-layout:fixed;text-align:left;margin-top:5px'><tr class='corner_2 corner_5'><td colspan='2' style='text-align:center'>현재 열려있는 채팅방</td>";
var occh = vew[2].split("\x1b");
var ochlg = occh.length - 1;
var och;
for(var i=0;i < ochlg;i++) {
och = occh[i].split("\x18");
strr += ((i % 2) == 1)? "<td width='50%' class='nobr'>":"</tr><tr><td colspan='2' style='background-color:#F5F5F5;height:1px'><img src='icon/t.gif' style='height:1px' alt='' /></td></tr><tr><td width='50%' class='nobr' height='22px'>";
<? if($isadmin) {?>strr += "&nbsp;<a href=\"#none\" onclick=\"if(confirm('삭제하시겠습니까')) {tout();location.href='<?=$_SERVER['PHP_SELF']?>?id=" + och[0] + "&amp;delete=all';}\" class='x'><span class='f8'>ⓧ</font></a>";
<?}?>
strr += "&nbsp; <a href='#none' onclick=\"exit('<?=$_SERVER['PHP_SELF']?>?id=" + encodeURIComponent(och[0]) + "','" + och[0] + "')\" class='x' title='" + och[0] + " (" + och[1] + ")'><font color='";
strr += (och[2] == '1')? "#FF00AE":"#222222";
strr += "' title='" + ntot(och[3]) + "'>- " + och[0] + "</font></a> <span class='f7'>(" + och[1] + ")</span></td>";
}
strr += ((i % 2) == 1)? "<td>&nbsp;</td></tr>":"</tr>";
$('FF').innerHTML = strr + "</table>";
	}
	if(gtime - cht_ptime > <?=$chtsound?>) $('cht_SS').innerHTML = "<embed src='dingdong.mid' type='application/x-mplayer2' autostart='1' width='1px' height='1px' volume='<?=$cht100?>' />";
	$('cht_ptim').value = gtime;
	}
	$('cht_ntim').value = String(gtime).substr(10);
	if(view == 'rpage') cht_obj.focus();
	else if(view == 'read') setTimeout("cht_go('read')", <?=$chtrefresh?>);
	delete xmlHttp;
}
}
xmlHttp.send(param);
if(view == 'out') return view;
} else cht_obj.focus();
}

function ntot(val) {
val = parseInt(val);
var nwtm = "\n ";
if(val >= 86400) {nwtm += parseInt(val / 86400) + "일 ";val = val % 86400;}
if(val >= 3600) {nwtm += parseInt(val / 3600) + "시간 ";val = val % 3600;}
if(val >= 60) {nwtm += parseInt(val / 60) + "분 ";val = val % 60;}
if(val > 0) nwtm += val + "초 ";
return nwtm + "전부터 \n";
}

function cht_gg() {
if($('cht_ntim').value == $('ispause1').value && $('ispause1').value == $('ispause2').value) {if(cht_obj && cht_obj.value == '') {tout();location.reload();}}
else {
$('ispause2').value = $('ispause1').value;
$('ispause1').value = $('cht_ntim').value;
}
setTimeout('cht_gg()', <?=$chtckcnnct?>);
}
function cht_setup() {
<?
if($_COOKIE['open']) {
setcookie("open");
?>$('cht_lgn').style.display='block';<?}?>

if(top.length == 0) pxxx = self;
else pxxx = top;
cht_obj = $('chcontent');
$('cht_AA').style.overflowX='hidden';
$('cht_ntim').value="a";
$('cht_gout').value='0';
$('cht_xtim').value='0';
<? if($id){if($chtusrinout && $iout) echo "$('notixx').checked=true;notixe(1);\n";?>
var femt = '';
for(var i=cht_ico.length -1;i > 0;i--) femt += "<img src='<?=$chticodir?>" +cht_ico[i] + "' alt='' onclick=\"cht_tag('" + i + "', '', 'ico')\" />";
$('cht_fico').innerHTML = femt;
<?
if($_COOKIE['sty_'.$id]) {
$cht_psty = explode('_',$_COOKIE['sty_'.$id]);
if($cht_psty[0]) echo "$('cht_color').value='{$cht_psty[0]}';cht_obj.style.color=fcht_bgclr[{$cht_psty[0]}];$('neme').style.color=fcht_bgclr[{$cht_psty[0]}];\n";
if($cht_psty[1]) echo "$('cht_face').value='{$cht_psty[1]}';cht_obj.style.fontFamily=ftface[{$cht_psty[1]}];\n";
if($cht_psty[2]) echo "$('cht_size').value='{$cht_psty[2]}';cht_obj.style.fontSize='{$cht_psty[2]}px';\n";
if((int)$cht_psty[3]) echo "$('cht_bold').checked=true;$('cht_bold').value=1;\n";
}}
?>
setTimeout('cht_gg()', <?=$chtckcnnct?>);
cht_go('read');
<? if($mbr_id) echo "\n$('neme').readOnly='true';";?>
cht_obj.focus();
setTimeout("$('cht_AA').scrollTop = '99000000';",1500);
}
function chtipths(ipths) {
if(ipths) {
$('cht_wip').value = ipths;
setTimeout("cht_obj.value = '귓속말//'",200);
$('cht_JJ').checked = true;
$('cht_JJ').parentNode.style.display = '';
} else {
cht_obj.value = cht_obj.value.replace(/귓속말\/\//,'');
$('cht_wip').value = '';
$('cht_JJ').parentNode.style.display = 'none';
}
cht_obj.focus();
}
function cht_pmview(ip,ths) {
var inn = '';
if(ip == '1' || ip == '' || cht_popn) {
inn = $('cht_DD').getElementsByTagName('div');
for(var i=inn.length -1;i >= 0; i--) {if(inn[i].className == 'pp') inn[i].innerHTML = '';}
if(ip != '1') {$('cht_wip').value = '';if(cht_obj.value.substr(0,5) == '귓속말//') cht_obj.value = '';}
cht_popn = '';
if(ddval) {$('cht_DD').innerHTML = ddval;ddval = '';}
} else {
setTimeout("cht_popn = 1",200);
var thsh = ths.innerHTML;
inn = "<a href='#none' onclick='chtipths(\"" + ip + thsh + "\");cht_pmview(1,\"\")'>귓속말<\/a>";
<? if($chtking){ if($id){?>
inn += "<a href='#none' onclick='if(confirm(\"" + thsh + "님을 강퇴합니까?\")) window.open(\"?id=<?=$id?>&ban=" + ip + "&nick=" + thsh + "\", \"exeframe\");cht_pmview()'>강퇴<\/a>";
inn += "<a href='#none' onclick='if(confirm(\"" + thsh + "님에게 방장권한을 이양합니까?\")) window.open(\"?id=<?=$id?>&handover=" + ip + "&nick=" + thsh + "\", \"exeframe\");cht_pmview()'>방장이양<\/a>";
<?} if($isadmin){?>
inn += "<a href='#none' onclick='if(confirm(\"" + thsh + "님을 접속차단합니까?\")) window.open(\"?id=<?=$id?>&kickout=" + ip + "&nick=" + thsh + "\", \"exeframe\");cht_pmview()'>접속차단<\/a>";
<?}}?>
ths.nextSibling.innerHTML = "<div id='cht_wsp'>" + inn + "<\/div>";
}
cht_obj.focus();
}
function exit(url,urln) {
var ggg = cht_go('out');
$('cht_gout').value = '9';
<?if(!strchr($_SERVER['HTTP_USER_AGENT'],"MSIE")){?>
if(urln) var kkk = urln + " 채팅방으로 들어갑니다";
else if(url) var kkk = "채팅방에서 나갑니다";
else var kkk = "개설한 채팅방으로 들어갑니다";
alert(kkk);
<?}?>
if(ggg && url) location.href= url;
}
function tout() {
$('cht_gout').value = '1';
setTimeout("$('cht_gout').value = '0'",1000);
}
<? if($_GET['v'] == "" && $unload == 2) {?>
window.onbeforeunload = function(){if($('cht_gout').value == '0'){if(cht_go('out')){$('cht_gout').value = '9';if(navigator.appName == 'Opera') alert('접속을 종료합니다');else return "---";}}}
window.onunload = function(){window.onbeforeunload();}
<?}?>
//]]>
</script>
<input type="hidden" id="cht_ntim" value="a" /><input type="hidden" id="cht_wip" value="" /><input type="hidden" id="prev" value="" /><input type="hidden" id="cht_psty" value="" /><input type="hidden" id="cht_pnam" value="<?=$chtnck?>" /><input type="hidden" id="cht_xtim" value="0" /><input type="hidden" id="cht_ptim" value="9999999999999" /><input type="hidden" id="ispause1" value="" /><input type="hidden" id="ispause2" value="" />
<div id="cht_SS"></div><iframe name="exeframe" width="0px" height="0px" style="display:none"></iframe>
<?
}} else {
?>
<body>
<center style="padding-top:100px">
<h2>설치되지 않았습니다.</h2>
<form name='logox' style="padding:30px;text-align:center" method="post" action="<?=$chat?>">
<input type="hidden" name="install" value="" />
<input type="hidden" name="loginout" value="x" />
<input type="hidden" name="request" value="<?=$_SERVER['PHP_SELF']?>" />
<?
if($isadmin){
?>
<input type="button" class="cht_button" value="install" onclick="document.logox.install.value='install';submit()" style="width:100px" />
<input type="button" class="cht_button" value="logout" onclick="document.logox.loginout.value='logout';submit()" style="width:100px" />
<?
} else {
?>
<font color='#828282'>아이디</font> : <input type='text' name='username' class='logn' /> &nbsp; 
<font color='#828282'>비밀번호</font> : <input type='password' name='password' class='logn' /> &nbsp; 
<input type="button" class="cht_button" value="login" onclick="document.logox.loginout.value='login';submit()" style="width:100px" />
<?}?>
</form></center>
<?}}?>
<div id="cht_img" style="display:none;z-index:9;position:absolute;top:0;left:0;width:100%" align="center"></div><input type="hidden" id="cht_gout" value="0" />
</body>
</html>