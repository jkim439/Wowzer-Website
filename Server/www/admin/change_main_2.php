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
if($vmember[level_state]!="1" || $vmember[character_mode]!="4") {
  echo "<script>location.href='change_main_1.php';</script>"; exit;
}

$character_name = "character_".$vmember[character_code]."_name";

// 작성 날짜
$time = date ("Y년 m월 d일 H시 i분", $vmember[level_time]);


											// main전문기술 명칭
											$character_db_skill_1 = "character_".$vmember[character_code]."_skill_1";
											$character_db_skill_2 = "character_".$vmember[character_code]."_skill_2";
											if($vmember[$character_db_skill_1]=="1") $character_skill_1 = "Herballsm";
											if($vmember[$character_db_skill_1]=="2") $character_skill_1 = "Mining";
											if($vmember[$character_db_skill_1]=="3") $character_skill_1 = "Skinning";
											if($vmember[$character_db_skill_1]=="4") $character_skill_1 = "Alchemy";
											if($vmember[$character_db_skill_1]=="5") $character_skill_1 = "Blacksmithing";
											if($vmember[$character_db_skill_1]=="6") $character_skill_1 = "Engineering";
											if($vmember[$character_db_skill_1]=="7") $character_skill_1 = "Leatherworking";
											if($vmember[$character_db_skill_1]=="8") $character_skill_1 = "Tailoring";
											if($vmember[$character_db_skill_1]=="9") $character_skill_1 = "Enchanting";
											if($vmember[$character_db_skill_1]=="10") $character_skill_1 = "Jewelcrafting";
											if($vmember[$character_db_skill_1]=="11") $character_skill_1 = "Inscription";
											if($vmember[$character_db_skill_2]=="1") $character_skill_2 = "Herballsm";
											if($vmember[$character_db_skill_2]=="2") $character_skill_2 = "Mining";
											if($vmember[$character_db_skill_2]=="3") $character_skill_2 = "Skinning";
											if($vmember[$character_db_skill_2]=="4") $character_skill_2 = "Alchemy";
											if($vmember[$character_db_skill_2]=="5") $character_skill_2 = "Blacksmithing";
											if($vmember[$character_db_skill_2]=="6") $character_skill_2 = "Engineering";
											if($vmember[$character_db_skill_2]=="7") $character_skill_2 = "Leatherworking";
											if($vmember[$character_db_skill_2]=="8") $character_skill_2 = "Tailoring";
											if($vmember[$character_db_skill_2]=="9") $character_skill_2 = "Enchanting";
											if($vmember[$character_db_skill_2]=="10") $character_skill_2 = "Jewelcrafting";
											if($vmember[$character_db_skill_2]=="11") $character_skill_2 = "Inscription";




											// sub 전문기술 명칭
											if($vmember[character_1_skill_1]=="1") $character_sub_skill_1 = "Herbal";
											if($vmember[character_1_skill_1]=="2") $character_sub_skill_1 = "Mine";
											if($vmember[character_1_skill_1]=="3") $character_sub_skill_1 = "Skin";
											if($vmember[character_1_skill_1]=="4") $character_sub_skill_1 = "Alchemy";
											if($vmember[character_1_skill_1]=="5") $character_sub_skill_1 = "Black";
											if($vmember[character_1_skill_1]=="6") $character_sub_skill_1 = "Engineer";
											if($vmember[character_1_skill_1]=="7") $character_sub_skill_1 = "Leather";
											if($vmember[character_1_skill_1]=="8") $character_sub_skill_1 = "Tailor";
											if($vmember[character_1_skill_1]=="9") $character_sub_skill_1 = "Enchant";
											if($vmember[character_1_skill_1]=="10") $character_sub_skill_1 = "Jewelcraft";
											if($vmember[character_1_skill_1]=="11") $character_sub_skill_1 = "Inscript";
											if($vmember[character_1_skill_2]=="1") $character_sub_skill_2 = "Herbal";
											if($vmember[character_1_skill_2]=="2") $character_sub_skill_2 = "Mine";
											if($vmember[character_1_skill_2]=="3") $character_sub_skill_2 = "Skin";
											if($vmember[character_1_skill_2]=="4") $character_sub_skill_2 = "Alchemy";
											if($vmember[character_1_skill_2]=="5") $character_sub_skill_2 = "Black";
											if($vmember[character_1_skill_2]=="6") $character_sub_skill_2 = "Engineer";
											if($vmember[character_1_skill_2]=="7") $character_sub_skill_2 = "Leather";
											if($vmember[character_1_skill_2]=="8") $character_sub_skill_2 = "Tailor";
											if($vmember[character_1_skill_2]=="9") $character_sub_skill_2 = "Enchant";
											if($vmember[character_1_skill_2]=="10") $character_sub_skill_2 = "Jewelcraft";
											if($vmember[character_1_skill_2]=="11") $character_sub_skill_2 = "Inscript";

