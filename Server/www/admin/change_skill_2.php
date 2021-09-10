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
if($vmember[level_state]!="1" || $vmember[character_mode]!="3") {
  echo "<script>location.href='change_skill_1.php';</script>"; exit;
}

// 등급 명칭
if($vmember[character_level]=="2") {
$level = "Bronze";
} elseif($vmember[character_level]=="3") {
$level = "Silver";
} else {
$level = "Gold";
}

$character_name = "character_".$vmember[character_code]."_name";
if($vmember[character_code]!="1") {
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
											
										} else {
											
											if($vmember[character_skill_1]=="1") $character_skill_1 = "Herballsm";
											if($vmember[character_skill_1]=="2") $character_skill_1 = "Mining";
											if($vmember[character_skill_1]=="3") $character_skill_1 = "Skinning";
											if($vmember[character_skill_1]=="4") $character_skill_1 = "Alchemy";
											if($vmember[character_skill_1]=="5") $character_skill_1 = "Blacksmithing";
											if($vmember[character_skill_1]=="6") $character_skill_1 = "Engineering";
											if($vmember[character_skill_1]=="7") $character_skill_1 = "Leatherworking";
											if($vmember[character_skill_1]=="8") $character_skill_1 = "Tailoring";
											if($vmember[character_skill_1]=="9") $character_skill_1 = "Enchanting";
											if($vmember[character_skill_1]=="10") $character_skill_1 = "Jewelcrafting";
											if($vmember[character_skill_1]=="11") $character_skill_1 = "Inscription";
											if($vmember[character_skill_2]=="1") $character_skill_2 = "Herballsm";
											if($vmember[character_skill_2]=="2") $character_skill_2 = "Mining";
											if($vmember[character_skill_2]=="3") $character_skill_2 = "Skinning";
											if($vmember[character_skill_2]=="4") $character_skill_2 = "Alchemy";
											if($vmember[character_skill_2]=="5") $character_skill_2 = "Blacksmithing";
											if($vmember[character_skill_2]=="6") $character_skill_2 = "Engineering";
											if($vmember[character_skill_2]=="7") $character_skill_2 = "Leatherworking";
											if($vmember[character_skill_2]=="8") $character_skill_2 = "Tailoring";
											if($vmember[character_skill_2]=="9") $character_skill_2 = "Enchanting";
											if($vmember[character_skill_2]=="10") $character_skill_2 = "Jewelcrafting";
											if($vmember[character_skill_2]=="11") $character_skill_2 = "Inscription";

											
										}
	
// 작성 날짜
$time = date ("Y년 m월 d일 H시 i분", $vmember[level_time]);

$file_name = $vmember[no].".jpg";
$screen = "../upload/lvcheck/$file_name";

if($vmember[character_code]!="1") $main = "[".$vmember[character_1_name]."] ";
if($vmember[character_code]=="1") $main = "";

?>

<script>
	function check_1() {
		document.write.submit.disabled = false;
		document.write.level_reason.disabled = true;
		document.write.level_reason[0].selected=true;
	}
	function check_2() {
		document.write.submit.disabled = false;
		document.write.level_reason.disabled = false;
	}
	function check_3() {
		if(document.write.level_reason[10].selected) {
			document.write.level_reason.style.display='none';
			document.write.level_reason_text.style.display='';
		}
	}
</script>

<form name="write" target="_self" method="post" action="change_skill_3.php">
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td width="450" colspan="2" bgcolor="#521800"><span style="font-size:9pt;"><b><font color="white"><br>계정 정보<br></font></b></span></td>
        <td width="844" rowspan="13">
            <p align="left"><iframe src="http://armory.molten-wow.com/character-profile/<?=$vmember[$character_name]?>/Neltharion/" style="width:100%; height:100%;" width="100%" height="100%" vspace="0" hspace="0" marginwidth="0" marginheight="0" frameborder="0"></iframe></p>
        </td>
    </tr>
    <tr>
        <td width="100" bgcolor="#CF863E"><span style="font-size:9pt;"><b><font color="#441D01">닉네임</font></b></span></td>
        <td width="350">
            <p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim"><span style="font-size:9pt;"><br>
<?=$vmember[name_nick]?><br>
&nbsp;</span></font></p>
        </td>
    </tr>
    <tr>
        <td width="100" bgcolor="#CF863E"><span style="font-size:9pt;"><b><font color="#441D01">변경</font></b></span></td>
        <td width="350">
            <p style="margin-right:10pt; margin-left:10pt;"><span style="font-size:9pt;"><font face="Gulim"><br>

<b>전문기술 변경요청<br>
&nbsp;</b></font></span></p>
        </td>
    </tr>
    <tr>
        <td width="100" bgcolor="#CF863E"><span style="font-size:9pt;"><b><font color="#441D01">신청일</font></b></span></td>
        <td width="350">
            <p style="margin-right:10pt; margin-left:10pt;"><span style="font-size:9pt;"><font face="Gulim"><br>
