<?php
/**
 * This example shows sending a message using a local sendmail binary.
 */

require '../PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
// Set PHPMailer to use the sendmail transport
// $mail->isSendMail();
//Set who the message is to be sent from
$mail->setFrom('seekdataleakplataform.info@gmail.com', 'SDL Plataform');
//Set an alternative reply-to address
$mail->addReplyTo('vsousa29@msn.com', 'Vitor Sousa');
//Set who the message is to be sent to
$mail->addAddress('sousa29@msn.com', 'Vitor Sousa');
//Set the subject line
$mail->Subject = 'PHPMailer sendmail test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
