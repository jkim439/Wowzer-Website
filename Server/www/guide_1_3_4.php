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
					보트를 어떻게 사용하는지에 대한 가이드입니다.
				</span></font></p><br><br>
				
				<table id="layout_guide_body_info" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td id="layout_guide_body_info_title" colspan='2'>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong>3-4. 보트 사용</strong>
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
								몰튼 홈페이지에 로그인한 후, 좌측 메뉴 중에서 [VOTE REWARDS]를 클릭합니다.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:539px; height:195px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_4_1.jpg');" valign="middle"></td>
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
								아이템 이름을 영문으로 입력합니다.<br><br>아이템 이름을 모르시면 초보자 팁 게시판에서 보트 검색하는 법을 찾아보세요.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:324px; height:219px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_4_2.jpg');" valign="middle"></td>
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
								검색 목록에서 원하는 아이템의 이름과 보트 포인트 가격이 나옵니다. 해당 아이템을 클릭합니다.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:387px; height:164px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_4_3.jpg');" valign="middle"></td>
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
								받을 캐릭터를 선택하고 보내시면 됩니다. (Item ID는 자동으로 입력됩니다)<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:255px; height:148px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_4_4.jpg');" valign="middle"></td>
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
								보트 아이템 구매를 완료하였습니다. 2~4분 후 편지를 열어보내세요.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:340px; height:68px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_4_5.jpg');" valign="middle"></td>
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
								2~4분 후 해당 캐릭터로 접속하면 편지가 도착했다는 아이콘이 뜹니다.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:230px; height:165px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_4_6.jpg');" valign="middle"></td>
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
								편지를 열고 첨부된 아이템을 받으시면 됩니다.<br><br>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:312px; height:380px; background-image:url('http://akeetes430.cdn2.cafe24.com/guide/guide_3_4_7.jpg');" valign="middle"></td>
									</tr>
								</table>
							</span></font></p><br>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_line" colspan='2'></td>
    			</tr>
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