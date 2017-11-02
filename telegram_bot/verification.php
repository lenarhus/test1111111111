﻿<?
require 'classes/Curl.php';
require 'classes/PDO.php';

$curl = new Curl();



$chat = intval($_GET['chat']);

// Получаем информацию из БД о настройках бота
$set_bot = DB::$the->query("SELECT * FROM `sel_set_bot` ");
$set_bot = $set_bot->fetch(PDO::FETCH_ASSOC);
$token		= $set_bot['token']; // токен бота


// Получаем всю информацию о настройках киви
$set_qiwi = DB::$the->query("SELECT * FROM `sel_set_qiwi` ");
$set_qiwi = $set_qiwi->fetch(PDO::FETCH_ASSOC);

// Получаем всю информацию о пользователе
$user = DB::$the->query("SELECT * FROM `sel_users` WHERE `chat` = {$chat} ");
$user = $user->fetch(PDO::FETCH_ASSOC);

if($user['id_key'] == '0') {

$curl->get('https://api.telegram.org/bot'.$token.'/sendMessage',array(
	'chat_id' => $chat,
	'text' => "������ Вы не выбрали товар!",
	
	)); 	
exit;	
}



	
// Получаем информацию о товаре 
$key = DB::$the->query("SELECT * FROM `sel_keys` WHERE `id` = '".$user['id_key']."' ");
$key = $key->fetch(PDO::FETCH_ASSOC);

// Получаем информацию о цене товара 
$amount = DB::$the->query("SELECT amount FROM `sel_subcategory` WHERE `id` = '".$key['id_subcat']."' ");
$amount = $amount->fetch(PDO::FETCH_ASSOC);

// Смотрим когда пользователь сделал последний запрос
$timeout = $user['verification']+$set_bot['verification'];
$timeout2 = $user['verification']+5;


