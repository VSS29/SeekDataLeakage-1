<?php
require 'PHPMailerAutoload.php';
$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "seekdataleakplataform.info@gmail.com";
$mail->Password = "l8thesisISCTE2015";
$mail->SetFrom("seekdataleakplataform.info@gmail.com");
$mail->Subject = "Test";
$mail->Body = "hello";
$mail->AddAddress("sousa29@msn.com");
if(!$mail->Send())
{
	echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
	echo "Message has been sent";
}
?>