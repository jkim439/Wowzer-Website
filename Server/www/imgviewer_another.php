<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$type = mysql_real_escape_string($_GET[type]);
$name = mysql_real_escape_string($_GET[name]);
$dir = mysql_real_escape_string($_GET[dir]);
$width = mysql_real_escape_string($_GET[width]);
$height = mysql_real_escape_string($_GET[height]);

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
}

// 경로 조작 검사
if(basename($type!=$type)) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}
if(basename($dir!=$dir)) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}
if(basename($name!=$name)) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 폴더 정보 설정
if($dir=="1") {
	$dir = "";
} else if($dir=="2") {
	$dir = "intro/";
} else {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 헤더 정보 설정
if($type=="1") {
	$type = "jpg";
} else if($type=="2") {
	$type = "gif";
} else {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 이미지 실제경로
$img = $dir.$name.".".$type;

// 브라우저 확인
			if (strpos($_SERVER[HTTP_USER_AGENT], 'MSIE')) {
				$wowzer_browser = 1;
			} else {
				$wowzer_browser = 2;
			}

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

<body	onload="java_check_imgviewer();" onpropertychange="defence_check();" oncontextmenu="return false;" onclick="history.back();" style="cursor:pointer; background-color:black;" OnMouseOut="div_hide('tooltip_1');"	OnMouseOver="div_show('tooltip_1');" onmousemove="div_move(event, 'tooltip_1');">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

	<center>
	<table id="layout_imgviewer" border="0" cellspacing="0" cellpadding="0" style="display:none; width:<?=$width?>; height:<?=$height?>;">
		<tr>
			<td style="background-image:url('http://akeetes430.cdn2.cafe24.com/<?=$img?>'); border-width:2pt; border-color:white; border-style:solid;"	valign="middle"><center><img src="http://akeetes430.cdn2.cafe24.com/iwm_large.png" style="width:400px; height:100px;"></center></td>
		</tr>
	</table>
	</center>
	
	<div id="tooltip_1" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
		<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($wowzer_browser=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
			<br><?if($wowzer_browser=="1"){?><br><?}?>이미지 전체보기를 끝내고 뒤로 돌아가려면 클릭하세요.
		</span></font></p>
	</div>

</body>

</html>