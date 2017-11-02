<?require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");

// Парсим csv файл
$items = file("price.csv");
foreach($items as $k => $item) {
    if ($k != 0) {
        $ar = explode(";", $item);
        $article = trim($ar[0]);
        $price = trim($ar[1]);
        $old_price = trim($ar[2]);
    }

    $arFilter = Array("IBLOCK_ID"=> 1, "ACTIVE" => "Y", "INCLUDE_SUBSECTIONS"=>"Y", "PROPERTY_ARTICLE" => $article);
    $result = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>9999), Array('ID'));
    while($ob = $result->GetNextElement()) {
        $field = $ob->GetFields();
        $item_id = $field['ID'];
    }

    $arFields = Array(
        "PRODUCT_ID" => $item_id,
        "CATALOG_GROUP_ID" => 1,
        "PRICE" => $price,
        "CURRENCY" => "RUB",
    );

    $res = CPrice::GetList(
        array(),
        array(
            "PRODUCT_ID" => $item_id,
            "CATALOG_GROUP_ID" => 1
        )
    );

    if ($arr = $res->Fetch()){
        CPrice::Update($arr["ID"], $arFields);
    }

    CIBlockElement::SetPropertyValuesEx($item_id, false, array("OLD_PRICE" => $old_price));
}
@unlink("price.csv");
echo "Цены успешно обновлены";
?>
    