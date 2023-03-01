<?php
//只能通过引用访问
!defined('IS_INCLUDE') && die();
// composer
require_once(WORKDIR.'/vendor/autoload.php');
use Noodlehaus\Config;
use Noodlehaus\Parser\Yaml;
$config = new Config(file_get_contents(WORKDIR.'/config/config.yaml'), new Yaml, true);
//config
$config_workdir = $config['config']['workdir'];
empty($config_workdir) ? $config_workdir = $_SERVER['DOCUMENT_ROOT'] : $config_workdir;
$config_debug = $config['config']['debug'];
$config_beta = $config['config']['beta'];
$config_use_db = $config['config']['use_db'];

// mysql
$mysql_database_name = $config['mysql']['database_name'];
$mysql_server = $config['mysql']['server'];
$mysql_username = $config['mysql']['username'];
$mysql_password = $config['mysql']['password'];
// mysql optional
$mysql_charset = $config['mysql']['charset'];
$mysql_port = $config['mysql']['port'];

// sqlite
$sqlite_database_file = $config['sqlite']['database_file'];

// postgresql
$postgresql_database_name = $config['postgresql']['database_name'];
$postgresql_server = $config['postgresql']['server'];
$postgresql_username = $config['postgresql']['username'];
$postgresql_password = $config['postgresql']['password'];
// postgresql optional
$postgresql_port = $config['postgresql']['port'];
