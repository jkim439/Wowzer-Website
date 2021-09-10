<?

echo "<script>alert(' 더 이상 신규 유저를 받지 않습니다. ');window.close();</script>";exit;

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
}

// 중복 가입 방지 쿠키 검사
if($_COOKIE[wowzer_join]=="1") {
  echo "<script>alert(' 24시간 이내에 같은 컴퓨터로 계정을 추가로 생성할 수 없습니다. ');window.close();</script>";exit;
}

$ip = md5($_SERVER[REMOTE_ADDR]);
$time = md5(time());
$keycode4 = md5($time.$ip.$time);

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
	<script type="text/javascript">
  function submit_check() {
    if(document.join.key.value.length<5) {
      alert(" 보안 코드를 올바르게 입력하여 주십시오. "); return false;
    }
    if(!document.join.agree.checked) {
      alert(" 길드 약관에 동의하셔야 합니다. "); return false;
    }
    if(document.join.id.value.length<4) {
      alert(" 아이디는 최소 4글자이여야 합니다. "); return false;
    }
    if(document.join.pw_1.value.length<4) {
      alert(" 비밀번호는 최소 4글자이여야 합니다. "); return false;
    }
    if(document.join.pw_2.value.length<4) {
      alert(" 비밀번호는 최소 4글자이여야 합니다. "); return false;
    }
    if(document.join.name_nick.value.length<2) {
      alert(" 닉네임은 최소 2글자이여야 합니다. "); return false;
    }
		var ok_1 = "yes";
			for(i=0; i<document.join.name_nick.value.length; i++) {
			if ((document.join.name_nick.value.charAt(i)<"가" || document.join.name_nick.value.charAt(i) >"힣") && (document.join.name_nick.value.charAt(i)<"a" || document.join.name_nick.value.charAt(i) >"z") && (document.join.name_nick.value.charAt(i)<"A" || document.join.name_nick.value.charAt(i) >"Z")){
				ok_1 = "no";
			}else{
				ok_1 = "yes";
			}
		}
		if (ok_1 == "no") {
		 alert(" 닉네임을 올바르게 입력해 주세요. "); return false;
		}
    if(document.join.name_real.value.length<2) {
      alert(" 실명은 최소 2글자이여야 합니다. "); return false;
    }
		var ok_2 = "yes";
			for(i=0; i<document.join.name_real.value.length; i++) {
			if (document.join.name_real.value.charAt(i)<"가" || document.join.name_real.value.charAt(i) >"힣"){
				ok_2 = "no";
			}else{
				ok_2 = "yes";
			}
		}
		if (ok_2 == "no") {
		 alert(" 실명을 올바르게 입력해 주세요. "); return false;
		}
    if(document.join.email.value.length<5) {
      alert(" 이메일을 올바르게 입력해 주세요. "); return false;
    }
		var aryValue = new Array("daum.net", "hanmail.net");
		for(var i=0; i < aryValue.length; i++)
		{
			if (document.join.email.value.indexOf(aryValue[i]) > -1) {
				alert(" 이메일에 다음(한메일) 메일은 사용할 수 없습니다. ");
				return false;
			}
		}
    if(document.join.join_id_check.checked) {
    	if(document.join.join_id.value.length<4) {
    		alert(" 추천인 아이디는 최소 4글자이여야 합니다. "); return false;
    	}
    }
  }
  function check_id() {
    if(!document.join.id.value) {
        alert(" 아이디를 입력하여 주십시오. "); return false;
    } else {
        join_process.location.href('join_check_id.php?id='+document.join.id.value);
    }
   }
  function check_name() {
    if(!document.join.name_nick.value) {
        alert(" 닉네임을 입력하여 주십시오. "); return false;
    } else {
    		join_process.location.href('join_check_name.php?name_nick='+encodeURIComponent(document.join.name_nick.value));
    }
   }
  function check_email() {
    if(!document.join.email.value) {
        alert(" 이메일을 입력하여 주십시오. "); return false;
    } else {
        join_process.location.href('join_check_email.php?email='+document.join.email.value);
    }
   }
  function join_id_option() {
    if(document.join.join_id_check.checked) {
    	document.join.join_id.style.border="1px solid #FF9900";
    	document.join.join_id.style.backgroundColor="#ffffff";
    	document.join.join_id.disabled = false;
    } else {
    	document.join.join_id.style.border="1px solid #808080";
    	document.join.join_id.style.backgroundColor="#e8e8e8";
    	document.join.join_id.disabled = true;
    	document.join.join_id.value = "";
    }
  }
  </script>  

</head>

