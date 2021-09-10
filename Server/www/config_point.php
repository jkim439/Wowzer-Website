<?

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

$log_point_code_1 = "<font color=\"blue\"><strong>[적립]</strong></font> 글쓰기 포인트";
$log_point_code_2 = "<font color=\"blue\"><strong>[적립]</strong></font> 로그인 포인트 <font color=\"blue\">(+300)</font>";
$log_point_code_3 = "<font color=\"blue\"><strong>[적립]</strong></font> 댓글 포인트 <font color=\"blue\">(+100)</font>";
$log_point_code_4 = "<font color=\"blue\"><strong>[적립]</strong></font> 업로드 수익 포인트 <font color=\"blue\">(+100)</font>";
$log_point_code_5 = "<font color=\"blue\"><strong>[적립]</strong></font> Bronze 등업 포인트 <font color=\"blue\">(+2000)</font>";
$log_point_code_6 = "<font color=\"blue\"><strong>[적립]</strong></font> Silver 등업 포인트 <font color=\"blue\">(+3000)</font>";
$log_point_code_7 = "<font color=\"blue\"><strong>[적립]</strong></font> Gold 등업 포인트 <font color=\"blue\">(+4000)</font>";
$log_point_code_8 = "<font color=\"blue\"><strong>[적립]</strong></font> Silver 등업 포인트 (추천인 등록 보너스) <font color=\"blue\">(+2000)</font>";
$log_point_code_9 = "<font color=\"blue\"><strong>[적립]</strong></font> Gold 등업 포인트 (추천인 등록 보너스) <font color=\"blue\">(+3000)</font>";
//$log_point_code_10 = "<font color=\"blue\"><strong>[적립]</strong></font> 신고 포상 포인트 <font color=\"blue\">(+2000)</font>";

$log_point_code_51 = "<font color=\"red\"><strong>[사용]</strong></font> 아이템 구매 포인트 (포인트 상점)";
$log_point_code_52 = "<font color=\"red\"><strong>[사용]</strong></font> 글쓰기 삭제 포인트 <font color=\"red\">(-500)</font>";
$log_point_code_53 = "<font color=\"red\"><strong>[사용]</strong></font> 댓글 삭제 포인트 <font color=\"red\">(-100)</font>";
$log_point_code_54 = "<font color=\"red\"><strong>[사용]</strong></font> 다운로드 포인트 <font color=\"red\">(-200)</font>";
$log_point_code_55 = "<font color=\"red\"><strong>[사용]</strong></font> 닉네임 변경 포인트 <font color=\"red\">(-2000)</font>";
$log_point_code_56 = "<font color=\"red\"><strong>[사용]</strong></font> 메인 캐릭터 변경 포인트 <font color=\"red\">(-4000)</font>";
$log_point_code_57 = "<font color=\"red\"><strong>[사용]</strong></font> 글 복사 포인트 <font color=\"red\">(-600)</font>";

?>