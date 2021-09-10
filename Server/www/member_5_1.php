<?

// 헤더파일	연결
include	"../header.php";

// 변수 변환
$url = mysql_real_escape_string($_SERVER[PHP_SELF]);

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  //echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

?>
<html> 
<head> 
<title> 경마게임 </title> 
<style> 
#horse0 { 
    border:solid 1px #000000; 
    position:absolute; 
    top:130; 
    left:70; 
    width:30; 
    height:30; 
    background-color:blue; 
} 
#horse1 { 
    border:solid 1px #000000; 
    position:absolute; 
    top:180; 
    left:70; 
    width:30; 
    height:30; 
    background-color:yellow; 
} 
#horse2 { 
    border:solid 1px #000000; 
    position:absolute; 
    top:230; 
    left:70; 
    width:30; 
    height:30; 
    background-color:green; 
} 
#horse3 { 
    border:solid 1px #000000; 
    position:absolute; 
    top:280; 
    left:70; 
    width:30; 
    height:30; 
    background-color:gray; 
} 
#horse4 { 
    border:solid 1px #000000; 
    position:absolute; 
    top:330; 
    left:70; 
    width:30; 
    height:30; 
    background-color:red; 
} 
</style> 
<script language="javascript"> 
<!-- 
var horse0, horse1, horse2, horse3, horse4; 
var origin, allin, choiceHorse; 
var xpoint=0; 
var layerControl; 
function battingSelect(){ 
    var money = document.getElementById("money"); 
    var batting = document.getElementById("batting"); 
    if(parseInt(batting.value) > parseInt(money.value)){ 
        alert("배팅금액이 보유금액보다 크면 안됩니다."); 
        return true; 
    }else if(parseInt(batting.value) == 0){ 
        alert("배팅금액이 0원이면 안됩니다. 배팅해 주세요"); 
        return true; 
    }else{ 
        return false; 
    } 
} 
function startGame(obj){ 
    allin = document.getElementById("choice"); 
    if(allin.value == ""){ 
        alert("말을 선택해 주세요"); 
    }else{ 
        if(battingSelect() == false){ 
            choiceHorse = allin.value; 
            allin.disabled = true; 
            obj.disabled = true; 
            running(); 
        } 
    } 
} 
function running(){ 
    horse0Run(Rnd()); 
    horse1Run(Rnd()); 
    horse2Run(Rnd()); 
    horse3Run(Rnd()); 
    horse4Run(Rnd()); 
    stopGame(); 
    layerControl = setTimeout("running()",10); 
    clearGame(); 
} 
function stopGame(){ 
    if(parseInt(horse0.left) >= 870 && xpoint == 0){ 
        origin = "0"; 
        xpoint=1; 
    } 
    if(parseInt(horse1.left) >= 870 && xpoint == 0){ 
        origin = "1"; 
        xpoint=1; 
    } 
    if(parseInt(horse2.left) >= 870 && xpoint == 0){ 
        origin = "2"; 
        xpoint=1; 
    } 
    if(parseInt(horse3.left) >= 870 && xpoint == 0){ 
        origin = "3"; 
        xpoint=1; 
    } 
    if(parseInt(horse4.left) >= 870 && xpoint == 0){ 
        origin = "4"; 
        xpoint=1; 
    } 
} 
function resetGame(){ 
    horse0.left=70; 
    horse1.left=70; 
    horse2.left=70; 
    horse3.left=70; 
    horse4.left=70; 
    xpoint=0; 
    choiceHorse = ""; 
    document.getElementById("startBtn").disabled = false; 
    document.getElementById("resetBtn").disabled = true; 
    allin.disabled = false; 
    allin[0].selected; 
} 
function clearGame(){ 
    if(parseInt(horse0.left) >= 870 && parseInt(horse1.left) >= 870 && parseInt(horse2.left) >= 870 && parseInt(horse3.left) >= 870 && parseInt(horse4.left) >= 870){ 
        clearTimeout(layerControl); 
        endGameMsg(); 
        document.getElementById("resetBtn").disabled = false; 
    } 
} 
function endGameMsg(){ 
    if(origin == choiceHorse){ 
        alert("당첨 되었습니다!"); 
        battingPrice(true); 
    }else{ 
        alert("꽝~"); 
        battingPrice(false); 
    } 
} 
function battingPrice(yn){ 
    var money = document.getElementById("money"); 
    var batting = document.getElementById("batting"); 
    if(yn == true){ 
        money.value = parseInt(money.value) + parseInt(batting.value)*2; 
    }else{ 
        money.value = parseInt(money.value) - parseInt(batting.value); 
    } 
    batting.value=0; 
} 
function Rnd(){ 
    var px = Math.floor(Math.random()*3); 
    return px; 
} 
function _init(){ 
    horse0 = document.getElementById("horse0").style; 
    horse1 = document.getElementById("horse1").style; 
    horse2 = document.getElementById("horse2").style; 
    horse3 = document.getElementById("horse3").style; 
    horse4 = document.getElementById("horse4").style; 
    document.getElementById("resetBtn").disabled = true; 
} 
window.onload = function (){ 
    _init(); 
} 
function horse0Run(run){ 
    if(parseInt(horse0.left)<870){ 
        horse0.left = parseInt(horse0.left)+run; 
    } 
} 
function horse1Run(run){ 
    if(parseInt(horse1.left)<870){ 
        horse1.left = parseInt(horse1.left)+run; 
    } 
} 
function horse2Run(run){ 
    if(parseInt(horse2.left)<870){ 
        horse2.left = parseInt(horse2.left)+run; 
    } 
} 
function horse3Run(run){ 
    if(parseInt(horse3.left)<870){ 
        horse3.left = parseInt(horse3.left)+run; 
    } 
} 
function horse4Run(run){ 
    if(parseInt(horse4.left)<870){ 
        horse4.left = parseInt(horse4.left)+run; 
    } 
} 
//--> 
</script> 
</head> 

