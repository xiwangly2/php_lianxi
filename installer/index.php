<?php

if (@file_get_contents('installed.lock')) {
    die('已安装，请勿重复安装');
}

define('WORKDIR',getcwd().'/../');
require_once(WORKDIR.'/include/index.php');

// 定义要导入的.sql文件路径
$sql_file = 'mysql/init.sql';

// 读取.sql文件内容
$sql = file_get_contents($sql_file);


// 执行导入操作
$result = $database->query($sql);

// 检查执行结果是否成功
if (!$result) {
echo "导入失败: " . $database->error;
die;
}

file_put_contents('installed.lock', 'true');
echo "导入成功";
?>
