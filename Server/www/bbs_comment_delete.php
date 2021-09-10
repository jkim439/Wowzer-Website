<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$board = mysql_real_escape_string($_GET[board]);
$cno = mysql_real_escape_string($_GET[cno]);

// 게시판 환경설정 연결
include "config_bbs.php";

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

// 데이터베이스 로드
$board_comment = $board.'_comment';
$view_comment = mysql_fetch_array(mysql_query("select * from $board_comment where cno='$cno'",$dbconn));

// 댓글 작성자 로드
$member_comment = mysql_fetch_array(mysql_query("select * from member where no='$view_comment[no]'",$dbconn));

// 삭제 권한 확인
if($member_comment[no]!=$member[no] && $member[level]<5){
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

if($member_comment[login_state]=="5"){
	echo "<script>alert(' 글이나 댓글의 수정, 삭제가 금지된 계정입니다. ');</script>";exit;
}

// 현재 시간
$time = time();

// 운영진 확인
if($member_comment[level]>=$member[level] && $member_comment[no]!=$member[no] && $member[level]>4) {
	echo "<script>alert(' 자신보다 레벨이 높은 댓글을 삭제할 수 없습니다. ');</script>";exit;
}

// 자기 자신 삭제
if($member_comment[no]==$member[no]) {
	if($member[point]<$point_comment) {
		echo "<script>alert(' 포인트가 부족하여 삭제할 수 없습니다. ');</script>";exit;
	} else {
		mysql_query("update member set point=point-$point_comment where no='$member[no]'", $dbconn);
		mysql_query("DELETE FROM $board_comment WHERE cno=$cno", $dbconn);
	}
} else {
		mysql_query("update member set point=point-$point_comment where no='$member_comment[no]'", $dbconn);
		mysql_query("DELETE FROM $board_comment WHERE cno=$cno", $dbconn);
}
if($member_comment[point]>=$point_comment && $point_comment!="0") {
// 포인트 기록 시스템
$code_p = "53";
for($p=1;$p<6;$p++) {
	$log_point_p = "log_point_".$p;
	$log_point_p_time = "log_point_".$p."_time";
	if($member_comment[$log_point_p]=="0") {
		break;
	}
}
if($p<6) {
	$log_point_p = "log_point_".$p;
	$log_point_p_time = "log_point_".$p."_time";
	mysql_query("update member set $log_point_p='$code_p' where no='$member_comment[no]'", $dbconn);
	mysql_query("update member set $log_point_p_time='$time' where no='$member_comment[no]'", $dbconn);
} else {
	$r=2;
	for($q=1;$q<5;$q++) {
		$log_point_q = "log_point_".$q;
		$log_point_r = "log_point_".$r;
		$log_point_q_time = "log_point_".$q."_time";
		$log_point_r_time = "log_point_".$r."_time";
		mysql_query("update member set $log_point_q=$log_point_r where no='$member_comment[no]'", $dbconn);
		mysql_query("update member set $log_point_q_time=$log_point_r_time where no='$member_comment[no]'", $dbconn);
		$r++;
	}
	mysql_query("update member set log_point_5='$code_p' where no='$member_comment[no]'", $dbconn);
	mysql_query("update member set log_point_5_time='$time' where no='$member_comment[no]'", $dbconn);
}
}
// 화면 이동
echo "<script>parent.location.reload();</script>";

?>