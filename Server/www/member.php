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

<body	background="http://akeetes430.cdn2.cafe24.com/bg.gif" onload="java_check();frame_check();" onpropertychange="defence_check();" oncontextmenu="return false;">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

	<center><br>
	<table id="layout" border="0" cellspacing="0" cellpadding="0" style="display:none;">
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
						<td id="layout_left_submeun_top" style="background-image:url('http://akeetes430.cdn2.cafe24.com/submeun_6.gif');"></td>
					</tr>
					<tr>
						<td	id="layout_left_submeun_bottom"	valign="top">
							<? include "member_meun.php"; ?>
						</td>
					</tr>
				</table>
			</td>
			<td	id="layout_right">
				<table id="layout_right_"	border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_6_0.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
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
								<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script><br><br><br>
							</span></font></p>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 마이 페이지 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								자신의 계정, 캐릭터, 아이템, 칭호 정보를 볼 수 있고 정보 수정이나 탈퇴를 할 수 있습니다.
							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 명예의 전당 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								포인트 랭킹과 우수 플레이어 정보를 볼 수 있습니다.
							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 포인트 상점 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								포인트를 이용해 각종 아이템을 구매할 수 있습니다.
							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 포인트 적립 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								포인트 쿠폰을 등록하거나 포인트 적립 방법을 알 수 있습니다.
							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 등업 신청 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								길드 등급을 승급하기 위한 등업 신청 장소입니다.
							</span></font></p>
							<br><br><br>
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