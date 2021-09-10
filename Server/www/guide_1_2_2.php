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
					보트가 무엇이고 어떻게 적립시키는지 알아봅니다.
				</span></font></p><br><br>
				
				<table id="layout_guide_body_info" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td id="layout_guide_body_info_title" colspan='2'>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong>2-2. 보트 적립</strong>
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
								몰튼에서는 보트(Vote)라는 특별한 제도가 있습니다.<br><br>와우 프리 서버의 랭킹을 조사하는 사이트가 5개 있는데,<br><br>이 사이트에 몰튼 와우를 투표(vote)해 주시면 보트 포인트가 올라갑니다.<br><br><br><font color="red">보트 포인트로 게임에서 얻기 힘든 아이템을 구매할 수 있습니다. 최대한 많이 모으세요.<br><br>참고로 만랩된 후 주요 장비를 보트로 맞추려면 보트 200포인트가 필요합니다.</font>
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
								몰튼 와우에 로그인하면 다음과 같은 메시지 창이 뜹니다. VOTE NOW를 클릭하세요.<br><br>창이 안 뜨는 경우 로그인 후 메뉴 중에서 VOTE를 클릭해도 도비니다.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:460px; height:121px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_2_2_1.jpg');" valign="middle"></td>
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
								투표(vote)는 총 5개 사이트에서 할 수 있으며 1개 사이트를 투표하면 1포인트를 얻습니다.<br><br>각각의 사이트마다 투표 후 12시간 후에 다시 투표가 가능합니다. (즉, 하루에 최대 10포인트 획득 가능)<br><br><br><br>일단 첫번째 사이트를 클릭합니다.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:478px; height:159px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_2_2_2.jpg');" valign="middle"></td>
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
								투표 사이트에서 무작위로 바뀌는 문자열을 그대로 입력하시면 1포인트를 얻습니다.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:370px; height:228px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_2_2_3.jpg');" valign="middle"></td>
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
								나머지 4개 사이트에서도 투표하고 몰튼에 재접속하면 다음과 같이 나옵니다.<br><br>보트 5포인트를 획득하였고, 앞으로 보트할 수 있는 시간이 11시간 59분이 남았습니다.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:479px; height:469px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_2_2_4.jpg');" valign="middle"></td>
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