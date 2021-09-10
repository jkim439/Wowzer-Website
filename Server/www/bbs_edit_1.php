<?

// 게시판 환경설정 연결
include "config_bbs.php";

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 전역 변수
global $board, $url, $wno;
$board = mysql_real_escape_string($board);
$url = mysql_real_escape_string($url);
$wno = mysql_real_escape_string($wno);

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

// 게시물 로드
$view = mysql_fetch_array(mysql_query("SELECT * FROM $board WHERE wno=$wno", $dbconn));

// 게시물 작성자 로드
$member_view = mysql_fetch_array(mysql_query("select * from member where no='$view[no]'",$dbconn));

// 수정 권한 확인
if($member_view[no]!=$member[no]){
  echo "<script>self.location.href='$site_403';</script>"; exit;
}

if($member_view[login_state]=="5"){
	echo "<script>alert(' 글이나 댓글의 수정, 삭제가 금지된 계정입니다. ');history.back();</script>";exit;
}

$folder = $view[path];

?>
<div id="div_overlay" style="display:none;"></div>
<script type="text/javascript" src="editor/js/HuskyEZCreator.js" charset="utf-8"></script>
<form name="write" target="edit_process" method="post" action="bbs_edit_2.php" enctype="multipart/form-data" onsubmit="return _onSubmit(this);">
<center>
	<br>
	<table id="layout_bbs" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td id="layout_bbs_titleline" colspan="2"></td>
		</tr>
		<tr>
			<td id="layout_bbs_title" colspan="2">
				<table style="width:700px; height:35px;" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="width:80px; height:35px;">
							<p style="margin-left:10pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<select name="category" size="1" style="width:70px;<?if($member[login_browser]=="1"){?> height:25px;<?}?> padding:1px; font-family:Gulim; font-size:9pt; color:rgb(0,0,0);">
									<option value="0">종류</option>
									<?
										for($i=1;$i<=$category;$i++) {
											$category_i = ${'category_'.$i};
									?>
									<option value="<?=$i?>"<?if($view[category]==$i){?> selected<?}?>>[<?=$category_i?>]</option>
									<?
										}
									?>
								</select>
							</span></font></p>
						</td>
						<td style="width:430px; height:35px;">
							<p style="margin-right:0pt; margin-left:10pt;"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<input type="text" name="title" value="<?=$view[title]?>" onblur="defence_on(); this.style.padding='2px'; this.style.border='1px solid #FF9900';" onfocus="defence_off(); this.style.padding='1px'; this.style.border='2px solid #FF9900';" style="width:400px; height:18px; padding:1px; font-family:Gulim; font-size:9pt; color:rgb(0,0,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;" maxlength="30">
							</span></font></p>
						</td>
						<td style="width:190px; height:35px;">
							<p style="margin-right:5pt; margin-left:5pt;" align="right"><font face="Gulim" color="white"><span style="font-size:9pt;">
								<label for="goldbox_check"><input type="checkbox" name="goldbox_check" id="goldbox_check"<?if($view[goldbox]=="1"){?> checked<?}?><?if($member[level]>4){?> onclick="goldbox_1();"<?}else{?> onclick="goldbox_2();"<?}?>> 금테</label>
								&nbsp;<label for="timefix_check"><input type="checkbox" name="timefix_check" id="timefix_check"<?if($member[level]<5){?> onclick="alert(' Staff 등급(5 레벨)부터 이용할 수 있습니다. ');document.getElementById('timefix_check').checked = false;"<?}else{?> value="1"<?}?>> 작성시간 고정</label>
							</span></font></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_titleline" colspan="2"></td>
		</tr>
		<tr>
			<td id="layout_bbs_info" colspan="2">
				<!-- 아바타/계정 정보 전용 테이블 -->
				<table>
					<tr>
						<td style="width:70px;">
							<p style="margin-left:5pt; margin-right:0pt;"><font face="Gulim" color="#241606"><span style="font-size:9pt;">
							<img src="http://akeetes430.cdn2.cafe24.com/<?=$member_avata[image]?>" align="left" alt="<?=$member_avata[name]?>" style="width:64px; height:64px; border-width:2pt; border-style:solid;<?if($member_avata[level]=="1"){?> border-color:rgb(255,255,255);<?}elseif($member_avata[level]=="2"){?> border-color:rgb(17,121,0);<?}elseif($member_avata[level]=="3"){?> border-color:rgb(0,72,255);<?}elseif($member_avata[level]=="4"){?> border-color:rgb(130,34,204);<?}else{?> border-color:rgb(255,114,0);<?}?>">
						</td>
						<td style="width:630px;">
							<p style="margin-left:5pt; margin-right:0pt;"><font face="Gulim" color="#241606"><span style="font-size:9pt;">
								<?if($member[title]=="0"){?>칭호가 없습니다.<?}else{?><?=$member[title]?><?}?><br>
								<?if($member[level]>4){?><img src="http://akeetes430.cdn2.cafe24.com/icon_admin.gif" align="absmiddle" style="width:20px; height:13px;" alt="운영진"> <?}elseif($member[level]=="4"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_gold.gif" align="absmiddle" style="width:20px; height:13px;" alt="골드"> <?}elseif($member[level]=="3"){?><img src="http://akeetes430.cdn2.cafe24.com/icon_silver.gif" align="absmiddle" style="width:20px; height:13px;" alt="실버"> <?}?><strong><?=$member[name_nick]?></strong><br><br>
								<strong><?=$level?></strong> (<strong><?=$member[level]?></strong> 레벨)<br>
								<strong><?=$member[point]?></strong> 포인트
							</font></span></p>
						</td>
					</tr>
				</table>
				<!-- 아바타/계정 정보 전용 테이블 -->
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_text_header_1" colspan="2"<?if($view[goldbox]=="1"){?> style="display:none;"<?}else{?> style="display:;"<?}?>></td>
			<td id="layout_bbs_text_header_2" colspan="2"<?if($view[goldbox]=="1"){?> style="display:;"<?}else{?> style="display:none;"<?}?>></td>
		</tr>
		<tr>
			<td id="layout_bbs_text_middle" colspan="2">
				<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<textarea name="text" id="text" style="width:640px; height:240px; word-break:break-all;"><?=$view[text]?></textarea>
				</font></span></p>
				<p style="margin-right:20pt; margin-left:23pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<?if($member[login_browser]=="1"){?>
					<select name="imgupload[]" align="left" size="3" style="width:439px; height:50px; padding:1px; font-family:Gulim; font-size:9pt; color:rgb(0,0,0);">
					<?
					$path = "upload/$board/".$view[path]."/";
						$k=0;
					if ($dh = opendir($path)) 
					{
						while (($file = readdir($dh)) !== false)
						{
							if ($k=="0") $selection = "selected";
							if ($file[0] == ".") continue;
							if (filetype($path . "/" . $file) == 'dir') continue;
							if(!eregi("\.jpg$|\.gif$|\.bmp$|\.png$",$file)) {
							} else {
								echo "<option id=\"$file\" $selection>$file</option>";
								$k++;
							}
						}
					}
					?>
					<input type="text" name="img_num" value="<?=$k?>" readonly onfocus="this.blur();" style="cursor:default; margin-left:5pt; width:15px; border-width:1pt; border-color:rgb(255,255,255); border-style:solid; font-family:'Gulim'; font-size:9pt;">개 이미지 업로드 <font color="red">(최대 20개)</font><br>
        	<input type="button" value="이미지 업로드" onclick="self.location.href='#'; div_show('div_overlay'); div_show('div_imgupload');" style="margin-left:5pt; width:90px; height:19px; font-family:'Gulim'; font-size:9pt;">
					&nbsp;<input type="button" value="이미지 삭제" onclick="delItem();" style="width:90px; height:19px; font-family:'Gulim'; font-size:9pt;">
					<?}else{?>
					<br><center><font color="red">이미지 업로드 기능은 인터넷 익스플로러에서만 이용할 수 있습니다.</font></center>
					<?}?>
				</font></span></p>
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_text_bottom_1" colspan="2"<?if($view[goldbox]=="1"){?> style="display:none;"<?}else{?> style="display:;"<?}?>></td>
			<td id="layout_bbs_text_bottom_2" colspan="2"<?if($view[goldbox]=="1"){?> style="display:;"<?}else{?> style="display:none;"<?}?>></td>
		</tr>
		<tr>
			<td id="layout_bbs_comment" colspan="2">
				<p style="margin-right:20pt; margin-left:20pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<strong>파일 첨부</strong>
				</font></span></p>
			</td>
		</tr>
		<tr>
			<td style="width:150px; height:32px;">
				<span style="font-size:5pt;"><br></span>
				<p style="margin-left:20pt; margin-right:0pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					파일 첨부 #1
				</font></span></p>
			</td>
			<td style="width:550px; height:32px;">
				<p style="margin-left:5pt; margin-right:5pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<?if($view[file_1_size]>0){?><?=$view[file_1_name_real]?><?}else{?>없음<?}?><font color="red"> (수정시 파일 첨부는 변경이 불가합니다)</font>
				</font></span></p>
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_comment_line" colspan="2">
				<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<img src="http://akeetes430.cdn2.cafe24.com/bbs_comment_line.gif" align="absmiddle" alt="" style="width:650px; height:1px;">
				</font></span></p>
			</td>
		</tr>
		<tr>
			<td style="width:150px; height:32px">
				<span style="font-size:5pt;"><br></span>
				<p style="margin-left:20pt; margin-right:0pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
					파일 첨부 #2
				</font></span></p>
			</td>
			<td style="width:550px; height:32px">
				<p style="margin-left:5pt; margin-right:5pt;"><font face="Gulim" color="black"><span style="font-size:9pt;">
				<?if($view[file_2_size]>0){?><?=$view[file_2_name_real]?><?}else{?>없음<?}?><font color="red"> (수정시 파일 첨부는 변경이 불가합니다)</font>
				</font></span></p>
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_comment_line" colspan="2">
				<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<img src="http://akeetes430.cdn2.cafe24.com/bbs_comment_line.gif" align="absmiddle" alt="" style="width:650px; height:1px;">
				</font></span></p>
			</td>
		</tr>
		<tr>
			<td style="width:700px; height:43px" colspan="2">
				<p align="center"><font face="Gulim" color="black"><span style="font-size:9pt;">
					<img src="http://akeetes430.cdn2.cafe24.com/illust_warning.gif" align="absmiddle" style="width:23px; height:23px;">
					&nbsp;파일 다운로드 1회당 작성자는 업로드 수익으로 100 포인트를 얻습니다.
				</font></span></p>
			</td>
		</tr>
		<tr>
			<td id="layout_bbs_comment_line" colspan="2">
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
					<input type="button" value=" 목록 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;" onclick="if(confirm(' 글쓰기를 취소하고 목록으로 돌아가시겠습니까? ')) self.location.href='<?=$url?>?page=<?=$page?>'; else ;">&nbsp;
				</p>
			</td>
			<td id="layout_bbs_bottom_right" style="width:350px;">
				<p style="margin-right:5pt; margin-left:5pt;" align="right">
					<iframe name="edit_process" id="edit_process" style="display:none; width:0px; height:0px;"></iframe><input type="hidden" name="url" value="<?=$url?>"><input type="hidden" name="board" value="<?=$board?>"><input type="hidden" name="wno" value="<?=$wno?>"><input type="hidden" name="goldbox" id="goldbox"<?if($view[goldbox]=="1"){?> value="1"<?}else{?> value="0"<?}?>><input type="submit" value=" 확인 " style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;">
				</p>
			</td>
		</tr>
	</table>
	<br><br><br>
