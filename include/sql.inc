<?php
//只能通过引用访问
!defined('is_include') && die();
// // Require Composer's autoloader.
// require_once(WORKDIR.'/vendor/autoload.php');

// Using Medoo namespace.
use Medoo\Medoo;
try{
    // Connect the database.
    if($config_use_db == 'mysql'){
        $database = new Medoo([
            'type' => 'mysql',
            'host' => $mysql_server,
            'database' => $mysql_database_name,
            'username' => $mysql_username,
            'password' => $mysql_password,
            'port' => $mysql_port
        ]);
    }
    elseif($config_use_db == 'sqlite'){
        $database = new medoo([
            'database_type' => 'sqlite',
            'database_file' => $sqlite_database_file
        ]);
    }
    elseif($config_use_db == 'postgresql'){
        $database = new Medoo([
            'type' => 'postgresql',
            'host' => $postgresql_server,
            'database' => $postgresql_database_name,
            'username' => $postgresql_username,
            'password' => $postgresql_password,
            'port' => $postgresql_port
        ]);
    }
}
catch(Exception $e){
    echo('数据库连接出问题了：'.$e->getMessage());
}
?>