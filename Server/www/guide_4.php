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

if($member[level]=="1"){
	echo "<script>self.location.href='error_401.php?level=2';</script>"; exit;
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
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_3_4.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								영문 퀘스트 이름을 검색하시면 한글로 된 공략을 보여주는 편의 기능입니다.
							</span></font></p>
							<br><br><br>
							<p align="center">
								<table id="layout_mini_guide" border="0" cellspacing="0" cellpadding="0">
									<tr>
				        		<td id="layout_mini_guide_line" colspan='2'></td>
				    			</tr>
									<tr>
										<td id="layout_mini_guide_left">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>1단계</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_guide_right">
											<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												아래 빈칸에 퀘스트 이름(영문)을 입력하시고 엔터를 누르거나 검색 버튼을 누르세요.<br><br><form name="quest" target="_blank" method="post" action="guide_4_1.php"><input type="text" name="quest_name" id="quest_name" onkeyup="blank_check('quest_name','quest_search');" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:400px; height:23px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="40">&nbsp;&nbsp;<input type="submit" id="quest_search" value=" 검색 " disabled style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"></form>
											</span></font></p><br>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_guide_line" colspan='2'></td>
				    			</tr>
									<tr>
										<td id="layout_mini_guide_left">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>2단계</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_guide_right">
											<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												퀘스트 목록 중에서 해당하는 퀘스트를 클릭하세요.
											</span></font></p><br>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_guide_line" colspan='2'></td>
				    			</tr>
									<tr>
										<td id="layout_mini_guide_left">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>3단계</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_guide_right">
											<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<font color="red">주소를 보시면 <strong>맨 끝에 숫자 1~5자리</strong>가 있습니다.</font><br><br>예를 들면 주소가 "http://www.wowhead.com/quest=24590"인 경우 숫자는 "24590"입니다.
											</span></font></p><br>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_guide_line" colspan='2'></td>
				    			</tr>
									<tr>
										<td id="layout_mini_guide_left">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>4단계</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_guide_right">
											<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												아래 빈칸에 숫자를 입력하고 엔터를 누르거나 확인 버튼을 누르세요.<br><br>와우 인벤(http://wow.inven.co.kr) 퀘스트 공략을 보여드립니다.<br><br><form name="quest" target="_blank" method="post" action="guide_4_2.php"><input type="text" name="quest_num" id="quest_num" onkeyup="blank_check('quest_num','quest_view');" onKeyPress="return only_num(event, false);" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:100px; height:23px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="5">&nbsp;&nbsp;<input type="submit" id="quest_view" value=" 확인 " disabled style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"></form>
											</span></font></p><br>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_guide_line" colspan='2'></td>
				    			</tr>
								</table>
							</span></font></p>
							<br><center><input type="button" value=" 초기화 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="document.getElementById('quest_search').disabled=true;document.getElementById('quest_view').disabled=true;document.getElementById('quest_name').value='';document.getElementById('quest_num').value='';document.getElementById('quest_name').focus();"></center><br><br><br>
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