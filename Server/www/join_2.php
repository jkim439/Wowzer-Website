<?

// 헤더파일 연결
include "../header.php";

// 변수 변환
$url = mysql_real_escape_string($_POST[url]);
$id = mysql_real_escape_string($_POST[id]);
$pw_1 = mysql_real_escape_string($_POST[pw_1]);
$pw_2 = mysql_real_escape_string($_POST[pw_2]);
$name_nick = mysql_real_escape_string($_POST[name_nick]);
$name_real = mysql_real_escape_string($_POST[name_real]);
$email = mysql_real_escape_string($_POST[email]);
$join_id = mysql_real_escape_string($_POST[join_id]);
$keycode4 = mysql_real_escape_string($_POST[keycode4]);
$key = mysql_real_escape_string($_POST[key]);

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

// 중복 가입 방지 쿠키 검사
if($_COOKIE[wowzer_join]=="1") {
	echo "<script>location.href='$site_403';</script>"; exit;
}

// 보안 코드 인증
$keycode1 = "4y89y54wun8her459kyg6uh35ygmepzg";
$keycode2 = md5($keycode1.$keycode4.$keycode1);
$keycode3 = mb_substr($keycode2,10,5,'UTF-8');
if($key!= $keycode3){
  echo "<script>alert(' 보안 코드가 올바르지 않습니다. ');</script>"; exit;
}

// 글자수 검사
$id_length = strlen($id);
$pw_1_length = strlen($pw_1);
$pw_2_length = strlen($pw_2);
$name_nick_length = strlen($name_nick);
$name_real_length = strlen($name_real);
$email_length = strlen($email);

if($id_length<4) {
  echo "<script>alert(' 아이디는 최소 4글자이여야 합니다. ');</script>"; exit;
}
if($pw_1_length<4) {
  echo "<script>alert(' 비밀번호는 최소 4글자이여야 합니다. ');</script>"; exit;
}
if($pw_2_length<4) {
  echo "<script>alert(' 비밀번호는 최소 4글자이여야 합니다. ');</script>"; exit;
}
if($name_nick_length<2) {
  echo "<script>alert(' 닉네임은 최소 2글자이여야 합니다. ');</script>"; exit;
}
if($name_real_length<2) {
  echo "<script>alert(' 실명은 최소 2글자이여야 합니다. ');</script>"; exit;
}
if($email_length<5) {
  echo "<script>alert(' 이메일은 최소 5글자이여야 합니다. ');</script>"; exit;
}

// 비밀번호 일치 여부
if($pw_1 != $pw_2){
  echo "<script>alert(' 비밀번호와 비밀번호 확인이 서로 다릅니다. ');</script>"; exit;
}

// 아이디에 영어 소문자와 숫자만 허용할 경우
preg_match_all('/[a-z]|[0-9]/', $id, $id_check);
$id_check = implode('', $id_check[0]);
if($id <> $id_check){
  echo "<script>alert(' 아이디에는 영어 소문자와 숫자만 사용할 수 있습니다. ');</script>"; exit;
}

