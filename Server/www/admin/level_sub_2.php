<?

// 헤더파일 연결
include "../../header.php";


// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

if($member[level]<5) {
	session_destroy();
  echo "<script>location.href='error_403.php';</script>"; exit;
}

// 변수 변환
$vno = mysql_real_escape_string($_GET[no]);
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);

// vmember 지정
$vmember = mysql_fetch_array(mysql_query("select * from member where no='$vno'",$dbconn));

// 무단 접속 확인
if($vmember[level_state]!="1" || $vmember[character_mode]!="2") {
  echo "<script>location.href='level_sub_1.php';</script>"; exit;
}

// 등급 명칭
if($vmember[character_level]=="2") {
$level = "Bronze";
} elseif($vmember[character_level]=="3") {
$level = "Silver";
} else {
$level = "Gold";
}


if($vmember[character_level]=="2"){

$character_name = $vmember[character_name];
											// 전문기술 명칭
											if($vmember[character_skill_1]=="1") $character_skill_1 = "Herbal";
											if($vmember[character_skill_1]=="2") $character_skill_1 = "Mine";
											if($vmember[character_skill_1]=="3") $character_skill_1 = "Skin";
											if($vmember[character_skill_1]=="4") $character_skill_1 = "Alchemy";
											if($vmember[character_skill_1]=="5") $character_skill_1 = "Black";
											if($vmember[character_skill_1]=="6") $character_skill_1 = "Engineer";
											if($vmember[character_skill_1]=="7") $character_skill_1 = "Leather";
											if($vmember[character_skill_1]=="8") $character_skill_1 = "Tailor";
											if($vmember[character_skill_1]=="9") $character_skill_1 = "Enchant";
											if($vmember[character_skill_1]=="10") $character_skill_1 = "Jewelcraft";
											if($vmember[character_skill_1]=="11") $character_skill_1 = "Inscript";
											if($vmember[character_skill_2]=="1") $character_skill_2 = "Herbal";
											if($vmember[character_skill_2]=="2") $character_skill_2 = "Mine";
											if($vmember[character_skill_2]=="3") $character_skill_2 = "Skin";
											if($vmember[character_skill_2]=="4") $character_skill_2 = "Alchemy";
											if($vmember[character_skill_2]=="5") $character_skill_2 = "Black";
											if($vmember[character_skill_2]=="6") $character_skill_2 = "Engineer";
											if($vmember[character_skill_2]=="7") $character_skill_2 = "Leather";
											if($vmember[character_skill_2]=="8") $character_skill_2 = "Tailor";
											if($vmember[character_skill_2]=="9") $character_skill_2 = "Enchant";
											if($vmember[character_skill_2]=="10") $character_skill_2 = "Jewelcraft";
											if($vmember[character_skill_2]=="11") $character_skill_2 = "Inscript";
											if($vmember[character_job]=="1") $character_job = "죽음의 기사";
											if($vmember[character_job]=="2") $character_job = "전사";
											if($vmember[character_job]=="3") $character_job = "도적";
											if($vmember[character_job]=="4") $character_job = "사냥꾼";
											if($vmember[character_job]=="5") $character_job = "마법사";
											if($vmember[character_job]=="6") $character_job = "흑마법사";
											if($vmember[character_job]=="7") $character_job = "사제";
											if($vmember[character_job]=="8") $character_job = "성기사";
											if($vmember[character_job]=="9") $character_job = "주술사";
											if($vmember[character_job]=="10") $character_job = "드루이드";
											
} else {
$character_name = "character_".$vmember[character_code]."_name";

}
// 작성 날짜
$time = date ("Y년 m월 d일 H시 i분", $vmember[level_time]);

$file_name = $vmember[no].".jpg";
$screen = "../upload/lvcheck/$file_name";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html	lang="ko">

<head>

	<title><?	echo site_title; ?> (관리자)</title>
	<meta	http-equiv="content-type"	content="text/html;	charset=utf-8">
	<meta	http-equiv="Cache-Control" content="no-cache">
	<meta	http-equiv="Pragma"	content="no-cache">
	<meta	http-equiv="imagetoolbar"	content="no">
	<script	type="text/javascript" src="inc_script_admin.js"></script>

</head>

