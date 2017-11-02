<?php
 ini_set('display_errors', 1);
$pdo = new PDO('mysql:host=localhost;dbname=ulmart', 'ulmart', '1X3y4I1i');
$pdo = connect_db();
//$value = 'teeee';
//$query = $pdo->prepare("INSERT INTO code (value) VALUES (:value)");
//$query->execute(array("value" => $value));
var_dump($pdo);
//$query = $pdo->prepare("UPDATE tasks SET task_text = :task_text WHERE id = :id");
//$query = $pdo->prepare("DELETE FROM tasks WHERE id =  :id");
//$query = $pdo->prepare("SELECT * FROM tasks ORDER BY id");	