<?

// 헤더파일 연결
include "../../header.php";


// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

if($member[level]<5) {
	session_destroy();
  echo "<script>location.href='error_403.php';</script>"; exit;
}


// 변수 변환
$url = mysql_real_escape_string($_POST[url]);
$no = mysql_real_escape_string($_POST[no]);
$type = mysql_real_escape_string($_POST[type]);
$level_reason = mysql_real_escape_string($_POST[level_reason]);
$level_reason_text = mysql_real_escape_string($_POST[level_reason_text]);

// POST 전송여부 검사
if(getenv("REQUEST_METHOD") != "POST" ) {
  echo "<script>location.href='$site_403';</script>"; exit;
}
if(!eregi("$url",$_SERVER['HTTP_REFERER'])) {
  echo "<script>location.href='$site_403';</script>"; exit;
}

// 이전 페이지 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>location.href='$site_403';</script>"; exit;
}

// 현재 시간
$level_time = time();
$time = time();

// vmember 지정
$vmember = mysql_fetch_array(mysql_query("select * from member where no='$no'",$dbconn));

if($member[no] == $vmember[no]) {
	echo "<script>alert(' 자기 자신의 신청은 처리할 수 없습니다. ');history.back();</script>"; exit;
}

// 무단 접속 확인
if($vmember[level_state]!="1") {
  echo "<script>location.href='level_main_1.php';</script>"; exit;
}

if($level_reason=="1") {
	$level_reason = $level_reason_text;
}

	  ////////////////////////////////////////////////////// 승인
	  
