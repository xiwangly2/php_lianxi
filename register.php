<?php
define('WORKDIR',getcwd());

require_once(WORKDIR.'/include/index.php');
require_once(WORKDIR.'/class/password.php');
?>

<?php
// 处理用户提交的注册表单

// 检查用户名是否已存在
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $upd_time = date("Y-m-d H:i",time());

    $data = $database->select('user', [
        'email'
    ],[
        "email" => $email
    ]);

    if (empty($data[0]['email'])) {
        // 用户名可用，将用户凭据插入到数据库中
        $password_hash = new PasswordHasher();
        $last_user_id = $database->insert("user", [
            "id" => null,
            "username" => $username,
            "password" => $password_hash->password_hash($password),
            "email" => $email,
            "crt_time" => $upd_time,
            "upd_time" => $upd_time
        ]);
    
        // 注册成功，将用户重定向到欢迎页面
        header('Location: welcome.php');
        exit;
    } else {
        // 用户名已存在，显示错误消息
        echo '用户名已存在！';
    }
}

require_once(WORKDIR.'/html/register.html');
?>