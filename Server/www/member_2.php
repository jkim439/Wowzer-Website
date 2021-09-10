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

// 랭킹 리스트
$ranking_result = mysql_query("SELECT * FROM member WHERE level<5 ORDER BY level DESC, point DESC, name_nick ASC", $dbconn);

if($type=="2"){
	echo "<script>alert(' 준비 중인 페이지입니다. 빠른 시일 내에 완성하겠습니다. ');history.back();</script>"; exit;
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
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_6_2.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								포인트 랭킹과 우수 플레이어 정보를 볼 수 있습니다.
							</span></font></p>
							<br><br><br>
							<p align="center">
								<?if($type=="1"){?><table id="layout_mini_2" border="0" cellspacing="0" cellpadding="0">
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="4"></td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_title" colspan="4">
				        			<table>
				        				<tr>
				        					<td style="width:650px;">
														<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<strong>실시간 포인트 랭킹</strong> (TOP 50)
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
												<center><strong>순위 기준</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" colspan="3">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												등급이 최우선 기준이고, 같은 등급이면 포인트 보유량으로 순위가 결정됩니다.
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>본인 랭킹</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" colspan="3">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<strong><?=$member[name_nick]?>님의 포인트 랭킹</strong>은 <strong><font color="red"><?=$m?>위</font></strong>입니다.
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
				    			<?

									// 반복 변수 초기화
									$j = 1;

									// 반복문 시작
									while($member_ranking = mysql_fetch_array($ranking_result)) {

										// 반복 변수 변환
										$ranking_j = 'ranking_'.$j;

										// 리스트 처리
										$member_ranking_i = mysql_fetch_array(mysql_query("select * from member where no='$member_ranking[no]'",$dbconn));
										$member_ranking_avata_result = mysql_query("SELECT * FROM item WHERE ino=$member_ranking[avata]", $dbconn);
										$member_ranking_avata_item = mysql_fetch_array($member_ranking_avata_result);

										if($member_ranking_avata_item[level_require]=="1") {
											$member_ranking_avata_item_level_require = "Copper";
										} else if($member_ranking_avata_item[level_require]=="2") {
											$member_ranking_avata_item_level_require = "Bronze";
										} else if($member_ranking_avata_item[level_require]=="3") {
											$member_ranking_avata_item_level_require = "Silver";
										} else if($member_ranking_avata_item[level_require]=="4") {
											$member_ranking_avata_item_level_require = "Gold";
										} else if($member_ranking_avata_item[level_require]=="5") {
											$member_ranking_avata_item_level_require = "Staff";
										} else {
											$member_ranking_avata_item_level_require = "Master";
										}
										
										// 등급 명칭
										if($member_ranking[level]=="1") {
											$member_ranking_level = "Copper";
										} elseif($member_ranking[level]=="2") {
											$member_ranking_level = "Bronze";
										} elseif($member_ranking[level]=="3") {
											$member_ranking_level = "Silver";
										} elseif($member_ranking[level]=="4") {
											$member_ranking_level = "Gold";
										} elseif($member_ranking[level]=="5") {
											$member_ranking_level = "Staff";
										} else {
											$member_ranking_level = "Master";
										}
										
										if($j=="1") {
											$k = $member_ranking[no];
										} else {
											$member_ranking_k = mysql_fetch_array(mysql_query("select * from member where no='$k'",$dbconn));
										}
										if($member_ranking[point]==$member_ranking_k[point]) {
												$j = $j-1;
										}
										if($j>50) break;

									?>
									<tr>
										<td id="layout_mini_2_left" style="height:80px;">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong><?if($member_ranking[point]==$member_ranking_k[point]){?><?}else{?><?=$j?>위<?}?></strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" style="width:80px; height:80px;">
											<p style="margin-right:0pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<img align="middle" src="http://akeetes430.cdn2.cafe24.com/<?=$member_ranking_avata_item[image]?>" width="64" height="64"  alt="" style="border-width:2pt; border-style:solid;<?if($member_ranking_avata_item[level]=="1"){?> border-color:rgb(0,0,0);<?}else if($member_ranking_avata_item[level]=="2"){?> border-color:rgb(17,121,0);<?}else if($member_ranking_avata_item[level]=="3"){?> border-color:rgb(0,72,255);<?}else if($member_ranking_avata_item[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>"" onmouseover="div_show('<?=$ranking_j?>');" onmouseout="div_hide('<?=$ranking_j?>');" onmousemove="div_move(event, '<?=$ranking_j?>');">
											</span></font></p>

											<?if($member[login_browser]=="1"){?>
												<div id="<?=$ranking_j?>" style="width:300px; height:200px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip.png'); display:none;">
													<table cellpadding="0" cellspacing="0" style="width:300px;">
														<tr>
															<td style="width:300px;" colspan="2">
																<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																	<strong><?if($member_ranking_avata_item[level]=="1"){?><font color="white"><?}?><?if($member_ranking_avata_item[level]=="2"){?><font color="#11d400"><?}?><?if($member_ranking_avata_item[level]=="3"){?><font color="#0048ff"><?}?><?if($member_ranking_avata_item[level]=="4"){?><font color="#8222cc"><?}?><?if($member_ranking_avata_item[level]=="5"){?><font color="#ff7200"><?}?>&nbsp;<br><br><?=$member_ranking_avata_item[name]?><br><br>&nbsp;</font></strong>
																</span></font></p>
															</td>
														</tr>
														<tr>
															<td style="width:200px;">
																<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#f6d818"><span style="font-size:9pt;">
																	<?if($member[point]<$member_ranking_avata_item[price] || $member[level]<$member_ranking_avata_item[level_require] || $member_ranking_avata_item[state]=="4"){?><font color="red">구매 불가<?}else{?><font color="white">구매 가능<?}?>
																</span></font></p>
															</td>
															<td style="width:100px;">
																<p align="right" style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																	<?if($member_ranking_avata_item[level]=="1"){?><font color="white">일반급</font><?}?><?if($member_ranking_avata_item[level]=="2"){?><font color="#11d400">고급</font><?}?><?if($member_ranking_avata_item[level]=="3"){?><font color="#0048ff">희귀급</font><?}?><?if($member_ranking_avata_item[level]=="4"){?><font color="#8222cc">영웅급</font><?}?><?if($member_ranking_avata_item[level]=="5"){?><font color="#ff7200">전설급</font><?}?>
																</span></font></p>
															</td>
														</tr>
														<tr>
															<td style="width:300px; text-align:justify;" colspan="2">
																<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#B2B2B2"><span style="font-size:9pt;">
																	&nbsp;<br><?=$member_ranking_avata_item[direction]?><br>&nbsp;
																</span></font></p>
																<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																	<font color="#11d400">사용효과: <?=$member_ranking_avata_item[effect]?></font><br>&nbsp;
																</span></font></p>
																<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																	<?if($member[level]<$member_ranking_avata_item[level_require]){?><font color="red"><?}else{?><font color="white"><?}?>최소 요구 등급: <?=$member_ranking_avata_item_level_require?> (<?=$member_ranking_avata_item[level_require]?> 레벨)</font>
																</span></font></p>
																<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																	<?if($member[point]<$member_ranking_avata_item[price]){?><font color="red"><?}else{?><font color="white"><?}?>상점 판매 가격: <?=$member_ranking_avata_item[price]?> 포인트</font>
																</span></font></p>
															</td>
														</tr>
													</table>
												</div>
											<?}
											// 파이어폭스
											else
											{?>
												<div id="<?=$ranking_j?>" style="width:300px; height:200px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip.png'); display:none;">
													<table cellpadding="0" cellspacing="0" style="width:300px;">
														<tr>
															<td style="width:300px;" colspan="2">
																<p style="margin-right:10pt; margin-left:10pt; line-height:8pt;"><font face="Gulim"><span style="font-size:9pt;">
																	<strong><?if($member_ranking_avata_item[level]=="1"){?><font color="white"><?}?><?if($member_ranking_avata_item[level]=="2"){?><font color="#11d400"><?}?><?if($member_ranking_avata_item[level]=="3"){?><font color="#0048ff"><?}?><?if($member_ranking_avata_item[level]=="4"){?><font color="#8222cc"><?}?><?if($member_ranking_avata_item[level]=="5"){?><font color="#ff7200"><?}?>&nbsp;<br><br><?=$member_ranking_avata_item[name]?><br><br>&nbsp;</font></strong>
																</span></font></p>
															</td>
														</tr>
														<tr>
															<td style="width:200px;">
																<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#f6d818"><span style="font-size:9pt;">
																	<?if($member[point]<$member_ranking_avata_item[price] || $member[level]<$member_ranking_avata_item[level_require]){?><font color="red">구매 불가<?}else{?><font color="white">구매 가능<?}?>
																</span></font></p>
															</td>
															<td style="width:100px;">
																<p align="right" style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																	<?if($member_ranking_avata_item[level]=="1"){?><font color="white">일반급</font><?}?><?if($member_ranking_avata_item[level]=="2"){?><font color="#11d400">고급</font><?}?><?if($member_ranking_avata_item[level]=="3"){?><font color="#0048ff">희귀급</font><?}?><?if($member_ranking_avata_item[level]=="4"){?><font color="#8222cc">영웅급</font><?}?><?if($member_ranking_avata_item[level]=="5"){?><font color="#ff7200">전설급</font><?}?>
																</span></font></p>
															</td>
														</tr>
														<tr>
															<td style="width:300px; text-align:justify; line-height:10pt;" colspan="2">
																<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#B2B2B2"><span style="font-size:9pt;">
																	&nbsp;<br><?=$member_ranking_avata_item[direction]?><br>&nbsp;
																</span></font></p>
																<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																	<font color="lime">사용효과: <?=$member_ranking_avata_item[effect]?></font><br>&nbsp;
																</span></font></p>
																<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																	<?if($member[level]<$member_ranking_avata_item[level_require]){?><font color="red"><?}else{?><font color="white"><?}?>최소 요구 등급: <?=$item_level_require?> (<?=$member_ranking_avata_item[level_require]?> 레벨)</font>
																</span></font></p>
																<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;">
																	<?if($member[point]<$member_ranking_avata_item[price]){?><font color="red"><?}else{?><font color="white"><?}?>상점 판매 가격: <?=$member_ranking_avata_item[price]?> 포인트</font>
																</span></font></p>
															</td>
														</tr>
													</table>
												</div>
											<?}?>

										</td>
										<td id="layout_mini_2_right" style="width:390px; height:80px;">
											<p style="margin-right:10pt; margin-left:5pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<?if($member_ranking[title]=="0"){?><font color="#767575">칭호가 없습니다.</font><?}else{?><?=$member_ranking[title]?><?}?><br>
												<?if($member_ranking[level]>4){?><img src="http://akeetes430.cdn2.cafe24.com/icon_admin.gif" align="absmiddle" style="width:20px; height:13px;" alt="운영진"> <?}elseif($member_ranking[level]=="4"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_gold.gif" align="absmiddle" style="width:20px; height:13px;" alt="골드"> <?}elseif($member_ranking[level]=="3"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_silver.gif" align="absmiddle" style="width:20px; height:13px;" alt="실버"> <?}?><strong><?=$member_ranking[name_nick]?></strong><br><br>
												<strong><?=$member_ranking_level?></strong> (<strong><?=$member_ranking[level]?></strong> 레벨)<br>
												<strong><?=$member_ranking[point]?></strong> 포인트
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" style="width:80px; height:80px;">
											<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<input type="button" value="정보" style="width:50px; height:19px; font-family:'Gulim'; font-size:9pt;" onclick="popup_profile('<?=urlencode($member_ranking[name_nick])?>');">
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
									<?
										$k = $member_ranking[no];
										$j++;
									}
									?>
									<tr>
										<td id="layout_mini_2_left">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<center><strong>51위~</strong></center>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" colspan="3">
											<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												실시간 포인트 랭킹은 1~50위까지만 볼 수 있습니다.
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="4"></td>
				    			</tr>
								</table>
								<br><br><br><br><br><br><br><br><br>
								<?} else if($type=="2"){?><table id="layout_mini_2" border="0" cellspacing="0" cellpadding="0">
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="2"></td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_title" colspan="2">
				        			<table>
				        				<tr>
				        					<td style="width:300px;">
														<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<strong>이번 주 우수 플레이어</strong> (9월 4주차)
														</span></font></p>
													</td>
				        					<td style="width:350px;">
														<p style="margin-right:15pt; margin-left:15pt;" align="right"><font face="Gulim" color="white"><span style="font-size:9pt;">
															<input type="button" value=" 기록 " style="width:60px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="popup_oldbest();">
														</span></font></p>
													</td>
												</tr>
											</table>
				        		</td>
				    			</tr>
									<tr>
				        		<td id="layout_mini_2_titleline" colspan="2"></td>
				    			</tr>
									<tr style="cursor:pointer;" onclick="popup_info(1);" onmouseover="div_show('tooltip_1');" onmouseout="div_hide('tooltip_1');" onmousemove="div_move(event, 'tooltip_1');">
										<td id="layout_mini_2_left" style="vertical-align:middle; height:110px; background-color:rgb(255,255,255);">
											<p align="center"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<img align="middle" src="http://akeetes430.cdn2.cafe24.com/illust_king.gif" style="width:80px; height:80px;" border="0" alt="">
											</span></font></p>
										</td>
										<td id="layout_mini_2_right" style="vertical-align:middle; height:110px;">
											<p style="margin-right:0pt; margin-left:0pt; font-family:Arial;"><font face="Arial" color="black">
												<span style="font-size:58pt; font-family:Arial;">Lichgold</span>
											</font></p>

											<div id="tooltip_1" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
												<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
													<br><?if($member[login_browser]=="1"){?><br><?}?>이번 주 우수 플레이어이신 [닉네임]님의 유저 정보를 보시려면 클릭하십시오.
												</span></font></p>
											</div>

										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p align="center"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<strong>대상</strong>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<strong>Lichgold</strong> (닉네임: <strong>[리치골드]</strong>)님이 9월 4주차 우수 플레이어로 선정되었습니다.
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p align="center"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<strong>기간</strong>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												<font color="#0048ff"><strong>[길드의 징표]</strong></font><font color="black"> 아이템을 드립니다. (</font><font color="lime">사용효과: 5000 포인트를 획득합니다.</font>)
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
									<tr>
										<td id="layout_mini_2_left">
											<p align="center"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
												<strong>발표</strong>
											</span></font></p>
										</td>
										<td id="layout_mini_2_right">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
												다음 우수 플레이어는 <strong>10월 4일 0시</strong>에 발표됩니다.
											</span></font></p>
										</td>
									</tr>
									<tr>
				        		<td id="layout_mini_2_line" colspan="2"></td>
				    			</tr>
								</table>
							<br><br><br>
								<?}else{?><a href="member_2.php?type=1"><img src="http://akeetes430.cdn2.cafe24.com/button_6_2_1_1.gif"	name="button_1" width="200" height="100" border="0"	OnMouseOut="button_1.src='http://akeetes430.cdn2.cafe24.com/button_6_2_1_1.gif';div_hide('tooltip_2');"	OnMouseOver="button_1.src='http://akeetes430.cdn2.cafe24.com/button_6_2_1_2.gif';div_show('tooltip_2');" align="bottom" alt="" onmousemove="div_move(event, 'tooltip_2');"></a>&nbsp;&nbsp;&nbsp;<a href="member_2.php?type=2"><img src="http://akeetes430.cdn2.cafe24.com/button_6_2_2_1.gif"	name="button_2" width="200" height="100" border="0"	OnMouseOut="button_2.src='http://akeetes430.cdn2.cafe24.com/button_6_2_2_1.gif';div_hide('tooltip_3');"	OnMouseOver="button_2.src='http://akeetes430.cdn2.cafe24.com/button_6_2_2_2.gif';div_show('tooltip_3');" align="bottom" alt="" onmousemove="div_move(event, 'tooltip_3');"></a>
							
								<div id="tooltip_2" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>자신의 포인트 순위와 다른 길드원의 랭킹을 보시려면 클릭하세요.
									</span></font></p>
								</div>

								<div id="tooltip_3" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>매주마다 운영진의 심사를 거쳐 선정된 우수 플레이어를 공개합니다.
									</span></font></p>
								</div>
							
							<br><br><br><?}?>
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