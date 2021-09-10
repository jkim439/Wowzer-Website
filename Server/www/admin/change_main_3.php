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
$url = mysql_real_escape_string($_POST[url]);
$no = mysql_real_escape_string($_POST[no]);
$lv = mysql_real_escape_string($_POST[lv]);

// POST 전송여부 검사
if(getenv("REQUEST_METHOD") != "POST" ) {
  echo "<script>location.href='$site_403';</script>"; exit;
}
if(!eregi("$url",$_SERVER['HTTP_REFERER'])) {
  echo "<script>location.href='$site_403';</script>"; exit;
}

// 이전 페이지 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>location.href='$site_403';</script>"; exit;
}

// 현재 시간
$level_time = time();
$time = time();

// vmember 지정
$vmember = mysql_fetch_array(mysql_query("select * from member where no='$no'",$dbconn));

if($member[no] == $vmember[no]) {
	echo "<script>alert(' 자기 자신의 신청은 처리할 수 없습니다. ');history.back();</script>"; exit;
}

// 무단 접속 확인
if($vmember[level_state]!="1") {
  echo "<script>location.href='change_main_1.php';</script>"; exit;
}

if($level_reason=="1") {
	$level_reason = $level_reason_text;
}

	  ////////////////////////////////////////////////////// 승인

	  


// 새 메인 캐릭터 data 저장
$character_main_name = "character_".$vmember[character_code]."_name";
$character_main_job = "character_".$vmember[character_code]."_job";
$character_main_skill_1 = "character_".$vmember[character_code]."_skill_1";
$character_main_skill_2 = "character_".$vmember[character_code]."_skill_2";

// 기존 메인 캐릭터 data 저장
$character_sub_name = $vmember[character_1_name];
$character_sub_job = $vmember[character_1_job];
$character_sub_skill_1 = $vmember[character_1_skill_1];
$character_sub_skill_2 = $vmember[character_1_skill_2];


// 기존 메인 캐릭터 DB를 서브로 변경
mysql_query("update member set $character_main_name='$character_sub_name' where no='$vmember[no]'", $dbconn);
mysql_query("update member set $character_main_job='$character_sub_job' where no='$vmember[no]'", $dbconn);
mysql_query("update member set $character_main_skill_1='$character_sub_skill_1' where no='$vmember[no]'", $dbconn);
mysql_query("update member set $character_main_skill_2='$character_sub_skill_2' where no='$vmember[no]'", $dbconn);

// 새 메인 캐릭터 DB를 메인으로 복구
mysql_query("update member set character_1_name='$vmember[$character_main_name]' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_1_job='$vmember[$character_main_job]' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_1_skill_1='$vmember[$character_main_skill_1]' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_1_skill_2='$vmember[$character_main_skill_2]' where no='$vmember[no]'", $dbconn);




mysql_query("update member set level='$lv' where no='$vmember[no]'", $dbconn);
mysql_query("update member set level_state='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set level_time='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set level_reason='0' where no='$vmember[no]'", $dbconn);

mysql_query("update member set character_mode='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_code='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_name='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_job='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_level='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_1='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_2='0' where no='$vmember[no]'", $dbconn);

mysql_query("update admin_log set $member[id]=$member[id]+1 where no='1'",$dbconn);
mysql_query("update admin_log set ok=ok+1 where no='1'",$dbconn);

        echo "<script>alert(' 변경을 승인하였습니다. ');location.href='change_main_1.php'</script>";


?>
