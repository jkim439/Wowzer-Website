<?

// 헤더파일	연결
include	"../header.php";

// 게시판 환경설정 연결
include "config_bbs.php";

// 변수 변환
$url = mysql_real_escape_string($_POST[url]);
$board = mysql_real_escape_string($_POST[board]);
$wno = mysql_real_escape_string($_POST[wno]);
$category = mysql_real_escape_string($_POST[category]);
$goldbox = mysql_real_escape_string($_POST[goldbox]);
$timefix_check = mysql_real_escape_string($_POST[timefix_check]);
$title = mysql_real_escape_string($_POST[title]);
$text = mysql_real_escape_string($_POST[text]);
$img_num = mysql_real_escape_string($_POST[img_num]);

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

// 데이터베이스 로드
$view = mysql_fetch_array(mysql_query("select * from $board where wno='$wno'",$dbconn));

// 글쓰기 작성자 로드
$member_view = mysql_fetch_array(mysql_query("select * from member where no='$view[no]'",$dbconn));

// 수정 권한 확인
if($member_view[no]!=$member[no]){
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 현재 시간
$time = time();

// 변수 빈칸 검사
if(!$category) {
	echo "<script>alert(' 카테고리를 선택하여 주십시오. ');</script>";exit;
}
if(!$title) {
	echo "<script>alert(' 제목을 입력하여 주십시오. ');</script>";exit;
}
if(!$text) {
	echo "<script>alert(' 내용을 입력하여 주십시오. ');</script>";exit;
}

// 데이터 수정
mysql_query("UPDATE $board SET category='$category' WHERE wno='$wno'", $dbconn);
mysql_query("UPDATE $board SET goldbox='$goldbox' WHERE wno='$wno'", $dbconn);
mysql_query("UPDATE $board SET title='$title' WHERE wno='$wno'", $dbconn);
mysql_query("UPDATE $board SET text='$text' WHERE wno='$wno'", $dbconn);
if($timefix_check!="1") {
	mysql_query("UPDATE $board SET time='$time' WHERE wno='$wno'", $dbconn);
}
if($img_num>0) {
mysql_query("DELETE FROM upload_folder WHERE board='$board' and folder='$view[path]'", $dbconn);
}

// 화면 이동
echo "<script>parent.location.href='$url?mode=view&wno=$wno'</script>";

?>