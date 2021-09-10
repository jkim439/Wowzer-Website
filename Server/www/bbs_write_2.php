<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_POST[url]);
$board = mysql_real_escape_string($_POST[board]);
$folder = mysql_real_escape_string($_POST[folder]);
$category = mysql_real_escape_string($_POST[category]);
$goldbox = mysql_real_escape_string($_POST[goldbox]);
$title = mysql_real_escape_string($_POST[title]);
$text = mysql_real_escape_string($_POST[text]);
$img_num = mysql_real_escape_string($_POST[img_num]);
$imgupload = $_POST[imgupload];
$file_1_name = mysql_real_escape_string($_FILES[file_1][name]);
$file_1_type = mysql_real_escape_string($_FILES[file_1][type]);
$file_1_size = mysql_real_escape_string($_FILES[file_1][size]);
$file_2_name = mysql_real_escape_string($_FILES[file_2][name]);
$file_2_type = mysql_real_escape_string($_FILES[file_2][type]);
$file_2_size = mysql_real_escape_string($_FILES[file_2][size]);

// 게시판 환경설정 연결
include "config_bbs.php";

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

// 쓰기 권한 확인
if($write_permission>$member[level]) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 업로드 용량
$file_max_size = "6291456";
$file_max_size_view = "6MB를";

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

// 데이터베이스 로드
$write_db = mysql_query("SELECT MAX(wno) AS wno, MAX(num) AS num FROM $board", $dbconn);

// 최대값 로드
$ist[wno] = mysql_result($write_db, 0, "wno");
$ist[wno] += 1;
$ist[num] = mysql_result($write_db, 0, "num");
$ist[num] += 1;

mysql_free_result($write_db);

// 파일 #1 업로드
if($file_1_size>0) {

	// 용량 검사
	if($file_1_size>$file_max_size) {
		echo "<script>alert(' 파일 첨부 #1의 용량이 $file_max_size_view 초과합니다. ');</script>";exit;
	} else {

		// 확장자 검사
		if(eregi("\.jpg$|\.gif$|\.bmp$|\.png$",$file_1_name)) {
			echo "<script>alert(' 이미지 파일은 이미지 업로드 기능을 이용하세요. ');</script>";exit;
		}
		if(!eregi("\.wtf$|\.exe$|\.zip$|\.hwp$|\.xls$|\.xlsx$|\.doc$|\.docx$|\.alz$|\.a00$|\.a01$|\.a02$|\.a03$|\.a04$|\.egg$|\.vol1$|\.vol2$|\.vol3$|\.vol4$|\.vol5$",$file_1_name)) {
			echo "<script>alert(' 업로드할 수 없는 확장자입니다. ');</script>";exit;
		} else {
      
			// 이름 검사
			$file_1_name_unsecure = substr($file_1_name, 0, strrpos($file_1_name, ".")+0);
			preg_match_all('/[A-Z]|[a-z]|[0-9]/', $file_1_name_unsecure, $file_1_name_unsecure_spell);
			$file_1_name_secure = implode('', $file_1_name_unsecure_spell[0]);
			if($file_1_name_unsecure != $file_1_name_secure){
				echo "<script>alert(' 파일 이름에는 영어와 숫자만 있어야 합니다. ');</script>";exit;
			} else {

				// 파일 이름 암호화
				$file_1_name_encode = md5($file_1_name.$member[login_key]);

				// 파일 업로드
				$dir_file_1 = "upload/$board/$folder//".$file_1_name_encode;
				if($img_num=="0") {
						clearstatcache();
						mkdir("upload/$board/$folder", 0755);
				}
				if(move_uploaded_file($_FILES[file_1][tmp_name], $dir_file_1)) {
					clearstatcache();
				} else {
					echo "<script>alert(' 파일 업로드 중 오류가 발생하였습니다. ');</script>";exit;
				}
			}
		}
	}
} else {
    // 파일 #1 업로드 없음
			$file_1_name_encode = "0";
			$file_1_name = "0";
      $file_1_size = "0";
}

// 파일 #2 업로드
if($file_2_size>0) {

	
	if($file_1_size=="0") {
		echo "<script>alert(' 파일 첨부 #1을 먼저 이용하시기 바랍니다. ');</script>";exit;
	}

	// 용량 검사
	if($file_2_size>$file_max_size) {
		echo "<script>alert(' 파일 첨부 #2의 용량이 $file_max_size_view 초과합니다. ');</script>";exit;
	} else {

		// 확장자 검사
		if(eregi("\.jpg$|\.gif$|\.bmp$|\.png$",$file_2_name)) {
			echo "<script>alert(' 이미지 파일은 이미지 업로드 기능을 이용하세요. ');</script>";exit;
		}
		if(!eregi("\.wtf$|\.exe$|\.jar$|\.tar$|\.arj$|\.rar$|\.7z$|\.zip$|\.hwp$|\.xls$|\.xlsx$|\.doc$|\.docx$|\.alz$|\.a00$|\.a01$|\.a02$|\.a03$|\.a04$|\.egg$|\.vol1$|\.vol2$|\.vol3$|\.vol4$|\.vol5$",$file_2_name)) {
			echo "<script>alert(' 업로드할 수 없는 확장자입니다. ');</script>";exit;
		} else {
      
			// 이름 검사
			$file_2_name_unsecure = substr($file_2_name, 0, strrpos($file_2_name, ".")+0);
			preg_match_all('/[A-Z]|[a-z]|[0-9]/', $file_2_name_unsecure, $file_2_name_unsecure_spell);
			$file_2_name_secure = implode('', $file_2_name_unsecure_spell[0]);
			if($file_2_name_unsecure != $file_2_name_secure){
				echo "<script>alert(' 파일 이름에는 영어와 숫자만 있어야 합니다. ');</script>";exit;
			} else {
				
				// 파일 이름 암호화
				$file_2_name_encode = md5($file_2_name.$member[login_key]);

				// 파일 업로드
				$dir_file_2 = "upload/$board/$folder//".$file_2_name_encode;

				if(move_uploaded_file($_FILES[file_2][tmp_name], $dir_file_2)) {
					clearstatcache();
				} else {
					echo "<script>alert(' 파일 업로드 중 오류가 발생하였습니다. ');</script>";exit;
				}
			}
		}
	}
} else {
    // 파일 #2 업로드 없음
			$file_2_name_encode = "0";
			$file_2_name = "0";
      $file_2_size = "0";
}
/*
// 포인트 기록 시스템
$code = "1";
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

// 글쓰기 보상
mysql_query("update member set point=point+$point_write where no='$member[no]'", $dbconn);
*/
// 데이터 삽입
mysql_query("INSERT INTO $board VALUES('', '$ist[num]', '$member[no]', '$category', '$title', '$text', '$goldbox', '0', '$time', '$folder', '$file_1_name_encode', '$file_1_name', '$file_1_size', '0', '$file_2_name_encode', '$file_2_name', '$file_2_size', '0')", $dbconn);
if($img_num>0) {
mysql_query("DELETE FROM upload_folder WHERE board='$board' and folder='$folder'", $dbconn);
}

// 화면 이동
if($board=="bbs_confirm") {
	echo "<script>alert(' 스크린 샷을 올린 후 등업 신청을 해주셔야 합니다. \\n\\n 지금 바로 등업 신청을 해주십시오. ');</script>";
}
echo "<script>parent.location.href='$url'</script>";

?>