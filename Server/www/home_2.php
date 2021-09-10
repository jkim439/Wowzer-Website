<?

// 헤더파일	연결
include	"../header.php";

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

<body	background="http://akeetes430.cdn2.cafe24.com/bg.gif" onload="java_check();frame_check();" onpropertychange="defence_check();" oncontextmenu="return false;">

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
						<td id="layout_left_submeun_top" style="background-image:url('http://akeetes430.cdn2.cafe24.com/submeun_1.gif');"></td>
					</tr>
					<tr>
						<td	id="layout_left_submeun_bottom"	valign="top">
							<br><br>
							<p style="margin-left:1pt;"><a href="home_1.php"	target="_self"><img	src="http://akeetes430.cdn2.cafe24.com/submeun_1_1_1.gif"	name="submeun_1" width="193" height="24" border="0"	OnMouseOut="submeun_1.src='http://akeetes430.cdn2.cafe24.com/submeun_1_1_1.gif';"	OnMouseOver="submeun_1.src='http://akeetes430.cdn2.cafe24.com/submeun_1_1_2.gif';" align="bottom" alt=""></a></p>
							<br>
							<p style="margin-left:1pt;"><a href="home_2.php"	target="_self"><img	src="http://akeetes430.cdn2.cafe24.com/submeun_1_2_1.gif"	name="submeun_2" width="193" height="24" border="0"	OnMouseOut="submeun_2.src='http://akeetes430.cdn2.cafe24.com/submeun_1_2_1.gif';"	OnMouseOver="submeun_2.src='http://akeetes430.cdn2.cafe24.com/submeun_1_2_2.gif';" align="bottom" alt=""></a></p>
							<?=$site_chat?><br><br>
							<p align="center">
							<script type="text/javascript">
								<!--
								google_ad_client = "ca-pub-8506472453970244";
								/* box_meun_1 */
								google_ad_slot = "9557988680";
								google_ad_width = 180;
								google_ad_height = 150;
								//-->
							</script>
							<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script><br><br><br>
							<script type="text/javascript">
								<!--
								google_ad_client = "ca-pub-8506472453970244";
								/* box_meun_2 */
								google_ad_slot = "5217885177";
								google_ad_width = 180;
								google_ad_height = 150;
								//-->
							</script>
							<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script><br><br><br>
							</p>
						</td>
					</tr>
				</table>
			</td>
			<td	id="layout_right">
				<table id="layout_right_"	border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_1_2.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								홈페이지 버전 및 최근 업데이트 날짜입니다.
							<br><br><br>
							</p>
							<p align="center">
								<img src="http://akeetes430.cdn2.cafe24.com/hp_info.jpg" align="absmiddle" style="width:600px; height:300px; border-width:3pt; border-color:black; border-style:solid;">
								<br><br><br>
							</p>
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