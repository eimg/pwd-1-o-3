<?php

include("../vendor/autoload.php");

use Libs\Database\MySQL;

$mysql = new MySQL;
$db = $mysql->connect();

$statement = $db->query("SELECT * FROM roles");
print_r($statement->fetchAll());
