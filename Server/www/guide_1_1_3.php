<?

// 헤더파일	연결
include	"../header.php";

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

<body onload="java_check_guide();popup_secret('wowzer_guide');" onpropertychange="defence_check();" oncontextmenu="return false;" style="overflow-x:hidden;">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

	<table id="layout_guide" border="0" cellspacing="0" cellpadding="0" style="display:none;">
		<tr>
			<td id="layout_guide_title"></td>
		</tr>
		<tr>
			<td id="layout_guide_body">
				<br><br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					프리 서버로 접속하기 위한 게임 설정 가이드입니다.
				</span></font></p><br><br>
				
				<table id="layout_guide_body_info" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td id="layout_guide_body_info_title" colspan='2'>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong>1-3. 게임 설정</strong>
							</span></font></p>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_titleline" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_left">
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
								<center><strong>1단계</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								우리 길드에서 제작한 설치 파일을 통해 손쉽게 설정이 가능합니다.<br><br>홈페이지의 [가이드] 메뉴에서 [몰튼 서버 접속기]를 클릭하여 다운로드 받으십시오.<br><br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:109px; height:120px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_1_3_1.jpg');" valign="middle"></td>
									</tr>
								</table>

							</span></font></p><br>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_line" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_left">
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
								<center><strong>2단계</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								별도의 작업 없이 설치 프로그램이 알아서 설치해 줍니다.<br><br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:585px; height:361px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_1_3_2.jpg');" valign="middle"></td>
									</tr>
									<tr>
										<td style="width:585px; height:361px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_1_3_3.jpg');" valign="middle"></td>
									</tr>
								</table>

							</span></font></p><br>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_line" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_left">
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
								<center><strong>3단계</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								이제 설치가 끝났습니다. 몰튼 와우의 계정이 없으므로 일단 게임 실행은 나중에 하십시오.</font><br><br>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:585px; height:361px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_1_3_4.jpg');" valign="middle"></td>
									</tr>
								</table>

							</span></font></p><br>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_line" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_left">
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
								<center><strong>완료</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								이 가이드를 완료하였습니다. 이제 다음 가이드로 넘어가십시오.
							</span></font></p><br>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_line" colspan='2'></td>
    			</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<br><center><input type="button" value=" 닫기 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="window.close();"></center><br>
			</td>
		</tr>
	</table>

</body>

</html>