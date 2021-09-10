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
if($item[kind]=="5" || $item[kind]=="6") {
	echo "<script>alert(' 삭제할 수 없습니다. 고객센터에 문의하십시오. ');history.back();</script>"; exit;
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
						<td	style="width:750px; height:37px; background-image:url('http://akeetes430.cdn2.cafe24.com/title_member_item_del.gif');"></td>
					</tr>
					<tr>
						<td	style="width:750px;"	bgcolor="white"	valign="top">
							<br><br>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								보유 중인 아이템 중에서 사용하지 않는 아이템을 삭제할 수 있습니다.
							</span></font></p>
							<br><br><br>
							<p align="center">
							<form name="del" target="_self" method="post" action="member_item_del_2.php">
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
														<strong>아이템 삭제</strong>
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
								<tr>
									<td id="layout_mini_2_left" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
											<center><strong>삭제 대상</strong></center>
										</span></font></p>
									</td>
									<td id="layout_mini_2_right" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
											<img align="middle" src="http://akeetes430.cdn2.cafe24.com/<?=$item[image]?>" width="64" height="64" alt="" style="border-width:2pt; border-style:solid;<?if($item[level]=="1"){?> border-color:rgb(0,0,0);<?}else if($item[level]=="2"){?> border-color:rgb(17,121,0);<?}else if($item[level]=="3"){?> border-color:rgb(0,72,255);<?}else if($item[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
											<strong><?if($item[level]=="1"){?><font color="black"><?}?><?if($item[level]=="2"){?><font color="#11d400"><?}?><?if($item[level]=="3"){?><font color="#0048ff"><?}?><?if($item[level]=="4"){?><font color="#8222cc"><?}?><?if($item[level]=="5"){?><font color="#ff7200"><?}?>[<?=$item[name]?>]</font></strong>
										</span></font></p>
									</td>
								</tr>
								<tr>
				       		<td id="layout_mini_2_line" colspan="2"></td>
				   			</tr>
								<tr>
								<tr>
									<td id="layout_mini_2_left" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
											<center><strong>본인 확인</strong></center>
										</span></font></p>
									</td>
									<td id="layout_mini_2_right" style="height:80px;">
										<p style="margin-right:10pt; margin-left:10pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
											본인 확인을 위해 비밀번호를 입력하여 주세요.<br><br><input type="password" name="pw" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:208px; height:22px; padding:1px; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="20" size="50">
										</span></font></p>
									</td>
								</tr>
								<tr>
				       		<td id="layout_mini_2_line" colspan="2"></td>
				   			</tr>
								<tr>
			        		<td style="height:80px;" colspan="2">
			        			<center><input type="hidden" name="ino" value="<?=$item[ino]?>"><input type="submit" value=" 삭제 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;">
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