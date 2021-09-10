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

$ip = md5($_SERVER[REMOTE_ADDR]);
$time = md5(time());
$keycode4 = md5($time.$ip.$time);

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
	
	<script	type="text/javascript">
		function checkbox() {
		var ok_1 = "yes";
			for(i=0; i<document.find.name_nick.value.length; i++) {
			if ((document.find.name_nick.value.charAt(i)<"가" || document.find.name_nick.value.charAt(i) >"힣") && (document.find.name_nick.value.charAt(i)<"a" || document.find.name_nick.value.charAt(i) >"z") && (document.find.name_nick.value.charAt(i)<"A" || document.find.name_nick.value.charAt(i) >"Z")){
				ok_1 = "no";
			}else{
				ok_1 = "yes";
			}
		}
		if (ok_1 == "no") {
		 alert(" 닉네임을 올바르게 입력해 주세요. "); return false;
		}
			if(!document.find.check.checked) {
				alert(" 포인트 사용에 동의하셔야 합니다. ");
				return false;
			}
		}
	</script>

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
								<form name="find" target="_self" method="post" action="help_modify_3_2.php" onsubmit="return checkbox();">
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
															<strong>닉네임 변경</strong>
														</span></font></p>
													</td>
					        				<td style="width:350px;">
														<p style="margin-right:15pt; margin-left:15pt;" align="right"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<input type="button" value=" 취소 " style="width:60px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='help_4.php';">
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
												<center><strong>보안 코드</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" style="height:80px;">
											<br><p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<img src="key.php?keycode4=<?=$keycode4?>" align="absmiddle">&nbsp;&nbsp;&nbsp;
												<input type="text" name="key" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:60px; height:22px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="5">&nbsp;
												<input type="button" value=" 재시도 " onclick="if(confirm(' 입력한 내용이 모두 지워집니다. 계속하시겠습니까? ')){location.reload();} else return false;" style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;">
											<br><br></span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left" style="height:80px;">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>비밀번호</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" style="height:80px;">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<input type="password" name="pw_check" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:200px; height:22px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="20"><br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left" style="height:80px;">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>변경할 닉네임</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" style="height:80px;">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<font color="red">불완전한 한글, 비속어, 종교, 이념, 특정인 비난과 사칭 등과 같은 닉네임을 사용하는 경우 로그인 제한 조치합니다.</font><br><br><input type="text" name="name_nick" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:200px; height:22px; padding:1px; ime-mode:active; font-family:Gulim; font-weight:bold; font-size:9pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="6">
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left" style="height:80px;">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>포인트</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" style="height:80px;">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												무분별한 닉네임 변경을 막기 위해 2000 포인트가 필요합니다.<br><br><label id="check"><input type="checkbox" name="check" id="check"> 2000 포인트 사용에 동의합니다.</label>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
				    			<tr>
				        		<td style="height:80px;" colspan="2">
				        			<p align="center"><input type="hidden" name="url" value="<?=$url?>"><input type="hidden" name="keycode4" value="<?=$keycode4?>"><input type="submit" value=" 확인 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"></p>
				        		</td>
				    			</tr>
								</table>
								</form>
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