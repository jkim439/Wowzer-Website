<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

// 최근 게시물 로드
$result_free = mysql_query("SELECT * FROM bbs_free ORDER BY num DESC LIMIT 5", $dbconn);
$result_qna = mysql_query("SELECT * FROM bbs_qna ORDER BY num DESC LIMIT 5", $dbconn);
$result_tip = mysql_query("SELECT * FROM bbs_tip ORDER BY num DESC LIMIT 5", $dbconn);
$result_screen = mysql_query("SELECT * FROM bbs_screen ORDER BY num DESC LIMIT 5", $dbconn);
$result_discussion = mysql_query("SELECT * FROM bbs_discussion ORDER BY num DESC LIMIT 5", $dbconn);
$result_greeting = mysql_query("SELECT * FROM bbs_greeting ORDER BY num DESC LIMIT 5", $dbconn);
$result_vip = mysql_query("SELECT * FROM bbs_vip ORDER BY num DESC LIMIT 5", $dbconn);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html	lang="ko">

<head>

	<title><?	echo site_title; ?></title>
	<meta	http-equiv="content-type"	content="text/html;	charset=utf-8">
	<meta	http-equiv="Cache-Control" content="no-cache">
	<meta	http-equiv="Pragma"	content="no-cache">
	<meta	http-equiv="imagetoolbar"	content="no">
	<script	type="text/javascript" src="inc_script.js"></script>
	<link rel="stylesheet" type="text/css" href="inc_style.css">

</head>

