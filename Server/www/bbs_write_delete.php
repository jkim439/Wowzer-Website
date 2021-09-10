<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$board = mysql_real_escape_string($_GET[board]);
$wno = mysql_real_escape_string($_GET[wno]);
$url = mysql_real_escape_string($_GET[url]);

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
$view = mysql_fetch_array(mysql_query("select * from $board where wno='$wno'",$dbconn));

// 글쓰기 작성자 로드
$member_view = mysql_fetch_array(mysql_query("select * from member where no='$view[no]'",$dbconn));

// 삭제 권한 확인
if($member_view[no]!=$member[no] && $member[level]<5){
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

if($member_view[login_state]=="5"){
	echo "<script>alert(' 글이나 댓글의 수정, 삭제가 금지된 계정입니다. ');history.back();</script>";exit;
}

// 운영진 확인
if($member_view[level]>=$member[level] && $member_view[no]!=$member[no] && $member[level]>4) {
	echo "<script>alert(' 자신보다 레벨이 높은 댓글을 삭제할 수 없습니다. ');</script>";exit;
}

// 댓글 로드
$board_comment = $board.'_comment';
$comment = mysql_query("SELECT * FROM $board_comment where code=$wno ORDER BY num",$dbconn);

// 댓글 수
$comment_num = mysql_result(mysql_query("SELECT COUNT(*) FROM $board_comment where code=$wno"), 0, "COUNT(*)");

if($comment_num>0) {
	echo "<script>alert(' 삭제하려는 글에 댓글이 있어 삭제할 수 없습니다. \\n\\n 댓글 작성자에게 댓글 삭제를 요청하십시오. ');history.back();</script>";exit;
}

// 현재 시간
$time = time();

// 자기 자신 삭제
if($member_view[no]==$member[no]) {
	if($member[point]<$point_write) {
		echo "<script>alert(' 포인트가 부족하여 삭제할 수 없습니다. ');history.back();</script>";exit;
	} else {
		mysql_query("update member set point=point-$point_write where no='$member[no]'", $dbconn);
		mysql_query("DELETE FROM $board WHERE wno=$wno", $dbconn);
		mysql_query("UPDATE $board SET num = num - 1 WHERE num > $view[num]", $dbconn);
	}
} else {
		mysql_query("update member set point=point-$point_write where no='$member_view[no]'", $dbconn);
		mysql_query("DELETE FROM $board WHERE wno=$wno", $dbconn);
		mysql_query("UPDATE $board SET num = num - 1 WHERE num > $view[num]", $dbconn);
}

// 폴더 삭제

function delete_folder($path) { 
        if (is_dir($path)) { 
            $files = scandir($path); 
            foreach($files as $t) { 
                if (is_dir($path . "/" . $t)) { // folder인 경우 
                    if ($t<>"." && $t<>"..") { // 자신과 부모 folder는 제외 
                        $this->delete_folder($path . "/" . $t); 
                        //print("Dir - $path/$t <br>\n"); 
                    } 
                } 
                else { // 파일인 경우 
                    //print("File - $path/$t <br>\n"); 
                    unlink($path . "/" . $t); 
                } 
            } 
            rmdir($path); 
        } 
    }

if(is_dir("upload/$board/$view[path]")) {
	delete_folder("upload/$board/$view[path]");
}

if($member_view[point]>=$point_write) {
// 포인트 기록 시스템
$code_p = "52";
for($p=1;$p<6;$p++) {
	$log_point_p = "log_point_".$p;
	$log_point_p_time = "log_point_".$p."_time";
	if($member_view[$log_point_p]=="0") {
		break;
	}
}
if($p<6) {
	$log_point_p = "log_point_".$p;
	$log_point_p_time = "log_point_".$p."_time";
	mysql_query("update member set $log_point_p='$code_p' where no='$member_view[no]'", $dbconn);
	mysql_query("update member set $log_point_p_time='$time' where no='$member_view[no]'", $dbconn);
} else {
	$r=2;
	for($q=1;$q<5;$q++) {
		$log_point_q = "log_point_".$q;
		$log_point_r = "log_point_".$r;
		$log_point_q_time = "log_point_".$q."_time";
		$log_point_r_time = "log_point_".$r."_time";
		mysql_query("update member set $log_point_q=$log_point_r where no='$member_view[no]'", $dbconn);
		mysql_query("update member set $log_point_q_time=$log_point_r_time where no='$member_view[no]'", $dbconn);
		$r++;
	}
	mysql_query("update member set log_point_5='$code_p' where no='$member_view[no]'", $dbconn);
	mysql_query("update member set log_point_5_time='$time' where no='$member_view[no]'", $dbconn);
}
}
// 화면 이동
echo "<script>self.location.href='$url';</script>";

?>