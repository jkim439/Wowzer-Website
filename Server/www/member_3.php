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
	echo "<script>alert(' 오픈을 준비하고 있습니다. ');history.back();</script>"; exit;

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
							<? include "member_meun.php"; ?>
						</td>
					</tr>
				</table>
			</td>
			<td	id="layout_right">
				<table id="layout_right_"	border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_6_3.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px; background-color:rgb(255,255,255);" valign="top">
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								다른 길드원의 계정 정보와 캐릭터 정보를 볼 수 있습니다.
							<br><br><br><br><br>
							</span></font></p>
							<p align="center">
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:700px; height:300px; cursor:default; background-image:url('http://akeetes430.cdn2.cafe24.com/profile_box.gif');" valign="middle">
											<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br><br>아래 빈칸에 닉네임을 입력하시기 바랍니다.<br><br>게시판에서 다른 길드원의 닉네임을 클릭하셔도 볼 수 있습니다.<br><br><iframe name="profile_search" id="profile_search" style="display:none; width:0px; height:0px;"></iframe><form name="profile" target="profile_search" method="post" action="profile_search.php"><input type="text" name="index" id="index" onkeyup="blank_check('index','index_ok');" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:200px; height:20px; padding:1px; font-family:Gulim; font-weight:bold; font-size:9pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="20">&nbsp;&nbsp;<input type="submit" id="index_ok" value=" 확인 " disabled style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"></form>
											</span></font></p>
										</td>
									</tr>
								</table>
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