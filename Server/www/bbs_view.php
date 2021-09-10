<?

// 헤더파일 연결
include "../header.php";

// 게시판 공지사항 연결
include "config_notice.php";

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 전역 변수
global $board, $url, $page, $wno;
$board = mysql_real_escape_string($board);
$url = mysql_real_escape_string($url);
$page = mysql_real_escape_string($page);
$wno = mysql_real_escape_string($wno);

// 게시판 환경설정 연결
include "config_bbs.php";

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	if($view_permission!="0") {
		session_destroy();
		echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
	}
}

// 읽기 권한 확인
if($view_permission>$member[level] && $view_permission!="0") {
	echo "<script>self.location.href='error_401.php?level=$view_permission';</script>"; exit;
}

// 등급 정보
if($comment_permission=="2") {
	$comment_permission_level = "Bronze";
} elseif($comment_permission=="3") {
	$comment_permission_level = "Silver";
} elseif($comment_permission=="4") {
	$comment_permission_level = "Gold";
} elseif($comment_permission=="5") {
	$comment_permission_level = "Staff";
} elseif($comment_permission=="6") {
	$comment_permission_level = "Master";
} else {
	$comment_permission_level = "Copper";
}

// 게시물 로드
$view = mysql_fetch_array(mysql_query("SELECT * FROM $board WHERE wno=$wno", $dbconn));

// 익명 게시판 권한 확인
if($anonymous=="1") {
	if($view[no]!=$member[no] && $member[level]<5) {
	  echo "<script>alert(' 익명 게시판이므로 본인 글만 읽을 수 있습니다. ');history.back();</script>"; exit;
	}
}

// 변수 변환
$title = mysql_real_escape_string(htmlentities($view[title], ENT_QUOTES, 'UTF-8'));
$text = nl2br($view[text]);
$time_write = mysql_real_escape_string(date("Y.m.d H:i", $view[time]));

// 조회 수 확인
$wowzer_cookie_view = md5(md5($key1).md5($member[login_ip]).md5($board).md5($wno));
if($_COOKIE[$wowzer_cookie_view]!="1") {
	setcookie($wowzer_cookie_view, '1', time()+86400, '/');
	mysql_query("UPDATE $board SET hit=hit+1 WHERE wno=$wno", $dbconn);
}

// 게시물 작성자 로드
$member_view = mysql_fetch_array(mysql_query("select * from member where no='$view[no]'",$dbconn));

// 아바타 아이템 로드
$member_view_avata = mysql_fetch_array(mysql_query("SELECT * FROM item WHERE ino=$member_view[avata]", $dbconn));

// 첨부파일 용량계산
if($view[file_1_size]<1024) {
	$file_1_size = round($view[file_1_size],2);
	$file_1_size = $file_1_size.'Byte';
} elseif($view[file_1_size]>=1024 && $view[file_1_size]<1048576) {
	$file_1_size = $view[file_1_size] / 1024;
	$file_1_size = round($file_1_size,2);
	$file_1_size = $file_1_size.'KB';
} elseif($view[file_1_size]>=1048576 && $view[file_1_size]<1073741824) {
	$file_1_size = $view[file_1_size] / 1024 / 1024;
	$file_1_size = round($file_1_size,2);
	$file_1_size = $file_1_size.'MB';
} else {
	$file_1_size = '';
}
if($view[file_2_size]<1024) {
	$file_2_size = round($view[file_2_size],2);
	$file_2_size = $file_2_size.'Byte';
} elseif($view[file_2_size]>=1024 && $view[file_2_size]<1048576) {
	$file_2_size = $view[file_2_size] / 1024;
	$file_2_size = round($file_2_size,2);
	$file_2_size = $file_2_size.'KB';
} elseif($view[file_2_size]>=1048576 && $view[file_2_size]<1073741824) {
	$file_2_size = $view[file_2_size] / 1024 / 1024;
	$file_2_size = round($file_2_size,2);
	$file_2_size = $file_2_size.'MB';
} else {
	$file_2_size = '';
}

// 등급 명칭
if($member_view[level]=="1") {
	$member_view_level = "Copper";
} elseif($member_view[level]=="2") {
	$member_view_level = "Bronze";
} elseif($member_view[level]=="3") {
	$member_view_level = "Silver";
} elseif($member_view[level]=="4") {
	$member_view_level = "Gold";
} elseif($member_view[level]=="5") {
	$member_view_level = "Staff";
} else {
	$member_view_level = "Master";
}