<body onload="java_check_guide();" onpropertychange="defence_check();" oncontextmenu="return false;" style="overflow-x:hidden;">

	<noscript><center><font face="Gulim" color="white"><br><br><?	echo site_java_msg; ?><br><br></font></center></noscript>

	<form name="join" target="join_process" method="post" action="join_2.php" onsubmit="return submit_check();">
	<table id="layout_guide" border="0" cellspacing="0" cellpadding="0" style="display:none;">
		<tr>
			<td id="layout_guide_title" style="background-image:url('http://akeetes430.cdn2.cafe24.com/title_join.gif');"></td>
		</tr>
		<tr>
			<td id="layout_guide_body">
				<br><br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					전세계 1위 프리 서버인 몰튼 와우에 오신 것을 환영합니다!
				</span></font></p><br><br>
				
				<table id="layout_guide_body_info" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td id="layout_guide_body_info_title" colspan='2'>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong>보안 코드</strong>
							</span></font></p>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_titleline" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_left">
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
								<center><strong>보안 코드</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<img src="key.php?keycode4=<?=$keycode4?>" align="absmiddle">&nbsp;&nbsp;&nbsp;
								<input type="text" name="key" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:60px; height:22px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="5">&nbsp;
								<input type="button" value=" 재시도 " onclick="if(confirm(' 입력한 내용이 모두 지워집니다. 계속하시겠습니까? ')){location.reload();} else return false;" style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;">
								
							<br><br></span></font></p>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_line" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_title" colspan='2'>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong>길드 약관</strong>
							</span></font></p>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_titleline" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_left">
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
								<center><strong>약관 내용</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<textarea name="agreement" rows="4" onfocus="this.blur();" style="width:640px; height:120px; padding:1px; font-family:Gulim; font-size:9pt; o`lor:rgb(0,0,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" readonly>[Eternal Soulmate] 임시 길드 약관

저희 길드 홈페이지에 가입하는 것은 길드 약관을 수락한다는 의미를 갖습니다.
만약 귀하가 길드 이용약관에 동의하지 않는다면 지금 가입을 중단하십시오.
귀하가 길드에 가입하기 위하여는 가입자 본인은 반드시 한국인이여야 합니다.

0. 명칭
  A. 저희 : 길드 Master와 Staff, 즉 길드 운영진을 뜻합니다.
  B. 홈페이지 : [Eternal Soulmate] 길드 홈페이지를 뜻합니다.
  C. 정식 길드원 : Bronze 등급(2 레벨)에 해당하는 회원을 뜻합니다.

1. 홈페이지 관련

  A. 홈페이지를 이용하기 위해서는 1인 1개의 고유한 계정에 대해 길드원 인증을 받아야 합니다.
  B. 정식 길드원이 되기 위해서는 게임 상의 캐릭터 이름과 직업을 제공해야 합니다.
  C. 부 캐릭터(부캐)의 이름을 제공하지 않아 생기는 문제에 대해 책임지지 않습니다.
  D. 허위 또는 잘못된 정보를 등록하는 경우 저희는 해당 계정을 차단시킬 수 있습니다.
  E. 계정은 다른 사람과 공유할 수 없으며 공유하는 경우 데이터베이스에 로그가 기록됩니다.
  F. 비밀번호는 저희도 알 수 없도록 암호화 처리가 되어 있어서 해킹에도 안전합니다.
  G. 비밀번호가 제3자에게 유출됨으로써 손해나 피해는 전적으로 이용자의 책임입니다.
  H. 닉네임은 홈페이지 시스템 설계상 최대 6자리까지만 허용되는 점을 유의하십시오. 
  I. 가입 후 1달 이상 미접속 계정에 대해 저희는 해당 계정을 삭제시킬 수 있습니다.
  J. 저희는 개인 간의 계정 판매 또는 기타 방식의 양도를 인정하지 않습니다.
  K. 저희는 1인 1계정을 원칙으로 하며 로그인 IP주소 검사 등을 통해 중복 계정을 삭제시킬 수 있습니다.
  L. 저희는 부정한 방식으로 포인트를 획득하는 로그가 기록되면 해당 계정을 차단시킬 수 있습니다.
  M. 게임 상 길드에 대한 영향이 길드 홈페이지의 계정에도 영향이 미칠 수 있습니다.
  N. 저희 홈페이지 운영기간이 보장되는 기간은 2010년 11월까지 입니다.
  O. 이용자는 홈페이지 서버를 공격하거나 해킹을 시도해서는 안됩니다.
  P. 저희의 서면 승인 없이 홈페이지의 저작권을 위반헤서는 안됩니다.
  Q. 등급이나 포인트에 관련하여 불법 조작시 해당 계정을 삭제합니다.
  R. 운영진은 등급 규칙에 따르지 않고 편법으로 등업시키면 안되며 적발시 운영진 자격을 박탈합니다.

2. 게임 관련
  A. 길드 활동에 따라 등급이 조정되며 등급에 따라 게임 내에서 그리고 홈페이지에서 혜택을 받을 수 있습니다.
  B. 길드에 가입하면 길드 창고에 아이템을 가져갈 수 있는 권리는 물론이고 넣어야 하는 의무도 생깁니다.
  C. 미풍양속을 해치는 행위로 인해 길드의 명예를 손상시키는 경우 저희는 길드에서 추방할 수 있습니다.
  D. 길드원에 대한 언어적, 행동적, 정신적 피해에 대해 저희는 제재할 수 있습니다.

3. 기타
  A. 본 계약은 대한민국 법률에 따라 규율되고 해석됩니다.
  B. 2010년 10월 01일 시행

