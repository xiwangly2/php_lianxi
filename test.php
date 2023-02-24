<?php
define('WORKDIR',getcwd());
// // 定义is_include常量，用于限制include/index.php只能通过引用访问
// define('is_include',true);
// include_once(WORKDIR.'/include/class/snowflake.php');

// // 使用示例
// $snowflake = new Snowflake(1, 1);
// echo $snowflake->nextId();

include_once(WORKDIR.'/class/password.php');

$password_hash = new PasswordHasher();

$test1 = $password_hash->password_hash("123456");

echo $test1;

echo "<br/>";

// echo strlen($test1);

echo "<br/>";

echo $password_hash->verify("123456",$test1);

?>