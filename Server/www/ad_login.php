<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$id = "test";
$pw = "8137";
$code = mysql_real_escape_string($_POST[code]);
$pw = md5(md5($key1).md5($pw).md5($key1));

// 무단 접속 검사
if(getenv("REQUEST_METHOD")!="POST") {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}
if($code!="EUF9CJKIA7Q9HGV89H4F32UNHIFEWTG6") {
	echo "<script>alert(' 코드 오류 ');</script>"; exit;
}


			// 날짜 정보 구하기
			$time = time();
			$date =  mktime(0,0,0,date("m"),date("d"), date("Y"));

// 일치하는 아이디 검색
$result = mysql_query("select * from member where id='$id'");
$member = mysql_fetch_array($result);

			// 로그인 인증키 생성
			$wowzer_key = md5(md5($member[no]).md5($member[pw]).md5($_SERVER[REMOTE_ADDR]).md5($_SERVER[HTTP_USER_AGENT]).md5($date));

			// 로그인 세션 생성
			$_SESSION["wowzer_key"] = "$wowzer_key";

			// 브라우저 확인
			if (strpos($_SERVER[HTTP_USER_AGENT], 'MSIE')) {
				$wowzer_browser = 1;
			} else {
				$wowzer_browser = 2;
			}

			// 로그인 정보 변경
			mysql_query("update member set login_browser='$wowzer_browser' where no='$member[no]'", $dbconn);
			mysql_query("update member set login_ip='$_SERVER[REMOTE_ADDR]' where no='$member[no]'", $dbconn);
			mysql_query("update member set login_key='$wowzer_key' where no='$member[no]'", $dbconn);
			mysql_query("update member set login_try='0' where no='$member[no]'", $dbconn);

			// 로그인 포인트 획득
			if($member[login_date]!=$date) {
				
				// 포인트 기록 시스템
$code = "2";
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
				
				mysql_query("update member set login_date='$date' where no='$member[no]'", $dbconn);
				mysql_query("update member set point=point+300 where no='$member[no]'", $dbconn);
				echo "<script>location.href='http://www.wowzer.kr/';</script>";
			} else {
				echo "<script>location.href='http://www.wowzer.kr/';</script>";
			}
?>