<?php
session_start();
function generateVerificationCode() {
    $code = null;
	for ($i = 0; $i < 6; $i++) {
		$code .= mt_rand(0, 9);
	}
	return $code;
}

$method = $_POST['method'];
$method = 'send_verification_code';
if ($method == 'send_verification_code'){
    $verification_code = generateVerificationCode();
    $_SESSION["verification_code"] = $verification_code;
    $_SESSION["verification_code_time"] = time();
    // $verification_code = $_POST["verification_code"];
    echo($verification_code);
}
