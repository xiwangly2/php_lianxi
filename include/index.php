<?php

// 定义IS_INCLUDE常量，用于限制include/*只能通过引用访问
define('IS_INCLUDE',true);

// 遍历载入include文件夹的php和inc文件
// $list = scandir('include',0);
// for($i = 0;$i < count($list);$i++){
//     if(preg_match('#^(index.php)$#i',$list[$i])){
//     }
//     elseif(preg_match('#.+\.(php|inc)$#i',$list[$i]) && is_file(WORKDIR.'/include/'.$list[$i])){
//         require_once(WORKDIR.'/include/'.$list[$i]);
//     }
// }

// composer
require_once(WORKDIR.'/vendor/autoload.php');
// 配置文件
require_once(WORKDIR.'/include/config.inc');
// 连接数据库
require_once(WORKDIR.'/include/sql.inc');
// 函数调用
require_once(WORKDIR.'/include/function.inc');

// function my_autoloader($class) {
//     require_once(WORKDIR.'/include/'.$class.'inc');
// }

// spl_autoload_register('my_autoloader');
