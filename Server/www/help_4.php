<?

// 헤더파일	연결
include	"../header.php";

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);

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
						<td id="layout_left_submeun_top" style="background-image:url('http://akeetes430.cdn2.cafe24.com/submeun_7.gif');"></td>
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
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_7_4.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								비밀번호나 이메일, 닉네임과 같은 계정 정보를 변경할 수 있습니다.
							</span></font></p>
							<br><br><br>
							<p align="center">
							<a href="help_modify_1_1.php"><img src="http://akeetes430.cdn2.cafe24.com/button_7_4_1_1.gif"	name="button_1" width="200" height="100" border="0"	OnMouseOut="button_1.src='http://akeetes430.cdn2.cafe24.com/button_7_4_1_1.gif';"	OnMouseOver="button_1.src='http://akeetes430.cdn2.cafe24.com/button_7_4_1_2.gif';" align="bottom" alt="""></a>&nbsp;&nbsp;&nbsp;<a href="help_modify_2_1.php"><img src="http://akeetes430.cdn2.cafe24.com/button_7_4_2_1.gif"	name="button_2" width="200" height="100" border="0"	OnMouseOut="button_2.src='http://akeetes430.cdn2.cafe24.com/button_7_4_2_1.gif';"	OnMouseOver="button_2.src='http://akeetes430.cdn2.cafe24.com/button_7_4_2_2.gif';" align="bottom" alt="""></a>&nbsp;&nbsp;&nbsp;<a href="help_modify_3_1.php"><img src="http://akeetes430.cdn2.cafe24.com/button_7_4_3_1.gif"	name="button_3" width="200" height="100" border="0"	OnMouseOut="button_3.src='http://akeetes430.cdn2.cafe24.com/button_7_4_3_1.gif';"	OnMouseOver="button_3.src='http://akeetes430.cdn2.cafe24.com/button_7_4_3_2.gif';" align="bottom" alt="""></a>
							</p>	
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