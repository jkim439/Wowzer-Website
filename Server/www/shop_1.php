<?

// 헤더파일	연결
include	"../header.php";

// 공지사항 연결
include	"config_notice.php";

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
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

<body bgcolor="#00384a" onload="java_check_shop_iframe(); frame_check();" onpropertychange="defence_check();" oncontextmenu="return false;" style="cursor:default;">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

	<div id="layout_shop_iframe" style="display:none;">
		<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
			<img src="http://akeetes430.cdn2.cafe24.com/shop_title_1.gif" width="500" height="40" border="0">
		</span></font></p>
		<p style="margin-left:20pt; margin-right:10pt;"><font face="Gulim" color="#00CCFF"><span style="font-size:9pt;">
			<br><br><br><img align="absmiddle" src="http://akeetes430.cdn2.cafe24.com/bullet_blue.gif"	border="0" alt="" style="width:11px; height:11px;"> <strong><?=$notice_shop_title?></strong> <span style="font-size:8pt;">(<?=$notice_shop_date?>)</span>
		</span></font></p>
		<p style="margin-left:20pt; margin-right:10pt;"><font face="Gulim" color="#00CCFF"><span style="font-size:1pt;">
			<br><br><br>____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________
		</span></font></p>
		<p style="margin-left:35pt; margin-right:10pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
			<br><br><?=$notice_shop_text_1?>
			<br><br><?=$notice_shop_text_2?>
			<br><br><?=$notice_shop_text_3?>
			<br><br><?=$notice_shop_text_4?>
			<br><br><?=$notice_shop_text_5?>
			<br><br><?=$notice_shop_text_6?>
			<br><br><?=$notice_shop_text_7?>
			<br><br><?=$notice_shop_text_8?>
			<br><br><?=$notice_shop_text_9?>
		</span></font></p>
	</div>

</body>

</html>