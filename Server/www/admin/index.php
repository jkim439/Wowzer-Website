<?

// 헤더파일	연결
include	"../../header.php";

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');top.location.href='http://www.wowzer.kr/';</script>"; exit;
}
/*
// 관리자 확인
if(!$_SESSION[wowzer_admin] || $_SESSION[wowzer_admin]!=$member[admin_type]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');top.location.href='http://www.wowzer.kr/';</script>"; exit;
}
*/
if($member[level]<5) {
	session_destroy();
	echo "<script>top.location.href='http://www.wowzer.kr/error_403.php';</script>"; exit;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html	lang="ko">

<head>

	<title><?	echo site_title; ?> (관리자)</title>
	<meta	http-equiv="content-type"	content="text/html;	charset=utf-8">
	<meta	http-equiv="Cache-Control" content="no-cache">
	<meta	http-equiv="Pragma"	content="no-cache">
	<meta	http-equiv="imagetoolbar"	content="no">

</head>

	<frameset rows="120, 1*" cols="1*">
		<frame name="top" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="meun.php">
		<frame name="bottom" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" src="../admin_bbs.php">
		<noframes><center><font face="Gulim" color="black"><br><br><?	echo site_frame_msg; ?><br><br></font></center></noframes>
	</frameset>

</html>