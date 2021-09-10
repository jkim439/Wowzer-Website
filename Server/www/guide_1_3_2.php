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
					길드에 가입하는 방법입니다.
				</span></font></p><br><br>
				
				<table id="layout_guide_body_info" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td id="layout_guide_body_info_title" colspan='2'>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong>3-2. 길드 가입</strong>
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
								게임 메뉴 중 커뮤니티(단축키: O) 메뉴를 클릭하세요.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:454px; height:138px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_2_1.jpg');" valign="middle"></td>
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
								커뮤니티 창에서 대화 탭을 클릭하세요.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:299px; height:422px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_2_2.jpg');" valign="middle"></td>
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
								추가 버튼을 클릭하세요.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:302px; height:245px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_2_3.jpg');" valign="middle"></td>
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
								<center><strong>4단계</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								채널 이름에 kor라고 입력하고 확인을 클릭하세요.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:241px; height:222px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_2_4.jpg');" valign="middle"></td>
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
								<center><strong>5단계</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								왼쪽에 사용자 채널 아래에 kor 채널이 추가되었습니다. 5. kor를 클릭하시기 바랍니다.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:303px; height:377px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_2_5.jpg');" valign="middle"></td>
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
								<center><strong>6단계</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								아무나 오른쪽 클릭해서 귓속말로 길드 가입을 요청합니다.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:301px; height:217px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_2_6.jpg');" valign="middle"></td>
									</tr>
								</table>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:414px; height:108px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_2_7.jpg');" valign="middle"></td>
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
								<center><strong>7단계</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								곧 길드 초대 메시지가 뜹니다. 가입하시면 됩니다.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:315px; height:103px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_2_8.jpg');" valign="middle"></td>
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
								<center><strong>8단계</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								다른 길드원분들이 당신을 환영합니다. 간단하게 길드창에 인사해 주시는 매너 잊지마세요!<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:418px; height:76px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_2_9.jpg');" valign="middle"></td>
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