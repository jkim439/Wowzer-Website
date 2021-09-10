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

// 현재 시간
$time = time();

// 등업 조건 확인
if($member[level]!="2" || $member[level_state]=="1") {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

if($member[item_239]>0) {

} else {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

if($member[title]!="0") {

} else {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}


mysql_query("update member set level_state='1' where no='$member[no]'", $dbconn);
mysql_query("update member set level_time='$time' where no='$member[no]'", $dbconn);
mysql_query("update member set character_mode='1' where no='$member[no]'", $dbconn);
mysql_query("update member set character_code='1' where no='$member[no]'", $dbconn);

echo "<script>alert(' 등업 신청을 완료하였습니다. \\n\\n 등업 신청은 평균 3일 이내에 처리됩니다. ');self.location.href='member_6.php'</script>";

?>