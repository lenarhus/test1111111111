<?php 
ob_start();
require '../style/head.php';
require '../classes/PDO.php';
require '../classes/My_Class.php';

$My_Class->title("Пользователи");

if (!isset($_COOKIE['secretkey']) or $_COOKIE['secretkey'] != $secretkey) {
header("Location: /admin");		
exit;
}

if(isset($_GET['cmd'])){$cmd = htmlspecialchars($_GET['cmd']);}else{$cmd = '0';}
if(isset($_GET['user'])){$user = abs(intval($_GET['user']));}else{$user = '0';}

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

switch ($cmd){
case 'edit':

?>
<ol class="breadcrumb">
  <li><a href="/admin">Админ-панель</a></li>
  <li><a href="users.php">Пользователи</a></li>
  <li class="active">Редактирование</li>
</ol>

<?
if(isset($_POST['submit'])) {

if(isset($_GET['ok'])) {
	
if($_POST['ban']=='on') { $ban = '1'; }
else { $ban = '0'; }


DB::$the->prepare("UPDATE sel_users SET ban=? WHERE chat=? ")->execute(array($ban, intval($_GET['chat']))); 

}
else
{
?>
<div class="alert alert-danger"> Пустые данные!</div>
<?
}	
}
?>

	<div class="table-responsive">
	<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th  style="text-align:center;">№</th>
            <th  style="text-align:center;">Никнейм</th>
			<th  style="text-align:center;">Имя и Фамилия</th>
            <th  style="text-align:center;">Бан</th>
            <th  style="text-align:center;">chat</th>
        </tr>
    </thead>
<tbody>
<?

$row = DB::$the->query("SELECT * FROM `sel_users` WHERE `chat` = '".intval($_GET['chat'])."'");
$user = $row->fetch(PDO::FETCH_ASSOC);

if($user['ban']==0) { $ban = 'Нет';	}
else { $ban = 'Да'; }
?>
<tr>
            <td  align="center"><?=$user['id'];?></td>
            <td  align="center"><?=$user['username'];?></td>
            <td  align="center"><?=$user['first_name'];?> <?=$user['last_name'];?></td>
            <td  align="center"><?=$ban;?></td>
            <td  align="center"><?=$user['chat'];?></td>
</tr>

</tbody>
</table>
</div> 

<form method="POST" action="?cmd=edit&chat=<?=intval($_GET['chat']);?>&ok">
<div class="form-group col-sm-8">

<hr>
<label><span class="glyphicon glyphicon-lock"></span>
<input name="ban" type="checkbox" <?if($user['ban']=='1')echo'checked';?>> 
 Забанен
</label>
<hr>

    <button type="submit" name="submit" class="btn btn-danger btn-lg btn-block" data-loading-text="Изменяю">Изменить</button></form>
</div>

<?
break;
	
default:

?>
<ol class="breadcrumb">
  <li><a href="/admin">Админ-панель</a></li>
  <li class="active">Пользователи</li>
</ol>

	<div class="table-responsive">
	<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th  style="text-align:center;">№</th>
            <th  style="text-align:center;">Никнейм</th>
			<th  style="text-align:center;">Имя и Фамилия</th>
            <th  style="text-align:center;">Бан</th>
            <th  style="text-align:center;">Редактор</th>
        </tr>
    </thead>
<tbody>
<?

$total = DB::$the->query("SELECT * FROM `sel_users` ");
$total = $total->fetchAll();
$max = 50;
$pages = $My_Class->k_page(count($total),$max);
$page = $My_Class->page($pages);
$start=($max*$page)-$max;

$query = DB::$the->query("SELECT * FROM `sel_users` order by `id` ASC LIMIT $start, $max");
while($user = $query->fetch()) {
if($user['ban']==0) { $ban = 'Нет';	}
else { $ban = 'Да'; }
?>
<tr>
            <td  align="center"><?=$user['id'];?></td>
            <td  align="center"><?=$user['username'];?></td>
            <td  align="center"><?=$user['first_name'];?> <?=$user['last_name'];?></td>
            <td  align="center"><?=$ban;?></td>
            <td  align="center"><? echo '<a href="?cmd=edit&chat='.$user['chat'].'">изменить</a>';?></td>
</tr>
<?	


}

?>
</tbody>
</table>
</div> 

<?

}
if ($pages>1) $My_Class->str('?',$pages,$page); 

$My_Class->foot();
?>