//$file_name = $vmember[no].".jpg";
//$delete = "../upload/lvcheck/$file_name";
//unlink($delete);
	  
	  if($type=="1") {
	  
	  
	  
////////// Bronze로 등업 //////////

if($vmember[level]=="1") {
// 포인트 기록 시스템
$code = "5";
for($p=1;$p<6;$p++) {
	$log_point_p = "log_point_".$p;
	$log_point_p_time = "log_point_".$p."_time";
	if($vmember[$log_point_p]=="0") {
		break;
	}
}
if($p<6) {
	$log_point_p = "log_point_".$p;
	$log_point_p_time = "log_point_".$p."_time";
	mysql_query("update member set $log_point_p='$code' where no='$vmember[no]'", $dbconn);
	mysql_query("update member set $log_point_p_time='$time' where no='$vmember[no]'", $dbconn);
} else {
	$r=2;
	for($q=1;$q<5;$q++) {
		$log_point_q = "log_point_".$q;
		$log_point_r = "log_point_".$r;
		$log_point_q_time = "log_point_".$q."_time";
		$log_point_r_time = "log_point_".$r."_time";
		mysql_query("update member set $log_point_q=$log_point_r where no='$vmember[no]'", $dbconn);
		mysql_query("update member set $log_point_q_time=$log_point_r_time where no='$vmember[no]'", $dbconn);
		$r++;
	}
	mysql_query("update member set log_point_5='$code' where no='$vmember[no]'", $dbconn);
	mysql_query("update member set log_point_5_time='$time' where no='$vmember[no]'", $dbconn);
}


mysql_query("update member set login_key='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set level='2' where no='$vmember[no]'", $dbconn);
mysql_query("update member set level_state='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set level_time='$level_time' where no='$vmember[no]'", $dbconn);
mysql_query("update member set level_reason='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set point=point+2000 where no='$vmember[no]'", $dbconn);
mysql_query("update member set item_244='2' where no='$vmember[no]'", $dbconn);

mysql_query("update member set character_1_name='$vmember[character_name]' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_1_job='$vmember[character_job]' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_1_skill_1='$vmember[character_skill_1]' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_1_skill_2='$vmember[character_skill_2]' where no='$vmember[no]'", $dbconn);

mysql_query("update member set character_mode='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_code='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_name='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_job='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_1='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_2='0' where no='$vmember[no]'", $dbconn);

mysql_query("update admin_log set $member[id]=$member[id]+1 where no='1'",$dbconn);
mysql_query("update admin_log set ok=ok+1 where no='1'",$dbconn);



        echo "<script>location.href='level_main_1.php'</script>";
}



	  
////////// silver로 등업 //////////

if($vmember[level]=="2") {
	
	
// 포인트 기록 시스템
$code = "6";
for($p=1;$p<6;$p++) {
	$log_point_p = "log_point_".$p;
	$log_point_p_time = "log_point_".$p."_time";
	if($vmember[$log_point_p]=="0") {
		break;
	}
}
if($p<6) {
	$log_point_p = "log_point_".$p;
	$log_point_p_time = "log_point_".$p."_time";
	mysql_query("update member set $log_point_p='$code' where no='$vmember[no]'", $dbconn);
	mysql_query("update member set $log_point_p_time='$time' where no='$vmember[no]'", $dbconn);
} else {
	$r=2;
	for($q=1;$q<5;$q++) {
		$log_point_q = "log_point_".$q;
		$log_point_r = "log_point_".$r;
		$log_point_q_time = "log_point_".$q."_time";
		$log_point_r_time = "log_point_".$r."_time";
		mysql_query("update member set $log_point_q=$log_point_r where no='$vmember[no]'", $dbconn);
		mysql_query("update member set $log_point_q_time=$log_point_r_time where no='$vmember[no]'", $dbconn);
		$r++;
	}
	mysql_query("update member set log_point_5='$code' where no='$vmember[no]'", $dbconn);
	mysql_query("update member set log_point_5_time='$time' where no='$vmember[no]'", $dbconn);
}

// 추천인 있음
if($vmember[join_id]!="0") {


			// 추천한 사람
		  mysql_query("update member set point=point+2000 where no='$vmember[no]'", $dbconn);
			$code_1 = "8";
			for($p_1=1;$p_1<6;$p_1++) {
				$log_point_p_1 = "log_point_".$p_1;
				$log_point_p_time_1 = "log_point".$p_1."_time";
				if($member[$log_point_p_1]=="0") {
					break;
				}
			}
			if($p_1<6) {
				$log_point_p_1 = "log_point_".$p_1;
				$log_point_p_time_1 = "log_point_".$p_1."_time";
				mysql_query("update member set $log_point_p_1='$code_1' where no='$vmember[no]'", $dbconn);
				mysql_query("update member set $log_point_p_time_1='$time' where no='$vmember[no]'", $dbconn);
			} else {
				$r_1=2;
				for($q_1=1;$q_1<5;$q_1++) {
					$log_point_q_1 = "log_point_".$q_1;
					$log_point_r_1 = "log_point_".$r_1;
					$log_point_q_time_1 = "log_point_".$q_1."_time";
					$log_point_r_time_1 = "log_point_".$r_1."_time";
					mysql_query("update member set $log_point_q_1=$log_point_r_1 where no='$vmember[no]'", $dbconn);
					mysql_query("update member set $log_point_q_time_1=$log_point_r_time_1 where no='$vmember[no]'", $dbconn);
					$r_1++;
				}
				mysql_query("update member set log_point_5='$code_1' where no='$vmember[no]'", $dbconn);
				mysql_query("update member set log_point_5_time='$time' where no='$vmember[no]'", $dbconn);
			}
		  
		  
		  // 추천당한 사람
			mysql_query("update member set point=point+2000 where id='$vmember[join_id]'", $dbconn);
			$code_2 = "8";
			for($p_2=1;$p_2<6;$p_2++) {
				$log_point_p_2 = "log_point_".$p_2;
				$log_point_p_time_2 = "log_point_".$p_2."_time";
				if($member_view[$log_point_p_2]=="0") {
					break;
				}
			}
			if($p_2<6) {
				$log_point_p_2 = "log_point_".$p_2;
				$log_point_p_time_2 = "log_point_".$p_2."_time";
				mysql_query("update member set $log_point_p_2='$code_2' where id='$vmember[join_id]'", $dbconn);
				mysql_query("update member set $log_point_p_time_2='$time' where id='$vmember[join_id]'", $dbconn);
			} else {
				$r_2=2;
				for($q_2=1;$q_2<5;$q_2++) {
					$log_point_q_2 = "log_point_".$q_2;
					$log_point_r_2 = "log_point_".$r_2;
					$log_point_q_time_2 = "log_point_".$q_2."_time";
					$log_point_r_time_2 = "log_point_".$r_2."_time";
					mysql_query("update member set $log_point_q_2=$log_point_r_2 where id='$vmember[join_id]'", $dbconn);
					mysql_query("update member set $log_point_q_time_2=$log_point_r_time_2 where id='$vmember[join_id]'", $dbconn);
					$r_2++;
				}
				mysql_query("update member set log_point_5='$code_2' where id='$vmember[join_id]'", $dbconn);
				mysql_query("update member set log_point_5_time='$time' where id='$vmember[join_id]'", $dbconn);
			}





}







        mysql_query("update member set login_key='0' where no='$vmember[no]'", $dbconn);
        mysql_query("update member set level='3' where no='$vmember[no]'", $dbconn);
        mysql_query("update member set level_state='0' where no='$vmember[no]'", $dbconn);
        mysql_query("update member set level_time='$level_time' where no='$vmember[no]'", $dbconn);
        mysql_query("update member set level_reason='0' where no='$vmember[no]'", $dbconn);
        mysql_query("update member set point=point+3000 where no='$vmember[no]'", $dbconn);
        mysql_query("update member set item_245='2' where no='$vmember[no]'", $dbconn);
        mysql_query("update member set character_mode='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_code='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_name='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_job='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_1='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_2='0' where no='$vmember[no]'", $dbconn);

mysql_query("update admin_log set $member[id]=$member[id]+1 where no='1'",$dbconn);
mysql_query("update admin_log set ok=ok+1 where no='1'",$dbconn);
        echo "<script>location.href='level_main_1.php'</script>";
}


	  
////////// gold로 등업 //////////

if($vmember[level]=="3") {
// 포인트 기록 시스템
$code = "7";
for($p=1;$p<6;$p++) {
	$log_point_p = "log_point_".$p;
	$log_point_p_time = "log_point_".$p."_time";
	if($vmember[$log_point_p]=="0") {
		break;
	}
}
if($p<6) {
	$log_point_p = "log_point_".$p;
	$log_point_p_time = "log_point_".$p."_time";
	mysql_query("update member set $log_point_p='$code' where no='$vmember[no]'", $dbconn);
	mysql_query("update member set $log_point_p_time='$time' where no='$vmember[no]'", $dbconn);
} else {
	$r=2;
	for($q=1;$q<5;$q++) {
		$log_point_q = "log_point_".$q;
		$log_point_r = "log_point_".$r;
		$log_point_q_time = "log_point_".$q."_time";
		$log_point_r_time = "log_point_".$r."_time";
		mysql_query("update member set $log_point_q=$log_point_r where no='$vmember[no]'", $dbconn);
		mysql_query("update member set $log_point_q_time=$log_point_r_time where no='$vmember[no]'", $dbconn);
		$r++;
	}
	mysql_query("update member set log_point_5='$code' where no='$vmember[no]'", $dbconn);
	mysql_query("update member set log_point_5_time='$time' where no='$vmember[no]'", $dbconn);
}




// 추천인 있음
if($vmember[join_id]!="0") {


			// 추천한 사람
		  mysql_query("update member set point=point+3000 where no='$vmember[no]'", $dbconn);
			$code_1 = "9";
			for($p_1=1;$p_1<6;$p_1++) {
				$log_point_p_1 = "log_point_".$p_1;
				$log_point_p_time_1 = "log_point".$p_1."_time";
				if($member[$log_point_p_1]=="0") {
					break;
				}
			}
			if($p_1<6) {
				$log_point_p_1 = "log_point_".$p_1;
				$log_point_p_time_1 = "log_point_".$p_1."_time";
				mysql_query("update member set $log_point_p_1='$code_1' where no='$vmember[no]'", $dbconn);
				mysql_query("update member set $log_point_p_time_1='$time' where no='$vmember[no]'", $dbconn);
			} else {
				$r_1=2;
				for($q_1=1;$q_1<5;$q_1++) {
					$log_point_q_1 = "log_point_".$q_1;
					$log_point_r_1 = "log_point_".$r_1;
					$log_point_q_time_1 = "log_point_".$q_1."_time";
					$log_point_r_time_1 = "log_point_".$r_1."_time";
					mysql_query("update member set $log_point_q_1=$log_point_r_1 where no='$vmember[no]'", $dbconn);
					mysql_query("update member set $log_point_q_time_1=$log_point_r_time_1 where no='$vmember[no]'", $dbconn);
					$r_1++;
				}
				mysql_query("update member set log_point_5='$code_1' where no='$vmember[no]'", $dbconn);
				mysql_query("update member set log_point_5_time='$time' where no='$vmember[no]'", $dbconn);
			}
		  
		  
		  // 추천당한 사람
			mysql_query("update member set point=point+3000 where id='$vmember[join_id]'", $dbconn);
			$code_2 = "9";
			for($p_2=1;$p_2<6;$p_2++) {
				$log_point_p_2 = "log_point_".$p_2;
				$log_point_p_time_2 = "log_point_".$p_2."_time";
				if($member_view[$log_point_p_2]=="0") {
					break;
				}
			}
			if($p_2<6) {
				$log_point_p_2 = "log_point_".$p_2;
				$log_point_p_time_2 = "log_point_".$p_2."_time";
				mysql_query("update member set $log_point_p_2='$code_2' where id='$vmember[join_id]'", $dbconn);
				mysql_query("update member set $log_point_p_time_2='$time' where id='$vmember[join_id]'", $dbconn);
			} else {
				$r_2=2;
				for($q_2=1;$q_2<5;$q_2++) {
					$log_point_q_2 = "log_point_".$q_2;
					$log_point_r_2 = "log_point_".$r_2;
					$log_point_q_time_2 = "log_point_".$q_2."_time";
					$log_point_r_time_2 = "log_point_".$r_2."_time";
					mysql_query("update member set $log_point_q_2=$log_point_r_2 where id='$vmember[join_id]'", $dbconn);
					mysql_query("update member set $log_point_q_time_2=$log_point_r_time_2 where id='$vmember[join_id]'", $dbconn);
					$r_2++;
				}
				mysql_query("update member set log_point_5='$code_2' where id='$vmember[join_id]'", $dbconn);
				mysql_query("update member set log_point_5_time='$time' where id='$vmember[join_id]'", $dbconn);
			}





}






        
        mysql_query("update member set login_key='0' where no='$vmember[no]'", $dbconn);
        mysql_query("update member set level='4' where no='$vmember[no]'", $dbconn);
        mysql_query("update member set level_state='0' where no='$vmember[no]'", $dbconn);
        mysql_query("update member set level_time='$level_time' where no='$vmember[no]'", $dbconn);
        mysql_query("update member set level_reason='0' where no='$vmember[no]'", $dbconn);
        mysql_query("update member set point=point+4000 where no='$vmember[no]'", $dbconn);
        mysql_query("update member set item_246='2' where no='$vmember[no]'", $dbconn);
        mysql_query("update member set character_mode='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_code='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_name='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_job='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_1='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_2='0' where no='$vmember[no]'", $dbconn);

mysql_query("update admin_log set $member[id]=$member[id]+1 where no='1'",$dbconn);
mysql_query("update admin_log set ok=ok+1 where no='1'",$dbconn);

        echo "<script>location.href='level_main_1.php'</script>";
}
}










/////////////////////////////////////// 거부

if($type=="2") {
	

	
mysql_query("update member set level_state='2' where no='$vmember[no]'", $dbconn);
mysql_query("update member set level_time='$level_time' where no='$vmember[no]'", $dbconn);
mysql_query("update member set level_reason='$level_reason' where no='$vmember[no]'", $dbconn);

mysql_query("update member set character_code='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_name='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_job='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_1='0' where no='$vmember[no]'", $dbconn);
mysql_query("update member set character_skill_2='0' where no='$vmember[no]'", $dbconn);
	
mysql_query("update admin_log set $member[id]=$member[id]+1 where no='1'",$dbconn);
mysql_query("update admin_log set cancel=cancel+1 where no='1'",$dbconn);
	
	echo "<script>location.href='level_main_1.php'</script>";
	
}
?>
