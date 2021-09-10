<?

// 헤더파일 연결
include "../header.php";

// 변수 변환
$board = mysql_real_escape_string($_GET[board]);
$folder = mysql_real_escape_string($_GET[folder]);
$name = mysql_real_escape_string($_GET[name]);


// 경로 조작 검사
if(basename($board)!=$board) {
  echo "<script>location.href='$site_403';</script>"; exit;
}
// 경로 조작 검사
if(basename($folder)!=$folder) {
  echo "<script>location.href='$site_403';</script>"; exit;
}



// 경로 조작 검사
if(basename($name)!=$name) {
  echo "<script>location.href='$site_403';</script>"; exit;
}


$delete = "upload/$board/$folder/$name";
unlink($delete);


// 빈 폴더
$del_folder = "upload/$board/$folder";
rmdir($del_folder);

?>