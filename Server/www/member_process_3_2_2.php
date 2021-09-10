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
$character = mysql_real_escape_string($_POST[character]);
$pw_check = mysql_real_escape_string($_POST[pw_check]);
$file_name = mysql_real_escape_string($_FILES[file][name]);
$file_type = mysql_real_escape_string($_FILES[file][type]);
$file_size = mysql_real_escape_string($_FILES[file][size]);

// 레벨 미달, 신청 중 상태
if($member[level]=="1" || $member[level_state]=="1") {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 글자수 검사
$pw_check_length = strlen($pw_check);

if($pw_check_length<4) {
  echo "<script>alert(' 비밀번호는 최소 4글자이여야 합니다. ');history.back();</script>"; exit;
}

// 비밀번호 변환
$pw = md5(md5($key1).md5($pw_check).md5($key1));

// 비밀번호 검사
if($member[pw]!=$pw) {
	echo "<script>alert(' 입력하신 정보가 올바르지 않습니다. ');history.back();</script>"; exit;
}

if($member[point]>=4000) {

// 현재 시간
$time = time();

// 포인트 기록 시스템
$code = "56";
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

mysql_query("update member set point=point-4000 where no='$member[no]'", $dbconn);
mysql_query("update member set level_state='1' where no='$member[no]'", $dbconn);
mysql_query("update member set level_time='$time' where no='$member[no]'", $dbconn);
mysql_query("update member set character_mode='4' where no='$member[no]'", $dbconn);
mysql_query("update member set character_code='$character' where no='$member[no]'", $dbconn);

echo "<script>alert(' 변경 요청을 완료하였습니다. \\n\\n 변경 요청은 평균 3일 이내에 처리됩니다. ');self.location.href='member_6.php'</script>";
} else {
echo "<script>alert(' 포인트가 부족합니다. ');history.back();</script>"; exit;
}
?>