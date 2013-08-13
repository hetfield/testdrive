<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.sukhov
 * Date: 13.08.13
 * Time: 16:29
 * To change this template use File | Settings | File Templates.
 */


/** @var PHPMailer $phpMailer */
$phpMailer = new PHPMailer();

$phpMailer->IsSMTP();
$phpMailer->Port       = 587;
$phpMailer->SMTPSecure = true;
$phpMailer->Host = 'smtp.mfxbroker.com';//'smtp.mfxbroker.com';
$phpMailer->Username = 'translations@mfxbroker.com';                            // SMTP username
$phpMailer->Password = 'aiutsraghuy545#';                           // SMTP password
$phpMailer->SMTPSecure = 'tls';
$phpMailer->SMTPAuth   = true;

$phpMailer->From = 'translations@mfxbroker.com';
$phpMailer->FromName = 'MasterForex';
$phpMailer->AddAddress('d.sukhov@mfxbroker.com', 'D.Sukhov');  // Add a recipient

$phpMailer->IsHTML(true);                                  // Set email format to HTML

$phpMailer->Subject = 'Тема письма';
$phpMailer->Body    = 'This is the HTML message body <b>in bold!</b>';
$phpMailer->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$phpMailer->Send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $phpMailer->ErrorInfo;
    exit;
}

echo 'Message has been sent';


die;