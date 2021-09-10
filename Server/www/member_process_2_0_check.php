<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$type = mysql_real_escape_string($_POST[type]);
$character = mysql_real_escape_string($_POST[character]);
$level = mysql_real_escape_string($_POST[level]);

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

// 레벨 미달, 신청 중 상태
if($member[level]=="1" || $member[level_state]=="1") {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}
	if($level>=$member[level]) {
	echo "<script>alert(' 메인 캐릭터 등급보다 더 높은 등급을 신청할 수 없습니다. ');self.location.href='member_6.php';</script>"; exit;
}

// 페이지 이동
if($type=="1") {
  echo "<script>self.location.href='member_process_2_1_1.php';</script>"; exit;
} elseif($type=="2") {
	
	
	$url = "member_process_2_".$level."_1.php?character=".$character;
  echo "<script>self.location.href='$url';</script>"; exit;
} else {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

?>