<?php
define('WORKDIR',getcwd());
// 定义is_include常量，用于限制include/index.php只能通过引用访问
define('is_include',true);
include_once(WORKDIR.'/config/config.php');
include_once(WORKDIR.'/include/index.php');
// composer
require_once(WORKDIR.'/vendor/autoload.php');




?>