Copyright ⓒ 2010 Tive. All rights reserved.
</textarea><br><br>
								<label for="agree" onclick="document.body.focus();"><input type="checkbox" name="agree" id="agree" value="1"> 길드 약관을 모두 읽었으며, 위 내용에 모두 동의합니다.</label><br><br>
							</span></font></p>
						</td>
					</tr>
					<tr>
						<td id="layout_guide_body_info_title" colspan='2'>
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<strong>정보 입력</strong>
							</span></font></p>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_titleline" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_left">
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
								<center><strong>아이디</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<input type="text" name="id" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:200px; height:22px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="20">&nbsp;
								<input type="button" value=" 중복검사 " onclick="check_id();" style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"><br><br>
								<img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""> 아이디는 최소 4자리부터 최대 20자리까지 가능합니다. 영어 소문자와 숫자로만 조합할 수 있습니다.
							<br><br></span></font></p>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_line" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_left">
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
								<center><strong>비밀번호</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<input type="password" name="pw_1" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:200px; height:22px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="20"><br><br>
								<img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""> 비밀번호는 서버에서 즉시 암호화 처리되어 안전하게 저장됩니다.<br>
							<br></span></font></p>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_line" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_left">
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
								<center><strong>비밀번호 재확인</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<input type="password" name="pw_2" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:200px; height:22px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="20"><br><br>
								<img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""> 위에 입력한 비밀번호를 다시 입력해 주세요.<br>
							<br></span></font></p>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_line" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_left">
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
								<center><strong>닉네임</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<input type="text" name="name_nick" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:200px; height:22px; padding:1px; ime-mode:active; font-family:Gulim; font-weight:bold; font-size:9pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="6">&nbsp;
								<input type="button" value=" 중복검사 " onclick="check_name();" style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"><br><br>
								<img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""> 닉네임은 최소 2자리부터 최대 6자리까지 가능합니다. 특수문자와 숫자는 이용할 수 없습니다.<br><br>
								<img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""> 잦은 변경을 막기 위해 닉네임은 변경시 포인트가 필요합니다. 신중히 결정하시기 바랍니다.<br><br>
								<img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""> <font color="red">불완전한 한글, 비속어, 종교, 이념, 특정인 비난과 사칭 등과 같은 닉네임을 사용하는 경우 로그인 제한 조치합니다.</font>
							<br><br></span></font></p>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_line" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_left">
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
								<center><strong>실명</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<input type="text" name="name_real" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:200px; height:22px; padding:1px; ime-mode:active; font-family:Gulim; font-weight:bold; font-size:9pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="4"><br><br>
								<img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""> 실명은 계정 정보 수정이나 탈퇴 등 본인 인증에 사용되므로 변경이 불가합니다.<br><br>
								<img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""> <font color="red">한글 실명이 아닌 경우 로그인 제한 조치합니다.</font>
							<br><br></span></font></p>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_line" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_left">
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
								<center><strong>이메일</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<input type="text" name="email" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:400px; height:22px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="40">&nbsp;
								<input type="button" value=" 중복검사 " onclick="check_email();" style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"><br><br>
								<img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""> 입력하신 이메일 주소로 인증 메일이 발송됩니다.<br><br>
								<img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""> <font color="red">일부 메일 업체(다음 한메일)에서는 인증 메일 도착하지 않을 수 있습니다.</font><br><br>
								<img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""> 메일이 오지 않으면 고객센터에서 이메일 재인증을 받으시기 바랍니다.
							<br><br></span></font></p>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_line" colspan='2'></td>
    			</tr>
					<tr>
						<td id="layout_guide_body_info_left">
							<p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="#311400"><span style="font-size:9pt;">
								<center><strong>추천인</strong></center>
							</span></font></p>
						</td>
						<td id="layout_guide_body_info_right">
							<br><p style="margin-right:15pt; margin-left:15pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
								<input type="text" name="join_id" disabled onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:200px; height:22px; padding:1px; ime-mode:disabled; font-family:Arial; font-weight:bold; font-size:10pt; color:rgb(91,43,0); border-width:1pt; border-color:rgb(128,128,128); border-style:solid; background-color:rgb(232,232,232);" maxlength="20">
								&nbsp;<label for="join_id_check"><input type="checkbox" name="join_id_check" id="join_id_check" onclick="join_id_option();"> <strong>추천인 있음</strong></label><br><br>
								<img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""> 추천받으신 분의 아이디를 알고 계시면 입력해 주세요.<br><br>
								<img align="top" src="http://akeetes430.cdn2.cafe24.com/bullet.gif"	width="12" height="12" border="0" alt=""> 추천인 입력시 등업할 때 마다 추가 보상이 있으며, 추천 받은 사람도 보상을 받게 됩니다.
							<br><br></span></font></p>
						</td>
					</tr>
					<tr>
        		<td id="layout_guide_body_info_line" colspan='2'></td>
    			</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<iframe name="join_process" id="join_process" style="display:none; width:0px; height:0px;"></iframe><input type="hidden" name="url" value="<?=$url?>"><input type="hidden" name="keycode4" value="<?=$keycode4?>"><br><center><input type="submit" value=" 가입 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;"></center><br>
			</td>
		</tr>
	</table>

</body>

</html>