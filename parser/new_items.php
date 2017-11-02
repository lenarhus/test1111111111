<?require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");

$sectionLinc = getAllCategory();
// Получаем список Цветов
$colors = get_related(2);
// Получаем список Материалов
$materials = get_related(3);
// Получаем список производителей
$producers = get_related(4);
// Получаем типы цоколя
$socles = get_related(5);
// Получаем список стиилей
$styles = get_related(6);

// Парсим csv файл
$items = file("items.csv");
if(!$items) die("Необходимо загрузить csv файл");

foreach($items as $k => $item){

    if($k != 0){
        $ar = explode(";", $item);
        $name = trim($ar[0]);
        $article = trim($ar[1]);
        $cat1 = trim($ar[2]);
        $cat2 = trim($ar[3]);
        $cat3 = trim($ar[4]);
        $cat4 = trim($ar[5]);
        $country = trim($ar[6]);
        $producer = trim($ar[7]);
        $height = trim($ar[8]);
        $socle = trim($ar[9]);
        $voltage = trim($ar[10]);
        $diam = trim($ar[11]);
        $color_p = trim($ar[12]);
        $def = trim($ar[13]);
        $color_a = trim($ar[14]);
        $material_a = trim($ar[15]);
        $collection = trim($ar[16]);
        $power = trim($ar[17]);
        $type = trim($ar[18]);
        $material_p = trim($ar[19]);
        $style = trim($ar[20]);
        $count = trim($ar[21]);
        $new = trim($ar[22]);
        $hit = trim($ar[23]);
        $old_price = trim($ar[24]);
        $price = trim($ar[25]);
        $descr = trim($ar[26]);
        $img = trim($ar[27]);
        $gallery_img = explode(',', trim($ar[28]));

        // Получаем id элементов для привязки (Если нет создаем, и обновляем массив проверки)
        $colorp_id = check_element($color_p, $colors, 2);
        if(!array_key_exists($colorp_id, $colors)) $colors[$colorp_id] = $color_p;

        $colora_id = check_element($color_a, $colors, 2);
        if(!array_key_exists($colora_id, $colors)) $colors[$colora_id] = $color_a;

        $materialp_id = check_element($material_p, $materials, 3);
        if(!array_key_exists($materialp_id, $materials)) $materials[$materialp_id] = $material_p;

        $materiala_id = check_element($material_a, $materials, 3);
        if(!array_key_exists($materiala_id, $materials)) $materials[$materiala_id] = $material_a;

        $producer_id = check_element($producer, $producers, 4);
        if(!array_key_exists($producer_id, $producers)) $producers[$producer_id] = $producer;

        $socle_id = check_element($socle, $socles, 5);
        if(!array_key_exists($socle_id, $socles)) $socles[$socle_id] = $socle;

        $style_id = check_element($style, $styles, 6);
        if(!array_key_exists($style_id, $styles)) $styles[$style_id] = $style;


        //echo "<pre>".print_r($sectionLinc, 1)."</pre>";
        // Получаем Массив дочерних разделов категории $cat1
        $cat_array = findCategory($sectionLinc , $cat1);
        $cat_id = findParentId($cat_array);


        // Получаем Массив дочерних разделов категории $cat2 (Если $cat2 сущуствует)
        if($cat2 == '') $section_id = $cat_array['ID'];
        else $cat_array = findCategory($cat_array , $cat2);

        // Добавляем 2, 3 и 4 уровень раздела
        if(empty($cat_array)){
            $cat_id = add_section($cat_id, $cat2);
            if($cat3 != '') $cat_id = add_section($cat_id, $cat3);
            if($cat4 != '') $cat_id = add_section($cat_id, $cat4);

            // Обновляем массив в котором постоянно ищем разделы
            $sectionLinc = getAllCategory();
        }else{
            $cat_id = findParentId($cat_array);
            if($cat3 != '') $cat_array = findCategory($cat_array , $cat3);
            // Добавляем 3 и 4 уровень раздела
            if(empty($cat_array)){
                $cat_id = add_section($cat_id, $cat3);
                if($cat4 != '') $cat_id = add_section($cat_id, $cat4);
                // Обновляем массив в котором постоянно ищем разделы
                $sectionLinc = getAllCategory();
            }else{
                $cat_id = findParentId($cat_array);
                if($cat4 != '') $cat_array = findCategory($cat_array , $cat4);
                // Добавляем 4 уровень раздела
                if(empty($cat_array)){
                    $cat_id = add_section($cat_id, $cat4);
                    // Обновляем массив в котором постоянно ищем разделы
                    $sectionLinc = getAllCategory();
                }else{
                    $cat_id = $cat_array['ID'];
                }
            }
        }


        $PROP = array(
            'ARTICLE' => $article,
            'COUNTRY' => $country,
            'PRODUCER' => $producer_id,
            'HEIGHT' => $height,
            'SOCLE' => $socle_id,
            'VOLTAGE' => $voltage,
            'DIAM' => $diam,
            'COLOR_PLAFOND' => $colorp_id,
            'DEF' => $def,
            'COLOR' => $colora_id,
            'MATERIAL' => $materiala_id,
            'COLLECTION' => $collection,
            'POWER' => $power,
            'TYPE' => $type,
            'MATERIAL_PLAFOND' => $materialp_id,
            'STYLE' => $style_id,
            'COUNT_LAMP' => $count,
            'NEW' => Array("VALUE" => $new),
            'HIT' => Array("VALUE" => $hit),
            'OLD_PRICE' => $old_price
        );

        foreach($gallery_img as $k => $img){
            $img = trim($img);
            $key = 'n'.$k;
            $images[$key]['VALUE'] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/parser/img/".$img);
        }
        $PROP["IMG"] = $images;

        $el = new CIBlockElement;
        // Параметры для символьного кода (Код необходим для построения url карточки товара)
        $params = Array(
            "max_len" => "100", // обрезает символьный код до 100 символов
            "change_case" => "L", // буквы преобразуются к нижнему регистру
            "replace_space" => "_", // меняем пробелы на нижнее подчеркивание
            "replace_other" => "_", // меняем левые символы на нижнее подчеркивание
            "delete_repeat_replace" => "true", // удаляем повторяющиеся нижние подчеркивания
            "use_google" => "false", // отключаем использование google
        );

        $arLoadProductArray = array(
            'IBLOCK_ID' => 1,
            'IBLOCK_SECTION_ID' => $cat_id,
            'NAME' => $name,
            "CODE" => CUtil::translit($name, "ru" , $params),
            'ACTIVE' => 'Y',
            'PROPERTY_VALUES' => $PROP,
            "PREVIEW_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/parser/img/".$img),
            'PREVIEW_TEXT' => $descr
        );
        $element_id = $el->Add($arLoadProductArray);

        $arFields = array(
            "ID" => $element_id,
            "VAT_ID" => 1, //тип ндс
            "VAT_INCLUDED" => "Y" //НДС входит в стоимость
        );
        CCatalogProduct::Add($arFields);

        $arFields = Array(
            "PRODUCT_ID" => $element_id,
            "CATALOG_GROUP_ID" => 1,
            "PRICE" => $price,
            "CURRENCY" => "RUB",
        );
        CPrice::Add($arFields);
    }
}


