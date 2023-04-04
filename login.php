<?php
session_start();

define('WORKDIR',getcwd());
require_once(WORKDIR.'/include/index.php');
require_once(WORKDIR.'/class/password.php');

// $data = $database->select('user', [
//     'id'
// ]);
// echo '<pre>';
// echo(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
// echo '</pre>';

// 处理用户提交的登录表单
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verification_code = $_SESSION['captcha'];
    $verification_code_time = $_SESSION['verification_code_time'];
    $email = $_POST['email'];
    $password = $_POST['password'];

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
        // 检查邮箱和密码是否正确
        $result = $database->select("user", [
            "email",
            "password"
        ], [
            "email" => $email
        ]);

        $password_hash = new PasswordHasher();
        if (empty($result[0]['email'])) {
            $echo = '<div class="alert alert-warning" role="alert">用户不存在！</div>';
        }
        elseif ($password_hash->verify($password,$result[0]['password'])) {
            // 登录成功，将用户重定向到欢迎页面
            header('Location: welcome.php');
            exit;
        } else {
            // 登录失败，显示错误消息
            $echo = '<div class="alert alert-warning" role="alert">邮箱或密码错误！</div>';
        }
    }
}

require_once(WORKDIR.'/html/login.html');
