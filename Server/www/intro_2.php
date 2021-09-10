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
						<td id="layout_left_submeun_top" style="background-image:url('http://akeetes430.cdn2.cafe24.com/submeun_2.gif');"></td>
					</tr>
					<tr>
						<td	id="layout_left_submeun_bottom"	valign="top">
							<? include "intro_meun.php"; ?>
							<br><br>
						</td>
					</tr>
				</table>
			</td>
			<td	id="layout_right">
				<table id="layout_right_"	border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_2_2.gif');"></td>
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
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								전세계 1위 프리서버의 한국인 최고의 길드인 Eternal Soulmate에 대해 알려드립니다.
							</span></font></p>
							<br><br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 다른 길드와는 차원이 다른 접속률 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								한국인 길드 중 최고의 길드답게 최고의 동시 접속수를 자랑하고 있습니다.<br><br>평일에는 평균 100명이고, 주말에는 130명을 넘기 때문에 매일, 매주 다음과 같은 일정이 진행됩니다.<br><br>영웅 던전 파티 5인, 레이드 공격대 10인, 레이드 공격대 25인, 전장 파티 5인, 얼라이언스 수장 처치 공격대 40인<br><br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:640px; height:365px; cursor:pointer;" valign="middle" onclick="location.href='imgviewer_another.php?name=intro_2_1&dir=2&type=1&width=1366&height=768';"><div style="position:relative;"><div style="position:absolute; width:640px; height:365px;"><center><img src="http://akeetes430.cdn2.cafe24.com/iwm_small.png" style="width:400px; height:100px;" border="0"></center></div></div><img align="middle" src="http://akeetes430.cdn2.cafe24.com/intro/intro_2_1.jpg" alt="" style="width:640px; height:365px; border-width:2pt; border-color:black; border-style:solid;"></td>
									</tr>
								</table>

							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 길드원을 위한 풍부한 지원 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								초보자들에게 초반 진행시 유리한 각종 아이템과 골드를 무상으로 지원합니다.<br><br>참고로 등급에 따라 지원받을 수 있는 양과 질에 차이가 있습니다.<br><br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:640px; height:365px; cursor:pointer;" valign="middle" onclick="location.href='imgviewer_another.php?name=intro_2_2&dir=2&type=1&width=1366&height=768';"><div style="position:relative;"><div style="position:absolute; width:640px; height:365px;"><center><img src="http://akeetes430.cdn2.cafe24.com/iwm_small.png" style="width:400px; height:100px;" border="0"></center></div></div><img align="middle" src="http://akeetes430.cdn2.cafe24.com/intro/intro_2_2.jpg" alt="" style="width:640px; height:365px; border-width:2pt; border-color:black; border-style:solid;"></td>
									</tr>
								</table>

							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 자체 길드 홈페이지 제공 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								대부분의 길드는 카페를 이용하지만 저희 길드는 자체 홈페이지가 있습니다.<br><br>카페에서는 지원 불가능한 각종 편의기능을 제공해주는 것은 물론 커뮤니티, 정보, 자료 등을 제공받을 수 있습니다.<br><br>아래 그림은 이전에 사용하던 길드 카페 화면입니다.<br><br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:640px; height:365px; cursor:pointer;" valign="middle" onclick="location.href='imgviewer_another.php?name=intro_2_3&dir=2&type=1&width=967&height=633';"><div style="position:relative;"><div style="position:absolute; width:640px; height:365px;"><center><img src="http://akeetes430.cdn2.cafe24.com/iwm_small.png" style="width:400px; height:100px;" border="0"></center></div></div><img align="middle" src="http://akeetes430.cdn2.cafe24.com/intro/intro_2_3.jpg" alt="" style="width:640px; height:365px; border-width:2pt; border-color:black; border-style:solid;"></td>
									</tr>
								</table>

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