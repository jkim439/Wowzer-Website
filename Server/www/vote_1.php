<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$admin = mysql_real_escape_string($_GET[admin]);

if($admin!="1230") {
// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');window.close();</script>"; exit;
}
}

/*
$ip = md5($_SERVER[REMOTE_ADDR]);
$time = md5(time());
$keycode4 = md5($time.$ip.$time);

$vote_check = mysql_query("select COUNT(*) FROM vote where no='$member[no]'",$dbconn);
$vote_check = mysql_result($vote_check, 0, "COUNT(*)");
if($vote_check=="0" && $admin!="1230"){
?>
<script>
	function check_button() {
		if(document.vote.key.value.length=="5") {
			if(document.vote.type[0].checked) {
				document.vote.submit.disabled=false;
			} else if(document.vote.type[1].checked) {
				document.vote.submit.disabled=false;
			} else {
				
			}
		} else {
			document.vote.submit.disabled=true;
		}
	}

	function check_submit() {
		if(document.vote.key.value.length<5) {
			alert(" 보안 코드를 올바르게 입력해 주십시오. ");
			return false;
		}
		if(document.vote.type[0].checked) {
			if(confirm(" 찬성하시겠습니까? ")) {
			} else {
				return false;
			}
		} else {
			if(confirm(" 반대하시겠습니까? ")) {
			} else {
				return false;
			}
		}
	}
</script>
<body onload="document.getElementById('key').focus();">
<form name="vote" target="_self" method="post" action="vote_2.php" onsubmit="return check_submit();">
<p style="margin-right:10pt; margin-left:10pt; line-height:16pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
<strong><span style="font-size:14pt;">골드팟 의견 투표</span></strong>
<br><br>
<strong>- 투표 대상 : </strong>Bronze 등급 이상의 계정 중 가입일이 2010년 12월 10일까지인 모든 계정<br>
<strong>- 투표 기간 : </strong>2010년 12월 11일 ~ 2010년 12월 18일 (8일간)<br>
<strong>- 투표 권한 : </strong>투표 대상에 해당하는 계정은 단 1표를 행사할 권한이 있음<br>
<strong>- 투표 결과 : </strong>투표 후 실시간으로 결과가 공개되며 유기명 투표임<br>
<font color="red"><strong>- 투표 보상 : </strong>투표한 계정에 대해 500 포인트 지급</font>
<br><br>
<table bgcolor="#FFFF99" width="800px;" height="100px;">
	<tr>
		<td>
			<p style="margin-right:10pt; margin-left:10pt; line-height:12pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
				<img src="key.php?keycode4=<?=$keycode4?>" align="absmiddle">&nbsp;&nbsp;&nbsp;
				<strong>보안 코드 : </strong><input type="text" name="key" id="key" onkeyup="check_button();" onblur="this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:60px; height:22px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="5">&nbsp;
				<input type="button" value=" 재시도 " onclick="if(confirm(' 입력한 내용이 모두 지워집니다. 계속하시겠습니까? ')){location.reload();} else return false;" style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;">
			</span></font></p>
		</td>
	</tr>
</table>
<br>
<table bgcolor="#C6E8FF" width="800px;" height="100px;" onclick="document.vote.type[0].checked=true; check_button();" style="cursor:pointer;">
	<tr>
		<td>
			<p style="margin-right:10pt; margin-left:10pt; line-height:12pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">

					<input type="radio" name="type" id="type_1" value="1" onclick="check_button();"> <strong><font color="blue">찬성</font></strong>
					<br><br>골드팟이 길드 내에서 진행되는 것을 찬성합니다.<br>골드팟에 대해 길드 창에 광고 모집이 공개적으로 허용됩니다.<br>골드팟 광고 모집을 통해 길드원끼리 모여서 가실 수 있습니다.<br>투표 이후 골드팟에 관해 서로 서로가 존중해 주셨으면 합니다.

			</span></font></p>
		</td>
	</tr>
</table>
<br>
<table bgcolor="#FFD9C0" width="800px;" height="100px;" onclick="document.vote.type[1].checked=true; check_button();" style="cursor:pointer;">
	<tr>
		<td>
			<p style="margin-right:10pt; margin-left:10pt; line-height:12pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">

					<input type="radio" name="type" id="type_2" value="2" onclick="check_button();"> <strong><font color="red">반대</font></strong>
					<br><br>골드팟이 길드 내에서 진행되는 것을 반대합니다.<br>골드팟에 대해 길드 창에 공개적으로 광고 모집을 하실 수 없지만,<br>가시고 싶은 분들끼리 개인적으로 진행해도 무방합니다.<br>투표 이후 골드팟에 관해 서로 서로가 존중해 주셨으면 합니다.

			</span></font></p>
		</td>
	</tr>
</table>
<br>
<input type="hidden" name="keycode4" value="<?=$keycode4?>"><input type="submit" name="submit" disabled value=" 투표 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;">
</span></font></p>
</form>
</body>
<?} else {
*/
// total
$total = mysql_query("select COUNT(*) FROM vote",$dbconn);
$total = mysql_result($total, 0, "COUNT(*)");

