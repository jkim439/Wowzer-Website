<?

// 서비스 시작
session_start();

// 세션 삭제
session_destroy();

// 페이지 이동
echo "<script>top.location.href='http://www.wowzer.kr/';</script>";

?>