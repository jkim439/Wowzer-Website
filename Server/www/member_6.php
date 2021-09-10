<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

echo "<script>alert(' 더 이상 등업/변경 신청을 받지 않습니다. ');history.back();</script>"; exit;
	
// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

$time = time();
$level_time_after = $time - $member[level_time];
$level_time = date ("Y년 m월 d일 H시 i분", $member[level_time]);
if($member[character_mode]=="1") {
	$character_mode = "메인 캐릭터 등업 신청";
} elseif($member[character_mode]=="2") {
	$character_mode = "서브 캐릭터 등업 신청";
} elseif($member[character_mode]=="3") {
	$character_mode = "전문 기술 변경 요청";
} elseif($member[character_mode]=="4") {
	$character_mode = "메인 캐릭터 변경 요청";
} else {
	$character_mode = "";
}

// 등업 신청자 리스트
$wait_result = mysql_query("SELECT * FROM member WHERE level_state='1' and level_time<=$time-172800 ORDER BY level_time", $dbconn);
$m = 1;
while($wait = mysql_fetch_array($wait_result)) {
	if($m=="1") {
		$n = $wait[no];
	} else {
		$wait_n = mysql_fetch_array(mysql_query("select * from member where no='$n'",$dbconn));
	}
	if($wait[point]==$wait_n[point]) {
		$m = $m-1;
	}
	if($wait[no]==$member[no]) break;
	$n = $wait[no];
	$m++;
}
$m = $m."등)";

if($level_time_after<172800) {
	$level_time_after = "[1단계] 몰튼 전투 정보실의 동기화를 위해 잠시 대기합니다. (48시간 소요)";
} else {
	$level_time_after = "[2단계] 운영진의 승인을 기다리고 있습니다. (대기 순위: $m";
}

