<?

// 헤더파일	연결
include	"../header.php";

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));

if($member[no]!="1") {
//session_destroy();
//echo "<script>top.location.href='http://www.wowzer.kr/';</script>"; exit;
//$_SESSION["wowzer_notice_2010111001"] = "1";
//echo "<script>alert(' [긴급 공지] 로그인 서버 오류로 게임 로그인이 안됩니다. \\n\\n 현재 몰튼측에서 긴급 수정 작업 중입니다. ');</script>";
}


echo "<script>self.location.href='inc_state.php';</script>";

?>