<?

// 헤더파일	연결
include	"../header.php";

// 포인트 기록 연결
include "config_point.php";

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

// 개인 랭킹
$myranking_result = mysql_query("SELECT * FROM member WHERE level<5 ORDER BY level DESC, point DESC, name_nick ASC", $dbconn);
$m = 1;
while($myranking = mysql_fetch_array($myranking_result)) {
	if($m=="1") {
		$n = $myranking[no];
	} else {
		$myranking_n = mysql_fetch_array(mysql_query("select * from member where no='$n'",$dbconn));
	}
	if($myranking[point]==$myranking_n[point]) {
		$m = $m-1;
	}
	if($myranking[no]==$member[no]) break;
	$n = $myranking[no];
	$m++;
}

// 칭호 글자수 제한
$title_num = mb_strlen($member[title], 'UTF-8');
if($title_num>12) {
	$title = mb_substr($member[title], 0, 12, 'UTF-8');
	$title = $title.'...';
} else {
	$title = $member[title];
}

// 이메일 글자수 제한
$email_num = mb_strlen($member[email], 'UTF-8');
if($email_num>27) {
	$email = mb_substr($member[email], 0, 27, 'UTF-8');
	$email = $email.'...';
} else {
	$email = $member[email];
}

// 아이템 갯수
$item = array();
$item_num=0;
$item_num_i=1;
while($item_num_i<=$site_item) {
	$item_i = 'item_'.$item_num_i;
	if($member[$item_i]=="0") {
		$item_num_i++;
	} else {
		$item_list[] = "$item_num_i";
		$item_num=$item_num+1;
		$item_num_i++;
	}
}

