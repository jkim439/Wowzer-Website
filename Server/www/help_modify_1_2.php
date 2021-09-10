<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_POST[url]);
$key = mysql_real_escape_string($_POST[key]);
$keycode4 = mysql_real_escape_string($_POST[keycode4]);
$pw_check = mysql_real_escape_string($_POST[pw_check]);
$pw_check_1 = mysql_real_escape_string($_POST[pw_check_1]);
$pw_check_2 = mysql_real_escape_string($_POST[pw_check_2]);
$name_real = mysql_real_escape_string($_POST[name_real]);
$email = mysql_real_escape_string($_POST[email]);

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
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

// 보안 코드 인증
$keycode1 = "4y89y54wun8her459kyg6uh35ygmepzg";
$keycode2 = md5($keycode1.$keycode4.$keycode1);
$keycode3 = mb_substr($keycode2,10,5,'UTF-8');
if($key!= $keycode3){
  echo "<script>alert(' 보안 코드가 올바르지 않습니다. ');self.location.href='help_modify_1_1.php';</script>"; exit;
}

// 글자수 검사
$pw_check_length = strlen($pw_check);
$pw_check_1_length = strlen($pw_check_1);
$pw_check_2_length = strlen($pw_check_2);
$name_real_length = strlen($name_real);

if($pw_check_length<4) {
  echo "<script>alert(' 비밀번호는 최소 4글자이여야 합니다. ');self.location.href='help_modify_1_1.php';</script>"; exit;
}
if($pw_check_1_length<4) {
  echo "<script>alert(' 비밀번호는 최소 4글자이여야 합니다. ');self.location.href='help_modify_1_1.php';</script>"; exit;
}
if($pw_check_2_length<4) {
  echo "<script>alert(' 비밀번호는 최소 4글자이여야 합니다. ');self.location.href='help_modify_1_1.php';</script>"; exit;
}
if($name_real_length<2) {
  echo "<script>alert(' 실명은 최소 2글자이여야 합니다. ');self.location.href='help_modify_1_1.php';</script>"; exit;
}

// 비밀번호 일치 여부
if($pw_check_1 != $pw_check_2){
  echo "<script>alert(' 비밀번호와 비밀번호 확인이 서로 다릅니다. ');self.location.href='help_modify_1_1.php';</script>"; exit;
}

// 비밀번호 변환
$pw = md5(md5($key1).md5($pw_check).md5($key1));
$pw_1 = md5(md5($key1).md5($pw_check_1).md5($key1));

// 비밀번호와 실명 검사
if($member[pw]!=$pw) {
	echo "<script>alert(' 입력하신 정보가 올바르지 않습니다. ');self.location.href='help_modify_1_1.php';</script>"; exit;
}
if($member[name_real]!=$name_real) {
	echo "<script>alert(' 입력하신 정보가 올바르지 않습니다. ');self.location.href='help_modify_1_1.php';</script>"; exit;
}

mysql_query("update member set pw='$pw_1' where no='$member[no]'", $dbconn);
session_destroy();
echo "<script>alert(' 비밀번호를 변경하였습니다. ');self.location.href='home.php';</script>"; exit;


?>