<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_POST[url]);
$key = mysql_real_escape_string($_POST[key]);
$keycode4 = mysql_real_escape_string($_POST[keycode4]);
$id = mysql_real_escape_string($_POST[id]);
$name_real = mysql_real_escape_string($_POST[name_real]);
$email = mysql_real_escape_string($_POST[email]);

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}
if(getenv("REQUEST_METHOD")!="POST") {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}
if(!eregi("$url",$_SERVER['HTTP_REFERER'])) {
	echo "<script>location.href='$site_403';</script>"; exit;
}

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
}

// 보안 코드 인증
$keycode1 = "4y89y54wun8her459kyg6uh35ygmepzg";
$keycode2 = md5($keycode1.$keycode4.$keycode1);
$keycode3 = mb_substr($keycode2,10,5,'UTF-8');
if($key!= $keycode3){
  echo "<script>alert(' 보안 코드가 올바르지 않습니다. ');self.location.href='help_find_2_1.php';</script>"; exit;
}

// 글자수 검사
$id_length = strlen($id);
$name_real_length = strlen($name_real);
$email_length = strlen($email);

if($id_length<4) {
  echo "<script>alert(' 아이디는 최소 4글자이여야 합니다. ');self.location.href='help_find_2_1.php';</script>"; exit;
}
if($name_real_length<2) {
  echo "<script>alert(' 실명은 최소 2글자이여야 합니다. ');self.location.href='help_find_2_1.php';</script>"; exit;
}
if($email_length<5) {
  echo "<script>alert(' 이메일은 최소 5글자이여야 합니다. ');self.location.href='help_find_2_1.php';</script>"; exit;
}

// 이이디 체크
$id_result = mysql_query("select * from member where id='$id'");
$member_find = mysql_fetch_array($id_result);

// 탈퇴 회원
if($member_find[pw]=="0") {
	echo "<script>alert(' 삭제된 계정입니다. ');self.location.href='help_find_2_1.php';</script>"; exit;
}

if($member_find[id]) {
	
	if($member_find[name_real]!=$name_real) {
		 echo "<script>alert(' 입력하신 정보가 올바르지 않습니다. ');self.location.href='help_find_2_1.php';</script>"; exit;
	} elseif($member_find[email]!=$email) {
		 echo "<script>alert(' 입력하신 정보가 올바르지 않습니다. ');self.location.href='help_find_2_1.php';</script>"; exit;
	} else {
		$time = time();
		$pw_temp = "mpogf7rewjire98udsahoiuju0jyoidf";
		$pw_temp = md5($time.$pw_temp.$time);
		$pw_temp = mb_substr($pw_temp,10,10,'UTF-8');
		$pw = md5(md5($key1).md5($pw_temp).md5($key1));
		mysql_query("update member set pw='$pw' where no='$member_find[no]'", $dbconn);
  
// 제목
$subject = 'Eternal Soulmate 찾기 메일입니다.';

// 내용
$message = "
<meta http-equiv='content-type' content='text/html; charset=utf-8'><br>
<table width='500' height='400' background='http://akeetes430.cdn2.cafe24.com/mail_find.gif' cellpadding='0' cellspacing='0' style='border-width:2pt; border-color:black; border-style:solid;'>
    <tr>
        <td width='500' height='50'><font face='굴림'><span style='font-size:9pt;'>&nbsp;</span></font></td>
    </tr>
    <tr>
        <td width='500' height='150'>
            <p style='margin-right:20pt; margin-left:20pt;'><span style='font-size:9pt;'><font face='굴림' color='white'><b><br>
전세계 1위 와우 프리 서버의 한국인 초대형 길드인,<br>
<br>
Eternal Soulmate의 비밀번호 찾기 메일입니다.<br>
<br>
<br>
고객센터에서 비밀번호 찾기 서비스를 이용하셨습니다.<br>
<br>
아래는 $member_find[name_nick]님의 임시 비밀번호입니다.</b></font></span><font face='굴림'><span style='font-size:9pt;'></span></font></p>
        </td>
    </tr>
    <tr>
        <td width='500' height='50'>
            <p style='margin-right:20pt; margin-left:20pt;' align='center'><span style='font-size:9pt;'><font face='굴림' color='black'><br>
임시 비밀번호: <b>$pw_temp</b><br>
&nbsp;</font></span><font face='굴림'><span style='font-size:9pt;'></span></font></p>
        </td>
    </tr>
    <tr>
        <td width='490' height='150'>
            <p style='margin-right:20pt; margin-left:20pt;' align='left'><span style='font-size:9pt;'><font face='굴림' color='white'><b><br>
혹시 문의사항이 있으시면 <a href='mailto:tive@wowzer.kr'><font color='blue'>tive@wowzer.kr</font></a>으로<br>
<br>
언제든지 문의해 주시기 바랍니다.<br>
<br>
<br>
저희 Eternal Soulmate 홈페이지를 이용해 주셔서 감사합니다.
<br></span></font></p>
        </td>
    </tr>
</table>
<br>
";

// HTML 내용을 메일로 보낼때는 Content-type을 설정해야한다
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// 받는사람 표시
$headers .= 'To: $name <$email>' . "\r\n";

// 보내는사람
$headers .= 'From: Eternal Soulmate <tive@wowzer.kr>' . "\r\n";

// 메일 보내기
mail($email, $subject, $message, $headers);

// 회원 가입 완료
echo "<script>alert(' 임시 비밀번호를 입력하신 이메일로 전송하였습니다. ');self.location.href='home.php';</script>"; exit;
}
} else {
  echo "<script>alert(' 입력하신 정보가 올바르지 않습니다. ');self.location.href='help_find_2_1.php';</script>"; exit;
}

?>