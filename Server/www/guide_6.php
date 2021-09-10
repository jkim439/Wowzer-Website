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
						<td id="layout_left_submeun_top" style="background-image:url('http://akeetes430.cdn2.cafe24.com/submeun_3.gif');"></td>
					</tr>
					<tr>
						<td	id="layout_left_submeun_bottom"	valign="top">
							<? include "guide_meun.php"; ?>
						</td>
					</tr>
				</table>
			</td>
			<td	id="layout_right">
				<table id="layout_right_"	border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_3_6.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								별도의 작업 없이 설치 한 번으로 몰튼 서버로 즉시 접속할 수 있는 몰튼 서버 접속기입니다.
							</span></font></p>
							<br><br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 특징 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								<strong>1. 빠른 설치</strong>&nbsp;&nbsp;&nbsp;언제 어디서나 설치 30초면 몰튼 서버로 접속할 수 있습니다.
								<br><br>
								<strong>2. 호환 가능</strong>&nbsp;&nbsp;&nbsp;대부분의 운영체제에서 호환이 가능하며 영문판에서도 설치가 가능합니다.
								<br><br>
								<strong>3. 자동 인식</strong>&nbsp;&nbsp;&nbsp;와우가 설치된 경로를 자동으로 인식하여 설치해 줍니다.
								<br><br>
								<strong>4. 제품 개선</strong>&nbsp;&nbsp;&nbsp;추후 단순히 서버 접속 수정 기능만이 아니라 다양한 기능을 추가할 예정입니다.
							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 저작권 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								해당 제품의 저작권은 Eternal Soulmate 길드장인 Tive가 가지고 있습니다.<br><br>
								다른 곳에서 배포할 때에는 반드시 출처를 남기시기 바랍니다.
							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 복구 방법 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								해당 제품은 게임 파일의 안전을 위해 별도의 삭제 기능을 제공하지 않습니다.<br><br>기존 공식 서버로 복구하시려면 와우 폴더에 있는 "Launcher.exe" 파일을 실행하시면 됩니다.
							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 게임 패치 방법 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								먼저 와우 폴더에 있는 "Launcher.exe" 파일을 실행하셔서 패치를 진행하신 후 이 제품을 다시 설치하시면 됩니다.
							</span></font></p>
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 버전 업데이트 내역 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								<strong>1.0.6 (2010.10.01)</strong>&nbsp;&nbsp;&nbsp;베타 버전 때 문제가 있는 버그가 수정되었습니다. 최초로 공개되는 정식 버전입니다.
							</span></font></p>
							<br><br>
							<p align="center"><font face="Gulim" color="red"><span style="font-size:9pt;">
								<img src="http://akeetes430.cdn2.cafe24.com/illust_warning.gif" align="absmiddle" style="width:23px; height:23px;">
								&nbsp;프리 서버로 수정하는 프로그램이므로 백신에서 바이러스나 악성코드로 인식할 수 있습니다.<br><br><br>
								<a href="http://www.mediafire.com/file/818qgc7cqbfkqcc/MoltenSetup.exe" target="_blank"><img src="http://akeetes430.cdn2.cafe24.com/button_3_6_1_1.gif"	name="button_1" width="200" height="100" border="0"	OnMouseOut="button_1.src='http://akeetes430.cdn2.cafe24.com/button_3_6_1_1.gif'"	OnMouseOver="button_1.src='http://akeetes430.cdn2.cafe24.com/button_3_6_1_2.gif'" align="bottom" alt=""></a>
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