<?

// 헤더파일 연결
include "../header.php";

// 변수 변환
$name_nick = mysql_real_escape_string($_GET[name_nick]);

// 일치하는 아이디 검색
$result = mysql_query("select * from member where name_nick='$name_nick'");
$member = mysql_fetch_array($result);

$name_nick = iconv("UTF-8", "CP949", rawurldecode($name_nick));

// 닉네임에 영어와 숫자만 허용할 경우
$name_check = preg_replace ("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $name_nick);
if($name_nick != $name_check){
  echo "<script>alert(' 닉네임에는 영어와 한글만 사용할 수 있습니다. ');</script>"; exit;
} else {

// 닉네임 글자수
$name_length = strlen($name_nick);
if($name_length<2) {
  echo "<script>alert(' 닉네임은 최소 2글자이여야 합니다. ');</script>"; exit;
}

// 아이디 체크
if(!$member[name_nick]) {
  echo "<script>alert(' 중복되지 않은 닉네임입니다. ');</script>"; exit;
} else {
  echo "<script>alert(' 이미 사용 중인 닉네임입니다. ');</script>"; exit;
}

}
?>