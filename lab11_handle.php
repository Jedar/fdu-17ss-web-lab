<?php
  if($_SERVER["REQUEST_METHOD"] == 'GET'||$_SERVER["REQUEST_METHOD"] == 'POST'){
      uploadMusicFile('file');
      $lyric = $_POST['edit_lyric'];
      $title = $_POST['title'];
      $artist = $_POST['artist'];
      $txt = "[ti:$title]\n[ar:$artist]\n".$lyric;
      $path = "upload/".$artist." - ".$title .".lrc";
      $myfile = fopen(iconv ( 'UTF-8', 'GBK', $path ),"w");
      fwrite($myfile, $txt);
      fclose($myfile);
  }else{
      exit();
  }
function uploadMusicFile($fileField){
    $backInfo = array();
    $files = $_FILES[$fileField];
    $fileName = $files['name'];
    $fileType = $files["type"];
    $fileTemp = $files['tmp_name'];
    error_log($files['size']);
    if($fileName != "" && $fileTemp != "" && $fileType != ""){
        if(allowType($fileType)){
            $newFileName = $fileName;
            if(file_exists("upload/".$newFileName)){
                unlink("upload/".$newFileName);
            }
            $backInfo["filestate"] = @move_uploaded_file($fileTemp,"upload/".$fileName) ? "true" : "false";
        }else{
            $backInfo["filename"] = "不合法的文件类型";
            $backInfo["filestate"] = "false";
        }
    }else{
        $backInfo["filename"] = "上传数据失败";
        $backInfo["filestate"] = "false";
    }
    print json_encode($backInfo);
}
function allowType($type){
    $types = array('application/x-js','application/octet-stream','application/x-php','text/html');
    if(in_array($type,$types)){
        return false;
    }else{
        return true;
    }
}
?>
