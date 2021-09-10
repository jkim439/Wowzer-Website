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
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_2_1.gif');"></td>
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
								전세계 1위 프리 서버인 몰튼 서버에 대한 특징을 알려드립니다.
							</span></font></p>
							<br><br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 엄청난 접속자 수 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								몰튼 서버는 전세계 1위 프리 서버로 접속자가 가장 많습니다.<br><br>접속자 수는 평일 오전에는 평균 3000명입니다.<br><br>평일 오후나 주말에는 서버 최대 정원(3500명)을 초과하며 대기자는 1500명까지 갑니다.<br><br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:640px; height:365px; cursor:pointer;" valign="middle" onclick="location.href='imgviewer_another.php?name=intro_1_1&dir=2&type=1&width=1366&height=768';"><div style="position:relative;"><div style="position:absolute; width:640px; height:365px;"><center><img src="http://akeetes430.cdn2.cafe24.com/iwm_small.png" style="width:400px; height:100px;" border="0"></center></div></div><img align="middle" src="http://akeetes430.cdn2.cafe24.com/intro/intro_1_1.jpg" alt="" style="width:640px; height:365px; border-width:2pt; border-color:black; border-style:solid;"></td>
									</tr>
								</table>

							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 최고의 구현율 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								전장, 투기장, 일반 던전, 영웅 던전, 레이드까지 빠임없이 모든 것이 구현되어 있습니다.<br><br>특히 최상위 레이드인 얼음왕관 성채와 십자군의 시험장도 구현되어 있습니다.<br><br>프리 서버인지 본 서버인지 구분하지 힘들 정도로 최고의 구현율을 자랑하고 있습니다.<br><br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:320px; height:183px; cursor:pointer;" valign="middle" onclick="location.href='imgviewer_another.php?name=intro_1_2&dir=2&type=1&width=1366&height=768';"><div style="position:relative;"><div style="position:absolute; width:640px; height:365px;"><center><img src="http://akeetes430.cdn2.cafe24.com/iwm_small.png" style="width:400px; height:100px;" border="0"></center></div></div><img align="middle" src="http://akeetes430.cdn2.cafe24.com/intro/intro_1_2.jpg" alt="" style="width:320px; height:183px; border-width:2pt; border-color:black; border-style:solid;"></td>
										<td style="width:320px; height:183px; cursor:pointer;" valign="middle" onclick="location.href='imgviewer_another.php?name=intro_1_3&dir=2&type=1&width=1366&height=768';"><div style="position:relative;"><div style="position:absolute; width:640px; height:365px;"></div></div><img align="middle" src="http://akeetes430.cdn2.cafe24.com/intro/intro_1_3.jpg" alt="" style="width:320px; height:183px; border-width:2pt; border-color:black; border-style:solid;"></td>
									</tr>
									<tr>
										<td style="width:320px; height:183px; cursor:pointer;" valign="middle" onclick="location.href='imgviewer_another.php?name=intro_1_4&dir=2&type=1&width=1366&height=768';"><div style="position:relative;"><div style="position:absolute; width:640px; height:365px;"><center><img src="http://akeetes430.cdn2.cafe24.com/iwm_small.png" style="width:400px; height:100px;" border="0"></center></div></div><img align="middle" src="http://akeetes430.cdn2.cafe24.com/intro/intro_1_4.jpg" alt="" style="width:320px; height:183px; border-width:2pt; border-color:black; border-style:solid;"></td>
										<td style="width:320px; height:183px; cursor:pointer;" valign="middle" onclick="location.href='imgviewer_another.php?name=intro_1_5&dir=2&type=1&width=1366&height=768';"><div style="position:relative;"><div style="position:absolute; width:640px; height:365px;"></div></div><img align="middle" src="http://akeetes430.cdn2.cafe24.com/intro/intro_1_5.jpg" alt="" style="width:320px; height:183px; border-width:2pt; border-color:black; border-style:solid;"></td>
									</tr>
								</table>

							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 프리 서버 최초로 전투정보실 지원  </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								프리 서버에서 최초로 전투정보실을 지원합니다.<br><br>각종 캐릭터 정보(장비/특성/평판 등)와 길드 정보를 인터넷으로 볼 수 있습니다.<br><br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:640px; height:365px; cursor:pointer;" valign="middle" onclick="location.href='imgviewer_another.php?name=intro_1_6&dir=2&type=1&width=1348&height=768';"><div style="position:relative;"><div style="position:absolute; width:640px; height:365px;"><center><img src="http://akeetes430.cdn2.cafe24.com/iwm_small.png" style="width:400px; height:100px;" border="0"></center></div></div><img align="middle" src="http://akeetes430.cdn2.cafe24.com/intro/intro_1_6.jpg" alt="" style="width:640px; height:365px; border-width:2pt; border-color:black; border-style:solid;"></td>
									</tr>
								</table>

							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 서버 다운이 없는 몰튼 서버 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								서버 다운(섭다)은 흔히 프리 서버의 큰 약점입니다. 언제 닫힐지 모르는 서버에서 플레이하기 고민되시죠?<br><br>몰튼 서버는 5년간 운영된 서버로 그동안 초기화나 서버 오프(Off)가 없었던 장수 서버입니다.<br><br>영웅 던전과 레이드의 귀속을 초기화하기 위해서 하루에 딱 1번만 10분정도 서버 다운만이 있을 뿐입니다.<br><br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:640px; height:365px; cursor:pointer;" valign="middle" onclick="location.href='imgviewer_another.php?name=intro_1_7&dir=2&type=1&width=1340&height=653';"><div style="position:relative;"><div style="position:absolute; width:640px; height:365px;"><center><img src="http://akeetes430.cdn2.cafe24.com/iwm_small.png" style="width:400px; height:100px;" border="0"></center></div></div><img align="middle" src="http://akeetes430.cdn2.cafe24.com/intro/intro_1_7.jpg" alt="" style="width:640px; height:365px; border-width:2pt; border-color:black; border-style:solid;"></td>
									</tr>
								</table>

							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 완벽한 스킬 구현 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								대부분의 프리 서버는 스킬이 완벽히 구현되지 않았습니다.<br><br>하지만 몰튼 서버는 전 직업의 모든 스킬을 구현해 놓았습니다.<br><br>왜 몰튼 서버가 전세계 1위인지 이제 이해가 되실겁니다.<br><br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:640px; height:365px; cursor:pointer;" valign="middle" onclick="location.href='imgviewer_another.php?name=intro_1_8&dir=2&type=1&width=1366&height=768';"><div style="position:relative;"><div style="position:absolute; width:640px; height:365px;"><center><img src="http://akeetes430.cdn2.cafe24.com/iwm_small.png" style="width:400px; height:100px;" border="0"></center></div></div><img align="middle" src="http://akeetes430.cdn2.cafe24.com/intro/intro_1_8.jpg" alt="" style="width:640px; height:365px; border-width:2pt; border-color:black; border-style:solid;"></td>
									</tr>
								</table>

							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 애드온 제한이 없는 자유로운 서버 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								애드온 제한없이 자기가 원하는대로 마음껏 취향에 맞게 설정할 수 있습니다.<br><br>프리 서버라고 해서 애드온 사용시 오류 발생이나 문제도 없습니다.<br><br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:640px; height:365px; cursor:pointer;" valign="middle" onclick="location.href='imgviewer_another.php?name=intro_1_9&dir=2&type=1&width=1366&height=768';"><div style="position:relative;"><div style="position:absolute; width:640px; height:365px;"><center><img src="http://akeetes430.cdn2.cafe24.com/iwm_small.png" style="width:400px; height:100px;" border="0"></center></div></div><img align="middle" src="http://akeetes430.cdn2.cafe24.com/intro/intro_1_9.jpg" alt="" style="width:640px; height:365px; border-width:2pt; border-color:black; border-style:solid;"></td>
									</tr>
								</table>

							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 본 서버와 동일한 게임 환경 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								몰튼 서버는 본 서버와 동일하게 구현되어 본 서버와 정말 똑같습니다.<br><br>버전도 본 서버와 동일한 최신 버전인 3.3.5(12340)입니다.<br><br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:640px; height:365px; cursor:pointer;" valign="middle" onclick="location.href='imgviewer_another.php?name=intro_1_10&dir=2&type=1&width=1366&height=768';"><div style="position:relative;"><div style="position:absolute; width:640px; height:365px;"><center><img src="http://akeetes430.cdn2.cafe24.com/iwm_small.png" style="width:400px; height:100px;" border="0"></center></div></div><img align="middle" src="http://akeetes430.cdn2.cafe24.com/intro/intro_1_10.jpg" alt="" style="width:640px; height:365px; border-width:2pt; border-color:black; border-style:solid;"></td>
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