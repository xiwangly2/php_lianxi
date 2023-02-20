<?php
define('WORKDIR',getcwd());
// 定义is_include常量，用于限制include/index.php只能通过引用访问
define('is_include',true);
// 引用
include_once(WORKDIR.'/include/index.php');
// composer
require_once(WORKDIR.'/vendor/autoload.php');
use Noodlehaus\Config;
use Noodlehaus\Parser\Json;
use Noodlehaus\Parser\Yaml;
$config = new Config(file_get_contents(WORKDIR.'/config/config.yaml'), new Yaml, true);
$debug = $config['config']['debug'];
echo("测试：{$debug}");
?>