<body onload="screen();">
	<center>
	<form name="admin" target="_self" method="post" action="level_sub_3.php">
	<table cellpadding="0" cellspacing="0" style="width:100%; height:100%;">
		<tr>
			<td colspan="2" style="width:400px; height:35px; background-image:url('http://akeetes430.cdn2.cafe24.com/title.jpg');">
				<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
					<strong>계정 정보</strong>
				</span></font></p>
			</td>
			<td rowspan="13" style="height:100%;">
				<p align="left">
						<?if($vmember[character_level]=="2"){?><iframe src="http://armory.molten-wow.com/character-profile/<?=$character_name?>/Neltharion/" style="width:100%; height:100%;" vspace="0" hspace="0" marginwidth="0" marginheight="0" frameborder="0"><?}else{?><iframe src="http://armory.molten-wow.com/character-profile/<?=$vmember[$character_name]?>/Neltharion/" style="width:100%; height:100%;" vspace="0" hspace="0" marginwidth="0" marginheight="0" frameborder="0"><?}?></iframe>
				</p>
			</td>
		</tr>
		<tr>
			<td style="width:100px; height:40px; background-color:rgb(217,101,0);">
				<p align="center"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
					<strong>닉네임</strong>
				</span></font></p>
			</td>
			<td style="width:300px; height:40px;">
				<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<?=$vmember[name_nick]?>
				</span></font></p>
			</td>
    </tr>
		<tr>
			<td style="width:100px; height:40px; background-color:rgb(217,101,0);">
				<p align="center"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
					<strong>신청 시간</strong>
				</span></font></p>
			</td>
			<td style="width:300px; height:40px;">
				<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<?=$time?>
				</span></font></p>
			</td>
    </tr>
		<tr>
			<td colspan="2" style="width:400px; height:35px; background-image:url('http://akeetes430.cdn2.cafe24.com/title.jpg');">
				<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
					<strong>신청 정보</strong>
				</span></font></p>
			</td>
		</tr>
		<tr>
			<td style="width:100px; height:50px; background-color:rgb(217,101,0);">
				<p align="center"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
					<strong>캐릭터 이름<br>(서브)</strong>
				</span></font></p>
			</td>
			<td style="width:300px; height:50px;">
				<p style="margin-right:10pt; margin-left:10pt; font-family:Arial;"><font face="Arial" color="black"><span style="font-size:24pt; font-family:Arial;">
					<?if($vmember[character_level]=="2"){?><?=$character_name?><?}else{?><?=$vmember[$character_name]?><?}?>
				</span></font></p>
			</td>
    </tr>
		<tr>
			<td style="width:100px; height:40px; background-color:rgb(217,101,0);">
				<p align="center"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
					<strong>신청 등급</strong>
				</span></font></p>
			</td>
			<td style="width:300px; height:40px;">
				<p style="margin-right:10pt; margin-left:10pt; font-family:Arial;"><font face="Arial" color="black"><span style="font-size:12pt; font-family:Arial;">
					<?if($vmember[character_level]=="4"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_gold.gif" align="absmiddle" style="width:20px; height:13px;"> Gold<?}elseif($vmember[character_level]=="3"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_silver.gif" align="absmiddle" style="width:20px; height:13px;"> Silver<?}else{?>Bronze<?}?>
				</span></font></p>
			</td>
    </tr>
		<?if($vmember[character_level]=="2"){?><tr>
			<td style="width:100px; height:70px; background-color:rgb(217,101,0);">
				<p align="center"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
					<strong>전문 기술</strong>
				</span></font></p>
			</td>
			<td style="width:300px; height:70px;">
				<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="red"><span style="font-size:9pt;">
					복사해서 <?=$character_name?>의 길드 쪽지에 그대로 붙여넣어 주십시오.<br><br>
					<input type="text" id="skill" value="[<?=$vmember[character_1_name]?>] <?=$character_skill_1?> / <?=$character_skill_2?>" readonly style="width:230px; height:23px font-size:10pt; font-family:Arial;"> <input type="button" value="복사" style="width:40px; height:23px; font-family:'Gulim'; font-weight:bold; font-size:9pt;" onclick="copy();">
				</span></font></p>
			</td>
    </tr><?}?>
		<tr>
			<td colspan="2" style="width:400px; height:35px; background-image:url('http://akeetes430.cdn2.cafe24.com/title.jpg');">
				<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
					<strong>등업 처리</strong>
				</span></font></p>
			</td>
		</tr>
		<tr>
			<td style="width:100px; height:40px; background-color:rgb(217,101,0);">
				<p align="center"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
					<strong>승인 여부</strong>
				</span></font></p>
			</td>
			<td style="width:300px; height:40px;">
				<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
					<input type="radio" name="type" value="1" onclick="ok();"> <font color="blue"><b>승인</b> 
					<?if($vmember[character_level]=="2"){?><a href="javascript:alert(' Bronze 등업 조건 \n\n 1. 레벨 20 이상 \n 2. ES 길드 가입 \n 3. 전문 기술 2개 배웠는지 \n 4. 신청 정보와 실제 정보가 맞는지 \n\n 자세한 내용은 [도움] 버튼을 클릭하시기 바랍니다. ');">[승인 전 필독]</a></font><?}?>
					<?if($vmember[character_level]=="3"){?><a href="javascript:alert(' Silver 등업 조건 \n\n 1. 업적 점수 800점 이상 \n 2. 전문 기술 1개 만숙련(마스터) \n\n 자세한 내용은 [도움] 버튼을 클릭하시기 바랍니다. ');">[승인 전 필독]</a></font><?}?>
					<?if($vmember[character_level]=="4"){?><a href="javascript:alert(' Gold 등업 조건 \n\n 1. 업적 점수 1600점 이상 \n 2. 전문 기술 2개 만숙련(마스터) \n\n 자세한 내용은 [도움] 버튼을 클릭하시기 바랍니다. ');">[승인 전 필독]</a></font><?}?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="type" value="2" onclick="document.admin.submit.disabled = false;document.admin.level_reason.disabled = false;"> <font color="red"><b>거부</b></font>
				</span></font></p>
			</td>
    </tr>
		<tr>
			<td style="width:100px; height:40px; background-color:rgb(217,101,0);">
				<p align="center"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
					<strong>거부 사유</strong>
				</span></font></p>
			</td>
			<td style="width:300px; height:40px;">
				<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
					<select name="level_reason" disabled size="1" style="width:280px;">
						<? include "inc_list_1.php"; ?>
					</select><input type="text" name="level_reason_text" style="display:none; width:280px;" maxlength="40">
				</span></font></p>
			</td>
    </tr>
		<tr>
			<td colspan="2" style="width:400px; height:35px;">
				<p align="center">
					<input type="hidden" name="sno" value="<?=$sno?>"><input type="hidden" name="url" value="<?=$url?>"><input type="hidden" name="no" value="<?=$vmember[no]?>"><input type="submit" name="submit" value=" 확인 " disabled style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"> <input type="button" value=" 취소 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="location.href='level_sub_1.php';"> <input type="button" value=" 도움 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="helper('main_<?=$vmember[character_level]-1?>.jpg');">
				</p>
			</td>
    </tr>
    <tr>
        <td colspan="2" style="width:400px;"></td>
    </tr>
	</table>
	</form>
	</center>
</body>
</html>