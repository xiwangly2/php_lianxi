<?php
session_start();

define('WORKDIR',getcwd());

require_once(WORKDIR.'/include/index.php');
require_once(WORKDIR.'/class/password.php');

// 处理用户提交的注册表单

// 检查用户名是否已存在
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verification_code = $_SESSION['captcha'];
    $verification_code_time = $_SESSION['verification_code_time'];

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($password != $_POST["confirm_password"]) {
        $echo = '<div class="alert alert-warning" role="alert">两次输入密码的不一致</div>';
    }

    if (time() - $verification_code_time > 300) { // 验证码过期时间为 5 分钟
        // 验证码已过期，处理错误
        $echo = '<div class="alert alert-warning" role="alert">验证码已过期，请重试</div>';
    }
    elseif ($_POST["verification_code"] != $verification_code) {
        // 验证码不正确，处理错误
        $echo = '<div class="alert alert-warning" role="alert">验证码输入错误</div>';
    }
    else {
        // 验证码正确，处理表单数据

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
            die;
        } else {
            // 用户名已存在，显示错误消息
            $echo = '<div class="alert alert-warning" role="alert">用户名已存在！</div>';
        }
    }
}

require_once(WORKDIR.'/html/register.html');
