<?php
ob_start();
require '../style/head.php';
require '../classes/My_Class.php';
require '../classes/PDO.php';

if (!isset($_COOKIE['secretkey']) or $_COOKIE['secretkey'] != $secretkey) {
header("Location: /admin");		
exit;
}

$row = DB::$the->query("SELECT name FROM `sel_category` WHERE `id` = '".intval($_GET['category'])."'");
$cat = $row->fetch(PDO::FETCH_ASSOC);

$row = DB::$the->query("SELECT name FROM `sel_subcategory` WHERE `id` = '".intval($_GET['subcategory'])."'");
$subcat = $row->fetch(PDO::FETCH_ASSOC);

$My_Class->title("Подкатегория: ".$subcat['name']);


if(isset($_GET['category'])){
$header = DB::$the->query("SELECT id FROM `sel_category` WHERE `id` = '".intval($_GET['category'])."' ");
$header = $header->fetchAll();
if(count($header) == 0){
header("Location: /admin");		
exit;
}}	

if(isset($_GET['subcategory'])){
$header = DB::$the->query("SELECT id FROM `sel_subcategory` WHERE `id` = '".intval($_GET['subcategory'])."' ");
$header = $header->fetchAll();
if(count($header) == 0){
header("Location: /admin");		
exit;
}}	
?>
<script type="text/javascript">  
 $(function() { 
    $(".btn").click(function(){
        $(this).button('loading').delay(3000).queue(function() {
            $(this).button('reset');
            $(this).dequeue();
        });        
    });
});  
</script>
<?

if(isset($_GET['cmd'])){$cmd = htmlspecialchars($_GET['cmd']);}else{$cmd = '0';}

if(isset($_GET['category'])){$category = abs(intval($_GET['category']));}else{$category = '0';}
if(isset($_GET['subcategory'])){$subcategory = abs(intval($_GET['subcategory']));}else{$subcategory = '0';}
if(isset($_GET['key'])){$key = abs(intval($_GET['key']));}else{$key = '0';}

