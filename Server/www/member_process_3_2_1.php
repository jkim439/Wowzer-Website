<?

// 헤더파일	연결
include	"../header.php";

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 변수 변환
$character = mysql_real_escape_string($_GET[character]);
	
// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

// 레벨 미달, 신청 중 상태
if($member[level]=="1" || $member[level_state]=="1") {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

$character_name = "character_".$character."_name";

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
		function submit_check() {
			if(!document.level.check.checked) {
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
						<td id="layout_left_submeun_top" style="background-image:url('http://akeetes430.cdn2.cafe24.com/submeun_6.gif');"></td>
					</tr>
					<tr>
						<td	id="layout_left_submeun_bottom"	valign="top">
							<? include "member_meun.php"; ?>
							<br><br>
						</td>
					</tr>
				</table>
			</td>
			<td	id="layout_right">
				<table id="layout_right_"	border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_6_6.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								길드 등급을 승급하기 위한 등업 신청 장소입니다.
							</span></font></p>
							<br><br><br>
							<form name="level" target="_self" method="post" action="member_process_3_2_2.php" onsubmit="return submit_check();" enctype="multipart/form-data">
							<p align="center">
								<table id="layout_mini_2" border="0" cellspacing="0" cellpadding="0">
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="4"></td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_title" colspan="4">
				        			<table>
				        				<tr>
				        					<td style="width:400px;">
														<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<strong>등업 신청</strong> (변경 요청-메인 캐릭터 변경 요청)
														</span></font></p>
													</td>
				        				<td style="width:250px;">
													<p style="margin-right:15pt; margin-left:15pt;" align="right"><font face="Gulim" color="white"><span style="font-size:9pt;">
														<input type="button" value=" 취소 " style="width:60px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='member_process_3_0.php';">
													</span></font></p>
												</td>
												</tr>
											</table>
				        		</td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="4"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>메인 캐릭터</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" colspan="3">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br>메인 캐릭터가 <strong><?=$member[character_1_name]?></strong>에서 <strong><?=$member[$character_name]?></strong>(으)로 변경됩니다.<br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>길드 등급</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" colspan="3">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br>길드 등급이 <strong><?=$member[$character_name]?></strong> 캐릭터의 길드 등급으로 조정됩니다.<br><br>등급이 내려가는 경우라도 칭호, 은메달, 금메달 아이템은 유지되어 불이익은 없습니다.<br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>포인트</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" colspan="3">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br>무분별한 메인 캐릭터 변경을 막기 위해 4000 포인트가 필요합니다.<br><br><label id="check"><input type="checkbox" name="check" id="check"> 4000 포인트 사용에 동의합니다.</label><br><br>
											</span></font></p>
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
												<input type="password" name="pw_check" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:200px; height:22px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="20">
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
								<tr>
			        		<td style="height:80px;" colspan="4">
			        			<center><input type="hidden" name="character" value="<?=$character?>"><input type="hidden" name="term_3" value="0"><input type="submit" value=" 신청 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;">
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