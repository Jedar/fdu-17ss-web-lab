<?php
  if($_SERVER["REQUEST_METHOD"] == 'GET'||$_SERVER["REQUEST_METHOD"] == 'POST'){
      upload();
  }else{
      exit();
  }
function uploadMusicFile($fileField){
    $upfile = array();
    $files = $_FILES[$fileField];
    $fileName = $files['name'];
    $fileType = $files["type"];
    $fileTemp = $files['tmp_name'];
    error_log($files['size']);
    //why here get file size 0???
    if($fileName != "" and $fileTemp != "" and $fileType != ""){
        if(allowType($fileType)){
            $upfile["filesize"] = filesize($fileTemp);
            $filePath = "upload/";
            $newFileName = $fileName;
            $upfile["filename"] = $newFileName;
            $upfile["filetype"] = $fileType;
            if(file_exists($filePath . $newFileName)){
                unlink($filePath . $newFileName);
            }
            $upfile["filestat"] = @move_uploaded_file($fileTemp,$filePath.$fileName) ? "true" : "false";
            header("Location:lab11.html");
        }else{
            $upfile["filename"] = "非法的文件类型";
            $upfile["filestat"] = "false";
        }
    }else{
        $upfile["filename"] = "无效的文件数据";
        $upfile["filestat"] = "false";
    }
}
function upload(){
    uploadMusicFile('file_upload');
    $lyric = $_POST['edit_lyric'];
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $txt = "[ti:$title]\n[ar:$artist]\n".$lyric;
    $path = "upload/".$artist." - ".$title .".lrc";
    $myfile = fopen(iconv ( 'UTF-8', 'GBK', $path ),"w");//编码转换
    fwrite($myfile, $txt);
    fclose($myfile);
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
