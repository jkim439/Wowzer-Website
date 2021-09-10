<?

// 헤더파일	연결
include	"../header.php";

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}
if(getenv("REQUEST_METHOD")!="POST") {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

// 변수 변환
$character_1_name = mysql_real_escape_string($_POST[character_1_name]);
$character_1_job = mysql_real_escape_string($_POST[character_1_job]);
$character_1_skill_1 = mysql_real_escape_string($_POST[character_1_skill_1]);
$character_1_skill_2 = mysql_real_escape_string($_POST[character_1_skill_2]);

// 현재 시간
$time = time();

// 등업 조건 확인
if($member[level]!="1" || $member[level_state]=="1") {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 이름 첫 글자 대문자
$character_1_name = ucwords($character_1_name);

// 캐릭터명 중복 신청 확인
$cha_chk = mysql_query("select COUNT(*) FROM member where character_name='$character_name' or character_1_name='$character_1_name' or character_2_name='$character_1_name' or character_3_name='$character_1_name' or character_4_name='$character_1_name' or character_5_name='$character_1_name' or character_6_name='$character_1_name' or character_7_name='$character_1_name' or character_8_name='$character_1_name' or character_9_name='$character_1_name'",$dbconn);
$cha_chk = mysql_result($cha_chk, 0, "COUNT(*)");
if($cha_chk!="0") {
	echo "<script>alert(' 입력하신 캐릭터 이름은 이미 등록되어 있습니다. \\n\\n 같은 캐릭터를 중복으로 등록할 수 없습니다. ');history.back();</script>"; exit;
}




mysql_query("update member set level_state='1' where no='$member[no]'", $dbconn);
mysql_query("update member set level_time='$time' where no='$member[no]'", $dbconn);
mysql_query("update member set character_mode='1' where no='$member[no]'", $dbconn);
mysql_query("update member set character_code='1' where no='$member[no]'", $dbconn);
mysql_query("update member set character_name='$character_1_name' where no='$member[no]'", $dbconn);
mysql_query("update member set character_job='$character_1_job' where no='$member[no]'", $dbconn);
mysql_query("update member set character_skill_1='$character_1_skill_1' where no='$member[no]'", $dbconn);
mysql_query("update member set character_skill_2='$character_1_skill_2' where no='$member[no]'", $dbconn);

echo "<script>alert(' 등업 신청을 완료하였습니다. \\n\\n 등업 신청은 평균 3일 이내에 처리됩니다. ');self.location.href='member_6.php'</script>";

?>