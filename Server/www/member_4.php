<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);
$type = mysql_real_escape_string($_GET[type]);

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
						<td id="layout_left_submeun_top" style="background-image:url('http://akeetes430.cdn2.cafe24.com/submeun_6.gif');"></td>
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
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_6_4.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								포인트 쿠폰을 등록하거나 포인트 적립 방법을 알 수 있습니다.
							</span></font></p>
							<br><br><br>
							<p align="center">
								<table id="layout_mini_2" border="0" cellspacing="0" cellpadding="0">
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="2"></td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_title" colspan="2">
				        			<table>
				        				<tr>
				        					<td style="width:300px;">
														<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<strong>일반 적립</strong>
														</span></font></p>
													</td>
				        					<td style="width:350px;"></td>
												</tr>
											</table>
				        		</td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>글쓰기</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												게시판에 글 작성시 500 포인트를 적립받습니다.
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>로그인</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												로그인시 300 포인트를 적립받습니다. (하루에 1번만 적립)
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>댓글</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												댓글을 쓸 경우 100 포인트를 적립받습니다.
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>등업</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br>등업시 등급별로 보상을 받습니다.<br><br>1. Bronze로 등업시: 2000 포인트 적립, <font color="#11d400"><strong>[하급 아바타 무료 쿠폰]</strong></font> 증정<br>2. Silver로 등업시: 3000 포인트 적립, <font color="#0048ff"><strong>[특수 아바타 무료 쿠폰]</strong></font> 증정<br>3. Gold로 등업시: 4000 포인트 적립, <font color="#8222cc"><strong>[상급 아바타 무료 쿠폰]</strong></font> 증정<br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
								</table><br><br><br>
								<table id="layout_mini_2" border="0" cellspacing="0" cellpadding="0">
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="2"></td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_title" colspan="2">
				        			<table>
				        				<tr>
				        					<td style="width:300px;">
														<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<strong>추천인 적립</strong> <img src="http://akeetes430.cdn2.cafe24.com/icon_new.gif" border="0" align="absmiddle" style="width:20px; height:13px;">
														</span></font></p>
													</td>
				        					<td style="width:350px;">
													</td>
												</tr>
											</table>
				        		</td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>대상</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br>신규 가입시 추천인을 입력한 신규 유저와 추천받은 기존 유저<br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>보상</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br>신규 유저가 Silver로 등업시: 신규 유저와 기존 유저 각각 추가로 2000 포인트를 획득<br><br>신규 유저가 Gold로 등업시: 신규 유저와 기존 유저 각각 추가로 3000 포인트를 획득<br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
								</table><br><br><br>
								<table id="layout_mini_2" border="0" cellspacing="0" cellpadding="0">
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="2"></td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_title" colspan="2">
				        			<table>
				        				<tr>
				        					<td style="width:300px;">
														<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<strong>우수 플레이어 적립</strong>
														</span></font></p>
													</td>
				        					<td style="width:350px;">
													</td>
												</tr>
											</table>
				        		</td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>대상</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br>길드 발전에 도움을 주신 분으로 예를 들면 다음과 같습니다.<br><br>1. 평소에 길드 창고에 기부를 많이 하는 분<br>2. 다른 분에게 각종 도움을 주시는 경우<br>3. 홍보 효과로 신규 유저를 많이 유치할 경우<br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>기간</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												매 주마다 우수 플레이어를 선정합니다.
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>보상</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<font color="#0048ff"><strong>[길드의 징표]</strong></font><font color="black"> 아이템을 드립니다. (</font><font color="#11d400">사용효과: 5000 포인트를 획득합니다.</font>)
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
								</table><br><br><br>
								<table id="layout_mini_2" border="0" cellspacing="0" cellpadding="0">
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="2"></td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_title" colspan="2">
				        			<table>
				        				<tr>
				        					<td style="width:300px;">
														<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<strong>포인트 쿠폰 적립</strong>
														</span></font></p>
													</td>
				        					<td style="width:350px;">
													</td>
												</tr>
											</table>
				        		</td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>안내</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												소유 중인 포인트 쿠폰을 등록하시면 즉시 포인트가 적립됩니다.
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>종류</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br>1. 포인트 쿠폰 (5000 포인트)<br>2. 포인트 쿠폰 (10000 포인트)<br>3. 포인트 쿠폰 (20000 포인트)<br>4. 포인트 쿠폰 (30000 포인트)<br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>등록</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<input type="button" value=" 쿠폰 등록 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='member_coupon_1.php';">
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
								</table>
							</p><br><br><br>
						</p>
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