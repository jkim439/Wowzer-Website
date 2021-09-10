<?

// 헤더파일	연결
include	"../header.php";

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}
if($level_time_after<172800) {
mysql_query("update member set level_state='0' where no='$member[no]'", $dbconn);
mysql_query("update member set level_time='0' where no='$member[no]'", $dbconn);
mysql_query("update member set character_mode='0' where no='$member[no]'", $dbconn);
mysql_query("update member set character_code='0' where no='$member[no]'", $dbconn);
mysql_query("update member set character_name='0' where no='$member[no]'", $dbconn);
mysql_query("update member set character_job='0' where no='$member[no]'", $dbconn);
mysql_query("update member set character_skill_1='0' where no='$member[no]'", $dbconn);
mysql_query("update member set character_skill_2='0' where no='$member[no]'", $dbconn);

echo "<script>alert(' 신청을 모두 취소하였습니다. ');self.location.href='member_6.php'</script>";
} else {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}
?>