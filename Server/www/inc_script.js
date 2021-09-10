
// 자바스크립트 체크
eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('b c(){2(3.4("5")){2(6.8.9("d")!=-1){2(6.8.9("7.0")==-1){3.4("5").e.f=\'\'}}}2(3.4("a")){3.4("a").g()}}',17,17,'||if|document|getElementById|layout|navigator||userAgent|indexOf|id_input|function|java_check|MSIE|style|display|focus'.split('|'),0,{}))
if(navigator.userAgent.indexOf("Opera") != -1) {
//	document.getElementById("layout").style.display='none';
}
function java_check_imgviewer() {
	document.getElementById("layout_imgviewer").style.display='';
}
function java_check_guide() {
	document.getElementById("layout_guide").style.display='';
}
function java_check_shop() {
	document.getElementById("layout_shop").style.display='';
}
function java_check_shop_iframe() {
	document.getElementById("layout_shop_iframe").style.display='';
}
function java_check_profile() {
	document.getElementById("layout_profile").style.display='';
}

// 보안 무력화 프로그램 체크
function dragno() {
	return false;
}
function defence_check() {
	eval('document.'+event.propertyName+'=dragno');
	alert(" 마우스 오른쪽 뚫기와 관련된 프로그램이 있습니다. \n\n 알툴바 같은 프로그램을 삭제해 주세요. ");
	return false;
}

// 무단복제 방지 시스템
if(document.all) {
	document.ondragstart = new Function ("return false");
	document.onselectstart = new Function ("return false");
} else {
	var preventCopy = function (e) {
		if (document.body.style.MozUserSelect != undefined) {
			document.body.style.MozUserSelect = "none";
		}
	}
	var preventF = function (e) {
		e.preventDefault();
		e.stopPropagation();
		return false;
	};
	window.oncontextmenu = preventF;
	window.addEventListener("load", preventCopy, false);
}

// 무단복제 방지 시스템 재설정
function defence_on() {
	if(document.all) {
		document.onselectstart = function() {return false;};
		document.ondragstart = function() {return false;};
	}	else {
		document.body.style.MozUserSelect = "none";
	}
}

// 무단복제 방지 시스템 해제
function defence_off(e) {
	if(document.all) {
		document.onselectstart = null;
		document.ondragstart = null;
	}	else {
		document.body.style.MozUserSelect = "";
	}
}

// 프레임셋 감시
function frame_check() {
	if(parent.frames.length=="0") {
		self.location.href="error_403.php";
	}
}

// 팝업창 열기
function popup_join() {
	window.open("join_1.php", "wowzer_member_join", "fullscreen=no,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,top=0px,left=0px,width=800px,height=600px");
}
function popup_guide(url) {
	var popcode = "wowzer_guide";
	window.showModalDialog("guide_1_"+url+".php",popcode,"dialogLeft:0px;dialogTop:0px;dialogWidth:800px;dialogHeight:600px;");
}
function popup_guide_beginner() {
	window.open("http://www.worldofwarcraft.co.kr/info/beginner/intro.html", "wowzer_guide_beginner", "fullscreen=no,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,top=0px,left=0px,width=1000px,height=720px");
}
function popup_shop() {
	window.open("shop.php", "wowzer_shop", "fullscreen=no,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,top=0px,left=0px,width=800px,height=600px");
}
function popup_profile(index) {
	window.open("profile.php?index="+index, "wowzer_profile", "fullscreen=no,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,top=0px,left=0px,width=891px,height=506px");
}
function popup_profile_search(index) {
	window.open("profile.php?index="+index+"&search=1", "wowzer_profile", "fullscreen=no,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,top=0px,left=0px,width=891px,height=506px");
}
function popup_oldbest() {
	alert(' 준비 중인 페이지입니다. 빠른 시일 내에 완성하겠습니다. ');
	//var popcode = "wowzer_oldbest";
	//window.showModalDialog("member_oldbest.php",popcode,"dialogLeft:0px;dialogTop:0px;dialogWidth:400px;dialogHeight:300px;");
}
function link_imgviewer(viewer_code) {
	self.location.href="imgviewer.php"+viewer_code;
}

// 팝업창 보안
function popup_secret(popcode_2) {
  var popcode_1 = window.dialogArguments;
  if(popcode_1!=popcode_2) {
  	self.location.href="error_403.php";
	}
}

// DIV 띄우기
function div_show(ds_id) {
	if(ds_id=="div_overlay") {
		document.getElementById(ds_id).style.width=document.body.scrollWidth;
		document.getElementById(ds_id).style.height=document.body.scrollHeight;
	}
	document.getElementById(ds_id).style.display = "";
}

// DIV 감추기
function div_hide(dh_id) {
	document.getElementById(dh_id).style.display = "none";
}

// DIV 이동
function div_move(e, dm_id) {
	if(document.all) {
		document.getElementById(dm_id).style.left=event.x + document.body.scrollLeft + 15;
		document.getElementById(dm_id).style.top=event.y + document.body.scrollTop + 15;
	} else {
		document.getElementById(dm_id).style.left=e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft + 15;
		document.getElementById(dm_id).style.top=e.clientY + document.body.scrollTop + document.documentElement.scrollTop + 15;
	}
}

// DIV ESC키 닫기
function div_esc(e, dk_id1, dk_id2) {
	if(document.all) {
		if(event.keyCode==27){
			document.getElementById(dk_id1).style.display = "none";
			document.getElementById(dk_id2).style.display = "none";
			return false;
		}
	} else {
		if(e.keyCode==27){
			document.getElementById(dk_id1).style.display = "none";
			document.getElementById(dk_id2).style.display = "none";
			return false;
		}
	}
}

