<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);
$ino = mysql_real_escape_string($_GET[ino]);

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
							<br><br>
							<p style="margin-left:1pt;"><a href="member_1.php"	target="_self"><img	src="http://akeetes430.cdn2.cafe24.com/submeun_6_1_1.gif"	name="submeun_1" width="193" height="24" border="0"	OnMouseOut="submeun_1.src='http://akeetes430.cdn2.cafe24.com/submeun_6_1_1.gif';"	OnMouseOver="submeun_1.src='http://akeetes430.cdn2.cafe24.com/submeun_6_1_2.gif';" align="bottom" alt=""></a></p>
							<br>
							<p style="margin-left:1pt;"><a href="member_2.php"	target="_self"><img	src="http://akeetes430.cdn2.cafe24.com/submeun_6_2_1.gif"	name="submeun_2" width="193" height="24" border="0"	OnMouseOut="submeun_2.src='http://akeetes430.cdn2.cafe24.com/submeun_6_2_1.gif';"	OnMouseOver="submeun_2.src='http://akeetes430.cdn2.cafe24.com/submeun_6_2_2.gif';" align="bottom" alt=""></a></p>
							<br>
							<p style="margin-left:1pt;"><a href="#" target="_self"><img	src="http://akeetes430.cdn2.cafe24.com/submeun_6_3_1.gif"	name="submeun_3" width="193" height="24" border="0"	OnMouseOut="submeun_3.src='http://akeetes430.cdn2.cafe24.com/submeun_6_3_1.gif';"	OnMouseOver="submeun_3.src='http://akeetes430.cdn2.cafe24.com/submeun_6_3_2.gif';" align="bottom" alt="" onclick="popup_shop();"></a></p>
							<br>
							<p style="margin-left:1pt;"><a href="member_4.php"	target="_self"><img	src="http://akeetes430.cdn2.cafe24.com/submeun_6_4_1.gif"	name="submeun_4" width="193" height="24" border="0"	OnMouseOut="submeun_4.src='http://akeetes430.cdn2.cafe24.com/submeun_6_4_1.gif';"	OnMouseOver="submeun_4.src='http://akeetes430.cdn2.cafe24.com/submeun_6_4_2.gif';" align="bottom" alt=""></a></p>
							<br>
							<p style="margin-left:1pt;"><a href="member_5.php"	target="_self"><img	src="http://akeetes430.cdn2.cafe24.com/submeun_6_5_1.gif"	name="submeun_5" width="193" height="24" border="0"	OnMouseOut="submeun_5.src='http://akeetes430.cdn2.cafe24.com/submeun_6_5_1.gif';"	OnMouseOver="submeun_5.src='http://akeetes430.cdn2.cafe24.com/submeun_6_5_2.gif';" align="bottom" alt=""></a></p>
							<br><br>
						</td>
					</tr>
				</table>
			</td>
			<td	id="layout_right">
				<table id="layout_right_"	border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_member_coupon.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								소유 중인 포인트 쿠폰을 등록하시면 즉시 포인트가 적립됩니다.
							</span></font></p>
							<br><br><br>
							<p align="center">
							<form name="coupon" target="_self" method="post" action="member_coupon_2.php">
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
														<strong>쿠폰 등록</strong>
													</span></font></p>
												</td>
				        				<td style="width:350px;">
													<p style="margin-right:15pt; margin-left:15pt;" align="right"><font face="Gulim" color="white"><span style="font-size:9pt;">
														<input type="button" value=" 취소 " style="width:60px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='member_4.php';">
													</span></font></p>
												</td>
											</tr>
										</table>
			        		</td>
			    			</tr>
								<tr>
				       		<td id="layout_mini_2_titleline" colspan="2"></td>
				    		</tr>
								<tr>
									<td id="layout_mini_2_left" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
											<center><strong>쿠폰 코드</strong></center>
										</span></font></p>
									</td>
									<td id="layout_mini_2_right" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
											쿠폰 코드를 입력하여 주십시오.<br><br><span style="font-size:12pt;"><input type="text" name="coupon_code_1" onkeyup="coupon_focus_1();" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:55px; height:25px; padding:1px; ime-mode:disabled; text-transform:uppercase; font-family:Arial; font-weight:bold; font-size:12pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="4">
											 - <input type="text" name="coupon_code_2" onkeyup="coupon_focus_2();" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:55px; height:25px; padding:1px; ime-mode:disabled; text-transform:uppercase; font-family:Arial; font-weight:bold; font-size:12pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="4">
											 - <input type="text" name="coupon_code_3" onkeyup="coupon_focus_3();" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:55px; height:25px; padding:1px; ime-mode:disabled; text-transform:uppercase; font-family:Arial; font-weight:bold; font-size:12pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="4">
											 - <input type="text" name="coupon_code_4" onkeyup="coupon_focus_4();" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:55px; height:25px; padding:1px; ime-mode:disabled; text-transform:uppercase; font-family:Arial; font-weight:bold; font-size:12pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="4">
											 - <input type="text" name="coupon_code_5" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:55px; height:25px; padding:1px; ime-mode:disabled; text-transform:uppercase; font-family:Arial; font-weight:bold; font-size:12pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="4">
										</span></span></font></p>
									</td>
								</tr>
								<tr>
				       		<td id="layout_mini_2_line" colspan="2"></td>
				   			</tr>
								<tr>
									<td id="layout_mini_2_left" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
											<center><strong>인증 번호</strong></center>
										</span></font></p>
									</td>
									<td id="layout_mini_2_right" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
											인증 번호를 입력하여 주십시오.<br><br><input type="password" name="coupon_pw" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:208px; height:22px; padding:1px; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="20" size="50">
										</span></font></p>
									</td>
								</tr>
								<tr>
				       		<td id="layout_mini_2_line" colspan="2"></td>
				   			</tr>
								<tr>
			        		<td style="height:80px;" colspan="2">
			        			<center><input type="submit" value=" 등록 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;">
			        		</td>
			    			</tr>
							</table>
							</form>
							<br><br><br>
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