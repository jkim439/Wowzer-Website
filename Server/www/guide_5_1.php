<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$item_name = mysql_real_escape_string($_POST[item_name]);

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

// 빈칸 검사
if($item_name=="") {
  echo "<script>location.href='$site_403';</script>"; exit;
}

// 페이지 이동
echo "<script>location.href='http://www.wowhead.com/items?filter=na=$item_name';</script>"; exit;

?>