// 캐릭터 갯수
$character_num=1;
while($character_num<=9) {
	$character_i = 'character_'.$character_num.'_name';
	if(!$member[$character_i]) {
		break;
	} else {
		$character_num++;
	}
}
$character_num=$character_num-1;

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
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_6_1.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br>
							<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<script type="text/javascript">
									<!--
									google_ad_client = "ca-pub-8506472453970244";
									/* title */
									google_ad_slot = "0177202610";
									google_ad_width = 728;
									google_ad_height = 90;
									//-->
								</script>
								<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script><br><br><br>
							</span></font></p>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								자신의 계정, 캐릭터, 아이템, 칭호 정보를 볼 수 있고 정보 수정이나 탈퇴를 할 수 있습니다.<?if($member[level]>4){?><br><font color="red">관리자 페이지로 이동하시려면 [관리자] 버튼을 클릭해 주세요. <input type="button" value=" 관리자 " style="width:60px; height:23px; font-weight:bold; font-family:'Gulim'; font-size:9pt;" onclick="top.location.href='http://www.wowzer.kr/admin/';"></font><?}?>
							</span></font></p>
							<br><br><br>
							<p align="center">
								<table id="layout_mini_1" border="0" cellspacing="0" cellpadding="0">
									<tr>
				        		<td id="layout_mini_1_titleline" colspan="4"></td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_1_title" colspan="4">
				        			<table>
				        				<tr>
				        					<td style="width:300px;">
														<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<strong>주요 정보</strong>
														</span></font></p>
													</td>
				        					<td style="width:350px;">
														<p style="margin-right:15pt; margin-left:15pt;" align="right"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<input type="button" value=" 변경 " style="width:60px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='help_4.php';"> <input type="button" value=" 삭제 " style="width:60px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='help_5.php';">
														</span></font></p>
													</td>
												</tr>
											</table>
				        		</td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_1_titleline" colspan="4"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_1_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>아이디</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_1_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<?=$member[id]?>
											</span></font></p>
										</td>
										<td id="layout_mini_1_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>닉네임</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_1_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<?=$member[name_nick]?>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_1_line" colspan="4"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_1_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>길드 등급</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_1_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<strong><?=$level?></strong> (<strong><?=$member[level]?></strong> 레벨)&nbsp;&nbsp;<input type="button" value="등업" style="width:50px; height:19px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='member_6.php';">
											</span></font></p>
										</td>
										<td id="layout_mini_1_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>포인트</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_1_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<strong><?=$member[point]?></strong> 포인트  <strong><font color="red">(<?=$m?>위)</font>&nbsp;&nbsp;<input type="button" value="랭킹" style="width:50px; height:19px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='member_2.php';">
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_1_line" colspan="4"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_1_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>칭호</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_1_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<?if($member[title]=="0"){?><input type="button" value="구매" style="width:50px; height:19px; font-family:'Gulim'; font-size:9pt;" onclick="popup_shop();"><?}else{?><?=$title?>&nbsp;&nbsp;<input type="button" value="구매" style="width:50px; height:19px; font-family:'Gulim'; font-size:9pt;" onclick="popup_shop();"><?}?>
											</span></font></p>
										</td>
										<td id="layout_mini_1_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>이메일</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_1_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<?=$email?>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_1_line" colspan="4"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_1_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>캐릭터</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_1_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<strong><?=$character_num?></strong> 개
											</span></font></p>
										</td>
										<td id="layout_mini_1_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>아이템</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_1_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
											<strong><?=$item_num?></strong> 개
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_1_line" colspan="4"></td>
				    			</tr>
								</table><br><br><br><table id="layout_mini_2" border="0" cellspacing="0" cellpadding="0">
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="4"></td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_title" colspan="4">
				        			<table>
				        				<tr>
				        					<td style="width:300px;">
														<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<strong>포인트 기록</strong> (최근 5개)
														</span></font></p>
													</td>
				        					<td style="width:350px;">
													</td>
												</tr>
											</table>
				        		</td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="4"></td>
				    			</tr>
				    			<?
									for($p=1;$p<6;$p++) {
										$log_point_p = "log_point_".$p;
										$log_point_p_time = "log_point_time_".$p;
										if($member[$log_point_p]=="0") {
											break;
										}
									}
									for($q=1;$q<$p;$q++) {
										$log_point_q = "log_point_".$q;
										$log_point_q_time = "log_point_".$q."_time";
										$log_point_q_time_1 = date("Y.m.d", $member[$log_point_q_time]);
										$log_point_q_time_2 = date("H:i:s", $member[$log_point_q_time]);
										$log_point_q_text = ${'log_point_code_'.$member[$log_point_q]};

									?>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong><?=$log_point_q_time_1?></strong><br><?=$log_point_q_time_2?></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<?=$log_point_q_text?>
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
				    			<?}?>
								</table><a name="bag">&nbsp;</a><br><br><br>
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
															<strong>아이템 가방</strong> (<?=$item_num?>개)
														</span></font></p>
													</td>
				        					<td style="width:350px;">
														<p style="margin-right:15pt; margin-left:15pt;" align="right"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<input type="button" value=" 상점 " style="width:60px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="popup_shop();">
														</span></font></p>
													</td>
												</tr>
											</table>
				        		</td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="4"></td>
				    			</tr>
				    			<?

									// 반복 변수 초기화
									$i = 1;
									$m = 0;

									// 반복문 시작
									while($i<=$item_num) {
										
										$item_result = mysql_query("SELECT * FROM item WHERE ino=$item_list[$m]", $dbconn);
										$item = mysql_fetch_array($item_result);
										$item_ii = 'item_'.$item[ino];

											if($item[level_require]=="1") {
												$item_level_require = "Copper";
											} elseif($item[level_require]=="2") {
												$item_level_require = "Bronze";
											} elseif($item[level_require]=="3") {
												$item_level_require = "Silver";
											} elseif($item[level_require]=="4") {
												$item_level_require = "Gold";
											} elseif($item[level_require]=="5") {
												$item_level_require = "Staff";
											} else {
												$item_level_require = "Master";
											}

										if($item[state]=="0") {
											$item_state = "";
										} else if($item[state]=="1") {
											$item_state = "<img align='absmiddle' src='http://akeetes430.cdn2.cafe24.com/icon_item_new.gif' width='50' height='19' alt=''> ";
										} else if($item[state]=="2") {
											$item_state = "<img align='absmiddle' src='http://akeetes430.cdn2.cafe24.com/icon_item_sale.gif' width='50' height='19' alt=''> ";
										} else if($item[state]=="3") {
											$item_state = "<img align='absmiddle' src='http://akeetes430.cdn2.cafe24.com/icon_item_event.gif' width='50' height='19' alt=''> ";
										} else {
											$item_state = "<img align='absmiddle' src='http://akeetes430.cdn2.cafe24.com/icon_item_notforsale.gif' width='50' height='19' alt=''> ";
										}

									?>
									<tr style="cursor:default;" onmouseover="div_show('<?=$item_ii?>');" onmouseout="div_hide('<?=$item_ii?>');" onmousemove="div_move(event, '<?=$item_ii?>');">
										<td id="layout_mini_2_left" style="height:80px;">
											<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<img align="middle" src="http://akeetes430.cdn2.cafe24.com/<?=$item[image]?>" width="64" height="64"  alt="" style="border-width:2pt; border-style:solid;<?if($item[level]=="1"){?> border-color:rgb(255,255,255);<?}else if($item[level]=="2"){?> border-color:rgb(17,121,0);<?}else if($item[level]=="3"){?> border-color:rgb(0,72,255);<?}else if($item[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" style="height:80px;">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
												<?=$item_state?><strong><?if($item[level]=="1"){?><font color="black"><?}?><?if($item[level]=="2"){?><font color="#11d400"><?}?><?if($item[level]=="3"){?><font color="#0048ff"><?}?><?if($item[level]=="4"){?><font color="#8222cc"><?}?><?if($item[level]=="5"){?><font color="#ff7200"><?}?>[<?=$item[name]?>]</font></strong><?if($member[$item_ii]=="1"){?>&nbsp;&nbsp;<input type="button" value="사용" style="width:50px; height:19px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='member_item_use_1.php?ino=<?=$item[ino]?>';"><?if($item[ino]!="1"){?>&nbsp;<input type="button" value="삭제" style="width:50px; height:19px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='member_item_del_1.php?ino=<?=$item[ino]?>';"><?}?><?}else{?>&nbsp;&nbsp;<input type="button" value="사용 중" style="width:50px; height:19px; font-family:'Gulim'; font-size:9pt;" disabled><?}?>
											</span></font></p>

											<?if($member[login_browser]=="1"){?>
											<div id="<?=$item_ii?>" style="width:300px; height:200px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip.png'); display:none;">
												<table cellpadding="0" cellspacing="0" style="width:300px;">
													<tr>
														<td style="width:300px;" colspan="2">
															<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																<strong><?if($item[level]=="1"){?><font color="white"><?}?><?if($item[level]=="2"){?><font color="#11d400"><?}?><?if($item[level]=="3"){?><font color="#0048ff"><?}?><?if($item[level]=="4"){?><font color="#8222cc"><?}?><?if($item[level]=="5"){?><font color="#ff7200"><?}?>&nbsp;<br><br><?=$item[name]?><br><br>&nbsp;</font></strong>
															</span></font></p>
														</td>
													</tr>
													<tr>
														<td style="width:200px;">
															<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#f6d818"><span style="font-size:9pt;">
																보유 아이템
															</span></font></p>
														</td>
														<td style="width:100px;">
															<p align="right" style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																<?if($item[level]=="1"){?><font color="white">일반급</font><?}?><?if($item[level]=="2"){?><font color="#11d400">고급</font><?}?><?if($item[level]=="3"){?><font color="#0048ff">희귀급</font><?}?><?if($item[level]=="4"){?><font color="#8222cc">영웅급</font><?}?><?if($item[level]=="5"){?><font color="#ff7200">전설급</font><?}?>
															</span></font></p>
														</td>
													</tr>
													<tr>
														<td style="width:300px; text-align:justify;" colspan="2">
															<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#B2B2B2"><span style="font-size:9pt;">
																&nbsp;<br><?=$item[direction]?><br>&nbsp;
															</span></font></p>
															<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																<font color="lime">사용효과: <?=$item[effect]?></font><br>&nbsp;
															</span></font></p>
															<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																<?if($member[level]<$item[level_require]){?><font color="red"><?}else{?><font color="white"><?}?>최소 요구 등급: <?=$item_level_require?> (<?=$item[level_require]?> 레벨)</font>
															</span></font></p>
															<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																<?if($member[point]<$item[price]){?><font color="red"><?}else{?><font color="white"><?}?>상점 판매 가격: <?=$item[price]?> 포인트</font>
															</span></font></p>
														</td>
													</tr>
												</table>
											</div>
										<?}
										// 파이어폭스
										else
										{?>
											<div id="<?=$item_ii?>" style="width:300px; height:200px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip.png'); display:none;">
												<table cellpadding="0" cellspacing="0" style="width:300px;">
													<tr>
														<td style="width:300px;" colspan="2">
															<p style="margin-right:10pt; margin-left:10pt; line-height:8pt;"><font face="Gulim"><span style="font-size:9pt;">
																<strong><?if($item[level]=="1"){?><font color="white"><?}?><?if($item[level]=="2"){?><font color="#11d400"><?}?><?if($item[level]=="3"){?><font color="#0048ff"><?}?><?if($item[level]=="4"){?><font color="#8222cc"><?}?><?if($item[level]=="5"){?><font color="#ff7200"><?}?>&nbsp;<br><br><?=$item[name]?><br><br>&nbsp;</font></strong>
															</span></font></p>
														</td>
													</tr>
													<tr>
														<td style="width:200px;">
															<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#f6d818"><span style="font-size:9pt;">
																보유 아이템
															</span></font></p>
														</td>
														<td style="width:100px;">
															<p align="right" style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																<?if($item[level]=="1"){?><font color="white">일반급</font><?}?><?if($item[level]=="2"){?><font color="#11d400">고급</font><?}?><?if($item[level]=="3"){?><font color="#0048ff">희귀급</font><?}?><?if($item[level]=="4"){?><font color="#8222cc">영웅급</font><?}?><?if($item[level]=="5"){?><font color="#ff7200">전설급</font><?}?>
															</span></font></p>
														</td>
													</tr>
													<tr>
														<td style="width:300px; text-align:justify; line-height:10pt;" colspan="2">
															<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#B2B2B2"><span style="font-size:9pt;">
																&nbsp;<br><?=$item[direction]?><br>&nbsp;
															</span></font></p>
															<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																<font color="lime">사용효과: <?=$item[effect]?></font><br>&nbsp;
															</span></font></p>
															<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																<?if($member[level]<$item[reqlv]){?><font color="red"><?}else{?><font color="white"><?}?>최소 요구 등급: <?=$item_level_require?> (<?=$item[reqlv]?> 레벨)</font>
															</span></font></p>
															<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																<?if($member[point]<$item[price]){?><font color="red"><?}else{?><font color="white"><?}?>상점 판매 가격: <?=$item[price]?> 포인트</font>
															</span></font></p>
														</td>
													</tr>
												</table>
											</div>
										<?}?>

										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
				    			<?
									$m++;
									$i++;
									}
									?>
								</table>
							<br><br><br>
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
															<strong>캐릭터 목록</strong> (<?=$character_num?>개)
														</span></font></p>
													</td>
				        					<td style="width:350px;">
														<p style="margin-right:15pt; margin-left:15pt;" align="right"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<input type="button" value=" 추가 " style="width:60px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='member_6.php';">
														</span></font></p>
													</td>
												</tr>
											</table>
				        		</td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="4"></td>
				    			</tr>
				    			<?

									// 반복 변수 초기화
									$j = 1;

									// 반복문 시작
									while($j<=$character_num) {

									// 반복 변수 변환
									$character_name = 'character_'.$j.'_name';
									$character_job = 'character_'.$j.'_job';
									$character_skill_1 = 'character_'.$j.'_skill_1';
									$character_skill_2 = 'character_'.$j.'_skill_2';

									// 직업 명칭
									if($member[$character_job]=="1") $character_job = "죽음의 기사";
									if($member[$character_job]=="2") $character_job = "전사";
									if($member[$character_job]=="3") $character_job = "도적";
									if($member[$character_job]=="4") $character_job = "사냥꾼";
									if($member[$character_job]=="5") $character_job = "마법사";
									if($member[$character_job]=="6") $character_job = "흑마법사";
									if($member[$character_job]=="7") $character_job = "사제";
									if($member[$character_job]=="8") $character_job = "성기사";
									if($member[$character_job]=="9") $character_job = "주술사";
									if($member[$character_job]=="10") $character_job = "드루이드";

									// 전문기술 명칭
									if($member[$character_skill_1]=="1") $character_skill_1 = "약초채집";
									if($member[$character_skill_1]=="2") $character_skill_1 = "채광";
									if($member[$character_skill_1]=="3") $character_skill_1 = "무두질";
									if($member[$character_skill_1]=="4") $character_skill_1 = "연금술";
									if($member[$character_skill_1]=="5") $character_skill_1 = "대장기술";
									if($member[$character_skill_1]=="6") $character_skill_1 = "기계공학";
									if($member[$character_skill_1]=="7") $character_skill_1 = "가죽세공";
									if($member[$character_skill_1]=="8") $character_skill_1 = "재봉술";
									if($member[$character_skill_1]=="9") $character_skill_1 = "마법부여";
									if($member[$character_skill_1]=="10") $character_skill_1 = "보석세공";
									if($member[$character_skill_1]=="11") $character_skill_1 = "주문각인";
									if($member[$character_skill_2]=="1") $character_skill_2 = "약초채집";
									if($member[$character_skill_2]=="2") $character_skill_2 = "채광";
									if($member[$character_skill_2]=="3") $character_skill_2 = "무두질";
									if($member[$character_skill_2]=="4") $character_skill_2 = "연금술";
									if($member[$character_skill_2]=="5") $character_skill_2 = "대장기술";
									if($member[$character_skill_2]=="6") $character_skill_2 = "기계공학";
									if($member[$character_skill_2]=="7") $character_skill_2 = "가죽세공";
									if($member[$character_skill_2]=="8") $character_skill_2 = "재봉술";
									if($member[$character_skill_2]=="9") $character_skill_2 = "마법부여";
									if($member[$character_skill_2]=="10") $character_skill_2 = "보석세공";
									if($member[$character_skill_2]=="11") $character_skill_2 = "주문각인";

									?>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong><?if($j=="1"){?>메인 캐릭터<?}else{?>서브 캐릭터<?}?></strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<strong>[<?=$member[$character_name]?>]</strong> (<?=$character_job?>) <<?=$character_skill_1?>,<?=$character_skill_2?>>&nbsp;&nbsp;<input type="button" value="자세히" style="width:50px; height:19px; font-family:'Gulim'; font-size:9pt;" onclick="window.open('http://armory.molten-wow.com/character-profile/<?=$member[$character_name]?>/Neltharion/');">
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
				    			<?
									$j++;
									}
									?>
								</table>
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