// ok
$ok = mysql_query("select COUNT(*) FROM vote where vote='1'",$dbconn);
$ok = mysql_result($ok, 0, "COUNT(*)");
$ok_percent = floor(($ok/$total)*100);
$result_1 = mysql_query("SELECT * FROM vote where vote='1' ORDER BY time", $dbconn);

// no
$no = mysql_query("select COUNT(*) FROM vote where vote='2'",$dbconn);
$no = mysql_result($no, 0, "COUNT(*)");
$no_percent = 100-$ok_percent;
$result_2 = mysql_query("SELECT * FROM vote where vote='2' ORDER BY time", $dbconn);

?>
<p style="margin-right:10pt; margin-left:10pt; line-height:16pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
<strong><span style="font-size:14pt;">골드팟 의견 투표 (결과)</span></strong>
<br><br>
<strong>- 투표 대상 : </strong>Bronze 등급 이상의 계정 중 가입일이 2010년 12월 10일까지인 모든 계정<br>
<strong>- 투표 기간 : </strong><font color="red">투표 종료</font><br>
<strong>- 투표 권한 : </strong>투표 대상에 해당하는 계정은 단 1표를 행사할 권한이 있음<br>
<strong>- 투표 결과 : </strong>투표 후 실시간으로 결과가 공개되며 유기명 투표임<br>
<font color="red"><strong>- 투표 보상 : </strong>투표한 계정에 대해 500 포인트 지급</font>
<br><br>
<table bgcolor="#FFFF99" width="800px;" height="20px;">
	<tr>
		<td>
			<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
				총 100%(<?=$total?>명)
			</span></font></p>
		</td>
	</tr>
</table>
<table width="800px;">
	<tr>
		<td bgcolor="#C6E8FF" width="<?=$ok_percent?>%;" heigth="20px;">
			<p align="center"><font face="Gulim" color="blue"><span style="font-size:9pt;">
				찬성 <?=$ok_percent?>%
			</span></font></p>
		</td>
		<td bgcolor="#FFD9C0" width="<?=$no_percent?>%;" heigth="20px;">
			<p align="center"><font face="Gulim" color="red"><span style="font-size:9pt;">
				반대 <?=$no_percent?>%
			</span></font></p>
		</td>
	</tr>
</table>
<table width="800px;">
	<tr>
		<td bgcolor="#C6E8FF" width="400px;" valign="top">
			<p style="margin-right:10pt; margin-left:10pt; line-height:12pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
				<label id="type_1">
					<br>
					<font color="blue">찬성</font> : <?=$ok?>명
					<br><br>
					<strike>골드팟이 길드 내에서 진행되는 것을 찬성합니다.<br>골드팟에 대해 길드 창에 광고 모집이 공개적으로 허용됩니다.<br>골드팟 광고 모집을 통해 길드원끼리 모여서 가실 수 있습니다.<br>투표 이후 골드팟에 관해 서로 서로가 존중해 주셨으면 합니다.</strike>
					<br><br>
					<?
					if($admin=="1230") {
					while($vote = mysql_fetch_array($result_1)) {
						$time = date("Y.m.d", $vote[time]);
						$member_vote = mysql_fetch_array(mysql_query("select * from member where no='$vote[no]'",$dbconn));
						$name = $member_vote[name_nick];
						//$name = mb_substr($member_vote[name_nick], 0, 2, 'UTF-8');
						//$name = $name."****";
						$character = mb_substr($member_vote[character_1_name], 0, 2, 'UTF-8');
						$character = $character."****";
					?>
					<?if($member[no]==$member_vote[no]){?><strong><?=$name?> (<?=$time?>) / <?=$character?></strong><?}?>
					<?if($member[no]!=$member_vote[no]){?><?=$name?> (<?=$time?>) / <?=$character?><?}?>
					<br>
					<?}}?><br>
			</span></font></p>
		</td>
		<td bgcolor="#FFD9C0" width="400px;" valign="top">
			<p style="margin-right:10pt; margin-left:10pt; line-height:12pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
				<label id="type_2">
					<br>
					<strong><font color="red">반대</font></strong> : <?=$no?>명
					<br><br>
					골드팟이 길드 내에서 진행되는 것을 반대합니다.<br>골드팟에 대해 길드 창에 공개적으로 광고 모집을 하실 수 없지만,<br>가시고 싶은 분들끼리 개인적으로 진행해도 무방합니다.<br>투표 이후 골드팟에 관해 서로 서로가 존중해 주셨으면 합니다.
					<br><br>
					<?
					if($admin=="1230") {
					while($vote = mysql_fetch_array($result_2)) {
						$time = date("Y.m.d", $vote[time]);
						$member_vote = mysql_fetch_array(mysql_query("select * from member where no='$vote[no]'",$dbconn));
						$name = $member_vote[name_nick];
						//$name = mb_substr($member_vote[name_nick], 0, 2, 'UTF-8');
						//$name = $name."****";
						$character = mb_substr($member_vote[character_1_name], 0, 2, 'UTF-8');
						$character = $character."****";
					?>
					<?if($member[no]==$member_vote[no]){?><strong><?=$name?> (<?=$time?>) / <?=$character?></strong><?}?>
					<?if($member[no]!=$member_vote[no]){?><?=$name?> (<?=$time?>) / <?=$character?><?}?>
					<br>
					<?}}?><br>
			</span></font></p>
		</td>
	</tr>
</table>
