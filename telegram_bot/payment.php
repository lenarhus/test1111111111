<?
require 'classes/Curl.php';
require 'classes/PDO.php';

$curl = new Curl();

// Получаем информацию из БД о настройках бота
$set_bot = DB::$the->query("SELECT * FROM `sel_set_bot` ");
$set_bot = $set_bot->fetch(PDO::FETCH_ASSOC);
$token		= $set_bot['token']; // токен бота


// Получаем всю информацию о настройках киви
$set_qiwi = DB::$the->query("SELECT * FROM `sel_set_qiwi` ");
$set_qiwi = $set_qiwi->fetch(PDO::FETCH_ASSOC);

// Получаем всю информацию о пользователе
$user = DB::$the->query("SELECT * FROM `sel_users` WHERE `chat` = {$argv[1]} ");
$user = $user->fetch(PDO::FETCH_ASSOC);



$active_number = $set_qiwi['qiwi_number'];
$active_password = $set_qiwi['qiwi_password'];
	
// Если номер доступен для оплаты

$text = '1⃣ Для того, чтобы Пополнить свой баланс, Вам нужно перевести любую сумму 💶 на Qiwi.кошелек «+'.$active_number.'».
2⃣ При этом обязательно указать в комментарии цифру: «'.$user['balans_num'].'».
3⃣ Нужно указать без ковычек, просто цифру: '.$user['balans_num'].'

4⃣ Как только Вы переведете нужную сумму с этим комментарием, нажмите на ссылку ниже для проверки начисления.

/verification - Проверка оплаты';


$text .= "\n\n/menu - Главное меню";	
// Отправляем текст сверху пользователю
$curl->get('https://api.telegram.org/bot'.$token.'/sendMessage',array(
	'chat_id' => $argv[1],
	'text' => $text,
	)); 
exit;	
?>