$arSelect = Array("ID", "PROPERTY_ARTICLE");
$arFilter = Array("IBLOCK_ID"=> 1);
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>9999), $arSelect);
while($ob = $res->GetNextElement()) {
    $arField = $ob->GetFields();
    $articles[$arField['ID']] = $arField['PROPERTY_ARTICLE_VALUE'];
}
// Проставляем id привязок Похожих товаров + Связанных элементов по цвету
foreach($items as $k => $item){
    if($k != 0) {
        $ar = explode(";", $item);
        $article = trim($ar[1]);
        $similar = explode(',', trim($ar[29]));
        $similar_color = explode(',', trim($ar[30]));

        $similar_id = array();
        foreach($similar as $item_article){
            $item_article = trim($item_article);
            if($item_article != '') $similar_id[] = array_search($item_article, $articles);
        }

        $similar_color_id = array();
        foreach($similar_color as $item_article){
            $item_article = trim($item_article);
            if($item_article != '') $similar_color_id[] = array_search($item_article, $articles);
        }

        $el_id = array_search($article, $articles);
        CIBlockElement::SetPropertyValuesEx($el_id, 1, array("SIMILAR" => $similar_id, "SIBLING" => $similar_color_id));
    }
}

/*===========================================================================================
                                        FUNCTIONS
============================================================================================*/

// Создаем новый раздел (Категорию товара)
function add_section($section_id, $name){

    // Параметры для символьного кода (Код необходим для построения url)
    $params = Array(
        "max_len" => "100", // обрезает символьный код до 100 символов
        "change_case" => "L", // буквы преобразуются к нижнему регистру
        "replace_space" => "_", // меняем пробелы на нижнее подчеркивание
        "replace_other" => "_", // меняем левые символы на нижнее подчеркивание
        "delete_repeat_replace" => "true", // удаляем повторяющиеся нижние подчеркивания
        "use_google" => "false", // отключаем использование google
    );

    $bs = new CIBlockSection;
    $arFields = Array(
        "IBLOCK_SECTION_ID" => $section_id,
        "IBLOCK_ID" => 1,
        "NAME" => $name,
        "CODE" => CUtil::translit($name, "ru" , $params),
    );

    $id = $bs->Add($arFields);
    return $id;
}

// Проверяем привязки к элементу, если не существует -> создаем
function check_element($check_el, $mas, $iblock_id){
    if (in_array($check_el, $mas)) {
        $result = array_search($check_el, $mas);
        return $result;
    }else{
        $result = add_element($iblock_id, $check_el);
        return $result;
    }
}

// Создаем элемент инфоблока
function add_element($iblock_id, $name){
    $el = new CIBlockElement;
    $arLoadProductArray = array(
        'IBLOCK_ID' => $iblock_id,
        'NAME' => $name,
        'ACTIVE' => 'Y'
    );
    $element_id = $el->Add($arLoadProductArray);
    return $element_id;
}

// Получаем Массив Иерархии Разделов 1С Битрикс
function getAllCategory(){
    $arFilter = array(
        'ACTIVE' => 'Y',
        'IBLOCK_ID' => 1,
        'GLOBAL_ACTIVE'=>'Y',
    );
    $arSelect = array('ID','NAME','IBLOCK_SECTION_ID', 'DEPTH_LEVEL');
    $arOrder = array('DEPTH_LEVEL'=>'ASC','SORT'=>'ASC');
    $rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);
    $sectionLinc = array();
    while($arSection = $rsSections->GetNext()) {
        $sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']] = $arSection;
        $sectionLinc[$arSection['ID']] = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
    }

    $sectionLinc = $sectionLinc[0]['CHILD'];
    return $sectionLinc;
}

// Поиск в массиве разделов
function findCategory($array, $cat_name){
    $result = array();
    foreach($array as $section){
        if($section['NAME'] == $cat_name){
            if(isset($section['CHILD']))$result = $section['CHILD'];
            else $result = $section;
        }
    }
    return $result;
}

// поиск id родительского раздела
function findParentId($array){
    $first_element = reset($array);
    $parent_id = $first_element['IBLOCK_SECTION_ID'];
    return $parent_id;
}


@unlink("items.csv");
echo "Товары успешно добавлены";
?>