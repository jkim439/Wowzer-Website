<?
ob_start();
session_start();
/*
 * srchat 203.0 위젯
 * Developed By 사리 (sariputra3@naver.com)
 * License : GNU Public License (GPL)
 * Homepage : http://srboard.styx.kr/srboard/index.php?id=blog&ct=06
 */
$chat = "chat4.php";
$chtdate = "srchat/chat/srchat_4/"; //데이타파일 저장경로(권한777)
$chtrefresh = 1500; // 새글 확인하는 인터벌
$chtlastgap = 10; // 단위는 초, 접속여부 판단하는 현재시간-마지막접속시간 간격
$chtemptgap = 180; // 단위는 초, 퇴장으로 판단하는, 자리비움 경과시간
$chtsound = 20000; // 소리로 표시하는 인터벌(default 20초)
$chtimgwth = 700; // 이미지클릭했을때 최대넓이
$chticodir = "srchat/emoticon/"; // 이모티콘 저장된 경로
$chtmid = "srchat/dingdong.mid"; // 알림음 파일경로
$chtusrinout = 0; // 사용자 입출력상황 본문출력 여부
$chtchange = 1; // 사용자 닉네임변경 본문출력 여부
$chtaway = 1; // 자리비움하고 새로고침 했을 때, 자리비움상태 유지 여부 (0:해제,1:유지)
$chtread = 10; // 처음 접속했을 때, 읽어오는 본문의 갯수 (최대 90)
$time = time();
$cht_isadmin = 0;
$chthis = date("H:i:s",$time);
$exxt = array('_GET','_POST','_SESSION','_COOKIE','_FILES','_SERVER','sessid','isadmin');
for($i=0;$i < 8;$i++) if(isset($_GET[$exxt[$i]]) || isset($_POST[$exxt[$i]])) exit;
$chtip = str_pad(str_replace('.','',$_SERVER['REMOTE_ADDR']),12,'x'); /* ip로 사용자구분 할때 */
//$chtip = substr(session_id(),0,12); /* ip로 사용자구분 안할때 */
if($_COOKIE['mck'] == md5($_SESSION['mk'])) {
if($adm = $_SESSION[$_COOKIE[md5($_COOKIE['mck']."\x1b".$_SESSION['mk'])]]) {
if($adm[1] == $_COOKIE['mck']) $cht_isadmin = 1;
}}
$chtnck = ($_SESSION['chtnick'])? $_SESSION['chtnick']:"손님_".substr($chtip,4,4);
$chtexit = ($_SERVER['HTTP_REFERER'] && false === strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST']))? '':'1';
function cht_vnmb($view) {
$ff = opendir($view);
while($fg = readdir($ff)) {
if($fg != '.' && $fg != '..') {$fff = $fg;break;}
}
closedir($ff);
return $fff;
}
function cht_mkroom($chtyd) {
mkdir($chtyd, 0777);
mkdir($chtyd."/_data", 0777);
mkdir($chtyd."/_gst", 0777);
mkdir($chtyd."/_ban", 0777);
mkdir($chtyd."/_upload", 0777);
mkdir($chtyd."/_gst/wt", 0777);
fclose(fopen($chtyd."/_bak","w"));
fclose(fopen($chtyd."/_gst/_guest","w"));
fclose(fopen($chtyd."/_gst/m_","w"));
fclose(fopen($chtyd."/_gst/gv","w"));
fclose(fopen($chtyd."/_gst/wt/00","w"));
$fpa = fopen($chtyd."/.htaccess","w");
fputs($fpa,"RewriteEngine On\nRedirectMatch /(.*)$ http://www.yahoo.com");
fclose($fpa);
$ftc = fopen($chtyd."/_chtntc","w");
fputs($ftc, "1\nGulim\n8\n1\nN\nN\n0\n30\n0\n0\n550px\n400px\nh\n400px\n150px\n");
fclose($ftc);
$fs = fopen($chtyd."/_fsum","w");fputs($fs,"2\n0");fclose($fs);
}
if(!$chtid) $chtid = ($_POST['chtid'])? $_POST['chtid'] : $_GET['chtid'];
if(($chtdata = cht_vnmb($chtdate)) && $chtid) {
$chtfid = $chtdate.$chtdata."/".$chtid."/";
if(!file_exists($chtfid)) $chtfid = '';
$chtxwd = $chtfid."_xword"; // 금지된 표현
$chtxnk = $chtfid."_xnick"; // 금지닉네임
if($chtexit && file_exists($chtfid."_ban/".$chtip)) {
$chtexit = 'exit';
echo "<h1>접속차단되셨습니다</h1>";
} else if($chtfid) {
$chtdt = $chtfid."_data/";
$chtbk = $chtfid."_bak";
$ischtbk = (file_exists($chtbk))?1:0;
$chtgt = $chtfid."_gst/_guest";
$chtwt = $chtfid."_gst/wt/";
$chtgv = $chtfid."_gst/gv";
$chtmip = $chtfid."_gst/m_";
if($delmip) @unlink($chtmip.$chtip);
$chtqip = $chtfid."_gst/q_";
$chtup = $chtfid."_upload/";
$dsm = $chtfid."_fsum";
if(!$_POST['tt']) {
if(file_exists($chtup)) {
$isdid = 1;
if($cht_isadmin || $_FILES['file']) {
if(file_exists($dsm) && $fd = fopen($dsm,"r")) {
$isdsm = (int)fgets($fd);
$isusm = (int)fgets($fd);
fclose($fd);
}}
} else $isdid = 0;
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
 global $ischtbk, $chtbk, $chtwt, $chtdt;
$ndwv = $dwn%90 + 1;
$ndwv = str_pad($ndwv, 2, '0', STR_PAD_LEFT);
@rename($chtwt.$dwn, $chtwt.$ndwv);
$fp = fopen($chtdt.$ndwv,"w");
fputs($fp,$mema);
fclose($fp);
if($ischtbk) {
$bk=fopen($chtbk,"a");
fputs($bk,str_replace("\x18","\n",$mema)."\n");
fclose($bk);
}
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
if(($_POST['tt'] != 'a' || !$chtaway) && file_exists($chtqip.$chtip)) {unlink($chtqip.$chtip);$mdd = 1;}
if($chtnck != $_POST['neme']){ // 닉변경되었으면
if($_POST['neme'] = newtext($_POST['neme'], 1)) {
if($_SESSION['chtnick'] && $chtchange) $memo .= "\x1b".$chtnck."<>".$_POST['neme']."\x1b".$chthis."\x1b\x18";
$chtnck = $_POST['neme'];
$_SESSION['chtnick'] = $_POST['neme'];
$mdd = 1;
}}
if($mdd == 1) {
fclose(fopen($chtgv,"w"));
$egv = $time;
}}
if($_POST['ff'] && $_POST['ff'] != $_COOKIE['cht_sty4']) {$_COOKIE['cht_sty4'] = $_POST['ff'];setcookie('cht_sty4',$_POST['ff']);$mdd = 1;}
else if(!$_COOKIE['cht_sty4']) $_COOKIE['cht_sty4'] = '00';
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
if($fgdo == $chtip) {$is = 1;$meo .= $chtip.":".(($_POST['neme'] && $mdd == 1)? "0":$fgo[13]).$_COOKIE['cht_sty4'].$chtnck."\n";}
else if($time - @filemtime($chtmip.$fgdo) > $chtlastgap || ($fgo[13] == "1" && $time - @filemtime($chtqip.$fgdo) > $chtemptgap)) {@unlink($chtmip.$fgdo);$mdd =1;$mout = substr($fgo,14,-1);}
else $meo .= $fgo;
}
fclose($fg);
if(!$is) $meo .= $chtip.":0".$_COOKIE['cht_sty4'].$chtnck."\n";
if($chtusrinout) {
if(!$is) $memo .= "\x1b".$chtnck."<<\x1b".$chthis."\x1b\x18";
if($mout) $memo .= "\x1b".$mout."<<\x1b".$chthis."\x1b\x18";
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
if(substr($chtid,0,2) == '__') {
if($fg = @fopen($chtgt,'r')) {
if(trim(fgets($fg)) == '' || trim(fgets($fg)) == '') chtrmfd($chtfid,1);
fclose($fg);
}}
if(!$chtaway || $time - @filemtime($chtqip.$chtip) > $chtemptgap) {
guestt($chtip,1);
if($chtusrinout) {
$memo = "\x1b".$chtnck.">>\x1b".$chthis."\x1b";
writee($dwv,$memo);
}
@unlink($chtmip.$chtip);
}}
exit;
}
if($chtnck && $_POST['content']){ // 새글처리
$_POST['content'] = newtext($_POST['content']);
if($_POST['content']) {
if(strpos($_POST['content'],'//whisper//') !== false) {
$wpcnt = explode('//whisper//',$_POST['content']);
$wpnk = substr($wpcnt[0],12);
$wwip = substr($wpcnt[0],0,12);
if($wpcnt[1] == '11chat') {
if($wpcnt[2]) {
if($wpcnt[2] == 'xx') $memo = "\x1b\x1b".$wwip.$wwip."\x1b<span class='dv'>".$wpnk."</span>님의 1:1 대화신청을 <span class='dv'>".$chtnck."</span>님이 거절하셨습니다.\x1b".$chthis."\x1b";
else $memo = "\x1b\x1b".$wwip.$wwip."\x1b<span class='dv'>".$wpnk."</span>님의 1:1 대화신청을 <span class='dv'>".$chtnck."</span>님이 수락하셨습니다.<br /> <a target='_blank' href='".$chat."?chtid=".$wpcnt[2]."' onmousedown=\"cht_go('ssetiq')\"><b>여기를</b></a> 클릭하세요\x1b".$chthis."\x1b";
} else {
$chtyd = substr(md5($wwip),8,16);
$memo = "\x1b\x1b".$wwip.$wwip."\x1b<span class='dv'>".$wpnk."</span>님에게 <span class='dv'>".$chtnck."</span>님이 1:1 대화를 신청하셨습니다.<br /> <a target='_blank' href='".$chat."?chtid=__".$chtyd."&amp;mkcht=1' onmousedown=\"cht_obj.value='".$chtip.$chtnck."//whisper//11chat//whisper//__".$chtyd."';cht_go('rpage');cht_go('ssetiq')\"><b>수락</b></a> 또는 <a href='#none' onmousedown=\"cht_obj.value='".$chtip.$chtnck."//whisper//11chat//whisper//xx';cht_go('rpage');\"><b>거절</b></a>\x1b".$chthis."\x1b";
}} else $memo= "\x1b\x1b".$chtip.$wwip."\x1b<span class='dv'>".$wpnk."</span>님에게 <span class='dv'>".$chtnck."</span>님의 귓속말 &gt;<br />".$wpcnt[1]."\x1b".$chthis."\x1b";
} else {
if(substr($_POST['content'],0,3) == '(b)') $_POST['content'] = '<b>'.substr($_POST['content'],3).'</b>';
$memo .= $chtnck."\x1b".$_POST['content']."\x1b".$chthis."\x1b".(int)$_POST['ff'];
}}} else $memo = substr($memo,0,-1);
if($memo) $dwv = writee($dwv,$memo);
if($vv || $red != $dmv || $time - $egg > 4){
$mnt = fopen($chtmip.$chtip,"w");
fputs($mnt,$dwv.$egv."\n".md5($_SERVER['HTTP_USER_AGENT']));
fclose($mnt);
}
echo "\x7f";
if($_POST['tt'] == 'a' || $red <> $dwv) { // 새글읽기
if($_POST['tt'] == 'a') $red = ($dwv > $chtread)? $dwv - $chtread:90 - $chtread + $dwv;
echo  reaad($dwv,$red);
}
exit;
// 1.내부데이타처리 끝
} else if($_POST['delf'] || $_GET['view'] || $_GET['down']){
// 2.업로드파일출력 시작
if($_POST['delf']) $gfile = $_POST['delf'];
else $gfile = ($_GET['view'])? $_GET['view']:$_GET['down'];
$filee = $chtup.str_replace("^","",str_replace("/","",$gfile));
if($_POST['delf']) {if($cht_isadmin && file_exists($filee)) {unlink($filee);echo "<script>alert('success');";if(!$_POST['frombk']) echo "location.replace('{$chat}?chtid={$chtid}&v=ban');";echo "</script>";}}
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
if($cht_isadmin) {
if($_POST['install'] == '1') {
// 3.4.관리자 로그인/로그아웃처리 시작
if($_POST['backup'] == 'reset') {
fclose(fopen($chtbk,"w"));
} else if($_POST['empty'] == 'empty') {
fclose(fopen($chtbk,"w"));
chtrmfd($chtfid."_data/",0);
chtrmfd($chtfid."_gst/",0);
fclose(fopen($chtfid."_gst/gv","w"));
chtrmfd($chtfid."_ban/",0);
chtrmfd($chtfid."_upload/",0);
$fs = fopen($dsm,"w");
fputs($fs,$isdsm."\n0");
fclose($fs);
fclose(fopen($chtfid."_gst/wt/00","w"));
} else if($_POST['upload_delete']) {
$fs = fopen($dsm,"w");fputs($fs,$isdsm."\n0");fclose($fs);
chtrmfd($chtup,0);
} else if($_POST['delcht']) {
chtrmfd("chat/".$chtdata."/".$_POST['delcht'],1);
} else {
if(isset($_POST['prhd'])) {
chtrmfd($chtfid."_ban/",0);
$prhe = explode("\n",str_replace("\r","",$_POST['prhd']));
foreach($prhe as $entry) {if($entry) fclose(fopen($chtfid."_ban/".$entry,"w"));}
$fph = fopen($chtxwd, "w");
$cnt = count($_POST['xword']);
for($i = 0; $i < $cnt; $i++) if($_POST['xword'][$i]) fputs($fph, $_POST['xword'][$i]."\n");
fclose($fph);
$fpi = fopen($chtxnk, "w");
$cnt = count($_POST['xnick']);
for($i = 0; $i < $cnt; $i++) if($_POST['xnick'][$i]) fputs($fpi, $_POST['xnick'][$i]."\n");
fclose($fpi);
}
if($_POST['chtmaxupload']) {$fs = fopen($dsm,"w");fputs($fs,$_POST['chtmaxupload']."\n".$isusm);fclose($fs);}
else if($isusm) {$fs = fopen($dsm,"w");fputs($fs,"0\n".$isusm);fclose($fs);}
if($_POST['chtusebak'] == 'a') {if(!$ischtbk) fclose(fopen($chtbk,"w"));}
else @unlink($chtbk);
if($_POST['chtuseupload'] == 'a') {if(!$isdid) mkdir($chtup,0777);}
else chtrmfd($chtup,1);
$ftc = fopen($chtfid."_chtntc","w");
fputs($ftc, $_POST['chtfbold_']."\n");
fputs($ftc, $_POST['chtfmly_']."\n");
fputs($ftc, $_POST['chtftsz_']."\n");
fputs($ftc, $_POST['chtunload_']."\n");
fputs($ftc, $_POST['chtisbr_']."\n");
fputs($ftc, $_POST['chtuseico_']."\n");
fputs($ftc, $_POST['chtusealert_']."\n");
fputs($ftc, $_POST['chtnoticet_']."\n");
fputs($ftc, $_POST['chtnoticex_']."\n");
fputs($ftc, $_POST['chtwidth_']."\n");
fputs($ftc, $_POST['chtheight_']."\n");
fputs($ftc, $_POST['chthorizon_']."\n");
fputs($ftc, $_POST['cht_cntwh_']."\n");
fputs($ftc, $_POST['cht_usrwh_']."\n");
fputs($ftc, $_POST['chtemptybak_']."\n");
fputs($ftc, $_POST['chtpause_']."\n");
fputs($ftc, $_POST['chtreload_']."\n");
fputs($ftc, $_POST['chtview_']."\n");
fputs($ftc, stripslashes($_POST['chtnoticed_']));
fclose($ftc);
}
echo "<script type=\"text/javascript\">location.replace('{$chat}?chtid={$chtid}&v=ban&admin=1');</script>";
exit;
// 3.4.관리자 로그인/로그아웃처리 끝
} else if($_POST['ban'] && $_POST['ban'] != $chtip) {
fclose(fopen($chtfid."_ban/".$_POST['ban'],"w"));
$memo = "\x1b<span>".$_POST['nick']."</span>님이 강퇴되셨습니다.\x1b".$chthis."\x1b";
writee($dwv,$memo);
guestt($_POST['ban'],0);
@unlink($chtmip.$_POST['ban']);
echo "<script type=\"text/javascript\">location.replace('{$chat}?chtid={$chtid}&v=ban');</script>";
exit;
}}
if($isdid && $_FILES['file']){
if($isdsm && $_FILES['file']['size'] > $isdsm*1048576) {unlink($_FILES['file']['tmp_name']);$alert = "parent.alert('upload_max_filesize : ".$isdsm."mb');";
} else {
$alert = '';
$fme = preg_replace("`[%(){}\+\[\]]`","",str_replace(" ","_",$_FILES['file']['name']));
$ext = strtolower(substr($fme,-4));
if($isdsm) {
$fs = fopen($dsm,"w");
fputs($fs,$isdsm."\n");
$isusm += $_FILES['file']['size'];
if($isusm > $isdsm*1048576) {chtrmfd($chtup,0);fputs($fs,$_FILES['file']['size']);}
else fputs($fs,$isusm);
fclose($fs);
}
$dest = $chtup.str_replace("%","",urlencode($fme));
move_uploaded_file($_FILES['file']['tmp_name'], $dest);
$fmee = str_replace("%","^",urlencode($fme));
if($ext=='.jpg' || $ext=='.gif' || $ext=='.png' || $ext=='.bmp'){
$memo = "<a  style='color:red' href='#none' onclick='cht_imgview(\"{$fmee}\")'>{$fme}</a>";
} else {
$memo = "<a  style='color:red' target='_blank' href='{$_SERVER['PHP_SELF']}?chtid={$chtid}&amp;down={$fmee}'>{$fme}</a>";
}
$memo= $chtnck."\x1b".$memo."\x1b".$chthis."\x1b".$_COOKIE['cht_sty4'];
writee($dwv,$memo);
}
?>
<script type="text/javascript"><?=$alert?>location.replace('<?=$chat?>?chtid=<?=$chtid?>&amp;v=file');</script>
<?
exit;
}} else if($_GET['mkcht'] && $chtid == "__".substr(md5($chtip),8,16)) {
cht_mkroom($chtdate.$chtdata."/".$chtid);
echo "<script type='text/javascript'>location.href='?chtid={$chtid}';</script>";
exit;
} else if(!$cht_isadmin || substr($_GET['chtid'],0,2) == '__') {echo "<fieldset style='padding:15px;text-align:center'>채팅방이 존재하지 않습니다</fieldset>";$chtexit = 'exit';}}
if($chtexit != 'exit') {
if($_POST['install'] && $cht_isadmin) {
if($_POST['install'] == 'install') {
@mkdir($chtdate);
$_POST['chtid'] = trim($_POST['chtid']);
if($_POST['chtid'] !=preg_replace("`[\`\!@#$%^&*\(\)\[\]\"'\.\?/,+=|~\{\}]`", "", $_POST['chtid'])) {
echo "<script type=\"text/javascript\">location.href='?';alert('채팅방id에 특수문자 사용 못합니다');</script>";
exit;
}
if(!$chtdata) {
$chtdata = substr(md5($time),rand(5,20),10);
mkdir($chtdate.$chtdata, 0777);
}
$chtfid = $chtdate.$chtdata."/".urldecode($_POST['chtid']);
cht_mkroom($chtfid);
} else if($_POST['install'] == 'uninstall') chtrmfd($chtfid,1);
echo "<script type=\"text/javascript\">opener.tout();opener.location.reload();location.replace('{$chat}?chtid={$chtid}&v=ban&admin=1');</script>";
exit;
}
if($_GET['css']) {
header ("Content-Type: text/css");
?>
/* chatting */
fieldset#cht_fbdy {border:0; border:1px solid #BEC0C3}
#cht_fbdy div,#cht_fbdy input,#cht_fbdy select,#cht_fbdy form,#cht_fbdy table,#cht_fbdy td {margin:0; padding:0}
#cht_fbdy,#cht_img,#cht_fbdy input {font-size:9pt}
#cht_fbdy #neme, #cht_fbdy #cht_color {font-size:9pt; font-family:Gulim; margin-top:1px; width:55px}
#cht_fbdy #chcontable {clear:both; width:100%}
#cht_fbdy #chcontent {width:100%; font-size:9pt; vertical-align:bottom; height:16px; margin-left:4px}
#cht_fbdy .cht_button, #cht_img .cht_button {background:url('srchat/chat.png') repeat-x 0% 100%; border:0; border:1px solid #828282; margin-right:1px; margin-left:1px; padding:2px 4px 1px 4px; height:20px; width:38px; cursor:pointer; color:#444444}
#cht_fbdy #cht_AA {overflow:auto}
#cht_fbdy #cht_AA div {padding:1px 1px 1px 4px; line-height:140%}
#cht_fbdy #cht_AA b {cursor:pointer}
#cht_fbdy #cht_AA b.myself {background:#DBFDD4} /* 글쓴이 닉네임을 본문에서 구분,강조 */
#cht_fbdy #cht_AA span.cht8 {color:#EBF2FF; background:#000000; font-size:8pt}
#cht_fbdy #cht_SS {clear:both; padding:3px 0 3px 0; color:#444444; border-top:1px solid #CEDEFF; border-bottom:1px solid #CEDEFF}
#cht_fbdy .cht_ntc {padding:2px 2px 2px 10px; color:#A3A3A3}
#cht_fbdy .cht_ipt {width:80px; font-size:8pt; border:0; margin-top:4px; border-width:0px 0px 1px 0px; border-style:solid; border-color:black}
#cht_fbdy .cht_addv {background:url('srchat/chat.png') repeat-x 0% 100%; padding:5px;  margin:10px 0 5px 0}
#cht_fbdy #cht_CC {background:url('srchat/chat.png') repeat-x 0% 0%; cursor:n-resize; color:#475488; padding:8px; height:14px; border-bottom:1px solid #E6E6E6}
#cht_fbdy #cht_CC #cht_EE {float:left; font-weight:bold}  /* 참여자 */
#cht_fbdy #cht_CC #cht_FF {float:right; text-align:right; font-size:8pt} /* 시간 */
#cht_fbdy #cht_DD {overflow:auto} /* 참여자 목록 */
#cht_fbdy div.dv {padding:10px 0 10px 0}
#cht_fbdy .dv, #cht_fbdy .dv a, #cht_fbdy #cht_AA .bx a {font-size:9pt; color:#7991BF; font-weight:bold}
#cht_fbdy #cht_DD dl,#cht_fbdy #cht_DD dt {margin:0; padding:0}
#cht_fbdy #cht_DD dd, #cht_fbdy #cht_AA .bx {display:none; width:90px; margin:0 0 0 10px; padding:8px 0 8px 5px; line-height:16px; border:1px solid #7991BF; background-color:#FFFFFF}
#cht_fbdy #cht_DD dt {height:18px; margin-left:7px}
#cht_fbdy a:link, #cht_fbdy a:visited, #cht_img a:link, #cht_img a:visited {text-decoration:none}
#cht_fbdy #cht_AA .cx {vertical-align:middle}
#cht_fbdy #cht_AA .cx a:link, #cht_fbdy #cht_AA .cx a:visited {text-decoration:underline}
#cht_fbdy a:hover,#cht_fbdy a:hover {text-decoration:underline; cursor:pointer}
#cht_fbdy #cht_bkadm a {color:#222222}
#cht_fbdy #cht_bkadm {float:right; padding-top:2px}
#cht_fbdy #cht_img a {padding:2px 5px 0 5px; height:18px; text-decoration:none; width:70px; color:#222; font-size:9pt}
#cht_fbdy #cht_fico img {border:2px solid #F7F7F7; cursor:pointer; width:19px; height:19px}
#cht_fbdy #cht_fico img:hover {border-color:#FF6633}
#cht_fbdy input.cht_ckb {vertical-align:middle; height:13px; margin-bottom:2px; margin-left:3px}
#cht_fbdy #neme {height:14px; margin-left:6px}
#cht_fbdy #chtupload {float:right; margin:1px 6px 0 0; width:41px; height:18px}
#cht_fbdy #cht_fico {clear:both; padding:5px; text-align:left; margin-top:5px}
#cht_img {display:none; z-index:9; position:absolute; top:0; left:0; width:100%; text-align:center}
<?
exit;
}
if($_GET['js']) {
header ("Content-Type: text/javascript; charset=UTF-8");
?>
var cht_imopn;
var cht_obj;
var cht_tid = 0;
var chtusealert = 0;
var cht_eeo = 0;
var cht_nxthtml;
var dph = Array();
var chtunload = 'N';
var chtv100 = '0';
var chtisbr = 'N';
var chtip = '';
var chtisbk;
var chtbx = 0;
var cht_ntime = 0;
var xmlhttp;
var chtnxtr = 0;
var chtreload = 0;
var chtview = 0;
var cht_ico = Array(''<?
if(@is_dir($chticodir)) {
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
var dpi = Array(<?
if(file_exists($chtxnk) && $fpi = @fopen($chtxnk, "r")){
if(!feof($fpi)) {
echo "'".trim(fgets($fpi))."'";
while($ppp = trim(fgets($fpi))) echo ",'".$ppp."'";
}
fclose($fpi);
}
?>
);

function $(key) {return document.getElementById(key);}
function cht_imgview(src) {
var img = $('cht_img');
if(src == 0 ||img.style.display == "block") {
img.innerHTML = "";
img.style.display = "none";
$('cht_gout').value = '0';
cht_imopn = '';
if(cht_nxthtml) {
cht_nxthtml.style.display = 'none';
cht_nxthtml = '';
}} else {
var srcu = (src.substr(0, 7) != 'http://')? chtsrchat + "&amp;view=" + src:src;
if(chtview == '1') {window.open(srcu.replace(/amp;/g,''),'_blank');return false;}
setTimeout("cht_imopn = 1",200);
img.style.display = "block";
var imgin = "<div style='width:200px;margin:0 auto'><a target='_blank' href='" + srcu + "' onclick='cht_imgview(0)' class='cht_button' style='float:left;width:60px;height:16px'>새창으로</a>";
if(src != srcu) imgin += "<a target='_blank' href='" + chtsrchat + "&amp;down=" + src + "' onclick='cht_imgview(0)' class='cht_button' style='float:right;width:60px;height:16px'>다운로드</a></div>";
img.innerHTML = imgin + "<br /><img onclick='cht_imgview(0)' style='cursor:pointer;border:2px solid #374169;background-color:#E2ECFF;text-align:center' src='" + srcu + "' onload=\"if(this.width > 700) this.style.width='700px';\" alt='' />";
img.style.top  = document.documentElement.scrollTop + 100 + 'px';
img.style.width  = (document.layers)?window.innerWidth + 'px':window.document.documentElement.clientWidth + 'px';
}
}

function chtdelf(ths) {
var furl;
var fkl;
var f = ths.nextSibling;
if(f.href.indexOf("#none") == -1) {
furl = f.href;
fkl = furl.indexOf("down=") + 5;
if(fkl == 4) fkl = furl.indexOf("view=") + 5;
if(fkl == 4) {alert('failure');return false;}
fkl = furl.substr(fkl);
if(fkl.indexOf("&") != -1) fkl = fkl.substr(0,fkl.indexOf("&"));
} else {
var ff = String(f.onclick);
ff = ff.substr(ff.indexOf('cht_imgview') + 13);
fkl = ff.substr(0,ff.indexOf(')') - 1);
furl = chtsrchat + '&view=' + fkl;
}
if(furl) cht_kout('',fkl);
}
function cht_tico(f) {
if(f) {
if(f.indexOf("<<") != -1) f = "▶ <span class='dv'>" + f.replace(/<</g,"<\/span> 님이 입장하셨습니다.");
else if(f.indexOf(">>") != -1) f = "▶ <span class='dv'>" + f.replace(/>>/g,"<\/span> 님이 퇴장하셨습니다.");
else if(f.indexOf("<>") != -1) f = "▶ <span class='dv'>" + f.replace(/([^<]+)<>/g,"$1<\/span>  → <span class='dv'>") + "<\/span> (으)로 바꿨습니다.";
else if(f.indexOf("http:") != -1 || f.indexOf("https:") != -1 || f.indexOf("ftp:") != -1) f = f.replace(/(http|https|ftp):\/\/([^"'<>\r\n\s]+)\.(jpg|gif|png|bmp|jpeg)/gi,"<a href='#none' onclick='cht_imgview(this.innerHTML.replace(/amp;/g,\"\"))'>$1:\\$2.$3</a>").replace(/(http|https|ftp):\/\/([^"'<>\r\n\s]+)/gi,"<a target='_blank' href='$1://$2'>$1://$2</a>").replace(/:\\/gi,"://");
else if('<?=$cht_isadmin?>' == '1' && f.indexOf("<a  style='color:red'") != -1) f = f.replace(/<a  style='color:red'/gi,"<input type='button' value='삭제' class='cht_button' onclick='chtdelf(this)' style='margin-right:10px;height:18px' /><a style='color:red'");
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
var fbcolor = Array("#000000","#000000","#7d7d7d","#ff0000","#8c4835","#ff6c00","#ff9900","#ffef00","#a6cf00","#009e25","#1c4827","#00b0a2","#00ccff","#0095ff","#0075c8","#3a32c3","#7820b9","#ef007c");

function cht_fdnm(fdnm) {
var retunr;
var chtdda = $('cht_DD').getElementsByTagName('dt');
if(chtdda && chtdda.length > 0) {
for(var i = chtdda.length -1;i >= 0; i--) {
if(fdnm == chtdda[i].innerHTML) {
retunr = chtdda[i];
break;
}}}
return retunr;
}
function ckt_whspr(ths) {
cht_ntm(ths.parentNode);
if(cht_nxthtml == ths.parentNode.nextSibling) {
if(cht_imopn == '1') cht_imgview(0);
} else {
if(cht_imopn == '1') cht_imgview(0);
var thst;
thst = ths.innerHTML;
if($('cht_vstd').value.indexOf("," + thst + ",") != -1) {
thst = cht_fdnm(thst);
sth = String(thst.onclick).indexOf('"');
if(sth != -1) {sth = String(thst.onclick).substr(sth +1,12);
ths.parentNode.nextSibling.innerHTML = cht_whspr(sth,thst,1);
ths.parentNode.nextSibling.style.display = 'block';
cht_nxthtml = ths.parentNode.nextSibling;
}} else cht_in("<b>" + thst + "</b> 님이 자리에 없습니다.");
}}
function cht_ntm(ths,ntm) {
if(ntm) {
var iscnnctd = ths.firstChild.innerHTML;
iscnnctd += ($('cht_vstd').value.indexOf("," + iscnnctd + ",") != -1)? '<\/b> :: 접속중':'<\/b> :: 부재중';
ths.style.background = '#E9FFE3';
$('cht_SS').innerHTML = '&nbsp;<b>' + iscnnctd + ' (' + ntm + ')';
$('cht_SS').style.background = '#EBF2FF';
} else {
$('cht_SS').innerHTML = '&nbsp;';
$('cht_SS').style.background = '';
ths.style.background = '';
}}
function cht_tosty(cont,cn,rnam) {
if(cont[3] && fbcolor[cont[3]]) cont[3] = " style='color:" + fbcolor[cont[3]] + ";'";
else cont[3] = "";
cont[1] = cht_tico(cont[1]);
if(!chtisbk) {
if(cont[0] == rnam) cont[0] = "<b class='myself' onclick='cht_away()'>" + cont[0];
else if(cn  == '1') cont[0] = "<b>" + cont[0];else cont[0] = "<b onclick='ckt_whspr(this)'>" + cont[0];
if(chtisbr == 'Y') cont[1] = "<br \/>" + cont[1];
return "<div class='cx' " + cont[3] + " onmouseover=\"cht_ntm(this,'" + cont[2] + "')\" onmouseout=\"cht_ntm(this)\">" + cont[0] + "<\/b><b> &gt; <\/b>" + cont[1] + "<\/div><div class='bx'><\/div>";
} else return "<div class='cx' " + cont[3] + "><span class='cht8'>&nbsp;" + cont[2] + " <\/span>&nbsp; <b>" + cont[0] + " &gt; <\/b>" + cont[1] + "<\/div>";
}
function cht_save_pos() {
if(cht_obj.createTextRange) cht_obj.currentPos = document.selection.createRange().duplicate();
}
function cht_fbc(str) {
if(str.substr(0,1) === '0') str = str.substr(1);
return fbcolor[parseInt(str)];
}
function cht_fbcolr(nine) {
var thst = $('cht_color');
var xx = cht_fbc(thst.value);
if(xx) {
cht_obj.style.color = xx;
$('neme').style.color = xx;
thst.style.backgroundColor = xx;
if(nine !== 9) cht_obj.focus();
}}
function cht_aadd(vdd,vaa) {
if($('cht_DD').style.height == vaa) {
$('cht_DD').style.height = vdd;
$('cht_AA').style.height = vaa;
} else {
$('cht_DD').style.height = vaa;
$('cht_AA').style.height = vdd;
}
$('cht_AA').scrollTop = '99000000';
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
var cht_ntctr = $('cht_AA').getElementsByTagName('div');
for(var i=cht_ntctr.length-1;i >= 0;i--) {if(cht_ntctr[i].className == 'cht_ntc') cht_ntctr[i].style.display = tht;}
}
function cht_toggle(f) {
f = $(f);
if(f) {f.style.display = (f.style.display == 'none')? '':'none';
}}
function cht_go(view) {
	var param = '';
	cht_ntime = new Date();
	var gtime = cht_ntime.getTime();
	var cht_etiq = Array("",";color:#BABABA' title='자리비움");
	var cht_ntv = $('cht_ntim').value.substr(10);
	var cht_ok = 9;
	var nam = $('neme').value.replace(/[&'"]/gi,"");
	if(view == 'rpage') {
		var nam = nam.replace(/[&'"]/gi,"");
		if($('cht_pnam').value != nam) {
		if(nam.substr(0,1).replace(/[　\s]/g,"") != "") {
		if($('cht_vstd').value.indexOf("," + nam + ",") != -1) {
		cht_ok = 2;
		cht_in("중복된 '닉네임' 입니다");
		}
		for(var i = 0; dpi[i]; i++) {
		if(dpi[i] == nam) {
		cht_ok = "not";
		alert("금지된 '닉네임' 입니다");
		break;
		}}} else {cht_ok = 2;cht_in("닉네임 첫글자가 공백입니다");}
		if(cht_ok == 9) $('cht_pnam').value = nam;
		else $('neme').value = $('cht_pnam').value;
		}
		if(cht_ok == 9) {
		var contt = cht_obj.value.replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/`/g,"").replace(/%/g,"%25").replace(/&/g,"%26").replace(/\+/g,"%2B").replace(/\\/g,"＼");if(contt =='') return false;
		cht_obj.value = "";
		if(dph.length) {
		for(var i = 0; dph[i]; i++){
		if(dph[i] && contt.indexOf(dph[i]) != -1) {
		cht_ok = 2;
		cht_in("금지된 표현 '"+ dph[i] +"' (이)가 포함되어 있습니다.");
		break;
		}}}
		if(cht_ok == 9) {
		if($('cht_prev').value != contt) {
		var fstyle = $('cht_color').value;
		if($('psty').value != fstyle) $('psty').value = fstyle;
		if(contt.substr(0,9) == 'whisper//') {
		contt = $('cht_wip').value + '//' + contt;
		if($('cht_JJ').checked == false) $('cht_wip').value = '';
		else cht_obj.value = 'whisper//';
		} else if($('cht_MM').checked) contt = "(b)" + contt;
		param = chtsrchat + '&neme='+ nam +'&content='+ contt + '&tt=' + cht_ntv + '&ff=' + fstyle;
		$('cht_prev').value = contt;
		$('cht_ptim').value = gtime;
		} else cht_in('중복된 내용입니다');
		}
		}
	} else if(view == 'out') {
		param = chtsrchat + '&content=95798584&tt=' + cht_ntv;
	} else if(view == 'ssetiq') {
		param = chtsrchat + '&content=69847381&tt=' + cht_ntv;
	} else if(view == 'delbak') {
		param = chtsrchat + '&xbk=1';
	} else if($('cht_gout').value != '9') {
		chtnxtr = 0;
		var xtval = (parseInt($('cht_xtim').value) + 1)%10;
		$('cht_xtim').value = xtval;
		if(xtval == 0) param = chtsrchat + '&tt=x';
		else if(cht_ntv == 'a') param = chtsrchat + '&tt=' + cht_ntv + '&neme=' + $('neme').value;
		else param = chtsrchat + '&tt=' + cht_ntv;
	}
if(param != '') {
var cht_ptime = $('cht_ptim').value;
if(window.ActiveXObject) {
xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}  else if(window.XMLHttpRequest) {
xmlhttp = new XMLHttpRequest();
}
xmlhttp.open("POST", param, true);
xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
//xmlhttp.setRequestHeader("Content-length", param.length);
//xmlhttp.setRequestHeader("Connection", "close");
xmlhttp.onreadystatechange = function(){
if(xmlhttp.readyState=='4' && xmlhttp.status=='200') {
	var str = xmlhttp.responseText;
	if(str == "\x7f") {
	var ts = '';
	var t = cht_ntime.getHours();
	var m = cht_ntime.getMinutes();
	var s = cht_ntime.getSeconds();
	ts += (t < 10)? "0"+t+":":t+":";
	ts += (m < 10)? "0"+m+":":m+":";
	ts += (s < 10)? "0"+s:s;
	$('cht_FF').innerHTML = ts;
	} else if(str.indexOf("<h1>") != -1) {$('cht_AA').innerHTML=str;cht_go = '';return false;}
	else {
		var vew = str.split("\x7f");
		if(vew.length > 0 && vew[0]){
			var vews = vew[0].split("\x18");
			var sdd = vews.length - 1;
			var strr = '';var vew12 = '';var vew13 = '';var cht_vstd = ",";
			for(var i = 0;i < sdd;i++) {
			vew12 = vews[i].substr(0,12);
			vew13 = vews[i].substr(16);
			strr += "<dl><dt style='color:" + cht_fbc(vews[i].substr(14,2)) + cht_etiq[vews[i].substr(13,1)] + "'";
			if(vew12 == chtip) strr += " onclick='cht_away()' id='chtddmyself'>*";
			else strr += " onclick='cht_whspr(\"" + vew12 + "\",this,0)'>";
			strr += vew13 + "<\/dt><dd><\/dd><\/dl>";
			cht_vstd += vew13 + ",";
			}
			$('cht_DD').innerHTML = "<div class='dv'>" + strr + "<\/div>";
			$('cht_EE').innerHTML = "참여자 (" + sdd + ")";
			$('cht_vstd').value = cht_vstd;
		}
		var strr = "";
		if(vew.length > 1 && vew[1]){
			var aline = vew[1].split("\x18");
			var alinength = aline.length -1;
			for(var i = 0;i < alinength;i++){
			if(aline[i]) {
			var wnam = aline[i].split("\x1b");
			if(wnam[0]) strr += cht_tosty(wnam,0);
			else {
			if(wnam[1].indexOf(" 1:1 ") != -1) {param = 'n';strr += "<div class='cht_ntc' onclick='cht_delt(this)'>"+ cht_tico(wnam[1]) +"<\/div>";}
			else strr += "<div class='cht_ntc'>"+ cht_tico(wnam[1]) +"<\/div>";
			}}}
			if(chtbx > 500) {$('cht_AA').innerHTML = strr;chtbx = 0;
			} else {
			chtbx++;
			var cdiv = document.createElement("div");
			cdiv.innerHTML = strr;
			cdiv.style.padding = 0;
			cdiv.style.margin = 0;
			$('cht_AA').appendChild(cdiv);
			}
			$('cht_AA').scrollTop = '99000000';
			setTimeout("$('cht_AA').scrollTop = '99000000';",200);
			if(strr != '' && cht_ntv != 'a' && chtusealert !== 0 && (param == 'n' || parseInt(gtime) - cht_ptime > chtusealert)) $('cht_SS').innerHTML = "<embed src='<?=$chtmid?>' type='application/x-mplayer2' autostart='1' width='1px' height='1px' volume='" + chtv100 + "' />";
			$('cht_ptim').value = gtime;
		}
	}
	$('cht_ntim').value = gtime;
	if(view == 'read') chtnxtr = setTimeout("cht_go('read')", <?=$chtrefresh?>);
	delete xmlhttp;
}
}
xmlhttp.send(param);
if(view == 'out') return view;
}
if(view == 'rpage') cht_obj.focus();
}

function cht_away() {
var ths = ($('chtddmyself').title != '')? '자리비움을 해제했습니다':'자리비움을 설정했습니다';
cht_in(ths);
cht_go('ssetiq');
}
function cht_in(texxt) {
if(texxt) {
setTimeout("cht_eeo = 3",1000);
setTimeout("if(cht_eeo == 3) cht_eeo = 2",2000);
setTimeout("cht_in()",4000);
cht_eeo = 0;
$('cht_SS').innerHTML = "&nbsp;" + texxt;
$('cht_SS').style.background = '#EBF2FF';
} else if(cht_eeo == 2) {$('cht_SS').innerHTML = "&nbsp;";$('cht_SS').style.background = '';cht_eeo = 0;}
}
function cht_inn(texxt,vtm,vclass,vid) {
if(!vid) {vid = 'srchat_' + cht_tid;cht_tid++;}
var vdiv = document.createElement("div");
vdiv.innerHTML = texxt;
vdiv.id = vid;
if(vclass) vdiv.className = vclass;
$('cht_AA').appendChild(vdiv);
if(vtm) setTimeout("cht_delt($('" + vid + "'))",vtm);
$('cht_AA').scrollTop = '99000000';
}
function cht_gg() {
if($('cht_NN').checked == false) {
var ckk = cht_ntime.getTime() - parseInt($('cht_ntim').value);
if(ckk > 5000) {
if(ckk < 15000) {clearTimeout(chtnxtr);cht_go('read');}
else {
if(chtreload == '1') {tout();location.reload();}
else if(chtreload == '2') cht_inn("새로고침이 필요합니다. <input type='button' value='새로고침' class='cht_button' onclick='tout();location.reload();' />","","","");
else if(confirm('새로고침이 필요합니다. 새로고침하시겠습니까')) {tout();location.reload();}
}}}
setTimeout('cht_gg()', 3000);
}
function cht_setup() {
cht_obj = $('chcontent');
cht_obj.value = '';
$('cht_AA').style.overflowX='hidden';
$('cht_ntim').value="0000000000a";
$('cht_gout').value='0';
$('cht_xtim').value='0';
if(cht_ico.length > 0) {
var femt = '';
for(var i=cht_ico.length -1;i > 0;i--) femt += "<img src='<?=$chticodir?>" + cht_ico[i] + "' alt='' onclick=\"cht_tag('" + i + "')\" />";
$('cht_fico').innerHTML = femt;
}
setTimeout('cht_gg()', 3000);
cht_go('read');
setInterval("cht_go('delbak')",300000);
setTimeout("$('cht_AA').scrollTop = '99000000';",1000);
setTimeout("$('cht_AA').scrollTop = '99000000';",2000);
setTimeout("if($('cht_AA').firstChild) cht_ntm($('cht_AA').firstChild)",50);
var chtstyle = document.cookie.indexOf('cht_sty4=');
if(chtstyle != -1) {
chtstyle = document.cookie.substr(chtstyle + 9);
if(chtstyle.indexOf(';') != -1) chtstyle = chtstyle.substr(0,chtstyle.indexOf(';'));
$('cht_color').value = chtstyle;
setTimeout("cht_fbcolr(9)",50);
}}
function cht_delt(ths) {
if(ths) ths.parentNode.removeChild(ths);
}
function chtipths(ipths) {
if(ipths) {
$('cht_wip').value = ipths;
setTimeout("cht_obj.value = 'whisper//'",200);
$('cht_JJ').checked = true;
$('cht_JJ').parentNode.style.display = '';
} else {
cht_obj.value = cht_obj.value.replace(/whisper\/\//,'');
cht_delt($($('cht_wip').value.substr(0,12)));
$('cht_wip').value = '';
$('cht_JJ').parentNode.style.display = 'none';
}
cht_obj.focus();
}
function cht_whspr(ip,ths,n) {
if(cht_nxthtml == ths.nextSibling) {
if(cht_imopn == '1') cht_imgview(0);
} else {
if(cht_imopn == '1') cht_imgview(0);
var thsi = ths.innerHTML;
var nxthtml = "<a href='#none' onclick=\"chtipths('" + ip + thsi + "')\">귓속말</a><br \/><a href='#none' onmousedown=\"cht_obj.value='" + ip + thsi + "//whisper//11chat';cht_go('rpage');cht_in('" + thsi + "님에게 1:1 대화를 신청했습니다')\">1:1 대화신청</a>";
if('<?=$cht_isadmin?>' == '1') nxthtml += "<br \/><a href='#none' onclick=\"cht_kout('" + ip + "','" + thsi + "')\">강퇴</a>";
setTimeout("cht_imopn = 1",100);
if(n === 1) return nxthtml;
else {
ths.nextSibling.innerHTML = nxthtml;
ths.nextSibling.style.display = 'block';
cht_nxthtml = ths.nextSibling;
}}}
function cht_kout(xban, xnick) {
if('<?=$cht_isadmin?>' == '1'){
if(chtisbk) var chtlgnf = document.logox;
else var chtlgnf = $('cht_ban').contentWindow.document.logox;
if(xban) {
if(confirm(xnick + "님을 강퇴합니까?")) {
chtlgnf.ban.value = xban;
chtlgnf.nick.value = xnick;
}} else chtlgnf.delf.value = xnick;
chtlgnf.submit();
}}
function tout() {
$('cht_gout').value = '1';
}
window.onbeforeunload = function(){if(!chtisbk && chtunload == 'Y') {if($('cht_gout').value == '0'){if(cht_go('out')){$('cht_gout').value = '9';if(navigator.appName == 'Opera') alert('접속을 종료합니다');else return "---";}}}}
window.onunload = function(){window.onbeforeunload();}
document.body.onclick = function() {if(cht_imopn) cht_imgview(0);}
<?
exit;
}}
if($ftc = @fopen($chtfid."_chtntc","r")) {
$chtfbold = (int)fgets($ftc);
$chtfmly = trim(fgets($ftc));
$chtftsz = trim(fgets($ftc));
$chtunload = trim(fgets($ftc));
$chtisbr = trim(fgets($ftc));
$chtuseico = (int)fgets($ftc);
$chtusealert = (int)fgets($ftc);
$chtnoticet = (int)fgets($ftc);
$chtnoticex = (int)fgets($ftc);
$chtwidth_ = trim(fgets($ftc));if(!$chtwidth) $chtwidth = $chtwidth_;
$chtheight_ = trim(fgets($ftc));if(!$chtheight) $chtheight = $chtheight_;
$chthorizon_ = trim(fgets($ftc));if(!$chthorizon) $chthorizon = $chthorizon_;
$cht_cntwh_ = trim(fgets($ftc));if(!$cht_cntwh) $cht_cntwh = $cht_cntwh_;
$cht_usrwh_ = trim(fgets($ftc));if(!$cht_usrwh) $cht_usrwh = $cht_usrwh_;
$chtemptybak = (int)fgets($ftc);
$chtpause = (int)fgets($ftc);
$chtreload = (int)fgets($ftc);
$chtview = (int)fgets($ftc);
$chtnoticed = '';
while(!feof($ftc)) $chtnoticed .= fgets($ftc);
fclose($ftc);
}
if($_POST['xbk']) {
if($chtemptybak > 0 && @filesize($chtbk) > $chtemptybak*1024) fclose(fopen($chtbk,"w"));
exit;
}
if($_POST['loginout'] == "login" && $_POST['username'] && $_POST['password']) {
$wid = $_SESSION['w4_'.$chtid];
session_unset();
foreach($_COOKIE as $key => $value) {if($key != 'PHPSESSID') setcookie($key,'');}
$_SESSION['w4_'.$chtid] = $wid;
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
echo "<script type=\"text/javascript\">location.replace('{$chat}?chtid={$chtid}&v=ban&admin=1');</script>";
exit;
// 3.4.관리자 로그인/로그아웃처리 끝
}
if($chtexit != 'exit') {
if(!$chtwidth) $chtwidth = '450px';
if(!$chtheight) $chtheight = '350px';
if(!$chthorizon) $chthorizon = 'v';
if(!$cht_cntwh) $cht_cntwh = '83.9%';
if(!$cht_usrwh) $cht_usrwh = '16%';
if(!$chtisbr) $chtisbr = 'N';
if(strpos($_SERVER['PHP_SELF'],$chat) !== false) {
$ischat = 1;
header ("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ko" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="generator" content="srchat 203.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel='stylesheet' type='text/css' href='<?=$chat?>?css=1' />
<style type='text/css'>
#cht_fbdy #cht_AA div {font-family:<?=$chtfmly?>;font-size:<?=$chtftsz?>pt}
</style>
<?
}
if($_GET['v'] == "ban") {
if($chtemptybak > 0 && @filesize($chtbk) > $chtemptybak*1024) fclose(fopen($chtbk,"w"));
$chtxword = '';
if($ff = @fopen($chtxwd,"r")) {
while($fff = trim(fgets($ff))) {
$chtxword[] = $fff;
}
fclose($ff);
}
if($_GET['admin'] == 1) {
?>
</head><body id="cht_fbdy" style="border:0;overflow:hidden;text-align:center">
<?
} else {
?>
<script type="text/javascript">
var chtntc;
function setup() {
if(!parent.cht_obj) {
parent.chtv100 = '<?=((strpos($_SERVER['HTTP_USER_AGENT'],'AppleWebKit') !== false)? '100%':'0')?>';
parent.chtreload = '<?=$chtreload?>';
parent.chtview = '<?=$chtview?>';
parent.$('cht_MM').parentNode.style.display = '<?=(($chtfbold)? '':'none')?>';
parent.$('cht_NN').parentNode.style.display = '<?=(($chtpause)? '':'none')?>';
parent.chtisbr = '<?=$chtisbr?>';
parent.chtunload = '<?=(($chtunload == 'Y' || strpos($_SERVER['HTTP_REFERER'],$chat) !== false)? 'Y':'N')?>';
parent.chtip = '<?=$chtip?>';
chtntc = document.getElementById('chtnoticed').value;
parent.chtusealert = <?=$chtusealert*1000?>;
setTimeout("parent.cht_setup()",500);
if("<?=$chtnoticet?>" != "0" && "<?=$chtnoticet?>" != "" && chtntc != "") setTimeout("setInterval(\"parent.cht_inn(chtntc,<?=$chtnoticex*1000?>)\",<?=$chtnoticet*1000?>)",1000);
}
<?
if($chtuseico) echo "parent.$('cht_KK').style.display = 'none';\n";
if($chtxword) {
echo "parent.dph = Array(";
foreach($chtxword as $fpp) echo "'{$fpp}',";
echo "'');\n";
}
?>
}
</script>
</head>
<body id="cht_fbdy" style="border:0;overflow:hidden;text-align:center" onload="setup()">
<textarea id="chtnoticed" cols="1" rows="1" style="display:none"><?=$chtnoticed?></textarea>
<?
}
if($cht_isadmin) {
?>
<form name='logox' style="margin:0px" method="post" action="<?=$chat?>">
<input type='hidden' name='chtid' value='<?=$_GET['chtid']?>' />
<input type="hidden" name="ban" value="" />
<input type="hidden" name="nick" value="" />
<input type="hidden" name="delf" value="" />
<input type="hidden" name="delcht" value="" />
<?
if($_GET['admin'] == 1) {
if($chtfid) {
?>
<div class='cht_addv'>금지된 표현</div>
<?
if($fph = @fopen($chtxwd, "r")){
while($fpp = trim(fgets($fph))) {
?>
<input type="text" name="xword[]" class="cht_ipt" value="<?=$fpp?>" />&nbsp;
<?
}
fclose($fph);
}
?>
<br /><input type="text" name="xword[]" class="cht_ipt" />
<div class='cht_addv'>금지 닉네임 지정</div>
<?
if($fph = @fopen($chtxnk, "r")){
while($fpp = trim(fgets($fph))) {
?>
<input type="text" name="xnick[]" class="cht_ipt" value="<?=$fpp?>" />&nbsp;
<?
}
fclose($fph);
}
?>
<br /><input type="text" name="xnick[]" class="cht_ipt" />
<div class='cht_addv'>접속차단된 IP</div>
<textarea name="prhd" cols="1" rows="5" style="width:150px;height:50px;font-size:9pt">
<?
if(file_exists($chtfid."_ban/")) {
$ff = opendir($chtfid."_ban/");
while($fff = readdir($ff)) {
if($fff != '.' && $fff != '..') echo $fff."\n";
}
closedir($ff);
}
?></textarea>
<div class='cht_addv'>높이,넓이,형태</div>
<br />전체 넓이 : <input type="text" name="chtwidth_" class="cht_ipt" style="width:40px" value="<?=$chtwidth?>" />
<br />전체 높이 : <input type="text" name="chtheight_" class="cht_ipt" style="width:40px" value="<?=$chtheight?>" />
<br /><label><input name="chthorizon_" type="radio" value="v" <? if($chthorizon == 'v') echo "checked=\"checked\"";?> /> 세로2단</label>&nbsp; <label><input name="chthorizon_" type="radio" value="h" <? if($chthorizon != 'v') echo "checked=\"checked\"";?> /> 가로2단</label>
<br /><span title="가로2단에서는 넓이, 세로2단에서는 높이">채팅본문 : </span><input type="text" name="cht_cntwh_" class="cht_ipt" style="width:40px" value="<?=$cht_cntwh?>" />
<br /><span title="가로2단에서는 넓이, 세로2단에서는 높이">참여자란 : </span><input type="text" name="cht_usrwh_" class="cht_ipt" style="width:40px" value="<?=$cht_usrwh?>" />
<div class='cht_addv'>공지</div>
<textarea name="chtnoticed_" cols="1" rows="5" style="width:80%;height:50px;font-size:9pt"><?=$chtnoticed?></textarea>
<br /><span title="이 시간마다 공지를 노출합니다">노출주기 : </span><input type="text" name="chtnoticet_" class="cht_ipt" style="width:40px" value="<?=$chtnoticet?>" />초
<br /><span title="노출된 공지를 이 시간 뒤에 지웁니다.">삭제시간 : </span><input type="text" name="chtnoticex_" class="cht_ipt" style="width:40px" value="<?=$chtnoticex?>" />초
<br /><span title="알림음을 내는 새글과 이전글의 시간간격">알림음주기 : </span><input type="text" name="chtusealert_" class="cht_ipt" style="width:40px" value="<?=$chtusealert?>" />초
<div class='cht_addv'>글꼴,크기</div>
<br />글꼴 :: <select name="chtfmly_">
<option value='Gulim' <? if($chtfmly == 'Gulim') echo "selected='selected'";?>>굴림</option>
<option value='Dotum' <? if($chtfmly == 'Dotum') echo "selected='selected'";?>>돋움</option>
<option value='Batang' <? if($chtfmly == 'Batang') echo "selected='selected'";?>>바탕</option>
<option value='Gungsuh' <? if($chtfmly == 'Gungsuh') echo "selected='selected'";?>>궁서</option>
<option value='Malgun Gothic' <? if($chtfmly == 'Malgun Gothic') echo "selected='selected'";?>>맑은고딕</option>
<option value='Arial' <? if($chtfmly == 'Arial') echo "selected='selected'";?>>Arial</option>
<option value='Tahoma' <? if($chtfmly == 'Tahoma') echo "selected='selected'";?>>Tahoma</option>
<option value='Verdana' <? if($chtfmly == 'Verdana') echo "selected='selected'";?>>Verdana</option>
<option value='Trebuchet MS' <? if($chtfmly == 'Trebuchet MS') echo "selected='selected'";?>>Trebuchet MS</option>
<option value='sans-serif' <? if($chtfmly == 'sans-serif') echo "selected='selected'";?>>sans-serif</option>
</select>
<br />크기 :: <select name="chtftsz_">
<option value='9' <? if($chtftsz == '9') echo "selected='selected'";?>>9pt</option>
<option value='8' <? if($chtftsz == '8') echo "selected='selected'";?>>8pt</option>
<option value='7' <? if($chtftsz == '7') echo "selected='selected'";?>>7pt</option>
<option value='10' <? if($chtftsz == '10') echo "selected='selected'";?>>10pt</option>
<option value='11' <? if($chtftsz == '11') echo "selected='selected'";?>>11pt</option>
<option value='12' <? if($chtftsz == '12') echo "selected='selected'";?>>12pt</option>
<option value='13' <? if($chtftsz == '13') echo "selected='selected'";?>>13pt</option>
<option value='15' <? if($chtftsz == '15') echo "selected='selected'";?>>15pt</option>
<option value='18' <? if($chtftsz == '18') echo "selected='selected'";?>>18pt</option>
</select>
<div class='cht_addv'>1:1 대화방</div>
<?
if($ff = @opendir($chtdate.$chtdata)) {
while($fg = readdir($ff)) {
if(substr($fg,0,2) == '__') {
$g = 0;$gh = 0;
if($fff = @opendir($chtdate.$chtdata."/".$fg."/_gst")) {
while($ffg = readdir($fff)) {
if(substr($ffg,0,2) == 'm_' && $ffg != 'm_') {
$g++;
$gf = filemtime($chtdate.$chtdata."/".$fg."/_gst/".$ffg);
if($gf > $gh) $gh = $gf;
}}}
closedir($fff);
if($g == 0 || $time - $gh > 60) chtrmfd($chtdate.$chtdata."/".$fg,1);
else echo "<a href='#none' onclick=\"if(confirm('\'' + this.innerHTML + '\' 1:1 대화방을 삭제합니까')) {document.logox.delcht.value=this.innerHTML;submit();}\">".$fg."</a> (".$g."명 / ".($time - $gh)."초 경과)<br />";
}}
closedir($ff);
}
?>
<br /><label title=" 이모티콘을 사용하려면, 
widgets/srchat/emoticon/ 경로에
 이미지파일이 들어 있어야 합니다."><input name="chtuseico_" type="radio" value="0" <? if(!$chtuseico) echo "checked=\"checked\"";?> /> 이모티콘 사용</label>&nbsp; <label><input name="chtuseico_" type="radio" value="1" <? if($chtuseico) echo "checked=\"checked\"";?> /> 사용안함</label>
<br /><label><input name="chtusebak" type="radio" value="a" <? if($ischtbk) echo "checked=\"checked\"";?> /> 내용백업 사용</label>&nbsp; <label><input name="chtusebak" type="radio" value="b" <? if(!$ischtbk) echo "checked=\"checked\"";?> /> 사용안함</label>
<br /><label><input name="chtuseupload" type="radio" value="a" <? if($isdid) echo "checked=\"checked\"";?> /> 첨부파일 사용</label>&nbsp; <label><input name="chtuseupload" type="radio" value="b" <? if(!$isdid) echo "checked=\"checked\"";?> /> 사용안함</label>
<br /><label><input name="chtfbold_" type="radio" value="1" <? if($chtfbold) echo "checked=\"checked\"";?> /> 굵기선택 사용</label>&nbsp; <label><input name="chtfbold_" type="radio" value="0" <? if(!$chtfbold) echo "checked=\"checked\"";?> /> 사용안함</label>
<br /><label><input name="chtpause_" type="radio" value="1" <? if($chtpause) echo "checked=\"checked\"";?> /> 일시정지 사용</label>&nbsp; <label><input name="chtpause_" type="radio" value="0" <? if(!$chtpause) echo "checked=\"checked\"";?> /> 사용안함</label>
<br /><label><input name="chtview_" type="radio" value="1" <? if($chtview) echo "checked=\"checked\"";?> /> 이미지 새창으로</label>&nbsp; <label><input name="chtview_" type="radio" value="0" <? if(!$chtview) echo "checked=\"checked\"";?> /> 레이어로</label>
<br />닉과 내용사이 :: <select name="chtisbr_"><option value="Y" <? if($chtisbr == 'Y') echo "selected=\"selected\"";?>>줄바꿈</option><option value="N" <? if($chtisbr != 'Y') echo "selected=\"selected\"";?>>한줄로</option></select>
<br /><span title=" 경로가 변경될 때, '다른 페이지를 탐색하시겠습니까'
 라고 뜨는 경고창 사용여부 설정,
 사용하면 이탈자 파악이 빨라집니다.">경로이동 경고창 :: </span><select name="chtunload_"><option value="Y" <? if($chtunload == 'Y') echo "selected=\"selected\"";?>>사용</option><option value="N" <? if($chtunload != 'Y') echo "selected=\"selected\"";?>>새창에서만 사용</option></select>
<br /><span title=" ajax 접속이 먹통이어서, 새로고침이 필요할 때">ajax 먹통일 때 :: </span><select name="chtreload_"><option value="0" <? if(!$chtreload) echo "selected=\"selected\"";?>>새로고침 확인창 띄움</option><option value="1" <? if($chtreload == 1) echo "selected=\"selected\"";?>>즉시 새로고침</option><option value="2" <? if($chtreload == 2) echo "selected=\"selected\"";?>>새로고침 안내문 출력</option></select>
<div title="백업파일용량이 이 값이 되면 백업파일을 비웁니다 / 0으로 설정하면 자동삭제 사용안함">백업파일 자동삭제 : <input type="text" name="chtemptybak_" class="cht_ipt" style="width:40px" value="<?=$chtemptybak?>" />kb</div>
<div title="첨부파일 누적용량이 이 값이 되면 모두 삭제 / 0으로 설정하면 총량제한 사용안함">첨부파일 총량제한 : <input type="text" name="chtmaxupload" class="cht_ipt" style="width:40px" value="<?=(int)$isdsm?>" />mb</div>
<br /><br />
<input type="submit" value="입력" class="cht_button" style="width:75%;height:40px" /><br /><br />
<input type="button" onclick="if(confirm('채팅 백업파일을 비웁니까.')) {this.nextSibling.value='reset';submit();}" value="백업파일 비움" class="cht_button" style="width:120px" /><input type="hidden" name="backup" value="" />
<input type="button" onclick="if(confirm('첨부한 파일을 모두 삭제합니까.')) {this.nextSibling.value='delete';submit();}" value="첨부파일 모두삭제" class="cht_button" style="width:120px" /><input type="hidden" name="upload_delete" value="" />
<input type="button" onclick="if(confirm('채팅내용, 업로드파일, 백업파일을 비웁니까')) {this.nextSibling.value='empty';submit();}" value="채팅 비움" class="cht_button" style="width:120px" /><input type="hidden" name="empty" value="" />
<input type="button" onclick="if(confirm('<?=$_GET['chtid']?> 채팅방을 언인스톨하시겠습니까')) {this.nextSibling.value='uninstall';submit();}" value="uninstall" class="cht_button" style="width:120px" /><input type="hidden" name="install" value="1" />
<?} else if($_GET['chtid']) {?>
<input type="button" onclick="if(confirm('<?=$_GET['chtid']?> 채팅방을 인스톨하시겠습니까')) {this.nextSibling.value='install';submit();}" value="install" class="cht_button" style="width:120px" /><input type="hidden" name="install" value="1" />
<?}}?>
</form>
<?} else if($_GET['admin'] == 1) {?>
<form name="cht_adfm" method="post" action="<?=$chat?>" onsubmit="tout()">
<input type='hidden' name='chtid' value='<?=$_GET['chtid']?>' />
<input type='hidden' name='loginout' value='login' /><font color='#828282'>아이디</font> : <input type='text' name='username' class='logn' /> &nbsp; <font color='#828282'>비밀번호</font> : <input type='password' name='password' class='logn' /> &nbsp; <input type="submit" value='로그인' class="cht_button" style='width:50px' /></form>
<?}?>
</body></html>
<?
exit;
}
if($chtfid) {
if($_GET['v'] == "file") {
if($isdid) {
?>
<style type='text/css'>
input {font-family:Tahoma; font-size:8pt; overflow:hidden}
body {overflow:hidden; background-color:#F9F9F9; margin:0}
.cht_button {background:url('srchat/chat.png') repeat-x 0% 100%; border:0; border:1px solid #828282; margin-right:1px; margin-left:1px; padding-left:3px; height:18px; width:40px}
.file {width:50px; height:40px; margin:0; opacity:0; position:absolute; top:0; left:0; z-index:2; cursor:pointer}
</style>
<!--[if IE]>
<style type='text/css'>
.file {filter:alpha(opacity=0)}
</style>
<![endif]-->
</head>
<body>
<form enctype="multipart/form-data" action="<?=$chat?>" method="post" style="margin:0">
<input type='hidden' name='chtid' value='<?=$_GET['chtid']?>' />
<input type="button" value="upload" class="cht_button" /><input type="file" class="file" name="file" onchange="if(this.value) submit()" />
</form></body></html>
<?
exit;
}} else if($_GET['v'] == 'backup') {
?>
<title>[저장된 기록]</title>
<style type='text/css'>
body,div,fieldset {font-size:9pt}
</style>
</head>
<body id="cht_fbdy" onload="settup()">
<script type="text/javascript">
//<![CDATA[
var chtsrchat = '<?=$chat?>?chtid=<?=$chtid?>';
function settup() {
chtisbk = 1;
var con = Array(""<?
$fp = fopen($chtbk, "r");
$memo = "";
while($memo = trim(fgets($fp))){
$memo = str_replace("</","<\/",str_replace("`","/",str_replace("\"","\\\"",$memo)));
$con = explode("\x1b", trim($memo));
if($con[4] && substr($memo, 0, 2) == "\x1b\x1b") {
if(substr($con[2],0,12) == $chtip || substr($con[2],12,12) == $chtip) {
$con[1] = $con[3];
$con[2] = $con[4];
}
}
if($con[1] != '') echo ",Array(\"{$con[0]}\",\"{$con[1]}\",\"{$con[2]}\",\"{$con[3]}\",\"{$con[4]}\",\"{$con[5]}\",\"{$con[6]}\",\"{$con[7]}\",\"{$con[8]}\")";
}
fclose($fp);
?>);
var cl = con.length -1;
if(cl > 0) {
var tcon = "<div class='cht_addv' style='margin:0'>&nbsp;</div>";
for(var i = 1;i <= cl;i++) {
if(con[i][0] != '') tcon += cht_tosty(con[i],1);
else tcon += "<div class='cht_ntc'>" + cht_tico(con[i][1]) + "</div>";
}
$('cht_AA').innerHTML = tcon;
}}
//]]>
</script>
<script type="text/javascript" src="<?=$chat?>?js=1"></script>
<fieldset id="cht_AA" style="width:50%;background:#FFFFFF;border:1px solid #828282;padding:5px;margin:0 25%;line-height:20px;text-align:left"></fieldset>
<div id="cht_img"></div><input type="hidden" id="cht_gout" value="0" />
<? if($cht_isadmin) {?>
<form name='logox' style="margin:0px" method="post" action="<?=$chat?>" target="exeframe">
<input type='hidden' name='chtid' value='<?=$_GET['chtid']?>' />
<input type="hidden" name="delf" value="" />
<input type="hidden" name="frombk" value="1" />
</form>
<iframe name="exeframe" style="display:none"></iframe>
<?}?>
</body>
</html>
<?
exit;
}}
if($ischat) echo "\n<title>채팅</title>\n</head>\n<body>\n";
?>
<script type="text/javascript">
var chtsrchat = '<?=$chat?>?chtid=<?=$chtid?>';
</script>
<script type="text/javascript" src="<?=$chat?>?js=1"></script>
<fieldset id="cht_fbdy" style="width:<?=$chtwidth?>;padding:0;clear:both;margin:0 auto;background-color:#FFFFFF;text-align:left">
<?
$exxt = 0;
if($time - @filemtime($chtmip.$chtip) < 30 && $fnt = fopen($chtmip.$chtip,"r")) {
if(@fgets($fnt)) {
if($dgx = trim(@fgets($fnt))) {
if(md5($_SERVER['HTTP_USER_AGENT']) != $dgx) $exxt = 9;
}}
fclose($fnt);
}
if($exxt == 9) echo "<div style='text-align:center;font-size:10pt;font-weight:bold;padding:10px 0 10px 0'>double access denied</div>";
else {
if($chthorizon == 'h') {
$styaa = "width:{$cht_cntwh};height:100%;float:left";
$stydd = "width:{$cht_usrwh};height:100%;float:right;background:#FAFAFA;";
$cht_aadd = '';
} else {
$styaa = "height:{$cht_cntwh}";
$stydd = "height:{$cht_usrwh};border-bottom:1px solid #CEDEFF";
$cht_aadd = "onclick='cht_aadd(\"{$cht_cntwh}\",\"{$cht_usrwh}\")'";
}
?>
<div id="cht_CC" <?=$cht_aadd?>><div id="cht_EE"></div><div id="cht_FF"></div></div>
<div style="height:<?=$chtheight?>">
<div id="cht_DD" style="<?=$stydd?>"></div>
<div id="cht_AA" style="<?=$styaa?>;font-family:<?=$chtfmly?>;font-size:<?=$chtftsz?>pt"></div>
</div>
<div id="cht_SS" style="font-size:9pt;font-family:Gulim">&nbsp;</div>
<form onsubmit="cht_go('rpage');return false;" action="">
<div style="float:left">
<input type="text" id="neme" maxlength="10" value="<?=$chtnck?>" />
<select id="cht_color" onchange="cht_fbcolr()">
	<option value="00" style="background-color:#ffffff">색상</option>
	<option value="01" style="background-color:#000000">&nbsp;</option>
	<option value="02" style="background-color:#7d7d7d">&nbsp;</option>
	<option value="03" style="background-color:#ff0000">&nbsp;</option>
	<option value="04" style="background-color:#8c4835">&nbsp;</option>
	<option value="05" style="background-color:#ff6c00">&nbsp;</option>
	<option value="06" style="background-color:#ff9900">&nbsp;</option>
	<option value="07" style="background-color:#ffef00">&nbsp;</option>
	<option value="08" style="background-color:#a6cf00">&nbsp;</option>
	<option value="09" style="background-color:#009e25">&nbsp;</option>
	<option value="10" style="background-color:#1c4827">&nbsp;</option>
	<option value="11" style="background-color:#00b0a2">&nbsp;</option>
	<option value="12" style="background-color:#00ccff">&nbsp;</option>
	<option value="13" style="background-color:#0095ff">&nbsp;</option>
	<option value="14" style="background-color:#0075c8">&nbsp;</option>
	<option value="15" style="background-color:#3a32c3">&nbsp;</option>
	<option value="16" style="background-color:#7820b9">&nbsp;</option>
	<option value="17" style="background-color:#ef007c">&nbsp;</option>
</select></div>
<? if($isdid) {?><iframe id="chtupload" src="<?=$chat?>?chtid=<?=$chtid?>&amp;v=file" frameborder="0"></iframe><?}?>
<table id="chcontable"><tr><td>
<input type="text" id="chcontent" onselect="cht_save_pos()" onclick="cht_save_pos()" maxlength="200" onfocus="this.style.imeMode='active'" onmouseover="this.focus()" />
</td><td style="width:27px"><input type="submit" class="cht_button" style="width:23px;margin:0;padding:2px 0 1px 0" value=" " /></td></tr></table>
<div style="padding:2px 6px 6px 6px;min-height:18px">
<div style='float:left'>
<label id="cht_KK">이모티콘<input type="checkbox" onclick="cht_toggle('cht_fico');cht_obj.focus()" class="cht_ckb" /></label>
 <label style="display:none"> 굵게<input type="checkbox" id="cht_MM" onclick="$('chcontent').style.fontWeight=((this.checked)? 'bold':'normal')" class="cht_ckb" /></label>
 <label style="display:none"> 일시정지<input type="checkbox" id="cht_NN" onclick="if(this.checked) clearTimeout(chtnxtr);else cht_go('read');" class="cht_ckb" /></label>
 <label style="display:none"> 귓속말<input type="checkbox" id="cht_JJ" onclick="chtipths()" class="cht_ckb" /></label>
</div>
<div id='cht_bkadm'>
<? if($ischtbk){?><a target="_blank" href="<?=$chat?>?chtid=<?=$chtid?>&amp;v=backup">전체대화</a><?}?> <a target="_blank" href="<?=$chat?>?chtid=<?=$chtid?>&amp;v=ban&amp;admin=1">관리자</a>
</div>
<div id="cht_fico" style="display:none"></div>
</div><input type="submit" style="width:0;height:0;border:0;padding:0;margin:0" /></form>

<iframe id="cht_ban" src="<?=$chat?>?chtid=<?=$chtid?>&amp;v=ban" style="display:none" frameborder="0"></iframe>
<input type="hidden" id="cht_ntim" value="a" /><input type="hidden" id="cht_vstd" value="" /><input type="hidden" id="cht_wip" value="" /><input type="hidden" id="cht_prev" value="" /><input type="hidden" id="psty" value="" /><input type="hidden" id="cht_pnam" value="<?=$chtnck?>" /><input type="hidden" id="cht_xtim" value="0" /><input type="hidden" id="cht_ptim" value="9999999999999" />
</fieldset>
<div id="cht_img" style="display:none;z-index:9;position:absolute;top:0;left:0;width:100%" align="center"></div><input type="hidden" id="cht_gout" value="0" />
<?} if($ischat) {?>
</body>
</html>
<?}}?>