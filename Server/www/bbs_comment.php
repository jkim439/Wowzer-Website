<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_POST[url]);
$board = mysql_real_escape_string($_POST[board]);
$code = mysql_real_escape_string($_POST[code]);
$text = mysql_real_escape_string($_POST[text]);

// 게시판 환경설정 연결
include "config_bbs.php";

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

// 쓰기 권한 확인
if($comment_permission>$member[level]) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 현재 시간
$time = time();

// 변수 빈칸 검사
if(!$text) {
	echo "<script>alert(' 내용을 입력하여 주십시오. ');</script>";exit;
}

// 데이터베이스 로드
$board_comment = $board.'_comment';
$comment_db = mysql_query("SELECT MAX(num) AS num FROM $board_comment where code=$code", $dbconn);

// 최대값 로드
$ist[num] = mysql_result($comment_db, 0, "num");
$ist[num] += 1;

mysql_free_result($comment_db);
/*
if($point_comment>0) {

// 포인트 기록 시스템
$code_p = "3";
for($p=1;$p<6;$p++) {
	$log_point_p = "log_point_".$p;
	$log_point_p_time = "log_point_".$p."_time";
	if($member[$log_point_p]=="0") {
		break;
	}
}
if($p<6) {
	$log_point_p = "log_point_".$p;
	$log_point_p_time = "log_point_".$p."_time";
	mysql_query("update member set $log_point_p='$code_p' where no='$member[no]'", $dbconn);
	mysql_query("update member set $log_point_p_time='$time' where no='$member[no]'", $dbconn);
} else {
	$r=2;
	for($q=1;$q<5;$q++) {
		$log_point_q = "log_point_".$q;
		$log_point_r = "log_point_".$r;
		$log_point_q_time = "log_point_".$q."_time";
		$log_point_r_time = "log_point_".$r."_time";
		mysql_query("update member set $log_point_q=$log_point_r where no='$member[no]'", $dbconn);
		mysql_query("update member set $log_point_q_time=$log_point_r_time where no='$member[no]'", $dbconn);
		$r++;
	}
	mysql_query("update member set log_point_5='$code_p' where no='$member[no]'", $dbconn);
	mysql_query("update member set log_point_5_time='$time' where no='$member[no]'", $dbconn);
}

// 글쓰기 보상
mysql_query("update member set point=point+$point_comment where no='$member[no]'", $dbconn);
}
*/
// 데이터 삽입
mysql_query("INSERT INTO $board_comment VALUES('', '$code', '$ist[num]', '$member[no]', '$text', '$time')", $dbconn);

// 화면 이동
echo "<script>parent.location.reload();</script>";

?>