// 가이드 리스트 변경
function guide_change() {
	var code1 = document.getElementById("guide_prelist").value;
	var code2 = document.getElementById("guide_list").value;
	document.getElementById(code1).style.display='none';
	document.getElementById(code2).style.display='';
	document.getElementById("guide_prelist").value = code2;
}

// 빈칸 비활성
function blank_check(bc_id,bc_button) {
	if(document.getElementById(bc_id).value.length==0){
		document.getElementById(bc_button).disabled=true;
	} else {
		document.getElementById(bc_button).disabled=false;
	}
}

// 숫자 입력
function only_num(e,	decimal) {
	var	key;
	var	keychar;

	if (window.event)	{
		// IE에서	이벤트를 확인하기	위한 설정
		key	=	window.event.keyCode;
	}	else if	(e)	{
		// FireFox에서 이벤트를	확인하기 위한	설정
		key	=	e.which;
	}	else {
		return true;
	}

	keychar	=	String.fromCharCode(key);
	if ((key ==	null)	|| (key	== 0)	|| (key	== 8)	|| (key	== 9)	|| (key	== 13) || (key	== 27))	{
		return true;
	}	else if	((("0123456789").indexOf(keychar)	>	-1)) {
		return true;
	}	else if	(decimal &&	(keychar ==	"."))	{
		return true;
	}	else {
		return false;
	}
}

// 포인트 상점 종료 후 기존 창 이동
function shop_reload() {
	opener.window.location.href="member_1.php#bag";
	window.self.close();
}

// 포인트 상점 쿠폰 확인
function shop_coupon() {
	if(document.buy.buy_coupon.value=="1"){
		document.buy.buy_submit.disabled=true;
	} else {
		document.buy.buy_submit.disabled=false;
	}
}

// 쿠폰번호 커서 자동 넘기기
function coupon_focus_1() {
	if(document.coupon.coupon_code_1.value.length==4) {
		document.coupon.coupon_code_2.focus();
	}
}
function coupon_focus_2() {
	if(document.coupon.coupon_code_2.value.length==4) {
		document.coupon.coupon_code_3.focus();
	}
}
function coupon_focus_3() {
	if(document.coupon.coupon_code_3.value.length==4) {
		document.coupon.coupon_code_4.focus();
	}
}
function coupon_focus_4() {
	if(document.coupon.coupon_code_4.value.length==4) {
		document.coupon.coupon_code_5.focus();
	}
}

// 댓글 공지사항
function comment_focus() {
	if(document.comment.comment_notice.value=="1") {
		document.comment.comment_notice.value="0"
		document.comment.text.value="";
	}
}

// 댓글 빈칸 검사
function comment_blank() {
	if(document.comment.text.value.length>0) {
		document.comment.comment_submit.disabled=false;
	} else {
		document.comment.comment_submit.disabled=true;
	}
}

// 금테 여부
function goldbox_1() {
	if(document.getElementById("goldbox_check").checked) {
		document.getElementById("layout_bbs_text_header_1").style.display = "none";
		document.getElementById("layout_bbs_text_header_2").style.display = "";
		document.getElementById("layout_bbs_text_bottom_1").style.display = "none";
		document.getElementById("layout_bbs_text_bottom_2").style.display = "";
		document.getElementById("goldbox").value = "1";
	} else {
		document.getElementById("layout_bbs_text_header_1").style.display = "";
		document.getElementById("layout_bbs_text_header_2").style.display = "none";
		document.getElementById("layout_bbs_text_bottom_1").style.display = "";
		document.getElementById("layout_bbs_text_bottom_2").style.display = "none";
		document.getElementById("goldbox").value = "0";
	}
}
function goldbox_2() {
	if(document.getElementById("goldbox_check").checked) {
		document.getElementById("layout_bbs_text_header_1").style.display = "none";
		document.getElementById("layout_bbs_text_header_2").style.display = "";
		document.getElementById("layout_bbs_text_bottom_1").style.display = "none";
		document.getElementById("layout_bbs_text_bottom_2").style.display = "";
		alert(" Staff 등급(5 레벨)부터 이용할 수 있습니다. ");
		document.getElementById("layout_bbs_text_header_1").style.display = "";
		document.getElementById("layout_bbs_text_header_2").style.display = "none";
		document.getElementById("layout_bbs_text_bottom_1").style.display = "";
		document.getElementById("layout_bbs_text_bottom_2").style.display = "none";
		document.getElementById("goldbox_check").checked = false;
		document.getElementById("goldbox").value = "0";
	} else {
		document.getElementById("layout_bbs_text_header_1").style.display = "";
		document.getElementById("layout_bbs_text_header_2").style.display = "none";
		document.getElementById("layout_bbs_text_bottom_1").style.display = "";
		document.getElementById("layout_bbs_text_bottom_2").style.display = "none";
		document.getElementById("goldbox_check").checked = false;
		document.getElementById("goldbox").value = "0";
	}
}

// 파일 첨부 확인
function file_1_check() {
	if(document.write.file_1.value.length=='0'){
		document.write.file_2.value="";
		document.write.file_2.outerHTML=document.write.file_2.outerHTML;
	}
}
function file_2_check() {
	if(document.write.file_1.value.length=='0'){
		alert(' 파일 첨부 #1을 먼저 이용하시기 바랍니다. ');
		document.write.file_2.blur();
	}
}