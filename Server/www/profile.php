<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);
$index = mysql_real_escape_string($_GET[index]);

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');window.close();</script>"; exit;
}

// 회원 정보 로드
$member_profile = mysql_fetch_array(mysql_query("SELECT * FROM member WHERE name_nick='$index'",$dbconn));

// 탈퇴 회원
if($member_profile[pw]=="0") {
	echo "<script>alert(' 삭제된 계정입니다. ');window.close();</script>"; exit;
}

// 탈퇴 회원
if($member_profile[no]=="1") {
	echo "<script>alert(' 삭제된 계정입니다. ');window.close();</script>"; exit;
}

// 아바타 아이템 로드
$member_profile_avata = mysql_fetch_array(mysql_query("SELECT * FROM item WHERE ino=$member_profile[avata]", $dbconn));

if(!$member_profile[no]) {
	echo "<script>alert(' 닉네임이 올바르지 않습니다. ');window.close();</script>"; exit;
}

// 등급 명칭
if($member_profile[level]=="1") {
	$member_profile_level = "Copper";
} elseif($member_profile[level]=="2") {
	$member_profile_level = "Bronze";
} elseif($member_profile[level]=="3") {
	$member_profile_level = "Silver";
} elseif($member_profile[level]=="4") {
	$member_profile_level = "Gold";
} elseif($member_profile[level]=="5") {
	$member_profile_level = "Staff";
} else {
	$member_profile_level = "Master";
}

$email=explode("@",$member_profile[email]); 
$email_id = mb_substr($email[0], 0, 5, 'UTF-8');
$email=$email_id."*****@".$email[1];

$ip=explode(".",$member_profile[login_ip]); 
$ip=$ip[0].".".$ip[1].".XXX.".$ip[3];

$join_date = date("Y년 m월 d일", $member_profile[join_date]);

// 아이템 갯수
$item_profile = array();
$item_num_profile=0;
$item_num_i_profile=1;
while($item_num_i_profile<=$site_item) {
	$item_i_profile = 'item_'.$item_num_i_profile;
	if($member_profile[$item_i_profile]=="0") {
		$item_num_i_profile++;
	} else {
		$item_list_profile[] = "$item_num_i_profile";
		$item_num_profile=$item_num_profile+1;
		$item_num_i_profile++;
	}
}

// 캐릭터 갯수
$character_num_profile=1;
while($character_num_profile<=9) {
	$character_i_profile = 'character_'.$character_num_profile.'_name';
	if(!$member_profile[$character_i_profile]) {
		break;
	} else {
		$character_num_profile++;
	}
}
$character_num_profile=$character_num_profile-1;

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

