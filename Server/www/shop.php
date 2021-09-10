<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');top.location.href='http://www.wowzer.kr/';</script>"; exit;
}

// 아바타 아이템
$avata_result = mysql_query("SELECT * FROM item WHERE ino=$member[avata]", $dbconn);
$avata_item = mysql_fetch_array($avata_result);

// 등급 명칭
if($member[level]=="1") {
	$level = "Copper";
} elseif($member[level]=="2") {
	$level = "Bronze";
} elseif($member[level]=="3") {
	$level = "Silver";
} elseif($member[level]=="4") {
	$level = "Gold";
} elseif($member[level]=="5") {
	$level = "Staff";
} else {
	$level = "Master";
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

<body background="http://akeetes430.cdn2.cafe24.com/shop_bg.gif" bgProperties="fixed" onload="java_check_shop();" onpropertychange="defence_check();" oncontextmenu="return false;" onunload="shop_reload();" style="overflow-x:hidden; overflow-y:hidden;">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

	<table id="layout_shop" border="0" cellspacing="0" cellpadding="0" style="display:none;">
		<tr>
			<td id="layout_shop_header" colspan="4"></td>
		</tr>
		<tr>
			<td id="layout_shop_blank_1" colspan="4"></td>
		</tr>
		<tr>
			<td id="layout_shop_blank_2"></td>
			<td id="layout_shop_meun">
				<p align="center">
					<br>
					<a href="shop_1.php" target="iframe"><img	src="http://akeetes430.cdn2.cafe24.com/shop_meun_1_1.png"	name="submeun_1" width="180" height="25" border="0"	OnMouseOut="submeun_1.src='http://akeetes430.cdn2.cafe24.com/shop_meun_1_1.png';"	OnMouseOver="submeun_1.src='http://akeetes430.cdn2.cafe24.com/shop_meun_1_2.png';" align="bottom" alt=""></a><br><br>
					<a href="shop_2.php" target="iframe"><img	src="http://akeetes430.cdn2.cafe24.com/shop_meun_2_1.png"	name="submeun_2" width="180" height="25" border="0"	OnMouseOut="submeun_2.src='http://akeetes430.cdn2.cafe24.com/shop_meun_2_1.png';"	OnMouseOver="submeun_2.src='http://akeetes430.cdn2.cafe24.com/shop_meun_2_2.png';" align="bottom" alt=""></a><br><br>
					<a href="shop_3.php" target="iframe"><img	src="http://akeetes430.cdn2.cafe24.com/shop_meun_3_1.png"	name="submeun_3" width="180" height="25" border="0"	OnMouseOut="submeun_3.src='http://akeetes430.cdn2.cafe24.com/shop_meun_3_1.png';"	OnMouseOver="submeun_3.src='http://akeetes430.cdn2.cafe24.com/shop_meun_3_2.png';" align="bottom" alt=""></a><br><br>
					<a href="shop_4.php" target="iframe"><img	src="http://akeetes430.cdn2.cafe24.com/shop_meun_4_1.png"	name="submeun_4" width="180" height="25" border="0"	OnMouseOut="submeun_4.src='http://akeetes430.cdn2.cafe24.com/shop_meun_4_1.png';"	OnMouseOver="submeun_4.src='http://akeetes430.cdn2.cafe24.com/shop_meun_4_2.png';" align="bottom" alt=""></a><br><br>
					<a href="shop_5.php" target="iframe"><img	src="http://akeetes430.cdn2.cafe24.com/shop_meun_5_1.png"	name="submeun_5" width="180" height="25" border="0"	OnMouseOut="submeun_5.src='http://akeetes430.cdn2.cafe24.com/shop_meun_5_1.png';"	OnMouseOver="submeun_5.src='http://akeetes430.cdn2.cafe24.com/shop_meun_5_2.png';" align="bottom" alt=""></a><br><br>
					<a href="shop_6.php" target="iframe"><img	src="http://akeetes430.cdn2.cafe24.com/shop_meun_6_1.png"	name="submeun_6" width="180" height="25" border="0"	OnMouseOut="submeun_6.src='http://akeetes430.cdn2.cafe24.com/shop_meun_6_1.png';"	OnMouseOver="submeun_6.src='http://akeetes430.cdn2.cafe24.com/shop_meun_6_2.png';" align="bottom" alt=""></a><br><br>
					<a href="shop_7.php" target="iframe"><img	src="http://akeetes430.cdn2.cafe24.com/shop_meun_7_1.png"	name="submeun_7" width="180" height="25" border="0"	OnMouseOut="submeun_7.src='http://akeetes430.cdn2.cafe24.com/shop_meun_7_1.png';"	OnMouseOver="submeun_7.src='http://akeetes430.cdn2.cafe24.com/shop_meun_7_2.png';" align="bottom" alt=""></a><br><br>
					<a href="shop_8.php" target="iframe"><img	src="http://akeetes430.cdn2.cafe24.com/shop_meun_8_1.png"	name="submeun_8" width="180" height="25" border="0"	OnMouseOut="submeun_8.src='http://akeetes430.cdn2.cafe24.com/shop_meun_8_1.png';"	OnMouseOver="submeun_8.src='http://akeetes430.cdn2.cafe24.com/shop_meun_8_2.png';" align="bottom" alt=""></a><br><br>
					<a href="shop_9.php" target="iframe"><img	src="http://akeetes430.cdn2.cafe24.com/shop_meun_9_1.png"	name="submeun_9" width="180" height="25" border="0"	OnMouseOut="submeun_9.src='http://akeetes430.cdn2.cafe24.com/shop_meun_9_1.png';"	OnMouseOver="submeun_9.src='http://akeetes430.cdn2.cafe24.com/shop_meun_9_2.png';" align="bottom" alt=""></a><br><br>
				</p>
			</td>
			<td id="layout_shop_body">
				<div id="layout_shop_body_div" style="width:560px; height:400px; background-image:url('http://akeetes430.cdn2.cafe24.com/shop_body.png');">
					<p align="center">
						<br><iframe name="iframe" src="shop_1.php" style="width:530px; height:370px;" frameborder="0" scrolling="yes"></iframe>
					</p>
				</div>
			</td>
			<td id="layout_shop_blank_2"></td>
		</tr>
		<tr>
			<td id="layout_shop_blank_1" colspan="4"></td>
		</tr>
		<tr>
			<td id="layout_shop_bottom" colspan="4">
				<?
					// 아바타 아이템 로드
					$avata_db = mysql_query("SELECT * FROM item WHERE ino=$member[avata]", $dbconn);
					$member_avata = mysql_fetch_array($avata_db);
				?>
				<!-- 아바타/계정 정보 전용 테이블 -->
				<table>
					<tr>
						<td style="width:70px;">
							<p style="margin-left:5pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
							<img src="http://akeetes430.cdn2.cafe24.com/<?=$member_avata[image]?>" align="left" alt="<?=$member_avata[name]?>" style="width:64px; height:64px; border-width:2pt; border-style:solid;<?if($member_avata[level]=="1"){?> border-color:rgb(255,255,255);<?}elseif($member_avata[level]=="2"){?> border-color:rgb(17,121,0);<?}elseif($member_avata[level]=="3"){?> border-color:rgb(0,72,255);<?}elseif($member_avata[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
						</td>
						<td style="width:730px;">
							<p style="margin-left:5pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<?if($member[title]=="0"){?>칭호가 없습니다.<?}else{?><?=$member[title]?><?}?><br>
								<?if($member[level]>4){?><img src="http://akeetes430.cdn2.cafe24.com/icon_admin.gif" align="absmiddle" style="width:20px; height:13px;" alt="운영진"> <?}elseif($member[level]=="4"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_gold.gif" align="absmiddle" style="width:20px; height:13px;" alt="골드"> <?}elseif($member[level]=="3"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_silver.gif" align="absmiddle" style="width:20px; height:13px;" alt="실버"> <?}?><strong><?=$member[name_nick]?></strong><br><br>
								<strong><?=$level?></strong> (<strong><?=$member[level]?></strong> 레벨)<br>
								<strong><?=$member[point]?></strong> 포인트
							</font></span></p>
						</td>
					</tr>
				</table>
				<!-- 아바타/계정 정보 전용 테이블 -->
			</td>
		</tr>
	</table>

</body>

</html>