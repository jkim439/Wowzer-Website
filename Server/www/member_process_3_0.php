<?

// 헤더파일	연결
include	"../header.php";

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

// 레벨 미달
if($member[level]=="1") {
	echo "<script>self.location.href='error_401.php?level=2';</script>"; exit;
}

// 신청 중 상태
if($member[level_state]=="1") {
  echo "<script>self.location.href='$site_403';</script>"; exit;
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
	
	<script	type="text/javascript">
	function check_1() {
		document.level.submit.disabled = true;
		document.level.character_1[0].selected = true;
		document.level.character_2[0].selected = true;
		document.level.character_1.disabled = false;
		document.level.character_2.disabled = true;
	}
	function check_2() {
		document.level.submit.disabled = true;
		document.level.character_1[0].selected = true;
		document.level.character_2[0].selected = true;
		document.level.character_1.disabled = true;
		document.level.character_2.disabled = false;
	}
	function check_3() {
		if(document.level.character_1[0].selected) {
			document.level.submit.disabled = true;
		} else {
			document.level.submit.disabled = false;
		}
	}
	function check_4() {
		if(document.level.character_2[0].selected) {
			document.level.submit.disabled = true;
		} else {
			document.level.submit.disabled = false;
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
							<form name="level" target="_self" method="post" action="member_process_3_0_check.php">
							<p align="center">
								<table id="layout_mini_2" border="0" cellspacing="0" cellpadding="0">
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="4"></td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_title" colspan="4">
				        			<table>
				        				<tr>
				        					<td style="width:300px;">
														<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<strong>등업 신청</strong> (변경 요청)
														</span></font></p>
													</td>
				        				<td style="width:350px;">
													<p style="margin-right:15pt; margin-left:15pt;" align="right"><font face="Gulim" color="white"><span style="font-size:9pt;">
														<input type="button" value=" 취소 " style="width:60px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='member_6.php';">
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
												<center><strong>전문 기술<br><br>변경</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" colspan="3">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br><label id="type_1"><input type="radio" name="type" id="type_1" value="1" checked onclick="check_1();"> <strong>전문 기술 변경 요청</strong></label><br><br><br>
												다른 전문 기술로 배워서 홈피에 등록된 전문 기술과 다르면 등업이 실패됩니다.<br><br>이런 분들은 등업 신청 전에 반드시 전문 기술을 바꿔주십시오.<br><br><br>
												<select name="character_1" size="1" onchange="check_3();" style="width:220px; height:25px; padding:1px; font-family:Gulim; font-size:9pt; color:rgb(0,0,0);">
													<option value="0">전문 기술을 변경할 캐릭터 선택</option><?if($member[character_1_name]!="0"){?>
                          <option value="1"><?=$member[character_1_name]?> (메인 캐릭터)</option><?}?><?if($member[character_2_name]!="0"){?>
                          <option value="2"><?=$member[character_2_name]?></option><?}?><?if($member[character_3_name]!="0"){?>
                          <option value="3"><?=$member[character_3_name]?></option><?}?><?if($member[character_4_name]!="0"){?>
                          <option value="4"><?=$member[character_4_name]?></option><?}?><?if($member[character_5_name]!="0"){?>
                          <option value="5"><?=$member[character_5_name]?></option><?}?><?if($member[character_6_name]!="0"){?>
                          <option value="6"><?=$member[character_6_name]?></option><?}?><?if($member[character_7_name]!="0"){?>
                          <option value="7"><?=$member[character_7_name]?></option><?}?><?if($member[character_8_name]!="0"){?>
                          <option value="8"><?=$member[character_8_name]?></option><?}?><?if($member[character_9_name]!="0"){?>
                          <option value="9"><?=$member[character_9_name]?></option><?}?>
                        </select><br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>메인 캐릭터<br><br>변경</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" colspan="3">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br><label id="type_2"><input type="radio" name="type" id="type_2" value="2" onclick="check_2();"> <strong>메인 캐릭터 변경 요청</strong></label><br><br><br>
												기존의 서브 캐릭터를 메인 캐릭터로 바꿉니다. 기존 메인 캐릭터는 서브 캐릭터로 전환됩니다.<br><br>길드 등급이 변경 요청한 메인 캐릭터의 등급으로 조정됩니다.<br><br><br>
												<select name="character_2" disabled size="1" onchange="check_4();" style="width:220px; height:25px; padding:1px; font-family:Gulim; font-size:9pt; color:rgb(0,0,0);">
													<option value="0">메인 캐릭터로 변경할 캐릭터 선택</option><?if($member[character_2_name]!="0"){?>
                          <option value="2"><?=$member[character_1_name]?> → <?=$member[character_2_name]?></option><?}?><?if($member[character_3_name]!="0"){?>
                          <option value="3"><?=$member[character_1_name]?> → <?=$member[character_3_name]?></option><?}?><?if($member[character_4_name]!="0"){?>
                          <option value="4"><?=$member[character_1_name]?> → <?=$member[character_4_name]?></option><?}?><?if($member[character_5_name]!="0"){?>
                          <option value="5"><?=$member[character_1_name]?> → <?=$member[character_5_name]?></option><?}?><?if($member[character_6_name]!="0"){?>
                          <option value="6"><?=$member[character_1_name]?> → <?=$member[character_6_name]?></option><?}?><?if($member[character_7_name]!="0"){?>
                          <option value="7"><?=$member[character_1_name]?> → <?=$member[character_7_name]?></option><?}?><?if($member[character_8_name]!="0"){?>
                          <option value="8"><?=$member[character_1_name]?> → <?=$member[character_8_name]?></option><?}?><?if($member[character_9_name]!="0"){?>
                          <option value="9"><?=$member[character_1_name]?> → <?=$member[character_9_name]?></option><?}?>
                        </select>
												<br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
								<tr>
			        		<td style="height:80px;" colspan="4">
			        			<center><input type="submit" name="submit" disabled value=" 확인 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;">
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