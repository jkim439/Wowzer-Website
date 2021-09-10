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
$ino = mysql_real_escape_string($_POST[ino]);
$pw = mysql_real_escape_string($_POST[pw]);
$pw = md5(md5($key1).md5($pw).md5($key1));

// 상점 아이템 로드
$item = mysql_fetch_array(mysql_query("select * from item where ino='$ino'",$dbconn));
$item_i = 'item_'.$item[ino];

// 미보유 또는 사용된 아이템 확인
if($member[$item_i]!="1") {
	echo "<script>self.location.href='$site_403';</script>"; exit;
} else {
	
	// 비밀번호 검사
	if($member[pw]==$pw) {
		mysql_query("update member set $item_i='0' where no='$member[no]'", $dbconn);
		echo "<script>alert(' 아이템 삭제가 완료되었습니다. ');self.location.href='member_1.php#bag';</script>"; exit;
	} else {
		echo "<script>alert(' 비밀번호가 올바르지 않습니다. ');history.back();</script>"; exit;
	}
}
?>