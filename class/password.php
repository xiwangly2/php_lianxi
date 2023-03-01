<?php

class PasswordHasher {
    /**
     * 生成密码哈希值
     *
     * @param string $password 需要哈希的密码
     * @return string 哈希后的密码
     */
    public static function password_hash(string $password): string {
        // 生成一个随机的盐值
        $salt = random_bytes(16);

        // 用 SHA-256 哈希算法生成哈希值
        $hash = hash('sha256', $salt . $password);

        // 将盐值和哈希值拼接起来
        return base64_encode($salt . $hash);
    }

    /**
     * 验证密码是否匹配
     *
     * @param string $password 需要验证的密码
     * @param string $hashedPassword 存储的哈希密码
     * @return bool 如果匹配则为 true，否则为 false
     */
    public static function verify(string $password, string $hashedPassword): bool {
        // 获取存储的盐值
        $hashedPassword = base64_decode($hashedPassword);
        $salt = substr($hashedPassword, 0, 16);

        // 用相同的方法生成密码哈希值
        $hash = hash('sha256', $salt . $password);

        // 比较两个哈希值是否匹配
        return $hash === substr($hashedPassword, 16);
    }
}
