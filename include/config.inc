<?php
//只能通过引用访问
!defined('is_include') && die();
// composer
require_once(WORKDIR.'/vendor/autoload.php');
use Noodlehaus\Config;
use Noodlehaus\Parser\Yaml;
$config = new Config(file_get_contents(WORKDIR.'/config/config.yaml'), new Yaml, true);
$debug = $config['config']['debug'];
echo("测试：{$debug}");
?>