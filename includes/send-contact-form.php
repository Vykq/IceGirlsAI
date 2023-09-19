<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/wp-load.php");

$email = $_POST['email'];
$type = $_POST['type'];
$msg = $_POST['info'];

$to = 'support@icegirls.ai';
$subject = 'IceGirlsAI: Visitor need help';

$message = '
<html>
<head>
    <title>' . $subject . '</title>
</head>
<body>
<p><b>Email:</b> ' . $email . '</p>
<p><b>Support type :</b> ' . $type . '</p>
<p><b>Message:</b> ' . $msg . '</p>
</body>
</html>
';

$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=UTF-8';
$headers[] = 'From: IceGirlsAI <support@icegirls.ai>';

mail($to, $subject, $message, implode("\r\n", $headers));

