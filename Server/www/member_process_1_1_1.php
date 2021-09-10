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

// 등업 조건 확인
if($member[level]!="1" || $member[level_state]=="1") {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 가입 인사 게시물 확인
$bbs_greeting = mysql_query("select COUNT(*) FROM bbs_greeting where no='$member[no]'",$dbconn);
$term_4_value = mysql_result($bbs_greeting, 0, "COUNT(*)");

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
			if(document.level.character_1_name.value.length==0) {
				alert(" 캐릭터 이름을 입력해 주세요. ");
				document.level.character_1_name.focus();
				return false;
			}
			if(document.level.character_1_level.value.length==0) {
				alert(" 캐릭터 레벨을 입력해 주세요. ");
				document.level.character_1_level.focus();
				return false;
			}
			if(document.level.character_1_job.value=="0"){
				alert(" 캐릭터 직업을 선택해 주세요. ");
				document.level.character_1_job.focus();
				return false;
			}
			if(document.level.character_1_skill_1.value=="0"){
				alert(" 첫번째로 배운 전문기술을 선택해 주세요. ");
				document.level.character_1_skill_1.focus();
				return false;
			}
			if(document.level.character_1_skill_2.value=="0"){
				alert(" 두번째로 배운 전문기술을 선택해 주세요. ");
				document.level.character_1_skill_2.focus();
				return false;
			}
			if(document.level.character_1_skill_1.value==document.level.character_1_skill_2.value){
				alert(" 전문기술 2개가 서로 동일합니다. ");
				document.getElementById("term_3_1").style.display='none';
				document.getElementById("term_3_2").style.display='';
				document.level.term_3.value="0";
				document.level.character_1_skill_1[0].selected=true;
				document.level.character_1_skill_2[0].selected=true;
				document.level.character_1_skill_1.focus();
				return false;
			}
			if(document.level.character_1_level.value<1 || document.level.character_1_level.value>80) {
				alert(" 캐릭터 레벨을 잘못 입력하였습니다. ");
				document.getElementById("term_2_1").style.display='none';
				document.getElementById("term_2_2").style.display='';
				document.level.term_2.value="0";
				document.level.character_1_level.value="";
				document.level.character_1_level.focus();
				return false;
			}
			if(document.level.term_1.value=="0" || document.level.term_2.value=="0" || document.level.term_3.value=="0" || document.level.term_4.value=="0"){
				alert(" 등업 조건 중 만족하지 못한 조건이 있습니다. ");
				return false;
			}
		}
		function term_1_check() {
			if(document.level.character_1_name.value.length!="0") {
				document.getElementById("term_1_1").style.display='';
				document.getElementById("term_1_2").style.display='none';
				document.level.term_1.value="1";
			} else {
				document.getElementById("term_1_1").style.display='none';
				document.getElementById("term_1_2").style.display='';
				document.level.term_1.value="0";
			}
		}
		function term_2_check() {
			if(document.level.character_1_level.value>19) {
				document.getElementById("term_2_1").style.display='';
				document.getElementById("term_2_2").style.display='none';
				document.level.term_2.value="1";
			} else {
				document.getElementById("term_2_1").style.display='none';
				document.getElementById("term_2_2").style.display='';
				document.level.term_2.value="0";
			}
		}
		function term_3_check() {
			if(document.level.character_1_skill_1.value!="0" && document.level.character_1_skill_2.value!="0") {
				document.getElementById("term_3_1").style.display='';
				document.getElementById("term_3_2").style.display='none';
				document.level.term_3.value="1";
			} else {
				document.getElementById("term_3_1").style.display='none';
				document.getElementById("term_3_2").style.display='';
				document.level.term_3.value="0";
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
							<form name="level" target="_self" method="post" action="member_process_1_1_2.php" onsubmit="return submit_check();" enctype="multipart/form-data">
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
															<strong>등업 신청</strong> (메인 캐릭터와 홈피 계정)
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
												<center><strong>캐릭터 이름</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" colspan="3">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br>본인이 주로 접속하시는 메인 캐릭터의 이름을 입력하세요.<br><br><input type="text" name="character_1_name" onkeyup="term_1_check();" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:156px; height:25px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:12pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="12"><br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>캐릭터 레벨</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" colspan="3">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br>현재 메인 캐릭터의 레벨을 입력해 주세요.<br><br><input type="text" name="character_1_level" onkeyup="term_2_check();" onKeyPress="return only_num(event, false);" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:55px; height:25px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:12pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="2"><br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>캐릭터 직업</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" colspan="3">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br>현재 메인 캐릭터의 직업을 선택해 주세요.<br><br>
												<select name="character_1_job" size="1" style="width:150px; height:25px; padding:1px; font-family:Gulim; font-size:9pt; color:rgb(0,0,0);">
													<option value="0">직업 선택</option>
													<option value="1">죽음의 기사</option>
													<option value="2">전사</option>
													<option value="3">도적</option>
													<option value="4">사냥꾼</option>
													<option value="5">마법사</option>
													<option value="6">흑마법사</option>
													<option value="7">사제</option>
													<option value="8">성기사</option>
													<option value="9">주술사</option>
													<option value="10">드루이드</option>
												</select>
											<br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>캐릭터 전문기술</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" colspan="3">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br>현재 메인 캐릭터가 배운 전문기술 2개를 선택해 주세요.<br><br>
												<select name="character_1_skill_1" size="1" onchange="term_3_check();" style="width:150px; height:25px; padding:1px; font-family:Gulim; font-size:9pt; color:rgb(0,0,0);">
													<option value="0">첫번째 전문기술</option>
													<option value="1">약초채집</option>
													<option value="2">채광</option>
													<option value="3">무두질</option>
													<option value="4">연금술</option>
													<option value="5">대장기술</option>
													<option value="6">기계공학</option>
													<option value="7">가죽세공</option>
													<option value="8">재봉술</option>
													<option value="9">마법부여</option>
													<option value="10">보석세공</option>
													<option value="11">주문각인</option>
												</select>&nbsp;&nbsp;
												<select name="character_1_skill_2" size="1" onchange="term_3_check();" style="width:150px; height:25px; padding:1px; font-family:Gulim; font-size:9pt; color:rgb(0,0,0);">
													<option value="0">두번째 전문기술</option>
													<option value="1">약초채집</option>
													<option value="2">채광</option>
													<option value="3">무두질</option>
													<option value="4">연금술</option>
													<option value="5">대장기술</option>
													<option value="6">기계공학</option>
													<option value="7">가죽세공</option>
													<option value="8">재봉술</option>
													<option value="9">마법부여</option>
													<option value="10">보석세공</option>
													<option value="11">주문각인</option>
												</select>
											<br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>등업 조건</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" colspan="3">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<br><strong>Bronze</strong> 등급의 등업 조건은 다음과 같습니다.<br><br>1. 본인의 캐릭터가 <strong>길드에 가입</strong>되어 있어야 합니다.<font id="term_1_1" color="blue" style="display:none;"><strong> [만족]</strong></font><font id="term_1_2" color="red"><strong> [불만족]</strong></font><br>2. 해당 캐릭터가 <strong>20 레벨 이상</strong>이어야 합니다.<font id="term_2_1" color="blue" style="display:none;"><strong> [만족]</strong></font><font id="term_2_2" color="red"><strong> [불만족]</strong></font><br>3. <strong>전문기술 2개</strong>를 배우셔야 합니다. (숙련도 상관없이 배우기만 하면 됩니다)<font id="term_3_1" color="blue" style="display:none;"><strong> [만족]</strong></font><font id="term_3_2" color="red"><strong> [불만족]</strong></font><br>4. <strong>가입 인사 게시판</strong>에 글을 쓰셔야 합니다.<?if($term_4_value>0){?><font color="blue"><strong> [만족]</strong></font><?}else{?><font color="red"><strong> [불만족]</strong></font><?}?><br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
								<tr>
			        		<td style="height:80px;" colspan="4">
			        			<center><input type="hidden" name="term_1" value="0"><input type="hidden" name="term_2" value="0"><input type="hidden" name="term_3" value="0"><?if($term_4_value>0){?><input type="hidden" name="term_4" value="1"><?}else{?><input type="hidden" name="term_4" value="0"><?}?><input type="submit" value=" 신청 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;">
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