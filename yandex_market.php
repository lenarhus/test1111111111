<?php
class YandexMarket {
  /**
 * Валидный yml генератор для Яндекс Маркет
 * @version 0.3  Date: 02.02.13
 * @author: fStrange
 * @url: http://fstrange.ru
 */
  
  protected
      $name = '',
      $company = '',
      $url = '',
      $date = '',
      $rootElem = '',
      $shopElem = '',
      $aOffer = array(),
      $aCurr = array(), //валюты
      $aCat = array(); //категории

  public function __construct($name = '', $company = '', $url = '') {
    $this->name = self::filterElem($name);
    $this->company = self::filterElem($company);
    $this->url = $url;
    $this->date = date("Y-m-d H:i");
    $this->rootElem = "<?xml version='1.0' encoding='windows-1251'?>
    		<!DOCTYPE yml_catalog SYSTEM 'shops.dtd'>
    		<!-- This YML generated with Yandex Market 0.1 (http://fstrange.ru)-->
    <yml_catalog date='{$this->date}'>\r\n%s\r\n</yml_catalog>";
    $this->shopElem =
        "<shop>\r\n<name>{$this->name}</name>
        <company>$this->company</company>
        <url>{$this->url}</url>
        <currencies>\r\n%s\r\n</currencies>
        <categories>\r\n%s\r\n</categories>
        <offers>\r\n%s\r\n</offers>
        </shop>\r\n";

  }

  /*
   * setCurr('RUR', 1);
   * setCurr('USD', 'CBRF');
   */
  public function addCurr($id, $rate, $plus = null) {
    $this->aCurr[] = "<currency ".self::setAttr(array('id'=>$id, 'rate' => $rate, 'plus'=>$plus)). " />";
  }

  public function addCat($sName, $id) {
    $this->aCat[] = "<category id=\"$id\">".self::filterElem($sName)."</category>";
  }

  public function addOffer($sOffer){
    $this->aOffer[] = $sOffer;
  }

  public function save() {
    $this->shopElem = sprintf($this->shopElem, implode("\n", $this->aCurr), implode("\n", $this->aCat), implode("\n", $this->aOffer));
    return sprintf($this->rootElem, $this->shopElem);
  }

  public function setOffer($id, $sType){

  }

  public static function setXmlNode($k, $v){
    return "<$k>$v</$k>";
  }
  public static function setAttr($a) {
    $s = '';

    //удалить пустые элементы массива
    $array_empty = array(null);
    $a = array_diff($a, $array_empty);

    foreach ($a as $k => $v) {
      $s .= "$k=\"$v\" ";
    }
    return trim($s);
  }

  public static function filterElem($s) {
    $a['&nbsp;'] = ' ';
    $a['&ndash;'] = ' ';
    $a['&raquo;'] = ' ';
    $a['&laquo;'] = ' ';
    $a['&ldquo;'] = ' ';
    $a['&rdquo;'] = ' ';
    $a['&bull;'] = ' ';
    $a['&oacute;'] = ' ';
    $a['&plusmn;'] = ' ';
    $s = str_replace(array_keys($a), array_values($a), $s);
    $s = strip_tags($s);
    $s = htmlspecialchars_decode($s);

    $a['"'] = '&quot;';
    $a['&;'] = '&amp;';
    $a['>'] = '&gt;';
    $a['<'] = '&lt;';
    $a["'"] = '&apos;';
    $s = str_replace(array_keys($a), array_values($a), $s);

    return $s;
  }
}

/*
 * $offer = new OfferYmt($id);
 * $offer->setUrl('http://ghghg.ghghg.ru/url/');
 * $offer->setRequired($price, $currencyId, $categoryId, $vendor, $model);
 */
class OfferYmt {
  //http://partner.market.yandex.ru/legal/tt/#id1164057815703
  //offer DTD type
  protected
    $sDtdElem =  'url?, buyurl?, price, wprice?, currencyId, xCategory?, categoryId+,
                picture?, store?, pickup?, delivery?, deliveryIncluded?,
                local_delivery_cost?, orderingTime,
                typePrefix?, vendor, vendorCode?, model,
                aliases?, additional*, description?, sales_notes?, promo?,
                manufacturer_warranty?, country_of_origin?, downloadable?, adult?,
                barcode*, param*',
    $aOffer = array(),
    $aElems = array(),
    $sOfferElem = '';

  public function __construct($id, $available=1, $bid=null, $cid=null) {
    $a = array('available'=>$available? 'true' : 'false' ,'bid'=>$bid, 'cid'=>$cid);
    $this->sOfferElem = "<offer id=\"$id\" type=\"vendor.model\" ";
    $this->sOfferElem .= YandexMarket::setAttr($a);
    $this->sOfferElem .= ">\r\n%s\r\n</offer>";


    $this->aElems = array_keys(explode(',', $this->sDtdElem));
    $this->aElems = array_map(array($this, '_cbTrim'), $this->aElems);
    /*
     * сформировали массив элементов в правильной последовательности описанной в DTD
     * для Яндекс Маркета это важно!!!!
     */
    $this->aElems = array_fill_keys($this->aElems, null);
  }

  public function setRequired($price, $currencyId, $categoryId, $vendor, $model){
    $this->setElem('price', $price);
    $this->setElem('currencyId', $currencyId);
    $this->setElem('categoryId', $categoryId);
    $this->setElem('vendor', $vendor);
    $this->setElem('model', $model);
  }

  public function setUrl($s){ $this->aElems['url'] = $s;}

  public function save(){
    $s = '';
    foreach($this->aElems as $k=>$v) if(!is_null($v)) $s .= YandexMarket::setXmlNode($k,$v)."\n";

    $this->sOfferElem = sprintf($this->sOfferElem, $s);
    return $this->sOfferElem;
  }

  public function setElem($sName, $sTitle){
    $this->aElems[$sName] = YandexMarket::filterElem($sTitle);
  }
  private function _cbTrim($s) { return trim($s, "+?* \r\n\t");}

}



/*
$offer = new OfferYmt($id);
$offer->setUrl($url);
$offer->setRequired($price, 'RUB', $idCat, $companyName, $name);
$offer->setElem('description', $description);
$offer->setElem('picture', $suImg);
$market->addOffer($offer->save());
*/