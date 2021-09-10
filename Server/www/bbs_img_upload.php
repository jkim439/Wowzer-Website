<?

// 헤더파일	연결
include	"../header.php";


$board = $_POST[board];
$folder = $_POST[folder];
 $file_temp = $_FILES[img][tmp_name];
 $file_name = $_FILES[img][name];
 $file_size = $_FILES[img][size];
 

// 업로드 용량
$file_max_size = "1048576";

 if(eregi("\.bmp$",$file_name)) {
        echo "<script>alert(' 용량 문제로 인해 BMP 이미지는 업로드가 금지됩니다. ')</script>";exit;
      }
 if(!eregi("\.jpg$|\.gif$|\.bmp$|\.png$",$file_name)) {
        echo "<script>alert(' 이미지만 업로드가 가능합니다. ')</script>";exit;
      }
      
      if($file_size>$file_max_size) {
        echo "<script>alert(' 이미지 용량이 너무 큽니다. 1MB를 넘을 수 없습니다. ')</script>";exit;
      }
      $file_name_unsecure = substr($file_name, 0, strrpos($file_name, ".")+0);
        preg_match_all('/[A-Z]|[a-z]|[0-9]|_/', $file_name_unsecure, $file_name_unsecure_spell);
        $file_name_secure = implode('', $file_name_unsecure_spell[0]);
        if($file_name_unsecure != $file_name_secure){
          echo "<script>alert(' 보안을 위해 파일 이름은 영어와 숫자만 가능합니다. \\n\\n 단, 특수 문자 중 _은 허용됩니다. ');</script>";exit;
        }
        

mkdir("upload/$board/$folder/", 0755);

$file_path = "upload/$board/$folder/".$file_name;
 if(move_uploaded_file($file_temp, $file_path)) {
              clearstatcache();
              

mysql_query("INSERT INTO upload_folder VALUES('', '$board', '$folder')", $dbconn);
            } else {
              echo "<script>alert(' 업로드 오류가 발생했습니다. 운영진에게 문의하세요. ');</script>";exit;
            }
            
$image_size = getimagesize($file_path);

if($image_size[0] > 588){
$width = "588";
$height_percent = $image_size[0] / 588;
$height_percent = sprintf('%.3f',$height_percent);
//$height_percent = (int)$height_percent;
$height = $image_size[1] / $height_percent;
$height = (int)$height;

} else {
$width = $image_size[0];
$height = $image_size[1];
}

$img_path = "../".$file_path;
$viewer_code = "?code=$folder&board=$board&name=$file_name";
?>
<script language="javascript">
parent.document.upload.img.select();
parent.document.selection.clear();

  var item = document.createElement("option");
  var name = "<?=$file_name?>";
  var path = "<?=$img_path?>";
 
  item.text = name;
  item.value = name;
  
  var num_1 = eval(parent.write.img_num.value);
  
  if(num_1=="20") {
     alert(' 이미지 업로드는 최대 20개까지만 가능합니다. ');
    } else {
 
 if(parent.oEditors.getById["text"].getWYSIWYGDocument().getElementById(name)) {
   alert(' 업로드한 이미지 중에 이미 같은 이름이 존재합니다. ');
   } else {
 
  parent.div_imgupload.style.display="none";
  parent.div_overlay.style.display="none";
  
  var num_2 = num_1 + 1;
  parent.write.img_num.value = num_2;
  
  parent.write["imgupload[]"].add(item);
  parent.write["imgupload[]"][num_1].selected=true;
  sHTML = "<img src=\"<?=$img_path?>\" id=\"" + name + "\" style=\"cursor:pointer; width:<?=$weight?>px; height:<?=$height?>px; border-width:2pt; border-color:black; border-style:solid;\" onclick=\"link_imgviewer('<?=$viewer_code?>');\" alt=\"그림을 크게 보시려면 클릭해 주세요.\">";
  parent.oEditors.getById["text"].exec("PASTE_HTML", [sHTML]);
  }
  }
  
</script>