<body	background="http://akeetes430.cdn2.cafe24.com/bg.gif" onload="java_check();frame_check();" onpropertychange="defence_check();" oncontextmenu="return false;">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

	<center><br>
	<table id="layout" border="0" cellspacing="0" cellpadding="0" style="display:none;">
		<tr>
			<td	id="layout_border_top" colspan="4"></td>
		</tr>
		<tr>
			<td	id="layout_border_left" rowspan="3"></td>
			<td	id="layout_header" colspan="2"></td>
			<td	id="layout_border_right" rowspan="3"></td>
		</tr>
		<tr>
			<td	id="layout_meun" colspan="2">
				<? include "inc_meun.php"; ?>
			</td>
		</tr>
		<tr>
			<td	id="layout_left"	valign="top">
				<table id="layout_left_" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td id="layout_left_login">
							<? include "inc_login.php"; ?>
						</td>
					</tr>
					<tr>
						<td id="layout_left_submeun_top" style="background-image:url('http://akeetes430.cdn2.cafe24.com/submeun_5.gif');"></td>
					</tr>
					<tr>
						<td	id="layout_left_submeun_bottom"	valign="top">
							<? include "community_meun.php"; ?>
						</td>
					</tr>
				</table>
			</td>
			<td	id="layout_right">
				<table id="layout_right_"	border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_5_0.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br>
							<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<script type="text/javascript">
									<!--
									google_ad_client = "ca-pub-8506472453970244";
									/* title */
									google_ad_slot = "0177202610";
									google_ad_width = 728;
									google_ad_height = 90;
									//-->
								</script>
								<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script><br>
							</span></font></p>
							<p align="center"><font	face="Gulim"><span style="font-size:9pt;">
								<br>
								<table style="width:690px; height:200px;"	border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:345px; height:50px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_5_1.gif');"></td>
										<td style="width:345px; height:50px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_5_2.gif');"></td>
									</tr>
									<tr>
										<td style="width:345px; height:150px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_red.gif');">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#370909"><span style="font-size:9pt;">
										<?
												while($list = mysql_fetch_array($result_free)) {

													$time = time();
													$time_write = $time-$list[time];
													if($time_write<=86400) {
														$new = 1;
													} else {
														$new = 0;
													}

													// 제목 생략
													$title_length = mb_strlen($list[title], 'UTF-8');
													if($title_length>22) {
														$title = mb_substr($list[title], 0, 22, 'UTF-8');
														$title = $title.'...';
													} else {
														$title = $list[title];
													}
												?>
											<img align="absmiddle" src="http://akeetes430.cdn2.cafe24.com/circle_red.gif"	style="width:6px; height:6px;" border="0" alt="">
											<a href="#" target="_self" onclick="self.location.href='community_1.php?mode=view&wno=<?=$list[wno]?>';" title="<?=$list[title]?>"><font color="#370909"><?if($new=="1"){?><strong><?=$title?></strong><?}else{?><?=$title?><?}?></font></a> <?if($new=="1"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_new.gif" align="absmiddle" style="width:20px; height:13px;" alt="새 글"><?}?><br><br><?}?>
											</span></font></p>
										</td>
										<td style="width:345px; height:150px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_blue.gif');">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#05383e"><span style="font-size:9pt;">
										<?
												while($list = mysql_fetch_array($result_qna)) {

													$time = time();
													$time_write = $time-$list[time];
													if($time_write<=86400) {
														$new = 1;
													} else {
														$new = 0;
													}

													// 제목 생략
													$title_length = mb_strlen($list[title], 'UTF-8');
													if($title_length>22) {
														$title = mb_substr($list[title], 0, 22, 'UTF-8');
														$title = $title.'...';
													} else {
														$title = $list[title];
													}
												?>
											<img align="absmiddle" src="http://akeetes430.cdn2.cafe24.com/circle_blue.gif"	style="width:6px; height:6px;" border="0" alt="">
											<a href="#" target="_self" onclick="self.location.href='community_2.php?mode=view&wno=<?=$list[wno]?>';" title="<?=$list[title]?>"><font color="#370909"><?if($new=="1"){?><strong><?=$title?></strong><?}else{?><?=$title?><?}?></font></a> <?if($new=="1"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_new.gif" align="absmiddle" style="width:20px; height:13px;" alt="새 글"><?}?><br><br><?}?>
											</span></font></p>
										</td>
									</tr>
									<tr>
										<td style="width:345px; height:50px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_5_3.gif');"></td>
										<td style="width:345px; height:50px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_5_4.gif');"></td>
									</tr>
									<tr>
										<td style="width:345px; height:150px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_blue.gif');">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#370909"><span style="font-size:9pt;">
										<?
												while($list = mysql_fetch_array($result_tip)) {

													$time = time();
													$time_write = $time-$list[time];
													if($time_write<=86400) {
														$new = 1;
													} else {
														$new = 0;
													}

													// 제목 생략
													$title_length = mb_strlen($list[title], 'UTF-8');
													if($title_length>22) {
														$title = mb_substr($list[title], 0, 22, 'UTF-8');
														$title = $title.'...';
													} else {
														$title = $list[title];
													}
												?>
											<img align="absmiddle" src="http://akeetes430.cdn2.cafe24.com/circle_blue.gif"	style="width:6px; height:6px;" border="0" alt="">
											<a href="#" target="_self" onclick="self.location.href='community_3.php?mode=view&wno=<?=$list[wno]?>';" title="<?=$list[title]?>"><font color="#370909"><?if($new=="1"){?><strong><?=$title?></strong><?}else{?><?=$title?><?}?></font></a> <?if($new=="1"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_new.gif" align="absmiddle" style="width:20px; height:13px;" alt="새 글"><?}?><br><br><?}?>
											</span></font></p>
										</td>
										<td style="width:345px; height:150px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_red.gif');">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#05383e"><span style="font-size:9pt;">
										<?
												while($list = mysql_fetch_array($result_screen)) {

													$time = time();
													$time_write = $time-$list[time];
													if($time_write<=86400) {
														$new = 1;
													} else {
														$new = 0;
													}

													// 제목 생략
													$title_length = mb_strlen($list[title], 'UTF-8');
													if($title_length>22) {
														$title = mb_substr($list[title], 0, 22, 'UTF-8');
														$title = $title.'...';
													} else {
														$title = $list[title];
													}
												?>
											<img align="absmiddle" src="http://akeetes430.cdn2.cafe24.com/circle_red.gif"	style="width:6px; height:6px;" border="0" alt="">
											<a href="#" target="_self" onclick="self.location.href='community_4.php?mode=view&wno=<?=$list[wno]?>';" title="<?=$list[title]?>"><font color="#370909"><?if($new=="1"){?><strong><?=$title?></strong><?}else{?><?=$title?><?}?></font></a> <?if($new=="1"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_new.gif" align="absmiddle" style="width:20px; height:13px;" alt="새 글"><?}?><br><br><?}?>
											</span></font></p>
										</td>
									</tr>									<tr>
										<td style="width:345px; height:50px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_5_5.gif');"></td>
										<td style="width:345px; height:50px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_5_6.gif');"></td>
									</tr>
									<tr>
										<td style="width:345px; height:150px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_red.gif');">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#370909"><span style="font-size:9pt;">
										<?
												while($list = mysql_fetch_array($result_discussion)) {

													$time = time();
													$time_write = $time-$list[time];
													if($time_write<=86400) {
														$new = 1;
													} else {
														$new = 0;
													}

													// 제목 생략
													$title_length = mb_strlen($list[title], 'UTF-8');
													if($title_length>22) {
														$title = mb_substr($list[title], 0, 22, 'UTF-8');
														$title = $title.'...';
													} else {
														$title = $list[title];
													}
												?>
											<img align="absmiddle" src="http://akeetes430.cdn2.cafe24.com/circle_red.gif"	style="width:6px; height:6px;" border="0" alt="">
											<a href="#" target="_self" onclick="self.location.href='community_5.php?mode=view&wno=<?=$list[wno]?>';" title="<?=$list[title]?>"><font color="#370909"><?if($new=="1"){?><strong><?=$title?></strong><?}else{?><?=$title?><?}?></font></a> <?if($new=="1"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_new.gif" align="absmiddle" style="width:20px; height:13px;" alt="새 글"><?}?><br><br><?}?>
											</span></font></p>
										</td>
										<td style="width:345px; height:150px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_blue.gif');">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#05383e"><span style="font-size:9pt;">
										<?
												while($list = mysql_fetch_array($result_greeting)) {

													$time = time();
													$time_write = $time-$list[time];
													if($time_write<=86400) {
														$new = 1;
													} else {
														$new = 0;
													}

													// 제목 생략
													$title_length = mb_strlen($list[title], 'UTF-8');
													if($title_length>22) {
														$title = mb_substr($list[title], 0, 22, 'UTF-8');
														$title = $title.'...';
													} else {
														$title = $list[title];
													}
												?>
											<img align="absmiddle" src="http://akeetes430.cdn2.cafe24.com/circle_blue.gif"	style="width:6px; height:6px;" border="0" alt="">
											<a href="#" target="_self" onclick="self.location.href='community_6.php?mode=view&wno=<?=$list[wno]?>';" title="<?=$list[title]?>"><font color="#370909"><?if($new=="1"){?><strong><?=$title?></strong><?}else{?><?=$title?><?}?></font></a> <?if($new=="1"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_new.gif" align="absmiddle" style="width:20px; height:13px;" alt="새 글"><?}?><br><br><?}?>
											</span></font></p>
										</td>
									</tr>
									<?if($member[level]>2){?>
									<tr>
										<td style="width:345px; height:50px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_5_7.gif');"></td>
										<td style="width:345px; height:200px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_green.gif');" rowspan="2"></td>
									</tr>
									<tr><td style="width:345px; height:150px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_blue.gif');">
											<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#05383e"><span style="font-size:9pt;">
										<?
												while($list = mysql_fetch_array($result_vip)) {

													$time = time();
													$time_write = $time-$list[time];
													if($time_write<=86400) {
														$new = 1;
													} else {
														$new = 0;
													}

													// 제목 생략
													$title_length = mb_strlen($list[title], 'UTF-8');
													if($title_length>22) {
														$title = mb_substr($list[title], 0, 22, 'UTF-8');
														$title = $title.'...';
													} else {
														$title = $list[title];
													}
												?>
											<img align="absmiddle" src="http://akeetes430.cdn2.cafe24.com/circle_blue.gif"	style="width:6px; height:6px;" border="0" alt="">
											<a href="#" target="_self" onclick="self.location.href='community_7.php?mode=view&wno=<?=$list[wno]?>';" title="<?=$list[title]?>"><font color="#370909"><?if($new=="1"){?><strong><?=$title?></strong><?}else{?><?=$title?><?}?></font></a> <?if($new=="1"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_new.gif" align="absmiddle" style="width:20px; height:13px;" alt="새 글"><?}?><br><br><?}?>
											</span></font></p>
										</td>
									</tr>
									<?}else{?>
									<tr>
										<td style="width:345px; height:50px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_5_7_disabled.gif');"></td>
										<td style="width:345px; height:200px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_green.gif');" rowspan="2"></td>
									</tr>
									<tr>
										<td style="width:345px; height:150px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_list_blue_disabled.gif');">
											<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
												Silver 등급부터 이용할 수 있는 비공개 게시판입니다.<br><br>보안을 위하여 최근 게시물 목록을 제공하지 않습니다.<br><br><br>
											</span></font></p>
										</td>
									</tr>
									<?}?>
								</table>
							</span></font></p>
							<br><br><br>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td	id="layout_border_bottom" colspan="4"></td>
		</tr>
	</table>
	</center><br>

</body>

</html>