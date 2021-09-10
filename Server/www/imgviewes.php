<?

header("Content-type: image/jpeg"); 

$code = $_GET[code];
$board = $_GET[board];
$name = $_GET[name];

# 이미지 실제경로 그리고 이미지 이름 
$url = "upload/$board/$code/$name";

$fp = fopen($url,"r"); 
$img_data = fread($fp,filesize($url)); 
fclose($fp); 

echo $img_data; 


?> 