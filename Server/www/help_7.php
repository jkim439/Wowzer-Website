<?

// 헤더파일	연결
include	"../header.php";

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);
$board = mysql_real_escape_string("bbs_report");
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

<body	background="http://akeetes430.cdn2.cafe24.com/bg.gif" onload="frame_check();<?if($mode!="write" && $mode!="edit"){?> java_check();<?}?><?if($mode=="write" || $mode=="edit"){?>document.write.title.focus();<?}?>" onpropertychange="defence_check();" oncontextmenu="return false;">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

	<center><br>
	<table id="layout" border="0" cellspacing="0" cellpadding="0"<?if($mode!="write" && $mode!="edit"){?> style="display:none;"<?}?>>
		<tr>
			<td	id="layout_border_top" colspan="4"></td>
		</tr>
		<tr>
			<td	id="layout_border_left" rowspan="3"></td>
			<td	id="layout_header" colspan="2"></td>
			<td	id="layout_border_right" rowspan="3"></td>
		</tr>
		<tr>
			<td	id="layout_meun" colspan="2">
				<? include "inc_meun.php"; ?>
			</td>
		</tr>
		<tr>
			<td	id="layout_left"	valign="top">
				<table id="layout_left_" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td id="layout_left_login">
							<? include "inc_login.php";	?>
						</td>
					</tr>
					<tr>
						<td id="layout_left_submeun_top" style="background-image:url('http://akeetes430.cdn2.cafe24.com/submeun_5.gif');"></td>
					</tr>
					<tr>
						<td	id="layout_left_submeun_bottom"	valign="top">
							<? include "help_meun.php"; ?>
						</td>
					</tr>
				</table>
			</td>
			<td	id="layout_right">
				<table id="layout_right_"	border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_7_7.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px; background-color:rgb(255,255,255);" valign="top">
							<br>
							<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<script type="text/javascript">
									<!--
									google_ad_client = "ca-pub-8506472453970244";
									/* title */
									google_ad_slot = "0177202610";
									google_ad_width = 728;
									google_ad_height = 90;
									//-->
								</script>
								<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
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
							<br>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td	id="layout_border_bottom" colspan="4"></td>
		</tr>
	</table>
	</center><br>

</body>

</html>