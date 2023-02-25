// 生成 6 位随机验证码
function generateVerificationCode() {
    let code = "";
    for (let i = 0; i < 6; i++) {
        code += Math.floor(Math.random() * 10);
    }
    return code;
}

// 点击按钮时生成验证码并发送到后台
document.getElementById("btn_verification_code").addEventListener("click", function() {
    let verification_code = generateVerificationCode();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "auth.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("method=send_verification_code&verification_code=" + verification_code);
    alert("验证码已发送到您的电子邮件，请注意查收！");
});

// 点击按钮时生成新的验证码并发送到后台
document.getElementById("btn_refresh_verification_code").addEventListener("click", function() {
    let verification_code = generateVerificationCode();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "auth.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("method=send_verification_code&verification_code=" + verification_code);
    alert("验证码已刷新，请注意查收！");
});