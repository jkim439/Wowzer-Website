<?

// 헤더파일 연결
include "../header.php";

// 게시판 환경설정 연결
include "config_bbs.php";

// 게시판 공지사항 연결
include "config_notice.php";

// 전역 변수
global $board, $url, $page;

// 현재 시간
$time = time();

// 전체 글 수
$total = mysql_query("SELECT COUNT(*) FROM $board",$dbconn);
$total = mysql_result($total, 0, "COUNT(*)");

// 전체 페이지 수
if($total<11) {
  $pageno = "1";
} else {
  if($total % 30) {
    $pageno = intval($total / 30) + 1;
  } else {
    $pageno = $total / 30;
  }
}

// page 변수 체크
if(!$page) {
  $page = "1";
}

// 페이지별 idx 시작값과 끝값
if($pageno!=$page) {
  if($page=="1") {
    $idxstart = $total - 29;
  } else {
    $idxstart = $total - ($page * 30) + 1;
    $idxend = $total - (($page-1) * 30);
  }
} else {
  $idxstart = $total - (($page-1) * 30);
}

// 마지막 페이지 목록 수
if($pageno!=$page) {
$listmax = "30";
} else {
  $listmax = $total - (($page-1) * 30);
}

if($pageno!=$page) {
  if($page=="1") {
    $result = mysql_query("SELECT * FROM $board WHERE num >= $idxstart ORDER BY num DESC LIMIT $listmax", $dbconn);
  } else {
    $result = mysql_query("SELECT * FROM $board WHERE num >= $idxstart and num <= $idxend ORDER BY num DESC LIMIT $listmax", $dbconn);
  }
} else {
 $result = mysql_query("SELECT * FROM $board WHERE num <= $idxstart ORDER BY num DESC LIMIT $listmax", $dbconn);
}