switch ($cmd){
case 'create':

?>
<ol class="breadcrumb">
  <li><a href="/admin">Админ-панель</a></li>
  <li><a href="subcategory.php?category=<?=$category;?>"><?=$cat['name'];?></a></li>
  <li><a href="key.php?category=<?=$category;?>&subcategory=<?=$subcategory;?>"><?=$subcat['name'];?></a></li>
  <li class="active">Добавление товара</li>
</ol>
<?

if(isset($_POST['create'])) {

if($_POST['key'] != "") {
$code=$_POST['key'];


$params = array('code' => $code, 'id_cat' => $category, 'id_subcat' => $subcategory, 'time' => time(), 'sale' => 0);  
 
$q= DB::$the->prepare("INSERT INTO `sel_keys` (code, id_cat, id_subcat, time, sale) VALUES (:code, :id_cat, :id_subcat, :time, :sale)");  
$q->execute($params);

$ph = DB::$the->query("SELECT id FROM `sel_keys` order by `id` DESC ");
$ph = $ph->fetch(PDO::FETCH_ASSOC);

if(!empty($_FILES['photo1'])){
$tmp = $_FILES['photo1']['tmp_name'];
move_uploaded_file($tmp, 'photo/'.$ph['id'].'_1.png');
}
if(!empty($_FILES['photo2'])){
$tmp = $_FILES['photo2']['tmp_name'];
move_uploaded_file($tmp, 'photo/'.$ph['id'].'_2.png');
}
if(!empty($_FILES['photo3'])){
$tmp = $_FILES['photo3']['tmp_name'];
move_uploaded_file($tmp, 'photo/'.$ph['id'].'_3.png');
}
if(!empty($_FILES['photo4'])){
$tmp = $_FILES['photo4']['tmp_name'];
move_uploaded_file($tmp, 'photo/'.$ph['id'].'_4.png');
}
if(!empty($_FILES['photo5'])){
$tmp = $_FILES['photo5']['tmp_name'];
move_uploaded_file($tmp, 'photo/'.$ph['id'].'_5.png');
}


header("Location: ?category=$category&subcategory=$subcategory");
}
else
{
echo '<div class="alert alert-danger">Не введен товар!</div>';
}
}

echo '<form action="?cmd=create&category='.$category.'&subcategory='.$subcategory.'" method="POST" enctype="multipart/form-data">
<div class="form-group col-sm-8">
<div class="input-group input-group-lg">
<span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span> </span>
<input type="text" placeholder="Содержание" class="form-control" name="key">
</div><br>
<div class="input-group input-group-lg">
<span class="input-group-addon">1. <span class="glyphicon glyphicon-camera"></span> </span>
<input type="file" placeholder="Фото" class="form-control" name="photo1">
</div><br>
<div class="input-group input-group-lg">
<span class="input-group-addon">2. <span class="glyphicon glyphicon-camera"></span> </span>
<input type="file" placeholder="Фото" class="form-control" name="photo2">
</div><br>
<div class="input-group input-group-lg">
<span class="input-group-addon">3. <span class="glyphicon glyphicon-camera"></span> </span>
<input type="file" placeholder="Фото" class="form-control" name="photo3">
</div><br>
<div class="input-group input-group-lg">
<span class="input-group-addon">4. <span class="glyphicon glyphicon-camera"></span> </span>
<input type="file" placeholder="Фото" class="form-control" name="photo4">
</div><br>
<div class="input-group input-group-lg">
<span class="input-group-addon">5. <span class="glyphicon glyphicon-camera"></span> </span>
<input type="file" placeholder="Фото" class="form-control" name="photo5">
</div><br>
<button type="submit" name="create" class="btn btn-danger btn-lg btn-block" data-loading-text="Добавляю">Добавить</button></form></div>';

break;
 
 
case 'edit':
?>
<ol class="breadcrumb">
  <li><a href="/admin">Админ-панель</a></li>
  <li><a href="subcategory.php?category=<?=$category;?>"><?=$cat['name'];?></a></li>
  <li><a href="key.php?category=<?=$category;?>&subcategory=<?=$subcategory;?>"><?=$subcat['name'];?></a></li>
  <li class="active">Редактирование товара</li>
</ol>
<?	
$key_edit = DB::$the->query("SELECT code FROM `sel_keys` WHERE `id` = {$key} and `id_subcat` = {$subcategory}");
$key_edit = $key_edit->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['edit'])) {

if($_POST['key'] != "") {
$code=$_POST['key'];

DB::$the->prepare("UPDATE sel_keys SET code=? WHERE id=? ")->execute(array("$code", $key)); 

if(!empty($_FILES['photo1'])){
$tmp = $_FILES['photo1']['tmp_name'];
move_uploaded_file($tmp, 'photo/'.$key.'_1.png');
}
if(!empty($_FILES['photo2'])){
$tmp = $_FILES['photo2']['tmp_name'];
move_uploaded_file($tmp, 'photo/'.$key.'_2.png');
}
if(!empty($_FILES['photo3'])){
$tmp = $_FILES['photo3']['tmp_name'];
move_uploaded_file($tmp, 'photo/'.$key.'_3.png');
}
if(!empty($_FILES['photo4'])){
$tmp = $_FILES['photo4']['tmp_name'];
move_uploaded_file($tmp, 'photo/'.$key.'_4.png');
}
if(!empty($_FILES['photo5'])){
$tmp = $_FILES['photo5']['tmp_name'];
move_uploaded_file($tmp, 'photo/'.$key.'_5.png');
}

header("Location: ?category=$category&subcategory=$subcategory");
}
else
{
echo '<div class="alert alert-danger">Не введен товар!</div>';
}
}


echo '<form action="?cmd=edit&category='.$category.'&subcategory='.$subcategory.'&key='.$key.'" method="POST" enctype="multipart/form-data">
<div class="form-group col-sm-8">
<div class="input-group input-group-lg">
<span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span> </span>
<input type="text" placeholder="Содержание" class="form-control" value="'.$key_edit['code'].'" name="key">
</div><br>';

