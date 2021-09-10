<?

// 헤더파일 연결
include "../header.php";
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));

// 전역 변수
global $url;

// 회원 정보
if ($_SESSION[wowzer_key]) {

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

	// 아바타 아이템
	$avata_result = mysql_query("SELECT * FROM item WHERE ino=$member[avata]", $dbconn);
	$member_avata = mysql_fetch_array($avata_result);
	
	// 칭호 글자수 제한
	$title_length = mb_strlen($member[title], 'UTF-8');
	if($title_length>8) {
		$title_login = mb_substr($member[title], 0, 8, 'UTF-8');
		$title_login = $title_login.'...';
	} else {
		$title_login = $member[title];
	}

}

?>

<script	type="text/javascript">
	function loging() {
		document.login.id_input.style.padding='2px';
		document.login.id_input.style.border='1px solid #FF9900';
		document.login.pw_input.style.padding='2px';
		document.login.pw_input.style.border='1px solid #FF9900';
		document.login.id.value = document.login.id_input.value;
		document.login.pw.value = document.login.pw_input.value;
		document.login.id_input.disabled = true;
		document.login.pw_input.disabled = true;
		document.login.submit.disabled = true;
		document.login.submit.value = "인증 중";
		document.login.join.disabled = true;
		document.login.help.disabled = true;
	}
</script>

<? if(!$_SESSION[wowzer_key]) { ?>
<form name="login" target="_self" method="post" action="member_login.php" onsubmit="loging();">
	<table id="layout_logout" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td id="layout_logout_1" colspan="2"></td>
		</tr>
		<tr>
	  	<td id="layout_logout_2_1">
				<img src="http://akeetes430.cdn2.cafe24.com/box_login_id.png" width="55" height="25" align="middle" alt="">
			</td>
			<td id="layout_logout_2_2">
				&nbsp;<input type="text" name="id_input" id="id_input" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:104px; height:22px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="20" size="12">
			</td>
		</tr>
		<tr>
			<td id="layout_logout_3_1">
				<img src="http://akeetes430.cdn2.cafe24.com/box_login_pw.png" width="55" height="25" align="middle" alt="">
			</td>
			<td id="layout_logout_3_2">
				&nbsp;<input type="password" name="pw_input" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:104px; height:22px; padding:1px; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="20" size="12">
			</td>
		</tr>
		<tr>
			<td id="layout_logout_4" colspan="2"></td>
		</tr>
		<tr>
			<td id="layout_logout_5" colspan="2">
				<center><input type="hidden" name="url" value="<?=$url?>"><input type="hidden" name="id" value=""><input type="hidden" name="pw" value=""><input type="submit" name="submit" value=" 로그인 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"></center>
			</td>
		</tr>
		<tr>
			<td id="layout_logout_6" colspan="2">
			<center><input type="button" name="join" value=" 회원가입 " style=" width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="popup_join();">&nbsp;<input type="button" name="help" value=" 고객지원 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='help.php';"></center>
			</td>
		</tr>
		<tr>
			<td id="layout_logout_7" colspan="2"></td>
		</tr>
	</table>
</form>
<?}?>
<? if($_SESSION[wowzer_key]) { ?>
	<table id="layout_login" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td id="layout_login_1" colspan="2"></td>
		</tr>
		<tr>
	  	<td id="layout_login_2_1">
				<p align="right"><a href="member_1.php#bag" target="_self"><img align="middle" src="http://akeetes430.cdn2.cafe24.com/<?=$member_avata[image]?>" OnMouseOut="div_hide('tooltip_4');"	OnMouseOver="div_show('tooltip_4');" onmousemove="div_move(event, 'tooltip_4');" width="64" height="64"  style="border-width:2pt; border-style:solid;<?if($member_avata[level]=="1"){?> border-color:rgb(255,255,255);<?}else if($member_avata[level]=="2"){?> border-color:rgb(17,121,0);<?}else if($member_avata[level]=="3"){?> border-color:rgb(0,72,255);<?}else if($member_avata[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>"></a></p>
			</td>
			<td id="layout_login_2_2" style="cursor:pointer;" onclick="popup_profile('<?=urlencode($member[name_nick])?>');" OnMouseOut="div_hide('tooltip_5');"	OnMouseOver="div_show('tooltip_5');" onmousemove="div_move(event, 'tooltip_5');">
				<p style="margin-right:0pt; margin-left:5pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
					<?if($member[title]=="0"){?>칭호가 없습니다.<?}else{?><?=$title_login?><?}?><br>
					<?if($member[level]>4){?><img src="http://akeetes430.cdn2.cafe24.com/icon_admin.gif" align="absmiddle" style="width:20px; height:13px;"> <?}elseif($member[level]=="4"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_gold.gif" align="absmiddle" style="width:20px; height:13px;"> <?}elseif($member[level]=="3"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_silver.gif" align="absmiddle" style="width:20px; height:13px;"> <?}?><strong><?=$member[name_nick]?></strong><br><br>
					<strong><?=$level?></strong> (<strong><?=$member[level]?></strong> 레벨)<br>
					<strong><?=$member[point]?></strong> 포인트
					
													<div id="tooltip_4" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>자신의 아이템 가방을 보시려면 아바타를 클릭하세요.
									</span></font></p>
								</div>

								<div id="tooltip_5" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>유저 정보실에서 자신의 정보를 보시려면 클릭하세요.
									</span></font></p>
								</div>
				</span></font></p>
			</td>
		</tr>
		<tr>
			<td id="layout_login_3" colspan="2">
				<center><input type="button" value=" 로그아웃 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='member_logout.php';">&nbsp;<input type="button" value="마이 페이지" style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='member_1.php';"></center>
			</td>
		</tr>
		<tr>
			<td id="layout_login_4" colspan="2"></td>
		</tr>
	</table>
<?}?>