?>
<center>
	<br>
	<table id="layout_bbs" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td id="layout_bbs_titleline" colspan="2"></td>
		</tr>
		<tr>
			<td id="layout_bbs_title">
				<table style="width:700px; height:35px;" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="width:40px; height:35px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong>번호</strong>
							</span></font></p>
						</td>
						<td style="width:80px; height:35px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong>종류</strong>
							</span></font></p>
						</td>
						<td style="width:350px; height:35px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong>제목</strong>
							</span></font></p>
						</td>
						<td style="width:110px; height:35px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong>작성자</strong>
							</span></font></p>
						</td>
						<td style="width:40px; height:35px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong>조회수</strong>
							</span></font></p>
						</td>
						<td style="width:80px; height:35px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong>날짜</strong>
							</span></font></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_titleline" colspan="2"></td>
		</tr>
	</table>
	<table id="layout_bbs" border="0" cellspacing="0" cellpadding="0">
		<?if($notice_1=="1"){?><tr>
			<td id="layout_bbs_notice">
				<table style="width:700px; height:30px;" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="width:40px; height:30px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								-
							</span></font></p>
						</td>
						<td style="width:80px; height:30px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								[공지사항]
							</span></font></p>
						</td>
						<td style="width:360px; height:30px;">
							<p style="margin-right:5pt; margin-left:5pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<?if($notice_1_url!=""){?><a href="<?=$notice_1_url?>" target="_self"><font color="white"><strong><?=$notice_1_title?></strong></font></a><?}else{?><font color="white"><strong><?=$notice_1_title?></strong></font><?}?>
							</span></font></p>
						</td>
						<td style="width:100px; height:30px;"<?if($_SESSION[wowzer_key]) {?> style="cursor:pointer;" onclick="popup_profile('<?=urlencode($notice_1_writer)?>');" OnMouseOut="div_hide('tooltip_1');"	OnMouseOver="div_show('tooltip_1');" onmousemove="div_move(event, 'tooltip_1');"<?}?>>
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<img src="http://akeetes430.cdn2.cafe24.com/icon_admin.gif" align="absmiddle" style="width:20px; height:13px;"> <?=$notice_1_writer?>
							</span></font></p>
						</td>
						<td style="width:40px; height:30px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								-
							</span></font></p>
						</td>
						<td style="width:80px; height:30px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<?=$notice_1_time?>
							</span></font></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_titleline" colspan="2"></td>
		</tr><?}?><?if($notice_2=="1"){?><tr>
			<td id="layout_bbs_notice">
				<table style="width:700px; height:30px;" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="width:40px; height:30px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								-
							</span></font></p>
						</td>
						<td style="width:80px; height:30px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								[공지사항]
							</span></font></p>
						</td>
						<td style="width:360px; height:30px;">
							<p style="margin-right:5pt; margin-left:5pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<?if($notice_2_url!=""){?><a href="<?=$notice_2_url?>" target="_self"><font color="white"><strong><?=$notice_2_title?></strong></font></a><?}else{?><font color="white"><strong><?=$notice_2_title?></strong></font><?}?>
							</span></font></p>
						</td>
						<td style="width:100px; height:30px;"<?if($_SESSION[wowzer_key]) {?> style="cursor:pointer;" onclick="popup_profile('<?=urlencode($notice_2_writer)?>');" OnMouseOut="div_hide('tooltip_1');"	OnMouseOver="div_show('tooltip_1');" onmousemove="div_move(event, 'tooltip_1');"<?}?>>
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<img src="http://akeetes430.cdn2.cafe24.com/icon_admin.gif" align="absmiddle" style="width:20px; height:13px;"> <?=$notice_2_writer?>
							</span></font></p>
						</td>
						<td style="width:40px; height:30px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								-
							</span></font></p>
						</td>
						<td style="width:80px; height:30px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<?=$notice_2_time?>
							</span></font></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_titleline" colspan="2"></td>
		</tr><?}?><?if($notice_3=="1"){?><tr>
			<td id="layout_bbs_notice">
				<table style="width:700px; height:30px;" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="width:40px; height:30px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								-
							</span></font></p>
						</td>
						<td style="width:80px; height:30px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								[공지사항]
							</span></font></p>
						</td>
						<td style="width:360px; height:30px;">
							<p style="margin-right:5pt; margin-left:5pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<?if($notice_3_url!=""){?><a href="<?=$notice_3_url?>" target="_self"><font color="white"><strong><?=$notice_3_title?></strong></font></a><?}else{?><font color="white"><strong><?=$notice_3_title?></strong></font><?}?>
							</span></font></p>
						</td>
						<td style="width:100px; height:30px;"<?if($_SESSION[wowzer_key]) {?> style="cursor:pointer;" onclick="popup_profile('<?=urlencode($notice_3_writer)?>');" OnMouseOut="div_hide('tooltip_1');"	OnMouseOver="div_show('tooltip_1');" onmousemove="div_move(event, 'tooltip_1');"<?}?>>
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<img src="http://akeetes430.cdn2.cafe24.com/icon_admin.gif" align="absmiddle" style="width:20px; height:13px;"> <?=$notice_3_writer?>
							</span></font></p>
						</td>
						<td style="width:40px; height:30px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								-
							</span></font></p>
						</td>
						<td style="width:80px; height:30px;">
							<p align="center"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<?=$notice_3_time?>
							</span></font></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_titleline" colspan="2"></td>
		</tr><?}?>
		<?

			// 반복 변수 초기화
			$i = 0;

			// 게시물 목록
			while($list = mysql_fetch_array($result)) {

			// 반복 변수에 따른 속성 지정
			if ($i) {
				$i = 0;
				$bgcolor = " background-color:rgb(217,145,81)";
			} else {
				$i = 1;
				$bgcolor = " background-color:rgb(164,102,40)";
			}

			// 작성 날짜
			$list_time = date("Y.m.d", $list[time]);

			// 댓글 시스템
			$board_comment = $board.'_comment';
			$result_comment = mysql_query("SELECT * FROM $board_comment where code=$list[wno]",$dbconn);
			$result_comment_list = mysql_query("SELECT COUNT(*) FROM $board_comment where code=$list[wno]",$dbconn);
			$result_comment_list = mysql_fetch_row($result_comment_list);

			// 댓글 갯수
			$comment_list = mysql_fetch_array($result_comment);
			if(!$comment_list) {
				$comment = '0';
			} else {
				$comment = $result_comment_list[0];
			}
			
			// 카테고리
			if($list[category]=="1") {
				$category = $category_1;
			} elseif($list[category]=="2") {
				$category = $category_2;
			} elseif($list[category]=="3") {
				$category = $category_3;
			} elseif($list[category]=="4") {
				$category = $category_4;
			} elseif($list[category]=="5") {
				$category = $category_5;
			} else {
				$category = "미지정";
			}
			
			// 등급 정보
			if($view_permission=="2") {
				$view_permission_level = "Bronze";
			} elseif($view_permission=="3") {
				$view_permission_level = "Silver";
			} elseif($view_permission=="4") {
				$view_permission_level = "Gold";
			} elseif($view_permission=="5") {
				$view_permission_level = "Staff";
			} elseif($view_permission=="6") {
				$view_permission_level = "Master";
			} else {
				$view_permission_level = "Copper";
			}

			// member_list 지정
			$member_list = mysql_fetch_array(mysql_query("select * from member where no='$list[no]'",$dbconn));

			// 제목 생략
			$title_length = mb_strlen($list[title], 'UTF-8');
			if($title_length>24) {
				$title = mb_substr($list[title], 0, 24, 'UTF-8');
				$title = $title.'...';
			} else {
				$title = $list[title];
			}
			$time_write = $time-$list[time];
			if($time_write<=86400) {
				$new = 1;
			} else {
				$new = 0;
			}

		?>
		<tr>
			<td id="layout_bbs_list">
				<table style="width:700px; height:30px;<?=$bgcolor?>" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="width:40px; height:30px;">
							<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<?=$list[num]?>
							</span></font></p>
						</td>
						<td style="width:80px; height:30px;">
							<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
								[<?=$category?>]
							</span></font></p>
						</td>
						<td style="width:360px; height:30px;">
							<p style="margin-right:5pt; margin-left:5pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<?if($view_permission>$member[level] && $view_permission!="0"){?><a href="error_401.php?level=<?=$view_permission?>" target="_self"><font color="black"><?=$list[title]?></font></a><?}else{?><a href="#" target="_self" onclick="self.location.href='<?=$url?>?mode=view&wno=<?=$list[wno]?>&page=<?=$page?>';" title="<?=$list[title]?><?if($member[level]>4){?> <<?=$list[wno]?>><?}?>"><font color="black"><?=$title?></font></a><?}?> <span style="font-size:8pt;">[<?=$comment?>]</span>
									&nbsp;<?if($new=="1"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_new.gif" align="absmiddle" style="width:20px; height:13px;" alt="24시간 이내 등록된 새 글"><?}?>
							</span></font></p>
						</td>
						<?if($anonymous=="0") {?>
						<td style="width:100px; height:30px;"<?if($_SESSION[wowzer_key]) {?> style="cursor:pointer;" onclick="popup_profile('<?=urlencode($member_list[name_nick])?>');" OnMouseOut="div_hide('tooltip_1');"	OnMouseOver="div_show('tooltip_1');" onmousemove="div_move(event, 'tooltip_1');"<?}?>>
							<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<?if($member_list[level]>4){?><img src="http://akeetes430.cdn2.cafe24.com/icon_admin.gif" align="absmiddle" style="width:20px; height:13px;"> <?}elseif($member_list[level]=="4"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_gold.gif" align="absmiddle" style="width:20px; height:13px;"> <?}elseif($member_list[level]=="3"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_silver.gif" align="absmiddle" style="width:20px; height:13px;"> <?}?><?=$member_list[name_nick]?>
							</span></font></p>
						</td>
						<?}else{?>
						<td style="width:100px; height:30px;">
							<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
								-
							</span></font></p>
						</td>
						<?}?>
						<td style="width:40px; height:30px;">
							<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<?=$list[hit]?>
							</span></font></p>
						</td>
						<td style="width:80px; height:30px;">
							<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<?=$list_time?>
							</span></font></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_line" colspan="2"></td>
		</tr>
	<?}?>
	</table>
	<table id="layout_bbs_bottom" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td id="layout_bbs_bottom_left">
				<p style="margin-right:5pt; margin-left:5pt;"><form method="get" action="<?=$url?>">
					<span style="font-size:9pt;"><br></span>
					<input type="hidden" name="mode" value="search"><input type="hidden" name="board" value="<?=$board?>">
					<select name="search_type" size="1" style="width:70px; height:25px; padding:1px; font-family:Gulim; font-size:9pt; color:rgb(0,0,0);">
						<option value="title">제목</option>
						<option value="text">내용</option>
						<option value="name">닉네임</option>
					</select>
					<input type="text" name="search" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:70px; height:18px; padding:1px; font-family:Gulim; font-size:9pt; color:rgb(0,0,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="10">
					<input type="submit" value=" 검색 " style="width:50px; height:19px; font-family:'Gulim'; font-size:9pt;">
				</form></p><div id="tooltip_1" style="width:300px; height:70px; position:absolute; z-index:1; background-image:url('http://akeetes430.cdn2.cafe24.com/tooltip_mini.png'); display:none;">
									<p style="margin-right:10pt; margin-left:10pt; text-align:justify;<?if($member[login_browser]=="2"){?> line-height:18px;<?}?>"><font face="Gulim" color="white"><span style="font-size:9pt;">
										<br><?if($member[login_browser]=="1"){?><br><?}?>유저 정보실을 통해 이 길드원의 정보를 보시려면 클릭하세요.
									</span></font></p>
								</div>
			</td>
			<td id="layout_bbs_bottom_middle">
				<p align="center"><font face="Gulim" color="white"><span style="font-size:8pt;">
					<span style="font-size:9pt;"><br></span>
					<strong><a href="#" target="_self" onclick="self.location.href='<?=$url?>?page=1';"><font color="blue">[처음]</font></a>&nbsp;<?if($page!="1"){?><a href="#" target="_self" onclick="self.location.href='<?=$url?>?page=1';"><font color="blue">[1]</font></a><?}else{?><font color="red">[1]</font><?}?><?
						$pagecalc = "1";
						while($pagecalc<$pageno) {
						$pagecalc = $pagecalc +1;
					?><?if($page!=$pagecalc){?><a href="#" target="_self" onclick="self.location.href='<?=$url?>?page=<?=$pagecalc?>';"><font color="blue">[<?=$pagecalc?>]</font></a><?}else{?><font color="red">[<?=$pagecalc?>]</font><?}?><?}?>
					<a href="#" target="_self" onclick="self.location.href='<?=$url?>?page=<?=$pageno?>';"><font color="blue">[끝]</font></a></strong>
				</p></font></span>
			</td>
			<td id="layout_bbs_bottom_right">
				<p style="margin-right:5pt; margin-left:5pt;" align="right">
					<span style="font-size:9pt;"><br></span>
					<input type="button" value=" 쓰기 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='<?=$url?>?mode=write';"<?if($write_permission>$member[level]){?> disabled<?}?>>
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