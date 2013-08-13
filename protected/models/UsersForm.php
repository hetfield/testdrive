<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.sukhov
 * Date: 25.07.13
 * Time: 12:02
 * To change this template use File | Settings | File Templates.
 */
class UsersForm extends CFormModel
{
    public $username;
    public $email;
    public $languages = array();
    public $password;

    public function rules()
    {
        return array(
            array('username, email', 'required'),
            array('email', 'email'),
            array('languages, password', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'username'=>'User Name',
            'email'=>'Email',
            'password' => 'New password:'
        );
    }

}