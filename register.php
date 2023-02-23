<?php
define('WORKDIR',getcwd());
include_once(WORKDIR.'/include/index.php');
include_once(WORKDIR.'/class/password.php');
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
        $last_user_id = $database->insert("user", [
            "id" => null,
            "username" => $username,
            "password" => $password,
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
?>
<!DOCTYPE html>
<html>
<head>
    <title>用户注册</title>
</head>
<body>
    <h1>用户注册</h1>
    <form method="post">
        <label>用户名：</label>
        <input type="text" name="username" required><br/><br/>
        <label>邮箱：</label>
        <input type="text" name="email" required><br/><br/>
        <label>密码：</label>
        <input type="password" name="password" required><br/><br/>
        <button type="submit">注册</button>
    </form>
</body>
</html>