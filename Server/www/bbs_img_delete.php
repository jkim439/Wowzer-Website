<?

// ������� ����
include "../header.php";

// ���� ��ȯ
$board = mysql_real_escape_string($_GET[board]);
$folder = mysql_real_escape_string($_GET[folder]);
$name = mysql_real_escape_string($_GET[name]);


// ��� ���� �˻�
if(basename($board)!=$board) {
  echo "<script>location.href='$site_403';</script>"; exit;
}
// ��� ���� �˻�
if(basename($folder)!=$folder) {
  echo "<script>location.href='$site_403';</script>"; exit;
}



// ��� ���� �˻�
if(basename($name)!=$name) {
  echo "<script>location.href='$site_403';</script>"; exit;
}


$delete = "upload/$board/$folder/$name";
unlink($delete);


// �� ����
$del_folder = "upload/$board/$folder";
rmdir($del_folder);

?>