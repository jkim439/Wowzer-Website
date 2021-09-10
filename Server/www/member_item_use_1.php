<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);
$ino = mysql_real_escape_string($_GET[ino]);

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

// 상점 아이템 로드
$item = mysql_fetch_array(mysql_query("select * from item where ino='$ino'",$dbconn));
$item_i = 'item_'.$item[ino];

// 미보유 또는 사용된 아이템 확인
if($member[$item_i]!="1") {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 게임 아이템, 기타 아이템
if($item[kind]=="5" || $item[kind]=="6" || $item[kind]=="7") {
	echo "<script>alert(' 사용할 수 없습니다. 쿠폰일 경우 포인트 상점에서 이용하세요. ');history.back();</script>"; exit;
}


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
							<? include "inc_login.php";	?>
						</td>
					</tr>
					<tr>
						<td id="layout_left_submeun_top" style="background-image:url('http://akeetes430.cdn2.cafe24.com/submeun_6.gif');"></td>
					</tr>
					<tr>
						<td	id="layout_left_submeun_bottom"	valign="top">
							<? include "member_meun.php"; ?>
						</td>
					</tr>
				</table>
			</td>
			<td	id="layout_right">
				<table id="layout_right_"	border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_member_item_use.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								현재 보유 중인 아이템을 사용할 수 있습니다.
							</span></font></p>
							<br><br><br>
							<p align="center">
							<form name="use" target="_self" method="post" action="member_item_use_2.php">
							<table id="layout_mini_2" border="0" cellspacing="0" cellpadding="0">
								<tr>
				       		<td id="layout_mini_2_titleline" colspan="2"></td>
				    		</tr>
								<tr>
				        	<td id="layout_mini_2_title" colspan="2">
				        		<table>
				        			<tr>
				        				<td style="width:300px;">
													<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
														<strong><?if($item[kind]=="1" || $item[kind]=="2" || $item[kind]=="3"){?>아바타 변경<?}else if($item[kind]=="4"){?>칭호 등록<?}else if($item[kind]=="5"){?>게임 아이템 사용<?}?></strong>
													</span></font></p>
												</td>
				        				<td style="width:350px;">
													<p style="margin-right:15pt; margin-left:15pt;" align="right"><font face="Gulim" color="white"><span style="font-size:9pt;">
														<input type="button" value=" 취소 " style="width:60px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="self.location.href='member_1.php#bag';">
													</span></font></p>
												</td>
											</tr>
										</table>
			        		</td>
			    			</tr>
								<tr>
				       		<td id="layout_mini_2_titleline" colspan="2"></td>
				    		</tr>
				   			<?if($item[kind]=="1" || $item[kind]=="2" || $item[kind]=="3"){?>
								<tr>
									<td id="layout_mini_2_left" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
											<center><strong>현재 아바타</strong></center>
										</span></font></p>
									</td>
									<td id="layout_mini_2_right" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
											<img align="middle" src="http://akeetes430.cdn2.cafe24.com/<?=$member_avata[image]?>" width="64" height="64"  alt="" style="border-width:2pt; border-style:solid;<?if($member_avata[level]=="1"){?> border-color:rgb(0,0,0);<?}else if($member_avata[level]=="2"){?> border-color:rgb(17,121,0);<?}else if($member_avata[level]=="3"){?> border-color:rgb(0,72,255);<?}else if($member_avata[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
											<strong><?if($member_avata[level]=="1"){?><font color="black"><?}?><?if($member_avata[level]=="2"){?><font color="#11d400"><?}?><?if($member_avata[level]=="3"){?><font color="#0048ff"><?}?><?if($member_avata[level]=="4"){?><font color="#8222cc"><?}?><?if($member_avata[level]=="5"){?><font color="#ff7200"><?}?>[<?=$member_avata[name]?>]</font></strong>
										</span></font></p>
									</td>
								</tr>
								<tr>
				       		<td id="layout_mini_2_line" colspan="2"></td>
				   			</tr>
								<tr>
									<td id="layout_mini_2_left" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
											<center><strong>변경 아바타</strong></center>
										</span></font></p>
									</td>
									<td id="layout_mini_2_right" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
											<img align="middle" src="http://akeetes430.cdn2.cafe24.com/<?=$item[image]?>" width="64" height="64"  alt="" style="border-width:2pt; border-style:solid;<?if($item[level]=="1"){?> border-color:rgb(0,0,0);<?}else if($item[level]=="2"){?> border-color:rgb(17,121,0);<?}else if($item[level]=="3"){?> border-color:rgb(0,72,255);<?}else if($item[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
											<strong><?if($item[level]=="1"){?><font color="black"><?}?><?if($item[level]=="2"){?><font color="#11d400"><?}?><?if($item[level]=="3"){?><font color="#0048ff"><?}?><?if($item[level]=="4"){?><font color="#8222cc"><?}?><?if($item[level]=="5"){?><font color="#ff7200"><?}?>[<?=$item[name]?>]</font></strong>
										</span></font></p>
									</td>
								</tr>
								<tr>
			        		<td id="layout_mini_2_line" colspan="2"></td>
			    			</tr>
			    			<?}else if($item[kind]=="4"){?>
								<tr>
									<td id="layout_mini_2_left" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
											<center><strong>칭호 입력</strong></center>
										</span></font></p>
									</td>
									<td id="layout_mini_2_right" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
											아래 빈칸에 원하시는 칭호를 입력하십시오. (최대 20자)<br><br><input type="text" name="title" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:312px; height:20px; padding:1px; font-family:Gulim; font-weight:bold; font-size:9pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="20">
										</span></font></p>
									</td>
								</tr>
								<tr>
			        		<td id="layout_mini_2_line" colspan="2"></td>
			    			</tr>
			    			<?}else if($item[kind]=="5"){?>
								<tr>
									<td id="layout_mini_2_left" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
											<center><strong>현재 아바타</strong></center>
										</span></font></p>
									</td>
									<td id="layout_mini_2_right" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
											<img align="middle" src="http://akeetes430.cdn2.cafe24.com/<?=$member_avata[image]?>" width="64" height="64"  alt="" style="border-width:2pt; border-style:solid;<?if($member_avata[level]=="1"){?> border-color:rgb(0,0,0);<?}else if($member_avata[level]=="2"){?> border-color:rgb(17,121,0);<?}else if($member_avata[level]=="3"){?> border-color:rgb(0,72,255);<?}else if($member_avata[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
											<strong><?if($member_avata[level]=="1"){?><font color="black"><?}?><?if($member_avata[level]=="2"){?><font color="#11d400"><?}?><?if($member_avata[level]=="3"){?><font color="#0048ff"><?}?><?if($member_avata[level]=="4"){?><font color="#8222cc"><?}?><?if($member_avata[level]=="5"){?><font color="#ff7200"><?}?>[<?=$member_avata[name]?>]</font></strong>
										</span></font></p>
									</td>
								</tr>
								<tr>
				       		<td id="layout_mini_2_line" colspan="2"></td>
				   			</tr>
								<tr>
									<td id="layout_mini_2_left" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
											<center><strong>변경 아바타</strong></center>
										</span></font></p>
									</td>
									<td id="layout_mini_2_right" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
											<img align="middle" src="http://akeetes430.cdn2.cafe24.com/<?=$item[image]?>" width="64" height="64"  alt="" style="border-width:2pt; border-style:solid;<?if($item[level]=="1"){?> border-color:rgb(0,0,0);<?}else if($item[level]=="2"){?> border-color:rgb(17,121,0);<?}else if($item[level]=="3"){?> border-color:rgb(0,72,255);<?}else if($item[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
											<strong><?if($item[level]=="1"){?><font color="black"><?}?><?if($item[level]=="2"){?><font color="#11d400"><?}?><?if($item[level]=="3"){?><font color="#0048ff"><?}?><?if($item[level]=="4"){?><font color="#8222cc"><?}?><?if($item[level]=="5"){?><font color="#ff7200"><?}?>[<?=$item[name]?>]</font></strong>
										</span></font></p>
									</td>
								</tr>
								<tr>
			        		<td id="layout_mini_2_line" colspan="2"></td>
			    			</tr>
			    			<?}?>
								<tr>
			        		<td style="height:80px;" colspan="2">
			        			<center><input type="hidden" name="ino" value="<?=$item[ino]?>"><input type="submit" value=" 사용 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;">
			        		</td>
			    			</tr>
							</table>
							</form>
							<br><br><br>
						</p>
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