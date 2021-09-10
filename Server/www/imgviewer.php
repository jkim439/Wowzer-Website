<?

//header("Content-type:image/jpeg");

// 헤더파일 연결
include "../header.php";

// 변수 변환
$code = mysql_real_escape_string($_GET[code]);
$board = mysql_real_escape_string($_GET[board]);
$name = mysql_real_escape_string($_GET[name]);

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

if(!eregi(".php",$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

if(!eregi("wowzer.kr",$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

if(getenv("REQUEST_METHOD")!="GET") {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

// 경로 조작 검사
if(basename($code!=$code)) {
  echo "<script>location.href='$site_403';</script>"; exit;
}
if(basename($board!=$board)) {
  echo "<script>location.href='$site_403';</script>"; exit;
}
if(basename($name!=$name)) {
  echo "<script>location.href='$site_403';</script>"; exit;
}
$url = "upload/$board/$code/$name";
$file_exist=file_exists($url);
	if($file_exist==1)
	{
$image_size = getimagesize($url);
/*

$fp = fopen($url,"r");
$img_data = fread($fp,filesize($url));
fclose($fp);

echo $img_data;

*/?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html	lang="ko">

<head>

	<title><?	echo site_title; ?></title>
	<meta	http-equiv="content-type"	content="text/html;	charset=utf-8">
	<meta	http-equiv="Cache-Control" content="no-cache">
	<meta	http-equiv="Pragma"	content="no-cache">
	<meta	http-equiv="imagetoolbar"	content="no">
	<script	type="text/javascript" src="inc_script.js"></script>
	<link rel="stylesheet" type="text/css" href="inc_style.css">

</head>

<body onload="java_check_imgviewer();" onpropertychange="defence_check();" oncontextmenu="return false;" onclick="history.back();" style="cursor:pointer; background-color:black;" OnMouseOut="div_hide('tooltip_1');"	OnMouseOver="div_show('tooltip_1');" onmousemove="div_move(event, 'tooltip_1');">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

	<center>
	<table id="layout_imgviewer" border="0" cellspacing="0" cellpadding="0" style="display:none; width:<?=$image_size[0]?>; height:<?=$image_size[1]?>;">
		<tr>
			<td style="background-image:url('<?=$url?>'); border-width:2pt; border-color:white; border-style:solid;"	valign="middle">
				<p align="center" style="font-family:Arial;"><span style="font-size:11pt; font-family:Arial;">
					<img src="http://akeetes430.cdn2.cafe24.com/iwm_large.png" style="width:400px; height:100px;">
				</p>
			</td>
		</tr>
	</table>
	</center>
	
	<div id="tooltip_1" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
		<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
			<br><?if($member[login_browser]=="1"){?><br><?}?>이미지 전체보기를 끝내고 뒤로 돌아가려면 클릭하세요.
		</span></font></p>
	</div>

</body>

</html>

<?

 } else {

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html	lang="ko">

<head>

	<title><?	echo site_title; ?></title>
	<meta	http-equiv="content-type"	content="text/html;	charset=utf-8">
	<meta	http-equiv="Cache-Control" content="no-cache">
	<meta	http-equiv="Pragma"	content="no-cache">
	<meta	http-equiv="imagetoolbar"	content="no">
	<script	type="text/javascript" src="inc_script.js"></script>
	<link rel="stylesheet" type="text/css" href="inc_style.css">

</head>

<body onpropertychange="defence_check();" oncontextmenu="return false;" onclick="history.back();" style="cursor:pointer; background-color:black;">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

	<center>
	<br><br><font face="Gulim" color="white"><span style="font-size:9pt;"><strong>해당 이미지가 서버에 존재하지 않습니다.</strong></span></font><br><br>
	</center>

</body>

</html>


<?}?>