<?require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$dirname= "upload/iblock/"; //место, откуда надо скопировать
header('Content-Type: text/html; charset=utf-8');
$script_name = basename(__FILE__);
if($handle = opendir($dirname)) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && !strpos($file, '.zip')) {
            $all_directory[] = $file;
        }
    }
    closedir($handle);
}
//sort($all_directory);
//$i = 0;

foreach($all_directory as $directory){
    if($handle = opendir('upload/iblock/'.$directory)) {

        while (false !== ($file = readdir($handle))) {
            if($file == '.' || $file == '..') continue;
            $old_file = 'upload/iblock/'.$directory.'/'.$file;
            $new_file = 'upload/import_img/'.$file;

            echo "<pre>".print_r($old_file, 1)."</pre><br>";
            echo "<pre>".print_r($new_file, 1)."</pre><br>";
            if (!copy($old_file, $new_file)) {
                echo "не удалось скопировать $file...\n";
                $errors= error_get_last();
                echo "COPY ERROR: ".$errors['type'];
                echo "<br />\n".$errors['message'];
            }
        }
        closedir($handle);
    }
    $i++;

}