// 인증 게시판 게시물 확인
$bbs_confirm = mysql_query("select COUNT(*) FROM bbs_confirm where no='$member[no]'",$dbconn);
$bbs_confirm_check = mysql_result($bbs_confirm, 0, "COUNT(*)");

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
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_6_6.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								길드 등급을 승급하기 위한 등업 신청 장소입니다.
							</span></font></p>
							<br><br><br>
							<p align="center">
								<?if($member[level_state]=="0"){?>
								<a href="member_process_1_<?=$member[level]?>_1.php"><img src="http://akeetes430.cdn2.cafe24.com/button_6_5_1_1.gif"	name="button_1" width="200" height="100" border="0"	OnMouseOut="button_1.src='http://akeetes430.cdn2.cafe24.com/button_6_5_1_1.gif';div_hide('tooltip_1');"	OnMouseOver="button_1.src='http://akeetes430.cdn2.cafe24.com/button_6_5_1_2.gif';div_show('tooltip_1');" align="bottom" alt="" onmousemove="div_move(event, 'tooltip_1');"></a>&nbsp;&nbsp;&nbsp;<a href="member_process_2_0.php"><img src="http://akeetes430.cdn2.cafe24.com/button_6_5_2_1.gif"	name="button_2" width="200" height="100" border="0"	OnMouseOut="button_2.src='http://akeetes430.cdn2.cafe24.com/button_6_5_2_1.gif';div_hide('tooltip_2');"	OnMouseOver="button_2.src='http://akeetes430.cdn2.cafe24.com/button_6_5_2_2.gif';div_show('tooltip_2');" align="bottom" alt="" onmousemove="div_move(event, 'tooltip_2');"></a>&nbsp;&nbsp;&nbsp;<a href="member_process_3_0.php"><img src="http://akeetes430.cdn2.cafe24.com/button_6_5_3_1.gif"	name="button_3" width="200" height="100" border="0"	OnMouseOut="button_3.src='http://akeetes430.cdn2.cafe24.com/button_6_5_3_1.gif';div_hide('tooltip_3');"	OnMouseOver="button_3.src='http://akeetes430.cdn2.cafe24.com/button_6_5_3_2.gif';div_show('tooltip_3');" align="bottom" alt="" onmousemove="div_move(event, 'tooltip_3');"></a>
								<div id="tooltip_1" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>일반적인 등업 신청으로 홈피 계정과 자신의 메인 캐릭터의 등급이 동일하게 등업됩니다.
									</span></font></p>
								</div>
								<div id="tooltip_2" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>메인 캐릭터 외에 다른 캐릭터를 추가해서 등업할 수 있습니다.
									</span></font></p>
								</div>
								<div id="tooltip_3" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>전문 기술 변경 및 메인-서브 캐릭터 전환 신청을 할 수 있습니다.
									</span></font></p>
								</div><?}?>
								
								<?if($member[level_state]=="1"){?><table id="layout_mini_2" border="0" cellspacing="0" cellpadding="0">
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="2"></td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_title" colspan="2">
				        			<table>
				        				<tr>
				        					<td style="width:300px;">
														<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<strong>처리 상황</strong>
														</span></font></p>
													</td>
				        					<td style="width:350px;">
														<p style="margin-right:15pt; margin-left:15pt;" align="right"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<?if($level_time_after<172800) {?><input type="button" value=" 취소 " style="width:60px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='member_6_cancel.php';"><?}?>
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
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>신청 종류</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<?=$character_mode?>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>신청 시간</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<?=$level_time?>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>진행 상황</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<?=$level_time_after?>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
								</table>
								<br><br><br>
								<img src="http://akeetes430.cdn2.cafe24.com/button_6_5_1_0.gif"	name="button_1" width="200" height="100" border="0"	OnMouseOut="div_hide('tooltip_1');"	OnMouseOver="div_show('tooltip_1');" align="bottom" alt="" onmousemove="div_move(event, 'tooltip_1');">&nbsp;&nbsp;&nbsp;<img src="http://akeetes430.cdn2.cafe24.com/button_6_5_2_0.gif"	name="button_1" width="200" height="100" border="0"	OnMouseOut="div_hide('tooltip_1');"	OnMouseOver="div_show('tooltip_1');" align="bottom" alt="" onmousemove="div_move(event, 'tooltip_1');">&nbsp;&nbsp;&nbsp;<img src="http://akeetes430.cdn2.cafe24.com/button_6_5_3_0.gif"	name="button_1" width="200" height="100" border="0"	OnMouseOut="div_hide('tooltip_1');"	OnMouseOver="div_show('tooltip_1');" align="bottom" alt="" onmousemove="div_move(event, 'tooltip_1');">
								<div id="tooltip_1" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="red"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>현재 신청하신 등업이 아직 처리되지 않아 이용할 수 없습니다.
									</span></font></p>
								</div><?}?>
								
								
								<?if($member[level_state]=="2"){?><table id="layout_mini_2" border="0" cellspacing="0" cellpadding="0">
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="2"></td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_title" colspan="2">
				        			<table>
				        				<tr>
				        					<td style="width:300px;">
														<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="red"><span style="font-size:9pt;">
															<strong>처리 실패</strong>
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
												<center><strong>신청 종류</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<?=$character_mode?>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>처리 시간</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<?=$level_time?>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>실패 이유</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="red"><span style="font-size:9pt;">
												<br><?=$member[level_reason]?><br><br>모든 조건을 만족하신 후 다시 신청해 주시기 바랍니다.<br><br>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
								</table>
								<br><br><br>
								<a href="member_process_1_<?=$member[level]?>_1.php"><img src="http://akeetes430.cdn2.cafe24.com/button_6_5_1_1.gif"	name="button_1" width="200" height="100" border="0"	OnMouseOut="button_1.src='http://akeetes430.cdn2.cafe24.com/button_6_5_1_1.gif';div_hide('tooltip_1');"	OnMouseOver="button_1.src='http://akeetes430.cdn2.cafe24.com/button_6_5_1_2.gif';div_show('tooltip_1');" align="bottom" alt="" onmousemove="div_move(event, 'tooltip_1');"></a>&nbsp;&nbsp;&nbsp;<a href="member_process_2_0.php"><img src="http://akeetes430.cdn2.cafe24.com/button_6_5_2_1.gif"	name="button_2" width="200" height="100" border="0"	OnMouseOut="button_2.src='http://akeetes430.cdn2.cafe24.com/button_6_5_2_1.gif';div_hide('tooltip_2');"	OnMouseOver="button_2.src='http://akeetes430.cdn2.cafe24.com/button_6_5_2_2.gif';div_show('tooltip_2');" align="bottom" alt="" onmousemove="div_move(event, 'tooltip_2');"></a>&nbsp;&nbsp;&nbsp;<a href="member_process_3_0.php"><img src="http://akeetes430.cdn2.cafe24.com/button_6_5_3_1.gif"	name="button_3" width="200" height="100" border="0"	OnMouseOut="button_3.src='http://akeetes430.cdn2.cafe24.com/button_6_5_3_1.gif';div_hide('tooltip_3');"	OnMouseOver="button_3.src='http://akeetes430.cdn2.cafe24.com/button_6_5_3_2.gif';div_show('tooltip_3');" align="bottom" alt="" onmousemove="div_move(event, 'tooltip_3');"></a>
								<div id="tooltip_1" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>일반적인 등업 신청으로 홈피 계정과 자신의 메인 캐릭터의 등급이 동일하게 등업됩니다.
									</span></font></p>
								</div>
								<div id="tooltip_2" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>메인 캐릭터 외에 다른 캐릭터를 추가해서 등업할 수 있습니다.
									</span></font></p>
								</div>
								<div id="tooltip_3" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>전문 기술 변경 및 메인-서브 캐릭터 전환 신청을 할 수 있습니다.
									</span></font></p>
								</div><?}?>
							
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