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
$type = mysql_real_escape_string($_POST[type]);
$level_reason = mysql_real_escape_string($_POST[level_reason]);
$level_reason_text = mysql_real_escape_string($_POST[level_reason_text]);

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
  echo "<script>location.href='change_skill_1.php';</script>"; exit;
}

if($level_reason=="1") {
	$level_reason = $level_reason_text;
}

	  ////////////////////////////////////////////////////// 승인
	  
//$file_name = $vmember[no].".jpg";
//$delete = "../upload/lvcheck/$file_name";
//unlink($delete);
	  
	  if($type=="1") {

// 서브 지정
$character_num_name = "character_".$vmember[character_code]."_name";
$character_num_skill_1 = "character_".$vmember[character_code]."_skill_1";
$character_num_skill_2 = "character_".$vmember[character_code]."_skill_2";

mysql_query("update member set level_state='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set level_time='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set level_reason='0' where no='$vmember[no]'", $dbconn);

mysql_query("update member set $character_num_skill_1='$vmember[character_skill_1]' where no='$vmember[no]'", $dbconn);
mysql_query("update member set $character_num_skill_2='$vmember[character_skill_2]' where no='$vmember[no]'", $dbconn);

mysql_query("update member set character_mode='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_code='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_name='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_job='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_level='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_1='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_2='0' where no='$vmember[no]'", $dbconn);
mysql_query("update admin_log set $member[id]=$member[id]+1 where no='1'",$dbconn);
mysql_query("update admin_log set ok=ok+1 where no='1'",$dbconn);
	echo "<script>location.href='change_skill_1.php'</script>";

}
/////////////////////////////////////// 거부

if($type=="2") {
	

	
mysql_query("update member set level_state='2' where no='$vmember[no]'", $dbconn);
mysql_query("update member set level_time='$level_time' where no='$vmember[no]'", $dbconn);
mysql_query("update member set level_reason='$level_reason' where no='$vmember[no]'", $dbconn);

mysql_query("update member set character_code='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_name='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_job='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_level='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_1='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_2='0' where no='$vmember[no]'", $dbconn);
mysql_query("update admin_log set $member[id]=$member[id]+1 where no='1'",$dbconn);
mysql_query("update admin_log set cancel=cancel+1 where no='1'",$dbconn);
	echo "<script>location.href='change_skill_1.php'</script>";
	
}
?>
