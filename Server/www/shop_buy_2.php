<?

// 헤더파일	연결
include	"../header.php";

// 무단 접속 검사
if(!eregi($_SERVER[HTTP_HOST],$_SERVER[HTTP_REFERER])) {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}
if(getenv("REQUEST_METHOD")!="POST") {
	echo "<script>self.location.href='$site_403';</script>"; exit;
}

// 로그인 인증키 확인
$member = mysql_fetch_array(mysql_query("select * from member where login_key='$_SESSION[wowzer_key]'",$dbconn));
if(!$_SESSION[wowzer_key] || $_SESSION[wowzer_key]!=$member[login_key]) {
	session_destroy();
	echo "<script>alert(' 로그인 후 이용할 수 있습니다. ');self.location.href='home.php';</script>"; exit;
}

// 변수 변환
$ino = mysql_real_escape_string($_POST[ino]);
$buy_method = mysql_real_escape_string($_POST[buy_method]);
$buy_coupon = mysql_real_escape_string($_POST[buy_coupon]);

// 상점 아이템 로드
$item = mysql_fetch_array(mysql_query("select * from item where ino='$ino'",$dbconn));
$item_i = 'item_'.$item[ino];
$coupon_i = 'item_'.$buy_coupon;

// 보유 중인 아이템
if($member[$item_i]!="0") {
	echo "<script>alert(' 현재 보유 중인 아이템입니다. ');history.back();</script>"; exit;
}

// 즉시 사용 아이템
if($item[ino]=="239" || $item[ino]=="240" || $item[ino]=="241") {
	$k = 2;
} else {
	$k = 1;
}

// 품절 및 비매품 아이템
if($item[state]=="3" || $item[state]=="4"){
	echo "<script>self.location.href='$site_403';</script>"; exit;
} else {

	// 최소 요구 등급 조건
	if($member[level]<$item[level_require]) {
		echo "<script>self.location.href='$site_403';</script>"; exit;
	} else {
	
		// 포인트 결제
		if($buy_method=="1") {
			if($member[point]<$item[price]) {
				echo "<script>self.location.href='$site_403';</script>"; exit;
			} else {
				// 포인트 기록 시스템
				
				$time = time();
				$code = "51";
				for($p=1;$p<6;$p++) {
					$log_point_p = "log_point_".$p;
					$log_point_p_time = "log_point_".$p."_time";
					if($member[$log_point_p]=="0") {
						break;
					}
				}
				if($p<6) {
					$log_point_p = "log_point_".$p;
					$log_point_p_time = "log_point_".$p."_time";
					mysql_query("update member set $log_point_p='$code' where no='$member[no]'", $dbconn);
					mysql_query("update member set $log_point_p_time='$time' where no='$member[no]'", $dbconn);
				} else {
					$r=2;
					for($q=1;$q<5;$q++) {
						$log_point_q = "log_point_".$q;
						$log_point_r = "log_point_".$r;
						$log_point_q_time = "log_point_".$q."_time";
						$log_point_r_time = "log_point_".$r."_time";
						mysql_query("update member set $log_point_q=$log_point_r where no='$member[no]'", $dbconn);
						mysql_query("update member set $log_point_q_time=$log_point_r_time where no='$member[no]'", $dbconn);
						$r++;
					}
					mysql_query("update member set log_point_5='$code' where no='$member[no]'", $dbconn);
					mysql_query("update member set log_point_5_time='$time' where no='$member[no]'", $dbconn);
				}
				
				mysql_query("update member set $item_i='$k' where no='$member[no]'", $dbconn);
				mysql_query("update member set point=point-$item[price] where no='$member[no]'", $dbconn);
				echo "<script>alert(' 아이템 구매를 완료하였습니다. ');top.shop_reload();</script>"; exit;
			}
		}
		
		// 무료 쿠폰 결제
		else if($buy_method=="2") {
		
			// 하급 아바타 무료 쿠폰
			if($buy_coupon=="244") {
				if($item[kind]=="1") {
					mysql_query("update member set $item_i='$k' where no='$member[no]'", $dbconn);
					mysql_query("update member set $coupon_i='0' where no='$member[no]'", $dbconn);
					echo "<script>alert(' 아이템 구매를 완료하였습니다. ');top.shop_reload();</script>"; exit;
				} else {
					echo "<script>alert(' 선택하신 쿠폰으로는 이 아이템을 구매할 수 없습니다. ');history.back();</script>"; exit;
				}
			}
		
			// 특수 아바타 무료 쿠폰
			else if($buy_coupon=="245") {
				if($item[kind]=="3") {
					mysql_query("update member set $item_i='$k' where no='$member[no]'", $dbconn);
					mysql_query("update member set $coupon_i='0' where no='$member[no]'", $dbconn);
					echo "<script>alert(' 아이템 구매를 완료하였습니다. ');top.shop_reload();</script>"; exit;
				} else {
					echo "<script>alert(' 선택하신 쿠폰으로는 이 아이템을 구매할 수 없습니다. ');history.back();</script>"; exit;
				}
			}
		
			// 상급 아바타 무료 쿠폰
			else if($buy_coupon=="246") {
				if($item[kind]=="2") {
					mysql_query("update member set $item_i='$k' where no='$member[no]'", $dbconn);
					mysql_query("update member set $coupon_i='0' where no='$member[no]'", $dbconn);
					echo "<script>alert(' 아이템 구매를 완료하였습니다. ');top.shop_reload();</script>"; exit;
				} else {
					echo "<script>alert(' 선택하신 쿠폰으로는 이 아이템을 구매할 수 없습니다. ');history.back();</script>"; exit;
				}
			}
			
			else {
				echo "<script>self.location.href='$site_403';</script>"; exit;
			}

		}
		
		// 결제 수단 미인증
		else {
			echo "<script>self.location.href='$site_403';</script>"; exit;
		}
	
	}

}

?>