<body onload="java_check_profile();" onpropertychange="defence_check();" oncontextmenu="return false;" style="overflow-x:hidden; overflow-y:hidden;">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

	<table id="layout_profile" border="0" cellspacing="0" cellpadding="0" style="display:none;">
		<tr>
			<td id="layout_profile_header" colspan="2" style="background-image:url('http://akeetes430.cdn2.cafe24.com/profile_header_<?=$member_profile[level]?>.gif');">
				<table style="width:891px; height:106px;">
					<tr>
						<td style="width:108px; height:106px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<img src="http://akeetes430.cdn2.cafe24.com/<?=$member_profile_avata[image]?>" alt="<?=$member_profile_avata[name]?>" style="width:64px; height:64px; border-width:2pt; border-style:solid;<?if($member_profile_avata[level]=="1"){?> border-color:rgb(255,255,255);<?}elseif($member_profile_avata[level]=="2"){?> border-color:rgb(17,121,0);<?}elseif($member_profile_avata[level]=="3"){?> border-color:rgb(0,72,255);<?}elseif($member_profile_avata[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
								<br><br>
							</font></span></p>
						</td>
						<td style="width:583px; height:106px;">
							<strong><p style="margin-left:3pt; margin-right:0pt; font-family:Dotum;"><font face="Dotum" color="white"><span style="font-size:19pt; font-family:Dotum;">
								<?=$member_profile[name_nick]?>
							</font></span></p></strong>
							<p style="margin-left:0pt; margin-right:0pt;"><font face="Dotum" color="white"><span style="font-size:9pt;">
								<br><br><br><br>
							</font></span></p>
						</td>
						<td style="width:300px; height:106px;">
							<p style="margin-left:0pt; margin-right:10pt;" align="right"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<?if($member_profile[title]=="0"){?>칭호가 없습니다.<?}else{?><strong><?=$member_profile[title]?></strong><?}?><br><br><br><br>
							</font></span></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td id="layout_profile_body">
				<table style="width:891px; height:106px;">
					<tr>
						<td style="width:461px; height:106px;">
							<p style="margin-left:15pt; margin-right:0pt;"><font face="Gulim" color="#e6907b"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt="">
								<strong> 계정 정보 </strong><br><br></span></font></p>
							<p style="margin-left:15pt; margin-right:0pt;"><font face="Gulim" color="#e6907b"><span style="font-size:1pt;">
								____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________
							</span></font></p>
							<p style="margin-left:30pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<table style="width:461px;">
									<tr>
										<td	style="width:91px;>
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><br><strong>칭호</strong>
											</font></span></p>
										</td>
										<td	style="width:370px;">
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><br><?if($member_profile[title]=="0"){?>칭호가 없습니다.<?}else{?><?=$member_profile[title]?><?}?>
											</font></span></p>
										</td>
									</tr>
									<tr>
										<td	style="width:91px;>
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><strong>닉네임</strong>
											</font></span></p>
										</td>
										<td	style="width:370px;">
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><?=$member_profile[name_nick]?>
											</font></span></p>
										</td>
									</tr>
									<tr>
										<td	style="width:91px;>
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><strong>길드 등급</strong>
											</font></span></p>
										</td>
										<td	style="width:370px;">
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><?=$member_profile_level?> (<?=$member_profile[level]?> 레벨)
											</font></span></p>
										</td>
									</tr>
									<tr>
										<td	style="width:91px;>
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><strong>아이템 보유</strong>
											</font></span></p>
										</td>
										<td	style="width:370px;">
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><?=$item_num_profile?>개
											</font></span></p>
										</td>
									</tr>
									<tr>
										<td	style="width:91px;>
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><strong>캐릭터 보유</strong>
											</font></span></p>
										</td>
										<td	style="width:370px;">
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><?=$character_num_profile?>개
											</font></span></p>
										</td>
									</tr>
									<tr>
										<td	style="width:91px;>
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><strong>이메일</strong>
											</font></span></p>
										</td>
										<td	style="width:370px;">
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><?=$email?>
											</font></span></p>
										</td>
									</tr>
									<tr>
										<td	style="width:91px;>
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><strong>IP주소</strong>
											</font></span></p>
										</td>
										<td	style="width:370px;">
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><?=$ip?>
											</font></span></p>
										</td>
									</tr>
									<tr>
										<td	style="width:91px;>
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><strong>가입일</strong>
											</font></span></p>
										</td>
										<td	style="width:370px;">
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><?=$join_date?>
											</font></span></p>
										</td>
									</tr>
									<tr>
										<td	style="width:91px;>
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><strong>자기 소개</strong>
											</font></span></p>
										</td>
										<td	style="width:370px;">
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><textarea name="text" rows="4" onfocus="this.blur();" style="width:327px; height:61px; padding:1px; font-family:Gulim; font-size:9pt; color:rgb(0,0,0); border-width:2pt; border-color:rgb(255,153,0); border-style:solid;" readonly><?=$member_profile[memo]?></textarea>
											</font></span></p>
										</td>
									</tr>
								</table>
							</font></span></p>
						</td>
						<td style="width:430px; height:106px;">
							
							<p style="margin-left:15pt; margin-right:0pt;"><font face="Gulim" color="#e6907b"><span style="font-size:9pt;"><img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt="">
								<strong> 캐릭터 정보 </strong><br><br></span></font></p>
							<p style="margin-left:15pt; margin-right:0pt;"><font face="Gulim" color="#e6907b"><span style="font-size:1pt;">
								_________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________
							</span></font></p>
							<p style="margin-left:30pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<table style="width:430px;">
									<?
										$j=1;
										for($i=1;$i<10;$i++) {

											// 반복 변수 변환
											$character_name = 'character_'.$j.'_name';
											$character_job = 'character_'.$j.'_job';
											$character_skill_1 = 'character_'.$j.'_skill_1';
											$character_skill_2 = 'character_'.$j.'_skill_2';

											// 직업 명칭
											if($member_profile[$character_job]=="1") $character_job = "죽음의 기사";
											if($member_profile[$character_job]=="2") $character_job = "전사";
											if($member_profile[$character_job]=="3") $character_job = "도적";
											if($member_profile[$character_job]=="4") $character_job = "사냥꾼";
											if($member_profile[$character_job]=="5") $character_job = "마법사";
											if($member_profile[$character_job]=="6") $character_job = "흑마법사";
											if($member_profile[$character_job]=="7") $character_job = "사제";
											if($member_profile[$character_job]=="8") $character_job = "성기사";
											if($member_profile[$character_job]=="9") $character_job = "주술사";
											if($member_profile[$character_job]=="10") $character_job = "드루이드";

											// 전문기술 명칭
											if($member_profile[$character_skill_1]=="1") $character_skill_1 = "약초채집";
											if($member_profile[$character_skill_1]=="2") $character_skill_1 = "채광";
											if($member_profile[$character_skill_1]=="3") $character_skill_1 = "무두질";
											if($member_profile[$character_skill_1]=="4") $character_skill_1 = "연금술";
											if($member_profile[$character_skill_1]=="5") $character_skill_1 = "대장기술";
											if($member_profile[$character_skill_1]=="6") $character_skill_1 = "기계공학";
											if($member_profile[$character_skill_1]=="7") $character_skill_1 = "가죽세공";
											if($member_profile[$character_skill_1]=="8") $character_skill_1 = "재봉술";
											if($member_profile[$character_skill_1]=="9") $character_skill_1 = "마법부여";
											if($member_profile[$character_skill_1]=="10") $character_skill_1 = "보석세공";
											if($member_profile[$character_skill_1]=="11") $character_skill_1 = "주문각인";
											if($member_profile[$character_skill_2]=="1") $character_skill_2 = "약초채집";
											if($member_profile[$character_skill_2]=="2") $character_skill_2 = "채광";
											if($member_profile[$character_skill_2]=="3") $character_skill_2 = "무두질";
											if($member_profile[$character_skill_2]=="4") $character_skill_2 = "연금술";
											if($member_profile[$character_skill_2]=="5") $character_skill_2 = "대장기술";
											if($member_profile[$character_skill_2]=="6") $character_skill_2 = "기계공학";
											if($member_profile[$character_skill_2]=="7") $character_skill_2 = "가죽세공";
											if($member_profile[$character_skill_2]=="8") $character_skill_2 = "재봉술";
											if($member_profile[$character_skill_2]=="9") $character_skill_2 = "마법부여";
											if($member_profile[$character_skill_2]=="10") $character_skill_2 = "보석세공";
											if($member_profile[$character_skill_2]=="11") $character_skill_2 = "주문각인";
											
											$character_name_num = mb_strlen($member_profile[$character_name], 'UTF-8');
											if($character_name_num>6) {
												$character_name_cut = mb_substr($member_profile[$character_name], 0, 6, 'UTF-8');
												$character_name_cut = $character_name_cut.'...';
											} else {
												$character_name_cut = $member_profile[$character_name];
											}
									?>
									<tr>
										<td	style="width:151px;" title="<?if($member_profile[$character_name]!="0"){?><?=$member_profile[$character_name]?><?}else{?>미등록<?}?>">
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><?if($member_profile[$character_name]!="0"){?><strong><?=$character_name_cut?></strong> (<?=$character_job?>)<?}else{?>미등록<?}?>
											</font></span></p>
										</td>
										<td	style="width:279px;" title="<?if($member_profile[$character_name]!="0"){?><?=$member_profile[$character_name]?><?}else{?>미등록<?}?>">
											<p style="margin-left:0pt; margin-right:0pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><?if($member_profile[$character_name]!="0"){?><?=$character_skill_1?> / <?=$character_skill_2?>&nbsp;&nbsp;<a href="#" onclick="window.open('http://armory.molten-wow.com/character-profile/<?=$member_profile[$character_name]?>/Neltharion/');"><font color="#00fffc">[자세히]</font></a><?}else{?><?}?>
											</font></span></p>
										</td>
									</tr>
								<?
								$j++;
								}?>
									<tr>
										<td	style="width:151px;"></td>
										<td	style="width:279px;">
											<p style="margin-left:0pt; margin-right:10pt;" align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
											<br><br><br><input type="button" value=" 닫기 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="window.close();">
											</font></span></p>
										</td>
									</tr>
							</font></span></p>
							
						</td>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>