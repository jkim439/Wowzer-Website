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

// 쿠폰 아이템 개수
$item = array();
$item_num=0;
$item_num_i=1;
while($item_num_i<=$site_item) {
	$item_i = 'item_'.$item_num_i;
	if($member[$item_i]=="0") {
		$item_num_i++;
	} else {
		$item_db = mysql_fetch_array(mysql_query("select * from item where ino='$item_num_i'",$dbconn));
		if($item_db[kind]=="7") {
			$item_list[] = "$item_num_i";
			$item_num=$item_num+1;
			$item_num_i++;
		} else {
			$item_num_i++;
		}
	}
}

// 상점 아이템 로드
$item = mysql_fetch_array(mysql_query("select * from item where ino='$ino'",$dbconn));
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
			<img src="http://akeetes430.cdn2.cafe24.com/shop_title_buy.gif" width="500" height="40" border="0">
		</span></font></p>
		<p style="margin-left:20pt; margin-right:10pt;"><font face="Gulim"><span style="font-size:9pt;">
			<br><br><br>
			<img align="left" src="http://akeetes430.cdn2.cafe24.com/<?=$item[image]?>" width="64" height="64"  alt="" style="border-width:2pt; border-style:solid;<?if($item[level]=="1"){?> border-color:rgb(255,255,255);<?}else if($item[level]=="2"){?> border-color:rgb(17,121,0);<?}else if($item[level]=="3"){?> border-color:rgb(0,72,255);<?}else if($item[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
			<br>&nbsp;&nbsp;&nbsp;<?=$item_state?><strong><?if($item[level]=="1"){?><font color="black"><?}?><?if($item[level]=="2"){?><font color="#11d400"><?}?><?if($item[level]=="3"){?><font color="#0048ff"><?}?><?if($item[level]=="4"){?><font color="#8222cc"><?}?><?if($item[level]=="5"){?><font color="#ff7200"><?}?><?=$item[name]?></font></strong>&nbsp;<?if($item[level]=="1"){?><font color="white">(일반급)</font><?}?><?if($item[level]=="2"){?><font color="#11d400">(고급)</font><?}?><?if($item[level]=="3"){?><font color="#0048ff">(희귀급)</font><?}?><?if($item[level]=="4"){?><font color="#8222cc">(영웅급)</font><?}?><?if($item[level]=="5"){?><font color="#ff7200">(전설급)</font><?}?>
			<br><br><?if($member[level]<$item[level_require]){?><font color="red"><?}else{?><font color="white"><?}?>&nbsp;&nbsp;&nbsp;최소 요구 등급: <strong><?=$item_level_require?></strong> (<strong><?=$item[level_require]?></strong> 레벨)
			<br><?if($member[point]<$item[price]){?><font color="red"><?}else{?><font color="white"><?}?>&nbsp;&nbsp;&nbsp;상점 판매 가격: <?if($item[state]=="2"){?><font color="red"><strike><?=$item[price_unused]?> 포인트</strike></font> → <?}?><strong><?=$item[price]?> 포인트</strong>
		</span></font></p>
		<p style="margin-left:20pt; margin-right:10pt;"><font face="Gulim" color="#00CCFF"><span style="font-size:1pt;">
			<br><br><br><br><br><br><br>____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________
		</span></font></p>
		<p style="margin-left:35pt; margin-right:10pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
			<br><br><?=$item[direction]?>
			<br><br><font color="lime">사용효과: <?=$item[effect]?></font>
		</span></font></p>
		<p style="margin-left:20pt; margin-right:10pt;"><font face="Gulim" color="#00CCFF"><span style="font-size:1pt;">
			<br><br><br><br><br><br><br><br><br>____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________
		</span></font></p>
		<form name="buy" target="_self" method="post" action="shop_buy_2.php">
			<table style="width:500px">
				<tr>
					<td style="width:350px;">
						<p style="margin-left:35pt; margin-right:10pt;"><font face="Gulim" color="#00CCFF"><span style="font-size:9pt;">
							<br><br><strong>결제 수단</strong>
						</span></font></p>
					</td>
					<td style="width:150px;">
						<p align="right" id="buy_method_1" style="margin-left:10pt; margin-right:35pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
							<br><br><?if($item[state]=="3"){?><font color="red"><strong>품절</strong></font><?}else if($item[state]=="4"){?><font color="red"><strong>비매품</strong></font><?}else{?><?if($member[point]<$item[price]){?><font color="red"><?}else{?><font color="white"><?}?><strong><?=$item[price]?> 포인트</strong></font><?}?>
						</span></font></p>
						<p align="right" id="buy_method_2" style="margin-left:10pt; margin-right:35pt; display:none;"><font face="Gulim" color="white"><span style="font-size:9pt;">
							<br><br><strong>0 포인트</strong>
						</span></font></p>
					</td>
				</tr>
				<tr>
					<td style="width:350px">
						<p style="margin-left:50pt; margin-right:0pt;"><font face="Gulim" color="#00CCFF"><span style="font-size:9pt;">
							<?if($item[state]=="3"){?>
								<br><font color="white"><label for="buy_method_lable_1"><input type="radio" name="buy_method" id="buy_method_lable_1" value="1" onclick="document.buy.buy_method[0].checked=false; alert(' 품절된 아이템이므로 구매할 수 없습니다. ');"> <strike>포인트 결제</strike></label>
								<br><font color="white"><label for="buy_method_lable_1"><input type="radio" name="buy_method" id="buy_method_lable_2" value="2" onclick="document.buy.buy_method[1].checked=false; alert(' 품절된 아이템이므로 구매할 수 없습니다. ');"> <strike>무료 쿠폰 결제</strike></label>
								&nbsp;<select id="buy_coupon" name="buy_coupon" size="1" style="width:150px; font-family:'Gulim'; font-size:9pt;" disabled>
									<option value="1">쿠폰 선택</option>
								</select>
							<?}else if($item[state]=="4"){?>
								<br><font color="white"><label for="buy_method_lable_1"><input type="radio" name="buy_method" id="buy_method_lable_1" value="1" onclick="document.buy.buy_method[0].checked=false; alert(' 비매품 아이템이므로 구매할 수 없습니다. ');"> <strike>포인트 결제</strike></label>
								<br><font color="white"><label for="buy_method_lable_1"><input type="radio" name="buy_method" id="buy_method_lable_2" value="2" onclick="document.buy.buy_method[1].checked=false; alert(' 비매품 아이템이므로 구매할 수 없습니다. ');"> <strike>무료 쿠폰 결제</strike></label>
								&nbsp;<select id="buy_coupon" name="buy_coupon" size="1" style="width:150px; font-family:'Gulim'; font-size:9pt;" disabled>
									<option value="1">쿠폰 선택</option>
								</select>
							<?}else{?>
								<?if($member[level]<$item[level_require]){?>
									<br><font color="white"><label for="buy_method_lable_1"><input type="radio" name="buy_method" id="buy_method_lable_1" value="1" onclick="document.buy.buy_method[0].checked=false; alert(' 최소 요구 등급 조건에 맞지 않아 구매할 수 없습니다. ');"> <strike>포인트 결제</strike></label>
									<br><font color="white"><label for="buy_method_lable_2"><input type="radio" name="buy_method" id="buy_method_lable_2" value="2" onclick="document.buy.buy_method[1].checked=false; alert(' 최소 요구 등급 조건에 맞지 않아 구매할 수 없습니다. ');"> <strike>무료 쿠폰 결제</strike></label>
									&nbsp;<select id="buy_coupon" name="buy_coupon" size="1" style="width:150px; font-family:'Gulim'; font-size:9pt;" disabled>
										<option value="1">쿠폰 선택</option>
									</select>
								<?}else{?>
									<br><font color="white"><label for="buy_method_lable_1"><input type="radio" name="buy_method" id="buy_method_lable_1" value="1" onclick="document.getElementById('buy_method_1').style.display=''; document.getElementById('buy_method_2').style.display='none'; document.buy.buy_coupon[0].selected=true; document.buy.buy_coupon.disabled=true;<?if($member[point]<$item[price]){?> document.buy.buy_submit.disabled=true;<?}else{?> document.buy.buy_submit.disabled=false;<?}?>" checked> 포인트 결제</label></font>
									<br><font color="white"><label for="buy_method_lable_2"><input type="radio" name="buy_method" id="buy_method_lable_2" value="2"<?if($item[state]=="1"){?> onclick="document.buy.buy_method[0].checked=true; alert(' 신상품은 무료 쿠폰을 사용할 수 없습니다. ');"<?}else{?> onclick="document.getElementById('buy_method_1').style.display='none'; document.getElementById('buy_method_2').style.display=''; document.buy.buy_coupon.disabled=false; document.buy.buy_submit.disabled=true;"<?}?>> <?if($item[state]=="1"){?><strike>무료 쿠폰 결제</strike><?}else{?>무료 쿠폰 결제<?}?></label>
									&nbsp;<select name="buy_coupon" size="1" style="width:150px; font-family:'Gulim'; font-size:9pt;" onchange="shop_coupon();" disabled>
										<option value="1">쿠폰 선택</option>
										<?
											$k=0;
											$i=1;
											$j=2;
											while($i<=$item_num) {
												$item_list_i = mysql_fetch_array(mysql_query("select * from item where ino='$item_list[$k] ORDER BY ino'",$dbconn));
										?>
											<option value="<?=$item_list_i[ino]?>"><?=$item_list_i[name]?></option>
										<?
												$k++;
												$j++;
												$i++;
											}
										?>
									</select>
								<?}?>
							<?}?>
						</p>
					</td>
					<td style="width:150px;">
						<p align="right" style="margin-left:10pt; margin-right:35pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
							<br><input type="hidden" name="ino" value="<?=$item[ino]?>"><?if($item[state]=="3"){?><input name="buy_submit" type="submit" value=" 구매 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" disabled><?}else if($item[state]=="4"){?><input name="buy_submit" type="submit" value=" 구매 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" disabled><?}else{?><?if($member[level]<$item[level_require]){?><input name="buy_submit" type="submit" value=" 구매 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" disabled><?}else{?><input name="buy_submit" type="submit" value=" 구매 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="if(confirm(' 아이템을 구매하시겠습니까? ')) ; else return false;"<?if($member[point]<$item[price]){?> disabled<?}?>><?}?><?}?>
							<br><input type="button" value=" 취소 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="history.back();">
						</span></font></p>
					</td>
				</tr>
			</table>
		</form>
		</span></font></p>
	</div>

</body>

</html>