<?

// 헤더파일	연결
include	"../header.php";

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);
$board = mysql_real_escape_string("bbs_admin");
$mode = mysql_real_escape_string($_GET[mode]);
$wno = mysql_real_escape_string($_GET[wno]);
$page = mysql_real_escape_string($_GET[page]);
$search_type = mysql_real_escape_string($_GET[search_type]);
$search = mysql_real_escape_string($_GET[search]);

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

	// 아바타 아이템
	$avata_result = mysql_query("SELECT * FROM item WHERE ino=$member[avata]", $dbconn);
	$member_avata = mysql_fetch_array($avata_result);
if($member[level]<5) {
	session_destroy();
	echo "<script>top.location.href='http://www.wowzer.kr/error_403.php';</script>"; exit;
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

<body	onload="frame_check();<?if($mode!="write" && $mode!="edit"){?> java_check();<?}?><?if($mode=="write" || $mode=="edit"){?>document.write.title.focus();<?}?>" onpropertychange="defence_check();" oncontextmenu="return false;">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

<p align="center">
								<?
									if(!$mode) {
										include "bbs_list.php";
									} else if($mode=="view") {
										include "bbs_view.php";
									} else if($mode=="write") {
										include "bbs_write_1.php";
									} else if($mode=="edit") {
										include "bbs_edit_1.php";
									} else if($mode=="search") {
										include "bbs_search.php";
									} else {
										echo "<script>location.href='$site_403';</script>"; exit;
									}
								?>
							</p>

</body>

</html>