// 카테고리
if($view[category]=="1") {
	$category = $category_1;
} elseif($view[category]=="2") {
	$category = $category_2;
} elseif($view[category]=="3") {
	$category = $category_3;
} elseif($view[category]=="4") {
	$category = $category_4;
} elseif($view[category]=="5") {
	$category = $category_5;
} else {
	$category = "미지정";
}

// 댓글 로드
$board_comment = $board.'_comment';
$comment = mysql_query("SELECT * FROM $board_comment where code=$wno ORDER BY num",$dbconn);

// 댓글 수
$comment_num = mysql_result(mysql_query("SELECT COUNT(*) FROM $board_comment where code=$wno"), 0, "COUNT(*)");

?>

<script>
function copy() {
	var a=document.getElementById("text").innerText;
	window.clipboardData.setData('Text',a);
	alert("복사가 완료되었습니다. 붙여넣기를 하시면 됩니다.");
}
</script>
<center>
	<br>
	<table id="layout_bbs" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td id="layout_bbs_titleline" colspan="3"></td>
		</tr>
		<tr>
			<td id="layout_bbs_title" colspan="3">
				<table style="width:700px; height:35px;" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="width:80px; height:35px;">
							<p style="margin-left:10pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								[<?=$category?>]
							</span></font></p>
						</td>
						<td style="width:530px; height:35px;">
							<p style="margin-right:0pt; margin-left:10pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong><?=$title?></strong> <span style="font-size:8pt;">(<?=$time_write?>)</span>
							</span></font></p>
						</td>
						<td style="width:90px; height:35px;">
							<p style="margin-right:5pt; margin-left:5pt;" align="right"><font face="Gulim" color="white"><span style="font-size:9pt;">
								조회 <strong><?=$view[hit]?></strong>
							</span></font></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_titleline" colspan="3"></td>
		</tr>
		<tr>
			<td id="layout_bbs_info" colspan="3">
				<!-- 아바타/계정 정보 전용 테이블 -->
				<?if($member_view[pw]!="0"){?>
				<table>
					<tr>
						<td style="width:70px;"<?if($_SESSION[wowzer_key]) {?> style="cursor:pointer;" onclick="popup_profile('<?=urlencode($member_view[name_nick])?>');" OnMouseOut="div_hide('tooltip_1');"	OnMouseOver="div_show('tooltip_1');" onmousemove="div_move(event, 'tooltip_1');"<?}?>>
							<p style="margin-left:5pt; margin-right:0pt;"><font face="Gulim" color="#241606"><span style="font-size:9pt;">
							<img src="http://akeetes430.cdn2.cafe24.com/<?=$member_view_avata[image]?>" align="left" style="width:64px; height:64px; border-width:2pt; border-style:solid;<?if($member_view_avata[level]=="1"){?> border-color:rgb(255,255,255);<?}elseif($member_view_avata[level]=="2"){?> border-color:rgb(17,121,0);<?}elseif($member_view_avata[level]=="3"){?> border-color:rgb(0,72,255);<?}elseif($member_view_avata[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
						</td>
						<td style="width:260px;"<?if($_SESSION[wowzer_key]) {?> style="cursor:pointer;" onclick="popup_profile('<?=urlencode($member_view[name_nick])?>');" OnMouseOut="div_hide('tooltip_1');"	OnMouseOver="div_show('tooltip_1');" onmousemove="div_move(event, 'tooltip_1');"<?}?>>
							<p style="margin-left:5pt; margin-right:0pt;"><font face="Gulim" color="#241606"><span style="font-size:9pt;">
								<?if($member_view[title]=="0"){?>칭호가 없습니다.<?}else{?><?=$member_view[title]?><?}?><br>
								<?if($member_view[level]>4){?><img src="http://akeetes430.cdn2.cafe24.com/icon_admin.gif" align="absmiddle" style="width:20px; height:13px;"> <?}elseif($member_view[level]=="4"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_gold.gif" align="absmiddle" style="width:20px; height:13px;"> <?}elseif($member_view[level]=="3"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_silver.gif" align="absmiddle" style="width:20px; height:13px;"> <?}?><strong><?=$member_view[name_nick]?></strong><br><br>
								<strong><?=$member_view_level?></strong> (<strong><?=$member_view[level]?></strong> 레벨)<br>

							</font></span></p>
						</td>
						<td style="width:370px;">
							<p style="margin-left:0pt; margin-right:5pt;" align="right"><font face="Gulim" color="#241606"><span style="font-size:9pt;">
								<?if($view[file_1_size]>0){?><strong>파일 첨부 #1</strong> (용량: <?=$file_1_size?> / 다운: <?=$view[file_1_download]?>회)&nbsp;<input type="button" value=" 다운로드 " style="width:70px; height:19px; font-family:'Gulim'; font-size:9pt;" onclick="if(confirm(' 200 포인트를 사용하시겠습니까? \n\n 다운로드시 작성자는 업로드 수익으로 100 포인트를 얻습니다. ')){down_process.location.href='bbs_down.php?board=<?=$board?>&wno=<?=$wno?>&code=1';} else return false;"><br><?}?>
								<?if($view[file_2_size]>0){?><strong>파일 첨부 #2</strong> (용량: <?=$file_2_size?> / 다운: <?=$view[file_2_download]?>회)&nbsp;<input type="button" value=" 다운로드 " style="width:70px; height:19px; font-family:'Gulim'; font-size:9pt;" onclick="if(confirm(' 200 포인트를 사용하시겠습니까? \n\n 다운로드시 작성자는 업로드 수익으로 100 포인트를 얻습니다. ')){down_process.location.href='bbs_down.php?board=<?=$board?>&wno=<?=$wno?>&code=2';} else return false;"><br><?}?>
								<input type="button" value=" 글 복사 " style="width:70px; height:19px; font-family:'Gulim'; font-weight:bold; font-size:9pt;" onclick="if(confirm(' 600 포인트를 사용하시겠습니까? \n\n 이 글의 그림을 제외한 모든 내용이 자동으로 복사됩니다. ')){down_process.location.href='bbs_copy.php';} else return false;">
								<iframe name="down_process" id="down_process" style="display:none; width:0px; height:0px;"></iframe>
							</font></span></p>
							<div id="tooltip_1" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>유저 정보실을 통해 이 길드원의 정보를 보시려면 클릭하세요.
									</span></font></p>
								</div>
						</td>
					</tr>
				</table>
				<?}else{?>
				<table>
					<tr>
						<td style="width:70px;"<?if($_SESSION[wowzer_key]) {?> OnMouseOut="div_hide('tooltip_2');"	OnMouseOver="div_show('tooltip_2');" onmousemove="div_move(event, 'tooltip_2');"<?}?>>
							<p style="margin-left:5pt; margin-right:0pt;"><font face="Gulim" color="#241606"><span style="font-size:9pt;">
							<img src="http://akeetes430.cdn2.cafe24.com/<?=$member_view_avata[image]?>" align="left" style="width:64px; height:64px; border-width:2pt; border-style:solid;<?if($member_view_avata[level]=="1"){?> border-color:rgb(255,255,255);<?}elseif($member_view_avata[level]=="2"){?> border-color:rgb(17,121,0);<?}elseif($member_view_avata[level]=="3"){?> border-color:rgb(0,72,255);<?}elseif($member_view_avata[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
						</td>
						<td style="width:260px;"<?if($_SESSION[wowzer_key]) {?> OnMouseOut="div_hide('tooltip_2');"	OnMouseOver="div_show('tooltip_2');" onmousemove="div_move(event, 'tooltip_2');"<?}?>>
							<p style="margin-left:5pt; margin-right:0pt;"><font face="Gulim" color="#241606"><span style="font-size:9pt;">
								<?if($member_view[title]=="0"){?>칭호가 없습니다.<?}else{?><?=$member_view[title]?><?}?><br>
								<?if($member_view[level]>4){?><img src="http://akeetes430.cdn2.cafe24.com/icon_admin.gif" align="absmiddle" style="width:20px; height:13px;"> <?}elseif($member_view[level]=="4"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_gold.gif" align="absmiddle" style="width:20px; height:13px;"> <?}elseif($member_view[level]=="3"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_silver.gif" align="absmiddle" style="width:20px; height:13px;"> <?}?><strong><?=$member_view[name_nick]?></strong><br><br>
								

							</font></span></p>
						</td>
						<td style="width:370px;">
							<p style="margin-left:0pt; margin-right:5pt;" align="right"><font face="Gulim" color="#241606"><span style="font-size:9pt;">
								<?if($view[file_1_size]>0){?><strong>파일 첨부 #1</strong> (용량: <?=$file_1_size?> / 다운: <?=$view[file_1_download]?>회)&nbsp;<input type="button" value=" 다운로드 " style="width:70px; height:19px; font-family:'Gulim'; font-size:9pt;" onclick="if(confirm(' 200 포인트를 사용하시겠습니까? \n\n 다운로드시 작성자는 업로드 수익으로 100 포인트를 얻습니다. ')){down_process.location.href='bbs_down.php?board=<?=$board?>&wno=<?=$wno?>&code=1';} else return false;"><br><?}?>
								<?if($view[file_2_size]>0){?><strong>파일 첨부 #2</strong> (용량: <?=$file_2_size?> / 다운: <?=$view[file_2_download]?>회)&nbsp;<input type="button" value=" 다운로드 " style="width:70px; height:19px; font-family:'Gulim'; font-size:9pt;" onclick="if(confirm(' 200 포인트를 사용하시겠습니까? \n\n 다운로드시 작성자는 업로드 수익으로 100 포인트를 얻습니다. ')){down_process.location.href='bbs_down.php?board=<?=$board?>&wno=<?=$wno?>&code=2';} else return false;"><br><?}?>
								<input type="button" value=" 글 복사 " style="width:70px; height:19px; font-family:'Gulim'; font-weight:bold; font-size:9pt;" onclick="if(confirm(' 600 포인트를 사용하시겠습니까? \n\n 이 글의 그림을 제외한 모든 내용이 자동으로 복사됩니다. ')){down_process.location.href='bbs_copy.php';} else return false;">
								<iframe name="down_process" id="down_process" style="display:none; width:0px; height:0px;"></iframe>
							</font></span></p>
							<div id="tooltip_2" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
								<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="red"><span style="font-size:9pt;">
									<br><?if($member[login_browser]=="1"){?><br><?}?>삭제된 계정이므로 유저 정보실을 볼 수 없습니다.<br>이메일: <?=$member_view[email]?>
								</span></font></p>
							</div>
							<div id="tooltip_1" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>유저 정보실을 통해 이 길드원의 정보를 보시려면 클릭하세요.
									</span></font></p>
								</div>
						</td>
					</tr>
				</table>
				<?}?>
				<!-- 아바타/계정 정보 전용 테이블 -->
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_text_header" colspan="3"<?if($view[goldbox]=="1"){?>  style="background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_text_header_gold.gif');"<?}?>></td>
		</tr>
		<tr>
			<td id="layout_bbs_text_middle" colspan="3">
				<table>
					<tr>
						<td style="width:50px;">
						</td>
						<td style="width:600px; word-break:break-all;" id="text">							
							<font face="Gulim" color="black"><span style="font-size:9pt;"><?=$text?></span></font>
						</td>
						<td style="width:50px;">
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_text_bottom" colspan="3"<?if($view[goldbox]=="1"){?> style="background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_text_bottom_gold.gif');"<?}?>></td>
		</tr>
		<tr>
			<td id="layout_bbs_comment" colspan="3">
				<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<strong>댓글</strong> (총 <?=$comment_num?>개)
				</font></span></p>
			</td>
		</tr>
		<?

			while($view_comment = mysql_fetch_array($comment)) {

				// 댓글 작성자 로드
				$member_comment = mysql_fetch_array(mysql_query("select * from member where no='$view_comment[no]'",$dbconn));
				$comment_time = date ("Y.m.d H:i", $view_comment[time]);

				// 아바타 아이템 로드
				$member_comment_avata = mysql_fetch_array(mysql_query("SELECT * FROM item WHERE ino=$member_comment[avata]", $dbconn));

				// 변수 변환
				$comment_text = nl2br(htmlentities($view_comment[text], ENT_QUOTES, 'UTF-8'));

				// 등급 명칭
				if($member_comment[level]=="1") {
					$member_comment_level = "Copper";
				} elseif($member_comment[level]=="2") {
					$member_comment_level = "Bronze";
				} elseif($member_comment[level]=="3") {
					$member_comment_level = "Silver";
				} elseif($member_comment[level]=="4") {
					$member_comment_level = "Gold";
				} elseif($member_comment[level]=="5") {
					$member_comment_level = "Staff";
				} else {
					$member_comment_level = "Master";
				}

			$time = time();

			$time_comment = $time-$view_comment[time];
			if($time_comment<=86400) {
				$new = 1;
			} else {
				$new = 0;
			}


		?>
		<tr>
			<td id="layout_bbs_comment_left"<?if($_SESSION[wowzer_key]) {?> style="cursor:pointer;" onclick="popup_profile('<?=urlencode($member_comment[name_nick])?>');" OnMouseOut="div_hide('tooltip_1');"	OnMouseOver="div_show('tooltip_1');" onmousemove="div_move(event, 'tooltip_1');"<?}?>>
				<span style="font-size:5pt;"><br></span>
				<p style="margin-left:20pt; margin-right:0pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<img src="http://akeetes430.cdn2.cafe24.com/<?=$member_comment_avata[image]?>" align="left" style="width:48px; height:48px; border-width:2pt; border-style:solid;<?if($member_comment_avata[level]=="1"){?> border-color:rgb(255,255,255);<?}elseif($member_comment_avata[level]=="2"){?> border-color:rgb(17,121,0);<?}elseif($member_comment_avata[level]=="3"){?> border-color:rgb(0,72,255);<?}elseif($member_comment_avata[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
					&nbsp;<?if($member_comment[level]>4){?><img src="http://akeetes430.cdn2.cafe24.com/icon_admin.gif" align="absmiddle" alt="운영진" style="width:20px; height:13px;"> <?}elseif($member_comment[level]=="4"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_gold.gif" align="absmiddle" alt="골드" style="width:20px; height:13px;"> <?}elseif($member_comment[level]=="3"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_silver.gif" align="absmiddle" alt="실버" style="width:20px; height:13px;"> <?}?><strong><?=$member_comment[name_nick]?></strong><br>
					&nbsp;<strong><?=$member_comment_level?></strong> (<strong><?=$member_comment[level]?></strong> 레벨)
					<br><br>&nbsp;<span style="font-size:8pt;">(<?=$comment_time?>)</span>
				</font></span></p>
				<span style="font-size:5pt;"><br></span>
			</td>
			<td id="layout_bbs_comment_middle">
				<p style="margin-left:5pt; margin-right:5pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<span style="font-size:5pt;"><br></span><?=$comment_text?> <?if($new=="1"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_new.gif" align="absmiddle" style="width:20px; height:13px;" alt="24시간 이내 등록된 댓글"><?}?><span style="font-size:5pt;"><br></span><span style="font-size:5pt;"><br></span>
				</font></span></p>
			</td>
			<td id="layout_bbs_comment_right">
				<p style="margin-left:5pt; margin-right:20pt;" align="right"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<input type="button" value="X" style="width:19px; height:19px; font-family:'Gulim'; font-size:9pt;" onclick="if(confirm(' <?=$point_comment?> 포인트를 사용하시겠습니까? \n\n 댓글을 삭제할 때는 적립받은 포인트를 반납해야 합니다. ')) comment_process.location.href='bbs_comment_delete.php?board=<?=$board?>&cno=<?=$view_comment[cno]?>'; else ;"<?if($member_comment[no]!=$member[no] && $member[level]<5){?> disabled<?}?>>
				</font></span></p>
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_comment_line" colspan="3">
				<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<img src="http://akeetes430.cdn2.cafe24.com/bbs_comment_line.gif" align="absmiddle" alt="" style="width:650px; height:1px;">
				</font></span></p>
			</td>
		</tr>
		<?
			}
		?>
		<?if($member[no]){?>
		<form name="comment" target="comment_process" method="post" action="bbs_comment.php">
		<tr>
			<td id="layout_bbs_comment_left">
				<span style="font-size:5pt;"><br></span>
				<p style="margin-left:20pt; margin-right:0pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<img src="http://akeetes430.cdn2.cafe24.com/<?=$member_avata[image]?>" align="left" alt="<?=$member_avata[name]?>" style="width:48px; height:48px; border-width:2pt; border-style:solid;<?if($member_avata[level]=="1"){?> border-color:rgb(255,255,255);<?}elseif($member_avata[level]=="2"){?> border-color:rgb(17,121,0);<?}elseif($member_avata[level]=="3"){?> border-color:rgb(0,72,255);<?}elseif($member_avata[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
					&nbsp;<?if($member[level]>4){?><img src="http://akeetes430.cdn2.cafe24.com/icon_admin.gif" align="absmiddle" alt="운영진" style="width:20px; height:13px;"> <?}elseif($member[level]=="4"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_gold.gif" align="absmiddle" alt="골드" style="width:20px; height:13px;"> <?}elseif($member[level]=="3"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_silver.gif" align="absmiddle" alt="실버" style="width:20px; height:13px;"> <?}?><strong><?=$member[name_nick]?></strong><br>
					&nbsp;<strong><?=$level?></strong> (<strong><?=$member[level]?></strong> 레벨)
					<br><br>&nbsp;<input type="hidden" name="url" value="<?=$url?>"><input type="hidden" name="board" value="<?=$board?>"><input type="hidden" name="code" value="<?=$wno?>"><input type="submit" value=" 입력 " name="comment_submit" style="width:50px; height:19px; font-family:'Gulim'; font-size:9pt;" disabled>
				</font></span></p>
			<span style="font-size:5pt;"><br></span>
			</td>
			<td id="layout_bbs_comment_middle" style="width:500px;" colspan="2">
				<p style="margin-left:5pt; margin-right:0pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<span style="font-size:5pt;"><br></span>
					<iframe name="comment_process" id="comment_process" style="display:none; width:0px; height:0px;"></iframe><input type="hidden" name="comment_notice" value="1"><textarea name="text" rows="3" onkeyup="comment_blank();" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); comment_focus(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:458px; height:46px; padding:1px; font-family:Gulim; font-size:9pt; color:rgb(0,0,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;"<?if($comment_permission>$member[level]){?> disabled<?}?>><?if($comment_permission>$member[level]){?><?=$comment_permission_level?> 등급(<?=$comment_permission?> 레벨)부터 이용할 수 있습니다.<?}else{?><?=$comment_notice?><?}?></textarea>
					<span style="font-size:5pt;"><br></span><span style="font-size:5pt;"><br></span>
				</font></span></p>
			</td>
		</tr>
		</form>
	<?}?>
		<tr>
			<td id="layout_bbs_comment_line" colspan="3">
				<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<img src="http://akeetes430.cdn2.cafe24.com/bbs_comment_line.gif" align="absmiddle" alt="" style="width:700px; height:5px;">
				</font></span></p>
			</td>
		</tr>
	</table>
	<table id="layout_bbs_bottom" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td id="layout_bbs_bottom_left" style="width:350px;">
				<p style="margin-right:5pt; margin-left:5pt;">
					<input type="button" value=" 목록 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='<?=$url?>?page=<?=$page?>';">&nbsp;
					<input type="button" value=" 쓰기 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='<?=$url?>?mode=write';"<?if($write_permission>$member[level]){?> disabled<?}?>>
				</p>
			</td>
			<td id="layout_bbs_bottom_right" style="width:350px;">
				<p style="margin-right:5pt; margin-left:5pt;" align="right">
					<input type="button" value=" 수정 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='<?=$url?>?mode=edit&wno=<?=$wno?>';"<?if($member_view[no]!=$member[no]){?> disabled<?}?>>&nbsp;
					<input type="button" value=" 삭제 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="if(confirm(' <?=$point_write?> 포인트를 사용하시겠습니까? \n\n 글을 삭제할 때는 적립받은 포인트를 반납해야 합니다. ')) self.location.href='bbs_write_delete.php?board=<?=$board?>&wno=<?=$view[wno]?>&url=<?=$url?>'; else ;"<?if($member_view[no]!=$member[no] && $member[level]<5){?> disabled<?}?>>
				</p>
			</td>
		</tr>
	</table>
	<br>
	<script type="text/javascript">
		<!--
		google_ad_client = "ca-pub-8506472453970244";
		/* link_bottom */
		google_ad_slot = "4589533096";
		google_ad_width = 728;
		google_ad_height = 15;
		//-->
	</script>
	<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
	</p>
	<br>
</center>