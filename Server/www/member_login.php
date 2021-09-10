<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$id = mysql_real_escape_string($_POST[id]);
$pw = mysql_real_escape_string($_POST[pw]);
$pw = md5(md5($key1).md5($pw).md5($key1));

// 로그인 보안 인증
$url = mysql_real_escape_string($_POST[url]);
$referer = mysql_real_escape_string($_SERVER[HTTP_REFERER]);
$url_length = mb_strlen($url, 'UTF-8');
$url_clean = mb_substr($url, 1, $url_length, 'UTF-8');
$url_bn = basename($url);
$url_bn_full = "http://www.wowzer.kr/".$url_bn;
$url_bn_full_length = mb_strlen($url_bn_full, 'UTF-8');
$referer_clean = mb_substr($referer, 0, $url_bn_full_length, 'UTF-8');
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}
if(getenv("REQUEST_METHOD")!="POST") {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}
if(!eregi($url,$referer)) {
	echo "<script>location.href='$site_403';</script>"; exit;
}
if($url_clean!=$url_bn) {
	echo "<script>location.href='$site_403';</script>"; exit;
}
if($url_bn_full!=$referer_clean) {
	echo "<script>location.href='$site_403';</script>"; exit;
}

// 빈칸 검사
if(!$id) {
	sleep(3);
	echo "<script>alert(' 아이디를 입력하여 주십시오. ');self.location.href='$url';</script>"; exit;
}
if(!$pw) {
	sleep(3);
	echo "<script>alert(' 비밀번호를 입력하여 주십시오. ');self.location.href='$url';</script>"; exit;
}

// 일치하는 아이디 검색
$result = mysql_query("select * from member where id='$id'");
$member = mysql_fetch_array($result);

// 아이디 검사
if(!$member[id]) {
	sleep(3);
	echo "<script>alert(' 아이디가 올바르지 않습니다. ');self.location.href='$url';</script>"; exit;
} else {
	
	// 탈퇴 회원
	if($member[pw]=="0") {
	sleep(3);
	echo "<script>alert(' 삭제된 계정입니다. ');self.location.href='$url';</script>"; exit;
	}

	// 연속 로그인 실패
	if($member[login_try]>2) {
		sleep(3);
		echo "<script>alert(' 비밀번호를 3회 이상 틀려 로그인이 제한되었습니다. \\n\\n 고객지원에서 해당 계정의 로그인 제한을 해제하십시오. ');self.location.href='help_3.php';</script>"; exit;
	}

	// 비밀번호 검사
		if($member[pw]==$pw) {
			sleep(3);

			// 날짜 정보 구하기
			$time = time();
			$date =  mktime(0,0,0,date("m"),date("d"), date("Y"));

      // 계정 제재 조치
      if($member[login_state]=="1" && $member[login_release]>$date) {
      	$login_release_y = date("Y",$member[login_release]).'년'; 
      	$login_release_m = date("m",$member[login_release]).'월'; 
      	$login_release_d = date("d",$member[login_release]).'일입니다.'; 
        echo "<script>alert(' 임시 계정 제재 조치를 받은 계정입니다. \\n\\n 제재가 해제되는 날짜는 $login_release_y $login_release_m $login_release_d \\n\\n 제재 사유는 공지사항에서 확인하십시오. ');self.location.href='home_1.php?mode=view&wno=24';</script>"; exit;
      }
      if($member[login_state]=="1" && $member[login_release]<=$date) {
      	$login_release_y = date("Y",$member[login_release]).'년'; 
      	$login_release_m = date("m",$member[login_release]).'월'; 
      	$login_release_d = date("d",$member[login_release]).'일에'; 
        echo "<script>alert(' 임시 계정 제재 조치가 해제되었습니다. \\n\\n 제재가 $login_release_y $login_release_m $login_release_d 해제되었습니다.  ');</script>";
        mysql_query("update member set login_state='0' where no='$member[no]'", $dbconn);
      }
      if($member[login_state]=="2") {
        echo "<script>alert(' 무기한 계정 제재 조치를 받은 계정입니다. \\n\\n 제재 사유는 공지사항에서 확인하십시오. ');self.location.href='home_1.php?mode=view&wno=24';</script>"; exit;
      }
      if($member[login_state]=="3") {
        echo "<script>alert(' 영구 계정 제재 조치를 받은 계정입니다. \\n\\n 제재 사유는 공지사항에서 확인하십시오. ');self.location.href='home_1.php?mode=view&wno=24';</script>"; exit;
      }

			// 이메일 인증을 받지 않은 경우
			if($member[login_state]=="4") {
				echo "<script>alert(' 이메일 인증을 받지 않은 계정입니다. \\n\\n 재인증을 원하는 경우 고객지원을 방문해 주세요. ');self.location.href='help_2.php';</script>"; exit;
			}

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
$vote_check = mysql_query("select COUNT(*) FROM vote where no='$member[no]'",$dbconn);
$vote_check = mysql_result($vote_check, 0, "COUNT(*)");
if($vote_check=="0" && $member[level]>1){
			//echo "<script>alert(' 골드팟 관련 길드 투표가 진행 중입니다. \\n\\n 투표시 포인트를 증정하오니 공지사항에서 투표해 주세요. ');</script>";
				//echo "<script>window.open('vote_1.php');</script>";
			}
				echo "<script>location.href='member_1.php';</script>";
				
				
				
			} else {


				echo "<script>location.href='member_1.php';</script>";
			}

		} else {
			sleep(3);
			mysql_query("update member set login_ip='$_SERVER[REMOTE_ADDR]' where no='$member[no]'", $dbconn);
			mysql_query("update member set login_try=login_try+1 where no='$member[no]'", $dbconn);
			echo "<script>alert(' 비밀번호가 올바르지 않습니다. ');self.location.href='$url';</script>"; exit;
		}
}
?>