<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.sukhov
 * Date: 25.07.13
 * Time: 12:02
 * To change this template use File | Settings | File Templates.
 */
class TaskForm extends CFormModel
{
    public $languages = array();
    public $calendar = array();
    public $title;
    public $customer;

    public function rules()
    {
        return array(
            array('languages, calendar, title, customer', 'required'),
        );
    }
}