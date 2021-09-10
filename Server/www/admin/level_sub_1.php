<?

// 헤더파일 연결
include "../../header.php";


// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

if($member[level]<5) {
	session_destroy();
  echo "<script>location.href='error_403.php';</script>"; exit;
}

$mode = mysql_real_escape_string($_GET[mode]);

// 등업 신청자 리스트
$time=time();
$result = mysql_query("SELECT * FROM member WHERE level_state='1' and character_mode='2' and level_time<=$time-172800 ORDER BY level_time", $dbconn);
?>

<center>서브 캐릭터
<br><br><font face='굴림' color='black'><span style='font-size:9pt;'>
Silver 업적 점수 조건: 기존 700 > <font color="red">800점 (100점 상향)</font><br>
Gold 업적 점수 조건: 기존 1400 > <font color="red">1600점 (200점 상향)</font>
</span></font>
<br><br>
<table cellspacing='0' bordercolordark='white' cellpadding='0'>
    <tr>
        <td height='35' background='images/bbs/view_title.jpg'>
            <table cellpadding='0' cellspacing='0' width='720' height='35'>
                    <tr>
                        <td width='35' height='35'>
                            <p align='center'><b><font face='굴림' color='white'><span style='font-size:9pt;'>순서</span></font></b></p>
                        </td>
                        <td width='50' height='35'>
                            <p align='center'><b><font face='굴림' color='white'><span style='font-size:9pt;'>아이디</span></font></b></p>
                        </td>
                        <td width='50' height='35'>
                            <p align='center'><b><font face='굴림' color='white'><span style='font-size:9pt;'>닉네임</span></font></b></p>
                        </td>
                        <td width='50' height='35'>
                            <p align='center'><b><font face='굴림' color='white'><span style='font-size:9pt;'>레벨</span></font></b></p>
                        </td>
                        <td width='50' height='35'>
                            <p align='center'><b><font face='굴림' color='white'><span style='font-size:9pt;'>신청일</span></font></b></p>
                        </td>
                        <td width='35' height='35'>
                            <p align='center'><b><font face='굴림' color='white'><span style='font-size:9pt;'>처리</span></font></b></p>
                        </td>
                    </tr>
                    
                    <?

// 반복 변수 초기화
$i = 0;
$j = 1;

// 게시물 목록
while($list = mysql_fetch_array($result)) {

// vmember 지정
$vmember = mysql_fetch_array(mysql_query("select * from member where no='$list[no]'",$dbconn));

// 반복 변수에 따른 속성 지정
if ($i) {
	$i = 0;
	$bgs = " bgcolor='#FFCA9B'";
	} else {
	$i = 1;
	$bgs = " bgcolor='#FFAA56'";
}

// 작성 날짜
$time = date("m.d", $vmember[level_time]);
?>
                    
                    <tr <?=$bgs?>>
                        <td width='35' height='35'>
                            <p align='center'><b><font face='굴림' color='black'><span style='font-size:9pt;'><?=$j?></span></font></b></p>
                        </td>
                        <td width='50' height='35'>
                            <p align='center'><b><font face='굴림' color='black'><span style='font-size:9pt;'><?=$vmember[id]?></span></font></b></p>
                        </td>
                        <td width='50' height='35'>
                            <p align='center'><b><font face='굴림' color='black'><span style='font-size:9pt;'><?=$vmember[name_nick]?></span></font></b></p>
                        </td>
                        <td width='50' height='35'>
                            <p align='center'><b><font face='굴림' color='black'><span style='font-size:9pt;'><?=$vmember[character_level]?></span></font></b></p>
                        </td>
                        <td width='50' height='35'>
                            <p align='center'><b><font face='굴림' color='black'><span style='font-size:9pt;'><?=$time?></span></font></b></p>
                        </td>
                        <td width='35' height='35'>
                            <p align='center'><b><font face='굴림' color='black'><span style='font-size:9pt;'><input type='button' name='ok' value="처리" style="font-family:'굴림'; font-size:'9pt';" onclick="location.href='level_sub_2.php?no=<?=$vmember[no]?>'"></span></font></b></p>
                        </td>
                    </tr><tr>
                        <td width='720' bgcolor='#522600' colspan='7' height='3'></td>
                    </tr>
                    <?
$j++;
}?>
                    
            </table>
        </td>
    </tr>
</table>
</center>

<br><p align='center'></p>