// 닉네임에 영어와 숫자만 허용할 경우
$name_check = preg_replace ("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $name_nick);
if($name_nick != $name_check){
  echo "<script>alert(' 닉네임에는 영어와 한글만 사용할 수 있습니다. ');</script>"; exit;
}

// 아이디 체크
$id_result = mysql_query("select * from member where id='$id'");
$id_check = mysql_fetch_array($id_result);
if($id_check[id]) {
  echo "<script>alert(' 이미 사용 중인 아이디입니다. ');</script>"; exit;
}

// 닉네임 체크
$name_result = mysql_query("select * from member where name_nick='$name_nick'");
$name_check = mysql_fetch_array($name_result);
if($name_check[name_nick]) {
  echo "<script>alert(' 이미 사용 중인 닉네임입니다. ');</script>"; exit;
}

// 이메일 체크
$email_result = mysql_query("select * from member where email='$email'");
$email_check = mysql_fetch_array($email_result);
if($email_check[email]) {
  echo "<script>alert(' 이미 사용 중인 이메일입니다. ');</script>"; exit;
}

// 추천인 체크
$join_id_result = mysql_query("select * from member where id='$join_id'");
$join_id_check = mysql_fetch_array($join_id_result);
if(!$join_id_check[no] && $join_id!="") {
  echo "<script>alert(' 입력하신 추천인 아이디는 존재하지 않습니다. ');</script>"; exit;
}

// 중복 가입 방지 쿠키 생성
setcookie('wowzer_join', '1', time()+86400, '/');

// 비밀번호 암호화
$pw = md5(md5($key1).md5($pw_1).md5($key1));

// 이메일 인증키 생성
$email_key = md5(md5($key1).md5($id).md5($email));

// 현재 시간
$time = time();

if($join_id=="") $join_id=0;

// 데이터베이스 등록

mysql_query("INSERT INTO `akeetes430`.`member` (`no`, `id`, `pw`, `point`, `title`, `avata`, `memo`, `name_nick`, `name_real`, `level`, `level_state`, `level_time`, `level_reason`, `email`, `email_key`, `login_browser`, `login_date`, `login_ip`, `login_key`, `login_reason`, `login_release`, `login_state`, `login_try`, `join_date`, `join_id`, `join_agreement`, `admin_mode`, `log_point_1`, `log_point_1_time`, `log_point_2`, `log_point_2_time`, `log_point_3`, `log_point_3_time`, `log_point_4`, `log_point_4_time`, `log_point_5`, `log_point_5_time`, `character_code`, `character_mode`, `character_name`, `character_job`, `character_level`, `character_skill_1`, `character_skill_2`, `character_1_name`, `character_1_job`, `character_1_skill_1`, `character_1_skill_2`, `character_2_name`, `character_2_job`, `character_2_skill_1`, `character_2_skill_2`, `character_3_name`, `character_3_job`, `character_3_skill_1`, `character_3_skill_2`, `character_4_name`, `character_4_job`, `character_4_skill_1`, `character_4_skill_2`, `character_5_name`, `character_5_job`, `character_5_skill_1`, `character_5_skill_2`, `character_6_name`, `character_6_job`, `character_6_skill_1`, `character_6_skill_2`, `character_7_name`, `character_7_job`, `character_7_skill_1`, `character_7_skill_2`, `character_8_name`, `character_8_job`, `character_8_skill_1`, `character_8_skill_2`, `character_9_name`, `character_9_job`, `character_9_skill_1`, `character_9_skill_2`, `item_1`, `item_2`, `item_3`, `item_4`, `item_5`, `item_6`, `item_7`, `item_8`, `item_9`, `item_10`, `item_11`, `item_12`, `item_13`, `item_14`, `item_15`, `item_16`, `item_17`, `item_18`, `item_19`, `item_20`, `item_21`, `item_22`, `item_23`, `item_24`, `item_25`, `item_26`, `item_27`, `item_28`, `item_29`, `item_30`, `item_31`, `item_32`, `item_33`, `item_34`, `item_35`, `item_36`, `item_37`, `item_38`, `item_39`, `item_40`, `item_41`, `item_42`, `item_43`, `item_44`, `item_45`, `item_46`, `item_47`, `item_48`, `item_49`, `item_50`, `item_51`, `item_52`, `item_53`, `item_54`, `item_55`, `item_56`, `item_57`, `item_58`, `item_59`, `item_60`, `item_61`, `item_62`, `item_63`, `item_64`, `item_65`, `item_66`, `item_67`, `item_68`, `item_69`, `item_70`, `item_71`, `item_72`, `item_73`, `item_74`, `item_75`, `item_76`, `item_77`, `item_78`, `item_79`, `item_80`, `item_81`, `item_82`, `item_83`, `item_84`, `item_85`, `item_86`, `item_87`, `item_88`, `item_89`, `item_90`, `item_91`, `item_92`, `item_93`, `item_94`, `item_95`, `item_96`, `item_97`, `item_98`, `item_99`, `item_100`, `item_101`, `item_102`, `item_103`, `item_104`, `item_105`, `item_106`, `item_107`, `item_108`, `item_109`, `item_110`, `item_111`, `item_112`, `item_113`, `item_114`, `item_115`, `item_116`, `item_117`, `item_118`, `item_119`, `item_120`, `item_121`, `item_122`, `item_123`, `item_124`, `item_125`, `item_126`, `item_127`, `item_128`, `item_129`, `item_130`, `item_131`, `item_132`, `item_133`, `item_134`, `item_135`, `item_136`, `item_137`, `item_138`, `item_139`, `item_140`, `item_141`, `item_142`, `item_143`, `item_144`, `item_145`, `item_146`, `item_147`, `item_148`, `item_149`, `item_150`, `item_151`, `item_152`, `item_153`, `item_154`, `item_155`, `item_156`, `item_157`, `item_158`, `item_159`, `item_160`, `item_161`, `item_162`, `item_163`, `item_164`, `item_165`, `item_166`, `item_167`, `item_168`, `item_169`, `item_170`, `item_171`, `item_172`, `item_173`, `item_174`, `item_175`, `item_176`, `item_177`, `item_178`, `item_179`, `item_180`, `item_181`, `item_182`, `item_183`, `item_184`, `item_185`, `item_186`, `item_187`, `item_188`, `item_189`, `item_190`, `item_191`, `item_192`, `item_193`, `item_194`, `item_195`, `item_196`, `item_197`, `item_198`, `item_199`, `item_200`, `item_201`, `item_202`, `item_203`, `item_204`, `item_205`, `item_206`, `item_207`, `item_208`, `item_209`, `item_210`, `item_211`, `item_212`, `item_213`, `item_214`, `item_215`, `item_216`, `item_217`, `item_218`, `item_219`, `item_220`, `item_221`, `item_222`, `item_223`, `item_224`, `item_225`, `item_226`, `item_227`, `item_228`, `item_229`, `item_230`, `item_231`, `item_232`, `item_233`, `item_234`, `item_235`, `item_236`, `item_237`, `item_238`, `item_239`, `item_240`, `item_241`, `item_242`, `item_243`, `item_244`, `item_245`, `item_246`, `item_247`, `item_248`, `item_249`, `item_250`, `item_251`, `item_252`, `item_253`, `item_254`, `item_255`, `item_256`, `item_257`, `item_258`, `item_259`, `item_260`, `item_261`, `item_262`, `item_263`, `item_264`, `item_265`, `item_266`, `item_267`, `item_268`, `item_269`, `item_270`, `item_271`, `item_272`, `item_273`, `item_274`, `item_275`, `item_276`, `item_277`, `item_278`, `item_279`, `item_280`, `item_281`, `item_282`, `item_283`, `item_284`, `item_285`, `item_286`, `item_287`, `item_288`, `item_289`, `item_290`, `item_291`, `item_292`, `item_293`, `item_294`, `item_295`, `item_296`, `item_297`, `item_298`, `item_299`, `item_300`) VALUES (NULL, '$id', '$pw', '0', '0', '1', '0', '$name_nick', '$name_real', '1', '0', '0', '0', '$email', '$email_key', '0', '0', '0', '0', '0', '0', '4', '0', '$time', '$join_id', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')", $dbconn);

// 제목
$subject = 'Eternal Soulmate 인증 메일입니다.';

// 내용
$message = "
<meta http-equiv='content-type' content='text/html; charset=utf-8'><br>
<table width='500' height='400' background='http://akeetes430.cdn2.cafe24.com/mail_certify.gif' cellpadding='0' cellspacing='0' style='border-width:2pt; border-color:black; border-style:solid;'>
    <tr>
        <td width='500' height='50'><font face='굴림'><span style='font-size:9pt;'>&nbsp;</span></font></td>
    </tr>
    <tr>
        <td width='500' height='150'>
            <p style='margin-right:20pt; margin-left:20pt;'><span style='font-size:9pt;'><font face='굴림' color='white'><b><br>
전세계 1위 와우 프리 서버의 한국인 초대형 길드인,<br>
<br>
Eternal Soulmate에 가입해 주셔서 진심으로 감사의 말씀 드립니다.<br>
<br>
<br>
이 메일은 회원 가입시 이메일 확인을 위한 인증 메일입니다.<br>
<br>
아래 인증 받기를 클릭하시면 이메일 인증이 완료됩니다.</b></font></span><font face='굴림'><span style='font-size:9pt;'></span></font></p>
        </td>
    </tr>
    <tr>
        <td width='500' height='50'>
            <p style='margin-right:20pt; margin-left:20pt;' align='center'><span style='font-size:9pt;'><font face='굴림' color='white'><b><br>
<a href='http://www.wowzer.kr/join_certify.php?key=$email_key' target='_blank'><font color='blue'>[인증 받기]</font></a><br>
&nbsp;</b></font></span><font face='굴림'><span style='font-size:9pt;'></span></font></p>
        </td>
    </tr>
    <tr>
        <td width='490' height='150'>
            <p style='margin-right:20pt; margin-left:20pt;' align='left'><span style='font-size:9pt;'><font face='굴림' color='white'><b><br>
혹시 인증에 문제가 발생하면 <a href='mailto:tive@wowzer.kr'><font color='blue'>tive@wowzer.kr</font></a>으로<br>
<br>
아래 인증키를 보내주시기 바랍니다.<br>
<br>
<br>
</b></font><font face='굴림' color='black'>인증키 : <b>$email_key</font></span></b><span style='font-size:9pt;'><font face='굴림' color='white'><b><br>
&nbsp;</b></font></span><font face='굴림'><span style='font-size:9pt;'></span></font></p>
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
echo "<script>alert(' 입력하신 이메일로 인증 메일을 보냈습니다. \\n\\n 이메일 인증을 하시면 회원가입이 완료됩니다. ');parent.window.close();</script>"; exit;

?>