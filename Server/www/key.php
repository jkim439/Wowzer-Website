<?

$keycode4 = $_GET[keycode4];
$keycode1 = "4y89y54wun8her459kyg6uh35ygmepzg";
$keycode2 = md5($keycode1.$keycode4.$keycode1);
$keycode3 = mb_substr($keycode2,10,5,'UTF-8');

header("Content-type:image/png");


    $width= "110";
    $height="60";
        $im = imagecreate($width,$height);

        $white = imagecolorallocate($im,255,255,255);
        $black = imagecolorallocate($im,0,0,0);

        // 원그리기 시작위치y 시작위치x 크기 x 크기 y
        for($i=5;$i<=105;$i+=rand(1,1)){ // 가로 시작점
        $f = rand(1,59);    // 세로 시작점
        $b = rand(1,2);        // 원의 크기
        ImageArc ($im, $i, $f, $b, $b, 0, 360, $black); // 원 그리기
        ImageFill ($im, $i, $f, $black); //그린원에 색채우기
    }
            // 격자 무늬 넣기
    $num = rand(0,5);
        for ($i=$num; $i<=$width; $i+=rand(4,7)){  // 가로 선
            imageline($im,$i,0,$i,$height,$black);
        }

        for ($i=$num; $i<=$height+10; $i+=rand(3,6)){ //세로 선
            imageline($im,0,$i,$width,$i,$black);
    }

                // 문자 만들기
                $size = rand(25,30);
                $angle = rand(9,20);
                $x = rand(10,15);
                $y =rand(50,55);
    imagettftext($im, $size, $angle, $x, $y, $black, 'contents/key.ttf', iconv("EUC-KR","UTF-8",$keycode3));
        imagepng($im);
        imagedestroy($im);

?>