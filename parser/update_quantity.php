<?require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");

// Парсим csv файл
$items = file("quantity.csv");
foreach($items as $k => $item) {
    if ($k != 0) {
        $ar = explode(";", $item);
        $article = trim($ar[0]);
        $quantity = trim($ar[1]);
    }

    $arFilter = Array("IBLOCK_ID"=> 1, "ACTIVE" => "Y", "INCLUDE_SUBSECTIONS"=>"Y", "PROPERTY_ARTICLE" => $article);
    $result = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>9999), Array('ID'));
    while($ob = $result->GetNextElement()) {
        $field = $ob->GetFields();
        $item_id = $field['ID'];
    }

    CIBlockElement::SetPropertyValuesEx($item_id, false, array("COUNT_LAMP" => $quantity));
}
@unlink("quantity.csv");
echo "Количество товаро успешно обновлено";
?>
