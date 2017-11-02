<?require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
die();

$dsn = "mysql:host=localhost;dbname=cottage;charset=cp1251";
$user = 'cottage';
$pass = '1RUkcBmW';
$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
try {
    $pdo = new PDO($dsn, $user, $pass, $opt);
} catch (PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
}
//header('Content-Type: text/html; charset=utf-8');
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
$result = array();
$check = $i = 1;
$arSelect = Array(
    "ID",
    "NAME",
    "PREVIEW_PICTURE",
    "PROPERTY_TECH",
    "PROPERTY_SQUARE",
    "PROPERTY_WIDTH",
    "PROPERTY_LENGTH",
    "PROPERTY_PRICE",
    "PROPERTY_IMG_PLAN",
    "PROPERTY_IMG_LOCATION",
    "PROPERTY_IMG_BUILD",
    "PROPERTY_PLACE",
     "PROPERTY_FULL_SQUARE",
     "PROPERTY_PROJECT",
     "PROPERTY_COMPLECT",
     "PROPERTY_TYPE",
     "PROPERTY_MATERIAL",
     "PROPERTY_OVERLAP",
     "PROPERTY_ROOF",
     "PROPERTY_FACING",
     "PROPERTY_EXTRA_WORK",
     "PROPERTY_COMPOSITION",
);
$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("PROPERTY_TECH_VALUE"=>"ASC"), $arFilter, false, Array("nPageSize"=>9999), $arSelect);
while($ob = $res->GetNextElement()){
    //if($i > 3) continue;
    $gallery = array();
    $arFields = $ob->GetFields();
    $result[$arFields['ID']]['name'] = $name = $arFields['NAME'];
    $result[$arFields['ID']]['img'] = $img_prev =  getImgName(CFile::GetPath($arFields['PREVIEW_PICTURE']));
    $result[$arFields['ID']]['price'] = $price = $arFields['PROPERTY_PRICE_VALUE'];
    $result[$arFields['ID']]['square'] = $square = $arFields['PROPERTY_SQUARE_VALUE'];
    $result[$arFields['ID']]['project'] = $project = $arFields['PROPERTY_PROJECT_VALUE'];
    $result[$arFields['ID']]['complect'] = $complect = $arFields['PROPERTY_COMPLECT_VALUE'];
    $result[$arFields['ID']]['material'] = $material = $arFields['PROPERTY_MATERIAL_VALUE'];
    $result[$arFields['ID']]['floor'] = $floor = $arFields['PROPERTY_OVERLAP_VALUE'];
    $result[$arFields['ID']]['roof'] = $roof = $arFields['PROPERTY_ROOF_VALUE'];
    $result[$arFields['ID']]['facing'] = $facing = $arFields['PROPERTY_FACING_VALUE'];
    $result[$arFields['ID']]['consist'] = $consist = $arFields['PROPERTY_COMPOSITION_VALUE'];



    foreach($arFields['PROPERTY_IMG_PLAN_VALUE'] as $img){
        $path = CFile::GetPath($img);
        $gallery[] = getImgName($path);
    }

    foreach($arFields['PROPERTY_IMG_LOCATION_VALUE'] as $img){
        $path = CFile::GetPath($img);
        $gallery[] = getImgName($path);
    }

    foreach($arFields['PROPERTY_IMG_BUILD_VALUE'] as $img){
        $path = CFile::GetPath($img);
        $gallery[] = getImgName($path);
    }




    $result[$arFields['ID']]['tech'] = $tech = $arFields['PROPERTY_TECH_VALUE'];

    if($i <= 11) $cat_id = 2;
    if($i > 11 && $i <= 14) $cat_id = 1;
    if($i > 14) $cat_id = 3;

    $result[$arFields['ID']]['width'] = $width = $arFields['PROPERTY_WIDTH_VALUE'];
    $result[$arFields['ID']]['lenght'] = $lenght = $arFields['PROPERTY_LENGTH_VALUE'];
    $result[$arFields['ID']]['place'] = $place = $arFields['PROPERTY_PLACE_VALUE'];
    $result[$arFields['ID']]['f_square'] = $f_square = $arFields['PROPERTY_FULL_SQUARE_VALUE'];
    $result[$arFields['ID']]['type'] = $type = $arFields['PROPERTY_TYPE_VALUE'];
    $result[$arFields['ID']]['extra_work'] = $extra_work = $arFields['PROPERTY_EXTRA_WORK_VALUE'];
    $result[$arFields['ID']]['gallery'] = $gallery;


    $query = $pdo->prepare("INSERT INTO item (name, cat_id, img, price, square, project, complectation, material, floor, roof, facing, consist, width, lenght, place, f_square, type, extra_work) VALUES (:name, :cat_id, :img, :price, :square, :project, :complectation, :material, :floor, :roof, :facing, :consist, :width, :lenght, :place, :f_square, :type, :extra_work)");
    $query->execute(array(
        "name" => $name,
        "cat_id" => $cat_id,
        "img" => $img_prev,
        "price" => $price,
        "square" => $square,
        "project" => $project,
        "complectation" => $complect,
        "material" => $material,
        "floor" => $floor,
        "roof" => $roof,
        "facing" => $facing,
        "consist" => $consist,
        "width" => $width,
        "lenght" => $lenght,
        "place" => $place,
        "f_square" => $f_square,
        "type" => $type,
        "extra_work" => $extra_work
    ));
    $lastId = $pdo->lastInsertId();

    foreach($gallery as $image) {
        $query = $pdo->prepare("INSERT INTO gallery (item_id, src) VALUES (:item_id, :src)");
        $query->execute(array(
            "item_id" => $lastId,
            "src" => $image
        ));
    }

    $i++;
}
echo $check . ' - find elements <br>';
echo "<pre>".print_r($result, 1)."</pre>";


function getImgName($array){
    $explode = explode('/', $array);
    $name = array_pop($explode);
    return $name;
}

/*
$stmt = $pdo->prepare('SELECT * FROM item');
$stmt->execute();
while ($row = $stmt->fetch()) {
    print_r($row);
}*/




