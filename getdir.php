<?php
    $files = array();
    if($handle = @opendir('upload')) {
        while(($file = readdir($handle)) !== false) {
            if($file != ".." && $file != ".") {
                $en = getExtendedName($file);
                if ($en == 'mp3'){
                    $files[] = $file;
                }
            }
        }
        closedir($handle);
        print json_encode($files);
    }
function getExtendedName($fileName){
        $ex = explode(".",$fileName);
    return $ex[count($ex)-1];
}
?>