<?

// 전역 변수
global $board;

// bbs_admin
if($board=="bbs_admin") {
$category = "5";
$category_1 = "문의";
$category_2 = "건의";
$category_3 = "신고";
$category_4 = "기타";
$category_5 = "공지";
$view_permission = "5";
$write_permission = "5";
$comment_permission = "5";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_notice
if($board=="bbs_notice") {
$category = "2";
$category_1 = "몰튼";
$category_2 = "홈피";
$category_3 = "";
$category_4 = "";
$category_5 = "";
$view_permission = "0";
$write_permission = "6";
$comment_permission = "2";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_confirm
if($board=="bbs_confirm") {
$category = "3";
$category_1 = "Bronze로";
$category_2 = "Silver로";
$category_3 = "Gold로";
$category_4 = "";
$category_5 = "";
$view_permission = "6";
$write_permission = "6";
$comment_permission = "6";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_tip_beginner
if($board=="bbs_tip_beginner") {
$category = "5";
$category_1 = "길드";
$category_2 = "육성";
$category_3 = "보트";
$category_4 = "편의";
$category_5 = "기타";
$view_permission = "1";
$write_permission = "2";
$comment_permission = "1";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_faq
if($board=="bbs_faq") {
$category = "5";
$category_1 = "길드";
$category_2 = "접속";
$category_3 = "보트";
$category_4 = "애드온";
$category_5 = "기타";
$view_permission = "1";
$write_permission = "2";
$comment_permission = "1";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_pds_addon_1
if($board=="bbs_pds_addon_1") {
$category = "1";
$category_1 = "필수";
$category_2 = "";
$category_3 = "";
$category_4 = "";
$category_5 = "";
$view_permission = "1";
$write_permission = "5";
$comment_permission = "1";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_pds_addon_2
if($board=="bbs_pds_addon_2") {
$category = "5";
$category_1 = "퀘스트";
$category_2 = "디자인";
$category_3 = "아이템";
$category_4 = "전문기술";
$category_5 = "기타";
$view_permission = "2";
$write_permission = "2";
$comment_permission = "2";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_screen
if($board=="bbs_screen") {
$category = "5";
$category_1 = "기쁨";
$category_2 = "슬픔";
$category_3 = "놀라움";
$category_4 = "신기함";
$category_5 = "기타";
$view_permission = "2";
$write_permission = "2";
$comment_permission = "2";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_pds_etc
if($board=="bbs_pds_etc") {
$category = "1";
$category_1 = "파일";
$category_2 = "";
$category_3 = "";
$category_4 = "";
$category_5 = "";
$view_permission = "2";
$write_permission = "2";
$comment_permission = "2";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_free
if($board=="bbs_free") {
$category = "3";
$category_1 = "잡담";
$category_2 = "접속";
$category_3 = "소식";
$category_4 = "";
$category_5 = "";
$view_permission = "2";
$write_permission = "2";
$comment_permission = "2";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_qna
if($board=="bbs_qna") {
$category = "5";
$category_1 = "접속";
$category_2 = "평판";
$category_3 = "아이템";
$category_4 = "퀘스트";
$category_5 = "기타";
$view_permission = "1";
$write_permission = "1";
$comment_permission = "1";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_tip
if($board=="bbs_tip") {
$category = "5";
$category_1 = "골드";
$category_2 = "평판";
$category_3 = "아이템";
$category_4 = "전문기술";
$category_5 = "기타";
$view_permission = "2";
$write_permission = "2";
$comment_permission = "2";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_greeting
if($board=="bbs_greeting") {
$category = "1";
$category_1 = "인사";
$category_2 = "";
$category_3 = "";
$category_4 = "";
$category_5 = "";
$view_permission = "1";
$write_permission = "1";
$comment_permission = "1";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_suggestion
if($board=="bbs_suggestion") {
$category = "3";
$category_1 = "홈피";
$category_2 = "길드";
$category_3 = "기타";
$category_4 = "";
$category_5 = "";
$view_permission = "2";
$write_permission = "2";
$comment_permission = "2";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_report
if($board=="bbs_report") {
$category = "1";
$category_1 = "신고";
$category_2 = "";
$category_3 = "";
$category_4 = "";
$category_5 = "";
$view_permission = "2";
$write_permission = "2";
$comment_permission = "2";
$anonymous = "1";
$point_write = "0";
$point_comment = "0";
}

// bbs_discussion
if($board=="bbs_discussion") {
$category = "4";
$category_1 = "게임";
$category_2 = "홈피";
$category_3 = "길드";
$category_4 = "기타";
$category_5 = "";
$view_permission = "2";
$write_permission = "2";
$comment_permission = "2";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_vip
if($board=="bbs_vip") {
$category = "1";
$category_1 = "기타";
$category_2 = "";
$category_3 = "";
$category_4 = "";
$category_5 = "";
$view_permission = "3";
$write_permission = "3";
$comment_permission = "3";
$anonymous = "0";
$point_write = "0";
$point_comment = "0";
}

// bbs_
if($board=="bbs_") {
$category = "";
$category_1 = "";
$category_2 = "";
$category_3 = "";
$category_4 = "";
$category_5 = "";
$view_permission = "";
$write_permission = "";
$comment_permission = "";
$anonymous = "0";
}

?>