<body> 
<table cellpadding="0" cellspacing="0" border="0" width="800" style="border-right:solid 1px #000000;border-left:solid 1px #000000;position:absolute;top:100;left:100;"> 
    <tr height="50"> 
        <td style="border-bottom:dotted 1px #000000;"> </td> 
    </tr> 
    <tr height="50"> 
        <td style="border-bottom:dotted 1px #000000;"> </td> 
    </tr> 
    <tr height="50"> 
        <td style="border-bottom:dotted 1px #000000;"> </td> 
    </tr> 
    <tr height="50"> 
        <td style="border-bottom:dotted 1px #000000;"> </td> 
    </tr> 
    <tr height="50"> 
        <td style="border-bottom:dotted 1px #000000;"> </td> 
    </tr> 
    <tr height="50"> 
        <td> </td> 
    </tr> 
</table> 
<table cellpadding="0" cellspacing="0" border="0" width="600" style="position:absolute;top:550;left:250;"> 
    <tr> 
        <td><input type="button" value="경기시작" onclick="startGame(this);" id="startBtn" /></td> 
        <td><input type="button" value="초기화" onclick="resetGame();" id="resetBtn" /></td> 
        <td> 
            <select id="choice"> 
                <option selected>말선택</option> 
                <option value="0">1번말</option> 
                <option value="1">2번말</option> 
                <option value="2">3번말</option> 
                <option value="3">4번말</option> 
                <option value="4">5번말</option> 
            </select> 
        </td> 
        <td>보유금액:<input type="text" size="14" id="money" value="<?=$member[point]?>" readonly /></td> 
        <td>배팅:<input type="text" size="14" id="batting"  value="0" /></td> 
    </tr> 
</table> 
<span id="horse0" style="left:70"></span> 
<span id="horse1" style="left:70"></span> 
<span id="horse2" style="left:70"></span> 
<span id="horse3" style="left:70"></span> 
<span id="horse4" style="left:70"></span> 
</body> 
</html> 