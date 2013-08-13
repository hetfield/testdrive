<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.sukhov
 * Date: 24.07.13
 * Time: 12:24
 * To change this template use File | Settings | File Templates.
 *
 * @property integer $ID
 * @property string $Username
 * @property string $Password
 * @property string $Email
 * @property string $Role
 * @property string $Languages
 */

class Users extends CActiveRecord
{
    /** @var UsersForm $form */
    public $form;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);

    }

    public function tableName()
    {
        return 'users';
    }

}