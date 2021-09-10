<?

// 헤더파일	연결
include	"../../header.php";

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

if($member[level]<5) {
	session_destroy();
  echo "<script>location.href='error_403.php';</script>"; exit;
}

// 변수 변환
$src = mysql_real_escape_string($_GET[src]);
// 경로 조작 검사
$src_check = basename($src);
if($src_check!=$src) {
  echo "<script>location.href='$site_403';</script>"; exit;
}
?>
<a href="#" onclick="window.close();"><img src="<?=$src?>" style="width:868px; height:443px;"></a>