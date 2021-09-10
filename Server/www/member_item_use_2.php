<?

// 헤더파일	연결
include	"../header.php";

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

// 변수 변환
$ino = mysql_real_escape_string($_POST[ino]);

// 상점 아이템 로드
$item = mysql_fetch_array(mysql_query("select * from item where ino='$ino'",$dbconn));
$item_i = 'item_'.$item[ino];
$item_j = 'item_'.$member[avata];

// 미보유 또는 사용된 아이템 확인
if($member[$item_i]!="1") {
	echo "<script>self.location.href='$site_403';</script>"; exit;
} else {

	// 아바타 아이템
	if($item[kind]=="1" || $item[kind]=="2" || $item[kind]=="3") {

		mysql_query("update member set $item_j='1' where no='$member[no]'", $dbconn);
		mysql_query("update member set avata='$item[ino]' where no='$member[no]'", $dbconn);
		mysql_query("update member set $item_i='2' where no='$member[no]'", $dbconn);
		echo "<script>alert(' 아바타 변경이 완료되었습니다. ');self.location.href='member_1.php#bag';</script>"; exit;

	// 칭호 아이템
	} else if($item[kind]=="4") {

		$title = mysql_real_escape_string($_POST[title]);
		if(!$title) { echo "<script>alert(' 원하시는 칭호를 입력하세요. ');history.back();</script>"; exit; }
		mysql_query("update member set title='$title' where no='$member[no]'", $dbconn);
		mysql_query("update member set $item_i='0' where no='$member[no]'", $dbconn);
		echo "<script>alert(' 칭호 변경이 완료되었습니다. ');self.location.href='member_1.php#bag';</script>"; exit;

	} else {
		echo "<script>alert(' 사용할 수 없습니다. 고객센터에 문의하십시오. ');self.location.href='member_1.php#bag';</script>"; exit;
	}

}
?>