// 높이 구하기
function screen() {
	var widthsize;
	var heightsize;
	widthsize = document.documentElement.scrollWidth;
	heightsize = document.documentElement.scrollHeight;
}

// 승인 및 거부
function check_1() {
	document.admin.submit.disabled = false;
	document.admin.level_reason.disabled = true;
	document.admin.level_reason[0].selected=true;
}
function check_2() {
	document.admin.submit.disabled = false;
	document.admin.level_reason.disabled = false;
}
function check_3() {
	if(document.admin.level_reason[10].selected) {
		document.admin.level_reason.style.display='none';
		document.admin.level_reason_text.style.display='';
	}
}

// 전문 기술 복사
function copy() {
	var copytext;
	var copytext=document.getElementById("skill").value;
	window.clipboardData.setData('Text',copytext);
	alert("복사가 완료되었습니다. 붙여넣기를 하시면 됩니다.");
}


function helper(index) {
	window.open("help.php?src="+index, "", "fullscreen=no,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,top=0px,left=0px,width=920px,height=500px");
}