?>

<script>
	function check_1() {
		if(document.write.type.checked) {
			if(!document.write.lv[0].selected) {
				document.write.submit.disabled = false;
			} else {
				document.write.submit.disabled = true;
			} 
			} else {
				document.write.submit.disabled = true;
		}
	}
</script>

<form name="write" target="_self" method="post" action="change_main_3.php">
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td width="450" colspan="2" bgcolor="#521800"><span style="font-size:9pt;"><b><font color="white"><br>계정 정보<br></font></b></span></td>
        <td width="844" rowspan="13">
            
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

<b>메인 캐릭터 변경요청<br>
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
        <td width="100" bgcolor="#CF863E"><span style="font-size:9pt;"><b><font color="#441D01">메인 캐릭터 변경</font></b></span></td>
        <td width="350">
            <p style="margin-right:10pt; margin-left:10pt;"><span style="font-size:9pt;"><font face="Gulim"><br>
<?=$vmember[character_1_name]?></strong>에서 <strong><?=$vmember[$character_name]?></strong>(으)로 메인 캐릭터 변경 요청
<input type="hidden" name="url" value="<?=$url?>"><input type="hidden" name="no" value="<?=$vmember[no]?>"><br>
&nbsp;</font></span></p>
        </td>
    </tr>
    <tr>
        <td width="100" bgcolor="#CF863E"><span style="font-size:9pt;"><b><font color="#441D01">전문기술</font></b></span></td>
        <td width="350">
            <p style="margin-right:10pt; margin-left:10pt;"><span style="font-size:9pt;"><font face="Gulim"><br>
            		<strong><?=$vmember[$character_name]?></strong> 캐릭터 길드 쪽지에 아래 내용을 붙여넣기 하세요.<br>
<input type="text" readonly value="<?=$character_skill_1?> / <?=$character_skill_2?>" style="width:330px;"><br>
&nbsp;</font></span></p>
        </td>
    </tr>
  
    <tr>
        <td width="100" bgcolor="#CF863E"><span style="font-size:9pt;"><b><font color="#441D01">전문기술</font></b></span></td>
        <td width="350">
            <p style="margin-right:10pt; margin-left:10pt;"><span style="font-size:9pt;"><font face="Gulim"><br>
            	<strong><?=$vmember[character_1_name]?></strong> 캐릭터 길드 쪽지에 아래 내용을 붙여넣기 하세요.<br>
<input type="text" readonly value="[<?=$vmember[$character_name]?>] <?=$character_sub_skill_1?> / <?=$character_sub_skill_2?>" style="width:330px;"><br>
&nbsp;</font></span></p>
        </td>
    </tr>
    <tr>
        <td width="100" bgcolor="#CF863E"><span style="font-size:9pt;"><b><font color="#441D01">등급 선택</font></b></span></td>
        <td width="350">
            <p style="margin-right:10pt; margin-left:10pt;"><span style="font-size:9pt;"><font face="Gulim">
            	<br><strong><?=$vmember[$character_name]?></strong> 캐릭터의 길드 등급을 선택하세요.<br><font color="red">경고: <?=$vmember[character_1_name]?>의 등급이 아닙니다!</font><br><br>
<select name="lv" onchange="check_1();">
                <option value="0">선택하세요.</option>
                <option value="2">Bronze</option><?if($vmember[level]>2){?>
              <option value="3">Silver</option><?}?><?if($vmember[level]>3){?>
              <option value="4">Gold</option><?}?></select><br><br>
            	</font></span></p>
        </td>
    </tr>

    <tr>
        <td width="450" colspan="2" bgcolor="#521800"><span style="font-size:9pt;"><b><font color="white"><br>등업 처리<br></font></b></span></td>
    </tr>
    <tr>
        <td width="100" bgcolor="#CF863E"><span style="font-size:9pt;"><b><font color="#441D01">승인 여부</font></b></span></td>
        <td width="350">
            <p style="margin-right:10pt; margin-left:10pt;"><span style="font-size:9pt;"><font face="Gulim"><br>
<input type="checkbox" name="type" value="1" onclick="check_1();"> <font color="blue"><b>승인</b></font><br>
&nbsp;</b></font></font></span></p>
        </td>
    </tr>
    <tr>
        <td width="450" colspan="2">
            <p align="center"><br>
<input type="hidden" name="sno" value="<?=$sno?>"><font face='Gulim'><input type='submit' name='submit' value=" 확 인 " disabled style="font-family:'Gulim'; font-size:'9pt';">  </font> <font face='Gulim'><input type='button' name='cancel' value=" 취 소 " style="font-family:'Gulim'; font-size:'9pt';" onclick="location.href='change_main_1.php';">
&nbsp;</font></p>
        </td>
    </tr>
</table>
</form>