if($timeout < time()) { // Если давно, то проверяем оплату
DB::$the->prepare("UPDATE sel_users SET verification=? WHERE chat=? ")->execute(array(time(), $chat)); 

require 'classes/qiwi.class.php';

// Получаем всю информацию о настройках киви
$us_qiwi = DB::$the->query("SELECT password FROM `sel_set_qiwi` WHERE `number` = '".$user['pay_number']."' ");
$us_qiwi = $us_qiwi->fetch(PDO::FETCH_ASSOC);


$iAccount = $user['pay_number'];
$sPassword = $us_qiwi['password'];



//$proxy = $set_bot['proxy'].":http:".$set_bot['proxy_login'].":".$set_bot['proxy_pass'];

$proxy = '';
	
$oQiwi = new QIWI( $iAccount, $sPassword, 'cookie.txt', $proxy ); // Заходим в киви



$json = $oQiwi->GetHistory( date( 'd.m.Y', strtotime( '-1 day' ) ), date( 'd.m.Y', strtotime( '+1 day' ) ) );
	
	
	
	
	
// Проверяем наличие комментария в пополнении счета		
$iTotal = 0; foreach($json as $aItem ) { $iTotal++; 

  
if($aItem['sComment'] == $user['id_key'] and $aItem['dAmount'] == $amount['amount'] and $aItem['sType'] == 'INCOME' and $aItem['sStatus'] == 'SUCCESS') 
{
	
// Выводим в меню список категорий
$query = DB::$the->query("SELECT * FROM `sel_category` order by `mesto` ");
while($cat = $query->fetch()) {
$arr[] = array("🔹".$cat['name']."");	
}

$arr[] = array("📦 Заказы");	

	$replyMarkup = array(
	'resize_keyboard' => true,
    'keyboard' => 
	$arr 
	
);
$menu = json_encode($replyMarkup);

	
$good = $user['id_key'];  

// Записываем всю информацию о платеже в БД
$params = array('chat' => $chat, 'iAccount' => $iAccount, 'iID' => $aItem['iID'], 'sDate' => $aItem['sDate'], 'sTime' => $aItem['sTime'],
'dAmount' => $aItem['dAmount'], 'iOpponentPhone' => $aItem['iOpponentPhone'], 
'sComment' => $aItem['sComment'], 'sStatus' => $aItem['sStatus'], 'time' => time() );  
 
$q = DB::$the->prepare("INSERT INTO `sel_qiwi` (chat, iAccount, iID, sDate, sTime, dAmount, iOpponentPhone, sComment, sStatus, time) 
VALUES (:chat, :iAccount, :iID, :sDate, :sTime, :dAmount, :iOpponentPhone, :sComment, :sStatus, :time)");  
$q->execute($params); 



if($key['block_user'] != $chat){
	
	
$text = '❌ Вы попытались купить товар, который был освобожден из-за не своевременной оплаты!';

// Отправляем текст сверху пользователю
$curl->get('https://api.telegram.org/bot'.$token.'/sendMessage',array(
	'chat_id' => $chat,
	'text' => $text,
	'reply_markup' => $menu,	
	)); 	
	
exit;	
}


// Записываем информацию о покупке в БД
$params = array('id_key' => $user['id_key'], 'code' => $key['code'], 'chat' => $chat, 'id_subcat' => $key['id_subcat'], 'time' => time() );   
$q = DB::$the->prepare("INSERT INTO `sel_orders` (id_key, code, chat, id_subcat, time) 
VALUES (:id_key, :code, :chat, :id_subcat, :time)");  
$q->execute($params);


DB::$the->prepare("UPDATE sel_keys SET sale=? WHERE id=? ")->execute(array("1", $user['id_key']));

DB::$the->prepare("UPDATE sel_keys SET block=? WHERE block_user=? ")->execute(array("0", $chat)); 
DB::$the->prepare("UPDATE sel_keys SET block_time=? WHERE block_user=? ")->execute(array('0', $chat));
DB::$the->prepare("UPDATE sel_keys SET block_user=? WHERE block_user=? ")->execute(array('0', $chat));

DB::$the->prepare("UPDATE sel_users SET id_key=? WHERE chat=? ")->execute(array('0', $chat));
DB::$the->prepare("UPDATE sel_users SET pay_number=? WHERE chat=? ")->execute(array('', $chat));


// Отправляем текст пользователю
$curl->get('https://api.telegram.org/bot'.$token.'/sendMessage',array(
	'chat_id' => $chat,
	'text' => "✔ Вы успешно приобрели товар! Пожалуйста, сохраните его!",
	)); 


// Отправляем текст пользователю
$curl->get('https://api.telegram.org/bot'.$token.'/sendMessage',array(
	'chat_id' => $chat,
	'text' => $key['code'],		
	)); 

$curl->post('https://api.telegram.org/bot'.$token.'/sendPhoto', array(
    'chat_id' => $chat,
    'photo' => new CURLFile('admin/photo/'.$key['id'].'_1.png'),
    ));	
$curl->post('https://api.telegram.org/bot'.$token.'/sendPhoto', array(
    'chat_id' => $chat,
    'photo' => new CURLFile('admin/photo/'.$key['id'].'_2.png'),
    ));	
$curl->post('https://api.telegram.org/bot'.$token.'/sendPhoto', array(
    'chat_id' => $chat,
    'photo' => new CURLFile('admin/photo/'.$key['id'].'_3.png'),
    ));	
$curl->post('https://api.telegram.org/bot'.$token.'/sendPhoto', array(
    'chat_id' => $chat,
    'photo' => new CURLFile('admin/photo/'.$key['id'].'_4.png'),
    ));	
$curl->post('https://api.telegram.org/bot'.$token.'/sendPhoto', array(
    'chat_id' => $chat,
    'photo' => new CURLFile('admin/photo/'.$key['id'].'_5.png'),
    ));	

	
if($oQiwi->aBalances['RUB'] > $set_bot['limits']) 
{	



DB::$the->prepare("UPDATE sel_set_qiwi SET active=? WHERE active=? ")->execute(array('0', '1')); 


$new_act = DB::$the->query("SELECT id FROM `sel_set_qiwi` order by rand()");
$new_act = $new_act->fetch(PDO::FETCH_ASSOC);

DB::$the->prepare("UPDATE sel_set_qiwi SET active=? WHERE id=? ")->execute(array('1', $new_act['id'])); 

}
	
exit;



}
}

// Если комментарий не найдем в истории платежа
if($good != $user['id_key']) {
	
$text = '❌ Оплата не произведена! 
Отсутствует перевод '.$amount['amount'].' руб с комментарием «'.$user['id_key'].'».';

// Отправляем текст сверху пользователю
$curl->get('https://api.telegram.org/bot'.$token.'/sendMessage',array(
	'chat_id' => $chat,
	'text' => $text,
	)); 
}
exit;		
}
else // Вызываем ошибку антифлуда
{
if($timeout2 < time()) {	
$sec = $timeout-time();	
$text = '❌ Подождите!
Следующую проверку можно сделать только через '.$sec.' сек.';
	

$curl->get('https://api.telegram.org/bot'.$token.'/sendMessage',array(
	'chat_id' => $chat,
	'text' => $text,
	)); 
}
}	
	
exit;
?>