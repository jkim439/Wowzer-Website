<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_POST[url]);
$key = mysql_real_escape_string($_POST[key]);
$keycode4 = mysql_real_escape_string($_POST[keycode4]);
$pw_check = mysql_real_escape_string($_POST[pw_check]);
$name_nick = mysql_real_escape_string($_POST[name_nick]);

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

// 보안 코드 인증
$keycode1 = "4y89y54wun8her459kyg6uh35ygmepzg";
$keycode2 = md5($keycode1.$keycode4.$keycode1);
$keycode3 = mb_substr($keycode2,10,5,'UTF-8');
if($key!= $keycode3){
  echo "<script>alert(' 보안 코드가 올바르지 않습니다. ');self.location.href='help_modify_3_1.php';</script>"; exit;
}

// 글자수 검사
$pw_check_length = strlen($pw_check);
$name_nick_length = strlen($name_nick);

if($pw_check_length<4) {
  echo "<script>alert(' 비밀번호는 최소 4글자이여야 합니다. ');self.location.href='help_modify_3_1.php';</script>"; exit;
}
if($name_nick_length<2) {
  echo "<script>alert(' 닉네임은 최소 2글자이여야 합니다. ');self.location.href='help_modify_3_1.php';</script>"; exit;
}

// 닉네임 체크
$name_result = mysql_query("select * from member where name_nick='$name_nick'");
$name_check = mysql_fetch_array($name_result);
if($name_check[name_nick]) {
  echo "<script>alert(' 이미 사용 중인 닉네임입니다. ');self.location.href='help_modify_3_1.php';</script>"; exit;
}

// 닉네임에 영어와 숫자만 허용할 경우
$name_check = preg_replace ("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $name_nick);
if($name_nick != $name_check){
  echo "<script>alert(' 닉네임에는 영어와 한글만 사용할 수 있습니다. ');self.location.href='help_modify_3_1.php';</script>"; exit;
}

// 비밀번호 변환
$pw = md5(md5($key1).md5($pw_check).md5($key1));

// 비밀번호와 실명 검사
if($member[pw]!=$pw) {
	echo "<script>alert(' 입력하신 정보가 올바르지 않습니다. ');self.location.href='help_modify_3_1.php';</script>"; exit;
}

if($member[point]>=2000) {
	
$time = time();
// 포인트 기록 시스템
$code = "55";
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
	mysql_query("update member set $log_point_p='$code' where no='$member[no]'", $dbconn);
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
	mysql_query("update member set log_point_5='$code' where no='$member[no]'", $dbconn);
	mysql_query("update member set log_point_5_time='$time' where no='$member[no]'", $dbconn);
}



mysql_query("update member set point=point-2000 where no='$member[no]'", $dbconn);
mysql_query("update member set name_nick='$name_nick' where no='$member[no]'", $dbconn);
echo "<script>alert(' 닉네임을 변경하였습니다. ');self.location.href='home.php';</script>"; exit;
} else {
echo "<script>alert(' 포인트가 부족합니다. ');self.location.href='help_modify_3_1.php';</script>"; exit;
}

?>