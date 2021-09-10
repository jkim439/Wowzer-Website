<?

// 헤더파일 연결
include "../../header.php";

// 세션키 검사
if(!$_SESSION[key] || $_SESSION[key]!=$member[logkey]) {
  echo "<script>location.href='$site_403';</script>"; exit;
}

// 변수 변환
$board = mysql_real_escape_string($_GET[board]);
$wno = mysql_real_escape_string($_GET[wno]);
$file = mysql_real_escape_string($_GET[file]);

// 경로 조작 검사
if(basename($board)!=$board) {
  //echo "<script>location.href='$site_403';</script>"; exit;
}
if(basename($wno)!=$wno) {
  //echo "<script>location.href='$site_403';</script>"; exit;
}
if(basename($file)!=$file) {
  //echo "<script>location.href='$site_403';</script>"; exit;
}

// 업로드 폴더
$type = "img";
$folder = md5($board.$wno.$type);


$src = 'upload/bbs10/temp/1279121465492/2.jpg';//원본파일
$mark ='test.png';//워터마크에 사용할 파일

$font_size = 28; // 글자 크기 
$opacity = 70; // 투명도 높을수록 불투명 
$font_path = "gulim.ttf";  //폰트 패스 
$string = "www.wowzer.kr";  // 찍을 워터마크 

$image = "upload/bbs10/temp/1279121465492/2.jpg"; 

$image_name = explode(".",$image); 
$image_targ = $image_name[0]."_marked.jpg";  // 워터마크가 찍혀 저장될 이미지 

$image_org = $image; // 원본 이미지를 다른 이름으로 저장 
$image = imagecreatefromjpeg($image); // JPG 이미지를 읽고 

$w = imagesx($image); 
$h = imagesy($image);  

$text_color = imagecolorallocate($image,0,0,0); // 텍스트 컬러 지정 

// 적당히 워터마크가 붙을 위치를 지정 
$text_pos_x = $font_size; 
$text_pos_y = $h - $font_size; 

imagettftext($image, $font_size, 0, $text_pos_x, $text_pos_y, $text_color, $font_path, $string);  // 읽은 이미지에 워터마크를 찍고 

$image_org = imagecreatefromjpeg($image_org); // 원본 이미지를 다시한번 읽고 
  
imagecopymerge($image,$image_org,0,0,0,0,$w,$h,$opacity); // 원본과 워터마크를 찍은 이미지를 적당한 투명도로 겹치기 

imagejpeg($image, $image_targ, 90); // 이미지 저장. 해상도는 90 정도 
  
imagedestroy($image); 
imagedestroy($image_org); 


echo "<center><img src=$image_targ></center>"; // 워터마크가 찍혀 저장된 이미지 출력 













 


/*
resource $src_im 원본이미지의 리소스
resource $mark_im 워터마크에 사용될 이미지의 리소스
int $src_x 원본에 워터마크가 겹쳐질 기준점의 x 좌표, 양의 정수만 사용
int $src_y 원본에 워터마크가 겹쳐질 기준점의 y 좌표, 양의 정수만 사용
int $mark_x 워터마크에 사용될 이미지의 복사 기준점의 x좌표, 양의 정수만 사용
int $mark_y 워터마크에 사용될 이미지의 복사 기준점의 y좌표, 양의 정수만 사용
int $mark_w 워터마크에 사용될 이미지의 복사영역의 너비, 양의 정수만 사용
int $mark_h 워터마크에 사용될 이미지의 복사영역의 높이, 양의 정수만 사용
int $pct 선명도, 0 에서 100 까지의 양의 정수만 사용, 100 이면 원본 그대로이고 숫자가 작아질수록 투명도가 증가

[출처] [PHP중급]이미지에 워터마크 처리하기 (웹+스마트폰어플 기획 스터디[3A PLUS]) |작성자 상덕JOUM


*/

?>
<html>

<head>

	<title><? echo site_title; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="imagetoolbar" content="no">

  <script language=javascript src="../script.js"></script>
  <noscript><style>body{display:none}</style></noscript>
</head>

<body style="cursor:pointer;" onclick="window.close();" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" onpropertychange="defence();" oncontextmenu="return false" link="#441D01" vlink="#441D01" alink="#441D01">

<center><!--<img src="upload/<?=$board?>/<?=$wno?>/<?=$folder?>/<?=$file?>">-->

</center>

</body></html>