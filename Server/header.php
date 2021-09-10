<?

// 서비스 시작
ob_start();
session_start();

$time = time();

if($time>1293375600) {
	echo "<script>top.location.href='http://www.wowzer.kr/';</script>";
}

// 계정정보	연결
include	"account.php";

// 데이터베이스 연결
$dbconn = mysql_connect('localhost',$homepage_secret_id,$homepage_secret_password) or die;
mysql_select_db($homepage_secret_id,$dbconn);
mysql_query("set names utf8");

// 비밀키
$key1 = "x";

// 사이트 기본정보
define('site_title', 'Eternal Soulmate 홈페이지');
define('site_url', 'http://www.wowzer.kr/');
define('site_java_msg', '보안 시스템이 자바스크립트 미작동 여부를 감지하였습니다.<br><br>보안을 위해서 해당 사용자를 임시 차단하였습니다.');
define('site_frame_msg', '보안 시스템이 프레임셋 미작동 여부를 감지하였습니다.<br><br>보안을 위해서 해당 사용자를 임시 차단하였습니다.');
$site_403 = "http://www.wowzer.kr/error_403.php";
$site_item = mysql_query("SELECT COUNT(*) FROM item",$dbconn);
$site_item = mysql_result($site_item, 0, "COUNT(*)");

?>
<link rel="shortcut icon" href="http://www.wowzer.kr/contents/favicon.ico" type="image/x-icon" />
<link rel="icon" href="http://www.wowzer.kr/contents/favicon.ico" type="image/x-icon" />
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20093337-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
