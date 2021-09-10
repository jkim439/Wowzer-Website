<?

// 헤더파일 연결
include "../header.php";

// 변수 변환
$key = mysql_real_escape_string($_GET[key]);

// 인증키 해킹 차단
if($key=="0") {
  echo "<script>alert(' 이미 인증을 받았거나 인증키가 유효하지 않습니다. ');location.href='http://www.wowzer.kr/'</script>";
}

// 인증키 검색
$result = mysql_query("select * from member where email_key='$key'");
$member = mysql_fetch_array($result);

// 인증키 존재 여부
if(!$member[email_key]) {
  echo "<script>alert(' 이미 인증을 받았거나 인증키가 유효하지 않습니다. ');location.href='http://www.wowzer.kr/'</script>";
} else {

// 인증키 일치 여부
if($member[email_key]==$key) {
  mysql_query("update member set email_key='0' where no='$member[no]'", $dbconn);
  mysql_query("update member set login_state='0' where no='$member[no]'", $dbconn);
  echo "<script>alert(' 이메일 인증이 완료되었습니다. ');location.href='http://www.wowzer.kr/'</script>";
} else {
  echo "<script>location.href='$site_403';</script>"; exit;
}
}
?>