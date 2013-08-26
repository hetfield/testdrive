<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.sukhov
 * Date: 26.08.13
 * Time: 13:19
 * To change this template use File | Settings | File Templates.
 */

class Mailer extends PHPMailer{

    public function NewMail($subject, $addresses = array(), $body, $altbody = '',$attachments = array())
    {
        $this->CharSet="utf8";
        $this->IsSMTP();
        $this->Port       = 587;
        $this->SMTPSecure = true;
        $this->Host = 'smtp.mfxbroker.com';//'smtp.mfxbroker.com';
        $this->Username = 'translations@mfxbroker.com';                            // SMTP username
        $this->Password = 'aiutsraghuy545#';                           // SMTP password
        $this->SMTPSecure = 'tls';
        $this->SMTPAuth   = true;
        $this->From = 'translations@mfxbroker.com';
        $this->FromName = 'MasterForex';
        $this->IsHTML(true);
        $this->Subject = 'New Task from MasterForex';

        if ($addresses != array()) {
            foreach ($addresses as $address) {
                $this->AddAddress($address['email'], $address['name']);
            }
        } else {
            $this->SetError('Addresses array cannot be emty!');
        }

        $this->Body = $body;

        if ($altbody != ''){
            $this->AltBody = $altbody;
        }

        if ($attachments != array()){
            foreach ($attachments as $attachment) {
                $this->AddAttachment($attachment['path'], $attachment['file']);
            }
        }

        return $this->Send();
    }

}