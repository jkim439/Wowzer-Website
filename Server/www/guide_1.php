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
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_3_1.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								첫 신규 유저를 위한 게임 접속 방법, 계정 생성 방법 등 초반에 필요한 정보를 알려드립니다.
							</span></font></p>
							<br><br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""><strong> 초보자 가이드 목록 </strong></span></font></p>
							<p style="margin-right:30pt; margin-left:30pt;"><font	face="Gulim"><span style="font-size:9pt;">
								<br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:200px;" valign="middle">
											<input type="hidden" id="guide_prelist" value="guide_content_0">
											<select id="guide_list" size="20" style="width:180px; height:246px; font-family:'Gulim'; font-size:9pt;" onchange="guide_change();">
			        					<option value="guide_content_0" selected>안내</option>
												<option value="guide_content_1">&nbsp;&nbsp;&nbsp;1. 게임 설치와 설정</option>
												<option value="guide_content_1_1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1-1. 게임 설치</option>
												<option value="guide_content_1_2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1-2. 게임 패치</option>
												<option value="guide_content_1_3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1-3. 게임 설정</option>
												<option value="guide_content_2">&nbsp;&nbsp;&nbsp;2. 몰튼 와우 계정</option>
												<option value="guide_content_2_1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2-1. 계정 생성</option>
												<option value="guide_content_2_2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2-2. 보트 적립</option>
												<option value="guide_content_3">&nbsp;&nbsp;&nbsp;3. 게임 초반 가이드</option>
												<option value="guide_content_3_1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3-1. 게임 시작</option>
												<option value="guide_content_3_2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3-2. 길드 가입</option>
												<option value="guide_content_3_3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3-3. 길드 창고</option>
												<option value="guide_content_3_4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3-4. 보트 사용</option>
												<option value="guide_content_4">&nbsp;&nbsp;&nbsp;4. 기타 가이드</option>
											</select>
										</td>
										<td style="width:490px; background-image:url('http://akeetes430.cdn2.cafe24.com/box_guide_list.gif');" valign="middle">
											<div id="guide_content_0" style="width:490px;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>안내</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													초보자 가이드에 오신 것을 환영합니다!<br><br>왼쪽 목록에서 원하시는 항목을 선택하시기 바랍니다.<br><br>처음 시작하시는 분들은 순서대로 보십시오.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " disabled style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"><br><br>
												</p>
											</div>
											<div id="guide_content_1" style="width:490px; display:none;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>1. 게임 설치 및 설정</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													게임 설치와 설정에 관한 가이드입니다.<br><br>이미 설치한 분들도 반드시 읽어보셔야 합니다.<br><br>왼쪽 목록에서 세부 항목을 선택하시기 바랍니다.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " disabled style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"><br><br>
												</p>
											</div>
											<div id="guide_content_1_1" style="width:490px; display:none;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>1-1. 게임 설치</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													게임을 설치하지 않은 분들을 위한 가이드입니다.<br><br>이미 설치한 분들은 다음 가이드를 읽으십시오.<br><br>이 가이드를 보시려면 아래 보기 버튼을 클릭하시기 바랍니다.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='home_1.php?mode=view&wno=16';"><br><br>
												</p>
											</div>
											<div id="guide_content_1_2" style="width:490px; display:none;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>1-2. 게임 패치</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													모든 분들이 반드시 읽어보셔야 합니다.<br><br>참고로 프리 서버는 본 서버와 버전이 다릅니다!<br><br>이 가이드를 보시려면 아래 보기 버튼을 클릭하시기 바랍니다.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='community_3.php?mode=view&wno=119';"><br><br>
												</p>
											</div>
											<div id="guide_content_1_3" style="width:490px; display:none;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>1-3. 게임 설정</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													프리 서버로 접속하기 위한 게임 설정 가이드입니다.<br><br>우리 길드에서 제작한 설치 파일을 통해 손쉽게 설정이 가능합니다.<br><br>이 가이드를 보시려면 아래 보기 버튼을 클릭하시기 바랍니다.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="popup_guide('1_3');"><br><br>
												</p>
											</div>
											<div id="guide_content_2" style="width:490px; display:none;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>2. 몰튼 와우 계정</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													전세계 1위 프리 서버인 몰튼 와우의 계정 관련 가이드입니다.<br><br>생성 방법과 보트에 대해 알아봅니다.<br><br>왼쪽 목록에서 세부 항목을 선택하시기 바랍니다.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " disabled style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"><br><br>
												</p>
											</div>
											<div id="guide_content_2_1" style="width:490px; display:none;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>2-1. 계정 생성</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													몰튼 와우 계정 생성 가이드입니다.<br><br>계정 생성에는 반드시 이메일이 필요합니다.<br><br>이 가이드를 보시려면 아래 보기 버튼을 클릭하시기 바랍니다.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="popup_guide('2_1');"><br><br>
												</p>
											</div>
											<div id="guide_content_2_2" style="width:490px; display:none;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>2-2. 보트 적립</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													보트가 무엇이고 어떻게 적립시키는지 알아봅니다.<br><br>보트 사용 방법은 3-4 가이드를 참고하세요.<br><br>이 가이드를 보시려면 아래 보기 버튼을 클릭하시기 바랍니다.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="popup_guide('2_2');"><br><br>
												</p>
											</div>
											<div id="guide_content_3" style="width:490px; display:none;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>3. 게임 초반 가이드</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													필수 가이드이므로 와우 숙련자도 반드시 봐야합니다.<br><br>보트 사용에 대한 중요 정보가 있습니다.<br><br>왼쪽 목록에서 세부 항목을 선택하시기 바랍니다.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " disabled style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"><br><br>
												</p>
											</div>
											<div id="guide_content_3_1" style="width:490px; display:none;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>3-1. 게임 시작</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													서버 접속 방법과 캐릭터 생성에 대한 가이드입니다.<br><br>모든분들이 보셔야 할 필수 가이드입니다.<br><br>이 가이드를 보시려면 아래 보기 버튼을 클릭하시기 바랍니다.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="popup_guide('3_1');"><br><br>
												</p>
											</div>
											<div id="guide_content_3_2" style="width:490px; display:none;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>3-2. 길드 가입</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													길드에 가입하는 방법입니다.<br><br>이 가이드를 통해 저희 길드의 길드원이 되시는 겁니다.<br><br>이 가이드를 보시려면 아래 보기 버튼을 클릭하시기 바랍니다.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="popup_guide('3_2');"><br><br>
												</p>
											</div>
											<div id="guide_content_3_3" style="width:490px; display:none;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>3-3. 길드 창고</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													길드원만의 혜택인 길드 창고에 대한 가이드입니다.<br><br>길드 창고에 대해 아시는 분은 보실 필요가 없습니다.<br><br>이 가이드를 보시려면 아래 보기 버튼을 클릭하시기 바랍니다.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="popup_guide('3_3');"><br><br>
												</p>
											</div>
											<div id="guide_content_3_4" style="width:490px; display:none;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>3-4. 보트 사용</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													보트를 어떻게 사용하는지에 대한 가이드입니다.<br><br>보트가 얼마나 중요한지 아실 수 있습니다.<br><br>이 가이드를 보시려면 아래 보기 버튼을 클릭하시기 바랍니다.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="popup_guide('3_4');"><br><br>
												</p>
											</div>
											<div id="guide_content_4" style="width:490px; display:none;">
												<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
													<br><br><strong>4. 기타 가이드</strong><br><br><br><br>
												</span></font></p>
												<p style="margin-right:30pt; margin-left:30pt;"><font face="Gulim" color="#5b2b00"><span style="font-size:9pt;">
													다른 정보에 대한 가이드입니다.<br><br>기타 가이드는 수시로 추가됩니다.<br><br>왼쪽 목록에서 세부 항목을 선택하시기 바랍니다.<br><br><br><br>
												</span></font></p>
												<p align="right" style="margin-right:30pt; margin-left:30pt;">
													<input type="button" value=" 보기 " disabled style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"><br><br>
												</p>
											</div>
										</td>
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