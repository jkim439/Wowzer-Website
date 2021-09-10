<?

// 서비스 시작
session_start();

// 계정정보	연결
include	"../account.php";

// 데이터베이스 연결
$dbconn = mysql_connect('localhost',$homepage_secret_id,$homepage_secret_password) or die;
mysql_select_db($homepage_secret_id,$dbconn);
mysql_query("set names utf8");

// 변수 변환
$board = mysql_real_escape_string($_GET[board]);
$wno = mysql_real_escape_string($_GET[wno]);
$code = mysql_real_escape_string($_GET[code]);

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

// 읽기 권한 확인
if($view_permission>$member[level] && $view_permission!="0") {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 게시물 로드
$view = mysql_fetch_array(mysql_query("SELECT * FROM $board WHERE wno=$wno", $dbconn));

// 게시물 작성자 로드
$member_view = mysql_fetch_array(mysql_query("select * from member where no='$view[no]'",$dbconn));

// 다운로드 폴더 이름/생성
list($microtime,$timestamp) = explode(' ',microtime()); 
$folder = $timestamp.substr($microtime,2,3);
clearstatcache();
mkdir("download/$board/$folder", 0755);

// 코드 변환
if($code=="1") {
$file_name_encode = $view[file_1_name_encode];
$file_path_real = "upload/$board/$view[path]/";
$file_path_down = "download/$board/$folder/";
$file_name_real = $view[file_1_name_real];
$file_path_full = $file_path_down.$file_name_real;
$file_code = "file_1_download";
copy("$file_path_real$file_name_encode", "$file_path_down$file_name_real");


} else if($code=="2") {
$file_name_encode = $view[file_2_name_encode];
$file_path_real = "upload/$board/$view[path]/";
$file_path_down = "download/$board/$folder/";
$file_name_real = $view[file_2_name_real];
$file_path_full = $file_path_down.$file_name_real;
$file_code = "file_2_download";
copy("$file_path_real$file_name_encode", "$file_path_down$file_name_real");
} else {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

	$file_exist=file_exists($file_path_full);

	if($file_exist==1)
	{
		$file_size=filesize($file_path_full);
		
		if($member[point]>=200 || $board=="bbs_pds_addon_1") {
			
			// 현재 시간
			$time = time();

			// 다운로더
		  mysql_query("update member set point=point-200 where no='$member[no]'", $dbconn);
			$code_1 = "54";
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
				mysql_query("update member set $log_point_p_1='$code_1' where no='$member[no]'", $dbconn);
				mysql_query("update member set $log_point_p_time_1='$time' where no='$member[no]'", $dbconn);
			} else {
				$r_1=2;
				for($q_1=1;$q_1<5;$q_1++) {
					$log_point_q_1 = "log_point_".$q_1;
					$log_point_r_1 = "log_point_".$r_1;
					$log_point_q_time_1 = "log_point_".$q_1."_time";
					$log_point_r_time_1 = "log_point_".$r_1."_time";
					mysql_query("update member set $log_point_q_1=$log_point_r_1 where no='$member[no]'", $dbconn);
					mysql_query("update member set $log_point_q_time_1=$log_point_r_time_1 where no='$member[no]'", $dbconn);
					$r_1++;
				}
				mysql_query("update member set log_point_5='$code_1' where no='$member[no]'", $dbconn);
				mysql_query("update member set log_point_5_time='$time' where no='$member[no]'", $dbconn);
			}
		  
		  
		  //업로더
		  mysql_query("update member set point=point+100 where no='$member_view[no]'", $dbconn);
			$code_2 = "4";
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
				mysql_query("update member set $log_point_p_2='$code_2' where no='$member_view[no]'", $dbconn);
				mysql_query("update member set $log_point_p_time_2='$time' where no='$member_view[no]'", $dbconn);
			} else {
				$r_2=2;
				for($q_2=1;$q_2<5;$q_2++) {
					$log_point_q_2 = "log_point_".$q_2;
					$log_point_r_2 = "log_point_".$r_2;
					$log_point_q_time_2 = "log_point_".$q_2."_time";
					$log_point_r_time_2 = "log_point_".$r_2."_time";
					mysql_query("update member set $log_point_q_2=$log_point_r_2 where no='$member_view[no]'", $dbconn);
					mysql_query("update member set $log_point_q_time_2=$log_point_r_time_2 where no='$member_view[no]'", $dbconn);
					$r_2++;
				}
				mysql_query("update member set log_point_5='$code_2' where no='$member_view[no]'", $dbconn);
				mysql_query("update member set log_point_5_time='$time' where no='$member_view[no]'", $dbconn);
			}
			
			// 다운횟수 증가
			mysql_query("update $board set $file_code=$file_code+1 where wno='$wno'", $dbconn);

		if (is_file($file_path_full)) {

    Header("Cache-Control: cache, must-revalidate, post-check=0, pre-check=0"); 
    Header("Content-type: application/x-msdownload"); 
    Header("Content-Length: ".(string)(filesize($file_path_full))); 
    Header("Content-Disposition: attachment; filename=".$file_name_real.""); 
    Header("Content-Description: PHP5 Generated Data"); 
    Header("Content-Transfer-incoding: utf-8");  
    Header("Content-Transfer-Encoding: binary");  
    Header("Pragma: no-cache"); 
    Header("Expires: 0"); 
    Header("Content-Description: File Transfer"); 

if (is_file($file_path_full)) {
  $fp = fopen($file_path_full, "rb"); 

if (!fpassthru($fp))  
    fclose($fp); 

} 
}else { 
  echo "<script>alert('해당 파일이나 경로가 존재하지 않습니다.');history.back();</script>"; 
}

	unlink($file_path_full);
	rmdir($file_path_down);
	
	
	
	



		
		} else {
		    echo "<script>alert(' 포인트가 부족하여 다운로드할 수 없습니다. ');parent.location.reload();</script>";exit;
		  }
	}
	else
	{
		  echo "<script>alert(' 해당 파일이 서버에 존재하지 않습니다. ');parent.location.reload();</script>";exit;
	}
?>-