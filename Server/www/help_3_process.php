<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_POST[url]);
$key = mysql_real_escape_string($_POST[key]);
$keycode4 = mysql_real_escape_string($_POST[keycode4]);
$id_check = mysql_real_escape_string($_POST[id_check]);
$name_real = mysql_real_escape_string($_POST[name_real]);
$email = mysql_real_escape_string($_POST[email]);
$pw = md5(md5($key1).md5($pw_check).md5($key1));

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}
if(getenv("REQUEST_METHOD")!="POST") {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}
if(!eregi("$url",$_SERVER['HTTP_REFERER'])) {
	echo "<script>location.href='$site_403';</script>"; exit;
}

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
}

// 보안 코드 인증
$keycode1 = "4y89y54wun8her459kyg6uh35ygmepzg";
$keycode2 = md5($keycode1.$keycode4.$keycode1);
$keycode3 = mb_substr($keycode2,10,5,'UTF-8');
if($key!= $keycode3){
  echo "<script>alert(' 보안 코드가 올바르지 않습니다. ');self.location.href='help_3.php';</script>"; exit;
}

// 글자수 검사
$id_check_length = strlen($id_check);
$name_real_length = strlen($name_real);
$email_length = strlen($email);

if($id_check_length<4) {
  echo "<script>alert(' 아이디는 최소 4글자이여야 합니다. ');self.location.href='help_3.php';</script>"; exit;
}
if($name_real_length<2) {
  echo "<script>alert(' 실명은 최소 2글자이여야 합니다. ');self.location.href='help_3.php';</script>"; exit;
}
if($email_length<5) {
  echo "<script>alert(' 이메일은 최소 5글자이여야 합니다. ');self.location.href='help_3.php';</script>"; exit;
}

// 이이디 체크
$id_result = mysql_query("select * from member where id='$id_check'");
$member_find = mysql_fetch_array($id_result);

// 탈퇴 회원
if($member_find[pw]=="0") {
	echo "<script>alert(' 삭제된 계정입니다. ');self.location.href='help_3.php';</script>"; exit;
}

if($member_find[id]) {
	
	if($member_find[name_real]!=$name_real) {
		 echo "<script>alert(' 입력하신 정보가 올바르지 않습니다. ');self.location.href='help_3.php';</script>"; exit;
	}
	if($member_find[email]!=$email) {
		 echo "<script>alert(' 입력하신 정보가 올바르지 않습니다. ');self.location.href='help_3.php';</script>"; exit;
	}
	mysql_query("update member set login_try='0' where no='$member_find[no]'", $dbconn);
	echo "<script>alert(' 로그인 제한이 해제되었습니다. ');self.location.href='home.php';</script>"; exit;
} else {
  echo "<script>alert(' 입력하신 정보가 올바르지 않습니다. ');self.location.href='help_3.php';</script>"; exit;
}

?>