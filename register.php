<?php
define('WORKDIR',getcwd());
include_once(WORKDIR.'/include/index.php');
// 处理用户提交的注册表单
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 连接到MySQL数据库
    $conn = mysqli_connect('localhost', 'username', 'password', 'database_name');

    // 检查用户名是否已存在
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        // 用户名可用，将用户凭据插入到数据库中
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        mysqli_query($conn, $query);
    
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
        <input type="text" name="username" required><br><br>
        <label>密码：</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">注册</button>
    </form>
</body>
</html>