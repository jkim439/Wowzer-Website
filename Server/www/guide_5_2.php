<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$item_num = mysql_real_escape_string($_POST[item_num]);

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
if($item_num=="") {
  echo "<script>location.href='$site_403';</script>"; exit;
}

// 숫자 확인
if (!preg_match("/[0-9]/", $item_num)) {
	echo "<script>alert(' 숫자만 입력이 가능합니다. ');window.close();</script>"; exit;
}

// 페이지 이동
echo "<script>location.href='http://wow.inven.co.kr/dataninfo/wdb/edb_item/detail.php?id=$item_num';</script>"; exit;

?>