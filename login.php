<?php
define('WORKDIR',getcwd());
include_once(WORKDIR.'/include/index.php');

// $data = $database->select('user', [
//     'id'
// ]);
// echo '<pre>';
// echo(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
// echo '</pre>';

?>

<?php
    // 处理用户提交的登录表单
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $data = $database->select('user', [
            'id'
        ]);

        // 检查用户名和密码是否正确
        $result = $database->select("user", [
            "username",
            "password"
        ], [
            "username" => $username,
            "password" => $password
        ]);

        if (!empty($result)) {
            // 登录成功，将用户重定向到欢迎页面
            header('Location: welcome.php');
            exit;
        } else {
            // 登录失败，显示错误消息
            echo '用户名或密码错误！';
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>用户登录</title>
</head>
<body>
    <h1>用户登录</h1>

    <form method="post">
        <label>用户名：</label>
        <input type="text" name="username" required><br><br>
        <label>密码：</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">登录</button>
    </form>
</body>
</html>
