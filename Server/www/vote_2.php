<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$key = mysql_real_escape_string($_POST[key]);
$keycode4 = mysql_real_escape_string($_POST[keycode4]);
$type = mysql_real_escape_string($_POST[type]);

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}
if(getenv("REQUEST_METHOD")!="POST") {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}
if(!eregi("http://www.wowzer.kr/vote_1.php",$_SERVER['HTTP_REFERER'])) {
	echo "<script>location.href='$site_403';</script>"; exit;
}

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>location.href='$site_403';</script>"; exit;
}

// 권한 확인
if($member[level]<2) {
	echo "<script>alert(' Bronze 등급부터 투표할 수 있습니다. ');self.location.href='vote_1.php';</script>"; exit;
}

// 보안 코드 인증
$keycode1 = "4y89y54wun8her459kyg6uh35ygmepzg";
$keycode2 = md5($keycode1.$keycode4.$keycode1);
$keycode3 = mb_substr($keycode2,10,5,'UTF-8');
if($key!= $keycode3){
  echo "<script>alert(' 보안 코드가 올바르지 않습니다. ');self.location.href='vote_1.php';</script>"; exit;
}

$vote_check = mysql_query("select COUNT(*) FROM vote where no='$member[no]'",$dbconn);
$vote_check = mysql_result($vote_check, 0, "COUNT(*)");
if($vote_check!="0"){
	echo "<script>location.href='$site_403';</script>"; exit;
}

$time = time();

if($member[join_date]>=1291993200) {
  echo "<script>alert(' 12월 10일 이후에 가입한 회원은 투표할 수 없습니다. ');self.location.href='vote_1.php';</script>"; exit;
}

// 글쓰기 보상
mysql_query("update member set point=point+500 where no='$member[no]'", $dbconn);

mysql_query("INSERT INTO `akeetes430`.`vote` (`vno`, `no`, `vote`, `time`) VALUES (NULL, '$member[no]', '$type', '$time')", $dbconn);
echo "<script>alert(' 투표를 완료하였습니다. \\n\\n 500 포인트를 보상받으셨습니다. ');self.location.href='vote_1.php'</script>";

?>