<?=$time?><br>
&nbsp;</font></span></p>
        </td>
    </tr>
    <tr>
        <td width="450" colspan="2" bgcolor="#521800"><span style="font-size:9pt;"><b><font color="white"><br>캐릭터 정보<br></font></b></span></td>
    </tr>
    <tr>
        <td width="100" bgcolor="#CF863E"><span style="font-size:9pt;"><b><font color="#441D01">캐릭터 이름</font></b></span></td>
        <td width="350">
            <p style="margin-right:10pt; margin-left:10pt;"><span style="font-size:9pt;"><font face="Gulim"><br>
캐릭터 이름 : <b><?=$vmember[$character_name]?></b>
<input type="hidden" name="url" value="<?=$url?>"><input type="hidden" name="no" value="<?=$vmember[no]?>"><br>
&nbsp;</font></span></p>
        </td>
    </tr>
  
    <tr>
        <td width="100" bgcolor="#CF863E"><span style="font-size:9pt;"><b><font color="#441D01">변경할 전문기술</font></b></span></td>
        <td width="350">
            <p style="margin-right:10pt; margin-left:10pt;"><span style="font-size:9pt;"><font face="Gulim"><br>
<input type="text" readonly value="<?=$main?><?=$character_skill_1?> / <?=$character_skill_2?>" style="width:330px;"><br>
&nbsp;</font></span></p>
        </td>
    </tr>

    <tr>
        <td width="450" colspan="2" bgcolor="#521800"><span style="font-size:9pt;"><b><font color="white"><br>등업 처리<br></font></b></span></td>
    </tr>
    <tr>
        <td width="100" bgcolor="#CF863E"><span style="font-size:9pt;"><b><font color="#441D01">승인 여부</font></b></span></td>
        <td width="350">
            <p style="margin-right:10pt; margin-left:10pt;"><span style="font-size:9pt;"><font face="Gulim"><br>
<input type="radio" name="type" value="1" onclick="check_1();"> <font color="blue"><b>승인 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></font><input type="radio" name="type" value="2" onclick="check_2();"> <font color="red"><b>거부<br>
&nbsp;</b></font></font></span></p>
        </td>
    </tr>
    <tr>
        <td width="100" bgcolor="#CF863E"><span style="font-size:9pt;"><b><font color="#441D01">승인 안내</font></b></span></td>
        <td width="350">
            <p style="margin-right:10pt; margin-left:10pt;"><span style="font-size:9pt;"><font face="Gulim"><br>
전문 기술 변경 승인 전 체크사항<br>
<br>
1. 전문기술이 2개인지 확인<br>
2. 위에 표시된 전문기술과 스크린 샷과 동일한지&nbsp;확인<br>
<br>
</span><span style="font-size:9pt;">하나라도 불만족시 거부해 주시기 바랍니다.<br>
&nbsp;</span></font></p>
        </td>
    </tr>
    <tr>
        <td width="100" bgcolor="#CF863E"><span style="font-size:9pt;"><b><font color="#441D01">거부 사유</font></b></span></td>
        <td width="350">
            <p style="margin-right:10pt; margin-left:10pt;"><span style="font-size:9pt;"><font face="Gulim"><br>
<select name="level_reason" disabled size="1" onchange="check_3();">
                <option value="0">선택하세요.</option>
                <option value="인증 게시판에 스크린 샷을 올려주세요.">인증 게시판에 스크린 샷을 올려주세요.</option>
                <option value="전문기술 2개를 모두 배우지 않았습니다.">전문기술 2개를 모두 배우지 않았습니다.</option>
                <option value="전문기술이 신청해 주신 것과 다릅니다.">전문기술이 신청해 주신 것과 다릅니다.</option>
                <option value="해당 캐릭터가 서버에 존재하지 않습니다.">해당 캐릭터가 서버에 존재하지 않습니다.</option>
                <option value="해당 캐릭터가 길드에 가입되지 않았습니다.">해당 캐릭터가 길드에 가입되지 않았습니다.</option>
                <option value="해당 캐릭터의 레벨이 낮습니다.">해당 캐릭터의 레벨이 낮습니다.</option>
                <option value="해당 캐릭터의 업적 점수가 부족합니다.">해당 캐릭터의 업적 점수가 부족합니다.</option>
                <option value="전문기술 1개가 마스터가 아닙니다.">전문기술 1개가 마스터가 아닙니다.</option>
                <option value="전문기술 2개가 마스터가 아닙니다.">전문기술 2개가 마스터가 아닙니다.</option>
                <option value="1">직접 입력</option>
</select><input type="text" name="level_reason_text" style="display:none; width:330px;" maxlength="40"></font><br></span></p>
        </td>
    </tr>
    <tr>
        <td width="450" colspan="2">
            <p align="center"><br>
<input type="hidden" name="sno" value="<?=$sno?>"><font face='Gulim'><input type='submit' name='submit' value=" 확 인 " disabled style="font-family:'Gulim'; font-size:'9pt';">  </font> <font face='Gulim'><input type='button' name='cancel' value=" 취 소 " style="font-family:'Gulim'; font-size:'9pt';" onclick="location.href='change_skill_1.php';">
&nbsp;</font></p>
        </td>
    </tr>
</table>
</form>