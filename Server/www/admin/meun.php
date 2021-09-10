<?

// 헤더파일	연결
include	"../../header.php";

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);

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


$admin = mysql_fetch_array(mysql_query("select * from admin_log where no='1'",$dbconn));
$total = $admin[ok] + $admin[cancel];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html	lang="ko">

<head>

	<title><?	echo site_title; ?></title>
	<meta	http-equiv="content-type"	content="text/html;	charset=utf-8">
	<meta	http-equiv="Cache-Control" content="no-cache">
	<meta	http-equiv="Pragma"	content="no-cache">
	<meta	http-equiv="imagetoolbar"	content="no">
	<script	type="text/javascript" src="../inc_script.js"></script>
	<link rel="stylesheet" type="text/css" href="../inc_style.css">

</head>

<body onload="defence_off();" bgcolor="white" text="black" link="blue" vlink="blue" alink="blue">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

	<table border="1" style="width:100%;">
	    <tr style="width:100%;">
	        <td>
	        	<table border="0" style="width:100%;">
	        		<tr>
	        			<td>
	            		<br><p style="margin-left:10pt; margin-right:10pt;"><font face="Arial"><span style="font-size:20pt;">Eternal Soulmate ADMIN SYSTEM </span><span style="font-size:12pt;">
	            			(Ver 1.0.2)</span></font></p><br>
	          		</td>
	        			<td>
	            		<br><p style="margin-left:10pt; margin-right:10pt;" align="right"><font face="Gulim"><span style="font-size:9pt;">
	            			<strong>티브</strong>(총 <?=$admin[tive]?>개처리) / <strong>블랙</strong>(총 <?=$admin[foxhound]?>개처리) / <strong>프리마</strong>(총 <?=$admin[prima]?>개처리) / <strong>푸</strong>(총 <?=$admin[gksgidrl]?>개처리)<br><strong>전체처리</strong>: 총 <?=$total?>개 / 승인: 총 <?=$admin[ok]?>개 / 거부: 총 <?=$admin[cancel]?>개<br><font color="red">새로고침을 눌러야 기록이 업데이트됩니다.</font> <font color="blue"><a href="meun.php" target="top">[새로고침]</font>
	            		</span></font></p><br>
	          </td>
	        </tr>
	      </table>
	        </td>
	    </tr>
	    <tr>
	        <td style="width:100%;">
	            <p align="center"><span style="font-size:9pt;"><br><a href="../member_logout.php" target="_top">로그아웃</a></span><font face="굴림"><span style="font-size:9pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.wowzer.kr/" target="_top">홈</a>&nbsp;&nbsp;&nbsp;&nbsp;공지사항 설정 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;실시간 제어 설정&nbsp;&nbsp;&nbsp;&nbsp;게시판 권한 설정&nbsp;&nbsp;&nbsp;&nbsp;등업 신청 처리(<a href="level_main_1.php" target="bottom">메인</a>/<a href="level_sub_1.php" target="bottom">서브</a>)&nbsp;&nbsp;&nbsp;&nbsp;변경 요청 처리(<a href="change_skill_1.php" target="bottom">전문기술</a>/<a href="change_main_1.php" target="bottom">메인캐릭터</a>)&nbsp;&nbsp;&nbsp;&nbsp;계정 처리&nbsp;&nbsp;&nbsp;&nbsp;<a href="../admin_bbs.php" target="bottom">운영진 게시판</a></span></font><span style="font-size:9pt;"><br><br></span></p>
	        </td>
	    </tr>
	</table>
	
</body>

</html>