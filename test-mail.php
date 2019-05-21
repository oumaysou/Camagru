<?php

$to      = 'maysour.oussama@gmail.com';
$subject = 'le sujet';
$message = 'Bonjour !';
$headers = 'From: slilo@example.com' . "\r\n" .
'Reply-To: webmaster@example.com' . "\r\n" .
'X-Mailer: PHP/' . phpversion();

$test = mail($to, $subject, $message, $headers);


var_dump ($test);
?>