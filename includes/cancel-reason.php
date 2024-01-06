<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/wp-load.php");

$current_user = wp_get_current_user();
$email = $current_user->user_email;
$reasons = $_POST['reasonInput'];
$msg = $_POST['reason'];
$reason = implode(', ', $reasons);

$to = 'vykintas.venckus@gmail.com';
$subject = 'IceGirlsAI: Cancel form';

$message = '
<html>
<head>
    <title>' . $subject . '</title>
</head>
<body>
<p><b>Email:</b> ' . $email . '</p>
<p><b>Reason :</b> ' . $reason . '</p>
<p><b>Message:</b> ' . $msg . '</p>
</body>
</html>
';

$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=UTF-8';
$headers[] = 'From: IceGirlsAI <support@icegirls.ai>';

mail($to, $subject, $message, implode("\r\n", $headers));

