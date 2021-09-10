<?

// 헤더파일 연결
include "../header.php";

// 변수 변환
$email = mysql_real_escape_string($_GET[email]);

// 일치하는 이메일 검색
$result = mysql_query("select * from member where email='$email'");
$member = mysql_fetch_array($result);

// 일치하는 이메일 검색 (_old)
$result_old = mysql_query("select * from member_old where email='$email'");
$member_old = mysql_fetch_array($result_old);

// 이메일 글자수
$email_length = strlen($email);
if($email_length<5) {
  echo "<script>alert(' 이메일은 최소 5글자이여야 합니다. ');</script>"; exit;
}

// 이메일 체크
if(!$member[email]) {
  if(!$member_old[email]) {
  	echo "<script>alert(' 사용할 수 있는 이메일입니다. ');</script>"; exit;
  } else {
		echo "<script>alert(' 이미 사용 중인 이메일입니다. ');</script>"; exit;
  }
} else {
  echo "<script>alert(' 이미 사용 중인 이메일입니다. ');</script>"; exit;
}

?>