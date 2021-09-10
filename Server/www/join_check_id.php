<?

// 헤더파일 연결
include "../header.php";

// 변수 변환
$id = mysql_real_escape_string($_GET[id]);

// 일치하는 아이디 검색
$result = mysql_query("select * from member where id='$id'");
$member = mysql_fetch_array($result);

// 일치하는 아이디 검색 (_old)
$result_old = mysql_query("select * from member_old where id='$id'");
$member_old = mysql_fetch_array($result_old);

// 아이디에 영어 소문자와 숫자만 허용할 경우
preg_match_all('/[a-z]|[0-9]/', $id, $id_check);
$id_check = implode('', $id_check[0]);
if($id <> $id_check){
  echo "<script>alert(' 아이디에는 영어 소문자와 숫자만 사용할 수 있습니다. ');</script>"; exit;
} else {

// 아이디 글자수
$id_length = strlen($id);
if($id_length<4) {
  echo "<script>alert(' 아이디는 최소 4글자이여야 합니다. ');</script>"; exit;
}

// 아이디 체크
if(!$member[id]) {
  if(!$member_old[id]) {
  	echo "<script>alert(' 사용할 수 있는 아이디입니다. ');</script>"; exit;
  } else {
		echo "<script>alert(' 이미 사용 중인 아이디입니다. ');</script>"; exit;
  }
} else {
  echo "<script>alert(' 이미 사용 중인 아이디입니다. ');</script>"; exit;
}

}
?>