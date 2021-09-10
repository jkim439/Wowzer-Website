<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);

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

// 상점 아이템 로드
$item_db = mysql_query("SELECT COUNT(*) FROM item where state=2",$dbconn);
$item_db = mysql_result($item_db, 0, "COUNT(*)");
$item_array = array();
$item_i = "0";
for($i=1; $i<=$item_db; $i++) {
	$item_array[] = "$i";
	$item_i++;
}

// 상점 아이템 목록
$item_list = mysql_query("SELECT * FROM item where state=2", $dbconn);

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

<body bgcolor="#00384a" onload="java_check_shop_iframe(); frame_check();" onpropertychange="defence_check();" oncontextmenu="return false;" style="cursor:default;">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

	<div id="layout_shop_iframe" style="display:none;">
		<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
			<img src="http://akeetes430.cdn2.cafe24.com/shop_title_9.gif" width="500" height="40" border="0">
		</span></font></p>
		<p style="margin-left:20pt; margin-right:10pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
			<br><br><br>현재 할인 이벤트가 진행 중인 아이템입니다. (총 <strong><?=$i-1?></strong>개)
			<br><br><br>
			<table id="layout_shop_list" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td id="layout_shop_list_line" colspan="2"></td>
				</tr>
				<?
					$j = 1;
					$k = 0;

					while($item = mysql_fetch_array($item_list)) {

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
							$item_state = "<img align='absmiddle' src='http://akeetes430.cdn2.cafe24.com/icon_item_soldout.gif' width='50' height='19' alt=''> ";
						} else {
							$item_state = "<img align='absmiddle' src='http://akeetes430.cdn2.cafe24.com/icon_item_notforsale.gif' width='50' height='19' alt=''> ";
						}
				?>
				<tr style="cursor:pointer;" onmouseover="div_show('<?=$item_ii?>');" onmouseout="div_hide('<?=$item_ii?>');" onmousemove="div_move(event, '<?=$item_ii?>');" onclick="self.location.href='shop_buy_1.php?ino=<?=$item[ino]?>';">
					<td id="layout_shop_list_left">
						<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
							<img align="middle" src="http://akeetes430.cdn2.cafe24.com/<?=$item[image]?>" width="64" height="64"  alt="" style="border-width:2pt; border-style:solid;<?if($item[level]=="1"){?> border-color:rgb(255,255,255);<?}else if($item[level]=="2"){?> border-color:rgb(17,121,0);<?}else if($item[level]=="3"){?> border-color:rgb(0,72,255);<?}else if($item[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
						</span></font></p>
					</td>
					<td id="layout_shop_list_right">
						<p style="margin-right:0pt; margin-left:0pt;"><font face="Gulim"><span style="font-size:9pt;">
							<?=$item_state?><strong><?if($item[level]=="1"){?><font color="black"><?}?><?if($item[level]=="2"){?><font color="#11d400"><?}?><?if($item[level]=="3"){?><font color="#0048ff"><?}?><?if($item[level]=="4"){?><font color="#8222cc"><?}?><?if($item[level]=="5"){?><font color="#ff7200"><?}?>[<?=$item[name]?>]</font></strong>
							<br><br><?if($member[level]<$item[level_require]){?><font color="red"><?}else{?><font color="black"><?}?>최소 요구 등급: <strong><?=$item_level_require?></strong> (<strong><?=$item[level_require]?></strong> 레벨)<br><?if($member[point]<$item[price]){?><font color="red"><?}else{?><font color="black"><?}?>
							상점 판매 가격: <?if($item[state]=="2"){?><font color="red"><strike><?=$item[price_unused]?> 포인트</strike></font> → <?}?><strong><?=$item[price]?> 포인트</strong>
						</span></font></p>
					</td>
				</tr>
				<tr>
					<td id="layout_shop_list_line" colspan="2">

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
																	<?if($member[point]<$item[price] || $member[level]<$item[level_require] || $item[state]=="4"){?><font color="red">구매 불가<?}else{?><font color="white">구매 가능<?}?>
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
												<div id="<?=$ranking_j?>" style="width:300px; height:200px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip.png'); display:none;">
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
																	<?if($member[point]<$item[price] || $member[level]<$item[level_require]){?><font color="red">구매 불가<?}else{?><font color="white">구매 가능<?}?>
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
																	<?if($member[level]<$item[level_require]){?><font color="red"><?}else{?><font color="white"><?}?>최소 요구 등급: <?=$item_level_require?> (<?=$item[level_require]?> 레벨)</font>
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
				<?
					$j++;
					$k++;
					}
				?>
			</table>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		</span></font></p>
	</div>

</body>

</html>