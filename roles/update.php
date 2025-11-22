<?php

$db = new PDO("mysql:dbhost=localhost;dbname=project", "root", "");

$id = $_POST['id'];
$name = $_POST['name'];
$value = $_POST['value'];

$db->query("UPDATE roles SET name='$name', value=$value WHERE id=$id");

header("location: index.php");