</center>
</form>

<script>
 var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
 oAppRef: oEditors,
 elPlaceHolder: "text",
 sSkinURI: "editor/SEditorSkin.html",
 fCreator: "createSEditorInIFrame",
 bUseBlocker: false
});
 // var oEditors = [];
 // 마지막 옵션은 체감 속도 증진을 위해서 페이지 로딩 완료시 까지 화면 표시를 하지 않는 옵션 입니다. 
 // 개발 작업시에는 이 값을 false로 설정 하세요.
 // nhn.husky.EZCreator.createInIFrame(oEditors, "ir1", "SmartEditor/SEditorSkin.html", "createSEditorInIFrame", null, true);

 // 복수개의 에디터를 생성하고자 할 경우, 아래와 같은 방식으로 호출하고 oEditors.getById["ir2"]이나 oEditors[1]을 이용해 접근하면 됩니다.
 // nhn.husky.EZCreator.createInIFrame(oEditors, "ir2", "SEditorSkin.html", "createSEditorInIFrame", null, true);
 function _onSubmit(elClicked){
 	
	var upload_list = write["imgupload[]"];
	var upload_name = new Array();
	var upload_length = eval(write.img_num.value);
	var j = eval(write.img_num.value);
	var upload_length_change;
 for (i=0; i<j;){
upload_name[i] = upload_list[i].text;
if(!oEditors.getById["text"].getWYSIWYGDocument().getElementById(upload_name[i])) {
  edit_process.navigate("bbs_img_delete.php?board=<?=$board?>&folder=<?=$folder?>&name=" + upload_name[i]);
  alert(" 업로드 한 이미지가 본문에 존재하지 않아 삭제되었습니다. \n\n 삭제된 파일: "+upload_name[i]);
  upload_length_change = j - 1;
  write.img_num.value = upload_length_change;
  upload_list.options[i]=null;
  j = j-1;
	i=i;
} else {
	i++;
}
}



  
   
  // 에디터의 내용을 에디터 생성시에 사용했던 textarea에 넣어 줍니다.
  oEditors.getById["text"].exec("UPDATE_IR_FIELD", []);

  if(!document.getElementById("text").value) {alert('내용을 입력해 주세요.');return false;}

  //var aImgs = oEditors.getById["ir1"].getWYSIWYGDocument().getElementsByTagName("IMG");

  //alert(aImgs);
  
  // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
  try{
   elClicked.form.submit();
  }catch(e){} }