if(file_exists("photo/{$key}_1.png")) echo '<img src="photo/'.$key.'_1.png" width="300" height="300">';
echo '<div class="input-group input-group-lg">
<span class="input-group-addon">1. <span class="glyphicon glyphicon-camera"></span> </span>
<input type="file" placeholder="Фото" class="form-control" name="photo1">
</div><br>';

if(file_exists("photo/{$key}_2.png")) echo '<img src="photo/'.$key.'_2.png" width="300" height="300">';
echo '<div class="input-group input-group-lg">
<span class="input-group-addon">2. <span class="glyphicon glyphicon-camera"></span> </span>
<input type="file" placeholder="Фото" class="form-control" name="photo2">
</div><br>';

if(file_exists("photo/{$key}_3.png")) echo '<img src="photo/'.$key.'_3.png" width="300" height="300">';
echo '<div class="input-group input-group-lg">
<span class="input-group-addon">3. <span class="glyphicon glyphicon-camera"></span> </span>
<input type="file" placeholder="Фото" class="form-control" name="photo3">
</div><br>';

if(file_exists("photo/{$key}_4.png")) echo '<img src="photo/'.$key.'_4.png" width="300" height="300">';
echo '<div class="input-group input-group-lg">
<span class="input-group-addon">4. <span class="glyphicon glyphicon-camera"></span> </span>
<input type="file" placeholder="Фото" class="form-control" name="photo4">
</div><br>';

if(file_exists("photo/{$key}_5.png")) echo '<img src="photo/'.$key.'_5.png" width="300" height="300">';
echo '<div class="input-group input-group-lg">
<span class="input-group-addon">5. <span class="glyphicon glyphicon-camera"></span> </span>
<input type="file" placeholder="Фото" class="form-control" name="photo5">
</div><br>';

echo '<button type="submit" name="edit" class="btn btn-danger btn-lg btn-block" data-loading-text="Изменить">Изменить</button></form></div>';

	
break;

case 'delete':	
$key_del = DB::$the->query("SELECT code FROM `sel_keys` WHERE `id` = {$key} and `id_subcat` = {$subcategory}");
$key_del = $key_del->fetch(PDO::FETCH_ASSOC);
?>
<ol class="breadcrumb">
  <li><a href="/admin">Админ-панель</a></li>
  <li><a href="subcategory.php?category=<?=$category;?>"><?=$cat['name'];?></a></li>
  <li><a href="key.php?category=<?=$category;?>&subcategory=<?=$subcategory;?>"><?=$subcat['name'];?></a></li>
  <li class="active">Удаление товара: <b><?=$key_del['code'];?></b></li>
</ol>
<div class="alert alert-danger">товар будет удален навсегда!</div>

<div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-loading-text="Думаем" data-toggle="dropdown">Вы уверены? <span class="caret"></span></button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="?cmd=delete&category=<?=$category;?>&subcategory=<?=$subcategory;?>&key=<?=$key;?>&ok">Да, удалить</a></li>
    <li class="divider"></li>
    <li><a href="?category=<?=$category;?>&subcategory=<?=$subcategory;?>">Нет, отменить</a></li>
  </ul>
</div><br /><br />
<?


if(isset($_GET['ok'])) {
DB::$the->query("DELETE FROM `sel_keys` WHERE `id` = {$key} ");

header("Location: ?category=$category&subcategory=$subcategory");
}

break;

case 'remove_sale':	

?>
<ol class="breadcrumb">
  <li><a href="/admin">Админ-панель</a></li>
  <li><a href="subcategory.php?category=<?=$category;?>"><?=$cat['name'];?></a></li>
  <li><a href="key.php?category=<?=$category;?>&subcategory=<?=$subcategory;?>"><?=$subcat['name'];?></a></li>
  <li class="active">Удаление всех не проданных товаров</li>
