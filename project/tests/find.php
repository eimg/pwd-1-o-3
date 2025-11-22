<?php

include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;

$table = new UsersTable(new MySQL);
$user = $table->find("alice@gmail.com", "password");

print_r($user);
