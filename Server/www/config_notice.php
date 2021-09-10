<?

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

$notice_img_url = "bye.php";
$notice_img_title = "그동안 저를 따라주신 여러분께 감사의 말씀드립니다.";

//팁 게시판에 얼라 수장 이동 경로를 올렸습니다. 출발하시는 모든 분들은 필독하시기 바랍니다. <www.wowzer.kr>

// 긴급 공지
$notice_emergency = "1";
$notice_emergency_img = "0";
$notice_emergency_alert = "0";
$notice_emergency_alert_text = " 전투 정보실 오류로 인해 등업/변경 처리가 지연되고 있습니다. ";

// 게시판
$notice_1 = "1";
$notice_1_url = "bye.php";
$notice_1_title = "그동안 저를 따라주신 여러분께 감사의 말씀드립니다.";
$notice_1_writer = "티브";
$notice_1_time = "2010.12.23";

$notice_2 = "0";
$notice_2_url = "intro_4.php";
$notice_2_title = "(버그 2차수정) 길드 포인트 제도 페이지 재오픈 <img src=\"http://akeetes430.cdn2.cafe24.com/icon_new.gif\" border=\"0\" align=\"absmiddle\" style=\"width:20px; height:13px;\" alt=\"최근에 등록된 공지사항\">";
$notice_2_writer = "티브";
$notice_2_time = "2010.12.15";

$notice_3 = "0";
$notice_3_url = "home_1.php?mode=view&wno=24";
$notice_3_title = "계정 제재 조치 리스트 (2010.12.22) <img src=\"http://akeetes430.cdn2.cafe24.com/icon_new.gif\" border=\"0\" align=\"absmiddle\" style=\"width:20px; height:13px;\" alt=\"최근에 등록된 공지사항\">";
$notice_3_writer = "티브";
$notice_3_time = "2010.12.22";

$comment_notice = "";

// 제한선
$notice_xxxxxx_text_0 = "가가가가가가가가가가가가가가가가가가가가가가가가가가";
// <img src=\"http://akeetes430.cdn2.cafe24.com/icon_new.gif\" border=\"0\" align=\"absmiddle\" style=\"width:20px; height:13px;\" alt=\"최근에 등록된 공지사항\">";
// <font color=\"red\">

// 몰튼 공지
$notice_molten_title = "골드팟 길드 투표 (투표시 포인트 증정)";
$notice_molten_date = "2010.12.11";
$notice_molten_text_1 = "골드팟 논란을 끝내기 위한 투표입니다.";
$notice_molten_text_2 = "자세한 내용은 공지사항을 참고하세요.";
$notice_molten_text_3 = "";
$notice_molten_text_4 = "";
$notice_molten_url = "home_1.php?mode=view&wno=22";

// 홈피 공지
$notice_home_title = "홈페이지 2.1.0 대규모 패치";
$notice_home_date = "2010.12.13";
$notice_home_text_1 = "5주간 조금씩 진행하던 2.1.0 대규모 패치가";
$notice_home_text_2 = "드디어 완료하였습니다.";
$notice_home_text_3 = "자세한 내용은 공지사항을 참고하세요.";
$notice_home_text_4 = "";
$notice_home_url = "home_1.php?mode=view&wno=23";

// 포인트 상점 공지
$notice_shop_title = "칭호 아이템 가격 대폭 할인";
$notice_shop_date = "2010.10.10";
$notice_shop_text_1 = "";
$notice_shop_text_2 = "Silver 등업을 보다 쉽게 하기 위해 Silver 등업에 필수로 필요한";
$notice_shop_text_3 = "칭호 아이템을 이제 계속 저렴한 가격에 판매합니다.";
$notice_shop_text_4 = "";
$notice_shop_text_5 = "기존에 구매하신 분들도 칭호 아이템을 구매하셔서";
$notice_shop_text_6 = "보다 자주 변경하실 수 있습니다.";
$notice_shop_text_7 = "";
$notice_shop_text_8 = "감사합니다.";
$notice_shop_text_9 = "";


?>