function delItem()
{
  var iul = write["imgupload[]"];
  var si = iul.selectedIndex;
  if(si == -1)
  {
    alert("파일이 선택되지 않았습니다.");
    return false;
    }
  if(!confirm("정말 삭제하시겠습니까?"))
    return false;

  var name =iul.options[si].text;
  var path = iul.options[si].value;
  
  if(oEditors.getById["text"].getWYSIWYGDocument().getElementById(name)) {
  	oEditors.getById["text"].getWYSIWYGDocument().getElementById(name).removeNode(true);
  }
  
  var num_3 = eval(write.img_num.value);
  var num_4 = num_3 - 1;
  write.img_num.value = num_4;
  
  edit_process.navigate("bbs_img_delete.php?board=<?=$board?>&folder=<?=$folder?>&name=" + name);

  iul.remove(si);
  

}
</script>
<table>
    <tr>
      <td>


<div id="div_imgupload" style="z-index:2; display:none; width:600px; height:300px; background-image:url('http://akeetes430.cdn2.cafe24.com/bbs_imgupload.gif');">
  <table style="width:600px; height:300px;">
  <form name="upload" action="bbs_img_upload.php" target="edit_process" method="post" enctype="multipart/form-data">
    <tr>
      <td style="width:600px; height:300px;">
      <input type="hidden" name="board" value="<?=$board?>">
      <input type="hidden" name="folder" value="<?=$folder?>">
      <script>
      function pathchg(thisObj) {

                thisObj.select();

                var selectionRange = document.selection.createRange();
                var selectionText = selectionRange.text.toString();

        //document.frmUpload.path.value = 'file://'+ selectionText +'';
        }
      </script>
      <center>
      
      <input type="file" align="center" name="img" onchange="pathchg(this);" onblur="defence_on();" onfocus="defence_off();" style="width:510px; height:18px; padding:1px; font-family:Gulim; font-size:9pt; color:rgb(0,0,0); border-width:1pt; border-color:rgb(255,153,0); border-style:solid;">
      <br><br>
      <input type="submit" value="업로드" style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;">
      <input type="button" value="취소" onclick="div_hide('div_imgupload');div_hide('div_overlay');" style="width:80px; height:23px; font-family:'Gulim'; font-size:9pt;">
      <br>
   	 </center>
      </td>
  </table>
    </tr>
  </form>
</div>
    </td>
  </tr>
</table>