</ol>
<div class="alert alert-danger">Будут удалены все не проданные товари!</div>

<div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-loading-text="Думаем" data-toggle="dropdown">Вы уверены? <span class="caret"></span></button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="?cmd=remove_sale&category=<?=$category;?>&subcategory=<?=$subcategory;?>&ok">Да, удалить все не проданные товари</a></li>
    <li class="divider"></li>
    <li><a href="key.php?category=<?=$category;?>&subcategory=<?=$subcategory;?>">Нет, отменить</a></li>
  </ul>
</div><br /><br />

<?

if(isset($_GET['ok'])) {
DB::$the->query("DELETE FROM `sel_keys` WHERE `id_cat` = {$category} and `id_subcat` = {$subcategory} and `sale` = '0' ");

header("Location: key.php?category=category&subcategory=$subcategory");
}

break;
	
default:

?>
<ol class="breadcrumb">
  <li><a href="/admin">Админ-панель</a></li>
  <li><a href="subcategory.php?category=<?=$category;?>"><?=$cat['name'];?></a></li>
  <li class="active"><?=$subcat['name'];?></li>
</ol>

<div class="list-group">
<a class="list-group-item" href="?cmd=create&category=<?=$category;?>&subcategory=<?=$subcategory;?>">
<span class="glyphicon glyphicon-plus-sign"></span> Добавить товар
</a>
</div>

<?


$total = DB::$the->query("SELECT * FROM `sel_keys` where `id_cat` = {$category} and `id_subcat` = {$subcategory} ");
$total = $total->fetchAll();
$max = 15;
$pages = $My_Class->k_page(count($total),$max);
$page = $My_Class->page($pages);
$start=($max*$page)-$max;

if(count($total) == 0){
echo '<div class="alert alert-danger">В данной подкатегории нет товаров!</div>';
}	

echo '<div class="list-group">';
$query = DB::$the->query("SELECT * FROM `sel_keys` where `id_cat` = {$category} and `id_subcat` = {$subcategory} order by `id` DESC LIMIT $start, $max");
while($key = $query->fetch()) {
if($key['sale'] == 1) {
$sales = '<font color="red">[ПРОДАН]</font>';
}
else $sales = null;
	
echo '<div class="panel panel-default">
  <div class="panel-heading"> <b>'.$key['code'].'</b> '.$sales;

echo '<a href="?cmd=edit&category='.$category.'&subcategory='.$subcategory.'&key='.$key['id'].'"> <span class="badge pull-right"><span class="glyphicon glyphicon-pencil"></span> </span></a>';
echo '<a href="?cmd=delete&category='.$category.'&subcategory='.$subcategory.'&key='.$key['id'].'"> <span class="badge pull-right"><span class="glyphicon glyphicon-remove"></span> </span></a>';
echo '</div><div class="panel-body">';
if(file_exists("photo/".$key['id']."_1.png")) echo '<img src="photo/'.$key['id'].'_1.png" width="200" height="200">';
if(file_exists("photo/".$key['id']."_2.png")) echo '<img src="photo/'.$key['id'].'_2.png" width="200" height="200">';
if(file_exists("photo/".$key['id']."_3.png")) echo '<img src="photo/'.$key['id'].'_3.png" width="200" height="200">';
if(file_exists("photo/".$key['id']."_4.png")) echo '<img src="photo/'.$key['id'].'_4.png" width="200" height="200">';
if(file_exists("photo/".$key['id']."_5.png")) echo '<img src="photo/'.$key['id'].'_5.png" width="200" height="200">';

echo '</div>';
echo '</div>';
}

if ($pages>1) $My_Class->str('?category='.$category.'&subcategory='.$subcategory.'&',$pages,$page); 
?>
<div class="list-group">
<a class="list-group-item" href="key.php?cmd=remove_sale&category=<?=$category;?>&subcategory=<?=$subcategory;?>">
<span class="glyphicon glyphicon-remove"></span> Удалить все не проданные товари
</a>
</div>
<?
}

$My_Class->foot();
?>